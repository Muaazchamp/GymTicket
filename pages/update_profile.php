<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    die("You must be logged in to update your profile.");
}
include '../includes/db.php';

// Fetch user data
$stmt = $conn->prepare("SELECT Name, Email, phone, Address FROM users WHERE UserID = ?");
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found!";
    exit();
}

// Extract country code and phone number
$fullPhone = $user["phone"];
$countryCode = "";
$phoneNumber = $fullPhone;

if (preg_match('/^\+(\d{1,4})\s(.+)$/', $fullPhone, $matches)) {
    $countryCode = $matches[1]; // Extract country code
    $phoneNumber = $matches[2]; // Extract phone number
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .profile-container {
            max-width: 500px;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<?php include __DIR__ . "/../includes/header.php"; ?>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="profile-container">
        <h3 class="text-center mb-4">Update Profile</h3>
        <form id="updateProfileForm" method="POST">
            <div class="mb-3">
                <label class="form-label">Name:</label>
                <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($user["Name"]) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user["Email"]) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone:</label>
                <input type="tel" id="phone" class="form-control" name="phone" value="<?= htmlspecialchars($phoneNumber) ?>" required>
                <input type="hidden" id="country_code" name="country_code" value="<?= htmlspecialchars($countryCode) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Address:</label>
                <input type="text" class="form-control" name="address" value="<?= htmlspecialchars($user["Address"]) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Update Profile</button>
        </form>
        <p id="message" class="mt-3 text-center"></p>
    </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
<script>
$(document).ready(function() {
    var input = document.querySelector("#phone");
    var iti = window.intlTelInput(input, {
        preferredCountries: ["in", "gb", "us"],  // Ensure India is included
        separateDialCode: true,
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
    });

    // Set the country based on stored country code
    var storedCountryCode = "<?= htmlspecialchars($countryCode) ?>";
    if (storedCountryCode) {
        // Try setting the country and fallback to 'in' (India) if it fails
        try {
            iti.setCountry(storedCountryCode);  // Set country using the stored code
        } catch (e) {
            iti.setCountry("in");  // Fallback to India if there is an error
            console.log("Error setting country, fallback to India.");
        }
    }

    $("#updateProfileForm").submit(function(e) {
        e.preventDefault();

        // Get the selected country code
        var countryCode = iti.getSelectedCountryData().dialCode;
        $("#country_code").val(countryCode); // Set the country code hidden field value

        $.ajax({
            type: "POST",
            url: "process_update_profile.php",
            data: $(this).serialize(),
            success: function(response) {
                if (response.trim() === "success") {
                    $("#message").html('<div class="alert alert-success">Profile updated successfully!</div>');
                    setTimeout(() => { location.href = "profile.php"; }, 1500);
                } else {
                    $("#message").html('<div class="alert alert-danger">Error: ' + response + '</div>');
                }
            }
        });
    });
});
</script>

</body>
</html>
