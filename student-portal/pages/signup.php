<?php
require_once("../config.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $phone_number = $_POST["phone_number"];
    $course = $_POST["course"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $profile_photo = "";

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

    if ($password !== $confirm_password) {
        $message = "Passwords do not match!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO student (profile_photo, full_name, email, phone_number, course, username, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $profile_photo, $full_name, $email, $phone_number, $course, $username, $hashed_password);

        if ($stmt->execute()) {
            $message = "Signup successful! You can now <a href='login.php'>login</a>.";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/main.css">
    <title>Sign Up</title>
</head>
<body>
    <?php include("../components/header.php"); ?>
    <div class="main">
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="container">
            <h1>Sign Up</h1>
            <?php if ($message) echo "<p>$message</p>"; ?>
            <input type="file" name="profile_photo" accept="image/*" class="input-field">
            <input type="text" name="full_name" required placeholder="Full Name" class="input-field">
            <input type="email" name="email" required placeholder="Email" class="input-field">
            <input type="text" name="phone_number" required placeholder="Phone Number" class="input-field">
            <input type="text" name="course" required placeholder="Course" class="input-field">
            <input type="text" name="username" required placeholder="Username" class="input-field">
            <input type="password" name="password" required placeholder="Password" class="input-field">
            <input type="password" name="confirm_password" required placeholder="Confirm Password" class="input-field">
            <button type="submit" class="btn">Sign Up</button>
        </div>
    </form>
    </div>
</body>
</html>