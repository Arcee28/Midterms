<?php
session_start();

// Block browser back button access to previously cached pages
header("Cache-Control: no-store, no-cache, must-revalidate");  // Prevent caching
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");  // For HTTP/1.0 compatibility
header("Expires: 0");  // For HTTP/1.0 compatibility

// Check if the user is already logged in and redirect them to dashboard if so
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: dashboard.php");
    exit();
}

function getUsers() {
    // This function should return an array of users with email and password.
    return [
        ["email" => "user1@gmail.com", "password" => "user1"],
        ["email" => "user2@gmail.com", "password" => "user2"],
        ["email" => "user3@example.com", "password" => "user3"],
        ["email" => "user4@example.com", "password" => "user4"],
        ["email" => "user5@example.com", "password" => "user5"]
    ];
}

function validateLoginCredentials($email, $password) {
    // Validate the email and password
    $errors = [];

    // Validate email
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid Email format.";
    }

    // Validate password
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    return $errors;
}

function checkLoginCredentials($email, $password, $users) {
    // Check if the provided email and password match any in the users array
    foreach ($users as $user) {
        if ($user['email'] === $email && $user['password'] === $password) {
            return true; // Valid credentials
        }
    }
    return false; // Invalid credentials
}

function displayErrors($errors) {
    // Display the errors in a formatted way
    $output = "<ul>";
    foreach ($errors as $error) {
        $output .= "<li>" . htmlspecialchars($error) . "</li>";
    }
    $output .= "</ul>";
    return $output;
}

// Check if the user is already logged in before showing login form
$errorMessages = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the login form submission
    if (isset($_POST['submitlogin'])) {
        // Get form inputs
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        // Validate the credentials
        $errorMessages = validateLoginCredentials($email, $password);

        // If validation passes, check the credentials against the users list
        if (empty($errorMessages)) {
            $users = getUsers();
            if (checkLoginCredentials($email, $password, $users)) {
                // Store user session and redirect to dashboard
                $_SESSION['logged_in'] = true;
                $_SESSION['email'] = $email;
                header("Location: dashboard.php");
                exit();
            } else {
                $errorMessages[] = "Invalid email or password.";
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
    <!-- Render error messages (if any) -->
    <?php if (!empty($errorMessages)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>System Errors:</strong>
            <?php echo displayErrors($errorMessages); ?>
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
