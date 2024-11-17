-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2023 at 03:49 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ils`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `size` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `product_id`, `comment`, `created_at`) VALUES
(20, 4, 6, 'test', '2023-12-14 15:11:09'),
(21, 4, 6, 'buwang', '2023-12-14 15:11:16'),
(22, 4, 6, 'buwang', '2023-12-14 15:12:02'),
(23, 4, 6, 'buwang', '2023-12-14 15:12:54'),
(24, 4, 6, 'wagaga', '2023-12-14 15:13:12'),
(25, 4, 6, 'wagaga', '2023-12-14 15:14:02'),
(26, 4, 7, 'test', '2023-12-14 15:14:14'),
(27, 4, 6, 'test', '2023-12-14 15:14:23'),
(28, 4, 6, 'test', '2023-12-14 15:14:54'),
(29, 4, 6, 'test', '2023-12-14 15:14:59');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `previous_cart`
--

CREATE TABLE `previous_cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `size` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `stock` int(100) NOT NULL,
  `size` varchar(255) DEFAULT NULL,
  `location` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `category`, `stock`, `size`, `location`) VALUES
(6, 'Basic Duckdown Parka [GREY]', 1250, 'prod-2.png', 'Outer', 1, NULL, ''),
(7, 'Basic Duckdown Parka [BLACK]', 1250, 'prod-1.png', 'Outer', 10, NULL, ''),
(8, 'Basic Duckdown Parka [PINK]', 1250, 'prod-3.png', 'Outer', 100, NULL, ''),
(9, 'Basic Duckdown Parka [OLIVE]', 1250, 'prod-4.png', 'Outer', 100, NULL, ''),
(10, 'Basic Duckdown Parka [KHAKI]', 1250, 'prod-5.png', 'Outer', 100, NULL, ''),
(11, 'Sherpa Flight Jacket [IVORY]', 1250, 'prod-6.png', 'Outer', 100, NULL, ''),
(12, 'Tweety & Sylvester Ball Cap [NAVY]', 1250, 'prod-13.png', 'Accessories', 100, NULL, ''),
(13, 'Taz Two Tone Ball Cap [BLACK]', 1250, 'prod-14.png', 'Accessories', 100, NULL, ''),
(14, 'Taz Two Tone Ball Cap [BLUE]', 1250, 'prod-24.png', 'Accessories', 100, NULL, ''),
(15, 'Marvin Fleece Earflap Camp [CHARCOAL]', 1250, 'prod-19.png', 'Accessories', 100, NULL, ''),
(16, 'Fantasia Beanie [PURPLE]', 1250, 'prod-20.png', 'Accessories', 0, NULL, ''),
(17, 'Eclipse Logo Brushed Beanie [BROWN]', 1250, 'prod-18.png', 'Accessories', 100, NULL, ''),
(18, 'Smoke Ball Cap [BLACK]', 1250, 'prod-21.png', 'Accessories', 100, NULL, ''),
(19, 'Smoke Ball Cap [KHAKI]', 1250, 'prod-22.png', 'Accessories', 100, NULL, ''),
(20, 'Raw Cut Pigment Ball Cap [NAVY]', 1250, 'prod-25.png', 'Accessories', 100, NULL, ''),
(21, 'Raw Cut Pigment Ball Cap [CHARCOAL]', 1250, 'prod-26.png', 'Accessories', 100, NULL, ''),
(22, 'Division Bell Cap [IVORY/BLACK]', 1250, 'prod-15.png', 'Accessories', 100, NULL, ''),
(23, 'Pink Floyd Mesh Trucker [WHITE/BLACK]', 1250, 'prod-17.png', 'Accessories', 100, NULL, ''),
(24, 'Bugs Bunny Ball Cap [MG2DSMAB24B]', 1250, 'prod-16.png', 'Accessories', 100, NULL, ''),
(25, 'Bullet Mark Denim Pant [BLUE]', 1250, 'prod-41.png', 'Bottom', 100, NULL, ''),
(26, 'String Cargo Sweatpant [KHAKI]', 1250, 'prod-36.png', 'Bottom', 100, NULL, ''),
(27, 'String Cargo Sweatpant [LIGHT]', 1250, 'prod-40.png', 'Bottom', 100, NULL, ''),
(28, 'Bullet Mark Denim Pant [BLACK]', 1250, 'prod-37.png', 'Bottom', 100, NULL, ''),
(29, 'Washed RIP Stop Cargo Short [BEIGE]', 1250, 'prod-39.png', 'Bottom', 100, NULL, ''),
(30, 'Washed RIP Stop Cargo Short [KHAKI]', 1250, 'prod-34.png', 'Bottom', 100, NULL, ''),
(31, 'Bunny Sweat Short [LIGHT GREY]', 1250, 'prod-38.png', 'Bottom', 100, NULL, ''),
(32, 'Bunny Sweat Short [NAVY]', 1250, 'prod-31.png', 'Bottom', 100, NULL, ''),
(33, 'Contrast Stitch Short [BLACK]', 1250, 'prod-32.png', 'Bottom', 100, NULL, ''),
(34, 'Water Dyed Mesh Short [GREEN]', 1250, 'prod-33.png', 'Bottom', 100, NULL, ''),
(35, 'Repaired Work Pant [BEIGE]', 1250, 'prod-30.png', 'Bottom', 100, NULL, ''),
(36, 'Repaired Work Pant [CHARCOAL]', 1250, 'prod-29.png', 'Bottom', 100, NULL, ''),
(37, 'LT CHAMPS VARSITY JACKET [NAVY]', 1250, 'prod-8.png', 'Outer', 100, NULL, ''),
(38, 'REVERSIBLE BUNNY SOUVENIR JACKET [BLACK]', 1250, 'prod-10.png', 'Outer', 100, NULL, ''),
(39, 'NYLON TWILL WINDBREAKER [BLACK]', 1250, 'prod-54.png', 'Outer', 100, NULL, ''),
(40, 'OVERDYED M-51 SHORT PARKA [CHARCOAL]', 1250, 'prod-55.png', 'Outer', 100, NULL, ''),
(41, 'THINSULATE MID LAYER JACKET [OLIVE]', 1250, 'prod-51.png', 'Outer', 100, NULL, ''),
(42, 'WASHED TIEDYE WIND BREAK [GREEN]', 1250, 'prod-56.png', 'Outer', 100, NULL, ''),
(43, 'WESTERN DUCKDOWN PARKA [BLUE]', 1250, 'prod-53.png', 'Outer', 100, NULL, ''),
(44, 'WASHED TIEDYE WIND BREAK [BLACK]', 1250, 'prod-52.png', 'Outer', 100, NULL, ''),
(45, 'DOT LOGO EMB HALF ZIP-UP [LIGHT GREY]', 1250, 'prod-7.png', 'Top', 100, NULL, ''),
(46, 'DOT LOGO EMB HALF ZIP-UP [BLACK]', 1250, 'prod-9.png', 'Top', 100, NULL, ''),
(47, 'TAZ FLAME HOODIE [BLACK]', 1250, 'prod-12.png', 'Top', 100, NULL, ''),
(48, 'TAZ FLAME HOODIE [BROWN]', 1250, 'prod-11.png', 'Top', 100, NULL, ''),
(49, 'LOVE YOUTH PEACE! [ROSE]', 1250, 'prod-42.png', 'Top', 0, NULL, ''),
(50, 'PRODUCT T1', 1250, 'prod-43.png', 'Top', 100, NULL, ''),
(51, 'PRODUCT T2', 1250, 'prod-44.png', 'Top', 100, NULL, ''),
(52, 'PRODUCT T3', 1250, 'prod-45.png', 'Top', 100, NULL, ''),
(53, 'PRODUCT T4', 1250, 'prod-46.png', 'Top', 100, NULL, ''),
(54, 'PRODUCT T5', 1250, 'prod-47.png', 'Top', 100, NULL, ''),
(55, 'PRODUCT T6', 1250, 'prod-48.png', 'Top', 100, NULL, ''),
(56, 'PRODUCT T7', 1250, 'prod-49.png', 'Top', 100, NULL, ''),
(58, '\'43 MATRIX PUFF JACKET [GREY]', 1000, 'v1.jpg', 'Outer', 0, NULL, 'vault'),
(59, '\'43 MATRIX PUFF JACKET [BLACK]', 1000, 'v2.jpg', 'Outer', 0, NULL, 'vault'),
(60, '\'43 MATRIX PUFF JACKET [ORANGE]', 1000, 'v3.jpg', 'Outer', 0, NULL, 'vault'),
(61, '\'43 MATRIX PUFF JACKET [LIME]', 1000, 'v4.jpg', 'Outer', 0, NULL, 'vault'),
(62, '\'43 MATRIX ITEM [???]', 1000, 'v5.jpg', 'Top', 0, NULL, 'vault'),
(63, '\'43 MATRIX ITEM [BLUE]', 1000, 'v6.jpg', 'Top', 0, NULL, 'vault'),
(64, '\'43 MATRIX ITEM [PINK]', 1000, 'v7.jpg', 'Top', 0, NULL, 'vault'),
(65, '\'43 MATRIX ITEM [CYAN]', 1000, 'v8.jpg', 'Top', 0, NULL, 'vault'),
(66, '\'43 MATRIX ITEM [JUNGLE]', 1000, 'v9.jpg', 'Top', 0, NULL, 'vault'),
(67, '\'43 MATRIX ITEM [DESERT]', 1000, 'v10.jpg', 'Top', 0, NULL, 'vault'),
(68, '\'43 MATRIX ITEM [NAVY]', 1000, 'v11.jpg', 'Top', 0, NULL, 'vault'),
(69, '\'43 MATRIX ITEM [ORANGE]', 1000, 'v12.jpg', 'Top', 0, NULL, 'vault'),
(70, '\'43 MATRIX ITEM [BEIGE]', 1000, 'v13.jpg', 'Top', 0, NULL, 'vault'),
(71, '\'43 MATRIX LNAD [BLUE]', 1000, 'v14.jpg', 'Top', 0, NULL, 'vault'),
(72, '\'43 MATRIX LNAD [BLACK]', 1000, 'v15.jpg', 'Top', 0, NULL, 'vault'),
(73, '\'43 MATRIX ITEM [BROWN]', 1000, 'v16.jpg', 'Top', 0, NULL, 'vault');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(11, 'customer1', 'customer@gmail.com', '$2y$10$F9r47YrSNg1CMwQhtbkyIeKk9Z0gZykKXgwWLkA95KNliygPlGJeG', 'user'),
(13, 'admin', 'admin@gmail.com', '$2y$10$KHQY1qc5uickL6fW2duVO.l2Qif6wyo2/qGVu9FDKW4eipSFvvzfS', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `previous_cart`
--
ALTER TABLE `previous_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `previous_cart`
--
ALTER TABLE `previous_cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
