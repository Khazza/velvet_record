<?php
include('db.php');
// Requête SQL pour sélectionner les 5 derniers disques ajoutés récemment
$recent_sql = "SELECT * 
              FROM disc
              JOIN artist ON disc.artist_id = artist.artist_id
              ORDER BY disc_id DESC
              LIMIT 5";
$recent_stmt = $pdo->query($recent_sql);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Liste des disques</title>
    <!-- Inclusion de Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <!-- Inclusion du fichier CSS personnalisé -->
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand fs-1 fw-bold">
                Liste des disques
            </a>
            <div class="ml-auto">
                <a href="add_disc.php" class="btn btn-primary">Ajouter</a>
            </div>
        </div>
    </nav>
    <div class="container">
        <!-- Section "Ajouté récemment" -->
        <div class="row my-4">
            <div class="col">
                <h4 class="fw-bold">Ajouté récemment:</h4>
                <div class="d-flex">
                    <?php while ($recent_row = $recent_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                        <div class="me-3">
                            <img src="src/img/jaquettes/<?= $recent_row['disc_picture']; ?>" alt="Jaquette" style="width: 50px;">
                            <div class="text-center" style="font-size: 12px;">
                                <div><?= $recent_row['disc_title']; ?></div>
                                <div><?= $recent_row['artist_name']; ?></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- Fin de la section "Ajouté récemment" -->

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
                                            <span class="card-text"><span class="fw-bold">Artiste: </span><?php echo $row['artist_name']; ?></span>
                                            <span class="card-text"><span class="fw-bold">Label: </span> <?php echo $row['disc_label']; ?></span>
                                            <span class="card-text"><span class="fw-bold">Année: </span><?php echo $row['disc_year']; ?></span>
                                            <span class="card-text"><span class="fw-bold">Genre: </span><?php echo $row['disc_genre']; ?></span>
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
