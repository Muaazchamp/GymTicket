<?php
include '../includes/header.php';
include '../includes/db.php';

// List of available classes
$available_classes = ["Bodybuilding", "Yoga", "Boxing", "Dance", "HIIT", "Zumba"];

// Check if booking ID is provided in URL
if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    // Fetch the booking details
    $query = $conn->prepare("SELECT cb.booking_id, cb.class_name FROM class_bookings cb WHERE cb.booking_id = ?");
    $query->bind_param("i", $booking_id);
    $query->execute();
    $result = $query->get_result();

    // Check if the booking exists
    if ($result->num_rows == 0) {
        echo "<p>Booking not found!</p>";
        exit();
    }

    // Get the current class name
    $row = $result->fetch_assoc();
    $current_class_name = $row['class_name'];

    // Handle the form submission to update the class name
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $new_class_name = $_POST['class_name'];

        // Update the class name in the database
        $update_query = $conn->prepare("UPDATE class_bookings SET class_name = ? WHERE booking_id = ?");
        $update_query->bind_param("si", $new_class_name, $booking_id);

        if ($update_query->execute()) {
            echo "<p>Class name updated successfully!</p>";
            header("Location: admin_booking.php"); // Redirect back to the bookings page
            exit();
        } else {
            echo "<p>Error updating class name. Please try again.</p>";
        }
    }
} else {
    echo "<p>Booking ID not specified!</p>";
    exit();
}
?>

<div class="container mt-5">
    <h2 class="text-center">Edit Class Booking</h2>
    <div class="card shadow-lg border-0 mt-4">
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label for="class_name" class="form-label">Class Name</label>
                    <select name="class_name" class="form-control" required>
                        <option value="">Select Class</option>
                        <?php foreach ($available_classes as $class) : ?>
                            <option value="<?php echo $class; ?>" <?php echo ($class == $current_class_name) ? 'selected' : ''; ?>><?php echo $class; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Class</button>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
