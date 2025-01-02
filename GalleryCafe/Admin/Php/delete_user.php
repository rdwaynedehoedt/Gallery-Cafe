<?php

include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        $userId = $_POST['id'];

        
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $userId);

        if ($stmt->execute()) {
            echo "User deleted successfully.";
        } else {
            echo "Error deleting user: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Error: User ID not received.";
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>