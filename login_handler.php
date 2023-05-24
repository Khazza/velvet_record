<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

session_start();
include('db.php');

// Transform JSON data from AJAX request into $_POST
$_POST = json_decode(file_get_contents('php://input'), true);

// Check CSRF token
if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
    echo json_encode(["status" => "error", "message" => "csrf_error"]);
    exit;
}

// Check if login fields are set
if (!isset($_POST["username"]) || !isset($_POST["password"])) {
    echo json_encode(["status" => "error", "message" => "field_error"]);
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
    echo json_encode(["status" => "success"]);
    exit;
} else {
    // Wrong username/password combination
    echo json_encode(["status" => "error", "message" => "auth_error"]);
    exit;
}
?>
