<?php
session_start(); // Start session

$servername = "localhost";  // Database server
$username = "root";          // Database username
$password = "root123456";              // Database password
$dbname = "FarmersMarketDatabase"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    // Display welcome message based on user type
    if ($_SESSION['user_type'] === 'buyer') {
        $buyerID = $_SESSION['user_id'];
        // Fetch the buyer's details
        $sql = "SELECT fname, sname FROM buyer WHERE buyerID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $buyerID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo "Welcome, " . $row['fname'] . " " . $row['sname'] . "!";
    } elseif ($_SESSION['user_type'] === 'farmer') {
        $farmerID = $_SESSION['user_id'];
        // Fetch the farmer's details
        $sql = "SELECT fname, sname FROM farmer WHERE farmerID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $farmerID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo "Welcome, " . $row['fname'] . " " . $row['sname'] . "!";
    }
    // Add the logout link
    echo '<br><br><a href="logout.php">Logout</a>';
    exit(); // Stop further execution
}

// Handle login logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pswd = $_POST['pswd'];

    // Check if user is a Buyer
    $sql = "SELECT * FROM buyer WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify password
        if (password_verify($pswd, $row['pswd'])) {
            $_SESSION['user_id'] = $row['buyerID'];
            $_SESSION['user_type'] = 'buyer';
            echo "Welcome, " . $row['fname'] . " " . $row['sname'] . "!"; // Display message
            echo '<br><br><a href="logout.php">Logout</a>'; // Logout link
            exit(); // Stop further execution
        } else {
            echo "Invalid email or password.";
        }
    } else {
        // Check if user is a Farmer
        $sql = "SELECT * FROM farmer WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Verify password
            if (password_verify($pswd, $row['pswd'])) {
                $_SESSION['user_id'] = $row['farmerID'];
                $_SESSION['user_type'] = 'farmer';
                echo "Welcome, " . $row['fname'] . " " . $row['sname'] . "!"; // Display message
                echo '<br><br><a href="logout.php">Logout</a>'; // Logout link
                exit(); // Stop further execution
            } else {
                echo "Invalid email or password.";
            }
        } else {
            echo "Invalid email or password.";
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="pswd">Password:</label>
        <input type="password" id="pswd" name="pswd" required><br><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
