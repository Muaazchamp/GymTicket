<?php
session_start();
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE UserID = ?");
    $stmt->bind_param("i", $id);
    echo $stmt->execute() ? "success" : "error";
}
?>
