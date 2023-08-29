-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2023 at 08:39 PM
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
-- Table structure for table `accounts_to_activate`
--

CREATE TABLE `accounts_to_activate` (
  `id` int(11) NOT NULL,
  `trainee_id` int(11) NOT NULL,
  `temp_email` varchar(255) NOT NULL,
  `query_token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `evaluation`
--

CREATE TABLE `evaluation` (
  `evaluation_code` varchar(12) NOT NULL,
  `question_code` varchar(5) NOT NULL,
  `question_content` text NOT NULL,
  `question_scale` float NOT NULL,
  `question_topic` enum('presentation','report') DEFAULT NULL,
  `season` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evaluation`
--

INSERT INTO `evaluation` (`evaluation_code`, `question_code`, `question_content`, `question_scale`, `question_topic`, `season`) VALUES
('E-228', 'Q-098', 'Presentation question #3', 6, 'presentation', '2023'),
('E-228', 'Q-171', 'Report question #4', 3, 'report', '2023'),
('E-228', 'Q-191', 'Report question #3', 5, 'report', '2023'),
('E-228', 'Q-325', 'Report question #2', 4, 'report', '2023'),
('E-228', 'Q-702', 'Presentation question #1', 7, 'presentation', '2023'),
('E-228', 'Q-762', 'Report question #1', 5, 'report', '2023'),
('E-228', 'Q-781', 'Presentation question #4', 6, 'presentation', '2023'),
('E-228', 'Q-915', 'Presentation question #2', 4, 'presentation', '2023');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `file_id` int(11) NOT NULL,
  `team_code` varchar(8) NOT NULL,
  `file_path` text NOT NULL,
  `file_type` enum('application','report','presentation') NOT NULL,
  `uploader` varchar(255) NOT NULL,
  `last_update` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`file_id`, `team_code`, `file_path`, `file_type`, `uploader`, `last_update`) VALUES
(17, '5130', 'uploads/WFS203_5130/Report.pdf', 'report', 'Othmane Nissoukin', '2023-08-07 19:01:17');

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
  `team_code` varchar(8) NOT NULL,
  `msg_content` text NOT NULL,
  `msg_object` varchar(64) NOT NULL DEFAULT 'Message',
  `sent_time` datetime DEFAULT current_timestamp(),
  `status` enum('Read','Unread') DEFAULT 'Unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id_msg`, `team_code`, `msg_content`, `msg_object`, `sent_time`, `status`) VALUES
