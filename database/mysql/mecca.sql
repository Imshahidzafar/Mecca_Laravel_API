-- Adminer 4.8.1 MySQL 5.5.5-10.5.22-MariaDB-log dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `authors`;
CREATE TABLE `authors` (
  `authors_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `added_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('Active','Inactive','Deleted','Pending') NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`authors_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `authors` (`authors_id`, `name`, `description`, `image`, `added_date`, `status`) VALUES
(1,	'Imam al Bukhari',	'Imam al Bukhari',	NULL,	'2023-05-10 05:27:38',	'Active'),
(2,	'testh',	NULL,	NULL,	'2023-05-10 05:28:00',	'Active'),
(3,	'Test auth 3',	'Author',	NULL,	'2023-05-15 03:24:18',	'Active'),
(4,	'Erin Kodicek',	'The Dutch philosopher Erasmus once said: “When I get a little money, I buy books. If any is left, I buy food and clothes.”',	'uploads/author/1685944367.jpeg',	'2023-06-05 01:52:47',	'Active'),
(5,	'T. J. de Boer',	'dasdasdasdas',	'uploads/author/1685944574.jpeg',	'2023-06-05 01:56:14',	'Active');

DROP TABLE IF EXISTS `bookmark_books`;
CREATE TABLE `bookmark_books` (
  `bookmark_books_id` int(11) NOT NULL AUTO_INCREMENT,
  `users_customers_id` int(11) NOT NULL,
  `books_id` int(11) NOT NULL,
  `added_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('Active','Inactive','Pending','Deleted') NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`bookmark_books_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `bookmark_books` (`bookmark_books_id`, `users_customers_id`, `books_id`, `added_date`, `status`) VALUES
(1,	41,	1,	'2023-05-10 15:31:58',	'Active'),
(2,	41,	4,	'2023-05-13 04:39:30',	'Deleted'),
(3,	41,	6,	'2023-05-16 03:14:05',	'Deleted'),
(4,	41,	16,	'2023-05-16 03:19:40',	'Deleted'),
(5,	41,	7,	'2023-05-19 06:42:45',	'Deleted'),
(6,	41,	17,	'2023-05-19 06:43:40',	'Deleted'),
(7,	40,	7,	'2023-05-20 01:19:09',	'Active'),
(8,	40,	17,	'2023-05-20 01:19:36',	'Deleted'),
(9,	40,	6,	'2023-05-20 01:20:24',	'Deleted'),
(10,	40,	16,	'2023-05-20 01:21:06',	'Active'),
(11,	41,	18,	'2023-05-20 04:38:25',	'Deleted'),
(12,	40,	18,	'2023-05-20 04:40:12',	'Active'),
(13,	43,	6,	'2023-05-23 05:13:09',	'Active'),
(14,	43,	7,	'2023-05-23 05:15:07',	'Active'),
(15,	47,	6,	'2023-05-23 05:21:35',	'Active'),
(16,	47,	7,	'2023-05-23 05:21:58',	'Deleted'),
(17,	50,	16,	'2023-05-23 05:22:57',	'Deleted'),
(18,	50,	18,	'2023-05-23 05:23:19',	'Deleted'),
(19,	50,	7,	'2023-05-23 05:23:38',	'Active'),
(20,	47,	16,	'2023-05-23 05:29:15',	'Deleted'),
(21,	47,	17,	'2023-05-23 05:30:58',	'Active'),
(22,	47,	18,	'2023-05-23 05:32:18',	'Active'),
(23,	50,	17,	'2023-05-23 05:40:48',	'Deleted'),
(24,	51,	6,	'2023-05-23 05:45:47',	'Deleted'),
(25,	51,	16,	'2023-05-23 05:46:15',	'Deleted'),
(26,	51,	7,	'2023-05-23 05:46:20',	'Deleted'),
(27,	51,	18,	'2023-05-23 05:46:23',	'Deleted'),
(28,	51,	17,	'2023-05-23 05:46:25',	'Deleted'),
(29,	52,	16,	'2023-05-23 05:48:45',	'Deleted'),
(30,	52,	6,	'2023-05-23 05:48:47',	'Deleted'),
(31,	52,	7,	'2023-05-23 05:48:50',	'Deleted'),
(32,	52,	18,	'2023-05-23 05:48:54',	'Deleted'),
(33,	52,	17,	'2023-05-23 05:48:59',	'Deleted'),
(34,	43,	16,	'2023-05-23 06:03:18',	'Deleted'),
(35,	40,	19,	'2023-05-27 01:49:34',	'Active'),
(36,	47,	19,	'2023-05-29 02:26:25',	'Deleted'),
(37,	41,	19,	'2023-06-04 01:22:57',	'Deleted'),
(38,	41,	20,	'2023-06-05 01:54:14',	'Active'),
(39,	50,	20,	'2023-06-05 04:07:00',	'Deleted'),
(40,	43,	20,	'2023-06-05 07:06:05',	'Active'),
(41,	43,	21,	'2023-06-05 07:14:49',	'Active'),
(42,	50,	21,	'2023-06-06 02:44:08',	'Deleted'),
(43,	50,	6,	'2023-06-06 02:46:10',	'Deleted'),
(44,	47,	20,	'2023-06-06 05:47:28',	'Deleted'),
(45,	43,	19,	'2023-06-07 01:15:07',	'Active'),
(46,	41,	21,	'2023-06-08 03:06:51',	'Active');

DROP TABLE IF EXISTS `books`;
CREATE TABLE `books` (
  `books_id` int(11) NOT NULL AUTO_INCREMENT,
  `categories_id` int(11) NOT NULL,
  `authors_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `pages` int(11) NOT NULL,
  `book_url` text NOT NULL,
  `cover` text NOT NULL,
  `downloads` int(11) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('Active','Inactive','Deleted','Pending') NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`books_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `books` (`books_id`, `categories_id`, `authors_id`, `title`, `pages`, `book_url`, `cover`, `downloads`, `date_added`, `status`) VALUES
(6,	3,	3,	'AL Hadees Vol no 3 by Imam',	0,	'uploads/book/1684137877.jpeg',	'uploads/cover/1684221879.jpeg',	24,	'2023-05-15 04:04:37',	'Active'),
(7,	1,	1,	'first',	0,	'uploads/book/1684212896.jpeg',	'uploads/cover/1684212896.jpeg',	6,	'2023-05-16 00:54:56',	'Active'),
(21,	2,	5,	'Geschichte der Philosophie im Islam',	192,	'uploads/book/1685944639.pdf',	'uploads/cover/1685944639.png',	4,	'2023-06-05 01:57:19',	'Active'),
(20,	3,	4,	'TK Eldridge\'s Series Starters',	955,	'uploads/book/1685944420.pdf',	'uploads/cover/1685944420.png',	18,	'2023-06-05 01:53:40',	'Active'),
(19,	2,	1,	'Sunan Abu Dawood',	2600,	'uploads/book/1685166078.pdf',	'uploads/cover/1685166079.png',	7,	'2023-05-27 01:41:19',	'Active'),
(18,	5,	2,	'The Casual Optimist',	5,	'uploads/book/1684571866.pdf',	'uploads/cover/1684571866.png',	11,	'2023-05-20 04:37:46',	'Active'),
(16,	5,	2,	'Lady MAGE Tone My first Book Vol 3',	0,	'uploads/book/1684221245.jpeg',	'uploads/cover/1684221245.jpeg',	6,	'2023-05-16 03:14:05',	'Active'),
(17,	1,	3,	'new book',	45,	'uploads/book/1684386678.pdf',	'uploads/cover/1684388968.png',	13,	'2023-05-18 01:11:18',	'Active');

DROP TABLE IF EXISTS `books_views`;
CREATE TABLE `books_views` (
  `books_views_id` int(11) NOT NULL AUTO_INCREMENT,
  `users_customers_id` int(11) NOT NULL,
  `books_id` int(11) NOT NULL,
  `added_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('Active','Inactive','Deleted','Pending') NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`books_views_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `books_views` (`books_views_id`, `users_customers_id`, `books_id`, `added_date`, `status`) VALUES
(1,	41,	1,	'2023-05-10 15:27:09',	'Active'),
(2,	41,	17,	'2023-05-20 00:43:27',	'Active'),
(3,	41,	7,	'2023-05-20 04:21:56',	'Active'),
(4,	40,	18,	'2023-05-20 04:38:31',	'Active'),
(5,	41,	18,	'2023-05-20 04:39:17',	'Active'),
(6,	41,	16,	'2023-05-22 06:26:53',	'Active'),
(7,	41,	6,	'2023-05-22 06:32:42',	'Active'),
(8,	46,	6,	'2023-05-23 04:23:06',	'Active'),
(9,	49,	7,	'2023-05-23 05:21:05',	'Active'),
(10,	49,	6,	'2023-05-23 05:21:31',	'Active'),
(11,	47,	6,	'2023-05-23 05:21:39',	'Active'),
(12,	49,	17,	'2023-05-23 05:22:05',	'Active'),
(13,	49,	16,	'2023-05-23 05:22:33',	'Active'),
(14,	52,	16,	'2023-05-23 05:51:34',	'Active'),
(15,	40,	19,	'2023-05-27 01:49:44',	'Active'),
(16,	41,	19,	'2023-05-28 23:48:25',	'Active'),
(17,	47,	19,	'2023-05-29 02:23:34',	'Active'),
(18,	40,	6,	'2023-06-02 01:53:10',	'Active'),
(19,	41,	20,	'2023-06-05 01:54:32',	'Active'),
(20,	50,	20,	'2023-06-06 02:46:42',	'Active'),
(21,	47,	20,	'2023-06-06 06:00:31',	'Active'),
(22,	43,	6,	'2023-06-07 01:11:12',	'Active'),
(23,	43,	20,	'2023-06-07 01:11:50',	'Active'),
(24,	41,	21,	'2023-06-08 03:19:09',	'Active'),
(25,	43,	21,	'2023-06-13 02:59:44',	'Active'),
(26,	43,	19,	'2023-06-17 06:11:19',	'Active');

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `categories_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `added_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('Active','Inactive','Deleted','Pending') NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`categories_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `categories` (`categories_id`, `name`, `added_date`, `status`) VALUES
(1,	'Quran',	'2023-05-10 00:13:12',	'Active'),
(2,	'Hadees',	'2023-05-13 01:18:21',	'Active'),
(3,	'My Book 1',	'2023-05-13 02:08:38',	'Active'),
(4,	'My book 2',	'2023-05-13 02:08:47',	'Active'),
(5,	'My book 3',	'2023-05-13 02:09:10',	'Active');

DROP TABLE IF EXISTS `chat_list`;
CREATE TABLE `chat_list` (
  `chat_list_id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `date_request` date NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`chat_list_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `chat_list` (`chat_list_id`, `sender_id`, `receiver_id`, `date_request`, `created_at`) VALUES
(1,	2,	1,	'2023-04-06',	'2023-04-06 15:29:52'),
(2,	11,	22,	'2023-04-06',	'2023-04-06 15:46:54'),
(3,	34,	1,	'2023-04-08',	'2023-04-08 09:53:36'),
(4,	10,	1,	'2023-04-10',	'2023-04-10 10:42:15'),
(5,	70,	1,	'2023-04-17',	'2023-04-17 12:30:23'),
(6,	72,	1,	'2023-04-19',	'2023-04-19 14:29:54'),
(7,	74,	1,	'2023-04-27',	'2023-04-27 14:38:21'),
(8,	72,	75,	'2023-04-27',	'2023-04-27 15:50:02'),
(9,	79,	75,	'2023-04-27',	'2023-04-27 16:35:33'),
(10,	74,	70,	'2023-04-27',	'2023-04-27 18:04:36'),
(11,	18,	1,	'2023-05-05',	'2023-05-05 16:42:28'),
(12,	6,	1,	'2023-05-05',	'2023-05-05 16:50:42');

DROP TABLE IF EXISTS `chat_list_live`;
CREATE TABLE `chat_list_live` (
  `chat_list_live_id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `date_request` date NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`chat_list_live_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `chat_list_live` (`chat_list_live_id`, `sender_id`, `receiver_id`, `date_request`, `created_at`) VALUES
(1,	2,	1,	'2023-04-06',	'2023-04-06 12:27:40');

DROP TABLE IF EXISTS `chat_messages`;
CREATE TABLE `chat_messages` (
  `chat_message_id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_type` enum('Employee','Customer') NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `message_type` enum('text','attachment','location') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `send_date` datetime NOT NULL,
  `send_time` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `read_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` enum('Read','Unread') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`chat_message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `chat_messages` (`chat_message_id`, `sender_type`, `sender_id`, `receiver_id`, `message`, `message_type`, `send_date`, `send_time`, `read_date`, `created_at`, `status`) VALUES
(1,	'Customer',	2,	1,	'\"hello this is customer message testing\"',	'text',	'2023-04-06 00:00:00',	'15:31:17',	NULL,	'2023-04-06 15:31:17',	'Read'),
(2,	'Employee',	1,	2,	'\"hello this is employee message testing\"',	'text',	'2023-04-06 00:00:00',	'15:32:19',	NULL,	'2023-04-06 15:32:19',	'Read'),
(3,	'Customer',	2,	1,	'\"hello this is customer message testing\"',	'text',	'2023-04-08 00:00:00',	'11:42:46',	NULL,	'2023-04-08 11:42:46',	'Read'),
(4,	'Customer',	2,	1,	'\"hello this is customer message testing\"',	'text',	'2023-04-08 00:00:00',	'12:07:40',	NULL,	'2023-04-08 12:07:40',	'Read'),
(5,	'Customer',	12,	14,	'\"hello this is customer message testing\"',	'text',	'2023-04-08 00:00:00',	'12:07:57',	NULL,	'2023-04-08 12:07:57',	'Unread'),
(6,	'Employee',	1,	2,	'\"hello this is employee message testing\"',	'text',	'2023-04-08 00:00:00',	'12:11:13',	NULL,	'2023-04-08 12:11:13',	'Read'),
(7,	'Customer',	34,	1,	'\"hello this is customer message testing\"',	'text',	'2023-04-10 00:00:00',	'10:25:18',	NULL,	'2023-04-10 10:25:18',	'Unread'),
(8,	'Customer',	34,	1,	'\"hello\"',	'text',	'2023-04-10 00:00:00',	'10:33:19',	NULL,	'2023-04-10 10:33:19',	'Unread'),
(9,	'Customer',	34,	1,	'\"hdhd\"',	'text',	'2023-04-10 00:00:00',	'10:36:22',	NULL,	'2023-04-10 10:36:22',	'Unread'),
(10,	'Customer',	34,	1,	'\"hello kitty \\ud83d\\udc08\"',	'text',	'2023-04-10 00:00:00',	'11:26:47',	NULL,	'2023-04-10 11:26:47',	'Unread'),
(11,	'Customer',	2,	1,	'\"hello this is customer message testing\"',	'text',	'2023-04-12 00:00:00',	'16:14:58',	NULL,	'2023-04-12 16:14:58',	'Read'),
(12,	'Employee',	1,	2,	'\"hello this is employee message testing\"',	'text',	'2023-04-12 00:00:00',	'16:15:06',	NULL,	'2023-04-12 16:15:06',	'Read'),
(13,	'Customer',	2,	1,	'\"hello this is customer message testing\"',	'text',	'2023-04-13 00:00:00',	'11:58:52',	NULL,	'2023-04-13 11:58:52',	'Read'),
(14,	'Employee',	1,	2,	'\"hello this is employee message testing\"',	'text',	'2023-04-13 00:00:00',	'12:00:48',	NULL,	'2023-04-13 12:00:48',	'Read'),
(15,	'Employee',	1,	2,	'\"hello this is employee message testing\"',	'text',	'2023-04-13 00:00:00',	'12:21:29',	NULL,	'2023-04-13 12:21:29',	'Read'),
(16,	'Customer',	2,	1,	'\"hello this is customer message testing\"',	'text',	'2023-04-13 00:00:00',	'12:21:37',	NULL,	'2023-04-13 12:21:37',	'Read'),
(17,	'Customer',	1,	2,	'\"hello this is customer message testing\"',	'text',	'2023-04-13 00:00:00',	'13:56:44',	NULL,	'2023-04-13 13:56:44',	'Read'),
(18,	'Employee',	2,	1,	'\"hello this is employee message testing\"',	'text',	'2023-04-13 00:00:00',	'13:57:04',	NULL,	'2023-04-13 13:57:04',	'Read'),
(19,	'Employee',	2,	1,	'\"hello this is employee message testing 123\"',	'text',	'2023-04-13 00:00:00',	'13:59:03',	NULL,	'2023-04-13 13:59:03',	'Read'),
(20,	'Customer',	2,	1,	'\"hello this is customer message testing\"',	'text',	'2023-04-13 00:00:00',	'13:59:54',	NULL,	'2023-04-13 13:59:54',	'Read'),
(21,	'Employee',	2,	15,	'\"hello this is employee message testing 12345\"',	'text',	'2023-04-13 00:00:00',	'14:02:42',	NULL,	'2023-04-13 14:02:42',	'Read'),
(22,	'Customer',	2,	15,	'\"hello this is customer message testing\"',	'text',	'2023-04-13 00:00:00',	'14:03:01',	NULL,	'2023-04-13 14:03:01',	'Read'),
(23,	'Customer',	15,	2,	'\"hello this is customer message testing\"',	'text',	'2023-04-13 00:00:00',	'14:03:57',	NULL,	'2023-04-13 14:03:57',	'Read'),
(24,	'Employee',	15,	2,	'\"hello this is employee message testing 12345\"',	'text',	'2023-04-13 00:00:00',	'14:04:05',	NULL,	'2023-04-13 14:04:05',	'Read'),
(25,	'Customer',	15,	2,	'\"hello this is customer message testing zxxsd\"',	'text',	'2023-04-13 00:00:00',	'14:06:05',	NULL,	'2023-04-13 14:06:05',	'Read'),
(26,	'Customer',	2,	15,	'\"hello this is customer message testing zxxsd\"',	'text',	'2023-04-13 00:00:00',	'14:06:29',	NULL,	'2023-04-13 14:06:29',	'Read'),
(27,	'Employee',	2,	15,	'\"hello this is employee message testing 12345\"',	'text',	'2023-04-13 00:00:00',	'14:06:37',	NULL,	'2023-04-13 14:06:37',	'Read'),
(28,	'Customer',	2,	4,	'\"hello this is customer message testing\"',	'text',	'2023-04-14 00:00:00',	'11:47:15',	NULL,	'2023-04-14 11:47:15',	'Unread'),
(29,	'Employee',	1,	2,	'\"hello this is employee message testing\"',	'text',	'2023-04-14 00:00:00',	'12:35:39',	NULL,	'2023-04-14 12:35:39',	'Read'),
(30,	'Customer',	72,	1,	'\"hjh\"',	'text',	'2023-04-26 00:00:00',	'13:11:10',	NULL,	'2023-04-26 13:11:10',	'Unread'),
(31,	'Customer',	72,	1,	'\"hello\"',	'text',	'2023-04-27 00:00:00',	'12:40:30',	NULL,	'2023-04-27 12:40:30',	'Unread'),
(32,	'Customer',	74,	1,	'\"hello\"',	'text',	'2023-04-27 00:00:00',	'14:40:27',	NULL,	'2023-04-27 14:40:27',	'Unread'),
(33,	'Customer',	72,	1,	'\"hsb\"',	'text',	'2023-04-27 00:00:00',	'15:22:42',	NULL,	'2023-04-27 15:22:42',	'Unread'),
(34,	'Customer',	72,	75,	'\"hello\"',	'text',	'2023-04-27 00:00:00',	'16:15:08',	NULL,	'2023-04-27 16:15:08',	'Unread'),
(35,	'Customer',	72,	75,	'\"hello\"',	'text',	'2023-04-27 00:00:00',	'16:19:09',	NULL,	'2023-04-27 16:19:09',	'Unread'),
(36,	'Customer',	79,	75,	'\"text messages\"',	'text',	'2023-04-27 00:00:00',	'16:36:01',	NULL,	'2023-04-27 16:36:01',	'Unread'),
(37,	'Customer',	72,	75,	'\"hello\"',	'text',	'2023-04-27 00:00:00',	'17:01:58',	NULL,	'2023-04-27 17:01:58',	'Unread'),
(38,	'Customer',	72,	75,	'\"about the\"',	'text',	'2023-04-27 00:00:00',	'17:02:12',	NULL,	'2023-04-27 17:02:12',	'Unread'),
(39,	'Customer',	72,	75,	'\"hello\"',	'text',	'2023-04-27 00:00:00',	'17:02:56',	NULL,	'2023-04-27 17:02:56',	'Unread'),
(40,	'Customer',	74,	70,	'\"hello\"',	'text',	'2023-04-27 00:00:00',	'18:06:11',	NULL,	'2023-04-27 18:06:11',	'Unread'),
(41,	'Customer',	74,	70,	'\"hello\"',	'text',	'2023-04-28 00:00:00',	'10:10:25',	NULL,	'2023-04-28 10:10:25',	'Unread'),
(42,	'Customer',	74,	70,	'\"ab\"',	'text',	'2023-04-28 00:00:00',	'10:10:45',	NULL,	'2023-04-28 10:10:45',	'Unread'),
(43,	'Customer',	74,	70,	'\"a\"',	'text',	'2023-04-28 00:00:00',	'10:12:05',	NULL,	'2023-04-28 10:12:05',	'Unread'),
(44,	'Customer',	3,	4,	'\"hello this is customer message testing123\"',	'text',	'2023-05-03 00:00:00',	'16:04:55',	NULL,	'2023-05-03 16:04:55',	'Unread'),
(45,	'Employee',	4,	3,	'\"hello this is employee message testing098\"',	'text',	'2023-05-03 00:00:00',	'16:05:17',	NULL,	'2023-05-03 16:05:17',	'Read'),
(46,	'Customer',	18,	1,	'\"hello\"',	'text',	'2023-05-05 00:00:00',	'16:47:09',	NULL,	'2023-05-05 16:47:09',	'Unread'),
(47,	'Customer',	6,	1,	'\"hello this is customer message testing\"',	'text',	'2023-05-05 00:00:00',	'17:00:35',	NULL,	'2023-05-05 17:00:35',	'Unread'),
(48,	'Employee',	1,	2,	'\"hello this is employee message testing\"',	'text',	'2023-05-05 00:00:00',	'17:29:12',	NULL,	'2023-05-05 17:29:12',	'Unread');

DROP TABLE IF EXISTS `chat_messages_live`;
CREATE TABLE `chat_messages_live` (
  `chat_messages_live_id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_type` enum('Users','Admin') NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `message_type` enum('text','attachment','location') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `send_date` datetime NOT NULL,
  `send_time` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `read_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` enum('Read','Unread') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`chat_messages_live_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `chat_messages_live` (`chat_messages_live_id`, `sender_type`, `sender_id`, `receiver_id`, `message`, `message_type`, `send_date`, `send_time`, `read_date`, `created_at`, `status`) VALUES
(1,	'Users',	1,	1,	'\"HI\"',	'text',	'2023-04-10 00:00:00',	'10:43:02',	NULL,	'2023-04-10 10:43:02',	'Read'),
(2,	'Users',	1,	1,	'\"HI\"',	'text',	'2023-04-10 00:00:00',	'15:13:36',	NULL,	'2023-04-10 15:13:36',	'Read'),
(3,	'Users',	1,	1,	'\"HI\"',	'text',	'2023-04-10 00:00:00',	'23:07:40',	NULL,	'2023-04-10 23:07:40',	'Read'),
(4,	'Users',	1,	1,	'\"HI\"',	'text',	'2023-04-10 00:00:00',	'23:47:11',	NULL,	'2023-04-10 23:47:11',	'Read'),
(5,	'Users',	1,	10,	'\"HI\"',	'text',	'2023-04-10 00:00:00',	'23:47:42',	NULL,	'2023-04-10 23:47:42',	'Read'),
(6,	'Users',	10,	1,	'\"HI\"',	'text',	'2023-04-10 00:00:00',	'23:48:07',	NULL,	'2023-04-10 23:48:07',	'Unread'),
(7,	'Users',	1,	10,	'\"HI\"',	'text',	'2023-04-10 00:00:00',	'23:49:36',	NULL,	'2023-04-10 23:49:36',	'Read'),
(8,	'Users',	1,	1,	'\"HI\"',	'text',	'2023-04-12 00:00:00',	'10:23:39',	NULL,	'2023-04-12 10:23:39',	'Read'),
(9,	'Users',	1,	2,	'\"HI\"',	'text',	'2023-04-12 00:00:00',	'10:38:02',	NULL,	'2023-04-12 10:38:02',	'Unread'),
(10,	'Users',	1,	1,	'\"HI\"',	'text',	'2023-04-12 00:00:00',	'10:40:42',	NULL,	'2023-04-12 10:40:42',	'Read'),
(11,	'Users',	2,	1,	'\"HI\"',	'text',	'2023-04-12 00:00:00',	'10:41:10',	NULL,	'2023-04-12 10:41:10',	'Read'),
(12,	'Users',	2,	1,	'\"HI h\"',	'text',	'2023-04-12 00:00:00',	'10:43:12',	NULL,	'2023-04-12 10:43:12',	'Read'),
(13,	'Users',	10,	1,	'\"HI h\"',	'text',	'2023-04-12 00:00:00',	'10:55:39',	NULL,	'2023-04-12 10:55:39',	'Unread'),
(14,	'Users',	1,	1,	'\"HI h\"',	'text',	'2023-04-12 00:00:00',	'10:56:41',	NULL,	'2023-04-12 10:56:41',	'Read'),
(15,	'Users',	1,	2,	'\"HI h\"',	'text',	'2023-04-12 00:00:00',	'10:57:00',	NULL,	'2023-04-12 10:57:00',	'Unread'),
(16,	'Users',	1,	1,	'\"HI\"',	'text',	'2023-04-26 00:00:00',	'10:34:19',	NULL,	'2023-04-26 10:34:19',	'Unread');

DROP TABLE IF EXISTS `dummy_table`;
CREATE TABLE `dummy_table` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` text NOT NULL,
  `date_added` datetime NOT NULL,
  `status` enum('Active','Inactive','Deleted','Pending') NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `dummy_table` (`cat_id`, `cat_name`, `date_added`, `status`) VALUES
(6,	'first',	'2023-06-08 14:28:16',	'Active'),
(2,	'Tech',	'2023-06-07 17:02:35',	'Active'),
(4,	'kids',	'2023-06-07 17:04:46',	'Active'),
(5,	'Garments',	'2023-06-08 12:03:17',	'Active');

DROP TABLE IF EXISTS `dummy_table2`;
CREATE TABLE `dummy_table2` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `product_name` text NOT NULL,
  `date_added` datetime NOT NULL,
  `status` enum('Active','Inactive','Pending','Deleted') NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `dummy_table2` (`product_id`, `cat_id`, `product_name`, `date_added`, `status`) VALUES
(2,	1,	'firft produvt',	'2023-06-08 14:28:51',	'Active');

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `notifications_id` int(11) NOT NULL AUTO_INCREMENT,
  `bookings_id` int(11) NOT NULL,
  `senders_id` int(11) NOT NULL,
  `receivers_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `status` enum('Read','Unread') NOT NULL,
  PRIMARY KEY (`notifications_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `notifications` (`notifications_id`, `bookings_id`, `senders_id`, `receivers_id`, `message`, `date_added`, `date_modified`, `status`) VALUES
(1,	0,	2,	1,	'A new message has been recieved.',	'2023-04-06 15:31:17',	'2023-04-06 15:31:17',	'Read'),
(2,	0,	1,	2,	'A new message has been recieved.',	'2023-04-06 15:32:19',	'2023-04-06 15:32:19',	'Read'),
(3,	0,	2,	1,	'A new message has been recieved.',	'2023-04-08 11:42:46',	'2023-04-08 11:42:46',	'Read'),
(4,	0,	2,	1,	'A new message has been recieved.',	'2023-04-08 12:07:40',	'2023-04-08 12:07:40',	'Read'),
(5,	0,	12,	14,	'A new message has been recieved.',	'2023-04-08 12:07:57',	'2023-04-08 12:07:57',	'Read'),
(6,	0,	1,	2,	'A new message has been recieved.',	'2023-04-08 12:11:13',	'2023-04-08 12:11:13',	'Read'),
(7,	0,	34,	1,	'A new message has been recieved.',	'2023-04-10 10:25:18',	'2023-04-10 10:25:18',	'Read'),
(8,	0,	34,	1,	'A new message has been recieved.',	'2023-04-10 10:33:19',	'2023-04-10 10:33:19',	'Read'),
(9,	0,	34,	1,	'A new message has been recieved.',	'2023-04-10 10:36:22',	'2023-04-10 10:36:22',	'Read'),
(10,	0,	1,	1,	'sent a message.',	'2023-04-10 10:43:02',	'2023-04-10 10:43:02',	'Read'),
(11,	0,	34,	1,	'A new message has been recieved.',	'2023-04-10 11:26:47',	'2023-04-10 11:26:47',	'Read'),
(12,	0,	1,	1,	'sent a message.',	'2023-04-10 15:13:36',	'2023-04-10 15:13:36',	'Read'),
(13,	0,	1,	1,	'sent a message.',	'2023-04-10 23:07:40',	'2023-04-10 23:07:40',	'Read'),
(14,	0,	1,	1,	'sent a message.',	'2023-04-10 23:47:11',	'2023-04-10 23:47:11',	'Read'),
(15,	0,	1,	10,	'sent a message.',	'2023-04-10 23:47:42',	'2023-04-10 23:47:42',	'Unread'),
(16,	0,	10,	1,	'sent a message.',	'2023-04-10 23:48:08',	'2023-04-10 23:48:08',	'Read'),
(17,	0,	1,	10,	'sent a message.',	'2023-04-10 23:49:37',	'2023-04-10 23:49:37',	'Unread'),
(18,	0,	1,	1,	'sent a message.',	'2023-04-12 10:23:39',	'2023-04-12 10:23:39',	'Read'),
(19,	0,	1,	2,	'sent a message.',	'2023-04-12 10:38:02',	'2023-04-12 10:38:02',	'Unread'),
(20,	0,	1,	1,	'sent a message.',	'2023-04-12 10:40:42',	'2023-04-12 10:40:42',	'Read'),
(21,	0,	2,	1,	'sent a message.',	'2023-04-12 10:41:10',	'2023-04-12 10:41:10',	'Read'),
(22,	0,	2,	1,	'sent a message.',	'2023-04-12 10:43:12',	'2023-04-12 10:43:12',	'Read'),
(23,	0,	10,	1,	'sent a message.',	'2023-04-12 10:55:40',	'2023-04-12 10:55:40',	'Read'),
(24,	0,	1,	1,	'sent a message.',	'2023-04-12 10:56:41',	'2023-04-12 10:56:41',	'Read'),
(25,	0,	1,	2,	'sent a message.',	'2023-04-12 10:57:00',	'2023-04-12 10:57:00',	'Unread'),
(26,	0,	2,	1,	'A new message has been recieved.',	'2023-04-12 16:14:58',	'2023-04-12 16:14:58',	'Read'),
(27,	0,	1,	2,	'A new message has been recieved.',	'2023-04-12 16:15:06',	'2023-04-12 16:15:06',	'Read'),
(28,	0,	2,	1,	'A new message has been recieved.',	'2023-04-13 11:58:52',	'2023-04-13 11:58:52',	'Read'),
(29,	0,	1,	2,	'A new message has been recieved.',	'2023-04-13 12:00:48',	'2023-04-13 12:00:48',	'Read'),
(30,	0,	1,	2,	'A new message has been recieved.',	'2023-04-13 12:21:29',	'2023-04-13 12:21:29',	'Read'),
(31,	0,	2,	1,	'A new message has been recieved.',	'2023-04-13 12:21:37',	'2023-04-13 12:21:37',	'Read'),
(32,	0,	1,	2,	'A new message has been recieved.',	'2023-04-13 13:56:44',	'2023-04-13 13:56:44',	'Read'),
(33,	0,	2,	1,	'A new message has been recieved.',	'2023-04-13 13:57:04',	'2023-04-13 13:57:04',	'Read'),
(34,	0,	2,	1,	'A new message has been recieved.',	'2023-04-13 13:59:03',	'2023-04-13 13:59:03',	'Read'),
(35,	0,	2,	1,	'A new message has been recieved.',	'2023-04-13 13:59:54',	'2023-04-13 13:59:54',	'Read'),
(36,	0,	2,	15,	'A new message has been recieved.',	'2023-04-13 14:02:42',	'2023-04-13 14:02:42',	'Read'),
(37,	0,	2,	15,	'A new message has been recieved.',	'2023-04-13 14:03:02',	'2023-04-13 14:03:02',	'Read'),
(38,	0,	15,	2,	'A new message has been recieved.',	'2023-04-13 14:03:58',	'2023-04-13 14:03:58',	'Read'),
(39,	0,	15,	2,	'A new message has been recieved.',	'2023-04-13 14:04:05',	'2023-04-13 14:04:05',	'Read'),
(40,	0,	15,	2,	'A new message has been recieved.',	'2023-04-13 14:06:06',	'2023-04-13 14:06:06',	'Read'),
(41,	0,	2,	15,	'A new message has been recieved.',	'2023-04-13 14:06:30',	'2023-04-13 14:06:30',	'Read'),
(42,	0,	2,	15,	'A new message has been recieved.',	'2023-04-13 14:06:39',	'2023-04-13 14:06:39',	'Read'),
(43,	0,	2,	4,	'A new message has been recieved.',	'2023-04-14 11:47:15',	'2023-04-14 11:47:15',	'Read'),
(44,	0,	1,	2,	'A new message has been recieved.',	'2023-04-14 12:35:39',	'2023-04-14 12:35:39',	'Read'),
(45,	0,	1,	1,	'sent a message.',	'2023-04-26 10:34:19',	'2023-04-26 10:34:19',	'Read'),
(46,	0,	72,	1,	'A new message has been recieved.',	'2023-04-26 13:11:10',	'2023-04-26 13:11:10',	'Read'),
(47,	0,	72,	1,	'A new message has been recieved.',	'2023-04-27 12:40:30',	'2023-04-27 12:40:30',	'Read'),
(48,	0,	74,	1,	'A new message has been recieved.',	'2023-04-27 14:40:27',	'2023-04-27 14:40:27',	'Read'),
(49,	0,	72,	1,	'A new message has been recieved.',	'2023-04-27 15:22:42',	'2023-04-27 15:22:42',	'Read'),
(50,	0,	72,	75,	'A new message has been recieved.',	'2023-04-27 16:15:08',	'2023-04-27 16:15:08',	'Read'),
(51,	0,	72,	75,	'A new message has been recieved.',	'2023-04-27 16:19:09',	'2023-04-27 16:19:09',	'Read'),
(52,	0,	79,	75,	'A new message has been recieved.',	'2023-04-27 16:36:01',	'2023-04-27 16:36:01',	'Read'),
(53,	0,	72,	75,	'A new message has been recieved.',	'2023-04-27 17:01:58',	'2023-04-27 17:01:58',	'Read'),
(54,	0,	72,	75,	'A new message has been recieved.',	'2023-04-27 17:02:12',	'2023-04-27 17:02:12',	'Read'),
(55,	0,	72,	75,	'A new message has been recieved.',	'2023-04-27 17:02:56',	'2023-04-27 17:02:56',	'Read'),
(56,	0,	74,	70,	'A new message has been recieved.',	'2023-04-27 18:06:11',	'2023-04-27 18:06:11',	'Read'),
(57,	0,	74,	70,	'A new message has been recieved.',	'2023-04-28 10:10:25',	'2023-04-28 10:10:25',	'Read'),
(58,	0,	74,	70,	'A new message has been recieved.',	'2023-04-28 10:10:45',	'2023-04-28 10:10:45',	'Read'),
(59,	0,	74,	70,	'A new message has been recieved.',	'2023-04-28 10:12:05',	'2023-04-28 10:12:05',	'Read'),
(60,	0,	3,	4,	'A new message has been recieved.',	'2023-05-03 16:04:55',	'2023-05-03 16:04:55',	'Read'),
(61,	0,	4,	3,	'A new message has been recieved.',	'2023-05-03 16:05:17',	'2023-05-03 16:05:17',	'Read'),
(62,	0,	18,	1,	'A new message has been recieved.',	'2023-05-05 16:47:09',	'2023-05-05 16:47:09',	'Read'),
(63,	0,	6,	1,	'A new message has been recieved.',	'2023-05-05 17:00:35',	'2023-05-05 17:00:35',	'Read'),
(64,	0,	1,	2,	'A new message has been recieved.',	'2023-05-05 17:29:12',	'2023-05-05 17:29:12',	'Read');

DROP TABLE IF EXISTS `system_settings`;
CREATE TABLE `system_settings` (
  `system_settings_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`system_settings_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `system_settings` (`system_settings_id`, `type`, `description`) VALUES
(1,	'system_name',	'Mecca'),
(2,	'email',	'support@mecca.com'),
(3,	'phone',	'1234567890'),
(4,	'language',	'english'),
(5,	'address',	'ABCD'),
(6,	'system_image',	'mecca.png'),
(7,	'smtp_host',	'localhost'),
(8,	'smtp_port',	'21'),
(9,	'smtp_username',	'no-reply@standman.com'),
(10,	'smtp_password',	'admin'),
(11,	'geo_api_key',	'AIzaSyC4HqZf-zANxtQqW0riYOrRKdrXvzMqCqM'),
(12,	'system_currency',	'$'),
(13,	'onesignal_appId',	'60c86bbb-36cd-406a-b336-2a88bbd68402'),
(14,	'one_signal_server_key',	'AAAATnqWTbw:APA91bE_DZqQwnLOgZwu6RTI8wrqKy0lZey11jzQT-lTtAn0Wa3PFQGfHf5U6GGVJjeOaWBz9KdoNGDNI0EE9M4OiwkppBSwpGjELEfBwowJFt1kwfiwRxaXskMaqt2ob9poF7cFItXL'),
(15,	'one_signal_sender_id',	'337064119740'),
(16,	'social_login',	'Yes'),
(17,	'invite_text',	'Invite \r\nLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing.\r\n\r\nLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing.'),
(18,	'terms_text',	'Terms \r\nLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing.\r\n\r\nLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing.'),
(19,	'about_text',	'1'),
(23,	'job_radius',	'10'),
(20,	'privacy_text',	'Privacy \r\nLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing.\r\n\r\nLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing.'),
(21,	'service_charges',	'2');

DROP TABLE IF EXISTS `users_customers`;
CREATE TABLE `users_customers` (
  `users_customers_id` int(11) NOT NULL AUTO_INCREMENT,
  `one_signal_id` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `users_customers_type` enum('Employee','Customer') NOT NULL,
  `first_name` text DEFAULT NULL,
  `last_name` text DEFAULT NULL,
  `phone` text DEFAULT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `profile_pic` text DEFAULT NULL,
  `proof_document` text DEFAULT NULL,
  `valid_document` text DEFAULT NULL,
  `messages` enum('Yes','No') DEFAULT 'Yes',
  `notifications` enum('Yes','No') NOT NULL,
  `account_type` enum('SignupWithApp','SignupWithSocial','Both') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `social_acc_type` enum('Google','Facebook','None') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `google_access_token` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `verify_code` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `verified_badge` enum('Yes','No') NOT NULL DEFAULT 'No',
  `date_expiry` date DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Active','Inactive','Deleted') NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`users_customers_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `users_customers` (`users_customers_id`, `one_signal_id`, `users_customers_type`, `first_name`, `last_name`, `phone`, `email`, `password`, `profile_pic`, `proof_document`, `valid_document`, `messages`, `notifications`, `account_type`, `social_acc_type`, `google_access_token`, `verify_code`, `verified_badge`, `date_expiry`, `date_added`, `status`) VALUES
(52,	'123456',	'Employee',	'User09',	'Dummy',	NULL,	'User@gmail.com',	'202cb962ac59075b964b07152d234b70',	NULL,	NULL,	NULL,	'Yes',	'Yes',	'SignupWithApp',	'None',	'',	NULL,	'No',	NULL,	'2023-05-23 18:48:25',	'Active'),
(53,	'123456',	'Employee',	'salman',	'ahmed',	NULL,	'salmanbhatti52@gmail.com',	'e10adc3949ba59abbe56e057f20f883e',	NULL,	NULL,	NULL,	'Yes',	'Yes',	'SignupWithApp',	'None',	'',	NULL,	'No',	NULL,	'2023-05-27 17:21:19',	'Active'),
(51,	'123456',	'Employee',	'User',	'Dummy',	NULL,	'user5@gmail.com',	'47fb33421eb25052e477ab7bbc53e72f',	NULL,	NULL,	NULL,	'Yes',	'Yes',	'SignupWithApp',	'None',	'',	NULL,	'No',	NULL,	'2023-05-23 18:45:35',	'Active'),
(50,	'123456',	'Employee',	'Tehreem',	'Fatima',	NULL,	'Zubaria.tehreem9@gmail.com',	'1f262a60600e30c026663a7ccbed6bab',	NULL,	NULL,	NULL,	'Yes',	'Yes',	'SignupWithApp',	'None',	'',	NULL,	'No',	NULL,	'2023-05-23 18:22:25',	'Active'),
(49,	'123456',	'Employee',	'aa',	'bb',	NULL,	'user245@gmail.com',	'94e7d712742adbbb7a73a1d52a7cc1a9',	NULL,	NULL,	NULL,	'Yes',	'Yes',	'SignupWithApp',	'None',	'',	'9986',	'No',	NULL,	'2023-05-23 18:20:40',	'Active'),
(48,	'123456',	'Employee',	'aa',	'bb',	NULL,	'fffs@gdd.com',	'94e7d712742adbbb7a73a1d52a7cc1a9',	NULL,	NULL,	NULL,	'Yes',	'Yes',	'SignupWithApp',	'None',	'',	NULL,	'No',	NULL,	'2023-05-23 18:20:20',	'Active'),
(47,	'123456',	'Employee',	'Zubair',	'shahid',	NULL,	'iamzubairshahid@gmail.com',	'e10adc3949ba59abbe56e057f20f883e',	NULL,	NULL,	NULL,	'Yes',	'Yes',	'SignupWithApp',	'None',	'',	NULL,	'No',	NULL,	'2023-05-23 18:20:19',	'Active'),
(46,	'123456',	'Employee',	'Zakir',	'Naik',	NULL,	'mrbrucewayne99@gmail.com',	'f5748aa8090a9d56192c1e5263484dad',	NULL,	NULL,	NULL,	'Yes',	'Yes',	'SignupWithApp',	'None',	'',	NULL,	'No',	NULL,	'2023-05-23 17:22:32',	'Active'),
(45,	'123456',	'Employee',	'Mo',	'Nath',	NULL,	'ynath23@icloud.com',	'9a694d63b0bc5279af690926aa4df0ad',	NULL,	NULL,	NULL,	'Yes',	'Yes',	'SignupWithApp',	'None',	'',	NULL,	'No',	NULL,	'2023-05-18 03:51:37',	'Active'),
(44,	'123456',	'Employee',	'ali',	'tareen',	NULL,	'alitareen@gmail.com',	'e10adc3949ba59abbe56e057f20f883e',	NULL,	NULL,	NULL,	'Yes',	'Yes',	'SignupWithApp',	'None',	'',	'3357',	'No',	NULL,	'2023-05-15 22:18:29',	'Active'),
(43,	'123456',	'Employee',	'mughees',	'malik',	NULL,	'mugheesmalik101@gmail.com',	'25f9e794323b453885f5181f1b624d0b',	NULL,	NULL,	NULL,	'Yes',	'Yes',	'SignupWithApp',	'None',	'',	NULL,	'No',	NULL,	'2023-05-13 14:08:23',	'Active'),
(42,	'123456',	'Employee',	'salman',	'ahmed',	NULL,	'salmanahmed124@gmail.com',	'e10adc3949ba59abbe56e057f20f883e',	NULL,	NULL,	NULL,	'Yes',	'Yes',	'SignupWithApp',	'None',	'',	NULL,	'No',	NULL,	'2023-05-12 17:08:03',	'Active'),
(41,	'123456',	'Employee',	'Tehreem',	'Hashmi',	NULL,	'tehreem.hashmi007@gmail.com',	'5e9167571c4fdf5f5bceabb11ca7d4c9',	NULL,	NULL,	NULL,	'Yes',	'Yes',	'SignupWithApp',	'None',	'',	'8839',	'No',	NULL,	'2023-05-11 02:18:30',	'Active'),
(40,	'123456',	'Employee',	'anna',	'singer',	NULL,	'annasinger444@gmail.com',	'25f9e794323b453885f5181f1b624d0b',	NULL,	NULL,	NULL,	'Yes',	'Yes',	'SignupWithApp',	'None',	'',	NULL,	'No',	NULL,	'2023-05-10 14:25:30',	'Active');

DROP TABLE IF EXISTS `users_customers_delete`;
CREATE TABLE `users_customers_delete` (
  `users_customers_delete_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  `delete_reason` text NOT NULL,
  `comments` text NOT NULL,
  `date_added` datetime NOT NULL,
  `status` enum('Pending','Approved','Declined') NOT NULL,
  PRIMARY KEY (`users_customers_delete_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `users_customers_delete` (`users_customers_delete_id`, `email`, `delete_reason`, `comments`, `date_added`, `status`) VALUES
(1,	'salmanbhatti52@gmail.com',	'test delete',	'Hello',	'2023-03-21 15:55:04',	'Pending'),
(2,	'hammadraza5388@gmail.com',	'test delete',	'Hello',	'2023-03-31 12:11:00',	'Pending'),
(3,	'mh630525@gmail.com',	'test delete',	'Hello',	'2023-03-31 14:06:18',	'Pending'),
(4,	'hammad5@gmail.com',	'test delete',	'Hello',	'2023-03-31 14:18:38',	'Pending'),
(5,	'haha@gmail.com',	'test delete',	'Hello',	'2023-04-06 10:20:05',	'Pending'),
(6,	'tehreem.hashmi007@gmail.com',	'test delete',	'Hello',	'2023-04-07 15:33:34',	'Pending'),
(7,	'customer@gmail.com',	'test delete',	'Hello',	'2023-04-07 16:02:21',	'Pending'),
(8,	'test@gmail.com',	'test delete',	'Hello',	'2023-04-07 22:52:24',	'Pending'),
(9,	'zubaria.tehreem9@gmail.com',	'test delete',	'Hello',	'2023-04-14 15:04:28',	'Pending'),
(10,	'annasinger444@gmail.com',	'test delete',	'Hello',	'2023-05-20 13:48:36',	'Pending'),
(11,	'mugheesmalik101@gmail.com',	'test delete',	'Hello',	'2023-06-17 15:16:50',	'Pending');

DROP TABLE IF EXISTS `users_system`;
CREATE TABLE `users_system` (
  `users_system_id` int(11) NOT NULL AUTO_INCREMENT,
  `users_system_roles_id` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `email` varchar(111) NOT NULL,
  `password` varchar(111) NOT NULL,
  `mobile` varchar(44) NOT NULL,
  `city` text NOT NULL,
  `address` text NOT NULL,
  `user_image` varchar(111) DEFAULT NULL,
  `is_deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`users_system_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users_system` (`users_system_id`, `users_system_roles_id`, `first_name`, `email`, `password`, `mobile`, `city`, `address`, `user_image`, `is_deleted`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
(1,	1,	'Super Admin',	'admin@mecca.com',	'admin',	'+6013008637767',	'KLCC',	'Malaysia',	'uploads/users_system/user-677d9d74c67929023eedb8469a34003b.jpeg',	'No',	NULL,	NULL,	NULL,	'Active');

DROP TABLE IF EXISTS `users_system_roles`;
CREATE TABLE `users_system_roles` (
  `users_system_roles_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `status` enum('Inactive','Active') NOT NULL,
  `dashboard` enum('Yes','No') NOT NULL,
  `users_customers` enum('Yes','No') NOT NULL,
  `support` enum('Yes','No') NOT NULL,
  `users_system` enum('Yes','No') NOT NULL,
  `users_system_roles` enum('Yes','No') NOT NULL,
  `account_settings` enum('Yes','No') NOT NULL,
  `system_settings` enum('Yes','No') NOT NULL,
  PRIMARY KEY (`users_system_roles_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users_system_roles` (`users_system_roles_id`, `name`, `status`, `dashboard`, `users_customers`, `support`, `users_system`, `users_system_roles`, `account_settings`, `system_settings`) VALUES
(1,	'Super Admin',	'Active',	'Yes',	'Yes',	'Yes',	'Yes',	'Yes',	'Yes',	'Yes');

-- 2023-09-11 05:04:08
