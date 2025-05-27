<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include database connection details
$servername = "sql105.infinityfree.com"; 
$username = "if0_38476924"; 
$password = "sbemVulE3Tg8"; 
$dbname = "if0_38476924_gym_ticket";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if POST request contains email and password
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Fetch user from the database based on email
    $stmt = $conn->prepare("SELECT UserID, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $db_password, $role);
    $stmt->fetch();

    // Check if email exists
    if ($stmt->num_rows === 1) {
        // Verify password
        if (password_verify($password, $db_password)) {
            // Store user details in session and redirect to respective page
            $_SESSION['user_id'] = $user_id;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;

            if ($role === 'admin') {
                echo "admin"; // For admin, redirect to the admin dashboard
            } else {
                echo "user"; // For normal users, redirect to the homepage
            }
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "No user found with this email.";
    }
    $stmt->close();
} else {
    echo "Email and password required.";
}

$conn->close();
?>
