<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtenir l'artiste du disque à supprimer
    $artist_sql = "SELECT artist_id FROM disc WHERE disc_id = :id";
    $artist_stmt = $pdo->prepare($artist_sql);
    $artist_stmt->execute(['id' => $id]);
    $artist_id = $artist_stmt->fetchColumn();

    // Compter le nombre de disques de l'artiste
    $count_sql = "SELECT COUNT(*) FROM disc WHERE artist_id = :artist_id";
    $count_stmt = $pdo->prepare($count_sql);
    $count_stmt->execute(['artist_id' => $artist_id]);
    $count = $count_stmt->fetchColumn();

    if (isset($_POST['confirm'])) {
        // Le formulaire de confirmation a été soumis, effectuez la suppression
        $disc_sql = "DELETE FROM disc WHERE disc_id = :id";
        $disc_stmt = $pdo->prepare($disc_sql);
        $disc_stmt->execute(['id' => $id]);

        // Si l'artiste n'a pas d'autres disques, le supprimer également
        if ($count == 1) {
            $artist_sql = "DELETE FROM artist WHERE artist_id = :artist_id";
            $artist_stmt = $pdo->prepare($artist_sql);
            $artist_stmt->execute(['artist_id' => $artist_id]);
        }

        // Rediriger vers la page de liste des disques après suppression
        header("Location: index.php");
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
    <title>Confirmation de suppression</title>
    <!-- Inclusion de Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- Inclusion du fichier CSS personnalisé -->
    <link rel="stylesheet" href="./assets/css/styles.css">

</head>

<body>
    <h1>Confirmation de suppression</h1>
    <p>Êtes-vous sûr de vouloir supprimer ce disque ?</p>
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal">Confirmer</button>
    <a href="details.php?id=<?php echo $id; ?>" class="btn btn-secondary">Annuler</a>

    <!-- Modal de confirmation -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmation de suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer ce disque ?
                </div>
                <div class="modal-footer">
                    <form method="post">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" name="confirm" class="btn btn-danger">Confirmer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Inclusion des scripts Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>