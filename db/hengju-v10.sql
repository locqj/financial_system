-- MySQL dump 10.13  Distrib 5.7.18, for Linux (x86_64)
--
-- Host: localhost    Database: hengju
-- ------------------------------------------------------
-- Server version	5.7.18-0ubuntu0.16.04.1

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
INSERT INTO `bonus_details` VALUES (1,12,'hjs00002T8','2017-07-20 02:04:08',2017,7,1,2,'20177T1','1','hjs00002',NULL),(2,12,'hjs00002T8','2017-07-20 02:09:06',2017,7,1,2,'20177T2','1','hjs00002',NULL),(3,12,'hjs00002T8','2017-07-20 02:13:07',2017,7,1,2,'20177T3','1','hjs00002',NULL),(4,1426,'hjs00002T8','2017-07-20 02:26:27',2017,7,1,2,'20177T4','1','hjs00002',NULL),(5,50,'hjs00002T9','2017-07-20 02:26:27',2017,7,1,2,'20177T4','1','hjs00002',NULL),(6,2271.2,'123132123123123123123','2017-07-20 02:26:27',2017,7,0,1,'20177T4','2','hj001','hjs00002'),(7,1362.7,'hjs00002T7','2017-07-20 02:26:27',2017,7,0,2,'20177T4','2','hjs00002',NULL),(8,1817,'qy00T2T5','2017-07-20 02:26:27',2017,7,0,3,'20177T4','2','qy00T2','hjs00002'),(9,908.5,'hjs00002T8','2017-07-20 02:26:27',2017,7,0,2,'20177T4','2','hjs00002',NULL);
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
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `is_last` int(4) NOT NULL DEFAULT '1' COMMENT '每次更新数据，置为1表示最新数据，其他需要修改为0',
  `employee_code` varchar(50) NOT NULL DEFAULT '操作者',
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=gbk;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calculate_log`
--

LOCK TABLES `calculate_log` WRITE;
/*!40000 ALTER TABLE `calculate_log` DISABLE KEYS */;
INSERT INTO `calculate_log` VALUES (15,'20177T1','2017-07-20 02:09:06',0,'120254',7,2017),(16,'20177T2','2017-07-20 02:13:07',0,'120254',7,2017),(17,'20177T3','2017-07-20 02:26:27',0,'120254',7,2017),(18,'20177T4','2017-07-20 02:07:27',1,'120254',7,2017),(19,'20178T1','2017-07-19 19:07:51',1,'120254',8,2017);
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
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calculate_store`
--

