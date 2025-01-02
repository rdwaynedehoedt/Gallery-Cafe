<?php
session_start();
include '../php/config.php'; 

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

$query = $conn->prepare("SELECT name, address, email, contact FROM users WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['fullName'];
    $address = $_POST['Address'];
    $email = $_POST['email'];
    $contact = $_POST['phone_number'];

    $update_query = $conn->prepare("UPDATE users SET name = ?, address = ?, email = ?, contact = ? WHERE id = ?");
    $update_query->bind_param("ssssi", $name, $address, $email, $contact, $user_id);

    if ($update_query->execute()) {
        $_SESSION['update_success'] = "Profile updated successfully.";
        header("Location: user_profile.php");
        exit;
    } else {
        echo "Error updating record: " . $update_query->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../CSS/Userprofile.css">
</head>
<body>
    <div class="profile-container">
        <div class="profile-sidebar">
            <img src="../Image/Profile pic.png" alt="Profile Image" class="profile-image">
            
        </div>
        <div class="profile-main">
            <div class="tabs">
             <h2>User Info</h2>
            </div>
            <form id="profileForm" class="profile-form" method="POST">
                <label for="fullName">Full Name:</label>
                <input type="text" id="fullName" name="fullName" value="<?php echo htmlspecialchars($user['name']); ?>" required>

                <label for="Address">Address:</label>
                <input type="text" id="Address" name="Address" value="<?php echo htmlspecialchars($user['address']); ?>" required>

                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                <label for="phone_number">Phone Number:</label>
                <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user['contact']); ?>" required>

                <button type="submit">Update Info</button>
            </form>
            <?php if (isset($_SESSION['update_success'])): ?>
                <p class="success-message"><?php echo $_SESSION['update_success']; unset($_SESSION['update_success']); ?></p>
            <?php endif; ?>
        </div>
    </div>

    <script src="../Js/Userprofile.js"></script>
</body>
</html>