-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2019 at 08:12 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `patwary_business_house`
--

--
-- Dumping data for table `business_type`
--

INSERT INTO `business_type` (`id`, `institute_id`, `business_type`, `prefix`, `created_at`, `created_by`, `modified_at`, `_key`) VALUES
(1, 1, 'Inventory', 'inv', '2018-12-17 03:36:02', 2, '2019-01-05 01:10:39', 'sdfsadfsdfsd'),
(2, 1, 'Flour Mill', 'flour', '2018-12-17 03:36:02', 2, '2019-01-05 01:10:49', 'sdfsadfasdfasdfsda'),
(3, 1, 'Woven Factory', 'inv', '2018-12-17 03:36:46', 2, '2019-01-05 03:27:12', 'sdfsdafsafsadfsafsadfdsa'),
(4, 1, 'Rice Mill', 'rice', '2018-12-17 03:38:39', 2, '2019-01-05 03:16:16', ',jhfsdafsdf'),
(5, 1, 'Dal Mill', 'flour', '2018-12-17 03:59:25', 2, '2019-01-05 03:16:35', 'uiuiiusdf'),
(6, 1, 'Oil Mill', 'flour', '2018-12-17 03:59:25', 2, '2019-01-05 03:16:38', 'detsdfsdfsdf'),
(7, 1, 'Import Export', 'packaging', '2018-12-17 03:59:25', 2, '2019-01-05 03:27:20', 'bythgflkjjjsdsd'),
(8, 1, 'Chira Muri Mill', 'rice', '2018-12-17 03:59:25', 2, '2019-01-05 03:16:43', 'sdfsdgsfssghrg'),
(9, 1, 'Fertilizer', 'inv', '2018-12-17 04:03:16', 2, '2019-01-05 03:16:48', 'dgdghtr6fdhdfg'),
(10, 1, 'Transport', 'transport', '2018-12-17 04:04:40', 2, '2019-01-07 09:26:45', 'hgdfghgfr6445bfgbfsg'),
(11, 1, 'Packaging', 'packaging', '2018-12-17 04:05:30', 2, '2019-01-05 03:27:35', 'fgkjksgdfjkaeg2fdgd'),
(12, 1, 'Building Rent', 'rental', '2018-12-17 04:09:09', 2, '2019-01-07 09:26:39', 'jdhshktyyheter');

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `institute_id`, `title`, `owner`, `logo`, `favicon`, `address`, `description`, `email`, `mobile`, `other_contact`, `phone`, `pagesize`, `copyright`, `created_at`, `created_by`, `modified_at`, `modified_by`, `_key`) VALUES
(1, 1, 'Patwary Business House', 'Legend IT Solution', NULL, 'fav.jpg', 'Pulhat, Dinajpur', 'Patwary Business House', 'mrhsajib.cse@gmail.com', '01719206144', '01568555554', '01719206144', 20, 'Copyright © 2018 Protected. All Rights Reserved, Legend IT', '2017-07-28 09:44:38', 2, '2018-12-17 08:26:03', 2, 'dc02ew21a0ya639kq912qx2tglf0si96'),
(14, 12, 'Ador Momota', NULL, NULL, NULL, 'DC More, Rangpur , Bangladesh', NULL, 'mrhsajib.cse@gmail.com', '01719206144', NULL, '01719206144', NULL, 'Copyright © 2018 Protected. All Rights Reserved', '2018-02-06 11:41:44', 2, '2018-12-19 06:49:37', 31, '9cb8c4c1ee36d837222cf08db4866ad9'),
(15, 13, 'NN Bricks 2', NULL, NULL, NULL, 'DC More, Rangpur , Bangladesh', NULL, 'nn2@gmail.com', '01719206144', NULL, '01719206144', 10, 'Copyright © 2018 Protected. All Rights Reserved, NN Bricks 2', '2018-02-06 11:43:21', 2, '2018-03-11 10:00:46', 32, 'e0545395b889c4f952f4163a51238f80'),
(16, 14, 'SRP Auto Fllor Mill', NULL, NULL, NULL, 'Pulhat, Dinajpur , Bangladesh', NULL, 'srp@gmail.com', '01719206144', NULL, '01737112739', NULL, 'Copyright © 2018 Protected. All Rights Reserved,SRP Auto Fllor Mill', '2018-12-17 08:35:37', 2, NULL, NULL, '37c87cdc00d6f68f5abf9e0abaa8de89'),
(17, 15, 'RBF Oven Factory', NULL, NULL, NULL, 'Pulhat, Dinajpur , Bangladesh', NULL, 'rbf@gmail.com', '1719206144', NULL, '1719206144', NULL, 'Copyright © 2018 Protected. All Rights Reserved,RBF Oven Factory', '2018-12-17 08:36:12', 2, NULL, NULL, '9687036059e7a389ef28cae5ccd02497'),
(18, 16, 'Manik Oil Mill', NULL, NULL, NULL, 'Pulhat, Dinajpur , Bangladesh', NULL, 'manik@gmail.com', '54555564656', NULL, '0171654554', NULL, 'Copyright © 2018 Protected. All Rights Reserved,Manik Oil Mill', '2018-12-17 08:36:57', 2, NULL, NULL, '75a6c71bb16769f3b577a11f326c808c'),
(19, 17, 'Manik Dall Mill', NULL, NULL, NULL, 'Pulhat, Dinajpur , Bangladesh', NULL, 'manikdal@gmail.com', '017545556455', NULL, '545545554', NULL, 'Copyright © 2018 Protected. All Rights Reserved,Manik Dall Mill', '2018-12-17 08:37:33', 2, NULL, NULL, '97f850ca96b9a7e79d80342dcc018735'),
(20, 18, 'Manik Chira Muri Mill', NULL, NULL, NULL, 'Pulhat, Dinajpur , Bangladesh', NULL, 'manikchiramuri@gmail.com', '017545454454', NULL, '52151231213', NULL, 'Copyright © 2018 Protected. All Rights Reserved,Manik Chira Muri Mill', '2018-12-17 08:38:11', 2, NULL, NULL, 'cbdd5470b3512f30454b95c6babbad10'),
(21, 19, 'Rental Manage', NULL, NULL, NULL, 'hgfuytuy', NULL, 'kjhhhk@hjhhj.com', '65464646', NULL, '6546464646', NULL, 'Copyright © 2019 Protected. All Rights Reserved,Rental Manage', '2019-01-07 06:20:01', 2, NULL, NULL, '5cafc6bb8bc6bd5686bdeaab8c096da9');

--
-- Dumping data for table `heads`
--

INSERT INTO `heads` (`id`, `institute_id`, `name`, `code`, `is_deleted`, `is_fixed`, `_key`) VALUES
(17, 13, 'Cash in Hand', 1533630827, 0, 1, '00d86737b9cc9d27cc8ed20783514f6a0'),
(18, 13, 'Cash At Bank', 1533630828, 0, 1, '475b6cbff9708b7e9c2f27f2e21f125b1'),
(19, 13, 'Debtors/ Customer', 1533630829, 0, 1, 'dc066e534a2c92e2723297d85d6289df2'),
(20, 13, 'Creditors/ Supplier', 1533630830, 0, 1, 'bbdfa5d5e09e0a82d1c8c817ba5a45383'),
(21, 13, 'Account Payable', 1533630831, 0, 1, '5dbed9d84e7a39456236ffa9a9874d0a4'),
(22, 13, 'Account Receivable', 1533630832, 0, 1, '99f40a68e2f69db5e8af1ffada0eef735'),
(23, 13, 'Expense', 1533630833, 0, 1, '6382dbcf8593a60e11ec9f6fc818de046'),
(24, 13, 'Capital', 1533630834, 0, 1, 'b7906f566bd3aa083463667b66924bb87'),
(25, 13, 'Purchase', 1533630835, 0, 1, '1c841ff848b67b2017472e01203f3abf8'),
(26, 13, 'Sales', 1533630836, 0, 1, 'c35d2b5ebeb0a297b8b6a97f8acffe009'),
(27, 1, 'Cash Account', 1546667014, 0, 1, 'af212e756041564f130007d60c7f571d0'),
(28, 1, 'Deptorss', 1546667015, 0, 1, 'e857d8c6372b367bc1cd290df4c4ff0a1'),
(29, 1, 'Creditors', 1546667016, 0, 1, '97da12d86eb1fd105e3df736f9551abf2');

