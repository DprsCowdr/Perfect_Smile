-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2025 at 04:33 AM
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
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) UNSIGNED NOT NULL,
  `appointment_id` varchar(20) NOT NULL COMMENT 'Unique appointment identifier (APT-001, APT-002, etc.)',
  `patient_id` int(11) UNSIGNED NOT NULL COMMENT 'Foreign key to patient table id field',
  `doctor_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'Foreign key to user table (doctor)',
  `appointment_date` date NOT NULL COMMENT 'Date of the appointment',
  `appointment_time` time NOT NULL COMMENT 'Time of the appointment',
  `duration` int(11) NOT NULL DEFAULT 30 COMMENT 'Duration in minutes',
  `appointment_type` enum('consultation','cleaning','filling','extraction','root_canal','crown','bridge','implant','orthodontics','emergency','follow_up') NOT NULL COMMENT 'Type of appointment',
  `status` enum('scheduled','confirmed','in_progress','completed','cancelled','no_show','rescheduled') NOT NULL DEFAULT 'scheduled' COMMENT 'Current status of the appointment',
  `priority` enum('low','normal','high','urgent') NOT NULL DEFAULT 'normal' COMMENT 'Priority level of the appointment',
  `chief_complaint` text DEFAULT NULL COMMENT 'Primary reason for the visit',
  `symptoms` text DEFAULT NULL COMMENT 'Patient symptoms description',
  `treatment_plan` text DEFAULT NULL COMMENT 'Planned treatment for the patient',
  `diagnosis` text DEFAULT NULL COMMENT 'Medical diagnosis',
  `treatment_notes` text DEFAULT NULL COMMENT 'Notes about the treatment provided',
  `prescription` text DEFAULT NULL COMMENT 'Prescribed medications or instructions',
  `follow_up_required` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Whether follow-up is required',
  `follow_up_date` date DEFAULT NULL COMMENT 'Date for follow-up appointment',
  `payment_status` enum('pending','partial','paid','refunded') NOT NULL DEFAULT 'pending' COMMENT 'Payment status',
  `amount` decimal(10,2) DEFAULT NULL COMMENT 'Total amount for the appointment',
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Discount amount applied',
  `insurance_claim` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Whether insurance claim is filed',
  `reminder_sent` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Whether reminder has been sent',
  `reminder_date` datetime DEFAULT NULL COMMENT 'When the reminder was sent',
  `room_number` varchar(20) DEFAULT NULL COMMENT 'Room or location for the appointment',
  `equipment_needed` text DEFAULT NULL COMMENT 'Special equipment required',
  `special_instructions` text DEFAULT NULL COMMENT 'Special instructions for the appointment',
  `cancellation_reason` text DEFAULT NULL COMMENT 'Reason for cancellation if applicable',
  `cancelled_by` int(11) UNSIGNED DEFAULT NULL COMMENT 'User ID who cancelled the appointment',
  `cancelled_at` datetime DEFAULT NULL COMMENT 'When the appointment was cancelled',
  `created_by` int(11) UNSIGNED DEFAULT NULL COMMENT 'User ID who created the appointment',
  `updated_by` int(11) UNSIGNED DEFAULT NULL COMMENT 'User ID who last updated the appointment',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Appointments table for Perfect Smile dental clinic management system';

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `appointment_id`, `patient_id`, `doctor_id`, `appointment_date`, `appointment_time`, `duration`, `appointment_type`, `status`, `priority`, `chief_complaint`, `symptoms`, `treatment_plan`, `diagnosis`, `treatment_notes`, `prescription`, `follow_up_required`, `follow_up_date`, `payment_status`, `amount`, `discount`, `insurance_claim`, `reminder_sent`, `reminder_date`, `room_number`, `equipment_needed`, `special_instructions`, `cancellation_reason`, `cancelled_by`, `cancelled_at`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(4, 'APT-001', 1, 3, '2025-07-24', '00:27:00', 30, 'cleaning', 'in_progress', 'normal', 'd', 'd', 'd', 'd', NULL, NULL, 1, '2025-07-30', 'pending', 5000.00, 0.00, 0, 0, NULL, NULL, 'd', 'd', NULL, NULL, NULL, NULL, NULL, '2025-07-19 02:25:28', '2025-07-19 02:25:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_appointment_id` (`appointment_id`),
  ADD KEY `idx_patient_id` (`patient_id`),
  ADD KEY `idx_doctor_id` (`doctor_id`),
  ADD KEY `idx_appointment_date` (`appointment_date`),
  ADD KEY `idx_appointment_time` (`appointment_time`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_priority` (`priority`),
  ADD KEY `idx_appointment_type` (`appointment_type`),
  ADD KEY `idx_payment_status` (`payment_status`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_updated_at` (`updated_at`),
  ADD KEY `idx_date_time` (`appointment_date`,`appointment_time`),
  ADD KEY `idx_doctor_date_time` (`doctor_id`,`appointment_date`,`appointment_time`),
  ADD KEY `idx_patient_date` (`patient_id`,`appointment_date`),
  ADD KEY `idx_status_date` (`status`,`appointment_date`),
  ADD KEY `idx_follow_up` (`follow_up_required`,`follow_up_date`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
