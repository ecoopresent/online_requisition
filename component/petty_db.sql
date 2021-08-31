-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2021 at 04:57 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `canvas_details`
--

CREATE TABLE `canvas_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `canvas_id` int(10) UNSIGNED NOT NULL,
  `qty` int(10) UNSIGNED NOT NULL,
  `uom` varchar(45) NOT NULL,
  `product_desc` varchar(105) NOT NULL,
  `price1` varchar(45) NOT NULL,
  `price2` varchar(45) NOT NULL,
  `price3` varchar(45) NOT NULL,
  `price4` varchar(45) NOT NULL,
  `price5` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

--
-- Dumping data for table `liquidation`
--

INSERT INTO `liquidation` (`id`, `pettycash_id`, `name`, `liquidation_date`, `branch`, `position`, `prepared_by`, `checked_by`, `approved_by`, `particulars`) VALUES
(1, 2, 'Jerico Presentacion', '2021-03-10', 'IT', 'WOW', 'Juan Dela X', 'Jerico Presentacion', 'ADS', 'Partucas');

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

--
-- Dumping data for table `liquidation_details`
--

INSERT INTO `liquidation_details` (`id`, `liquidation_id`, `l_from`, `l_to`, `vehicle_type`, `amount`) VALUES
(1, 1, 'Antel Global', 'Sm megamall', 'UV Express', '120');

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

--
-- Dumping data for table `pettycash`
--

INSERT INTO `pettycash` (`id`, `department`, `voucher_date`, `voucher_no`, `particulars`, `cash_advance`, `actual_amount`, `charge_to`, `liquidated_on`, `requested_by`, `approved_by`, `authorized`, `pettycash_status`, `liquidation`) VALUES
(1, 'IT', '2021-03-03', 'VHER2021-1', 'Mema', '120', '120', 'Sayo daw', '2021-03-10', 'Juan Dela X', 'Jerico Presentacion', 'ADS', 'Approved', 'no'),
(2, 'IT', '2021-03-03', 'VHER2021-2', 'Partucas', '120', '120', 'Sad developer', '2021-03-10', 'Juan Dela X', 'Jerico Presentacion', 'ADS', 'Approved1', 'yes');

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
(1, 'IT', '2021-03-03', '2021-03-04', 'PRCHS2021-1', 'Sample', 'Juan Dela X', '', 'Submitted');

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
(1, 1, 'BP', 5, 10, 'pc', 'Ballpen');

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
(6, 'Jerico Presentacion', 'a', 'a', 'active', 'Approver', 'IT'),
(7, 'Juan Dela X', 'b', 'b', 'active', 'Enduser', 'IT'),
(8, 'Jojo Mendoza', 'c', 'c', 'active', 'Accounting', 'IT'),
(9, 'Administrator', 'd', 'd', 'active', 'Administrator', 'Admin'),
(10, 'Eco present', 'aa', 'aa', 'active', 'Approver', 'HR'),
(11, 'Marian Ignacio', 'e', 'e', 'active', 'Purchaser', 'Accounting'),
(12, 'Marjorie Barona', 'enduser', 'enduser', 'active', 'Enduser', 'Purchasing'),
(13, 'Marjorie Barona', 'approver', 'approver', 'active', 'Approver', 'Purchasing');

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `canvas_details`
--
ALTER TABLE `canvas_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cashcheck`
--
ALTER TABLE `cashcheck`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `liquidation`
--
ALTER TABLE `liquidation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `liquidation_details`
--
ALTER TABLE `liquidation_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pettycash`
--
ALTER TABLE `pettycash`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pr`
--
ALTER TABLE `pr`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pr_details`
--
ALTER TABLE `pr_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
