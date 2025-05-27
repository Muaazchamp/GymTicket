<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';
// Handle payment addition
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $amount = $_POST['amount'];
    $payment_date = $_POST['payment_date'];
    $payment_method = $_POST['payment_method'];

    // Insert payment into database
    $sql = "INSERT INTO payments (user_id, amount, payment_date, payment_method) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idss", $user_id, $amount, $payment_date, $payment_method); // Adjusted types accordingly
    if ($stmt->execute()) {
        echo "Payment added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch users to display in the dropdown for selection
$sql = "SELECT UserID, name FROM users";
$result = $conn->query($sql);
?>

<div class="container mt-4">
    <h2><i class="fas fa-plus"></i> Add Payment</h2>

    <!-- Add Payment Form -->
    <form action="add_payment.php" method="POST">
        <div class="form-group">
            <label for="user_id">User ID</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <option value="<?= $row['UserID'] ?>"><?= $row['name'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" step="0.01" name="amount" id="amount" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="payment_date">Payment Date</label>
            <input type="date" name="payment_date" id="payment_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="payment_method">Payment Method</label>
            <select name="payment_method" id="payment_method" class="form-control" required>
                <option value="Debit Card">Debit Card</option>
                <option value="GooglePay">GooglePay</option>
                <option value="Net Banking">Net Banking</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Add Payment</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
