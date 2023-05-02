<?php
    include('db.php');

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Requête SQL pour supprimer le disque avec l'identifiant spécifié
        $sql = "DELETE FROM disc WHERE disc_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        // Redirection vers la page de liste des disques après suppression
        header("Location: discs.php");
        exit;
    } else {
        echo "Identifiant non fourni";
        exit;
    }
?>
------------
Ce fichier delete_disc.php effectue les actions suivantes :

Inclure le fichier de connexion à la base de données (db.php).
Vérifier si un identifiant de disque est fourni dans l'URL via $_GET['id'].
Exécuter une requête SQL pour supprimer le disque correspondant à l'identifiant spécifié.
Rediriger l'utilisateur vers la page discs.php (la liste des disques) après suppression.
Utiliser exit pour arrêter l'exécution du script.
Assurez-vous de mettre à jour le nom du fichier de redirection (discs.php) en fonction de votre application.

N'oubliez pas de sécuriser votre application en utilisant 
des mesures appropriées pour la suppression des données, telles que la vérification des autorisations et la confirmation de la suppression.



----------------------------------------
<?php
    include('db.php');

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Vérifier si le formulaire de confirmation a été soumis
        if (isset($_POST['confirm'])) {
            // Suppression du disque après confirmation
            $sql = "DELETE FROM disc WHERE disc_id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id' => $id]);

            // Redirection vers la page de liste des disques après suppression
            header("Location: discs.php");
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

Dans la page details.php, remplacez le lien du bouton "Supprimer" par le lien qui pointe vers delete_disc.php
 en incluant l'identifiant du disque à supprimer dans l'URL. Voici un exemple :

<a href="delete_disc.php?id=<?php echo $row['disc_id']; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce disque ?')">Supprimer</a>
Dans cet exemple, le lien du bouton "Supprimer" est mis à jour pour pointer vers delete_disc.php avec
 l'identifiant du disque ($row['disc_id']) ajouté à l'URL en tant que paramètre GET. De plus, la fonction confirm() est utilisée pour afficher une 
 boîte de dialogue de confirmation avec un message demandant à l'utilisateur de confirmer la suppression.
 

