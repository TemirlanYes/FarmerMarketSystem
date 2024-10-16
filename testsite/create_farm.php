<?php
session_start(); // Start the session

$servername = "localhost";
$username = "root"; // Your MySQL username
$password = "root123456"; // Your MySQL password
$dbname = "FarmersMarketDatabase"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$farmCreated = false; // Flag to check if the farm was created successfully

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $farmLoc = $_POST['farmLoc'];
    $farmSize = $_POST['farmSize'];
    $farmerID = $_SESSION['farmerID']; // Get the farmerID from session
    $farmID = $farmerID * 10 + 1; // Calculate farmID

    // SQL to insert farm
    $sql = "INSERT INTO farm (farmID, farmerID, farmLoc, farmSize) VALUES ('$farmID', '$farmerID', '$farmLoc', '$farmSize')";

    if ($conn->query($sql) === TRUE) {
        $farmCreated = true; // Set flag to true if the farm is created successfully
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Farm</title>
</head>
<body>
    <h2>Create Your Farm</h2>

    <?php if ($farmCreated): ?>
        <h3>Congratulations! Your farm has been created successfully!</h3>
        <p>Thank you for registering.</p>
    <?php else: ?>
        <form action="create_farm.php" method="POST">
            <label for="farmLoc">Farm Location:</label>
            <input type="text" id="farmLoc" name="farmLoc" required><br><br>

            <label for="farmSize">Farm Size:</label>
            <input type="text" id="farmSize" name="farmSize" required><br><br>

            <input type="submit" value="Create Farm">
        </form>
    <?php endif; ?>
</body>
</html>
