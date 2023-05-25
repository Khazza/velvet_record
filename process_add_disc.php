<?php
include('db.php');

// Vérifiez si l'utilisateur est connecté
if (isset($_SESSION['user'])) {
    // Récupérez le nom d'utilisateur et le rôle de l'utilisateur
    $username = $_SESSION['user']['username'];
    $role = $_SESSION['user']['role'];
}

// Récupération des données du formulaire
$title = $_POST['title'];
$artist = $_POST['artist'];
$newArtist = $_POST['new_artist'];
$year = $_POST['year'];
$genre = $_POST['genre'];
$label = $_POST['label'];
$price = $_POST['price'];

// Vérification si un nouvel artiste est ajouté
if (!empty($newArtist)) {
    // Insertion du nouvel artiste
    $insertArtistSql = "INSERT INTO artist (artist_name) VALUES (:artist_name)";
    $insertArtistStmt = $pdo->prepare($insertArtistSql);
    $insertArtistStmt->execute(['artist_name' => $newArtist]);

    // Récupération de l'ID du nouvel artiste
    $artistId = $pdo->lastInsertId();
} else {
    $artistId = $artist;
}

// Gestion de l'upload de la jaquette
if ($_FILES['file']['name']) {
    $uploadDir = 'src/img/jaquettes/';
    $filename = $_FILES['file']['name'];
    $tmpFilePath = $_FILES['file']['tmp_name'];
    $newFilePath = $uploadDir . $filename;

    // Redimensionnement de l'image si nécessaire
    list($width, $height) = getimagesize($tmpFilePath);
    $maxSize = 500;

    if ($width > $maxSize || $height > $maxSize) {
        // Calcul des nouvelles dimensions
        if ($width > $height) {
            $newWidth = $maxSize;
            $newHeight = intval($height * ($maxSize / $width));
        } else {
            $newHeight = $maxSize;
            $newWidth = intval($width * ($maxSize / $height));
        }

        // Création de la nouvelle image redimensionnée
        $imageResized = imagecreatetruecolor($newWidth, $newHeight);
        $imageSource = imagecreatefromjpeg($tmpFilePath);

        // Redimensionnement de l'image source à la nouvelle taille
        imagecopyresampled($imageResized, $imageSource, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Sauvegarde de l'image redimensionnée
        imagejpeg($imageResized, $newFilePath);
        // Libération de la mémoire
        imagedestroy($imageResized);
        imagedestroy($imageSource);
    } else {
        move_uploaded_file($tmpFilePath, $newFilePath);
    }

    // Insertion des données dans la table disc
    $insertDiscSql = "INSERT INTO disc (disc_title, artist_id, disc_year, disc_genre, disc_label, disc_price, disc_picture) VALUES (:title, :artist_id, :year, :genre, :label, :price, :picture)";
    $insertDiscStmt = $pdo->prepare($insertDiscSql);
    $insertDiscStmt->execute([
        'title' => $title,
        'artist_id' => $artistId,
        'year' => $year,
        'genre' => $genre,
        'label' => $label,
        'price' => $price,
        'picture' => $filename
    ]);

    // Redirection vers la page d'accueil
    header('Location: index.php');
    exit();
}
?>