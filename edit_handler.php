<?php
include('db.php');
session_start();

// Vérifiez si l'utilisateur est connecté
if (isset($_SESSION['user'])) {
    // Récupérez le nom d'utilisateur et le rôle de l'utilisateur
    $username = $_SESSION['user']['username'];
    $role = $_SESSION['user']['role'];
}

// Récupération de la liste des artistes pour le select
$artist_sql = "SELECT * FROM artist";
$artist_stmt = $pdo->query($artist_sql);
$artists = $artist_stmt->fetchAll(PDO::FETCH_ASSOC);
$_SESSION['artists'] = $artists; // Sauvegarde des artistes pour l'utilisation dans le formulaire

// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $artist = $_POST['artist'];
    $title = $_POST['title'];
    $label = $_POST['label'];
    $year = $_POST['year'];
    $genre = $_POST['genre'];
    $price = $_POST['price'];

    // Check if artist exists or needs to be added
    $artist_stmt = $pdo->prepare("SELECT * FROM artist WHERE artist_name = :artist");
    $artist_stmt->execute([':artist' => $artist]);
    $artist_row = $artist_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$artist_row) {
        // L'artiste n'existe pas, ajoutez-le à la base de données
        $new_artist_stmt = $pdo->prepare("INSERT INTO artist (artist_name) VALUES (:artist)");
        $new_artist_stmt->execute([':artist' => $artist]);
        $artist = $pdo->lastInsertId();
    } else {
        $artist = $artist_row['artist_id'];
    }

    // Vérification si un fichier image a été téléchargé
    if (!empty($_FILES['picture']['name'])) {

        // Gestion du changement de jaquette
        $uploadDir = 'src/img/jaquettes/';
        $filename = $_FILES['picture']['name'];
        $tmpFilePath = $_FILES['picture']['tmp_name'];
        $newFilePath = $uploadDir . $filename;

        // Vérification de la taille de l'image
        $imageSize = getimagesize($tmpFilePath);
        $imageWidth = $imageSize[0];
        $imageHeight = $imageSize[1];

        if ($imageWidth > 600 || $imageHeight > 600) {
            // Redimensionnement de l'image si elle dépasse la taille maximale de 600x600 pixels
            $maxWidth = 500;
            $maxHeight = 500;

            // Calcul des nouvelles dimensions de l'image en conservant le ratio
            $ratio = min($maxWidth / $imageWidth, $maxHeight / $imageHeight);
            $newWidth = $imageWidth * $ratio;
            $newHeight = $imageHeight * $ratio;

            $dst = imagecreatetruecolor($newWidth, $newHeight);

            // Création de l'image redimensionnée en fonction du type de l'image originale
            $src = null;
            switch ($imageSize[2]) {
                case IMAGETYPE_GIF:
                    $src = imagecreatefromgif($tmpFilePath);
                    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $imageWidth, $imageHeight);
                    imagegif($dst, $newFilePath);
                    break;
                case IMAGETYPE_JPEG:
                    $src = imagecreatefromjpeg($tmpFilePath);
                    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $imageWidth, $imageHeight);
                    imagejpeg($dst, $newFilePath);
                    break;
                case IMAGETYPE_PNG:
                    $src = imagecreatefrompng($tmpFilePath);
                    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $imageWidth, $imageHeight);
                    imagepng($dst, $newFilePath);
                    break;
                default:
                    echo "Le format de l'image n'est pas pris en charge.";
                    exit;
            }

            imagedestroy($src);
            imagedestroy($dst);
        } else {
            // Si l'image est plus petite que la taille maximale, déplacez-la simplement vers le répertoire d'upload
            move_uploaded_file($tmpFilePath, $newFilePath);
        }
    } else {
        $filename = $row['disc_picture'];
    }

    $update_sql = "UPDATE disc SET artist_id = :artist_id, disc_title = :title, disc_year = :year, disc_genre = :genre, disc_label = :label, disc_price = :price, disc_picture = :picture WHERE disc_id = :id";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->execute([':artist_id' => $artist, ':title' => $title, ':year' => $year, ':genre' => $genre, ':label' => $label, ':price' => $price, ':picture' => $filename, ':id' => $id]);

    // Récupérer l'URL de la page de détails du disque modifié
    $details_url = 'details.php?id=' . $id;

    // Rediriger vers la page de détails du disque modifié
    $details_url = 'details.php?id=' . $id;
    header('Location: ' . $details_url);
    exit;
} else {
    // Sinon, afficher le formulaire d'édition
    header('Location: edit_disc_form.php');
    exit;
}