(1, '4148', 'New testing message!', 'Message', '2023-08-27 00:59:56', 'Unread'),
(2, '5130', 'New Message For The Second Team.', 'Message', '2023-08-27 09:15:20', 'Unread'),
(3, '5130', 'Another testing message for 5130', 'Message', '2023-08-27 09:20:21', 'Unread'),
(4, '5130', 'Another\r\nMessage\r\nWith\r\nMultilines', 'Message', '2023-08-27 09:31:56', 'Unread'),
(5, '5192', 'Your prensentation date has been scheduled on 15-12-2023 at 1', 'Presentation time update.', '2023-08-27 14:14:28', 'Unread'),
(6, '6396', 'Your prensentation date has been scheduled on 15-10-2023 at 1', 'Presentation time update.', '2023-08-27 14:22:33', 'Unread'),
(9, '6396', 'Your prensentation date has been updated to: 15-10-2023 at 1', 'Presentation time update.', '2023-08-27 15:03:35', 'Unread'),
(10, '6396', 'Your prensentation date has been updated to: 17-10-2023 at ', 'Presentation time update.', '2023-08-27 15:09:44', 'Unread'),
(11, '6396', 'Your prensentation date has been updated to: 17-10-2023 at ', 'Presentation time update.', '2023-08-27 15:11:25', 'Unread'),
(12, '6396', 'Your prensentation date has been updated to: 17-10-2023 at 08:30', 'Presentation time update.', '2023-08-27 15:12:43', 'Unread'),
(13, '6396', 'Your prensentation date has been updated to: 17-10-2023 at (Time still unknown)', 'Presentation time update.', '2023-08-27 15:18:58', 'Unread'),
(14, '6396', 'Message for test', 'From admin', '2023-08-27 15:24:28', 'Unread'),
(15, '4148', 'Your prensentation date has been updated to: 12-12-2023 at 15:20', 'Presentation time update.', '2023-08-27 18:42:45', 'Unread'),
(16, '4148', 'Your prensentation date has been updated to: 11-12-2023 at 16:20', 'Presentation time update.', '2023-08-27 18:49:53', 'Unread'),
(17, '4148', 'Your prensentation date has been updated to: 11-12-2023 at 13:20', 'Presentation time update.', '2023-08-27 18:51:50', 'Unread'),
(18, '4148', 'Your prensentation date has been updated to: 11-12-2023 at 14:20', 'Presentation time update.', '2023-08-27 18:52:26', 'Unread'),
(19, '4148', 'Your prensentation date has been updated to: 11-12-2023 at 11:20', 'Presentation time update.', '2023-08-27 18:59:52', 'Unread'),
(20, '4148', 'Your prensentation date has been updated to: 11-12-2023 at 15:20', 'Presentation time update.', '2023-08-27 19:16:55', 'Unread'),
(21, '4148', 'Your prensentation date has been updated to: 11-12-2023 at 08:45', 'Presentation time update.', '2023-08-27 19:17:30', 'Unread'),
(22, '4148', 'Your prensentation date has been updated to: 11-12-2023 at 08:45', 'Presentation time update.', '2023-08-27 19:41:10', 'Unread'),
(23, '4148', 'Your prensentation date has been updated to: 11-12-2023 at 09:45', 'Presentation time update.', '2023-08-27 19:41:57', 'Unread'),
(24, '4148', 'Your prensentation date has been updated to: 11-12-2023 at 08:45', 'Presentation time update.', '2023-08-27 19:44:10', 'Unread'),
(25, '4148', 'Your prensentation date has been updated to: 11-12-2023 at 09:45', 'Presentation time update.', '2023-08-27 19:45:09', 'Unread'),
(26, '4148', 'Your prensentation date has been updated to: 11-12-2023 at 13:45', 'Presentation time update.', '2023-08-27 19:45:27', 'Unread'),
(27, '4148', 'Your prensentation date has been updated to: 11-12-2023 at 14:45', 'Presentation time update.', '2023-08-27 19:45:40', 'Unread'),
(28, '4148', 'Your prensentation date has been updated to: 11-12-2023 at 16:45', 'Presentation time update.', '2023-08-27 19:52:10', 'Unread'),
(30, '4148', 'Your prensentation date has been updated to: 13-12-2023 at 16:45', 'Presentation time update.', '2023-08-27 19:56:03', 'Unread'),
(37, '4148', 'Your prensentation date has been updated to: 20-12-2023 at 17:45:00', 'Presentation time update.', '2023-08-27 22:06:22', 'Unread'),
(38, '4148', 'Your prensentation date has been updated to: 15-12-2023 at 17:45:00', 'Presentation time update.', '2023-08-27 22:10:53', 'Unread'),
(39, '4148', 'Your prensentation date has been updated to: 2023-12-15 at 08:45', 'Presentation time update.', '2023-08-27 22:11:53', 'Unread'),
(40, '4148', 'Your prensentation date has been updated to: 2023-12-15 at 09:45', 'Presentation time update.', '2023-08-27 22:13:09', 'Unread'),
(41, '4148', 'Your prensentation date has been updated to: 2023-12-15 at 10:45', 'Presentation time update.', '2023-08-27 22:14:03', 'Unread'),
(42, '4148', 'Your prensentation date has been updated to: 12-12-2023 at 10:45:00', 'Presentation time update.', '2023-08-27 22:17:05', 'Unread'),
(43, '4148', 'Your prensentation date has been updated to: 13-12-2023 at 10:45:00', 'Presentation time update.', '2023-08-27 22:18:17', 'Unread'),
(44, '4148', 'Your prensentation date has been updated to: 2023-12-13 at 12:45', 'Presentation time update.', '2023-08-28 12:08:59', 'Unread'),
(45, '4148', 'Your prensentation date has been updated to: 2023-12-13 at 10:45', 'Presentation time update.', '2023-08-28 12:26:01', 'Unread'),
(46, '4148', 'Your prensentation date has been updated to: 13-09-2023 at 11:00', 'Presentation time update.', '2023-08-28 13:05:03', 'Unread'),
(47, '5130', 'Your prensentation date has been updated to: 30-08-2023 at 08:30:00', 'Presentation time update.', '2023-08-28 22:30:52', 'Unread'),
(48, '5130', 'Your prensentation date has been updated to: 2023-08-30 at 14:30', 'Presentation time update.', '2023-08-28 23:41:11', 'Unread');

-- --------------------------------------------------------

--
-- Table structure for table `reset_pwd_requests`
--

