<?php
include '../includes/db.php';
session_start();

$user_id = $_SESSION['user_id'];

// Approve the payment after verification
$update_payment = $conn->prepare("UPDATE users SET payment_status = 'approved' WHERE id = ?");
$update_payment->bind_param("i", $user_id);
$update_payment->execute();

// Redirect to profile
header("Location: profile.php");
exit();
?>
