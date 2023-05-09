<?php
// Informations de connexion à la base de données
$host = "localhost";
$dbname = "record";
$username = "username";
$password = "password";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupération des données du formulaire
$username = $_POST["username"];
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];

// Vérification que les mots de passe sont identiques
if ($password != $confirm_password) {
    header("Location: signup.php?error=1");
   

// Arrêt du script en cas de mots de passe différents
exit();
}

// Hashage du mot de passe avant l'insertion en base de données
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insertion des données dans la table users
$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $password_hash);
$stmt->execute();
$stmt->close();

// Redirection vers la page de login en cas de succès
header("Location: login.php?success=1");
exit();

// Fermeture de la connexion à la base de données
$conn->close();
?>