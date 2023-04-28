<?php
                include('db.php');
                ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Liste des disques</title>
    <!-- Inclusion de Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Inclusion du fichier CSS personnalisé -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Liste des disques</h1>
    <a href="add_disc.php" class="btn btn-primary">Ajouter</a>

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
                    <div class="card mb-3">
                        <img src="src/img/jaquettes/<?= $row['disc_picture']; ?>" class="card-img-top" alt="Jaquette">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['disc_title']; ?></h5>
                            <p class="card-text">Artiste: <?php echo $row['artist_name']; ?></p>
                            <p class="card-text">Label: <?php echo $row['disc_label']; ?></p>
                            <p class="card-text">Année: <?php echo $row['disc_year']; ?></p>
                            <p class="card-text">Genre: <?php echo $row['disc_genre']; ?></p>
                            <a href="details.php?id=<?php echo $row['disc_id']; ?>" class="btn btn-primary">Détails</a>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <!-- Inclusion des scripts Bootstrap et des scripts JS supplémentaires -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Inclusion du fichier JS personnalisé -->
    <script src="script.js"></script>
</body>
</html>