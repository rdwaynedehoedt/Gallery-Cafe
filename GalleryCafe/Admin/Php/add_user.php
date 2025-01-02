<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $password = $_POST['password']; 

    
    $check_query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "User with this email already exists.";
    } else {
        $sql = "INSERT INTO users (name, address, email, contact, password, user_type_id) VALUES (?, ?, ?, ?, ?, 2)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $address, $email, $contact, $password);

        if ($stmt->execute()) {
            echo "User added successfully.";
        } else {
            echo "Error adding user.";
        }
    }

    $stmt->close();
    $conn->close();
}
?>