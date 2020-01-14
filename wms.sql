-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Jan 14, 2020 at 10:56 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wms`
--

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_log`
--

DROP TABLE IF EXISTS `password_reset_log`;
CREATE TABLE IF NOT EXISTS `password_reset_log` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_master_id` int(11) UNSIGNED DEFAULT NULL,
  `password_reset_code` varchar(256) DEFAULT NULL,
  `code_generated_time` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `is_successful` tinyint(1) DEFAULT '0',
  `password_reset_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `prl_user_master_id_idx` (`user_master_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `password_reset_log`
--

INSERT INTO `password_reset_log` (`id`, `user_master_id`, `password_reset_code`, `code_generated_time`, `is_active`, `is_successful`, `password_reset_time`) VALUES
(25, 2, 'C1QU9bJO99R77qhp46XTOF4wjSWQvv0CTFHJnB6j2VMZ6CWyDVUR0ESLDSuy4YsllxMd8PJpAnHwIcgL3eIqqodfdPGap2AjuggeolO5Z3XiaHDfMXiiahN2Gmkt7Yfh', '2020-01-08 05:55:41', 0, 0, NULL),
(26, 2, 'pbB8BFfUnLDtvRgAZjlHUkQ0poCEoNzMD1NGV9scrMM7iN5kSL6bDFuqOUWRjeunEayVrWH1eVgSrKAQWqwxfiGOyKabHYcR29I6sthlQvxws6TE7cThJCZoXdeupaXv', '2020-01-08 06:00:58', 0, 0, NULL),
(27, 2, 'wQHyTDUXCeVM1zkbgleYguhJLRDrSzF012S34oKsd2he4J56wCchdftlv9IOBuUGEwiaKjgLa7OWWNqTZpmdYGvb70KVx02nPym3sxS9qpP7xXANrz5lQVnOc968f1NE', '2020-01-08 08:51:44', 0, 1, '2020-01-08 09:25:07'),
(28, 2, 'C6frWJlyIKIRqLAmH4u3S7s7e23gKQG25AlbEqnxBvdscNrj0PbUQtSZSPgPrTtYdepix6OoFKanNT8jLTafOMFRDOhdYHqkmcbgW0LkuiMsnH4XNmuD6fUGRJVypDGZ', '2020-01-08 09:31:44', 0, 0, NULL),
(29, 2, 'DbfNE5ABEBGoyZSWfRGs6gSU9EqqCk2dvxtlQFBdPX6LW4M2HlyjRAi5qpZf2yb9mCvrIOt8VXkdh0HT1QDor3Yxaa73peeKjAphUzK7bJYzNmLVgLckP3G56jhvc0Qc', '2020-01-08 09:32:13', 0, 1, '2020-01-08 09:33:39'),
(30, 2, 'lqTQTtas57FtS93oNt74DArDYsfNpbLPvDr9h6JhKwIj2krkUIz2i7M8FVxBhB3vjy6xoH0OXinEy0CYenE4LU5FqCp1QjKqMLuX4gm1Zyc2ggRRbXWaHm9uZ8QeVciW', '2020-01-08 09:34:59', 0, 1, '2020-01-08 09:35:28'),
(31, 2, 'auALtahsH70JxM4pfPOFddG5BYeEijmffznXXOSycbm9ZDsVcHuRWg8lUNhTeMNonljQtmDv7KOBZ1EXkJNRTJGv67pW1QLP5won0Vt0bkU6SDiQqgjAy2Gkq39FY4rM', '2020-01-08 09:36:05', 0, 1, '2020-01-08 09:37:26'),
(32, 2, 'jJ8yhrKCSF4ZPpMxFPuniXyRAfHGalwnDQTbC6U8cKdiYlqBVWyI6IEv1gVMLGj9Elx7pm1LWtYqY5ecgD9FZPRrU4KApA0esuUbJOh92H3qbLd02zOSxoawkvtOsfso', '2020-01-13 10:13:36', 0, 1, '2020-01-13 10:17:51'),
(33, 2, '8VxVQg5p2YYnTba99KqIRojyOuZ3g5CD01rN0KFdtsDGPZR8ewBrk6mYDXUJwAnAqabx3BicPOiE4UkhJjnflSH7sx3l8zS1P26IlteRHuBzXycqgWWtcvOLdiLEF24a', '2020-01-13 17:02:46', 0, 1, '2020-01-13 17:03:32');

-- --------------------------------------------------------

--
-- Table structure for table `user_login_log`
--

DROP TABLE IF EXISTS `user_login_log`;
CREATE TABLE IF NOT EXISTS `user_login_log` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_master_id` int(11) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `login_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `logout_time` datetime DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `province` varchar(128) DEFAULT NULL,
  `country` varchar(128) DEFAULT NULL,
  `login_success` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_login_log`
--

INSERT INTO `user_login_log` (`id`, `user_master_id`, `ip_address`, `login_time`, `logout_time`, `city`, `province`, `country`, `login_success`) VALUES
(158, 2, '::1', '2020-01-14 08:59:55', '2020-01-14 08:59:58', NULL, NULL, NULL, 1),
(159, 2, '::1', '2020-01-14 09:00:29', '2020-01-14 10:39:41', NULL, NULL, NULL, 1),
(160, 2, '::1', '2020-01-14 10:39:43', NULL, NULL, NULL, NULL, 1),
(161, 2, '::1', '2020-01-14 10:55:41', NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_master`
--

DROP TABLE IF EXISTS `user_master`;
CREATE TABLE IF NOT EXISTS `user_master` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_master`
--

INSERT INTO `user_master` (`id`, `email`, `password`, `disabled`, `deleted`, `created_on`, `updated_on`) VALUES
(2, 'abc@xyz.com', '123456', 0, 0, '2019-12-31 06:13:44', '2020-01-14 06:40:54');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

DROP TABLE IF EXISTS `user_profile`;
CREATE TABLE IF NOT EXISTS `user_profile` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_master_id` int(11) UNSIGNED DEFAULT NULL,
  `first_name` varchar(128) DEFAULT NULL,
  `last_name` varchar(128) DEFAULT NULL,
  `mobile_number` varchar(16) DEFAULT NULL,
  `alternate_number` varchar(32) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_on` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `up_user_master_id_idx` (`user_master_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`id`, `user_master_id`, `first_name`, `last_name`, `mobile_number`, `alternate_number`, `city`, `created_on`, `updated_on`) VALUES
(4, 2, 'abc', 'xyz', '1234567890', '1234567890', 'LA', '2020-01-07 14:27:36', '2020-01-14 10:55:45');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `password_reset_log`
--
ALTER TABLE `password_reset_log`
  ADD CONSTRAINT `prl_user_master_id` FOREIGN KEY (`user_master_id`) REFERENCES `user_master` (`id`);

--
-- Constraints for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `up_user_master_id` FOREIGN KEY (`user_master_id`) REFERENCES `user_master` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
