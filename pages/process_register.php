<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if all required fields are set
if (!isset($_POST['email'], $_POST['name'], $_POST['phone'], $_POST['address'], $_POST['password'])) {
    echo 'Missing required fields';
    die();
}

// Retrieve data from POST request
$email = trim($_POST['email']);
$name = trim($_POST['name']);
$phone = trim($_POST['phone']);
$address = trim($_POST['address']);
$password = trim($_POST['password']);

// Generate a 6-digit OTP
$otp = rand(100000, 999999);
$otp_expiry = date('Y-m-d H:i:s', strtotime('+10 minutes')); // OTP expires in 10 minutes

// Database connection (Change these credentials accordingly)
$servername =  "sql105.infinityfree.com"; 
$username =  "if0_38476924"; // Change if hosted online
$db_password =  "sbemVulE3Tg8";  // Change if hosted online
$dbname = "if0_38476924_gym_ticket";

$conn = new mysqli($servername, $username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Hash the password before storing it
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert user into database with OTP and expiry
$sql = "INSERT INTO users (name, email, phone, address, password, otp, otp_expiry, otp_verified) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$otp_verified = 0; // OTP not verified yet
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssi", $name, $email, $phone, $address, $hashedPassword, $otp, $otp_expiry, $otp_verified);

if ($stmt->execute()) {
    echo 'success';  // Registration successful
    // Send OTP email to the user (You need to implement this)
    // For example, use PHPMailer or any other mail service to send OTP.
} else {
    echo 'Error: ' . $conn->error;  // Database insertion error
}

// Close connection
$stmt->close();
$conn->close();
?>
