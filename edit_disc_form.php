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
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Modifier un disque</title>
    <!-- Inclusion de Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Inclusion du fichier CSS personnalisé -->
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>

<body>
    <div class="container">
        <h1>Modifier un disque</h1>
        <form action="edit_disc_handler.php" method="post" enctype="multipart/form-data">
            <!-- Les autres champs du formulaire... -->
            <div class="mb-3">
                <label for="artist" class="form-label">Artiste</label>
                <select class="form-select" id="artist" name="artist" required>
                    <option value="">Sélectionner un artiste</option>
                    <option value="add_new">Ajouter un nouvel artiste</option>
                    <?php
                    foreach ($artists as $artist) : ?>
                        <option value="<?= $artist['artist_name'] ?>">
                            <?= $artist['artist_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Les autres champs du formulaire... -->
        </form>
    </div>
    <!-- Inclusion de jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Inclusion des scripts Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <!-- Inclusion de SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.0.0/dist/sweetalert2.all.min.js"></script>
    <!-- Inclusion du script JS personnalisé -->
    <script src="./js/script.js"></script>
</body>

</html>
