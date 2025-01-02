<?php
session_start();
include '../php/config.php'; 

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to book a table.'); window.location.href = 'login.html';</script>";
    exit();
}

function fetchCapacity($conn) {
    $stmt = $conn->prepare ("SELECT * FROM capacity ORDER BY updated_at DESC LIMIT 1");
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

$capacity = fetchCapacity($conn); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Image/Logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <title>The Gallery Cafe | Table Booking</title>
    <link rel="stylesheet" href="../CSS/Booking.css">
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>

    <div class="booking-container">
        <form class="booking-form" id="bookingForm">
            <button class="back-home-btn" onclick="goBackToHome()">Back to Home</button>
            <h1>Booking</h1>
            
            
            <label for="date">Date *</label>
            <input type="date" id="date" name="date" required>
            
            <label for="time">Time *</label>
            <input type="time" id="time" name="time" value="18:00" required>
            
            <label for="people">People *</label>
            <select id="people" name="people" required>
                <option value="2 persons">2 persons</option>
                <option value="3 persons">3 persons</option>
                <option value="4 persons">4 persons</option>
                <option value="5 persons">5 persons</option>
                <option value="6 persons">6 persons</option>
            </select>

            <label for="first-name">First Name *</label>
            <input type="text" id="first-name" name="first-name" required>

            <label for="last-name">Last Name *</label>
            <input type="text" id="last-name" name="last-name" required>

            <label for="email">Email *</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone *</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="comments">Comments (optional)</label>
            <textarea id="comments" name="comments"></textarea>

            <div class="newsletter">
                <input type="checkbox" id="subscribe" name="subscribe">
                <label for="subscribe">Subscribe me to the newsletter</label>
            </div>

            <button type="submit">Book a table</button>
        </form>

        
        
        
        <div id="thank-you-box" style="display: none;">
            <h2>Thank You!</h2>
            <p>Your table has been successfully booked!</p>
         </div>

        
    <div class="capacity-container">
        <h2>Available Capacities</h2>
        <div class="capacity-box">
            <div class="capacity-item">
                <h3>Parking Spots (Cars)</h3>
                <p><?php echo $capacity['parking_spots']; ?> spots available</p>
            </div>
            <div class="capacity-item">
                <h3>Parking Spots (Motorbikes)</h3>
                <p><?php echo $capacity['motorbike_spots']; ?> spots available</p>
            </div>
            <div class="capacity-item">
                <h3>Two-person Tables</h3>
                <p><?php echo $capacity['table_two']; ?> tables available</p>
            </div>
            <div class="capacity-item">
                <h3>Four-person Tables</h3>
                <p><?php echo $capacity['table_four']; ?> tables available</p>
            </div>
            <div class="capacity-item">
                <h3>Six-person Tables</h3>
                <p><?php echo $capacity['table_six']; ?> tables available</p>
            </div>
        </div>
    </div>


    </div>
   
    
    <script src="../Js/Booking.js"></script>
</body>
</html>