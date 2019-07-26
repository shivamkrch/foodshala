-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2019 at 02:05 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foodshala_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pwd` varchar(32) NOT NULL,
  `veg` tinyint(1) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `pwd`, `veg`, `date`) VALUES
(2, 'shivam', 'hiv@ga.co', 'e10adc3949ba59abbe56e057f20f883e', 1, '2019-07-23 12:49:29'),
(7, 'shivam', 'hiva@ga.co', 'e10adc3949ba59abbe56e057f20f883e', 1, '2019-07-23 13:30:00'),
(9, 'Shivam Kumar', 'shivam@gmail.com', 'fba660a50bb1744203b4dbb0a91ed469', 0, '2019-07-23 17:35:48'),
(10, 'Akash Dev', 'akash@gmail.com', '5f9497d7ab9c5f53e24816121a430c9d', 1, '2019-07-25 14:26:20');

-- --------------------------------------------------------

--
-- Table structure for table `food_items`
--

CREATE TABLE `food_items` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `ingredients` text NOT NULL,
  `veg` tinyint(1) NOT NULL DEFAULT '1',
  `rest_id` int(11) DEFAULT NULL,
  `cost` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `food_items`
--

INSERT INTO `food_items` (`id`, `name`, `ingredients`, `veg`, `rest_id`, `cost`) VALUES
(1, 'Chicken kabab', 'Chicken(2 pcs)', 0, 5, 120),
(9, 'Paneer Masala', 'Paneer (4 pcs)', 1, 5, 80),
(10, 'Butter Paneer', 'Paneer (4 pcs), Butter', 1, 5, 90),
(11, 'Butter Chicken', 'Chicken (4 pcs), Butter', 0, 5, 140),
(13, 'Paneer Combo', 'Paneer Masala (2pcs), 2 Parathas, Salad', 1, 5, 120),
(14, 'Chicken Kadhai', 'Chicken (4 pcs), Salad', 0, 5, 140),
(16, 'Chicken Fried Rice', 'Fried Rice, Chicken (4 pcs), Salad', 0, 7, 155),
(17, 'Veg Hakka Noodles', 'Noodles', 1, 7, 140),
(18, 'Paneer Butter Masala', 'Main Course', 1, 7, 165),
(19, 'Tandoori Chicken', 'Chicken (6 pcs)', 0, 7, 165),
(20, 'Chicken Tikka', 'Chicken (4 pcs)', 0, 7, 140),
(21, 'Butter Naan', 'Butter baked tandoori breads', 1, 7, 35),
(22, 'Chicken and 2 Parathas', 'Chicken (4 pcs) + 2 Plain Parathas', 0, 9, 115),
(23, 'Chicken Biryani', 'Rice and Biryani with Chicken and Egg', 0, 9, 126),
(24, 'Egg Biryani', 'Rice and Biryani, fried eggs', 0, 9, 99),
(25, 'Tadka Dal', 'Fried Dal with Tadka', 1, 9, 90),
(26, 'Paneer Butter Masala', 'Paneer (4 pcs)', 1, 9, 144),
(27, 'Matar Paneer', 'Paneer (6 pcs)', 1, 9, 160);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `rest_id` int(11) DEFAULT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `food_id` int(11) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `rest_id`, `cust_id`, `food_id`, `date`) VALUES
(1, 5, 9, 1, '2019-07-23 21:34:26'),
(4, 5, 9, 1, '2019-07-25 13:14:45'),
(5, 7, 9, 20, '2019-07-25 13:15:27'),
(6, 7, 9, 18, '2019-07-25 13:24:54'),
(7, 5, 9, 1, '2019-07-25 13:25:54'),
(8, 5, 9, 10, '2019-07-25 13:25:59'),
(9, 5, 10, 9, '2019-07-25 14:30:11'),
(10, 5, 10, 13, '2019-07-25 14:30:21'),
(11, 7, 10, 17, '2019-07-25 14:30:33'),
(12, 5, 10, 9, '2019-07-25 18:12:36'),
(13, 7, 9, 21, '2019-07-26 13:34:32'),
(14, 9, 10, 25, '2019-07-26 13:58:46'),
(15, 9, 10, 23, '2019-07-26 13:58:54'),
(16, 9, 10, 27, '2019-07-26 14:03:07');

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `location` varchar(100) NOT NULL,
  `pwd` varchar(32) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `email`, `location`, `pwd`, `date`) VALUES
(5, 'Panthshala', 'panthshala@gmail.com', 'City Centre, Durgapur', 'f9344b84a771b4bdb200d50743942858', '2019-07-23 13:33:46'),
(7, 'Theque', 'theque@gmail.com', 'Bidhannagar', '060f3ed6bf1f1958aacccc5a72d25ee5', '2019-07-24 15:02:19'),
(9, 'Hotel Kohinoor', 'kohinoor@gmail.com', 'Bidhannagar, Durgapur', '9c908aed01bf1c599cfde078f295b96e', '2019-07-26 13:48:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `food_items`
--
ALTER TABLE `food_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rest_id` (`rest_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cust_id` (`cust_id`),
  ADD KEY `food_id` (`food_id`),
  ADD KEY `rest_id` (`rest_id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `food_items`
--
ALTER TABLE `food_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `food_items`
--
ALTER TABLE `food_items`
  ADD CONSTRAINT `food_items_ibfk_1` FOREIGN KEY (`rest_id`) REFERENCES `restaurants` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`food_id`) REFERENCES `food_items` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`rest_id`) REFERENCES `restaurants` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
