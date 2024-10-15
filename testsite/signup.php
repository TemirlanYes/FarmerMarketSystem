<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Change this if you use a different user
$password = ""; // Your database password
$dbname = "FarmersMarketDatabase"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO buyer (fname, sname, email, phoneNum, pswd) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $fname, $sname, $email, $phoneNum, $hashed_password);

// Collect form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $sname = $_POST['sname'];
    $email = $_POST['email'];
    $phoneNum = $_POST['phoneNum'];

    // Hash the password
    $hashed_password = password_hash($_POST['pswd'], PASSWORD_DEFAULT);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Close connections
$stmt->close();
$conn->close();
?>