LOCK TABLES `calculate_store` WRITE;
/*!40000 ALTER TABLE `calculate_store` DISABLE KEYS */;
INSERT INTO `calculate_store` VALUES (1,2400,11512,-9112,'hjs00002','2017-07-20 02:04:08','20177T1',2017,7),(2,0,2500,-2500,'hjs00003','2017-07-20 02:04:08','20177T1',2017,7),(3,0,3000,-3000,'hjs00004','2017-07-20 02:04:08','20177T1',2017,7),(4,2400,10512,-8112,'hjs00002','2017-07-20 02:09:06','20177T2',2017,7),(5,0,1500,-1500,'hjs00003','2017-07-20 02:09:06','20177T2',2017,7),(6,0,2000,-2000,'hjs00004','2017-07-20 02:09:06','20177T2',2017,7),(7,2400,10512,-8112,'hjs00002','2017-07-20 02:13:07','20177T3',2017,7),(8,0,1500,-1500,'hjs00003','2017-07-20 02:13:07','20177T3',2017,7),(9,0,2000,-2000,'hjs00004','2017-07-20 02:13:07','20177T3',2017,7),(10,57400,11976,45424,'hjs00002','2017-07-20 02:26:27','20177T4',2017,7),(11,0,1500,-1500,'hjs00003','2017-07-20 02:26:27','20177T4',2017,7),(12,0,2000,-2000,'hjs00004','2017-07-20 02:26:27','20177T4',2017,7),(13,0,10083.3,-10083.3,'hjs00002','2017-07-20 07:00:51','20178T1',2017,8),(14,0,1883.3,-1883.3,'hjs00003','2017-07-20 07:00:51','20178T1',2017,8),(15,0,1750,-1750,'hjs00004','2017-07-20 07:00:51','20178T1',2017,8),(16,0,1083.3,-1083.3,'hjs00005','2017-07-20 07:00:51','20178T1',2017,8);
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
INSERT INTO `commission_details` VALUES (1,'hjs00002','hjs00002T8',1200,0,0,2017,7,'2017-07-20 02:04:08','20177T1','1'),(2,'hjs00002','hjs00002T8',1200,0,0,2017,7,'2017-07-20 02:09:06','20177T2','1'),(3,'hjs00002','hjs00002T8',1200,0,0,2017,7,'2017-07-20 02:13:07','20177T3','1'),(4,'hjs00002','hjs00002T8',1200,50000,0,2017,7,'2017-07-20 02:26:27','20177T4','2'),(5,'hjs00002','hjs00002T9',0,0,5000,2017,7,'2017-07-20 02:26:27','20177T4','1');
/*!40000 ALTER TABLE `commission_details` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cost_details`
--

LOCK TABLES `cost_details` WRITE;
/*!40000 ALTER TABLE `cost_details` DISABLE KEYS */;
INSERT INTO `cost_details` VALUES (1,'人员工资[总店分摊]',2000,'hjs00002',2017,7,'20177T1','2017-07-20 02:07:08'),(2,'人员工资[总店分摊]',2000,'hjs00003',2017,7,'20177T1','2017-07-20 02:07:08'),(3,'人员工资[总店分摊]',2000,'hjs00004',2017,7,'20177T1','2017-07-20 02:07:08'),(4,'区域经理[工资分摊]',500,'hjs00002',2017,7,'20177T1','2017-07-20 02:07:08'),(5,'区域经理[工资分摊]',500,'hjs00003',2017,7,'20177T1','2017-07-20 02:07:08'),(6,'区域经理[工资分摊]',1000,'hjs00004',2017,7,'20177T1','2017-07-20 02:07:08'),(7,'过户费用[总店分摊]',0,'hjs00002',2017,7,'20177T1','2017-07-20 02:07:08'),(8,'过户费用[总店分摊]',0,'hjs00003',2017,7,'20177T1','2017-07-20 02:07:08'),(9,'过户费用[总店分摊]',0,'hjs00004',2017,7,'20177T1','2017-07-20 02:07:08'),(10,'asd',6000,'hjs00002',2017,7,'20177T1','2017-07-20 02:04:08'),(11,'人员工资[总店分摊]',1000,'hjs00002',2017,7,'20177T2','2017-07-20 02:07:06'),(12,'人员工资[总店分摊]',1000,'hjs00003',2017,7,'20177T2','2017-07-20 02:07:06'),(13,'人员工资[总店分摊]',1000,'hjs00004',2017,7,'20177T2','2017-07-20 02:07:06'),(14,'区域经理[工资分摊]',500,'hjs00002',2017,7,'20177T2','2017-07-20 02:07:06'),(15,'区域经理[工资分摊]',500,'hjs00003',2017,7,'20177T2','2017-07-20 02:07:06'),(16,'区域经理[工资分摊]',1000,'hjs00004',2017,7,'20177T2','2017-07-20 02:07:06'),(17,'过户费用[总店分摊]',0,'hjs00002',2017,7,'20177T2','2017-07-20 02:07:06'),(18,'过户费用[总店分摊]',0,'hjs00003',2017,7,'20177T2','2017-07-20 02:07:06'),(19,'过户费用[总店分摊]',0,'hjs00004',2017,7,'20177T2','2017-07-20 02:07:06'),(20,'asd',6000,'hjs00002',2017,7,'20177T2','2017-07-20 02:09:06'),(21,'人员工资[总店分摊]',1000,'hjs00002',2017,7,'20177T3','2017-07-20 02:07:06'),(22,'人员工资[总店分摊]',1000,'hjs00003',2017,7,'20177T3','2017-07-20 02:07:06'),(23,'人员工资[总店分摊]',1000,'hjs00004',2017,7,'20177T3','2017-07-20 02:07:06'),(24,'区域经理[工资分摊]',500,'hjs00002',2017,7,'20177T3','2017-07-20 02:07:06'),(25,'区域经理[工资分摊]',500,'hjs00003',2017,7,'20177T3','2017-07-20 02:07:07'),(26,'区域经理[工资分摊]',1000,'hjs00004',2017,7,'20177T3','2017-07-20 02:07:07'),(27,'asd',6000,'hjs00002',2017,7,'20177T3','2017-07-20 02:13:07'),(28,'人员工资[总店分摊]',1000,'hjs00002',2017,7,'20177T4','2017-07-20 02:07:27'),(29,'人员工资[总店分摊]',1000,'hjs00003',2017,7,'20177T4','2017-07-20 02:07:27'),(30,'人员工资[总店分摊]',1000,'hjs00004',2017,7,'20177T4','2017-07-20 02:07:27'),(31,'区域经理[工资分摊]',500,'hjs00002',2017,7,'20177T4','2017-07-20 02:07:27'),(32,'区域经理[工资分摊]',500,'hjs00003',2017,7,'20177T4','2017-07-20 02:07:27'),(33,'区域经理[工资分摊]',1000,'hjs00004',2017,7,'20177T4','2017-07-20 02:07:27'),(34,'asd',6000,'hjs00002',2017,7,'20177T4','2017-07-20 02:26:27'),(35,'人员工资[总店分摊]',750,'hjs00002',2017,8,'20178T1','2017-07-19 19:07:51'),(36,'人员工资[总店分摊]',750,'hjs00003',2017,8,'20178T1','2017-07-19 19:07:51'),(37,'人员工资[总店分摊]',750,'hjs00004',2017,8,'20178T1','2017-07-19 19:07:51'),(38,'人员工资[总店分摊]',750,'hjs00005',2017,8,'20178T1','2017-07-19 19:07:51'),(39,'区域经理[工资分摊]',333.3,'hjs00002',2017,8,'20178T1','2017-07-19 19:07:51'),(40,'区域经理[工资分摊]',333.3,'hjs00003',2017,8,'20178T1','2017-07-19 19:07:51'),(41,'区域经理[工资分摊]',333.3,'hjs00005',2017,8,'20178T1','2017-07-19 19:07:51'),(42,'区域经理[工资分摊]',1000,'hjs00004',2017,8,'20178T1','2017-07-19 19:07:51'),(43,'asd',6000,'hjs00002',2017,8,'20178T1','2017-07-19 19:00:51'),(44,'test',800,'hjs00003',2017,8,'20178T1','2017-07-19 19:00:51');
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
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=gbk;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_position`
--

LOCK TABLES `employee_position` WRITE;
/*!40000 ALTER TABLE `employee_position` DISABLE KEYS */;
INSERT INTO `employee_position` VALUES (14,'123132123123123123123','jl01','hj001'),(15,'120254','cw01','hj001'),(16,'123123','gh01','hj001'),(24,'hjs00002T7','dz01','hjs00002'),(23,'qy00T1T6','qy01','qy00T1'),(22,'qy00T2T5','qy01','qy00T2'),(25,'hjs00002T8','zl01','hjs00002'),(26,'hjs00002T9','xs01','hjs00002');
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk;
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
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1);
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reduce_salary`
--

