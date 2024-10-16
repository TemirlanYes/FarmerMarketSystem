<?php
session_start(); // Start the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Optionally set a logout message
session_start();
$_SESSION['message'] = "You have been logged out successfully.";

header("Location: login.php"); // Redirect to the login page
exit(); // Stop further script execution
?>
