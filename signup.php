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
    <!-- Inclusion du fichier CSS personnalisé -->
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>
<body>
    <div class="container form-container">
        <div class="card">
            <div class="card-header">
                <h2 class="text-signup text-center">Signup</h2>
            </div>
            <div class="card-body">
                <?php
                // Afficher les erreurs s'il y en a
                if (isset($_SESSION['errors'])) {
                    foreach ($_SESSION['errors'] as $error) {
                        echo "<div class='alert alert-danger' role='alert'>" . $error . "</div>";
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
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Signup</button>
                    </div>
                </form>
                <div class="text-center mt-2">
                    <span>Already have an account? <a href="login.php" class="text-login">Login</a></span>
                </div>
                <div class="text-center mt-2">
                    <span>Or go back to <a href="index.php">Home</a></span>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
