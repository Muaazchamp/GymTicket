<?php
session_start();
include '../includes/db.php';

// Ensure 'id' is passed in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("User ID is required.");
}

$userID = intval($_GET['id']); // Sanitize input

// Fetch user details
$stmt = $conn->prepare("SELECT UserID, name, email, phone, address, payment_status FROM users WHERE UserID = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("User not found.");
}

include __DIR__ . "/../includes/header.php";
?>

<!-- Include intl-tel-input CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">

<div class="container mt-4">
    <h2>Edit User</h2>
    <form action="update_user.php" method="POST">
        <input type="hidden" name="UserID" value="<?= htmlspecialchars($user['UserID']) ?>">
        
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>" required>
            <input type="hidden" name="country_code" id="country_code">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" id="address" class="form-control"><?= htmlspecialchars($user['address']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="payment_status" class="form-label">Payment Status</label>
            <select name="payment_status" id="payment_status" class="form-control" required>
                <option value="Pending" <?= ($user['payment_status'] === 'Pending') ? 'selected' : '' ?>>Pending</option>
                <option value="Approved" <?= ($user['payment_status'] === 'Approved') ? 'selected' : '' ?>>Approved</option>
                <option value="Rejected" <?= ($user['payment_status'] === 'Rejected') ? 'selected' : '' ?>>Rejected</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update User</button>
        <a href="manage_users.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<!-- Include intl-tel-input JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script>
    var input = document.querySelector("#phone");
    var iti = window.intlTelInput(input, {
        preferredCountries: ["in", "gb", "us"],
        separateDialCode: true,
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
    });

    // Store the selected country code in the hidden input field
    input.addEventListener("countrychange", function() {
        document.querySelector("#country_code").value = iti.getSelectedCountryData().dialCode;
    });

    // Set initial country code value
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector("#country_code").value = iti.getSelectedCountryData().dialCode;
    });
</script>

<?php include __DIR__ . "/../includes/footer.php"; ?>