LOCK TABLES `reduce_salary` WRITE;
/*!40000 ALTER TABLE `reduce_salary` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salary_details`
--

LOCK TABLES `salary_details` WRITE;
/*!40000 ALTER TABLE `salary_details` DISABLE KEYS */;
INSERT INTO `salary_details` VALUES (1,'123132123123123123123',1000,2017,7,'2017-07-20 02:02:06',1,'20177T1','hj001'),(2,'120254',1000,2017,7,'2017-07-20 02:02:06',1,'20177T1','hj001'),(3,'123123',1000,2017,7,'2017-07-20 02:02:06',1,'20177T1','hj001'),(4,'123132123123123123123',1000,2017,7,'2017-07-20 02:04:08',1,'20177T1','hj001'),(5,'120254',1000,2017,7,'2017-07-20 02:04:08',1,'20177T1','hj001'),(6,'123123',1000,2017,7,'2017-07-20 02:04:08',1,'20177T1','hj001'),(7,'qy00T2T5',1000,2017,7,'2017-07-20 02:04:08',2,'20177T1','qy00T2'),(8,'qy00T1T6',1000,2017,7,'2017-07-20 02:04:08',2,'20177T1','qy00T1'),(9,'hjs00002T7',1000,2017,7,'2017-07-20 02:04:08',2,'20177T1','hjs00002'),(10,'hjs00002T8',1000,2017,7,'2017-07-20 02:04:08',2,'20177T1','hjs00002'),(11,'hjs00002T9',1000,2017,7,'2017-07-20 02:04:08',2,'20177T1','hjs00002'),(12,'123132123123123123123',1000,2017,7,'2017-07-20 02:09:06',1,'20177T2','hj001'),(13,'120254',1000,2017,7,'2017-07-20 02:09:06',1,'20177T2','hj001'),(14,'123123',1000,2017,7,'2017-07-20 02:09:06',1,'20177T2','hj001'),(15,'qy00T2T5',1000,2017,7,'2017-07-20 02:09:06',2,'20177T2','qy00T2'),(16,'qy00T1T6',1000,2017,7,'2017-07-20 02:09:06',2,'20177T2','qy00T1'),(17,'hjs00002T7',1000,2017,7,'2017-07-20 02:09:06',2,'20177T2','hjs00002'),(18,'hjs00002T8',1000,2017,7,'2017-07-20 02:09:06',2,'20177T2','hjs00002'),(19,'hjs00002T9',1000,2017,7,'2017-07-20 02:09:06',2,'20177T2','hjs00002'),(20,'123132123123123123123',1000,2017,7,'2017-07-20 02:13:06',1,'20177T3','hj001'),(21,'120254',1000,2017,7,'2017-07-20 02:13:06',1,'20177T3','hj001'),(22,'123123',1000,2017,7,'2017-07-20 02:13:06',1,'20177T3','hj001'),(23,'qy00T2T5',1000,2017,7,'2017-07-20 02:13:06',2,'20177T3','qy00T2'),(24,'qy00T1T6',1000,2017,7,'2017-07-20 02:13:06',2,'20177T3','qy00T1'),(25,'hjs00002T7',1000,2017,7,'2017-07-20 02:13:06',2,'20177T3','hjs00002'),(26,'hjs00002T8',1000,2017,7,'2017-07-20 02:13:06',2,'20177T3','hjs00002'),(27,'hjs00002T9',1000,2017,7,'2017-07-20 02:13:06',2,'20177T3','hjs00002'),(28,'123132123123123123123',1000,2017,7,'2017-07-20 02:26:27',1,'20177T4','hj001'),(29,'120254',1000,2017,7,'2017-07-20 02:26:27',1,'20177T4','hj001'),(30,'123123',1000,2017,7,'2017-07-20 02:26:27',1,'20177T4','hj001'),(31,'qy00T2T5',1000,2017,7,'2017-07-20 02:26:27',2,'20177T4','qy00T2'),(32,'qy00T1T6',1000,2017,7,'2017-07-20 02:26:27',2,'20177T4','qy00T1'),(33,'hjs00002T7',1000,2017,7,'2017-07-20 02:26:27',2,'20177T4','hjs00002'),(34,'hjs00002T8',1000,2017,7,'2017-07-20 02:26:27',2,'20177T4','hjs00002'),(35,'hjs00002T9',1000,2017,7,'2017-07-20 02:26:27',2,'20177T4','hjs00002'),(36,'123132123123123123123',1000,2017,8,'2017-07-19 19:00:51',1,'20178T1','hj001'),(37,'120254',1000,2017,8,'2017-07-19 19:00:51',1,'20178T1','hj001'),(38,'123123',1000,2017,8,'2017-07-19 19:00:51',1,'20178T1','hj001'),(39,'qy00T2T5',1000,2017,8,'2017-07-19 19:00:51',2,'20178T1','qy00T2'),(40,'qy00T1T6',1000,2017,8,'2017-07-19 19:00:51',2,'20178T1','qy00T1'),(41,'hjs00002T7',1000,2017,8,'2017-07-19 19:00:51',2,'20178T1','hjs00002'),(42,'hjs00002T8',1000,2017,8,'2017-07-19 19:00:51',2,'20178T1','hjs00002'),(43,'hjs00002T9',1000,2017,8,'2017-07-19 19:00:51',2,'20178T1','hjs00002');
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
  `rule_key` int(50) NOT NULL COMMENT '规则key:1:销售阶梯提成；2:助理分红；3:店长分红（本店）；4:区域经理分红；5:总经理；6:二级分店；7:一手分成比例；8:二手手方分成；9:租售提成',
  `top` varchar(50) DEFAULT NULL COMMENT '范围上限',
  `bottom` int(11) DEFAULT NULL COMMENT '范围下限',
  `percentage` float NOT NULL COMMENT '百分比',
  `is_cost` int(11) NOT NULL COMMENT '店铺成本:0-不作，1-作',
  `status_del` int(11) NOT NULL DEFAULT '0' COMMENT '0--存在 ，1--不存在',
  `position_code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_bonus_rule`
