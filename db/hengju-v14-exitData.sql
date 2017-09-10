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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bonus_details`
--

LOCK TABLES `bonus_details` WRITE;
/*!40000 ALTER TABLE `bonus_details` DISABLE KEYS */;
INSERT INTO `bonus_details` VALUES (1,5188,'hjs00002T4','2017-07-24 07:42:19',2017,7,1,2,'20177T1','1','hjs00002',NULL),(2,292,'hjs00003T6','2017-07-24 07:42:19',2017,7,1,2,'20177T1','1','hjs00003',NULL),(3,200,'hjs00004T8','2017-07-24 07:42:19',2017,7,1,2,'20177T1','1','hjs00004',NULL),(4,150,'hjs00005T12','2017-07-24 07:42:19',2017,7,1,2,'20177T1','1','hjs00005',NULL),(5,12844.8,'123132123123123123123','2017-07-24 07:42:19',2017,7,0,1,'20177T1','2','hj001','hjs00002'),(6,10275.8,'hjs00002T3','2017-07-24 07:42:19',2017,7,0,2,'20177T1','2','hjs00002',NULL),(7,10275.8,'qy00T1T9','2017-07-24 07:42:19',2017,7,0,3,'20177T1','2','qy00T1','hjs00002'),(8,5188,'hjs00002T4','2017-07-24 08:24:11',2017,7,1,2,'20177T2','1','hjs00002',NULL),(9,292,'hjs00003T6','2017-07-24 08:24:11',2017,7,1,2,'20177T2','1','hjs00003',NULL),(10,200,'hjs00004T8','2017-07-24 08:24:11',2017,7,1,2,'20177T2','1','hjs00004',NULL),(11,150,'hjs00005T12','2017-07-24 08:24:11',2017,7,1,2,'20177T2','1','hjs00005',NULL),(12,13444.8,'123132123123123123123','2017-07-24 08:24:11',2017,7,0,1,'20177T2','2','hj001','hjs00002'),(13,384.2,'123132123123123123123','2017-07-24 08:24:11',2017,7,0,1,'20177T2','2','hj001','hjs00003'),(14,107.1,'123132123123123123123','2017-07-24 08:24:11',2017,7,0,1,'20177T2','2','hj001','hjs00004'),(15,61.3,'123132123123123123123','2017-07-24 08:24:11',2017,7,0,1,'20177T2','2','hj001','hjs00005'),(16,10755.8,'hjs00002T3','2017-07-24 08:24:11',2017,7,0,2,'20177T2','2','hjs00002',NULL),(17,307.3,'hjs00003T5','2017-07-24 08:24:11',2017,7,0,2,'20177T2','2','hjs00003',NULL),(18,85.7,'hjs00004T7','2017-07-24 08:24:11',2017,7,0,2,'20177T2','2','hjs00004',NULL),(19,10755.8,'qy00T1T9','2017-07-24 08:24:11',2017,7,0,3,'20177T2','2','qy00T1','hjs00002'),(20,307.3,'qy00T1T9','2017-07-24 08:24:11',2017,7,0,3,'20177T2','2','qy00T1','hjs00003'),(21,85.7,'qy00T2T10','2017-07-24 08:24:11',2017,7,0,3,'20177T2','2','qy00T2','hjs00004'),(22,49,'qy00T2T10','2017-07-24 08:24:11',2017,7,0,3,'20177T2','2','qy00T2','hjs00005'),(23,49,'hjs00005T11','2017-07-24 08:24:11',2017,7,0,2,'20177T2','2','hjs00005',NULL),(24,2948,'hjs00002T4','2017-07-24 15:36:18',2017,7,1,2,'20177T3','1','hjs00002',NULL),(25,292,'hjs00003T6','2017-07-24 15:36:18',2017,7,1,2,'20177T3','1','hjs00003',NULL),(26,190,'hjs00004T8','2017-07-24 15:36:19',2017,7,1,2,'20177T3','1','hjs00004',NULL),(27,160,'hjs00005T12','2017-07-24 15:36:19',2017,7,1,2,'20177T3','1','hjs00005',NULL),(28,13556.8,'123132123123123123123','2017-07-24 15:36:19',2017,7,0,1,'20177T3','2','hj001','hjs00002'),(29,384.2,'123132123123123123123','2017-07-24 15:36:19',2017,7,0,1,'20177T3','2','hj001','hjs00003'),(30,107.6,'123132123123123123123','2017-07-24 15:36:19',2017,7,0,1,'20177T3','2','hj001','hjs00004'),(31,60.8,'123132123123123123123','2017-07-24 15:36:19',2017,7,0,1,'20177T3','2','hj001','hjs00005'),(32,10845.4,'hjs00002T3','2017-07-24 15:36:19',2017,7,0,2,'20177T3','2','hjs00002',NULL),(33,307.3,'hjs00003T5','2017-07-24 15:36:19',2017,7,0,2,'20177T3','2','hjs00003',NULL),(34,86.1,'hjs00004T7','2017-07-24 15:36:19',2017,7,0,2,'20177T3','2','hjs00004',NULL),(35,10845.4,'qy00T1T9','2017-07-24 15:36:19',2017,7,0,3,'20177T3','2','qy00T1','hjs00002'),(36,307.3,'qy00T1T9','2017-07-24 15:36:19',2017,7,0,3,'20177T3','2','qy00T1','hjs00003'),(37,86.1,'qy00T2T10','2017-07-24 15:36:19',2017,7,0,3,'20177T3','2','qy00T2','hjs00004'),(38,48.6,'qy00T2T10','2017-07-24 15:36:19',2017,7,0,3,'20177T3','2','qy00T2','hjs00005'),(39,48.6,'hjs00005T11','2017-07-24 15:36:19',2017,7,0,2,'20177T3','2','hjs00005',NULL);
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=gbk;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calculate_log`
--

