<?php
session_start();
include '../Customer/php/config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (empty($email) || empty($password)) {
        echo "<script>alert('Please enter both email and password'); window.location.href='staffLogin.html';</script>";
        exit();
    }

    $stmt = $conn->prepare("SELECT id, name, password, user_type_id FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $name, $db_password, $user_type_id);
        $stmt->fetch();
        
        if ($password === $db_password) {
            if ($user_type_id == 3) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['name'] = $name;
                $_SESSION['user_type_id'] = $user_type_id;
                
                header("Location: staff-dashboard.php");
                exit();
            } else {
                echo "<script>alert('Access denied. You are not a staff member.'); window.location.href='staffLogin.html';</script>";
            }
        } else {
            echo "<script>alert('Invalid password. Please try again.'); window.location.href='staffLogin.html';</script>";
        }
    } else {
        echo "<script>alert('No account found with this email.'); window.location.href='staffLogin.html';</script>";
    }

    $stmt->close();
}
?>