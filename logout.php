<?php
include('header.php');

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

<!-- HTML code for the dashboard follows -->
