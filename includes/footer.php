<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymTicket</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Ensure the page takes full height */
        html, body {
            height: 80%;
            margin: 0;
            padding: 0;
        }

        /* Wrapper to handle footer positioning */
        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Full height */
        }

        /* Footer styling */
        footer {
            background-color: #1a1a1a; /* Dark background */
            color: white;
            text-align: center;
            padding: 5px 0;
            margin-top: auto; /* Push footer to the bottom */
        }

        .footer-box img {
            max-width: 100px; /* Adjust logo size */
            height: auto;
        }

        /* Optional: Add some padding to ensure space around footer */
        .footer-box {
            padding: 10px;
        }
    </style>
</head>
<body class="wrapper">
    <!-- Your main content goes here -->

    <!-- Footer Section -->
    <footer>
        <div class="footer-box">
            <img class="logo" src="../activities/vertLogo.PNG" alt="Logo">
            <p>&copy; 2025 GymTicket. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (For AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>
