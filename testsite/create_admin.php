<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Database connection
$servername = "localhost";
$username = "root";
$password = "root123456"; // Database password (likely empty if using default settings)
$dbname = "FarmersMarketDatabase";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Admin credentials
$email = "admin.test@mail.com";
$plain_password = "4m64NK5J8qf8Tut";
$hashed_password = password_hash($plain_password, PASSWORD_DEFAULT); // Hash the password

// Insert admin
$sql = "INSERT INTO admins (email, password, fname, sname) VALUES (?, ?, 'Admin', 'User')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $hashed_password);

if ($stmt->execute()) {
    echo "Admin account created successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
