<?php include __DIR__ . "/../includes/header.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
.partnered-gyms {
            background: #f8f9fa;
            padding: 50px 0;
        }
        .partnered-gyms h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }
        .partnered-gyms .location-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .partnered-gyms .location-card i {
            font-size: 2rem;
            color: #28a745;
        }
        .gymlink {
    color: white !important; /* Set text color to white */
    text-decoration: none !important; /* Remove underline */
    font-weight: bold; /* Make it stand out */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7); /* Add shadow for better visibility */
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 30px;
    text-align: center;
    width: 100%;
}
         </style>
</head>
<body>


<!-- Gym Section -->
     <div class="container text-center my-5">
        <h2 class="fw-bold pb-3">GYMTICKET is available at your favourite GYMS</h2>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="position-relative">
                    <img src="../gyms/1.jpg" class="img-fluid w-100 rounded" alt="Body Building">
                    <div class="position-absolute top-50 start-50 w-100 translate-middle text-white fw-bold fs-4"><a class="gymlink" href="https://g.co/kgs/vvzsCy1">The Gold's Gym</a></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="position-relative">
                    <img src="../gyms/2.jpg" class="img-fluid w-100 rounded" alt="Boxing">
                    <div class="position-absolute top-50 start-50 w-100 translate-middle text-white fw-bold fs-4"><a class="gymlink" href="https://g.co/kgs/Fhxx31e">GRAVITY FITNESS</a></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="position-relative">
                    <img src="../gyms/12.png" class="img-fluid w-100 rounded" alt="Dance">
                    <div class="position-absolute top-50 start-50 w-100 translate-middle text-white fw-bold fs-4"><a class="gymlink" href="https://g.co/kgs/SLAj2ZW">HIGHLIFE.FIT - HMT MIYAPUR BRANCH</a></div>
                </div> 
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="position-relative">
                    <img src="../gyms/4.jpg"  class="img-fluid w-100 rounded" alt="HIIT">
                    <div class="position-absolute top-50 start-50 w-100 translate-middle text-white fw-bold fs-4"><a class="gymlink" href="https://g.co/kgs/bxqQqHR">The Sky Fitness</a></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="position-relative">
                    <img src="../gyms/5.jpg" class="img-fluid w-100 rounded" alt="Yoga">
                    <div class="position-absolute top-50 start-50 w-100 translate-middle text-white fw-bold fs-4"><a class="gymlink" href="https://g.co/kgs/FPgbx6Z">Crunch Gym - Gyms in Kondapur</a></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="position-relative">
                    <img src="../gyms/6.jpg" class="img-fluid w-100 rounded" alt="Zumba">
                    <div class="position-absolute top-50 start-50 w-100 translate-middle text-white fw-bold fs-4"><a class="gymlink" href="https://g.co/kgs/Y4qCvgB">CORE.FIT GYM - Kondapur Branch -3</a></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="position-relative">
                    <img src="../gyms/7.jpg" class="img-fluid w-100 rounded" alt="Zumba">
                    <div class="position-absolute top-50 start-50 w-100 translate-middle text-white fw-bold fs-4"><a class="gymlink" href="https://g.co/kgs/NAz1w9J">Muscletech Fitness - Madinaguda</a></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
<?php include __DIR__ . "/../includes/footer.php"; ?>

<!-- Bootstrap JS (via CDN) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>