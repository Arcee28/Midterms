<?php
session_start(); // Start the session at the beginning

// Define valid credentials for demonstration (you may replace this with database checks)
$validEmail = "user@gmail.com";  // Example email
$validPassword = "password123";  // Example password (in real-world, it should be hashed)

// Initialize error messages
$errorMessages = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // If login form is submitted
    if (isset($_POST['submitlogin'])) {
        // Sanitize email input
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        // Validate email and password
        if (empty($email)) {
            $errorMessages[] = "Email is required.";
        }

        if (empty($password)) {
            $errorMessages[] = "Password is required.";
        }

        // If no errors, validate credentials
        if (empty($errorMessages)) {
            if ($email === $validEmail && $password === $validPassword) {
                // If credentials are valid, set session variables
                $_SESSION['logged_in'] = true;
                $_SESSION['email'] = $email;

                // Redirect to the dashboard page
                header("Location: dashboard.php");
                exit(); // Exit to ensure no further code is executed
            } else {
                $errorMessages[] = "Invalid email or password. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <!-- Error messages -->
    <?php if (!empty($errorMessages)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>System Errors:</strong>
            <ul>
                <?php foreach ($errorMessages as $message): ?>
                    <li><?php echo $message; ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Login Form -->
    <div class="login-box" style="max-width: 400px; margin: 0 auto; padding: 30px; border: 1px solid #ddd;">
        <h2 class="text-center">Login</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="submitlogin" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</div>

<!-- Include Bootstrap JS for alert dismiss functionality -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
