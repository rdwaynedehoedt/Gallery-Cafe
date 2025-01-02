<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Image/Logo1.png" type="image/x-icon">
    <title>Gallery Cafe Admin Dashboard</title>
    <link rel="stylesheet" href="../Css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        
        <aside class="sidebar">
            <div class="logo">
                <img src="../Image/Logo.png" alt="">        
            </div>
            <div class="head">
                <h2>Admin <span style="color: red;">Dashboard</span></h2>
            </div>

            <ul class="menu">
                <li><a href="#dashboard">Dashboard</a></li>
                <li><a href="../Pages/user_management.html">Users Management</a></li>
                <li><a href="../Pages/food-beverage.html">Food & Beverages</a></li>
                <li><a href="../Pages/orders.html">Orders Management</a></li>
                <li><a href="../Pages/pramotion.php">Manage Promotions</a></li>
                <li><a href="../Pages/reports.html">Reports</a></li>
            </ul>
        </aside>

        
        <main class="main-content">
            <header class="header">
                <div class="search-bar">
                    <input type="text" placeholder="Search...">
                </div>
                <div class="profile">
                    <button onclick="logout()">Logout</button>
                </div>
            </header>

            <section id="dashboard" class="content active">
                <h1>Dashboard</h1>
                <div class="stats">
                    <div class="card">Total Users: <span id="total-users">
                        <?php
                        include '../Php/connection.php'; 
                        $result = $conn->query("SELECT COUNT(*) as count FROM users");
                        $row = $result->fetch_assoc();
                        echo $row['count'];
                        ?>
                    </span></div>
                    <div class="card">Total Orders: <span id="total-orders">
                        <?php
                        $result = $conn->query("SELECT COUNT(*) as count FROM orders");
                        $row = $result->fetch_assoc();
                        echo $row['count'];
                        ?>
                    </span></div>
                    <div class="card">Total Sales: <span id="total-sales">
                        <?php
                        $result = $conn->query("SELECT SUM(total) as total FROM orders");
                        $row = $result->fetch_assoc();
                        echo "LKR" . number_format($row['total'], 2);
                        ?>
                    </span></div>
                    <div class="card">Total Items: <span id="total-items">
                        <?php
                        $result = $conn->query("SELECT SUM(quantity) as total FROM order_items");
                        $row = $result->fetch_assoc();
                        echo $row['total'] ?: 0; 
                        ?>
                    </span></div>
                </div>
                <canvas id="salesChart"></canvas>
                <canvas id="ordersChart"></canvas>
            </section>
        </main>
    </div>

    <script src="../JS/adminscript.js"></script>
</body>
</html>