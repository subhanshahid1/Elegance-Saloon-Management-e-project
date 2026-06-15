-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2026 at 12:09 PM
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
-- Database: `saloon`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `stylist_id` int(11) DEFAULT NULL,
  `service_id` int(11) NOT NULL,
  `apt_date` date NOT NULL,
  `apt_time` time NOT NULL,
  `status` enum('pending','confirmed','cancelled','completed') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `client_id`, `stylist_id`, `service_id`, `apt_date`, `apt_time`, `status`, `notes`, `created_at`) VALUES
(1, 15, 4, 7, '2026-07-22', '08:51:00', 'confirmed', '', '2026-04-08 03:51:44'),
(2, 14, 4, 7, '2027-07-02', '20:58:00', 'confirmed', '', '2026-04-08 03:58:38'),
(3, 16, 4, 1, '2026-05-02', '14:22:00', 'cancelled', 'I need haircut haircut advise from a professional', '2026-04-08 04:20:30'),
(4, 16, 4, 5, '2027-02-01', '09:34:00', 'cancelled', 'need this treatment from a professional\r\n', '2026-04-08 04:35:02'),
(5, 16, 4, 1, '2027-03-02', '17:00:00', 'confirmed', '233223', '2026-04-08 05:12:15'),
(6, 16, 4, 5, '2026-04-23', '14:00:00', 'confirmed', '', '2026-04-08 05:12:56'),
(7, 16, 4, 7, '2027-02-02', '10:00:00', 'confirmed', 'i need a professional advice', '2026-04-08 05:31:50'),
(8, 16, 4, 3, '2027-02-02', '11:00:00', 'confirmed', 'I need any stylist\r\n', '2026-04-08 05:34:14'),
(9, 2, 4, 4, '2027-02-02', '13:00:00', 'confirmed', 'i need a professional advice', '2026-04-08 05:37:26'),
(11, 17, 4, 10, '2026-04-09', '10:00:00', 'completed', 'NOTHING ', '2026-04-09 05:14:35'),
(12, 16, 4, 26, '2026-04-12', '10:00:00', 'completed', 'Nothing to say', '2026-04-10 05:09:36'),
(13, 16, 4, 27, '2026-04-12', '11:00:00', 'completed', 'Hello', '2026-04-10 05:24:25'),
(14, 16, 4, 26, '2026-04-13', '17:00:00', 'confirmed', 'i might need a professional advice for  this service', '2026-04-13 10:12:03'),
(15, 16, 4, 27, '2026-04-15', '13:00:00', 'completed', '', '2026-04-13 11:32:45'),
(16, 16, 4, 24, '2026-04-16', '16:00:00', 'confirmed', 'Hello', '2026-04-16 10:09:52'),
(17, 16, NULL, 23, '2026-04-16', '14:00:00', 'cancelled', 'Hello', '2026-04-16 10:11:08'),
(27, 31, 4, 11, '2026-05-01', '10:00:00', 'confirmed', ' n', '2026-04-17 12:07:59'),
(28, 32, 4, 1, '2026-04-23', '15:00:00', 'pending', '', '2026-04-20 10:45:36'),
(29, 16, 4, 23, '2026-04-20', '14:00:00', 'pending', 'hvhfjd', '2026-04-20 11:34:31');

-- --------------------------------------------------------

--
-- Table structure for table `commissions`
--

