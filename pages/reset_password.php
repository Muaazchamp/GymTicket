<?php
session_start();
include '../includes/header.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "sql105.infinityfree.com"; 
$username = "if0_38476924"; 
$password = "sbemVulE3Tg8"; 
$dbname = "if0_38476924_gym_ticket";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Check if token is provided
if (!isset($_GET['token'])) {
    die("No token provided.");
}

$token = $_GET['token'];

// Check if the token exists in the database
$stmt = $conn->prepare("SELECT email, reset_token_expiry FROM users WHERE reset_token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $email = $user['email'];
    $expiry_time = $user['reset_token_expiry'];

    // Check if the token has expired
    if (strtotime($expiry_time) < time()) {
        die("The reset token has expired. Please request a new password reset.");
    }

    // If form is submitted, update the password
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Validate password
        if (strlen($new_password) < 6) {
            $error = "Password must be at least 6 characters long.";
        } elseif ($new_password !== $confirm_password) {
            $error = "Passwords do not match.";
        } else {
            $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
            $update_stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE email = ?");
            $update_stmt->bind_param("ss", $hashedPassword, $email);
            $update_stmt->execute();

            echo "<div class='container text-center mt-5'>
                    <div class='row justify-content-center'>
                        <div class='col-md-6'>
                            <div class='card shadow-lg border-0 rounded-lg'>
                                <div class='card-body'>
                                    <h2 class='text-success'>Success!</h2>
                                    <p>Your password has been reset successfully.</p>
                                    <a href='login.php' class='btn btn-primary'>Go to Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>";
            include '../includes/footer.php'; // Include footer before exiting
            exit();
        }
    }
} else {
    die("Invalid reset token.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Reset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="row justify-content-center w-100">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg border-0 rounded-lg p-4">
                <h2 class="text-center">Reset Password</h2>
                <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" id="new_password" name="new_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</div>


    <?php include '../includes/footer.php'; ?>
</body>
</html>
