<?php
session_start();  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="shortcut icon" href="../Image/Logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gallery Cafe | Home</title>
</head>
<body>
    
<header>
    <div class="header">
    <div class="logo">
             <img src="../Image/Logo.png" alt="" class="">
         </div>

         <div class="nav">
                <ul>
                    <a href="index.php">
                        <li>Home</li>
                    </a>
                    <a href="about.php">
                        <li>About</li>
                    </a>
                    <a href="menu.php">
                        <li>Food Menu</li>
                    </a>
                    <a href="booking.php">
                        <li>Book Table</li>
                    </a>
                    <a href="pramotion.php">
                     <li>Pramotion</li>
                 </a>
                </ul>
            </div>

        <div class="headerbar">
        
            <div class="account">
                <ul>
                     <div class="search" id="searchinput1">
                        <input type="search">
                        <i class="fa-solid fa-magnifying-glass srchicon"></i>
                    </div>
                    <a href="../Pages/cart.php">
                            <li>
                                <i class="fa-solid fa-shopping-cart" id="cart-icon"></i>
                                <span id="cartCount">0</span> 
                            </li>
                        </a>
                    

                    
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                     <a href="user_profile.php"> 
                      <li>
                        <i class="fa-solid fa-user"></i> <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                      </li>
                     </a>
                       <a href="logout.php">
                      <li>Logout</li>
                       </a>
                        <?php else: ?>
                    <a href="login.html">
                       <li>Login</li>
                   </a>
                    <?php endif; ?>
                </ul>
            </div>
            
        </div>
    </div>
</header>

<script src="../Js/App.js"></script>
</body>
</html>