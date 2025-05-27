<?php
// process_forgot_password.php

session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if email is provided
if (isset($_POST['email'])) {
    $email = trim($_POST['email']);

    // Database connection
    $servername = "sql105.infinityfree.com"; 
    $username = "if0_38476924"; 
    $password = "sbemVulE3Tg8"; 
    $dbname = "if0_38476924_gym_ticket";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate a unique reset token
        $reset_token = bin2hex(random_bytes(16)); // Secure random string
        $expiry_time = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token expiry in 1 hour

        // Save the reset token and expiry time in the database
        $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?");
        $stmt->bind_param("sss", $reset_token, $expiry_time, $email);
        $stmt->execute();

        // Send the password reset link to the user
        $reset_link = "https://gymticket.free.nf/reset_password.php?token=" . $reset_token;
        $subject = "Password Reset Request";
        $message = "Click the following link to reset your password: " . $reset_link;
        $headers = "From: muaazchamp@gmail.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "success";
        } else {
            echo "failed";
        }
    } else {
        echo "Email not found.";
    }

    $conn->close();
}
?>
