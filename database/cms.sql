-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2018 at 07:39 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `publish_time` date DEFAULT NULL,
  `creation_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `thumbnail_url` varchar(255) NOT NULL,
  `share_url` varchar(255) NOT NULL,
  `category_orginal` int(11) DEFAULT NULL,
  `catelist` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `ordering` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `title`, `description`, `content`, `publish_time`, `creation_time`, `update_time`, `thumbnail_url`, `share_url`, `category_orginal`, `catelist`, `status`, `ordering`) VALUES
(1000013, 'Post1', 'This is a description Post1', '<p><u><em><strong>This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.</strong></em></u></p>\r\n', '2018-06-20', '2018-06-08 02:06:28', '2018-06-08 10:06:03', 'fxm5sr0q.jpg', '/the-thao/post1-1000013.html', 10, NULL, 1, 1),
(1000014, 'Post2', 'This is a descripton Post2', '<p><u><strong><span style="color:#c0392b">This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.</span></strong></u></p>\r\n', '2018-06-20', '2018-06-08 02:06:51', '2018-06-08 10:06:10', '', '', 12, NULL, 0, 2),
(1000018, 'Post3', 'This is a description Post3', '<p><span style="color:#e74c3c"><u><em><strong>This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.This is a content.</strong></em></u></span></p>\r\n', '2018-06-30', '2018-06-08 10:06:32', '2018-06-08 10:06:57', 'dymuxwo0.jpg', '', 11, NULL, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created` date NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `modified` date NOT NULL,
  `modified_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `name`, `status`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 'Bộ nhớ', 1, '2018-06-07', 'admin', '0000-00-00', ''),
(2, 'RAM', 1, '2018-06-07', 'admin', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `creation_time` datetime NOT NULL,
  `modified_time` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `ordering` int(11) NOT NULL,
  `share_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `name`, `creation_time`, `modified_time`, `status`, `ordering`, `share_url`, `avatar`) VALUES
(1, 'Tom', '2018-06-01 00:00:00', '2018-06-06 11:06:30', 1, 1, '', 'yzwhd8mt.jpg'),
(2, 'John', '2018-06-01 00:00:00', '2018-06-06 11:06:03', 1, 2, '', 'hlzaoks3.jpg'),
(3, 'Bob', '2018-06-01 00:00:00', '2018-06-06 11:06:05', 1, 3, '', ''),
(4, 'Adam', '2018-06-01 00:00:00', '2018-06-06 11:06:01', 1, 3, '', ''),
(6, 'Tom', '2018-06-01 00:00:00', '2018-06-06 11:06:01', 1, 4, '', ''),
(5, 'Maria', '2018-06-01 00:00:00', '2018-06-06 11:06:01', 1, 5, '', ''),
(7, 'John', '2018-06-01 00:00:00', '2018-06-06 11:06:01', 1, 6, '', ''),
(8, 'Bob', '2018-06-01 00:00:00', '2018-06-06 11:06:01', 1, 7, '', ''),
(9, 'Adam', '2018-06-01 00:00:00', '2018-06-06 11:06:01', 1, 8, '', ''),
(11, 'Tommy', '2018-06-06 11:06:44', '2018-06-06 12:06:11', 1, 10, '', 'n31cw097.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `category_article`
--

CREATE TABLE `category_article` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `catecode` varchar(255) NOT NULL,
  `show_on_fe` tinyint(4) NOT NULL,
  `show_on_footer` tinyint(4) NOT NULL,
  `position` int(11) NOT NULL,
  `position_footer` int(11) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `created_by` varchar(45) NOT NULL,
  `modified_by` varchar(45) NOT NULL,
  `created_at` date NOT NULL,
  `modified_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category_article`
--

INSERT INTO `category_article` (`id`, `name`, `status`, `catecode`, `show_on_fe`, `show_on_footer`, `position`, `position_footer`, `meta_title`, `meta_description`, `created_by`, `modified_by`, `created_at`, `modified_at`) VALUES
(10, 'Thể thao', 1, 'the-thao', 1, 1, 1, 1, 'Meta-title', 'Meta-description', 'admin', 'admin', '2018-06-08', '2018-06-08'),
(11, 'Khuyến mãi', 1, 'khuyen-mai', 1, 1, 1, 1, 'Meta-Title', 'Meta-Description', 'admin', 'admin', '2018-06-08', '2018-06-08'),
(12, 'Tin tức12345', 1, 'tin-tuc12345', 1, 1, 1, 1, 'Tin tức', 'Tin tức Tin tức', 'admin', 'admin', '2018-06-08', '2018-06-08');

-- --------------------------------------------------------

--
-- Table structure for table `category_product`
--

CREATE TABLE `category_product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `catecode` varchar(255) NOT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `modified_at` date NOT NULL,
  `modified_by` varchar(255) NOT NULL,
  `show_on_fe` tinyint(4) NOT NULL,
  `show_on_footer` tinyint(4) NOT NULL,
  `position` int(11) NOT NULL,
  `position_footer` int(11) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category_product`
--

INSERT INTO `category_product` (`id`, `name`, `catecode`, `lft`, `rgt`, `parent`, `level`, `status`, `created_at`, `created_by`, `modified_at`, `modified_by`, `show_on_fe`, `show_on_footer`, `position`, `position_footer`, `meta_title`, `meta_description`) VALUES
(27, 'Chuyên ngành', 'chuyen-nganh', 0, 6, 0, 1, 1, '2018-06-08', 'admin', '2018-06-08', 'admin', 1, 1, 1, 1, 'Sách chuyên ngành', 'Sách chuyên ngành'),
(28, 'Kinh tế', 'kinh-te', 3, 4, 27, 2, 1, '2018-06-08', 'admin', '0000-00-00', '', 1, 1, 1, 1, 'Kinh tế', 'Kinh tế'),
(29, 'Công nghệ', 'cong-nghe', 1, 2, 27, 2, 1, '2018-06-08', 'admin', '0000-00-00', '', 1, 1, 1, 1, 'Công nghệ', 'Công nghệ'),
(30, 'Tạp chí', 'tap-chi', 5, 6, 0, 1, 1, '2018-06-08', 'admin', '0000-00-00', '', 1, 1, 1, 1, 'Tạp chí', 'Tạp chí');

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE `group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `group_acp` tinyint(1) DEFAULT '0',
  `created` date DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `modified` date DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `ordering` int(11) DEFAULT '10',
  `privilege_id` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id`, `name`, `group_acp`, `created`, `created_by`, `modified`, `modified_by`, `status`, `ordering`, `privilege_id`) VALUES
