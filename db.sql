-- phpMyAdmin SQL Dump
-- version 4.8.0-dev
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 16, 2017 at 02:17 AM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.0.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `open`
--

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

CREATE TABLE `blocks` (
  `block_id` int(11) NOT NULL,
  `block_to` int(11) NOT NULL,
  `block_by` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `communities`
--

CREATE TABLE `communities` (
  `community_id` int(11) NOT NULL,
  `community_title` int(11) NOT NULL,
  `community_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `community_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `community_icon` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `community_banner` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `community_platform` int(1) NOT NULL COMMENT '0 = 3DS, 1 = Wii U, 2 = 3DS/Wii U, 3 or more = N/A',
  `community_type` int(1) NOT NULL,
  `community_perms` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `empathies`
--

CREATE TABLE `empathies` (
  `yeah_id` int(11) NOT NULL,
  `yeah_type` int(1) NOT NULL,
  `yeah_to` int(11) NOT NULL,
  `yeah_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `favorite_id` int(11) NOT NULL,
  `favorite_by` int(11) NOT NULL,
  `favorite_to` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `follow_id` int(11) NOT NULL,
  `follow_to` int(11) NOT NULL,
  `follow_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `friendships`
--

CREATE TABLE `friendships` (
  `friend_id` int(11) NOT NULL,
  `friend_date` datetime NOT NULL,
  `friend_to` int(11) NOT NULL,
  `friend_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `request_id` int(11) NOT NULL,
  `request_to` int(11) NOT NULL,
  `request_by` int(11) NOT NULL,
  `request_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `login_tokens`
--

CREATE TABLE `login_tokens` (
  `token_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `token_for` int(11) NOT NULL,
  `token_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `token_status` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `message_to` int(11) NOT NULL,
  `message_by` int(11) NOT NULL,
  `message_feeling_id` int(1) NOT NULL,
  `message_content` text NOT NULL,
  `message_is_spoiler` int(1) NOT NULL,
  `message_screenshot` varchar(1024) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notif_id` int(11) NOT NULL,
  `notif_type` int(1) NOT NULL,
  `notif_to` int(11) NOT NULL,
  `notif_by` int(11) NOT NULL,
  `notif_topic` int(11) NOT NULL,
  `notif_date` datetime NOT NULL,
  `notif_read` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `post_feeling_id` int(1) NOT NULL,
  `post_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `post_screenshot` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `post_drawing` text COLLATE utf8_unicode_ci,
  `post_url` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `post_is_spoiler` int(1) DEFAULT '0',
  `post_has_title_depended_value` int(1) NOT NULL,
  `post_date` datetime NOT NULL,
  `post_community` int(11) NOT NULL,
  `post_by` int(11) NOT NULL,
  `post_status` int(1) NOT NULL,
  `post_edited` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_reports`
--

CREATE TABLE `post_reports` (
  `report_id` int(11) NOT NULL,
  `report_to` int(11) NOT NULL,
  `report_by` int(11) NOT NULL,
  `report_type` int(1) NOT NULL,
  `report_body` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL,
  `report_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_yeahs`
--

CREATE TABLE `post_yeahs` (
  `yeah_id` int(11) NOT NULL,
  `yeah_post` int(11) NOT NULL,
  `yeah_by` int(11) NOT NULL,
  `yeah_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `reply_id` int(11) NOT NULL,
  `reply_to` int(11) NOT NULL,
  `reply_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `reply_feeling_id` int(1) NOT NULL,
  `reply_screenshot` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `reply_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `reply_date` datetime NOT NULL,
  `reply_is_spoiler` int(1) NOT NULL,
  `reply_by` int(11) NOT NULL,
  `reply_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reply_reports`
--

CREATE TABLE `reply_reports` (
  `rreport_id` int(11) NOT NULL,
  `rreport_to` int(11) NOT NULL,
  `rreport_by` int(11) NOT NULL,
  `rreport_type` int(1) NOT NULL,
  `rreport_body` tinytext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `rreport_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reply_yeahs`
--

CREATE TABLE `reply_yeahs` (
  `ryeah_id` int(11) NOT NULL,
  `ryeah_reply` int(11) NOT NULL,
  `ryeah_by` int(11) NOT NULL,
  `ryeah_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `titles`
--

CREATE TABLE `titles` (
  `title_id` int(11) NOT NULL,
  `title_type` int(1) NOT NULL,
  `title_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `title_icon` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `title_banner` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `title_platform` int(1) NOT NULL COMMENT '0 = 3DS, 1 = Wii U, 2 = 3DS/Wii U, 3 or more = N/A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `user_pid` int(11) NOT NULL,
  `user_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `user_pass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `user_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `user_date` datetime NOT NULL,
  `user_rank` int(1) NOT NULL DEFAULT '0',
  `user_avatar` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `user_profile_comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `user_country` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `user_birthday` date NOT NULL,
  `user_website` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `user_skill` int(1) NOT NULL DEFAULT '0',
  `user_systems` int(1) NOT NULL DEFAULT '0',
  `user_favorite_post` int(11) NOT NULL,
  `user_favorite_post_type` int(1) NOT NULL,
  `user_nnid` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `user_ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `user_code` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `user_email_confirmed` int(1) NOT NULL,
  `user_relationship_visibility` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`block_id`);

--
-- Indexes for table `communities`
--
ALTER TABLE `communities`
  ADD PRIMARY KEY (`community_id`);

--
-- Indexes for table `empathies`
--
ALTER TABLE `empathies`
  ADD PRIMARY KEY (`yeah_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`favorite_id`);

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`follow_id`);

--
-- Indexes for table `friendships`
--
ALTER TABLE `friendships`
  ADD PRIMARY KEY (`friend_id`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `login_tokens`
--
ALTER TABLE `login_tokens`
  ADD PRIMARY KEY (`token_id`),
  ADD KEY `token_for` (`token_for`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notif_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `post_reports`
--
ALTER TABLE `post_reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `post_yeahs`
--
ALTER TABLE `post_yeahs`
  ADD PRIMARY KEY (`yeah_id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`reply_id`);

--
-- Indexes for table `reply_reports`
--
ALTER TABLE `reply_reports`
  ADD PRIMARY KEY (`rreport_id`);

--
-- Indexes for table `reply_yeahs`
--
ALTER TABLE `reply_yeahs`
  ADD PRIMARY KEY (`ryeah_id`);

--
-- Indexes for table `titles`
--
ALTER TABLE `titles`
  ADD PRIMARY KEY (`title_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_pid`),
  ADD UNIQUE KEY `user_pid` (`user_pid`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blocks`
--
ALTER TABLE `blocks`
  MODIFY `block_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `communities`
--
ALTER TABLE `communities`
  MODIFY `community_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `empathies`
--
ALTER TABLE `empathies`
  MODIFY `yeah_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `favorite_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `follows`
--
ALTER TABLE `follows`
  MODIFY `follow_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `friendships`
--
ALTER TABLE `friendships`
  MODIFY `friend_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=734;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `post_reports`
--
ALTER TABLE `post_reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `post_yeahs`
--
ALTER TABLE `post_yeahs`
  MODIFY `yeah_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=560;
--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=282;
--
-- AUTO_INCREMENT for table `reply_reports`
--
ALTER TABLE `reply_reports`
  MODIFY `rreport_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `reply_yeahs`
--
ALTER TABLE `reply_yeahs`
  MODIFY `ryeah_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `titles`
--
ALTER TABLE `titles`
  MODIFY `title_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;COMMIT;

