<?php
require_once __DIR__ . "/../includes/db.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    echo "Unauthorized access.";
    exit;
}

$user_id = $_SESSION["user_id"];
$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$countryCode = $_POST["country_code"];
$fullPhone = "+" . $countryCode . " " . $phone; // Store full number with country code
$address = $_POST["address"];

// Update query
$stmt = $conn->prepare("UPDATE users SET Name = ?, Email = ?, phone = ?, Address = ? WHERE UserID = ?");
$stmt->bind_param("ssssi", $name, $email, $fullPhone, $address, $user_id);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "Error updating profile.";
}
?>
