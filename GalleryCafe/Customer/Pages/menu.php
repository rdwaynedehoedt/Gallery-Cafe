<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/menu.css">
    <link rel="shortcut icon" href="../Image/Logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gallery Cafe | Menu</title>
</head>
<body>
<?php
    include '../php/header.php'; 
?>

<script>
    
    const isLoggedIn = <?php echo json_encode(isset($_SESSION['user_id'])); ?>;
</script>

<div class="menu">
    <h1>Over Delicious Food</h1>
    <div class="menu-box"></div>

    <div class="pagination">
        <button id="prevPage" class="pagination-btn">
            <i class="fas fa-arrow-left"></i> 
        </button>
        <span id="pageNumber">Page 1</span>
        <button id="nextPage" class="pagination-btn">
            <i class="fas fa-arrow-right"></i> 
        </button>
    </div>
</div>

<?php
    include '../php/footer.php';  
?>

<script src="../Js/menu.js"></script>
</body>
</html>