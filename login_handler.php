<?php
session_start();
include('db.php');

// Vérification du jeton CSRF
if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
    header("Location: index.php");
    exit;
}

// Vérification si les champs de connexion sont renseignés
if (!isset($_POST["username"]) || !isset($_POST["password"])) {
    header("Location: index.php");
    exit;
}

// Récupération de l'utilisateur dans la base de données
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$_POST["username"]]);
$user = $stmt->fetch();

// Vérification du mot de passe
if ($user && password_verify($_POST["password"], $user["password"])) {
    // Authentification réussie, on stocke l'utilisateur en session
    $_SESSION["user"] = $user;

    // Afficher la popup SweetAlert2
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Connexion réussie',
            text: 'Vous êtes maintenant connecté',
            showConfirmButton: false,
            timer: 1500
        }).then(function() {
            // Redirection facultative après la fermeture de la popup
            // Remplacez 'index.php' par l'URL souhaitée
            window.location.href = 'index.php';
        });
    </script>";

    exit;
} else {
    // Mauvaise combinaison nom d'utilisateur / mot de passe
    $_SESSION["login_error"] = "Mauvaise combinaison nom d'utilisateur / mot de passe.";
    header("Location: index.php?error=1");
    exit;
}
?>