CREATE TABLE `commissions` (
  `id` int(11) NOT NULL,
  `stylist_id` int(11) DEFAULT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','paid') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `commissions`
--

INSERT INTO `commissions` (`id`, `stylist_id`, `appointment_id`, `amount`, `status`, `created_at`) VALUES
(1, 4, NULL, 0.00, 'pending', '2026-04-07 06:32:27'),
(2, 4, NULL, 60.00, 'pending', '2026-04-07 11:13:26'),
(3, 4, NULL, 600.00, 'pending', '2026-04-10 04:00:03'),
(4, 4, NULL, 100.00, 'pending', '2026-04-10 04:01:32'),
(5, 4, NULL, 225.00, 'pending', '2026-04-13 10:56:00'),
(6, 4, NULL, 750.00, 'pending', '2026-04-13 11:31:19'),
(7, 4, NULL, 225.00, 'pending', '2026-04-17 11:30:56'),
(8, 4, NULL, 100.00, 'pending', '2026-04-17 11:35:37');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `first_name`, `last_name`, `email`, `phone`, `subject`, `message`, `created_at`) VALUES
(1, 'salman', 'ahmed', 'salman23@gmail.com', '03092164686', 'inquiry', 'Hello i need to know about you services', '2026-04-13 09:20:48'),
(3, 'Subhan', 'Shahid', 'subhanshahid.pk1@gmail.com', '03092638416', 'inquiry', 's', '2026-04-20 10:31:43'),
(4, 'Subhan', 'Shahid', 'subhanshahid.pk1@gmail.com', '03092164686', 'pricing', 'tets', '2026-04-20 10:32:05');

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `rating` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` enum('new','read') DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `name`, `email`, `rating`, `message`, `status`, `created_at`) VALUES
(1, 'salman ahmed', 'salman23@gmail.com', 4, '23231111sss', '', '2026-04-08 11:35:07'),
(2, 'salman', 'salman23@gmail.com', 5, 'great experience staff is friendly', 'new', '2026-04-13 11:24:32'),
(3, 'Muhammad  Amir', 'amir23@gmail.com', 2, 'bad experience', 'new', '2026-04-13 11:26:21'),
(4, 'salman ahmed', 'salman23@gmail.com', 2, 'bad experience', 'new', '2026-04-13 11:32:23');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `reorder_level` int(11) DEFAULT 10,
  `cost_per_unit` decimal(10,2) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `name`, `category`, `quantity`, `reorder_level`, `cost_per_unit`, `supplier_id`, `last_updated`) VALUES
(1, 'Keune Tinta Color (Various)', 'Color', 45, 10, 850.00, 2, '2026-04-07 11:00:05'),
(2, 'Olaplex No. 3 Hair Perfector', 'Hair Treatment', 12, 3, 4500.00, 3, '2026-04-07 07:37:22'),
(3, 'Dermalogica Special Cleansing Gel', 'Skin Care', 80, 12, 3200.00, 4, '2026-04-15 11:28:52'),
(4, 'Disposable Hair Cutting Capes', 'Essentials', 100, 20, 45.00, 5, '2026-04-07 10:39:46'),
(5, 'Keune Developer 20 Vol', 'Chemical', 15, 5, 1200.00, 2, '2026-04-07 07:37:22'),
(6, 'Signature Shampoo (Bulk)', 'Hair Care', 10, 3, 5500.00, 1, '2026-04-13 11:31:09'),
(7, 'Golden Pearl Facial Kit', 'Facial', 16, 5, 2500.00, 3, '2026-04-07 08:00:12'),
(8, 'Professional Hair Bleach Powder', 'Chemical', 6, 2, 1200.00, 3, '2026-04-07 11:09:24');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(50) DEFAULT 'general',
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `link` varchar(255) DEFAULT 'dashboard/index.php',
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `title`, `message`, `link`, `is_read`, `created_at`) VALUES
(2, 16, 'appointment', 'Booking Received', 'Your request for 2026-04-13 at 05:00 PM is pending approval.', 'index.php', 0, '2026-04-13 10:12:03'),
(8, 4, 'payment', 'Commission Earned', 'You earned Rs. 225 commission from a recent service.', 'commissions.php', 0, '2026-04-13 10:56:00'),
(9, 16, 'payment', 'Payment Receipt', 'Thank you! Your payment of Rs. 4,500 has been confirmed.', 'index.php', 0, '2026-04-13 10:56:00'),
(19, 4, 'payment', 'Commission Earned', 'You earned Rs. 750 commission from a recent service.', 'commissions.php', 0, '2026-04-13 11:31:19'),
(20, 14, 'payment', 'Payment Receipt', 'Thank you! Your payment of Rs. 15,000 has been confirmed.', 'index.php', 0, '2026-04-13 11:31:19'),
(24, 4, 'appointment', 'New Appointment', 'You have a new appointment assigned for 2026-04-15 at 01:00 PM.', 'appointments.php', 0, '2026-04-13 11:32:45'),
(25, 16, 'appointment', 'Booking Received', 'Your request for 2026-04-15 at 01:00 PM is pending approval.', 'index.php', 0, '2026-04-13 11:32:45'),
(34, 4, 'appointment', 'New Appointment', 'You have a new appointment assigned for 2026-04-16 at 01:00 PM.', 'appointments.php', 0, '2026-04-16 10:09:52'),
(35, 16, 'appointment', 'Booking Received', 'Your request for 2026-04-16 at 01:00 PM is pending approval.', 'index.php', 0, '2026-04-16 10:09:52'),
(38, 16, 'appointment', 'Booking Received', 'Your request for 2026-04-16 at 02:00 PM is pending approval.', 'index.php', 0, '2026-04-16 10:11:08'),
(40, 4, 'appointment', 'New Appointment', 'New appointment for 2026-04-16 at 03:00 PM.', 'appointments.php', 0, '2026-04-16 10:56:54'),
(44, 4, 'appointment', 'New Appointment', 'New appointment for 2026-04-17 at 02:00 PM.', 'appointments.php', 0, '2026-04-16 11:17:41'),
(62, 22, 'payment', 'Payment Receipt', 'Thank you! Your payment of Rs. 4,500 has been confirmed.', 'index.php', 0, '2026-04-17 11:30:57'),
(69, 4, 'payment', 'Commission Earned', 'You earned Rs. 100 commission from a recent service.', 'commissions.php', 0, '2026-04-17 11:35:37'),
(70, 5, 'payment', 'Payment Receipt', 'Thank you! Your payment of Rs. 2,000 has been confirmed.', 'index.php', 0, '2026-04-17 11:35:37'),
(90, 5, 'payment', 'Payment Receipt', 'Thank you! Your payment of Rs. 8,500 has been confirmed.', 'index.php', 0, '2026-04-17 11:36:29'),
(110, 4, 'appointment', 'New Appointment', 'New appointment for 2026-05-01 at 10:00 AM.', 'appointments.php', 0, '2026-04-17 12:07:59'),
(111, 31, 'appointment', 'Booking Received', 'Request for 2026-05-01 at 10:00 AM is pending.', 'index.php', 0, '2026-04-17 12:07:59'),
(131, 4, 'appointment', 'New Appointment', 'New appointment for 2026-04-23 at 03:00 PM.', 'appointments.php', 0, '2026-04-20 10:45:36'),
(132, 32, 'appointment', 'Booking Received', 'Request for 2026-04-23 at 03:00 PM is pending.', 'index.php', 0, '2026-04-20 10:45:36'),
(134, 4, 'appointment', 'New Appointment', 'New appointment for 2026-04-20 at 02:00 PM.', 'appointments.php', 0, '2026-04-20 11:34:31'),
(135, 16, 'appointment', 'Booking Received', 'Request for 2026-04-20 at 02:00 PM is pending.', 'index.php', 0, '2026-04-20 11:34:31');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `method` enum('cash','card','online') DEFAULT 'cash',
  `status` enum('paid','pending','refunded') DEFAULT 'paid',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `appointment_id`, `client_id`, `amount`, `method`, `status`, `notes`, `created_at`) VALUES
(3, NULL, 16, 12000.00, 'cash', 'paid', NULL, '2026-04-10 04:00:03'),
(4, NULL, 14, 2000.00, 'card', 'paid', NULL, '2026-04-10 04:01:32'),
(7, NULL, 22, 4500.00, 'card', 'paid', NULL, '2026-04-17 11:30:56');

-- --------------------------------------------------------

--
-- Table structure for table `salon_settings`
--

CREATE TABLE `salon_settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salon_settings`
--

INSERT INTO `salon_settings` (`id`, `setting_key`, `setting_value`) VALUES
(1, 'salon_name', 'Elegance Luxury Salon'),
(2, 'contact_phone', '+92 300 1234567'),
(3, 'address', '123 Luxury Street, Karachi');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) DEFAULT 'General',
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `duration` int(11) DEFAULT 30,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `category`, `description`, `price`, `duration`, `status`) VALUES
(1, 'Signature Haircut', 'Hair Styling', 'Professional consultation, cut, and style.', 2500.00, 45, 'active'),
(3, 'Beard Grooming', 'Hair Styling', '', 1200.00, 30, 'active'),
(4, 'Balayage Hair Color', 'Hair Styling', '', 12000.00, 180, 'active'),
(5, 'Keratin Treatment', 'Hair Styling', 'Smoothing treatment for frizz-free hair.', 15000.00, 150, 'active'),
(6, 'Deep Conditioning', 'Hair Styling', '', 3500.00, 40, 'active'),
(7, 'Deep Cleanse Facial', 'Skin Care', 'Pore extraction and skin rejuvenation.', 5500.00, 60, 'active'),
(8, 'Gold Radiance Facial', 'Skin Care', 'Premium anti-aging treatment with 24K gold foil.', 8500.00, 90, 'active'),
(9, 'Charcoal Detox', 'Skin Care', 'Deep suction mask for oil and blackhead removal.', 3000.00, 45, 'active'),
(10, 'Luxury Manicure', 'Nails', 'Nail shaping, cuticle care, and hand massage.', 2000.00, 45, 'active'),
(11, 'Spa Pedicure', 'Nails', 'Foot soak, exfoliation, and polish.', 3000.00, 60, 'active'),
(12, 'Full Body Massage', 'Massage', 'Swedish relaxation massage.', 7000.00, 60, 'active'),
(20, 'Swedish Deep Tissue', 'Massage', 'A full-body therapeutic massage using firm pressure to release deep muscle tension.', 4500.00, 60, 'active'),
(21, 'Aromatic Hot Stone', 'Massage', 'Relaxing massage using heated volcanic stones to improve circulation and calm the mind.', 5500.00, 90, 'inactive'),
(22, 'Thai Herbal Compress', 'Massage', 'Authentic Thai stretching combined with a warm herbal poultice to relieve body aches.', 5000.00, 75, 'active'),
(23, 'Stress Buster (Back & Neck)', 'Massage', 'Targeted intensive massage focusing on the areas that carry the most daily stress.', 2500.00, 30, 'active'),
(24, 'Elegance Signature Manicure', 'Nails', 'Complete nail shaping, cuticle care, and hand massage with premium gel polish.', 2000.00, 45, 'active'),
(25, 'Luxury Spa Pedicure', 'Nails', 'Exfoliating foot scrub, callous removal, and hydrating mask with flawless polish.', 2800.00, 60, 'active'),
(26, 'Acrylic Nail Extensions', 'Nails', 'High-quality acrylic extensions for a durable, glamorous, and long-lasting look.', 4500.00, 90, 'active'),
(27, 'Hydra-Glow Facial', 'Skin Care', 'Deep cleansing and intense hydration treatment for a dewy, refreshed look.', 6500.00, 60, 'active'),
(28, 'Anti-Aging Collagen Peel', 'Skin Care', 'Advanced treatment to reduce fine lines and boost natural collagen production.', 8000.00, 75, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `contact_person`, `email`, `phone`, `address`) VALUES
(1, 'LOréal Official', 'Ahmed Raza', 'orders@loreal.com.pk', '021-3456789', 'Plot 42, Industrial Estate, Karachi'),
(2, 'Keune Pakistan', 'Sara Khan', 'sales@keune.com.pk', '0300-9876543', 'Office 12, Blue Area, Islamabad'),
(3, 'Professional Beauty Supplies', 'Zeeshan Ali', 'pbs@beauty.pk', '0321-5554433', 'Market Road, Lahore'),
(4, 'SkinCare Distributing', 'Mariam Noor', 'info@skincare.pk', '042-111222333', 'DHA Phase 5, Lahore'),
(5, 'Hygiene Pro', 'Bilal Sethi', 'bulk@hygienepro.com', '0333-1231231', 'S.I.T.E Area, Karachi'),
(11, 'Test', 'Subhan Shahid', 'subhanshahid.pk1@gmail.com', '0333-1231231', 'karachi,sindh,Pakistan');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','receptionist','stylist','client') DEFAULT 'client',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `gender` enum('male','female','other') DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `commission_rate` decimal(5,2) DEFAULT 0.00,
  `work_schedule` text DEFAULT NULL,
  `preferred_stylist_id` int(11) DEFAULT NULL,
  `preferences` text DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role`, `status`, `created_at`, `gender`, `dob`, `address`, `bio`, `commission_rate`, `work_schedule`, `preferred_stylist_id`, `preferences`, `notes`) VALUES
