<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];  
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $user_type_id = 2;  

    
    $checkEmail = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $checkEmail->execute([':email' => $email]);
    if ($checkEmail->rowCount() > 0) {
        echo json_encode(["message" => "Email already exists"]);
        exit();
    }

    $sql = "INSERT INTO users (name, email, password, address, contact, user_type_id) 
            VALUES (:name, :email, :password, :address, :contact, :user_type_id)";
    
    $stmt = $conn->prepare($sql);

    if ($stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':password' => $password,  
        ':address' => $address,
        ':contact' => $contact,
        ':user_type_id' => $user_type_id
    ])) {
        
        echo json_encode(["message" => "Sign up successful"]);
    } else {
        
        echo json_encode(["message" => "Error during sign up"]);
    }
}
?>
