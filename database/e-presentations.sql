-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2023 at 03:19 PM
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
-- Table structure for table `evaluation`
--

CREATE TABLE `evaluation` (
  `evaluation_code` varchar(12) NOT NULL,
  `question_code` int(11) NOT NULL,
  `question_content` text NOT NULL,
  `question_scale` float NOT NULL,
  `question_topic` enum('presentation','report') DEFAULT NULL,
  `season` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evaluation`
--

INSERT INTO `evaluation` (`evaluation_code`, `question_code`, `question_content`, `question_scale`, `question_topic`, `season`) VALUES
('E-551', 4, 'Report question #1', 4, 'report', '2023'),
('E-551', 5, 'Report question #2', 6, 'report', '2023'),
('E-551', 6, 'Report question #3', 5, 'report', '2023'),
('E-551', 7, 'Presentation question #1', 6, 'presentation', '2023'),
('E-551', 8, 'Presentation question #2', 4, 'presentation', '2023');

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
(11, '0616', 'uploads/WFS205_0616/Presentation.pptx', 'presentation', 'Shay Cormac', '2023-07-27 22:50:27'),
(12, '0616', 'uploads/WFS205_0616/Report.pdf', 'report', 'Shay Cormac', '2023-07-27 22:50:47'),
(14, '9765', 'uploads/OAM201_9765/Presentation.pptx', 'presentation', 'Haytham Kenway', '2023-07-28 10:44:29'),
(15, '9765', 'https://github.com/OthmaneNissoukin/demo-interns', 'application', 'Haytham Kenway', '2023-07-28 10:44:53'),
(16, '9765', 'uploads/OAM201_9765/Report.pdf', 'report', 'Haytham Kenway', '2023-07-28 10:45:23');

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

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `result_id` int(11) NOT NULL,
  `question_code` int(11) NOT NULL,
  `trainee_id` int(11) NOT NULL,
  `grade` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `result`
--

INSERT INTO `result` (`result_id`, `question_code`, `trainee_id`, `grade`) VALUES
(250, 4, 1, 4),
(251, 5, 1, 4),
(252, 6, 1, 4),
(253, 7, 1, 4),
(254, 8, 1, 4),
(255, 4, 2, 4),
(256, 5, 2, 4),
(257, 6, 2, 4),
(258, 7, 2, 4),
(259, 8, 2, 4),
(260, 4, 1, 4),
(261, 5, 1, 5),
(262, 6, 1, 3),
(263, 7, 1, 6),
(264, 8, 1, 2),
(265, 4, 2, 4),
(266, 5, 2, 2),
(267, 6, 2, 5),
(268, 7, 2, 6),
(269, 8, 2, 2),
(270, 4, 1, 4),
(271, 5, 1, 5),
(272, 6, 1, 3),
(273, 7, 1, 6),
(274, 8, 1, 2),
(275, 4, 2, 4),
(276, 5, 2, 2),
(277, 6, 2, 5),
(278, 7, 2, 6),
(279, 8, 2, 2),
(280, 4, 1, 4),
(281, 5, 1, 4),
(282, 6, 1, 4),
(283, 7, 1, 5),
(284, 8, 1, 4),
(285, 4, 2, 4),
(286, 5, 2, 4),
(287, 6, 2, 4),
(288, 7, 2, 4),
(289, 8, 2, 4),
(290, 4, 1, 4),
(291, 5, 1, 4),
(292, 6, 1, 4),
(293, 7, 1, 5),
(294, 8, 1, 4),
(295, 4, 2, 4),
(296, 5, 2, 4),
(297, 6, 2, 4),
(298, 7, 2, 4),
(299, 8, 2, 4),
(300, 4, 1, 4),
(301, 5, 1, 4),
(302, 6, 1, 4),
(303, 7, 1, 5),
(304, 8, 1, 4),
(305, 4, 2, 4),
(306, 5, 2, 4),
(307, 6, 2, 4),
(308, 7, 2, 4),
(309, 8, 2, 4),
(310, 4, 1, 4),
(311, 5, 1, 4),
(312, 6, 1, 4),
(313, 7, 1, 4),
(314, 8, 1, 4),
(315, 4, 2, 4),
(316, 5, 2, 4),
(317, 6, 2, 4),
(318, 7, 2, 4),
(319, 8, 2, 4),
(320, 4, 1, 4),
(321, 5, 1, 4),
(322, 6, 1, 4),
(323, 7, 1, 2),
(324, 8, 1, 1),
(325, 4, 2, 4),
(326, 5, 2, 4),
(327, 6, 2, 4),
(328, 7, 2, 2),
(329, 8, 2, 1),
(330, 4, 1, 4),
(331, 5, 1, 4),
(332, 6, 1, 4),
(333, 7, 1, 2),
(334, 8, 1, 1),
(335, 4, 2, 4),
(336, 5, 2, 4),
(337, 6, 2, 4),
(338, 7, 2, 2),
(339, 8, 2, 1),
(340, 4, 1, 4),
(341, 5, 1, 4),
(342, 6, 1, 4),
(343, 7, 1, 4),
(344, 8, 1, 4),
(345, 4, 2, 4),
(346, 5, 2, 4),
(347, 6, 2, 4),
(348, 7, 2, 4),
(349, 8, 2, 4);

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
('0616', 'WFS205', '2023-09-20', '12:30:00', 'Not Ready'),
('2691', 'WFS203', '2023-08-15', '14:30:00', 'Not Ready'),
('5522', 'WFS205', '2023-08-13', '10:45:00', 'Not Ready'),
('9765', 'OAM201', '2023-08-17', '08:30:00', 'Ready');

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
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainee`
--

INSERT INTO `trainee` (`trainee_id`, `team_code`, `fullname`, `trainee_login`, `trainee_password`, `status`) VALUES
(1, '0616', 'Othmane Nissoukin', 'loggin', '246810', 'inactive'),
(2, '0616', 'Shay Cormac', 'login', '246810', 'inactive'),
(3, '9765', 'Haytham Kenway', 'udohx9', 'Azerty123@', 'active'),
(4, '9765', 'Shay Cormac', 'BWrxem', 'azerty123', 'inactive'),
(5, '9765', 'Conor Kenway', 'Mvzeq6', 'azerty123', 'inactive'),
(6, '5522', 'John Doe', 'ALyghl', 'azerty123', 'inactive'),
(7, '2691', 'Jane Doe', 'ACH3jG', 'azerty123', 'inactive');

--
-- Indexes for dumped tables
--

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
  ADD KEY `team_code` (`team_code`);

--
-- Indexes for table `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`result_id`);

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
-- AUTO_INCREMENT for table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `question_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id_msg` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `result`
--
ALTER TABLE `result`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=350;

--
-- AUTO_INCREMENT for table `trainee`
--
ALTER TABLE `trainee`
  MODIFY `trainee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`team_code`) REFERENCES `team` (`team_code`) ON DELETE CASCADE;

--
-- Constraints for table `result`
--
ALTER TABLE `result`
  ADD CONSTRAINT `result_ibfk_1` FOREIGN KEY (`question_code`) REFERENCES `evaluation` (`question_code`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `result_ibfk_2` FOREIGN KEY (`trainee_id`) REFERENCES `trainee` (`trainee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `trainee`
--
ALTER TABLE `trainee`
  ADD CONSTRAINT `trainee_ibfk_1` FOREIGN KEY (`team_code`) REFERENCES `team` (`team_code`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