(1, 'Admin', 1, '2013-11-11', 'admin', '2018-06-06', 'admin', 1, 1, ''),
(2, 'Manager', 0, '2013-11-07', 'admin', '2018-06-06', 'admin', 1, 2, ''),
(10, 'Member', 0, '2018-06-01', 'admin', '2018-06-06', 'admin', 1, 3, '');

-- --------------------------------------------------------

--
-- Table structure for table `keyword_product`
--

CREATE TABLE `keyword_product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `created` date NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `modified` date NOT NULL,
  `modified_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `keyword_product`
--

INSERT INTO `keyword_product` (`id`, `name`, `status`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(3, 'sale', 1, '2018-06-08', 'admin', '0000-00-00', ''),
(4, 'sale123', 1, '2018-06-08', 'admin', '0000-00-00', ''),
(5, 'sale-all', 1, '2018-06-08', 'admin', '0000-00-00', ''),
(6, 'sale456', 1, '2018-06-08', 'admin', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `object_article`
--

CREATE TABLE `object_article` (
  `id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `object_type` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `creation_time` datetime NOT NULL,
  `modified_time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `object_product`
--

CREATE TABLE `object_product` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `object_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `object_type` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `creation_time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `object_product`
--

INSERT INTO `object_product` (`id`, `product_id`, `object_id`, `object_value`, `object_type`, `status`, `creation_time`) VALUES
(46, 1000002, 2, '4GB', 2, 1, '2018-06-08 22:06:07'),
(45, 1000002, 1, '64GB', 2, 1, '2018-06-08 22:06:07'),
(44, 1000002, 4, '', 1, 1, '2018-06-08 22:06:07'),
(43, 1000002, 3, '', 1, 1, '2018-06-08 22:06:07');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `note` text NOT NULL,
  `total` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `name`, `email`, `phone`, `address`, `note`, `total`, `status`, `created_at`) VALUES
(1, 'Nguyễn Võ Hoàng Duy', 'nguyenvohoangduy@gmail.com', '01267583308', '99/14 Đường Số 1, Phường 13, Quận Gò Vấp, TP Hồ Chí Minh', 'Giao buổi chiều', 10000000, 1, '2018-06-07');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`order_id`, `product_id`, `price`, `quantity`) VALUES
(1, 6, 100000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `privilege`
--

CREATE TABLE `privilege` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `module` varchar(45) NOT NULL,
  `controller` varchar(45) NOT NULL,
  `action` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `privilege`
--

INSERT INTO `privilege` (`id`, `name`, `module`, `controller`, `action`) VALUES
(1, 'Hiển thị danh sách người dùng', 'admin', 'user', 'index'),
(2, 'Thay đổi status của người dùng', 'admin', 'user', 'status'),
(3, 'Cập nhật thông tin của người dùng', 'admin', 'user', 'form'),
(4, 'Thay đổi status của người dùng sử dụng Ajax', 'admin', 'user', 'ajaxStatus'),
(5, 'Xóa một hoặc nhiều người dùng', 'admin', 'user', 'trash'),
(6, 'Thay đổi vị trí hiển thị của các người dùng', 'admin', 'user', 'ordering'),
(7, 'Truy cập menu Admin Control Panel', 'admin', 'index', 'index'),
(8, 'Đăng nhập Admin Control Panel', 'admin', 'index', 'login'),
(9, 'Đăng xuất Admin Control Panel', 'admin', 'index', 'logout'),
(10, 'Cập nhật thông tin tài khoản quản trị', 'admin', 'index', 'profile'),
(11, 'Hiển thị danh sách nhóm người dùng', 'admin', 'group', 'index'),
(12, 'Thay đổi status của nhóm người dùng', 'admin', 'group', 'status'),
(13, 'Cập nhật thông tin của nhóm người dùng', 'admin', 'group', 'form'),
(14, 'Thay đổi status của nhóm người dùng sử dụng Ajax', 'admin', 'group', 'ajaxStatus'),
(15, 'Xóa một hoặc nhiều nhóm  người dùng', 'admin', 'group', 'trash'),
(16, 'Thay đổi vị trí hiển thị của cácnhóm  người dùng', 'admin', 'group', 'ordering'),
(17, 'Thay đổi groupACP của nhóm người dùng sử dụng Ajax', 'admin', 'group', 'ajaxACP');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_show` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `discount_price` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` date NOT NULL,
  `modified_at` date NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `modified_by` varchar(255) NOT NULL,
  `category_product_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `ordering` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `name_show`, `price`, `discount_price`, `description`, `content`, `created_at`, `modified_at`, `created_by`, `modified_by`, `category_product_id`, `image`, `status`, `ordering`) VALUES
(1000002, 'Kinh tế Vĩ Mô', '', 150000, 10, '', '', '2018-06-08', '0000-00-00', 'admin', '', 28, 'rngu5t79.JPG', 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created` date NOT NULL,
  `created_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `modified` date NOT NULL,
  `modified_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`id`, `name`, `status`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1000007, 'jquery', 1, '2018-06-06', 'admin', '2018-06-06', 'admin'),
(1000005, 'javascript', 1, '2018-06-06', 'admin', '2018-06-06', 'admin'),
(1000006, 'java-core', 1, '2018-06-06', 'admin', '2018-06-06', 'admin'),
(1000004, 'java', 1, '2018-06-06', 'admin', '2018-06-06', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created` date DEFAULT '0000-00-00',
  `created_by` varchar(45) DEFAULT NULL,
  `modified` date DEFAULT '0000-00-00',
  `modified_by` varchar(45) DEFAULT NULL,
  `register_date` datetime DEFAULT '0000-00-00 00:00:00',
  `register_ip` varchar(25) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `ordering` int(11) DEFAULT '10',
  `group_id` int(11) NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `fullname`, `password`, `created`, `created_by`, `modified`, `modified_by`, `register_date`, `register_ip`, `status`, `ordering`, `group_id`, `avatar`) VALUES
(4, 'admin', 'admin@gmail.com', 'Admin', 'e10adc3949ba59abbe56e057f20f883e', '2018-03-20', 'admin', '2018-06-06', 'admin', '2018-06-06 10:06:00', NULL, 1, 1, 1, '2a4yputk.jpg'),
(13, 'user1', 'user1@gmail.com', 'user1', 'e10adc3949ba59abbe56e057f20f883e', '2018-04-12', 'admin', '2018-06-06', 'admin', '2018-06-06 09:04:00', '::1', 1, 2, 2, 'gvtrkx4w.jpg'),
(17, 'user2', 'user2@gmail.com', 'user2', 'e10adc3949ba59abbe56e057f20f883e', '2018-05-30', 'admin', '2018-06-06', 'admin', '2018-06-03 11:32:00', NULL, 1, 3, 2, 'uq0y1jzn.jpg'),
(23, 'user3', 'user3@gmail.com', 'user3', 'e10adc3949ba59abbe56e057f20f883e', '2018-06-01', 'admin', '2018-06-06', 'admin', '2018-06-03 11:32:00', NULL, 1, 4, 10, 'wij074xh.jpg'),
(24, 'user4', 'user4@gmail.com', 'user4', 'e10adc3949ba59abbe56e057f20f883e', '2018-06-01', 'admin', '2018-06-06', 'admin', '2018-06-03 11:32:00', NULL, 0, 5, 10, 'dluv4c3m.jpg'),
(25, 'user5', 'user5@gmail.com', 'user5', 'e10adc3949ba59abbe56e057f20f883e', '2018-06-01', 'admin', '2018-06-06', 'admin', '2018-06-03 11:32:00', NULL, 1, 6, 10, '5eujsb9r.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_article`
--
ALTER TABLE `category_article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_product`
--
ALTER TABLE `category_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keyword_product`
--
ALTER TABLE `keyword_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `object_article`
--
ALTER TABLE `object_article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `object_product`
--
ALTER TABLE `object_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`order_id`,`product_id`);

--
-- Indexes for table `privilege`
--
ALTER TABLE `privilege`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000019;
--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `category_article`
--
ALTER TABLE `category_article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `category_product`
--
ALTER TABLE `category_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `group`
--
ALTER TABLE `group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `keyword_product`
--
ALTER TABLE `keyword_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `object_article`
--
ALTER TABLE `object_article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000274;
--
-- AUTO_INCREMENT for table `object_product`
--
ALTER TABLE `object_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `privilege`
--
ALTER TABLE `privilege`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000003;
--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000009;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
