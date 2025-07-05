<?php
session_start();
require_once("../config.php");

$user = null;
if (isset($_SESSION["student_id"])) {
    $stmt = $conn->prepare("SELECT profile_photo, full_name, email, phone_number, course, username FROM student WHERE id = ?");
    $stmt->bind_param("i", $_SESSION["student_id"]);
    $stmt->execute();
    $stmt->bind_result($profile_photo, $full_name, $email, $phone_number, $course, $username);
    if ($stmt->fetch()) {
        $user = [
            "profile_photo" => $profile_photo,
            "full_name" => $full_name,
            "email" => $email,
            "phone_number" => $phone_number,
            "course" => $course,
            "username" => $username
        ];
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../styles/dashboard.css">
</head>
<body>
    <?php include("../components/header.php"); ?>
    <div class="dashboard-main">
        <?php if (!isset($_SESSION["student_id"])): ?>
            <div class="dashboard-message">
                <h2>To view dashboard you have to log in or register.</h2>
            </div>
        <?php elseif ($user): ?>
            <div class="dashboard-grid">

                <div class="dashboard-card profile-card">
                    <div class="profile-photo-section">
                        <img class="profile-pic-large" src="<?php echo htmlspecialchars($user['profile_photo'] ?: '../assets/default-profile.png'); ?>" alt="Profile Photo">
                    </div>
                    <div class="profile-username">
                        <span class="username-label">Username</span>
                        <span class="username-value"><?php echo htmlspecialchars($user['username']); ?></span>
                    </div>
                    <div class="profile-fullname">
                        <span class="fullname-label">Full Name</span>
                        <span class="fullname-value"><?php echo htmlspecialchars($user['full_name']); ?></span>
                    </div>
                </div>


                <div class="dashboard-card info-card">
                    <h3>Contact Information</h3>
                    <div class="info-row">
                        <span class="label">Email:</span>
                        <span><?php echo htmlspecialchars($user['email']); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="label">Phone:</span>
                        <span><?php echo htmlspecialchars($user['phone_number']); ?></span>
                    </div>
                </div>

                <div class="dashboard-card info-card">
                    <h3>Academic Information</h3>
                    <div class="info-row">
                        <span class="label">Course:</span>
                        <span><?php echo htmlspecialchars($user['course']); ?></span>
                    </div>
                </div>

                <div class="dashboard-card actions-card">
                    <h3>Quick Actions</h3>
                    <div class="actions-list">
                        <a href="edit-profile.php" class="action-btn">Edit Profile</a>
                        <a href="./logout.php" class="action-btn logout">Logout</a>
                    </div>
                    <hr>
                    <div class="dashboard-stats">
                        <div>
                            <span class="stat-label">Last Login:</span>
                            <span class="stat-value">Today</span>
                        </div>
                        <div>
                            <span class="stat-label">Status:</span>
                            <span class="stat-value active">Active</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="dashboard-message">
                <h2>User not found.</h2>
            </div>
        <?php endif; ?>
    </div>


</html></body>

</html></body></body>
</html>