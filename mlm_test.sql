-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2018 at 08:18 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mlm_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `user_id`, `password`) VALUES
(1, 'mlm', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `day_bal` int(11) NOT NULL,
  `current_bal` int(11) NOT NULL,
  `total_bal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`id`, `user_id`, `day_bal`, `current_bal`, `total_bal`) VALUES
(1, 'user@petbooq.com', 200, 200, 200),
(2, 'a1@gmail.com', 100, 100, 100),
(3, 'a2@gmail.com', 0, 0, 0),
(4, 'a3@gmail.com', 0, 0, 0),
(5, 'a4@gmail.com', 0, 0, 0),
(6, 'a5@gmail.com', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `income_recieved`
--

CREATE TABLE `income_recieved` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pin_list`
--

CREATE TABLE `pin_list` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `pin` int(10) NOT NULL,
  `status` enum('open','close') NOT NULL DEFAULT 'open'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pin_list`
--

INSERT INTO `pin_list` (`id`, `user_id`, `pin`, `status`) VALUES
(1, 'user@petbooq.com', 273144, 'close'),
(2, 'user@petbooq.com', 861819, 'close'),
(3, 'user@petbooq.com', 888323, 'close'),
(4, 'user@petbooq.com', 219503, 'close'),
(5, 'user@petbooq.com', 316540, 'close'),
(6, 'user@petbooq.com', 923233, 'open');

-- --------------------------------------------------------

--
-- Table structure for table `pin_request`
--

CREATE TABLE `pin_request` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` enum('open','close') NOT NULL DEFAULT 'open'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pin_request`
--

INSERT INTO `pin_request` (`id`, `email`, `amount`, `date`, `status`) VALUES
(1, 'user@petbooq.com', 2000, '2018-02-09', 'close');

-- --------------------------------------------------------

--
-- Table structure for table `tree`
--

CREATE TABLE `tree` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `left` varchar(50) NOT NULL,
  `right` varchar(50) NOT NULL,
  `leftcount` int(11) NOT NULL,
  `rightcount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tree`
--

INSERT INTO `tree` (`id`, `user_id`, `left`, `right`, `leftcount`, `rightcount`) VALUES
(1, 'user@petbooq.com', 'a1@gmail.com', 'a2@gmail.com', 3, 2),
(2, 'a1@gmail.com', 'a3@gmail.com', 'a4@gmail.com', 1, 1),
(3, 'a2@gmail.com', '', 'a5@gmail.com', 0, 1),
(4, 'a3@gmail.com', '', '', 0, 0),
(5, 'a4@gmail.com', '', '', 0, 0),
(6, 'a5@gmail.com', '', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `account` varchar(50) NOT NULL,
  `under_userid` varchar(50) NOT NULL,
  `side` varchar(50) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `mobile`, `address`, `account`, `under_userid`, `side`, `date`) VALUES
(1, 'user@petbooq.com', '12345', '423232242', 'Vasnt Kunj D14', '4747474', '', 'left', '2018-01-30'),
(2, 'a1@gmail.com', '123456', '7800987279', 'Vasant Kunj, Delhi', '2131313131', 'user@petbooq.com', 'left', '2018-02-09'),
(3, 'a2@gmail.com', '123456', '7800987279', 'Vasant Kunj, Delhi', '232132131', 'user@petbooq.com', 'right', '2018-02-09'),
(4, 'a3@gmail.com', '123456', '7800987279', 'Vasant Kunj, Delhi', '232132131', 'a1@gmail.com', 'left', '2018-02-09'),
(5, 'a4@gmail.com', '123456', '7800987279', 'Vasant Kunj, Delhi', '232132131', 'a1@gmail.com', 'right', '2018-02-09'),
(6, 'a5@gmail.com', '123456', '7800987279', 'Vasant Kunj, Delhi', '232132131', 'a2@gmail.com', 'right', '2018-02-09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `income_recieved`
--
ALTER TABLE `income_recieved`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pin_list`
--
ALTER TABLE `pin_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pin_request`
--
ALTER TABLE `pin_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tree`
--
ALTER TABLE `tree`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
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
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `income_recieved`
--
ALTER TABLE `income_recieved`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pin_list`
--
ALTER TABLE `pin_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `pin_request`
--
ALTER TABLE `pin_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tree`
--
ALTER TABLE `tree`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
