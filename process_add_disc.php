<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les autres informations du formulaire
    $artist = $_POST['artist'];
    $label = $_POST['label'];
    $year = $_POST['year'];
    $genre = $_POST['genre'];
    $price = $_POST['price'];

    // Vérifier si un fichier a été téléchargé
    if (!empty($_FILES['file']['name'])) {
        // Chemin du répertoire de stockage des jaquettes
        $uploadDirectory = 'src/img/jaquettes/';

        // Nom du fichier téléchargé
        $filename = basename($_FILES['file']['name']);

        // Chemin complet du fichier sur le serveur
        $uploadFilePath = $uploadDirectory . $filename;

        // Déplacer le fichier téléchargé vers le répertoire de stockage
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath)) {
            // Mettre à jour le chemin de la nouvelle jaquette dans la base de données
            $updateSql = "UPDATE disc SET artist_id = :artist, disc_label = :label, disc_year = :year, disc_genre = :genre, disc_price = :price, disc_jacket = :jacket WHERE disc_id = :id";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute([
                'artist' => $artist,
                'label' => $label,
                'year' => $year,
                'genre' => $genre,
                'price' => $price,
                'jacket' => $uploadFilePath,
                'id' => $id
            ]);

            // Redirection vers la page des détails du disque
            header('Location: details.php?id=' . $id);
            exit;
        } else {
            echo "Une erreur s'est produite lors du téléchargement de la jaquette.";
            exit;
        }
    } else {
        // Si aucun fichier n'a été téléchargé, mettre à jour les autres informations sans changer la jaquette
        $updateSql = "UPDATE disc SET artist_id = :artist, disc_label = :label, disc_year = :year, disc_genre = :genre, disc_price = :price WHERE disc_id = :id";
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->execute([
            'artist' => $artist,
            'label' => $label,
            'year' => $year,
            'genre' => $genre,
            'price' => $price,
            'id' => $id
        ]);

        // Redirection vers la page des détails du disque
        header('Location: details.php?id=' . $id);
        exit;
    }
}
?>
