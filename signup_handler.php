<?php
session_start();
include('db.php');

// Vérification du jeton CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['errors'][] = "CSRF token validation failed.";
    header("Location: signup.php");
    exit();
}

// Vérification des champs
if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) {
    $_SESSION['errors'][] = "Le nom d'utilisateur ne doit contenir que des lettres et des chiffres.";
}
if (strlen($_POST['password']) < 5) {
    $_SESSION['errors'][] = "Le mot de passe doit comporter au moins 5 caractères.";
}
if (!preg_match('/[A-Z]/', $_POST['password']) || !preg_match('/[a-z]/', $_POST['password'])) {
    $_SESSION['errors'][] = "Le mot de passe doit contenir au moins une lettre majuscule et une lettre minuscule.";
}
if ($_POST['password'] !== $_POST['confirm_password']) {
    $_SESSION['errors'][] = "Les mots de passe ne correspondent pas.";
}

// Vérification si le nom d'utilisateur est déjà pris
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$_POST['username']]);
$user = $stmt->fetch();

if ($user) {
    $_SESSION['errors'][] = "Le nom d'utilisateur est déjà pris.";
    header("Location: signup.php");
    exit();
}

// Si des erreurs ont été détectées, retourner sur la page signup.php
if (!empty($_SESSION['errors'])) {
    header("Location: signup.php");
    exit();
}

// Si tout est correct, ajouter l'utilisateur à la base de données
$stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->execute([$_POST['username'], password_hash($_POST['password'], PASSWORD_DEFAULT)]);

// Récupérer l'utilisateur fraîchement inscrit et le connecter
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$_POST['username']]);
$user = $stmt->fetch();

if ($user) {
    $_SESSION["user"] = $user;
    $_SESSION["register_success"] = "Inscription réussie! Vous êtes maintenant connecté.";
    header("Location: index.php");  // Rediriger vers l'index
    exit();
} else {
    $_SESSION["errors"][] = "Erreur lors de l'inscription. Veuillez réessayer.";
    header("Location: signup.php");
    exit();
}
?>
