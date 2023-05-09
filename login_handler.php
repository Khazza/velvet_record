<?php
// Démarrage de la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclure le fichier de connexion à la base de données
include "db.php";

// Vérifie si la méthode de requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Vérifie si le token CSRF est valide
    if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
        die("Token CSRF invalide");
    }

    // Vérifie si les champs requis ont été remplis
    if (empty($_POST["username"]) || empty($_POST["password"])) {
        die("Veuillez remplir tous les champs");
    }

    // Échapper les données utilisateur pour éviter les attaques par injection SQL
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);

    // Rechercher l'utilisateur dans la base de données
    $query = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $query->execute([$username]);

    // Vérifie si l'utilisateur existe dans la base de données
    if ($query->rowCount() > 0) {

        // Récupère le mot de passe haché de l'utilisateur
        $user = $query->fetch();
        $password_hash = $user["password"];

        // Vérifie si le mot de passe est correct
        if (password_verify($password, $password_hash)) {

            // Authentification réussie, stocke l'ID de l'utilisateur en session
            $_SESSION["user_id"] = $user["id"];

            // Redirige l'utilisateur vers la page d'accueil
            header("Location: index.php");
            exit();

        } else {
            die("Mot de passe incorrect");
        }

    } else {
        die("Nom d'utilisateur incorrect");
    }

} else {
    die("Méthode de requête invalide");
}
