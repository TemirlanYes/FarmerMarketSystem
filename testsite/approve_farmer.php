<?php
session_start(); // Start the session

$servername = "localhost";
$username = "root";
$password = "root123456"; // Add your password
$dbname = "FarmersMarketDatabase"; // Database name

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $farmerID = intval($_GET['id']);

    // Update the farmer's status to approved and set is_enabled to 1
    $sql = "UPDATE farmer SET status = 'approved', is_enabled = 1 WHERE farmerID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $farmerID);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?message=Farmer approved successfully");
    } else {
        header("Location: admin_dashboard.php?message=Error approving farmer");
    }

    $stmt->close();
}

$conn->close();
?>
