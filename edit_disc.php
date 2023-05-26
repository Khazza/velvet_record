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
        <form method="post" action="edit_disc_handler.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Titre</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= $row['disc_title'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="artist" class="form-label">Artiste</label>
                <select class="form-select" id="artist" name="artist" required>
                    <option value="">Sélectionner un artiste</option>
                    <option value="add_new">Ajouter un nouvel artiste</option>
                    <?php foreach ($artists as $artist) : ?>
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
            <div id="disc-id" data-id="<?= $id ?>"></div>
            <input type="hidden" name="id" value="<?= $id ?>"> 
            <!-- Cela permet de passer l'identifiant du disque au script de traitement (edit_disc_handler.php) lorsque le formulaire est soumis (normalement). -->
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