LOCK TABLES `calculate_log` WRITE;
/*!40000 ALTER TABLE `calculate_log` DISABLE KEYS */;
INSERT INTO `calculate_log` VALUES (1,'20177T1','2017-07-24 15:42:19',0,'120254',7,2017),(2,'20177T2','2017-07-24 16:24:12',0,'120254',7,2017),(3,'20177T3','2017-07-24 23:36:19',1,'123132123123123123123',7,2017);
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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calculate_store`
--

LOCK TABLES `calculate_store` WRITE;
/*!40000 ALTER TABLE `calculate_store` DISABLE KEYS */;
INSERT INTO `calculate_store` VALUES (1,284200,27304.3,256896,'hjs00002','2017-07-24 07:42:19','20177T1',2017,7),(2,16800,21116.7,-4316.7,'hjs00003','2017-07-24 07:42:19','20177T1',2017,7),(3,11000,20858,-9858,'hjs00004','2017-07-24 07:42:19','20177T1',2017,7),(4,9200,19974.7,-10774.7,'hjs00005','2017-07-24 07:42:19','20177T1',2017,7),(5,284200,15304.6,268895,'hjs00002','2017-07-24 08:24:11','20177T2',2017,7),(6,16800,9116.9,7683.1,'hjs00003','2017-07-24 08:24:11','20177T2',2017,7),(7,11000,8858.2,2141.8,'hjs00004','2017-07-24 08:24:11','20177T2',2017,7),(8,9200,7974.9,1225.1,'hjs00005','2017-07-24 08:24:11','20177T2',2017,7),(9,284200,13064.6,271135,'hjs00002','2017-07-24 15:36:19','20177T3',2017,7),(10,16800,9116.9,7683.1,'hjs00003','2017-07-24 15:36:19','20177T3',2017,7),(11,11000,8848.2,2151.8,'hjs00004','2017-07-24 15:36:19','20177T3',2017,7),(12,9200,7984.9,1215.1,'hjs00005','2017-07-24 15:36:19','20177T3',2017,7);
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commission_details`
--