--
-- Dumping data for table `institutes`
--

INSERT INTO `institutes` (`id`, `business_type_id`, `type`, `code`, `name`, `address`, `phone`, `mobile`, `email`, `website`, `status`, `is_fixed`, `created_at`, `created_by`, `updated_at`, `updated_by`, `_key`) VALUES
(1, 1, 'admin', NULL, 'Patwary Store', 'Pulhat, Dinajpur', '54856665', '01719206144', 'admin@gmail.com', 'www.legenditsolution.com', 1, 1, '2017-07-28 09:44:38', 26, '2018-12-19 06:29:12', NULL, 'dc02ew21a0ya639kq912qx2tglf0si96'),
(12, 4, 'institute', NULL, 'Ador Momota Rice Mill', 'Pulhat, Dinajpur', '01737112739', '01737112739', 'momota@gmail.com', 'www.adormomota.com', 1, 0, '2018-02-06 11:41:44', 2, '2019-01-05 05:35:32', NULL, '9cb8c4c1ee36d837222cf08db4866ad9'),
(13, 1, 'institute', NULL, 'BM Rice Mill', 'Pulhat, Dinajpur , Bangladesh', '01737112739', '01737112739', 'bm@gmail.com', 'www.bm.com', 1, 0, '2018-02-06 11:43:21', 2, '2018-12-17 09:39:06', NULL, 'e0545395b889c4f952f4163a51238f80'),
(14, 2, 'institute', NULL, 'SRP Auto Flour Mill', 'Pulhat, Dinajpur , Bangladesh', '01737112739', '01719206144', 'srp@gmail.com', 'www.srp.com', 1, 0, '2018-12-17 08:35:37', 26, '2018-12-17 10:35:22', NULL, '37c87cdc00d6f68f5abf9e0abaa8de89'),
(15, 3, 'institute', NULL, 'RBF Oven Factory', 'Pulhat, Dinajpur , Bangladesh', '1719206144', '1719206144', 'rbf@gmail.com', 'www.rbf.com', 1, 0, '2018-12-17 08:36:12', 26, '2018-12-24 08:01:59', NULL, '9687036059e7a389ef28cae5ccd02497'),
(16, 1, 'institute', NULL, 'Manik Oil Mill', 'Pulhat, Dinajpur , Bangladesh', '0171654554', '54555564656', 'manik@gmail.com', 'www.manik.com', 1, 0, '2018-12-17 08:36:57', 2, '2018-12-17 09:39:31', NULL, '75a6c71bb16769f3b577a11f326c808c'),
(17, 2, 'institute', NULL, 'Manik Dall Mill', 'Pulhat, Dinajpur , Bangladesh', '545545554', '017545556455', 'manikdal@gmail.com', 'www.manikdallmill.com', 1, 0, '2018-12-17 08:37:33', 2, '2018-12-17 09:39:39', NULL, '97f850ca96b9a7e79d80342dcc018735'),
(18, 4, 'institute', NULL, 'Manik Chira Muri Mill', 'Pulhat, Dinajpur , Bangladesh', '52151231213', '017545454454', 'manikchiramuri@gmail.com', 'www.manikchiramuri.com', 1, 0, '2018-12-17 08:38:11', 2, '2019-01-05 09:28:30', NULL, 'cbdd5470b3512f30454b95c6babbad10'),
(19, 12, 'institute', NULL, 'Rental Management Software', 'hgfuytuy', '6546464646', '65464646', 'kjhhhk@hjhhj.com', 'hjkhjkh', 1, 0, '2019-01-07 06:20:01', 26, '2019-01-07 09:26:08', NULL, '5cafc6bb8bc6bd5686bdeaab8c096da9');

--
-- Dumping data for table `institute_permissions`
--

INSERT INTO `institute_permissions` (`id`, `institute_id`, `permissions`, `_key`) VALUES
(1, 1, '{\"permission_admin\":\"Admin Setting\",\"setting\":\"Setting\",\"generel_setting\":\"General Setting\",\"generel_setting_update\":\"General Setting Update\",\"manage_user\":\"Manage User\",\"user_access\":\"User Access\",\"user_status\":\"User Status\",\"manage_institute\":\"Manage Institute\",\"institute_access\":\"Institute Access\",\"institute_status\":\"Institute Status\",\"permission_accounts\":\"Accounts Setting\",\"manage_head\":\"Manage Head\",\"manage_subhead\":\"Manage Subhead\",\"manage_particular\":\"Manage Particular\",\"manage_transaction\":\"Manage Transaction\",\"permission_rice\":\"Rice Mill\",\"rice_category\":\"Rice Category\",\"rice_category_delete\":\"Rice Category Delete\",\"rice_product_delete\":\"Rice Product Delete\",\"rice_product\":\"Rice Product\",\"rice_production\":\"Rice Production\",\"rice_stocks\":\"Rice Stocks\",\"rice_purchase_confirm\":\"Purchase Confirm\",\"rice_purchase_edit\":\"Purchase Edit\",\"rice_purchase_delete\":\"Purchase Delete\",\"rice_purchase_list\":\"Purchase List\",\"rice_manage_sales\":\"Manage Sales\",\"rice_sale_create\":\"Sale Create\",\"rice_sale_edit\":\"Sale Edit\",\"rice_sale_confirm\":\"Sale Confirm\",\"rice_sale_delete\":\"Sale Delete\",\"rice_sale_list\":\"Sale List\",\"rice_manage_drawer\":\"Manage Drawer\",\"rice_manage_production\":\"Manage Production\",\"rice_production_order\":\"Production Order\",\"rice_production_order_create\":\"Production Order Create\",\"rice_production_order_edit\":\"Production Order Edit\",\"rice_production_order_delete\":\"Production Order Delete\",\"rice_production_order_confirm\":\"Production Order Confirm\",\"rice_production_stocks\":\"Production Stocks\",\"permission_flour\":\"Flour Mill\",\"flour_category\":\"Flour Category\",\"flour_product\":\"Flour Product\",\"flour_production\":\"Flour Production\",\"flour_stocks\":\"Flour Stocks\",\"permission_rental\":\"Rental Management\",\"rental_building\":\"Rental Building\",\"rental_floor\":\"Rental Floor\",\"rental_flat\":\"Rental Flat\",\"rental_party\":\"Rental Party\",\"permission_chiramill\":\"Chira Mill\",\"chira_category\":\"Chira_Category\",\"chira_product\":\"Chira_Product\",\"chira_production\":\"Chira_Production\",\"chira_stocks\":\"Chira_Stocks\",\"permission_murimill\":\"Muri Mill\",\"muri_category\":\"Muri Category\",\"muri_product\":\"Muri Product\",\"muri_production\":\"Muri Production\",\"muri_stocks\":\"Muri Stocks\",\"permission_inv\":\"Inventory\",\"inv_category\":\"Inv Category\",\"inv_category_delete\":\"Inv Category Delete\",\"inv_product\":\"Inv Product\",\"inv_production\":\"Inv Production\",\"inv_stocks\":\"Inv Stocks\",\"inv_purchase\":\"Inv Purchase\",\"inv_sales\":\"Inv Sales\",\"permission_bag\":\"Bag Production\",\"bag_category\":\"Bag Category\",\"bag_product\":\"Bag Product\",\"bag_production\":\"Bag Production\",\"bag_stocks\":\"Bag Stocks\",\"bag_bag\":\"Bag Bag Type\",\"bag_bag_size\":\"Bag Bag Size\"}', 'dc02ew21a0ya639kq912qx2tglf0si96'),
(12, 12, '{\"permission_admin\":\"Admin Setting\",\"setting\":\"Setting\",\"generel_setting\":\"General Setting\",\"generel_setting_update\":\"General Setting Update\",\"manage_user\":\"Manage User\",\"user_access\":\"User Access\",\"permission_accounts\":\"Accounts Setting\",\"manage_head\":\"Manage Head\",\"manage_subhead\":\"Manage Subhead\",\"manage_particular\":\"Manage Particular\",\"manage_transaction\":\"Manage Transaction\",\"permission_rice\":\"Rice Mill\",\"rice_category\":\"Rice Category\",\"rice_category_delete\":\"Rice Category Delete\",\"rice_product_delete\":\"Rice Product Delete\",\"rice_product\":\"Rice Product\",\"rice_production\":\"Rice Production\",\"rice_stocks\":\"Rice Stocks\",\"rice_purchase_confirm\":\"Purchase Confirm\",\"rice_purchase_edit\":\"Purchase Edit\",\"rice_purchase_delete\":\"Purchase Delete\",\"rice_purchase_list\":\"Purchase List\",\"rice_manage_sales\":\"Manage Sales\",\"rice_sale_create\":\"Sale Create\",\"rice_sale_edit\":\"Sale Edit\",\"rice_sale_confirm\":\"Sale Confirm\",\"rice_sale_delete\":\"Sale Delete\",\"rice_sale_list\":\"Sale List\",\"rice_manage_drawer\":\"Manage Drawer\",\"rice_manage_production\":\"Manage Production\",\"rice_production_order\":\"Production Order\",\"rice_production_order_create\":\"Production Order Create\",\"rice_production_order_edit\":\"Production Order Edit\",\"rice_production_order_delete\":\"Production Order Delete\",\"rice_production_order_confirm\":\"Production Order Confirm\",\"rice_production_stocks\":\"Production Stocks\"}', '9cb8c4c1ee36d837222cf08db4866ad9'),
(13, 13, '{\"permission_common_setting\":\"Common Setting\",\"manage_account\":\"Manage Accounts\",\"setting\":\"Setting\",\"generel_setting\":\"General Setting\",\"generel_setting_update\":\"General Setting Update\",\"manage_user\":\"Manage User\",\"inv_sales\":\"Inv Sales\"}', 'e0545395b889c4f952f4163a51238f80'),
(14, 14, '{\"permission_common_setting\":\"Common Setting\",\"manage_account\":\"Manage Accounts\",\"setting\":\"Setting\",\"generel_setting\":\"General Setting\",\"generel_setting_update\":\"General Setting Update\",\"manage_user\":\"Manage User\"}', '37c87cdc00d6f68f5abf9e0abaa8de89'),
(15, 15, '{\"permission_common_setting\":\"Common Setting\",\"manage_account\":\"Manage Accounts\",\"setting\":\"Setting\",\"generel_setting\":\"General Setting\",\"generel_setting_update\":\"General Setting Update\",\"manage_user\":\"Manage User\"}', '9687036059e7a389ef28cae5ccd02497'),
(16, 16, '{\"setting\":\"Setting\",\"generel_setting\":\"General Setting\",\"generel_setting_update\":\"General Setting Update\",\"manage_user\":\"Manage User\"}', '75a6c71bb16769f3b577a11f326c808c'),
(17, 17, '{\"permission_common_setting\":\"Common Setting\",\"manage_account\":\"Manage Accounts\",\"setting\":\"Setting\",\"generel_setting\":\"General Setting\",\"generel_setting_update\":\"General Setting Update\",\"manage_user\":\"Manage User\"}', '97f850ca96b9a7e79d80342dcc018735'),
(18, 18, '{\"permission_common_setting\":\"Common Setting\",\"manage_account\":\"Manage Accounts\",\"setting\":\"Setting\",\"generel_setting\":\"General Setting\",\"generel_setting_update\":\"General Setting Update\",\"manage_user\":\"Manage User\",\"chira_category\":\"Chira_Category\",\"chira_product\":\"Chira_Product\",\"chira_production\":\"Chira_Production\",\"chira_stocks\":\"Chira_Stocks\"}', 'cbdd5470b3512f30454b95c6babbad10'),
(19, 19, '{\"permission_common\":\"Common Setting\",\"setting\":\"Setting\",\"generel_setting\":\"General Setting\",\"generel_setting_update\":\"General Setting Update\",\"manage_user\":\"Manage User\"}', '5cafc6bb8bc6bd5686bdeaab8c096da9');

