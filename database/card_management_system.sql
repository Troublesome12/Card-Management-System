-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2017 at 05:47 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.5.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `card_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `designation` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `name`, `designation`, `address`, `mobile`, `email`, `website`, `image`) VALUES
(1, 'Shakil Hossain', 'JavaScript Developer', 'Dhanmondi 8/A', '+880 1620178', 'shakil@gmail.com', 'sites.google.com', '1486531510.jpg'),
(3, 'Tanvir Hassan', 'UX Designer', 'Dhanmondi Jigatola', '+880 162017812', 'nil@gmail.com', NULL, '1486531527.jpg'),
(4, 'Mahmadul Hasan Dip', 'Web Designer', 'Dhanmondi 15', '+880 16201791', 'dip@gmail.com', NULL, '1486531519.jpg'),
(9, 'Test', 'Test Designation', 'Test Address', '016161616116', 'test@gmail.com', 'www.test.com', '1487404213.png'),
(10, 'Test', 'Test Designation', 'Test Address', '12313', 'test@gmail.com', 'www.test.com', '1486531433.jpg'),
(11, 'Tanvir Hassan', 'UX Designer', 'Dhanmondi Jigatola', '+880 162017812', 'nil@gmail.com', NULL, '1487226281.jpg'),
(12, 'Test', 'UX Designer', 'Dhaka', '016161616116', 'a@gmail.com', 'www.test.com', '1487404885.jpg'),
(13, 'Rakib', 'none', 'Taltola', '1211620898', 'rakib@gmail.com', 'www.test.com', '1487757841.jpg'),
(14, 'Test', 'Test Designation', 'test', '123132132131', 'test@gmail.com', 'test', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `mobile`) VALUES
(1, 'shariful', 'shariful@gmail.com', '0123456788'),
(2, 'Test', 'test@gmail.com', '');

-- --------------------------------------------------------

--
-- Table structure for table `contact_group`
--

CREATE TABLE `contact_group` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `contact_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `contact_group`
--

INSERT INTO `contact_group` (`id`, `group_id`, `contact_id`) VALUES
(1, 1, 2),
(2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `color` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `user_id`, `title`, `description`, `color`, `start`, `end`) VALUES
(11, 1, 'Test', 'Test Description', '#DD6B55', '2017-03-08 18:00:00', '2017-03-09 18:00:00'),
(12, 1, 'Test', 'Description', '#3A87AD', '2017-02-21 18:00:00', '2017-02-23 18:00:00'),
(15, 1, 'Test', NULL, '#539987', '2017-03-01 18:00:00', '2017-03-02 18:00:00'),
(16, 1, 'Test', NULL, '#364958', '2017-02-13 18:00:00', '2017-02-14 18:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`) VALUES
(1, 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `ip_address`, `created_at`) VALUES
(4, 1, '::1', '2017-02-22 06:46:40'),
(5, 1, '::1', '2017-02-22 07:22:29'),
(6, 8, '::1', '2017-02-22 07:47:47'),
(7, 1, '::1', '2017-02-22 07:47:54'),
(8, 8, '::1', '2017-02-22 12:27:57'),
(9, 1, '::1', '2017-02-22 12:28:32'),
(10, 1, '::1', '2017-02-23 05:22:26'),
(11, 1, '::1', '2017-02-23 05:27:53'),
(12, 8, '::1', '2017-02-23 07:02:39'),
(13, 1, '::1', '2017-02-23 07:03:28'),
(14, 1, '::1', '2017-02-23 12:20:07'),
(17, 1, '::1', '2017-02-23 12:31:56');

-- --------------------------------------------------------

--
-- Table structure for table `manage_emails`
--

CREATE TABLE `manage_emails` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` varchar(255) NOT NULL,
  `contact_id` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `footer` text NOT NULL,
  `template` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manage_emails`
--

INSERT INTO `manage_emails` (`id`, `user_id`, `group_id`, `contact_id`, `subject`, `footer`, `template`) VALUES
(5, 1, '4,', '1,', 'Demo', '<p style="text-align: right;" data-mce-style="text-align: right;">Your Sincerely</p>', 0);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`) VALUES
(1, 'Card Management'),
(2, 'Email Management');

-- --------------------------------------------------------

--
-- Table structure for table `sent_email_status`
--

CREATE TABLE `sent_email_status` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `from` varchar(255) NOT NULL,
  `to` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter_link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `linkedin_link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_plus_link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `copyright` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `logo`, `facebook_link`, `twitter_link`, `linkedin_link`, `google_plus_link`, `copyright`) VALUES
(1, 'logo.png', 'https://www.facebook.com/web.flickmax/', 'https://www.twiiter.com/web.flickmax//', 'https://www.linkedin.com/web.flickmax///', 'https://www.google-plus.com/web.flickmax////', '2017 Test Group');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `image`, `isAdmin`) VALUES
(1, 'Shariful Islam', 'admin@gmail.com', 'MWZmZjgwMjAzODE5NDk5OThhYmY5Nzg5YmE0OGQwMWMzZDRiMWY5NWVkZjNhYTlhYzFmODcwYjQxMzE5YWM1OGZkZGZiZTNlYjJhYjE2YTA0NWVhYTlkYWIwZmFmZWRhZjNiNTI2YWUwMTRkNGJmMjUzNWY0ZDIyNzc1NGQxZjY=', '1487243318.png', 1),
(8, 'Shakil', 'shaion@gmail.com', 'OGU3NGU3MGEyMzRlZTJhNjZmNDdjMzM2ZDcyZDI3Mzc2MjVlYmNkNTBkMmUyMjc2OGViZGM4YmVjNThkMTVmM2I0MTk1N2IxNzg4YzI5YmU1M2IyNzczNTE2NmE2YmNjZDRiN2JiODlhZWMyM2M1N2ZhZTQzZWVmY2NiOGI3NWE=', NULL, 0),
(11, 'Test', 'test@gmail.com', 'NzEwMjRhOTJhZDFlMTIwMDUwODg4NTY3NDZjMmU5Nzc5MTQ1NWZjNDExNzZhMjFiYThhOGU1MWQ0MDZjZDQ0YTIxZTE3NDAzMDJiZDYxMmM0ODRmYTVmMTlmMDMxZjE5Y2I0NWFiMzdkZTQzNWIxYzdlZjZjMmQwYjVlMGQ4ZjM=', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_permission`
--

CREATE TABLE `user_permission` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `permission_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_permission`
--

INSERT INTO `user_permission` (`id`, `user_id`, `permission_id`) VALUES
(9, 1, 1),
(10, 1, 2),
(20, 8, 2),
(24, 11, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_group`
--
ALTER TABLE `contact_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `contact_id` (`contact_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `manage_emails`
--
ALTER TABLE `manage_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sent_email_status`
--
ALTER TABLE `sent_email_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_permission`
--
ALTER TABLE `user_permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `contact_group`
--
ALTER TABLE `contact_group`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `manage_emails`
--
ALTER TABLE `manage_emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sent_email_status`
--
ALTER TABLE `sent_email_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `user_permission`
--
ALTER TABLE `user_permission`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `contact_group`
--
ALTER TABLE `contact_group`
  ADD CONSTRAINT `contact_group_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `contact_group_ibfk_2` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_permission`
--
ALTER TABLE `user_permission`
  ADD CONSTRAINT `user_permission_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_permission_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
