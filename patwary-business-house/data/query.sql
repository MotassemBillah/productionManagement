---15.01.19----
DROP TABLE IF EXISTS `rice_stocks`;
CREATE TABLE `rice_stocks` (
  `id` int(15) UNSIGNED NOT NULL,
  `purchase_challan_id` int(15) DEFAULT NULL,
  `production_id` int(20) DEFAULT NULL,
  `production_no_id` int(30) DEFAULT NULL,
  `category_id` int(15) DEFAULT NULL,
  `product_id` int(15) DEFAULT NULL,
  `type` enum('in','out','process') DEFAULT NULL,
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

ALTER TABLE `rice_stocks`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `rice_stocks`
  MODIFY `id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT;

--- 16.01.19---

RENAME TABLE `patwary_business_house`.`rice_production_orders` TO `patwary_business_house`.`rice_production`;

DROP TABLE IF EXISTS `rice_purchase_challan`;
CREATE TABLE `rice_purchase_challan` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `supplier_head` int(11) DEFAULT NULL,
  `supplier_subhead` int(11) DEFAULT NULL,
  `supplier_particular` int(11) DEFAULT NULL,
  `challan_no` varchar(100) DEFAULT NULL,
  `voucher_no` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `port_weight` double DEFAULT NULL,
  `scale_weight` double DEFAULT NULL,
  `bag_quantity` double DEFAULT NULL,
  `transport_agency` varchar(300) DEFAULT NULL,
  `truck_no` varchar(100) DEFAULT NULL,
  `truck_rent` double DEFAULT NULL,
  `comments` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `rice_purchase_challan`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `rice_purchase_challan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--- 20.01.19 -----

ALTER TABLE `rice_purchase_challan` ADD `institute_id` INT NULL DEFAULT NULL AFTER `id`;
ALTER TABLE `rice_production_stocks` ADD `institute_id` INT NULL DEFAULT NULL AFTER `id`;
ALTER TABLE `rice_production_stocks_item` ADD `institute_id` INT NULL DEFAULT NULL AFTER `id`;
ALTER TABLE `rice_production` ADD `institute_id` INT NULL DEFAULT NULL AFTER `id`;
TER TABLE `rice_production_items` ADD `institute_id` INT NULL DEFAULT NULL AFTER `id`;
ALTER TABLE `rice_production_stocks_item` ADD `sales_challan_id` INT NULL DEFAULT NULL AFTER `production_stocks_id`;

------------
-- Rakib
--20/1/19
------------
DROP TABLE IF EXISTS `inv_purchase`;
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
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `inv_purchase_cart`;
CREATE TABLE `inv_purchase_cart` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `inv_purchase_items`;
CREATE TABLE `inv_purchase_items` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `inv_sale`;
CREATE TABLE `inv_sale` (
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
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `inv_sale_cart`;
CREATE TABLE `inv_sale_cart` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `inv_sale_items`;
CREATE TABLE `inv_sale_items` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `inv_transactions`;
CREATE TABLE `inv_transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
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
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `inv_purchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_head_id` (`from_head_id`),
  ADD KEY `from_subhead_id` (`from_subhead_id`),
  ADD KEY `from_particular_id` (`from_particular_id`),
  ADD KEY `to_head_id` (`to_head_id`),
  ADD KEY `to_subhead_id` (`to_subhead_id`),
  ADD KEY `to_particular_id` (`to_particular_id`);

ALTER TABLE `inv_purchase_cart`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `inv_purchase_items`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `inv_sale`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_head_id` (`from_head_id`),
  ADD KEY `from_subhead_id` (`from_subhead_id`),
  ADD KEY `from_particular_id` (`from_particular_id`),
  ADD KEY `to_head_id` (`to_head_id`),
  ADD KEY `to_subhead_id` (`to_subhead_id`),
  ADD KEY `to_particular_id` (`to_particular_id`);

ALTER TABLE `inv_sale_cart`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `inv_sale_items`
  ADD PRIMARY KEY (`id`);

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

ALTER TABLE `inv_purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `inv_purchase_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `inv_purchase_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `inv_sale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `inv_sale_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `inv_sale_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `inv_transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `transactions` 
ADD `is_deleted` TINYINT(2) NOT NULL DEFAULT '0' AFTER `modified_by`, 
ADD `deleted_by` INT NULL DEFAULT NULL AFTER `is_deleted`, 
ADD `deleted_at` DATETIME NULL DEFAULT NULL AFTER `deleted_by`;

ALTER TABLE `transactions` ADD `pst_type` VARCHAR(20) NULL DEFAULT NULL AFTER `institute_id`;

------------
-- Rakib
--21/1/19
------------
ALTER TABLE `inv_sale_items` CHANGE `purchase_id` `sale_id` INT(11) NULL DEFAULT NULL;

----- 24.01.2019----
-- By Mothaar ----

DROP TABLE IF EXISTS `flour_drawers`;
CREATE TABLE `flour_drawers` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
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
-- Table structure for table `flour_production`
--

DROP TABLE IF EXISTS `flour_production`;
CREATE TABLE `flour_production` (
  `id` int(10) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
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
-- Table structure for table `flour_production_items`
--

DROP TABLE IF EXISTS `flour_production_items`;
CREATE TABLE `flour_production_items` (
  `id` int(10) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
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
-- Table structure for table `flour_production_stocks`
--

DROP TABLE IF EXISTS `flour_production_stocks`;
CREATE TABLE `flour_production_stocks` (
  `id` int(15) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
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

DROP TABLE IF EXISTS `flour_production_stocks_item`;
CREATE TABLE `flour_production_stocks_item` (
  `id` int(15) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `production_stocks_id` int(11) DEFAULT NULL,
  `sales_challan_id` int(11) DEFAULT NULL,
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
-- Table structure for table `flour_purchase_challan`
--

DROP TABLE IF EXISTS `flour_purchase_challan`;
CREATE TABLE `flour_purchase_challan` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `supplier_head` int(11) DEFAULT NULL,
  `supplier_subhead` int(11) DEFAULT NULL,
  `supplier_particular` int(11) DEFAULT NULL,
  `challan_no` varchar(100) DEFAULT NULL,
  `voucher_no` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `port_weight` double DEFAULT NULL,
  `scale_weight` double DEFAULT NULL,
  `bag_quantity` double DEFAULT NULL,
  `transport_agency` varchar(300) DEFAULT NULL,
  `truck_no` varchar(100) DEFAULT NULL,
  `truck_rent` double DEFAULT NULL,
  `comments` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_sales_challan`
--

DROP TABLE IF EXISTS `flour_sales_challan`;
CREATE TABLE `flour_sales_challan` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `voucher_no` varchar(100) DEFAULT NULL,
  `challan_no` varchar(100) DEFAULT NULL,
  `supplier_head` int(11) DEFAULT NULL,
  `supplier_subhead` int(11) DEFAULT NULL,
  `supplier_particular` int(11) DEFAULT NULL,
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

DROP TABLE IF EXISTS `flour_sales_challan_item`;
CREATE TABLE `flour_sales_challan_item` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `sales_challan_id` int(11) DEFAULT NULL,
  `challan_no` varchar(100) DEFAULT NULL,
  `voucher_no` varchar(100) DEFAULT NULL,
  `supplier_head` int(11) DEFAULT NULL,
  `supplier_subhead` int(11) DEFAULT NULL,
  `supplier_particular` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `scale_weight` double NOT NULL,
  `bag_quantity` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flour_stocks`
--

DROP TABLE IF EXISTS `flour_stocks`;
CREATE TABLE `flour_stocks` (
  `id` int(15) UNSIGNED NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `purchase_challan_id` int(15) DEFAULT NULL,
  `production_id` int(20) DEFAULT NULL,
  `production_no_id` int(30) DEFAULT NULL,
  `category_id` int(15) DEFAULT NULL,
  `product_id` int(15) DEFAULT NULL,
  `type` enum('in','out','process') DEFAULT NULL,
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `flour_drawers`
--
ALTER TABLE `flour_drawers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flour_production`
--
ALTER TABLE `flour_production`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_no` (`order_no`);

--
-- Indexes for table `flour_production_items`
--
ALTER TABLE `flour_production_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `product_id` (`product_id`);

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
  ADD KEY `production_stocks_id` (`production_stocks_id`);

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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `flour_drawers`
--
ALTER TABLE `flour_drawers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_production`
--
ALTER TABLE `flour_production`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flour_production_items`
--
ALTER TABLE `flour_production_items`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

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


----- Rice Mill -----

DROP TABLE IF EXISTS `rice_drawers`;
CREATE TABLE `rice_drawers` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
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
-- Table structure for table `rice_production`
--

DROP TABLE IF EXISTS `rice_production`;
CREATE TABLE `rice_production` (
  `id` int(10) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
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
-- Table structure for table `rice_production_items`
--

DROP TABLE IF EXISTS `rice_production_items`;
CREATE TABLE `rice_production_items` (
  `id` int(10) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
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
-- Table structure for table `rice_production_stocks`
--

DROP TABLE IF EXISTS `rice_production_stocks`;
CREATE TABLE `rice_production_stocks` (
  `id` int(15) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
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

DROP TABLE IF EXISTS `rice_production_stocks_item`;
CREATE TABLE `rice_production_stocks_item` (
  `id` int(15) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `production_stocks_id` int(11) DEFAULT NULL,
  `sales_challan_id` int(11) DEFAULT NULL,
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
-- Table structure for table `rice_purchase_challan`
--

DROP TABLE IF EXISTS `rice_purchase_challan`;
CREATE TABLE `rice_purchase_challan` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `supplier_head` int(11) DEFAULT NULL,
  `supplier_subhead` int(11) DEFAULT NULL,
  `supplier_particular` int(11) DEFAULT NULL,
  `challan_no` varchar(100) DEFAULT NULL,
  `voucher_no` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `port_weight` double DEFAULT NULL,
  `scale_weight` double DEFAULT NULL,
  `bag_quantity` double DEFAULT NULL,
  `transport_agency` varchar(300) DEFAULT NULL,
  `truck_no` varchar(100) DEFAULT NULL,
  `truck_rent` double DEFAULT NULL,
  `comments` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rice_sales_challan`
--

DROP TABLE IF EXISTS `rice_sales_challan`;
CREATE TABLE `rice_sales_challan` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `voucher_no` varchar(100) DEFAULT NULL,
  `challan_no` varchar(100) DEFAULT NULL,
  `supplier_head` int(11) DEFAULT NULL,
  `supplier_subhead` int(11) DEFAULT NULL,
  `supplier_particular` int(11) DEFAULT NULL,
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
-- Table structure for table `rice_sales_challan_item`
--

DROP TABLE IF EXISTS `rice_sales_challan_item`;
CREATE TABLE `rice_sales_challan_item` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `sales_challan_id` int(11) DEFAULT NULL,
  `challan_no` varchar(100) DEFAULT NULL,
  `voucher_no` varchar(100) DEFAULT NULL,
  `supplier_head` int(11) DEFAULT NULL,
  `supplier_subhead` int(11) DEFAULT NULL,
  `supplier_particular` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `scale_weight` double NOT NULL,
  `bag_quantity` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rice_stocks`
--

DROP TABLE IF EXISTS `rice_stocks`;
CREATE TABLE `rice_stocks` (
  `id` int(15) UNSIGNED NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `purchase_challan_id` int(15) DEFAULT NULL,
  `production_id` int(20) DEFAULT NULL,
  `production_no_id` int(30) DEFAULT NULL,
  `category_id` int(15) DEFAULT NULL,
  `product_id` int(15) DEFAULT NULL,
  `type` enum('in','out','process') DEFAULT NULL,
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rice_drawers`
--
ALTER TABLE `rice_drawers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rice_production`
--
ALTER TABLE `rice_production`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_no` (`order_no`);

--
-- Indexes for table `rice_production_items`
--
ALTER TABLE `rice_production_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `product_id` (`product_id`);

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
-- Indexes for table `rice_purchase_challan`
--
ALTER TABLE `rice_purchase_challan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rice_sales_challan`
--
ALTER TABLE `rice_sales_challan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rice_sales_challan_item`
--
ALTER TABLE `rice_sales_challan_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rice_stocks`
--
ALTER TABLE `rice_stocks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rice_drawers`
--
ALTER TABLE `rice_drawers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_production`
--
ALTER TABLE `rice_production`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_production_items`
--
ALTER TABLE `rice_production_items`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `rice_purchase_challan`
--
ALTER TABLE `rice_purchase_challan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_sales_challan`
--
ALTER TABLE `rice_sales_challan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_sales_challan_item`
--
ALTER TABLE `rice_sales_challan_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rice_stocks`
--
ALTER TABLE `rice_stocks`
  MODIFY `id` int(15) UNSIGNED NOT NULL AUTO_INCREMENT;

------------
-- Rakib
--27/1/19
------------
ALTER TABLE `inv_purchase` ADD `other_cost` DOUBLE NULL DEFAULT NULL AFTER `labor_cost`;
ALTER TABLE `inv_purchase` ADD `avg_cost` DOUBLE NULL DEFAULT NULL AFTER `other_cost`;
ALTER TABLE `inv_purchase_cart` ADD `institute_id` INT NULL DEFAULT NULL AFTER `id`; 
ALTER TABLE `inv_purchase_cart` ADD `business_type_id` INT NULL DEFAULT NULL AFTER `institute_id`;
ALTER TABLE `inv_purchase_items` ADD `institute_id` INT NULL DEFAULT NULL AFTER `id`; 
ALTER TABLE `inv_purchase_items` ADD `business_type_id` INT NULL DEFAULT NULL AFTER `institute_id`;
ALTER TABLE `inv_purchase_items` ADD `avg_price` DOUBLE NULL DEFAULT NULL AFTER `amount`;
ALTER TABLE `inv_product` ADD `pavg_price` DOUBLE NULL DEFAULT NULL AFTER `buy_price`; 
ALTER TABLE `inv_product` ADD `savg_price` DOUBLE NULL DEFAULT NULL AFTER `pavg_price`;

CREATE TABLE `inv_avg_price` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `stock_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `avg_price` double DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `inv_avg_price`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `inv_avg_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `inv_stocks` (
  `id` int(11) NOT NULL,
  `stock_type` varchar(20) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `inv_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_id` (`purchase_id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `product_id` (`product_id`);

ALTER TABLE `inv_stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

------------
-- Rakib
--31/1/19
------------
ALTER TABLE `inv_sale` 
ADD `other_cost` DOUBLE NULL DEFAULT NULL AFTER `labor_cost`, 
ADD `avg_cost` DOUBLE NULL DEFAULT NULL AFTER `other_cost`;
ALTER TABLE `inv_sale_cart` 
ADD `institute_id` INT NULL DEFAULT NULL AFTER `id`, 
ADD `business_type_id` INT NULL DEFAULT NULL AFTER `institute_id`;
ALTER TABLE `inv_sale_items` 
ADD `institute_id` INT NULL DEFAULT NULL AFTER `id`, 
ADD `business_type_id` INT NULL DEFAULT NULL AFTER `institute_id`;
ALTER TABLE `inv_sale_items` ADD `avg_price` DOUBLE NULL DEFAULT NULL AFTER `amount`;

--------05.02.19----
----By Motahar------

ALTER TABLE `rice_stocks` CHANGE `type` `type` ENUM('in','out','process','os','tin','tout') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `rice_stocks` ADD `godown_id` INT NULL DEFAULT NULL AFTER `_key`, ADD `from_godown_id` INT NULL DEFAULT NULL AFTER `godown_id`, ADD `to_godown_id` INT NULL DEFAULT NULL AFTER `from_godown_id`;

ALTER TABLE `flour_stocks` CHANGE `type` `type` ENUM('in','out','process','os','tin','tout') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `flour_stocks` ADD `godown_id` INT NULL DEFAULT NULL AFTER `_key`, ADD `from_godown_id` INT NULL DEFAULT NULL AFTER `godown_id`, ADD `to_godown_id` INT NULL DEFAULT NULL AFTER `from_godown_id`;

--------06.02.15----
----By Rakib Hasan------
ALTER TABLE `inv_stocks` ADD `subhead_id` INT NULL DEFAULT NULL AFTER `id`, ADD `particular_id` INT NULL DEFAULT NULL AFTER `subhead_id`;

--- 06.02.19----
----- By Motahar -----

CREATE TABLE `rice_godowns` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `rice_godowns`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `rice_godowns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `rice_emptybag_setting` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `weight` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `rice_emptybag_setting`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `rice_emptybag_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `flour_emptybag_setting` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `weight` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `flour_emptybag_setting`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `flour_emptybag_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `flour_godowns` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `flour_godowns`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `flour_godowns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `rice_purchase_challan` CHANGE `voucher_no` `slip_no` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `rice_purchase_challan` CHANGE `port_weight` `challan_weight` DOUBLE NULL DEFAULT NULL;
ALTER TABLE `flour_purchase_challan` CHANGE `port_weight` `challan_weight` DOUBLE NULL DEFAULT NULL;
ALTER TABLE `flour_purchase_challan` CHANGE `voucher_no` `slip_no` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `rice_purchase_challan` ADD `net_weight` DOUBLE NULL DEFAULT NULL AFTER `bag_quantity`, ADD `per_kg_price` DOUBLE NULL DEFAULT NULL AFTER `net_weight`, ADD `total_price` DOUBLE NULL DEFAULT NULL AFTER `per_kg_price`;
ALTER TABLE `flour_purchase_challan` ADD `net_weight` DOUBLE NULL DEFAULT NULL AFTER `bag_quantity`, ADD `per_kg_price` DOUBLE NULL DEFAULT NULL AFTER `net_weight`, ADD `total_price` DOUBLE NULL DEFAULT NULL AFTER `per_kg_price`;

----13.02.19------
---By Motahar----

DROP TABLE IF EXISTS `dal_purchase_challan`;
CREATE TABLE `dal_purchase_challan` (
  `id` int(20) NOT NULL,
  `date` date DEFAULT NULL,
  `type` enum('in','out','os') DEFAULT NULL,
  `production_type` varchar(200) DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `order_no` varchar(50) DEFAULT NULL,
  `challan_no` varchar(50) DEFAULT NULL,
  `supplier_head` int(11) DEFAULT NULL,
  `supplier_subhead` int(11) DEFAULT NULL,
  `supplier_particular` int(11) DEFAULT NULL,
  `truck_no` varchar(200) DEFAULT NULL,
  `transport_info` varchar(300) DEFAULT NULL,
  `total_quantity` double DEFAULT NULL,
  `process_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_purchase_challan_item`
--

DROP TABLE IF EXISTS `dal_purchase_challan_item`;
CREATE TABLE `dal_purchase_challan_item` (
  `id` int(20) NOT NULL,
  `date` date DEFAULT NULL,
  `purchase_challan_id` int(11) DEFAULT NULL,
  `type` enum('in','out','os') DEFAULT NULL,
  `production_type` varchar(200) DEFAULT NULL,
  `order_no` varchar(50) DEFAULT NULL,
  `invoice_no` varchar(100) DEFAULT NULL,
  `challan_no` varchar(51) DEFAULT NULL,
  `supplier_head` int(15) DEFAULT NULL,
  `supplier_subhead` int(15) DEFAULT NULL,
  `supplier_particular` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
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

DROP TABLE IF EXISTS `dal_sales_challan`;
CREATE TABLE `dal_sales_challan` (
  `id` int(20) NOT NULL,
  `date` date DEFAULT NULL,
  `type` enum('in','out','os') DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `order_no` varchar(50) DEFAULT NULL,
  `challan_no` varchar(50) DEFAULT NULL,
  `transport_info` varchar(300) DEFAULT NULL,
  `supplier_head` int(11) DEFAULT NULL,
  `supplier_subhead` int(11) DEFAULT NULL,
  `supplier_particular` int(11) DEFAULT NULL,
  `truck_no` varchar(200) DEFAULT NULL,
  `total_quantity` double DEFAULT NULL,
  `process_status` tinyint(4) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_sales_challan_item`
--

DROP TABLE IF EXISTS `dal_sales_challan_item`;
CREATE TABLE `dal_sales_challan_item` (
  `id` int(20) NOT NULL,
  `date` date DEFAULT NULL,
  `sales_challan_id` int(11) DEFAULT NULL,
  `type` enum('in','out','os') DEFAULT NULL,
  `order_no` varchar(50) DEFAULT NULL,
  `invoice_no` varchar(200) DEFAULT NULL,
  `challan_no` varchar(51) DEFAULT NULL,
  `supplier_head` int(15) DEFAULT NULL,
  `supplier_subhead` int(15) DEFAULT NULL,
  `supplier_particular` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dal_purchase_challan`
--
ALTER TABLE `dal_purchase_challan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`),
  ADD KEY `invoice_no` (`invoice_no`),
  ADD KEY `head_id` (`supplier_head`),
  ADD KEY `subhead_id` (`supplier_subhead`);

--
-- Indexes for table `dal_purchase_challan_item`
--
ALTER TABLE `dal_purchase_challan_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dal_sales_challan`
--
ALTER TABLE `dal_sales_challan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`),
  ADD KEY `invoice_no` (`invoice_no`),
  ADD KEY `head_id` (`supplier_head`),
  ADD KEY `subhead_id` (`supplier_subhead`);

--
-- Indexes for table `dal_sales_challan_item`
--
ALTER TABLE `dal_sales_challan_item`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dal_purchase_challan`
--
ALTER TABLE `dal_purchase_challan`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_purchase_challan_item`
--
ALTER TABLE `dal_purchase_challan_item`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_sales_challan`
--
ALTER TABLE `dal_sales_challan`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_sales_challan_item`
--
ALTER TABLE `dal_sales_challan_item`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--------17.02.19----
----By Rakib Hasan------
ALTER TABLE `inv_avg_price` ADD `purchase_return_id` INT NULL DEFAULT NULL AFTER `sale_id`, ADD `sale_return_id` INT NULL DEFAULT NULL AFTER `purchase_return_id`;
ALTER TABLE `inv_stocks` ADD `purchase_return_id` INT NULL DEFAULT NULL AFTER `sale_id`, ADD `sale_return_id` INT NULL DEFAULT NULL AFTER `purchase_return_id`;
ALTER TABLE `transactions` ADD `purchase_return_id` INT NULL DEFAULT NULL AFTER `sale_id`, ADD `sale_return_id` INT NULL DEFAULT NULL AFTER `purchase_return_id`;

DROP TABLE IF EXISTS `inv_purchase_return`;
CREATE TABLE `inv_purchase_return` (
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
  `other_cost` double DEFAULT NULL,
  `avg_cost` double DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `discount` enum('No','Yes') NOT NULL DEFAULT 'No',
  `discount_amount` double DEFAULT NULL,
  `net_amount` double DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `due_amount` double DEFAULT NULL,
  `note` text,
  `process_status` enum('Pending','Processed') NOT NULL DEFAULT 'Pending',
  `payment_status` enum('Not Paid','Partial Paid','Paid') NOT NULL DEFAULT 'Not Paid',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `inv_purchase_return_cart`;
CREATE TABLE `inv_purchase_return_cart` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `business_type_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `inv_purchase_return_items`;
CREATE TABLE `inv_purchase_return_items` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `business_type_id` int(11) DEFAULT NULL,
  `purchase_return_id` int(11) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `avg_price` double DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `inv_purchase_return`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_head_id` (`from_head_id`),
  ADD KEY `from_subhead_id` (`from_subhead_id`),
  ADD KEY `from_particular_id` (`from_particular_id`),
  ADD KEY `to_head_id` (`to_head_id`),
  ADD KEY `to_subhead_id` (`to_subhead_id`),
  ADD KEY `to_particular_id` (`to_particular_id`);

ALTER TABLE `inv_purchase_return_cart`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `inv_purchase_return_items`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `inv_purchase_return`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `inv_purchase_return_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `inv_purchase_return_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

DROP TABLE IF EXISTS `inv_sale_return`;
CREATE TABLE `inv_sale_return` (
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
  `other_cost` double DEFAULT NULL,
  `avg_cost` double DEFAULT NULL,
  `total_amount` double DEFAULT NULL,
  `discount` enum('No','Yes') NOT NULL DEFAULT 'No',
  `discount_amount` double DEFAULT NULL,
  `net_amount` double DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `due_amount` double DEFAULT NULL,
  `note` text,
  `process_status` enum('Pending','Processed') NOT NULL DEFAULT 'Pending',
  `payment_status` enum('Not Paid','Partial Paid','Paid') NOT NULL DEFAULT 'Not Paid',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0',
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `_key` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `inv_sale_return_cart`;
CREATE TABLE `inv_sale_return_cart` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `business_type_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `inv_sale_return_items`;
CREATE TABLE `inv_sale_return_items` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) DEFAULT NULL,
  `business_type_id` int(11) DEFAULT NULL,
  `sale_return_id` int(11) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `avg_price` double DEFAULT NULL,
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `inv_sale_return`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_head_id` (`from_head_id`),
  ADD KEY `from_subhead_id` (`from_subhead_id`),
  ADD KEY `from_particular_id` (`from_particular_id`),
  ADD KEY `to_head_id` (`to_head_id`),
  ADD KEY `to_subhead_id` (`to_subhead_id`),
  ADD KEY `to_particular_id` (`to_particular_id`);

ALTER TABLE `inv_sale_return_cart`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `inv_sale_return_items`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `inv_sale_return`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `inv_sale_return_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `inv_sale_return_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

----- 20.02.19-----
---- By Motahar----

CREATE TABLE `packaging_purchase_challan` (
  `id` int(20) NOT NULL,
  `date` date DEFAULT NULL,
  `type` enum('in','out','os') DEFAULT NULL,
  `production_type` varchar(200) DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `order_no` varchar(50) DEFAULT NULL,
  `challan_no` varchar(50) DEFAULT NULL,
  `supplier_head` int(11) DEFAULT NULL,
  `supplier_subhead` int(11) DEFAULT NULL,
  `supplier_particular` int(11) DEFAULT NULL,
  `truck_no` varchar(200) DEFAULT NULL,
  `transport_info` varchar(300) DEFAULT NULL,
  `total_quantity` double DEFAULT NULL,
  `process_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `packaging_purchase_challan_item`
--

CREATE TABLE `packaging_purchase_challan_item` (
  `id` int(20) NOT NULL,
  `date` date DEFAULT NULL,
  `purchase_challan_id` int(11) DEFAULT NULL,
  `type` enum('in','out','os') DEFAULT NULL,
  `production_type` varchar(200) DEFAULT NULL,
  `order_no` varchar(50) DEFAULT NULL,
  `invoice_no` varchar(100) DEFAULT NULL,
  `challan_no` varchar(51) DEFAULT NULL,
  `supplier_head` int(15) DEFAULT NULL,
  `supplier_subhead` int(15) DEFAULT NULL,
  `supplier_particular` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `packaging_sales_challan`
--

CREATE TABLE `packaging_sales_challan` (
  `id` int(20) NOT NULL,
  `date` date DEFAULT NULL,
  `type` enum('in','out','os') DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `order_no` varchar(50) DEFAULT NULL,
  `challan_no` varchar(50) DEFAULT NULL,
  `transport_info` varchar(300) DEFAULT NULL,
  `supplier_head` int(11) DEFAULT NULL,
  `supplier_subhead` int(11) DEFAULT NULL,
  `supplier_particular` int(11) DEFAULT NULL,
  `truck_no` varchar(200) DEFAULT NULL,
  `total_quantity` double DEFAULT NULL,
  `process_status` tinyint(4) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `packaging_sales_challan_item`
--

CREATE TABLE `packaging_sales_challan_item` (
  `id` int(20) NOT NULL,
  `date` date DEFAULT NULL,
  `sales_challan_id` int(11) DEFAULT NULL,
  `type` enum('in','out','os') DEFAULT NULL,
  `order_no` varchar(50) DEFAULT NULL,
  `invoice_no` varchar(200) DEFAULT NULL,
  `challan_no` varchar(51) DEFAULT NULL,
  `supplier_head` int(15) DEFAULT NULL,
  `supplier_subhead` int(15) DEFAULT NULL,
  `supplier_particular` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `packaging_purchase_challan`
--
ALTER TABLE `packaging_purchase_challan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`),
  ADD KEY `invoice_no` (`invoice_no`),
  ADD KEY `head_id` (`supplier_head`),
  ADD KEY `subhead_id` (`supplier_subhead`);

--
-- Indexes for table `packaging_purchase_challan_item`
--
ALTER TABLE `packaging_purchase_challan_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packaging_sales_challan`
--
ALTER TABLE `packaging_sales_challan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`),
  ADD KEY `invoice_no` (`invoice_no`),
  ADD KEY `head_id` (`supplier_head`),
  ADD KEY `subhead_id` (`supplier_subhead`);

--
-- Indexes for table `packaging_sales_challan_item`
--
ALTER TABLE `packaging_sales_challan_item`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `packaging_purchase_challan`
--
ALTER TABLE `packaging_purchase_challan`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `packaging_purchase_challan_item`
--
ALTER TABLE `packaging_purchase_challan_item`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `packaging_sales_challan`
--
ALTER TABLE `packaging_sales_challan`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `packaging_sales_challan_item`
--
ALTER TABLE `packaging_sales_challan_item`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--- 22.02.19----
--- By Motahar ----
ALTER TABLE `packaging_sales_challan_item` ADD `per_qty_price` DOUBLE NULL DEFAULT NULL AFTER `quantity`;
ALTER TABLE `packaging_sales_challan` ADD `total_price` DOUBLE NULL DEFAULT NULL AFTER `total_quantity`;
ALTER TABLE `packaging_sales_challan_item` ADD `total_price` DOUBLE NULL DEFAULT NULL AFTER `per_qty_price`;

----26.02.19-----
---- By Motahar----

CREATE TABLE `dal_purchase_challan` (
  `id` int(20) NOT NULL,
  `date` date DEFAULT NULL,
  `type` enum('in','out','os') DEFAULT NULL,
  `production_type` varchar(200) DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `order_no` varchar(50) DEFAULT NULL,
  `challan_no` varchar(50) DEFAULT NULL,
  `supplier_head` int(11) DEFAULT NULL,
  `supplier_subhead` int(11) DEFAULT NULL,
  `supplier_particular` int(11) DEFAULT NULL,
  `truck_no` varchar(200) DEFAULT NULL,
  `transport_info` varchar(300) DEFAULT NULL,
  `total_quantity` double DEFAULT NULL,
  `process_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_purchase_challan_item`
--

CREATE TABLE `dal_purchase_challan_item` (
  `id` int(20) NOT NULL,
  `date` date DEFAULT NULL,
  `purchase_challan_id` int(11) DEFAULT NULL,
  `type` enum('in','out','os') DEFAULT NULL,
  `production_type` varchar(200) DEFAULT NULL,
  `order_no` varchar(50) DEFAULT NULL,
  `invoice_no` varchar(100) DEFAULT NULL,
  `challan_no` varchar(51) DEFAULT NULL,
  `supplier_head` int(15) DEFAULT NULL,
  `supplier_subhead` int(15) DEFAULT NULL,
  `supplier_particular` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
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
  `id` int(20) NOT NULL,
  `date` date DEFAULT NULL,
  `type` enum('in','out','os') DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `order_no` varchar(50) DEFAULT NULL,
  `challan_no` varchar(50) DEFAULT NULL,
  `transport_info` varchar(300) DEFAULT NULL,
  `supplier_head` int(11) DEFAULT NULL,
  `supplier_subhead` int(11) DEFAULT NULL,
  `supplier_particular` int(11) DEFAULT NULL,
  `truck_no` varchar(200) DEFAULT NULL,
  `total_quantity` double DEFAULT NULL,
  `process_status` tinyint(4) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(15) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(15) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dal_sales_challan_item`
--

CREATE TABLE `dal_sales_challan_item` (
  `id` int(20) NOT NULL,
  `date` date DEFAULT NULL,
  `sales_challan_id` int(11) DEFAULT NULL,
  `type` enum('in','out','os') DEFAULT NULL,
  `order_no` varchar(50) DEFAULT NULL,
  `invoice_no` varchar(200) DEFAULT NULL,
  `challan_no` varchar(51) DEFAULT NULL,
  `supplier_head` int(15) DEFAULT NULL,
  `supplier_subhead` int(15) DEFAULT NULL,
  `supplier_particular` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `_key` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dal_purchase_challan`
--
ALTER TABLE `dal_purchase_challan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`),
  ADD KEY `invoice_no` (`invoice_no`),
  ADD KEY `head_id` (`supplier_head`),
  ADD KEY `subhead_id` (`supplier_subhead`);

--
-- Indexes for table `dal_purchase_challan_item`
--
ALTER TABLE `dal_purchase_challan_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dal_sales_challan`
--
ALTER TABLE `dal_sales_challan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`),
  ADD KEY `invoice_no` (`invoice_no`),
  ADD KEY `head_id` (`supplier_head`),
  ADD KEY `subhead_id` (`supplier_subhead`);

--
-- Indexes for table `dal_sales_challan_item`
--
ALTER TABLE `dal_sales_challan_item`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dal_purchase_challan`
--
ALTER TABLE `dal_purchase_challan`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_purchase_challan_item`
--
ALTER TABLE `dal_purchase_challan_item`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_sales_challan`
--
ALTER TABLE `dal_sales_challan`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dal_sales_challan_item`
--
ALTER TABLE `dal_sales_challan_item`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--- 10.03.19----
--- By Motahar ----
ALTER TABLE `rice_stocks` ADD `mon` DOUBLE NULL DEFAULT NULL AFTER `weight`;

--- 14.03.19----
--- By Motahar ----
ALTER TABLE `rice_sales_challan_item` ADD `track_weight` DOUBLE NULL DEFAULT NULL AFTER `bag_quantity`, ADD `net_weight` DOUBLE NULL DEFAULT NULL AFTER `track_weight`;

--- 14.03.19----
--- By Rakib ----
ALTER TABLE `inv_purchase` CHANGE `invoice_no` `invoice_no` INT(11) NULL DEFAULT NULL;
ALTER TABLE `inv_purchase_return` CHANGE `invoice_no` `invoice_no` INT(11) NULL DEFAULT NULL;
ALTER TABLE `inv_sale` CHANGE `invoice_no` `invoice_no` INT(11) NULL DEFAULT NULL;
ALTER TABLE `inv_sale_return` CHANGE `invoice_no` `invoice_no` INT(11) NULL DEFAULT NULL;

--- 18.03.19 ---
--- By Motahar ----
ALTER TABLE `flour_purchase_challan` ADD `empty_bag_weight` DOUBLE NULL DEFAULT NULL AFTER `bag_quantity`;

---- 19.03.19 ----
---- By Motahar ----
ALTER TABLE `flour_stocks` CHANGE `type` `type` ENUM('in','out','process','os') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

--- 24.03.19----
--- By Rakib ----
ALTER TABLE `transactions` ADD `bank_info` TEXT NULL DEFAULT NULL AFTER `bank_account_id`;
ALTER TABLE `transactions` ADD `check_issue_date` DATE NULL DEFAULT NULL AFTER `bank_info`;

--- By Motahar ----
--- 25.03.19---
ALTER TABLE `oven_purchase_challan` ADD `total_weight` DOUBLE NULL DEFAULT NULL AFTER `total_quantity`;
ALTER TABLE `oven_purchase_challan_item` ADD `weight` DOUBLE NULL DEFAULT NULL AFTER `quantity`, ADD `net_weight` DOUBLE NULL DEFAULT NULL AFTER `weight`;

