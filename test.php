<!-- test navbar pour le username -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand fs-1 fw-bold">
            Liste des disques (<span class="counter-style"><?php echo $count; ?></span>)
        </a>
        <div class="ml-auto">
            <?php if (isset($_SESSION['user'])) { ?>
                <span class="navbar-text me-2">
                    Bonjour <?php echo $_SESSION['user']; ?> !
                </span>
                <a href="logout.php" class="btn btn-outline-primary me-2">Logout</a>
                <a href="add_disc.php" class="btn btn-primary">Ajouter un Disque</a>
            <?php } else { ?>
                <a href="login.php" class="btn btn-outline-primary me-2">Log in</a>
                <a href="signup.php" class="btn btn-primary">Sign up</a>
            <?php } ?>
        </div>
    </div>
</nav>


<!-- -------------------------------------------------------------- -->
<!-- -------------------------------------------------------------- -->
<!-- -------------------------------------------------------------- -->
<!-- -------------------------------------------------------------- -->
<!-- -------------------------------------------------------------- -->

Pour stocker le nom de l'utilisateur connecté dans la variable de session $_SESSION['user'], 
vous pouvez ajouter le nom d'utilisateur à la session après une connexion réussie. Voici comment vous pouvez le faire:

Tout d'abord, vous devez récupérer le nom d'utilisateur lorsqu'un utilisateur se connecte. 
Supposons que vous avez un formulaire de connexion avec deux champs: nom d'utilisateur et mot de passe. 
Vous pouvez récupérer le nom d'utilisateur à partir de ce formulaire de connexion en utilisant la superglobale $_POST.
Voici un exemple de code pour récupérer le nom d'utilisateur dans votre fichier de connexion (login.php):

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // récupération des données de formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];
    // code de vérification du nom d'utilisateur et du mot de passe
    // ...
    // si l'authentification est réussie, stockez le nom d'utilisateur dans la variable de session
    $_SESSION['user'] = $username;
    // rediriger l'utilisateur vers la page d'accueil
    header('Location: index.php');
    exit;
}
Maintenant, vous pouvez vérifier si un utilisateur est connecté en vérifiant si $_SESSION['user'] est défini. Par exemple, 
dans votre fichier index.php, vous pouvez vérifier si l'utilisateur est connecté comme suit:
<?php
session_start();
if(isset($_SESSION['user'])) {
    // l'utilisateur est connecté, afficher le nom d'utilisateur
    echo "Bonjour " . $_SESSION['user'] . " !";
} else {
    // l'utilisateur n'est pas connecté, afficher un message de bienvenue
    echo "Bienvenue, veuillez vous connecter.";
}
?>
Notez que vous devez appeler session_start() avant d'utiliser la variable de session $_SESSION.




Warning: Array to string conversion in /home/mahe/Bureau/velvet_record/index.php on line 5