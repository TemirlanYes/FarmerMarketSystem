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
    $farmerID = intval($_GET['id']);
    $action = $_GET['action'];

    // Determine the new status
    if ($action === 'enable') {
        $newStatus = 1; // Enable
    } elseif ($action === 'disable') {
        $newStatus = 0; // Disable
    } else {
        die("Invalid action");
    }

    // Update the farmer's status
    $sql = "UPDATE Farmer SET is_enabled = ? WHERE farmerID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $newStatus, $farmerID);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?message=Farmer+status+updated+successfully");
        exit();
    } else {
        header("Location: admin_dashboard.php?message=Error+updating+farmer+status");
        exit();
    }

    $stmt->close();
} else {
    header("Location: admin_dashboard.php?message=Invalid+request");
    exit();
}

$conn->close();
?>
