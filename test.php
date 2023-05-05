<!-- Encadré "Ajouté récemment" -->
<div class="container">
    <div class="row mt-4">
        <div class="col">
            <h4 class="text-center">Ajouté récemment :</h4>
            <div id="recent-carousel" class="carousel slide" data-bs-ride="carousel">
                <!-- Indicateurs -->
                <ol class="carousel-indicators">
                    <?php for ($i = 0; $i < $recent_count; $i++) { ?>
                        <li data-bs-target="#recent-carousel" data-bs-slide-to="<?= $i ?>" <?php if ($i == 0) echo 'class="active"'; ?>></li>
                    <?php } ?>
                </ol>

                <!-- Slides -->
                <div class="carousel-inner d-flex justify-content-center">
                    <?php while ($recent_row = $recent_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                        <div class="carousel-item">
                            <img src="src/img/jaquettes/<?= $recent_row['disc_picture']; ?>" alt="Jaquette" class="d-block mx-auto" style="width: 50px; height: 50px; object-fit: cover;">
                            <div class="text-center mt-2">
                                <div><?= $recent_row['disc_title']; ?></div>
                                <div><?= $recent_row['artist_name']; ?></div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <!-- Contrôles -->
                <a class="carousel-control-prev" href="#recent-carousel" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Précédent</span>
                </a>
                <a class="carousel-control-next" href="#recent-carousel" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Suivant</span>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Fin de l'encadré "Ajouté récemment" -->



------------------------------------------------------------------

<?php
include('db.php');
// Requête SQL pour compter le nombre de disques
$count_sql = "SELECT COUNT(*) as count FROM disc";
$count_stmt = $pdo->query($count_sql);
$count_row = $count_stmt->fetch(PDO::FETCH_ASSOC);
$count = $count_row['count'];

// Initialisation du compteur
$recent_count = 0;

// Requête SQL pour sélectionner les 5 derniers disques ajoutés récemment
$recent_sql = "SELECT * 
               FROM disc
               JOIN artist ON disc.artist_id = artist.artist_id
               ORDER BY disc_id DESC
               LIMIT 5";
$recent_stmt = $pdo->query($recent_sql);

// Comptage du nombre de résultats
$recent_count = $recent_stmt->rowCount();

$recent_rows = array(); // Tableau pour stocker les résultats

// Récupérer les résultats dans le tableau
while ($recent_row = $recent_stmt->fetch(PDO::FETCH_ASSOC)) {
    $recent_rows[] = $recent_row;
}
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
                Liste des disques (<span class="counter-style"><?php echo $count; ?></span>)
            </a>
            <div class="ml-auto">
                <a href="add_disc.php" class="btn btn-primary">Ajouter</a>
            </div>
        </div>
    </nav>

    <!-- Encadré "Ajouté récemment" -->
    <div class="container">
        <div class="row mt-4">
            <div class="col">
                <h4 class="text-center">Ajouté récemment :</h4>
                <div id="recent-carousel" class="carousel slide" data-bs-ride="carousel">
                    <!-- Indicateurs -->
                    <ol class="carousel-indicators">
                        <?php for ($i = 0; $i < $recent_count; $i++) { ?>
                            <li data-bs-target="#recent-carousel" data-bs-slide-to="<?= $i ?>" <?php if ($i == 0) echo 'class="active"'; ?>></li>
                        <?php } ?>
                    </ol>

                    <!-- Slides -->
                    <div class="carousel-inner d-flex justify-content-center">
                        <?php foreach ($recent_rows as $index => $recent_row) { ?>
                            <div class="carousel-item <?php if ($index === 0) echo 'active'; ?>">
                                <img src="src/img/jaquettes/<?= $recent_row['disc_picture']; ?>" alt="Jaquette" class="d-block mx-auto" style="width: 50px; height: 50px; object-fit: cover;">
                                <div class="text-center mt-2">
                                    <div><?= $recent_row['disc_title']; ?></div>
                                    <div><?= $recent_row['artist_name']; ?></div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                                        <!-- Contrôles -->
                                        <a class="carousel-control-prev" href="#recent-carousel" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Précédent</span>
                    </a>
                    <a class="carousel-control-next" href="#recent-carousel" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Suivant</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin de l'encadré "Ajouté récemment" -->

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
    <script src="./js/script.js"></script>
</body>
</html>


