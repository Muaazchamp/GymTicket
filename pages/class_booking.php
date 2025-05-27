<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include_once "../includes/header.php";
include_once "../includes/db.php"; 

// Fetch available classes from database
$classes = ["Bodybuilding", "Yoga", "Boxing", "Dance", "HIIT", "Zumba"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Booking</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Book Your Class</h2>
    <form id="classBookingForm" class="card p-4 shadow-lg">
        <div class="mb-3">
            <label for="classSelect" class="form-label">Select Class</label>
            <select class="form-select" id="classSelect" required>
                <option value="">Choose a class</option>
                <?php foreach ($classes as $class): ?>
                    <option value="<?= $class; ?>"><?= $class; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="bookingDate" class="form-label">Select Date</label>
            <input type="date" class="form-control" id="bookingDate" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Book Now</button>
        <div id="bookingMessage" class="mt-3"></div>
    </form>
</div>

<script>
$(document).ready(function(){
    $("#classBookingForm").submit(function(e){
        e.preventDefault();

        let selectedClass = $("#classSelect").val();
        let bookingDate = $("#bookingDate").val();

        if (selectedClass === "" || bookingDate === "") {
            $("#bookingMessage").html('<div class="alert alert-danger">Please fill all fields.</div>');
            return;
        }

        $.ajax({
            url: "process_booking.php",
            type: "POST",
            data: { class: selectedClass, date: bookingDate },
            success: function(response){
                $("#bookingMessage").html('<div class="alert alert-success">' + response + '</div>');
                $("#classBookingForm")[0].reset();
            },
            error: function(){
                $("#bookingMessage").html('<div class="alert alert-danger">Booking failed. Try again.</div>');
            }
        });
    });
});
</script>
</body>
</html>
