<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/main.css">
    <title>Document</title>
</head>
<body>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav>
    <ul>
        <li><a href="/studentPortal/student-portal/pages/home.php">Home</a></li>
        <li><a href="/studentPortal/student-portal/pages/dashboard.php">Dashboard</a></li>
        <?php if (!isset($_SESSION["student_id"])): ?>
            <li><a href="/studentPortal/student-portal/pages/signup.php">Signup</a></li>
            <li><a href="/studentPortal/student-portal/pages/login.php">Login</a></li>
        <?php else: ?>
            <li><a href="/studentPortal/student-portal/pages/logout.php">Logout</a></li>
        <?php endif; ?>
    </ul>
</nav>
</body>
</html>