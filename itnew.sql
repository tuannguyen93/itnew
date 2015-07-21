-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2015 at 08:06 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `itnew`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
`cat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cat_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `position` tinyint(4) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `user_id`, `cat_name`, `position`) VALUES
(1, 1, 'Äiá»‡n thoáº¡i', 1),
(2, 1, 'Laptop', 2),
(3, 1, 'Há»‡ Ä‘iá»u hÃ nh', 3),
(4, 1, 'Xe mÃ¡y', 4),
(9, 1, 'Äá»“ chÆ¡i cÃ´ng nghá»‡', 5);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
`comment_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `author` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `page_id`, `author`, `email`, `comment`, `comment_date`) VALUES
(5, 4, 'Silver Thunder', 'nhmtuan93@gmail.com', '<p>M&igrave;nh váº«n th&iacute;ch máº¥y con panasonic th&ocirc;i ak</p>', '2015-07-17 04:26:58'),
(6, 14, 'Silver Thunder', 'nhmtuan93@gmail.com', '<p>Hay</p>', '2015-07-19 07:57:43'),
(3, 1, 'Silver Thunder', 'silverstart@gmail.com', 'Chá»‰ thÃ­ch Linux thÃ´i ak.', '2015-07-15 09:33:29'),
(7, 5, 'Silver Thunder', 'nhmtuan93@gmail.com', '<p>Th&iacute;ch</p>', '2015-07-19 08:02:56');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
`page_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `page_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `position` tinyint(4) NOT NULL,
  `post_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`page_id`, `user_id`, `cat_id`, `page_name`, `content`, `position`, `post_on`) VALUES
(1, 1, 1, 'Xuáº¥t hiá»‡n mÃ£ Ä‘á»™c Android giáº£ máº¡o trÃ² chÆ¡i cÃ³ tráº£ tiá»n', '<p>M&atilde; Ä‘á»™c (malware) Ä‘ang tá»«ng bÆ°á»›c thay Ä‘á»•i v&agrave; trá»Ÿ n&ecirc;n tinh vi hÆ¡n. Má»™t ph&aacute;t hiá»‡n má»›i Ä‘&acirc;y cá»§a c&aacute;c chuy&ecirc;n gia an ninh cho tháº¥y, ch&uacute;ng Ä‘&atilde; len lá»i v&agrave;o trong nhiá»u á»©ng dá»¥ng game tráº£ ph&iacute; tr&ecirc;n di Ä‘á»™ng. Haizz</p>', 1, '2015-07-19 10:01:30'),
(2, 1, 1, '3 smartphone Android táº§m trung Ä‘Ã¡ng mua hiá»‡n nay', 'Má»©c giÃ¡ 5-6 triá»‡u Ä‘á»“ng Ä‘ang lÃ  phÃ¢n khÃºc cáº¡nh tranh sÃ´i Ä‘á»™ng vÃ  cÃ³ nhiá»u lá»±a chá»n nháº¥t trÃªn thá»‹ trÆ°á»ng smartphone á»Ÿ thá»i Ä‘iá»ƒm hiá»‡n nay. Tuy váº­y á»Ÿ táº§m giÃ¡ nÃ y, cÃ¡c sáº£n pháº©m cao cáº¥p tháº¿ há»‡ cÅ© Ä‘Æ°á»£c giáº£m giÃ¡ láº¡i Ä‘ang chiáº¿m Æ°u tháº¿ nhá» sá»Ÿ há»¯u cáº¥u hÃ¬nh tá»‘t cÅ©ng nhÆ° thiáº¿t káº¿ cháº¥t lÆ°á»£ng.', 2, '2015-07-14 16:54:03'),
(4, 1, 2, 'HP giá»›i thiá»‡u phiÃªn báº£n giá»›i háº¡n cá»§a Elitebook Folio 1020 mÃ u xÃ¡m Ä‘á»“ng', 'HP cÃ¹ng vá»›i nhÃ  lÃ m Ã¢m thanh ná»•i tiáº¿ng Bang & Olufsen (B&O) vá»«a tung ra phiÃªn báº£n háº¡n cháº¿ cá»§a chiáº¿c mÃ¡y tÃ­nh ráº¥t má»ng vÃ  nháº¹ Elitebook Folio 1020 vá»‘n ra máº¯t cuá»‘i nÄƒm ngoÃ¡i. á»ž phiÃªn báº£n giá»›i háº¡n nÃ y, thiáº¿t káº¿ vÃ  cáº¥u hÃ¬nh cá»§a Folio 1020 gáº§n nhÆ° giá»¯ nguyÃªn, HP vÃ  B&O chá»‰ nÃ¢ng cáº¥p cháº¥t Ã¢m, bÃ n phÃ­m cÃ´ng nghá»‡ má»›i vÃ  giá»›i thiá»‡u mÃ u má»›i dÃ nh cho chiáº¿c mÃ¡y tÃ­nh.\r\n\r\nVá»›i trá»ng lÆ°á»£ng 1kg vÃ  dÃ y 1,5cm thÃ¬ Folio 1020 Ä‘Ã£ chiáº¿n tháº¯ng MacBook Air cá»§a Apple vá» Ä‘á»™ má»ng vÃ  náº·ng, bÃ¢y giá» thÃ¬ nÃ³ sáº½ Ä‘áº¹p hÆ¡n vá»›i mÃ u sáº¯c má»›i. HP cÃ¹ng vá»›i B&O mang cho mÃ¡y tÃ­nh phiÃªn báº£n giá»›i háº¡n vá» sá»‘ lÆ°á»£ng nÃ y gam mÃ u tá»‘i vá»›i hai tÃ´ng mÃ u mÃ  há» gá»i lÃ  báº¡c tÃ n thuá»‘c vÃ  Ä‘á»“ng. ToÃ n bá»™ thÃ¢n mÃ¡y sáº½ cÃ³ mÃ u xÃ¡m Ä‘en trong khi má»™t sá»‘ chi tiáº¿t khÃ¡c sáº½ Ä‘Æ°á»£c trang trÃ­ vá»›i tÃ´ng mÃ u Ä‘á»“ng hay cÃ³ thá»ƒ gá»i lÃ  mÃ u vÃ ng há»“ng nhÆ° báº£n lá», logo HP, bÃ n phÃ­m hay bÃ n rÃª. Viá»n bÃ n rÃª vÃ  cÃ¡c phÃ­m sá»‘, chá»¯ trÃªn bÃ n phÃ­m cÃ³ mÃ u vÃ ng há»“ng ráº¥t ná»•i báº­t so vá»›i ná»n Ä‘en xÃ¡m cá»§a mÃ¡y.\r\n\r\nNgoÃ i mÃ u má»›i, báº£n giá»›i háº¡n cá»§a Elitebook Folio 1020 cÃ²n cÃ³ loa ngoÃ i cao cáº¥p Ä‘Æ°á»£c B&O há»©a háº¹n cho cháº¥t Ã¢m tinh táº¿. BÃ n phÃ­m cá»§a mÃ¡y Ä‘Æ°á»£c á»©ng dá»¥ng cÃ´ng nghá»‡ HP Premium Keyboard cho cáº£m giÃ¡c báº¥m tá»‘t hÆ¡n. Elitebook Folio 1020 sáº½ cÃ³ mÃ n hÃ¬nh 12"5 vá»›i Ä‘á»™ phÃ¢n giáº£i QHD (2560 x 1440 Ä‘iá»ƒm áº£nh), webcam HD. MÃ¡y cÅ©ng cÃ³ cÃ´ng nghá»‡ Client Security vÃ  BIOSphere cá»§a HP, káº¿t há»£p vá»›i cáº£m biáº¿n vÃ¢n tay Ä‘á»ƒ báº£o vá»‡ dá»¯ liá»‡u cá»§a mÃ¡y vÃ  ngÆ°á»i dÃ¹ng má»™t cÃ¡ch an toÃ n. Hiá»‡n HP chÆ°a cÃ´ng bá»‘ giÃ¡ bÃ¡n chÃ­nh thá»©c nhÆ°ng cho biáº¿t phiÃªn báº£n giá»›i háº¡n nÃ y sáº½ bÃ¡n ra vÃ o mÃ¹a thu nÄƒm nay.', 1, '2015-07-15 00:44:54'),
(5, 1, 4, 'Tá»± thay nhá»›t vÃ  lá»c nhá»›t Suzuki Raider R150', 'Xin chia sáº» anh em má»™t sá»‘ hÃ¬nh áº£nh mÃ¬nh Ä‘Ã£ tá»± thay nhá»›t vÃ  lá»c nhá»›t Raider. VÃ´ cÃ¹ng dá»… lÃ m.\r\nTheo khuyáº¿n cÃ¡o cá»§a NhÃ  sáº£n xuáº¥t Suzuki thÃ¬ trong 1000km Ä‘áº§u tiÃªn, Raider cáº§n pháº£i Ä‘Æ°á»£c thay nhá»›t vÃ  lá»c nhá»›t. Thá»i gian sau thÃ¬ sau 2000 - 3000km thay nhá»›t; 6000km thay lá»c nhá»›t. NhÆ° váº­y lÃ  sau 2 hoáº·c 3 láº§n thay nhá»›t thÃ¬ thay lá»c nhá»›t.\r\nNáº¿u cÃ³ Ä‘iá»u kiá»‡n thÃ¬ sá»­ dá»¥ng loáº¡i nhá»›t tá»‘t hÆ¡n. NhÆ°ng theo mÃ¬nh nhá»›t Castrol Power 1 15W-40 (API SL, JASO MA2) hoáº·c cÃ¡c loáº¡i khÃ¡c tÆ°Æ¡ng Ä‘Æ°Æ¡ng lÃ  quÃ¡ Ä‘á»§. Chá»‰ 90.000 Ä‘á»“ng cho chai 1lÃ­t vÃ  80.000 Ä‘á»“ng cho chai 800ml. Chai 800ml Ä‘á»ƒ dÃ¹ng dáº§n sau nÃ y khi cáº§n bÃ¹ thÃªm nhá»›t cho má»—i láº§n thay cáº£ nhá»›t vÃ  lá»c nhá»›t.\r\nMá»™t háº¡n cháº¿ lÃ  cÃ¡i khÃ³a vÃ²ng vÃ  T8 loáº¡i tá»‘t hÆ¡i Ä‘áº¯t, khoáº£ng máº¥y trÄƒm nghÃ¬n Ä‘á»“ng má»™t cÃ¡i. CÃ²n cÃ¡c loáº¡i ráº» dÃ¹ng vÃ i láº§n lÃ  há»ng, hÆ¡n ná»¯a láº¡i lÃ m há»ng á»‘c cá»§a xe.\r\nTá»± thay nhá»›t vÃ  lá»c nhá»›t bao giá» cÅ©ng cáº©n tháº­n hÆ¡n thá»£ lÃ m. ÄÆ¡n giáº£n vÃ¬ cháº³ng ai yÃªu xe báº±ng chá»§ xe :)\r\nChÃºc anh em thÃ nh cÃ´ng!', 1, '2015-07-15 00:44:12'),
(6, 1, 9, 'ÄÃ¡nh giÃ¡ nhanh tai nghe Jabra Move Wireless ', 'ÄÃ¡nh giÃ¡ nhanh tai nghe Jabra Move Wireless ', 5, '2015-07-15 06:10:31'),
(7, 2, 1, 'áº¢nh chá»¥p tá»« Bphone dÆ°á»›i tay mÃ¡y cá»§a mod diá»…n Ä‘Ã n Tinh Táº¿ ', 'áº¢nh chá»¥p tá»« Bphone dÆ°á»›i tay mÃ¡y cá»§a mod diá»…n Ä‘Ã n Tinh Táº¿ ', 6, '2015-07-15 06:14:05'),
(8, 1, 1, 'Bphone láº¥n lÆ°á»›t Sony Xperia Z4 trong thá»­ nghiá»‡m hiá»‡u nÄƒng ', 'Bphone láº¥n lÆ°á»›t Sony Xperia Z4 trong thá»­ nghiá»‡m hiá»‡u nÄƒng ', 7, '2015-07-15 06:43:48'),
(9, 1, 1, ' HÆ°á»›ng dáº«n jailbreak iOS 8.4', ' HÆ°á»›ng dáº«n jailbreak iOS 8.4', 8, '2015-07-15 06:47:34'),
(10, 1, 1, ' CÃ¡ch cÃ i Windows 10 lÃªn Asus ZenFone 2', ' CÃ¡ch cÃ i Windows 10 lÃªn Asus ZenFone 2', 9, '2015-07-15 06:48:40'),
(11, 1, 1, 'ÄÃ¡nh giÃ¡ laptop chuyÃªn game Lenovo Y70 Touch ', 'ÄÃ¡nh giÃ¡ laptop chuyÃªn game Lenovo Y70 Touch ', 9, '2015-07-15 06:49:12'),
(12, 1, 1, 'ÄÃ¡nh giÃ¡ nhanh laptop Samsung Ativ Book 9 2014 ', 'ÄÃ¡nh giÃ¡ nhanh laptop Samsung Ativ Book 9 2014 ', 9, '2015-07-15 06:49:26'),
(13, 1, 1, 'ÄÃ¡nh giÃ¡ laptop Toshiba Satellite P50T ', 'ÄÃ¡nh giÃ¡ laptop Toshiba Satellite P50T ', 9, '2015-07-15 06:49:45'),
(14, 1, 3, 'Tá»•ng há»£p cÃ¡c hÆ°á»›ng dáº«n cÃ i Ä‘áº·t pháº§n má»m phá»• biáº¿n trÃªn Linux / Ubuntu', '1. CÃ¡ch cÃ i Ä‘áº·t bá»™ gÃµ tiáº¿ng Viá»‡t:\r\nIBus â€“ Unikey:\r\n- dÃ¹ng lá»‡nh: sudo apt-get install ibus-unikey\r\n- kÃ­ch hoáº¡t bá»™ gÃµ: im-switch -s ibus\r\n- hoáº·c: VÃ o trÃ¬nh Ä‘Æ¡n System â†’ Administration â†’ Language Support , á»ž pháº§n Keyboard input method system (Há»‡ thá»‘ng phÆ°Æ¡ng thá»©c nháº­p) chá»n ibus.\r\nIbus-Bogo\r\n- wget -O - http://bogoengine.github.com/debian/stable/installer.sh | sudo sh\r\n- Tham kháº£o: http://ibus-bogo.readthedocs.org/en...ai-dat-cho-cac-ban-phan-phoi-linux-thong-dung\r\nhttps://github.com/BoGoEngine/ibus-bogo-python/blob/master/doc/sphinx/install.rst\r\n\r\n2. CÃ i Ä‘áº·t graphic driver: sudo apt-get install mesa-utils:\r\n- Hoáº·c (sá»­a lá»—i chá»¥p mÃ n hÃ¬nh bá»‹ Ä‘en):\r\n- sudo add-apt-repository ppa:xorg-edgers/ppa\r\n- sudo apt-get update && sudo apt-get upgrade\r\n- VÃ o System setting vÃ  Install update\r\n\r\n3. Sá»­a lá»—i khÃ´ng hiá»ƒn thá»‹ há»™p thoáº¡i khi áº¥n printscreen trÃªn LinuxMint:\r\n- VÃ o SystemSeting â†’ Keyboard â†’ Keyboard shortcuts â†’ Custom shortcuts â†’ ThÃªm Keyboard shortcuts vá»›i thÃ´ng sá»‘ sau:\r\n- Name: Screenshot\r\n- Command: gnome-screenshot â€“interactive\r\n- LÆ°u láº¡i vÃ  chá»¥p thá»­ :D\r\n\r\n4. CÃ i Flash cho trÃ¬nh duyá»‡t:\r\n- sudo apt-get install flashplugin-installer\r\n\r\n5. CÃ i Ä‘áº·t ubuntu-tweak:\r\n- sudo add-apt-repository ppa:tualatrix/ppa\r\n- sudo apt-get update && sudo apt-get install ubuntu-tweak\r\n\r\n6. Má»Ÿ thÆ° má»¥c cÃ³ thá»ƒ copy vÃ  xÃ³a nhÆ° windows: gksudo nautilus\r\n\r\n7. Sá»­a lá»—i khÃ´ng giáº£m Ä‘á»™ sÃ¡ng mÃ n hÃ¬nh Ä‘Æ°á»£c:\r\n- Run this command: gksu gedit /etc/default/grub\r\n- Change the line GRUB_CMDLINE_LINUX="" into GRUB_CMDLINE_LINUX="acpi_osi=Linux".\r\n- Save the file and quit the text editor.\r\n- Then run: sudo update-grub\r\n- Restart.\r\n\r\n', 1, '2015-07-15 16:02:23'),
(15, 1, 1, 'Má»‡t quÃ¡', 'Má»‡t quÃ¡', 1, '2015-07-20 11:55:16');

-- --------------------------------------------------------

--
-- Table structure for table `page_views`
--

CREATE TABLE IF NOT EXISTS `page_views` (
`view_id` int(6) NOT NULL,
  `page_id` int(6) NOT NULL,
  `num_views` int(9) NOT NULL,
  `user_ip` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `page_views`
--

INSERT INTO `page_views` (`view_id`, `page_id`, `num_views`, `user_ip`) VALUES
(1, 5, 1, '::1'),
(2, 4, 1, '::1'),
(3, 1, 23, '::2'),
(4, 14, 1, '::1'),
(5, 2, 1, '::1'),
(6, 11, 1, '::1'),
(7, 10, 1, '::1'),
(8, 13, 1, '::1'),
(9, 15, 1, '::1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`user_id` int(11) NOT NULL,
  `first_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `question_security` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8_unicode_ci,
  `avatar` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_level` tinyint(4) NOT NULL DEFAULT '2',
  `active` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `pass`, `question_security`, `website`, `facebook`, `bio`, `avatar`, `user_level`, `active`, `registration_date`) VALUES
(1, 'Silver', 'Thunder', 'nhmtuan93@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '', 'yaourt', 'face/yaourt', '<p>Sá»‘ng láº·ng tháº§m, th&iacute;ch tá»± ká»·</p>', '742055a8a22b334115.77809866.png', 1, NULL, '2015-07-19 10:29:05'),
(9, 'Nguyen Ngoc', 'Khanh Minh', 'khanhminh1@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '8d813378c294d9c43ea7cbe34e05c65cfa43b630', NULL, NULL, NULL, NULL, 2, NULL, '2015-07-19 10:28:01'),
(10, 'Nguyá»…n Ngá»c', 'KhÃ¡nh Nhi', 'khanhnhi@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '8d813378c294d9c43ea7cbe34e05c65cfa43b630', 'yaourt', 'face/yaourt', '<p>Con cá»§a 2Yaourt</p>', '319255ab61b4334b91.95339322.png', 2, NULL, '2015-07-19 10:27:52'),
(11, 'Nguyá»…n Ngá»c', 'KhÃ¡nh Minh', 'nhmtuan931@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, NULL, NULL, 2, NULL, '2015-07-19 10:27:55'),
(12, 'Nguyá»…n HoÃ ng', 'Minh Khang', 'khangnguyen@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '8d813378c294d9c43ea7cbe34e05c65cfa43b630', NULL, NULL, NULL, NULL, 2, NULL, '2015-07-19 10:27:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
 ADD PRIMARY KEY (`comment_id`), ADD KEY `page_id` (`page_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
 ADD PRIMARY KEY (`page_id`), ADD KEY `user_id` (`user_id`,`cat_id`,`position`,`post_on`);

--
-- Indexes for table `page_views`
--
ALTER TABLE `page_views`
 ADD PRIMARY KEY (`view_id`), ADD KEY `page_id` (`page_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`), ADD UNIQUE KEY `email` (`email`), ADD KEY `first_name` (`first_name`,`last_name`,`pass`,`registration_date`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `page_views`
--
ALTER TABLE `page_views`
MODIFY `view_id` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
