-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 11, 2021 at 07:13 AM
-- Server version: 5.7.24
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recipe`
--

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `material_id` int(11) NOT NULL,
  `material_name` varchar(100) NOT NULL,
  `material_amount` varchar(100) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`material_id`, `material_name`, `material_amount`, `recipe_id`, `created_at`, `updated_at`) VALUES
(1, '厚切りベーコン', '100g', 1, '2021-06-12 11:35:11', '2021-06-12 11:35:11'),
(2, 'キノコ（エリンギ・しめじ・えのき）', '200g', 1, '2021-06-12 11:35:11', '2021-06-12 11:35:11'),
(3, '調整豆乳', '400ml～500ml', 1, '2021-06-12 11:36:20', '2021-06-12 11:36:20'),
(4, 'アレルギー用ブイヨン', '1袋', 1, '2021-06-12 11:36:20', '2021-06-12 11:36:20'),
(5, '塩糀', '大1', 1, '2021-06-12 11:37:02', '2021-06-12 11:37:02'),
(6, 'オリーブ油', '小1', 1, '2021-06-12 11:37:02', '2021-06-12 11:37:02'),
(7, '大根', '小1/2本', 2, '2021-06-20 17:31:22', '2021-06-20 17:31:22'),
(8, '豚バラ肉', '140g', 2, '2021-06-20 17:31:22', '2021-06-20 17:31:22'),
(9, 'てんさい糖', '大1', 2, '2021-06-20 17:32:05', '2021-06-20 17:32:05'),
(10, 'みりん', '大2', 2, '2021-06-20 17:32:05', '2021-06-20 17:32:05'),
(11, 'しょうゆ', '大1と1/2', 2, '2021-06-20 17:32:48', '2021-06-20 17:32:48'),
(12, '水', '3/4カップ', 2, '2021-06-20 17:32:48', '2021-06-20 17:32:48'),
(13, '青ネギ', 'お好みで', 2, '2021-06-20 17:33:00', '2021-06-20 17:33:00');

-- --------------------------------------------------------

--
-- Table structure for table `processes`
--

CREATE TABLE `processes` (
  `process_id` int(11) NOT NULL,
  `process_content` varchar(200) NOT NULL,
  `process_number` int(11) NOT NULL,
  `trick` varchar(400) DEFAULT NULL,
  `recipe_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `processes`
--

INSERT INTO `processes` (`process_id`, `process_content`, `process_number`, `trick`, `recipe_id`, `created_at`, `updated_at`) VALUES
(1, 'エリンギ、しめじ、えのきは食べやすい大きさにカットし、塩糀を加え、全体にからむように混ぜ合わせる。そのまま３０分以上おいておく。', 1, 'きのこと塩糀を混ぜておくと水分が出ますが、きのこの旨みが出ているので汁ごと使いましょう。\r\n豆乳は、無調整豆乳でも可ですが、調整豆乳のほうが、きのことの相性がよく、コクが出ます。', 1, '2021-06-27 18:51:46', '2021-06-27 18:51:46'),
(2, 'ベーコンは１ｃｍの厚さに切り、オリーブ油を入れた鍋でベーコンを炒める。火が通ったらきのこ類も全部加えて炒める。', 2, NULL, 1, '2021-06-27 18:51:46', '2021-06-27 18:52:38'),
(3, '調整豆乳を入れ、ブイヨンを入れる。沸騰しない程度に温める。', 3, NULL, 1, '2021-06-27 18:52:29', '2021-06-27 18:52:29');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `recipe_id` int(11) NOT NULL,
  `recipe_name` varchar(100) NOT NULL,
  `recipe_image` varchar(200) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `number_of_materials` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`recipe_id`, `recipe_name`, `recipe_image`, `user_id`, `number_of_materials`, `created_at`, `updated_at`) VALUES
(1, 'きのこの旨みたっぷりスープ', 'recipe-1.jpg', 1, 4, '2021-06-12 11:33:31', '2021-06-20 17:52:41'),
(2, '味しみ豚バラ大根', 'recipe-2.jpg', 1, 3, '2021-06-20 17:30:24', '2021-06-20 17:52:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `email` varchar(400) NOT NULL,
  `password` varchar(255) NOT NULL,
  `temp_pass` varchar(255) DEFAULT NULL,
  `temp_pass_limit_time` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `email`, `password`, `temp_pass`, `temp_pass_limit_time`, `created_at`, `updated_at`) VALUES
(1, 'unakiba', 'example@mail.com', '$2y$10$wQCjo5..EDITWEwvqtUyLOruSEwLxkUT5b5BOcjnl5Kyv1cmr3Zii', NULL, NULL, '2021-07-10 20:19:47', '2021-07-10 20:19:47'),
(2, 'll', 'example@mail.com', '$2y$10$Rec0srQ1iUvP84V7wuSAEOoUVSPq1zfgqT6ivDEUJuUjysyUZlKg2', NULL, NULL, '2021-07-10 20:23:50', '2021-07-10 20:23:50'),
(3, 'll', 'example@mail.com', '$2y$10$264a48KF76208Ph0pOLELu07RnBVAryy9dBifTrzZYslwPwNVz1wq', NULL, NULL, '2021-07-10 20:23:58', '2021-07-10 20:23:58'),
(4, 'll', 'example@mail.com', '$2y$10$t1Kp/04j/UnnkclbGLR3dOcUGgcaoeUVmt7GJ.uwsNOOdALYZToLu', NULL, NULL, '2021-07-10 20:24:00', '2021-07-10 20:24:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`material_id`);

--
-- Indexes for table `processes`
--
ALTER TABLE `processes`
  ADD PRIMARY KEY (`process_id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`recipe_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `processes`
--
ALTER TABLE `processes`
  MODIFY `process_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `recipe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
