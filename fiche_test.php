<?php
// Informations de connexion à la base de données
$host = "localhost";
$dbname = "record";
$username = "admin";
$password = "cv05";

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Définition du mode d'erreur PDO sur Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit;
}

// Fonction pour exécuter une requête SQL
function executeQuery($sql, $params = []) {
    global $pdo;
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        exit;
    }
}
?>
Maintenant, dans chaque page où vous souhaitez accéder à la base de données, vous pouvez simplement inclure le fichier database.php en utilisant la directive require_once :

<?php
// Inclure le fichier de la base de données
require_once 'database.php';
?>
// Votre code de la page ici
// Vous pouvez maintenant utiliser l'objet $pdo pour exécuter des requêtes SQL sans avoir à vous soucier de la connexion à la base de données
En incluant database.php, vous disposez maintenant d'un accès facile à la base de données dans toutes vos pages sans avoir à répéter la connexion et les requêtes à chaque fois.




Tout d'abord, les informations de connexion à la base de données sont définies dans les variables $host, $dbname, $username et $password. 
Vous devez les modifier en fonction de vos propres informations de connexion.

Ensuite, une tentative de connexion à la base de données est effectuée en utilisant la classe PDO. La ligne $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password); 
crée un nouvel objet PDO qui représente la connexion à la base de données.

L'instruction $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); définit le mode d'erreur de PDO sur ERRMODE_EXCEPTION, 
ce qui signifie que PDO lancera une exception en cas d'erreur lors de l'exécution d'une requête SQL. Cela facilite la détection et la gestion des erreurs.

Ensuite, une fonction appelée executeQuery() est définie. Cette fonction prend en paramètres une requête SQL et éventuellement des 
paramètres pour les requêtes préparées. Elle exécute la requête en utilisant l'objet PDO et retourne le résultat sous la forme d'un objet PDOStatement. 
Si une erreur se produit lors de l'exécution de la requête, une exception est levée.

Enfin, vous pouvez inclure le fichier database.php dans vos autres fichiers PHP à l'aide de la directive require_once 'database.php';. 
Cela permet d'inclure les informations de connexion à la base de données et la fonction executeQuery() dans chaque fichier où vous avez besoin d'accéder à la base de données. 
Vous pouvez ensuite utiliser l'objet $pdo pour exécuter des requêtes SQL en appelant la fonction executeQuery() avec la requête SQL appropriée et les paramètres si nécessaire.

En résumé, le fichier database.php établit la connexion à la base de données et fournit une fonction réutilisable pour exécuter des requêtes SQL. 
En l'incluant dans vos autres fichiers PHP, vous pouvez facilement accéder à la base de données sans avoir à répéter la connexion et les requêtes à chaque fois.



---------------------------------------

