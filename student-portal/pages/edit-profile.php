<?php
session_start();
require_once("../config.php");

if (!isset($_SESSION["student_id"])) {
    header("Location: login.php");
    exit();
}

$message = "";
$user = null;

// Fetch current user data
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $phone_number = $_POST["phone_number"];
    $course = $_POST["course"];
    $username = $_POST["username"];
    $profile_photo = $user["profile_photo"];

    // Handle profile photo upload
    if (isset($_FILES["profile_photo"]) && $_FILES["profile_photo"]["error"] == 0) {
        $target_dir = "../uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES["profile_photo"]["name"]);
        if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
            $profile_photo = $target_file;
        }
    }

    $stmt = $conn->prepare("UPDATE student SET profile_photo=?, full_name=?, email=?, phone_number=?, course=?, username=? WHERE id=?");
    $stmt->bind_param("ssssssi", $profile_photo, $full_name, $email, $phone_number, $course, $username, $_SESSION["student_id"]);
    if ($stmt->execute()) {
        $message = "Profile updated successfully!";
        // Refresh user data
        $user = [
            "profile_photo" => $profile_photo,
            "full_name" => $full_name,
            "email" => $email,
            "phone_number" => $phone_number,
            "course" => $course,
            "username" => $username
        ];
    } else {
        $message = "Error updating profile: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../styles/main.css">
    <style>
        .profile-card {
            background: #fff;
            padding: 32px 24px;
            border-radius: 8px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.08);
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 350px;
            gap: 16px;
        }
        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #007bff;
            background: #eee;
        }
        .profile-info {
            width: 100%;
        }
        .profile-info p {
            margin: 8px 0;
        }
        .edit-btn {
            margin-top: 16px;
            padding: 10px 24px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        .edit-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <?php include("../components/header.php"); ?>
    <div class="main">
        <div class="profile-card">
            <form action="" method="POST" enctype="multipart/form-data" style="width:100%;">
                <h2>Edit Profile</h2>
                <?php if ($message) echo "<p>$message</p>"; ?>
                <img class="profile-pic" src="<?php echo htmlspecialchars($user['profile_photo'] ?: '../assets/default-profile.png'); ?>" alt="Profile Photo">
                <input type="file" name="profile_photo" accept="image/*" class="input-field">
                <input type="text" name="full_name" required placeholder="Full Name" class="input-field" value="<?php echo htmlspecialchars($user['full_name']); ?>">
                <input type="email" name="email" required placeholder="Email" class="input-field" value="<?php echo htmlspecialchars($user['email']); ?>">
                <input type="text" name="phone_number" required placeholder="Phone Number" class="input-field" value="<?php echo htmlspecialchars($user['phone_number']); ?>">
                <input type="text" name="course" required placeholder="Course" class="input-field" value="<?php echo htmlspecialchars($user['course']); ?>">
                <input type="text" name="username" required placeholder="Username" class="input-field" value="<?php echo htmlspecialchars($user['username']); ?>">
                <button type="submit" class="edit-btn">Save Changes</button>