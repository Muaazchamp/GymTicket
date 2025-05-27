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

// Fetch all classes
$stmt = $pdo->query("SELECT * FROM classes");
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include __DIR__ . "/../includes/header.php"; ?> <!-- Include common header -->

<div class="container mt-5">
    <h1 class="display-4 text-center">Manage Classes</h1>
    <p class="lead text-center">Add, edit, and remove gym classes.</p>

    <div class="row mt-4">
        <?php foreach ($classes as $class): ?>
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($class["class_name"]) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($class["description"]) ?></p>
                    <p><strong>Schedule:</strong> <?= htmlspecialchars($class["schedule"]) ?></p>
                    <a href="edit_class.php?id=<?= $class['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <button class="btn btn-danger btn-sm deleteClass" data-id="<?= $class['id'] ?>">Delete</button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?> <!-- Include common footer -->
