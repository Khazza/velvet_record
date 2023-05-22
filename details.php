<?php
session_start();
include('db.php');
$role = false;

// Vérifiez si l'utilisateur est connecté
if (isset($_SESSION['user'])) {
    // Récupérez le nom d'utilisateur et le rôle de l'utilisateur
    $username = $_SESSION['user']['username'];
    $role = $_SESSION['user']['role'];
}

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
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Détails du disque</title>
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
                Détails
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

    <div class="container">
        <h1 class="text-center"><?php echo $row['disc_title']; ?></h1>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="artist" class="form-label">Artiste</label>
                    <input type="text" class="form-control" id="artist" value="<?php echo $row['artist_name']; ?>"
                        disabled>
                </div>
                <div class="mb-3">
                    <label for="label" class="form-label">Label</label>
                    <input type="text" class="form-control" id="label" value="<?php echo $row['disc_label']; ?>"
                        disabled>
                </div>
                <div class="mb-3">
                    <label for="year" class="form-label">Année</label>
                    <input type="text" class="form-control" id="year" value="<?php echo $row['disc_year']; ?>"
                        disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="artist" class="form-label">Titre</label>
                    <input type="text" class="form-control" id="artist" value="<?php echo $row['disc_title']; ?>"
                        disabled>
                </div>
                <div class="mb-3">
                    <label for="genre" class="form-label">Genre</label>
                    <input type="text" class="form-control" id="genre" value="<?php echo $row['disc_genre']; ?>"
                        disabled>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Prix</label>
                    <input type="text" class="form-control" id="price" value="<?php echo $row['disc_price']; ?>"
                        disabled>
                </div>
            </div>
        </div>
        <div class="text-center">
            <img src="src/img/jaquettes/<?php echo $row['disc_picture']; ?>" alt="<?php echo $row['disc_title']; ?>"><br>
        </div>
        <div class="text-center mt-3">
            <?php if ($role === 'admin') { ?>
                <a href="edit_disc.php?id=<?php echo $row['disc_id']; ?>" class="btn btn-warning">Modifier</a>
                <button class="btn btn-danger" onclick="deleteDisc(<?php echo $row['disc_id']; ?>)">Supprimer</button>
            <?php } ?>
            <a href="javascript:history.back()" class="btn btn-primary">Retour</a>
        </div>
    </div>
    <!-- Inclusion de jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Inclusion des scripts Bootstrap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
    <!-- Inclusion de SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
    <!-- Inclusion du script JS personnalisé -->
    <script src="script.js"></script>
</body>

</html>
