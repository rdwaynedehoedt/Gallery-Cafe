<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cartCount = 0;
foreach ($_SESSION['cart'] as $item) {
    $cartCount += $item['quantity']; 
}

echo json_encode(['cart_count' => $cartCount]);