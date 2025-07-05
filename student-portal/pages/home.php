<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/home.css">
</head>
<body>
    <?php include("../components/header.php"); ?>
    <div class="main back home-bg">
        <section class="hero-section">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <h1>
                    <span class="portal-highlight">Welcome to the Student Portal</span>
                </h1>
                <p class="portal-intro">
                    <strong>Manage your academic journey at IIMS College.</strong>
                </p>
                <?php if (!isset($_SESSION["student_id"])): ?>
                <span class="portal-cta" onclick="window.location.href='login.php'">
                    Get started by logging in or signing up!
                </span>
                <?php endif; ?>
            </div>
        </section>
        <div class="welcome-section">
            <h2>About the Student Portal</h2>
            <p>
                The Student Portal is your all-in-one platform to manage your academic profile, view and update your information, and stay connected with your course activities. Enjoy a seamless and secure experience designed for students!
            </p>
        </div>
        <section class="about-section">
            <div class="about-content">
                <h2>Why use the Student Portal?</h2>
                <ul>
                    <li>✔️ Manage your academic profile and personal information</li>
                    <li>✔️ View your enrolled courses and details</li>
                    <li>✔️ Edit your profile and keep your data up-to-date</li>
                    <li>✔️ Secure and easy access anytime, anywhere</li>
                </ul>
            </div>
            <div class="about-image">
                <div class="image-overlay"></div>
                <img src="../assets/image.png" alt="IIMS College" />
            </div>
        </section>
    </div>
    <?php include("../components/footer.php"); ?>
</body>
</html>