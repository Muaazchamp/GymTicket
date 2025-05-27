<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

// Fetch all payments
$sql = "SELECT p.id AS PaymentID, p.amount AS Amount, p.payment_date AS PaymentDate, 
               p.payment_method AS PaymentMethod, u.name AS Username, u.email AS Email 
        FROM payments p 
        JOIN users u ON p.user_id = u.UserID 
        ORDER BY p.payment_date DESC";
$result = $conn->query($sql);

// Fetch unique payment methods for filter
$methods = $conn->query("SELECT DISTINCT payment_method FROM payments");
?>

<div class="container mt-4">
    <h2><i class="fas fa-file-invoice-dollar"></i> Manage Payments</h2>

    <!-- Add Payment Button -->
    <div class="mb-3">
        <a href="add_payment.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Payment</a>
    </div>

    <!-- Search & Filter -->
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" id="search" class="form-control" placeholder="Search by username">
        </div>
        <div class="col-md-3">
            <select id="filterMethod" class="form-control">
                <option value="">Filter by Payment Method</option>
                <?php while ($method = $methods->fetch_assoc()) { ?>
                    <option value="<?= $method['payment_method'] ?>"><?= $method['payment_method'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-3">
            <input type="date" id="filterDate" class="form-control">
        </div>
        <div class="col-md-2">
            <button class="btn btn-secondary" id="resetFilters"><i class="fas fa-sync"></i> Reset</button>
        </div>
    </div>

    <!-- Bootstrap Cards for Summary -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-success text-white text-center p-3">
                <h5>Total Payments</h5>
                <h3 id="totalPayments">₹</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white text-center p-3">
                <h5>Transactions</h5>
                <h3 id="totalTransactions">0</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-dark text-center p-3">
                <h5>Top Payment Method</h5>
                <h3 id="topMethod">-</h3>
            </div>
        </div>
    </div>

    <!-- Table -->
    <table class="table table-bordered" id="paymentTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Amount</th>
                <th>Payment Date</th>
                <th>Method</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['PaymentID'] ?></td>
                    <td><?= $row['Username'] ?></td>
                    <td class="amount">₹<?= number_format($row['Amount'], 2) ?></td>
                    <td class="date"><?= $row['PaymentDate'] ?></td>
                    <td class="method"><?= $row['PaymentMethod'] ?></td>
                    <td>
                        <a href="edit_payment.php?id=<?= $row['PaymentID'] ?>" 
                           class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <button class="btn btn-danger btn-sm delete-payment" 
                                data-id="<?= $row['PaymentID'] ?>">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Chart -->
    <canvas id="paymentChart"></canvas>

</div>

<script>
    document.querySelectorAll('.delete-payment').forEach(button => {
        button.addEventListener('click', function () {
            let paymentId = this.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this payment?')) {
                fetch('delete_payment.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'id=' + paymentId
                }).then(response => response.text()).then(data => {
                    if (data === 'success') {
                        location.reload();
                    } else {
                        alert('Failed to delete payment.');
                    }
                });
            }
        });
    });

    // Search Functionality
    document.getElementById('search').addEventListener('keyup', function () {
        let value = this.value.toLowerCase();
        document.querySelectorAll('#paymentTable tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(value) ? '' : 'none';
        });
    });

    // Filter Functionality
    document.getElementById('filterMethod').addEventListener('change', function () {
        let value = this.value;
        document.querySelectorAll('#paymentTable tbody tr').forEach(row => {
            row.style.display = value === '' || row.querySelector('.method').textContent === value ? '' : 'none';
        });
    });

    document.getElementById('filterDate').addEventListener('change', function () {
        let value = this.value;
        document.querySelectorAll('#paymentTable tbody tr').forEach(row => {
            row.style.display = row.querySelector('.date').textContent.startsWith(value) ? '' : 'none';
        });
    });

    document.getElementById('resetFilters').addEventListener('click', function () {
        document.getElementById('search').value = '';
        document.getElementById('filterMethod').value = '';
        document.getElementById('filterDate').value = '';
        document.querySelectorAll('#paymentTable tbody tr').forEach(row => row.style.display = '');
    });

    // Payment Reports & Charts
    let amounts = Array.from(document.querySelectorAll('.amount')).map(el => parseFloat(el.textContent.replace('₹', '')));
    let methods = Array.from(document.querySelectorAll('.method')).map(el => el.textContent);
    
    let totalPayments = amounts.reduce((a, b) => a + b, 0);
    let totalTransactions = amounts.length;
    let methodCount = methods.reduce((acc, method) => (acc[method] = (acc[method] || 0) + 1, acc), {});
    let topMethod = Object.keys(methodCount).reduce((a, b) => methodCount[a] > methodCount[b] ? a : b, '');

    document.getElementById('totalPayments').textContent = '₹' + totalPayments.toFixed(2);
    document.getElementById('totalTransactions').textContent = totalTransactions;
    document.getElementById('topMethod').textContent = topMethod || '-';

    // Generate Chart
    let ctx = document.getElementById('paymentChart').getContext('2d');
    let chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Object.keys(methodCount),
            datasets: [{
                label: 'Payments by Method',
                data: Object.values(methodCount),
                backgroundColor: ['#4CAF50', '#FF9800', '#2196F3'],
                borderWidth: 1
            }]
        }
    });
</script>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php include __DIR__ . "/../includes/footer.php"; ?>
