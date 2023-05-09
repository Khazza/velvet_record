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

// Requête pour récupérer l'utilisateur correspondant au nom d'utilisateur et au mot de passe
$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

// Vérification des résultats
if ($result->num_rows == 1) {
    // Utilisateur trouvé, création de la session
    session_start();
    $_SESSION["username"] = $username;
    $_SESSION["role"] = $result->fetch_assoc()["role"];
    header("Location: index.php"); // Redirection vers la page d'accueil
} else {
    // Utilisateur non trouvé, retour à la page de login avec un message d'erreur
    header("Location: login.php?error=1");
}
$conn->close();
?>