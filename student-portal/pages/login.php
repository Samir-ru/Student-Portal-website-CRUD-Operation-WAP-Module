<?php
require_once("../config.php");
session_start();

$message = "";

// If already logged in, redirect to dashboard
if (isset($_SESSION["student_id"])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, password FROM student WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION["student_id"] = $id;
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "Invalid username or password.";
        }
    } else {
        $message = "Invalid username or password.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/main.css">
    <title>Login</title>
</head>
<body>
    <?php include("../components/header.php"); ?>
    <div class="main">
    <form action="" method="POST">
        <div class="container">
            <h1>Login</h1>
            <?php if ($message) echo "<p>$message</p>"; ?>
            <input type="text" id="username" name="username" required placeholder="Enter your username" class="input-field">
            <input type="password" id="password" name="password" required placeholder="Enter your password" class="input-field">
            <button type="submit" class="btn">Login</button>
        </div>
    </form>
    </div>
</body>
</html>