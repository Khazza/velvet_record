<?php
session_start();
include('db.php');

// Vérification si les champs de formulaire sont renseignés
if (!isset($_POST["username"]) || !isset($_POST["email"]) || !isset($_POST["password"]) || !isset($_POST["confirm_password"])) {
    header("Location: signup.php");
    exit;
}

// Vérification du jeton CSRF
if (!isset($_POST["csrf_token"]) || !isset($_SESSION["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
    header("Location: index.php");
    exit;
}

// Vérification si l'utilisateur existe déjà
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
$stmt->execute([$_POST["username"], $_POST["email"]]);
$user = $stmt->fetch();

if ($user) {
    $_SESSION["signup_error"] = "Nom d'utilisateur ou adresse email déjà utilisé.";
    header("Location: signup.php");
    exit;
}

// Vérification si les mots de passe correspondent
if ($_POST["password"] !== $_POST["confirm_password"]) {
    $_SESSION["signup_error"] = "Les mots de passe ne correspondent pas.";
    header("Location: signup.php");
    exit;
}

// Hashage du mot de passe
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

// Insertion du nouvel utilisateur dans la base de données
$stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->execute([$_POST["username"], $_POST["email"], $password_hash]);

// Redirection vers la page de connexion
header("Location: login.php");
exit;
?>
