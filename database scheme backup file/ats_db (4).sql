-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2023 at 08:14 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ats_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `automated_schedule`
--

CREATE TABLE `automated_schedule` (
  `id` int(11) NOT NULL,
  `schedcode` varchar(10) NOT NULL,
  `teacher` varchar(255) NOT NULL,
  `subject_code` varchar(255) NOT NULL,
  `subject_description` varchar(255) NOT NULL,
  `subject_type` enum('Lec','Lab') DEFAULT NULL,
  `subject_units` int(11) NOT NULL,
  `subject_hours` double DEFAULT NULL,
  `section_name` varchar(50) DEFAULT NULL,
  `course_name` varchar(50) DEFAULT NULL,
  `section_year` varchar(255) DEFAULT NULL,
  `course_year_section` varchar(255) NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `day` varchar(10) DEFAULT NULL,
  `room_name` varchar(255) NOT NULL,
  `room_type` enum('lab','lec') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `available_days`
--

CREATE TABLE `available_days` (
  `id` int(11) NOT NULL,
  `day` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `available_days`
--

INSERT INTO `available_days` (`id`, `day`) VALUES
(16, 'Monday'),
(17, 'Tuesday'),
(18, 'Wednesday'),
(19, 'Thursday'),
(23, 'Friday');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_id` varchar(50) NOT NULL,
  `course_name` varchar(255) DEFAULT NULL,
  `slots` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_id`, `course_name`, `slots`) VALUES
(33, '2', 'BSCS', 200),
(34, '23', 'BSINFOTECH', 123);

-- --------------------------------------------------------

--
-- Table structure for table `faculty_loadings`
--

CREATE TABLE `faculty_loadings` (
  `id` int(11) NOT NULL,
  `schedcode` varchar(10) NOT NULL,
  `teacher` varchar(255) NOT NULL,
  `subject_code` varchar(255) NOT NULL,
  `subject_description` varchar(255) NOT NULL,
  `subject_type` enum('Lec','Lab') DEFAULT NULL,
  `subject_units` int(11) NOT NULL,
  `subject_hours` double DEFAULT NULL,
  `section_name` varchar(50) DEFAULT NULL,
  `course_name` varchar(50) DEFAULT NULL,
  `section_year` varchar(255) DEFAULT NULL,
  `course_year_section` varchar(255) NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `day` varchar(10) DEFAULT NULL,
  `room_name` varchar(255) NOT NULL,
  `room_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_loadings`
--

INSERT INTO `faculty_loadings` (`id`, `schedcode`, `teacher`, `subject_code`, `subject_description`, `subject_type`, `subject_units`, `subject_hours`, `section_name`, `course_name`, `section_year`, `course_year_section`, `start_time`, `end_time`, `day`, `room_name`, `room_type`) VALUES
(2, '20230001', 'Jenerry Abad', 'DCIT 26', 'App Development & Emerging Tech (LAB)', 'Lab', 1, 3, 'A', 'BSCS', '3rd', 'BSCS 301-A', '07:00:00', '10:00:00', 'Wednesday', 'DCS-3', 'Lec'),
(3, '20230002', 'Jenerry Abad', 'DCIT 26', 'App Development & Emerging Tech (LAB)', 'Lab', 1, 3, 'B', 'BSCS', '3rd', 'BSCS 301-B', '07:00:00', '10:00:00', 'Thursday', 'CCL-4', 'Lab'),
(4, '20230003', 'Jenerry Abad', 'DCIT 26', 'App Development & Emerging Tech (LEC)', 'Lec', 2, 2, 'A', 'BSCS', '2nd', 'BSCS 201-A', '07:00:00', '09:00:00', 'Monday', 'DCS-3', 'Lec'),
(5, '20230004', 'Jenerry Abad', 'DCIT 26', 'App Development & Emerging Tech (LEC)', 'Lec', 2, 2, 'B', 'BSCS', '2nd', 'BSCS 201-B', '07:00:00', '09:00:00', 'Friday', 'CCL-5', 'Lab'),
(6, '20230005', 'Jenerry Abad', 'DCIT 26', 'App Development & Emerging Tech (LAB)', 'Lab', 1, 3, 'A', 'BSCS', '4th', 'BSCS 401-A', '07:00:00', '10:00:00', 'Tuesday', 'DCS-5', 'Lec'),
(7, '20230006', 'Jenerry Abad', 'DCIT 26', 'App Development & Emerging Tech (LAB)', 'Lab', 1, 3, 'B', 'BSCS', '4th', 'BSCS 401-B', '09:00:00', '12:00:00', 'Monday', 'CCL-2', 'Lab'),
(8, '20230007', 'Renato Bautista', 'DCIT 23', 'Computer Programming II (LEC)', 'Lec', 1, 1, 'A', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-A', '07:00:00', '08:00:00', 'Thursday', 'DCS-1', 'Lec'),
(9, '20230008', 'Renato Bautista', 'DCIT 23', 'Computer Programming II (LEC)', 'Lec', 1, 1, 'B', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-B', '07:00:00', '08:00:00', 'Monday', 'DCS-7', 'Lec'),
(10, '20230009', 'Renato Bautista', 'DCIT 23', 'Computer Programming II (LEC)', 'Lec', 1, 1, 'C', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-C', '07:00:00', '08:00:00', 'Friday', 'DCS-3', 'Lec'),
(11, '20230010', 'Renato Bautista', 'DCIT 23', 'Computer Programming II (LEC)', 'Lec', 1, 1, 'D', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-D', '07:00:00', '08:00:00', 'Wednesday', 'CCL-7', 'Lab'),
(12, '20230011', 'Renato Bautista', 'DCIT 23', 'Computer Programming II (LEC)', 'Lec', 1, 1, 'E', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-E', '07:00:00', '08:00:00', 'Tuesday', 'CCL-7', 'Lab'),
(13, '20230012', 'Renato Bautista', 'DCIT 23', 'Computer Programming II (LAB)', 'Lab', 1, 3, 'A', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-A', '08:00:00', '11:00:00', 'Thursday', 'CCL-5', 'Lab'),
(14, '20230013', 'Renato Bautista', 'DCIT 23', 'Computer Programming II (LAB)', 'Lab', 1, 3, 'B', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-B', '08:00:00', '11:00:00', 'Wednesday', 'DCS-2', 'Lec'),
(15, '20230014', 'Renato Bautista', 'DCIT 23', 'Computer Programming II (LAB)', 'Lab', 1, 3, 'C', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-C', '08:00:00', '11:00:00', 'Friday', 'CCL-6', 'Lab'),
(16, '20230015', 'Renato Bautista', 'DCIT 23', 'Computer Programming II (LAB)', 'Lab', 1, 3, 'D', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-D', '08:00:00', '11:00:00', 'Tuesday', 'DCS-7', 'Lec'),
(17, '20230016', 'Renato Bautista', 'DCIT 23', 'Computer Programming II (LAB)', 'Lab', 1, 3, 'E', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-E', '08:00:00', '11:00:00', 'Monday', 'CCL-5', 'Lab'),
(18, '20230017', 'Axel Cabarles', 'COSC 65', 'Architecture and Organization (LEC)', 'Lec', 2, 2, 'A', 'BSCS', '2nd', 'BSCS 201-A', '07:00:00', '09:00:00', 'Wednesday', 'CCL-2', 'Lab'),
(19, '20230018', 'Axel Cabarles', 'COSC 65', 'Architecture and Organization (LEC)', 'Lec', 2, 2, 'B', 'BSCS', '2nd', 'BSCS 201-B', '07:00:00', '09:00:00', 'Tuesday', 'CCL-6', 'Lab'),
(20, '20230019', 'Axel Cabarles', 'ITEC 85', 'Information Assurance and Security (LAB)', 'Lab', 1, 3, 'A', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-A', '07:00:00', '10:00:00', 'Friday', 'DCS-5', 'Lec'),
(21, '20230020', 'Axel Cabarles', 'ITEC 85', 'Information Assurance and Security (LAB)', 'Lab', 1, 3, 'B', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-B', '07:00:00', '10:00:00', 'Thursday', 'CCL-6', 'Lab'),
(22, '20230021', 'Axel Cabarles', 'ITEC 85', 'Information Assurance and Security (LAB)', 'Lab', 1, 3, 'C', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-C', '07:00:00', '10:00:00', 'Monday', 'CCL-7', 'Lab'),
(23, '20230022', 'Axel Cabarles', 'ITEC 85', 'Information Assurance and Security (LAB)', 'Lab', 1, 3, 'D', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-D', '09:00:00', '12:00:00', 'Wednesday', 'CCL-3', 'Lab'),
(24, '20230023', 'Axel Cabarles', 'ITEC 85', 'Information Assurance and Security (LAB)', 'Lab', 1, 3, 'E', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-E', '09:00:00', '12:00:00', 'Tuesday', 'CCL-4', 'Lab'),
(25, '20230024', 'Princess Garvie Camingawan', 'ITEC 80', 'Introduction to Human Computer Interaction (LEC)', 'Lec', 2, 2, 'A', 'BSCS', '2nd', 'BSCS 201-A', '07:00:00', '09:00:00', 'Friday', 'CCL-7', 'Lab'),
(28, '20230025', 'Princess Garvie Camingawan', 'ITEC 80', 'Introduction to Human Computer Interaction (LEC)', 'Lec', 2, 2, 'B', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-B', '07:00:00', '09:00:00', 'Monday', 'CCL-1', 'Lab'),
(29, '20230026', 'Princess Garvie Camingawan', 'ITEC 80', 'Introduction to Human Computer Interaction (LEC)', 'Lec', 2, 2, 'C', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-C', '07:00:00', '09:00:00', 'Thursday', 'DCS-3', 'Lec'),
(30, '20230027', 'Princess Garvie Camingawan', 'ITEC 80', 'Introduction to Human Computer Interaction (LEC)', 'Lec', 2, 2, 'D', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-D', '07:00:00', '09:00:00', 'Wednesday', 'DCS-5', 'Lec'),
(31, '20230028', 'Princess Garvie Camingawan', 'ITEC 80', 'Introduction to Human Computer Interaction (LEC)', 'Lec', 2, 2, 'E', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-E', '07:00:00', '09:00:00', 'Tuesday', 'DCS-1', 'Lec'),
(32, '20230029', 'Princess Garvie Camingawan', 'ITEC 80', 'Introduction to Human Computer Interaction I (LAB)', 'Lab', 1, 3, 'A', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-A', '09:00:00', '12:00:00', 'Wednesday', 'CCL-5', 'Lab'),
(33, '20230030', 'Princess Garvie Camingawan', 'ITEC 80', 'Introduction to Human Computer Interaction I (LAB)', 'Lab', 1, 3, 'B', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-B', '09:00:00', '12:00:00', 'Monday', 'DCS4', 'Lec'),
(34, '20230031', 'Princess Garvie Camingawan', 'ITEC 80', 'Introduction to Human Computer Interaction I (LAB)', 'Lab', 1, 3, 'C', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-C', '09:00:00', '12:00:00', 'Thursday', 'DCS-1', 'Lec'),
(35, '20230032', 'Princess Garvie Camingawan', 'ITEC 80', 'Introduction to Human Computer Interaction I (LAB)', 'Lab', 1, 3, 'D', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-D', '09:00:00', '12:00:00', 'Friday', 'DCS-6', 'Lec'),
(36, '20230033', 'Princess Garvie Camingawan', 'ITEC 80', 'Introduction to Human Computer Interaction I (LAB)', 'Lab', 1, 3, 'E', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-E', '13:00:00', '16:00:00', 'Thursday', 'DCS4', 'Lec'),
(37, '20230034', 'Angela Clarito', 'ITEC 65', 'Open-Source Technologies (LEC)', 'Lec', 2, 2, 'A', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-A', '07:00:00', '09:00:00', 'Friday', 'CCL-1', 'Lab'),
(38, '20230035', 'Angela Clarito', 'ITEC 65', 'Open-Source Technologies (LEC)', 'Lec', 2, 2, 'B', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-B', '07:00:00', '09:00:00', 'Tuesday', 'CCL-4', 'Lab'),
(39, '20230036', 'Angela Clarito', 'ITEC 65', 'Open-Source Technologies (LEC)', 'Lec', 2, 2, 'C', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-C', '07:00:00', '09:00:00', 'Wednesday', 'CCL-4', 'Lab'),
(40, '20230037', 'Angela Clarito', 'ITEC 65', 'Open-Source Technologies (LEC)', 'Lec', 2, 2, 'D', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-D', '07:00:00', '09:00:00', 'Monday', 'CCL-2', 'Lab'),
(41, '20230038', 'Angela Clarito', 'ITEC 65', 'Open-Source Technologies (LEC)', 'Lec', 2, 2, 'E', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-E', '07:00:00', '09:00:00', 'Thursday', 'CCL-1', 'Lab'),
(42, '20230039', 'Angela Clarito', 'ITEC 85', 'Information Assurance and Security (LEC)', 'Lec', 2, 2, 'A', 'BSCS', '2nd', 'BSCS 201-A', '09:00:00', '11:00:00', 'Tuesday', 'CCL-2', 'Lab'),
(43, '20230040', 'Angela Clarito', 'ITEC 85', 'Information Assurance and Security (LEC)', 'Lec', 2, 2, 'B', 'BSCS', '2nd', 'BSCS 201-B', '09:00:00', '11:00:00', 'Thursday', 'CCL-7', 'Lab'),
(44, '20230041', 'Angela Clarito', 'ITEC 85', 'Information Assurance and Security (LAB)', 'Lab', 1, 3, 'A', 'BSCS', '3rd', 'BSCS 301-A', '09:00:00', '12:00:00', 'Monday', 'CCL-4', 'Lab'),
(45, '20230042', 'Angela Clarito', 'DCIT 24', 'Information Management (LAB)', 'Lab', 1, 3, 'B', 'BSCS', '3rd', 'BSCS 301-B', '09:00:00', '12:00:00', 'Friday', 'DCS-1', 'Lec'),
(46, '20230043', 'Janessa Marielle Cruz', 'DCIT 55', 'Advance Database System (LEC)', 'Lec', 2, 2, 'A', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-A', '07:00:00', '09:00:00', 'Tuesday', 'CCL-2', 'Lab'),
(47, '20230044', 'Janessa Marielle Cruz', 'DCIT 55', 'Advance Database System (LEC)', 'Lec', 2, 2, 'B', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-B', '07:00:00', '09:00:00', 'Friday', 'CCL-4', 'Lab'),
(48, '20230045', 'Janessa Marielle Cruz', 'DCIT 55', 'Advance Database System (LEC)', 'Lec', 2, 2, 'C', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-C', '07:00:00', '09:00:00', 'Wednesday', 'CCL-5', 'Lab'),
(49, '20230046', 'Janessa Marielle Cruz', 'DCIT 55', 'Advance Database System (LEC)', 'Lec', 2, 2, 'D', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-D', '07:00:00', '09:00:00', 'Monday', 'DCS-6', 'Lec'),
(50, '20230047', 'Janessa Marielle Cruz', 'DCIT 55', 'Advance Database System (LEC)', 'Lec', 2, 2, 'E', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-E', '07:00:00', '09:00:00', 'Thursday', 'DCS4', 'Lec'),
(51, '20230048', 'Janessa Marielle Cruz', 'DCIT 55', 'Advance Database System (LAB)', 'Lab', 1, 3, 'A', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-A', '09:00:00', '12:00:00', 'Monday', 'DCS-3', 'Lec'),
(52, '20230049', 'Janessa Marielle Cruz', 'DCIT 55', 'Advance Database System (LAB)', 'Lab', 1, 3, 'B', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-B', '09:00:00', '12:00:00', 'Tuesday', 'DCS4', 'Lec'),
(53, '20230050', 'Janessa Marielle Cruz', 'DCIT 55', 'Advance Database System (LAB)', 'Lab', 1, 3, 'C', 'BSCS', '3rd', 'BSCS 301-C', '09:00:00', '12:00:00', 'Thursday', 'CCL-2', 'Lab'),
(54, '20230051', 'Janessa Marielle Cruz', 'DCIT 55', 'Advance Database System (LAB)', 'Lab', 1, 3, 'D', 'BSCS', '3rd', 'BSCS 301-D', '09:00:00', '12:00:00', 'Friday', 'CCL-5', 'Lab'),
(55, '20230052', 'Janessa Marielle Cruz', 'DCIT 55', 'Advance Database System (LAB)', 'Lab', 1, 3, 'E', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-E', '09:00:00', '12:00:00', 'Wednesday', 'CCL-1', 'Lab'),
(56, '20230053', 'Mary Grace  Dela Cruz', 'COSC 90', 'Design Analysis of Algorithm (LEC)', 'Lec', 2, 2, 'A', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-A', '07:00:00', '09:00:00', 'Tuesday', 'DCS-6', 'Lec'),
(57, '20230054', 'Mary Grace  Dela Cruz', 'DCIT 25', 'Data Structures and Algorithm (LEC)', 'Lec', 2, 2, 'B', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-B', '07:00:00', '09:00:00', 'Friday', 'DCS-6', 'Lec'),
(58, '20230055', 'Mary Grace  Dela Cruz', 'DCIT 25', 'Data Structures and Algorithm (LEC)', 'Lec', 2, 2, 'C', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-C', '07:00:00', '09:00:00', 'Monday', 'CCL-4', 'Lab'),
(59, '20230056', 'Mary Grace  Dela Cruz', 'DCIT 25', 'Data Structures and Algorithm (LEC)', 'Lec', 2, 2, 'D', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-D', '07:00:00', '09:00:00', 'Thursday', 'DCS-2', 'Lec'),
(60, '20230057', 'Mary Grace  Dela Cruz', 'DCIT 25', 'Data Structures and Algorithm (LEC)', 'Lec', 2, 2, 'E', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-E', '07:00:00', '09:00:00', 'Wednesday', 'CCL-1', 'Lab'),
(61, '20230058', 'Mary Grace  Dela Cruz', 'COSC 90', 'Design Analysis of Algorithm (LEC)', 'Lec', 2, 2, 'A', 'BSCS', '2nd', 'BSCS 201-A', '09:00:00', '11:00:00', 'Thursday', 'DCS-3', 'Lec'),
(62, '20230059', 'Mary Grace  Dela Cruz', 'COSC 90', 'Design Analysis of Algorithm (LEC)', 'Lec', 2, 2, 'B', 'BSCS', '2nd', 'BSCS 201-B', '09:00:00', '11:00:00', 'Tuesday', 'CCL-6', 'Lab'),
(63, '20230060', 'Mary Grace  Dela Cruz', 'ITEC 60', 'Integrated Programming and Technologies I (LEC)', 'Lec', 2, 2, 'A', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-A', '09:00:00', '11:00:00', 'Monday', 'CCL-6', 'Lab'),
(64, '20230061', 'Mary Grace  Dela Cruz', 'ITEC 60', 'Integrated Programming and Technologies I (LEC)', 'Lec', 2, 2, 'B', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-B', '09:00:00', '11:00:00', 'Friday', 'DCS-2', 'Lec'),
(65, '20230062', 'Mary Grace  Dela Cruz', 'ITEC 60', 'Integrated Programming and Technologies I (LEC)', 'Lec', 2, 2, 'C', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-C', '09:00:00', '11:00:00', 'Wednesday', 'CCL-6', 'Lab'),
(66, '20230063', 'Mary Grace  Dela Cruz', 'ITEC 60', 'Integrated Programming and Technologies I (LEC)', 'Lec', 2, 2, 'D', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-D', '13:00:00', '15:00:00', 'Wednesday', 'CCL-3', 'Lab'),
(67, '20230064', 'Mary Grace  Dela Cruz', 'ITEC 60', 'Integrated Programming and Technologies I (LEC)', 'Lec', 2, 2, 'E', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-E', '13:00:00', '15:00:00', 'Monday', 'CCL-1', 'Lab'),
(68, '20230065', 'Renjie Driza', 'DCIT 50', 'Object Oriented Programing (LEC)', 'Lec', 2, 2, 'A', 'BSCS', '3rd', 'BSCS 301-A', '07:00:00', '09:00:00', 'Thursday', 'CCL-7', 'Lab'),
(69, '20230066', 'Renjie Driza', 'DCIT 50', 'Object Oriented Programing (LEC)', 'Lec', 2, 2, 'B', 'BSCS', '3rd', 'BSCS 301-B', '07:00:00', '09:00:00', 'Wednesday', 'DCS-6', 'Lec'),
(70, '20230067', 'Renjie Driza', 'DCIT 50', 'Object Oriented Programing (LAB)', 'Lab', 1, 3, 'A', 'BSCS', '3rd', 'BSCS 301-A', '07:00:00', '10:00:00', 'Tuesday', 'DCS-3', 'Lec'),
(71, '20230068', 'Renjie Driza', 'DCIT 50', 'Object Oriented Programing (LAB)', 'Lab', 1, 3, 'B', 'BSCS', '3rd', 'BSCS 301-B', '07:00:00', '10:00:00', 'Monday', 'DCS-5', 'Lec'),
(72, '20230069', 'Renjie Driza', 'DCIT 55', 'Advance Database System (LEC)', 'Lec', 2, 2, 'A', 'BSCS', '4th', 'BSCS 401-A', '07:00:00', '09:00:00', 'Friday', 'CCL-3', 'Lab'),
(73, '20230070', 'Renjie Driza', 'DCIT 55', 'Advance Database System (LEC)', 'Lec', 2, 2, 'B', 'BSCS', '4th', 'BSCS 401-B', '09:00:00', '11:00:00', 'Wednesday', 'CCL-7', 'Lab'),
(74, '20230071', 'Renjie Driza', 'DCIT 55', 'Advance Database System (LAB)', 'Lab', 1, 3, 'A', 'BSCS', '4th', 'BSCS 401-A', '09:00:00', '12:00:00', 'Friday', 'DCS-7', 'Lec'),
(75, '20230072', 'Renjie Driza', 'DCIT 55', 'Advance Database System (LAB)', 'Lab', 1, 3, 'B', 'BSCS', '4th', 'BSCS 401-B', '09:00:00', '12:00:00', 'Thursday', 'DCS-7', 'Lec'),
(76, '20230073', 'Christopher Estonilo', 'DCIT 60', 'Methods of Research', 'Lec', 3, 3, 'A', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-A', '09:00:00', '12:00:00', 'Tuesday', 'CCL-3', 'Lab'),
(77, '20230074', 'Christopher Estonilo', 'DCIT 60', 'Methods of Research', 'Lec', 3, 3, 'B', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-B', '09:00:00', '12:00:00', 'Friday', 'CCL-4', 'Lab'),
(78, '20230075', 'Christopher Estonilo', 'DCIT 60', 'Methods of Research', 'Lec', 3, 3, 'C', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-C', '09:00:00', '12:00:00', 'Wednesday', 'CCL-2', 'Lab'),
(79, '20230076', 'Christopher Estonilo', 'DCIT 60', 'Methods of Research', 'Lec', 3, 3, 'D', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-D', '07:00:00', '10:00:00', 'Thursday', 'DCS-6', 'Lec'),
(80, '20230077', 'Christopher Estonilo', 'DCIT 60', 'Methods of Research', 'Lec', 3, 3, 'E', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-E', '13:00:00', '16:00:00', 'Wednesday', 'CCL-4', 'Lab'),
(81, '20230078', 'Aries Gelera', 'INSY 55', 'System Analysis and Design (LAB)', 'Lab', 1, 3, 'A', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-A', '13:00:00', '16:00:00', 'Tuesday', 'DCS4', 'Lec'),
(82, '20230079', 'Aries Gelera', 'INSY 55', 'System Analysis and Design (LAB)', 'Lab', 1, 3, 'B', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-B', '13:00:00', '16:00:00', 'Friday', 'CCL-4', 'Lab'),
(83, '20230080', 'Aries Gelera', 'INSY 55', 'System Analysis and Design (LAB)', 'Lab', 1, 3, 'C', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-C', '07:00:00', '10:00:00', 'Tuesday', 'CCL-1', 'Lab'),
(85, '20230081', 'Marie Angelie Gerios', 'ITEC 90', 'Networks Fundamentals (LEC)', 'Lec', 2, 2, 'A', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-A', '07:00:00', '09:00:00', 'Wednesday', 'DCS4', 'Lec'),
(86, '20230082', 'Marie Angelie Gerios', 'ITEC 90', 'Networks Fundamentals (LEC)', 'Lec', 2, 2, 'B', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-B', '07:00:00', '09:00:00', 'Thursday', 'DCS-7', 'Lec'),
(87, '20230083', 'Marie Angelie Gerios', 'ITEC 90', 'Networks Fundamentals (LEC)', 'Lec', 2, 2, 'C', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-C', '07:00:00', '09:00:00', 'Tuesday', 'DCS4', 'Lec'),
(88, '20230084', 'Marie Angelie Gerios', 'ITEC 90', 'Networks Fundamentals (LEC)', 'Lec', 2, 2, 'D', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-D', '07:00:00', '09:00:00', 'Friday', 'CCL-2', 'Lab'),
(89, '20230085', 'Marie Angelie Gerios', 'ITEC 90', 'Networks Fundamentals (LEC)', 'Lec', 2, 2, 'E', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-E', '07:00:00', '09:00:00', 'Monday', 'DCS4', 'Lec'),
(90, '20230086', 'Marie Angelie Gerios', 'COSC 85', 'Networks and Communication (LEC)', 'Lec', 2, 2, 'A', 'BSCS', '2nd', 'BSCS 201-A', '09:00:00', '11:00:00', 'Wednesday', 'DCS-1', 'Lec'),
(91, '20230087', 'Marie Angelie Gerios', 'COSC 85', 'Networks and Communication (LEC)', 'Lec', 2, 2, 'B', 'BSCS', '2nd', 'BSCS 201-B', '09:00:00', '11:00:00', 'Monday', 'DCS-2', 'Lec'),
(92, '20230088', 'Girlie Meliante', 'COSC 70', 'Software Engineering I (LEC)', 'Lab', 3, 3, 'A', 'BSCS', '2nd', 'BSCS 201-A', '09:00:00', '12:00:00', 'Friday', 'DCS4', 'Lec'),
(93, '20230089', 'Girlie Meliante', 'COSC 70', 'Software Engineering I (LEC)', 'Lab', 3, 3, 'B', 'BSCS', '2nd', 'BSCS 201-B', '07:00:00', '10:00:00', 'Wednesday', 'DCS-7', 'Lec'),
(94, '20230090', 'Girlie Meliante', 'ITEC 50', 'Web System and Technologies II (LEC)', 'Lec', 2, 2, 'A', 'BSCS', '1st', 'BSCS 101-A', '07:00:00', '09:00:00', 'Tuesday', 'DCS-2', 'Lec'),
(95, '20230091', 'Girlie Meliante', 'ITEC 50', 'Web System and Technologies II (LEC)', 'Lec', 2, 2, 'B', 'BSCS', '1st', 'BSCS 101-B', '07:00:00', '09:00:00', 'Thursday', 'CCL-3', 'Lab'),
(96, '20230092', 'Girlie Meliante', 'ITEC 50', 'Web System and Technologies II (LEC)', 'Lec', 2, 2, 'C', 'BSCS', '2nd', 'BSCS 201-C', '07:00:00', '09:00:00', 'Friday', 'DCS4', 'Lec'),
(97, '20230093', 'Girlie Meliante', 'ITEC 50', 'Web System and Technologies II (LEC)', 'Lec', 2, 2, 'D', 'BSCS', '2nd', 'BSCS 201-D', '07:00:00', '09:00:00', 'Monday', 'CCL-3', 'Lab'),
(98, '20230094', 'Girlie Meliante', 'ITEC 50', 'Web System and Technologies II (LEC)', 'Lec', 2, 2, 'A', 'BSINFOTECH', '1st', 'BSINFOTECH 101-A', '09:00:00', '11:00:00', 'Monday', 'CCL-3', 'Lab'),
(99, '20230095', 'Girlie Meliante', 'ITEC 50', 'Web System and Technologies II (LEC)', 'Lec', 2, 2, 'B', 'BSINFOTECH', '1st', 'BSINFOTECH 101-B', '09:00:00', '11:00:00', 'Thursday', 'DCS-2', 'Lec'),
(100, '20230096', 'Girlie Meliante', 'ITEC 50', 'Web System and Technologies II (LEC)', 'Lec', 2, 2, 'C', 'BSINFOTECH', '1st', 'BSINFOTECH 101-C', '09:00:00', '11:00:00', 'Tuesday', 'DCS-1', 'Lec'),
(101, '20230097', 'Girlie Meliante', 'ITEC 50', 'Web System and Technologies II (LEC)', 'Lec', 2, 2, 'D', 'BSINFOTECH', '1st', 'BSINFOTECH 101-D', '10:00:00', '12:00:00', 'Wednesday', 'DCS-5', 'Lec'),
(102, '20230098', 'Girlie Meliante', 'ITEC 50', 'Web System and Technologies II (LEC)', 'Lec', 2, 2, 'E', 'BSINFOTECH', '1st', 'BSINFOTECH 101-E', '13:00:00', '15:00:00', 'Friday', 'DCS-7', 'Lec'),
(103, '20230099', 'Girlie Meliante', 'INSY 55', 'System Analysis and Design (LEC)', 'Lec', 2, 2, 'A', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-A', '13:00:00', '15:00:00', 'Monday', 'DCS-6', 'Lec'),
(104, '20230100', 'Girlie Meliante', 'INSY 55', 'System Analysis and Design (LEC)', 'Lec', 2, 2, 'B', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-B', '13:00:00', '15:00:00', 'Tuesday', 'DCS-1', 'Lec'),
(105, '20230101', 'Girlie Meliante', 'INSY 55', 'System Analysis and Design (LEC)', 'Lec', 2, 2, 'C', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-C', '13:00:00', '15:00:00', 'Wednesday', 'DCS-5', 'Lec'),
(106, '20230102', 'Girlie Meliante', 'INSY 55', 'System Analysis and Design (LEC)', 'Lec', 2, 2, 'D', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-D', '13:00:00', '15:00:00', 'Thursday', 'CCL-4', 'Lab'),
(107, '20230103', 'Girlie Meliante', 'INSY 55', 'System Analysis and Design (LEC)', 'Lec', 2, 2, 'E', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-E', '15:00:00', '17:00:00', 'Tuesday', 'DCS-1', 'Lec'),
(108, '20230104', 'EJ Muyot', 'COSC 106 ', 'Introduction to Game Development (LEC)', 'Lec', 2, 2, 'A', 'BSCS', '4th', 'BSCS 401-A', '07:00:00', '09:00:00', 'Thursday', 'CCL-2', 'Lab'),
(109, '20230105', 'EJ Muyot', 'COSC 106 ', 'Introduction to Game Development (LEC)', 'Lec', 2, 2, 'B', 'BSCS', '4th', 'BSCS 401-B', '07:00:00', '09:00:00', 'Wednesday', 'CCL-3', 'Lab'),
(110, '20230106', 'EJ Muyot', 'COSC 106 ', 'Introduction to Game Development (LAB)', 'Lab', 1, 3, 'A', 'BSCS', '4th', 'BSCS 401-A', '07:00:00', '10:00:00', 'Monday', 'DCS-1', 'Lec'),
(111, '20230107', 'EJ Muyot', 'COSC 106 ', 'Introduction to Game Development (LAB)', 'Lab', 1, 3, 'B', 'BSCS', '4th', 'BSCS 401-B', '07:00:00', '10:00:00', 'Tuesday', 'CCL-5', 'Lab'),
(112, '20230108', 'Karlo Jose Nabablit', 'DCIT 23', 'Computer Programming II (LEC)', 'Lec', 1, 1, 'A', 'BSCS', '3rd', 'BSCS 301-A', '07:00:00', '08:00:00', 'Friday', 'DCS-7', 'Lec'),
(113, '20230109', 'Karlo Jose Nabablit', 'DCIT 23', 'Computer Programming II (LEC)', 'Lec', 1, 1, 'B', 'BSCS', '3rd', 'BSCS 301-B', '07:00:00', '08:00:00', 'Tuesday', 'CCL-3', 'Lab'),
(114, '20230110', 'Karlo Jose Nabablit', 'COSC 200A', 'Undergraduate Thesis 1', 'Lec', 3, 3, 'A', 'BSCS', '4th', 'BSCS 401-A', '09:00:00', '12:00:00', 'Thursday', 'DCS-5', 'Lec'),
(115, '20230111', 'Karlo Jose Nabablit', 'COSC 200A', 'Undergraduate Thesis 1', 'Lec', 3, 3, 'B', 'BSCS', '4th', 'BSCS 401-B', '08:00:00', '11:00:00', 'Friday', 'DCS-3', 'Lec'),
(116, '20230112', 'Mark Edriane Nolledo', 'COSC 65', 'Architecture and Organization (LAB)', 'Lab', 1, 3, 'A', 'BSCS', '3rd', 'BSCS 301-A', '09:00:00', '12:00:00', 'Friday', 'CCL-2', 'Lab'),
(117, '20230113', 'Mark Edriane Nolledo', 'COSC 65', 'Architecture and Organization (LAB)', 'Lab', 1, 3, 'B', 'BSCS', '3rd', 'BSCS 301-B', '08:00:00', '11:00:00', 'Tuesday', 'CCL-7', 'Lab'),
(118, '20230114', 'Mark Edriane Nolledo', 'COSC 65', 'Architecture and Organization (LAB)', 'Lab', 1, 3, 'A', 'BSCS', '4th', 'BSCS 401-A', '09:00:00', '12:00:00', 'Wednesday', 'CCL-4', 'Lab'),
(119, '20230115', 'Karlo Jose Nabablit', 'COSC 65', 'Architecture and Organization (LAB)', 'Lab', 1, 3, 'B', 'BSCS', '4th', 'BSCS 401-B', '13:00:00', '16:00:00', 'Tuesday', 'DCS-5', 'Lec'),
(120, '20230116', 'Ana Marie Obon', 'DCIT 25', 'Data Structures and Algorithm (LEC)', 'Lec', 2, 2, 'A', 'BSCS', '3rd', 'BSCS 301-A', '07:00:00', '09:00:00', 'Monday', 'CCL-6', 'Lab'),
(121, '20230117', 'Ana Marie Obon', 'DCIT 25', 'Data Structures and Algorithm (LEC)', 'Lec', 2, 2, 'B', 'BSCS', '3rd', 'BSCS 301-B', '07:00:00', '09:00:00', 'Friday', 'DCS-1', 'Lec'),
(122, '20230118', 'Ana Marie Obon', 'DCIT 25', 'Data Structures and Algorithm (LAB)', 'Lab', 1, 3, 'A', 'BSCS', '3rd', 'BSCS 301-A', '09:00:00', '12:00:00', 'Thursday', 'CCL-3', 'Lab'),
(123, '20230119', 'Ana Marie Obon', 'DCIT 25', 'Data Structures and Algorithm (LAB)', 'Lab', 1, 3, 'B', 'BSCS', '3rd', 'BSCS 301-B', '09:00:00', '12:00:00', 'Wednesday', 'DCS4', 'Lec'),
(124, '20230120', 'Chrisa Mae Turla', 'ITECT 75', 'System Integration and Architecture (LAB)', 'Lab', 1, 3, 'A', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-A', '13:00:00', '16:00:00', 'Monday', 'CCL-4', 'Lab'),
(125, '20230121', 'Chrisa Mae Turla', 'ITECT 75', 'System Integration and Architecture (LAB)', 'Lab', 1, 3, 'B', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-B', '13:00:00', '16:00:00', 'Thursday', 'DCS-3', 'Lec'),
(126, '20230122', 'Chrisa Mae Turla', 'ITECT 75', 'System Integration and Architecture (LAB)', 'Lab', 1, 3, 'C', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-C', '13:00:00', '16:00:00', 'Friday', 'CCL-1', 'Lab'),
(127, '20230123', 'Chrisa Mae Turla', 'ITECT 75', 'System Integration and Architecture (LAB)', 'Lab', 1, 3, 'D', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-D', '09:00:00', '12:00:00', 'Monday', 'DCS-6', 'Lec'),
(128, '20230124', 'Chrisa Mae Turla', 'ITECT 75', 'System Integration and Architecture (LAB)', 'Lab', 1, 3, 'E', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-E', '09:00:00', '12:00:00', 'Friday', 'CCL-7', 'Lab'),
(129, '20230125', 'Chrisa Mae Turla', 'ITEC 75', 'System Integration and Architecture (LEC)', 'Lec', 2, 2, 'A', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-A', '07:00:00', '09:00:00', 'Monday', 'DCS-2', 'Lec'),
(130, '20230126', 'Chrisa Mae Turla', 'ITEC 75', 'System Integration and Architecture (LEC)', 'Lec', 2, 2, 'B', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-B', '07:00:00', '09:00:00', 'Wednesday', 'CCL-6', 'Lab'),
(131, '20230127', 'Chrisa Mae Turla', 'ITEC 75', 'System Integration and Architecture (LEC)', 'Lec', 2, 2, 'C', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-C', '07:00:00', '09:00:00', 'Friday', 'DCS-2', 'Lec'),
(132, '20230128', 'Chrisa Mae Turla', 'ITEC 75', 'System Integration and Architecture (LEC)', 'Lec', 2, 2, 'D', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-D', '09:00:00', '11:00:00', 'Thursday', 'CCL-1', 'Lab'),
(133, '20230129', 'Chrisa Mae Turla', 'ITEC 75', 'System Integration and Architecture (LEC)', 'Lec', 2, 2, 'E', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-E', '09:00:00', '11:00:00', 'Tuesday', 'DCS-2', 'Lec'),
(134, '20230130', 'Lester  Villanueva', 'ITEC 90', 'Networks Fundamentals (LAB)', 'Lab', 1, 3, 'A', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-A', '13:00:00', '16:00:00', 'Thursday', 'CCL-1', 'Lab'),
(135, '20230131', 'Lester  Villanueva', 'ITEC 90', 'Networks Fundamentals (LAB)', 'Lab', 1, 3, 'B', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-B', '13:00:00', '16:00:00', 'Wednesday', 'DCS-7', 'Lec'),
(136, '20230132', 'Lester  Villanueva', 'ITEC 90', 'Networks Fundamentals (LAB)', 'Lab', 1, 3, 'C', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-C', '13:00:00', '16:00:00', 'Tuesday', 'DCS-6', 'Lec'),
(137, '20230133', 'Lester  Villanueva', 'ITEC 90', 'Networks Fundamentals (LAB)', 'Lab', 1, 3, 'D', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-D', '13:00:00', '16:00:00', 'Friday', 'DCS-3', 'Lec'),
(138, '20230134', 'Lester  Villanueva', 'ITEC 90', 'Networks Fundamentals (LAB)', 'Lab', 1, 3, 'E', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-E', '09:00:00', '12:00:00', 'Thursday', 'DCS4', 'Lec'),
(139, '20230135', 'Lester  Villanueva', 'COSC 80', 'Operating System (LAB)', 'Lab', 1, 3, 'A', 'BSCS', '4th', 'BSCS 401-A', '13:00:00', '16:00:00', 'Monday', 'DCS-7', 'Lec');

--
-- Triggers `faculty_loadings`
--
DELIMITER $$
CREATE TRIGGER `tr_generate_schedcode` BEFORE INSERT ON `faculty_loadings` FOR EACH ROW BEGIN
    DECLARE new_schedcode INT(255);
    SELECT IFNULL(SUBSTRING(MAX(schedcode), 5), 0) + 1 INTO new_schedcode FROM faculty_loadings WHERE schedcode LIKE '2023%';
    SET NEW.schedcode = CONCAT('2023', LPAD(new_schedcode, 4, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `faculty_loadings_testing`
--

CREATE TABLE `faculty_loadings_testing` (
  `id` int(11) NOT NULL DEFAULT 0,
  `schedcode` varchar(10) NOT NULL,
  `teacher` varchar(255) NOT NULL,
  `subject_code` varchar(255) NOT NULL,
  `subject_description` varchar(255) NOT NULL,
  `subject_type` enum('Lec','Lab') DEFAULT NULL,
  `subject_units` int(11) NOT NULL,
  `subject_hours` double DEFAULT NULL,
  `section_name` varchar(50) DEFAULT NULL,
  `course_name` varchar(50) DEFAULT NULL,
  `section_year` varchar(255) DEFAULT NULL,
  `course_year_section` varchar(255) NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `day` varchar(10) DEFAULT NULL,
  `room_name` varchar(255) NOT NULL,
  `room_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_loadings_testing`
--

INSERT INTO `faculty_loadings_testing` (`id`, `schedcode`, `teacher`, `subject_code`, `subject_description`, `subject_type`, `subject_units`, `subject_hours`, `section_name`, `course_name`, `section_year`, `course_year_section`, `start_time`, `end_time`, `day`, `room_name`, `room_type`) VALUES
(2, '20230001', 'Jenerry Abad', 'DCIT 26', 'App Development & Emerging Tech (LAB)', 'Lab', 1, 3, 'A', 'BSCS', '3rd', 'BSCS 301-A', '07:00:00', '10:00:00', 'Wednesday', 'DCS-3', 'Lec'),
(3, '20230002', 'Jenerry Abad', 'DCIT 26', 'App Development & Emerging Tech (LAB)', 'Lab', 1, 3, 'B', 'BSCS', '3rd', 'BSCS 301-B', '07:00:00', '10:00:00', 'Thursday', 'CCL-4', 'Lab'),
(4, '20230003', 'Jenerry Abad', 'DCIT 26', 'App Development & Emerging Tech (LEC)', 'Lec', 2, 2, 'A', 'BSCS', '2nd', 'BSCS 201-A', '07:00:00', '09:00:00', 'Monday', 'DCS-3', 'Lec'),
(5, '20230004', 'Jenerry Abad', 'DCIT 26', 'App Development & Emerging Tech (LEC)', 'Lec', 2, 2, 'B', 'BSCS', '2nd', 'BSCS 201-B', '07:00:00', '09:00:00', 'Friday', 'CCL-5', 'Lab'),
(6, '20230005', 'Jenerry Abad', 'DCIT 26', 'App Development & Emerging Tech (LAB)', 'Lab', 1, 3, 'A', 'BSCS', '4th', 'BSCS 401-A', '07:00:00', '10:00:00', 'Tuesday', 'DCS-5', 'Lec'),
(7, '20230006', 'Jenerry Abad', 'DCIT 26', 'App Development & Emerging Tech (LAB)', 'Lab', 1, 3, 'B', 'BSCS', '4th', 'BSCS 401-B', '09:00:00', '12:00:00', 'Monday', 'CCL-2', 'Lab'),
(8, '20230007', 'Renato Bautista', 'DCIT 23', 'Computer Programming II (LEC)', 'Lec', 1, 1, 'A', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-A', '07:00:00', '08:00:00', 'Thursday', 'DCS-1', 'Lec'),
(9, '20230008', 'Renato Bautista', 'DCIT 23', 'Computer Programming II (LEC)', 'Lec', 1, 1, 'B', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-B', '07:00:00', '08:00:00', 'Monday', 'DCS-7', 'Lec'),
(10, '20230009', 'Renato Bautista', 'DCIT 23', 'Computer Programming II (LEC)', 'Lec', 1, 1, 'C', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-C', '07:00:00', '08:00:00', 'Friday', 'DCS-3', 'Lec'),
(11, '20230010', 'Renato Bautista', 'DCIT 23', 'Computer Programming II (LEC)', 'Lec', 1, 1, 'D', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-D', '07:00:00', '08:00:00', 'Wednesday', 'CCL-7', 'Lab'),
(12, '20230011', 'Renato Bautista', 'DCIT 23', 'Computer Programming II (LEC)', 'Lec', 1, 1, 'E', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-E', '07:00:00', '08:00:00', 'Tuesday', 'CCL-7', 'Lab'),
(13, '20230012', 'Renato Bautista', 'DCIT 23', 'Computer Programming II (LAB)', 'Lab', 1, 3, 'A', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-A', '08:00:00', '11:00:00', 'Thursday', 'CCL-5', 'Lab'),
(14, '20230013', 'Renato Bautista', 'DCIT 23', 'Computer Programming II (LAB)', 'Lab', 1, 3, 'B', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-B', '08:00:00', '11:00:00', 'Wednesday', 'DCS-2', 'Lec'),
(15, '20230014', 'Renato Bautista', 'DCIT 23', 'Computer Programming II (LAB)', 'Lab', 1, 3, 'C', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-C', '08:00:00', '11:00:00', 'Friday', 'CCL-6', 'Lab'),
(16, '20230015', 'Renato Bautista', 'DCIT 23', 'Computer Programming II (LAB)', 'Lab', 1, 3, 'D', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-D', '08:00:00', '11:00:00', 'Tuesday', 'DCS-7', 'Lec'),
(17, '20230016', 'Renato Bautista', 'DCIT 23', 'Computer Programming II (LAB)', 'Lab', 1, 3, 'E', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-E', '08:00:00', '11:00:00', 'Monday', 'CCL-5', 'Lab'),
(18, '20230017', 'Axel Cabarles', 'COSC 65', 'Architecture and Organization (LEC)', 'Lec', 2, 2, 'A', 'BSCS', '2nd', 'BSCS 201-A', '07:00:00', '09:00:00', 'Wednesday', 'CCL-2', 'Lab'),
(19, '20230018', 'Axel Cabarles', 'COSC 65', 'Architecture and Organization (LEC)', 'Lec', 2, 2, 'B', 'BSCS', '2nd', 'BSCS 201-B', '07:00:00', '09:00:00', 'Tuesday', 'CCL-6', 'Lab'),
(20, '20230019', 'Axel Cabarles', 'ITEC 85', 'Information Assurance and Security (LAB)', 'Lab', 1, 3, 'A', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-A', '07:00:00', '10:00:00', 'Friday', 'DCS-5', 'Lec'),
(21, '20230020', 'Axel Cabarles', 'ITEC 85', 'Information Assurance and Security (LAB)', 'Lab', 1, 3, 'B', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-B', '07:00:00', '10:00:00', 'Thursday', 'CCL-6', 'Lab'),
(22, '20230021', 'Axel Cabarles', 'ITEC 85', 'Information Assurance and Security (LAB)', 'Lab', 1, 3, 'C', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-C', '07:00:00', '10:00:00', 'Monday', 'CCL-7', 'Lab'),
(23, '20230022', 'Axel Cabarles', 'ITEC 85', 'Information Assurance and Security (LAB)', 'Lab', 1, 3, 'D', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-D', '09:00:00', '12:00:00', 'Wednesday', 'CCL-3', 'Lab'),
(24, '20230023', 'Axel Cabarles', 'ITEC 85', 'Information Assurance and Security (LAB)', 'Lab', 1, 3, 'E', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-E', '09:00:00', '12:00:00', 'Tuesday', 'CCL-4', 'Lab'),
(25, '20230024', 'Princess Garvie Camingawan', 'ITEC 80', 'Introduction to Human Computer Interaction (LEC)', 'Lec', 2, 2, 'A', 'BSCS', '2nd', 'BSCS 201-A', '07:00:00', '09:00:00', 'Friday', 'CCL-7', 'Lab'),
(28, '20230025', 'Princess Garvie Camingawan', 'ITEC 80', 'Introduction to Human Computer Interaction (LEC)', 'Lec', 2, 2, 'B', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-B', '07:00:00', '09:00:00', 'Monday', 'CCL-1', 'Lab'),
(29, '20230026', 'Princess Garvie Camingawan', 'ITEC 80', 'Introduction to Human Computer Interaction (LEC)', 'Lec', 2, 2, 'C', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-C', '07:00:00', '09:00:00', 'Thursday', 'DCS-3', 'Lec'),
(30, '20230027', 'Princess Garvie Camingawan', 'ITEC 80', 'Introduction to Human Computer Interaction (LEC)', 'Lec', 2, 2, 'D', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-D', '07:00:00', '09:00:00', 'Wednesday', 'DCS-5', 'Lec'),
(31, '20230028', 'Princess Garvie Camingawan', 'ITEC 80', 'Introduction to Human Computer Interaction (LEC)', 'Lec', 2, 2, 'E', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-E', '07:00:00', '09:00:00', 'Tuesday', 'DCS-1', 'Lec'),
(32, '20230029', 'Princess Garvie Camingawan', 'ITEC 80', 'Introduction to Human Computer Interaction I (LAB)', 'Lab', 1, 3, 'A', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-A', '09:00:00', '12:00:00', 'Wednesday', 'CCL-5', 'Lab'),
(33, '20230030', 'Princess Garvie Camingawan', 'ITEC 80', 'Introduction to Human Computer Interaction I (LAB)', 'Lab', 1, 3, 'B', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-B', '09:00:00', '12:00:00', 'Monday', 'DCS4', 'Lec'),
(34, '20230031', 'Princess Garvie Camingawan', 'ITEC 80', 'Introduction to Human Computer Interaction I (LAB)', 'Lab', 1, 3, 'C', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-C', '09:00:00', '12:00:00', 'Thursday', 'DCS-1', 'Lec'),
(35, '20230032', 'Princess Garvie Camingawan', 'ITEC 80', 'Introduction to Human Computer Interaction I (LAB)', 'Lab', 1, 3, 'D', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-D', '09:00:00', '12:00:00', 'Friday', 'DCS-6', 'Lec'),
(36, '20230033', 'Princess Garvie Camingawan', 'ITEC 80', 'Introduction to Human Computer Interaction I (LAB)', 'Lab', 1, 3, 'E', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-E', '13:00:00', '16:00:00', 'Thursday', 'DCS4', 'Lec'),
(37, '20230034', 'Angela Clarito', 'ITEC 65', 'Open-Source Technologies (LEC)', 'Lec', 2, 2, 'A', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-A', '07:00:00', '09:00:00', 'Friday', 'CCL-1', 'Lab'),
(38, '20230035', 'Angela Clarito', 'ITEC 65', 'Open-Source Technologies (LEC)', 'Lec', 2, 2, 'B', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-B', '07:00:00', '09:00:00', 'Tuesday', 'CCL-4', 'Lab'),
(39, '20230036', 'Angela Clarito', 'ITEC 65', 'Open-Source Technologies (LEC)', 'Lec', 2, 2, 'C', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-C', '07:00:00', '09:00:00', 'Wednesday', 'CCL-4', 'Lab'),
(40, '20230037', 'Angela Clarito', 'ITEC 65', 'Open-Source Technologies (LEC)', 'Lec', 2, 2, 'D', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-D', '07:00:00', '09:00:00', 'Monday', 'CCL-2', 'Lab'),
(41, '20230038', 'Angela Clarito', 'ITEC 65', 'Open-Source Technologies (LEC)', 'Lec', 2, 2, 'E', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-E', '07:00:00', '09:00:00', 'Thursday', 'CCL-1', 'Lab'),
(42, '20230039', 'Angela Clarito', 'ITEC 85', 'Information Assurance and Security (LEC)', 'Lec', 2, 2, 'A', 'BSCS', '2nd', 'BSCS 201-A', '09:00:00', '11:00:00', 'Tuesday', 'CCL-2', 'Lab'),
(43, '20230040', 'Angela Clarito', 'ITEC 85', 'Information Assurance and Security (LEC)', 'Lec', 2, 2, 'B', 'BSCS', '2nd', 'BSCS 201-B', '09:00:00', '11:00:00', 'Thursday', 'CCL-7', 'Lab'),
(44, '20230041', 'Angela Clarito', 'ITEC 85', 'Information Assurance and Security (LAB)', 'Lab', 1, 3, 'A', 'BSCS', '3rd', 'BSCS 301-A', '09:00:00', '12:00:00', 'Monday', 'CCL-4', 'Lab'),
(45, '20230042', 'Angela Clarito', 'DCIT 24', 'Information Management (LAB)', 'Lab', 1, 3, 'B', 'BSCS', '3rd', 'BSCS 301-B', '09:00:00', '12:00:00', 'Friday', 'DCS-1', 'Lec'),
(46, '20230043', 'Janessa Marielle Cruz', 'DCIT 55', 'Advance Database System (LEC)', 'Lec', 2, 2, 'A', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-A', '07:00:00', '09:00:00', 'Tuesday', 'CCL-2', 'Lab'),
(47, '20230044', 'Janessa Marielle Cruz', 'DCIT 55', 'Advance Database System (LEC)', 'Lec', 2, 2, 'B', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-B', '07:00:00', '09:00:00', 'Friday', 'CCL-4', 'Lab'),
(48, '20230045', 'Janessa Marielle Cruz', 'DCIT 55', 'Advance Database System (LEC)', 'Lec', 2, 2, 'C', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-C', '07:00:00', '09:00:00', 'Wednesday', 'CCL-5', 'Lab'),
(49, '20230046', 'Janessa Marielle Cruz', 'DCIT 55', 'Advance Database System (LEC)', 'Lec', 2, 2, 'D', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-D', '07:00:00', '09:00:00', 'Monday', 'DCS-6', 'Lec'),
(50, '20230047', 'Janessa Marielle Cruz', 'DCIT 55', 'Advance Database System (LEC)', 'Lec', 2, 2, 'E', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-E', '07:00:00', '09:00:00', 'Thursday', 'DCS4', 'Lec'),
(51, '20230048', 'Janessa Marielle Cruz', 'DCIT 55', 'Advance Database System (LAB)', 'Lab', 1, 3, 'A', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-A', '09:00:00', '12:00:00', 'Monday', 'DCS-3', 'Lec'),
(52, '20230049', 'Janessa Marielle Cruz', 'DCIT 55', 'Advance Database System (LAB)', 'Lab', 1, 3, 'B', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-B', '09:00:00', '12:00:00', 'Tuesday', 'DCS4', 'Lec'),
(53, '20230050', 'Janessa Marielle Cruz', 'DCIT 55', 'Advance Database System (LAB)', 'Lab', 1, 3, 'C', 'BSCS', '3rd', 'BSCS 301-C', '09:00:00', '12:00:00', 'Thursday', 'CCL-2', 'Lab'),
(54, '20230051', 'Janessa Marielle Cruz', 'DCIT 55', 'Advance Database System (LAB)', 'Lab', 1, 3, 'D', 'BSCS', '3rd', 'BSCS 301-D', '09:00:00', '12:00:00', 'Friday', 'CCL-5', 'Lab'),
(55, '20230052', 'Janessa Marielle Cruz', 'DCIT 55', 'Advance Database System (LAB)', 'Lab', 1, 3, 'E', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-E', '09:00:00', '12:00:00', 'Wednesday', 'CCL-1', 'Lab'),
(56, '20230053', 'Mary Grace  Dela Cruz', 'COSC 90', 'Design Analysis of Algorithm (LEC)', 'Lec', 2, 2, 'A', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-A', '07:00:00', '09:00:00', 'Tuesday', 'DCS-6', 'Lec'),
(57, '20230054', 'Mary Grace  Dela Cruz', 'DCIT 25', 'Data Structures and Algorithm (LEC)', 'Lec', 2, 2, 'B', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-B', '07:00:00', '09:00:00', 'Friday', 'DCS-6', 'Lec'),
(58, '20230055', 'Mary Grace  Dela Cruz', 'DCIT 25', 'Data Structures and Algorithm (LEC)', 'Lec', 2, 2, 'C', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-C', '07:00:00', '09:00:00', 'Monday', 'CCL-4', 'Lab'),
(59, '20230056', 'Mary Grace  Dela Cruz', 'DCIT 25', 'Data Structures and Algorithm (LEC)', 'Lec', 2, 2, 'D', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-D', '07:00:00', '09:00:00', 'Thursday', 'DCS-2', 'Lec'),
(60, '20230057', 'Mary Grace  Dela Cruz', 'DCIT 25', 'Data Structures and Algorithm (LEC)', 'Lec', 2, 2, 'E', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-E', '07:00:00', '09:00:00', 'Wednesday', 'CCL-1', 'Lab'),
(61, '20230058', 'Mary Grace  Dela Cruz', 'COSC 90', 'Design Analysis of Algorithm (LEC)', 'Lec', 2, 2, 'A', 'BSCS', '2nd', 'BSCS 201-A', '09:00:00', '11:00:00', 'Thursday', 'DCS-3', 'Lec'),
(62, '20230059', 'Mary Grace  Dela Cruz', 'COSC 90', 'Design Analysis of Algorithm (LEC)', 'Lec', 2, 2, 'B', 'BSCS', '2nd', 'BSCS 201-B', '09:00:00', '11:00:00', 'Tuesday', 'CCL-6', 'Lab'),
(63, '20230060', 'Mary Grace  Dela Cruz', 'ITEC 60', 'Integrated Programming and Technologies I (LEC)', 'Lec', 2, 2, 'A', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-A', '09:00:00', '11:00:00', 'Monday', 'CCL-6', 'Lab'),
(64, '20230061', 'Mary Grace  Dela Cruz', 'ITEC 60', 'Integrated Programming and Technologies I (LEC)', 'Lec', 2, 2, 'B', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-B', '09:00:00', '11:00:00', 'Friday', 'DCS-2', 'Lec'),
(65, '20230062', 'Mary Grace  Dela Cruz', 'ITEC 60', 'Integrated Programming and Technologies I (LEC)', 'Lec', 2, 2, 'C', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-C', '09:00:00', '11:00:00', 'Wednesday', 'CCL-6', 'Lab'),
(66, '20230063', 'Mary Grace  Dela Cruz', 'ITEC 60', 'Integrated Programming and Technologies I (LEC)', 'Lec', 2, 2, 'D', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-D', '13:00:00', '15:00:00', 'Wednesday', 'CCL-3', 'Lab'),
(67, '20230064', 'Mary Grace  Dela Cruz', 'ITEC 60', 'Integrated Programming and Technologies I (LEC)', 'Lec', 2, 2, 'E', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-E', '13:00:00', '15:00:00', 'Monday', 'CCL-1', 'Lab'),
(68, '20230065', 'Renjie Driza', 'DCIT 50', 'Object Oriented Programing (LEC)', 'Lec', 2, 2, 'A', 'BSCS', '3rd', 'BSCS 301-A', '07:00:00', '09:00:00', 'Thursday', 'CCL-7', 'Lab'),
(69, '20230066', 'Renjie Driza', 'DCIT 50', 'Object Oriented Programing (LEC)', 'Lec', 2, 2, 'B', 'BSCS', '3rd', 'BSCS 301-B', '07:00:00', '09:00:00', 'Wednesday', 'DCS-6', 'Lec'),
(70, '20230067', 'Renjie Driza', 'DCIT 50', 'Object Oriented Programing (LAB)', 'Lab', 1, 3, 'A', 'BSCS', '3rd', 'BSCS 301-A', '07:00:00', '10:00:00', 'Tuesday', 'DCS-3', 'Lec'),
(71, '20230068', 'Renjie Driza', 'DCIT 50', 'Object Oriented Programing (LAB)', 'Lab', 1, 3, 'B', 'BSCS', '3rd', 'BSCS 301-B', '07:00:00', '10:00:00', 'Monday', 'DCS-5', 'Lec'),
(72, '20230069', 'Renjie Driza', 'DCIT 55', 'Advance Database System (LEC)', 'Lec', 2, 2, 'A', 'BSCS', '4th', 'BSCS 401-A', '07:00:00', '09:00:00', 'Friday', 'CCL-3', 'Lab'),
(73, '20230070', 'Renjie Driza', 'DCIT 55', 'Advance Database System (LEC)', 'Lec', 2, 2, 'B', 'BSCS', '4th', 'BSCS 401-B', '09:00:00', '11:00:00', 'Wednesday', 'CCL-7', 'Lab'),
(74, '20230071', 'Renjie Driza', 'DCIT 55', 'Advance Database System (LAB)', 'Lab', 1, 3, 'A', 'BSCS', '4th', 'BSCS 401-A', '09:00:00', '12:00:00', 'Friday', 'DCS-7', 'Lec'),
(75, '20230072', 'Renjie Driza', 'DCIT 55', 'Advance Database System (LAB)', 'Lab', 1, 3, 'B', 'BSCS', '4th', 'BSCS 401-B', '09:00:00', '12:00:00', 'Thursday', 'DCS-7', 'Lec'),
(76, '20230073', 'Christopher Estonilo', 'DCIT 60', 'Methods of Research', 'Lec', 3, 3, 'A', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-A', '09:00:00', '12:00:00', 'Tuesday', 'CCL-3', 'Lab'),
(77, '20230074', 'Christopher Estonilo', 'DCIT 60', 'Methods of Research', 'Lec', 3, 3, 'B', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-B', '09:00:00', '12:00:00', 'Friday', 'CCL-4', 'Lab'),
(78, '20230075', 'Christopher Estonilo', 'DCIT 60', 'Methods of Research', 'Lec', 3, 3, 'C', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-C', '09:00:00', '12:00:00', 'Wednesday', 'CCL-2', 'Lab'),
(79, '20230076', 'Christopher Estonilo', 'DCIT 60', 'Methods of Research', 'Lec', 3, 3, 'D', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-D', '07:00:00', '10:00:00', 'Thursday', 'DCS-6', 'Lec'),
(80, '20230077', 'Christopher Estonilo', 'DCIT 60', 'Methods of Research', 'Lec', 3, 3, 'E', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-E', '13:00:00', '16:00:00', 'Wednesday', 'CCL-4', 'Lab'),
(81, '20230078', 'Aries Gelera', 'INSY 55', 'System Analysis and Design (LAB)', 'Lab', 1, 3, 'A', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-A', '13:00:00', '16:00:00', 'Tuesday', 'DCS4', 'Lec'),
(82, '20230079', 'Aries Gelera', 'INSY 55', 'System Analysis and Design (LAB)', 'Lab', 1, 3, 'B', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-B', '13:00:00', '16:00:00', 'Friday', 'CCL-4', 'Lab'),
(83, '20230080', 'Aries Gelera', 'INSY 55', 'System Analysis and Design (LAB)', 'Lab', 1, 3, 'C', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-C', '07:00:00', '10:00:00', 'Tuesday', 'CCL-1', 'Lab'),
(85, '20230081', 'Marie Angelie Gerios', 'ITEC 90', 'Networks Fundamentals (LEC)', 'Lec', 2, 2, 'A', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-A', '07:00:00', '09:00:00', 'Wednesday', 'DCS4', 'Lec'),
(86, '20230082', 'Marie Angelie Gerios', 'ITEC 90', 'Networks Fundamentals (LEC)', 'Lec', 2, 2, 'B', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-B', '07:00:00', '09:00:00', 'Thursday', 'DCS-7', 'Lec'),
(87, '20230083', 'Marie Angelie Gerios', 'ITEC 90', 'Networks Fundamentals (LEC)', 'Lec', 2, 2, 'C', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-C', '07:00:00', '09:00:00', 'Tuesday', 'DCS4', 'Lec'),
(88, '20230084', 'Marie Angelie Gerios', 'ITEC 90', 'Networks Fundamentals (LEC)', 'Lec', 2, 2, 'D', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-D', '07:00:00', '09:00:00', 'Friday', 'CCL-2', 'Lab'),
(89, '20230085', 'Marie Angelie Gerios', 'ITEC 90', 'Networks Fundamentals (LEC)', 'Lec', 2, 2, 'E', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-E', '07:00:00', '09:00:00', 'Monday', 'DCS4', 'Lec'),
(90, '20230086', 'Marie Angelie Gerios', 'COSC 85', 'Networks and Communication (LEC)', 'Lec', 2, 2, 'A', 'BSCS', '2nd', 'BSCS 201-A', '09:00:00', '11:00:00', 'Wednesday', 'DCS-1', 'Lec'),
(91, '20230087', 'Marie Angelie Gerios', 'COSC 85', 'Networks and Communication (LEC)', 'Lec', 2, 2, 'B', 'BSCS', '2nd', 'BSCS 201-B', '09:00:00', '11:00:00', 'Monday', 'DCS-2', 'Lec'),
(92, '20230088', 'Girlie Meliante', 'COSC 70', 'Software Engineering I (LEC)', 'Lab', 3, 3, 'A', 'BSCS', '2nd', 'BSCS 201-A', '09:00:00', '12:00:00', 'Friday', 'DCS4', 'Lec'),
(93, '20230089', 'Girlie Meliante', 'COSC 70', 'Software Engineering I (LEC)', 'Lab', 3, 3, 'B', 'BSCS', '2nd', 'BSCS 201-B', '07:00:00', '10:00:00', 'Wednesday', 'DCS-7', 'Lec'),
(94, '20230090', 'Girlie Meliante', 'ITEC 50', 'Web System and Technologies II (LEC)', 'Lec', 2, 2, 'A', 'BSCS', '1st', 'BSCS 101-A', '07:00:00', '09:00:00', 'Tuesday', 'DCS-2', 'Lec'),
(95, '20230091', 'Girlie Meliante', 'ITEC 50', 'Web System and Technologies II (LEC)', 'Lec', 2, 2, 'B', 'BSCS', '1st', 'BSCS 101-B', '07:00:00', '09:00:00', 'Thursday', 'CCL-3', 'Lab'),
(96, '20230092', 'Girlie Meliante', 'ITEC 50', 'Web System and Technologies II (LEC)', 'Lec', 2, 2, 'C', 'BSCS', '2nd', 'BSCS 201-C', '07:00:00', '09:00:00', 'Friday', 'DCS4', 'Lec'),
(97, '20230093', 'Girlie Meliante', 'ITEC 50', 'Web System and Technologies II (LEC)', 'Lec', 2, 2, 'D', 'BSCS', '2nd', 'BSCS 201-D', '07:00:00', '09:00:00', 'Monday', 'CCL-3', 'Lab'),
(98, '20230094', 'Girlie Meliante', 'ITEC 50', 'Web System and Technologies II (LEC)', 'Lec', 2, 2, 'A', 'BSINFOTECH', '1st', 'BSINFOTECH 101-A', '09:00:00', '11:00:00', 'Monday', 'CCL-3', 'Lab'),
(99, '20230095', 'Girlie Meliante', 'ITEC 50', 'Web System and Technologies II (LEC)', 'Lec', 2, 2, 'B', 'BSINFOTECH', '1st', 'BSINFOTECH 101-B', '09:00:00', '11:00:00', 'Thursday', 'DCS-2', 'Lec'),
(100, '20230096', 'Girlie Meliante', 'ITEC 50', 'Web System and Technologies II (LEC)', 'Lec', 2, 2, 'C', 'BSINFOTECH', '1st', 'BSINFOTECH 101-C', '09:00:00', '11:00:00', 'Tuesday', 'DCS-1', 'Lec'),
(101, '20230097', 'Girlie Meliante', 'ITEC 50', 'Web System and Technologies II (LEC)', 'Lec', 2, 2, 'D', 'BSINFOTECH', '1st', 'BSINFOTECH 101-D', '10:00:00', '12:00:00', 'Wednesday', 'DCS-5', 'Lec'),
(102, '20230098', 'Girlie Meliante', 'ITEC 50', 'Web System and Technologies II (LEC)', 'Lec', 2, 2, 'E', 'BSINFOTECH', '1st', 'BSINFOTECH 101-E', '13:00:00', '15:00:00', 'Friday', 'DCS-7', 'Lec'),
(103, '20230099', 'Girlie Meliante', 'INSY 55', 'System Analysis and Design (LEC)', 'Lec', 2, 2, 'A', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-A', '13:00:00', '15:00:00', 'Monday', 'DCS-6', 'Lec'),
(104, '20230100', 'Girlie Meliante', 'INSY 55', 'System Analysis and Design (LEC)', 'Lec', 2, 2, 'B', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-B', '13:00:00', '15:00:00', 'Tuesday', 'DCS-1', 'Lec'),
(105, '20230101', 'Girlie Meliante', 'INSY 55', 'System Analysis and Design (LEC)', 'Lec', 2, 2, 'C', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-C', '13:00:00', '15:00:00', 'Wednesday', 'DCS-5', 'Lec'),
(106, '20230102', 'Girlie Meliante', 'INSY 55', 'System Analysis and Design (LEC)', 'Lec', 2, 2, 'D', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-D', '13:00:00', '15:00:00', 'Thursday', 'CCL-4', 'Lab'),
(107, '20230103', 'Girlie Meliante', 'INSY 55', 'System Analysis and Design (LEC)', 'Lec', 2, 2, 'E', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-E', '15:00:00', '17:00:00', 'Tuesday', 'DCS-1', 'Lec'),
(108, '20230104', 'EJ Muyot', 'COSC 106 ', 'Introduction to Game Development (LEC)', 'Lec', 2, 2, 'A', 'BSCS', '4th', 'BSCS 401-A', '07:00:00', '09:00:00', 'Thursday', 'CCL-2', 'Lab'),
(109, '20230105', 'EJ Muyot', 'COSC 106 ', 'Introduction to Game Development (LEC)', 'Lec', 2, 2, 'B', 'BSCS', '4th', 'BSCS 401-B', '07:00:00', '09:00:00', 'Wednesday', 'CCL-3', 'Lab'),
(110, '20230106', 'EJ Muyot', 'COSC 106 ', 'Introduction to Game Development (LAB)', 'Lab', 1, 3, 'A', 'BSCS', '4th', 'BSCS 401-A', '07:00:00', '10:00:00', 'Monday', 'DCS-1', 'Lec'),
(111, '20230107', 'EJ Muyot', 'COSC 106 ', 'Introduction to Game Development (LAB)', 'Lab', 1, 3, 'B', 'BSCS', '4th', 'BSCS 401-B', '07:00:00', '10:00:00', 'Tuesday', 'CCL-5', 'Lab'),
(112, '20230108', 'Karlo Jose Nabablit', 'DCIT 23', 'Computer Programming II (LEC)', 'Lec', 1, 1, 'A', 'BSCS', '3rd', 'BSCS 301-A', '07:00:00', '08:00:00', 'Friday', 'DCS-7', 'Lec'),
(113, '20230109', 'Karlo Jose Nabablit', 'DCIT 23', 'Computer Programming II (LEC)', 'Lec', 1, 1, 'B', 'BSCS', '3rd', 'BSCS 301-B', '07:00:00', '08:00:00', 'Tuesday', 'CCL-3', 'Lab'),
(114, '20230110', 'Karlo Jose Nabablit', 'COSC 200A', 'Undergraduate Thesis 1', 'Lec', 3, 3, 'A', 'BSCS', '4th', 'BSCS 401-A', '09:00:00', '12:00:00', 'Thursday', 'DCS-5', 'Lec'),
(115, '20230111', 'Karlo Jose Nabablit', 'COSC 200A', 'Undergraduate Thesis 1', 'Lec', 3, 3, 'B', 'BSCS', '4th', 'BSCS 401-B', '08:00:00', '11:00:00', 'Friday', 'DCS-3', 'Lec'),
(116, '20230112', 'Mark Edriane Nolledo', 'COSC 65', 'Architecture and Organization (LAB)', 'Lab', 1, 3, 'A', 'BSCS', '3rd', 'BSCS 301-A', '09:00:00', '12:00:00', 'Friday', 'CCL-2', 'Lab'),
(117, '20230113', 'Mark Edriane Nolledo', 'COSC 65', 'Architecture and Organization (LAB)', 'Lab', 1, 3, 'B', 'BSCS', '3rd', 'BSCS 301-B', '08:00:00', '11:00:00', 'Tuesday', 'CCL-7', 'Lab'),
(118, '20230114', 'Mark Edriane Nolledo', 'COSC 65', 'Architecture and Organization (LAB)', 'Lab', 1, 3, 'A', 'BSCS', '4th', 'BSCS 401-A', '09:00:00', '12:00:00', 'Wednesday', 'CCL-4', 'Lab'),
(119, '20230115', 'Karlo Jose Nabablit', 'COSC 65', 'Architecture and Organization (LAB)', 'Lab', 1, 3, 'B', 'BSCS', '4th', 'BSCS 401-B', '13:00:00', '16:00:00', 'Tuesday', 'DCS-5', 'Lec'),
(120, '20230116', 'Ana Marie Obon', 'DCIT 25', 'Data Structures and Algorithm (LEC)', 'Lec', 2, 2, 'A', 'BSCS', '3rd', 'BSCS 301-A', '07:00:00', '09:00:00', 'Monday', 'CCL-6', 'Lab'),
(121, '20230117', 'Ana Marie Obon', 'DCIT 25', 'Data Structures and Algorithm (LEC)', 'Lec', 2, 2, 'B', 'BSCS', '3rd', 'BSCS 301-B', '07:00:00', '09:00:00', 'Friday', 'DCS-1', 'Lec'),
(122, '20230118', 'Ana Marie Obon', 'DCIT 25', 'Data Structures and Algorithm (LAB)', 'Lab', 1, 3, 'A', 'BSCS', '3rd', 'BSCS 301-A', '09:00:00', '12:00:00', 'Thursday', 'CCL-3', 'Lab'),
(123, '20230119', 'Ana Marie Obon', 'DCIT 25', 'Data Structures and Algorithm (LAB)', 'Lab', 1, 3, 'B', 'BSCS', '3rd', 'BSCS 301-B', '09:00:00', '12:00:00', 'Wednesday', 'DCS4', 'Lec'),
(124, '20230120', 'Chrisa Mae Turla', 'ITECT 75', 'System Integration and Architecture (LAB)', 'Lab', 1, 3, 'A', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-A', '13:00:00', '16:00:00', 'Monday', 'CCL-4', 'Lab'),
(125, '20230121', 'Chrisa Mae Turla', 'ITECT 75', 'System Integration and Architecture (LAB)', 'Lab', 1, 3, 'B', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-B', '13:00:00', '16:00:00', 'Thursday', 'DCS-3', 'Lec'),
(126, '20230122', 'Chrisa Mae Turla', 'ITECT 75', 'System Integration and Architecture (LAB)', 'Lab', 1, 3, 'C', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-C', '13:00:00', '16:00:00', 'Friday', 'CCL-1', 'Lab'),
(127, '20230123', 'Chrisa Mae Turla', 'ITECT 75', 'System Integration and Architecture (LAB)', 'Lab', 1, 3, 'D', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-D', '09:00:00', '12:00:00', 'Monday', 'DCS-6', 'Lec'),
(128, '20230124', 'Chrisa Mae Turla', 'ITECT 75', 'System Integration and Architecture (LAB)', 'Lab', 1, 3, 'E', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-E', '09:00:00', '12:00:00', 'Friday', 'CCL-7', 'Lab'),
(129, '20230125', 'Chrisa Mae Turla', 'ITEC 75', 'System Integration and Architecture (LEC)', 'Lec', 2, 2, 'A', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-A', '07:00:00', '09:00:00', 'Monday', 'DCS-2', 'Lec'),
(130, '20230126', 'Chrisa Mae Turla', 'ITEC 75', 'System Integration and Architecture (LEC)', 'Lec', 2, 2, 'B', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-B', '07:00:00', '09:00:00', 'Wednesday', 'CCL-6', 'Lab'),
(131, '20230127', 'Chrisa Mae Turla', 'ITEC 75', 'System Integration and Architecture (LEC)', 'Lec', 2, 2, 'C', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-C', '07:00:00', '09:00:00', 'Friday', 'DCS-2', 'Lec'),
(132, '20230128', 'Chrisa Mae Turla', 'ITEC 75', 'System Integration and Architecture (LEC)', 'Lec', 2, 2, 'D', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-D', '09:00:00', '11:00:00', 'Thursday', 'CCL-1', 'Lab'),
(133, '20230129', 'Chrisa Mae Turla', 'ITEC 75', 'System Integration and Architecture (LEC)', 'Lec', 2, 2, 'E', 'BSINFOTECH', '2nd', 'BSINFOTECH 201-E', '09:00:00', '11:00:00', 'Tuesday', 'DCS-2', 'Lec'),
(134, '20230130', 'Lester  Villanueva', 'ITEC 90', 'Networks Fundamentals (LAB)', 'Lab', 1, 3, 'A', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-A', '13:00:00', '16:00:00', 'Thursday', 'CCL-1', 'Lab'),
(135, '20230131', 'Lester  Villanueva', 'ITEC 90', 'Networks Fundamentals (LAB)', 'Lab', 1, 3, 'B', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-B', '13:00:00', '16:00:00', 'Wednesday', 'DCS-7', 'Lec'),
(136, '20230132', 'Lester  Villanueva', 'ITEC 90', 'Networks Fundamentals (LAB)', 'Lab', 1, 3, 'C', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-C', '13:00:00', '16:00:00', 'Tuesday', 'DCS-6', 'Lec'),
(137, '20230133', 'Lester  Villanueva', 'ITEC 90', 'Networks Fundamentals (LAB)', 'Lab', 1, 3, 'D', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-D', '13:00:00', '16:00:00', 'Friday', 'DCS-3', 'Lec'),
(138, '20230134', 'Lester  Villanueva', 'ITEC 90', 'Networks Fundamentals (LAB)', 'Lab', 1, 3, 'E', 'BSINFOTECH', '3rd', 'BSINFOTECH 301-E', '09:00:00', '12:00:00', 'Thursday', 'DCS4', 'Lec'),
(139, '20230135', 'Lester  Villanueva', 'COSC 80', 'Operating System (LAB)', 'Lab', 1, 3, 'A', 'BSCS', '4th', 'BSCS 401-A', '13:00:00', '16:00:00', 'Monday', 'DCS-7', 'Lec');

-- --------------------------------------------------------

--
-- Table structure for table `manual_generated_schedule`
--

CREATE TABLE `manual_generated_schedule` (
  `id` int(11) NOT NULL,
  `schedcode` varchar(10) NOT NULL,
  `teacher` varchar(255) NOT NULL,
  `subject_code` varchar(255) NOT NULL,
  `subject_description` varchar(255) NOT NULL,
  `subject_type` enum('Lec','Lab') DEFAULT NULL,
  `subject_units` int(11) NOT NULL,
  `subject_hours` double DEFAULT NULL,
  `section_name` varchar(50) DEFAULT NULL,
  `course_name` varchar(50) DEFAULT NULL,
  `section_year` varchar(255) DEFAULT NULL,
  `course_year_section` varchar(255) NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `day` varchar(10) DEFAULT NULL,
  `room_name` varchar(255) NOT NULL,
  `room_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(100) NOT NULL,
  `room_id` varchar(255) NOT NULL,
  `room_name` varchar(255) DEFAULT NULL,
  `room_type` varchar(255) DEFAULT NULL,
  `room_capacity` bigint(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_id`, `room_name`, `room_type`, `room_capacity`) VALUES
(15, '1', 'DCS-1', 'Lec', 30),
(16, '2', 'DCS-2', 'Lec', 25),
(31, '3', 'DCS-3', 'Lec', 100),
(33, '4', 'DCS-4', 'Lec', 30),
(35, '5', 'DCS-5', 'Lec', 50),
(36, '6', 'DCS-6', 'Lec', 50),
(37, '7', 'DCS-7', 'Lec', 20),
(38, '8', 'CCL-1', 'Lab', 20),
(39, '9', 'CCL-2', 'Lab', 30),
(40, '10', 'CCL-3', 'Lab', 30),
(41, '11', 'CCL-4', 'Lab', 30),
(42, '13', 'CCL-5', 'Lab', 25),
(43, '14', 'CCL-6', 'Lab', 20),
(45, '15', 'CCL-7', 'Lab', 30);

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `section_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `section_id`, `section_name`) VALUES
(16, 1, 'A'),
(17, 2, 'B'),
(18, 3, 'C'),
(19, 4, 'D'),
(23, 5, 'E'),
(24, 6, 'F');

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE `semesters` (
  `id` int(11) NOT NULL,
  `semester_name` varchar(50) NOT NULL,
  `semester_id` varchar(100) NOT NULL,
  `start_year` bigint(255) NOT NULL,
  `end_year` bigint(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semesters`
--

INSERT INTO `semesters` (`id`, `semester_name`, `semester_id`, `start_year`, `end_year`) VALUES
(16, '2nd Sem', '1', 2023, 2024);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(100) NOT NULL,
  `subject_code` varchar(255) NOT NULL,
  `subject_description` varchar(255) NOT NULL,
  `subject_type` enum('Lec','Lab') DEFAULT NULL,
  `subject_units` int(100) DEFAULT NULL,
  `subject_hours` float DEFAULT NULL,
  `timeslot_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_code`, `subject_description`, `subject_type`, `subject_units`, `subject_hours`, `timeslot_id`) VALUES
(45, 'DCIT 26', 'App Development & Emerging Tech (LAB)', 'Lab', 1, 3, NULL),
(46, 'DCIT 26', 'App Development & Emerging Tech (LEC)', 'Lec', 2, 2, NULL),
(47, 'DCIT 23', 'Computer Programming II (LEC)', 'Lec', 1, 1, NULL),
(48, 'DCIT 23', 'Computer Programming II (LAB)', 'Lab', 1, 3, NULL),
(49, 'COSC 65', 'Architecture and Organization (LEC)', 'Lec', 2, 2, NULL),
(50, 'ITEC 85', 'Information Assurance and Security (LAB)', 'Lab', 1, 3, NULL),
(51, 'ITEC 80', 'Introduction to Human Computer Interaction I (LAB)', 'Lab', 1, 3, NULL),
(52, 'ITEC 80A', 'Introduction to Human Computer Interaction (LEC)', 'Lab', 2, 1, NULL),
(53, 'ITEC 65', 'Open-Source Technologies (LEC)', 'Lec', 2, 2, NULL),
(54, 'ITEC 85', 'Information Assurance and Security (LEC)', 'Lec', 2, 2, NULL),
(55, 'ITEC 110', 'System Administration and Maintenance (LEC)', 'Lec', 2, 2, NULL),
(56, 'DCIT 55', 'Advance Database System (LEC)', 'Lec', 2, 2, NULL),
(57, 'DCIT 55', 'Advance Database System (LAB)', 'Lab', 1, 3, NULL),
(58, 'ITEC 106', 'Web System and Technologies II (LAB)', 'Lab', 1, 3, NULL),
(59, 'DCIT 25', 'Data Structures and Algorithm (LEC)', 'Lec', 2, 2, NULL),
(60, 'COSC 90', 'Design Analysis of Algorithm (LEC)', 'Lec', 2, 2, NULL),
(61, 'ITEC 60', 'Integrated Programming and Technologies I (LEC)', 'Lec', 2, 2, NULL),
(62, 'DCIT 60', 'Methods of Research', 'Lec', 3, 3, NULL),
(63, 'INSY 55', 'System Analysis and Design (LAB)', 'Lab', 1, 3, NULL),
(64, 'ITEC 200B', 'Capstone Project and Research 2', 'Lec', 3, 3, NULL),
(65, 'ITEC 90', 'Networks Fundamentals (LEC)', 'Lec', 2, 2, NULL),
(66, 'COSC 85', 'Networks and Communication (LEC)', 'Lec', 2, 2, NULL),
(67, 'ITEC 111', 'Integrated Programming and Technologies I (LAB)', 'Lab', 1, 3, NULL),
(68, 'COSC 70', 'Software Engineering I (LEC)', 'Lec', 3, 3, NULL),
(69, 'ITEC 50', 'Web System and Technologies II (LEC)', 'Lec', 2, 2, NULL),
(70, 'INSY 55', 'System Analysis and Design (LEC)', 'Lec', 2, 2, NULL),
(71, 'COSC 106 ', 'Introduction to Game Development (LEC)', 'Lec', 2, 2, NULL),
(72, 'COSC 106 ', 'Introduction to Game Development (LAB)', 'Lab', 1, 3, NULL),
(73, 'COSC 200A', 'Undergraduate Thesis 1', 'Lec', 3, 3, NULL),
(74, 'COSC 65', 'Architecture and Organization (LAB)', 'Lab', 1, 3, NULL),
(75, 'DCIT 25', 'Data Structures and Algorithm (LAB)', 'Lab', 1, 3, NULL),
(76, 'ITECT 75', 'System Integration and Architecture (LAB)', 'Lab', 1, 3, NULL),
(77, 'ITEC 75', 'System Integration and Architecture (LEC)', 'Lec', 2, 2, NULL),
(78, 'ITEC 90', 'Networks Fundamentals (LAB)', 'Lab', 1, 3, NULL),
(79, 'COSC 80', 'Operating System (LAB)', 'Lab', 1, 3, NULL),
(80, 'DCIT 24', 'Information Management (LAB)', 'Lab', 1, 3, NULL),
(81, 'DCIT 50', 'Object Oriented Programing (LEC)', 'Lec', 2, 2, NULL),
(82, 'DCIT 50', 'Object Oriented Programing (LAB)', 'Lab', 1, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(6) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `teacher_id`, `firstname`, `lastname`) VALUES
(9, 2, 'Karlo Jose', 'Nabablit'),
(10, 3, 'Aries', 'Gelera'),
(11, 4, 'Renato', 'Bautista'),
(12, 5, 'Marie Angelie', 'Gerios'),
(13, 6, 'EJ', 'Muyot'),
(14, 7, 'Jenerry', 'Abad'),
(16, 8, 'Axel', 'Cabarles'),
(17, 9, 'Princess Garvie', 'Camingawan'),
(18, 10, 'Angela', 'Clarito'),
(19, 11, 'Janessa Marielle', 'Cruz'),
(20, 12, 'Yvana', 'Nocon'),
(21, 13, 'Mark Edriane', 'Nolledo'),
(22, 14, 'Ana Marie', 'Obon'),
(23, 15, 'Chrisa Mae', 'Turla'),
(24, 16, 'Lester ', 'Villanueva'),
(25, 17, 'Mary Grace ', 'Dela Cruz'),
(26, 18, 'Renjie', 'Driza'),
(27, 19, 'Christopher', 'Estonilo'),
(28, 20, 'Girlie', 'Meliante'),
(45, 1, 'Raven', 'Topacio');

-- --------------------------------------------------------

--
-- Table structure for table `timeslots`
--

CREATE TABLE `timeslots` (
  `id` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `duration` time DEFAULT NULL,
  `timeslot_id_based_on_duration` int(200) NOT NULL,
  `availability` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timeslots`
--

INSERT INTO `timeslots` (`id`, `start_time`, `end_time`, `duration`, `timeslot_id_based_on_duration`, `availability`) VALUES
(1, '07:00:00', '08:00:00', '00:00:01', 1, 1),
(2, '07:00:00', '09:00:00', '00:00:02', 2, 1),
(3, '07:00:00', '08:30:00', '00:00:01', 4, 1),
(4, '07:00:00', '10:00:00', '00:00:03', 3, 1),
(5, '07:30:00', '08:30:00', '00:00:01', 1, 1),
(6, '07:30:00', '09:30:00', '00:00:02', 2, 1),
(7, '07:30:00', '09:00:00', '00:00:01', 4, 1),
(8, '07:30:00', '10:30:00', '00:00:03', 3, 1),
(9, '08:00:00', '09:00:00', '00:00:01', 1, 1),
(10, '08:00:00', '10:00:00', '00:00:02', 2, 1),
(11, '08:00:00', '09:30:00', '00:00:01', 4, 1),
(12, '08:00:00', '11:00:00', '00:00:03', 3, 1),
(13, '08:30:00', '09:30:00', '00:00:01', 1, 1),
(14, '08:30:00', '10:30:00', '00:00:02', 2, 1),
(15, '08:30:00', '10:00:00', '00:00:01', 4, 1),
(16, '08:30:00', '11:30:00', '00:00:03', 3, 1),
(17, '09:00:00', '10:00:00', '00:00:01', 1, 1),
(18, '09:00:00', '11:00:00', '00:00:02', 2, 1),
(19, '09:00:00', '10:30:00', '00:00:01', 4, 1),
(20, '09:00:00', '12:00:00', '00:00:03', 3, 1),
(21, '09:30:00', '10:30:00', '00:00:01', 1, 1),
(22, '09:30:00', '11:30:00', '00:00:02', 2, 1),
(23, '09:30:00', '11:00:00', '00:00:01', 4, 1),
(25, '10:00:00', '11:00:00', '00:00:01', 1, 1),
(26, '10:00:00', '12:00:00', '00:00:02', 2, 1),
(27, '10:00:00', '11:30:00', '00:00:01', 4, 1),
(29, '10:30:00', '11:30:00', '00:00:01', 1, 1),
(31, '10:30:00', '12:00:00', '00:00:01', 4, 1),
(33, '11:00:00', '11:30:00', '00:00:01', 1, 1),
(37, '11:30:00', '12:30:00', '00:00:01', 1, 1),
(41, '13:00:00', '14:00:00', '00:00:01', 1, 1),
(42, '13:00:00', '15:00:00', '00:00:02', 2, 1),
(43, '13:00:00', '14:30:00', '00:00:01', 4, 1),
(44, '13:00:00', '16:00:00', '00:00:03', 3, 1),
(45, '13:30:00', '14:30:00', '00:00:01', 1, 1),
(46, '13:30:00', '15:30:00', '00:00:02', 2, 1),
(47, '13:30:00', '15:00:00', '00:00:01', 4, 1),
(48, '13:30:00', '16:30:00', '00:00:03', 3, 1),
(49, '14:00:00', '15:00:00', '00:00:01', 1, 1),
(50, '14:00:00', '16:00:00', '00:00:02', 2, 1),
(51, '14:00:00', '15:30:00', '00:00:01', 4, 1),
(52, '14:00:00', '17:00:00', '00:00:03', 3, 1),
(53, '14:30:00', '15:30:00', '00:00:01', 1, 1),
(54, '14:30:00', '16:30:00', '00:00:02', 2, 1),
(55, '14:30:00', '16:00:00', '00:00:01', 4, 1),
(56, '14:30:00', '17:30:00', '00:00:03', 3, 1),
(57, '15:00:00', '16:00:00', '00:00:01', 1, 1),
(58, '15:00:00', '17:00:00', '00:00:02', 2, 1),
(59, '15:00:00', '16:30:00', '00:00:01', 4, 1),
(60, '15:00:00', '18:00:00', '00:00:03', 3, 1),
(61, '15:30:00', '16:30:00', '00:00:01', 1, 1),
(62, '15:30:00', '17:30:00', '00:00:02', 2, 1),
(63, '15:30:00', '17:00:00', '00:00:01', 4, 1),
(64, '15:30:00', '18:30:00', '00:00:03', 3, 1),
(65, '16:00:00', '17:00:00', '00:00:01', 1, 1),
(66, '16:00:00', '18:00:00', '00:00:02', 2, 1),
(67, '16:00:00', '17:30:00', '00:00:01', 4, 1),
(68, '16:00:00', '19:00:00', '00:00:03', 3, 1),
(69, '16:30:00', '17:30:00', '00:00:01', 1, 1),
(70, '16:30:00', '18:30:00', '00:00:02', 2, 1),
(71, '16:30:00', '18:00:00', '00:00:01', 4, 1),
(72, '17:00:00', '18:00:00', '00:00:01', 1, 1),
(73, '17:00:00', '19:00:00', '00:00:02', 2, 1),
(74, '17:00:00', '18:30:00', '00:00:01', 4, 1),
(75, '17:00:00', '20:00:00', '00:00:03', 3, 1),
(76, '17:30:00', '18:30:00', '00:00:01', 1, 1),
(77, '17:30:00', '19:30:00', '00:00:02', 2, 1),
(78, '17:30:00', '19:00:00', '00:00:01', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `login_attempts` int(11) DEFAULT 0,
  `last_failed_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `login_attempts`, `last_failed_login`) VALUES
(1, 'HERNANDO JR.', 'hernandocostelo@gmail.com', 'hernandocostelo@gmail.com', 0, NULL),
(2, 'katrina', 'katrinalavilla@gmail.com', 'pogisiren', 0, NULL),
(3, 'ADMIN', 'admin@gmail.com', 'admin@gmail.com', 0, NULL),
(4, 'Hernando Jr. J. Costelo', 'a@gmail.com', 'a@gmail.com', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `automated_schedule`
--
ALTER TABLE `automated_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_year_section` (`course_year_section`),
  ADD KEY `schedcode` (`schedcode`),
  ADD KEY `idx_schedcode` (`schedcode`),
  ADD KEY `idx_start_time` (`start_time`),
  ADD KEY `idx_end_time` (`end_time`),
  ADD KEY `idx_day` (`day`),
  ADD KEY `idx_subject_hours` (`subject_hours`);

--
-- Indexes for table `available_days`
--
ALTER TABLE `available_days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculty_loadings`
--
ALTER TABLE `faculty_loadings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_year_section` (`course_year_section`),
  ADD KEY `schedcode` (`schedcode`),
  ADD KEY `idx_schedcode` (`schedcode`),
  ADD KEY `idx_start_time` (`start_time`),
  ADD KEY `idx_end_time` (`end_time`),
  ADD KEY `idx_day` (`day`),
  ADD KEY `idx_subject_hours` (`subject_hours`);

--
-- Indexes for table `manual_generated_schedule`
--
ALTER TABLE `manual_generated_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_year_section` (`course_year_section`),
  ADD KEY `schedcode` (`schedcode`),
  ADD KEY `idx_schedcode` (`schedcode`),
  ADD KEY `idx_start_time` (`start_time`),
  ADD KEY `idx_end_time` (`end_time`),
  ADD KEY `idx_day` (`day`),
  ADD KEY `idx_subject_hours` (`subject_hours`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `subject_code` (`subject_code`,`subject_description`,`subject_type`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `firstname` (`firstname`,`lastname`);

--
-- Indexes for table `timeslots`
--
ALTER TABLE `timeslots`
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
-- AUTO_INCREMENT for table `automated_schedule`
--
ALTER TABLE `automated_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `available_days`
--
ALTER TABLE `available_days`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `faculty_loadings`
--
ALTER TABLE `faculty_loadings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `manual_generated_schedule`
--
ALTER TABLE `manual_generated_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `semesters`
--
ALTER TABLE `semesters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `timeslots`
--
ALTER TABLE `timeslots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
