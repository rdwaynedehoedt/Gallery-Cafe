<?php
include 'connection.php';

$sql = "SELECT * FROM users WHERE user_type_id = 2";  
$result = $conn->query($sql);

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode($users);

$conn->close();
?>