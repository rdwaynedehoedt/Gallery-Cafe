<?php
include '../Php/connection.php';


$sql = "SELECT o.order_id, u.name AS customer_name, o.total, o.order_status 
        FROM orders o 
        JOIN users u ON o.user_id = u.id 
        ORDER BY o.created_at DESC";
$result = $conn->query($sql);

$orders = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        $order_id = $row['order_id'];
        $item_sql = "SELECT oi.quantity, i.name 
                     FROM order_items oi 
                     JOIN items i ON oi.item_id = i.id 
                     WHERE oi.order_id = $order_id";
        $item_result = $conn->query($item_sql);
        
        $items = [];
        if ($item_result->num_rows > 0) {
            while ($item_row = $item_result->fetch_assoc()) {
                $items[] = $item_row;
            }
        }
        
        $row['items'] = $items;
        $orders[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($orders);

$conn->close();
?>