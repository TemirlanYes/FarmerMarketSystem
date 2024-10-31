<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', 'root123456', 'FarmersMarketDatabase');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the SQL statement to fetch admin info
    $sql = "SELECT * FROM admins WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['adminID'];
            $_SESSION['admin_fname'] = $admin['fname'];
            $_SESSION['admin_sname'] = $admin['sname'];
            header("Location: admin_dashboard.php"); // Redirect to admin dashboard
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No admin found with this email.";
    }
}

$conn->close();
?>
