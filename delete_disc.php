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

    // Supprimer le disque
    $disc_sql = "DELETE FROM disc WHERE disc_id = :id";
    $disc_stmt = $pdo->prepare($disc_sql);
    $disc_stmt->execute(['id' => $id]);

    // Si l'artiste n'a pas d'autres disques, le supprimer également
    if ($count == 1) {
        $artist_sql = "DELETE FROM artist WHERE artist_id = :artist_id";
        $artist_stmt = $pdo->prepare($artist_sql);
        $artist_stmt->execute(['artist_id' => $artist_id]);
    }

    // Redirection vers la page de liste des disques après suppression
    header("Location: index.php");
    exit;
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>
    <h1>Confirmation de suppression</h1>
    <p>Êtes-vous sûr de vouloir supprimer ce disque ?</p>
    <form method="post">
        <button type="submit" name="confirm" class="btn btn-danger">Confirmer</button>
        <a href="details.php?id=<?php echo $id; ?>" class="btn btn-secondary">Annuler</a>
    </form>

    <!-- Inclusion des scripts Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
