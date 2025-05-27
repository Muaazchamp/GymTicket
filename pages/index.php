<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include __DIR__ . "/../includes/header.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home | Gym Website</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    .hero-section {
      position: relative;
      width: 100%;
      height: 100vh;
      overflow: hidden;
    }

    .hero-section video {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: -1;
    }

    .hero-content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      color: white;
      z-index: 2;
      width: 100%;
      padding: 0 20px;
    }

    .hero-content h1 {
      font-size: 3rem;
      font-weight: bold;
    }

    .hero-content p {
      font-size: 1.5rem;
    }

    .hero-content .btn {
      font-size: 1.2rem;
      padding: 10px 20px;
      margin-top: 20px;
      text-transform: uppercase;
    }

    @media (max-width: 767px) {
      .hero-content h1 {
        font-size: 2.5rem;
      }

      .hero-content p {
        font-size: 1.2rem;
      }

      .hero-content .btn {
        font-size: 1rem;
        padding: 8px 16px;
      }
    }

    .cta-section {
      background: rgba(10, 5, 63, 0);
      color: black;
      text-align: center;
      padding: 50px 0;
    }

    .cta-box h2 {
      margin-bottom: 20px;
    }
.hero-video {
  display: none;
}


    .position-relative img {
      object-fit: cover;
      height: 250px;
    }
  </style>
</head>
<body>

<section class="hero-section">
  <video id="hero-video" class="w-100" autoplay muted loop playsinline preload="auto" poster="https://gymticket.free.nf/assets/videos/hero-poster.jpg">
    <source src="https://gymticket.free.nf/assets/videos/hero.mp4" type="video/mp4">
    Your browser does not support the video tag.
  </video>
  <div class="hero-content">
    <h1>Achieve Your Fitness Goals with GymTicket</h1>
    <p>Join the best gym facilities near you and take your fitness to the next level.</p>
  </div>
</section>


<section class="container text-center my-5">
    <h2 class="fw-bold">BENEFITS</h2>
    <div class="row mt-4">
        <div class="col-md-4">
            <i class="bi bi-phone fs-1 text-dark"></i>
            <h4 class="fw-bold mt-3">One Pass to Your Fitness</h4>
            <p>Get fit at any fitness center near you, consult expert nutritionists, and get customized exercise routines from a certified professional.</p>
        </div>
        <div class="col-md-4">
            <i class="bi bi-buildings fs-1 text-success"></i>
            <h4 class="fw-bold mt-3">Freedom of Choice</h4>
            <p>GymTicket is your smart membership to work out anywhere, anytime across Hyderabad.</p>
        </div>
        <div class="col-md-4">
            <i class="bi bi-people fs-1 text-dark"></i>
            <h4 class="fw-bold mt-3">Meet Like-minded Fitness Enthusiasts</h4>
            <p>Join the rapidly growing GymTicket community. Get inspired, attend new workout sessions, and attract others like you.</p>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-4">
            <i class="bi bi-globe fs-1 text-primary"></i>
            <h4 class="fw-bold mt-3">Workout Anywhere</h4>
            <p>Attend your favorite workout sessions at the best gyms and fitness studios near your home, office, and more with your GymTicket.</p>
        </div>
        <div class="col-md-4">
            <i class="bi bi-clock fs-1 text-warning"></i>
            <h4 class="fw-bold mt-3">Workout Anytime</h4>
            <p>Attend any or multiple sessions at any center(s) in a day at your convenience.</p>
        </div>
        <div class="col-md-4">
            <i class="bi bi-activity fs-1 text-primary"></i>
            <h4 class="fw-bold mt-3">Workout Anyhow</h4>
            <p>Yoga, Zumba, Pilates, Swimming, Gym workout, MMA, CrossFit, Spinning - you name it, you have it with your GymTicket.</p>
        </div>
    </div>
</section>

<!-- Featured Workouts -->
<div class="container text-center my-5">
  <h2 class="fw-bold">FEATURED WORKOUTS</h2>
  <div class="row mt-4">
    <div class="col-md-4">
      <div class="position-relative">
        <img src="../activities/BODYBUILDING.jpg" class="img-fluid w-100 rounded" alt="Body Building" loading="lazy">
        <div class="position-absolute top-50 start-50 translate-middle text-white fw-bold fs-4">BODY BUILDING</div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="position-relative">
        <img src="../activities/BOXING.jpeg" class="img-fluid w-100 rounded" alt="Boxing" loading="lazy">
        <div class="position-absolute top-50 start-50 translate-middle text-white fw-bold fs-4">BOXING</div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="position-relative">
        <img src="../activities/DANCE.jpeg" class="img-fluid w-100 rounded" alt="Dance" loading="lazy">
        <div class="position-absolute top-50 start-50 translate-middle text-white fw-bold fs-4">DANCE</div>
      </div>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col-md-4">
      <div class="position-relative">
        <img src="../activities/HIIT.jpg" class="img-fluid w-100 rounded" alt="HIIT" loading="lazy">
        <div class="position-absolute top-50 start-50 translate-middle text-white fw-bold fs-4">HIIT</div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="position-relative">
        <img src="../activities/YOGA.jpeg" class="img-fluid w-100 rounded" alt="Yoga" loading="lazy">
        <div class="position-absolute top-50 start-50 translate-middle text-white fw-bold fs-4">YOGA</div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="position-relative">
        <img src="../activities/ZUMBA.jpg" class="img-fluid w-100 rounded" alt="Zumba" loading="lazy">
        <div class="position-absolute top-50 start-50 translate-middle text-white fw-bold fs-4">ZUMBA</div>
      </div>
    </div>
  </div>
</div>
<!-- Call to Action -->
<div class="cta-section">
        <div class="cta-box">
            <h2>Ready to Transform Your Fitness?</h2>
            <a href="register.php" class="btn btn-outline-success btn-lg">Join Now</a>
            <a href="login.php" class="btn btn-outline-primary btn-lg">Member Login</a>
        </div>
    </div>

<!-- Pricing Plans -->
<div class="container my-5">
    <h2 class="text-center">Membership Plans</h2>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h3>Basic Plan</h3>
                    <p>Access to gym facilities</p>
                    <h4>₹999 / month</h4>
                    <a href="payment.php" class="btn btn-warning w-100">Get Started</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h3>Standard Plan</h3>
                    <p>Includes trainer support</p>
                    <h4>₹2,499 / month</h4>
                    <a href="payment.php" class="btn btn-warning w-100">Get Started</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h3>Premium Plan</h3>
                    <p>Trainer + Nutrition Plan</p>
                    <h4>₹3,999 / month</h4>
                    <a href="payment.php" class="btn btn-warning w-100">Get Started</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include __DIR__ . "/../includes/footer.php"; ?>

<!-- Bootstrap JS (via CDN) -->
</body>
</html>
