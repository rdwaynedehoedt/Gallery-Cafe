<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Image/Logo1.png" type="image/x-icon">
    <title>The Gallery Cafe | Promotions</title>
    <link rel="stylesheet" href="../CSS/event.css">
    <style>
        
</head>
<body>
    <section class="promotions-section">
        <h2>Current Promotions</h2>
        <div class="promotions-grid">

            <?php
            include '../php/config.php'; 

            $sql = "SELECT * FROM promotions WHERE status='Active'"; 
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
               
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="promotion-card">';
                    echo '<img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['title']) . '">';
                    echo '<div class="promo-details">';
                    echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
                    echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                    echo '<button class="cta-button" onclick="openModal(\'' . htmlspecialchars($row['title']) . '\', \'' . htmlspecialchars($row['description']) . '\', \'' . htmlspecialchars($row['start_date']) . '\', \'' . htmlspecialchars($row['end_date']) . '\')">View Details</button>';
                    echo '</div></div>';
                }
            } else {
                echo '<p>No current promotions available.</p>'; 
            }

            $conn->close(); 
            ?>

        </div>
    </section>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle"></h2>
            <p id="modalDescription"></p>
            <p><strong>Start Date:</strong> <span id="modalStartDate"></span></p>
            <p><strong>End Date:</strong> <span id="modalEndDate"></span></p>
        </div>
    </div>

    <script>
        function openModal(title, description, startDate, endDate) {
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalDescription').innerText = description;
            document.getElementById('modalStartDate').innerText = startDate;
            document.getElementById('modalEndDate').innerText = endDate;
            document.getElementById('myModal').style.display = "block";
        }

        function closeModal() {
            document.getElementById('myModal').style.display = "none";
        }

        // Close the modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('myModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>