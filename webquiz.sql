-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2025 at 01:43 PM
-- Server version: 8.4.2
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webquiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `assigned_tests`
--

CREATE TABLE `assigned_tests` (
  `Assignment_ID` int NOT NULL,
  `Test_ID` int NOT NULL,
  `Users_ID` int NOT NULL,
  `Score` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `assigned_tests`
--

INSERT INTO `assigned_tests` (`Assignment_ID`, `Test_ID`, `Users_ID`, `Score`) VALUES
(1, 1, 1, 80),
(2, 2, 1, 90),
(3, 1, 10, 80),
(4, 2, 10, 60),
(5, 3, 10, 70),
(6, 4, 10, 90),
(7, 3, 1, 100);

-- --------------------------------------------------------

--
-- Table structure for table `question_test`
--

CREATE TABLE `question_test` (
  `Question_TestID` int NOT NULL,
  `Test_ID` int NOT NULL,
  `Question` varchar(255) NOT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `Answer_1` varchar(255) NOT NULL,
  `Answer_2` varchar(255) NOT NULL,
  `Answer_3` varchar(255) NOT NULL,
  `Correct_Answers` enum('A','B','C') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `Test_ID` int NOT NULL,
  `Test_Name` varchar(255) NOT NULL,
  `Test_Topic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`Test_ID`, `Test_Name`, `Test_Topic`) VALUES
(1, 'OOP', 'Mempelajari lanjutan dari Algoritma dan Programming'),
(2, 'Kalkulus', 'Pahami dasar dari matematika kalkulus'),
(3, 'Algoritma & Programming', 'Pahami coding melalui Algoritma'),
(4, 'Dasar Aritmetika', 'Yuk, paham tambah, kurang, kali dan bagi!');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Users_ID` int NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Status` enum('Users','Teacher') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Users_ID`, `Username`, `Password`, `Status`) VALUES
(1, 'Jessica Windsor', 'J3ss1c4', 'Users'),
(6, 'Clara Winston', 'Cl4r4_w1n5', 'Teacher'),
(10, 'James Winston', 'J4m3s_w1n5', 'Users'),
(11, 'Felicia', '12345678', 'Users');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assigned_tests`
--
ALTER TABLE `assigned_tests`
  ADD PRIMARY KEY (`Assignment_ID`),
  ADD KEY `Test_ID` (`Test_ID`,`Users_ID`),
  ADD KEY `Users_ID` (`Users_ID`);

--
-- Indexes for table `question_test`
--
ALTER TABLE `question_test`
  ADD PRIMARY KEY (`Question_TestID`),
  ADD KEY `Test_ID` (`Test_ID`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`Test_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Users_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assigned_tests`
--
ALTER TABLE `assigned_tests`
  MODIFY `Assignment_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `question_test`
--
ALTER TABLE `question_test`
  MODIFY `Question_TestID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `Test_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Users_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assigned_tests`
--
ALTER TABLE `assigned_tests`
  ADD CONSTRAINT `assigned_tests_ibfk_1` FOREIGN KEY (`Users_ID`) REFERENCES `users` (`Users_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assigned_tests_ibfk_2` FOREIGN KEY (`Test_ID`) REFERENCES `tests` (`Test_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `question_test`
--
ALTER TABLE `question_test`
  ADD CONSTRAINT `fk_question_test_test` FOREIGN KEY (`Test_ID`) REFERENCES `tests` (`Test_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `question_test_ibfk_1` FOREIGN KEY (`Test_ID`) REFERENCES `tests` (`Test_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
