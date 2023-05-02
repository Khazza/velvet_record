<?php
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <!-- Inclusion du fichier CSS personnalisé -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center"><?php echo $row['disc_title']; ?></h1>
        <div class="text-center">
            <img src="src/img/jaquettes/<?php echo $row['disc_picture']; ?>" alt="<?php echo $row['disc_title']; ?>"><br>
        </div>
        <div class="text-center">
            <strong>Artiste :</strong> <?php echo $row['artist_name']; ?><br>
            <strong>Label :</strong> <?php echo $row['disc_label']; ?><br>
            <strong>Année :</strong> <?php echo $row['disc_year']; ?><br>
            <strong>Genre :</strong> <?php echo $row['disc_genre']; ?><br>
            <strong>Prix :</strong> <?php echo $row['disc_price']; ?> €<br>
        </div>
        <div class="text-center mt-3">
            <a href="edit_disc.php?id=<?php echo $row['disc_id']; ?>" class="btn btn-warning">Modifier</a>
            <a href="delete_disc.php?id=<?php echo $row['disc_id']; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce disque ?')">Supprimer</a>
            <a href="javascript:history.back()" class="btn btn-primary">Retour</a>
        </div>
    </div>

    <!-- Inclusion des scripts Bootstrap et des scripts JS supplémentaires -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Inclusion du fichier JS personnalisé -->
    <script src="script.js"></script>
</body>
</html>
