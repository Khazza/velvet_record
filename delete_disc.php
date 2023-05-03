<?php
include 'db.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Requête SQL pour supprimer le disque avec l'identifiant spécifié
        $sql = "DELETE FROM disc WHERE disc_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
