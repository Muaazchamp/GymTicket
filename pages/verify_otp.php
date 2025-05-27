<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if OTP is already verified
if (isset($_SESSION['otp_verified']) && $_SESSION['otp_verified'] === true) {
    echo "OTP already verified. You can proceed.";
    exit();
}

// Get email and OTP from POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_SESSION['email'];  // Assuming the email is stored in the session when OTP is sent
    $otp = trim($_POST['otp']);
    
    // Database connection
    $servername = "sql105.infinityfree.com"; 
    $username = "if0_38476924"; 
    $password = "sbemVulE3Tg8"; 
    $dbname = "if0_38476924_gym_ticket";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Fetch OTP and expiry time from the database
    $stmt = $conn->prepare("SELECT otp, otp_expiry FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($db_otp, $otp_expiry);
    $stmt->fetch();
    
    if ($stmt->num_rows === 1) {
        // Debugging: Check if OTP matches the one from the database
        error_log("Session OTP: " . ($_SESSION['otp'] ?? 'Not Set'));
        error_log("User entered OTP: $otp");
        error_log("Stored OTP from DB: $db_otp");
        error_log("OTP Expiry Time: " . $otp_expiry);
        error_log("Current Time: " . time());
        error_log("Expiry Time: " . strtotime($otp_expiry));

        // Check if OTP is correct and not expired
        if ($otp === $db_otp && strtotime($otp_expiry) > time()) {
            // OTP verified successfully, update database and session
            $update_stmt = $conn->prepare("UPDATE users SET otp_verified = 1 WHERE email = ?");
            $update_stmt->bind_param("s", $email);
            $update_stmt->execute();

            // Clear OTP session
            unset($_SESSION['otp']);
            unset($_SESSION['email']);

            $_SESSION['otp_verified'] = true;  // Mark OTP as verified in session
            echo "OTP verified successfully!";
            // Optionally, redirect user to another page after successful OTP verification
            header('Location: index.php');
        } else {
            echo "Invalid OTP or OTP has expired.";
        }
    } else {
        echo "No OTP found for this email.";
    }

    // Close database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
</head>
<body>
    <h2>Enter OTP to Verify Your Email</h2>
    <form method="POST" action="verify_otp.php">
        <label for="otp">Enter OTP:</label>
        <input type="text" id="otp" name="otp" required>
        <button type="submit">Verify OTP</button>
    </form>
</body>
</html>
