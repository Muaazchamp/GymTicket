<?php
session_start();
include("../includes/header.php");
include("../includes/db.php");

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php?error=Please login to make a payment");
    exit();
}

// Membership Plans
$plans = [
    ['name' => 'Basic', 'price' => 999, 'description' => 'Access to limited gym facilities'],
    ['name' => 'Essentials', 'price' => 2499, 'description' => 'Access to all gym facilities & group classes'],
    ['name' => 'Elite', 'price' => 2999, 'description' => 'Unlimited access with personal trainer support']
];
?>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<div class="container mt-5">
    <h2 class="text-center fw-bold">Choose Your Membership Plan</h2>
    <div class="row mt-4">
        <?php foreach ($plans as $plan) : ?>
            <div class="col-md-4">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white text-center">
                        <h3 class="fw-bold"><?php echo $plan['name']; ?></h3>
                    </div>
                    <div class="card-body text-center">
                        <h4 class="fw-bold">₹<?php echo $plan['price']; ?></h4>
                        <p><?php echo $plan['description']; ?></p>

                        <!-- Pay Now Button (Redirects to QR Page) -->
                        <a href="show_qr.php?plan=<?php echo urlencode($plan['name']); ?>&amount=<?php echo $plan['price']; ?>" 
                           class="btn btn-success w-100">
                            Pay Now
                        </a>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include '../includes/footer.php'; ?>