<?php
    include('db.php');
    // Récupération de la liste des artistes pour le select
    $artist_sql = "SELECT * FROM artist";
    $artist_stmt = $pdo->query($artist_sql);
    $artists = $artist_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ajouter un vinyle</title>
    <!-- Inclusion de Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <!-- Inclusion du fichier CSS personnalisé -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Ajouter un vinyle</h1>
        <form method="POST" action="process_add_disc.php">
            <div class="mb-3">
                <label for="title" class="form-label">Titre</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" required>
            </div>
            <div class="mb-3">
                <label for="artist" class="form-label">Artiste</label>
                <select class="form-select" id="artist" name="artist" required>
                    <option value="">Sélectionner un artiste</option>
                    <?php foreach ($artists as $artist) : ?>
                        <option value="<?= $artist['artist_id']; ?>"><?= $artist['artist_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="new_artist" class="form-label">Nouvel artiste</label>
                <input type="text" class="form-control" id="new_artist" name="new_artist" placeholder="Enter artist">
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Année</label>
                <input type="number" class="form-control" id="year" name="year" placeholder="Enter year" required>
            </div>
            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" placeholder="Enter genre" required>
            </div>
            <div class="mb-3">
                <label for="label" class="form-label">Label</label>
                <input type="text" class="form-control" id="label" name="label" placeholder="Enter label" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">Jaquette</label>
                <input type="text" class="form-control" id="picture" name="picture" placeholder="URL de l'image">
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
    <!-- Inclusion des scripts Bootstrap et des scripts JS supplémentaires -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Inclusion du fichier JS personnalisé -->
    <script src="script.js"></script>
</body>
</html>
--------------------------------------------
ajout:

<?php
    include('db.php');

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    
        $sql = "SELECT * FROM disc JOIN artist ON disc.artist_id = artist.artist_id WHERE disc_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$row) {
            echo "Disque non trouvé";
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
    <title>Détails du disque</title>
    <!-- Inclusion de Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <!-- Inclusion du fichier CSS personnalisé -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1><?php echo $row['disc_title']; ?></h1>
    <img src="src/img/jaquettes/<?php echo $row['disc_picture']; ?>" alt="<?php echo $row['disc_title']; ?>"><br>
    <strong>Artiste :</strong> <?php echo $row['artist_name']; ?><br>
    <strong>Label :</strong> <?php echo $row['disc_label']; ?><br>
    <strong>Année :</strong> <?php echo $row['disc_year']; ?><br>
    <strong>Genre :</strong> <?php echo $row['disc_genre']; ?><br>
    <strong>Prix :</strong> <?php echo $row['disc_price']; ?> €<br>
    <a href="edit_disc.php?id=<?php echo $row['disc_id']; ?>" class="btn btn-warning">Modifier</a>
    <a href="delete_disc.php?id=<?php echo $row['disc_id']; ?>" class="btn btn-danger">Supprimer</a>

    <!-- Inclusion des scripts Bootstrap et des scripts JS supplémentaires -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Inclusion du fichier JS personnalisé -->
    <script src="script.js"></script>
</body>
</html>
---------------------
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
 
<!-- ------------
Ce fichier delete_disc.php effectue les actions suivantes :

Inclure le fichier de connexion à la base de données (db.php).
Vérifier si un identifiant de disque est fourni dans l'URL via $_GET['id'].
Exécuter une requête SQL pour supprimer le disque correspondant à l'identifiant spécifié.
Rediriger l'utilisateur vers la page discs.php (la liste des disques) après suppression.
Utiliser exit pour arrêter l'exécution du script.
Assurez-vous de mettre à jour le nom du fichier de redirection (discs.php) en fonction de votre application.

N'oubliez pas de sécuriser votre application en utilisant 
des mesures appropriées pour la suppression des données, telles que la vérification des autorisations et la confirmation de la suppression.
 -->


 -------------------------------------------------------
 <?php
    include('db.php');
    // Récupération de la liste des artistes pour le select
    $artist_sql = "SELECT * FROM artist";
    $artist_stmt = $pdo->query($artist_sql);
    $artists = $artist_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ajouter un vinyle</title>
    <!-- Inclusion de Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <!-- Inclusion du fichier CSS personnalisé -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center">Ajouter un vinyle</h1>
        <form method="POST" action="process_add_disc.php">
            <div class="mb-3">
                <label for="title" class="form-label">Titre</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" required>
            </div>
            <div class="mb-3">
                <label for="artist" class="form-label">Artiste</label>
                <select class="form-select" id="artist" name="artist" required>
                    <option value="">Sélectionner un artiste</option>
                    <?php foreach ($artists as $artist) : ?>
                        <option value="<?= $artist['artist_id']; ?>"><?= $artist['artist_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="new_artist" class="form-label">Nouvel artiste</label>
                <input type="text" class="form-control" id="new_artist" name="new_artist" placeholder="Enter artist">
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Année</label>
                <input type="number" class="form-control" id="year" name="year" placeholder="Enter year" required>
            </div>
            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" placeholder="Enter genre" required>
            </div>
            <div class="mb-3">
                <label for="label" class="form-label">Label</label>
                <input type="text" class="form-control" id="label" name="label" placeholder="Enter label" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">Jaquette</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="picture" name="picture" placeholder="URL de l'image">
                    <label class="input-group-text" for="inputGroupFile">Choisir un fichier</label>
<input type="file" class="form-control" id="inputGroupFile" name="file" accept="image/*">
</div>
</div>
<div class="mb-3">
<button type="reset" class="btn btn-secondary">Retour</button>
<button type="submit" class="btn btn-primary">Ajouter</button>
</div>
</form>
</div>
<!-- Inclusion des scripts Bootstrap et des scripts JS supplémentaires -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Inclusion du fichier JS personnalisé -->
<script src="script.js"></script>

</body>
</html>


