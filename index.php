<?php
session_start();
include('db.php');

// Vérifiez si l'utilisateur est connecté
if (isset($_SESSION['user'])) {
    // Récupérez le nom d'utilisateur et le rôle de l'utilisateur
    $username = $_SESSION['user']['username'];
    $role = $_SESSION['user']['role'];
}

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- Inclusion du fichier CSS personnalisé -->
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light py-0">
        <div class="container">
            <a class="navbar-brand fs-1 fw-bold">
                Liste des disques
                <div class="info-bubble">
                    <?php echo $count; ?>
                </div>
            </a>
            <div class="ml-auto">
                <?php if (isset($_SESSION['user'])) { ?>
                    <span class="navbar-text me-2">Bonjour, <?php echo $username; ?></span>
                    <a href="logout.php" class="btn btn-outline-primary me-2">Logout</a>
                    <?php if ($role === 'admin') { ?>
                        <a href="add_disc.php" class="btn btn-primary">Ajouter un Disque</a>
                    <?php } ?>
                <?php } else { ?>
                    <a href="login.php" class="btn btn-outline-primary me-2">Log in</a>
                    <a href="signup.php" class="btn btn-primary">Sign up</a>
                <?php } ?>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mb-3 border-0 history-container">
                    <div class="card-body">
                        <h5 class="card-title text-center history-title">Ajoutés récemment :</h5>
                        <div class="row d-flex justify-content-center history-content">
                            <?php
                            // Requête SQL pour sélectionner les 5 derniers de la table disc
                            $history_sql = "SELECT * 
                    FROM disc
                    JOIN artist ON disc.artist_id = artist.artist_id
                    ORDER BY disc_id DESC
                    LIMIT 5";
                            $history_stmt = $pdo->query($history_sql);

                            // Boucle pour afficher les enregistrements de l'historique
                            while ($history_row = $history_stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <div class="col-md-2 text-center">
                                    <img src="src/img/jaquettes/<?= $history_row['disc_picture']; ?>" class="card-img-top" alt="Jaquette">
                                    <div class="mt-2">
                                        <span class="disc-title">
                                            <?php echo $history_row['disc_title']; ?>
                                        </span><br>
                                        <span class="artist-name">
                                            <?php echo $history_row['artist_name']; ?>
                                        </span>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


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
                    <div class="card mb-3 border border-0 disc-card">
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

    <!-- Inclusion de jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Inclusion des scripts Bootstrap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
    <!-- Inclusion de SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
    <!-- Inclusion du script JS personnalisé -->
    <script src="./js/script.js"></script>

    <script>
        var register_success = <?php echo json_encode($_SESSION['register_success'] ?? null); ?>;
        <?php
        if (isset($_SESSION['register_success'])) {
            unset($_SESSION['register_success']);
        }
        ?>
    </script>

</body>

</html>