-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2025 at 12:21 PM
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
-- Database: `dentalv5`
--

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `patient_id` varchar(20) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `full_name` varchar(200) GENERATED ALWAYS AS (concat(`first_name`,' ',`last_name`)) STORED,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `age` int(3) DEFAULT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `nationality` varchar(50) DEFAULT 'Filipino',
  `occupation` varchar(100) DEFAULT NULL,
  `marital_status` enum('single','married','divorced','widowed') DEFAULT 'single',
  `emergency_contact_name` varchar(100) DEFAULT NULL,
  `emergency_contact_phone` varchar(20) DEFAULT NULL,
  `emergency_contact_relationship` varchar(50) DEFAULT NULL,
  `blood_type` enum('A+','A-','B+','B-','AB+','AB-','O+','O-','Unknown') DEFAULT 'Unknown',
  `allergies` text DEFAULT NULL,
  `medical_conditions` text DEFAULT NULL,
  `current_medications` text DEFAULT NULL,
  `insurance_provider` varchar(100) DEFAULT NULL,
  `insurance_number` varchar(50) DEFAULT NULL,
  `dental_history` text DEFAULT NULL,
  `previous_dentist` varchar(100) DEFAULT NULL,
  `referral_source` varchar(100) DEFAULT NULL,
  `preferred_appointment_time` enum('morning','afternoon','evening') DEFAULT 'morning',
  `status` enum('active','inactive','suspended') DEFAULT 'active',
  `preferred_language` varchar(50) DEFAULT 'English',
  `special_needs` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id`, `user_id`, `patient_id`, `first_name`, `last_name`, `email`, `phone`, `address`, `date_of_birth`, `age`, `gender`, `nationality`, `occupation`, `marital_status`, `emergency_contact_name`, `emergency_contact_phone`, `emergency_contact_relationship`, `blood_type`, `allergies`, `medical_conditions`, `current_medications`, `insurance_provider`, `insurance_number`, `dental_history`, `previous_dentist`, `referral_source`, `preferred_appointment_time`, `status`, `preferred_language`, `special_needs`, `notes`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, NULL, 'PAT-001', 'John Bert', 'Manaog', 'manaogjohnbert@gmail.com', '09948804318', 'san jose baybayon sugong', '2025-07-19', NULL, 'female', 'japan', 'student', 'divorced', 'John Bert Manaog', '09948804318', 'parent', 'AB+', '', '', '', 's', 's', '', 's', 's', 'afternoon', 'active', 'tagalog', '', '', '2025-07-18 02:19:43', '2025-07-18 02:19:43', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('admin','doctor','staff','patient','guest') DEFAULT 'patient',
  `status` enum('active','inactive','suspended') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `user_type`, `status`, `created_at`, `updated_at`) VALUES
(2, 'admin', 'admin@perfectsmile.com', '$2y$10$CfXMUjkDu8HdkG2iR1rqv.Ujdva3SyTSdP9fpGsZ7LihWEEayFtK6', 'admin', 'active', '2025-07-18 01:42:27', '2025-07-18 01:42:27'),
(3, 'doctor', 'doctor@perfectsmile.com', '$2y$10$VW1xPzNSEi6ObWM3/Q478ecYc1uRw9uPGc5.HC2zwe9/XWyWm4RGi', 'doctor', 'active', '2025-07-18 01:42:27', '2025-07-18 01:42:27'),
(4, 'staff', 'staff@perfectsmile.com', '$2y$10$NO5N0FVvs3CsUj.26fEjN.XhK6HEuiZRhI7QHGPWS1zFkaA/5WN6O', 'staff', 'active', '2025-07-18 01:42:27', '2025-07-18 01:42:27'),
(5, 'bertmelo', 'bertmelo@gmail.com', '$2y$10$9FMTsT0M6yN4xofUSUq4QeuD1PVk29g6BMJP4tgveJ7v9Qi4k67oa', 'patient', 'active', '2025-07-18 01:44:37', '2025-07-18 01:44:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patient_id` (`patient_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `idx_username` (`username`),
  ADD UNIQUE KEY `idx_email` (`email`),
  ADD KEY `idx_user_type` (`user_type`),
  ADD KEY `idx_status` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `patient_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `patient_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `patient_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
