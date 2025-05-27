<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$currentPage = basename($_SERVER['PHP_SELF']); // Get the current page name
?>
<header class="bg-dark py-3">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <a href="../pages/index.php" class="navbar-brand d-flex align-items-center">
                <img src="../activities/vertLogo.PNG" alt="GymTicket Logo" width="50" class="me-2">
                <h2 class="fw-bold text-white m-0">GYMTICKET</h2>
            </a>

            <!-- Toggle Button for Small Screens -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="../pages/index.php" class="nav-link <?php echo ($currentPage == 'index.php') ? 'active text-light' : 'text-warning'; ?>">Home</a>
                    </li>

                    <li class="nav-item">
                        <a href="../pages/location.php" class="nav-link <?php echo ($currentPage == 'location.php') ? 'active text-light' : 'text-warning'; ?>">Locations</a>
                    </li>

                    <?php
                    // Debugging: Check session variables
                    echo '<!-- Debug: ' . print_r($_SESSION, true) . ' -->';

                    // Show Class Booking link only for logged-in users who are NOT admins
                    if ((isset($_SESSION['user_id']) && !isset($_SESSION['admin_email'])) || !isset($_SESSION['user_id'])) : ?>
                        <li class="nav-item">
                            <a href="../pages/class_booking.php" class="nav-link <?php echo ($currentPage == 'class_booking.php') ? 'active text-light' : 'text-warning'; ?>">Class Booking</a>
                        </li>
                    <?php endif; ?>

                    <?php if (!isset($_SESSION['user_id'])) : ?>
                        <li class="nav-item">
                            <a href="../pages/login.php" class="nav-link <?php echo ($currentPage == 'login.php') ? 'active text-light' : 'text-warning'; ?>">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="../pages/register.php" class="nav-link <?php echo ($currentPage == 'register.php') ? 'active text-light' : 'text-warning'; ?>">Register</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a href="../pages/profile.php" class="nav-link <?php echo ($currentPage == 'profile.php') ? 'active text-light' : 'text-warning'; ?>">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="../pages/payment.php" class="nav-link <?php echo ($currentPage == 'payment.php') ? 'active text-light' : 'text-warning'; ?>">Payment</a>
                        </li>

                       <?php
if (!empty($_SESSION['user_role']) && trim($_SESSION['user_role']) === 'admin') : ?>
    <li class="nav-item">
        <a href="../admin/admin_dashboard.php" class="nav-link <?php echo ($currentPage == 'admin_dashboard.php') ? 'active text-light' : 'text-warning'; ?>">Admin Panel</a>
    </li>
<?php endif; ?>



                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-warning" href="#" role="button" data-bs-toggle="dropdown">
                                Account
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item text-dark" href="../pages/profile.php">Profile</a></li>
                                <li><a class="dropdown-item text-danger" href="../pages/logout.php">Logout</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </div>
</header>
