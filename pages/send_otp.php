<?php
session_start();
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Validate email
if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    die("Invalid email address.");
}

$email = trim($_POST['email']);
$_SESSION['email'] = $email;  

// Generate OTP
$otp = rand(100000, 999999);

// Store OTP and expiry time in the database
$otp_expiry = date('Y-m-d H:i:s', strtotime('+5 minutes')); // OTP expires in 5 minutes

// Database connection
$servername = "sql105.infinityfree.com"; 
$username = "if0_38476924"; 
$password = "sbemVulE3Tg8"; 
$dbname = "if0_38476924_gym_ticket";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Update OTP and expiry in the database
$stmt = $conn->prepare("UPDATE users SET otp = ?, otp_expiry = ? WHERE email = ?");
$stmt->bind_param("sss", $otp, $otp_expiry, $email);
$stmt->execute();

// Close database connection
$stmt->close();
$conn->close();

// Send OTP via email
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'gymticketsup@gmail.com'; 
    $mail->Password   = 'jleb mlpx dtwh kmku'; 
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('muaazchamp@gmail.com', 'GymTicket');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Your OTP for Registration';
    $mail->Body    = "Your OTP is <b>$otp</b>. It will expire in 5 minutes.";

    if ($mail->send()) {
        echo "success";
    } else {
        echo "Failed to send OTP.";
    }
} catch (Exception $e) {
    echo "Error: {$mail->ErrorInfo}";
}
?>
