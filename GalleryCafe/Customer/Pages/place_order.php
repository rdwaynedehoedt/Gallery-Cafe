<?php
session_start();
include '../php/config.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
    echo json_encode(['status' => 'error', 'message' => 'No items in cart']);
    exit();
}

$userId = $_SESSION['user_id'];
$total = 0; 

foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}

$stmt = $conn->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
$stmt->bind_param("id", $userId, $total);
$stmt->execute();
$orderId = $stmt->insert_id;

foreach ($_SESSION['cart'] as $item_id => $item) {
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, item_id, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $orderId, $item['id'], $item['quantity'], $item['price']);
    $stmt->execute();
}

unset($_SESSION['cart']);

echo json_encode(['status' => 'success', 'order_id' => $orderId]);
?>