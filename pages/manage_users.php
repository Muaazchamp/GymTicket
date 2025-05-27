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

// Fetch all users
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include "../includes/header.php"; ?> <!-- Include common header -->

<div class="container mt-5">
    <h1 class="display-4 text-center">Manage Users</h1>
    <p class="lead text-center">View, edit, and delete users.</p>

    <div class="table-responsive mt-4">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user["name"]) ?></td>
                    <td><?= htmlspecialchars($user["email"]) ?></td>
                    <td><?= htmlspecialchars($user["role"]) ?></td>
                    <td>
                        <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm deleteUser" data-id="<?= $user['id'] ?>">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?> <!-- Include common footer -->
