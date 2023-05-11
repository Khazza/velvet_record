<!-- -----------------page details modifier --------------------------------- -->
<?php
session_start();
include('db.php');

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
    <div class="container">
        <h1 class="text-center"><?php echo $row['disc_title']; ?></h1>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="artist" class="form-label">Artiste</label>
                    <input type="text" class="form-control" id="artist" value="<?php echo $row['artist_name']; ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="label" class="form-label">Label</label>
                    <input type="text" class="form-control" id="label" value="<?php echo $row['disc_label']; ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="year" class="form-label">Année</label>
                    <input type="text" class="form-control" id="year" value="<?php echo $row['disc_year']; ?>" disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="artist" class="form-label">Titre</label>
                    <input type="text" class="form-control" id="artist" value="<?php echo $row['disc_title']; ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="genre" class="form-label">Genre</label>
                    <input type="text" class="form-control" id="genre" value="<?php echo $row['disc_genre']; ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Prix</label>
                    <input type="text" class="form-control" id="price" value="<?php echo $row['disc_price']; ?>" disabled>
                </div>
            </div>
        </div>
        <div class="text-center">
            <img src="src/img/jaquettes/<?php echo $row['disc_picture']; ?>" alt="<?php echo $row['disc_title']; ?>" class="img-fluid">
        </div>
        <div class="text-center mt-3">
            <a href="index.php" class="btn btn-primary">Retour</a>
            <?php
            if (isset($_SESSION['username'])) {
                echo '<a href="update_form.php?id=' . $id . '" class="btn btn-warning">Modifier</a>';
                echo '<a href="delete.php?id=' . $id . '" class="btn btn-danger">Supprimer</a>';
            }
            ?>
        </div>
    </div>
    <!-- Inclusion de Bootstrap JS et des scripts personnalisés -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js"></script>
    <script src="scripts.js"></script>
</body>

</html>