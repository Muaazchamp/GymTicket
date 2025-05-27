<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../includes/header.php';
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user profile data
$query = $conn->prepare("SELECT name, email, phone, address, payment_status FROM users WHERE Userid = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

// Extract country code and phone number
$phone = $user['phone'];
$formattedPhone = $phone;

// Ensure phone number is formatted correctly
if (!preg_match('/^\+/', $phone)) {
    $formattedPhone = "+XX " . $phone; // Default placeholder if no country code is found
}

?>

<div class="container mt-5">
    <h2 class="text-center fw-bold">My Profile</h2>
    <div class="card shadow-lg border-0 mt-4">
        <div class="card-body">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($formattedPhone); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>

            <?php if ($user['payment_status'] === 'approved') : ?>
                <hr>
                <h4 class="mt-3">Your Training Program</h4>
                <a href="../pages/The_Ultimate_Push_Pull_Legs_System_5X.pdf" class="btn btn-primary" download>Download PDF</a>
                <p class="text-success fw-bold mt-3">Your payment is approved. Enjoy your training program!</p>
            <?php endif; ?>

            <a href="update_profile.php" class="btn btn-primary mt-3">Update Profile</a>
            <hr>

            <h4 class="mt-3">My Bookings</h4>
            <?php if ($result->num_rows > 0): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Class Name</th>
                            <th>Booking Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($booking = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($booking['class_name']); ?></td>
                                <td><?php echo htmlspecialchars($booking['booking_date']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>You have not booked any classes yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    <a href="logout.php" class="btn btn-danger w-100">Logout</a>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<?php include '../includes/footer.php'; ?>
