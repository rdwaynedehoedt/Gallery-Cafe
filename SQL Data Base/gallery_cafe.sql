-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2024 at 08:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gallery_cafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `people` varchar(10) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `comments` text DEFAULT NULL,
  `subscribe` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `capacity`
--

CREATE TABLE `capacity` (
  `id` int(11) NOT NULL,
  `parking_spots` int(11) DEFAULT 0,
  `motorbike_spots` int(11) DEFAULT 0,
  `table_two` int(11) DEFAULT 0,
  `table_four` int(11) DEFAULT 0,
  `table_six` int(11) DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `capacity`
--

INSERT INTO `capacity` (`id`, `parking_spots`, `motorbike_spots`, `table_two`, `table_four`, `table_six`, `updated_at`) VALUES
(1, 4, 5, 4, 4, 3, '2024-09-23 05:44:53'),
(2, 4, 5, 9, 6, 6, '2024-09-26 08:27:30');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(5, 'Sri lankan'),
(6, 'chinese'),
(7, 'Italian'),
(8, 'Beverage');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `category_id`, `description`, `price`, `image`) VALUES
(14, 'Mutton rolls', 5, 'Sri Lanka\'s croquettes are breadcrumb rolls made of spicy minced meat and potato, typically served with a spicy hot sauce as a dipping sauce.', 450.00, '../upload/mutton.png'),
(15, 'Crab curry', 5, 'Sri Lankans are obsessed with Crab Curry – depending on where you are on the island, but we are providing best crab curry in sri lanka.', 850.00, '../upload/Crab curry.jpg'),
(16, 'Kothu Roti', 5, 'Keep your eyes (and ears) peeled for this really popular street food dish, which consists of finely chopped roti (flatbread) cooked with vegetables, eggs, curry sauce, meat or seafood.', 1250.00, '../upload/Kothu roti.jpg'),
(17, 'Shrimp Szechuan', 6, 'Szechuan cuisine is quite a popular cuisine style from the Szechuan province of China.', 1150.00, '../upload/sichuan-style-shrimp-main-.jpg'),
(18, 'Chili Fish', 6, 'Chili Fish is an Indo-Chinese recipe. These dishes are an adaptation of Chinese seasoning and cooking techniques to Indian tastes.', 1350.00, '../upload/fish-manchurian-recipe-chili-fish-min.jpg'),
(19, 'Shrimp Masala', 6, 'This is yet another Indo-Chinese inspired recipe.', 1450.00, '../upload/shrimp-masala-min.jpg'),
(20, 'Chef Special Shrimp', 6, 'As the name suggests, Chef Special Shrimp is indeed the Chefs Specialties.', 1450.00, '../upload/sweet-and-sour-shrimp.jpg'),
(21, 'Bruschetta', 7, 'This local food in Italy has existed since the 15th century and is still very popular throughout the world.', 1300.00, '../upload/Bruschetta.jpg'),
(22, 'Risotto', 7, 'Risotto has a similar appearance with porridge, and it’s the most common way to cook rice in Italy.', 1400.00, '../upload/Risotto.jpg'),
(23, 'Lasagna', 7, 'One of the most delicious Italian foods that once included on the CNN best 50 food list is Lasagna. No wonder, because this food is divine and has fans from all over the world.', 1300.00, '../upload/Lasagna.jpg'),
(24, 'Fettuccine Alfredo', 7, 'As the name suggests, fettuccine alfredo is only using Fettuccine as its main ingredient.', 1500.00, '../upload/Fettuccine Alfredo.jpg'),
(25, 'Coffee', 8, 'Tea is alright but thank God for Coffee! Sri lankan special coffee.', 250.00, '../upload/Coffee.jpg'),
(26, 'Orange Juice', 8, 'A glass full of orange juice is a glass full of sunshine.', 350.00, '../upload/Orange Juice.jpg'),
(27, 'Lemonade', 8, 'Lemonade is probably consumed in every corner of the world that has access to lime or lemons.', 550.00, '../upload/Lemonade.jpg'),
(28, 'Soup', 8, 'Beverages are not all artificially sweetened, alcoholic, colorful or carbonated drinks. Some of them are wholesome, savory and spicy concoctions. And none of them are as well received as Soup.', 1250.00, '../upload/Soup.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `order_status` enum('Pending','Processing','Confirmed','Cancelled') DEFAULT 'Pending',
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_status`, `total`, `created_at`) VALUES
(1, 5, 'Pending', 20750.00, '2024-09-22 23:59:43'),
(2, 5, 'Cancelled', 1300.00, '2024-09-23 00:01:47'),
(3, 5, 'Pending', 850.00, '2024-10-02 17:22:42');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `item_id`, `quantity`, `price`) VALUES
(1, 1, NULL, 14, 450.00),
(2, 1, NULL, 17, 850.00),
(3, 2, 14, 1, 450.00),
(4, 2, 15, 1, 850.00),
(5, 3, 15, 1, 850.00);

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `title`, `image`, `description`, `start_date`, `end_date`, `status`) VALUES
(11, 'Sicario Weekend Indulgence\"', 'http://localhost/gallerycafe/Admin/upload/happy hour.jpeg', 'Enjoy a 20% discount on all meals, complimentary dessert with every main course, and 2-for-1 happy hour drinks from 4 PM to 6 PM every weekend. Indulge in great food, savings, and a fantastic atmosphere at Sicario!', '2024-10-12', '2024-10-18', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `user_type_id` int(11) UNSIGNED NOT NULL DEFAULT 2,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `address`, `email`, `password`, `contact`, `user_type_id`, `created_at`) VALUES
(1, 'admin', 'Galleroad Bambalapitiya Colombo', 'admin@example.com', 'admin123', '0770770770', 1, '2024-09-18 21:19:51'),
(3, 'Deshika ', '80,Bentota,Galle', 'deshika@gmail.com', 'deshika123', '0777077012', 2, '2024-09-18 21:52:05'),
(5, 'Pahan Sanjana', 'Galle Road', 'Pahan@gmail.com', 'pahan123', '0777077012', 2, '2024-09-20 20:15:49'),
(6, 'Staff Name', '123 Example Street', 'staff@example.com', 's123', '1234567890', 3, '2024-09-23 05:38:54'),
(7, 'sahan', '80 galle road ', 'sahan@gmail.com', '123456', '0112233456', 2, '2024-10-02 17:05:04');

-- --------------------------------------------------------

--
-- Table structure for table `usertype`
--

CREATE TABLE `usertype` (
  `id` int(11) UNSIGNED NOT NULL,
  `type_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usertype`
--

INSERT INTO `usertype` (`id`, `type_name`) VALUES
(1, 'Admin'),
(2, 'Customer'),
(3, 'Staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `capacity`
--
ALTER TABLE `capacity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usertype`
--
ALTER TABLE `usertype`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `capacity`
--
ALTER TABLE `capacity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `usertype`
--
ALTER TABLE `usertype`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
