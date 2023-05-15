<?php
session_start();
include('db.php');

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
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Ajouter un vinyle</title>
    <!-- Inclusion de Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- Inclusion du fichier CSS personnalisé -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light py-0">
        <div class="container">
            <a class="navbar-brand fs-1 fw-bold">
                Ajouter un vinyle
            </a>
            <div class="ml-auto">
            <?php if (isset($_SESSION['user'])) { ?>
                    <span class="navbar-text me-2">Bonjour, <?php echo $username; ?></span>
                    <a href="logout.php" class="btn btn-outline-primary me-2">Logout</a>
                <?php } else { ?>
                    <a href="login.php" class="btn btn-outline-primary me-2">Log in</a>
                    <a href="signup.php" class="btn btn-primary">Sign up</a>
                <?php } ?>
            </div>
        </div>
    </nav>

    <!-- Formulaire d'ajout de disque -->
    <div class="container">
        <form method="POST" action="process_add_disc.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Titre</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" required>
            </div>
            <div class="mb-3">
                <label for="artist" class="form-label">Artiste</label>
                <select class="form-select" id="artist" name="artist">
                    <option value="">Sélectionner un artiste</option>
                    <?php foreach ($artists as $artist) { ?>
                        <option value="<?= $artist['artist_id']; ?>"><?= $artist['artist_name']; ?></option>
                    <?php } ?>
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
            <a href="javascript:history.back()" class="btn btn-primary">Retour</a>
        </form>
    </div>
    <!-- Inclusion des scripts Bootstrap et des scripts JS supplémentaires -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
    <!-- Inclusion du fichier JS personnalisé -->
    <script src="script.js"></script>

</body>

</html>
