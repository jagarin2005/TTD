-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2017 at 06:47 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ttd`
--
CREATE DATABASE IF NOT EXISTS `ttd` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ttd`;

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` varchar(50) DEFAULT NULL,
  `booking_note` text,
  `booking_status` varchar(50) DEFAULT NULL,
  `booking_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `checklist`
--

CREATE TABLE `checklist` (
  `checklist_id` int(11) NOT NULL,
  `checklist_note` text NOT NULL,
  `check_status` varchar(50) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `noti_id` int(11) NOT NULL,
  `noti_title` text NOT NULL,
  `noti_type` varchar(30) NOT NULL,
  `noti_desc` text NOT NULL,
  `noti_status` tinyint(4) NOT NULL DEFAULT '0',
  `noti_link` varchar(30) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `score`
--

CREATE TABLE `score` (
  `staff_id` int(11) NOT NULL,
  `score_count` int(11) NOT NULL,
  `score_score` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `score`
--

INSERT IGNORE INTO `score` (`staff_id`, `score_count`, `score_score`) VALUES
(9, 0, '0.00'),
(10, 0, '0.00'),
(11, 0, '0.00'),
(12, 0, '0.00'),
(13, 0, '0.00'),
(14, 0, '0.00'),
(15, 0, '0.00'),
(16, 0, '0.00'),
(17, 0, '0.00'),
(18, 0, '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `scorelog`
--

CREATE TABLE `scorelog` (
  `sl_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `checklist_id` int(11) NOT NULL,
  `sl_score` int(11) DEFAULT NULL,
  `sl_note` text,
  `sl_active` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `s_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `s_date` date NOT NULL,
  `s_position` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shifts`
--

INSERT IGNORE INTO `shifts` (`s_id`, `staff_id`, `s_date`, `s_position`) VALUES
(38, 9, '2017-08-11', 'ว/น'),
(50, 11, '2017-08-09', 'ว/น'),
(51, 12, '2017-08-09', 'ว/น'),
(52, 10, '2017-08-10', 'น.2'),
(53, 15, '2017-08-10', 'ว/น'),
(55, 9, '2017-08-01', 'ว/น'),
(56, 10, '2017-08-03', 'น.2'),
(57, 11, '2017-08-03', 'น/ว'),
(58, 16, '2017-08-01', 'น/ว'),
(59, 12, '2017-08-02', 'น/ว'),
(60, 17, '2017-08-02', 'ว/น'),
(61, 13, '2017-08-03', 'ว/น'),
(62, 14, '2017-08-04', 'น/ว'),
(63, 16, '2017-08-04', 'ว/น'),
(64, 10, '2017-08-07', 'น.2'),
(66, 16, '2017-08-07', 'ว/น'),
(67, 14, '2017-08-08', 'น/ว'),
(68, 13, '2017-08-08', 'ว/น'),
(69, 9, '2017-08-16', 'น/ว'),
(70, 9, '2017-08-23', 'ว/น'),
(71, 9, '2017-08-31', 'น/ว'),
(72, 10, '2017-08-17', 'น.2'),
(73, 10, '2017-08-21', 'น.2'),
(74, 10, '2017-08-24', 'น.2'),
(75, 10, '2017-08-28', 'น.2'),
(76, 10, '2017-08-31', 'น.2'),
(77, 11, '2017-08-21', 'ว/น'),
(78, 11, '2017-08-24', 'ว/น'),
(79, 12, '2017-08-18', 'น/ว'),
(80, 12, '2017-08-23', 'น/ว'),
(81, 12, '2017-08-30', 'น/ว'),
(82, 14, '2017-08-11', 'น/ว'),
(83, 14, '2017-08-15', 'น/ว'),
(84, 14, '2017-08-18', 'ว/น'),
(85, 14, '2017-08-22', 'ว/น'),
(86, 14, '2017-08-25', 'น/ว'),
(87, 14, '2017-08-29', 'ว/น'),
(88, 17, '2017-08-07', 'น/ว'),
(89, 17, '2017-08-17', 'ว/น'),
(90, 17, '2017-08-22', 'น/ว'),
(91, 17, '2017-08-31', 'ว/น'),
(92, 15, '2017-08-24', 'น/ว'),
(93, 15, '2017-08-28', 'น/ว'),
(94, 15, '2017-08-30', 'ว/น'),
(95, 16, '2017-08-10', 'น/ว'),
(96, 16, '2017-08-16', 'ว/น'),
(97, 16, '2017-08-21', 'น/ว'),
(98, 16, '2017-08-25', 'ว/น'),
(99, 16, '2017-08-28', 'ว/น'),
(100, 13, '2017-08-15', 'ว/น'),
(101, 13, '2017-08-17', 'น/ว'),
(102, 13, '2017-08-29', 'น/ว'),
(104, 18, '2017-08-31', 'ว/น');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `staff_name` varchar(255) NOT NULL,
  `staff_email` varchar(255) NOT NULL,
  `staff_tel` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `staff_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `staff`
--

INSERT IGNORE INTO `staff` (`staff_id`, `staff_name`, `staff_email`, `staff_tel`, `user_id`, `staff_image`) VALUES
(9, 'อ.นพวรรณ์ พรศิริ', 's1@staff.com', '0000000000', 25, '/public/img/profile/อ_นพวรรณ์.png'),
(10, 'อ.สุภกฤษ บุตรจันทร์', 's2@staff.com', '0001000200', 26, '/public/img/profile/อ_สุภกฤษ.png'),
(11, 'อ.ศรินรัตน์ โคตะพันธ์', 's3@staff.com', '', 27, '/public/img/profile/อ_ศรินรัตน์.png'),
(12, 'อ.กุลนันทน์ จงนิมิตไพบูรย์', 's4@staff.com', '', 28, '/public/img/profile/อ_กุลนันทน์.png'),
(13, 'อ.กุลภัสร โภชนกุล', 's5@staff.com', '', 29, '/public/img/profile/อ_กุลภัสร.png'),
(14, 'อ.กุลิสรา เผ่าพันธ์', 's6@staff.com', '', 30, '/public/img/profile/อ_กุลิสรา.png'),
(15, 'อ.ศุภมาศ จารุจรณ', 's7@staff.com', '', 31, '/public/img/profile/อ_ศุภมาศ.png'),
(16, 'อ.นฤมล วิถีธรรมศักดิ์', 's8@staff.com', '', 32, '/public/img/profile/อ_นฤมล.png'),
(17, 'อ.อนรรฆนง ลิ้มสุวรรณ', 's9@staff.com', '', 33, '/public/img/profile/อ_อนรรฆนง.png');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL COMMENT 'รหัสผู้ใช้งาน',
  `user_email` varchar(50) NOT NULL COMMENT 'อีเมล์',
  `user_pwd` varchar(60) NOT NULL COMMENT 'รหัสผ่าน',
  `user_role` varchar(15) NOT NULL COMMENT 'เลเวลการใช้งาน',
  `user_name` varchar(255) NOT NULL COMMENT 'ชื่อ',
  `user_tel` varchar(10) DEFAULT NULL COMMENT 'เบอร์โทร',
  `user_sex` varchar(10) NOT NULL,
  `user_hash` varchar(128) DEFAULT '0',
  `user_active` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'สถานะการใช้งาน'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT IGNORE INTO `user` (`user_id`, `user_email`, `user_pwd`, `user_role`, `user_name`, `user_tel`, `user_sex`, `user_hash`, `user_active`) VALUES
(0, 'admin@admin', 'f5bb0c8de146c67b44babbf4e6584cc0', 'admin', 'Admin', '-', '-1', '0', 1),
(25, 's1@staff.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'staff', 'อ.นพวรรณ์ พรศิริ', '', 'หญิง', '0', 0),
(26, 's2@staff.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'staff', 'อ.สุภกฤษ บุตรจันทร์', '', 'ชาย', '0', 0),
(27, 's3@staff.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'staff', 'อ.ศรินรัตน์ โคตะพันธ์', '', 'หญิง', '0', 0),
(28, 's4@staff.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'staff', 'อ.กุลนันทน์ จงนิมิตไพบูรย์', '', 'หญิง', '0', 0),
(29, 's5@staff.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'staff', 'อ.กุลภัสร โภชนกุล', '', 'หญิง', '0', 0),
(30, 's6@staff.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'staff', 'อ.กุลิสรา เผ่าพันธ์', '', 'หญิง', '0', 0),
(31, 's7@staff.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'staff', 'อ.ศุภมาศ จารุจรณ', '', 'หญิง', '0', 0),
(32, 's8@staff.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'staff', 'อ.นฤมล วิถีธรรมศักดิ์', '', 'หญิง', '0', 0),
(33, 's9@staff.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'staff', 'อ.อนรรฆนง ลิ้มสุวรรณ', '', 'หญิง', '0', 0),
(34, 'u2@user.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'user', 'user 2', '1231231234', 'ชาย', '719a6e5ecb3067f0725a36f477404c5c', 0),
(35, 'user1@user.com', 'f5bb0c8de146c67b44babbf4e6584cc0', 'user', 'user 1', '1231231231', 'หญิง', '62dd7f109d002483515e4e226ef7a928', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `checklist`
--
ALTER TABLE `checklist`
  ADD PRIMARY KEY (`checklist_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`noti_id`);

--
-- Indexes for table `score`
--
ALTER TABLE `score`
  ADD UNIQUE KEY `med_id` (`staff_id`);

--
-- Indexes for table `scorelog`
--
ALTER TABLE `scorelog`
  ADD PRIMARY KEY (`sl_id`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `checklist`
--
ALTER TABLE `checklist`
  MODIFY `checklist_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `noti_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `scorelog`
--
ALTER TABLE `scorelog`
  MODIFY `sl_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;
--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสผู้ใช้งาน', AUTO_INCREMENT=36;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
