<?php
include('db.php');
// Requête SQL pour compter le nombre de disques
$count_sql = "SELECT COUNT(*) as count FROM disc";
$count_stmt = $pdo->query($count_sql);
$count_row = $count_stmt->fetch(PDO::FETCH_ASSOC);
$count = $count_row['count'];
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Liste des disques</title>
    <!-- Inclusion de Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <!-- Inclusion du fichier CSS personnalisé -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand fs-1 fw-bold">Liste des disques (<?php echo $count; ?>)</a>
            <div class="ml-auto">
                <a href="add_disc.php" class="btn btn-primary">Ajouter</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <?php
            // Requête SQL pour sélectionner tous les enregistrements de la table disc
            $sql = "SELECT * 
            FROM disc
            JOIN artist ON disc.artist_id = artist.artist_id";
            $stmt = $pdo->query($sql);

            // Boucle pour afficher les enregistrements
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <div class="col-md-6">
                    <div class="card mb-3 border border-0">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="src/img/jaquettes/<?= $row['disc_picture']; ?>" class="card-img-top" alt="Jaquette">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body py-0 h-100">
                                    <div class="d-flex flex-column justify-content-between h-100">
                                        <div class="d-flex flex-column">
                                            <h5 class="card-title fw-bold"><?php echo $row['disc_title']; ?></h5>
                                            <span class="card-text">Artiste: <?php echo $row['artist_name']; ?></span>
                                            <span class="card-text">Label: <?php echo $row['disc_label']; ?></span>
                                            <span class="card-text">Année: <?php echo $row['disc_year']; ?></span>
                                            <span class="card-text">Genre: <?php echo $row['disc_genre']; ?></span>
                                        </div>
                                        <div>
                                            <a href="details.php?id=<?php echo $row['disc_id']; ?>" class="btn btn-primary">Détails</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <!-- Inclusion des scripts Bootstrap et des scripts JS supplémentaires -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Inclusion du fichier JS personnalisé -->
    <script src="script.js"></script>
</body>

</html>