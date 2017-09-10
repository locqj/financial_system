-- MySQL dump 10.13  Distrib 5.5.48, for Linux (x86_64)
--
-- Host: localhost    Database: hengju
-- ------------------------------------------------------
-- Server version	5.5.48-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bonus_details`
--

DROP TABLE IF EXISTS `bonus_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bonus_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bonus_amount` float NOT NULL DEFAULT '0' COMMENT '提成金额（根据rule_key，一手提成或者分红）',
  `employee_code` varchar(50) NOT NULL COMMENT '员工编号',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `is_cost` int(11) NOT NULL COMMENT '店铺成本:0-不作，1-作',
  `store_type` int(11) NOT NULL COMMENT '店铺类型',
  `update_code` varchar(50) NOT NULL COMMENT '表唯一标识',
  `bonus_rule_key` varchar(50) NOT NULL COMMENT '(提成，分红)',
  `store_code` varchar(50) NOT NULL,
  `cstore_code` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '子店铺编号，可为空',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bonus_details`
--

LOCK TABLES `bonus_details` WRITE;
/*!40000 ALTER TABLE `bonus_details` DISABLE KEYS */;
INSERT INTO `bonus_details` VALUES (1,350,'hj002T5','2017-08-09 07:21:00',2017,8,1,2,'20178T1','1','hj002',NULL),(2,100,'hj002T4','2017-08-09 07:21:00',2017,8,1,2,'20178T1','1','hj002',NULL),(3,375,'123132123123123123123','2017-08-09 07:21:00',2017,8,0,1,'20178T1','5','hj001','hj002'),(4,375,'hj002T3','2017-08-09 07:21:00',2017,8,0,2,'20178T1','2','hj002',NULL),(5,310,'hj002T3','2017-08-09 07:25:59',2017,8,1,2,'20178T2','1','hj002',NULL),(6,350,'hj002T5','2017-08-09 07:25:59',2017,8,1,2,'20178T2','1','hj002',NULL),(7,100,'hj002T4','2017-08-09 07:25:59',2017,8,1,2,'20178T2','1','hj002',NULL),(8,1143.3,'123132123123123123123','2017-08-09 07:25:59',2017,8,0,1,'20178T2','5','hj001','hj002'),(9,1143.3,'hj002T3','2017-08-09 07:25:59',2017,8,0,2,'20178T2','2','hj002',NULL);
/*!40000 ALTER TABLE `bonus_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calculate_log`
--

DROP TABLE IF EXISTS `calculate_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calculate_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `update_code` varchar(50) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `is_last` int(4) NOT NULL DEFAULT '1' COMMENT '每次更新数据，置为1表示最新数据，其他需要修改为0',
  `employee_code` varchar(50) NOT NULL DEFAULT '操作者',
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=gbk;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calculate_log`
--

LOCK TABLES `calculate_log` WRITE;
/*!40000 ALTER TABLE `calculate_log` DISABLE KEYS */;
INSERT INTO `calculate_log` VALUES (1,'20178T1','2017-08-09 15:21:00',0,'hj001T2',8,2017),(2,'20178T2','2017-08-09 15:25:59',1,'hj001T2',8,2017);
/*!40000 ALTER TABLE `calculate_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calculate_store`
--

DROP TABLE IF EXISTS `calculate_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calculate_store` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `income` float NOT NULL COMMENT '总收入',
  `outcome` float NOT NULL COMMENT '总支出',
  `profit` float NOT NULL COMMENT '总利润',
  `store_code` varchar(50) NOT NULL COMMENT '店铺编号',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_code` varchar(50) NOT NULL COMMENT '更新标志',
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calculate_store`
--

LOCK TABLES `calculate_store` WRITE;
/*!40000 ALTER TABLE `calculate_store` DISABLE KEYS */;
INSERT INTO `calculate_store` VALUES (1,21000,13500,7500,'hj002','2017-08-09 07:21:00','20178T1',2017,8),(2,31000,8134,22866,'hj002','2017-08-09 07:25:59','20178T2',2017,8);
/*!40000 ALTER TABLE `calculate_store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commission_details`
--

DROP TABLE IF EXISTS `commission_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commission_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_code` varchar(50) NOT NULL COMMENT '店铺编号',
  `employee_code` varchar(50) NOT NULL COMMENT '员工编号',
  `amount` float NOT NULL DEFAULT '0' COMMENT '佣金额度',
  `second_amount` float NOT NULL DEFAULT '0' COMMENT '二手房佣金',
  `rent_amount` float NOT NULL DEFAULT '0' COMMENT '租房佣金',
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `update_code` varchar(50) NOT NULL COMMENT '表唯一标识',
  `contract_number` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commission_details`
--

LOCK TABLES `commission_details` WRITE;
/*!40000 ALTER TABLE `commission_details` DISABLE KEYS */;
INSERT INTO `commission_details` VALUES (1,'hj002','hj002T5',0,11000,0,2017,8,'2017-08-09 07:21:00','20178T1','1'),(2,'hj002','hj002T4',10000,0,0,2017,8,'2017-08-09 07:21:00','20178T1','1'),(3,'hj002','hj002T3',0,10000,0,2017,8,'2017-08-09 07:25:59','20178T2','1'),(4,'hj002','hj002T5',0,11000,0,2017,8,'2017-08-09 07:25:59','20178T2','1'),(5,'hj002','hj002T4',10000,0,0,2017,8,'2017-08-09 07:25:59','20178T2','1');
/*!40000 ALTER TABLE `commission_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contract_images`
--

DROP TABLE IF EXISTS `contract_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contract_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contract_id` varchar(50) NOT NULL COMMENT '签单编号',
  `url` varchar(255) NOT NULL COMMENT '地址',
  `status_del` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='图片';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contract_images`
--

LOCK TABLES `contract_images` WRITE;
/*!40000 ALTER TABLE `contract_images` DISABLE KEYS */;
INSERT INTO `contract_images` VALUES (1,'1','/static/files/images/201708091506phpvjlRzp.jpeg',0);
/*!40000 ALTER TABLE `contract_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contract_process`
--

DROP TABLE IF EXISTS `contract_process`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contract_process` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contract_number` varchar(50) NOT NULL COMMENT '签单号',
  `type` int(10) unsigned NOT NULL COMMENT '1:网签，2：贷款，3：交税',
  `remark` text COMMENT '备注',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `status_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='签单流程表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contract_process`
--

LOCK TABLES `contract_process` WRITE;
/*!40000 ALTER TABLE `contract_process` DISABLE KEYS */;
INSERT INTO `contract_process` VALUES (1,'123123',1,'王洽','2017-08-09 15:08:33',0);
/*!40000 ALTER TABLE `contract_process` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cost_details`
--

DROP TABLE IF EXISTS `cost_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cost_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(128) NOT NULL COMMENT '类目',
  `amount` float NOT NULL COMMENT '金额',
  `store_code` varchar(50) NOT NULL COMMENT '店铺编码',
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `update_code` varchar(50) NOT NULL COMMENT '表唯一标识',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cost_details`
--

LOCK TABLES `cost_details` WRITE;
/*!40000 ALTER TABLE `cost_details` DISABLE KEYS */;
INSERT INTO `cost_details` VALUES (1,'人员工资[总店分摊]',9000,'hj002',2017,8,'20178T1','2017-08-09 07:21:00'),(2,'过户费用[总店分摊]',1000,'hj002',2017,8,'20178T1','2017-08-09 07:21:00'),(3,'分摊员工端口费【员工编号：hj002T4,当月佣金总额：10000,承担比例：10%】',50,'hj002',2017,8,'20178T1','2017-08-09 07:21:00'),(4,'人员工资[总店分摊]',3000,'hj002',2017,8,'20178T2','2017-08-09 07:25:59'),(5,'过户费用[总店分摊]',1324,'hj002',2017,8,'20178T2','2017-08-09 07:25:59'),(6,'分摊员工端口费【员工编号：hj002T4,当月佣金总额：10000,承担比例：10%】',50,'hj002',2017,8,'20178T2','2017-08-09 07:25:59');
/*!40000 ALTER TABLE `cost_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_position`
--

DROP TABLE IF EXISTS `employee_position`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_code` varchar(50) NOT NULL COMMENT '员工编号',
  `position_code` varchar(50) NOT NULL COMMENT '职位编号',
  `store_code` varchar(50) NOT NULL COMMENT '店铺编号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=gbk;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_position`
--

LOCK TABLES `employee_position` WRITE;
/*!40000 ALTER TABLE `employee_position` DISABLE KEYS */;
INSERT INTO `employee_position` VALUES (14,'123132123123123123123','jl01','hj001'),(15,'hj001T2','cw01','hj001'),(16,'123123','gh01','hj001'),(56,'hj002T3','zl02','hj002'),(58,'hj002T5','xs04','hj002'),(57,'hj002T4','xs04','hj002');
/*!40000 ALTER TABLE `employee_position` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grant_log`
--

DROP TABLE IF EXISTS `grant_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grant_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_code` varchar(50) NOT NULL DEFAULT '' COMMENT '员工编号',
  `year` int(50) NOT NULL,
  `month` int(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `record_user` varchar(50) NOT NULL COMMENT '录入员',
  `update_code` varchar(50) NOT NULL,
  `amount` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grant_log`
--

LOCK TABLES `grant_log` WRITE;
/*!40000 ALTER TABLE `grant_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `grant_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `position_adjustment_log`
--

DROP TABLE IF EXISTS `position_adjustment_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `position_adjustment_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `old_position_code` varchar(50) NOT NULL COMMENT '旧职位编号',
  `new_position_code` varchar(50) NOT NULL COMMENT '新职位编号',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `employee_code` varchar(50) NOT NULL COMMENT '员工编号',
  `old_store_code` varchar(50) NOT NULL COMMENT '旧店铺编号',
  `new_store_code` varchar(50) NOT NULL COMMENT '新店铺编号',
  `year` int(10) unsigned NOT NULL COMMENT '年',
  `month` int(10) unsigned NOT NULL COMMENT '月',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `position_adjustment_log`
--

LOCK TABLES `position_adjustment_log` WRITE;
/*!40000 ALTER TABLE `position_adjustment_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `position_adjustment_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reduce_salary`
--

DROP TABLE IF EXISTS `reduce_salary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reduce_salary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_code` varchar(50) NOT NULL,
  `employee_code` varchar(50) NOT NULL,
  `record_user` varchar(50) NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `amount` float NOT NULL DEFAULT '0',
  `category` text NOT NULL COMMENT '类目',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `day` int(11) NOT NULL,
  `is_port` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否是端口费',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reduce_salary`
--

LOCK TABLES `reduce_salary` WRITE;
/*!40000 ALTER TABLE `reduce_salary` DISABLE KEYS */;
INSERT INTO `reduce_salary` VALUES (1,'hj002','hj002T4','hj001T2',2017,8,0,450,'自付端口费【自付比例：90%】','2017-08-09 07:25:59',1,1),(2,'hj002','hj002T4','hj001T2',2017,8,1,450,'自付端口费【自付比例：90%】','2017-08-09 07:25:59',1,1);
/*!40000 ALTER TABLE `reduce_salary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salary_details`
--

DROP TABLE IF EXISTS `salary_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salary_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_code` varchar(50) NOT NULL COMMENT '员工编号',
  `salary_amount` float NOT NULL COMMENT '基本工资',
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `store_type` int(11) NOT NULL COMMENT '店铺类型 1-总店 2-分店;3:区域',
  `update_code` varchar(50) NOT NULL COMMENT '表唯一标识',
  `store_code` varchar(50) NOT NULL COMMENT '店铺code',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salary_details`
--

LOCK TABLES `salary_details` WRITE;
/*!40000 ALTER TABLE `salary_details` DISABLE KEYS */;
INSERT INTO `salary_details` VALUES (1,'123132123123123123123',1000,2017,8,'2017-08-08 18:24:03',1,'20178T1','hj001'),(2,'hj001T2',1000,2017,8,'2017-08-08 18:24:03',1,'20178T1','hj001'),(3,'123123',1000,2017,8,'2017-08-08 18:24:03',1,'20178T1','hj001'),(4,'123132123123123123123',1000,2017,8,'2017-08-08 18:24:26',1,'20178T1','hj001'),(5,'hj001T2',1000,2017,8,'2017-08-08 18:24:26',1,'20178T1','hj001'),(6,'123123',1000,2017,8,'2017-08-08 18:24:26',1,'20178T1','hj001'),(7,'123132123123123123123',1000,2017,8,'2017-08-08 19:21:00',1,'20178T1','hj001'),(8,'hj001T2',1000,2017,8,'2017-08-08 19:21:00',1,'20178T1','hj001'),(9,'123123',1000,2017,8,'2017-08-08 19:21:00',1,'20178T1','hj001'),(10,'hj002T3',1000,2017,8,'2017-08-08 19:21:00',2,'20178T1','hj002'),(11,'hj002T4',1000,2017,8,'2017-08-08 19:21:00',2,'20178T1','hj002'),(12,'hj002T5',1000,2017,8,'2017-08-08 19:21:00',2,'20178T1','hj002'),(13,'123132123123123123123',1000,2017,8,'2017-08-08 19:25:59',1,'20178T2','hj001'),(14,'hj001T2',1000,2017,8,'2017-08-08 19:25:59',1,'20178T2','hj001'),(15,'123123',1000,2017,8,'2017-08-08 19:25:59',1,'20178T2','hj001'),(16,'hj002T3',1000,2017,8,'2017-08-08 19:25:59',2,'20178T2','hj002'),(17,'hj002T4',1000,2017,8,'2017-08-08 19:25:59',2,'20178T2','hj002'),(18,'hj002T5',1000,2017,8,'2017-08-08 19:25:59',2,'20178T2','hj002');
/*!40000 ALTER TABLE `salary_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_bonus_rule`
--

DROP TABLE IF EXISTS `staff_bonus_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_bonus_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rule_key` int(50) NOT NULL COMMENT '规则key:1:销售阶梯提成；2:助理分红；3:店长分红（本店）；4:区域经理分红；5:总经理；6:二级分店；7:一手分成比例；8:二手房房源分成比例；9:租售房源分成比例，10:销售等级评定，11:一手房提成；12:二租房提成，13:端口申报评定',
  `top` varchar(50) DEFAULT NULL COMMENT '范围上限',
  `bottom` int(11) DEFAULT NULL COMMENT '范围下限',
  `percentage` float NOT NULL COMMENT '百分比',
  `is_cost` int(11) NOT NULL COMMENT '店铺成本:0-不作，1-作',
  `status_del` int(11) NOT NULL DEFAULT '0' COMMENT '0--存在 ，1--不存在',
  `position_code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_bonus_rule`
--

LOCK TABLES `staff_bonus_rule` WRITE;
/*!40000 ALTER TABLE `staff_bonus_rule` DISABLE KEYS */;
INSERT INTO `staff_bonus_rule` VALUES (8,3,NULL,NULL,0.04,0,0,NULL),(9,4,NULL,NULL,0.04,0,0,NULL),(10,5,NULL,NULL,0.05,0,0,NULL),(12,7,NULL,NULL,0.05,0,0,NULL),(68,2,NULL,NULL,0.05,0,0,NULL),(70,12,NULL,NULL,0.03,0,0,NULL),(81,8,NULL,NULL,0.7,0,0,NULL),(82,9,NULL,NULL,0.5,0,0,NULL),(83,11,NULL,NULL,0.01,0,0,NULL),(91,1,'3000',0,0.01,1,0,NULL),(92,1,'6000',3001,0.05,1,0,NULL),(93,1,'9000',6001,0.03,1,0,NULL),(94,1,'+00',9001,0.04,1,0,NULL),(104,13,NULL,10000,0.1,0,0,NULL),(105,13,NULL,15000,0.3,0,0,NULL),(106,13,NULL,20000,0.4,0,0,NULL),(122,10,NULL,0,0,0,1,'xs01'),(123,10,NULL,200,0,0,1,'xs02'),(124,10,NULL,1000,0,0,1,'xs03'),(125,10,NULL,14000,0,0,1,'xs04'),(126,10,NULL,15000,0,0,1,'xs05'),(129,6,'20',NULL,0.66,0,0,NULL),(130,10,NULL,0,0,0,0,'xs01'),(131,10,NULL,200,0,0,0,'xs02'),(132,10,NULL,1000,0,0,0,'xs03'),(133,10,NULL,1400,0,0,0,'xs04'),(134,10,NULL,15000,0,0,0,'xs05');
/*!40000 ALTER TABLE `staff_bonus_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_contract`
--

DROP TABLE IF EXISTS `staff_contract`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_contract` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(255) NOT NULL COMMENT '单号',
  `employee_code` varchar(50) NOT NULL COMMENT '员工编号',
  `sign_amount` float NOT NULL COMMENT '签单额度',
  `real_amount` float NOT NULL DEFAULT '0' COMMENT '结单额度',
  `is_signed` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否结佣：1-是，0-不是',
  `year` int(11) NOT NULL COMMENT '年',
  `month` int(11) NOT NULL COMMENT '月',
  `store_code` varchar(50) NOT NULL COMMENT '店铺编号',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `day` int(11) NOT NULL,
  `status_del` int(11) NOT NULL DEFAULT '0' COMMENT '0 未删除',
  `type` int(11) NOT NULL COMMENT '单子类型 1-一手， 2-二手， 3 -租单',
  `is_divide` int(11) NOT NULL DEFAULT '0' COMMENT '是否为有房源提供方，0-无，1-有 ',
  `source_employee` varchar(50) DEFAULT '0' COMMENT '房源提供方code',
  `remark` text COMMENT '备注',
  `contract_addr` text NOT NULL COMMENT '房源地址',
  `received_amount` float DEFAULT '0' COMMENT '已收金额',
  `source_store` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_contract`
--

LOCK TABLES `staff_contract` WRITE;
/*!40000 ALTER TABLE `staff_contract` DISABLE KEYS */;
INSERT INTO `staff_contract` VALUES (1,'123123','hj002T5',1000,11000,1,2017,8,'hj002','2017-08-09 07:11:12','2017-08-09 07:06:57',9,0,2,0,'0','123    结佣备注：qwqheioqwe','12312',10000,'all'),(2,'12323','hj002T3',10000,10000,1,2017,8,'hj002','2017-08-09 07:25:32','2017-08-09 07:11:35',8,0,2,0,'0','12    结佣备注：234','123',10000,'all'),(3,'hjf201708091','hj002T4',10000,10000,1,2017,8,'hj002','2017-08-09 07:20:47','2017-08-09 07:19:44',9,0,1,0,'0','12312    结佣备注：12','123321',10000,'all');
/*!40000 ALTER TABLE `staff_contract` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_employee`
--

DROP TABLE IF EXISTS `staff_employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL COMMENT '员工姓名',
  `sex` int(11) NOT NULL COMMENT '性别：0：男，1-女',
  `birth` varchar(128) DEFAULT NULL COMMENT '出生年月',
  `id_card` varchar(50) DEFAULT NULL COMMENT '身份证',
  `phone` varchar(11) DEFAULT NULL COMMENT '电话',
  `addr` varchar(255) DEFAULT NULL COMMENT '住址',
  `entry_time` varchar(128) DEFAULT NULL COMMENT '入职时间',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态：1-存在，0-不存在',
  `position_code` varchar(10) NOT NULL COMMENT '所属职位',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `code` varchar(50) NOT NULL COMMENT '员工编号，唯一',
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_employee`
--

LOCK TABLES `staff_employee` WRITE;
/*!40000 ALTER TABLE `staff_employee` DISABLE KEYS */;
INSERT INTO `staff_employee` VALUES (37,'bruce_zj',0,'','2312312312312','13213123123','addr','2017-07-26',1,'','2017-07-24 00:29:16','123132123123123123123','2017-06-30 01:29:29'),(38,'bruce_cw',1,'2017-06','2356456','12312312312','aaa','2017-07-26',1,'','2017-08-03 06:03:21','hj001T2','2017-06-30 01:30:11'),(39,'bruce_gh',1,'2017-06','123123123123123123','12312312312','addr','2017-07-26',1,'','2017-07-21 09:30:54','123123','2017-06-30 01:30:38'),(93,'印象城助理',0,'','123123123123123123','12312312312','','2017-08-09',1,'',NULL,'hj002T3','2017-08-09 07:03:13'),(94,'印象城销售',0,'2017-08-09','123123123123123123','13123123123','','2017-03-09',1,'',NULL,'hj002T4','2017-08-09 07:03:55'),(95,'印象城销售2',1,'','123123123213123123','21312312312','','2017-08-09',1,'',NULL,'hj002T5','2017-08-09 07:04:36');
/*!40000 ALTER TABLE `staff_employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_port`
--

DROP TABLE IF EXISTS `staff_port`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_port` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `port_name` varchar(255) NOT NULL COMMENT '端口名',
  `employee_code` varchar(50) NOT NULL,
  `store_code` varchar(50) NOT NULL,
  `remark` text,
  `amount` float NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `length` int(11) NOT NULL COMMENT '期数',
  `pay_month` text NOT NULL COMMENT '还款月份',
  `status` int(11) NOT NULL COMMENT '1-存在 0-不存在',
  `port_number` varchar(50) DEFAULT NULL,
  `unit` float DEFAULT NULL,
  `port_place` varchar(255) DEFAULT NULL,
  `start_year_month` int(10) unsigned NOT NULL COMMENT '开始还款年月',
  `end_year_month` int(10) unsigned NOT NULL COMMENT '结束还款年月',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_port`
--

LOCK TABLES `staff_port` WRITE;
/*!40000 ALTER TABLE `staff_port` DISABLE KEYS */;
INSERT INTO `staff_port` VALUES (1,'','hj002T4','hj002','',1000,2017,7,2,'[{\"year\":2017,\"month\":7},{\"year\":2017,\"month\":8}]',1,'1222',500,'121',201707,201708);
/*!40000 ALTER TABLE `staff_port` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_position`
--

DROP TABLE IF EXISTS `staff_position`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_code` varchar(50) NOT NULL COMMENT '所属店铺',
  `code` varchar(50) NOT NULL COMMENT '职位代号',
  `name` varchar(255) NOT NULL COMMENT '职位名称',
  `level` int(11) NOT NULL DEFAULT '1' COMMENT '级别',
  `salary` float NOT NULL COMMENT '基本工资',
  `status_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1-删除，0-未删除',
  `position_tag` varchar(255) NOT NULL COMMENT '头衔',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=231 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_position`
--

LOCK TABLES `staff_position` WRITE;
/*!40000 ALTER TABLE `staff_position` DISABLE KEYS */;
INSERT INTO `staff_position` VALUES (1,'hj001','jl01','总经理',1,1000,0,'总经理'),(2,'hj001','gh01','过户',1,1000,0,'过户专员'),(5,'hj001','cw01','财务',1,1000,0,'财务专员'),(220,'qy00T1','qy01','区域经理',1,1000,0,'区域经理'),(221,'qy00T2','qy01','区域经理',1,1000,0,'区域经理'),(222,'hj002','dz01','店长',1,1000,0,'店长'),(223,'hj002','zl01','店长助理',1,1000,0,'高级置业顾问'),(224,'hj002','zl02','店长助理',2,1000,0,'主任置业顾问'),(225,'hj002','zl03','店长助理',3,1000,0,'金牌置业顾问'),(226,'hj002','xs01','销售',1,1000,0,'见习置业顾问'),(227,'hj002','xs02','销售',2,1000,0,'置业顾问'),(228,'hj002','xs03','销售',3,1000,0,'高级置业顾问'),(229,'hj002','xs04','销售',4,1000,0,'主任置业顾问'),(230,'hj002','xs05','销售',5,1000,0,'金牌置业顾问');
/*!40000 ALTER TABLE `staff_position` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_position_level`
--

DROP TABLE IF EXISTS `staff_position_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_position_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `top` varchar(50) NOT NULL,
  `bottom` varchar(50) NOT NULL,
  `position_code` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_position_level`
--

LOCK TABLES `staff_position_level` WRITE;
/*!40000 ALTER TABLE `staff_position_level` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff_position_level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_transfer_record`
--

DROP TABLE IF EXISTS `staff_transfer_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_transfer_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_code` varchar(50) NOT NULL COMMENT '店铺编号',
  `employee_code` varchar(50) NOT NULL COMMENT '员工编号',
  `amount` float NOT NULL COMMENT '过户费用',
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `contract_number` varchar(50) NOT NULL COMMENT '签单号',
  `day` int(11) NOT NULL,
  `status_del` int(11) NOT NULL DEFAULT '0' COMMENT '0 未删除',
  `remark` text CHARACTER SET utf8 COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_transfer_record`
--

LOCK TABLES `staff_transfer_record` WRITE;
/*!40000 ALTER TABLE `staff_transfer_record` DISABLE KEYS */;
INSERT INTO `staff_transfer_record` VALUES (1,'hj002','123123',1000,2017,8,'2017-08-09 07:09:06','123123',9,0,'王洽'),(2,'hj002','123123',324,2017,8,'2017-08-09 07:25:24','12323',1,0,'');
/*!40000 ALTER TABLE `staff_transfer_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `store_city`
--

DROP TABLE IF EXISTS `store_city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `store_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL COMMENT '城市编号',
  `name` varchar(128) NOT NULL COMMENT '城市名称',
  `remark` text CHARACTER SET utf8,
  `status_del` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store_city`
--

LOCK TABLES `store_city` WRITE;
/*!40000 ALTER TABLE `store_city` DISABLE KEYS */;
INSERT INTO `store_city` VALUES (1,'cs00T1','常熟地区','',0,'2017-07-31 09:23:25'),(2,'cs00T2','张家港',NULL,0,'2017-07-31 07:00:18'),(3,'cs00T3','上海地区','上海',1,'2017-07-31 09:27:58');
/*!40000 ALTER TABLE `store_city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `store_company`
--

DROP TABLE IF EXISTS `store_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `store_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '公司名',
  `addr` varchar(255) DEFAULT NULL COMMENT '公司地址',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态：1-存在，0-不存在',
  `reamrk` varchar(255) DEFAULT NULL COMMENT '备注',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `code` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store_company`
--

LOCK TABLES `store_company` WRITE;
/*!40000 ALTER TABLE `store_company` DISABLE KEYS */;
INSERT INTO `store_company` VALUES (1,'江苏公司',NULL,1,NULL,NULL,'2017-05-28 22:32:16','888');
/*!40000 ALTER TABLE `store_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `store_cost`
--

DROP TABLE IF EXISTS `store_cost`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `store_cost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `total` float NOT NULL COMMENT '总额',
  `category` varchar(128) NOT NULL COMMENT '类目',
  `month` int(255) NOT NULL COMMENT '创建月份',
  `length` int(10) NOT NULL COMMENT '分期数',
  `owner_store_code` varchar(50) NOT NULL COMMENT '费用所属店铺',
  `pay_stores` varchar(255) NOT NULL COMMENT '还款店铺',
  `unit` float NOT NULL COMMENT '每期还款金额',
  `pay_month` text NOT NULL COMMENT '偿还月份',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `year` int(11) NOT NULL COMMENT '创建年份',
  `start_year_month` int(11) NOT NULL COMMENT '结束还款年份',
  `end_year_month` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store_cost`
--

LOCK TABLES `store_cost` WRITE;
/*!40000 ALTER TABLE `store_cost` DISABLE KEYS */;
/*!40000 ALTER TABLE `store_cost` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `store_income`
--

DROP TABLE IF EXISTS `store_income`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `store_income` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `total` float NOT NULL COMMENT '总额',
  `category` varchar(128) NOT NULL COMMENT '类目',
  `month` int(255) NOT NULL COMMENT '创建月份',
  `year` int(11) NOT NULL COMMENT '创建年份',
  `store_code` varchar(50) NOT NULL COMMENT '店铺号',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  `remark` text CHARACTER SET utf8 COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store_income`
--

LOCK TABLES `store_income` WRITE;
/*!40000 ALTER TABLE `store_income` DISABLE KEYS */;
/*!40000 ALTER TABLE `store_income` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `store_store`
--

DROP TABLE IF EXISTS `store_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `store_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL COMMENT '店铺编号',
  `name` varchar(128) NOT NULL COMMENT '店铺名称',
  `addr` varchar(255) NOT NULL COMMENT '地址',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态：1-存在，0-不存在',
  `type` int(11) NOT NULL COMMENT '店铺类型：1-总店，2-分店',
  `city_code` varchar(50) DEFAULT NULL COMMENT '所属城市邮编',
  `parent_code` varchar(50) DEFAULT '0' COMMENT '父级店铺编号',
  `parent_start_time` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '父级店铺开始时间',
  `company_code` varchar(50) NOT NULL COMMENT '所属公司',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `status_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'del状态 1-删除，0-未删除',
  `zone_code` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '区域code',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store_store`
--

LOCK TABLES `store_store` WRITE;
/*!40000 ALTER TABLE `store_store` DISABLE KEYS */;
INSERT INTO `store_store` VALUES (19,'hj001','xxx总公司','addr',1,1,'cs00T1','0','','888','2017-08-09 02:23:23',NULL,0,''),(63,'hj002','印象城店','印象城',1,2,'cs00T1','0','','888',NULL,'2017-08-09 07:01:40',0,'qy00T1');
/*!40000 ALTER TABLE `store_store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `store_zone`
--

DROP TABLE IF EXISTS `store_zone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `store_zone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '区域名',
  `code` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 -- 存在 0 -- 不存在',
  `remark` text COMMENT '备注',
  `addr` text,
  `city_code` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '城市编号',
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=gbk;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store_zone`
--

LOCK TABLES `store_zone` WRITE;
/*!40000 ALTER TABLE `store_zone` DISABLE KEYS */;
INSERT INTO `store_zone` VALUES (1,'东南开发区','qy00T1',1,'','东南','cs00T1','2017-08-09 07:00:47'),(2,'虞山片区','qy00T2',1,'','虞山','cs00T1','2017-08-09 07:01:13');
/*!40000 ALTER TABLE `store_zone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL COMMENT '用户名',
  `pwd` varchar(255) NOT NULL,
  `employee_code` varchar(50) NOT NULL COMMENT '所属员工编号',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态：1-存在，0-不存在',
  `last_login_time` varchar(128) DEFAULT NULL COMMENT '最后登陆时间',
  `last_login_ip` varchar(128) DEFAULT NULL COMMENT '最后登陆ip',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (5,'cw','e10adc3949ba59abbe56e057f20f883e','hj001T2',1,NULL,NULL),(7,'jl','e10adc3949ba59abbe56e057f20f883e','123132123123123123123',1,NULL,NULL),(8,'gh','e10adc3949ba59abbe56e057f20f883e','123123',1,NULL,NULL),(58,'印象城助理','e10adc3949ba59abbe56e057f20f883e','hj002T3',1,NULL,NULL),(59,'印象城销售','e10adc3949ba59abbe56e057f20f883e','hj002T4',1,NULL,NULL),(60,'印象城销售2','e10adc3949ba59abbe56e057f20f883e','hj002T5',1,NULL,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_perm`
--

DROP TABLE IF EXISTS `user_perm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_perm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL COMMENT '权限名',
  `code` varchar(128) NOT NULL COMMENT '权限代号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_perm`
--

LOCK TABLES `user_perm` WRITE;
/*!40000 ALTER TABLE `user_perm` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_perm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL COMMENT '角色名',
  `code` varchar(128) NOT NULL COMMENT '角色代号',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态：1-存在，0-不存在',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_login_ip` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login_time` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '状态：1-存在，0-不存在',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `work_note`
--

DROP TABLE IF EXISTS `work_note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `work_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(255) NOT NULL,
  `date` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work_note`
--

LOCK TABLES `work_note` WRITE;
/*!40000 ALTER TABLE `work_note` DISABLE KEYS */;
/*!40000 ALTER TABLE `work_note` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-09 15:26:46
