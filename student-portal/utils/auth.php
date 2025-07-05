<?php
function login($email, $password) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        return true;
    }
    return false;
}

function logout() {
    session_start();
    session_unset();
    session_destroy();
}

function isAuthenticated() {
    return isset($_SESSION['user_id']);
}

function getUserById($id) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch();
}

function updateUser($id, $data) {
    global $pdo;

    $stmt = $pdo->prepare("UPDATE users SET full_name = :full_name, email = :email, phone = :phone, course = :course WHERE id = :id");
    $stmt->bindParam(':full_name', $data['full_name']);
    $stmt->bindParam(':email', $data['email']);
    $stmt->bindParam(':phone', $data['phone']);
    $stmt->bindParam(':course', $data['course']);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}
?>