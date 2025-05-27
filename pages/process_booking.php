<?php
session_start();
include_once "../includes/db.php";

if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized access.";
    exit;
}

$user_id = $_SESSION['user_id'];
$class = $_POST['class'];
$date = $_POST['date'];

// Insert booking into the database
$query = $conn->prepare("INSERT INTO class_bookings (user_id, class_name, booking_date) VALUES (?, ?, ?)");
$query->bind_param("iss", $user_id, $class, $date);

if ($query->execute()) {
    echo "Your class has been booked successfully!";
} else {
    echo "Error booking the class.";
}
?>
