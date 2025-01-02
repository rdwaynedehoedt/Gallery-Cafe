<?php
include 'connection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $userId = $_POST['id']; 
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    
    if (empty($userId) || empty($name) || empty($address) || empty($email) || empty($contact)) {
        echo "Please fill in all fields.";
        exit();
    }


    $stmt = $conn->prepare("UPDATE users SET name = ?, address = ?, email = ?, contact = ? WHERE id = ?");
    $stmt->bind_param('ssssi', $name, $address, $email, $contact, $userId);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "User updated successfully.";
        } else {
            echo "No changes made.";
        }
    } else {
        echo "Error updating user: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>