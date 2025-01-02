<?php
session_start();
include 'config.php'; 


if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Please log in to book a table.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $user_id = $_SESSION['user_id'];
    $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
    $time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_STRING);
    $people = filter_input(INPUT_POST, 'people', FILTER_SANITIZE_STRING);
    $first_name = filter_input(INPUT_POST, 'first-name', FILTER_SANITIZE_STRING);
    $last_name = filter_input(INPUT_POST, 'last-name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $comments = filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_STRING);
    $subscribe = isset($_POST['subscribe']) ? 1 : 0;

    
    if (empty($date) || empty($time) || empty($people) || empty($first_name) || empty($last_name) || empty($email) || empty($phone)) {
        echo json_encode(['status' => 'error', 'message' => 'All required fields must be filled in.']);
        exit();
    }

    
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, date, time, people, first_name, last_name, email, phone, comments, subscribe) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('issssssssi', $user_id, $date, $time, $people, $first_name, $last_name, $email, $phone, $comments, $subscribe);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Your table has been successfully booked!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to book the table. Please try again later.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}