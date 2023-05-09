<?php
// Inclure le fichier de connexion à la base de données
include "db.php";

// Vérifie si la méthode de requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Vérifie si le token CSRF est valide
    if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
        die("Token CSRF invalide");
    }

    // Vérifie si les champs requis ont été remplis
    if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["confirm_password"])) {
        die("Veuillez remplir tous les champs");
    }

    // Vérifie si les mots de passe correspondent
    if ($_POST["password"] !== $_POST["confirm_password"]) {
        die("Les mots de passe ne correspondent pas");
    }

    // Vérifie si le mot de passe répond aux exigences de complexité
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $_POST["password"])) {
        die("Le mot de passe doit comporter au moins 8 caractères, une majuscule et une minuscule");
    }

    // Échapper les données utilisateur pour éviter les attaques par injection SQL
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);

    // Hacher le mot de passe avec la fonction password_hash avant de l'insérer dans la base de données
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Préparer la requête SQL pour insérer le nouvel utilisateur dans la base de données
    $query = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");

    // Exécuter la requête SQL avec les valeurs des paramètres liés
    if ($query->execute([$username, $password_hash])) {
        echo "Nouvel utilisateur créé avec succès";
    } else {
        echo "Erreur lors de la création de l'utilisateur: " . $query->errorInfo()[2];
    }
} else {
    die("Méthode de requête invalide");
}
