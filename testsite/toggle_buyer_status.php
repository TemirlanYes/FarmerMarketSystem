<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "root123456"; // Add your password
$dbname = "FarmersMarketDatabase";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id']) && isset($_GET['action'])) {
    $buyerID = intval($_GET['id']);
    $action = $_GET['action'];

    // Determine the new status
    if ($action === 'enable') {
        $newStatus = 1; // Enable
    } elseif ($action === 'disable') {
        $newStatus = 0; // Disable
    } else {
        die("Invalid action");
    }

    // Update the buyer's status
    $sql = "UPDATE Buyer SET is_enabled = ? WHERE buyerID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $newStatus, $buyerID);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?message=Buyer+status+updated+successfully");
        exit();
    } else {
        header("Location: admin_dashboard.php?message=Error+updating+buyer+status");
        exit();
    }

    $stmt->close();
} else {
    header("Location: admin_dashboard.php?message=Invalid+request");
    exit();
}

$conn->close();
?>
