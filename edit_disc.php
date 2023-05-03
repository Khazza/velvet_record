<?php
include('db.php');

// Inclusion de la bibliothèque GD
if (!extension_loaded('gd') || !function_exists('gd_info')) {
    echo 'L\'extension GD n\'est pas activée. Veuillez activer GD pour utiliser la manipulation d\'images.';
    exit;
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $artist = $_POST['artist'];
    $label = $_POST['label'];
    $year = $_POST['year'];
    $genre = $_POST['genre'];
    $price = $_POST['price'];

    // Gestion du changement de jaquette
    if ($_FILES['file']['name']) {
        $uploadDir = 'src/img/jaquettes/';
        $filename = $_FILES['file']['name'];
        $tmpFilePath = $_FILES['file']['tmp_name'];
        $newFilePath = $uploadDir . $filename;

        // Vérification de la taille de l'image
        $imageSize = getimagesize($tmpFilePath);
        $imageWidth = $imageSize[0];
        $imageHeight = $imageSize[1];

        if ($imageWidth > 600 || $imageHeight > 600) {
            // Redimensionnement de l'image si elle dépasse la taille maximale de 600x600 pixels
            $maxWidth = 600;
            $maxHeight = 600;

            // Calcul des nouvelles dimensions de l'image en conservant le ratio
            $ratio = min($maxWidth / $imageWidth, $maxHeight / $imageHeight);
            $newWidth = intval($imageWidth * $ratio);
            $newHeight = intval($imageHeight * $ratio);

            // Création d'une nouvelle image redimensionnée
            $newImage = imagecreatetruecolor($newWidth, $newHeight);
            $sourceImage = imagecreatefromstring(file_get_contents($tmpFilePath));

            // Redimensionnement de l'image source vers la nouvelle image
            imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $imageWidth, $imageHeight);

            // Enregistrement de l'image redimensionnée
            imagejpeg($newImage, $newFilePath, 90);

            // Libération de la mémoire utilisée par les images
            imagedestroy($newImage);
            imagedestroy($sourceImage);
        } else {
            // Pas de redimensionnement nécessaire, copie directe de l'image
            move_uploaded_file($tmpFilePath, $newFilePath);
        }

        // Mise à jour du chemin de la nouvelle jaquette dans la base de données
        $updateSql = "UPDATE disc SET artist_id = :artist, disc_label = :label, disc_year = :year, disc_genre = :genre, disc_price = :price, disc_picture = :picture WHERE disc_id = :id";
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->execute(['artist' => $artist, 'label' => $label, 'year' => $year, 'genre' => $genre, 'price' => $price, 'picture' => $filename, 'id' => $id]);
    } else {
        // Mise à jour des autres informations sans changer la jaquette
        $updateSql = "UPDATE disc SET artist_id = :artist, disc_label = :label, disc_year = :year, disc_genre = :genre, disc_price = :price WHERE disc_id = :id";
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->execute(['artist' => $artist, 'label' => $label, 'year' => $year, 'genre' => $genre, 'price' => $price, 'id' => $id]);
    }

    header('Location: details.php?id=' . $id);
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Modifier le disque</title>
    <!-- Inclusion de Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <!-- Inclusion du fichier CSS personnalisé -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h1 class="text-center">Modifier le disque : <?php echo $row['disc_title']; ?></h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <select class="form-select" id="artist" name="artist" required>
                    <option value="">Sélectionner un artiste</index.php/option>
                        <?php foreach ($artists as $artist) : ?>
                    <option value="<?= $artist['artist_id']; ?>" <?php if ($artist['artist_id'] == $row['artist_id']) echo 'selected'; ?>>
                        <?= $artist['artist_name']; ?>
                    </option>
                <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="label" class="form-label">Label :</label>
                <input type="text" class="form-control" id="label" name="label" value="<?php echo $row['disc_label']; ?>">
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Année :</label>
                <input type="text" class="form-control" id="year" name="year" value="<?php echo $row['disc_year']; ?>">
            </div>
            <div class="mb-3">
                <label for="genre" class="form-label">Genre :</label>
                <input type="text" class="form-control" id="genre" name="genre" value="<?php echo $row['disc_genre']; ?>">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Prix :</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo $row['disc_price']; ?>">
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">Jaquette :</label>
                <div class="input-group">
                    <input type="file" class="form-control" id="picture" name="file" accept="image/*">
                </div>
            </div>
            <input type="hidden" name="id" value="<?php echo $row['disc_id']; ?>">
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                <a href="details.php?id=<?php echo $row['disc_id']; ?>" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
    <!-- Inclusion des scripts Bootstrap et des scripts JS supplémentaires -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Inclusion du fichier JS personnalisé -->
    <script src="script.js"></script>

</body>

</html>