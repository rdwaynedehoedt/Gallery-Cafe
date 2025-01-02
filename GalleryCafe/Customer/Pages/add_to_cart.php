<?php
session_start();


if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


$item_id = $_POST['item_id'];
$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;


if (isset($_SESSION['cart'][$item_id])) {
    $_SESSION['cart'][$item_id]['quantity'] += $quantity; 
} else {
    $connection = new mysqli('127.0.0.1', 'root', '', 'gallery_cafe');
    $stmt = $connection->prepare("SELECT id, name, price, image FROM items WHERE id = ?");
    $stmt->bind_param('i', $item_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();

        $_SESSION['cart'][$item_id] = [
            'id' => $item['id'],
            'name' => $item['name'],
            'price' => $item['price'],
            'image' => $item['image'],
            'quantity' => $quantity
        ];

        $response = [
            'status' => 'success',
            'message' => 'Item added to cart!'
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Item not found.'
        ];
    }
    
    $stmt->close();
    $connection->close();
}

echo json_encode($response);