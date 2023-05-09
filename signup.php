<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-dYYNR0gKu2qV3qB6HmrEucCmLy6uPX7VUswbIauY7V+eSx5+eK7rh5o5Pwv5n4JD" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h2>Signup</h2>
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
            <button type="submit" class="btn btn-primary">Signup</button>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js" integrity="sha384-6KMjU6RznU6Hovd9XOgV7S0NcUBNUT7LnWE8bNwJ0DN4G0DBke93BdYQ9fZ1/6yo" crossorigin="anonymous"></script>
</body>
</html>
