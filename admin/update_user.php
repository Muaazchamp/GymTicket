<?php
session_start();
include '../includes/db.php';

// Ensure the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userID = intval($_POST['UserID']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $payment_status = mysqli_real_escape_string($conn, $_POST['payment_status']);

    // Prepare and execute the update query (no reference to country_code)
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, phone = ?, address = ?, payment_status = ? WHERE UserID = ?");
    $stmt->bind_param("sssssi", $name, $email, $phone, $address, $payment_status, $userID);

    if ($stmt->execute()) {
        // Redirect to manage users page with a success message
        header("Location: manage_users.php?success=User updated successfully.");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
