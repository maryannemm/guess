-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2020 at 03:56 PM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_nubia`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cust_id` int(20) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `password` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `remarks` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cust_id`, `first_name`, `last_name`, `phone_no`, `email`, `status`, `password`, `username`, `remarks`, `date_created`) VALUES
(1, 'Ann', 'Njeri', '0754821589', 'njeri@gmail.com', 'Approved', '1234', 'Njeri', '', '2019-10-27 13:05:32'),
(2, 'Micheal', 'Nyaga', '0784851520', 'nyaga@gmail.com', 'Approved', '1234', 'Njaga', 'osdos', '2019-10-27 13:41:19'),
(3, 'Mwangi', 'Kamau', '0784854120', 'kamaa@gmail.com', 'Approved', '1234', 'Kamaa', '', '2020-01-04 18:18:03'),
(4, 'sds', 'klk', '0787485120', 'jkklk@gmail.com', 'Rejected', '1234', 'lklk', 'Fake account', '2020-01-05 09:31:19'),
(5, 'ana', 'iri', '0723456712', 'ana@gmail.com', 'Approved', '1234', 'anne', '', '2020-01-24 09:30:31'),
(6, 'kip', 'kep', '0787454120', 'kip@gmail.com', 'Approved', '1234', 'kip', '', '2020-02-28 10:52:30'),
(7, 'Carol', 'Jane', '0784854152', 'jane@gmail.com', 'Approved', '1234', 'Jane', '', '2020-05-02 17:01:30');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `fb_id` int(20) NOT NULL,
  `comment` text NOT NULL,
  `reply` text NOT NULL,
  `fb_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cust_id` int(20) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`fb_id`, `comment`, `reply`, `fb_date`, `cust_id`, `staff_id`) VALUES
(1, 'feedback', 'wel', '2020-05-03 11:43:41', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `feedback_supplier`
--

CREATE TABLE `feedback_supplier` (
  `fd_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `reply` text NOT NULL,
  `feb_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `supplier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feedback_supplier`
--

INSERT INTO `feedback_supplier` (`fd_id`, `comment`, `reply`, `feb_date`, `supplier_id`) VALUES
(1, 'Hi', 'hi to', '2020-05-03 11:49:48', 2);

-- --------------------------------------------------------

--
-- Table structure for table `item_sold`
--

CREATE TABLE `item_sold` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_sold`
--

