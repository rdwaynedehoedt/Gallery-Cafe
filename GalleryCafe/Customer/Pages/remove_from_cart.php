<?php
session_start();

if (isset($_SESSION['cart']) && isset($_POST['item_id'])) {
    $item_id = $_POST['item_id'];
    unset($_SESSION['cart'][$item_id]);
    echo json_encode(['status' => 'success', 'message' => 'Item removed from cart']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Item could not be removed']);
}
?>