--
-- Dumping data for table `inv_category`
--

INSERT INTO `inv_category` (`id`, `business_type_id`, `type`, `name`, `unit`, `description`, `created_by`, `created_at`, `modified_by`, `modified_at`, `is_deleted`, `deleted_by`, `deleted_at`, `_key`) VALUES
(1, 1, 'Others', 'চিনি', 'Bag', 'বাহিরের পণ্য', 2, '2019-01-03 07:35:08', NULL, NULL, 0, NULL, NULL, 'b91fd8a4a84f8660e035dbf62f9f5c48'),
(2, 1, 'Others', 'তেল', 'Dram', 'বাহিরের পণ্য', 2, '2019-01-03 07:36:07', 26, '2019-01-04 11:47:18', 0, NULL, NULL, '02565acf707950d762c2c14735067a16'),
(3, 1, 'Others', 'সালটু', 'Bag', 'বাহিরের পণ্য', 2, '2019-01-03 07:36:48', NULL, NULL, 0, NULL, NULL, 'd264af8d574c46f4cd20457cd08c5e1f'),
(4, 1, 'Others', 'হাইড্রোজ', 'Dram', 'বাহিরের পণ্য', 2, '2019-01-03 07:37:37', 26, '2019-01-04 11:47:42', 0, NULL, NULL, '9d446a1a54f0bc7bc15d2ef6f915db3d'),
(5, 1, 'Others', 'বি. সোডা', 'Bag', 'বাহিরের পণ্য', 2, '2019-01-03 07:38:00', NULL, NULL, 0, NULL, NULL, '61ee33c3511d96969c36f77bbd022e9d'),
(6, 1, 'Others', 'লবণ', 'Bag', 'বাহিরের পণ্য', 2, '2019-01-03 07:38:47', NULL, NULL, 0, NULL, NULL, '01dfc830f04da3d92bfb172224cc292b'),
(7, 1, 'Others', 'খালী ড্রাম', 'Piece', 'বাহিরের পণ্য', 2, '2019-01-03 07:39:09', NULL, NULL, 0, NULL, NULL, '60b63cdab067df21de2eb43fb81dd194'),
(8, 1, 'Others', 'খালি টিন', 'Piece', 'বাহিরের পণ্য', 2, '2019-01-03 07:39:39', NULL, NULL, 0, NULL, NULL, '42ffc363227bebd3cc9113dc64202a4a'),
(9, 6, 'Raw', 'সরিষা', 'Bag', 'ফ্যাক্টরি পণ্য', 2, '2019-01-03 07:40:39', 26, '2019-01-04 11:48:22', 0, NULL, NULL, '66db6e9ab69cc7af2c95f7fdd5517d22'),
(10, 6, 'Raw', 'খইল', 'Bag', 'ফ্যাক্টরি পণ্য', 2, '2019-01-03 07:41:06', 26, '2019-01-04 11:48:41', 0, NULL, NULL, '39e51f3e2778bf25b2c5901dd7fe0128'),
(11, 6, 'Finish', 'সরিষার তেল', 'Dram', 'ফ্যাক্টরি পণ্য', 2, '2019-01-03 07:41:30', 26, '2019-01-04 11:49:09', 0, NULL, NULL, 'f002e6d202197a568bb4069f42246430'),
(12, 6, 'Finish', 'খইল', 'Bag', 'ফ্যাক্টরি পণ্য', 2, '2019-01-03 07:41:49', 26, '2019-01-04 11:49:28', 0, NULL, NULL, 'c6258adab89c01ac2e4e2876eaa830bc'),
(13, 1, 'Others', 'ডালডা', 'Cartoon', 'বাহিরের পণ্য', 2, '2019-01-03 07:45:30', NULL, NULL, 0, NULL, NULL, 'a0c4f2a71ef18079a26fe6dc52d85598'),
(14, 2, 'Raw', 'গম', 'Kg', 'ফ্যাক্টরি পণ্য', 2, '2019-01-03 08:45:11', NULL, NULL, 0, NULL, NULL, '79a2e389bbaa760efd36d1e2b0dad942'),
(15, 2, 'Finish', 'আটা', 'Kg', 'ফ্যাক্টরি পণ্য', 2, '2019-01-03 08:51:56', NULL, NULL, 0, NULL, NULL, '692450671713e42a7c6b3c7abb88000f'),
(16, 2, 'Finish', 'ময়দা', 'Kg', 'ফ্যাক্টরি পণ্য', 2, '2019-01-03 08:52:19', NULL, NULL, 0, NULL, NULL, '21d0ba1525a49ee3906f3590fa020cb2'),
(17, 2, 'Finish', 'ভুষি', 'Kg', 'ফ্যাক্টরি পণ্য', 2, '2019-01-03 08:52:38', NULL, NULL, 0, NULL, NULL, '11a74eebe2d2e7be7f884535d6d6b9ae'),
(18, 2, 'Finish', 'সুজি', 'Kg', 'ফ্যাক্টরি পণ্য', 2, '2019-01-03 08:52:53', NULL, NULL, 0, NULL, NULL, 'fd5b9c74bc579aa715cc88a37e59c84e'),
(19, 2, 'Finish', 'মিলিং আটা', 'Kg', 'ফ্যাক্টরি পণ্য', 2, '2019-01-03 08:53:19', NULL, NULL, 0, NULL, NULL, 'cee6525f83435482a16547bb7496fc14'),
(20, 2, 'Finish', 'ফিল্টার', 'Kg', 'বাহিরের পণ্য', 2, '2019-01-03 08:53:52', NULL, NULL, 0, NULL, NULL, '9132aedbce1c406ce3783671a67c6424'),
(21, 2, 'Finish', 'সেমাই', 'Khaca', 'ফাক্টরী পণ্য', 26, '2019-01-04 12:11:06', 26, '2019-01-04 12:12:19', 0, NULL, NULL, 'deef2da8af42bb82271b56a043e0efb3'),
(22, 5, 'Raw', 'মসুর ডাল (কাঁচামাল)', 'Kg', 'ফাক্টরী পণ্য', 26, '2019-01-04 12:16:39', 26, '2019-01-04 12:19:32', 0, NULL, NULL, 'a8adc2b15a4e3875aa2fd1d430558f4b'),
(23, 5, 'Raw', 'খেসারি ডাল (কাঁচামাল)', 'Kg', 'ফাক্টরী পণ্য', 26, '2019-01-04 12:17:25', 26, '2019-01-04 12:20:27', 0, NULL, NULL, '4ef576244e23542428eed178b265bd1f'),
(24, 5, 'Raw', 'এ্যানকর ডাল (কাঁচামাল)', 'Kg', 'ফাক্টরী পণ্য', 26, '2019-01-04 12:18:05', 26, '2019-01-04 12:20:49', 0, NULL, NULL, '913ed338c72774bb0e29c996c27e9550'),
(25, 5, 'Raw', 'বুট ডাল (কাঁচামাল)', 'Kg', 'ফাক্টরী পণ্য', 26, '2019-01-04 12:18:38', 26, '2019-01-04 12:21:16', 0, NULL, NULL, 'bd826dff75110fa605ce4194ac4bd31a'),
(26, 5, 'Finish', 'মসুর ডাল (Finish)', 'Bag', 'ফাক্টরী পণ্য', 26, '2019-01-04 12:23:12', NULL, NULL, 0, NULL, NULL, '50425d0fac0d740643928e15d27fe82f'),
(27, 5, 'Finish', 'খেসারি ডাল (Finish)', 'Bag', 'ফাক্টরী পণ্য', 26, '2019-01-04 12:24:52', NULL, NULL, 0, NULL, NULL, '31c3c0118a4f175cecd7a135263c815e'),
(28, 5, 'Finish', 'এ্যানকর ডাল (Finish)', 'Bag', 'ফাক্টরী পণ্য', 26, '2019-01-04 12:25:31', NULL, NULL, 0, NULL, NULL, '1887bcd7c1a06ea0b419968d6c013512'),
(29, 5, 'Finish', 'বুট ডাল (Finish)', 'Bag', 'ফাক্টরী পণ্য', 26, '2019-01-04 12:26:21', NULL, NULL, 0, NULL, NULL, '9495ac31cf4429c504420f3d39771d0f'),
(30, 4, 'Raw', 'Paddy', 'Kg', 'Dhan', 2, '2019-01-05 01:16:22', NULL, NULL, 0, NULL, NULL, '9f1c58a48e99a087ff7e0330b2b4b14a');

