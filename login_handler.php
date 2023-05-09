<?php
session_start();
include_once("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifie si les champs requis ont été remplis
    if (empty($_POST["username"]) || empty($_POST["password"])) {
        die("Veuillez remplir tous les champs");
    }

    $username = $_POST["username"];
    $password = $_POST["password"];

    // Récupère l'utilisateur correspondant à l'identifiant fourni
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Vérifie si l'utilisateur existe et si le mot de passe est correct
    if ($user && password_verify($password, $user['password'])) {
        // Stocke les informations de l'utilisateur dans la session
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];

        // Redirige vers la page d'accueil
        header("Location: index.php");
        exit();
    } else {
        die("Identifiants incorrects");
    }
} else {
    die("Méthode de requête invalide");
}