(2, 'Subhan Shahid', 'subhanshahid270@gmail.com', '03092146626', '$2y$10$ehEMTEtcH1JKr35iBTOi..okrOb9OZpYAlmqRUxPIBZbPl8f5F7X.', 'client', 'active', '2026-04-05 06:55:53', NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL),
(4, 'Nadia Siddiqui', 'stylist@elegance.pk', '0300-2222222', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'stylist', 'active', '2026-04-05 08:04:42', NULL, NULL, NULL, NULL, 5.00, '', NULL, NULL, NULL),
(5, 'sufyan khan', 'sufyankhan123@gmail.com', '03023134524', '$2y$10$J5WONXVqjyrzAW1E2viBQePVb0TwM4XDqA30YcUCPsRHd0MYpx5OG', 'client', 'active', '2026-04-06 11:03:49', NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL),
(14, 'Ahmed Shah', 'ahmed12@gmail.com', '03029698416', '$2y$10$D6xLNAAnm3FPGTO6lh22D..XcgI7a/IkbWM8CGyXSJ.LnfewQpkWu', 'client', 'active', '2026-04-07 11:46:59', 'male', '2000-02-22', NULL, NULL, 0.00, NULL, 4, 'need haircuts specialist', NULL),
(15, 'Subhan Shahid', 'subhanshahid1@gmail.com', '03092638416', '$2y$10$vnvRTUx11SBnkJ9WBFuOVexDL2.PsBmJ4kOdbNSHc0JQg/r8nqgOu', 'client', 'active', '2026-04-08 03:51:44', NULL, NULL, NULL, NULL, 0.00, NULL, NULL, NULL, NULL),
(16, 'Salman Ahmed', 'salman23@gmail.com', '03023446327', '$2y$10$3ctT32mDl72J2DhCikVVAetuzUFsuhDQJWWYUQCk2evlPg2DVZLZK', 'client', 'active', '2026-04-08 04:14:59', 'male', '2007-01-01', NULL, NULL, 0.00, NULL, NULL, '', NULL),
(17, 'Mohammad Amir Ali', 'amirali22@gmail.com', '03023134524', '$2y$10$YWfU215zfIpFbs44xs93DeY1b2iRIjKzucCktNsdekq.kwaiygP3i', 'client', 'active', '2026-04-09 05:13:21', 'male', '2009-02-02', NULL, NULL, 0.00, NULL, NULL, '', NULL),
(22, 'Ali Ahmed', 'aliahmed12@gmail.com', '03023134524', '$2y$10$bLC0sPgJ1jRWTU1pdw8.4uIvKwGM2/E7CUX9ryYabdXBZ1hHqSQLC', 'client', 'active', '2026-04-14 11:43:55', 'male', '2006-01-14', NULL, NULL, 0.00, NULL, NULL, '', NULL),
(31, 'Subhan Shahid', 'subhanshahid.k1@gmail.com', '03032638416', '$2y$10$3B0qHxm7USmng3Iy.WaG6ORxAQEcQ/kj3ZrlbCMd8KpzlVpPDrXe.', 'client', 'active', '2026-04-17 12:07:02', 'male', '2026-05-07', NULL, NULL, 0.00, NULL, NULL, NULL, NULL),
(32, 'ahmed', 'ahmedrah236@gmail.com', '03240424919', '$2y$10$i.lnxAq8ZjHFcW89XzY6qO8MVJ8pmHgMvuai4/4mPZKx6u.vWG622', 'client', 'active', '2026-04-20 10:44:33', 'male', '2009-10-07', NULL, NULL, 0.00, NULL, NULL, NULL, NULL),
(33, 'admin', 'admin@elegance.pk', '03092638416', '$2y$10$Le6SglD3xEOstflrJc8RD.m0hZ3FtuZpJ8of3pORYnF0sUaLiGrPq', 'admin', 'active', '2026-04-20 11:43:26', 'male', '2008-01-01', NULL, NULL, 0.00, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `stylist_id` (`stylist_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `commissions`
--
ALTER TABLE `commissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stylist_id` (`stylist_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `salon_settings`
--
ALTER TABLE `salon_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `commissions`
--
ALTER TABLE `commissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `salon_settings`
--
ALTER TABLE `salon_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`stylist_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `appointments_ibfk_3` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `commissions`
--
ALTER TABLE `commissions`
  ADD CONSTRAINT `commissions_ibfk_1` FOREIGN KEY (`stylist_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
