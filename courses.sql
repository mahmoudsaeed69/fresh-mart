-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2024 at 12:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `courses`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `ID` int(11) NOT NULL,
  `Fullname` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Pass` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Groubid` int(11) NOT NULL DEFAULT 0,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`ID`, `Fullname`, `Username`, `Pass`, `Email`, `Groubid`, `date`) VALUES
(8, 'mohamed ahmed', 'mohamed', 'fdcca43175c6c3da4542836cb553cf4d2bd66b4a', 'mo@gmail.com', 1, '2024-03-21 13:43:57'),
(12, 'faed mohamed', 'Yousef', '9a36ce1da2be148cee55051c26b0b87c22476abf', 'faed@gmail.com', 2, '2024-05-28 20:08:39');

-- --------------------------------------------------------

--
-- Table structure for table `buy_brodect`
--

CREATE TABLE `buy_brodect` (
  `ID` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `name_item` int(11) NOT NULL,
  `user_name` int(11) NOT NULL,
  `phone` int(11) NOT NULL,
  `Email` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catagory`
--

CREATE TABLE `catagory` (
  `ID` int(11) NOT NULL,
  `NameCatagory` varchar(255) NOT NULL,
  `caption` text NOT NULL,
  `orderCatagoury` int(11) DEFAULT NULL,
  `vesplite` tinyint(4) NOT NULL DEFAULT 0,
  `Ads` tinyint(4) NOT NULL DEFAULT 0,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `catagory`
--

INSERT INTO `catagory` (`ID`, `NameCatagory`, `caption`, `orderCatagoury`, `vesplite`, `Ads`, `date`) VALUES
(8, 'خضار طازج', 'احصل على افضل جودة', 1, 0, 0, '2024-05-28 17:04:38'),
(9, 'فواكه طازجه', 'fresh frutes', 2, 0, 0, '2024-05-28 18:41:26');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `ID` int(11) NOT NULL,
  `name_item` varchar(255) NOT NULL,
  `caption` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `cat_img` varchar(255) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`ID`, `name_item`, `caption`, `price`, `cat_img`, `cat_id`, `member_id`, `date`) VALUES
(7, 'طماطم', 'افضل جودة', '100$', '696648568_IMG_20220321_192143.jpg', 8, 12, '2024-05-28 17:10:20'),
(8, 'banana', 'موز', '100$', '445319954_IMG_20220321_192143.jpg', 9, 8, '2024-05-28 18:43:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_video`
--

CREATE TABLE `tbl_video` (
  `ID` int(11) NOT NULL,
  `Video_name` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `Video_src` varchar(255) NOT NULL,
  `course_id` int(11) NOT NULL,
  `member_add` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `st_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `st_fullname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `st_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `st_phone` int(11) NOT NULL,
  `item_sub` int(11) NOT NULL,
  `st_img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `st_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `st_name`, `st_fullname`, `st_email`, `st_phone`, `item_sub`, `st_img`, `st_date`) VALUES
(4, 'yousef', 'yousef ayman mohamed', 'yousef@gmail.com', 1234567891, 7, '', '2024-05-28 18:03:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `buy_brodect`
--
ALTER TABLE `buy_brodect`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `course_exam` (`id_item`),
  ADD KEY `item_buy` (`name_item`),
  ADD KEY `user_buy` (`user_name`),
  ADD KEY `email_user` (`Email`),
  ADD KEY `phone_user` (`phone`);

--
-- Indexes for table `catagory`
--
ALTER TABLE `catagory`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `memberSubscrip` (`member_id`),
  ADD KEY `itemForCourse` (`cat_id`);

--
-- Indexes for table `tbl_video`
--
ALTER TABLE `tbl_video`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `co_video` (`course_id`),
  ADD KEY `adds` (`member_add`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `st_spscripe` (`item_sub`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `buy_brodect`
--
ALTER TABLE `buy_brodect`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `catagory`
--
ALTER TABLE `catagory`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_video`
--
ALTER TABLE `tbl_video`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buy_brodect`
--
ALTER TABLE `buy_brodect`
  ADD CONSTRAINT `course_exam` FOREIGN KEY (`id_item`) REFERENCES `item` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `email_user` FOREIGN KEY (`Email`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `item_buy` FOREIGN KEY (`name_item`) REFERENCES `item` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `phone_user` FOREIGN KEY (`phone`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_buy` FOREIGN KEY (`user_name`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `itemForCourse` FOREIGN KEY (`cat_id`) REFERENCES `catagory` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `memberSubscrip` FOREIGN KEY (`member_id`) REFERENCES `admins` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_video`
--
ALTER TABLE `tbl_video`
  ADD CONSTRAINT `adds` FOREIGN KEY (`member_add`) REFERENCES `admins` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `co_video` FOREIGN KEY (`course_id`) REFERENCES `item` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `st_spscripe` FOREIGN KEY (`item_sub`) REFERENCES `item` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
