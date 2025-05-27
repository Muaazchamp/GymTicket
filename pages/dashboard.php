<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect guests
    exit();
}
?>
<?php

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../includes/db.php";
require_once "../includes/auth_functions.php";

// Redirect if not logged in
if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}
?>

<?php include __DIR__ . "/../includes/header.php"; ?> <!-- Include common header -->


</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="display-4">Welcome to Your Dashboard</h1>
            <p class="lead">Manage your profile, book classes, and track your payments.</p>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="card-title">Profile</h5>
                    <p class="card-text">View and update your profile information.</p>
                    <a href="profile.php" class="btn btn-primary">Go to Profile</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="card-title">Logout</h5>
                    <p class="card-text">Log out of your account safely.</p>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?> <!-- Include common footer -->
