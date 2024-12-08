-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2024 at 05:31 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `23bcs220`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `account_number` int(8) NOT NULL,
  `branch_name` varchar(15) NOT NULL,
  `balance` int(8) NOT NULL,
  `DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`account_number`, `branch_name`, `balance`, `DATE`) VALUES
(1, 'Cross Square', 1000, '2024-10-10'),
(101, 'Wright Town', 500, '0005-02-11'),
(102, 'S Street', 400, '0006-08-10'),
(201, 'Stadium', 900, '0009-04-10'),
(215, 'Meghawan', 700, '0003-07-12'),
(217, 'Stadium', 750, '0002-10-12'),
(222, 'Cross Square', 700, '0008-11-11'),
(305, 'Napier Town', 350, '0004-06-09');

-- --------------------------------------------------------

--
-- Table structure for table `borrower`
--

CREATE TABLE `borrower` (
  `customer_name` varchar(15) NOT NULL,
  `loan_number` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrower`
--

INSERT INTO `borrower` (`customer_name`, `loan_number`) VALUES
('Amit', 16),
('Charu', 93),
('Divya', 11),
('Divya', 23),
('Priya', 15),
('Sakshi', 17),
('Vinay', 17),
('vishal', 220),
('Yash', 14);

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_name` varchar(15) NOT NULL,
  `branch_city` varchar(15) DEFAULT NULL,
  `assests` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_name`, `branch_city`, `assests`) VALUES
('Cross Square', 'Nagpur', 2100),
('Meghawan', 'Meghawan', 400),
('Napier Town', 'Hyderabad', 80000),
('North Town', 'Raipur', 370),
('Pownal', 'Bilaspur', 300),
('S Street', 'Hyderabad', 1700),
('Stadium', 'Delhi', 71),
('Wright Town', 'Delhi', 900);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_name` varchar(15) NOT NULL,
  `customer_street` varchar(15) DEFAULT NULL,
  `customer_city` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_name`, `customer_street`, `customer_city`) VALUES
('Amit', 'Sarafa', 'Patna'),
('Anjali', 'Mall Road', 'Patna'),
('Bani', 'Civil Lines', 'Delhi'),
('Charu', NULL, 'Raipur'),
('Divya', NULL, 'Raipur'),
('harshitaaaa', 'jaba', 'jaaaa'),
('Jai', 'South Street', 'Mumbai'),
('Priya', 'Main Street', 'Banglore'),
('Rahul', 'Vijay Nagar', 'Jabalpur'),
('Rohit', 'Sadar', 'Jabalpur'),
('Sakshi', 'Park Street', 'Kolkata'),
('Sisira', 'Garden', 'Vizag'),
('Vinay', 'Main Street', 'Banglore'),
('vishal', 'garden', 'vizag'),
('vishal kumar', 'garden', 'vizag'),
('Yash', 'Hill Road', 'Nagpur');

-- --------------------------------------------------------

--
-- Table structure for table `depositer`
--

CREATE TABLE `depositer` (
  `customer_name` varchar(15) NOT NULL,
  `account_number` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `depositer`
--

INSERT INTO `depositer` (`customer_name`, `account_number`) VALUES
('Anjali', 222),
('Divya', 217),
('Priya', 102),
('Rohit', 305),
('Vinay', 217),
('vishal', 1),
('Yash', 101),
('Yash', 201);

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `loan_number` int(8) NOT NULL,
  `branch_name` varchar(15) NOT NULL,
  `amount` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loan`
--

INSERT INTO `loan` (`loan_number`, `branch_name`, `amount`) VALUES
(11, 'Napier town', 900),
(14, 'Wright Town', 1500),
(15, 'S street', 1500),
(16, 'S street', 1300),
(17, 'Wright Town', 1000),
(23, 'Cross square', 2000),
(93, 'Meghawan', 500),
(220, 'Cross square', 2000);

-- --------------------------------------------------------

--
-- Table structure for table `master_login`
--

CREATE TABLE `master_login` (
  `userid` varchar(30) NOT NULL,
  `password` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master_login`
--

INSERT INTO `master_login` (`userid`, `password`) VALUES
('divanshu', '7078120013'),
('vishal', '123456'),
('Hashy', 'meow2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`account_number`),
  ADD KEY `branch_name` (`branch_name`);

--
-- Indexes for table `borrower`
--
ALTER TABLE `borrower`
  ADD PRIMARY KEY (`customer_name`,`loan_number`),
  ADD KEY `loan_number` (`loan_number`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_name`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_name`);

--
-- Indexes for table `depositer`
--
ALTER TABLE `depositer`
  ADD PRIMARY KEY (`customer_name`,`account_number`),
  ADD KEY `account_number` (`account_number`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`loan_number`),
  ADD KEY `branch_name` (`branch_name`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `account_ibfk_1` FOREIGN KEY (`branch_name`) REFERENCES `branch` (`branch_name`);

--
-- Constraints for table `borrower`
--
ALTER TABLE `borrower`
  ADD CONSTRAINT `borrower_ibfk_1` FOREIGN KEY (`customer_name`) REFERENCES `customer` (`customer_name`),
  ADD CONSTRAINT `borrower_ibfk_2` FOREIGN KEY (`loan_number`) REFERENCES `loan` (`loan_number`);

--
-- Constraints for table `depositer`
--
ALTER TABLE `depositer`
  ADD CONSTRAINT `depositer_ibfk_1` FOREIGN KEY (`customer_name`) REFERENCES `customer` (`customer_name`),
  ADD CONSTRAINT `depositer_ibfk_2` FOREIGN KEY (`account_number`) REFERENCES `account` (`account_number`) ON DELETE CASCADE;

--
-- Constraints for table `loan`
--
ALTER TABLE `loan`
  ADD CONSTRAINT `loan_ibfk_1` FOREIGN KEY (`branch_name`) REFERENCES `branch` (`branch_name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
