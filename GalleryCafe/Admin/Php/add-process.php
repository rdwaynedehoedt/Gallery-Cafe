<?php
include 'connection.php';

$title = $_POST['title'];
$description = $_POST['description'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$status = $_POST['status'];


$target_dir = "http://localhost/gallerycafe/Admin/upload/";
$image = $target_dir . basename($_FILES["image"]["name"]);
move_uploaded_file($_FILES["image"]["tmp_name"], $image);


$sql = "INSERT INTO promotions (title, image, description, start_date, end_date, status) 
        VALUES ('$title', '$image', '$description', '$start_date', '$end_date', '$status')";

if ($conn->query($sql) === TRUE) {
    header("Location:../Pages/pramotion.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>