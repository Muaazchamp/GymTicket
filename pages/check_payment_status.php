<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "error";
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT ps.status_name FROM payments p 
        JOIN payment_status ps ON p.status_id = ps.status_id
        WHERE p.user_id = $user_id ORDER BY p.payment_id DESC LIMIT 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo strtolower($row['status_name']); // Convert to lowercase for easy matching
} else {
    echo "no_payment";
}
?>
