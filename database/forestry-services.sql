-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2023 at 11:15 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forestry-services`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `email_address` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `number_of_submissions` int(11) NOT NULL,
  `date_registered` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `chainsaw_stores`
--

CREATE TABLE `chainsaw_stores` (
  `chainsaw_store_id` int(11) NOT NULL,
  `permit_number` varchar(255) DEFAULT NULL,
  `bus_name` varchar(255) DEFAULT NULL,
  `owners_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `date_issued` varchar(255) DEFAULT NULL,
  `expiration_date` varchar(255) DEFAULT NULL,
  `certificate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `business_name` varchar(50) NOT NULL,
  `owners_name` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `email_address` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cov_registrations`
--

CREATE TABLE `cov_registrations` (
  `cov_registration_id` int(11) NOT NULL,
  `registration_number` varchar(255) NOT NULL,
  `permit_number` varchar(255) DEFAULT NULL,
  `cov_client_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `pltp` varchar(255) DEFAULT NULL,
  `vehicle_information` varchar(255) DEFAULT NULL,
  `location_from` varchar(255) DEFAULT NULL,
  `location_to` varchar(255) DEFAULT NULL,
  `species` varchar(255) DEFAULT NULL,
  `number_of_trees` varchar(255) DEFAULT NULL,
  `gross_volume` varchar(255) DEFAULT NULL,
  `net_volume` varchar(255) DEFAULT NULL,
  `drivers_name` varchar(255) DEFAULT NULL,
  `or_number` varchar(255) DEFAULT NULL,
  `plate_number` varchar(255) DEFAULT NULL,
  `date_and_time_encoded` datetime NOT NULL DEFAULT current_timestamp(),
  `date_and_time_updated` varchar(11) DEFAULT NULL,
  `date_and_time_accepted` varchar(11) DEFAULT NULL,
  `date_and_time_returned` varchar(11) DEFAULT NULL,
  `uploaded_requirements` varchar(11) DEFAULT NULL,
  `received_by` varchar(255) DEFAULT NULL,
  `date_and_time_submitted` varchar(255) DEFAULT NULL,
  `date_and_time_released` varchar(255) DEFAULT NULL,
  `released_by` varchar(255) DEFAULT NULL,
  `accepted_by` varchar(255) DEFAULT NULL,
  `validity_date` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `documents` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ptpr_registrations`
--

CREATE TABLE `ptpr_registrations` (
  `ptpr_registration_id` int(11) NOT NULL,
  `registration_number` varchar(255) NOT NULL,
  `permit_number` varchar(255) DEFAULT NULL,
  `ptpr_client_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `tax_declaration` varchar(255) DEFAULT NULL,
  `special_power_of_attorney` varchar(255) DEFAULT NULL,
  `tax_declaration_number` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `municipality` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `total_lot_area` varchar(255) DEFAULT NULL,
  `area_devoted_to_plantation` varchar(255) DEFAULT NULL,
  `species` varchar(255) DEFAULT NULL,
  `number_of_trees` varchar(255) DEFAULT NULL,
  `date_and_time_encoded` datetime NOT NULL DEFAULT current_timestamp(),
  `date_and_time_updated` varchar(11) DEFAULT NULL,
  `date_and_time_accepted` varchar(11) DEFAULT NULL,
  `date_and_time_returned` varchar(11) DEFAULT NULL,
  `uploaded_requirements` varchar(11) DEFAULT NULL,
  `received_by` varchar(255) DEFAULT NULL,
  `returned_by` varchar(255) DEFAULT NULL,
  `accepted_by` varchar(255) DEFAULT NULL,
  `date_and_time_submitted` varchar(255) DEFAULT NULL,
  `date_and_time_released` varchar(255) DEFAULT NULL,
  `released_by` varchar(255) DEFAULT NULL,
  `validity_date` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `documents` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `registration_id` int(11) NOT NULL,
  `registration_number` varchar(255) NOT NULL,
  `permit_number` varchar(255) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `chainsaw_receipt` varchar(255) DEFAULT NULL,
  `mayors_permit` varchar(255) DEFAULT NULL,
  `new_documents` varchar(100) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `serial_no` varchar(255) DEFAULT NULL,
  `date_of_acquisition` varchar(255) DEFAULT NULL,
  `power_output` varchar(255) DEFAULT NULL,
  `maximum_length_of_guidebar` varchar(255) DEFAULT NULL,
  `country_of_origin` varchar(255) DEFAULT NULL,
  `purchase_price` varchar(255) DEFAULT NULL,
  `date_and_time_encoded` datetime DEFAULT current_timestamp(),
  `date_and_time_updated` varchar(11) DEFAULT NULL,
  `date_and_time_accepted` varchar(11) DEFAULT NULL,
  `date_and_time_returned` varchar(11) DEFAULT NULL,
  `uploaded_requirements` varchar(11) DEFAULT NULL,
  `received_by` varchar(255) DEFAULT NULL,
  `accepted_by` varchar(255) DEFAULT NULL,
  `date_and_time_submitted` varchar(255) DEFAULT NULL,
  `date_and_time_released` varchar(255) DEFAULT NULL,
  `released_by` varchar(255) DEFAULT NULL,
  `validity_date` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `documents` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chainsaw_stores`
--
ALTER TABLE `chainsaw_stores`
  ADD PRIMARY KEY (`chainsaw_store_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `cov_registrations`
--
ALTER TABLE `cov_registrations`
  ADD PRIMARY KEY (`cov_registration_id`),
  ADD KEY `cov_client_id` (`cov_client_id`);

--
-- Indexes for table `ptpr_registrations`
--
ALTER TABLE `ptpr_registrations`
  ADD PRIMARY KEY (`ptpr_registration_id`),
  ADD KEY `ptpr_client_id` (`ptpr_client_id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`registration_id`),
  ADD KEY `client_id` (`client_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `chainsaw_stores`
--
ALTER TABLE `chainsaw_stores`
  MODIFY `chainsaw_store_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cov_registrations`
--
ALTER TABLE `cov_registrations`
  MODIFY `cov_registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `ptpr_registrations`
--
ALTER TABLE `ptpr_registrations`
  MODIFY `ptpr_registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cov_registrations`
--
ALTER TABLE `cov_registrations`
  ADD CONSTRAINT `cov_client_id` FOREIGN KEY (`cov_client_id`) REFERENCES `clients` (`client_id`) ON DELETE CASCADE;

--
-- Constraints for table `ptpr_registrations`
--
ALTER TABLE `ptpr_registrations`
  ADD CONSTRAINT `ptpr_client_id` FOREIGN KEY (`ptpr_client_id`) REFERENCES `clients` (`client_id`) ON DELETE CASCADE;

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `client_id` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
