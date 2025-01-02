<?php
session_start();
include "connection.php"; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["e"];
    $password = $_POST["p"];

    if (empty($email)) {
        echo "Please Enter Your Email";
    } else if (empty($password)) {
        echo "Please Enter Your Password";
    } else {
        
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $num = $result->num_rows;

        if ($num == 1) {
            $user = $result->fetch_assoc();

            if ($user["user_type_id"] == 1) { 
                $_SESSION["admin"] = $user; 
                echo "Success";
            } else {
                echo "You Don't Have an Admin Account";
            }
        } else {
            echo "Invalid Email or Password";
        }

        $stmt->close();
    }
}
?>