--

LOCK TABLES `staff_bonus_rule` WRITE;
/*!40000 ALTER TABLE `staff_bonus_rule` DISABLE KEYS */;
INSERT INTO `staff_bonus_rule` VALUES (1,1,'+00',0,0,1,1,NULL),(2,1,'+00',0,0,1,1,NULL),(3,1,'+00',0,0,1,1,NULL),(4,1,'5000',0,0.01,1,0,NULL),(5,1,'6000',5001,0.02,1,0,NULL),(6,1,'+00',6001,0.03,1,0,NULL),(7,2,NULL,NULL,0.02,0,0,NULL),(8,3,NULL,NULL,0.03,0,0,NULL),(9,4,NULL,NULL,0.04,0,0,NULL),(10,5,NULL,NULL,0.05,0,0,NULL),(11,6,NULL,NULL,0.05,0,0,NULL),(12,7,NULL,NULL,0.95,0,0,NULL),(13,8,NULL,NULL,0.05,0,0,NULL),(14,9,NULL,NULL,0.05,0,0,NULL),(15,10,NULL,0,0,0,0,'xs01'),(16,10,NULL,5000,0,0,0,'xs02'),(17,10,NULL,36000,0,0,0,'xs03'),(18,10,NULL,48000,0,0,0,'xs04'),(19,10,NULL,66000,0,0,0,'xs05');
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_contract`
--

LOCK TABLES `staff_contract` WRITE;
/*!40000 ALTER TABLE `staff_contract` DISABLE KEYS */;
INSERT INTO `staff_contract` VALUES (1,'0231564889','hjs00002T8',12000,1200,1,2017,7,'hjs00002','2017-07-20 01:53:54','2017-07-20 01:52:56',20,0,1,0,'0','asd','胡三路',1200),(2,'12323','hjs00002T8',1232230,50000,1,2017,7,'hjs00002','2017-07-20 02:23:40','2017-07-20 02:23:11',18,0,2,0,'0','','1222',50000),(3,'1200000','hjs00002T9',12000,5000,1,2017,7,'hjs00002','2017-07-20 02:26:13','2017-07-20 02:25:54',19,0,3,0,'0','12','12000',5000);
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
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_employee`
--

