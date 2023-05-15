<?php
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Success</title>
    <meta http-equiv="refresh" content="3; url=index.php">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container text-center p-5">
    <h2 class="text-primary">Login Success!</h2>
    <p class="lead">Vous êtes maintenant connecté.</p>
    <p>Vous allez être redirigé vers la page d'accueil dans quelques secondes...</p>
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
