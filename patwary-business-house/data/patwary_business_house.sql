-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2018 at 09:54 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `bag_bag_color`
--

CREATE TABLE `bag_bag_color` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bag_bag_size`
--

CREATE TABLE `bag_bag_size` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bag_bag_type`
--

CREATE TABLE `bag_bag_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bag_balancesheet`
--

CREATE TABLE `bag_balancesheet` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_payment_id` int(10) UNSIGNED DEFAULT NULL,
  `payment_id` int(10) UNSIGNED DEFAULT NULL,
  `expense_id` int(10) UNSIGNED DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
  `debit` float DEFAULT NULL,
  `credit` float DEFAULT NULL,
  `balance` float DEFAULT NULL,
  `last_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bag_empty_bags`
--

CREATE TABLE `bag_empty_bags` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `type` enum('Payment','Receive') DEFAULT NULL,
  `dr_head_id` int(11) DEFAULT NULL,
  `dr_subhead_id` int(11) DEFAULT NULL,
  `dr_particular_id` int(11) DEFAULT NULL,
  `cr_head_id` int(11) DEFAULT NULL,
  `cr_subhead_id` int(11) DEFAULT NULL,
  `cr_particular_id` int(11) DEFAULT NULL,
  `by_whom` varchar(50) DEFAULT NULL,
  `description` text,
  `per_bag_price` int(11) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `size` varchar(200) DEFAULT NULL,
  `color` varchar(200) DEFAULT NULL,
  `bag_type` varchar(200) DEFAULT NULL,
  `debit` double DEFAULT NULL,
  `credit` double DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL,
  `is_edible` tinyint(4) NOT NULL DEFAULT '0',
  `is_dbl` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bag_empty_bag_stock`
--

CREATE TABLE `bag_empty_bag_stock` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `challan_no` varchar(100) DEFAULT NULL,
  `type` enum('Payment','Receive') DEFAULT NULL,
  `dr_head_id` int(11) DEFAULT NULL,
  `dr_subhead_id` int(11) DEFAULT NULL,
  `dr_particular_id` int(11) DEFAULT NULL,
  `cr_head_id` int(11) DEFAULT NULL,
  `cr_subhead_id` int(11) DEFAULT NULL,
  `cr_particular_id` int(11) DEFAULT NULL,
  `by_whom` varchar(50) DEFAULT NULL,
  `description` text,
  `quantity` double DEFAULT NULL,
  `size` varchar(200) DEFAULT NULL,
  `color` varchar(200) DEFAULT NULL,
  `bag_type` varchar(200) DEFAULT NULL,
  `debit` double DEFAULT NULL,
  `credit` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL,
  `is_edible` tinyint(4) NOT NULL DEFAULT '0',
  `is_dbl` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bag_finish_category`
--

CREATE TABLE `bag_finish_category` (
  `id` int(10) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bag_finish_product`
--

