<?php
include('header.php');
// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

// Logout logic
if (isset($_POST['logout'])) {
    session_unset(); 
    session_destroy(); 
    header("Location: index.php");
    exit();
}
?>

<!-- HTML code for the dashboard follows -->
