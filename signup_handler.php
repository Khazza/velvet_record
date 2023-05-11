<?php
session_start();
include ('db.php');

// Vérification du jeton CSRF
if($_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
    $_SESSION['errors'][] = "Erreur : jeton CSRF invalide.";
}

// Récupération des données du formulaire
$username = $_POST["username"];
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];

// Vérification que les mots de passe correspondent
if($password !== $confirm_password) {
    $_SESSION['errors'][] = "Erreur : les mots de passe ne correspondent pas.";
}

// Vérification de la complexité du mot de passe
if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{5,}$/', $password)) {
    $_SESSION['errors'][] = "Erreur : le mot de passe doit contenir au moins 5 caractères, une majuscule et une minuscule.";
}

// Vérification que le nom d'utilisateur n'est pas déjà utilisé
$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
$stmt->execute([$username]);
if($stmt->fetchColumn() > 0) {
    $_SESSION['errors'][] = "Erreur : ce nom d'utilisateur est déjà utilisé.";
}

// Si des erreurs sont présentes, rediriger vers la page signup.php
if(isset($_SESSION['errors'])) {
    header("Location: signup.php");
    exit();
}

// Hashage du mot de passe
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insertion du nouvel utilisateur dans la base de données
$stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->execute([$username, $hashed_password]);

// Redirection vers la page d'index après création de compte
header("Location: index.php");
exit();
?>