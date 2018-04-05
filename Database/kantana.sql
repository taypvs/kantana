-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 04, 2018 at 06:01 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kantana`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `update_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `username`, `password`, `update_date`) VALUES
(1, 'Kantana Admin', 'kantana', 'JRnaWt6d9lCJXjKbAfrYOQ==:RjhzcXZCbUpUNXUzUWNCTklpMzFiQT09', '2018-03-31');

-- --------------------------------------------------------

--
-- Table structure for table `Career`
--

CREATE TABLE `Career` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `type` varchar(25) NOT NULL,
  `salary_max` int(15) NOT NULL,
  `salary_min` int(15) NOT NULL,
  `start_date` date NOT NULL,
  `close_date` date NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  `active` int(11) NOT NULL,
  `delete` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Career`
--

INSERT INTO `Career` (`id`, `title`, `location`, `type`, `salary_max`, `salary_min`, `start_date`, `close_date`, `created_date`, `updated_date`, `active`, `delete`) VALUES
(13, 'Technical Leader', 'Ha Noi', 'Full Time', 18000000, 12000000, '2018-04-07', '2018-04-18', '2018-04-03', '2018-04-04', 1, 0),
(14, 'Senior Graphic Designer ', 'Ho Chi Minh', 'Full Time', 15000000, 8000000, '2018-04-07', '2018-04-23', '2018-04-03', '2018-04-03', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `CareerApplication`
--

CREATE TABLE `CareerApplication` (
  `id` int(11) NOT NULL,
  `career_id` int(11) NOT NULL,
  `cv_file` varchar(255) DEFAULT NULL,
  `cv_link` varchar(255) DEFAULT NULL,
  `portfolio_link` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `references_from` varchar(255) DEFAULT NULL,
  `post_date` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `active` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `CareerApplication`
--

INSERT INTO `CareerApplication` (`id`, `career_id`, `cv_file`, `cv_link`, `portfolio_link`, `start_date`, `references_from`, `post_date`, `status`, `active`) VALUES
(2, 14, '1494146386_huyenttk-cv.pdf', '', '', '2018-05-01', 'facebook', '2018-04-04', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `CareerDescriptionItem`
--

CREATE TABLE `CareerDescriptionItem` (
  `id` int(11) NOT NULL,
  `career_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `CareerDescriptionItem`
--

INSERT INTO `CareerDescriptionItem` (`id`, `career_id`, `content`, `created_date`) VALUES
(37, 14, 'Senior Graphic Designer Description 1', '2018-04-03'),
(38, 14, 'Senior Graphic Designer Description 2', '2018-04-03'),
(39, 14, 'Senior Graphic Designer Description 3', '2018-04-03'),
(46, 13, 'Description 1', '2018-04-04'),
(47, 13, 'Description 2', '2018-04-04'),
(48, 13, 'Description 3', '2018-04-04');

-- --------------------------------------------------------

--
-- Table structure for table `CareerRequirementItem`
--

CREATE TABLE `CareerRequirementItem` (
  `id` int(11) NOT NULL,
  `career_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `CareerRequirementItem`
--

INSERT INTO `CareerRequirementItem` (`id`, `career_id`, `content`, `created_date`) VALUES
(32, 14, 'Senior Graphic Designer Requirement 1 ', '2018-04-03'),
(33, 14, 'Senior Graphic Designer Requirement 2', '2018-04-03'),
(34, 14, 'Senior Graphic Designer Requirement 3', '2018-04-03'),
(41, 13, 'Requirement 1', '2018-04-04'),
(42, 13, 'Requirement 2', '2018-04-04'),
(43, 13, 'Requirement 3', '2018-04-04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Career`
--
ALTER TABLE `Career`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `CareerApplication`
--
ALTER TABLE `CareerApplication`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `CareerDescriptionItem`
--
ALTER TABLE `CareerDescriptionItem`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `CareerRequirementItem`
--
ALTER TABLE `CareerRequirementItem`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Career`
--
ALTER TABLE `Career`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `CareerApplication`
--
ALTER TABLE `CareerApplication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `CareerDescriptionItem`
--
ALTER TABLE `CareerDescriptionItem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `CareerRequirementItem`
--
ALTER TABLE `CareerRequirementItem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
