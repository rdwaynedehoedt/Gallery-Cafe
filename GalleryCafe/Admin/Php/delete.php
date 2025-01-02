<?php
include 'connection.php';

$id = $_GET['id'];
$sql = "DELETE FROM promotions WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: ../Pages/pramotion.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>