--
-- Dumping data for table `inv_product`
--

INSERT INTO `inv_product` (`id`, `business_type_id`, `inv_category_id`, `type`, `name`, `unit`, `size`, `weight`, `color`, `grade`, `printed`, `laminated`, `liner`, `buy_price`, `created_by`, `created_at`, `modified_by`, `modified_at`, `is_deleted`, `deleted_by`, `deleted_at`, `_key`) VALUES
(1, 1, 1, 'Others', 'ফ্রেস চিনি', 'Bag', '50 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 07:43:43', NULL, NULL, 0, NULL, NULL, 'fafb9b383a7b4d03687e6319e11a68b8'),
(2, 1, 1, 'Others', 'তীর চিনি', 'Bag', '50 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 07:44:29', NULL, NULL, 0, NULL, NULL, 'c985d7afceb2e86a42c55de64458e3ce'),
(3, 1, 13, 'Others', 'পুষ্টি ডালডা', 'Cartoon', '16 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 07:46:13', NULL, NULL, 0, NULL, NULL, '8161d18ad18452e9eb5b1fb0a0b5f0e9'),
(4, 1, 2, 'Others', 'সয়াবিন তেল', 'Dram', '186 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 07:47:24', 26, '2019-01-04 11:52:44', 0, NULL, NULL, 'c4a1f1fb2174e3a3f7fa2b2ad09e50c8'),
(5, 1, 2, 'Others', 'পাম্প তেল', 'Dram', '186 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 07:48:23', 26, '2019-01-04 11:53:04', 0, NULL, NULL, '859e99911e0e37ec18027ca91d07fccb'),
(6, 1, 3, 'Others', 'সালটু', 'Bag', '25 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 07:48:57', NULL, NULL, 0, NULL, NULL, '75d58327f90c09bae83bbc586905b33e'),
(7, 1, 4, 'Others', 'হাইড্রোজ', 'Dram', '50 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 07:49:31', 26, '2019-01-04 11:53:35', 0, NULL, NULL, '1261775c5d918a79afc70760dd09b62c'),
(8, 1, 5, 'Others', 'বি. সোডা', 'Bag', '25 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 07:49:53', NULL, NULL, 0, NULL, NULL, '79c459286daff1eea0a4794c60dd9e27'),
(9, 1, 6, 'Others', 'প্যাকেট লবণ', 'Bag', '25 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 07:50:33', NULL, NULL, 0, NULL, NULL, 'e524b3bdcfcf22cd0256e007119b888e'),
(10, 1, 6, 'Others', 'খোলা লবণ', 'Bag', '50 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 07:51:22', NULL, NULL, 0, NULL, NULL, '7f16aeb8db2e11aff4bd7e2f7e07673f'),
(11, 1, 7, 'Others', 'খালী ড্রাম প্লাষ্টিক', 'Piece', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 07:52:19', NULL, NULL, 0, NULL, NULL, '7e8290f7323492994e5d204eabbde512'),
(12, 1, 7, 'Others', 'খালী ড্রাম ষ্টিল', 'Piece', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 07:53:10', NULL, NULL, 0, NULL, NULL, '131355d270801b4d348c96cd001a9ca9'),
(13, 1, 8, 'Others', 'খালি টিন', 'Piece', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 07:53:39', NULL, NULL, 0, NULL, NULL, '34f46e7ed6975bd5a5363e1af6a31a64'),
(14, 6, 9, 'Raw', 'রাসিয়ান সরিষা', 'Kg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 07:55:30', NULL, NULL, 0, NULL, NULL, 'cb56c46dee26ccbc6c7beead79b1235a'),
(15, 6, 10, 'Raw', 'দেশী সাদা সরিষা', 'Kg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 07:56:13', NULL, NULL, 0, NULL, NULL, 'f31da6b2976cdbe2f85cd09881be94ee'),
(16, 6, 10, 'Raw', 'দেশী খইল', 'Kg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 07:57:57', NULL, NULL, 0, NULL, NULL, '4c54f77be5bc09c1db1bfb4ff1cadf5e'),
(17, 6, 10, 'Raw', 'বিদেশী খইল (এল. সি)', 'Kg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 07:58:32', NULL, NULL, 0, NULL, NULL, '68de4e2fa670f555e052a404b2671dfa'),
(18, 6, 11, 'Finish', 'জাহাজ সরিষা তেল (ড্রাম)', 'Dram', '186 কে. জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 07:59:40', 26, '2019-01-04 11:55:47', 0, NULL, NULL, '816e41115c382bf56248ec4f11357754'),
(19, 6, 11, 'Finish', 'জাহাজ সরিষা তেল (টিন)', 'Tin', '15 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 08:00:52', 26, '2019-01-04 11:56:13', 0, NULL, NULL, '3c52a8281fab7ad5c8e72ed4e5488b57'),
(20, 6, 11, 'Finish', 'জাহাজ সরিষা তেল এস.পি (ড্রাম)', 'Dram', '186 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 08:01:38', 26, '2019-01-04 11:57:09', 0, NULL, NULL, '38d02e49c24fe4ceff30423b08effd6e'),
(21, 6, 11, 'Finish', 'জাহাজ সরিষা তেল এস.পি (টিন)', 'Tin', '15 কে. জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 08:02:32', 26, '2019-01-04 11:57:32', 0, NULL, NULL, 'a382c5de14970c7ce07b275efa099ff7'),
(22, 6, 11, 'Finish', 'ঈগল সরিষা তেল (ড্রাম)', 'Dram', '186 কে. জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 08:05:07', 26, '2019-01-04 11:58:14', 0, NULL, NULL, '496acf3acdd0b8f719300f442fb89494'),
(23, 6, 11, 'Finish', 'ঈগল সরিষা তেল (টিন)', 'Tin', '15 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 08:06:17', 26, '2019-01-04 11:58:35', 0, NULL, NULL, 'a3480e9ccc9abe3215975a2c69a93628'),
(24, 6, 11, 'Finish', 'ঈগল সরিষা তেল এস.পি (ড্রাম)', 'Dram', '186 কে. জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 08:07:10', 26, '2019-01-04 11:58:56', 0, NULL, NULL, '9d3f4fdeb1eb301218decfefb8d2c20c'),
(25, 6, 11, 'Finish', 'ঈগল সরিষা তেল এস.পি (টিন)', 'Tin', '15 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 08:07:37', 26, '2019-01-04 11:59:16', 0, NULL, NULL, '8abc9f1c67a629746fd478ffc688ff2e'),
(26, 6, 9, 'Raw', 'দেশী কালো সরিষা', 'Kg', 'ব্যাগ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 26, '2019-01-03 08:19:16', 26, '2019-01-04 11:59:42', 0, NULL, NULL, '75e5200beeea7ec30f81e91567e1d6d3'),
(27, 1, 13, 'Others', 'পিওর ডালডা', 'Cartoon', '16 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 26, '2019-01-03 08:20:14', NULL, NULL, 0, NULL, NULL, '788d13cbb3e66434c240e6c9ce56cf81'),
(28, 2, 14, 'Raw', 'কানাডা গম', 'Kg', 'ব্যাগ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 08:46:20', 2, '2019-01-03 08:48:40', 0, NULL, NULL, '5dbc46df0788b13d060211d5262f8387'),
(29, 2, 14, 'Raw', 'রাশিয়া গম', 'Kg', 'ব্যাগ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 08:46:57', 2, '2019-01-03 08:48:14', 0, NULL, NULL, 'f4f23577b8ebe927f36bb53eb9632608'),
(30, 2, 14, 'Raw', 'দেশী গম', 'Kg', 'ব্যাগ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 08:47:47', NULL, NULL, 0, NULL, NULL, '94870606413531e129cdb11155c42a36'),
(31, 2, 14, 'Raw', 'বুলেট গম', 'Kg', 'ব্যাগ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 08:49:18', NULL, NULL, 0, NULL, NULL, 'b34c74079bf844c632b8a457a2122da1'),
(32, 2, 14, 'Raw', 'পাকিস্তানী গম', 'Kg', 'ব্যাগ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 08:50:09', NULL, NULL, 0, NULL, NULL, '6eb8c3e49b65a12f36785babbc4225c3'),
(33, 2, 14, 'Raw', 'হাডিয়া গম', 'Kg', 'ব্যাগ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 08:50:31', NULL, NULL, 0, NULL, NULL, 'c52154578bbf7369d324b9e73c521ae1'),
(34, 2, 14, 'Raw', 'ইউক্রেন গম', 'Kg', 'ব্যাগ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 08:51:07', NULL, NULL, 0, NULL, NULL, '0e4c86591c6e10d9625bceba0f4b7fa8'),
(35, 2, 16, 'Finish', 'স্পেশাল জাহাজ ময়দা', 'Bag', '74 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 08:55:04', 26, '2019-01-04 12:00:40', 0, NULL, NULL, 'dd6be1558ef500e549afc3a56def6844'),
(36, 2, 16, 'Finish', 'জাহাজ ময়দা', 'Bag', '74 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 08:55:35', 26, '2019-01-04 12:01:19', 0, NULL, NULL, '3d1865232726b9c9e4eafa1c197279e5'),
(37, 2, 16, 'Finish', 'পায়রা ময়দা (74 কে.জি.)', 'Bag', '74 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 08:56:43', 26, '2019-01-04 12:02:00', 0, NULL, NULL, '2d9c1c95ddb2f0db6b2ce6d0f14a3f1a'),
(38, 2, 16, 'Finish', 'পায়রা ময়দা (37 কে.জি.)', 'Bag', '37 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 08:57:15', 26, '2019-01-04 12:02:36', 0, NULL, NULL, 'b4ce6e127ab9fe4b47ba9cb59476ce2d'),
(39, 2, 16, 'Finish', 'ঈগল ময়দা (74 কে.জি.)', 'Bag', '74 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 08:57:58', 26, '2019-01-04 12:03:17', 0, NULL, NULL, 'ffc6b94af6ede22de02207429ce06c5a'),
(40, 2, 16, 'Finish', 'ঈগল ময়দা (37 কে.জি.)', 'Bag', '37 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 08:58:27', 26, '2019-01-04 12:03:52', 0, NULL, NULL, '31df9f19882eb78cccdd5061ae085ed3'),
(41, 2, 17, 'Finish', 'চিকন ভুষি', 'Bag', '55 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 08:59:25', 26, '2019-01-04 12:04:37', 0, NULL, NULL, '9a2405b4c5a81f07a16803177e657f7e'),
(42, 2, 17, 'Finish', 'মোটা ভুষি', 'Bag', '37 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 09:00:13', 26, '2019-01-04 12:05:06', 0, NULL, NULL, '36a4787b21738b9d941cb7b8ad19cea7'),
(43, 2, 19, 'Finish', '১ নং মিলিং আটা', 'Bag', '74 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 09:01:42', 26, '2019-01-04 12:05:43', 0, NULL, NULL, 'dc87ce1d1b5d7805747f32376a98b032'),
(44, 2, 19, 'Finish', '২ নং মিলিং আটা', 'Bag', '74 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2019-01-03 09:02:23', 26, '2019-01-04 12:06:29', 0, NULL, NULL, 'c758168a7f3253977463c20a84591a47'),
(45, 2, 21, 'Finish', 'সাদা সেমাই', 'Khaca', '37 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 26, '2019-01-04 12:13:27', NULL, NULL, 0, NULL, NULL, '792a04ff04dc955e8c5c4152f08cf377'),
(46, 2, 21, 'Finish', 'ভাজা সেমাই', 'Khaca', '37 কে.জি', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 26, '2019-01-04 12:15:11', NULL, NULL, 0, NULL, NULL, '8cb2cc87d39055e6e6b1cf5730aa8000'),
(47, 5, 22, 'Raw', 'মসুর ডাল (দেশী)', 'Kg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 26, '2019-01-04 12:30:12', NULL, NULL, 0, NULL, NULL, '290ea13bfc75fe4e74d10831f02cafdc'),
(48, 5, 22, 'Raw', 'মসুর ডাল (বিদেশী-কানাডা)', 'Kg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 26, '2019-01-04 12:31:40', 26, '2019-01-04 12:32:35', 0, NULL, NULL, '1b30daa19c6331b7d9e336dfee5cb9a4'),
(49, 5, 22, 'Raw', 'মসুর ডাল (বিদেশী-অস্ট্রেলিয়া)', 'Kg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 26, '2019-01-04 12:36:24', NULL, NULL, 0, NULL, NULL, '5489651cd81f2d1c80bef737999dbc31'),
(50, 5, 23, 'Raw', 'খেসারি ডাল (দেশী)', 'Kg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 26, '2019-01-04 12:37:41', NULL, NULL, 0, NULL, NULL, '4194113d238239f1343481c5efc68d9d'),
(51, 5, 23, 'Raw', 'খেসারি ডাল (বিদেশী)', 'Kg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 26, '2019-01-04 12:38:33', NULL, NULL, 0, NULL, NULL, '6fccf19848e585b4e52d98e57caec8e8'),
(52, 5, 24, 'Raw', 'এ্যানকর ডাল', 'Kg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 26, '2019-01-04 12:40:07', NULL, NULL, 0, NULL, NULL, 'b4be71e78a5cc8f3f059c48a071a5cc2'),
(53, 5, 25, 'Raw', 'বুট ডাল (বড়)', 'Kg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 26, '2019-01-04 12:41:19', NULL, NULL, 0, NULL, NULL, '173f6372c591a80dbf483cd1bd9c4a9e'),
(54, 5, 25, 'Raw', 'বুট ডাল (বড়)', 'Kg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 26, '2019-01-04 12:41:20', NULL, NULL, 0, NULL, NULL, 'b07033d07c75f4dbde0a88229670e0f3'),
(55, 5, 25, 'Raw', 'বুট ডাল (ছোট)', 'Kg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 26, '2019-01-04 12:43:37', NULL, NULL, 0, NULL, NULL, '324f56d9a92575dbb73fefb70fea8901'),
(56, 5, 22, 'Finish', 'মুসর ডাল', 'Bag', '২৫ কে.জি.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 26, '2019-01-04 12:45:49', NULL, NULL, 0, NULL, NULL, '52b248656432436d0b40303445ea892c');

--
-- Dumping data for table `particulars`
--

INSERT INTO `particulars` (`id`, `institute_id`, `head_id`, `subhead_id`, `mobile`, `address`, `name`, `company_name`, `account_type`, `cc_loan_amount`, `mon`, `commission`, `code`, `created_at`, `created_by`, `modified_at`, `modified_by`, `is_deleted`, `_key`) VALUES
(4, 1, 28, 10, '46554456', '`5sdfsdfasdf', 'Rahim Mia', 'sdfsdfasdf', 'CC loan A/C', 1200, NULL, NULL, 1546668014, '2019-01-05 06:00:14', NULL, '2019-01-09 12:02:27', NULL, 0, '0915be2d40be97f8d9d8d25b7967b9b4'),
(5, 1, 28, 6, '1719206144', 'Ring Road, Shyamoli, Mohammadpur', 'Hasan', 'Tech sdfsdfasdfLsdfd', NULL, NULL, NULL, NULL, 1546668030, '2019-01-05 06:00:30', NULL, NULL, NULL, 0, '287d43b0eebe318025ccf8ffc40fbae7'),
(6, 1, 28, 7, 'sdfsadfasdf', 'Ragnpur', 'RAkib', 'sdfsadfsdfsdf', NULL, NULL, NULL, NULL, 1546668043, '2019-01-05 06:00:43', NULL, '2019-01-09 11:29:23', NULL, 0, '481b90e6f4b91136f9e18cc33915560e'),
(7, 1, 29, 7, 'lkjldsjfkljldf', 'Dhaka', 'oop', 'sdklfjsajdfkldsalk', NULL, NULL, NULL, NULL, 1546668056, '2019-01-05 06:00:56', NULL, '2019-01-09 11:29:31', NULL, 0, 'ba5a88401d4a4a9469a11e0a06207125'),
(8, 13, 20, 10, '1719206144', 'Ring Road, Shyamoli, Mohammadpur', 'Md Motaharul Islam', 'Tech Expert Lab', NULL, NULL, NULL, NULL, 1546668397, '2019-01-05 06:06:37', NULL, NULL, NULL, 0, '5b63c430b5b24392d5c7e9564606700b'),
(9, 1, 29, 8, '017154454454', 'sdfsafsd', 'Nur Hosen', 'Nur Products', 'LTR A/C', 630, NULL, NULL, 1546941219, '2019-01-08 09:53:39', NULL, NULL, NULL, 0, 'b075f00dda837c69f2ab5b5d3fe67601');

--
-- Dumping data for table `rental_building`
--

INSERT INTO `rental_building` (`id`, `building_type`, `building_name`, `building_no`, `mobile_no`, `address`, `is_deleted`, `created_at`, `created_by`, `modified_at`, `modified_by`, `deleted_at`, `deleted_by`, `_key`) VALUES
(1, 'Dokan', 'Motahar Tower', '05', '01719206144', 'Central Road, Rangpur', 0, '2019-01-08 01:12:47', 2, '2019-01-09 03:44:45', 26, NULL, NULL, '00db0ad3831421abd12227c4930c8e8e'),
(2, 'House', 'Khonikaloy', '04', '0175665555556', 'RAngpur', 0, '2019-01-09 03:33:45', 26, '2019-01-09 03:44:37', 26, NULL, NULL, '2e5b351ff9857f099cd9e86809cb92e5');

--
-- Dumping data for table `rental_flat`
--

INSERT INTO `rental_flat` (`id`, `building_id`, `floor_id`, `flat_name`, `description`, `is_deleted`, `created_at`, `created_by`, `modified_at`, `modified_by`, `deleted_at`, `deleted_by`, `_key`) VALUES
(1, 1, 1, 'A', 'A Flat', 0, '2019-01-10 04:01:01', 26, NULL, NULL, NULL, NULL, 'a18979579527655c3511cdf4ad2698c4'),
(2, 2, 2, 'A', 'A Flat', 0, '2019-01-10 04:04:58', 26, '2019-01-10 04:56:24', 26, NULL, NULL, '7864e409b6e7d69b590fd15b6ba489d6'),
(3, 1, 1, 'B', 'B Flat', 0, '2019-01-10 04:05:12', 26, '2019-01-10 04:55:50', 26, NULL, NULL, '40a33caec15a50312a6a08662d3c7ee3'),
(4, 2, 2, 'A Flat', 'A Flat', 0, '2019-01-10 04:05:28', 26, NULL, NULL, NULL, NULL, '3c32a3841687431589186118034e1497');

--
-- Dumping data for table `rental_floor`
--

INSERT INTO `rental_floor` (`id`, `building_id`, `floor_name`, `description`, `is_deleted`, `created_at`, `created_by`, `modified_at`, `modified_by`, `deleted_at`, `deleted_by`, `_key`) VALUES
(1, 1, '5th Floor', 'Fifth Floor', 0, '2019-01-10 02:32:29', 26, '2019-01-10 03:14:05', 26, NULL, NULL, 'fa1317bbe3ad1155134173155a003c29'),
(2, 2, '1st Floor', 'First Floor', 0, '2019-01-10 03:13:30', 26, '2019-01-10 03:13:39', 26, NULL, NULL, 'cd109fe0e86c5c93e1f71638d1e2ebb6');

--
-- Dumping data for table `subheads`
--

INSERT INTO `subheads` (`id`, `institute_id`, `head_id`, `name`, `code`, `is_edible`, `is_deleted`, `_key`) VALUES
(4, 1, 27, 'Hand Cash', 1546667817, 1, 0, '1b1a8e5c9339420fee2f36d7762a1ed9'),
(5, 1, 27, 'Bank Cash', 1546667818, 1, 0, 'bfb7898621492e5f064b087c37ae56aa'),
(6, 1, 28, 'Deptors', 1546667846, 1, 0, '3278366bfc6bce77bad4c59547b2cbfa'),
(7, 1, 28, 'Party', 1546667847, 1, 0, 'a70b19b63481c6708c26e41c7968a15c'),
(8, 1, 29, 'Customer', 1546667874, 1, 0, '6b53395976b8667a1253c8e6d4a08410'),
(9, 1, 29, 'Customer/Party', 1546667875, 1, 0, '78d661738a03e6c4bce8107518e7ea64'),
(10, 13, 20, 'Supplier', 1546668387, 1, 0, 'd5dec8a59b754b4b13880059e9b4cba1');

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `institute_id`, `purchase_id`, `sale_id`, `purchase_coal_id`, `type`, `voucher_type`, `payment_method`, `dr_head_id`, `dr_subhead_id`, `dr_particular_id`, `cr_head_id`, `cr_subhead_id`, `cr_particular_id`, `bank_account_id`, `check_no`, `date`, `description`, `note`, `by_whom`, `debit`, `credit`, `amount`, `created`, `created_by`, `modified`, `modified_by`, `is_edible`, `is_dbl`, `_key`) VALUES
(2, 1, NULL, NULL, NULL, 'D', 'Receive Voucher', NULL, 20, 10, 8, 20, 10, 8, NULL, NULL, '2019-01-05', 'sdfsfd', 'sdfsfd', 'sdfsdfa', 10000, 10000, 10000, '2019-01-05 06:06:58', 2, '2019-01-05 06:07:54', NULL, 1, 0, 'cf29e0ab4bd4dcda407e1b0d97bbfd45'),
(3, 1, NULL, NULL, NULL, 'D', 'Receive Voucher', NULL, 27, 4, NULL, 29, 8, 7, NULL, NULL, '2019-01-05', 'sdfsadf', 'sdfsadf', 'sadffd', 6500, 6500, 6500, '2019-01-05 10:39:03', 26, NULL, NULL, 1, 0, '696dd407fc765c1576e894630618405c'),
(4, 1, NULL, NULL, NULL, 'C', 'Payment Voucher', NULL, 29, 8, 7, 27, 4, NULL, NULL, NULL, '2019-01-06', 'fsd', 'fsd', 'fsdfsdf', 3000, 3000, 3000, '2019-01-06 08:41:23', 26, '2019-01-06 08:41:49', 26, 1, 0, '3e887c92374bc40890c57a06140c0e97'),
(5, 1, NULL, NULL, NULL, 'C', 'Payment Voucher', NULL, 29, 8, 7, 27, 4, NULL, NULL, NULL, '2019-01-08', 'wewqr', 'wewqr', 'warwe', 8000, 8000, 8000, '2019-01-06 08:42:56', 26, NULL, NULL, 1, 0, '13614dbe736010bb36707de8bada47ed'),
(6, 1, NULL, NULL, NULL, NULL, '', NULL, 28, 7, 6, 27, 4, NULL, NULL, NULL, '2019-01-07', 'uyyuiuyyi', 'uyyuiuyyi', 'ygfhf', 2000, 2000, 2000, '2019-01-07 11:23:40', 26, NULL, NULL, 1, 0, '4986dc3a36f9cbba6aa6c5464528224e'),
(7, 1, NULL, NULL, NULL, NULL, 'Journal Voucher', NULL, 27, 4, NULL, 27, 5, NULL, NULL, NULL, '2019-01-07', 'sdfsdf', 'sdfsdf', 'sdfsdfsdf', 6000, 6000, 6000, '2019-01-07 11:25:57', 26, NULL, NULL, 1, 0, '33422a574b0aed0028da55efeea49a9f');

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `institute_id`, `user_role_id`, `name`, `type`, `email`, `password`, `status`, `is_loggedin`, `lastlogin`, `locale`, `remember_token`, `created_at`, `created_by`, `updated_at`, `updated_by`, `_key`) VALUES
(2, 1, 1, 'Patwary Store', 'admin', 'admin@gmail.com', '$2y$10$tmd4k3lQMeX30ChEjKWtP.e9EqTpv73enTIqQnZeLVyYZ/skkwaNy', 1, 1, NULL, 'bn', 'u4I0ENQ1NL8yOHXLYlSkbtJ3YePUV6UTw2jV2crnBmS4uNBYDmlpnyGvYgsl', NULL, 2, '2019-01-07 22:28:38', 26, 'dc0g5w21a0ya63pob912qbddglf0si96'),
(26, 1, 1, 'Motahar', 'admin', 'mrhsajib.cse@gmail.com', '$2y$10$aHSECQ0Ar/olV0cwI3QHFuqD7iOhkOjaExn3fArr7C6guKl2StrZC', 1, 1, NULL, 'bn', 'rLXBTX5eIMMl4QKVxFcizcaZ5cxoZj4nn60P4ILzms5iXDNCjphDxEIZ7p2x', '2018-02-06 09:12:48', 2, '2019-01-10 00:05:10', 26, 'dc0b1121a0946355b91e8bddbbf0ffe6'),
(31, 12, 1, 'Ador Momota', 'institute', 'momota@gmail.com', '$2y$10$Kx3l74slFGdDD3v4zupeIObfMPeU58XmY98tM5ElZGt/wev3t8mQK', 1, 1, NULL, 'bn', 'ucJlWzBzQneYz2dgbrQqp7f2xmS1dboeqqKG1N5Ri1nEzNLSsqFvnG0zKjeL', '2018-02-06 11:44:32', 2, '2019-01-03 02:45:14', 26, 'da406e5ba774410f48204fcb1fd3b4d4'),
(32, 13, 1, 'Branch Two', 'institute', 'branch2@gmail.com', '$2y$10$KUOYsFhqFL0Nw.gNzyu8deGAkj8eZbyTMN98YD8P7TAw3FbuHim7O', 1, 0, NULL, 'bn', 'AFIzZnSfO8Sn0mj5L5r66vbN8heuXfYTVSlLJICAFlRK4mGDc3803PefM7xB', '2018-02-06 11:44:53', 2, '2018-12-12 03:34:29', 26, '2383f28135caec532d087d1570948f8f'),
(33, 12, 2, 'user1@gmail.com', 'institute', 'user1@gmail.com', '$2y$10$F0qd7Yg1nlyr3rAldUoKkue7h4pSsvKn2PFA3FNmKF6OTp0jNRcX.', 0, 0, NULL, 'en', NULL, '2018-12-20 06:59:57', 31, NULL, NULL, '14c195918bd569acd4a0195be055acd4');

--
-- Dumping data for table `user_permissions`
--

INSERT INTO `user_permissions` (`id`, `institute_id`, `user_id`, `user_type`, `permissions`, `_key`) VALUES
(3, 1, 2, NULL, '{\"permission_admin\":\"Admin Setting\",\"setting\":\"Setting\",\"generel_setting\":\"General Setting\",\"generel_setting_update\":\"General Setting Update\",\"manage_user\":\"Manage User\",\"user_access\":\"User Access\",\"user_status\":\"User Status\",\"manage_institute\":\"Manage Institute\",\"institute_access\":\"Institute Access\",\"institute_status\":\"Institute Status\",\"permission_accounts\":\"Accounts Setting\",\"manage_head\":\"Manage Head\",\"manage_subhead\":\"Manage Subhead\",\"manage_particular\":\"Manage Particular\",\"manage_transaction\":\"Manage Transaction\",\"permission_rice\":\"Rice Mill\",\"rice_category\":\"Rice Category\",\"rice_category_delete\":\"Rice Category Delete\",\"rice_product_delete\":\"Rice Product Delete\",\"rice_product\":\"Rice Product\",\"rice_production\":\"Rice Production\",\"rice_stocks\":\"Rice Stocks\",\"rice_purchase_confirm\":\"Purchase Confirm\",\"rice_purchase_edit\":\"Purchase Edit\",\"rice_purchase_delete\":\"Purchase Delete\",\"rice_purchase_list\":\"Purchase List\",\"rice_manage_sales\":\"Manage Sales\",\"rice_sale_create\":\"Sale Create\",\"rice_sale_edit\":\"Sale Edit\",\"rice_sale_confirm\":\"Sale Confirm\",\"rice_sale_delete\":\"Sale Delete\",\"rice_sale_list\":\"Sale List\",\"rice_manage_drawer\":\"Manage Drawer\",\"rice_manage_production\":\"Manage Production\",\"rice_production_order\":\"Production Order\",\"rice_production_order_create\":\"Production Order Create\",\"rice_production_order_edit\":\"Production Order Edit\",\"rice_production_order_delete\":\"Production Order Delete\",\"rice_production_order_confirm\":\"Production Order Confirm\",\"rice_production_stocks\":\"Production Stocks\",\"permission_flour\":\"Flour Mill\",\"flour_category\":\"Flour Category\",\"flour_product\":\"Flour Product\",\"flour_production\":\"Flour Production\",\"flour_stocks\":\"Flour Stocks\",\"permission_rental\":\"Rental Management\",\"rental_building\":\"Rental Building\",\"rental_floor\":\"Rental Floor\",\"rental_flat\":\"Rental Flat\",\"rental_party\":\"Rental Party\",\"permission_chiramill\":\"Chira Mill\",\"chira_category\":\"Chira_Category\",\"chira_product\":\"Chira_Product\",\"chira_production\":\"Chira_Production\",\"chira_stocks\":\"Chira_Stocks\",\"permission_murimill\":\"Muri Mill\",\"muri_category\":\"Muri Category\",\"muri_product\":\"Muri Product\",\"muri_production\":\"Muri Production\",\"muri_stocks\":\"Muri Stocks\",\"permission_inv\":\"Inventory\",\"inv_category\":\"Inv Category\",\"inv_category_delete\":\"Inv Category Delete\",\"inv_product\":\"Inv Product\",\"inv_production\":\"Inv Production\",\"inv_stocks\":\"Inv Stocks\",\"inv_purchase\":\"Inv Purchase\",\"inv_sales\":\"Inv Sales\",\"permission_bag\":\"Bag Production\",\"bag_category\":\"Bag Category\",\"bag_product\":\"Bag Product\",\"bag_production\":\"Bag Production\",\"bag_stocks\":\"Bag Stocks\",\"bag_bag\":\"Bag Bag Type\",\"bag_bag_size\":\"Bag Bag Size\"}', 'dc0g5w21a0ya63pob912qbddglf0si96'),
(27, 1, 26, NULL, '{\"permission_admin\":\"Admin Setting\",\"setting\":\"Setting\",\"generel_setting\":\"General Setting\",\"generel_setting_update\":\"General Setting Update\",\"manage_user\":\"Manage User\",\"user_access\":\"User Access\",\"user_status\":\"User Status\",\"manage_institute\":\"Manage Institute\",\"institute_access\":\"Institute Access\",\"institute_status\":\"Institute Status\",\"permission_accounts\":\"Accounts Setting\",\"manage_head\":\"Manage Head\",\"manage_subhead\":\"Manage Subhead\",\"manage_particular\":\"Manage Particular\",\"manage_transaction\":\"Manage Transaction\",\"permission_rice\":\"Rice Mill\",\"rice_category\":\"Rice Category\",\"rice_category_delete\":\"Rice Category Delete\",\"rice_product_delete\":\"Rice Product Delete\",\"rice_product\":\"Rice Product\",\"rice_production\":\"Rice Production\",\"rice_stocks\":\"Rice Stocks\",\"rice_purchase_confirm\":\"Purchase Confirm\",\"rice_purchase_edit\":\"Purchase Edit\",\"rice_purchase_delete\":\"Purchase Delete\",\"rice_purchase_list\":\"Purchase List\",\"rice_manage_sales\":\"Manage Sales\",\"rice_sale_create\":\"Sale Create\",\"rice_sale_edit\":\"Sale Edit\",\"rice_sale_confirm\":\"Sale Confirm\",\"rice_sale_delete\":\"Sale Delete\",\"rice_sale_list\":\"Sale List\",\"rice_manage_drawer\":\"Manage Drawer\",\"rice_manage_production\":\"Manage Production\",\"rice_production_order\":\"Production Order\",\"rice_production_order_create\":\"Production Order Create\",\"rice_production_order_edit\":\"Production Order Edit\",\"rice_production_order_delete\":\"Production Order Delete\",\"rice_production_order_confirm\":\"Production Order Confirm\",\"rice_production_stocks\":\"Production Stocks\",\"permission_flour\":\"Flour Mill\",\"flour_category\":\"Flour Category\",\"flour_product\":\"Flour Product\",\"flour_production\":\"Flour Production\",\"flour_stocks\":\"Flour Stocks\",\"permission_rental\":\"Rental Management\",\"rental_building\":\"Rental Building\",\"rental_floor\":\"Rental Floor\",\"rental_flat\":\"Rental Flat\",\"rental_party\":\"Rental Party\",\"permission_chiramill\":\"Chira Mill\",\"chira_category\":\"Chira_Category\",\"chira_product\":\"Chira_Product\",\"chira_production\":\"Chira_Production\",\"chira_stocks\":\"Chira_Stocks\",\"permission_murimill\":\"Muri Mill\",\"muri_category\":\"Muri Category\",\"muri_product\":\"Muri Product\",\"muri_production\":\"Muri Production\",\"muri_stocks\":\"Muri Stocks\",\"permission_inv\":\"Inventory\",\"inv_category\":\"Inv Category\",\"inv_category_delete\":\"Inv Category Delete\",\"inv_product\":\"Inv Product\",\"inv_production\":\"Inv Production\",\"inv_stocks\":\"Inv Stocks\",\"inv_purchase\":\"Inv Purchase\",\"inv_sales\":\"Inv Sales\",\"permission_bag\":\"Bag Production\",\"bag_category\":\"Bag Category\",\"bag_product\":\"Bag Product\",\"bag_production\":\"Bag Production\",\"bag_stocks\":\"Bag Stocks\",\"bag_bag\":\"Bag Bag Type\",\"bag_bag_size\":\"Bag Bag Size\"}', 'dc0b1121a0946355b91e8bddbbf0ffe6'),
(32, 12, 31, NULL, '{\"permission_admin\":\"Admin Setting\",\"setting\":\"Setting\",\"generel_setting\":\"General Setting\",\"generel_setting_update\":\"General Setting Update\",\"manage_user\":\"Manage User\",\"user_access\":\"User Access\",\"permission_accounts\":\"Accounts Setting\",\"manage_head\":\"Manage Head\",\"manage_subhead\":\"Manage Subhead\",\"manage_particular\":\"Manage Particular\",\"manage_transaction\":\"Manage Transaction\",\"permission_ricemill\":\"Rice Mill\",\"rice_category\":\"Rice Category\",\"rice_category_delete\":\"Rice Category Delete\",\"rice_product_delete\":\"Rice Product Delete\",\"rice_product\":\"Rice Product\",\"rice_production\":\"Rice Production\",\"rice_stocks\":\"Rice Stocks\",\"rice_purchase_confirm\":\"Purchase Confirm\",\"rice_purchase_edit\":\"Purchase Edit\",\"rice_purchase_delete\":\"Purchase Delete\",\"rice_purchase_list\":\"Purchase List\",\"rice_manage_sales\":\"Manage Sales\",\"rice_sale_create\":\"Sale Create\",\"rice_sale_edit\":\"Sale Edit\",\"rice_sale_confirm\":\"Sale Confirm\",\"rice_sale_delete\":\"Sale Delete\",\"rice_sale_list\":\"Sale List\",\"rice_manage_drawer\":\"Manage Drawer\",\"rice_manage_production\":\"Manage Production\",\"rice_production_order\":\"Production Order\",\"rice_production_order_create\":\"Production Order Create\",\"rice_production_order_edit\":\"Production Order Edit\",\"rice_production_order_delete\":\"Production Order Delete\",\"rice_production_order_confirm\":\"Production Order Confirm\",\"rice_production_stocks\":\"Production Stocks\"}', 'da406e5ba774410f48204fcb1fd3b4d4'),
(33, 13, 32, NULL, '{\"setting\":\"Setting\",\"generel_setting\":\"General Setting\",\"generel_setting_update\":\"General Setting Update\",\"manage_user\":\"Manage User\"}', '2383f28135caec532d087d1570948f8f'),
(34, 12, 33, NULL, '{\"manage_account\":\"Manage Accounts\",\"setting\":\"Setting\",\"generel_setting\":\"General Setting\",\"generel_setting_update\":\"General Setting Update\",\"manage_user\":\"Manage User\"}', '14c195918bd569acd4a0195be055acd4');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
