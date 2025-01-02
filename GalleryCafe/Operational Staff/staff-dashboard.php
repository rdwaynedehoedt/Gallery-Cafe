<?php
session_start();
include '../Customer/php/config.php'; 

function fetchReservations($conn)
{
    $stmt = $conn->prepare("SELECT * FROM bookings");
    $stmt->execute();
    return $stmt->get_result();
}

function fetchPreOrders($conn)
{
    $stmt = $conn->prepare("
        SELECT o.order_id, u.name AS customer_name, o.order_status, 
               i.name AS item_name, oi.price, oi.quantity
        FROM orders o
        JOIN users u ON o.user_id = u.id
        JOIN order_items oi ON o.order_id = oi.order_id
        JOIN items i ON oi.item_id = i.id
    ");
    $stmt->execute();
    return $stmt->get_result();
}

function fetchCapacity($conn)
{
    $stmt = $conn->prepare("SELECT * FROM capacity ORDER BY updated_at DESC LIMIT 1");
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function fetchReports($conn)
{
    $stmt = $conn->prepare("SELECT COUNT(*) AS total_reservations FROM bookings");
    $stmt->execute();
    $total_reservations = $stmt->get_result()->fetch_assoc()['total_reservations'];

    $stmt = $conn->prepare("SELECT COUNT(*) AS total_orders FROM orders");
    $stmt->execute();
    $total_orders = $stmt->get_result()->fetch_assoc()['total_orders'];

    return ['total_reservations' => $total_reservations, 'total_orders' => $total_orders];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_order'])) {
    $order_id = intval($_POST['order_id']);
    $order_status = $_POST['order_status'];

    $stmt = $conn->prepare("UPDATE orders SET order_status = ? WHERE order_id = ?");
    $stmt->bind_param("si", $order_status, $order_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update order status.']);
    }
    $stmt->close();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['capacity'])) {
    $parking_spots = intval($_POST['parking-spots']);
    $motorbike_spots = intval($_POST['motorbike-spots']);
    $table_two = intval($_POST['table-two']);
    $table_four = intval($_POST['table-four']);
    $table_six = intval($_POST['table-six']);

    $stmt = $conn->prepare("INSERT INTO capacity (parking_spots, motorbike_spots, table_two, table_four, table_six) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiii", $parking_spots, $motorbike_spots, $table_two, $table_four, $table_six);
    $stmt->execute();
    $stmt->close();
    echo json_encode(['status' => 'success']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'cancel') {
    $booking_id = intval($_POST['booking_id']);
    $stmt = $conn->prepare("DELETE FROM bookings WHERE booking_id = ?");
    $stmt->bind_param("i", $booking_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to cancel reservation.']);
    }
    $stmt->close();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'view_order') {
    $order_id = intval($_POST['order_id']);
    $stmt = $conn->prepare("
        SELECT o.order_id, u.name AS customer_name, GROUP_CONCAT(CONCAT(i.name, ' (Qty: ', oi.quantity, ')') SEPARATOR ', ') AS items
        FROM orders o
        JOIN users u ON o.user_id = u.id
        JOIN order_items oi ON o.order_id = oi.order_id
        JOIN items i ON oi.item_id = i.id
        WHERE o.order_id = ?
        GROUP BY o.order_id
    ");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'order' => $order]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Order not found.']);
    }
    $stmt->close();
    exit();
}

$reservations = fetchReservations($conn);
$preOrders = fetchPreOrders($conn);
$capacity = fetchCapacity($conn);
$reports = fetchReports($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Customer/Image/Logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="staff-dashboard.css">
    <title>Operational Staff Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container">
        <aside class="sidebar">
            <div class="logo">
                <img src="./Image/Logo.png" alt="Logo">
            </div>
            <div class="head">
                <h2>Operational <span style="color: red;">Dashboard</span></h2>
            </div>
            <ul class="menu">
                <li><a href="#reservations">Reservations</a></li>
                <li><a href="#pre-orders">Pre-Orders</a></li>
                <li><a href="#parking-table">Parking & Table Capacity</a></li>
                <li><a href="#reports">Reports</a></li>
            </ul>

            <p>&copy; 2024 The Gallery Cafe. All rights reserved</p>
        </aside>

       

        <main class="main-content">
            <header class="header">
                <div class="profile">
                    <button onclick="logout()">Logout</button>
                </div>

            </header>

            <section id="reservations" class="content">
                <h1>Reservations Management</h1>
                <table id="reservation-table">
                    <thead>
                        <tr>
                            <th>Reservation ID</th>
                            <th>Customer Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $reservations->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['booking_id']; ?></td>
                                <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                <td><?php echo $row['date']; ?></td>
                                <td><?php echo $row['time']; ?></td>
                                <td><?php echo 'Confirmed'; ?></td>
                                <td><button onclick="cancelReservation(<?php echo $row['booking_id']; ?>)">Cancel</button></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </section>

            <section id="pre-orders" class="content">
                <h1>Pre-Orders Management</h1>
                <table id="preorder-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Item Name</th>
                            <th>Item Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $preOrders->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['order_id']; ?></td>
                                <td><?php echo $row['customer_name']; ?></td>
                                <td><?php echo $row['item_name']; ?></td>
                                <td>Rs <?php echo number_format($row['price'], 2); ?></td>
                                <td><?php echo $row['order_status']; ?></td>
                                <td>
                                    <button onclick="viewOrder(<?php echo $row['order_id']; ?>)">View</button>
                                    <form class="update-status-form" method="POST" style="display:inline;">
                                        <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                        <select name="order_status">
                                            <option value="Pending" <?php if ($row['order_status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                            <option value="Processing" <?php if ($row['order_status'] == 'Processing') echo 'selected'; ?>>Processing</option>
                                            <option value="Confirmed" <?php if ($row['order_status'] == 'Confirmed') echo 'selected'; ?>>Confirmed</option>
                                            <option value="Cancelled" <?php if ($row['order_status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                                        </select>
                                        <button type="submit" name="update_order">Update</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </section>

            <section id="parking-table" class="content">
                <h1>Parking & Table Capacity Management</h1>
                <form id="capacity-form">
                    <label for="parking-spots">Available Parking Spots (Cars):</label>
                    <input type="number" id="parking-spots" value="<?php echo $capacity['parking_spots']; ?>"><br><br>

                    <label for="motorbike-spots">Available Parking Spots (Motorbikes):</label>
                    <input type="number" id="motorbike-spots" value="<?php echo $capacity['motorbike_spots']; ?>"><br><br>

                    <label for="table-two">Two-person Tables:</label>
                    <input type="number" id="table-two" value="<?php echo $capacity['table_two']; ?>"><br><br>

                    <label for="table-four">Four-person Tables:</label>
                    <input type="number" id="table-four" value="<?php echo $capacity['table_four']; ?>"><br><br>

                    <label for="table-six">Six-person Tables:</label>
                    <input type="number" id="table-six" value="<?php echo $capacity['table_six']; ?>"><br><br>

                    <button type="submit">Update Availability</button>
                </form>
            </section>

            <section id="reports" class="content">
                <h1>Reports</h1>
                <div>
                    <h2>Total Reservations: <?php echo $reports['total_reservations']; ?></h2>
                    <h2>Total Orders: <?php echo $reports['total_orders']; ?></h2>
                </div>
                <div class="charts">
                    <div>
                        <h2>Sales Report</h2>
                        <canvas id="sales-chart"></canvas>
                    </div>
                    <div>
                        <h2>Order Report</h2>
                        <canvas id="orders-chart"></canvas>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script src="staff-dashboard.js"></script>
</body>

</html>