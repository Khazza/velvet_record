<?php
session_start();
include ('db.php');

// Vérification du jeton CSRF
if($_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
    die("Erreur : jeton CSRF invalide.");
}

// Récupération des données du formulaire
$username = $_POST["username"];
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];

// Vérification que les mots de passe correspondent
if($password !== $confirm_password) {
    $error_msg = "Les mots de passe ne correspondent pas.";
} else {
    // Vérification que le mot de passe respecte la regex (5 caractères, une majuscule et une minuscule minimum)
    if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z]).{5,}$/", $password)) {
        $error_msg = "Le mot de passe doit contenir au moins 5 caractères, une majuscule et une minuscule.";
    } else {
        // Vérification que le nom d'utilisateur n'est pas déjà utilisé
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if($stmt->fetchColumn() > 0) {
            $error_msg = "Ce nom d'utilisateur est déjà utilisé.";
        } else {
            // Hashage du mot de passe
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insertion du nouvel utilisateur dans la base de données
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $hashed_password]);

            // Affichage d'un message de succès
            $success_msg = "Votre compte a bien été créé !";
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inscription</title>
</head>
<body>
    <?php if(isset($error_msg)): ?>
        <p><?php echo $error_msg; ?></p>
    <?php endif; ?>
    <?php if(isset($success_msg)): ?>
        <p><?php echo $success_msg; ?></p>
    <?php endif; ?>
    <a href="index.php">Retour à la page d'accueil</a>
</body>
</html>