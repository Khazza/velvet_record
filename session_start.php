<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire de connexion
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérifier si l'utilisateur existe dans la base de données
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si le mot de passe est correct
    if ($user && password_verify($password, $user['password'])) {
        // Stocker les informations d'identification dans la session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];

        // Rediriger vers la page d'accueil
        header('Location: index.php');
        exit;
    } else {
        // Afficher un message d'erreur si les informations d'identification sont incorrectes
        $error_message = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>