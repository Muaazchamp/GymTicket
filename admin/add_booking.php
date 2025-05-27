<?php
include '../includes/header.php';
include '../includes/db.php';

// List of available classes
$available_classes = ["Bodybuilding", "Yoga", "Boxing", "Dance", "HIIT", "Zumba"];

// Fetch all users to display in the dropdown
$query = $conn->prepare("SELECT Userid, name FROM users");
$query->execute();
$users_result = $query->get_result();

// Handle the form submission to add a new booking
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $class_name = $_POST['class_name'];
    $booking_date = $_POST['booking_date'];

    // Insert the new booking into the database
    $insert_query = $conn->prepare("INSERT INTO class_bookings (user_id, class_name, booking_date) VALUES (?, ?, ?)");
    $insert_query->bind_param("iss", $user_id, $class_name, $booking_date);

    if ($insert_query->execute()) {
        echo "<p>Booking added successfully!</p>";
        header("Location: admin_booking.php"); // Redirect back to the bookings page
        exit();
    } else {
        echo "<p>Error adding booking. Please try again.</p>";
    }
}
?>

<div class="container mt-5">
    <h2 class="text-center">Add Class Booking</h2>
    <div class="card shadow-lg border-0 mt-4">
        <div class="card-body">
            <form method="POST">
                <!-- User Selection -->
                <div class="mb-3">
                    <label for="user_id" class="form-label">User</label>
                    <select name="user_id" class="form-control" required>
                        <option value="">Select User</option>
                        <?php while ($user = $users_result->fetch_assoc()) : ?>
                            <option value="<?php echo $user['Userid']; ?>"><?php echo htmlspecialchars($user['name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Class Selection -->
                <div class="mb-3">
                    <label for="class_name" class="form-label">Class Name</label>
                    <select name="class_name" class="form-control" required>
                        <option value="">Select Class</option>
                        <?php foreach ($available_classes as $class) : ?>
                            <option value="<?php echo $class; ?>"><?php echo $class; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Booking Date -->
                <div class="mb-3">
                    <label for="booking_date" class="form-label">Booking Date</label>
                    <input type="datetime-local" name="booking_date" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Add Booking</button>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