LOCK TABLES `staff_employee` WRITE;
/*!40000 ALTER TABLE `staff_employee` DISABLE KEYS */;
INSERT INTO `staff_employee` VALUES (37,'bruce_zj',0,'2017-06','2312312312312','13213123123','addr','2017-06',1,'','2017-07-19 08:53:20','123132123123123123123','2017-06-30 01:29:29'),(38,'bruce_cw',1,'2017-06','2356456','12312312312','aaa','2017-06',1,'',NULL,'120254','2017-06-30 01:30:11'),(39,'bruce_gh',1,'2017-06','123123123123123123','12312312312','addr','2017-06',1,'',NULL,'123123','2017-06-30 01:30:38'),(59,'东湖区域',0,'2017-07','121231213152312121','12323520323','addt','2017-06',1,'',NULL,'qy00T2T5','2017-07-20 01:48:30'),(60,'东南区域经理',0,'2017-07','121233212313212312','13265952323','addr','2017-07',1,'',NULL,'qy00T1T6','2017-07-20 01:49:03'),(61,'胡三',0,'2017-07-28','122222222222222222','12312311111','addr','2017-07-13',1,'',NULL,'hjs00002T7','2017-07-20 01:50:43'),(62,'李四',0,'2017-07-13','111111111111111111','12345678911','addr','2017-07-13',1,'',NULL,'hjs00002T8','2017-07-20 01:51:07'),(63,'销售1',0,'2017-07-20','122222222222222222','12321312312','addr','2017-07-13',1,'',NULL,'hjs00002T9','2017-07-20 01:51:34');
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
  `staff_portcol` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_port`
--

LOCK TABLES `staff_port` WRITE;
/*!40000 ALTER TABLE `staff_port` DISABLE KEYS */;
INSERT INTO `staff_port` VALUES (1,'','hjs00002T8','hjs00002','test',12000,2017,7,12,'[{\"year\":2017,\"month\":7},{\"year\":2017,\"month\":8},{\"year\":2017,\"month\":9},{\"year\":2017,\"month\":10},{\"year\":2017,\"month\":11},{\"year\":2017,\"month\":12},{\"year\":2018,\"month\":1},{\"year\":2018,\"month\":2},{\"year\":2018,\"month\":3},{\"year\":2018,\"month\":4},{\"year\":2018,\"month\":5},{\"year\":2018,\"month\":6}]',1,'123512',1000,'平台12323',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_position`
--

