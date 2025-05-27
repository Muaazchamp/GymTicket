<?php include __DIR__ . "/../includes/header.php"; ?>

<!-- Include intl-tel-input CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css">

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h2 class="text-center">Register</h2>
                    
                    <!-- Step 1: Registration Form -->
                    <form id="registerForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="2" placeholder="Enter your address" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>

                        <button type="button" class="btn btn-primary w-100" id="sendOTP">Send OTP</button>
                    </form>

                    <!-- Step 2: OTP Verification -->
                    <div id="otpSection" class="mt-4 d-none">
                        <p class="text-center">An OTP has been sent to your email.</p>
                        <input type="text" id="otp" class="form-control" placeholder="Enter OTP" required>
                        <button type="submit" class="btn btn-success w-100 mt-3" id="verifyOTP">Verify & Register</button>
                    </div>

                    <p id="registerMessage" class="mt-3 text-center"></p>
                    <p class="text-center mt-3">
                        Already have an account? <a href="login.php">Login here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?>

<!-- Include intl-tel-input JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize intl-tel-input
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            preferredCountries: ["in", "gb", "us"],
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });

        // Send OTP when clicking "Send OTP"
        $("#sendOTP").click(function() {
            var email = $("#email").val();

            // Validate email format
            if (email === "") {
                alert("Please enter your email.");
                return;
            } else if (!validateEmail(email)) {
                alert("Please enter a valid email.");
                return;
            }

            $.ajax({
                url: "send_otp.php",
                type: "POST",
                data: { email: email },
                success: function(response) {
                    if (response.trim() === "success") {
                        alert("OTP sent to your email.");
                        $("#otpSection").removeClass("d-none"); // Show OTP input
                    } else {
                        alert(response);
                    }
                }
            });
        });

        // Verify OTP when clicking "Verify & Register"
        $("#verifyOTP").click(function() {
            var otp = $("#otp").val();
            var formData = $("#registerForm").serialize() + "&otp=" + otp;

            $.ajax({
                url: "process_register.php",
                type: "POST",
                data: formData,
                success: function(response) {
                    if (response.trim() === "success") {
                        alert("Registration successful!");
                        window.location.href = "login.php";
                    } else {
                        alert(response); // Handle errors or success message here
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error: ", status, error);
                }
            });
        });

        // Helper function to validate email format
        function validateEmail(email) {
            var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }
    });
</script>
