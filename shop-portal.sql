-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2025 at 09:53 AM
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
-- Database: `shop-portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `activity_type` enum('product_added','shop_updated','offer_created','category_added') NOT NULL,
  `description` varchar(255) NOT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `shop_id`, `category_name`, `created_at`) VALUES
(1, 2, 'Clothing', '2025-07-01 12:59:28'),
(2, 3, 'Container', '2025-07-03 07:48:09'),
(3, 4, 'Electronics', '2025-07-10 06:35:59'),
(4, 2, 'Gym', '2025-07-10 06:36:26'),
(5, 2, 'Saloon', '2025-07-10 06:41:33');

-- --------------------------------------------------------

--
-- Table structure for table `customer_queries`
--

CREATE TABLE `customer_queries` (
  `query_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `status` enum('new','in_progress','answered','closed') DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_queries`
--

INSERT INTO `customer_queries` (`query_id`, `user_id`, `shop_id`, `name`, `email`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'ygu7g', 'ygtd@gmail.com', 'uyftydf', 'uhuy', 'new', '2025-07-11 07:24:11', NULL),
(2, 1, NULL, 'Chinmaya', 'chinmaya@gmail.com', 'gyvghvhhh', 'cgvcgvvvgjh', 'new', '2025-07-11 07:32:25', NULL),
(3, 1, NULL, 'Chinmaya', 'chinmaya@gmail.com', 'vuguygyuyu', 'byhbuhui', 'new', '2025-07-11 07:34:36', NULL),
(4, 1, NULL, 'Chinmaya Prasad', 'cpbehera03@gmail.com', 'vgvvvvvgv', 'cffvtytjjjjjj', 'new', '2025-07-11 07:36:10', NULL),
(5, 1, NULL, 'hjvbhjhjb', 'ch@gmail.com', 'ygbbbbjj', 'jkjnjnhjnjn', 'new', '2025-07-11 07:39:20', NULL),
(6, 1, NULL, 'bb', 'Ch@gmail.com', 'b jb jknkjk', 'vhbhijmiojioj', 'new', '2025-07-11 07:41:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `offer_id` int(11) NOT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `discount_percent` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`offer_id`, `shop_id`, `title`, `description`, `discount_percent`, `start_date`, `end_date`, `image_path`, `created_at`, `category_id`) VALUES
(1, 2, '30% off on Good Life Turmeric Powder 100 g', 'Turmeric or Haldi is an essential ingredient in Indian cuisines.', 30, '2025-07-01', '2025-07-05', NULL, '2025-07-01 15:44:17', NULL),
(3, 3, '30% off on Laptops', 'Laptops', 29, '2025-07-03', '2025-07-06', NULL, '2025-07-03 11:08:02', NULL),
(4, 4, '30% OFF on Shirts', 'Stylish Glamorous Men Shirts', 29, '2025-07-07', '2025-07-10', '1752065626_f4ypd_512.webp', '2025-07-07 07:40:07', NULL),
(5, 2, '20% OFF on FLATS', '20% OFF on FLATS', 20, '2025-07-07', '2025-07-14', '1752065932_1618191776_Elevation1.jpg', '2025-07-07 10:58:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `shop_id`, `category_id`, `product_name`, `description`, `price`, `image`, `created_at`) VALUES
(2, 2, 1, 'Mango Banganapalli 1 kg', 'Often referred as \"The King of fruits\", Mango is a juicy, nutrition-rich stone fruit with exclusive fragrance, flavour, varieties and health enhancing benefits.', 99.00, '1751374864_mango-banganapalli-1-kg-product-images-o590000651-p590000651-0-202504011511.webp', '2025-07-01 13:01:04'),
(3, 3, 2, 'Faverito Brown Plastic Masala Rangoli Dabba', 'faverito Masala container, maintain good health and hygiene. The lid color is in contrast with the container color to make the masala box attractive.', 100.00, '1751528968_faverito-masala-rangoli-box-dabba-for-keeping-spices-spice-box-for-kitchen-product-images-orv0nvzzwq4-p590479388-0-202108161554.webp', '2025-07-03 07:49:28');

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `shop_id` int(11) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `shop_name` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`shop_id`, `owner_id`, `shop_name`, `address`, `city`, `state`, `pincode`, `latitude`, `longitude`, `created_at`, `image`) VALUES
(2, 1, 'Grand Bazar', '9VGQ+P8C, Bamphakuda, Odisha 754001', 'Bhubaneswar', 'Odisha', '754001', 20.67240000, 85.86830000, '2025-07-01 12:41:13', 'uploads/shops/shop_686e622515cfd7.97798667.jpeg'),
(3, 2, 'Reliance Smart Bazaar', 'Bhubaneswar,Odisha', 'Bhubaneswar', 'Odisha', '751002', 20.00000000, 40.00000000, '2025-07-03 07:45:53', 'uploads/shops/shop_686e64b59fb4e1.56131298.jpg'),
(4, 1, 'V-MART', 'Gopabandhu Chak, Byasanagar, Odisha 750019', 'Jajpur', 'Odisha', '750019', 20.98146400, 86.14222000, '2025-07-07 06:51:42', 'uploads/shops/shop_686e625d31c148.55714809.webp'),
(5, 1, 'Patanjali Mega Store', 'Plot No 2060 & 2061 & 2062, Samantarapur, Old Town, Bhubaneswar, Odisha 751002', 'Bhubaneswar', 'Odisha', '751002', 0.00000000, 0.00000000, '2025-07-08 05:39:23', 'uploads/shops/shop_686e6b37036061.95839627.webp'),
(6, 1, 'Monginis Cake Shop', 'Plot No 3095 Mahaveer Nagar, Samantarapur, Old Town, Bhubaneswar, Odisha 751007', 'Bhubaneswar', 'Odisha', '751007', 0.00000000, 0.00000000, '2025-07-08 09:17:49', 'uploads/shops/shop_686e6b60180fd2.83924604.webp');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('shop_owner','customer') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'abc', 'abc@gmail.com', '$2y$10$OIe8qQUf59N3G1n9T/De4uF8slcpw23Msx9nMbVUCHQFfh/NN1tsy', 'shop_owner', '2025-07-01 12:26:25'),
(2, 'xyz', 'xyz@gmail.com', '$2y$10$a.D5dspTb/P6QhCpVf1KYOhB.6imDhxjyL3.RvYuNpqLGeW3i4zRW', 'shop_owner', '2025-07-03 06:42:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `shop_id` (`shop_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `shop_id` (`shop_id`);

--
-- Indexes for table `customer_queries`
--
ALTER TABLE `customer_queries`
  ADD PRIMARY KEY (`query_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `shop_id` (`shop_id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`offer_id`),
  ADD KEY `shop_id` (`shop_id`),
  ADD KEY `fk_offer_category` (`category_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `shop_id` (`shop_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`shop_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer_queries`
--
ALTER TABLE `customer_queries`
  MODIFY `query_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `offer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `shop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `activity_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `activity_log_ibfk_2` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`shop_id`) ON DELETE SET NULL;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`shop_id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_queries`
--
ALTER TABLE `customer_queries`
  ADD CONSTRAINT `fk_query_shop` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`shop_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_query_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `fk_offer_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `offers_ibfk_1` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`shop_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`shop_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL;

--
-- Constraints for table `shops`
--
ALTER TABLE `shops`
  ADD CONSTRAINT `shops_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
