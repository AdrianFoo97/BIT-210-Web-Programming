-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2019 at 10:12 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assignment2`
--

-- --------------------------------------------------------

--
-- Table structure for table `group training`
--

CREATE TABLE `group training` (
  `no` int(255) NOT NULL,
  `sessionID` int(255) NOT NULL,
  `groupType` varchar(255) NOT NULL,
  `maxNum` int(255) NOT NULL,
  `currentNum` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `group training`
--

INSERT INTO `group training` (`no`, `sessionID`, `groupType`, `maxNum`, `currentNum`) VALUES
(2, 5, 'Dance', 2, 0),
(3, 6, 'Dance', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `no` int(255) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`no`, `userName`, `level`) VALUES
(2, 'member', 'advanced');

-- --------------------------------------------------------

--
-- Table structure for table `personal training`
--

CREATE TABLE `personal training` (
  `no` int(255) NOT NULL,
  `sessionID` int(255) NOT NULL,
  `notes` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `personal training`
--

INSERT INTO `personal training` (`no`, `sessionID`, `notes`) VALUES
(3, 4, ''),
(4, 7, '');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `no` int(255) NOT NULL,
  `sessionID` int(255) NOT NULL,
  `rating` double(3,2) NOT NULL,
  `comments` varchar(255) NOT NULL,
  `member` varchar(255) NOT NULL,
  `timeStamp` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `trainer`
--

CREATE TABLE `trainer` (
  `userName` varchar(255) NOT NULL,
  `specialty` int(255) NOT NULL,
  `rating` double(3,2) NOT NULL,
  `reviewNum` int(255) NOT NULL,
  `no` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `trainer`
--

INSERT INTO `trainer` (`userName`, `specialty`, `rating`, `reviewNum`, `no`) VALUES
('123', 0, 0.00, 0, 1),
('345', 0, 0.00, 0, 2),
('trainer', 0, 0.00, 0, 3),
('trainer2', 0, 0.00, 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `training session`
--

CREATE TABLE `training session` (
  `sessionID` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `fee` double(7,2) NOT NULL,
  `status` varchar(255) NOT NULL,
  `classType` varchar(255) NOT NULL,
  `trainer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `training session`
--

INSERT INTO `training session` (`sessionID`, `title`, `date`, `time`, `fee`, `status`, `classType`, `trainer`) VALUES
(4, 'Personal Session 1', '2022-10-13', '09:00', 255.00, 'AVAILABLE', 'personal', 'trainer'),
(5, 'Group Session 1', '2022-03-17', '09:09', 456.00, 'AVAILABLE', 'group', 'trainer'),
(6, 'Group Session 2', '2022-11-24', '09:09', 555.00, 'AVAILABLE', 'group', 'trainer2'),
(7, 'Personal Session 2', '2030-02-03', '21:09', 304.00, 'AVAILABLE', 'personal', 'trainer2');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userName` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userType` varchar(255) NOT NULL,
  `profilePic` varchar(255) NOT NULL,
  `no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userName`, `password`, `fullName`, `email`, `userType`, `profilePic`, `no`) VALUES
('trainer', 'trainer', 'trainer name', 'trainer@123.gmail.com', 'trainer', '', 4),
('trainer2', 'trainer2', 'trainer2 name', 'trainer2@gmail.com', 'trainer', '', 5),
('member', 'member', 'member name', 'member@123.com', 'member', '', 6);

-- --------------------------------------------------------

--
-- Table structure for table `user_session`
--

CREATE TABLE `user_session` (
  `no` int(11) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `sessionID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_session`
--

INSERT INTO `user_session` (`no`, `userName`, `sessionID`) VALUES
(5, 'trainer', 4),
(6, 'trainer', 5),
(7, 'trainer2', 6),
(8, 'trainer2', 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `group training`
--
ALTER TABLE `group training`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `personal training`
--
ALTER TABLE `personal training`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `trainer`
--
ALTER TABLE `trainer`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `training session`
--
ALTER TABLE `training session`
  ADD PRIMARY KEY (`sessionID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `user_session`
--
ALTER TABLE `user_session`
  ADD PRIMARY KEY (`no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `group training`
--
ALTER TABLE `group training`
  MODIFY `no` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `no` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal training`
--
ALTER TABLE `personal training`
  MODIFY `no` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `no` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trainer`
--
ALTER TABLE `trainer`
  MODIFY `no` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `training session`
--
ALTER TABLE `training session`
  MODIFY `sessionID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_session`
--
ALTER TABLE `user_session`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
