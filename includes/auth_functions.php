<?php
// ==========================
// Authentication Functions
// ==========================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "db.php";

// Register User Function
function registerUser($name, $email, $password)
{
    global $pdo;
    
    // Check if email already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute(["email" => $email]);
    if ($stmt->fetch()) {
        return "Email already in use!";
    }
    
    // Hash Password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert User
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    if ($stmt->execute(["name" => $name, "email" => $email, "password" => $hashed_password])) {
        return "Registration successful!";
    } else {
        return "Something went wrong!";
    }
}

// Login User Function
function loginUser($email, $password)
{
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = :email");
    $stmt->execute(["email" => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user["password"])) {
        $_SESSION['id'] = $user['id']; // Store user ID in session

        return "Login successful!";
    } else {
        return "Invalid login credentials.";
    }
}

// Logout User Function
function logoutUser()
{
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

// Check if User is Logged In
function isLoggedIn()
{
    return isset($_SESSION["user_id"]);
}
?>
