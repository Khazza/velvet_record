<?php
include('db.php');

// Récupération de la liste des artistes pour le select
$artist_sql = "SELECT * FROM artist";
$artist_stmt = $pdo->query($artist_sql);
$artists = $artist_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ajouter un vinyle</title>
    <!-- Inclusion de Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <!-- Inclusion du fichier CSS personnalisé -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Ajouter un vinyle</h1>
        <form method="POST" action="process_add_disc.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Titre</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" required>
            </div>
            <div class="mb-3">
                <label for="artist" class="form-label">Artiste</label>
                <select class="form-select" id="artist" name="artist">
                    <option value="">Sélectionner un artiste</option>
                    <?php foreach ($artists as $artist) : ?>
                        <option value="<?= $artist['artist_id']; ?>"><?= $artist['artist_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="new_artist" class="form-label">Nouvel artiste</label>
                <input type="text" class="form-control" id="new_artist" name="new_artist" placeholder="Enter artist">
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Année</label>
                <input type="number" class="form-control" id="year" name="year" placeholder="Enter year" required>
            </div>
            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" placeholder="Enter genre" required>
            </div>
            <div class="mb-3">
                <label for="label" class="form-label">Label</label>
                <input type="text" class="form-control" id="label" name="label" placeholder="Enter label" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">Jaquette</label>
                <input type="file" class="form-control" id="picture" name="file" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
    <!-- Inclusion des scripts Bootstrap et des scripts JS supplémentaires -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Inclusion du fichier JS personnalisé -->
<script src="script.js"></script>

</body>
</html>

-------------------------------------------------------------------------------
Page process modifier:
    <?php
include('db.php');

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
    // Insertion du nouvel artiste dans la table artist
    $insertArtistSql = "INSERT INTO artist (artist_name) VALUES (:artist_name)";
    $insertArtistStmt = $pdo->prepare($insertArtistSql);
    $insertArtistStmt->execute(['artist_name' => $newArtist]);

    // Récupération de l'ID du nouvel artiste ajouté
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
    $maxSize = 600;

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
$insertDiscSql = "INSERT INTO disc (title, artist_id, year, genre, label, price, picture) VALUES (:title, :artist_id, :year, :genre, :label, :price, :picture)";
$insertDiscStmt = $pdo->prepare($insertDiscSql);
$insertDiscStmt->execute([
    'title' => $title,
    'artist_id' => $artistId,
    'year' => $year,
    'genre' => $genre,
    'label' => $label,
    'price' => $price,
    'picture' => $newFilePath
]);

// Redirection vers la page d'accueil ou une autre page de confirmation
header('Location: index.php');
exit();
}
?>

