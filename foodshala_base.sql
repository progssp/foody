-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2020 at 12:08 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foodshala_base`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `c_id` int(11) NOT NULL COMMENT 'Customer id',
  `c_name` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT 'Customer name',
  `c_email` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT 'Customer email',
  `c_country_code` varchar(6) COLLATE utf8_bin DEFAULT NULL COMMENT 'Customer phone num country code',
  `c_cont_no` varchar(16) COLLATE utf8_bin DEFAULT NULL COMMENT 'Customer phone num',
  `c_password` varchar(200) COLLATE utf8_bin DEFAULT NULL COMMENT 'Customer password',
  `c_food_preference` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT 'Customer food preference'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`c_id`, `c_name`, `c_email`, `c_country_code`, `c_cont_no`, `c_password`, `c_food_preference`) VALUES
(1, 'Sam Martin', 'sam@mail.com', '+91', '8888887865', 'f16bed56189e249fe4ca8ed10a1ecae60e8ceac0', 'non-veg'),
(2, 'Demi Moore', 'demi@yahoo.com', '+91', '5432229856', '3ed7670cfb6228de16e954a84dc99cad8b37538a', 'veg');

-- --------------------------------------------------------

--
-- Table structure for table `menu_item`
--

CREATE TABLE `menu_item` (
  `item_id` int(11) NOT NULL COMMENT 'Item id',
  `r_id` int(11) NOT NULL COMMENT 'Restaurant id from Restaurant',
  `item_name` varchar(100) COLLATE utf8_bin NOT NULL COMMENT 'Item name',
  `item_type` varchar(10) COLLATE utf8_bin NOT NULL COMMENT 'veg/non-veg',
  `item_measurment` varchar(50) COLLATE utf8_bin NOT NULL COMMENT 'item price per',
  `item_price` float NOT NULL COMMENT 'item price'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `menu_item`
--

INSERT INTO `menu_item` (`item_id`, `r_id`, `item_name`, `item_type`, `item_measurment`, `item_price`) VALUES
(1, 1, 'Pasta', 'veg', 'plate', 100),
(2, 1, 'Sandwich', 'veg', 'plate', 140);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `o_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL COMMENT 'Customer id',
  `r_id` int(11) NOT NULL COMMENT 'Restaurant id',
  `o_desc` varchar(1000) COLLATE utf8_bin DEFAULT NULL COMMENT 'Order desc',
  `o_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `o_amt` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`o_id`, `c_id`, `r_id`, `o_desc`, `o_date`, `o_amt`) VALUES
(1, 1, 1, '[{\"item_title\":\"Pasta\",\"item_price\":\"100\",\"item_measurment\":\"per plate\",\"item_type\":\"veg\",\"item_qty\":1},{\"item_title\":\"Sandwich\",\"item_price\":\"140\",\"item_measurment\":\"per plate\",\"item_type\":\"veg\",\"item_qty\":5}]', '2020-09-28 10:06:21', 800),
(2, 1, 1, '[{\"item_title\":\"Pasta\",\"item_price\":\"100\",\"item_measurment\":\"per plate\",\"item_type\":\"veg\",\"item_qty\":3}]', '2020-09-28 10:07:59', 300);

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `r_id` int(11) NOT NULL COMMENT 'Restaurant id',
  `r_name` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT 'Restaurant name',
  `r_address` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT 'Restaurant address',
  `r_email` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT 'Restaurant email',
  `r_country_code` varchar(6) COLLATE utf8_bin DEFAULT NULL COMMENT 'Restaurant phone num country code',
  `r_cont_no` varchar(16) COLLATE utf8_bin DEFAULT NULL COMMENT 'Restaurant phone num',
  `r_password` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT 'Restaurant password',
  `r_food_preference` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT 'Restaurant food preference'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`r_id`, `r_name`, `r_address`, `r_email`, `r_country_code`, `r_cont_no`, `r_password`, `r_food_preference`) VALUES
(1, 'Roger Cafe', 'serif road, townsville building, floor 2, usa', 'rogercafe@mail.com', '+91', '9988989898', '8067936531828e35329048574c9ab83b0cc39ac0', 'non-veg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `menu_item`
--
ALTER TABLE `menu_item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `r_id` (`r_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`o_id`),
  ADD KEY `c_id` (`c_id`),
  ADD KEY `r_id` (`r_id`);

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`r_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu_item`
--
ALTER TABLE `menu_item`
  ADD CONSTRAINT `menu_item_ibfk_1` FOREIGN KEY (`r_id`) REFERENCES `restaurant` (`r_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `customer` (`c_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`r_id`) REFERENCES `restaurant` (`r_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
