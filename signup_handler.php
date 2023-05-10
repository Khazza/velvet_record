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
    die("Erreur : les mots de passe ne correspondent pas.");
}

// Vérification que le nom d'utilisateur n'est pas déjà utilisé
$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
$stmt->execute([$username]);
if($stmt->fetchColumn() > 0) {
    die("Erreur : ce nom d'utilisateur est déjà utilisé.");
}

// Vérification de la complexité du mot de passe
if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{5,}$/', $password)) {
    die("Erreur : le mot de passe doit comporter au moins 5 caractères avec une majuscule, une minuscule et un chiffre.");
}

// Hashage du mot de passe
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insertion du nouvel utilisateur dans la base de données
$stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->execute([$username, $hashed_password]);

// // Redirection vers la page de succès
// header("Location: signup_success.php");
// exit;

// Redirection vers la page d'index après création de compte
header("Location: index.php");
exit();
?>
