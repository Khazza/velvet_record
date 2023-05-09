<!-- requête SQL pour créer une table users dans votre base de données : -->
CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user'
);
<!-- Cette table contiendra les informations de connexion des utilisateurs avec leur nom d'utilisateur (username), 
leur mot de passe hashé (password) et leur rôle (role), qui peut être soit "admin" pour un utilisateur ayant tous les droits, 
soit "user" pour un utilisateur lambda qui ne peut que consulter les pages.-->


<!-- -------------------------------------------------------------------------------------------------------------- -->
<!--code pour la page de connexion (login.php) : -->

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

<!-- Sur chaque page qui doit être protégée par une authentification, vérifier si l'utilisateur est 
connecté et a le rôle approprié en utilisant les informations de session. page details.php : -->

<!-- -------------------------------------------------------------------------------------------------------------- -->
<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Rediriger vers la page de connexion s'il n'est pas connecté
    header('Location: login.php');
    exit;
}

// Vérifier si l'utilisateur a le rôle approprié
if ($_SESSION['user_role'] !== 'admin') {
    // Rediriger vers la page d'accueil s'il n'a pas le rôle approprié
    header('Location: index.php');
    exit;
}

// Le reste du code de la page...
?>
<!--inclure session_start() au début de chaque page pour pouvoir accéder aux informations de session. -->


<!-- -------------------------------------------------------------------------------------------------------------- -->
<!-- Exemple mdp non hash -->
INSERT INTO users (username, password, role) VALUES ('Kaza', 'CV05', 'admin');

<!-- Exemple pour hashé le mot de passe: -->
INSERT INTO users (username, password, role) VALUES ('Kaza', PASSWORD('CV05'), 'admin');


<!-- -------------------------------------------------------------------------------------------------------------- -->
<!-- requete avec mdp sécurisé ! -->
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire de connexion
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérifier si le mot de passe est conforme aux exigences de sécurité
    if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $password)) {
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
    } else {
        // Afficher un message d'erreur si le mot de passe ne respecte pas les exigences de sécurité
        $error_message = "Le mot de passe doit comporter au moins 8 caractères, dont au moins une majuscule, une minuscule et un chiffre.";
    }
}
?>
<!-- Ce script doit être intégré ux pages de connexion (login.php) et d'inscription (signup.php) dans la section de traitement du formulaire de connexion. 
Placer ce code à la suite de la section qui récupère les données du formulaire et avant la section qui affiche les erreurs éventuelles. 
Initialiser la variable $pdo avec une connexion à la base de données. -->

<!-- ---------------------------------------------------------------------------------------------------------------------------------------- -->
<!-- Bouton page index navbar: -->

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand fs-1 fw-bold">
            Liste des disques (<span class="counter-style"><?php echo $count; ?></span>)
        </a>
        <div class="ml-auto">
            <a href="login.php" class="btn btn-outline-primary me-2">Log in</a>
            <a href="signup.php" class="btn btn-primary">Sign up</a>
            <a href="add_disc.php" class="btn btn-primary">Ajouter</a>
        </div>
    </div>
</nav>