CREATE TABLE `bag_finish_product` (
  `id` int(15) NOT NULL,
  `finish_category_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `unit` varchar(150) DEFAULT NULL,
  `size` varchar(150) DEFAULT NULL,
  `sale_price` double DEFAULT NULL,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bag_heads`
--

CREATE TABLE `bag_heads` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `code` int(15) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `is_fixed` tinyint(4) NOT NULL DEFAULT '1',
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bag_labor_payment`
--

CREATE TABLE `bag_labor_payment` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `head_id` int(11) DEFAULT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  `shift` enum('Day','Night') DEFAULT NULL,
  `no_of_labor` int(11) DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(38) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bag_labor_payment_item`
--

CREATE TABLE `bag_labor_payment_item` (
  `id` int(11) NOT NULL,
  `labor_payment_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `head_id` int(11) DEFAULT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  `particular_id` int(11) DEFAULT NULL,
  `net_price` double DEFAULT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(38) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bag_particulars`
--

CREATE TABLE `bag_particulars` (
  `id` int(10) UNSIGNED NOT NULL,
  `head_id` int(11) DEFAULT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `address` text,
  `name` varchar(200) DEFAULT NULL,
  `company_name` varchar(150) DEFAULT NULL,
  `mon` double DEFAULT NULL,
  `commission` double DEFAULT NULL,
  `code` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(12) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bag_purchase`
--

CREATE TABLE `bag_purchase` (
  `id` int(20) NOT NULL,
  `date` date DEFAULT NULL,
  `type` enum('in','out','os') DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `challan_no` varchar(50) DEFAULT NULL,
  `head_id` int(11) DEFAULT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  `particular_id` int(11) DEFAULT NULL,
  `person` varchar(200) DEFAULT NULL,
  `invoice_amount` double DEFAULT NULL,
  `commission` double DEFAULT NULL,
  `transport_cost` double DEFAULT NULL,
  `labor_cost` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `due_amount` double DEFAULT NULL,
  `process_status` tinyint(4) DEFAULT '0',
  `payment_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bag_purchase_item`
--

CREATE TABLE `bag_purchase_item` (
  `id` int(20) NOT NULL,
  `date` date DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `type` enum('in','out','os') DEFAULT NULL,
  `head_id` int(15) DEFAULT NULL,
  `subhead_id` int(15) DEFAULT NULL,
  `particular_id` int(11) DEFAULT NULL,
  `person` varchar(200) DEFAULT NULL,
  `raw_category_id` int(11) DEFAULT NULL,
  `raw_product_id` int(11) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `per_qty_price` double DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bag_raw_category`
--

CREATE TABLE `bag_raw_category` (
  `id` int(10) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bag_raw_product`
--

CREATE TABLE `bag_raw_product` (
  `id` int(10) NOT NULL,
  `raw_category_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `unit` varchar(100) DEFAULT NULL,
  `size` varchar(100) DEFAULT NULL,
  `buy_price` double DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bag_sales`
--

CREATE TABLE `bag_sales` (
  `id` int(20) NOT NULL,
  `date` date DEFAULT NULL,
  `type` enum('in','out','os') DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `challan_no` varchar(50) DEFAULT NULL,
  `head_id` int(11) DEFAULT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  `particular_id` int(11) DEFAULT NULL,
  `person` varchar(200) DEFAULT NULL,
  `invoice_amount` double DEFAULT NULL,
  `commission` double DEFAULT NULL,
  `transport_cost` double DEFAULT NULL,
  `labor_cost` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `due_amount` double DEFAULT NULL,
  `process_status` tinyint(4) DEFAULT '0',
  `payment_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bag_sales_item`
--

CREATE TABLE `bag_sales_item` (
  `id` int(20) NOT NULL,
  `date` date DEFAULT NULL,
  `sales_id` int(11) DEFAULT NULL,
  `type` enum('in','out','os') DEFAULT NULL,
  `head_id` int(15) DEFAULT NULL,
  `subhead_id` int(15) DEFAULT NULL,
  `particular_id` int(11) DEFAULT NULL,
  `person` varchar(200) DEFAULT NULL,
  `finish_category_id` int(11) DEFAULT NULL,
  `finish_product_id` int(11) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `per_qty_price` double DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bag_subheads`
--

CREATE TABLE `bag_subheads` (
  `id` int(11) NOT NULL,
  `head_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `code` int(11) NOT NULL,
  `is_edible` tinyint(2) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bag_tbl_settings`
--

CREATE TABLE `bag_tbl_settings` (
  `id` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `owner` varchar(100) NOT NULL,
  `logo` varchar(300) DEFAULT NULL,
  `favicon` varchar(300) DEFAULT NULL,
  `address` text NOT NULL,
  `description` text NOT NULL,
  `email` varchar(120) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `other_contact` text NOT NULL,
  `phone` varchar(15) NOT NULL,
  `pagesize` int(11) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(12) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `copyright` text,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bag_transactions`
--

CREATE TABLE `bag_transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `empty_bag_id` int(11) DEFAULT NULL,
  `labor_payment_id` int(11) DEFAULT NULL,
  `type` enum('D','C') DEFAULT NULL,
  `voucher_type` enum('Payment Voucher','Receive Voucher','Purchase Voucher','Sales Voucher','Due Voucher','Journal Voucher') DEFAULT NULL,
  `payment_method` enum('No Payment','Bank Payment','Cash Payment') DEFAULT NULL,
  `dr_head_id` int(15) DEFAULT NULL,
  `dr_subhead_id` int(15) DEFAULT NULL,
  `dr_particular_id` int(15) DEFAULT NULL,
  `cr_head_id` int(15) DEFAULT NULL,
  `cr_subhead_id` int(15) DEFAULT NULL,
  `cr_particular_id` int(15) DEFAULT NULL,
  `bank_account_id` int(10) UNSIGNED DEFAULT NULL,
  `check_no` varchar(50) DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
  `description` text,
  `note` text,
  `by_whom` varchar(100) DEFAULT NULL,
  `debit` double DEFAULT NULL,
  `credit` double DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `is_edible` tinyint(2) NOT NULL DEFAULT '0',
  `is_dbl` tinyint(4) NOT NULL DEFAULT '0',
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `business_type`
--

CREATE TABLE `business_type` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `business_type` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `_key` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `business_type`
--

INSERT INTO `business_type` (`id`, `institute_id`, `business_type`, `created_at`, `created_by`, `modified_at`, `_key`) VALUES
(1, 1, 'Inventory', '2018-12-17 09:36:02', 2, '2018-12-17 10:26:28', 'sdfsadfsdfsd'),
(2, 1, 'Flour Mill', '2018-12-17 09:36:02', 2, '2018-12-17 10:07:29', 'sdfsadfasdfasdfsda'),
(3, 1, 'Oven Factory', '2018-12-17 09:36:46', 2, '2018-12-17 10:06:45', 'sdfsdafsafsadfsafsadfdsa'),
(4, 1, 'Rice Mill', '2018-12-17 09:38:39', 2, '2018-12-17 10:12:39', ',jhfsdafsdf'),
(5, 1, 'Dal Mill', '2018-12-17 09:59:25', 2, '2018-12-17 10:07:43', 'uiuiiusdf'),
(6, 1, 'Oil Mill', '2018-12-17 09:59:25', 2, '2018-12-17 10:07:54', 'detsdfsdfsdf'),
(7, 1, 'Import Export', '2018-12-17 09:59:25', 2, '2018-12-17 10:08:08', 'bythgflkjjjsdsd'),
(8, 1, 'Chira Muri Mill', '2018-12-17 09:59:25', 2, '2018-12-17 10:08:29', 'sdfsdgsfssghrg'),
(9, 1, 'Fertilizer', '2018-12-17 10:03:16', 2, NULL, 'dgdghtr6fdhdfg'),
(10, 1, 'Transport', '2018-12-17 10:04:40', 2, '2018-12-17 10:08:37', 'hgdfghgfr6445bfgbfsg'),
(11, 1, 'Packaging', '2018-12-17 10:05:30', 2, '2018-12-17 10:08:43', 'fgkjksgdfjkaeg2fdgd'),
(12, 1, 'Building Rent', '2018-12-17 10:09:09', 2, NULL, 'jdhshktyyheter');

-- --------------------------------------------------------

--
-- Table structure for table `dal_after_production`
--

CREATE TABLE `dal_after_production` (
  `id` int(15) NOT NULL,
  `category_id` int(10) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `sale_price` double DEFAULT NULL,
  `eqv_weight` double DEFAULT NULL,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_bag_color`
--

CREATE TABLE `dal_bag_color` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_bag_size`
--

CREATE TABLE `dal_bag_size` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_bag_type`
--

CREATE TABLE `dal_bag_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_balancesheet`
--

CREATE TABLE `dal_balancesheet` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_payment_id` int(10) UNSIGNED DEFAULT NULL,
  `payment_id` int(10) UNSIGNED DEFAULT NULL,
  `expense_id` int(10) UNSIGNED DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
  `debit` float DEFAULT NULL,
  `credit` float DEFAULT NULL,
  `balance` float DEFAULT NULL,
  `last_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_banks`
--

CREATE TABLE `dal_banks` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_deleted` tinyint(4) DEFAULT '0',
  `_key` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_bank_accounts`
--

CREATE TABLE `dal_bank_accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `bank_id` int(10) UNSIGNED NOT NULL,
  `manager_name` varchar(50) DEFAULT NULL,
  `manager_mobile` varchar(15) DEFAULT NULL,
  `account_name` varchar(100) NOT NULL,
  `account_number` varchar(100) NOT NULL,
  `account_type` varchar(50) NOT NULL,
  `address` text,
  `created` datetime NOT NULL,
  `created_by` int(10) NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(10) DEFAULT NULL,
  `_key` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='bank accounts information';

-- --------------------------------------------------------

--
-- Table structure for table `dal_categories`
--

CREATE TABLE `dal_categories` (
  `id` int(10) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `unit` varchar(30) DEFAULT NULL,
  `description` text,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_customers`
--

CREATE TABLE `dal_customers` (
  `id` int(11) NOT NULL,
  `head_id` int(11) DEFAULT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `email` varchar(55) DEFAULT NULL,
  `address` text,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(10) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_drawers`
--

CREATE TABLE `dal_drawers` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_empty_bags`
--

CREATE TABLE `dal_empty_bags` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `type` enum('Payment','Receive') DEFAULT NULL,
  `dr_head_id` int(11) DEFAULT NULL,
  `dr_subhead_id` int(11) DEFAULT NULL,
  `dr_particular_id` int(11) DEFAULT NULL,
  `cr_head_id` int(11) DEFAULT NULL,
  `cr_subhead_id` int(11) DEFAULT NULL,
  `cr_particular_id` int(11) DEFAULT NULL,
  `by_whom` varchar(50) DEFAULT NULL,
  `description` text,
  `per_bag_price` int(11) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `size` varchar(200) DEFAULT NULL,
  `color` varchar(200) DEFAULT NULL,
  `bag_type` varchar(200) DEFAULT NULL,
  `debit` double DEFAULT NULL,
  `credit` double DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL,
  `is_edible` tinyint(4) NOT NULL DEFAULT '0',
  `is_dbl` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_empty_bag_stock`
--

CREATE TABLE `dal_empty_bag_stock` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `challan_no` varchar(100) DEFAULT NULL,
  `type` enum('Payment','Receive') DEFAULT NULL,
  `dr_head_id` int(11) DEFAULT NULL,
  `dr_subhead_id` int(11) DEFAULT NULL,
  `dr_particular_id` int(11) DEFAULT NULL,
  `cr_head_id` int(11) DEFAULT NULL,
  `cr_subhead_id` int(11) DEFAULT NULL,
  `cr_particular_id` int(11) DEFAULT NULL,
  `by_whom` varchar(50) DEFAULT NULL,
  `description` text,
  `quantity` double DEFAULT NULL,
  `size` varchar(200) DEFAULT NULL,
  `color` varchar(200) DEFAULT NULL,
  `bag_type` varchar(200) DEFAULT NULL,
  `debit` double DEFAULT NULL,
  `credit` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL,
  `is_edible` tinyint(4) NOT NULL DEFAULT '0',
  `is_dbl` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_heads`
--

CREATE TABLE `dal_heads` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `code` int(15) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `is_fixed` tinyint(4) NOT NULL DEFAULT '1',
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_labor_payment`
--

CREATE TABLE `dal_labor_payment` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `duty_period` varchar(100) DEFAULT NULL,
  `labor_type` varchar(100) DEFAULT NULL,
  `no_of_labor` int(11) DEFAULT NULL,
  `per_labor_price` double DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(38) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_migrations`
--

CREATE TABLE `dal_migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dal_particulars`
--

CREATE TABLE `dal_particulars` (
  `id` int(10) UNSIGNED NOT NULL,
  `head_id` int(11) DEFAULT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `address` text,
  `name` varchar(200) DEFAULT NULL,
  `company_name` varchar(150) DEFAULT NULL,
  `mon` double DEFAULT NULL,
  `commission` double DEFAULT NULL,
  `code` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(12) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_password_resets`
--

CREATE TABLE `dal_password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_permissions`
--

CREATE TABLE `dal_permissions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `items` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_price_settings`
--

CREATE TABLE `dal_price_settings` (
  `id` int(12) NOT NULL,
  `type` varchar(30) DEFAULT NULL,
  `category_id` int(15) DEFAULT NULL,
  `product_id` int(15) DEFAULT NULL,
  `product_no_id` int(15) DEFAULT NULL,
  `per_bag_weight` float DEFAULT NULL,
  `per_bag_price` float DEFAULT NULL,
  `per_kg_price` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(12) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(12) DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_production_cost`
--

CREATE TABLE `dal_production_cost` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `order_no` int(11) DEFAULT NULL,
  `total_in` double DEFAULT NULL,
  `total_out` double DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `purchase_price` double DEFAULT NULL,
  `per_kg_price` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(38) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_production_cost_item`
--

CREATE TABLE `dal_production_cost_item` (
  `id` int(11) NOT NULL,
  `production_cost_id` int(11) DEFAULT NULL,
  `head_id` int(11) DEFAULT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  `amount` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_production_items`
--

CREATE TABLE `dal_production_items` (
  `id` int(10) NOT NULL,
  `production_id` int(11) DEFAULT NULL,
  `drawer_id` int(11) DEFAULT NULL,
  `category_id` int(10) DEFAULT NULL,
  `product_id` int(10) DEFAULT NULL,
  `net_quantity` int(20) DEFAULT NULL,
  `net_weight` float DEFAULT NULL,
  `per_qty_weight` double DEFAULT NULL,
  `process_status` tinyint(4) NOT NULL DEFAULT '0',
  `stock_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_production_orders`
--

CREATE TABLE `dal_production_orders` (
  `id` int(10) NOT NULL,
  `date` date DEFAULT NULL,
  `order_no` varchar(50) DEFAULT NULL,
  `total_quantity` int(11) DEFAULT NULL,
  `total_weight` double DEFAULT NULL,
  `process_status` tinyint(4) NOT NULL DEFAULT '0',
  `cost_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_production_settings`
--

CREATE TABLE `dal_production_settings` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_no_id` int(11) DEFAULT NULL,
  `after_production_id` int(11) DEFAULT NULL,
  `total_weight` double DEFAULT NULL,
  `net_weight` double DEFAULT NULL,
  `bag_weight` float DEFAULT NULL,
  `production_ratio` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_production_stocks`
--

CREATE TABLE `dal_production_stocks` (
  `id` int(15) NOT NULL,
  `weight_id` int(11) DEFAULT NULL,
  `category_id` int(15) DEFAULT NULL,
  `product_id` int(15) DEFAULT NULL,
  `after_production_id` int(15) DEFAULT NULL,
  `weight_item_id` int(11) DEFAULT NULL,
  `production_id` int(15) DEFAULT NULL,
  `production_item_id` text,
  `drawer_id` text,
  `order_no` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `production_stocks_no` varchar(80) DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `type` enum('in','out') DEFAULT NULL,
  `quantity` int(15) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `fraction_weight` double DEFAULT NULL,
  `per_qty_weight` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_production_stocks_item`
--

CREATE TABLE `dal_production_stocks_item` (
  `id` int(15) NOT NULL,
  `production_stocks_id` int(11) DEFAULT NULL,
  `weight_id` int(11) DEFAULT NULL,
  `sales_challan_id` int(11) DEFAULT NULL,
  `category_id` int(15) DEFAULT NULL,
  `product_id` int(15) DEFAULT NULL,
  `after_production_id` int(15) DEFAULT NULL,
  `weight_item_id` int(11) DEFAULT NULL,
  `production_id` int(15) DEFAULT NULL,
  `production_item_id` text,
  `drawer_id` text,
  `order_no` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `production_stocks_no` varchar(80) DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `type` enum('in','out') DEFAULT NULL,
  `quantity` int(15) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `fraction_weight` double DEFAULT NULL,
  `per_qty_weight` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_products`
--

CREATE TABLE `dal_products` (
  `id` int(10) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_purchase_challan`
--

CREATE TABLE `dal_purchase_challan` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `voucher_no` varchar(100) DEFAULT NULL,
  `challan_no` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `supplier_head` int(11) DEFAULT NULL,
  `supplier_subhead` int(11) DEFAULT NULL,
  `frm_head` int(11) DEFAULT NULL,
  `frm_subhead` int(11) DEFAULT NULL,
  `frm_particular` int(11) DEFAULT NULL,
  `to_head` int(11) DEFAULT NULL,
  `to_subhead` int(11) DEFAULT NULL,
  `to_particular` int(11) DEFAULT NULL,
  `truck_no` varchar(100) DEFAULT NULL,
  `port_weight` double DEFAULT NULL,
  `scale_weight` double DEFAULT NULL,
  `bag_quantity` double DEFAULT NULL,
  `truck_rent` double DEFAULT NULL,
  `comments` text,
  `transport_agency` varchar(300) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_sales_challan`
--

CREATE TABLE `dal_sales_challan` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `voucher_no` varchar(100) DEFAULT NULL,
  `challan_no` varchar(100) DEFAULT NULL,
  `supplier_head` int(11) DEFAULT NULL,
  `supplier_subhead` int(11) DEFAULT NULL,
  `truck_no` varchar(100) DEFAULT NULL,
  `comments` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_sales_challan_item`
--

CREATE TABLE `dal_sales_challan_item` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `sales_challan_id` int(11) DEFAULT NULL,
  `challan_no` varchar(100) DEFAULT NULL,
  `voucher_no` varchar(100) DEFAULT NULL,
  `supplier_head` int(11) DEFAULT NULL,
  `supplier_subhead` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `scale_weight` double NOT NULL,
  `bag_quantity` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_stocks`
--

CREATE TABLE `dal_stocks` (
  `id` int(15) UNSIGNED NOT NULL,
  `weight_id` int(15) DEFAULT NULL,
  `purchase_challan_id` int(11) DEFAULT NULL,
  `production_id` int(20) DEFAULT NULL,
  `production_no_id` int(30) DEFAULT NULL,
  `category_id` int(15) DEFAULT NULL,
  `product_id` int(15) DEFAULT NULL,
  `weight_type` enum('in','out','process') DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `invoice_no` varchar(30) DEFAULT NULL,
  `quantity` int(20) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `weight_per_qty` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_subheads`
--

CREATE TABLE `dal_subheads` (
  `id` int(11) NOT NULL,
  `head_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `code` int(11) NOT NULL,
  `is_edible` tinyint(2) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_tbl_settings`
--

CREATE TABLE `dal_tbl_settings` (
  `id` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `owner` varchar(100) NOT NULL,
  `logo` varchar(300) DEFAULT NULL,
  `favicon` varchar(300) DEFAULT NULL,
  `address` text NOT NULL,
  `description` text NOT NULL,
  `email` varchar(120) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `other_contact` text NOT NULL,
  `phone` varchar(15) NOT NULL,
  `pagesize` int(11) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(12) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `copyright` text,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_transactions`
--

CREATE TABLE `dal_transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `empty_bag_id` int(11) DEFAULT NULL,
  `purchase_challan_id` int(11) DEFAULT NULL,
  `type` enum('D','C') DEFAULT NULL,
  `voucher_type` enum('Payment Voucher','Receive Voucher','Purchase Voucher','Sales Voucher','Paddy Sales Voucher','Journal Voucher') DEFAULT NULL,
  `payment_method` enum('No Payment','Bank Payment','Cash Payment') DEFAULT NULL,
  `dr_head_id` int(15) DEFAULT NULL,
  `dr_subhead_id` int(15) DEFAULT NULL,
  `dr_particular_id` int(15) DEFAULT NULL,
  `cr_head_id` int(15) DEFAULT NULL,
  `cr_subhead_id` int(15) DEFAULT NULL,
  `cr_particular_id` int(15) DEFAULT NULL,
  `bank_account_id` int(10) UNSIGNED DEFAULT NULL,
  `check_no` varchar(50) DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
  `description` text,
  `note` text,
  `by_whom` varchar(100) DEFAULT NULL,
  `debit` double DEFAULT NULL,
  `credit` double DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `is_edible` tinyint(2) NOT NULL DEFAULT '0',
  `is_dbl` tinyint(4) NOT NULL DEFAULT '0',
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_weights`
--

CREATE TABLE `dal_weights` (
  `id` int(20) NOT NULL,
  `head_id` int(11) DEFAULT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  `broker_head_id` int(11) DEFAULT NULL,
  `broker_subhead_id` int(11) DEFAULT NULL,
  `commission_rate` double DEFAULT NULL,
  `total_commission` double DEFAULT NULL,
  `date` date DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `challan_no` varchar(50) DEFAULT NULL,
  `weight_type` enum('in','out') DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `mon` double DEFAULT NULL,
  `weight_per_qty` double DEFAULT NULL,
  `invoice_amount` double DEFAULT NULL,
  `transport_cost` double DEFAULT NULL,
  `labor_cost` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `net_payable` double DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `due_amount` double DEFAULT NULL,
  `process_status` tinyint(4) DEFAULT '0',
  `payment_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_weight_items`
--

CREATE TABLE `dal_weight_items` (
  `id` int(20) NOT NULL,
  `weight_id` int(11) DEFAULT NULL,
  `weight_type` enum('in','out') DEFAULT NULL,
  `head_id` int(15) DEFAULT NULL,
  `subhead_id` int(15) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `after_production_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `mon` double DEFAULT NULL,
  `weight_per_qty` double DEFAULT NULL,
  `per_bag_price` double DEFAULT NULL,
  `net_price` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_after_production`
--

CREATE TABLE `flour_after_production` (
  `id` int(15) NOT NULL,
  `category_id` int(10) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `sale_price` double DEFAULT NULL,
  `eqv_weight` double DEFAULT NULL,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_bag_color`
--

CREATE TABLE `flour_bag_color` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_bag_size`
--

CREATE TABLE `flour_bag_size` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_bag_type`
--

CREATE TABLE `flour_bag_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_balancesheet`
--

CREATE TABLE `flour_balancesheet` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_payment_id` int(10) UNSIGNED DEFAULT NULL,
  `payment_id` int(10) UNSIGNED DEFAULT NULL,
  `expense_id` int(10) UNSIGNED DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
  `debit` float DEFAULT NULL,
  `credit` float DEFAULT NULL,
  `balance` float DEFAULT NULL,
  `last_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_banks`
--

CREATE TABLE `flour_banks` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_deleted` tinyint(4) DEFAULT '0',
  `_key` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_bank_accounts`
--

CREATE TABLE `flour_bank_accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `bank_id` int(10) UNSIGNED NOT NULL,
  `manager_name` varchar(50) DEFAULT NULL,
  `manager_mobile` varchar(15) DEFAULT NULL,
  `account_name` varchar(100) NOT NULL,
  `account_number` varchar(100) NOT NULL,
  `account_type` varchar(50) NOT NULL,
  `address` text,
  `created` datetime NOT NULL,
  `created_by` int(10) NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(10) DEFAULT NULL,
  `_key` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='bank accounts information';

-- --------------------------------------------------------

--
-- Table structure for table `flour_categories`
--

CREATE TABLE `flour_categories` (
  `id` int(10) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `unit` varchar(30) DEFAULT NULL,
  `description` text,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_customers`
--

CREATE TABLE `flour_customers` (
  `id` int(11) NOT NULL,
  `head_id` int(11) DEFAULT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `email` varchar(55) DEFAULT NULL,
  `address` text,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(10) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_drawers`
--

CREATE TABLE `flour_drawers` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_empty_bags`
--

CREATE TABLE `flour_empty_bags` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `type` enum('Payment','Receive') DEFAULT NULL,
  `dr_head_id` int(11) DEFAULT NULL,
  `dr_subhead_id` int(11) DEFAULT NULL,
  `dr_particular_id` int(11) DEFAULT NULL,
  `cr_head_id` int(11) DEFAULT NULL,
  `cr_subhead_id` int(11) DEFAULT NULL,
  `cr_particular_id` int(11) DEFAULT NULL,
  `by_whom` varchar(50) DEFAULT NULL,
  `description` text,
  `per_bag_price` int(11) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `size` varchar(200) DEFAULT NULL,
  `color` varchar(200) DEFAULT NULL,
  `bag_type` varchar(200) DEFAULT NULL,
  `debit` double DEFAULT NULL,
  `credit` double DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL,
  `is_edible` tinyint(4) NOT NULL DEFAULT '0',
  `is_dbl` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_empty_bag_stock`
--

CREATE TABLE `flour_empty_bag_stock` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `challan_no` varchar(100) DEFAULT NULL,
  `type` enum('Payment','Receive') DEFAULT NULL,
  `dr_head_id` int(11) DEFAULT NULL,
  `dr_subhead_id` int(11) DEFAULT NULL,
  `dr_particular_id` int(11) DEFAULT NULL,
  `cr_head_id` int(11) DEFAULT NULL,
  `cr_subhead_id` int(11) DEFAULT NULL,
  `cr_particular_id` int(11) DEFAULT NULL,
  `by_whom` varchar(50) DEFAULT NULL,
  `description` text,
  `quantity` double DEFAULT NULL,
  `size` varchar(200) DEFAULT NULL,
  `color` varchar(200) DEFAULT NULL,
  `bag_type` varchar(200) DEFAULT NULL,
  `debit` double DEFAULT NULL,
  `credit` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL,
  `is_edible` tinyint(4) NOT NULL DEFAULT '0',
  `is_dbl` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_heads`
--

CREATE TABLE `flour_heads` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `code` int(15) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `is_fixed` tinyint(4) NOT NULL DEFAULT '1',
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_labor_payment`
--

CREATE TABLE `flour_labor_payment` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `duty_period` varchar(100) DEFAULT NULL,
  `labor_type` varchar(100) DEFAULT NULL,
  `no_of_labor` int(11) DEFAULT NULL,
  `per_labor_price` double DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(38) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_migrations`
--

CREATE TABLE `flour_migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flour_particulars`
--

CREATE TABLE `flour_particulars` (
  `id` int(10) UNSIGNED NOT NULL,
  `head_id` int(11) DEFAULT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `address` text,
  `name` varchar(200) DEFAULT NULL,
  `company_name` varchar(150) DEFAULT NULL,
  `mon` double DEFAULT NULL,
  `commission` double DEFAULT NULL,
  `code` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(12) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_password_resets`
--

CREATE TABLE `flour_password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_permissions`
--

CREATE TABLE `flour_permissions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `items` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_price_settings`
--

CREATE TABLE `flour_price_settings` (
  `id` int(12) NOT NULL,
  `type` varchar(30) DEFAULT NULL,
  `category_id` int(15) DEFAULT NULL,
  `product_id` int(15) DEFAULT NULL,
  `product_no_id` int(15) DEFAULT NULL,
  `per_bag_weight` float DEFAULT NULL,
  `per_bag_price` float DEFAULT NULL,
  `per_kg_price` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(12) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(12) DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_production_cost`
--

CREATE TABLE `flour_production_cost` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `order_no` int(11) DEFAULT NULL,
  `total_in` double DEFAULT NULL,
  `total_out` double DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `purchase_price` double DEFAULT NULL,
  `per_kg_price` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(38) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_production_cost_item`
--

CREATE TABLE `flour_production_cost_item` (
  `id` int(11) NOT NULL,
  `production_cost_id` int(11) DEFAULT NULL,
  `head_id` int(11) DEFAULT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  `amount` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_production_items`
--

CREATE TABLE `flour_production_items` (
  `id` int(10) NOT NULL,
  `production_id` int(11) DEFAULT NULL,
  `drawer_id` int(11) DEFAULT NULL,
  `category_id` int(10) DEFAULT NULL,
  `product_id` int(10) DEFAULT NULL,
  `net_quantity` int(20) DEFAULT NULL,
  `net_weight` float DEFAULT NULL,
  `per_qty_weight` double DEFAULT NULL,
  `process_status` tinyint(4) NOT NULL DEFAULT '0',
  `stock_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_production_orders`
--

CREATE TABLE `flour_production_orders` (
  `id` int(10) NOT NULL,
  `date` date DEFAULT NULL,
  `order_no` varchar(50) DEFAULT NULL,
  `total_quantity` int(11) DEFAULT NULL,
  `total_weight` double DEFAULT NULL,
  `process_status` tinyint(4) NOT NULL DEFAULT '0',
  `cost_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_production_settings`
--

CREATE TABLE `flour_production_settings` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_no_id` int(11) DEFAULT NULL,
  `after_production_id` int(11) DEFAULT NULL,
  `total_weight` double DEFAULT NULL,
  `net_weight` double DEFAULT NULL,
  `bag_weight` float DEFAULT NULL,
  `production_ratio` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_production_stocks`
--

CREATE TABLE `flour_production_stocks` (
  `id` int(15) NOT NULL,
  `weight_id` int(11) DEFAULT NULL,
  `category_id` int(15) DEFAULT NULL,
  `product_id` int(15) DEFAULT NULL,
  `after_production_id` int(15) DEFAULT NULL,
  `weight_item_id` int(11) DEFAULT NULL,
  `production_id` int(15) DEFAULT NULL,
  `production_item_id` text,
  `drawer_id` text,
  `order_no` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `production_stocks_no` varchar(80) DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `type` enum('in','out') DEFAULT NULL,
  `quantity` int(15) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `fraction_weight` double DEFAULT NULL,
  `per_qty_weight` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_production_stocks_item`
--

CREATE TABLE `flour_production_stocks_item` (
  `id` int(15) NOT NULL,
  `production_stocks_id` int(11) DEFAULT NULL,
  `weight_id` int(11) DEFAULT NULL,
  `sales_challan_id` int(11) DEFAULT NULL,
  `category_id` int(15) DEFAULT NULL,
  `product_id` int(15) DEFAULT NULL,
  `after_production_id` int(15) DEFAULT NULL,
  `weight_item_id` int(11) DEFAULT NULL,
  `production_id` int(15) DEFAULT NULL,
  `production_item_id` text,
  `drawer_id` text,
  `order_no` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `production_stocks_no` varchar(80) DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `type` enum('in','out') DEFAULT NULL,
  `quantity` int(15) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `fraction_weight` double DEFAULT NULL,
  `per_qty_weight` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_products`
--

CREATE TABLE `flour_products` (
  `id` int(10) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_purchase_challan`
--

CREATE TABLE `flour_purchase_challan` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `voucher_no` varchar(100) DEFAULT NULL,
  `challan_no` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `supplier_head` int(11) DEFAULT NULL,
  `supplier_subhead` int(11) DEFAULT NULL,
  `frm_head` int(11) DEFAULT NULL,
  `frm_subhead` int(11) DEFAULT NULL,
  `frm_particular` int(11) DEFAULT NULL,
  `to_head` int(11) DEFAULT NULL,
  `to_subhead` int(11) DEFAULT NULL,
  `to_particular` int(11) DEFAULT NULL,
  `truck_no` varchar(100) DEFAULT NULL,
  `port_weight` double DEFAULT NULL,
  `scale_weight` double DEFAULT NULL,
  `bag_quantity` double DEFAULT NULL,
  `truck_rent` double DEFAULT NULL,
  `comments` text,
  `transport_agency` varchar(300) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_sales_challan`
--

CREATE TABLE `flour_sales_challan` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `voucher_no` varchar(100) DEFAULT NULL,
  `challan_no` varchar(100) DEFAULT NULL,
  `supplier_head` int(11) DEFAULT NULL,
  `supplier_subhead` int(11) DEFAULT NULL,
  `truck_no` varchar(100) DEFAULT NULL,
  `comments` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_sales_challan_item`
--

CREATE TABLE `flour_sales_challan_item` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `sales_challan_id` int(11) DEFAULT NULL,
  `challan_no` varchar(100) DEFAULT NULL,
  `voucher_no` varchar(100) DEFAULT NULL,
  `supplier_head` int(11) DEFAULT NULL,
  `supplier_subhead` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `scale_weight` double NOT NULL,
  `bag_quantity` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_stocks`
--

CREATE TABLE `flour_stocks` (
  `id` int(15) UNSIGNED NOT NULL,
  `weight_id` int(15) DEFAULT NULL,
  `purchase_challan_id` int(11) DEFAULT NULL,
  `production_id` int(20) DEFAULT NULL,
  `production_no_id` int(30) DEFAULT NULL,
  `category_id` int(15) DEFAULT NULL,
  `product_id` int(15) DEFAULT NULL,
  `weight_type` enum('in','out','process') DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `invoice_no` varchar(30) DEFAULT NULL,
  `quantity` int(20) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `weight_per_qty` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_subheads`
--

CREATE TABLE `flour_subheads` (
  `id` int(11) NOT NULL,
  `head_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `code` int(11) NOT NULL,
  `is_edible` tinyint(2) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_tbl_settings`
--

CREATE TABLE `flour_tbl_settings` (
  `id` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `owner` varchar(100) NOT NULL,
  `logo` varchar(300) DEFAULT NULL,
  `favicon` varchar(300) DEFAULT NULL,
  `address` text NOT NULL,
  `description` text NOT NULL,
  `email` varchar(120) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `other_contact` text NOT NULL,
  `phone` varchar(15) NOT NULL,
  `pagesize` int(11) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(12) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `copyright` text,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_transactions`
--

CREATE TABLE `flour_transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `empty_bag_id` int(11) DEFAULT NULL,
  `purchase_challan_id` int(11) DEFAULT NULL,
  `type` enum('D','C') DEFAULT NULL,
  `voucher_type` enum('Payment Voucher','Receive Voucher','Purchase Voucher','Sales Voucher','Paddy Sales Voucher','Journal Voucher') DEFAULT NULL,
  `payment_method` enum('No Payment','Bank Payment','Cash Payment') DEFAULT NULL,
  `dr_head_id` int(15) DEFAULT NULL,
  `dr_subhead_id` int(15) DEFAULT NULL,
  `dr_particular_id` int(15) DEFAULT NULL,
  `cr_head_id` int(15) DEFAULT NULL,
  `cr_subhead_id` int(15) DEFAULT NULL,
  `cr_particular_id` int(15) DEFAULT NULL,
  `bank_account_id` int(10) UNSIGNED DEFAULT NULL,
  `check_no` varchar(50) DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
  `description` text,
  `note` text,
  `by_whom` varchar(100) DEFAULT NULL,
  `debit` double DEFAULT NULL,
  `credit` double DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `is_edible` tinyint(2) NOT NULL DEFAULT '0',
  `is_dbl` tinyint(4) NOT NULL DEFAULT '0',
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_weights`
--

CREATE TABLE `flour_weights` (
  `id` int(20) NOT NULL,
  `head_id` int(11) DEFAULT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  `broker_head_id` int(11) DEFAULT NULL,
  `broker_subhead_id` int(11) DEFAULT NULL,
  `commission_rate` double DEFAULT NULL,
  `total_commission` double DEFAULT NULL,
  `date` date DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `challan_no` varchar(50) DEFAULT NULL,
  `weight_type` enum('in','out') DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `mon` double DEFAULT NULL,
  `weight_per_qty` double DEFAULT NULL,
  `invoice_amount` double DEFAULT NULL,
  `transport_cost` double DEFAULT NULL,
  `labor_cost` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `net_payable` double DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `due_amount` double DEFAULT NULL,
  `process_status` tinyint(4) DEFAULT '0',
  `payment_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_weight_items`
--

CREATE TABLE `flour_weight_items` (
  `id` int(20) NOT NULL,
  `weight_id` int(11) DEFAULT NULL,
  `weight_type` enum('in','out') DEFAULT NULL,
  `head_id` int(15) DEFAULT NULL,
  `subhead_id` int(15) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `after_production_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `mon` double DEFAULT NULL,
  `weight_per_qty` double DEFAULT NULL,
  `per_bag_price` double DEFAULT NULL,
  `net_price` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` int(10) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `owner` varchar(100) DEFAULT NULL,
  `logo` varchar(300) DEFAULT NULL,
  `favicon` varchar(300) DEFAULT NULL,
  `address` text,
  `description` text,
  `email` varchar(120) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `other_contact` text,
  `phone` varchar(15) DEFAULT NULL,
  `pagesize` int(10) DEFAULT NULL,
  `copyright` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(10) DEFAULT NULL,
  `_key` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(20, 18, 'Manik Chira Muri Mill', NULL, NULL, NULL, 'Pulhat, Dinajpur , Bangladesh', NULL, 'manikchiramuri@gmail.com', '017545454454', NULL, '52151231213', NULL, 'Copyright © 2018 Protected. All Rights Reserved,Manik Chira Muri Mill', '2018-12-17 08:38:11', 2, NULL, NULL, 'cbdd5470b3512f30454b95c6babbad10');

-- --------------------------------------------------------

--
-- Table structure for table `heads`
--

CREATE TABLE `heads` (
  `id` int(10) UNSIGNED NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `code` int(15) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `is_fixed` tinyint(4) NOT NULL DEFAULT '1',
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `heads`
--

INSERT INTO `heads` (`id`, `institute_id`, `name`, `code`, `is_deleted`, `is_fixed`, `_key`) VALUES
(14, 12, 'Cash in Hand', 1533625874, 0, 1, '1aed366457ac27dde245418436a4310f0'),
(15, 12, 'Capital Account', 1533625875, 0, 1, 'c81aa4a93cae40382e8f69fbff2de14e1'),
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
(27, 12, 'Debtors/ Customer', 1534061875, 0, 1, 'f0f57ad96feed02f91d8812fb8816eb30'),
(28, 12, 'Creditors/ Supplier', 1534062067, 0, 1, '90c0c146b6dd99179236bf1d5ecc47400'),
(29, 12, 'Purchase', 1534233835, 0, 1, '48ee7ec6c34581c9052eb659a4fe01610'),
(30, 12, 'Party', 1534412403, 0, 1, 'faf5f18b7ae8c86ffbd3405a7b8188c80'),
(31, 13, 'Party', 1534412636, 0, 1, '6347c5a55e3db2693bd497bf650007d70');

-- --------------------------------------------------------

--
-- Table structure for table `institutes`
--

CREATE TABLE `institutes` (
  `id` int(20) NOT NULL,
  `business_type_id` int(11) DEFAULT NULL,
  `type` varchar(30) DEFAULT 'institute',
  `code` varchar(20) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `address` text,
  `phone` varchar(15) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `is_fixed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `_key` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `institutes`
--

INSERT INTO `institutes` (`id`, `business_type_id`, `type`, `code`, `name`, `address`, `phone`, `mobile`, `email`, `website`, `status`, `is_fixed`, `created_at`, `created_by`, `updated_at`, `updated_by`, `_key`) VALUES
(1, 1, 'admin', NULL, 'Patwary Store', 'Pulhat, Dinajpur', '54856665', '01719206144', 'admin@gmail.com', 'www.legenditsolution.com', 1, 1, '2017-07-28 09:44:38', 26, '2018-12-19 06:29:12', NULL, 'dc02ew21a0ya639kq912qx2tglf0si96'),
(12, 1, 'institute', NULL, 'Ador Momota Rice Mill', 'Pulhat, Dinajpur', '01737112739', '01737112739', 'momota@gmail.com', 'www.adormomota.com', 1, 0, '2018-02-06 11:41:44', 2, '2018-12-17 09:39:02', NULL, '9cb8c4c1ee36d837222cf08db4866ad9'),
(13, 1, 'institute', NULL, 'BM Rice Mill', 'Pulhat, Dinajpur , Bangladesh', '01737112739', '01737112739', 'bm@gmail.com', 'www.bm.com', 1, 0, '2018-02-06 11:43:21', 2, '2018-12-17 09:39:06', NULL, 'e0545395b889c4f952f4163a51238f80'),
(14, 2, 'institute', NULL, 'SRP Auto Flour Mill', 'Pulhat, Dinajpur , Bangladesh', '01737112739', '01719206144', 'srp@gmail.com', 'www.srp.com', 1, 0, '2018-12-17 08:35:37', 26, '2018-12-17 10:35:22', NULL, '37c87cdc00d6f68f5abf9e0abaa8de89'),
(15, 3, 'institute', NULL, 'RBF Oven Factory', 'Pulhat, Dinajpur , Bangladesh', '1719206144', '1719206144', 'rbf@gmail.com', 'www.rbf.com', 1, 0, '2018-12-17 08:36:12', 2, '2018-12-17 09:39:24', NULL, '9687036059e7a389ef28cae5ccd02497'),
(16, 1, 'institute', NULL, 'Manik Oil Mill', 'Pulhat, Dinajpur , Bangladesh', '0171654554', '54555564656', 'manik@gmail.com', 'www.manik.com', 1, 0, '2018-12-17 08:36:57', 2, '2018-12-17 09:39:31', NULL, '75a6c71bb16769f3b577a11f326c808c'),
(17, 2, 'institute', NULL, 'Manik Dall Mill', 'Pulhat, Dinajpur , Bangladesh', '545545554', '017545556455', 'manikdal@gmail.com', 'www.manikdallmill.com', 1, 0, '2018-12-17 08:37:33', 2, '2018-12-17 09:39:39', NULL, '97f850ca96b9a7e79d80342dcc018735'),
(18, 1, 'institute', NULL, 'Manik Chira Muri Mill', 'Pulhat, Dinajpur , Bangladesh', '52151231213', '017545454454', 'manikchiramuri@gmail.com', 'www.manikchiramuri.com', 1, 0, '2018-12-17 08:38:11', 2, '2018-12-17 09:39:43', NULL, 'cbdd5470b3512f30454b95c6babbad10');

-- --------------------------------------------------------

--
-- Table structure for table `institute_permissions`
--

CREATE TABLE `institute_permissions` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `permissions` text,
  `_key` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `institute_permissions`
--

INSERT INTO `institute_permissions` (`id`, `institute_id`, `permissions`, `_key`) VALUES
(1, 1, '{\"setting\":\"Setting\",\"generel_setting\":\"General Setting\",\"generel_setting_update\":\"General Setting Update\",\"raw_category\":\"Raw Category\",\"raw_product\":\"Raw Product\",\"raw_category_create\":\"Raw Category Create\",\"raw_category_delete\":\"Raw Category Delete\",\"raw_product_create\":\"Raw Product Create\",\"raw_product_delete\":\"Raw Product Delete\",\"finish_category\":\"Finish Category\",\"finish_category_create\":\"Finish Category Create\",\"finish_category_delete\":\"Finish Category Delete\",\"finish_product_create\":\"Finish Product Create\",\"finish_product_delete\":\"Finish Product Delete\",\"finish_product\":\"Finish Product\",\"manage_purchase\":\"Manage Purchase\",\"purchase_create\":\"Purchase Create\",\"purchase_edit\":\"Purchase Edit\",\"purchase_delete\":\"Purchase Delete\",\"manage_sales\":\"Manage Sales\",\"sale_create\":\"Sale Create\",\"sale_edit\":\"Sale Edit\",\"sale_delete\":\"Sale Delete\",\"manage_stocks\":\"Manage Stocks\",\"manage_user\":\"Manage User\",\"user_create\":\"User Create\",\"user_edit\":\"User Edit\",\"user_delete\":\"User Delete\",\"user_access\":\"User Access\",\"user_status\":\"User Status\",\"institute_create\":\"Institute Create\",\"institute_edit\":\"Institute Edit\",\"institute_delete\":\"Institute Delete\",\"institute_access\":\"Institute Access\",\"institute_status\":\"Institute Status\",\"manage_account\":\"Manage Accounts\",\"head_create\":\"Head Create\",\"head_edit\":\"Head Edit\",\"head_delete\":\"Head Delete\",\"subhead_create\":\"Subhead Create\",\"subhead_edit\":\"Subhead Edit\",\"subhead_delete\":\"Subhead Delete\",\"particular_create\":\"Particular Create\",\"particular_edit\":\"Particular Edit\",\"particular_delete\":\"Particular Delete\",\"transaction\":\"Transaction\",\"ledger\":\"Ledger\",\"daily_sheet\":\"Daily Sheet\"}', 'dc02ew21a0ya639kq912qx2tglf0si96'),
(12, 12, '{\"rice_category\":\"Rice Category\"}', '9cb8c4c1ee36d837222cf08db4866ad9'),
(13, 13, '{\"setting\":\"Setting\",\"generel_setting\":\"General Setting\",\"generel_setting_update\":\"General Setting Update\",\"raw_category\":\"Raw Category\",\"raw_product\":\"Raw Product\",\"raw_category_create\":\"Raw Category Create\",\"raw_category_delete\":\"Raw Category Delete\",\"raw_product_create\":\"Raw Product Create\",\"raw_product_delete\":\"Raw Product Delete\",\"finish_category\":\"Finish Category\",\"finish_category_create\":\"Finish Category Create\",\"finish_category_delete\":\"Finish Category Delete\",\"finish_product_create\":\"Finish Product Create\",\"finish_product_delete\":\"Finish Product Delete\",\"finish_product\":\"Finish Product\",\"manage_purchase\":\"Manage Purchase\",\"purchase_create\":\"Purchase Create\",\"purchase_edit\":\"Purchase Edit\",\"purchase_delete\":\"Purchase Delete\",\"manage_sales\":\"Manage Sales\",\"sale_create\":\"Sale Create\",\"sale_edit\":\"Sale Edit\",\"sale_delete\":\"Sale Delete\",\"manage_stocks\":\"Manage Stocks\",\"manage_user\":\"Manage User\",\"user_create\":\"User Create\",\"user_edit\":\"User Edit\",\"user_delete\":\"User Delete\",\"user_access\":\"User Access\",\"user_status\":\"User Status\",\"institute_create\":\"Institute Create\",\"institute_edit\":\"Institute Edit\",\"institute_delete\":\"Institute Delete\",\"institute_access\":\"Institute Access\",\"institute_status\":\"Institute Status\",\"manage_account\":\"Manage Accounts\",\"head_create\":\"Head Create\",\"head_edit\":\"Head Edit\",\"head_delete\":\"Head Delete\",\"subhead_create\":\"Subhead Create\",\"subhead_edit\":\"Subhead Edit\",\"subhead_delete\":\"Subhead Delete\",\"particular_create\":\"Particular Create\",\"particular_edit\":\"Particular Edit\",\"particular_delete\":\"Particular Delete\",\"transaction\":\"Transaction\",\"ledger\":\"Ledger\",\"daily_sheet\":\"Daily Sheet\"}', 'e0545395b889c4f952f4163a51238f80'),
(14, 14, '{\"setting\":\"Setting\",\"generel_setting\":\"General Setting\",\"generel_setting_update\":\"General Setting Update\",\"manage_user\":\"Manage User\"}', '37c87cdc00d6f68f5abf9e0abaa8de89'),
(15, 15, '{\"setting\":\"Setting\",\"generel_setting\":\"General Setting\",\"generel_setting_update\":\"General Setting Update\",\"manage_user\":\"Manage User\"}', '9687036059e7a389ef28cae5ccd02497'),
(16, 16, '{\"setting\":\"Setting\",\"generel_setting\":\"General Setting\",\"generel_setting_update\":\"General Setting Update\",\"manage_user\":\"Manage User\"}', '75a6c71bb16769f3b577a11f326c808c'),
(17, 17, '{\"setting\":\"Setting\",\"generel_setting\":\"General Setting\",\"generel_setting_update\":\"General Setting Update\",\"manage_user\":\"Manage User\"}', '97f850ca96b9a7e79d80342dcc018735'),
(18, 18, '{\"setting\":\"Setting\",\"generel_setting\":\"General Setting\",\"generel_setting_update\":\"General Setting Update\",\"manage_user\":\"Manage User\"}', 'cbdd5470b3512f30454b95c6babbad10');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `muri_after_production`
--

CREATE TABLE `muri_after_production` (
  `id` int(15) NOT NULL,
  `category_id` int(10) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `sale_price` double DEFAULT NULL,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `muri_balancesheet`
--

CREATE TABLE `muri_balancesheet` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_payment_id` int(10) UNSIGNED DEFAULT NULL,
  `payment_id` int(10) UNSIGNED DEFAULT NULL,
  `expense_id` int(10) UNSIGNED DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
  `debit` float DEFAULT NULL,
  `credit` float DEFAULT NULL,
  `balance` float DEFAULT NULL,
  `last_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `muri_banks`
--

CREATE TABLE `muri_banks` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_deleted` tinyint(4) DEFAULT '0',
  `_key` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `muri_bank_accounts`
--

CREATE TABLE `muri_bank_accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `bank_id` int(10) UNSIGNED NOT NULL,
  `manager_name` varchar(50) DEFAULT NULL,
  `manager_mobile` varchar(15) DEFAULT NULL,
  `account_name` varchar(100) NOT NULL,
  `account_number` varchar(100) NOT NULL,
  `account_type` varchar(50) NOT NULL,
  `address` text,
  `created` datetime NOT NULL,
  `created_by` int(10) NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(10) DEFAULT NULL,
  `_key` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='bank accounts information';

-- --------------------------------------------------------

--
-- Table structure for table `muri_categories`
--

CREATE TABLE `muri_categories` (
  `id` int(10) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `unit` varchar(30) DEFAULT NULL,
  `description` text,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `muri_customers`
--

CREATE TABLE `muri_customers` (
  `id` int(11) NOT NULL,
  `head_id` int(11) DEFAULT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `email` varchar(55) DEFAULT NULL,
  `address` text,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(10) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `muri_drawers`
--

CREATE TABLE `muri_drawers` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `muri_empty_bags`
--

CREATE TABLE `muri_empty_bags` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `type` enum('Payment','Receive') DEFAULT NULL,
  `dr_head_id` int(11) DEFAULT NULL,
  `dr_subhead_id` int(11) DEFAULT NULL,
  `dr_particular_id` int(11) DEFAULT NULL,
  `cr_head_id` int(11) DEFAULT NULL,
  `cr_subhead_id` int(11) DEFAULT NULL,
  `cr_particular_id` int(11) DEFAULT NULL,
  `per_bag_price` double DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `by_whom` varchar(50) DEFAULT NULL,
  `description` text,
  `debit` double DEFAULT NULL,
  `credit` double DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL,
  `is_edible` tinyint(4) NOT NULL DEFAULT '0',
  `is_dbl` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `muri_heads`
--

CREATE TABLE `muri_heads` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `code` int(15) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `is_fixed` tinyint(4) NOT NULL DEFAULT '1',
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `muri_particulars`
--

CREATE TABLE `muri_particulars` (
  `id` int(10) UNSIGNED NOT NULL,
  `head_id` int(11) DEFAULT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `address` text,
  `name` varchar(200) DEFAULT NULL,
  `company_name` varchar(150) DEFAULT NULL,
  `mon` double DEFAULT NULL,
  `code` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(12) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `muri_price_settings`
--

CREATE TABLE `muri_price_settings` (
  `id` int(12) NOT NULL,
  `type` varchar(30) DEFAULT NULL,
  `category_id` int(15) DEFAULT NULL,
  `product_id` int(15) DEFAULT NULL,
  `product_no_id` int(15) DEFAULT NULL,
  `per_bag_weight` float DEFAULT NULL,
  `per_bag_price` float DEFAULT NULL,
  `per_kg_price` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(12) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(12) DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `muri_production_items`
--

CREATE TABLE `muri_production_items` (
  `id` int(10) NOT NULL,
  `production_id` int(11) DEFAULT NULL,
  `drawer_id` int(11) DEFAULT NULL,
  `category_id` int(10) DEFAULT NULL,
  `product_id` int(10) DEFAULT NULL,
  `net_quantity` int(20) DEFAULT NULL,
  `net_weight` float DEFAULT NULL,
  `per_qty_weight` double DEFAULT NULL,
  `process_status` tinyint(4) NOT NULL DEFAULT '0',
  `stock_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `muri_production_orders`
--

CREATE TABLE `muri_production_orders` (
  `id` int(10) NOT NULL,
  `date` date DEFAULT NULL,
  `order_no` varchar(50) DEFAULT NULL,
  `total_quantity` int(11) DEFAULT NULL,
  `total_weight` double DEFAULT NULL,
  `process_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `muri_production_settings`
--

CREATE TABLE `muri_production_settings` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_no_id` int(11) DEFAULT NULL,
  `after_production_id` int(11) DEFAULT NULL,
  `total_weight` double DEFAULT NULL,
  `net_weight` double DEFAULT NULL,
  `bag_weight` float DEFAULT NULL,
  `production_ratio` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `muri_production_stocks`
--

CREATE TABLE `muri_production_stocks` (
  `id` int(15) NOT NULL,
  `weight_id` int(11) DEFAULT NULL,
  `category_id` int(15) DEFAULT NULL,
  `product_id` int(15) DEFAULT NULL,
  `after_production_id` int(15) DEFAULT NULL,
  `weight_item_id` int(11) DEFAULT NULL,
  `production_id` int(15) DEFAULT NULL,
  `production_item_id` text,
  `drawer_id` text,
  `order_no` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `production_stocks_no` varchar(80) DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `type` enum('in','out') DEFAULT NULL,
  `quantity` int(15) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `fraction_weight` double DEFAULT NULL,
  `per_qty_weight` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `muri_production_stocks_item`
--

CREATE TABLE `muri_production_stocks_item` (
  `id` int(15) NOT NULL,
  `production_stocks_id` int(11) DEFAULT NULL,
  `weight_id` int(11) DEFAULT NULL,
  `category_id` int(15) DEFAULT NULL,
  `product_id` int(15) DEFAULT NULL,
  `after_production_id` int(15) DEFAULT NULL,
  `weight_item_id` int(11) DEFAULT NULL,
  `production_id` int(15) DEFAULT NULL,
  `production_item_id` text,
  `drawer_id` text,
  `order_no` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `production_stocks_no` varchar(80) DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `type` enum('in','out') DEFAULT NULL,
  `quantity` int(15) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `fraction_weight` double DEFAULT NULL,
  `per_qty_weight` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `muri_products`
--

CREATE TABLE `muri_products` (
  `id` int(10) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `muri_stocks`
--

CREATE TABLE `muri_stocks` (
  `id` int(15) UNSIGNED NOT NULL,
  `weight_id` int(15) DEFAULT NULL,
  `production_id` int(20) DEFAULT NULL,
  `production_no_id` int(30) DEFAULT NULL,
  `category_id` int(15) DEFAULT NULL,
  `product_id` int(15) DEFAULT NULL,
  `weight_type` enum('in','out','process') DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `invoice_no` varchar(30) DEFAULT NULL,
  `quantity` int(20) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `weight_per_qty` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `muri_subheads`
--

CREATE TABLE `muri_subheads` (
  `id` int(11) NOT NULL,
  `head_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `code` int(11) NOT NULL,
  `is_edible` tinyint(2) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `muri_tbl_settings`
--

CREATE TABLE `muri_tbl_settings` (
  `id` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `owner` varchar(100) NOT NULL,
  `logo` varchar(300) DEFAULT NULL,
  `favicon` varchar(300) DEFAULT NULL,
  `address` text NOT NULL,
  `description` text NOT NULL,
  `email` varchar(120) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `other_contact` text NOT NULL,
  `phone` varchar(15) NOT NULL,
  `pagesize` int(11) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(12) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `copyright` text,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `muri_transactions`
--

CREATE TABLE `muri_transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `empty_bag_id` int(11) DEFAULT NULL,
  `type` enum('D','C') DEFAULT NULL,
  `voucher_type` enum('Payment Voucher','Receive Voucher','Purchase Voucher','Sales Voucher','Paddy Sales Voucher','Due Voucher') DEFAULT NULL,
  `payment_method` enum('No Payment','Bank Payment','Cash Payment') DEFAULT NULL,
  `dr_head_id` int(15) DEFAULT NULL,
  `dr_subhead_id` int(15) DEFAULT NULL,
  `dr_particular_id` int(15) DEFAULT NULL,
  `cr_head_id` int(15) DEFAULT NULL,
  `cr_subhead_id` int(15) DEFAULT NULL,
  `cr_particular_id` int(15) DEFAULT NULL,
  `bank_account_id` int(10) UNSIGNED DEFAULT NULL,
  `check_no` varchar(50) DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
  `description` text,
  `note` text,
  `by_whom` varchar(100) DEFAULT NULL,
  `debit` double DEFAULT NULL,
  `credit` double DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `is_edible` tinyint(2) NOT NULL DEFAULT '0',
  `is_dbl` tinyint(4) NOT NULL DEFAULT '0',
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `muri_weights`
--

CREATE TABLE `muri_weights` (
  `id` int(20) NOT NULL,
  `head_id` int(11) DEFAULT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `challan_no` varchar(50) DEFAULT NULL,
  `weight_type` enum('in','out') DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `mon` double DEFAULT NULL,
  `weight_per_qty` double DEFAULT NULL,
  `invoice_amount` double DEFAULT NULL,
  `transport_cost` double DEFAULT NULL,
  `labor_cost` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `net_payable` double DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `due_amount` double DEFAULT NULL,
  `process_status` tinyint(4) DEFAULT '0',
  `payment_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `muri_weight_items`
--

CREATE TABLE `muri_weight_items` (
  `id` int(20) NOT NULL,
  `weight_id` int(11) DEFAULT NULL,
  `weight_type` enum('in','out') DEFAULT NULL,
  `head_id` int(15) DEFAULT NULL,
  `subhead_id` int(15) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `after_production_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `mon` double DEFAULT NULL,
  `weight_per_qty` double DEFAULT NULL,
  `per_bag_price` double DEFAULT NULL,
  `net_price` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oil_bag_color`
--

CREATE TABLE `oil_bag_color` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oil_bag_size`
--

CREATE TABLE `oil_bag_size` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oil_bag_type`
--

CREATE TABLE `oil_bag_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oil_balancesheet`
--

CREATE TABLE `oil_balancesheet` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_payment_id` int(10) UNSIGNED DEFAULT NULL,
  `payment_id` int(10) UNSIGNED DEFAULT NULL,
  `expense_id` int(10) UNSIGNED DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
  `debit` float DEFAULT NULL,
  `credit` float DEFAULT NULL,
  `balance` float DEFAULT NULL,
  `last_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oil_empty_bags`
--

CREATE TABLE `oil_empty_bags` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `type` enum('Payment','Receive') DEFAULT NULL,
  `dr_head_id` int(11) DEFAULT NULL,
  `dr_subhead_id` int(11) DEFAULT NULL,
  `dr_particular_id` int(11) DEFAULT NULL,
  `cr_head_id` int(11) DEFAULT NULL,
  `cr_subhead_id` int(11) DEFAULT NULL,
  `cr_particular_id` int(11) DEFAULT NULL,
  `by_whom` varchar(50) DEFAULT NULL,
  `description` text,
  `per_bag_price` int(11) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `size` varchar(200) DEFAULT NULL,
  `color` varchar(200) DEFAULT NULL,
  `bag_type` varchar(200) DEFAULT NULL,
  `debit` double DEFAULT NULL,
  `credit` double DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL,
  `is_edible` tinyint(4) NOT NULL DEFAULT '0',
  `is_dbl` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oil_empty_bag_stock`
--

CREATE TABLE `oil_empty_bag_stock` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `challan_no` varchar(100) DEFAULT NULL,
  `type` enum('Payment','Receive') DEFAULT NULL,
  `dr_head_id` int(11) DEFAULT NULL,
  `dr_subhead_id` int(11) DEFAULT NULL,
  `dr_particular_id` int(11) DEFAULT NULL,
  `cr_head_id` int(11) DEFAULT NULL,
  `cr_subhead_id` int(11) DEFAULT NULL,
  `cr_particular_id` int(11) DEFAULT NULL,
  `by_whom` varchar(50) DEFAULT NULL,
  `description` text,
  `quantity` double DEFAULT NULL,
  `size` varchar(200) DEFAULT NULL,
  `color` varchar(200) DEFAULT NULL,
  `bag_type` varchar(200) DEFAULT NULL,
  `debit` double DEFAULT NULL,
  `credit` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL,
  `is_edible` tinyint(4) NOT NULL DEFAULT '0',
  `is_dbl` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oil_finish_category`
--

CREATE TABLE `oil_finish_category` (
  `id` int(10) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oil_finish_product`
--

CREATE TABLE `oil_finish_product` (
  `id` int(15) NOT NULL,
  `finish_category_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `unit` varchar(150) DEFAULT NULL,
  `size` varchar(150) DEFAULT NULL,
  `sale_price` double DEFAULT NULL,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oil_heads`
--

CREATE TABLE `oil_heads` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `code` int(15) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `is_fixed` tinyint(4) NOT NULL DEFAULT '1',
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oil_labor_payment`
--

CREATE TABLE `oil_labor_payment` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `head_id` int(11) DEFAULT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  `shift` enum('Day','Night') DEFAULT NULL,
  `no_of_labor` int(11) DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(38) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oil_labor_payment_item`
--

CREATE TABLE `oil_labor_payment_item` (
  `id` int(11) NOT NULL,
  `labor_payment_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `head_id` int(11) DEFAULT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  `particular_id` int(11) DEFAULT NULL,
  `net_price` double DEFAULT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(38) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oil_particulars`
--

CREATE TABLE `oil_particulars` (
  `id` int(10) UNSIGNED NOT NULL,
  `head_id` int(11) DEFAULT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `address` text,
  `name` varchar(200) DEFAULT NULL,
  `company_name` varchar(150) DEFAULT NULL,
  `mon` double DEFAULT NULL,
  `commission` double DEFAULT NULL,
  `code` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(12) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oil_purchase`
--

CREATE TABLE `oil_purchase` (
  `id` int(20) NOT NULL,
  `date` date DEFAULT NULL,
  `type` enum('in','out','os') DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `challan_no` varchar(50) DEFAULT NULL,
  `head_id` int(11) DEFAULT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  `particular_id` int(11) DEFAULT NULL,
  `person` varchar(200) DEFAULT NULL,
  `invoice_amount` double DEFAULT NULL,
  `commission` double DEFAULT NULL,
  `transport_cost` double DEFAULT NULL,
  `labor_cost` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `due_amount` double DEFAULT NULL,
  `process_status` tinyint(4) DEFAULT '0',
  `payment_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oil_purchase_item`
--

CREATE TABLE `oil_purchase_item` (
  `id` int(20) NOT NULL,
  `date` date DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `type` enum('in','out','os') DEFAULT NULL,
  `head_id` int(15) DEFAULT NULL,
  `subhead_id` int(15) DEFAULT NULL,
  `particular_id` int(11) DEFAULT NULL,
  `person` varchar(200) DEFAULT NULL,
  `raw_category_id` int(11) DEFAULT NULL,
  `raw_product_id` int(11) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `per_qty_price` double DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oil_raw_category`
--

CREATE TABLE `oil_raw_category` (
  `id` int(10) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oil_raw_product`
--

CREATE TABLE `oil_raw_product` (
  `id` int(10) NOT NULL,
  `raw_category_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `unit` varchar(100) DEFAULT NULL,
  `size` varchar(100) DEFAULT NULL,
  `buy_price` double DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oil_sales`
--

CREATE TABLE `oil_sales` (
  `id` int(20) NOT NULL,
  `date` date DEFAULT NULL,
  `type` enum('in','out','os') DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `challan_no` varchar(50) DEFAULT NULL,
  `head_id` int(11) DEFAULT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  `particular_id` int(11) DEFAULT NULL,
  `person` varchar(200) DEFAULT NULL,
  `invoice_amount` double DEFAULT NULL,
  `commission` double DEFAULT NULL,
  `transport_cost` double DEFAULT NULL,
  `labor_cost` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `due_amount` double DEFAULT NULL,
  `process_status` tinyint(4) DEFAULT '0',
  `payment_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oil_sales_item`
--

CREATE TABLE `oil_sales_item` (
  `id` int(20) NOT NULL,
  `date` date DEFAULT NULL,
  `sales_id` int(11) DEFAULT NULL,
  `type` enum('in','out','os') DEFAULT NULL,
  `head_id` int(15) DEFAULT NULL,
  `subhead_id` int(15) DEFAULT NULL,
  `particular_id` int(11) DEFAULT NULL,
  `person` varchar(200) DEFAULT NULL,
  `finish_category_id` int(11) DEFAULT NULL,
  `finish_product_id` int(11) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `per_qty_price` double DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oil_subheads`
--

CREATE TABLE `oil_subheads` (
  `id` int(11) NOT NULL,
  `head_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `code` int(11) NOT NULL,
  `is_edible` tinyint(2) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oil_tbl_settings`
--

CREATE TABLE `oil_tbl_settings` (
  `id` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `owner` varchar(100) NOT NULL,
  `logo` varchar(300) DEFAULT NULL,
  `favicon` varchar(300) DEFAULT NULL,
  `address` text NOT NULL,
  `description` text NOT NULL,
  `email` varchar(120) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `other_contact` text NOT NULL,
  `phone` varchar(15) NOT NULL,
  `pagesize` int(11) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(12) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `copyright` text,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oil_transactions`
--

CREATE TABLE `oil_transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `empty_bag_id` int(11) DEFAULT NULL,
  `labor_payment_id` int(11) DEFAULT NULL,
  `type` enum('D','C') DEFAULT NULL,
  `voucher_type` enum('Payment Voucher','Receive Voucher','Purchase Voucher','Sales Voucher','Due Voucher','Journal Voucher') DEFAULT NULL,
  `payment_method` enum('No Payment','Bank Payment','Cash Payment') DEFAULT NULL,
  `dr_head_id` int(15) DEFAULT NULL,
  `dr_subhead_id` int(15) DEFAULT NULL,
  `dr_particular_id` int(15) DEFAULT NULL,
  `cr_head_id` int(15) DEFAULT NULL,
  `cr_subhead_id` int(15) DEFAULT NULL,
  `cr_particular_id` int(15) DEFAULT NULL,
  `bank_account_id` int(10) UNSIGNED DEFAULT NULL,
  `check_no` varchar(50) DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
  `description` text,
  `note` text,
  `by_whom` varchar(100) DEFAULT NULL,
  `debit` double DEFAULT NULL,
  `credit` double DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `is_edible` tinyint(2) NOT NULL DEFAULT '0',
  `is_dbl` tinyint(4) NOT NULL DEFAULT '0',
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `particulars`
--

CREATE TABLE `particulars` (
  `id` int(10) UNSIGNED NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `head_id` int(11) DEFAULT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `address` text,
  `name` varchar(200) DEFAULT NULL,
  `company_name` varchar(150) DEFAULT NULL,
  `mon` double DEFAULT NULL,
  `commission` double DEFAULT NULL,
  `code` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(12) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `particulars`
--

INSERT INTO `particulars` (`id`, `institute_id`, `head_id`, `subhead_id`, `mobile`, `address`, `name`, `company_name`, `mon`, `commission`, `code`, `created_at`, `created_by`, `modified_at`, `modified_by`, `is_deleted`, `_key`) VALUES
(10, 13, 20, 57, '99', 'sdfsdf', 'Kamal hasan', 'ljlj', NULL, NULL, 1533638560, '2018-08-07 10:42:40', NULL, NULL, NULL, 0, 'c48276699d75c82e655afde915c2e9de'),
(11, 12, 28, 59, NULL, NULL, 'Rajib Ahmed', NULL, NULL, NULL, 1534062176, '2018-08-12 08:22:56', NULL, NULL, NULL, 0, '39cbbf012aa36df7073fa47ba93a11dd'),
(12, 12, 28, 59, NULL, NULL, 'Raton Mia', NULL, NULL, NULL, 1534062188, '2018-08-12 08:23:08', NULL, NULL, NULL, 0, '92f2d7dbae8a5ad4d282093062e6fd80'),
(13, 12, 28, 60, NULL, NULL, 'Ripon', NULL, NULL, NULL, 1534062196, '2018-08-12 08:23:16', NULL, NULL, NULL, 0, 'f5baf000e949d4bbfa72bdbd974fb251'),
(14, 13, 20, 57, NULL, NULL, 'Sajib', NULL, NULL, NULL, 1534062205, '2018-08-12 08:23:25', NULL, NULL, NULL, 0, '130d43aaef92c056ca4c08001e8a8671'),
(15, 13, 20, 61, NULL, NULL, 'Ryad', NULL, NULL, NULL, 1534062218, '2018-08-12 08:23:38', NULL, NULL, NULL, 0, 'a1b7e1a073f344867d6c904c5a3ff5c5'),
(16, 12, 30, 70, NULL, NULL, 'Hasan Ali', NULL, NULL, NULL, 1534412937, '2018-08-16 09:48:57', NULL, NULL, NULL, 0, 'c6f165b324e3142e16172aea66fc821f'),
(17, 12, 30, 71, NULL, NULL, 'Kashem Ali', NULL, NULL, NULL, 1534412964, '2018-08-16 09:49:24', NULL, NULL, NULL, 0, 'b8a65d7c506d03d19abfa46dac511628'),
(18, 12, 30, 70, NULL, NULL, 'Najjim Ahmed', NULL, NULL, NULL, 1534420022, '2018-08-16 11:47:02', NULL, NULL, NULL, 0, '56e235474404af34fff6ec929d7ddc10'),
(19, 13, 31, 77, NULL, NULL, 'Billah', NULL, NULL, NULL, 1534422261, '2018-08-16 12:24:21', NULL, NULL, NULL, 0, '06dbb2abf061e882bddb36e298c051b1'),
(20, 13, 31, 78, NULL, NULL, 'Shofiqul Islam', NULL, NULL, NULL, 1536388665, '2018-09-08 06:37:45', NULL, NULL, NULL, 0, 'cd34f0fbc873ac1ef1f53dbeb38348e0'),
(21, 13, 31, 78, NULL, NULL, 'Nadim', NULL, NULL, NULL, 1536388683, '2018-09-08 06:38:03', NULL, NULL, NULL, 0, '797d48c26b63c87e58ed5f1d8a643c30'),
(22, 12, 27, 58, '1719206144', 'Ring Road, Shyamoli, Mohammadpur', 'Md Motaharul Islam', 'Tech Expert Lab', NULL, NULL, 1545202198, '2018-12-19 06:49:58', NULL, NULL, NULL, 0, 'cb1083bcacd86a2df1d2eb752784ac4b');

-- --------------------------------------------------------

--
-- Table structure for table `rice_after_production`
--

CREATE TABLE `rice_after_production` (
  `id` int(15) NOT NULL,
  `category_id` int(10) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `sale_price` double DEFAULT NULL,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rice_balancesheet`
--

CREATE TABLE `rice_balancesheet` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_payment_id` int(10) UNSIGNED DEFAULT NULL,
  `payment_id` int(10) UNSIGNED DEFAULT NULL,
  `expense_id` int(10) UNSIGNED DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
  `debit` float DEFAULT NULL,
  `credit` float DEFAULT NULL,
  `balance` float DEFAULT NULL,
  `last_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rice_banks`
--

CREATE TABLE `rice_banks` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_deleted` tinyint(4) DEFAULT '0',
  `_key` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rice_bank_accounts`
--

CREATE TABLE `rice_bank_accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `bank_id` int(10) UNSIGNED NOT NULL,
  `manager_name` varchar(50) DEFAULT NULL,
  `manager_mobile` varchar(15) DEFAULT NULL,
  `account_name` varchar(100) NOT NULL,
  `account_number` varchar(100) NOT NULL,
  `account_type` varchar(50) NOT NULL,
  `address` text,
  `created` datetime NOT NULL,
  `created_by` int(10) NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(10) DEFAULT NULL,
  `_key` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='bank accounts information';

-- --------------------------------------------------------

--
-- Table structure for table `rice_categories`
--

CREATE TABLE `rice_categories` (
  `id` int(10) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `unit` varchar(30) DEFAULT NULL,
  `description` text,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rice_customers`
--

CREATE TABLE `rice_customers` (
  `id` int(11) NOT NULL,
  `head_id` int(11) DEFAULT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `email` varchar(55) DEFAULT NULL,
  `address` text,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(10) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rice_drawers`
--

CREATE TABLE `rice_drawers` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rice_empty_bags`
--

CREATE TABLE `rice_empty_bags` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `type` enum('Payment','Receive') DEFAULT NULL,
  `dr_head_id` int(11) DEFAULT NULL,
  `dr_subhead_id` int(11) DEFAULT NULL,
  `dr_particular_id` int(11) DEFAULT NULL,
  `cr_head_id` int(11) DEFAULT NULL,
  `cr_subhead_id` int(11) DEFAULT NULL,
  `cr_particular_id` int(11) DEFAULT NULL,
  `per_bag_price` double DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `by_whom` varchar(50) DEFAULT NULL,
  `description` text,
  `debit` double DEFAULT NULL,
  `credit` double DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL,
  `is_edible` tinyint(4) NOT NULL DEFAULT '0',
  `is_dbl` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rice_heads`
--

CREATE TABLE `rice_heads` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `code` int(15) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `is_fixed` tinyint(4) NOT NULL DEFAULT '1',
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rice_particulars`
--

CREATE TABLE `rice_particulars` (
  `id` int(10) UNSIGNED NOT NULL,
  `head_id` int(11) DEFAULT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `address` text,
  `name` varchar(200) DEFAULT NULL,
  `company_name` varchar(150) DEFAULT NULL,
  `mon` double DEFAULT NULL,
  `code` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(12) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rice_price_settings`
--

CREATE TABLE `rice_price_settings` (
  `id` int(12) NOT NULL,
  `type` varchar(30) DEFAULT NULL,
  `category_id` int(15) DEFAULT NULL,
  `product_id` int(15) DEFAULT NULL,
  `product_no_id` int(15) DEFAULT NULL,
  `per_bag_weight` float DEFAULT NULL,
  `per_bag_price` float DEFAULT NULL,
  `per_kg_price` float DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(12) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(12) DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rice_production_items`
--

CREATE TABLE `rice_production_items` (
  `id` int(10) NOT NULL,
  `production_id` int(11) DEFAULT NULL,
  `drawer_id` int(11) DEFAULT NULL,
  `category_id` int(10) DEFAULT NULL,
  `product_id` int(10) DEFAULT NULL,
  `net_quantity` int(20) DEFAULT NULL,
  `net_weight` float DEFAULT NULL,
  `per_qty_weight` double DEFAULT NULL,
  `process_status` tinyint(4) NOT NULL DEFAULT '0',
  `stock_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rice_production_orders`
--

CREATE TABLE `rice_production_orders` (
  `id` int(10) NOT NULL,
  `date` date DEFAULT NULL,
  `order_no` varchar(50) DEFAULT NULL,
  `total_quantity` int(11) DEFAULT NULL,
  `total_weight` double DEFAULT NULL,
  `process_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rice_production_settings`
--

CREATE TABLE `rice_production_settings` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_no_id` int(11) DEFAULT NULL,
  `after_production_id` int(11) DEFAULT NULL,
  `total_weight` double DEFAULT NULL,
  `net_weight` double DEFAULT NULL,
  `bag_weight` float DEFAULT NULL,
  `production_ratio` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rice_production_stocks`
--

CREATE TABLE `rice_production_stocks` (
  `id` int(15) NOT NULL,
  `weight_id` int(11) DEFAULT NULL,
  `category_id` int(15) DEFAULT NULL,
  `product_id` int(15) DEFAULT NULL,
  `after_production_id` int(15) DEFAULT NULL,
  `weight_item_id` int(11) DEFAULT NULL,
  `production_id` int(15) DEFAULT NULL,
  `production_item_id` text,
  `drawer_id` text,
  `order_no` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `production_stocks_no` varchar(80) DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `type` enum('in','out') DEFAULT NULL,
  `quantity` int(15) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `fraction_weight` double DEFAULT NULL,
  `per_qty_weight` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rice_production_stocks_item`
--

CREATE TABLE `rice_production_stocks_item` (
  `id` int(15) NOT NULL,
  `production_stocks_id` int(11) DEFAULT NULL,
  `weight_id` int(11) DEFAULT NULL,
  `category_id` int(15) DEFAULT NULL,
  `product_id` int(15) DEFAULT NULL,
  `after_production_id` int(15) DEFAULT NULL,
  `weight_item_id` int(11) DEFAULT NULL,
  `production_id` int(15) DEFAULT NULL,
  `production_item_id` text,
  `drawer_id` text,
  `order_no` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `production_stocks_no` varchar(80) DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `type` enum('in','out') DEFAULT NULL,
  `quantity` int(15) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `fraction_weight` double DEFAULT NULL,
  `per_qty_weight` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rice_products`
--

CREATE TABLE `rice_products` (
  `id` int(10) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rice_stocks`
--

CREATE TABLE `rice_stocks` (
  `id` int(15) UNSIGNED NOT NULL,
  `weight_id` int(15) DEFAULT NULL,
  `production_id` int(20) DEFAULT NULL,
  `production_no_id` int(30) DEFAULT NULL,
  `category_id` int(15) DEFAULT NULL,
  `product_id` int(15) DEFAULT NULL,
  `weight_type` enum('in','out','process') DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `invoice_no` varchar(30) DEFAULT NULL,
  `quantity` int(20) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `weight_per_qty` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rice_subheads`
--

CREATE TABLE `rice_subheads` (
  `id` int(11) NOT NULL,
  `head_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `code` int(11) NOT NULL,
  `is_edible` tinyint(2) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rice_tbl_settings`
--

CREATE TABLE `rice_tbl_settings` (
  `id` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `owner` varchar(100) NOT NULL,
  `logo` varchar(300) DEFAULT NULL,
  `favicon` varchar(300) DEFAULT NULL,
  `address` text NOT NULL,
  `description` text NOT NULL,
  `email` varchar(120) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `other_contact` text NOT NULL,
  `phone` varchar(15) NOT NULL,
  `pagesize` int(11) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(12) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `copyright` text,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rice_transactions`
--

CREATE TABLE `rice_transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `empty_bag_id` int(11) DEFAULT NULL,
  `type` enum('D','C') DEFAULT NULL,
  `voucher_type` enum('Payment Voucher','Receive Voucher','Purchase Voucher','Sales Voucher','Paddy Sales Voucher','Due Voucher') DEFAULT NULL,
  `payment_method` enum('No Payment','Bank Payment','Cash Payment') DEFAULT NULL,
  `dr_head_id` int(15) DEFAULT NULL,
  `dr_subhead_id` int(15) DEFAULT NULL,
  `dr_particular_id` int(15) DEFAULT NULL,
  `cr_head_id` int(15) DEFAULT NULL,
  `cr_subhead_id` int(15) DEFAULT NULL,
  `cr_particular_id` int(15) DEFAULT NULL,
  `bank_account_id` int(10) UNSIGNED DEFAULT NULL,
  `check_no` varchar(50) DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
  `description` text,
  `note` text,
  `by_whom` varchar(100) DEFAULT NULL,
  `debit` double DEFAULT NULL,
  `credit` double DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `is_edible` tinyint(2) NOT NULL DEFAULT '0',
  `is_dbl` tinyint(4) NOT NULL DEFAULT '0',
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rice_weights`
--

CREATE TABLE `rice_weights` (
  `id` int(20) NOT NULL,
  `head_id` int(11) DEFAULT NULL,
  `subhead_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `challan_no` varchar(50) DEFAULT NULL,
  `weight_type` enum('in','out') DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `mon` double DEFAULT NULL,
  `weight_per_qty` double DEFAULT NULL,
  `invoice_amount` double DEFAULT NULL,
  `transport_cost` double DEFAULT NULL,
  `labor_cost` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `net_payable` double DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `due_amount` double DEFAULT NULL,
  `process_status` tinyint(4) DEFAULT '0',
  `payment_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rice_weight_items`
--

CREATE TABLE `rice_weight_items` (
  `id` int(20) NOT NULL,
  `weight_id` int(11) DEFAULT NULL,
  `weight_type` enum('in','out') DEFAULT NULL,
  `head_id` int(15) DEFAULT NULL,
  `subhead_id` int(15) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `after_production_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `mon` double DEFAULT NULL,
  `weight_per_qty` double DEFAULT NULL,
  `per_bag_price` double DEFAULT NULL,
  `net_price` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subheads`
--

CREATE TABLE `subheads` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `head_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `code` int(11) NOT NULL,
  `is_edible` tinyint(2) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subheads`
--

INSERT INTO `subheads` (`id`, `institute_id`, `head_id`, `name`, `code`, `is_edible`, `is_deleted`, `_key`) VALUES
(53, 12, 14, 'Cash Account', 1533626009, 1, 0, 'd192658e614356e5f336c9c6b68ec25b'),
(55, 13, 17, 'Cash Account', 1533630869, 1, 0, 'eba05505dcfefaebd310db479f5f2672'),
(57, 13, 20, 'Coila Supplier', 1533630923, 1, 0, '4d695491fa33dc4be492b90a874c5522'),
(58, 12, 27, 'Customer', 1534062124, 1, 0, '392f1164999c40f04d9aea9343d6caef'),
(59, 12, 28, 'Coila Supplier', 1534062146, 1, 0, 'ad8c42a10e5bfb0452cd82e5e099faf1'),
(60, 12, 28, 'Soil Supplier', 1534062147, 1, 0, 'bc1d1f17246e2cd2da711400e9037b86'),
(61, 13, 20, 'Soil Supplier', 1534062160, 1, 0, '27c8e5af1acc34028ffbe66c46611023'),
(62, 13, 25, 'Soil Purchase', 1534231228, 1, 0, 'b2dbfaa681a7a38c88e6b63d740b0a4a'),
(66, 13, 25, 'Coila Purchase', 1534231264, 1, 0, 'c9e5136643662bfdaa1f4aba88a0d386'),
(68, 12, 29, 'Soil Purchase', 1534233878, 1, 0, 'e421e967d544f9764a8167febfad9fd7'),
(69, 12, 29, 'Coila Purchase', 1534233879, 1, 0, '81067e4346245c1490f083b0345d6b3f'),
(70, 12, 30, 'Mill party', 1534412550, 1, 0, '60d9ceebb4b5cae8f8c4be9e5f4c0451'),
(71, 12, 30, 'Reza party', 1534412551, 1, 0, 'eb7384e9e41fcdb11e09a9d942365bc1'),
(72, 12, 30, 'Reza Mistri', 1534412552, 1, 0, '978687a6e693bb0d4e8df1e1a9228cc5'),
(73, 12, 30, 'Chamber Rubbish party', 1534412553, 1, 0, '742df68ef0126118081f87fa1bd2dca7'),
(74, 12, 30, 'Unloading Party', 1534412554, 1, 0, '72afce8ab9109e31bf61cc124fc6707a'),
(75, 12, 30, 'Coal Break party', 1534412555, 1, 0, '17fe6df23e18205fccb337fbbe3b0635'),
(76, 12, 30, 'Coal burning party', 1534412556, 1, 0, '238e27e8319c8c3829646133bce72449'),
(77, 13, 31, 'Mill Party', 1534412732, 1, 0, '5e5998732534900cfbc9012e310b78dd'),
(78, 13, 31, 'Reza party', 1534412733, 1, 0, '5a1a90b0dbe7250dce3de5eb8287fe7e'),
(79, 13, 31, 'Reza Mistri', 1534412734, 1, 0, '90d13278948ec7e2510bc1fcdb9cc22f'),
(80, 13, 31, 'Chamber Rubbish party ', 1534412735, 1, 0, '018d55c13405d26b0317b120cda53cc2'),
(81, 13, 31, 'Unloading Party', 1534412736, 1, 0, '9d13ed26cb707fcb24dc6525d90cee63'),
(82, 13, 31, 'Coal Break Party ', 1534412737, 1, 0, '3d77cf09c3e7dd1e71e5192436d03802'),
(83, 13, 31, 'Coal burning party', 1534412738, 1, 0, '69e1946b1a584c3076e6dcf017a2e787'),
(84, 13, 31, 'Fire Mistri', 1534412739, 1, 0, '19869c57eb5cc900af7fd1fc4aab5912'),
(85, 12, 30, 'Fire Mistri', 1534412763, 1, 0, 'a3d1ea3506a2ca18785eed956b087816');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `purchase_coal_id` int(11) DEFAULT NULL,
  `type` enum('D','C') DEFAULT NULL,
  `voucher_type` enum('Payment Voucher','Receive Voucher','Purchase Voucher','Sales Voucher','Paddy Sales Voucher','Journal Voucher') DEFAULT NULL,
  `payment_method` enum('No Payment','Bank Payment','Cash Payment') DEFAULT NULL,
  `dr_head_id` int(15) DEFAULT NULL,
  `dr_subhead_id` int(15) DEFAULT NULL,
  `dr_particular_id` int(15) DEFAULT NULL,
  `cr_head_id` int(15) DEFAULT NULL,
  `cr_subhead_id` int(15) DEFAULT NULL,
  `cr_particular_id` int(15) DEFAULT NULL,
  `bank_account_id` int(10) UNSIGNED DEFAULT NULL,
  `check_no` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `description` text,
  `note` text,
  `by_whom` varchar(100) DEFAULT NULL,
  `debit` double DEFAULT NULL,
  `credit` double DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `is_edible` tinyint(2) NOT NULL DEFAULT '0',
  `is_dbl` tinyint(4) NOT NULL DEFAULT '0',
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `institute_id` int(10) DEFAULT NULL,
  `user_role_id` int(10) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'institute',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `is_loggedin` tinyint(1) NOT NULL DEFAULT '0',
  `lastlogin` timestamp NULL DEFAULT NULL,
  `locale` enum('en','bn') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(10) DEFAULT NULL,
  `_key` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `institute_id`, `user_role_id`, `name`, `type`, `email`, `password`, `status`, `is_loggedin`, `lastlogin`, `locale`, `remember_token`, `created_at`, `created_by`, `updated_at`, `updated_by`, `_key`) VALUES
(2, 1, 1, 'Patwary Store', 'admin', 'admin@gmail.com', '$2y$10$tmd4k3lQMeX30ChEjKWtP.e9EqTpv73enTIqQnZeLVyYZ/skkwaNy', 1, 0, NULL, 'bn', 'ePwvioaXH9hyPdEB7QzDiC8Rh0pdtIoLhKxdhZfSGdizCKDIPjqodCxUW0Dc', NULL, 2, '2018-12-17 03:25:26', 26, 'dc0g5w21a0ya63pob912qbddglf0si96'),
(26, 1, 1, 'Motahar', 'admin', 'mrhsajib.cse@gmail.com', '$2y$10$aHSECQ0Ar/olV0cwI3QHFuqD7iOhkOjaExn3fArr7C6guKl2StrZC', 1, 1, NULL, 'bn', 'jzV0Tba2nduags9CMVo98YEb2xf4SRac68OLcugWuvNJxEsN30g1HBfJYGah', '2018-02-06 09:12:48', 2, '2018-12-19 00:50:56', 26, 'dc0b1121a0946355b91e8bddbbf0ffe6'),
(31, 12, 1, 'Ador Momota', 'institute', 'momota@gmail.com', '$2y$10$Kx3l74slFGdDD3v4zupeIObfMPeU58XmY98tM5ElZGt/wev3t8mQK', 1, 1, NULL, 'bn', 'mslrto49abPeB40W5FWo62IBsdYLE0bOEuVwPehzz5JtPuPvjkFVGIEGLrnW', '2018-02-06 11:44:32', 2, '2018-12-20 00:49:56', 26, 'da406e5ba774410f48204fcb1fd3b4d4'),
(32, 13, 1, 'Branch Two', 'institute', 'branch2@gmail.com', '$2y$10$KUOYsFhqFL0Nw.gNzyu8deGAkj8eZbyTMN98YD8P7TAw3FbuHim7O', 1, 0, NULL, 'bn', 'AFIzZnSfO8Sn0mj5L5r66vbN8heuXfYTVSlLJICAFlRK4mGDc3803PefM7xB', '2018-02-06 11:44:53', 2, '2018-12-12 03:34:29', 26, '2383f28135caec532d087d1570948f8f'),
(33, 12, 2, 'user1@gmail.com', 'institute', 'user1@gmail.com', '$2y$10$F0qd7Yg1nlyr3rAldUoKkue7h4pSsvKn2PFA3FNmKF6OTp0jNRcX.', 0, 0, NULL, 'en', NULL, '2018-12-20 06:59:57', 31, NULL, NULL, '14c195918bd569acd4a0195be055acd4');

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

CREATE TABLE `user_permissions` (
  `id` int(20) NOT NULL,
  `institute_id` int(20) DEFAULT NULL,
  `user_id` int(20) DEFAULT NULL,
  `user_type` varchar(30) DEFAULT NULL,
  `permissions` text,
  `_key` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_permissions`
--

INSERT INTO `user_permissions` (`id`, `institute_id`, `user_id`, `user_type`, `permissions`, `_key`) VALUES
(3, 1, 2, NULL, '{\"setting\":\"Setting\",\"generel_setting\":\"General Setting\",\"generel_setting_update\":\"General Setting Update\",\"raw_category\":\"Raw Category\",\"raw_product\":\"Raw Product\",\"raw_category_create\":\"Raw Category Create\",\"raw_category_delete\":\"Raw Category Delete\",\"raw_product_create\":\"Raw Product Create\",\"raw_product_delete\":\"Raw Product Delete\",\"finish_category\":\"Finish Category\",\"finish_category_create\":\"Finish Category Create\",\"finish_category_delete\":\"Finish Category Delete\",\"finish_product_create\":\"Finish Product Create\",\"finish_product_delete\":\"Finish Product Delete\",\"finish_product\":\"Finish Product\",\"manage_purchase\":\"Manage Purchase\",\"purchase_create\":\"Purchase Create\",\"purchase_edit\":\"Purchase Edit\",\"purchase_delete\":\"Purchase Delete\",\"manage_sales\":\"Manage Sales\",\"sale_create\":\"Sale Create\",\"sale_edit\":\"Sale Edit\",\"sale_delete\":\"Sale Delete\",\"manage_stocks\":\"Manage Stocks\",\"manage_user\":\"Manage User\",\"user_create\":\"User Create\",\"user_edit\":\"User Edit\",\"user_delete\":\"User Delete\",\"user_access\":\"User Access\",\"user_status\":\"User Status\",\"institute_create\":\"Institute Create\",\"institute_edit\":\"Institute Edit\",\"institute_delete\":\"Institute Delete\",\"institute_access\":\"Institute Access\",\"institute_status\":\"Institute Status\",\"manage_account\":\"Manage Accounts\",\"head_create\":\"Head Create\",\"head_edit\":\"Head Edit\",\"head_delete\":\"Head Delete\",\"subhead_create\":\"Subhead Create\",\"subhead_edit\":\"Subhead Edit\",\"subhead_delete\":\"Subhead Delete\",\"particular_create\":\"Particular Create\",\"particular_edit\":\"Particular Edit\",\"particular_delete\":\"Particular Delete\",\"transaction\":\"Transaction\",\"ledger\":\"Ledger\",\"daily_sheet\":\"Daily Sheet\"}', 'dc0g5w21a0ya63pob912qbddglf0si96'),
(27, 1, 26, NULL, '{\"setting\":\"Setting\",\"generel_setting\":\"General Setting\",\"generel_setting_update\":\"General Setting Update\",\"raw_category\":\"Raw Category\",\"raw_product\":\"Raw Product\",\"raw_category_create\":\"Raw Category Create\",\"raw_category_delete\":\"Raw Category Delete\",\"raw_product_create\":\"Raw Product Create\",\"raw_product_delete\":\"Raw Product Delete\",\"finish_category\":\"Finish Category\",\"finish_category_create\":\"Finish Category Create\",\"finish_category_delete\":\"Finish Category Delete\",\"finish_product_create\":\"Finish Product Create\",\"finish_product_delete\":\"Finish Product Delete\",\"finish_product\":\"Finish Product\",\"manage_purchase\":\"Manage Purchase\",\"purchase_create\":\"Purchase Create\",\"purchase_edit\":\"Purchase Edit\",\"purchase_delete\":\"Purchase Delete\",\"manage_sales\":\"Manage Sales\",\"sale_create\":\"Sale Create\",\"sale_edit\":\"Sale Edit\",\"sale_delete\":\"Sale Delete\",\"manage_stocks\":\"Manage Stocks\",\"manage_user\":\"Manage User\",\"user_create\":\"User Create\",\"user_edit\":\"User Edit\",\"user_delete\":\"User Delete\",\"user_access\":\"User Access\",\"user_status\":\"User Status\",\"institute_create\":\"Institute Create\",\"institute_edit\":\"Institute Edit\",\"institute_delete\":\"Institute Delete\",\"institute_access\":\"Institute Access\",\"institute_status\":\"Institute Status\",\"manage_account\":\"Manage Accounts\",\"head_create\":\"Head Create\",\"head_edit\":\"Head Edit\",\"head_delete\":\"Head Delete\",\"subhead_create\":\"Subhead Create\",\"subhead_edit\":\"Subhead Edit\",\"subhead_delete\":\"Subhead Delete\",\"particular_create\":\"Particular Create\",\"particular_edit\":\"Particular Edit\",\"particular_delete\":\"Particular Delete\",\"transaction\":\"Transaction\",\"ledger\":\"Ledger\",\"daily_sheet\":\"Daily Sheet\"}', 'dc0b1121a0946355b91e8bddbbf0ffe6'),
(32, 12, 31, NULL, '{\"rice_category\":\"Rice Category\"}', 'da406e5ba774410f48204fcb1fd3b4d4'),
(33, 13, 32, NULL, '{\"setting\":\"Setting\",\"generel_setting\":\"General Setting\",\"generel_setting_update\":\"General Setting Update\",\"raw_category\":\"Raw Category\",\"raw_product\":\"Raw Product\",\"raw_category_create\":\"Raw Category Create\",\"raw_category_delete\":\"Raw Category Delete\",\"raw_product_create\":\"Raw Product Create\",\"raw_product_delete\":\"Raw Product Delete\",\"finish_category\":\"Finish Category\",\"finish_category_create\":\"Finish Category Create\",\"finish_category_delete\":\"Finish Category Delete\",\"finish_product_create\":\"Finish Product Create\",\"finish_product_delete\":\"Finish Product Delete\",\"finish_product\":\"Finish Product\",\"manage_purchase\":\"Manage Purchase\",\"purchase_create\":\"Purchase Create\",\"purchase_edit\":\"Purchase Edit\",\"purchase_delete\":\"Purchase Delete\",\"manage_sales\":\"Manage Sales\",\"sale_create\":\"Sale Create\",\"sale_edit\":\"Sale Edit\",\"sale_delete\":\"Sale Delete\",\"manage_stocks\":\"Manage Stocks\",\"manage_user\":\"Manage User\",\"user_create\":\"User Create\",\"user_edit\":\"User Edit\",\"user_delete\":\"User Delete\",\"user_access\":\"User Access\",\"user_status\":\"User Status\",\"institute_create\":\"Institute Create\",\"institute_edit\":\"Institute Edit\",\"institute_delete\":\"Institute Delete\",\"institute_access\":\"Institute Access\",\"institute_status\":\"Institute Status\",\"manage_account\":\"Manage Accounts\",\"head_create\":\"Head Create\",\"head_edit\":\"Head Edit\",\"head_delete\":\"Head Delete\",\"subhead_create\":\"Subhead Create\",\"subhead_edit\":\"Subhead Edit\",\"subhead_delete\":\"Subhead Delete\",\"particular_create\":\"Particular Create\",\"particular_edit\":\"Particular Edit\",\"particular_delete\":\"Particular Delete\",\"transaction\":\"Transaction\",\"ledger\":\"Ledger\",\"daily_sheet\":\"Daily Sheet\"}', '2383f28135caec532d087d1570948f8f'),
(34, 12, 33, NULL, '{\"setting\":\"Setting\",\"generel_setting\":\"General Setting\",\"generel_setting_update\":\"General Setting Update\"}', '14c195918bd569acd4a0195be055acd4');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bag_bag_color`
--
ALTER TABLE `bag_bag_color`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bag_bag_size`
--
ALTER TABLE `bag_bag_size`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bag_bag_type`
--
ALTER TABLE `bag_bag_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bag_balancesheet`
--
ALTER TABLE `bag_balancesheet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `last_update` (`last_update`),
  ADD KEY `customer_payment_id` (`customer_payment_id`),
  ADD KEY `expense_id` (`expense_id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Indexes for table `bag_empty_bags`
--
ALTER TABLE `bag_empty_bags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bag_empty_bag_stock`
--
ALTER TABLE `bag_empty_bag_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bag_finish_category`
--
ALTER TABLE `bag_finish_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bag_finish_product`
--
ALTER TABLE `bag_finish_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bag_heads`
--
ALTER TABLE `bag_heads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `bag_labor_payment`
--
ALTER TABLE `bag_labor_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bag_labor_payment_item`
--
ALTER TABLE `bag_labor_payment_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bag_particulars`
--
ALTER TABLE `bag_particulars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `bag_purchase`
--
ALTER TABLE `bag_purchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`),
  ADD KEY `invoice_no` (`invoice_no`),
  ADD KEY `head_id` (`head_id`),
  ADD KEY `subhead_id` (`subhead_id`);

--
-- Indexes for table `bag_purchase_item`
--
ALTER TABLE `bag_purchase_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weight_id` (`purchase_id`),
  ADD KEY `category_id` (`raw_category_id`),
  ADD KEY `after_production_id` (`raw_product_id`),
  ADD KEY `product_id` (`particular_id`);

--
-- Indexes for table `bag_raw_category`
--
ALTER TABLE `bag_raw_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bag_raw_product`
--
ALTER TABLE `bag_raw_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `raw_category_id` (`raw_category_id`);

--
-- Indexes for table `bag_sales`
--
ALTER TABLE `bag_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`),
  ADD KEY `invoice_no` (`invoice_no`),
  ADD KEY `head_id` (`head_id`),
  ADD KEY `subhead_id` (`subhead_id`);

--
-- Indexes for table `bag_sales_item`
--
ALTER TABLE `bag_sales_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weight_id` (`sales_id`),
  ADD KEY `category_id` (`finish_category_id`),
  ADD KEY `after_production_id` (`finish_product_id`),
  ADD KEY `product_id` (`particular_id`);

--
-- Indexes for table `bag_subheads`
--
ALTER TABLE `bag_subheads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `head_id` (`head_id`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `bag_tbl_settings`
--
ALTER TABLE `bag_tbl_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bag_transactions`
--
ALTER TABLE `bag_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`bank_account_id`),
  ADD KEY `type` (`type`),
  ADD KEY `ledger_head_id` (`dr_head_id`),
  ADD KEY `transaction_date` (`pay_date`),
  ADD KEY `sub_head_id` (`cr_head_id`),
  ADD KEY `is_edible` (`is_edible`),
  ADD KEY `purchase_id` (`purchase_id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `empty_bag_id` (`empty_bag_id`);

--
-- Indexes for table `business_type`
--
ALTER TABLE `business_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dal_after_production`
--
ALTER TABLE `dal_after_production`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dal_bag_color`
--
ALTER TABLE `dal_bag_color`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dal_bag_size`
--
ALTER TABLE `dal_bag_size`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dal_bag_type`
--
ALTER TABLE `dal_bag_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dal_balancesheet`
--
ALTER TABLE `dal_balancesheet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `last_update` (`last_update`),
  ADD KEY `customer_payment_id` (`customer_payment_id`),
  ADD KEY `expense_id` (`expense_id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Indexes for table `dal_banks`
--
ALTER TABLE `dal_banks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indexes for table `dal_bank_accounts`
--
ALTER TABLE `dal_bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `number` (`account_number`),
  ADD KEY `type` (`account_type`),
  ADD KEY `bank_id` (`bank_id`);

--
-- Indexes for table `dal_categories`
--
ALTER TABLE `dal_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dal_customers`
--
ALTER TABLE `dal_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dal_drawers`
--
ALTER TABLE `dal_drawers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dal_empty_bags`
--
ALTER TABLE `dal_empty_bags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dal_empty_bag_stock`
--
ALTER TABLE `dal_empty_bag_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dal_heads`
--
ALTER TABLE `dal_heads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `dal_labor_payment`
--
ALTER TABLE `dal_labor_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dal_migrations`
--
ALTER TABLE `dal_migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dal_particulars`
--
ALTER TABLE `dal_particulars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `dal_password_resets`
--
ALTER TABLE `dal_password_resets`
  ADD KEY `token` (`token`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `dal_permissions`
--
ALTER TABLE `dal_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dal_price_settings`
--
ALTER TABLE `dal_price_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dal_production_cost`
--
ALTER TABLE `dal_production_cost`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dal_production_cost_item`
--
ALTER TABLE `dal_production_cost_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dal_production_items`
--
ALTER TABLE `dal_production_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `dal_production_orders`
--
ALTER TABLE `dal_production_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_no` (`order_no`);

--
-- Indexes for table `dal_production_settings`
--
ALTER TABLE `dal_production_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dal_production_stocks`
--
ALTER TABLE `dal_production_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weight_id` (`weight_id`);

--
-- Indexes for table `dal_production_stocks_item`
--
ALTER TABLE `dal_production_stocks_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weight_id` (`weight_id`),
  ADD KEY `production_stocks_id` (`production_stocks_id`),
  ADD KEY `sales_challan_id` (`sales_challan_id`);

--
-- Indexes for table `dal_products`
--
ALTER TABLE `dal_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dal_purchase_challan`
--
ALTER TABLE `dal_purchase_challan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dal_sales_challan`
--
ALTER TABLE `dal_sales_challan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dal_sales_challan_item`
--
ALTER TABLE `dal_sales_challan_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dal_stocks`
--
ALTER TABLE `dal_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_challan_id` (`purchase_challan_id`);

--
-- Indexes for table `dal_subheads`
--
ALTER TABLE `dal_subheads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `head_id` (`head_id`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `dal_tbl_settings`
--
ALTER TABLE `dal_tbl_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dal_transactions`
--
ALTER TABLE `dal_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`bank_account_id`),
  ADD KEY `type` (`type`),
  ADD KEY `ledger_head_id` (`dr_head_id`),
  ADD KEY `transaction_date` (`pay_date`),
  ADD KEY `sub_head_id` (`cr_head_id`),
  ADD KEY `is_edible` (`is_edible`),
  ADD KEY `purchase_id` (`purchase_id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `empty_bag_id` (`empty_bag_id`);

--
-- Indexes for table `dal_weights`
--
ALTER TABLE `dal_weights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`),
  ADD KEY `invoice_no` (`invoice_no`),
  ADD KEY `head_id` (`head_id`),
  ADD KEY `subhead_id` (`subhead_id`);

--
-- Indexes for table `dal_weight_items`
--
ALTER TABLE `dal_weight_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weight_id` (`weight_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `after_production_id` (`after_production_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `flour_after_production`
--
ALTER TABLE `flour_after_production`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flour_bag_color`
--
ALTER TABLE `flour_bag_color`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flour_bag_size`
--
ALTER TABLE `flour_bag_size`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flour_bag_type`
--
ALTER TABLE `flour_bag_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flour_balancesheet`
--
ALTER TABLE `flour_balancesheet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `last_update` (`last_update`),
  ADD KEY `customer_payment_id` (`customer_payment_id`),
  ADD KEY `expense_id` (`expense_id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Indexes for table `flour_banks`
--
ALTER TABLE `flour_banks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indexes for table `flour_bank_accounts`
--
ALTER TABLE `flour_bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `number` (`account_number`),
  ADD KEY `type` (`account_type`),
  ADD KEY `bank_id` (`bank_id`);

--
-- Indexes for table `flour_categories`
--
ALTER TABLE `flour_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flour_customers`
--
ALTER TABLE `flour_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flour_drawers`
--
ALTER TABLE `flour_drawers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flour_empty_bags`
--
ALTER TABLE `flour_empty_bags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flour_empty_bag_stock`
--
ALTER TABLE `flour_empty_bag_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flour_heads`
--
ALTER TABLE `flour_heads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `flour_labor_payment`
--
ALTER TABLE `flour_labor_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flour_migrations`
--
ALTER TABLE `flour_migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flour_particulars`
--
ALTER TABLE `flour_particulars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `flour_password_resets`
--
ALTER TABLE `flour_password_resets`
  ADD KEY `token` (`token`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `flour_permissions`
--
ALTER TABLE `flour_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flour_price_settings`
--
ALTER TABLE `flour_price_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flour_production_cost`
--
ALTER TABLE `flour_production_cost`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flour_production_cost_item`
--
ALTER TABLE `flour_production_cost_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flour_production_items`
--
ALTER TABLE `flour_production_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `flour_production_orders`
--
ALTER TABLE `flour_production_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_no` (`order_no`);

--
-- Indexes for table `flour_production_settings`
--
ALTER TABLE `flour_production_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flour_production_stocks`
--
ALTER TABLE `flour_production_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weight_id` (`weight_id`);

--
-- Indexes for table `flour_production_stocks_item`
--
ALTER TABLE `flour_production_stocks_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weight_id` (`weight_id`),
  ADD KEY `production_stocks_id` (`production_stocks_id`),
  ADD KEY `sales_challan_id` (`sales_challan_id`);

--
-- Indexes for table `flour_products`
--
ALTER TABLE `flour_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flour_purchase_challan`
--
ALTER TABLE `flour_purchase_challan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flour_sales_challan`
--
ALTER TABLE `flour_sales_challan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flour_sales_challan_item`
--
ALTER TABLE `flour_sales_challan_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flour_stocks`
--
ALTER TABLE `flour_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_challan_id` (`purchase_challan_id`);

--
-- Indexes for table `flour_subheads`
--
ALTER TABLE `flour_subheads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `head_id` (`head_id`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `flour_tbl_settings`
--
ALTER TABLE `flour_tbl_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flour_transactions`
--
ALTER TABLE `flour_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`bank_account_id`),
  ADD KEY `type` (`type`),
  ADD KEY `ledger_head_id` (`dr_head_id`),
  ADD KEY `transaction_date` (`pay_date`),
  ADD KEY `sub_head_id` (`cr_head_id`),
  ADD KEY `is_edible` (`is_edible`),
  ADD KEY `purchase_id` (`purchase_id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `empty_bag_id` (`empty_bag_id`);

--
-- Indexes for table `flour_weights`
--
ALTER TABLE `flour_weights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`),
  ADD KEY `invoice_no` (`invoice_no`),
  ADD KEY `head_id` (`head_id`),
  ADD KEY `subhead_id` (`subhead_id`);

--
-- Indexes for table `flour_weight_items`
--
ALTER TABLE `flour_weight_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weight_id` (`weight_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `after_production_id` (`after_production_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `heads`
--
ALTER TABLE `heads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`),
  ADD KEY `institute_id` (`institute_id`);

--
-- Indexes for table `institutes`
--
ALTER TABLE `institutes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `mobile` (`mobile`),
  ADD KEY `code` (`code`),
  ADD KEY `email` (`email`),
  ADD KEY `is_fixed` (`is_fixed`);

--
-- Indexes for table `institute_permissions`
--
ALTER TABLE `institute_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `muri_after_production`
--
ALTER TABLE `muri_after_production`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `muri_balancesheet`
--
ALTER TABLE `muri_balancesheet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `last_update` (`last_update`),
  ADD KEY `customer_payment_id` (`customer_payment_id`),
  ADD KEY `expense_id` (`expense_id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Indexes for table `muri_banks`
--
ALTER TABLE `muri_banks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indexes for table `muri_bank_accounts`
--
ALTER TABLE `muri_bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `number` (`account_number`),
  ADD KEY `type` (`account_type`),
  ADD KEY `bank_id` (`bank_id`);

--
-- Indexes for table `muri_categories`
--
ALTER TABLE `muri_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `muri_customers`
--
ALTER TABLE `muri_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `muri_drawers`
--
ALTER TABLE `muri_drawers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `muri_empty_bags`
--
ALTER TABLE `muri_empty_bags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `muri_heads`
--
ALTER TABLE `muri_heads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `muri_particulars`
--
ALTER TABLE `muri_particulars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `muri_price_settings`
--
ALTER TABLE `muri_price_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `muri_production_items`
--
ALTER TABLE `muri_production_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `muri_production_orders`
--
ALTER TABLE `muri_production_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_no` (`order_no`);

--
-- Indexes for table `muri_production_settings`
--
ALTER TABLE `muri_production_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `muri_production_stocks`
--
ALTER TABLE `muri_production_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weight_id` (`weight_id`);

--
-- Indexes for table `muri_production_stocks_item`
--
ALTER TABLE `muri_production_stocks_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weight_id` (`weight_id`),
  ADD KEY `production_stocks_id` (`production_stocks_id`);

--
-- Indexes for table `muri_products`
--
ALTER TABLE `muri_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `muri_stocks`
--
ALTER TABLE `muri_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `muri_subheads`
--
ALTER TABLE `muri_subheads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `head_id` (`head_id`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `muri_tbl_settings`
--
ALTER TABLE `muri_tbl_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `muri_transactions`
--
ALTER TABLE `muri_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`bank_account_id`),
  ADD KEY `type` (`type`),
  ADD KEY `ledger_head_id` (`dr_head_id`),
  ADD KEY `transaction_date` (`pay_date`),
  ADD KEY `sub_head_id` (`cr_head_id`),
  ADD KEY `is_edible` (`is_edible`),
  ADD KEY `purchase_id` (`purchase_id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `empty_bag_id` (`empty_bag_id`);

--
-- Indexes for table `muri_weights`
--
ALTER TABLE `muri_weights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`),
  ADD KEY `invoice_no` (`invoice_no`),
  ADD KEY `head_id` (`head_id`),
  ADD KEY `subhead_id` (`subhead_id`);

--
-- Indexes for table `muri_weight_items`
--
ALTER TABLE `muri_weight_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weight_id` (`weight_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `after_production_id` (`after_production_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `oil_bag_color`
--
ALTER TABLE `oil_bag_color`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oil_bag_size`
--
ALTER TABLE `oil_bag_size`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oil_bag_type`
--
ALTER TABLE `oil_bag_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oil_balancesheet`
--
ALTER TABLE `oil_balancesheet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `last_update` (`last_update`),
  ADD KEY `customer_payment_id` (`customer_payment_id`),
  ADD KEY `expense_id` (`expense_id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Indexes for table `oil_empty_bags`
--
ALTER TABLE `oil_empty_bags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oil_empty_bag_stock`
--
ALTER TABLE `oil_empty_bag_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oil_finish_category`
--
ALTER TABLE `oil_finish_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oil_finish_product`
--
ALTER TABLE `oil_finish_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oil_heads`
--
ALTER TABLE `oil_heads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `oil_labor_payment`
--
ALTER TABLE `oil_labor_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oil_labor_payment_item`
--
ALTER TABLE `oil_labor_payment_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oil_particulars`
--
ALTER TABLE `oil_particulars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `oil_purchase`
--
ALTER TABLE `oil_purchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`),
  ADD KEY `invoice_no` (`invoice_no`),
  ADD KEY `head_id` (`head_id`),
  ADD KEY `subhead_id` (`subhead_id`);

--
-- Indexes for table `oil_purchase_item`
--
ALTER TABLE `oil_purchase_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weight_id` (`purchase_id`),
  ADD KEY `category_id` (`raw_category_id`),
  ADD KEY `after_production_id` (`raw_product_id`),
  ADD KEY `product_id` (`particular_id`);

--
-- Indexes for table `oil_raw_category`
--
ALTER TABLE `oil_raw_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oil_raw_product`
--
ALTER TABLE `oil_raw_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `raw_category_id` (`raw_category_id`);

--
-- Indexes for table `oil_sales`
--
ALTER TABLE `oil_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`),
  ADD KEY `invoice_no` (`invoice_no`),
  ADD KEY `head_id` (`head_id`),
  ADD KEY `subhead_id` (`subhead_id`);

--
-- Indexes for table `oil_sales_item`
--
ALTER TABLE `oil_sales_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weight_id` (`sales_id`),
  ADD KEY `category_id` (`finish_category_id`),
  ADD KEY `after_production_id` (`finish_product_id`),
  ADD KEY `product_id` (`particular_id`);

--
-- Indexes for table `oil_subheads`
--
ALTER TABLE `oil_subheads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `head_id` (`head_id`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `oil_tbl_settings`
--
ALTER TABLE `oil_tbl_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oil_transactions`
--
ALTER TABLE `oil_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`bank_account_id`),
  ADD KEY `type` (`type`),
  ADD KEY `ledger_head_id` (`dr_head_id`),
  ADD KEY `transaction_date` (`pay_date`),
  ADD KEY `sub_head_id` (`cr_head_id`),
  ADD KEY `is_edible` (`is_edible`),
  ADD KEY `purchase_id` (`purchase_id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `empty_bag_id` (`empty_bag_id`);

--
-- Indexes for table `particulars`
--
ALTER TABLE `particulars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`),
  ADD KEY `institute_id` (`institute_id`);

--
-- Indexes for table `rice_after_production`
--
ALTER TABLE `rice_after_production`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rice_balancesheet`
--
ALTER TABLE `rice_balancesheet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `last_update` (`last_update`),
  ADD KEY `customer_payment_id` (`customer_payment_id`),
  ADD KEY `expense_id` (`expense_id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Indexes for table `rice_banks`
--
ALTER TABLE `rice_banks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indexes for table `rice_bank_accounts`
--
ALTER TABLE `rice_bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `number` (`account_number`),
  ADD KEY `type` (`account_type`),
  ADD KEY `bank_id` (`bank_id`);

--
-- Indexes for table `rice_categories`
--
ALTER TABLE `rice_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rice_customers`
--
ALTER TABLE `rice_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rice_drawers`
--
ALTER TABLE `rice_drawers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rice_empty_bags`
--
ALTER TABLE `rice_empty_bags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rice_heads`
--
ALTER TABLE `rice_heads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `rice_particulars`
--
ALTER TABLE `rice_particulars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `rice_price_settings`
--
ALTER TABLE `rice_price_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rice_production_items`
--
ALTER TABLE `rice_production_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `rice_production_orders`
--
ALTER TABLE `rice_production_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_no` (`order_no`);

--
-- Indexes for table `rice_production_settings`
--
ALTER TABLE `rice_production_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rice_production_stocks`
--
ALTER TABLE `rice_production_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weight_id` (`weight_id`);

--
-- Indexes for table `rice_production_stocks_item`
--
ALTER TABLE `rice_production_stocks_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weight_id` (`weight_id`),
  ADD KEY `production_stocks_id` (`production_stocks_id`);

--
-- Indexes for table `rice_products`
--
ALTER TABLE `rice_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rice_stocks`
--
ALTER TABLE `rice_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rice_subheads`
--
ALTER TABLE `rice_subheads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `head_id` (`head_id`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `rice_tbl_settings`
--
ALTER TABLE `rice_tbl_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rice_transactions`
--
ALTER TABLE `rice_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`bank_account_id`),
  ADD KEY `type` (`type`),
  ADD KEY `ledger_head_id` (`dr_head_id`),
  ADD KEY `transaction_date` (`pay_date`),
  ADD KEY `sub_head_id` (`cr_head_id`),
  ADD KEY `is_edible` (`is_edible`),
  ADD KEY `purchase_id` (`purchase_id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `empty_bag_id` (`empty_bag_id`);

--
-- Indexes for table `rice_weights`
--
ALTER TABLE `rice_weights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`),
  ADD KEY `invoice_no` (`invoice_no`),
  ADD KEY `head_id` (`head_id`),
  ADD KEY `subhead_id` (`subhead_id`);

--
-- Indexes for table `rice_weight_items`
--
ALTER TABLE `rice_weight_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `weight_id` (`weight_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `after_production_id` (`after_production_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `subheads`
--
ALTER TABLE `subheads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `head_id` (`head_id`),
  ADD KEY `code` (`code`),
  ADD KEY `institute_id` (`institute_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`bank_account_id`),
  ADD KEY `type` (`type`),
  ADD KEY `ledger_head_id` (`dr_head_id`),
  ADD KEY `transaction_date` (`date`),
  ADD KEY `sub_head_id` (`cr_head_id`),
  ADD KEY `is_edible` (`is_edible`),
  ADD KEY `purchase_id` (`purchase_id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `empty_bag_id` (`purchase_coal_id`),
  ADD KEY `institute_id` (`institute_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bag_bag_color`
--
ALTER TABLE `bag_bag_color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bag_bag_size`
--
ALTER TABLE `bag_bag_size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bag_bag_type`
--
ALTER TABLE `bag_bag_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bag_balancesheet`
--
ALTER TABLE `bag_balancesheet`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bag_empty_bags`
--
ALTER TABLE `bag_empty_bags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bag_empty_bag_stock`
--
ALTER TABLE `bag_empty_bag_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bag_finish_category`
--
ALTER TABLE `bag_finish_category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bag_finish_product`
--
ALTER TABLE `bag_finish_product`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bag_heads`
--
ALTER TABLE `bag_heads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bag_labor_payment`
--
ALTER TABLE `bag_labor_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bag_labor_payment_item`
--
ALTER TABLE `bag_labor_payment_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bag_particulars`
--
ALTER TABLE `bag_particulars`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bag_purchase`
--
ALTER TABLE `bag_purchase`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bag_purchase_item`
--
ALTER TABLE `bag_purchase_item`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bag_raw_category`
--
ALTER TABLE `bag_raw_category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bag_raw_product`
--
ALTER TABLE `bag_raw_product`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bag_sales`
--
ALTER TABLE `bag_sales`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bag_sales_item`
--
ALTER TABLE `bag_sales_item`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bag_subheads`
--
ALTER TABLE `bag_subheads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bag_tbl_settings`
--
ALTER TABLE `bag_tbl_settings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bag_transactions`
--
ALTER TABLE `bag_transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_type`
--
ALTER TABLE `business_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `dal_after_production`
--
ALTER TABLE `dal_after_production`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_bag_color`
--
ALTER TABLE `dal_bag_color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_bag_size`
--
ALTER TABLE `dal_bag_size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_bag_type`
--
ALTER TABLE `dal_bag_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_balancesheet`
--
ALTER TABLE `dal_balancesheet`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_banks`
--
ALTER TABLE `dal_banks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_bank_accounts`
--
ALTER TABLE `dal_bank_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_categories`
--
ALTER TABLE `dal_categories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_customers`
--
ALTER TABLE `dal_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_drawers`
--
ALTER TABLE `dal_drawers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_empty_bags`
--
ALTER TABLE `dal_empty_bags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_empty_bag_stock`
--
ALTER TABLE `dal_empty_bag_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_heads`
--
ALTER TABLE `dal_heads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_labor_payment`
--
ALTER TABLE `dal_labor_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_migrations`
--
ALTER TABLE `dal_migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_particulars`
--
ALTER TABLE `dal_particulars`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_permissions`
--
ALTER TABLE `dal_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_price_settings`
--
ALTER TABLE `dal_price_settings`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_production_cost`
--
ALTER TABLE `dal_production_cost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_production_cost_item`
--
ALTER TABLE `dal_production_cost_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_production_items`
--
ALTER TABLE `dal_production_items`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_production_orders`
--
ALTER TABLE `dal_production_orders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_production_settings`
--
ALTER TABLE `dal_production_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_production_stocks`
--
ALTER TABLE `dal_production_stocks`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_production_stocks_item`
--
ALTER TABLE `dal_production_stocks_item`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_products`
--
ALTER TABLE `dal_products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_purchase_challan`
--
ALTER TABLE `dal_purchase_challan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_sales_challan`
--
ALTER TABLE `dal_sales_challan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_sales_challan_item`
--
ALTER TABLE `dal_sales_challan_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_stocks`
--
ALTER TABLE `dal_stocks`
  MODIFY `id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_subheads`
--
ALTER TABLE `dal_subheads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_tbl_settings`
--
ALTER TABLE `dal_tbl_settings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_transactions`
--
ALTER TABLE `dal_transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_weights`
--
ALTER TABLE `dal_weights`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_weight_items`
--
ALTER TABLE `dal_weight_items`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_after_production`
--
ALTER TABLE `flour_after_production`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_bag_color`
--
ALTER TABLE `flour_bag_color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_bag_size`
--
ALTER TABLE `flour_bag_size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_bag_type`
--
ALTER TABLE `flour_bag_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_balancesheet`
--
ALTER TABLE `flour_balancesheet`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_banks`
--
ALTER TABLE `flour_banks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_bank_accounts`
--
ALTER TABLE `flour_bank_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_categories`
--
ALTER TABLE `flour_categories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_customers`
--
ALTER TABLE `flour_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_drawers`
--
ALTER TABLE `flour_drawers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_empty_bags`
--
ALTER TABLE `flour_empty_bags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_empty_bag_stock`
--
ALTER TABLE `flour_empty_bag_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_heads`
--
ALTER TABLE `flour_heads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_labor_payment`
--
ALTER TABLE `flour_labor_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_migrations`
--
ALTER TABLE `flour_migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_particulars`
--
ALTER TABLE `flour_particulars`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_permissions`
--
ALTER TABLE `flour_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_price_settings`
--
ALTER TABLE `flour_price_settings`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_production_cost`
--
ALTER TABLE `flour_production_cost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_production_cost_item`
--
ALTER TABLE `flour_production_cost_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_production_items`
--
ALTER TABLE `flour_production_items`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_production_orders`
--
ALTER TABLE `flour_production_orders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_production_settings`
--
ALTER TABLE `flour_production_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_production_stocks`
--
ALTER TABLE `flour_production_stocks`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_production_stocks_item`
--
ALTER TABLE `flour_production_stocks_item`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_products`
--
ALTER TABLE `flour_products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_purchase_challan`
--
ALTER TABLE `flour_purchase_challan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_sales_challan`
--
ALTER TABLE `flour_sales_challan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_sales_challan_item`
--
ALTER TABLE `flour_sales_challan_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_stocks`
--
ALTER TABLE `flour_stocks`
  MODIFY `id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_subheads`
--
ALTER TABLE `flour_subheads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_tbl_settings`
--
ALTER TABLE `flour_tbl_settings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_transactions`
--
ALTER TABLE `flour_transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_weights`
--
ALTER TABLE `flour_weights`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_weight_items`
--
ALTER TABLE `flour_weight_items`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `heads`
--
ALTER TABLE `heads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `institutes`
--
ALTER TABLE `institutes`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `institute_permissions`
--
ALTER TABLE `institute_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `muri_after_production`
--
ALTER TABLE `muri_after_production`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `muri_balancesheet`
--
ALTER TABLE `muri_balancesheet`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `muri_banks`
--
ALTER TABLE `muri_banks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `muri_bank_accounts`
--
ALTER TABLE `muri_bank_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `muri_categories`
--
ALTER TABLE `muri_categories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `muri_customers`
--
ALTER TABLE `muri_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `muri_drawers`
--
ALTER TABLE `muri_drawers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `muri_empty_bags`
--
ALTER TABLE `muri_empty_bags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `muri_heads`
--
ALTER TABLE `muri_heads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `muri_particulars`
--
ALTER TABLE `muri_particulars`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `muri_price_settings`
--
ALTER TABLE `muri_price_settings`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `muri_production_items`
--
ALTER TABLE `muri_production_items`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `muri_production_orders`
--
ALTER TABLE `muri_production_orders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `muri_production_settings`
--
ALTER TABLE `muri_production_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `muri_production_stocks`
--
ALTER TABLE `muri_production_stocks`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `muri_production_stocks_item`
--
ALTER TABLE `muri_production_stocks_item`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `muri_products`
--
ALTER TABLE `muri_products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `muri_stocks`
--
ALTER TABLE `muri_stocks`
  MODIFY `id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `muri_subheads`
--
ALTER TABLE `muri_subheads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `muri_tbl_settings`
--
ALTER TABLE `muri_tbl_settings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `muri_transactions`
--
ALTER TABLE `muri_transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `muri_weights`
--
ALTER TABLE `muri_weights`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `muri_weight_items`
--
ALTER TABLE `muri_weight_items`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oil_bag_color`
--
ALTER TABLE `oil_bag_color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oil_bag_size`
--
ALTER TABLE `oil_bag_size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oil_bag_type`
--
ALTER TABLE `oil_bag_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oil_balancesheet`
--
ALTER TABLE `oil_balancesheet`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oil_empty_bags`
--
ALTER TABLE `oil_empty_bags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oil_empty_bag_stock`
--
ALTER TABLE `oil_empty_bag_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oil_finish_category`
--
ALTER TABLE `oil_finish_category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oil_finish_product`
--
ALTER TABLE `oil_finish_product`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oil_heads`
--
ALTER TABLE `oil_heads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oil_labor_payment`
--
ALTER TABLE `oil_labor_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oil_labor_payment_item`
--
ALTER TABLE `oil_labor_payment_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oil_particulars`
--
ALTER TABLE `oil_particulars`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oil_purchase`
--
ALTER TABLE `oil_purchase`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oil_purchase_item`
--
ALTER TABLE `oil_purchase_item`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oil_raw_category`
--
ALTER TABLE `oil_raw_category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oil_raw_product`
--
ALTER TABLE `oil_raw_product`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oil_sales`
--
ALTER TABLE `oil_sales`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oil_sales_item`
--
ALTER TABLE `oil_sales_item`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oil_subheads`
--
ALTER TABLE `oil_subheads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oil_tbl_settings`
--
ALTER TABLE `oil_tbl_settings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oil_transactions`
--
ALTER TABLE `oil_transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `particulars`
--
ALTER TABLE `particulars`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `rice_after_production`
--
ALTER TABLE `rice_after_production`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_balancesheet`
--
ALTER TABLE `rice_balancesheet`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_banks`
--
ALTER TABLE `rice_banks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_bank_accounts`
--
ALTER TABLE `rice_bank_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_categories`
--
ALTER TABLE `rice_categories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_customers`
--
ALTER TABLE `rice_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_drawers`
--
ALTER TABLE `rice_drawers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_empty_bags`
--
ALTER TABLE `rice_empty_bags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_heads`
--
ALTER TABLE `rice_heads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_particulars`
--
ALTER TABLE `rice_particulars`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_price_settings`
--
ALTER TABLE `rice_price_settings`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_production_items`
--
ALTER TABLE `rice_production_items`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_production_orders`
--
ALTER TABLE `rice_production_orders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_production_settings`
--
ALTER TABLE `rice_production_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_production_stocks`
--
ALTER TABLE `rice_production_stocks`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_production_stocks_item`
--
ALTER TABLE `rice_production_stocks_item`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_products`
--
ALTER TABLE `rice_products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_stocks`
--
ALTER TABLE `rice_stocks`
  MODIFY `id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_subheads`
--
ALTER TABLE `rice_subheads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_tbl_settings`
--
ALTER TABLE `rice_tbl_settings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_transactions`
--
ALTER TABLE `rice_transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_weights`
--
ALTER TABLE `rice_weights`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_weight_items`
--
ALTER TABLE `rice_weight_items`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subheads`
--
ALTER TABLE `subheads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `user_permissions`
--
ALTER TABLE `user_permissions`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
