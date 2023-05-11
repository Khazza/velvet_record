<?php
session_start();
include('db.php');

// Génération du jeton CSRF
if (!isset($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

// Gestion erreurs
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];

?>
<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Signup</h2>
        <?php
        // Afficher les erreurs s'il y en a
        if (isset($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $error) {
                echo "<p>" . $error . "</p>";
            }
            unset($_SESSION['errors']);
        }
        ?>
        <form method="POST" action="signup_handler.php">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password:</label>
                <input type="password" class="form-control" name="confirm_password" required>
            </div>
            <input type="hidden" name="csrf_token" value="<?= $_SESSION["csrf_token"] ?>">
            <button type="submit" class="btn btn-primary">Signup</button>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
