<?php
session_start(); 

include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password']; 

    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);  

    if ($user && $password === $user['password']) {
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['logged_in'] = true;  

        echo json_encode(["message" => "Login successful"]);
    } else {
        echo json_encode(["message" => "Invalid email or password"]);
    }
}
?>