INSERT INTO `item_sold` (`id`, `product_id`, `supplier_id`, `date_added`) VALUES
(1, 1, 2, '2020-05-03 09:01:18'),
(2, 2, 2, '2020-05-03 09:01:36'),
(3, 3, 2, '2020-05-03 09:10:51');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_status` varchar(20) NOT NULL DEFAULT 'Cart',
  `order_remark` text NOT NULL,
  `delivery_date` varchar(20) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `address` varchar(30) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `cust_id`, `order_date`, `order_status`, `order_remark`, `delivery_date`, `company_id`, `address`, `city`) VALUES
(2, 1, '2019-10-28 00:30:04', 'Shipping', '', '', 3, '', 'Maua'),
(3, 1, '2019-12-06 10:52:46', 'Rejected', 'Order reject for no reason', '', 3, '', 'Maua'),
(4, 1, '2020-01-04 17:54:30', 'Delivered', '', '2020-01-05 16:30:30', 3, '', 'Maua'),
(5, 3, '2020-01-05 07:57:43', 'Pending approval', '', '', 4, '', 'Maua'),
(6, 3, '2020-01-05 08:31:05', 'Cart', '', '', NULL, NULL, NULL),
(7, 5, '2020-01-24 09:37:41', 'Pending approval', '', '', 3, '2345679', 'nakuru'),
(8, 7, '2020-05-02 17:08:49', 'Cart', '', '', NULL, NULL, NULL),
(9, 1, '2020-05-02 20:53:47', 'Approved', '', '', 3, '123', 'Maua'),
(10, 1, '2020-05-02 20:57:06', 'Pending approval', '', '', 3, '123', 'Maua');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(20) NOT NULL,
  `cust_id` int(20) NOT NULL,
  `order_id` int(20) NOT NULL,
  `product_id` int(20) NOT NULL,
  `item_quantity` varchar(20) NOT NULL,
  `item_status` varchar(20) NOT NULL DEFAULT 'Cart',
  `price` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `cust_id`, `order_id`, `product_id`, `item_quantity`, `item_status`, `price`) VALUES
(30, 1, 4, 1, '2', 'Submitted', '1500'),
(32, 1, 4, 2, '3', 'Submitted', '1200'),
(33, 3, 5, 2, '1', 'Submitted', '1200'),
(34, 3, 5, 3, '1', 'Submitted', '521'),
(35, 3, 6, 3, '1', 'Cart', '521'),
(36, 5, 7, 1, '1', 'Submitted', '1500'),
(37, 5, 7, 3, '1', 'Submitted', '521'),
(38, 7, 8, 1, '1', 'Cart', '1500'),
(39, 7, 8, 3, '1', 'Cart', '521'),
(40, 1, 9, 1, '1', 'Submitted', '1500'),
(41, 1, 9, 3, '1', 'Submitted', '521'),
(42, 1, 10, 3, '1', 'Submitted', '521'),
(43, 1, 10, 2, '1', 'Submitted', '1200');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(20) NOT NULL,
  `order_id` int(20) NOT NULL,
  `payment_amount` varchar(50) NOT NULL,
  `mpesa_code` varchar(50) NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'Pending approval',
  `cust_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `order_id`, `payment_amount`, `mpesa_code`, `phone_no`, `payment_status`, `cust_id`) VALUES
