-- MySQL dump 10.13  Distrib 5.5.47, for Win32 (x86)
--
-- Host: localhost    Database: hengju
-- ------------------------------------------------------
-- Server version	5.5.47

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
  `bonus_amount` float NOT NULL COMMENT '提成金额',
  `employee_code` varchar(50) NOT NULL COMMENT '员工编号',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `is_cost` int(11) NOT NULL COMMENT '店铺成本:0-不作，1-作',
  `store_type` int(11) NOT NULL COMMENT '店铺类型',
  `update_code` int(11) NOT NULL COMMENT '表唯一标识',
  `bonus_rule_key` varchar(50) NOT NULL COMMENT '(提成，分红)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bonus_details`
--

LOCK TABLES `bonus_details` WRITE;
/*!40000 ALTER TABLE `bonus_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `bonus_details` ENABLE KEYS */;
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
  `amount` float NOT NULL COMMENT '佣金额度',
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `update_code` varchar(255) NOT NULL COMMENT '表唯一标识',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commission_details`
--

LOCK TABLES `commission_details` WRITE;
/*!40000 ALTER TABLE `commission_details` DISABLE KEYS */;
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
  `update_code` int(11) NOT NULL COMMENT '表唯一标识',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cost_details`
--

LOCK TABLES `cost_details` WRITE;
/*!40000 ALTER TABLE `cost_details` DISABLE KEYS */;
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
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1--存在，0--不存在',
  `store_code` varchar(50) NOT NULL COMMENT '店铺编号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=gbk;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_position`
--

LOCK TABLES `employee_position` WRITE;
/*!40000 ALTER TABLE `employee_position` DISABLE KEYS */;
INSERT INTO `employee_position` VALUES (1,'F0001','gh001',1,'1'),(2,'cqj','zjl001',1,'1'),(4,'Z003','zl02',1,'00002'),(5,'F002','gh001',1,'1'),(6,'00002','qy001',1,'1'),(10,'03001','03001',1,'00003'),(7,'9999','zl02',1,'00002'),(8,'99999','xs03',1,'00002'),(9,'911','xs03',1,'00002'),(11,'03002','03xs01',1,'00003'),(12,'01gh003','gh001',1,'1');
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
  `store_code` varchar(50) NOT NULL COMMENT '店铺编号',
  `position_code` varchar(50) NOT NULL COMMENT '职位编号',
  `salary` float DEFAULT NULL COMMENT '基本工资',
  `bonus` float DEFAULT NULL COMMENT '提成',
  `dividend` float DEFAULT NULL COMMENT '分红',
  `others` float DEFAULT NULL COMMENT '其他',
  `year` int(50) NOT NULL,
  `month` int(50) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `record_user` varchar(50) NOT NULL COMMENT '录入员',
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
  `store_type` int(11) NOT NULL COMMENT '店铺类型',
  `update_code` varchar(50) NOT NULL COMMENT '表唯一标识',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salary_details`
--

LOCK TABLES `salary_details` WRITE;
/*!40000 ALTER TABLE `salary_details` DISABLE KEYS */;
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
  `position_code` varchar(50) NOT NULL COMMENT '所属职位代号',
  `rule_key` varchar(50) NOT NULL COMMENT '规则key （销售，分红）',
  `top` varchar(50) DEFAULT NULL COMMENT '范围上限',
  `buttom` varchar(50) DEFAULT NULL COMMENT '范围下限',
  `percentage` varchar(50) NOT NULL COMMENT '百分比',
  `is_cost` int(11) NOT NULL COMMENT '店铺成本:0-不作，1-作',
  `status_del` int(11) NOT NULL DEFAULT '0' COMMENT '0--存在 ，1--不存在',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_bonus_rule`
--