LOCK TABLES `commission_details` WRITE;
/*!40000 ALTER TABLE `commission_details` DISABLE KEYS */;
INSERT INTO `commission_details` VALUES (1,'hjs00002','hjs00002T4',112000,22200,0,2017,7,'2017-07-24 07:42:19','20177T1','3'),(2,'hjs00003','hjs00003T6',0,11800,0,2017,7,'2017-07-24 07:42:19','20177T1','2'),(3,'hjs00004','hjs00004T8',9500,0,0,2017,7,'2017-07-24 07:42:19','20177T1','1'),(4,'hjs00005','hjs00005T12',8000,0,0,2017,7,'2017-07-24 07:42:19','20177T1','1'),(5,'hjs00002','hjs00002T4',112000,22200,0,2017,7,'2017-07-24 08:24:11','20177T2','3'),(6,'hjs00003','hjs00003T6',0,11800,0,2017,7,'2017-07-24 08:24:11','20177T2','2'),(7,'hjs00004','hjs00004T8',9500,0,0,2017,7,'2017-07-24 08:24:11','20177T2','1'),(8,'hjs00005','hjs00005T12',8000,0,0,2017,7,'2017-07-24 08:24:11','20177T2','1'),(9,'hjs00002','hjs00002T4',112000,22200,0,2017,7,'2017-07-24 15:36:18','20177T3','3'),(10,'hjs00003','hjs00003T6',0,11800,0,2017,7,'2017-07-24 15:36:18','20177T3','2'),(11,'hjs00004','hjs00004T8',9500,0,0,2017,7,'2017-07-24 15:36:18','20177T3','1'),(12,'hjs00005','hjs00005T12',8000,0,0,2017,7,'2017-07-24 15:36:19','20177T3','1');
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
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cost_details`
--

LOCK TABLES `cost_details` WRITE;
/*!40000 ALTER TABLE `cost_details` DISABLE KEYS */;
INSERT INTO `cost_details` VALUES (1,'人员工资[总店分摊]',750,'hjs00002',2017,7,'20177T1','2017-07-24 07:42:18'),(2,'人员工资[总店分摊]',750,'hjs00003',2017,7,'20177T1','2017-07-24 07:42:18'),(3,'人员工资[总店分摊]',750,'hjs00004',2017,7,'20177T1','2017-07-24 07:42:18'),(4,'人员工资[总店分摊]',750,'hjs00005',2017,7,'20177T1','2017-07-24 07:42:18'),(5,'区域经理工资[区域分摊]',500,'hjs00002',2017,7,'20177T1','2017-07-24 07:42:18'),(6,'区域经理工资[区域分摊]',500,'hjs00003',2017,7,'20177T1','2017-07-24 07:42:18'),(7,'区域经理工资[区域分摊]',500,'hjs00004',2017,7,'20177T1','2017-07-24 07:42:18'),(8,'区域经理工资[区域分摊]',500,'hjs00005',2017,7,'20177T1','2017-07-24 07:42:18'),(9,'过户费用[总店分摊]',75,'hjs00002',2017,7,'20177T1','2017-07-24 07:42:18'),(10,'过户费用[总店分摊]',75,'hjs00003',2017,7,'20177T1','2017-07-24 07:42:18'),(11,'过户费用[总店分摊]',75,'hjs00004',2017,7,'20177T1','2017-07-24 07:42:18'),(12,'过户费用[总店分摊]',75,'hjs00005',2017,7,'20177T1','2017-07-24 07:42:18'),(13,'材料1',500,'hjs00003',2017,7,'20177T1','2017-07-24 07:42:18'),(14,'材料2',1000,'hjs00003',2017,7,'20177T1','2017-07-24 07:42:18'),(15,'水电',500,'hjs00005',2017,7,'20177T1','2017-07-24 07:42:18'),(16,'水电费',1000,'hjs00004',2017,7,'20177T1','2017-07-24 07:42:18'),(17,'端口费',333.33,'hjs00004',2017,7,'20177T1','2017-07-24 07:42:19'),(18,'房租[总店分摊]',10000,'hjs00002',2017,7,'20177T1','2017-07-24 07:42:19'),(19,'房租[总店分摊]',10000,'hjs00003',2017,7,'20177T1','2017-07-24 07:42:19'),(20,'房租[总店分摊]',10000,'hjs00004',2017,7,'20177T1','2017-07-24 07:42:19'),(21,'房租[总店分摊]',10000,'hjs00005',2017,7,'20177T1','2017-07-24 07:42:19'),(22,'广告[总店分摊]',5666.67,'hjs00002',2017,7,'20177T1','2017-07-24 07:42:19'),(23,'广告[总店分摊]',5666.67,'hjs00003',2017,7,'20177T1','2017-07-24 07:42:19'),(24,'广告[总店分摊]',5666.67,'hjs00004',2017,7,'20177T1','2017-07-24 07:42:19'),(25,'广告[总店分摊]',5666.67,'hjs00005',2017,7,'20177T1','2017-07-24 07:42:19'),(26,'水电[总店分摊]',333,'hjs00002',2017,7,'20177T1','2017-07-24 07:42:19'),(27,'水电[总店分摊]',333,'hjs00003',2017,7,'20177T1','2017-07-24 07:42:19'),(28,'水电[总店分摊]',333,'hjs00004',2017,7,'20177T1','2017-07-24 07:42:19'),(29,'水电[总店分摊]',333,'hjs00005',2017,7,'20177T1','2017-07-24 07:42:19'),(30,'房租',2500,'hjs00002',2017,7,'20177T1','2017-07-24 07:42:19'),(31,'水电费',291.67,'hjs00002',2017,7,'20177T1','2017-07-24 07:42:19'),(32,'人员工资[总店分摊]',750,'hjs00002',2017,7,'20177T2','2017-07-24 08:24:11'),(33,'人员工资[总店分摊]',750,'hjs00003',2017,7,'20177T2','2017-07-24 08:24:11'),(34,'人员工资[总店分摊]',750,'hjs00004',2017,7,'20177T2','2017-07-24 08:24:11'),(35,'人员工资[总店分摊]',750,'hjs00005',2017,7,'20177T2','2017-07-24 08:24:11'),(36,'区域经理工资[区域分摊]',500,'hjs00002',2017,7,'20177T2','2017-07-24 08:24:11'),(37,'区域经理工资[区域分摊]',500,'hjs00003',2017,7,'20177T2','2017-07-24 08:24:11'),(38,'区域经理工资[区域分摊]',500,'hjs00004',2017,7,'20177T2','2017-07-24 08:24:11'),(39,'区域经理工资[区域分摊]',500,'hjs00005',2017,7,'20177T2','2017-07-24 08:24:11'),(40,'过户费用[总店分摊]',75,'hjs00002',2017,7,'20177T2','2017-07-24 08:24:11'),(41,'过户费用[总店分摊]',75,'hjs00003',2017,7,'20177T2','2017-07-24 08:24:11'),(42,'过户费用[总店分摊]',75,'hjs00004',2017,7,'20177T2','2017-07-24 08:24:11'),(43,'过户费用[总店分摊]',75,'hjs00005',2017,7,'20177T2','2017-07-24 08:24:11'),(44,'材料1',500,'hjs00003',2017,7,'20177T2','2017-07-24 08:24:11'),(45,'材料2',1000,'hjs00003',2017,7,'20177T2','2017-07-24 08:24:11'),(46,'水电',500,'hjs00005',2017,7,'20177T2','2017-07-24 08:24:11'),(47,'水电费',1000,'hjs00004',2017,7,'20177T2','2017-07-24 08:24:11'),(48,'端口费',333.33,'hjs00004',2017,7,'20177T2','2017-07-24 08:24:11'),(49,'房租[总店分摊]',2500,'hjs00002',2017,7,'20177T2','2017-07-24 08:24:11'),(50,'房租[总店分摊]',2500,'hjs00003',2017,7,'20177T2','2017-07-24 08:24:11'),(51,'房租[总店分摊]',2500,'hjs00004',2017,7,'20177T2','2017-07-24 08:24:11'),(52,'房租[总店分摊]',2500,'hjs00005',2017,7,'20177T2','2017-07-24 08:24:11'),(53,'广告[总店分摊]',1416.67,'hjs00002',2017,7,'20177T2','2017-07-24 08:24:11'),(54,'广告[总店分摊]',1416.67,'hjs00003',2017,7,'20177T2','2017-07-24 08:24:11'),(55,'广告[总店分摊]',1416.67,'hjs00004',2017,7,'20177T2','2017-07-24 08:24:11'),(56,'广告[总店分摊]',1416.67,'hjs00005',2017,7,'20177T2','2017-07-24 08:24:11'),(57,'水电[总店分摊]',83.25,'hjs00002',2017,7,'20177T2','2017-07-24 08:24:11'),(58,'水电[总店分摊]',83.25,'hjs00003',2017,7,'20177T2','2017-07-24 08:24:11'),(59,'水电[总店分摊]',83.25,'hjs00004',2017,7,'20177T2','2017-07-24 08:24:11'),(60,'水电[总店分摊]',83.25,'hjs00005',2017,7,'20177T2','2017-07-24 08:24:11'),(61,'房租',2500,'hjs00002',2017,7,'20177T2','2017-07-24 08:24:11'),(62,'水电费',291.67,'hjs00002',2017,7,'20177T2','2017-07-24 08:24:11'),(63,'人员工资[总店分摊]',750,'hjs00002',2017,7,'20177T3','2017-07-24 15:36:18'),(64,'人员工资[总店分摊]',750,'hjs00003',2017,7,'20177T3','2017-07-24 15:36:18'),(65,'人员工资[总店分摊]',750,'hjs00004',2017,7,'20177T3','2017-07-24 15:36:18'),(66,'人员工资[总店分摊]',750,'hjs00005',2017,7,'20177T3','2017-07-24 15:36:18'),(67,'区域经理工资[区域分摊]',500,'hjs00002',2017,7,'20177T3','2017-07-24 15:36:18'),(68,'区域经理工资[区域分摊]',500,'hjs00003',2017,7,'20177T3','2017-07-24 15:36:18'),(69,'区域经理工资[区域分摊]',500,'hjs00004',2017,7,'20177T3','2017-07-24 15:36:18'),(70,'区域经理工资[区域分摊]',500,'hjs00005',2017,7,'20177T3','2017-07-24 15:36:18'),(71,'过户费用[总店分摊]',75,'hjs00002',2017,7,'20177T3','2017-07-24 15:36:18'),(72,'过户费用[总店分摊]',75,'hjs00003',2017,7,'20177T3','2017-07-24 15:36:18'),(73,'过户费用[总店分摊]',75,'hjs00004',2017,7,'20177T3','2017-07-24 15:36:18'),(74,'过户费用[总店分摊]',75,'hjs00005',2017,7,'20177T3','2017-07-24 15:36:18'),(75,'材料1',500,'hjs00003',2017,7,'20177T3','2017-07-24 15:36:18'),(76,'材料2',1000,'hjs00003',2017,7,'20177T3','2017-07-24 15:36:18'),(77,'水电',500,'hjs00005',2017,7,'20177T3','2017-07-24 15:36:18'),(78,'水电费',1000,'hjs00004',2017,7,'20177T3','2017-07-24 15:36:18'),(79,'端口费',333.33,'hjs00004',2017,7,'20177T3','2017-07-24 15:36:18'),(80,'房租[总店分摊]',2500,'hjs00002',2017,7,'20177T3','2017-07-24 15:36:18'),(81,'房租[总店分摊]',2500,'hjs00003',2017,7,'20177T3','2017-07-24 15:36:18'),(82,'房租[总店分摊]',2500,'hjs00004',2017,7,'20177T3','2017-07-24 15:36:18'),(83,'房租[总店分摊]',2500,'hjs00005',2017,7,'20177T3','2017-07-24 15:36:18'),(84,'广告[总店分摊]',1416.67,'hjs00002',2017,7,'20177T3','2017-07-24 15:36:18'),(85,'广告[总店分摊]',1416.67,'hjs00003',2017,7,'20177T3','2017-07-24 15:36:18'),(86,'广告[总店分摊]',1416.67,'hjs00004',2017,7,'20177T3','2017-07-24 15:36:18'),(87,'广告[总店分摊]',1416.67,'hjs00005',2017,7,'20177T3','2017-07-24 15:36:18'),(88,'水电[总店分摊]',83.25,'hjs00002',2017,7,'20177T3','2017-07-24 15:36:18'),(89,'水电[总店分摊]',83.25,'hjs00003',2017,7,'20177T3','2017-07-24 15:36:18'),(90,'水电[总店分摊]',83.25,'hjs00004',2017,7,'20177T3','2017-07-24 15:36:18'),(91,'水电[总店分摊]',83.25,'hjs00005',2017,7,'20177T3','2017-07-24 15:36:18'),(92,'房租',2500,'hjs00002',2017,7,'20177T3','2017-07-24 15:36:18'),(93,'水电费',291.67,'hjs00002',2017,7,'20177T3','2017-07-24 15:36:18');
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
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=gbk;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_position`
--

