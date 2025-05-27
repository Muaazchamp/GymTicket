<?php
session_start();
include '../includes/db.php'; // Ensure this path is correct
include '../includes/header.php';

// Check if 'id' is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Payment ID is missing.");
}

$id = $_GET['id'];

// Fetch existing payment details
$stmt = $conn->prepare("SELECT amount, payment_method FROM payments WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Check if payment exists
if ($result->num_rows > 0) {
    $payment = $result->fetch_assoc();
} else {
    die("Error: Payment record not found.");
}


$row = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];

    // ✅ FIXED: Correct column names (id, amount, payment_method)
    $stmt = $conn->prepare("UPDATE payments SET amount=?, payment_method=? WHERE id=?");
    $stmt->bind_param("dsi", $amount, $payment_method, $id);

    if ($stmt->execute()) {
        header("Location: manage_payments.php");
        exit;
    } else {
        echo "Error updating payment.";
    }
}
?>

<div class="container mt-4">
    <h2>Edit Payment</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Amount (₹)</label>
            <input type="number" name="amount" class="form-control" 
       value="<?= isset($payment['amount']) ? htmlspecialchars($payment['amount']) : '' ?>" required>

        </div>
        <div class="mb-3">
        <select name="payment_method" class="form-control" required>
    <option value="Debit Card" <?= (isset($payment['payment_method']) && $payment['payment_method'] == 'Debit Card') ? 'selected' : '' ?>>Debit Card</option>
    <option value="GooglePay" <?= (isset($payment['payment_method']) && $payment['payment_method'] == 'GooglePay') ? 'selected' : '' ?>>GooglePay</option>
    <option value="Bank Transfer" <?= (isset($payment['payment_method']) && $payment['payment_method'] == 'Net Banking') ? 'selected' : '' ?>>Net Banking</option>
</select>

        </div>
        <button type="submit" class="btn btn-success">Update Payment</button>
    </form>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?>

