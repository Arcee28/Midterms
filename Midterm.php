<?php
// Handle form submission (if POST request is made)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data (email and password)
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Placeholder for authentication logic (you'd check these against a database)
    $validEmail = "user@example.com"; // example valid email
    $validPassword = "password123";   // example valid password

    // Simple validation (this would be more complex with a real database)
    if ($email === $validEmail && $password === $validPassword) {
        echo "<div class='alert alert-success'>Login successful!</div>";
    } else {
        echo "<div class='alert alert-danger'>Invalid credentials. Please try again.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h2>Login</h2>
            <form action="login.php" method="POST">
                <!-- Email Input Field -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <!-- Password Input Field -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
