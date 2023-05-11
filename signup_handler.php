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
    $_SESSION['errors'][] = "Username must only contain letters and digits.";
}
if (strlen($_POST['password']) < 5) {
    $_SESSION['errors'][] = "Password must be at least 5 characters long.";
}
if (!preg_match('/[A-Z]/', $_POST['password']) || !preg_match('/[a-z]/', $_POST['password'])) {
    $_SESSION['errors'][] = "Password must contain at least one uppercase and one lowercase letter.";
}
if ($_POST['password'] !== $_POST['confirm_password']) {
    $_SESSION['errors'][] = "Passwords don't match.";
}

// Si des erreurs ont été détectées, retourner sur la page signup.php
if (!empty($_SESSION['errors'])) {
    header("Location: signup.php");
    exit();
}

// Si tout est correct, ajouter l'utilisateur à la base de données
$stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->execute([$_POST['username'], password_hash($_POST['password'], PASSWORD_DEFAULT)]);

// Rediriger l'utilisateur vers une page de succès
header("Location: signup_success.php");
exit();
?>
