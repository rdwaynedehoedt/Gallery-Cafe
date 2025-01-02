<?php
include '../Php/connection.php'; 

$sql = "SELECT * FROM promotions";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Promotions</title>
    <link rel="shortcut icon" href="../Customer/Image/Logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="../Css/pramotion.css">
    
</head>
<body>
    <div class="admin-wrapper">
        <main class="main-content">
            <header class="admin-header">
                <h1>Manage Promotions</h1>
                <button class="add-promotion-btn" id="openAddModal">Add New Promotion</button>
            </header>

            <section class="promotion-table-section">
                <table class="promotion-table">
                    <thead>
                        <tr>
                            <th>Promotion Title</th>
                            <th>Image</th>
                            <th>Description</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['title']; ?></td>
                            <td><img src="<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>" class="table-img"></td>
                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo $row['start_date']; ?></td>
                            <td><?php echo $row['end_date']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <button class="edit-btn" onclick="openEditModal(<?php echo $row['id']; ?>, '<?php echo addslashes($row['title']); ?>', '<?php echo addslashes($row['description']); ?>', '<?php echo $row['start_date']; ?>', '<?php echo $row['end_date']; ?>', '<?php echo $row['status']; ?>')">Edit</button>
                                <a href="../Php/delete.php?id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" id="closeAddModal">&times;</span>
            <h2>Add New Promotion</h2>
            <form id="addPromotionForm" action="../Php/add-process.php" method="post" enctype="multipart/form-data">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
                
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" required>
                
                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>
                
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" required>
                
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" required>

                <label for="edit_status">Status:</label>
    <select id="edit_status" name="status" required>
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
    </select>
                
                <button type="submit">Add Promotion</button>
            </form>
        </div>
    </div>

    
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" id="closeEditModal">&times;</span>
            <h2>Edit Promotion</h2>
            <form id="editPromotionForm" action="../Php/edit-process.php" method="post" enctype="multipart/form-data">
    <input type="hidden" id="edit_id" name="id"> 
    <input type="hidden" id="current_image" name="current_image"> 
    
    <label for="edit_title">Title:</label>
    <input type="text" id="edit_title" name="title" required>
    
    <label for="edit_image">Image:</label>
    <input type="file" id="edit_image" name="image">
    
    <label for="edit_description">Description:</label>
    <textarea id="edit_description" name="description" required></textarea>
    
    <label for="edit_start_date">Start Date:</label>
    <input type="date" id="edit_start_date" name="start_date" required>
    
    <label for="edit_end_date">End Date:</label>
    <input type="date" id="edit_end_date" name="end_date" required>
    
    <label for="edit_status">Status:</label>
    <select id="edit_status" name="status" required>
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
    </select>
    
    <button type="submit">Save Changes</button>
</form>

        </div>
    </div>

    <script>
        
        var addModal = document.getElementById("addModal");
        var editModal = document.getElementById("editModal");

        var openAddModalBtn = document.getElementById("openAddModal");
        var closeAddModalBtn = document.getElementById("closeAddModal");

        var closeEditModalBtn = document.getElementById("closeEditModal");

       
        openAddModalBtn.onclick = function() {
            addModal.style.display = "block";
        }

        closeAddModalBtn.onclick = function() {
            addModal.style.display = "none";
        }

        
        closeEditModalBtn.onclick = function() {
            editModal.style.display = "none";
        }

        
        function openEditModal(id, title, description, startDate, endDate, status) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_title').value = title;
    document.getElementById('edit_description').value = description;
    document.getElementById('edit_start_date').value = startDate;
    document.getElementById('edit_end_date').value = endDate;
    document.getElementById('edit_status').value = status;
    
    
    const imageSrc = document.querySelector(` img[alt='${title}']`).src;
    document.getElementById('current_image').value = imageSrc; 

    editModal.style.display = "block";
}


        
        window.onclick = function(event) {
            if (event.target == addModal) {
                addModal.style.display = "none";
            } else if (event.target == editModal) {
                editModal.style.display = "none";
            }
        }
    </script>
</body>
</html>