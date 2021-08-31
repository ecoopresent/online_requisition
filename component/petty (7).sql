-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2021 at 03:58 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `petty`
--

-- --------------------------------------------------------

--
-- Table structure for table `canvas`
--

CREATE TABLE `canvas` (
  `id` int(10) UNSIGNED NOT NULL,
  `pr_id` int(10) UNSIGNED NOT NULL,
  `supplier1` varchar(105) NOT NULL,
  `supplier2` varchar(105) NOT NULL,
  `supplier3` varchar(105) NOT NULL,
  `supplier4` varchar(105) NOT NULL,
  `supplier5` varchar(105) NOT NULL,
  `remarks` varchar(105) NOT NULL,
  `approved_by` varchar(45) NOT NULL,
  `canvas_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `canvas`
--

INSERT INTO `canvas` (`id`, `pr_id`, `supplier1`, `supplier2`, `supplier3`, `supplier4`, `supplier5`, `remarks`, `approved_by`, `canvas_date`) VALUES
(1, 1, '5 BROTHERS', 'LEERUS', '', '', '', 'LOWEST CANVAS LEERUS 3/2', 'Homer C. Lim', '2021-03-03'),
(2, 2, 'LEERUS AUTOCARE', 'RAPIDE AUTO SERVICE EXPERT', '', '', '', 'LOWEST CANVAS LEERUS 3/2', 'Homer C. Lim', '2021-03-04'),
(3, 3, 'MC Truck Body Maker Inc', 'Hearttruck Body Builder', 'Red Dragon Truck Body Builder', '', '', 'Lowest Quote: Mc Truck Body maker Inc', 'Homer C. Lim', '2021-03-04');

-- --------------------------------------------------------

--
-- Table structure for table `canvas_details`
--

CREATE TABLE `canvas_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `canvas_id` int(10) UNSIGNED NOT NULL,
  `qty` int(10) UNSIGNED NOT NULL,
  `uom` varchar(45) NOT NULL,
  `product_desc` varchar(405) NOT NULL,
  `price1` varchar(45) NOT NULL,
  `price2` varchar(45) NOT NULL,
  `price3` varchar(45) NOT NULL,
  `price4` varchar(45) NOT NULL,
  `price5` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `canvas_details`
--

INSERT INTO `canvas_details` (`id`, `canvas_id`, `qty`, `uom`, `product_desc`, `price1`, `price2`, `price3`, `price4`, `price5`) VALUES
(3, 1, 1, 'PC', 'WINDOW MECHANISM', '1500', '780', '0', '0', '0'),
(4, 1, 1, 'PC', 'GLASS HOLDER', '700', '950', '0', '0', '0'),
(7, 1, 0, '', 'LABOR', '350', '800', '0', '0', '0'),
(9, 2, 0, '', 'CHANGE OIL AND CHECK-UP KM READING PREV -106,883 PRESENT -115,242 *LAST CHANGE OIL WAS DD 11/26/20 /LEERUSS AUTOCARE CENTER', '3440', '4550', '0', '0', '0'),
(10, 3, 1, 'Unit', 'Fiber Glass', '15000', '28000', '18000', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `cashcheck`
--

CREATE TABLE `cashcheck` (
  `id` int(10) UNSIGNED NOT NULL,
  `pr_id` int(10) UNSIGNED NOT NULL,
  `department` varchar(45) NOT NULL,
  `payee` varchar(45) NOT NULL,
  `date_prepared` date NOT NULL,
  `date_needed` date NOT NULL,
  `particulars` varchar(205) NOT NULL,
  `amount` varchar(45) NOT NULL,
  `purpose` varchar(205) NOT NULL,
  `remarks` varchar(205) NOT NULL,
  `charge_to` varchar(45) NOT NULL,
  `budget` varchar(45) NOT NULL,
  `liquidated_on` date NOT NULL,
  `prepared_by` varchar(45) NOT NULL,
  `department_head` varchar(45) NOT NULL,
  `president` varchar(45) NOT NULL,
  `accounting` varchar(45) NOT NULL,
  `cash_status` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `liquidation`
--

CREATE TABLE `liquidation` (
  `id` int(10) UNSIGNED NOT NULL,
  `pettycash_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(45) NOT NULL,
  `liquidation_date` date NOT NULL,
  `branch` varchar(45) NOT NULL,
  `position` varchar(45) NOT NULL,
  `prepared_by` varchar(45) NOT NULL,
  `checked_by` varchar(45) NOT NULL,
  `approved_by` varchar(45) NOT NULL,
  `particulars` varchar(205) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `liquidation_details`
--

CREATE TABLE `liquidation_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `liquidation_id` int(10) UNSIGNED NOT NULL,
  `l_from` varchar(45) NOT NULL,
  `l_to` varchar(45) NOT NULL,
  `vehicle_type` varchar(45) NOT NULL,
  `amount` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pettycash`
--

CREATE TABLE `pettycash` (
  `id` int(10) UNSIGNED NOT NULL,
  `department` varchar(45) NOT NULL,
  `voucher_date` date NOT NULL,
  `voucher_no` varchar(45) NOT NULL,
  `particulars` varchar(105) NOT NULL,
  `cash_advance` varchar(45) NOT NULL,
  `actual_amount` varchar(45) NOT NULL,
  `charge_to` varchar(45) NOT NULL,
  `liquidated_on` date NOT NULL,
  `requested_by` varchar(45) NOT NULL,
  `approved_by` varchar(45) NOT NULL,
  `authorized` varchar(45) NOT NULL,
  `pettycash_status` varchar(45) NOT NULL,
  `liquidation` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pr`
--

CREATE TABLE `pr` (
  `id` int(10) UNSIGNED NOT NULL,
  `department` varchar(45) NOT NULL,
  `date_prepared` date NOT NULL,
  `date_needed` date NOT NULL,
  `pr_no` varchar(45) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `requested_by` varchar(45) NOT NULL,
  `approved_by` varchar(45) NOT NULL,
  `pr_status` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pr`
--

INSERT INTO `pr` (`id`, `department`, `date_prepared`, `date_needed`, `pr_no`, `purpose`, `requested_by`, `approved_by`, `pr_status`) VALUES
(1, 'Admin', '2021-02-23', '2021-02-23', 'PRCHS2021-1', 'FOR REPAIR OF LEFT SIDE WINDOW OF VAN', 'Rina Gavino', 'Marjorie Barona', 'Finished'),
(2, 'Admin', '2021-03-23', '2021-03-23', 'PRCHS2021-2', 'CHANGE OIL FOR DELIVERY VAN MAINTENANCE', 'Rina Gavino', 'Marjorie Barona', 'Finished'),
(3, 'Admin', '2021-03-23', '2021-03-23', 'PRCHS2021-3', 'Supply and Installation of Wind Breaker for Aluminum Van', 'Rina Gavino', 'Marjorie Barona', 'Finished');

-- --------------------------------------------------------

--
-- Table structure for table `pr_details`
--

CREATE TABLE `pr_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `pr_id` int(10) UNSIGNED NOT NULL,
  `item_code` varchar(45) NOT NULL,
  `stock` int(10) UNSIGNED NOT NULL,
  `rqmt` int(10) UNSIGNED NOT NULL,
  `uom` varchar(45) NOT NULL,
  `item_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pr_details`
--

INSERT INTO `pr_details` (`id`, `pr_id`, `item_code`, `stock`, `rqmt`, `uom`, `item_description`) VALUES
(1, 1, '', 0, 1, 'PC', 'WINDOW MECHANISM'),
(2, 1, '', 0, 1, 'PC', 'GLASS HOLDER'),
(3, 2, '', 0, 0, '', 'CHANGE OIL AND CHECK-UP KM READING PREV -106,883 PRESENT -115,242 *LAST CHANGE OIL WAS DD 11/26/20 /LEERUSS AUTOCARE CENTER'),
(4, 3, '', 0, 1, 'Unit', 'Fiber Glass');

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(45) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `user_status` varchar(45) NOT NULL,
  `user_type` varchar(45) NOT NULL,
  `user_dept` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`id`, `full_name`, `username`, `password`, `user_status`, `user_type`, `user_dept`) VALUES
(8, 'Accounting', 'c', 'c', 'active', 'Accounting', 'IT'),
(9, 'Administrator', 'd', 'd', 'active', 'Administrator', 'Admin'),
(12, 'Rina Gavino', 'enduser', 'enduser', 'active', 'Enduser', 'Purchasing'),
(13, 'Marjorie Barona', 'approver', 'approver', 'active', 'Approver', 'Admin'),
(15, 'Marjorie Barona', 'purchaser', 'purchaser', 'active', 'Purchaser', 'Purchasing');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `canvas`
--
ALTER TABLE `canvas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `canvas_details`
--
ALTER TABLE `canvas_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cashcheck`
--
ALTER TABLE `cashcheck`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `liquidation`
--
ALTER TABLE `liquidation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `liquidation_details`
--
ALTER TABLE `liquidation_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pettycash`
--
ALTER TABLE `pettycash`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pr`
--
ALTER TABLE `pr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pr_details`
--
ALTER TABLE `pr_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `canvas`
--
ALTER TABLE `canvas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `canvas_details`
--
ALTER TABLE `canvas_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cashcheck`
--
ALTER TABLE `cashcheck`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `liquidation`
--
ALTER TABLE `liquidation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `liquidation_details`
--
ALTER TABLE `liquidation_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pettycash`
--
ALTER TABLE `pettycash`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pr`
--
ALTER TABLE `pr`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pr_details`
--
ALTER TABLE `pr_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
