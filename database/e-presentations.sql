-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2023 at 08:46 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-presentations`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `file_id` int(11) NOT NULL,
  `team_code` int(11) NOT NULL,
  `file_path` text NOT NULL,
  `file_type` enum('application','report','presentation') NOT NULL,
  `last_update` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`file_id`, `team_code`, `file_path`, `file_type`, `last_update`) VALUES
(1, 93, 'https://github.com/OthmaneNissoukin/demo-interns', 'application', '2023-07-26 18:53:09'),
(2, 93, 'uploads/WFS203_93/Presentation.pptx', 'presentation', '2023-07-26 18:55:33');

-- --------------------------------------------------------

--
-- Table structure for table `mentor`
--

CREATE TABLE `mentor` (
  `login` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mentor`
--

INSERT INTO `mentor` (`login`, `password`, `email`) VALUES
('admin1', 'admin1', 'o@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id_msg` int(11) NOT NULL,
  `team_code` int(11) NOT NULL,
  `msg_content` text NOT NULL,
  `msg_object` varchar(64) NOT NULL DEFAULT 'Message',
  `sent_time` datetime DEFAULT current_timestamp(),
  `status` enum('Read','Unread') DEFAULT 'Unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id_msg`, `team_code`, `msg_content`, `msg_object`, `sent_time`, `status`) VALUES
(1, 3419, 'My first notification!', 'Message', '2023-07-18 20:50:59', 'Unread'),
(2, 2312, 'Hello from PHP', 'Message', '2023-07-18 20:52:21', 'Unread'),
(3, 3419, 'Presentation date has been changed, please check out the new status.', 'Message', '2023-07-18 21:46:25', 'Read'),
(4, 3419, 'Presentation date and time have been changed.\r\n\r\nAll files should be uploaded in the right format before 30-07-2023 at 19:00.\r\n\r\nGood Luck!', 'Message', '2023-07-18 21:59:25', 'Unread'),
(5, 2312, 'Presentation date has been updated to: 28/07/2023 at 08:30', 'Update', '2023-07-20 13:05:04', 'Unread');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `team_code` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `group_code` varchar(10) NOT NULL,
  `trainee_1` varchar(82) NOT NULL,
  `trainee_2` varchar(82) DEFAULT NULL,
  `trainee_3` varchar(82) DEFAULT NULL,
  `presentation_date` date DEFAULT NULL,
  `presentation_time` time DEFAULT NULL,
  `status` enum('Done','Ready','Not Ready','Inactivated') DEFAULT 'Inactivated'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`team_code`, `password`, `group_code`, `trainee_1`, `trainee_2`, `trainee_3`, `presentation_date`, `presentation_time`, `status`) VALUES
(93, '246810', 'WFS203', 'Reda Farouk', 'Haytham Murad', 'Marwan Nabil', '2023-07-25', '08:30:00', 'Not Ready'),
(2312, '246810', 'WFS205', 'Alaoui Chafik', 'Alaoui Hassan', 'Yahya Darif', '2023-07-19', '09:20:00', 'Not Ready'),
(3419, 'NewPassword', 'WFS203', 'Othmane Nissoukin', 'Ahmed Eljabary', 'Alaoui Hassan', '2023-07-19', '08:45:00', 'Not Ready'),
(5339, 'Abc123@', 'WFS203', 'Haytham Kenway', 'Shay Cormac', 'Conor Kenway', NULL, NULL, 'Not Ready');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`file_id`),
  ADD KEY `team_code` (`team_code`);

--
-- Indexes for table `mentor`
--
ALTER TABLE `mentor`
  ADD PRIMARY KEY (`login`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id_msg`),
  ADD KEY `team_code` (`team_code`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`team_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id_msg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`team_code`) REFERENCES `team` (`team_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`team_code`) REFERENCES `team` (`team_code`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
