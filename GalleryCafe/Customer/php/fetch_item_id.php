<?php
include 'db_connec.php'; 
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $productName = $data['productName'];

    $query = "SELECT id FROM items WHERE name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $productName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'item_id' => $item['id']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Item not found.']);
    }

    $stmt->close();
}

$conn->close();
?>
