<?php
session_start();
include '../includes/db.php';
include __DIR__ . "/../includes/header.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure the input field is correctly named "name"
    $name = isset($_POST['name']) ? trim($_POST['name']) : ''; 
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';

    // Validate that required fields are not empty
    if (empty($name) || empty($email) || empty($password)) {
        echo "<div class='alert alert-danger'>Name, Email, and Password are required.</div>";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $password);

        if ($stmt->execute()) {
            header("Location: manage_users.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error adding user.</div>";
        }
    }
}
?>

<div class="container mt-4">
    <h2>Add New User</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required> 
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control">
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add User</button>
    </form>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
