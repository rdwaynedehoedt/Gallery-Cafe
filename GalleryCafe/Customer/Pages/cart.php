<?php
session_start();
include '../php/config.php'; 


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cartItems = $_SESSION['cart'];

$orderStatus = "No Active Order";
$orderId = null;

$userId = $_SESSION['user_id']; 
$stmt = $conn->prepare("SELECT order_id, order_status FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $orderId = $row['order_id'];
    $orderStatus = $row['order_status'];
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link rel="stylesheet" href="../CSS/cart.css">
</head>
<body>
    <div class="cart-container">
        <button class="back-menu-btn" onclick="goBackToMenu()">Back to Menu</button>
        <h2>Your Cart</h2>

        <?php if (empty($cartItems)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <?php foreach ($cartItems as $item_id => $item): ?>
                <div class="cart-item" id="item-<?php echo $item_id; ?>">
                    <img src="<?php echo 'http://localhost/gallerycafe/admin' . $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                    <div class="details">
                        <p><?php echo $item['name']; ?></p>
                        <p>Price: Rs <?php echo $item['price']; ?></p>
                        <input type="number" value="<?php echo $item['quantity']; ?>" min="1" class="quantity" data-id="<?php echo $item_id; ?>" data-price="<?php echo $item['price']; ?>">
                        <button class="remove-btn" onclick="removeItem(<?php echo $item_id; ?>)">Remove</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="cart-total">
            <strong>Total: Rs <span id="total">0</span></strong>
        </div>

        <?php if (isset($_SESSION['user_id'])): ?>
            <button class="checkout-btn" onclick="placeOrder()">Pre-Order</button>
        <?php else: ?>
            <p>Please log in to place an order.</p>
        <?php endif; ?>

        <div class="order-status">
            <h3>Order Status</h3>
            <?php if ($orderId): ?>
                <p>Order ID: <strong>#<?php echo $orderId; ?></strong></p>
                <p>Status: <strong id="status-text"><?php echo $orderStatus; ?></strong></p>
            <?php else: ?>
                <p id="status-text">No Active Orders</p>
            <?php endif; ?>
        </div>
    </div>

    
    <?php
    include '../php/footer.php';  
?>

    <script src="../Js/cart.js"></script>
</body>
</html>