LOCK TABLES `staff_position` WRITE;
/*!40000 ALTER TABLE `staff_position` DISABLE KEYS */;
INSERT INTO `staff_position` VALUES (1,'hj001','jl01','总经理',1,1000,0,'总经理'),(2,'hj001','gh01','过户',1,1000,0,'过户专员'),(5,'hj001','cw01','财务',1,1000,0,'财务专员'),(22,'hjs00004','dz01','店长',1,1000,0,'店长'),(23,'hjs00004','zl01','店长助理',1,1000,0,'店长助理'),(24,'hjs00004','xs01','销售',1,1000,0,'见习置业顾问'),(25,'hjs00004','xs02','销售',2,1000,0,'置业顾问'),(26,'hjs00004','xs03','销售',3,1000,0,'高级置业顾问'),(27,'hjs00004','xs04','销售',4,1000,0,'主任置业顾问'),(28,'hjs00004','xs05','销售',5,1000,0,'金牌置业顾问'),(29,'qy00T2','qy01','区域经理',1,1000,0,'区域经理'),(30,'qy00T3','qy01','区域经理',1,1000,0,'区域经理'),(31,'qy00T1','qy01','区域经理',1,1000,0,'区域经理'),(34,'qy00T4','qy01','区域经理',1,1000,0,'区域经理'),(35,'hjs00002','dz01','店长',1,1000,0,'店长'),(36,'hjs00002','zl01','店长助理',1,1000,0,'店长助理'),(37,'hjs00002','xs01','销售',1,1000,0,'见习置业顾问'),(38,'hjs00002','xs02','销售',2,1000,0,'置业顾问'),(39,'hjs00002','xs03','销售',3,1000,0,'高级置业顾问'),(40,'hjs00002','xs04','销售',4,1000,0,'主任置业顾问'),(41,'hjs00002','xs05','销售',5,1000,0,'金牌置业顾问'),(42,'hjs00003','dz01','店长',1,1000,0,'店长'),(43,'hjs00003','zl01','店长助理',1,1000,0,'店长助理'),(44,'hjs00003','xs01','销售',1,1000,0,'见习置业顾问'),(45,'hjs00003','xs02','销售',2,1000,0,'置业顾问'),(46,'hjs00003','xs03','销售',3,1000,0,'高级置业顾问'),(47,'hjs00003','xs04','销售',4,1000,0,'主任置业顾问'),(48,'hjs00003','xs05','销售',5,1000,0,'金牌置业顾问'),(49,'hjs00004','dz01','店长',1,1000,0,'店长'),(50,'hjs00004','zl01','店长助理',1,1000,0,'店长助理'),(51,'hjs00004','xs01','销售',1,1000,0,'见习置业顾问'),(52,'hjs00004','xs02','销售',2,1000,0,'置业顾问'),(53,'hjs00004','xs03','销售',3,1000,0,'高级置业顾问'),(54,'hjs00004','xs04','销售',4,1000,0,'主任置业顾问'),(55,'hjs00004','xs05','销售',5,1000,0,'金牌置业顾问'),(56,'hjs00005','dz01','店长',1,1000,0,'店长'),(57,'hjs00005','zl01','店长助理',1,1000,0,'店长助理'),(58,'hjs00005','xs01','销售',1,1000,0,'见习置业顾问'),(59,'hjs00005','xs02','销售',2,1000,0,'置业顾问'),(60,'hjs00005','xs03','销售',3,1000,0,'高级置业顾问'),(61,'hjs00005','xs04','销售',4,1000,0,'主任置业顾问'),(62,'hjs00005','xs05','销售',5,1000,0,'金牌置业顾问');
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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=gbk;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_position_level`
--

LOCK TABLES `staff_position_level` WRITE;
/*!40000 ALTER TABLE `staff_position_level` DISABLE KEYS */;
INSERT INTO `staff_position_level` VALUES (1,'1','一级','2221','0','xs01'),(2,'2','二级','2800','2222','xs02'),(3,'3','三级','NaN','3000','xs03');
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_transfer_record`
--

