<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../includes/header.php';

// Include PHPMailer
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = ""; // Message for success or error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Database connection
    $servername = "sql105.infi";
    $username = "if0_3";
    $password = "sbemV";
    $dbname = "if0_38476924";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("<div class='alert alert-danger'>Database connection failed: " . $conn->connect_error . "</div>");
    }

    // Check if email exists
    $stmt = $conn->prepare("SELECT UserID FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        // Generate token & expiry
        $reset_token = bin2hex(random_bytes(16));
        $reset_expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

        // Store token
        $update_stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?");
        $update_stmt->bind_param("sss", $reset_token, $reset_expiry, $email);
        $update_stmt->execute();

        // Password reset link
        $reset_link = "https://gymticket.free.nf/GymTicket/pages/reset_password.php?token=" . $reset_token;

        // Email setup
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'gymticketsup@gmail.com';  // Your Gmail
            $mail->Password = 'jleb mlpx ';     // App password (Not your real Gmail password)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Email details
            $mail->setFrom('gymticketsup@gmail.com', 'GymTicket Support');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = "Password Reset Request";
            $mail->Body = "<p>Click <a href='$reset_link'>here</a> to reset your password. This link will expire in 1 hour.</p>";

            $mail->send();
            $message = "<div class='alert alert-success text-center'>Password reset link has been sent to your email.</div>";
        } catch (Exception $e) {
            $message = "<div class='alert alert-danger text-center'>Failed to send email. Error: " . $mail->ErrorInfo . "</div>";
        }
    } else {
        $message = "<div class='alert alert-danger text-center'>Email not found in the database.</div>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h2 class="text-center">Forgot Password</h2>
                        <?= $message; ?>
                        <form method="POST" action="forgot_password.php">
                            <div class="mb-3">
                                <label for="email" class="form-label">Enter Your Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Send Password Reset Link</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include '../includes/footer.php'; ?>
