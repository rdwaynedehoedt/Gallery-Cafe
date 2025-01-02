<?php
include 'config.php';

$sql = "SELECT items.id, items.name, items.description, items.price, items.image, categories.category_name 
        FROM items 
        JOIN categories ON items.category_id = categories.id";

$result = $conn->query($sql);
$items = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['image'] = 'http://localhost/gallerycafe/admin' . $row['image'];
        $items[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($items);

$conn->close();
?>