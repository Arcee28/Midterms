<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

// Logout logic
if (isset($_POST['logout'])) {
    // Destroy the session and redirect to the login page
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .welcome-message {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container d-flex justify-content-between">
        <h3 class="welcome-message mb-0">Welcome, <?php echo $_SESSION['email']; ?></h3>
        
        <!-- Logout Form -->
        <form action="dashboard.php" method="POST">
            <button type="submit" name="logout" class="btn btn-danger">Logout</button>
        </form>
    </div>
</nav>

<div class="container mt-5">
    <div class="row">
        <!-- Add Subject Card -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Add a Subject</h5>
                </div>
                <div class="card-body">
                    <p>This section allows you to add a new subject in the system. Click the button below to proceed with the adding process.</p>
                    <form action="add_subject.php" method="POST">
                        <button type="submit" class="btn btn-primary w-100">Add Subject</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Student Card -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Add a Student</h5>
                </div>
                <div class="card-body">
                    <p>This section allows you to register a new student in the system. Click the button below to proceed with the registration process.</p>
                    <!-- Link to register.php for adding a student -->
                    <a href="student/register.php" class="btn btn-primary w-100">Add Student</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
