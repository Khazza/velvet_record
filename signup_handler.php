<?php
session_start();
include('db.php');

// Vérification du jeton CSRF
if ($_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
    die("Erreur : jeton CSRF invalide.");
}

// Récupération des données du formulaire
$username = $_POST["username"];
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];

// Vérification que les mots de passe correspondent
if ($password !== $confirm_password) {
    die("Erreur : les mots de passe ne correspondent pas.");
}

// Vérification que le nom d'utilisateur n'est pas déjà utilisé
$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
$stmt->execute([$username]);
if ($stmt->fetchColumn() > 0) {
    die("Erreur : ce nom d'utilisateur est déjà utilisé.");
}

// Vérification de la complexité du mot de passe
if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{5,}$/', $password)) {
    $error = "Erreur : le mot de passe doit comporter au moins 5 caractères avec une majuscule, une minuscule et un chiffre.";
} else {
    // Hashage du mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertion du nouvel utilisateur dans la base de données
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $hashed_password]);

    // Redirection vers la page d'index après création de compte
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Inscription</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Inscription</h2>
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger" role="alert">
                <?= $error ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="signup_handler.php">
            <div class="mb-3">
                <label for="username" class="form-label">Nom d'utilisateur :</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe :</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirmer le mot de passe :</label>
                <input type="password" class="form-control" name="confirm_password" required>
            </div>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION["csrf_token"]; ?>">
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>