LOCK TABLES `employee_position` WRITE;
/*!40000 ALTER TABLE `employee_position` DISABLE KEYS */;
INSERT INTO `employee_position` VALUES (14,'123132123123123123123','jl01','hj001'),(15,'120254','cw01','hj001'),(16,'123123','gh01','hj001'),(41,'hjs00002T3','dz01','hjs00002'),(42,'hjs00002T4','xs01','hjs00002'),(43,'hjs00003T5','dz01','hjs00003'),(44,'hjs00003T6','xs01','hjs00003'),(45,'hjs00004T7','dz01','hjs00004'),(46,'hjs00004T8','xs01','hjs00004'),(47,'qy00T1T9','qy01','qy00T1'),(48,'qy00T2T10','qy01','qy00T2'),(49,'hjs00005T11','dz01','hjs00005'),(50,'hjs00005T12','xs01','hjs00005');
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salary_details`
--

LOCK TABLES `salary_details` WRITE;
/*!40000 ALTER TABLE `salary_details` DISABLE KEYS */;
INSERT INTO `salary_details` VALUES (1,'123132123123123123123',1000,2017,7,'2017-07-23 19:42:18',1,'20177T1','hj001'),(2,'120254',1000,2017,7,'2017-07-23 19:42:18',1,'20177T1','hj001'),(3,'123123',1000,2017,7,'2017-07-23 19:42:18',1,'20177T1','hj001'),(4,'hjs00002T3',1000,2017,7,'2017-07-23 19:42:18',2,'20177T1','hjs00002'),(5,'hjs00002T4',1000,2017,7,'2017-07-23 19:42:18',2,'20177T1','hjs00002'),(6,'hjs00003T5',1000,2017,7,'2017-07-23 19:42:18',2,'20177T1','hjs00003'),(7,'hjs00003T6',1000,2017,7,'2017-07-23 19:42:18',2,'20177T1','hjs00003'),(8,'hjs00004T7',1000,2017,7,'2017-07-23 19:42:18',2,'20177T1','hjs00004'),(9,'hjs00004T8',1000,2017,7,'2017-07-23 19:42:18',2,'20177T1','hjs00004'),(10,'qy00T1T9',1000,2017,7,'2017-07-23 19:42:18',2,'20177T1','qy00T1'),(11,'qy00T2T10',1000,2017,7,'2017-07-23 19:42:18',2,'20177T1','qy00T2'),(12,'hjs00005T11',1000,2017,7,'2017-07-23 19:42:18',2,'20177T1','hjs00005'),(13,'hjs00005T12',1000,2017,7,'2017-07-23 19:42:18',2,'20177T1','hjs00005'),(14,'123132123123123123123',1000,2017,7,'2017-07-23 20:24:11',1,'20177T2','hj001'),(15,'120254',1000,2017,7,'2017-07-23 20:24:11',1,'20177T2','hj001'),(16,'123123',1000,2017,7,'2017-07-23 20:24:11',1,'20177T2','hj001'),(17,'hjs00002T3',1000,2017,7,'2017-07-23 20:24:11',2,'20177T2','hjs00002'),(18,'hjs00002T4',1000,2017,7,'2017-07-23 20:24:11',2,'20177T2','hjs00002'),(19,'hjs00003T5',1000,2017,7,'2017-07-23 20:24:11',2,'20177T2','hjs00003'),(20,'hjs00003T6',1000,2017,7,'2017-07-23 20:24:11',2,'20177T2','hjs00003'),(21,'hjs00004T7',1000,2017,7,'2017-07-23 20:24:11',2,'20177T2','hjs00004'),(22,'hjs00004T8',1000,2017,7,'2017-07-23 20:24:11',2,'20177T2','hjs00004'),(23,'qy00T1T9',1000,2017,7,'2017-07-23 20:24:11',2,'20177T2','qy00T1'),(24,'qy00T2T10',1000,2017,7,'2017-07-23 20:24:11',2,'20177T2','qy00T2'),(25,'hjs00005T11',1000,2017,7,'2017-07-23 20:24:11',2,'20177T2','hjs00005'),(26,'hjs00005T12',1000,2017,7,'2017-07-23 20:24:11',2,'20177T2','hjs00005'),(27,'123132123123123123123',1000,2017,7,'2017-07-24 03:36:18',1,'20177T3','hj001'),(28,'120254',1000,2017,7,'2017-07-24 03:36:18',1,'20177T3','hj001'),(29,'123123',1000,2017,7,'2017-07-24 03:36:18',1,'20177T3','hj001'),(30,'hjs00002T3',1000,2017,7,'2017-07-24 03:36:18',2,'20177T3','hjs00002'),(31,'hjs00002T4',1000,2017,7,'2017-07-24 03:36:18',2,'20177T3','hjs00002'),(32,'hjs00003T5',1000,2017,7,'2017-07-24 03:36:18',2,'20177T3','hjs00003'),(33,'hjs00003T6',1000,2017,7,'2017-07-24 03:36:18',2,'20177T3','hjs00003'),(34,'hjs00004T7',1000,2017,7,'2017-07-24 03:36:18',2,'20177T3','hjs00004'),(35,'hjs00004T8',1000,2017,7,'2017-07-24 03:36:18',2,'20177T3','hjs00004'),(36,'qy00T1T9',1000,2017,7,'2017-07-24 03:36:18',2,'20177T3','qy00T1'),(37,'qy00T2T10',1000,2017,7,'2017-07-24 03:36:18',2,'20177T3','qy00T2'),(38,'hjs00005T11',1000,2017,7,'2017-07-24 03:36:18',2,'20177T3','hjs00005'),(39,'hjs00005T12',1000,2017,7,'2017-07-24 03:36:18',2,'20177T3','hjs00005');
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
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_bonus_rule`
--

