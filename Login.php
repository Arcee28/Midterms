<?php
session_start(); // Start the session to use session variables

// Define valid credentials (this could come from a database in a real app)
$validEmail = "user@gmail.com";
$validPassword = "password123"; // In real applications, you should hash the password

$errorMessages = []; // Array to store error messages

// Initialize $submitlogin as false
$submitlogin = false;

// Check if form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Set $submitlogin to true when the form is submitted
    $submitlogin = isset($_POST['submitlogin']) ? true : false;

    // Proceed if the form is submitted
    if ($submitlogin) {
        // Sanitize email input to avoid XSS
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        // Check if email and password fields are empty
        if (empty($email)) {
            $errorMessages[] = "Email is required.";
        }

        if (empty($password)) {
            $errorMessages[] = "Password is required.";
        }

        // If no errors, validate the credentials
        if (empty($errorMessages)) {
            if ($email === $validEmail && $password === $validPassword) {
                // If credentials are valid, start the session and set session variables
                $_SESSION['logged_in'] = true;
                $_SESSION['email'] = $email;

                // Redirect to dashboard.php after successful login
                header("Location: dashboard.php");
                exit(); // Ensure no further code is executed after redirect
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
    <link rel="stylesheet" href="style.css"> <!-- Link to the external style.css -->
</head>
<body>
    <div class="container mt-5">
        <!-- Display error messages if any, placed at the top -->
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

        <!-- Login Box -->
        <div class="login-box">
            <div class="login-heading-container">
                <h2 class="login-heading">Login</h2>
            </div>
            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" name="submitlogin" class="btn btn-primary w-100">Submit</button>
            </form>
        </div>
    </div>

    <!-- Ensure Bootstrap's JS is included for alert dismiss functionality -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery (required for Bootstrap's JS) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> <!-- Bootstrap's JS bundle -->
</body>
</html>
