<?php
 include("../includes/header.php"); 


// Get Plan & Amount from URL
$plan = isset($_GET['plan']) ? htmlspecialchars($_GET['plan']) : 'Unknown Plan';
$amount = isset($_GET['amount']) ? htmlspecialchars($_GET['amount']) : '0';

// Redirect URLs
$done_url = "profile.php";
$cancel_url = "index.php";
?>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<div class="container text-center mt-5">
    <h2 class="fw-bold">Scan the QR Code to Pay</h2>
    <p class="lead"><?php echo $plan; ?> - ₹<?php echo $amount; ?></p>

    <!-- QR Code Image -->
    <img src="qr-code.jpeg" alt="QR Code" class="img-fluid" style="max-width: 200px;">

    <p class="text-danger fw-bold mt-3">Complete the payment within <span id="timer">2:00</span> minutes.</p>

    <!-- Action Buttons -->
    <div class="mt-4">
        <a href="<?php echo $done_url; ?>" class="btn btn-success btn-lg me-2">Done</a>
        <a href="<?php echo $cancel_url; ?>" class="btn btn-danger btn-lg">Cancel</a>
    </div>
</div>

<!-- Auto Redirect After 2 Minutes -->
<script>
    let timeLeft = 120; // 2 minutes in seconds

    function updateTimer() {
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;
        document.getElementById("timer").textContent = `${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
        timeLeft--;

        if (timeLeft < 0) {
            window.location.href = "<?php echo $cancel_url; ?>"; // Auto-redirect to index.php after 2 min
        } else {
            setTimeout(updateTimer, 1000);
        }
    }

    updateTimer();
</script>

<?php include("../includes/footer.php"); ?>
