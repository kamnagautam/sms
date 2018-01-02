-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2018 at 09:19 AM
-- Server version: 5.7.11
-- PHP Version: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sms`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendance`
--

CREATE TABLE `tbl_attendance` (
  `attendanceid` int(11) NOT NULL,
  `attendancedate` date NOT NULL,
  `userid` varchar(50) NOT NULL,
  `attendance` varchar(50) NOT NULL,
  `remarks` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_attendance`
--

INSERT INTO `tbl_attendance` (`attendanceid`, `attendancedate`, `userid`, `attendance`, `remarks`) VALUES
(6, '2017-12-28', 'Neha', 'A', ''),
(5, '2017-12-28', 'Rakesh', 'P', ''),
(4, '2017-12-28', 'rohit', 'P', ''),
(7, '2017-12-29', 'rohit', 'P', ''),
(8, '2017-12-29', 'Rakesh', 'P', ''),
(9, '2017-12-29', 'Neha', 'P', ''),
(10, '2017-12-30', 'rohit', 'P', ''),
(11, '2017-12-30', 'Rakesh', 'P', ''),
(12, '2017-12-30', 'Neha', 'P', ''),
(13, '2017-12-26', 'rohit', 'P', NULL),
(14, '2017-12-26', 'Rakesh', 'P', NULL),
(15, '2017-12-26', 'Neha', 'P', NULL),
(16, '2018-01-01', 'rohit', 'P', NULL),
(17, '2018-01-01', 'Rakesh', 'P', NULL),
(18, '2018-01-01', 'Neha', 'A', NULL),
(19, '2018-01-02', 'rohit', 'P', NULL),
(20, '2018-01-02', 'Rakesh', 'A', NULL),
(21, '2018-01-02', 'Neha', 'P', NULL),
(45, '2018-01-06', 'Neha', 'P', NULL),
(44, '2018-01-06', 'Rakesh', 'P', NULL),
(43, '2018-01-06', 'rohit', 'P', NULL),
(42, '2018-01-05', 'Neha', 'P', NULL),
(41, '2018-01-05', 'Rakesh', 'A', NULL),
(40, '2018-01-05', 'rohit', 'A', NULL),
(39, '2018-01-04', 'Neha', 'P', NULL),
(38, '2018-01-04', 'Rakesh', 'P', NULL),
(37, '2018-01-04', 'rohit', 'A', NULL),
(36, '2018-01-03', 'Neha', 'A', NULL),
(35, '2018-01-03', 'Rakesh', 'P', NULL),
(34, '2018-01-03', 'rohit', 'P', NULL),
(46, '2018-01-08', 'rohit', 'P', NULL),
(58, '2018-01-12', 'Neha', 'P', NULL),
(52, '2018-01-12', 'rohit', 'P', NULL),
(53, '2018-01-12', 'Rakesh', 'P', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_booking`
--

CREATE TABLE `tbl_booking` (
  `bookingid` int(11) NOT NULL,
  `bookingdate` date NOT NULL,
  `userid` varchar(50) NOT NULL,
  `adminstatus` varchar(50) DEFAULT NULL,
  `remarks` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_booking`
--

INSERT INTO `tbl_booking` (`bookingid`, `bookingdate`, `userid`, `adminstatus`, `remarks`) VALUES
(9, '2018-01-03', 'Neha', 'accept', ''),
(8, '2018-01-04', 'Rakesh', 'accept', ''),
(7, '2018-01-01', 'Rakesh', '', ''),
(6, '2018-01-01', 'rohit', 'accept', ''),
(10, '2018-01-05', 'rohit', 'accept', ''),
(11, '2018-01-03', 'Neha', '', ''),
(12, '2018-01-02', 'rohit', NULL, NULL),
(13, '2018-01-10', 'rohit', NULL, NULL),
(14, '2018-01-10', 'Rakesh', '', ''),
(15, '2018-01-11', 'Rakesh', '', ''),
(16, '2018-01-17', 'rohit', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `userid` varchar(50) NOT NULL,
  `hashpassword` varchar(100) NOT NULL,
  `usertype` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` varchar(200) DEFAULT NULL,
  `phone` varchar(14) DEFAULT NULL,
  `course` varchar(50) DEFAULT NULL,
  `remarks` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`userid`, `hashpassword`, `usertype`, `username`, `email`, `address`, `phone`, `course`, `remarks`) VALUES
('rohit', '$2y$10$NmUxZWM2NTg1Yjg1YWVjM.k/t91jkTLfHuHKkXcZiOnjBt78wt5KG', 'student', 'Rohit Kumar', 'rohit345@gmail.com', 'Delhi', '5467894323', 'B.Tech-1', ''),
('Rakesh', '$2y$10$NWUwZmVlZGMyM2YxYzE5Z.kn6EhWLaDiyRXwbuhfFrSAN8LhHhevu', 'student', 'Rakesh Kumar', 'rakesh123@gmail.com', 'Amritsar', '9900876567', 'B.Tech-2', ''),
('Pradeep', '$2y$10$NzQ1ZWMwNzYzMzg3NjIxMux3PwvFqxgV0mIn4mY4aywpqyQ/YGRjW', 'attendant', 'Pradeep Gupta', 'pradeep234@gmail.com', 'Ludhiana', '8463529834', '', ''),
('admin', '$2y$10$NjlhMTQ1NTFiMzIzYzRlMuqO2PWpfpFCNMeqSn71JSoFthq.2fTdy', 'admin', 'Administrator', 'admin@sms.com', 'Amritsar', '3424819345', '', ''),
('Neha', '$2y$10$ZDlkOWZmY2Q5MDkxMTFiYOaFuplI/ZjdJssjeY2O35wyTurHXwzsu', 'student', 'Neha Sharma', 'neha672@gmail.com', 'Gurgaon', '7634526395', 'B.Tech-2', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD PRIMARY KEY (`attendanceid`);

--
-- Indexes for table `tbl_booking`
--
ALTER TABLE `tbl_booking`
  ADD PRIMARY KEY (`bookingid`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  MODIFY `attendanceid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `tbl_booking`
--
ALTER TABLE `tbl_booking`
  MODIFY `bookingid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
