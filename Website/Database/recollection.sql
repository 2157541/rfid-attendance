-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2020 at 11:13 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recollection`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(6) NOT NULL,
  `course_name` text NOT NULL,
  `school_id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_name`, `school_id`) VALUES
(101, 'BS IT', 1),
(102, 'BS CS', 1),
(103, 'BS Math', 1),
(104, 'BS HTM', 1),
(201, 'BS Archi', 2),
(202, 'BS Chem Eng', 2);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `sched_id` int(6) NOT NULL,
  `sched_date` date NOT NULL,
  `sched_time_start` time(1) NOT NULL,
  `sched_time_end` time(1) NOT NULL,
  `recollection_master` text DEFAULT NULL,
  `venue` text NOT NULL,
  `term` varchar(15) NOT NULL,
  `academic_year` varchar(15) NOT NULL,
  `recollection_description` text DEFAULT NULL,
  `year_level` varchar(8) NOT NULL,
  `course_id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`sched_id`, `sched_date`, `sched_time_start`, `sched_time_end`, `recollection_master`, `venue`, `term`, `academic_year`, `recollection_description`, `year_level`, `course_id`) VALUES
(1111, '2019-11-13', '08:00:00.0', '16:00:00.0', NULL, 'Frances Gevers Hall, Slu Main', '1st', '2018-2019', NULL, '1st Year', 101),
(1002, '2019-11-13', '08:00:00.0', '16:00:00.0', NULL, 'Frances Gevers Hall, Slu Main', '1st', '2018-2019', NULL, '1st Year', 102),
(1003, '2017-11-02', '08:00:00.0', '16:00:00.0', NULL, 'Frances Gevers Hall, Slu Main', '1st', '2016-2017', NULL, '1st year', 103),
(1012, '2018-11-02', '08:00:00.0', '16:00:00.0', NULL, 'Frances Gevers Hall, Slu Main', '1st', '2017-2018', NULL, '1st year', 202),
(2002, '2020-11-02', '08:00:00.0', '16:00:00.0', NULL, 'Frances Gevers Hall, Slu Main', '1st', '2019-2020', NULL, '2nd year', 102),
(2012, '2019-11-02', '08:00:00.0', '16:00:00.0', NULL, 'Frances Gevers Hall, Slu Main', '1st', '2018-2019', NULL, '2nd year', 202),
(2003, '2018-11-03', '08:00:00.0', '16:00:00.7', NULL, 'Frances Gevers Hall, Slu Main', '1st', '2017-2018', NULL, '2nd year', 103),
(3003, '2019-11-04', '08:00:00.0', '16:00:00.0', NULL, 'Frances Gevers Hall, Slu Main', '1st', '2018-2019', NULL, '3rd year', 103),
(3012, '2020-11-02', '08:00:00.0', '16:00:00.0', NULL, 'Frances Gevers Hall, Slu Main', '1st', '2019-2020', NULL, '3rd year', 202),
(4003, '2020-11-05', '08:00:00.0', '16:00:00.0', NULL, 'Frances Gevers Hall, Slu Main', '1st', '2019-2020', NULL, '4th year', 103);

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE `school` (
  `school_id` int(6) NOT NULL,
  `school_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`school_id`, `school_name`) VALUES
(1, 'SAMCIS'),
(2, 'SEA');

-- --------------------------------------------------------

--
-- Table structure for table `student_attendance`
--

CREATE TABLE `student_attendance` (
  `id_number` int(11) NOT NULL,
  `sched_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `attendance_am` time DEFAULT NULL,
  `attendance_pm` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_attendance`
--

INSERT INTO `student_attendance` (`id_number`, `sched_id`, `year`, `attendance_am`, `attendance_pm`) VALUES
(2190000, 1111, 1, '08:02:00', '16:00:00'),
(2190001, 1111, 1, '08:02:00', '16:00:00'),
(2190002, 1111, 1, '08:02:00', '16:00:00'),
(2190003, 1111, 1, '08:02:00', '16:00:00'),
(2190004, 1111, 1, '08:02:00', '16:00:00'),
(2190005, 1111, 1, '08:02:00', '16:00:00'),
(2190006, 1111, 1, '08:02:00', '16:00:00'),
(2190007, 1111, 1, '08:02:00', '16:00:00'),
(2190008, 1111, 1, '08:02:00', '16:00:00'),
(2190009, 1111, 1, '08:02:00', '16:00:00'),
(2192001, 1002, 1, '08:02:00', '16:00:00'),
(2192002, 1002, 1, '08:14:00', '16:00:00'),
(2192003, 1002, 1, '08:05:00', '16:00:00'),
(2192004, 1002, 1, '08:07:00', '16:00:00'),
(2192001, 2002, 2, '08:02:00', '16:00:00'),
(2192002, 2002, 2, '08:19:00', '16:00:00'),
(2192003, 2002, 2, '08:05:00', '16:00:00'),
(2192004, 2002, 2, '08:07:00', '16:00:00'),
(2183001, 1012, 1, '08:07:00', '16:00:00'),
(2183002, 1012, 1, '08:07:00', '16:00:00'),
(2183003, 1012, 1, '08:07:00', '16:00:00'),
(2183004, 1012, 1, '08:07:00', '16:00:00'),
(2183001, 2012, 2, '08:07:00', '16:00:00'),
(2183002, 2012, 2, '08:07:00', '16:00:00'),
(2183003, 2012, 2, '08:07:00', '16:00:00'),
(2183004, 2012, 2, '08:07:00', '16:00:00'),
(2183001, 3012, 3, '08:07:00', '16:00:00'),
(2183002, 3012, 3, '08:07:00', '16:00:00'),
(2183003, 3012, 3, '08:07:00', '16:00:00'),
(2183004, 3012, 3, '08:16:00', '16:00:00'),
(2174001, 1003, 1, '08:02:00', '16:00:00'),
(2174002, 1003, 1, '08:12:00', '16:00:00'),
(2174003, 1003, 1, '08:05:00', '16:00:00'),
(2174004, 1003, 1, '08:07:00', '16:00:00'),
(2174001, 2003, 2, '08:14:00', '16:00:00'),
(2174002, 2003, 2, '08:03:00', '16:00:00'),
(2174003, 2003, 2, '08:16:00', '16:00:00'),
(2174004, 2003, 2, '08:02:00', '16:00:00'),
(2174001, 3003, 3, '08:10:00', '16:00:00'),
(2174002, 3003, 3, '08:12:00', '16:00:00'),
(2174003, 3003, 3, '08:06:00', '16:00:00'),
(2174004, 3003, 3, '08:02:00', '16:00:00'),
(2174001, 4003, 4, '08:04:00', '16:00:00'),
(2174002, 4003, 4, '08:02:00', '16:00:00'),
(2174003, 4003, 4, '08:08:00', '16:00:00'),
(2174004, 4003, 4, '08:09:00', '16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `student_history`
--

CREATE TABLE `student_history` (
  `id_number` int(11) NOT NULL,
  `1st_year` varchar(10) DEFAULT NULL,
  `2nd_year` varchar(10) DEFAULT NULL,
  `3rd_year` varchar(10) DEFAULT NULL,
  `4th_year` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_history`
--

INSERT INTO `student_history` (`id_number`, `1st_year`, `2nd_year`, `3rd_year`, `4th_year`) VALUES
(2190000, 'Completed', '', '', ''),
(2190001, 'Completed', '', '', ''),
(2190002, 'Completed', '', '', ''),
(2190003, 'Completed', '', '', ''),
(2190004, 'Completed', '', '', ''),
(2190005, 'Completed', '', '', ''),
(2190006, 'Completed', '', '', ''),
(2190007, 'Completed', '', '', ''),
(2190008, 'Completed', '', '', ''),
(2190009, 'Completed', '', '', ''),
(2192001, 'Completed', 'Completed', '', ''),
(2192002, 'Completed', 'ABSENT', '', ''),
(2192003, 'Completed', 'Completed', '', ''),
(2192004, 'Completed', 'Completed', '', ''),
(2183001, 'Completed', 'Completed', 'Completed', ''),
(2183002, 'Completed', 'Completed', 'Completed', ''),
(2183003, 'Completed', 'Completed', 'Completed', ''),
(2183004, 'Completed', 'Completed', 'ABSENT', ''),
(2174001, 'Completed', 'Completed', 'Completed', 'Completed'),
(2174002, 'Completed', 'Completed', 'Completed', 'Completed'),
(2174003, 'Completed', 'ABSENT', 'Completed', 'Completed'),
(2174004, 'Completed', 'Completed', 'Completed', 'ABSENT');

-- --------------------------------------------------------

--
-- Table structure for table `student_info`
--

CREATE TABLE `student_info` (
  `id_number` int(6) NOT NULL,
  `course` varchar(20) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `year` int(11) NOT NULL,
  `gender` varchar(2) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_info`
--

INSERT INTO `student_info` (`id_number`, `course`, `fname`, `lname`, `year`, `gender`, `status`) VALUES
(2190000, 'BS IT','Mark','Justin',1,'M','Enrolled'),
(2190001, 'BS IT','Eric','Marlety',1,'M','Enrolled'),
(2190002, 'BS IT','Choco','Late',1,'M','Enrolled'),
(2190003, 'BS IT','Ed','Sheraan',1,'M','Enrolled'),
(2190004, 'BS IT','Bella','Throne',1,'F','Enrolled'),
(2190005, 'BS IT','Justine','Timberlake',1,'M','Enrolled'),
(2190006, 'BS IT','Sam','Son',1,'M','Enrolled'),
(2190007, 'BS IT','Let','Melive',1,'M','Enrolled'),
(2190008, 'BS IT','Josh','John',1,'M','Enrolled'),
(2190009, 'BS IT','Hendrix','Comaad Sr',1,'M','Enrolled'),
(2192001, 'BS CS','James','Mark', 2, 'M', 'Enrolled'),
(2192002, 'BS CS','Jordan','John', 2, 'M', 'Enrolled'),
(2192003, 'BS CS','Jordan','James', 2, 'M', 'Enrolled'),
(2192004, 'BS CS','Johnson','Jose', 2, 'M', 'Enrolled'),
(2183001, 'BS Chem Eng', 'Hendrix', 'James', 3, 'M', 'Enrolled'),
(2183002, 'BS Chem Eng', 'Adam', 'De Guzman', 3, 'M', 'Enrolled'),
(2183003, 'BS Chem Eng', 'Omar', 'Benladin', 3, 'M', 'Enrolled'),
(2183004, 'BS Chem Eng', 'Osama', 'Maute', 3, 'M', 'Enrolled'),
(2174001, 'BS Math', 'Manny', 'Pugyao', 4, 'M', 'Enrolled'),
(2174002, 'BS Math', 'Lito', 'Folayang', 4, 'M', 'Enrolled'),
(2174003, 'BS Math', 'Geje', 'Adiwang', 4, 'M', 'Enrolled'),
(2174004, 'BS Math', 'Mcgregor', 'Nurmagomedov', 4, 'M', 'Enrolled');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(80) NOT NULL,
  `name` varchar(80) NOT NULL,
  `password` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `password`) VALUES
(1, 'user', 'user', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`sched_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`school_id`);

--
-- Indexes for table `student_attendance`
--
ALTER TABLE `student_attendance`
  ADD KEY `student_attendance_ibfk_1` (`id_number`),
  ADD KEY `sched_id` (`sched_id`);

--
-- Indexes for table `student_history`
--
ALTER TABLE `student_history`
  ADD KEY `id_number` (`id_number`);

--
-- Indexes for table `student_info`
--
ALTER TABLE `student_info`
  ADD PRIMARY KEY (`id_number`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `school` (`school_id`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_attendance`
--
ALTER TABLE `student_attendance`
  ADD CONSTRAINT `student_attendance_ibfk_1` FOREIGN KEY (`id_number`) REFERENCES `student_info` (`id_number`),
  ADD CONSTRAINT `student_attendance_ibfk_2` FOREIGN KEY (`sched_id`) REFERENCES `schedule` (`sched_id`);

--
-- Constraints for table `student_history`
--
ALTER TABLE `student_history`
  ADD CONSTRAINT `student_history_ibfk_1` FOREIGN KEY (`id_number`) REFERENCES `student_info` (`id_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
