-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:3306
-- 生成日時: 
-- サーバのバージョン： 5.7.24
-- PHP のバージョン: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `recipe`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `processes`
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
-- テーブルのデータのダンプ `processes`
--

INSERT INTO `processes` (`process_id`, `process_content`, `process_number`, `trick`, `recipe_id`, `created_at`, `updated_at`) VALUES
(1, 'エリンギ、しめじ、えのきは食べやすい大きさにカットし、塩糀を加え、全体にからむように混ぜ合わせる。そのまま３０分以上おいておく。', 1, 'きのこと塩糀を混ぜておくと水分が出ますが、きのこの旨みが出ているので汁ごと使いましょう。\r\n豆乳は、無調整豆乳でも可ですが、調整豆乳のほうが、きのことの相性がよく、コクが出ます。', 1, '2021-06-27 18:51:46', '2021-06-27 18:51:46'),
(2, 'ベーコンは１ｃｍの厚さに切り、オリーブ油を入れた鍋でベーコンを炒める。火が通ったらきのこ類も全部加えて炒める。', 2, NULL, 1, '2021-06-27 18:51:46', '2021-06-27 18:52:38'),
(3, '調整豆乳を入れ、ブイヨンを入れる。沸騰しない程度に温める。', 3, NULL, 1, '2021-06-27 18:52:29', '2021-06-27 18:52:29');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `processes`
--
ALTER TABLE `processes`
  ADD PRIMARY KEY (`process_id`);

--
-- ダンプしたテーブルのAUTO_INCREMENT
--

--
-- テーブルのAUTO_INCREMENT `processes`
--
ALTER TABLE `processes`
  MODIFY `process_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
