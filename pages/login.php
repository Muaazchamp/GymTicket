<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . "/../includes/header.php"; 
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h2 class="text-center">Login</h2>
                    <form id="loginForm">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                    <!-- Error Message -->
                    <p id="errorMessage" class="mt-3 text-center text-danger"></p>
                    <p class="text-center mt-3">
    <a href="forgot_password.php">Forgot your password?</a></p>
                    <p class="text-center mt-3">Don't have an account? <a href="register.php">Register here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?> 

<script>
$(document).ready(function() {
    // Login Form Submit
    $("#loginForm").submit(function(e) {
        e.preventDefault(); // Prevent form submission

        const email = $("#email").val().trim();
        const password = $("#password").val().trim();

        if (email === "" || password === "") {
            $("#errorMessage").html('<div class="alert alert-danger">Please enter both email and password.</div>');
            return;
        }

        // Proceed with login
        $.ajax({
            type: "POST",
            url: "process_login.php", // Proceed with login
            data: { email: email, password: password },
            success: function(response) {
                console.log("Server Response: [" + response.trim() + "]");

                if (response.trim() === "admin") {
                    window.location.href = "/GymTicket/admin/admin_dashboard.php"; // Redirect admin
                } else if (response.trim() === "user") {
                    window.location.href = "/GymTicket/pages/index.php"; // Redirect normal user
                } else {
                    $("#errorMessage").html('<div class="alert alert-danger">' + response + '</div>');
                }
            }
        });
    });
});
</script>
