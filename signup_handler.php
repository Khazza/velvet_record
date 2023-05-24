<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

session_start();
include('db.php');

// Transform JSON data from AJAX request into $_POST
$_POST = json_decode(file_get_contents('php://input'), true);

// Check CSRF token
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode(["status" => "error", "message" => "csrf_error"]);
    exit;
}

// Check fields
if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) {
    echo json_encode(["status" => "error", "message" => "username_error"]);
    exit;
}
if (strlen($_POST['password']) < 5) {
    echo json_encode(["status" => "error", "message" => "password_length_error"]);
    exit;
}
if (!preg_match('/[A-Z]/', $_POST['password']) || !preg_match('/[a-z]/', $_POST['password'])) {
    echo json_encode(["status" => "error", "message" => "password_case_error"]);
    exit;
}
if ($_POST['password'] !== $_POST['confirm_password']) {
    echo json_encode(["status" => "error", "message" => "password_mismatch_error"]);
    exit;
}

// Check if username is already taken
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$_POST['username']]);
$user = $stmt->fetch();

if ($user) {
    echo json_encode(["status" => "error", "message" => "username_taken_error"]);
    exit;
}

// If everything is okay, add user to the database
$stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->execute([$_POST['username'], password_hash($_POST['password'], PASSWORD_DEFAULT)]);

echo json_encode(["status" => "success"]);
exit;
?>
