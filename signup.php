<?php
session_start();
include ('db.php');

// Génération d'un jeton CSRF
$csrf_token = bin2hex(random_bytes(32));
$_SESSION["csrf_token"] = $csrf_token;

session_start();
if(isset($_SESSION['errors'])) {
    foreach ($_SESSION['errors'] as $error) {
        echo "<p>" . $error . "</p>";
    }
    unset($_SESSION['errors']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>
    <form action="signup_handler.php" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required><br>

        <label for="confirm_password">Confirmer le mot de passe :</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br>

        <button type="submit">S'inscrire</button>
    </form>

    <a href="index.php">Retour à la page d'accueil</a>
</body>
</html>
