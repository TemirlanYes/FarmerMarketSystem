<?php
session_start(); // Start the session

$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "FarmersMarketDatabase"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$buyerCreated = false; // Flag to check if the buyer was created successfully
$farmerCreated = false; // Flag to check if the farmer was created successfully

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['userType'] === 'buyer') {
        // Process buyer registration
        $fname = $_POST['fname'];
        $sname = $_POST['sname'];
        $email = $_POST['email'];
        $phoneNum = $_POST['phoneNum'];
        $pswd = password_hash($_POST['pswd'], PASSWORD_DEFAULT); // Hash the password

        // SQL to insert buyer
        $sql = "INSERT INTO buyer (fname, sname, email, pswd, phoneNum) VALUES ('$fname', '$sname', '$email', '$pswd', '$phoneNum')";

        if ($conn->query($sql) === TRUE) {
            $buyerCreated = true; // Set flag to true if the buyer is created successfully
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif ($_POST['userType'] === 'farmer') {
        // Process farmer registration
        $fname = $_POST['fname'];
        $sname = $_POST['sname'];
        $email = $_POST['email'];
        $phoneNum = $_POST['phoneNum'];
        $pswd = password_hash($_POST['pswd'], PASSWORD_DEFAULT); // Hash the password

        // SQL to insert farmer
        $sql = "INSERT INTO farmer (fname, sname, email, pswd, phoneNum) VALUES ('$fname', '$sname', '$email', '$pswd', '$phoneNum')";

        if ($conn->query($sql) === TRUE) {
            $farmerCreated = true; // Set flag to true if the farmer is created successfully
            $_SESSION['farmerID'] = $conn->insert_id; // Save farmer ID for later use
            header("Location: create_farm.php"); // Redirect to farm creation page
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <h2>Sign Up</h2>

    <?php if ($buyerCreated): ?>
        <h3>Congratulations! You have successfully registered as a Buyer!</h3>
        <p>Thank you for joining us!</p>
    <?php elseif ($farmerCreated): ?>
        <h3>Congratulations! You have successfully registered as a Farmer!</h3>
        <p>Thank you for joining us! Please proceed to create your farm.</p>
    <?php else: ?>
        <form action="signup.php" method="POST">
            <label for="userType">Are you a Farmer or a Buyer?</label><br>
            <input type="radio" id="buyer" name="userType" value="buyer" required>
            <label for="buyer">Buyer</label><br>
            <input type="radio" id="farmer" name="userType" value="farmer">
            <label for="farmer">Farmer</label><br><br>

            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="fname" required><br><br>

            <label for="sname">Surname:</label>
            <input type="text" id="sname" name="sname" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="phoneNum">Phone Number:</label>
            <input type="text" id="phoneNum" name="phoneNum" required><br><br>

            <label for="pswd">Password:</label>
            <input type="password" id="pswd" name="pswd" required><br><br>

            <input type="submit" value="Sign Up">
        </form>
    <?php endif; ?>
</body>
</html>
