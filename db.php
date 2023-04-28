<?php
$host = "localhost";
$username = "admin";
$password = "cv05";
$database = "record";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>