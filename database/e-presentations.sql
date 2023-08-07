-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2023 at 08:28 PM
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
('E-084', 'Q-177', 'New question #3', 15, 'presentation', '2023'),
('E-475', 'Q-234', 'Question #21', 20, 'presentation', '2023'),
('E-084', 'Q-257', 'New question #1', 5, 'report', '2023'),
('E-084', 'Q-377', 'New question #1', 5, 'presentation', '2023'),
('E-985', 'Q-456', 'Presentation question #1', 6, 'presentation', '2023'),
('E-985', 'Q-589', 'Report #3', 4, 'report', '2023'),
('E-985', 'Q-597', 'Presentation question #2', 6, 'presentation', '2023'),
('E-985', 'Q-599', 'Report #1', 4, 'report', '2023'),
('E-475', 'Q-643', 'Question #20', 20, 'report', '2023'),
('E-985', 'Q-658', 'Presentation question #3', 3, 'presentation', '2023'),
('E-985', 'Q-659', 'Report #2', 5, 'report', '2023'),
('E-084', 'Q-705', 'New question #2', 5, 'report', '2023'),
('E-084', 'Q-862', 'New question #3', 5, 'report', '2023'),
('E-084', 'Q-875', 'New question #2', 5, 'presentation', '2023');

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
(61, 1, 2, 'Q-589', '2023'),
(62, 1, 2, 'Q-599', '2023'),
(63, 1, 2, 'Q-659', '2023'),
(64, 1, 1, 'Q-456', '2023'),
(65, 1, 1, 'Q-597', '2023'),
(66, 1, 1, 'Q-658', '2023'),
(67, 2, 2, 'Q-589', '2023'),
(68, 2, 2, 'Q-599', '2023'),
(69, 2, 2, 'Q-659', '2023'),
(70, 2, 3, 'Q-456', '2023'),
(71, 2, 3, 'Q-597', '2023'),
(72, 2, 3, 'Q-658', '2023'),
(73, 3, 2, 'Q-589', '2023'),
(74, 3, 2, 'Q-599', '2023'),
(75, 3, 2, 'Q-659', '2023'),
(76, 3, 3, 'Q-456', '2023'),
(77, 3, 3, 'Q-597', '2023'),
(78, 3, 3, 'Q-658', '2023');

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
('4148', 'OAM201', NULL, NULL, 'Not Ready'),
('5130', 'WFS203', '2023-08-20', '08:30:00', 'Not Ready');

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
(1, '5130', 'Othmane Nissoukin', 'loggin', 'loggin', 'active'),
(2, '5130', 'Ahmed Eljabary', '8Ha6RI', 'azerty123', 'inactive'),
(3, '5130', 'Conor Kenway', 'T25vUa', 'azerty123', 'inactive'),
(4, '4148', 'John Doe', 'TSgW3j', 'azerty123', 'inactive'),
(5, '4148', 'Ahmed Eljabary', 'KTcILN', 'azerty123', 'inactive'),
(6, '4148', 'Conor Kenway', 'jFLOgQ', 'azerty123', 'inactive');

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
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id_msg` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `result`
--
ALTER TABLE `result`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `trainee`
--
ALTER TABLE `trainee`
  MODIFY `trainee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- Constraints for table `trainee`
--
ALTER TABLE `trainee`
  ADD CONSTRAINT `trainee_ibfk_1` FOREIGN KEY (`team_code`) REFERENCES `team` (`team_code`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
