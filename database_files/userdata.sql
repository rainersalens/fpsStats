-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2023 at 02:19 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `userdata`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `discussion_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `discussion_id`, `content`, `created_on`) VALUES
(28, 1, 26, 'You may use this forum for chatting about various topics with other individuals.', '2023-06-12 23:07:05'),
(29, 1, 18, 'test', '2023-06-13 12:25:18');

-- --------------------------------------------------------

--
-- Table structure for table `credentials`
--

CREATE TABLE `credentials` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT current_timestamp(),
  `privilege` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `credentials`
--

INSERT INTO `credentials` (`id`, `username`, `email`, `password`, `createdOn`, `privilege`) VALUES
(1, 'admin', 'test@test.test', '1', '2023-06-09 22:00:47', 'admin'),
(3, 'user', 'test@t.t', '1', '2023-06-09 23:08:39', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `discussions`
--

CREATE TABLE `discussions` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `pinned` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `discussion_type` int(11) NOT NULL DEFAULT 1,
  `is_edited` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discussions`
--

INSERT INTO `discussions` (`id`, `title`, `content`, `created_at`, `pinned`, `user_id`, `discussion_type`, `is_edited`) VALUES
(18, 'Sveiki!', 'Sveiki! Esiet sveicināti fpsStats forumā.\n\nŠeit jūs varat izrunāt visu, kas ir par spēlēm un fpsStats.', '2023-06-12 21:02:04', 0, 1, 1, 1),
(26, 'What may I use this forum for?', 'Just like the title says. What is this forum for?', '2023-06-12 22:06:42', 0, 3, 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `discussion_types`
--

CREATE TABLE `discussion_types` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discussion_types`
--

INSERT INTO `discussion_types` (`id`, `name`, `created_at`) VALUES
(1, 'General discussion', '2023-06-11 19:07:50'),
(5, 'Apex Legends Discussion', '2023-06-12 21:10:49'),
(6, 'Fortnite Discussion', '2023-06-12 21:10:52'),
(7, 'Questions', '2023-06-12 21:10:56'),
(12, 'Suggestions', '2023-06-12 21:13:11');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `name`) VALUES
(1, 'Apex Legends'),
(2, 'Fortnite');

-- --------------------------------------------------------

--
-- Table structure for table `third_party_user_accounts`
--

CREATE TABLE `third_party_user_accounts` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `third_party_user_accounts`
--

INSERT INTO `third_party_user_accounts` (`id`, `username`, `user_id`, `game_id`) VALUES
(5, 'RainIsTakenBruh', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_ranks_apex`
--

CREATE TABLE `user_ranks_apex` (
  `id` int(11) NOT NULL,
  `third_party_user_account_id` int(11) NOT NULL,
  `rank` varchar(50) NOT NULL,
  `rank_division` varchar(50) NOT NULL,
  `rank_image_link` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_ranks_apex`
--

INSERT INTO `user_ranks_apex` (`id`, `third_party_user_account_id`, `rank`, `rank_division`, `rank_image_link`) VALUES
(1, 1, 'Rookie', '4', 'https://api.mozambiquehe.re/assets/ranks/rookie4.p');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discussion_id` (`discussion_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `credentials`
--
ALTER TABLE `credentials`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `discussions`
--
ALTER TABLE `discussions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `discussion_types`
--
ALTER TABLE `discussion_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `third_party_user_accounts`
--
ALTER TABLE `third_party_user_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_ranks_apex`
--
ALTER TABLE `user_ranks_apex`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `credentials`
--
ALTER TABLE `credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `discussions`
--
ALTER TABLE `discussions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `discussion_types`
--
ALTER TABLE `discussion_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `third_party_user_accounts`
--
ALTER TABLE `third_party_user_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_ranks_apex`
--
ALTER TABLE `user_ranks_apex`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `credentials` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `discussions`
--
ALTER TABLE `discussions`
  ADD CONSTRAINT `fk_user_discussion` FOREIGN KEY (`user_id`) REFERENCES `credentials` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
