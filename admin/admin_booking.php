<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php
include '../includes/header.php';
include '../includes/db.php';

// Fetch all class bookings
$query = $conn->prepare("SELECT cb.booking_id, u.name AS user_name, u.email, cb.class_name, cb.booking_date 
                        FROM class_bookings cb 
                        JOIN users u ON cb.user_id = u.Userid 
                        ORDER BY cb.booking_date DESC");
$query->execute();
$result = $query->get_result();
?>

<div class="container mt-5">
    <h2 class="text-center fw-bold">Admin - Class Bookings</h2>

    <!-- Add Booking Button -->
    <div class="mb-3">
        <a href="add_booking.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Booking
        </a>
    </div>

    <div class="card shadow-lg border-0 mt-4">
        <div class="card-body">
            <!-- Table to display bookings -->
            <table class="table">
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>Class Name</th>
                        <th>Booking Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['class_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                            <td>
                                <!-- Edit booking button -->
                                <a href="edit_booking.php?booking_id=<?php echo $row['booking_id']; ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <!-- Option to delete booking -->
                                <a href="delete_booking.php?booking_id=<?php echo $row['booking_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this booking?')">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <?php if ($result->num_rows == 0): ?>
                <p>No class bookings found.</p>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
