
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "sql105."; // Get this from InfinityFree MySQL settings
$username = "if0";
$password = "sbemV";
$database = "if0_38476924_gym";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