LOCK TABLES `staff_transfer_record` WRITE;
/*!40000 ALTER TABLE `staff_transfer_record` DISABLE KEYS */;
INSERT INTO `staff_transfer_record` VALUES (1,'hjs00002','123123',1200,2017,7,'2017-07-20 07:08:57','0231564889',20,0);
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
  `zone` int(4) NOT NULL COMMENT '区号',
  `name` varchar(128) NOT NULL COMMENT '城市名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store_city`
--

LOCK TABLES `store_city` WRITE;
/*!40000 ALTER TABLE `store_city` DISABLE KEYS */;
INSERT INTO `store_city` VALUES (1,513,'苏州');
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
INSERT INTO `store_company` VALUES (1,'江苏公司',NULL,1,NULL,NULL,'2017-05-29 06:32:16','888');
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store_cost`
--

LOCK TABLES `store_cost` WRITE;
/*!40000 ALTER TABLE `store_cost` DISABLE KEYS */;
INSERT INTO `store_cost` VALUES (1,12000,'asd',7,2,'hjs00002','[\"hjs00002\"]',6000,'[{\"year\":2017,\"month\":7},{\"year\":2017,\"month\":8}]','2017-07-20 01:45:08',2017),(3,1200,'随便的成本',7,1,'hjs00003','[\"hjs00003\"]',1200,'[{\"year\":2017,\"month\":4}]','2017-07-20 06:27:05',2017),(4,12000,'test',7,15,'hjs00003','[\"hjs00003\"]',800,'[{\"year\":2017,\"month\":7},{\"year\":2017,\"month\":8},{\"year\":2017,\"month\":9},{\"year\":2017,\"month\":10},{\"year\":2017,\"month\":11},{\"year\":2017,\"month\":12},{\"year\":2018,\"month\":1},{\"year\":2018,\"month\":2},{\"year\":2018,\"month\":3},{\"year\":2018,\"month\":4},{\"year\":2018,\"month\":5},{\"year\":2018,\"month\":6},{\"year\":2018,\"month\":7},{\"year\":2018,\"month\":8},{\"year\":2018,\"month\":9}]','2017-07-20 06:40:42',2017);
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store_income`
--

