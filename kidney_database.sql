-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 25, 2024 at 03:52 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kidney_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `kidney_patients`
--

CREATE TABLE `kidney_patients` (
  `patient_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `blood_type` varchar(5) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `nic` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kidney_patients`
--

INSERT INTO `kidney_patients` (`patient_id`, `first_name`, `last_name`, `dob`, `gender`, `email`, `phone`, `blood_type`, `address`, `nic`) VALUES
(7, 'pasidu', 'yapra', '2024-11-08', 'Male', 'malintha@gmail.com', '0779180997', 'A', '1/2 wawathanna,ambanpola,udasgiriya', '222222222222'),
(8, 'pasidu', 'yapab', '2024-11-15', 'Male', 'malintha@gmail.com', '0779180997', 'A-', '1/2 wawathanna,ambanpola,udasgiriya', '777777777777'),
(10, 'Dddd', 'dddd', '2024-11-16', 'Male', 'asma@gmail.com', '0779180997', 'A', '1/2 wawathanna,ambanpola,udasgiriya', '555555555555');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kidney_patients`
--
ALTER TABLE `kidney_patients`
  ADD PRIMARY KEY (`patient_id`),
  ADD UNIQUE KEY `nic` (`nic`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kidney_patients`
--
ALTER TABLE `kidney_patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
