<?php
session_start();
include('db.php');

?>
<!DOCTYPE html>
<html>
<head>
    <title>Signup Success</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container text-center p-5">
        <h2 class="text-primary">Signup Success!</h2>
        <p class="lead">Votre compte a été créé.</p>
        <a href="login.php" class="btn btn-primary">Log in</a>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