LOCK TABLES `store_income` WRITE;
/*!40000 ALTER TABLE `store_income` DISABLE KEYS */;
INSERT INTO `store_income` VALUES (1,1200,'置换费',7,2017,'hjs00002','2017-07-20 01:43:24',NULL);
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
  `city_zone` varchar(50) DEFAULT NULL COMMENT '所属城市邮编',
  `parent_code` varchar(50) DEFAULT '0' COMMENT '父级店铺编号',
  `company_code` varchar(50) NOT NULL COMMENT '所属公司',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `status_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'del状态 1-删除，0-未删除',
  `zone_code` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '区域code',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store_store`
--

LOCK TABLES `store_store` WRITE;
/*!40000 ALTER TABLE `store_store` DISABLE KEYS */;
INSERT INTO `store_store` VALUES (19,'hj001','xxx总公司','addr',1,1,'0513','0','888','2017-07-04 07:34:04',NULL,0,''),(41,'hjs00002','灵动','asd',1,2,'0513','','888',NULL,'2017-07-20 01:41:29',0,'qy00T2'),(42,'hjs00003','水合','虎山',1,2,'0513','','888',NULL,'2017-07-20 01:41:45',0,'qy00T2'),(43,'hjs00004','东湖一号','阿萨德',1,2,'0513','','888',NULL,'2017-07-20 01:42:08',0,'qy00T1'),(44,'hjs00005','test','123',1,2,'0513','','888',NULL,'2017-07-20 06:45:26',0,'qy00T2');
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
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=gbk;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store_zone`
--

LOCK TABLES `store_zone` WRITE;
/*!40000 ALTER TABLE `store_zone` DISABLE KEYS */;
INSERT INTO `store_zone` VALUES (12,'东湖校区','qy00T2',1,NULL,'addr','2017-07-20 01:40:17'),(11,'东南开发区','qy00T1',1,NULL,'999','2017-07-20 01:40:03'),(13,'方塔','qy00T3',1,NULL,'123','2017-07-20 01:40:27'),(14,'漕泾','qy00T4',1,NULL,'4568','2017-07-20 01:40:48');
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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (5,'cw','e10adc3949ba59abbe56e057f20f883e','120254',1,NULL,NULL),(7,'jl','e10adc3949ba59abbe56e057f20f883e','123132123123123123123',1,NULL,NULL),(8,'gh','e10adc3949ba59abbe56e057f20f883e','123123',1,NULL,NULL),(15,'阿斯顿','e10adc3949ba59abbe56e057f20f883e',' 公寓',1,NULL,NULL),(20,'销售01','e10adc3949ba59abbe56e057f20f883e','hjs00002T4',1,NULL,NULL),(21,'东南店长','e10adc3949ba59abbe56e057f20f883e','hjs00002T5',1,NULL,NULL),(22,'东南区域','e10adc3949ba59abbe56e057f20f883e','qy00T1T6',1,NULL,NULL),(23,'seller1','e10adc3949ba59abbe56e057f20f883e','hjs00002T7',1,NULL,NULL),(24,'东湖区域','e10adc3949ba59abbe56e057f20f883e','qy00T2T5',1,NULL,NULL),(25,'东南区域经理','e10adc3949ba59abbe56e057f20f883e','qy00T1T6',1,NULL,NULL),(26,'胡三','e10adc3949ba59abbe56e057f20f883e','hjs00002T7',1,NULL,NULL),(27,'李四','e10adc3949ba59abbe56e057f20f883e','hjs00002T8',1,NULL,NULL),(28,'销售1','e10adc3949ba59abbe56e057f20f883e','hjs00002T9',1,NULL,NULL);
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'locqj','lcoqj@163.com','$2y$10$rJGk0y/hqTa/A5TgJNf0deY6YiKOqF1NxbEw8Hx7V1dYj/bC9Lfuq','BtEsH01cu9mw2QohsmmYzRveCvuokDCEiNGwzkwMR79nYDoaHUgv6NWHzGVp','2017-07-01 21:46:13','2017-07-01 22:07:42','',NULL,NULL,NULL),(2,'bruce','lcoqaj@163.com','$10$rJGk0y/hqTa/A5TgJNf0deY6YiKOqF1NxbEw8Hx7V1dYj/bC9Lfuq',NULL,NULL,NULL,'',NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-20 16:07:54
