<?php
if (isset($_GET['id']) && isset($_GET['reason'])) {
    $farmerID = intval($_GET['id']);
    $reason = $_GET['reason'];

    // Database connection settings
    $servername = "localhost";
    $username = "root";
    $password = "root123456"; // Your database password
    $dbname = "FarmersMarketDatabase";

    // Create a database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update the farmer's status to 'Rejected'
    $sqlUpdate = "UPDATE farmer SET status = 'Rejected' WHERE farmerID = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("i", $farmerID);

    if ($stmtUpdate->execute()) {
        // Prepare the SQL to insert the rejection reason
        $sqlInsert = "INSERT INTO rejection_reasons (farmerID, reason) VALUES (?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("is", $farmerID, $reason);

        if ($stmtInsert->execute()) {
            // Optionally, you can send an email to the farmer here
            header("Location: admin_dashboard.php?message=Farmer+rejected+successfully");
        } else {
            header("Location: admin_dashboard.php?message=Error+logging+rejection+reason");
        }

        $stmtInsert->close();
    } else {
        header("Location: admin_dashboard.php?message=Error+rejecting+farmer");
    }

    $stmtUpdate->close();
    $conn->close();
} else {
    header("Location: admin_dashboard.php?message=Invalid+request");
}
?>
