-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2026 at 06:19 PM
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
-- Database: `food_ordering_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `food_name` varchar(255) NOT NULL,
  `price` varchar(100) NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `food_name`, `price`, `image_url`) VALUES
(1, 'wali', '5000', '1770312406_1770311360_1770311038_walinyama.jpg'),
(2, 'samaki wa kupaka', '12000', '1770322825_samakiwakupaka.jpg'),
(3, 'mchuzi wa mboga', '15000', '1770322882_mchuziwamboga.jpg'),
(4, 'chips kavu', '7500', '1770322919_chipskavu.jpg'),
(5, 'chapati supu', '13000', '1770322959_chapatinasupu.jpg'),
(6, 'kuku wa kupaka', '20000', '1770323030_kukuwakupaka.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `food_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('Inasubiri','Imekubaliwa','Imekataliwa','Imekamilika') DEFAULT 'Inasubiri',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `food_name`, `price`, `status`, `order_date`) VALUES
(1, 3, 'wali', 5000.00, 'Imekubaliwa', '2026-02-05 18:34:15'),
(2, 3, 'wali', 5000.00, 'Imekubaliwa', '2026-02-05 18:51:18'),
(3, 3, 'wali', 5000.00, 'Imekataliwa', '2026-02-05 18:57:14'),
(4, 3, 'wali', 5000.00, 'Imekataliwa', '2026-02-06 08:06:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'user', 'admin@test.com', '$2y$10$qNbu/Czxiso4B0E1DrZpiOvhhFTpdgtgXJWQGXwcdroy6bdjTm04S', 'user', '2026-02-05 18:02:19'),
(2, 'Salumu', 'Salumuamani38@gmail.com', '$2y$10$exgP8QWD.MUyKrnR0B9iO.qAG/R2cWP5MIyroRe3cprQa1U58rCmO', 'admin', '2026-02-05 18:05:26'),
(3, 'philimon', 'philimon8@gmail.com', '$2y$10$ift62bwSdq7fZhTHoEhmde6FbrwaqYgxWPahuXaZ7SX6aL1kwdHH2', 'user', '2026-02-05 18:25:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
