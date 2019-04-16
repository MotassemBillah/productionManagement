-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2019 at 08:10 AM
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
  `prefix` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `_key` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Table structure for table `inv_category`
--

CREATE TABLE `inv_category` (
  `id` int(10) NOT NULL,
  `business_type_id` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `description` text,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inv_product`
--

CREATE TABLE `inv_product` (
  `id` int(10) NOT NULL,
  `business_type_id` int(11) DEFAULT NULL,
  `inv_category_id` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `size` varchar(100) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `grade` varchar(50) DEFAULT NULL,
  `printed` varchar(50) DEFAULT NULL,
  `laminated` varchar(50) DEFAULT NULL,
  `liner` varchar(50) DEFAULT NULL,
  `buy_price` double DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inv_purchase`
--

CREATE TABLE `inv_purchase` (
  `id` int(11) NOT NULL,
  `invoice_date` date DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `challan_no` varchar(50) DEFAULT NULL,
  `from_head_id` int(11) DEFAULT NULL,
  `from_subhead_id` int(11) DEFAULT NULL,
  `from_particular_id` int(11) DEFAULT NULL,
  `to_head_id` int(11) DEFAULT NULL,
  `to_subhead_id` int(11) DEFAULT NULL,
  `to_particular_id` int(11) DEFAULT NULL,
  `invoice_amount` double DEFAULT NULL,
  `transport_cost` double DEFAULT NULL,
  `labor_cost` double DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `discount` enum('No','Yes') NOT NULL DEFAULT 'No',
  `discount_amount` double DEFAULT NULL,
  `net_amount` double DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `due_amount` double DEFAULT NULL,
  `note` text,
  `process_status` enum('Pending','Processed') NOT NULL DEFAULT 'Pending',
  `payment_status` enum('Not Paid','Partial Paid','Paid') NOT NULL DEFAULT 'Not Paid',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inv_sales`
--

CREATE TABLE `inv_sales` (
  `id` int(11) NOT NULL,
  `invoice_date` date DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `challan_no` varchar(50) DEFAULT NULL,
  `from_head_id` int(11) DEFAULT NULL,
  `from_subhead_id` int(11) DEFAULT NULL,
  `from_particular_id` int(11) DEFAULT NULL,
  `to_head_id` int(11) DEFAULT NULL,
  `to_subhead_id` int(11) DEFAULT NULL,
  `to_particular_id` int(11) DEFAULT NULL,
  `invoice_amount` double DEFAULT NULL,
  `transport_cost` double DEFAULT NULL,
  `labor_cost` double DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `discount` enum('No','Yes') NOT NULL DEFAULT 'No',
  `discount_amount` double DEFAULT NULL,
  `net_amount` double DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `due_amount` double DEFAULT NULL,
  `note` text,
  `process_status` enum('Pending','Processed') NOT NULL DEFAULT 'Pending',
  `payment_status` enum('Not Paid','Partial Paid','Paid') NOT NULL DEFAULT 'Not Paid',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inv_transactions`
--

CREATE TABLE `inv_transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `pay_date` date DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `from_head_id` int(11) DEFAULT NULL,
  `from_subhead_id` int(11) DEFAULT NULL,
  `from_particular_id` int(11) DEFAULT NULL,
  `to_head_id` int(11) DEFAULT NULL,
  `to_subhead_id` int(11) DEFAULT NULL,
  `to_particular_id` int(11) DEFAULT NULL,
  `type` enum('C','D') DEFAULT NULL,
  `voucher_type` enum('Payment Voucher','Receive Voucher','Purchase Voucher','Sales Voucher','Due Voucher','Journal Voucher') DEFAULT NULL,
  `pay_method` enum('No Payment','Bank Payment','Cash Payment') DEFAULT NULL,
  `bank_account_id` int(10) DEFAULT NULL,
  `check_no` varchar(100) DEFAULT NULL,
  `description` text,
  `note` text,
  `by_whom` varchar(100) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `debit` double DEFAULT NULL,
  `credit` double DEFAULT NULL,
  `is_edible` tinyint(2) NOT NULL DEFAULT '0',
  `is_dbl` tinyint(2) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `account_type` enum('CC loan A/C','Savings A/C','Current A/C','LC A/C','LTR A/C','Loan A/C (Monthly Installment)') DEFAULT NULL,
  `cc_loan_amount` double DEFAULT NULL,
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
-- Table structure for table `rental_building`
--

CREATE TABLE `rental_building` (
  `id` int(11) NOT NULL,
  `building_type` enum('Dokan','House','Others','Hostel','Godown') DEFAULT NULL,
  `building_name` varchar(300) DEFAULT NULL,
  `building_no` varchar(200) DEFAULT NULL,
  `mobile_no` varchar(25) DEFAULT NULL,
  `address` text,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rental_flat`
--

CREATE TABLE `rental_flat` (
  `id` int(11) NOT NULL,
  `building_id` int(11) DEFAULT NULL,
  `floor_id` int(11) DEFAULT NULL,
  `flat_name` varchar(300) DEFAULT NULL,
  `description` text,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rental_floor`
--

CREATE TABLE `rental_floor` (
  `id` int(11) NOT NULL,
  `building_id` int(11) DEFAULT NULL,
  `floor_name` varchar(300) DEFAULT NULL,
  `description` text,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rental_party`
--

CREATE TABLE `rental_party` (
  `id` int(11) NOT NULL,
  `party_name` varchar(300) DEFAULT NULL,
  `mobile_no` varchar(25) DEFAULT NULL,
  `address` text,
  `building_id` int(11) DEFAULT NULL,
  `floor_id` int(11) DEFAULT NULL,
  `flat_id` int(11) DEFAULT NULL,
  `rental_year` double DEFAULT NULL,
  `rental_month` double DEFAULT NULL,
  `monthly_rent` double DEFAULT NULL,
  `description` text,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `title` varchar(500) DEFAULT NULL,
  `owner` varchar(300) DEFAULT NULL,
  `logo` varchar(300) DEFAULT NULL,
  `favicon` varchar(300) DEFAULT NULL,
  `address` text,
  `description` text,
  `email` varchar(50) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `other_contact` text,
  `phone` varchar(15) DEFAULT NULL,
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
-- Indexes for table `inv_category`
--
ALTER TABLE `inv_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_type_id` (`business_type_id`);

--
-- Indexes for table `inv_product`
--
ALTER TABLE `inv_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_type_id` (`business_type_id`),
  ADD KEY `inv_category_id` (`inv_category_id`);

--
-- Indexes for table `inv_purchase`
--
ALTER TABLE `inv_purchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_head_id` (`from_head_id`),
  ADD KEY `from_subhead_id` (`from_subhead_id`),
  ADD KEY `from_particular_id` (`from_particular_id`),
  ADD KEY `to_head_id` (`to_head_id`),
  ADD KEY `to_subhead_id` (`to_subhead_id`),
  ADD KEY `to_particular_id` (`to_particular_id`);

--
-- Indexes for table `inv_sales`
--
ALTER TABLE `inv_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_head_id` (`from_head_id`),
  ADD KEY `from_subhead_id` (`from_subhead_id`),
  ADD KEY `from_particular_id` (`from_particular_id`),
  ADD KEY `to_head_id` (`to_head_id`),
  ADD KEY `to_subhead_id` (`to_subhead_id`),
  ADD KEY `to_particular_id` (`to_particular_id`);

--
-- Indexes for table `inv_transactions`
--
ALTER TABLE `inv_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_id` (`purchase_id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `from_head_id` (`from_head_id`),
  ADD KEY `from_subhead_id` (`from_subhead_id`),
  ADD KEY `from_particular_id` (`from_particular_id`),
  ADD KEY `to_head_id` (`to_head_id`),
  ADD KEY `to_subhead_id` (`to_subhead_id`),
  ADD KEY `to_particular_id` (`to_particular_id`),
  ADD KEY `bank_account_id` (`bank_account_id`);

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
-- Indexes for table `rental_building`
--
ALTER TABLE `rental_building`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rental_flat`
--
ALTER TABLE `rental_flat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rental_floor`
--
ALTER TABLE `rental_floor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rental_party`
--
ALTER TABLE `rental_party`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `heads`
--
ALTER TABLE `heads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `institutes`
--
ALTER TABLE `institutes`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `institute_permissions`
--
ALTER TABLE `institute_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_category`
--
ALTER TABLE `inv_category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_product`
--
ALTER TABLE `inv_product`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_purchase`
--
ALTER TABLE `inv_purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_sales`
--
ALTER TABLE `inv_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_transactions`
--
ALTER TABLE `inv_transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rental_building`
--
ALTER TABLE `rental_building`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rental_flat`
--
ALTER TABLE `rental_flat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rental_floor`
--
ALTER TABLE `rental_floor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rental_party`
--
ALTER TABLE `rental_party`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_permissions`
--
ALTER TABLE `user_permissions`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