LOCK TABLES `staff_bonus_rule` WRITE;
/*!40000 ALTER TABLE `staff_bonus_rule` DISABLE KEYS */;
INSERT INTO `staff_bonus_rule` VALUES (1,1,'+00',0,0,1,1,NULL),(2,1,'+00',0,0,1,1,NULL),(3,1,'+00',0,0,1,1,NULL),(4,1,'5000',0,0.01,1,1,NULL),(5,1,'6000',5001,0.02,1,1,NULL),(6,1,'+00',6001,0.03,1,1,NULL),(7,2,NULL,NULL,0.04,0,1,NULL),(8,3,NULL,NULL,0.04,0,0,NULL),(9,4,NULL,NULL,0.04,0,0,NULL),(10,5,NULL,NULL,0.05,0,0,NULL),(11,6,NULL,NULL,0.05,0,0,NULL),(12,7,NULL,NULL,0.05,0,0,NULL),(13,8,NULL,NULL,0.05,0,1,NULL),(14,9,NULL,NULL,0.05,0,1,NULL),(15,10,NULL,0,0,0,1,'xs01'),(16,10,NULL,5000,0,0,1,'xs02'),(17,10,NULL,36000,0,0,1,'xs03'),(18,10,NULL,48000,0,0,1,'xs04'),(19,10,NULL,66000,0,0,1,'xs05'),(20,1,'5000',0,0.01,1,1,NULL),(21,1,'6000',5001,0.02,1,1,NULL),(22,1,'+00',6001,0.03,1,1,NULL),(23,1,'5000',0,0.01,1,1,NULL),(24,1,'6000',5001,0.02,1,1,NULL),(25,1,'+00',6001,0.03,1,1,NULL),(26,1,'5000',0,0.01,1,1,NULL),(27,1,'6000',5001,0.02,1,1,NULL),(28,1,'+00',6001,0.03,1,1,NULL),(29,10,NULL,0,0,0,0,'xs01'),(30,10,NULL,5000,0,0,0,'xs02'),(31,10,NULL,36000,0,0,0,'xs03'),(32,10,NULL,48000,0,0,0,'xs04'),(33,10,NULL,66000,0,0,0,'xs05'),(34,1,'3000',0,0.01,1,1,NULL),(35,1,'6000',3001,0.02,1,1,NULL),(36,1,'+00',6001,0.03,1,1,NULL),(37,1,'3000',0,0.01,1,1,NULL),(38,1,'6000',3001,0.02,1,1,NULL),(39,1,'9000',6001,0.03,1,1,NULL),(40,1,'+00',9001,0.04,1,1,NULL),(41,1,'3000',0,0.01,1,1,NULL),(42,1,'6000',3001,0.02,1,1,NULL),(43,1,'9000',6001,0.03,1,1,NULL),(44,1,'+00',9001,0.04,1,1,NULL),(45,1,'3000',0,0.01,1,1,NULL),(46,1,'6000',3001,0.02,1,1,NULL),(47,1,'9000',6001,0.03,1,1,NULL),(48,1,'+00',9001,0.04,1,1,NULL),(49,1,'3000',0,0.01,1,1,NULL),(50,1,'6000',3001,0.02,1,1,NULL),(51,1,'9000',6001,0.03,1,1,NULL),(52,1,'+00',9001,0.04,1,1,NULL),(53,9,NULL,NULL,0.7,0,0,NULL),(54,8,NULL,NULL,0.7,0,0,NULL),(55,1,'3000',0,0.01,1,1,NULL),(56,1,'6000',3001,0.02,1,1,NULL),(57,1,'9000',6001,0.03,1,1,NULL),(58,1,'+00',9001,0.04,1,1,NULL),(59,1,'3000',0,0.01,1,1,NULL),(60,1,'6000',3001,0.02,1,1,NULL),(61,1,'9000',6001,0.03,1,1,NULL),(62,1,'+00',9001,0.04,1,1,NULL),(63,1,'3000',0,0.01,1,0,NULL),(64,1,'6000',3001,0.02,1,0,NULL),(65,1,'9000',6001,0.03,1,0,NULL),(66,1,'+00',9001,0.04,1,0,NULL),(67,2,NULL,NULL,0.05,0,1,NULL),(68,2,NULL,NULL,0.05,0,0,NULL),(69,11,NULL,NULL,0.02,0,0,NULL),(70,12,NULL,NULL,0.03,0,0,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_contract`
--

LOCK TABLES `staff_contract` WRITE;
/*!40000 ALTER TABLE `staff_contract` DISABLE KEYS */;
INSERT INTO `staff_contract` VALUES (1,'1223','hjs00005T12',9500,8000,1,2017,7,'hjs00005','2017-07-24 07:26:41','2017-07-24 06:55:56',24,0,1,0,'0','。。。','黄河路',8000,'all'),(2,'1111','hjs00004T8',9500,9500,1,2017,7,'hjs00004','2017-07-24 07:32:05','2017-07-24 06:55:56',12,0,1,0,'0','。。。。。','长江',9500,'all'),(3,'1345','hjs00005T12',1222,0,0,2017,7,'hjs00005','2017-07-24 07:29:30','2017-07-24 06:59:05',25,0,3,1,'hjs00003T6','','珠江路',1000,'hjs00003'),(4,'22222','hjs00004T8',19000,0,0,2017,7,'hjs00004',NULL,'2017-07-24 06:59:06',12,0,3,1,'hjs00003T6','11111','湖上',0,'hjs00003'),(5,'123','hjs00002T4',1900,112000,1,2017,7,'hjs00002','2017-07-24 07:31:07','2017-07-24 07:17:32',11,0,1,0,'0','没有','藏山路',112000,'all'),(6,'1000','hjs00003T6',10000,0,0,2017,7,'hjs00003',NULL,'2017-07-24 07:17:53',24,0,1,0,'0','','',0,'all'),(7,'1234','hjs00002T4',30000,30000,1,2017,7,'hjs00002','2017-07-24 07:31:33','2017-07-24 07:18:16',10,0,2,1,'hjs00003T6','111','长江路',30000,'hjs00003'),(8,'10000','hjs00003T6',5000,4000,1,2017,7,'hjs00003','2017-07-24 07:32:38','2017-07-24 07:18:25',24,0,2,1,'hjs00002T4','','',4000,'hjs00002'),(9,'234','hjs00002T4',2000,0,0,2017,7,'hjs00002',NULL,'2017-07-24 07:18:55',14,0,3,1,'hjs00002T4','','虞山北路',0,'hjs00002'),(10,'444','hjs00002T4',3325,0,0,2017,6,'hjs00002',NULL,'2017-07-24 07:19:31',18,0,3,1,'hjs00003T6','','虎山路',0,'hjs00003'),(11,'909000','hjs00003T6',9500,0,0,2017,7,'hjs00003',NULL,'2017-07-24 07:20:21',24,0,3,1,'hjs00004T8','','',0,'hjs00004');
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
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_employee`
--

LOCK TABLES `staff_employee` WRITE;
/*!40000 ALTER TABLE `staff_employee` DISABLE KEYS */;
INSERT INTO `staff_employee` VALUES (37,'bruce_zj',0,'','2312312312312','13213123123','addr','2017-07-26',1,'','2017-07-24 00:29:16','123132123123123123123','2017-06-30 01:29:29'),(38,'bruce_cw',1,'2017-06','2356456','12312312312','aaa','2017-07-26',1,'','2017-07-21 09:30:54','120254','2017-06-30 01:30:11'),(39,'bruce_gh',1,'2017-06','123123123123123123','12312312312','addr','2017-07-26',1,'','2017-07-21 09:30:54','123123','2017-06-30 01:30:38'),(78,'朱伽一',1,'2017-07-19','111111111111111111','12345678000','虎山','2017-07-26',1,'',NULL,'hjs00002T3','2017-07-24 06:43:08'),(79,'东湖1销售',0,'2017-07-17','111111111111111111','11111111111','东湖路','2017-07-24',1,'',NULL,'hjs00002T4','2017-07-24 06:43:43'),(80,'姜巡',0,'2017-08-01','111111111111111111','11111111111','黄河','2017-07-10',1,'',NULL,'hjs00003T5','2017-07-24 06:44:44'),(81,'东湖2销售',0,'2017-07-10','111111111111111111','11111111111','长江','2017-07-18',1,'',NULL,'hjs00003T6','2017-07-24 06:45:09'),(82,'陈瑞军',0,'2017-07-18','111111111111111111','11111111111','黄河长江','2017-07-24',1,'',NULL,'hjs00004T7','2017-07-24 06:46:11'),(83,'东南1销售',0,'2017-07-18','111111111111111111','11111111111','长江黄河','2017-07-03',1,'',NULL,'hjs00004T8','2017-07-24 06:46:37'),(84,'东湖区域经理',0,'2017-07-04','111111111111111111','11111111111','东湖','2017-07-24',1,'',NULL,'qy00T1T9','2017-07-24 06:47:13'),(85,'东南区域经理',0,'2017-07-18','111111111111111111','11111111111','东南','2017-07-25',1,'',NULL,'qy00T2T10','2017-07-24 06:47:55'),(86,'陈庆杰',0,'2017-07-17','111111111111111111','11111111111','东南','2017-07-10',1,'',NULL,'hjs00005T11','2017-07-24 06:51:00'),(87,'东南2销售',0,'2017-07-06','111111111111111111','11111111111','长江','2017-07-20',1,'',NULL,'hjs00005T12','2017-07-24 06:51:28');
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_port`
--

LOCK TABLES `staff_port` WRITE;
/*!40000 ALTER TABLE `staff_port` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_position`
--

LOCK TABLES `staff_position` WRITE;
/*!40000 ALTER TABLE `staff_position` DISABLE KEYS */;
INSERT INTO `staff_position` VALUES (1,'hj001','jl01','总经理',1,1000,0,'总经理'),(2,'hj001','gh01','过户',1,1000,0,'过户专员'),(5,'hj001','cw01','财务',1,1000,0,'财务专员'),(124,'qy00T1','qy01','区域经理',1,1000,0,'区域经理'),(125,'qy00T2','qy01','区域经理',1,1000,0,'区域经理'),(126,'hjs00002','dz01','店长',1,1000,0,'店长'),(127,'hjs00002','zl01','店长助理',1,1000,0,'店长助理'),(128,'hjs00002','xs01','销售',1,1000,0,'见习置业顾问'),(129,'hjs00002','xs02','销售',2,1000,0,'置业顾问'),(130,'hjs00002','xs03','销售',3,1000,0,'高级置业顾问'),(131,'hjs00002','xs04','销售',4,1000,0,'主任置业顾问'),(132,'hjs00002','xs05','销售',5,1000,0,'金牌置业顾问'),(133,'hjs00003','dz01','店长',1,1000,0,'店长'),(134,'hjs00003','zl01','店长助理',1,1000,0,'店长助理'),(135,'hjs00003','xs01','销售',1,1000,0,'见习置业顾问'),(136,'hjs00003','xs02','销售',2,1000,0,'置业顾问'),(137,'hjs00003','xs03','销售',3,1000,0,'高级置业顾问'),(138,'hjs00003','xs04','销售',4,1000,0,'主任置业顾问'),(139,'hjs00003','xs05','销售',5,1000,0,'金牌置业顾问'),(140,'hjs00004','dz01','店长',1,1000,0,'店长'),(141,'hjs00004','zl01','店长助理',1,1000,0,'店长助理'),(142,'hjs00004','xs01','销售',1,1000,0,'见习置业顾问'),(143,'hjs00004','xs02','销售',2,1000,0,'置业顾问'),(144,'hjs00004','xs03','销售',3,1000,0,'高级置业顾问'),(145,'hjs00004','xs04','销售',4,1000,0,'主任置业顾问'),(146,'hjs00004','xs05','销售',5,1000,0,'金牌置业顾问'),(147,'hjs00005','dz01','店长',1,1000,0,'店长'),(148,'hjs00005','zl01','店长助理',1,1000,0,'店长助理'),(149,'hjs00005','xs01','销售',1,1000,0,'见习置业顾问'),(150,'hjs00005','xs02','销售',2,1000,0,'置业顾问'),(151,'hjs00005','xs03','销售',3,1000,0,'高级置业顾问'),(152,'hjs00005','xs04','销售',4,1000,0,'主任置业顾问'),(153,'hjs00005','xs05','销售',5,1000,0,'金牌置业顾问');
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_transfer_record`
--

LOCK TABLES `staff_transfer_record` WRITE;
/*!40000 ALTER TABLE `staff_transfer_record` DISABLE KEYS */;
INSERT INTO `staff_transfer_record` VALUES (1,'hjs00002','123123',300,2017,7,'2017-07-24 07:37:25','123',23,0);
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
  `end_year` int(11) NOT NULL COMMENT '结束还款年份',
  `end_month` int(11) NOT NULL COMMENT '结束还款月份',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store_cost`
--

LOCK TABLES `store_cost` WRITE;
/*!40000 ALTER TABLE `store_cost` DISABLE KEYS */;
INSERT INTO `store_cost` VALUES (1,1000,'材料1',7,2,'hjs00003','[\"hjs00003\"]',500,'[{\"year\":2017,\"month\":7},{\"year\":2017,\"month\":8}]','2017-07-24 06:51:21',2017),(2,2000,'材料2',7,2,'hjs00003','[\"hjs00003\"]',1000,'[{\"year\":2017,\"month\":7},{\"year\":2017,\"month\":8}]','2017-07-24 06:51:39',2017),(3,6000,'水电',7,12,'hjs00005','[\"hjs00005\"]',500,'[{\"year\":2017,\"month\":7},{\"year\":2017,\"month\":8},{\"year\":2017,\"month\":9},{\"year\":2017,\"month\":10},{\"year\":2017,\"month\":11},{\"year\":2017,\"month\":12},{\"year\":2018,\"month\":1},{\"year\":2018,\"month\":2},{\"year\":2018,\"month\":3},{\"year\":2018,\"month\":4},{\"year\":2018,\"month\":5},{\"year\":2018,\"month\":6}]','2017-07-24 06:52:44',2017),(4,10000,'水电费',7,10,'hjs00004','[\"hjs00004\"]',1000,'[{\"year\":2017,\"month\":7},{\"year\":2017,\"month\":8},{\"year\":2017,\"month\":9},{\"year\":2017,\"month\":10},{\"year\":2017,\"month\":11},{\"year\":2017,\"month\":12},{\"year\":2018,\"month\":1},{\"year\":2018,\"month\":2},{\"year\":2018,\"month\":3},{\"year\":2018,\"month\":4}]','2017-07-24 06:52:52',2017),(5,1000,'端口费',7,3,'hjs00004','[\"hjs00004\"]',333.33,'[{\"year\":2017,\"month\":7},{\"year\":2017,\"month\":8},{\"year\":2017,\"month\":9}]','2017-07-24 07:17:07',2017),(6,120000,'房租',7,12,'hj001','[\"hjs00002\",\"hjs00003\",\"hjs00004\",\"hjs00005\"]',10000,'[{\"year\":2017,\"month\":7},{\"year\":2017,\"month\":8},{\"year\":2017,\"month\":9},{\"year\":2017,\"month\":10},{\"year\":2017,\"month\":11},{\"year\":2017,\"month\":12},{\"year\":2018,\"month\":1},{\"year\":2018,\"month\":2},{\"year\":2018,\"month\":3},{\"year\":2018,\"month\":4},{\"year\":2018,\"month\":5},{\"year\":2018,\"month\":6}]','2017-07-24 07:17:42',2017),(7,34000,'广告',7,6,'hj001','[\"hjs00002\",\"hjs00003\",\"hjs00004\",\"hjs00005\"]',5666.67,'[{\"year\":2017,\"month\":7},{\"year\":2017,\"month\":8},{\"year\":2017,\"month\":9},{\"year\":2017,\"month\":10},{\"year\":2017,\"month\":11},{\"year\":2017,\"month\":12}]','2017-07-24 07:18:39',2017),(8,333,'水电',7,1,'hj001','[\"hjs00002\",\"hjs00003\",\"hjs00004\",\"hjs00005\"]',333,'[{\"year\":2017,\"month\":7}]','2017-07-24 07:19:26',2017),(9,30000,'房租',6,12,'hjs00002','[\"hjs00002\"]',2500,'[{\"year\":2017,\"month\":6},{\"year\":2017,\"month\":7},{\"year\":2017,\"month\":8},{\"year\":2017,\"month\":9},{\"year\":2017,\"month\":10},{\"year\":2017,\"month\":11},{\"year\":2017,\"month\":12},{\"year\":2018,\"month\":1},{\"year\":2018,\"month\":2},{\"year\":2018,\"month\":3},{\"year\":2018,\"month\":4},{\"year\":2018,\"month\":5}]','2017-07-24 07:22:25',2017),(10,3500,'水电费',7,12,'hjs00002','[\"hjs00002\"]',291.67,'[{\"year\":2017,\"month\":7},{\"year\":2017,\"month\":8},{\"year\":2017,\"month\":9},{\"year\":2017,\"month\":10},{\"year\":2017,\"month\":11},{\"year\":2017,\"month\":12},{\"year\":2018,\"month\":1},{\"year\":2018,\"month\":2},{\"year\":2018,\"month\":3},{\"year\":2018,\"month\":4},{\"year\":2018,\"month\":5},{\"year\":2018,\"month\":6}]','2017-07-24 07:23:21',2017);
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store_income`
--

LOCK TABLES `store_income` WRITE;
/*!40000 ALTER TABLE `store_income` DISABLE KEYS */;
INSERT INTO `store_income` VALUES (1,2000,'收入1',7,2017,'hjs00003','2017-07-24 06:52:21',NULL),(2,3000,'收入2',7,2017,'hjs00003','2017-07-24 06:52:32',NULL),(3,1200,'二手房过户',7,2017,'hjs00005','2017-07-24 06:53:30',NULL),(4,1500,'二手房过户',7,2017,'hjs00004','2017-07-24 06:53:35',NULL),(5,150000,'本月收入',7,2017,'hjs00002','2017-07-24 07:24:26',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store_store`
--

LOCK TABLES `store_store` WRITE;
/*!40000 ALTER TABLE `store_store` DISABLE KEYS */;
INSERT INTO `store_store` VALUES (19,'hj001','xxx总公司','addr',1,1,'0513','0','888','2017-07-04 07:34:04',NULL,0,''),(53,'hjs00002','东湖1号','湖山路333',1,2,'0513','','888',NULL,'2017-07-24 06:41:29',0,'qy00T1'),(54,'hjs00003','东湖2','黄河路',1,2,'0513','','888',NULL,'2017-07-24 06:41:42',0,'qy00T1'),(55,'hjs00004','东南1','湖山路99',1,2,'0513','','888',NULL,'2017-07-24 06:41:59',0,'qy00T2'),(56,'hjs00005','东南2','东南',1,2,'0513','','888',NULL,'2017-07-24 06:50:21',0,'qy00T2');
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=gbk;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store_zone`
--

LOCK TABLES `store_zone` WRITE;
/*!40000 ALTER TABLE `store_zone` DISABLE KEYS */;
INSERT INTO `store_zone` VALUES (1,'东湖','qy00T1',1,'','11','2017-07-24 06:40:54'),(2,'东南','qy00T2',1,'','爱仕达','2017-07-24 06:41:04');
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
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (5,'cw','202cb962ac59075b964b07152d234b70','120254',1,NULL,NULL),(7,'jl','e10adc3949ba59abbe56e057f20f883e','123132123123123123123',1,NULL,NULL),(8,'gh','e10adc3949ba59abbe56e057f20f883e','123123',1,NULL,NULL),(43,'朱伽一','d0970714757783e6cf17b26fb8e2298f','hjs00002T3',1,NULL,NULL),(44,'东湖1销售','e10adc3949ba59abbe56e057f20f883e','hjs00002T4',1,NULL,NULL),(45,'姜巡','e10adc3949ba59abbe56e057f20f883e','hjs00003T5',1,NULL,NULL),(46,'东湖2销售','e10adc3949ba59abbe56e057f20f883e','hjs00003T6',1,NULL,NULL),(47,'陈瑞军','e10adc3949ba59abbe56e057f20f883e','hjs00004T7',1,NULL,NULL),(48,'东南1销售','261c6a5ee77fe7d2a3c9b4fb7dd6963d','hjs00004T8',1,NULL,NULL),(49,'东湖区域经理','e10adc3949ba59abbe56e057f20f883e','qy00T1T9',1,NULL,NULL),(50,'东南区域经理','e10adc3949ba59abbe56e057f20f883e','qy00T2T10',1,NULL,NULL),(51,'陈庆杰','e10adc3949ba59abbe56e057f20f883e','hjs00005T11',1,NULL,NULL),(52,'东南2销售','e10adc3949ba59abbe56e057f20f883e','hjs00005T12',1,NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work_note`
--

LOCK TABLES `work_note` WRITE;
/*!40000 ALTER TABLE `work_note` DISABLE KEYS */;
INSERT INTO `work_note` VALUES (1,'今日总店开会','2017-07-25 02:06:30',1);
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

-- Dump completed on 2017-07-25 14:08:26
