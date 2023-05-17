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
    // Après la suppression réussie du disque
    $_SESSION['success_message'] = "Le disque a été supprimé avec succès.";
    header("Location: index.php");
    exit;
} else {
    echo "Identifiant non fourni";
    exit;
}