LOCK TABLES `staff_bonus_rule` WRITE;
/*!40000 ALTER TABLE `staff_bonus_rule` DISABLE KEYS */;
INSERT INTO `staff_bonus_rule` VALUES (1,'dz01','fh001','10000','0','10%',1,0),(3,'dz01','fh001','20000','10000','20%',1,0),(4,'dz01','fh001','30000','20000','25%',1,0),(5,'dz01','fh001','++','30000','30%',1,0);
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
  `real_amount` float DEFAULT NULL COMMENT '结单额度',
  `is_signed` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否结佣：1-是，0-不是',
  `year` int(11) NOT NULL COMMENT '年',
  `month` int(11) NOT NULL COMMENT '月',
  `store_code` varchar(50) NOT NULL COMMENT '店铺编号',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `day` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_contract`
--

LOCK TABLES `staff_contract` WRITE;
/*!40000 ALTER TABLE `staff_contract` DISABLE KEYS */;
INSERT INTO `staff_contract` VALUES (1,'123456','Z003',2000,5000,0,2017,5,'00002','2017-05-23 12:13:00','2017-05-23 07:50:07',2),(2,'00001','Z003',123.1,12223.1,1,2017,5,'00002','2017-05-23 12:11:36','2017-05-23 07:55:25',24),(3,'2310','F002',2006,10000,0,2017,7,'00002','2017-05-23 13:11:11','2017-05-23 11:37:53',14),(4,'000023','Z003',123456,123542,1,2016,2,'00001','2017-05-24 11:23:27','2017-05-23 12:32:33',10),(5,'10000','9999',12000,13000,0,2017,5,'00002',NULL,'2017-05-26 12:00:55',31),(6,'10001','911',1200,3210,1,2017,3,'00002',NULL,'2017-05-26 12:01:37',17),(7,'1000321','03002',1000,1200,0,2017,5,'00003',NULL,'2017-05-29 07:12:23',29);
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_employee`
--

LOCK TABLES `staff_employee` WRITE;
/*!40000 ALTER TABLE `staff_employee` DISABLE KEYS */;
INSERT INTO `staff_employee` VALUES (2,'陈勤',0,'1994',NULL,'2272962','ok','2017',1,'','2017-05-21 09:21:55','F0001','2017-05-15 23:36:17'),(3,'李宇春',0,'1994-06-30',NULL,'15501526809','惠州','2014-06-30',1,'zjl001','2017-05-20 05:50:53','00002','2017-05-15 23:47:05'),(4,'locqj',1,'2016',NULL,'13622665421','','2016',1,'','2017-05-20 05:50:55','cqj','2017-05-15 23:47:58'),(5,'ppd',0,'1994-06-30',NULL,'15501526809','惠州','2014-06-30',1,'zl02','2017-05-20 05:50:56','Z003','2017-05-15 23:59:53'),(6,'刘德华',0,'1994-6-15',NULL,'110','苏州','1994-6-15',1,'dz02','2017-05-20 05:50:58','F002','2017-05-16 00:15:15'),(7,'啊乐',1,'2017-05','443211','110','阿斯顿','2017-05',1,'',NULL,'9999','2017-05-20 21:58:37'),(8,'啊乐a',1,'2017-05','443211','110','阿斯顿','2017-05',1,'',NULL,'99999','2017-05-20 21:59:46'),(9,'阿古',1,'2017-01','110','110','addr','2017-05',1,'',NULL,'911','2017-05-20 22:02:11'),(10,'好丽友',1,'2017-05','110','110','湖山路333','2017-05',1,'',NULL,'03001','2017-05-28 23:08:58'),(11,'蛋黄派',1,'2017-05','120','120','黄山路9号','2017-05',1,'',NULL,'03002','2017-05-28 23:11:26'),(12,'理查德',1,'2017-05','1223','120','纽约','2017-05',1,'',NULL,'01gh003','2017-05-28 23:14:22');
/*!40000 ALTER TABLE `staff_employee` ENABLE KEYS */;
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_position`
--

LOCK TABLES `staff_position` WRITE;
/*!40000 ALTER TABLE `staff_position` DISABLE KEYS */;
INSERT INTO `staff_position` VALUES (1,'00002','dz0022222','店长',1,23000,0),(2,'00002','zl02','店长助理',1,2000,0),(3,'00002','xs02','销售',1,2000,0),(4,'1','zjl001','总经理',1,2000,0),(8,'1','gh001','过户',1,2000,0),(9,'1','qy001','区域经理',1,20000,0),(10,'00002','xs03','销售',2,3000,0),(11,'00002','xs04','销售',3,4000,0),(12,'00002','sd02','扫地的',1,200,0),(13,'1','00001','店长助理',1,20000,0),(14,'00003','03001','店长',1,200000,0),(15,'00003','03xs01','销售',1,2000,0),(16,'00003','03xs02','销售',2,3000,0);
/*!40000 ALTER TABLE `staff_position` ENABLE KEYS */;
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_transfer_record`
--

