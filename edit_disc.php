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

// Récupération de la liste des artistes pour le select
$artist_sql = "SELECT * FROM artist";
$artist_stmt = $pdo->query($artist_sql);
$artists = $artist_stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM disc JOIN artist ON disc.artist_id = artist.artist_id WHERE disc_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo "Disque non trouvé";
        exit;
    }
} else {
    echo "Identifiant non fourni";
    exit;
}

// Inclusion de la bibliothèque GD
if (!extension_loaded('gd') || !function_exists('gd_info')) {
    echo 'L\'extension GD n\'est pas activée. Veuillez activer GD pour utiliser la manipulation d\'images.';
    exit;
}

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

    // Continuer avec le reste du code ...
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

    header('Location: index.php');
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <title>Modifier un disque</title>
<!-- Inclusion de Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- Inclusion du fichier CSS personnalisé -->
    <link rel="stylesheet" href="./assets/css/styles.css"> 
</head>
<body>
    <div class="container">
        <h1>Modifier un disque</h1>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Titre</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= $row['disc_title'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="artist" class="form-label">Artiste</label>
                <select class="form-select" id="artist" name="artist" required>
                    <option value="">Sélectionner un artiste</option>
                    <option value="add_new">Ajouter un nouvel artiste</option>
                    <?php foreach ($artists as $artist): ?>
                        <option value="<?= $artist['artist_name'] ?>" <?= $artist['artist_id'] == $row['artist_id'] ? 'selected' : '' ?>>
                            <?= $artist['artist_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="label" class="form-label">Label</label>
                <input type="text" class="form-control" id="label" name="label" value="<?= $row['disc_label'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Year</label>
                <input type="number" class="form-control" id="year" name="year" value="<?= $row['disc_year'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" value="<?= $row['disc_genre'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Prix</label>
                <input type="number" class="form-control" id="price" name="price" value="<?= $row['disc_price'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">Jaquette (laissez vide pour conserver l'image actuelle)</label>
                <input type="file" class="form-control" id="picture" name="picture">
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        </form>
    </div>
    <!-- Inclusion de jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Inclusion des scripts Bootstrap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
    <!-- Inclusion de SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
    <!-- Inclusion du script JS personnalisé -->
    <script src="./js/script.js"></script>
</body>
</html>
