<?php
include('db.php');
session_start();
$role = false;

// Vérifiez si l'utilisateur est connecté
if (isset($_SESSION['user'])) {
    // Récupérez le nom d'utilisateur et le rôle de l'utilisateur
    $username = $_SESSION['user']['username'];
    $role = $_SESSION['user']['role'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $artist = $_POST['artist'];
    $title = $_POST['title'];
    $label = $_POST['label'];
    $year = $_POST['year'];
    $genre = $_POST['genre'];
    $price = $_POST['price'];

    // Verifie si l'artiste existe ou s'il a besoin d'être ajouter
    $artist_stmt = $pdo->prepare("SELECT * FROM artist WHERE artist_name = :artist");
    $artist_stmt->execute([':artist' => $artist]);
    $artist_row = $artist_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$artist_row) {
        // L'artiste n'existe pas, on l'ajoute
        $new_artist_stmt = $pdo->prepare("INSERT INTO artist (artist_name) VALUES (:artist)");
        $new_artist_stmt->execute([':artist' => $artist]);
        $artist = $pdo->lastInsertId();
    } else {
        $artist = $artist_row['artist_id'];
    }

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

        // Création de l'image redimensionnée
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
                throw new Exception('Le format de l\'image n\'est pas supporté.');
        }
        imagedestroy($src);
        imagedestroy($dst);
    } else {
        // Si l'image est de la bonne taille, on la déplace simplement
        move_uploaded_file($tmpFilePath, $newFilePath);
    }

    // Préparation de la requête SQL
    $stmt = $pdo->prepare("UPDATE disc SET disc_title = :title, artist_id = :artist, disc_label = :label, disc_year = :year, disc_genre = :genre, disc_price = :price, disc_picture = :picture WHERE disc_id = :id");
    $stmt->execute([':title' => $title, ':artist' => $artist, ':label' => $label, ':year' => $year, ':genre' => $genre, ':price' => $price, ':picture' => $filename, ':id' => $id]);

    // Récupérer l'URL de la page de détails du disque modifié
    $details_url = 'details.php?id=' . $id;

    // Rediriger vers la page de détails du disque modifié
    header('Location: ' . $details_url);
    exit;
}

// En cas d'accès direct à la page
header('Location: form.php');
exit;
?>
