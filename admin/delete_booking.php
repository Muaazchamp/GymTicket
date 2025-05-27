<?php
include '../includes/db.php';

// Check if admin is logged in
session_start();

if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    // Prepare query to delete booking
    $query = $conn->prepare("DELETE FROM class_bookings WHERE booking_id = ?");
    $query->bind_param("i", $booking_id);
    
    if ($query->execute()) {
        // Redirect back to admin booking page after successful deletion
        header("Location: admin_booking.php");
    } else {
        echo "Error deleting booking.";
    }
} else {
    echo "No booking ID provided.";
}
?>
