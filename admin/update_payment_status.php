<?php
session_start();
include '../includes/db.php';

if (!isset($_POST['id']) || !isset($_POST['status'])) {
    echo 'Error: Missing required data.';
    exit;
}

$userId = $_POST['id'];
$status = $_POST['status'];

// Prepare the SQL query
$stmt = $conn->prepare("UPDATE users SET payment_status = ? WHERE UserID = ?");

// Bind parameters
$stmt->bind_param("si", $status, $userId);

// Execute the query and check if it's successful
if ($stmt->execute()) {
    echo 'success'; // Success response
} else {
    // Output any errors for debugging
    echo 'Error updating payment status: ' . $stmt->error;
}

$stmt->close();
?>
