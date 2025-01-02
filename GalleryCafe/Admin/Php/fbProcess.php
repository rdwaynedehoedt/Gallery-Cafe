<?php
include 'connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    if (isset($_GET['action']) && $_GET['action'] === 'fetch_items') {
        $sql = "SELECT items.*, categories.category_name FROM items JOIN categories ON items.category_id = categories.id";
        $result = $conn->query($sql);
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        echo json_encode($items);
    } 
    
    elseif (isset($_GET['action']) && $_GET['action'] === 'get_categories') {
        $sql = "SELECT * FROM categories";
        $result = $conn->query($sql);
        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
        echo json_encode($categories);
    } 
    
    elseif (isset($_GET['action']) && $_GET['action'] === 'get_item' && isset($_GET['id'])) {
        $id = intval($_GET['id']);  
        $sql = "SELECT * FROM items WHERE id = $id";
        $result = $conn->query($sql);
        if ($result) {
            $item = $result->fetch_assoc();
            echo json_encode($item);
        } else {
            echo json_encode(['error' => "Item not found"]);
        }
    } 
    
    elseif (isset($_GET['action']) && $_GET['action'] === 'delete_category' && isset($_GET['id'])) {
        $id = intval($_GET['id']);  
        $sql = "DELETE FROM categories WHERE id = $id";
        if ($conn->query($sql)) {
            echo "Category deleted successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    } 
    
    elseif (isset($_GET['action']) && $_GET['action'] === 'delete_item' && isset($_GET['id'])) {
        $id = intval($_GET['id']);  
        $sql = "DELETE FROM items WHERE id = $id";
        if ($conn->query($sql)) {
            echo "Item deleted successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['action']) && $_POST['action'] === 'add_item') {
        $name = $conn->real_escape_string($_POST['name']);
        $category_id = intval($_POST['category']);
        $description = $conn->real_escape_string($_POST['description']);
        $price = floatval($_POST['price']);
        $image = '';

        
        if (isset($_FILES['image'])) {
            $targetDir = "../upload/";  
            $targetFile = $targetDir . basename($_FILES["image"]["name"]);
            
            
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);  
            }
        
            
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $image = $targetFile;
            } else {
                echo "Error uploading the file";
            }
        }

        $sql = "INSERT INTO items (name, category_id, description, price, image) 
                VALUES ('$name', '$category_id', '$description', '$price', '$image')";
        if ($conn->query($sql)) {
            echo "Item added successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    } 
    
    elseif (isset($_POST['action']) && $_POST['action'] === 'edit_item' && isset($_POST['id'])) {
    $id = intval($_POST['id']);  
    $name = $conn->real_escape_string($_POST['name']);
    $category_id = intval($_POST['category']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = floatval($_POST['price']);
    
    
    $image = '';

    if (isset($_FILES['image'])) {
        $targetDir = "../upload/";  
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        
        
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);  
        }
    
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image = $targetFile;
        } else {
            echo "Error uploading the file";
        }
    }

    
    if ($image != '') {
        
        $sql = "UPDATE items 
                SET name = '$name', category_id = '$category_id', description = '$description', price = '$price', image = '$image' 
                WHERE id = $id";
    } else {
        
        $sql = "UPDATE items 
                SET name = '$name', category_id = '$category_id', description = '$description', price = '$price'
                WHERE id = $id";
    }

    if ($conn->query($sql)) {
        echo "Item updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

        elseif (isset($_POST['action']) && $_POST['action'] === 'add_category') {
        $category_name = $conn->real_escape_string($_POST['category_name']);
        $sql = "INSERT INTO categories (category_name) VALUES ('$category_name')";
        if ($conn->query($sql)) {
            echo "Category added successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

$conn->close();
?>