CREATE TABLE `reset_pwd_requests` (
  `id` int(11) NOT NULL,
  `trainee_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `query_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `result_id` int(11) NOT NULL,
  `trainee_id` int(11) NOT NULL,
  `grade` float NOT NULL,
  `question_code` varchar(5) NOT NULL,
  `season` varchar(4) NOT NULL DEFAULT year(curdate())
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `result`
--

INSERT INTO `result` (`result_id`, `trainee_id`, `grade`, `question_code`, `season`) VALUES
(1, 4, 3, 'Q-171', '2023'),
(2, 4, 2, 'Q-191', '2023'),
(3, 4, 3, 'Q-325', '2023'),
(4, 4, 5, 'Q-762', '2023'),
(5, 4, 3, 'Q-098', '2023'),
(6, 4, 4, 'Q-702', '2023'),
(7, 4, 2, 'Q-781', '2023'),
(8, 4, 1, 'Q-915', '2023'),
(9, 5, 3, 'Q-171', '2023'),
(10, 5, 2, 'Q-191', '2023'),
(11, 5, 3, 'Q-325', '2023'),
(12, 5, 5, 'Q-762', '2023'),
(13, 5, 5, 'Q-098', '2023'),
(14, 5, 4, 'Q-702', '2023'),
(15, 5, 3, 'Q-781', '2023'),
(16, 5, 4, 'Q-915', '2023'),
(17, 6, 3, 'Q-171', '2023'),
(18, 6, 2, 'Q-191', '2023'),
(19, 6, 3, 'Q-325', '2023'),
(20, 6, 5, 'Q-762', '2023'),
(21, 6, 3.5, 'Q-098', '2023'),
(22, 6, 7, 'Q-702', '2023'),
(23, 6, 2, 'Q-781', '2023'),
(24, 6, 4, 'Q-915', '2023');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `team_code` varchar(8) NOT NULL,
  `group_code` varchar(10) NOT NULL,
  `presentation_date` date DEFAULT NULL,
  `presentation_time` time DEFAULT NULL,
  `status` enum('Done','Ready','Not Ready') DEFAULT 'Not Ready'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`team_code`, `group_code`, `presentation_date`, `presentation_time`, `status`) VALUES
('4148', 'OAM201', '2023-09-13', '11:00:00', 'Done'),
('5130', 'WFS203', '2023-08-30', '14:30:00', 'Not Ready'),
('5192', 'OAM201', '2023-12-15', '15:30:00', 'Not Ready'),
('6396', 'WFS205', '2023-10-17', '00:00:00', 'Not Ready');

-- --------------------------------------------------------

--
-- Table structure for table `trainee`
--

CREATE TABLE `trainee` (
  `trainee_id` int(11) NOT NULL,
  `team_code` varchar(8) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `trainee_login` varchar(16) NOT NULL,
  `trainee_password` varchar(255) NOT NULL DEFAULT '246810',
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive',
  `email` varchar(255) DEFAULT 'trigger2000p@gmail.com'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainee`
--

INSERT INTO `trainee` (`trainee_id`, `team_code`, `fullname`, `trainee_login`, `trainee_password`, `status`, `email`) VALUES
(1, '5130', 'Othmane Nissoukin', 'loggin', 'loggin', 'active', 'email_sample@domain.xwz'),
(2, '5130', 'Ahmed Eljabary', '8Ha6RI', 'azerty123', 'active', 'email_sample@domain.xwz'),
(3, '5130', 'Conor Kenway', 'T25vUa', 'azerty123', 'inactive', 'email_sample@domain.xwz'),
(4, '4148', 'John Doe', 'TSgW3j', 'azerty123', 'inactive', 'email_sample@domain.xwz'),
(5, '4148', 'Ahmed Eljabary', 'KTcILN', 'azerty123', 'inactive', 'email_sample@domain.xwz'),
(6, '4148', 'Conor Kenway', 'jFLOgQ', 'azerty123', 'inactive', 'email_sample@domain.xwz');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts_to_activate`
--
ALTER TABLE `accounts_to_activate`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trainee_id` (`trainee_id`);

--
-- Indexes for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`question_code`);

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
  ADD KEY `notification_ibfk_1` (`team_code`);

--
-- Indexes for table `reset_pwd_requests`
--
ALTER TABLE `reset_pwd_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trainee_id` (`trainee_id`);

--
-- Indexes for table `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `idx_Registration_CustomizationSet` (`question_code`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`team_code`);

--
-- Indexes for table `trainee`
--
ALTER TABLE `trainee`
  ADD PRIMARY KEY (`trainee_id`),
  ADD UNIQUE KEY `trainee_login` (`trainee_login`),
  ADD KEY `team_code` (`team_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts_to_activate`
--
ALTER TABLE `accounts_to_activate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id_msg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `reset_pwd_requests`
--
ALTER TABLE `reset_pwd_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `result`
--
ALTER TABLE `result`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `trainee`
--
ALTER TABLE `trainee`
  MODIFY `trainee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts_to_activate`
--
ALTER TABLE `accounts_to_activate`
  ADD CONSTRAINT `accounts_to_activate_ibfk_1` FOREIGN KEY (`trainee_id`) REFERENCES `trainee` (`trainee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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

--
-- Constraints for table `reset_pwd_requests`
--
ALTER TABLE `reset_pwd_requests`
  ADD CONSTRAINT `reset_pwd_requests_ibfk_1` FOREIGN KEY (`trainee_id`) REFERENCES `trainee` (`trainee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `result`
--
ALTER TABLE `result`
  ADD CONSTRAINT `idx_Registration_CustomizationSet` FOREIGN KEY (`question_code`) REFERENCES `evaluation` (`question_code`) ON UPDATE CASCADE;

--
-- Constraints for table `trainee`
--
ALTER TABLE `trainee`
  ADD CONSTRAINT `trainee_ibfk_1` FOREIGN KEY (`team_code`) REFERENCES `team` (`team_code`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
