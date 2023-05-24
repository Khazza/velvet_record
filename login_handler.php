<?php
session_start();
include('db.php');

// Check CSRF token
if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
    echo "csrf_error";
    exit;
}

// Check if login fields are set
if (!isset($_POST["username"]) || !isset($_POST["password"])) {
    echo "field_error";
    exit;
}

// Fetch user from the database
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$_POST["username"]]);
$user = $stmt->fetch();

// Check password
if ($user && password_verify($_POST["password"], $user["password"])) {
    // Successful authentication, store user in session
    $_SESSION["user"] = $user;
    echo "success";
    exit;
} else {
    // Wrong username/password combination
    echo "auth_error";
    exit;
}
?>