(1, 2, '4700', 'SDERFT56Y7', '0754821589', 'Pending approval', 1),
(2, 3, '5000', 'kjujhyhgt6', '0754821589', 'Pending approval', 1),
(3, 4, '7100', 'kijuhyu78u', '0754821589', 'Pending approval', 1),
(8, 5, '2071', 'LKJNHBGYT6', '0784854120', 'Pending approval', 3),
(9, 7, '2521', 'qwertyuiop', '0723456712', 'Pending approval', 5),
(10, 9, '2521', 'lkijuijuii', '0754821589', 'Pending approval', 1),
(11, 10, '2221', 'SEDRFTG67Y', '0754821589', 'Pending approval', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(20) NOT NULL,
  `product_name` varchar(30) NOT NULL,
  `product_price` varchar(20) NOT NULL,
  `stock` int(20) NOT NULL,
  `product_status` varchar(20) NOT NULL DEFAULT 'Available',
  `product_remark` text NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_price`, `stock`, `product_status`, `product_remark`, `date_added`, `image`) VALUES
(1, 'Wheat flour 2kg bundles', '1500', 59, 'Available', '', '2019-10-27 09:32:59', '1575630180_2070.jpg'),
(2, 'Wheat flour 1kg bundles', '1200', 100, 'Available', '', '2019-10-27 09:34:56', '1572171170_8148.jpg'),
(3, 'kj', '521', 46, 'Available', '', '2019-12-06 10:47:38', '1575629258_5185.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_company`
--

CREATE TABLE `shipping_company` (
  `company_id` int(20) NOT NULL,
  `comp_name` varchar(50) NOT NULL,
  `shipping_cost` varchar(20) NOT NULL,
  `comp_status` varchar(20) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shipping_company`
--

INSERT INTO `shipping_company` (`company_id`, `comp_name`, `shipping_cost`, `comp_status`) VALUES
(3, 'G4s', '500', 'Active'),
(4, 'Poster kenya', '350', 'Active'),
(5, 'Welles fargo', '787', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_details`
--

CREATE TABLE `shipping_details` (
  `shipping_id` int(20) NOT NULL,
  `comp_id` int(20) NOT NULL,
  `cust_id` int(20) NOT NULL,
  `address` varchar(20) NOT NULL,
  `city` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shipping_details`
--

INSERT INTO `shipping_details` (`shipping_id`, `comp_id`, `cust_id`, `address`, `city`) VALUES
(8, 3, 1, '123', 'Maua'),
(9, 4, 3, '254', 'Maua'),
(10, 3, 5, '2345679', 'nakuru'),
(12, 3, 7, '1542', 'Kerugoya');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(20) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `staff_username` varchar(20) NOT NULL,
  `staff_password` varchar(20) NOT NULL,
  `staff_email` varchar(50) NOT NULL,
  `staff_phonenumber` varchar(20) NOT NULL,
  `staff_remark` text NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `staff_status` varchar(20) NOT NULL DEFAULT 'Active',
  `user_level` varchar(20) NOT NULL DEFAULT 'Staff'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `firstname`, `lastname`, `staff_username`, `staff_password`, `staff_email`, `staff_phonenumber`, `staff_remark`, `date_added`, `staff_status`, `user_level`) VALUES
(1, 'Admin', 'Admin', 'Admin', '1234', 'admin@gmail.com', '0784851259', '', '2019-10-27 06:57:47', 'Active', 'Admin'),
(2, 'Ann', 'Mary', 'Ann', '1234', 'ann@gmail.com', '0785452100', '', '2019-10-27 08:34:28', 'Active', 'Cashier'),
(3, 'Mary', 'Ann', 'MaryAnn', '1234', 'annmary@gmail.com', '0784854120', '', '2020-05-03 09:58:43', 'Active', 'Procurement');

-- --------------------------------------------------------

--
-- Table structure for table `stock_in`
--

CREATE TABLE `stock_in` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `date_supplied` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock_in`
--

INSERT INTO `stock_in` (`id`, `product_id`, `quantity`, `supplier_id`, `date_supplied`) VALUES
(1, 1, 20, 2, '2020-05-03 12:23:00');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `remarks` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `supplier_name`, `email`, `phone_no`, `password`, `date_added`, `username`, `status`, `remarks`) VALUES
(1, 'Jimwa grains', 'jimwa@gmail.com', '0784854215', '1234', '2020-05-02 23:00:22', 'Jimwa', 'Rejected', 'No username'),
(2, 'Maua farm', 'farm@gmail.com', '0784854512', '1234', '2020-05-02 23:15:01', 'Farm', 'Approved', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`fb_id`),
  ADD KEY `customer_id` (`cust_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `feedback_supplier`
--
ALTER TABLE `feedback_supplier`
  ADD PRIMARY KEY (`fd_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `item_sold`
--
ALTER TABLE `item_sold`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`cust_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `customer_id` (`cust_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `cust_id` (`cust_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `shipping_company`
--
ALTER TABLE `shipping_company`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `shipping_details`
--
ALTER TABLE `shipping_details`
  ADD PRIMARY KEY (`shipping_id`),
  ADD KEY `company_id` (`comp_id`),
  ADD KEY `customer_id` (`cust_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `stock_in`
--
ALTER TABLE `stock_in`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `cust_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `fb_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feedback_supplier`
--
ALTER TABLE `feedback_supplier`
  MODIFY `fd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `item_sold`
--
ALTER TABLE `item_sold`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shipping_company`
--
ALTER TABLE `shipping_company`
  MODIFY `company_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shipping_details`
--
ALTER TABLE `shipping_details`
  MODIFY `shipping_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stock_in`
--
ALTER TABLE `stock_in`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customer` (`cust_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item_sold`
--
ALTER TABLE `item_sold`
  ADD CONSTRAINT `item_sold_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`),
  ADD CONSTRAINT `item_sold_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customer` (`cust_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shipping_details`
--
ALTER TABLE `shipping_details`
  ADD CONSTRAINT `shipping_details_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customer` (`cust_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `shipping_details_ibfk_2` FOREIGN KEY (`comp_id`) REFERENCES `shipping_company` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock_in`
--
ALTER TABLE `stock_in`
  ADD CONSTRAINT `stock_in_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`),
  ADD CONSTRAINT `stock_in_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