LOCK TABLES `staff_transfer_record` WRITE;
/*!40000 ALTER TABLE `staff_transfer_record` DISABLE KEYS */;
INSERT INTO `staff_transfer_record` VALUES (5,'00002','01gh003',1200,2017,5,'2017-05-17 03:55:58','2310',30),(10,'00002','F0001',1200.1,2017,5,'2017-05-17 12:56:07','123456',21),(11,'00002','F0001',10,2017,2,'2017-05-29 06:06:37','00001',10),(12,'00002','F002',1,2017,4,'2017-05-29 06:08:18','10000',20),(13,'00002','F0001',10,2017,5,'2017-05-29 06:08:36','10001',25),(14,'00003','F0001',120,2017,5,'2017-05-29 07:12:46','1000321',29);
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
  `cateqory` varchar(128) NOT NULL COMMENT '类目',
  `month` int(255) NOT NULL COMMENT '创建月份',
  `length` int(10) NOT NULL COMMENT '分期数',
  `owner_store_code` varchar(50) NOT NULL COMMENT '费用所属店铺',
  `pay_stores` varchar(255) NOT NULL COMMENT '还款店铺',
  `unit` float NOT NULL COMMENT '每期还款金额',
  `pay_month` varchar(255) NOT NULL COMMENT '偿还月份',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `year` int(11) NOT NULL COMMENT '创建年份',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store_cost`
--

LOCK TABLES `store_cost` WRITE;
/*!40000 ALTER TABLE `store_cost` DISABLE KEYS */;
INSERT INTO `store_cost` VALUES (7,1000,'test',5,0,'1','[\"1\",\"00002\",\"008\",\"808\",\"999\",\"324\",\"2112\",\"asd\",\"qwe\",\"00003\"]',200,'[{\"year\":\"2017\",\"month\":\"2\"},{\"year\":\"2017\",\"month\":3},{\"year\":\"2017\",\"month\":4},{\"year\":\"2017\",\"month\":5},{\"year\":\"2017\",\"month\":6}]','2017-05-29 06:58:37',2017);
/*!40000 ALTER TABLE `store_cost` ENABLE KEYS */;
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
  `parent_code` int(11) NOT NULL DEFAULT '0' COMMENT '父级店铺编号',
  `company_code` varchar(50) NOT NULL COMMENT '所属公司',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `status_del` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'del状态 1-删除，0-未删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store_store`
--

LOCK TABLES `store_store` WRITE;
/*!40000 ALTER TABLE `store_store` DISABLE KEYS */;
INSERT INTO `store_store` VALUES (1,'1','常熟总店','惠州',1,1,'0513',1,'888','2017-05-29 06:51:16','2017-05-17 15:08:46',0),(2,'00002','常熟分店1','惠州',1,2,'0513',1,'888','2017-05-29 06:48:40','2017-05-17 15:13:10',0),(6,'008','test','test',1,2,'0513',1,'888','2017-05-29 07:05:57','2017-05-19 11:13:39',1),(7,'808','test','test',1,2,'0513',1,'888','2017-05-29 07:05:59','2017-05-19 11:14:20',1),(8,'999','test','test',1,2,'0513',1,'888','2017-05-29 07:06:02','2017-05-19 11:15:06',1),(9,'124','name','add',1,2,'0513',1,'888','2017-05-20 14:17:36','2017-05-19 11:20:15',1),(10,'123','123','123',1,2,'0513',1,'888','2017-05-20 14:17:38','2017-05-19 15:21:40',1),(11,'324','123','213',1,2,'0513',1,'888','2017-05-29 07:06:30','2017-05-19 15:21:50',1),(12,'2112','3213','12',1,2,'0513',1,'888','2017-05-29 07:06:33','2017-05-19 15:22:03',1),(13,'asd','asd','asd',1,2,'0513',1,'888','2017-05-20 14:17:50','2017-05-20 09:35:43',1),(14,'asd','asd','asd',1,2,'0513',1,'888','2017-05-29 07:05:43','2017-05-20 13:23:43',1),(15,'qwe','qweqw','eqwe',1,2,'0513',1,'888','2017-05-29 07:05:48','2017-05-20 14:06:56',1),(16,'00003','常熟分店2','虎山路33号',1,2,'0513',1,'888',NULL,'2017-05-28 22:20:41',0);
/*!40000 ALTER TABLE `store_store` ENABLE KEYS */;
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
  `last_login_time` varchar(128) NOT NULL COMMENT '最后登陆时间',
  `last_login_ip` varchar(128) NOT NULL COMMENT '最后登陆ip',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-29 19:33:10
