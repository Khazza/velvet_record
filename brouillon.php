<!-- MODIF FORMULAIRE DE MODIF -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Modifier le disque</title>
    <!-- Inclusion de Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <!-- Inclusion du fichier CSS personnalisé -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h1 class="text-center">Modifier le disque</h1>
        <form method="POST" action="process_edit_disc.php?id=<?php echo $row['disc_id']; ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Titre</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Entrez le titre" value="<?php echo $row['disc_title']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="artist" class="form-label">Artiste</label>
                <select class="form-select" id="artist" name="artist" required>
                    <option value="">Sélectionner un artiste</option>
                    <?php foreach ($artists as $artist) : ?>
                        <option value="<?php echo $artist['artist_id']; ?>" <?php if ($artist['artist_id'] == $row['artist_id']) echo 'selected'; ?>><?php echo $artist['artist_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="label" class="form-label">Label</label>
                <input type="text" class="form-control" id="label" name="label" placeholder="Entrez le label" value="<?php echo $row['disc_label']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Année</label>
                <input type="number" class="form-control" id="year" name="year" placeholder="Entrez l'année" value="<?php echo $row['disc_year']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" placeholder="Entrez le genre" value="<?php echo $row['disc_genre']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Prix</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" placeholder="Entrez le prix" value="<?php echo $row['disc_price']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">Jaquette</label>
                <input type="file" class="form-control" id="picture" name="picture" accept="image/*">
            </div>
            <div class="mb-3">
                <?php if ($row['disc_picture']) : ?>
                    <img src="src/img/jaquettes/<?php echo $row['disc_picture']; ?>" alt="<?php echo $row['disc_title']; ?>" width="200">
                <?php else : ?>
                    <span>Aucune jaquette disponible</span>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        </form>
    </div>

    <!-- Inclusion des scripts Bootstrap et des scripts JS supplémentaires -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Inclusion du fichier JS personnalisé -->
    <script src="script.js"></script>
</body>

</html>


---------------------------------------------------------------------------------------------------------
MODIF PROCESS ADD disc

<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $new_artist = $_POST['new_artist'];
    $year = $_POST['year'];
    $genre = $_POST['genre'];
    $label = $_POST['label'];
    $price = $_POST['price'];

    // Vérifier si l'artiste existe déjà ou si un nouvel artiste a été saisi
    if (!empty($artist)) {
        $artist_id = $artist;
    } elseif (!empty($new_artist)) {
        // Insérer le nouvel artiste dans la table "artist"
        $newArtistStmt = $pdo->prepare("INSERT INTO artist (artist_name) VALUES (?)");
        $newArtistStmt->execute([$new_artist]);

        // Récupérer l'ID du nouvel artiste inséré
        $artist_id = $pdo->lastInsertId();
    } else {
        // Les champs artiste sont tous les deux vides
        echo "Veuillez sélectionner un artiste existant ou entrer un nouvel artiste.";
        exit;
    }

    // Mettre à jour les données du disque dans la base de données
    $updateStmt = $pdo->prepare("UPDATE disc SET disc_title = ?, artist_id = ?, disc_year = ?, disc_genre = ?, disc_label = ?, disc_price = ? WHERE disc_id = ?");
    $updateStmt->execute([$title, $artist_id, $year, $genre, $label, $price, $id]);

    echo "Les modifications ont été enregistrées avec succès.";
} else {
    echo "Une erreur s'est produite lors du traitement des données.";
}
?>



--------------------------------------------------------------------------------------------------------------------
MODIF PAGE DETAILS

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
    <div class="container">
        <h1 class="text-center"><?php echo $row['disc_title']; ?></h1>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="artist" class="form-label">Artiste</label>
                    <input type="text" class="form-control" id="artist" value="<?php echo $row['artist_name']; ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="label" class="form-label">Label</label>
                    <input type="text" class="form-control" id="label" value="<?php echo $row['disc_label']; ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="year" class="form-label">Année</label>
                    <input type="text" class="form-control" id="year" value="<?php echo $row['disc_year']; ?>" disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="genre" class="form-label">Genre</label>
                    <input type="text" class="form-control" id="genre" value="<?php echo $row['disc_genre']; ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Prix</label>
                    <input type="text" class="form-control" id="price" value="<?php echo $row['disc_price']; ?>" disabled>
                </div>
            </div>
        </div>
        <div class="text-center">
            <img src="src/img/jaquettes/<?php echo $row['disc_picture']; ?>" alt="<?php echo $row['disc_title']; ?>"><br>
        </div>
        <div class="text-center mt-3">
            <a href="edit_disc.php?id=<?php echo $row['disc_id']; ?>" class="btn btn-warning">Modifier</a>
            <a href="delete_disc.php?id=<?php echo $row['disc_id']; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce disque ?')">Supprimer</a>
            <a href="javascript:history.back()" class="btn btn-primary">Retour</a>
        </div>
    </div>
    <!-- Inclusion des scripts Bootstrap et des scripts JS supplémentaires -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Inclusion du fichier JS personnalisé -->
    <script src="script.js"></script>
</body>

</html>