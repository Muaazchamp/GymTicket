<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../includes/db.php";
require_once "../includes/auth_functions.php";

if (!isLoggedIn() || $_SESSION["user_role"] !== "admin") {
    header("Location: login.php");
    exit;
}

// Fetch all payments
$stmt = $pdo->query("SELECT * FROM payments");
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include __DIR__ . "/../includes/header.php"; ?> <!-- Include common header -->

<div class="container mt-5">
    <h1 class="display-4 text-center">Manage Payments</h1>
    <p class="lead text-center">View and track all transactions.</p>

    <div class="table-responsive mt-4">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>User ID</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $payment): ?>
                <tr>
                    <td><?= htmlspecialchars($payment["user_id"]) ?></td>
                    <td>$<?= number_format($payment["amount"], 2) ?></td>
                    <td><?= htmlspecialchars($payment["payment_method"]) ?></td>
                    <td><?= htmlspecialchars($payment["payment_date"]) ?></td>
                    <td>
                        <button class="btn btn-danger btn-sm deletePayment" data-id="<?= $payment['id'] ?>">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?> <!-- Include common footer -->
