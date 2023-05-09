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



ALTER TABLE users
MODIFY COLUMN password VARCHAR(255)
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci
    NOT NULL
    CHECK (password REGEXP '^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$');

    
    Cette requête modifie la colonne "password" pour ajouter une contrainte "CHECK" qui vérifie que le mot de passe respecte l'expression 
    régulière "^(?=.[a-z])(?=.[A-Z])(?=.*[0-9]).{8,}$", 
    qui correspond à la présence d'au moins une minuscule, une majuscule et un chiffre, ainsi qu'à une longueur minimale de 8 caractères.


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