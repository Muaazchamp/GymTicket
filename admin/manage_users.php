<?php
session_start();
include '../includes/db.php';
include __DIR__ . "/../includes/header.php";

// Fetch users and their payment status from the database
$result = $conn->query("SELECT u.UserID, u.name, u.email, u.phone, u.payment_status FROM users u");

?>

<div class="container mt-4">
    <h2>Manage Users</h2>
    <a href="add_user.php" class="btn btn-success mb-3">Add User</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>UserID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Payment Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['UserID']) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td>
                            <?php if ($row['payment_status'] == 'pending') { ?>
                                <span class="badge bg-warning">Pending</span>
                            <?php } elseif ($row['payment_status'] == 'approved') { ?>
                                <span class="badge bg-success">Approved</span>
                            <?php } else { ?>
                                <span class="badge bg-danger">Rejected</span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($row['payment_status'] == 'pending') { ?>
                                <button class="btn btn-success btn-sm approve-payment" data-id="<?= htmlspecialchars($row['UserID']) ?>">Approve</button>
                                <button class="btn btn-danger btn-sm reject-payment" data-id="<?= htmlspecialchars($row['UserID']) ?>">Reject</button>
                            <?php } else { ?>
                                <span class="text-muted">No action</span>
                            <?php } ?>
                            <a href="edit_user.php?id=<?= urlencode($row['UserID']) ?>" class="btn btn-warning btn-sm">Edit</a>
                            <button class="btn btn-danger btn-sm delete-user" data-id="<?= htmlspecialchars($row['UserID']) ?>">Delete</button>
                        </td>
                    </tr>
                <?php }
            } else {
                echo "<tr><td colspan='6'>No users found</td></tr>";
            } ?>
        </tbody>
    </table>
</div>

<script>
    document.querySelectorAll('.delete-user').forEach(button => {
        button.addEventListener('click', function () {
            let userId = this.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this user?')) {
                fetch('delete_user.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'id=' + userId
                }).then(response => response.text()).then(data => {
                    if (data.trim() === 'success') {
                        location.reload();
                    } else {
                        alert('Failed to delete user.');
                    }
                });
            }
        });
    });

    // Approve payment
    document.querySelectorAll('.approve-payment').forEach(button => {
        button.addEventListener('click', function () {
            let userId = this.getAttribute('data-id');
            if (confirm('Are you sure you want to approve this payment?')) {
                fetch('update_payment_status.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'id=' + userId + '&status=approved'
                }).then(response => response.text()).then(data => {
                    if (data.trim() === 'success') {
                        location.reload();
                    } else {
                        alert('Failed to approve payment.');
                    }
                });
            }
        });
    });

    // Reject payment
    document.querySelectorAll('.reject-payment').forEach(button => {
        button.addEventListener('click', function () {
            let userId = this.getAttribute('data-id');
            if (confirm('Are you sure you want to reject this payment?')) {
                fetch('update_payment_status.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'id=' + userId + '&status=rejected'
                }).then(response => response.text()).then(data => {
                    if (data.trim() === 'success') {
                        location.reload();
                    } else {
                        alert('Failed to reject payment.');
                    }
                });
            }
        });
    });
</script>

<?php include __DIR__ . "/../includes/footer.php"; ?>
