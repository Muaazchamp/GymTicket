<?php
session_start();
if (!isset($_SESSION['admin_email'])) {
    

}

include '../includes/header.php'; // Include header
?>


<div class="container mt-5">
    <h2 class="text-center">Admin Dashboard</h2>
    <p class="text-center">Welcome, <?php echo htmlspecialchars($_SESSION['admin_email'] ?? 'Admin'); ?>!</p>

    <!-- Row for managing users and payments -->
    <div class="row mt-4">
        <!-- Manage Users -->
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title">Manage Users</h5>
                    <p class="card-text">Add, edit, or remove users.</p>
                    <a href="manage_users.php" class="btn btn-primary">Go</a>
                </div>
            </div>
        </div>

        <!-- Manage Payments -->
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title">Manage Payments</h5>
                    <p class="card-text">View and track payments.</p>
                    <a href="manage_payments.php" class="btn btn-success">Go</a>
                </div>
            </div>
        </div>

        <!-- Manage Bookings -->
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title">Manage Bookings</h5>
                    <p class="card-text">View and manage class bookings.</p>
                    <a href="admin_booking.php" class="btn btn-warning">Go</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Section -->
    <div class="row mt-4">
        <div class="col-md-4 offset-md-4">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h5 class="card-title">Logout</h5>
                    <p class="card-text">Log out of your admin session.</p>
                    <a href="admin_logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
