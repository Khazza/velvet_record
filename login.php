<?php
session_start();
include('db.php');

// Générer un nouveau jeton CSRF et l'enregistrer dans la variable de session
if (!isset($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

$csrf_token = isset($_SESSION["csrf_token"]) ? $_SESSION["csrf_token"] : '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // récupération des données de formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];
    // code de vérification du nom d'utilisateur et du mot de passe
    // ...
    // si l'authentification est réussie, stock le nom d'utilisateur dans session
    $_SESSION['user'] = $username;
    // rediriger l'utilisateur vers la page d'accueil
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="POST" action="login_handler.php">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
