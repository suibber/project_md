-- MySQL dump 10.13  Distrib 5.6.19, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: miduoduo
-- ------------------------------------------------------
-- Server version	5.6.19-0ubuntu0.14.04.1

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
-- Table structure for table `jz_address`
--

DROP TABLE IF EXISTS `jz_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jz_address` (
  `id` int(11) NOT NULL,
  `province` varchar(45) DEFAULT NULL COMMENT '省',
  `city` varchar(45) DEFAULT NULL COMMENT '市',
  `district` varchar(45) DEFAULT NULL COMMENT '区/县',
  `address` varchar(45) DEFAULT NULL COMMENT '地址',
  `lat` decimal(10,8) NOT NULL COMMENT '纬度',
  `lng` decimal(11,8) NOT NULL COMMENT '经度',
  `user_id` int(11) NOT NULL COMMENT '用户',
  `belong_to` smallint(6) NOT NULL DEFAULT '0' COMMENT '使用的地方',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_jz_addresses_jz_users1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jz_address`
--

LOCK TABLES `jz_address` WRITE;
/*!40000 ALTER TABLE `jz_address` DISABLE KEYS */;
/*!40000 ALTER TABLE `jz_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jz_auth_assignment`
--

DROP TABLE IF EXISTS `jz_auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jz_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `jz_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `jz_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jz_auth_assignment`
--

LOCK TABLES `jz_auth_assignment` WRITE;
/*!40000 ALTER TABLE `jz_auth_assignment` DISABLE KEYS */;
/*!40000 ALTER TABLE `jz_auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jz_auth_item`
--

DROP TABLE IF EXISTS `jz_auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jz_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `jz_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `jz_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jz_auth_item`
--

LOCK TABLES `jz_auth_item` WRITE;
/*!40000 ALTER TABLE `jz_auth_item` DISABLE KEYS */;
INSERT INTO `jz_auth_item` VALUES ('admin',1,NULL,NULL,NULL,1432547132,1432547132),('hunter',1,NULL,NULL,NULL,1432547132,1432547132),('product_manager',1,NULL,NULL,NULL,1432547132,1432547132),('saleman',1,NULL,NULL,NULL,1432547132,1432547132),('supervisor',1,NULL,NULL,NULL,1432547132,1432547132),('worker',1,NULL,NULL,NULL,1432547132,1432547132);
/*!40000 ALTER TABLE `jz_auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jz_auth_item_child`
--

DROP TABLE IF EXISTS `jz_auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jz_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `jz_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `jz_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `jz_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `jz_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jz_auth_item_child`
--

LOCK TABLES `jz_auth_item_child` WRITE;
/*!40000 ALTER TABLE `jz_auth_item_child` DISABLE KEYS */;
INSERT INTO `jz_auth_item_child` VALUES ('admin','hunter'),('admin','product_manager'),('admin','saleman');
/*!40000 ALTER TABLE `jz_auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jz_auth_rule`
--

DROP TABLE IF EXISTS `jz_auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jz_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jz_auth_rule`
--

LOCK TABLES `jz_auth_rule` WRITE;
/*!40000 ALTER TABLE `jz_auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `jz_auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jz_cache_for_api`
--

DROP TABLE IF EXISTS `jz_cache_for_api`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jz_cache_for_api` (
  `id` char(128) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jz_cache_for_api`
--

LOCK TABLES `jz_cache_for_api` WRITE;
/*!40000 ALTER TABLE `jz_cache_for_api` DISABLE KEYS */;
INSERT INTO `jz_cache_for_api` VALUES ('963454f612a8b5fb4a63ba1e97f028a1',0,'a:2:{i:0;a:2:{i:0;a:2:{i:0;O:16:\"yii\\rest\\UrlRule\":11:{s:6:\"prefix\";s:0:\"\";s:6:\"suffix\";N;s:10:\"controller\";a:3:{s:10:\"v1/address\";s:10:\"v1/address\";s:9:\"v1/resume\";s:9:\"v1/resume\";s:16:\"v1/offline-order\";s:16:\"v1/offline-order\";}s:4:\"only\";a:0:{}s:6:\"except\";a:0:{}s:13:\"extraPatterns\";a:0:{}s:6:\"tokens\";a:1:{s:4:\"{id}\";s:13:\"<id:\\d[\\d,]*>\";}s:8:\"patterns\";a:7:{s:14:\"PUT,PATCH {id}\";s:6:\"update\";s:11:\"DELETE {id}\";s:6:\"delete\";s:13:\"GET,HEAD {id}\";s:4:\"view\";s:4:\"POST\";s:6:\"create\";s:8:\"GET,HEAD\";s:5:\"index\";s:4:\"{id}\";s:7:\"options\";s:0:\"\";s:7:\"options\";}s:10:\"ruleConfig\";a:1:{s:5:\"class\";s:15:\"yii\\web\\UrlRule\";}s:9:\"pluralize\";s:0:\"\";s:8:\"\0*\0rules\";a:3:{s:10:\"v1/address\";a:7:{i:0;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:24:\"v1/address/<id:\\d[\\d,]*>\";s:7:\"pattern\";s:32:\"#^v1/address/(?P<id>\\d[\\d,]*)$#u\";s:4:\"host\";N;s:5:\"route\";s:17:\"v1/address/update\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:2:{i:0;s:3:\"PUT\";i:1;s:5:\"PATCH\";}s:4:\"mode\";i:1;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:17:\"/v1/address/<id>/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:1:{s:2:\"id\";s:13:\"#^\\d[\\d,]*$#u\";}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:1;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:24:\"v1/address/<id:\\d[\\d,]*>\";s:7:\"pattern\";s:32:\"#^v1/address/(?P<id>\\d[\\d,]*)$#u\";s:4:\"host\";N;s:5:\"route\";s:17:\"v1/address/delete\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:1:{i:0;s:6:\"DELETE\";}s:4:\"mode\";i:1;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:17:\"/v1/address/<id>/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:1:{s:2:\"id\";s:13:\"#^\\d[\\d,]*$#u\";}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:2;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:24:\"v1/address/<id:\\d[\\d,]*>\";s:7:\"pattern\";s:32:\"#^v1/address/(?P<id>\\d[\\d,]*)$#u\";s:4:\"host\";N;s:5:\"route\";s:15:\"v1/address/view\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:2:{i:0;s:3:\"GET\";i:1;s:4:\"HEAD\";}s:4:\"mode\";N;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:17:\"/v1/address/<id>/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:1:{s:2:\"id\";s:13:\"#^\\d[\\d,]*$#u\";}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:3;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:10:\"v1/address\";s:7:\"pattern\";s:15:\"#^v1/address$#u\";s:4:\"host\";N;s:5:\"route\";s:17:\"v1/address/create\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:1:{i:0;s:4:\"POST\";}s:4:\"mode\";i:1;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:12:\"/v1/address/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:0:{}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:4;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:10:\"v1/address\";s:7:\"pattern\";s:15:\"#^v1/address$#u\";s:4:\"host\";N;s:5:\"route\";s:16:\"v1/address/index\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:2:{i:0;s:3:\"GET\";i:1;s:4:\"HEAD\";}s:4:\"mode\";N;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:12:\"/v1/address/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:0:{}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:5;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:24:\"v1/address/<id:\\d[\\d,]*>\";s:7:\"pattern\";s:32:\"#^v1/address/(?P<id>\\d[\\d,]*)$#u\";s:4:\"host\";N;s:5:\"route\";s:18:\"v1/address/options\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:0:{}s:4:\"mode\";i:1;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:17:\"/v1/address/<id>/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:1:{s:2:\"id\";s:13:\"#^\\d[\\d,]*$#u\";}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:6;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:10:\"v1/address\";s:7:\"pattern\";s:15:\"#^v1/address$#u\";s:4:\"host\";N;s:5:\"route\";s:18:\"v1/address/options\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:0:{}s:4:\"mode\";i:1;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:12:\"/v1/address/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:0:{}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}}s:9:\"v1/resume\";a:7:{i:0;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:23:\"v1/resume/<id:\\d[\\d,]*>\";s:7:\"pattern\";s:31:\"#^v1/resume/(?P<id>\\d[\\d,]*)$#u\";s:4:\"host\";N;s:5:\"route\";s:16:\"v1/resume/update\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:2:{i:0;s:3:\"PUT\";i:1;s:5:\"PATCH\";}s:4:\"mode\";i:1;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:16:\"/v1/resume/<id>/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:1:{s:2:\"id\";s:13:\"#^\\d[\\d,]*$#u\";}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:1;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:23:\"v1/resume/<id:\\d[\\d,]*>\";s:7:\"pattern\";s:31:\"#^v1/resume/(?P<id>\\d[\\d,]*)$#u\";s:4:\"host\";N;s:5:\"route\";s:16:\"v1/resume/delete\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:1:{i:0;s:6:\"DELETE\";}s:4:\"mode\";i:1;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:16:\"/v1/resume/<id>/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:1:{s:2:\"id\";s:13:\"#^\\d[\\d,]*$#u\";}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:2;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:23:\"v1/resume/<id:\\d[\\d,]*>\";s:7:\"pattern\";s:31:\"#^v1/resume/(?P<id>\\d[\\d,]*)$#u\";s:4:\"host\";N;s:5:\"route\";s:14:\"v1/resume/view\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:2:{i:0;s:3:\"GET\";i:1;s:4:\"HEAD\";}s:4:\"mode\";N;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:16:\"/v1/resume/<id>/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:1:{s:2:\"id\";s:13:\"#^\\d[\\d,]*$#u\";}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:3;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:9:\"v1/resume\";s:7:\"pattern\";s:14:\"#^v1/resume$#u\";s:4:\"host\";N;s:5:\"route\";s:16:\"v1/resume/create\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:1:{i:0;s:4:\"POST\";}s:4:\"mode\";i:1;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:11:\"/v1/resume/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:0:{}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:4;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:9:\"v1/resume\";s:7:\"pattern\";s:14:\"#^v1/resume$#u\";s:4:\"host\";N;s:5:\"route\";s:15:\"v1/resume/index\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:2:{i:0;s:3:\"GET\";i:1;s:4:\"HEAD\";}s:4:\"mode\";N;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:11:\"/v1/resume/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:0:{}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:5;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:23:\"v1/resume/<id:\\d[\\d,]*>\";s:7:\"pattern\";s:31:\"#^v1/resume/(?P<id>\\d[\\d,]*)$#u\";s:4:\"host\";N;s:5:\"route\";s:17:\"v1/resume/options\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:0:{}s:4:\"mode\";i:1;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:16:\"/v1/resume/<id>/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:1:{s:2:\"id\";s:13:\"#^\\d[\\d,]*$#u\";}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:6;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:9:\"v1/resume\";s:7:\"pattern\";s:14:\"#^v1/resume$#u\";s:4:\"host\";N;s:5:\"route\";s:17:\"v1/resume/options\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:0:{}s:4:\"mode\";i:1;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:11:\"/v1/resume/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:0:{}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}}s:16:\"v1/offline-order\";a:7:{i:0;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:30:\"v1/offline-order/<id:\\d[\\d,]*>\";s:7:\"pattern\";s:38:\"#^v1/offline-order/(?P<id>\\d[\\d,]*)$#u\";s:4:\"host\";N;s:5:\"route\";s:23:\"v1/offline-order/update\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:2:{i:0;s:3:\"PUT\";i:1;s:5:\"PATCH\";}s:4:\"mode\";i:1;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:23:\"/v1/offline-order/<id>/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:1:{s:2:\"id\";s:13:\"#^\\d[\\d,]*$#u\";}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:1;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:30:\"v1/offline-order/<id:\\d[\\d,]*>\";s:7:\"pattern\";s:38:\"#^v1/offline-order/(?P<id>\\d[\\d,]*)$#u\";s:4:\"host\";N;s:5:\"route\";s:23:\"v1/offline-order/delete\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:1:{i:0;s:6:\"DELETE\";}s:4:\"mode\";i:1;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:23:\"/v1/offline-order/<id>/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:1:{s:2:\"id\";s:13:\"#^\\d[\\d,]*$#u\";}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:2;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:30:\"v1/offline-order/<id:\\d[\\d,]*>\";s:7:\"pattern\";s:38:\"#^v1/offline-order/(?P<id>\\d[\\d,]*)$#u\";s:4:\"host\";N;s:5:\"route\";s:21:\"v1/offline-order/view\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:2:{i:0;s:3:\"GET\";i:1;s:4:\"HEAD\";}s:4:\"mode\";N;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:23:\"/v1/offline-order/<id>/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:1:{s:2:\"id\";s:13:\"#^\\d[\\d,]*$#u\";}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:3;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:16:\"v1/offline-order\";s:7:\"pattern\";s:21:\"#^v1/offline-order$#u\";s:4:\"host\";N;s:5:\"route\";s:23:\"v1/offline-order/create\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:1:{i:0;s:4:\"POST\";}s:4:\"mode\";i:1;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:18:\"/v1/offline-order/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:0:{}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:4;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:16:\"v1/offline-order\";s:7:\"pattern\";s:21:\"#^v1/offline-order$#u\";s:4:\"host\";N;s:5:\"route\";s:22:\"v1/offline-order/index\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:2:{i:0;s:3:\"GET\";i:1;s:4:\"HEAD\";}s:4:\"mode\";N;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:18:\"/v1/offline-order/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:0:{}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:5;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:30:\"v1/offline-order/<id:\\d[\\d,]*>\";s:7:\"pattern\";s:38:\"#^v1/offline-order/(?P<id>\\d[\\d,]*)$#u\";s:4:\"host\";N;s:5:\"route\";s:24:\"v1/offline-order/options\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:0:{}s:4:\"mode\";i:1;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:23:\"/v1/offline-order/<id>/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:1:{s:2:\"id\";s:13:\"#^\\d[\\d,]*$#u\";}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:6;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:16:\"v1/offline-order\";s:7:\"pattern\";s:21:\"#^v1/offline-order$#u\";s:4:\"host\";N;s:5:\"route\";s:24:\"v1/offline-order/options\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:0:{}s:4:\"mode\";i:1;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:18:\"/v1/offline-order/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:0:{}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}}}}i:1;O:16:\"yii\\rest\\UrlRule\":11:{s:6:\"prefix\";s:0:\"\";s:6:\"suffix\";N;s:10:\"controller\";a:1:{s:7:\"v1/user\";s:7:\"v1/user\";}s:4:\"only\";a:0:{}s:6:\"except\";a:0:{}s:13:\"extraPatterns\";a:3:{s:10:\"POST login\";s:5:\"login\";s:10:\"POST vcode\";s:5:\"vcode\";s:11:\"POST vlogin\";s:6:\"vlogin\";}s:6:\"tokens\";a:1:{s:4:\"{id}\";s:13:\"<id:\\d[\\d,]*>\";}s:8:\"patterns\";a:7:{s:14:\"PUT,PATCH {id}\";s:6:\"update\";s:11:\"DELETE {id}\";s:6:\"delete\";s:13:\"GET,HEAD {id}\";s:4:\"view\";s:4:\"POST\";s:6:\"create\";s:8:\"GET,HEAD\";s:5:\"index\";s:4:\"{id}\";s:7:\"options\";s:0:\"\";s:7:\"options\";}s:10:\"ruleConfig\";a:1:{s:5:\"class\";s:15:\"yii\\web\\UrlRule\";}s:9:\"pluralize\";s:0:\"\";s:8:\"\0*\0rules\";a:1:{s:7:\"v1/user\";a:10:{i:0;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:13:\"v1/user/login\";s:7:\"pattern\";s:18:\"#^v1/user/login$#u\";s:4:\"host\";N;s:5:\"route\";s:13:\"v1/user/login\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:1:{i:0;s:4:\"POST\";}s:4:\"mode\";i:1;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:15:\"/v1/user/login/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:0:{}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:1;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:13:\"v1/user/vcode\";s:7:\"pattern\";s:18:\"#^v1/user/vcode$#u\";s:4:\"host\";N;s:5:\"route\";s:13:\"v1/user/vcode\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:1:{i:0;s:4:\"POST\";}s:4:\"mode\";i:1;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:15:\"/v1/user/vcode/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:0:{}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:2;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:14:\"v1/user/vlogin\";s:7:\"pattern\";s:19:\"#^v1/user/vlogin$#u\";s:4:\"host\";N;s:5:\"route\";s:14:\"v1/user/vlogin\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:1:{i:0;s:4:\"POST\";}s:4:\"mode\";i:1;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:16:\"/v1/user/vlogin/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:0:{}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:3;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:21:\"v1/user/<id:\\d[\\d,]*>\";s:7:\"pattern\";s:29:\"#^v1/user/(?P<id>\\d[\\d,]*)$#u\";s:4:\"host\";N;s:5:\"route\";s:14:\"v1/user/update\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:2:{i:0;s:3:\"PUT\";i:1;s:5:\"PATCH\";}s:4:\"mode\";i:1;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:14:\"/v1/user/<id>/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:1:{s:2:\"id\";s:13:\"#^\\d[\\d,]*$#u\";}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:4;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:21:\"v1/user/<id:\\d[\\d,]*>\";s:7:\"pattern\";s:29:\"#^v1/user/(?P<id>\\d[\\d,]*)$#u\";s:4:\"host\";N;s:5:\"route\";s:14:\"v1/user/delete\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:1:{i:0;s:6:\"DELETE\";}s:4:\"mode\";i:1;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:14:\"/v1/user/<id>/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:1:{s:2:\"id\";s:13:\"#^\\d[\\d,]*$#u\";}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:5;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:21:\"v1/user/<id:\\d[\\d,]*>\";s:7:\"pattern\";s:29:\"#^v1/user/(?P<id>\\d[\\d,]*)$#u\";s:4:\"host\";N;s:5:\"route\";s:12:\"v1/user/view\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:2:{i:0;s:3:\"GET\";i:1;s:4:\"HEAD\";}s:4:\"mode\";N;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:14:\"/v1/user/<id>/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:1:{s:2:\"id\";s:13:\"#^\\d[\\d,]*$#u\";}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:6;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:7:\"v1/user\";s:7:\"pattern\";s:12:\"#^v1/user$#u\";s:4:\"host\";N;s:5:\"route\";s:14:\"v1/user/create\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:1:{i:0;s:4:\"POST\";}s:4:\"mode\";i:1;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:9:\"/v1/user/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:0:{}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:7;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:7:\"v1/user\";s:7:\"pattern\";s:12:\"#^v1/user$#u\";s:4:\"host\";N;s:5:\"route\";s:13:\"v1/user/index\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:2:{i:0;s:3:\"GET\";i:1;s:4:\"HEAD\";}s:4:\"mode\";N;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:9:\"/v1/user/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:0:{}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:8;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:21:\"v1/user/<id:\\d[\\d,]*>\";s:7:\"pattern\";s:29:\"#^v1/user/(?P<id>\\d[\\d,]*)$#u\";s:4:\"host\";N;s:5:\"route\";s:15:\"v1/user/options\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:0:{}s:4:\"mode\";i:1;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:14:\"/v1/user/<id>/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:1:{s:2:\"id\";s:13:\"#^\\d[\\d,]*$#u\";}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}i:9;O:15:\"yii\\web\\UrlRule\":13:{s:4:\"name\";s:7:\"v1/user\";s:7:\"pattern\";s:12:\"#^v1/user$#u\";s:4:\"host\";N;s:5:\"route\";s:15:\"v1/user/options\";s:8:\"defaults\";a:0:{}s:6:\"suffix\";N;s:4:\"verb\";a:0:{}s:4:\"mode\";i:1;s:12:\"encodeParams\";b:1;s:26:\"\0yii\\web\\UrlRule\0_template\";s:9:\"/v1/user/\";s:27:\"\0yii\\web\\UrlRule\0_routeRule\";N;s:28:\"\0yii\\web\\UrlRule\0_paramRules\";a:0:{}s:29:\"\0yii\\web\\UrlRule\0_routeParams\";a:0:{}}}}}}i:1;s:32:\"c376c675907bb7f942431fe1920894fb\";}i:1;N;}'),('a38c0963fc63c284f809d57c048603b2',0,'a:2:{i:0;s:6:\"547364\";i:1;N;}');
/*!40000 ALTER TABLE `jz_cache_for_api` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jz_cache_for_backend`
--

DROP TABLE IF EXISTS `jz_cache_for_backend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jz_cache_for_backend` (
  `id` char(128) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jz_cache_for_backend`
--

LOCK TABLES `jz_cache_for_backend` WRITE;
/*!40000 ALTER TABLE `jz_cache_for_backend` DISABLE KEYS */;
/*!40000 ALTER TABLE `jz_cache_for_backend` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jz_cache_for_frontend`
--

DROP TABLE IF EXISTS `jz_cache_for_frontend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jz_cache_for_frontend` (
  `id` char(128) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jz_cache_for_frontend`
--

LOCK TABLES `jz_cache_for_frontend` WRITE;
/*!40000 ALTER TABLE `jz_cache_for_frontend` DISABLE KEYS */;
INSERT INTO `jz_cache_for_frontend` VALUES ('a38c0963fc63c284f809d57c048603b2',0,'a:2:{i:0;s:6:\"380309\";i:1;N;}');
/*!40000 ALTER TABLE `jz_cache_for_frontend` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jz_company`
--

DROP TABLE IF EXISTS `jz_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jz_company` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL COMMENT '企业名',
  `license_id` varchar(500) NOT NULL COMMENT '营业执照号',
  `license_img` varchar(500) NOT NULL COMMENT '营业执照',
  `examined_time` timestamp NULL DEFAULT NULL COMMENT '审核日期',
  `status` smallint(6) DEFAULT '0' COMMENT '状态',
  `address_id` int(11) DEFAULT NULL COMMENT '地址',
  `examined_by` int(11) NOT NULL DEFAULT '0' COMMENT '审核人',
  `user_id` int(11) NOT NULL COMMENT '用户',
  PRIMARY KEY (`id`),
  KEY `fk_p_company_jz_user1_idx` (`user_id`),
  KEY `fk_p_company_jz_user2_idx` (`examined_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jz_company`
--

LOCK TABLES `jz_company` WRITE;
/*!40000 ALTER TABLE `jz_company` DISABLE KEYS */;
/*!40000 ALTER TABLE `jz_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jz_freetime`
--

DROP TABLE IF EXISTS `jz_freetime`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jz_freetime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dayofweek` smallint(6) NOT NULL COMMENT '周几',
  `morning` tinyint(1) NOT NULL DEFAULT '0' COMMENT '上午',
  `afternoon` tinyint(1) NOT NULL DEFAULT '0' COMMENT '下午',
  `evening` tinyint(1) NOT NULL DEFAULT '0' COMMENT '晚上',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_jz_freetime_jz_user1_idx` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jz_freetime`
--

LOCK TABLES `jz_freetime` WRITE;
/*!40000 ALTER TABLE `jz_freetime` DISABLE KEYS */;
INSERT INTO `jz_freetime` VALUES (1,3,0,1,1,1),(2,4,1,1,1,1),(3,5,1,1,1,1),(4,6,1,1,0,1),(5,1,1,0,0,1),(6,2,1,0,0,1);
/*!40000 ALTER TABLE `jz_freetime` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jz_migration`
--

DROP TABLE IF EXISTS `jz_migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jz_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jz_migration`
--

LOCK TABLES `jz_migration` WRITE;
/*!40000 ALTER TABLE `jz_migration` DISABLE KEYS */;
INSERT INTO `jz_migration` VALUES ('m000000_000000_base',1432547118),('m140506_102106_rbac_init',1432547125);
/*!40000 ALTER TABLE `jz_migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jz_offline_order`
--

DROP TABLE IF EXISTS `jz_offline_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jz_offline_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` varchar(1000) DEFAULT NULL COMMENT '订单号',
  `date` date DEFAULT NULL COMMENT '日期',
  `worker_quntity` int(11) NOT NULL COMMENT '人数',
  `fee` decimal(10,2) NOT NULL COMMENT '服务金额',
  `need_train` tinyint(1) NOT NULL DEFAULT '0' COMMENT '需要培训',
  `requirement` text COMMENT '要求',
  `quality_requirement` text COMMENT '质检要求',
  `status` smallint(6) NOT NULL DEFAULT '0' COMMENT '状态',
  `created_by` int(11) NOT NULL COMMENT '创建人',
  `pm_id` int(11) NOT NULL DEFAULT '0' COMMENT '项目经理',
  `saleman_id` int(11) NOT NULL DEFAULT '0' COMMENT '销售人',
  `company` varchar(500) DEFAULT NULL COMMENT '公司名',
  `person_fee` varchar(100) NOT NULL DEFAULT '无' COMMENT '单价额',
  PRIMARY KEY (`id`),
  KEY `fk_jz_offline_orders_jz_users_idx` (`created_by`),
  KEY `fk_jz_offline_orders_jz_users1_idx` (`pm_id`),
  KEY `fk_jz_offline_orders_jz_users2_idx` (`saleman_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jz_offline_order`
--

LOCK TABLES `jz_offline_order` WRITE;
/*!40000 ALTER TABLE `jz_offline_order` DISABLE KEYS */;
INSERT INTO `jz_offline_order` VALUES (1,'143257529717834485171','2015-05-13',30,6.10,0,'asd','asd',0,1,0,0,'asd','asd'),(2,'14325769011011','2015-05-31',31,15.00,0,'','',0,1,0,0,'','');
/*!40000 ALTER TABLE `jz_offline_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jz_offline_orders_has_addresses`
--

DROP TABLE IF EXISTS `jz_offline_orders_has_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jz_offline_orders_has_addresses` (
  `order_id` bigint(20) NOT NULL COMMENT '服务地址',
  `address_id` int(11) NOT NULL,
  PRIMARY KEY (`order_id`,`address_id`),
  KEY `fk_jz_offline_orders_has_jz_addresses_jz_addresses1_idx` (`address_id`),
  KEY `fk_jz_offline_orders_has_jz_addresses_jz_offline_orders1_idx` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jz_offline_orders_has_addresses`
--

LOCK TABLES `jz_offline_orders_has_addresses` WRITE;
/*!40000 ALTER TABLE `jz_offline_orders_has_addresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `jz_offline_orders_has_addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jz_online_order`
--

DROP TABLE IF EXISTS `jz_online_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jz_online_order` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `gid` varchar(1000) NOT NULL COMMENT '订单号',
  `status` smallint(6) NOT NULL DEFAULT '0' COMMENT '状态',
  `need_train` tinyint(1) NOT NULL DEFAULT '0' COMMENT '需要培训',
  `date` date NOT NULL COMMENT '日期',
  `fee` decimal(10,2) NOT NULL COMMENT '服务金额',
  `worker_quantity` int(11) NOT NULL COMMENT '质检要求',
  `requirement` text,
  `quality_requirement` text,
  `company` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jz_online_order`
--

LOCK TABLES `jz_online_order` WRITE;
/*!40000 ALTER TABLE `jz_online_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `jz_online_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jz_resume`
--

DROP TABLE IF EXISTS `jz_resume`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jz_resume` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL COMMENT '姓名',
  `phonenum` varchar(45) NOT NULL COMMENT '手机号',
  `gender` smallint(6) NOT NULL DEFAULT '0' COMMENT '性别',
  `birthdate` date DEFAULT NULL COMMENT '生日',
  `degree` varchar(500) DEFAULT NULL COMMENT '学历',
  `nation` varchar(255) DEFAULT NULL COMMENT '民族',
  `height` smallint(6) DEFAULT NULL COMMENT '身高',
  `is_student` tinyint(1) DEFAULT NULL COMMENT '是学生',
  `college` varchar(500) DEFAULT NULL COMMENT '学校',
  `avatar` varchar(2048) DEFAULT NULL COMMENT '头像',
  `gov_id` varchar(50) DEFAULT NULL COMMENT '身份证号',
  `grade` smallint(6) DEFAULT '0' COMMENT '年级',
  `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
  `updated_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改日期',
  `status` smallint(6) DEFAULT NULL COMMENT '状态',
  `user_id` int(11) NOT NULL COMMENT '用户',
  `home` int(11) NOT NULL,
  `workplace` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_jz_resume_jz_user1_idx` (`user_id`),
  KEY `fk_jz_resume_jz_address1_idx` (`home`),
  KEY `fk_jz_resume_jz_address2_idx` (`workplace`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jz_resume`
--

LOCK TABLES `jz_resume` WRITE;
/*!40000 ALTER TABLE `jz_resume` DISABLE KEYS */;
INSERT INTO `jz_resume` VALUES (1,'wangwang','18661775816',0,NULL,'','',NULL,0,'',NULL,'',0,'2015-05-25 16:12:15','2015-05-25 16:12:15',NULL,3,0,0),(2,'李艳伟','18661775819',0,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,1,'2015-05-26 12:29:39','2015-05-26 12:29:39',NULL,1,0,0);
/*!40000 ALTER TABLE `jz_resume` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jz_service_type`
--

DROP TABLE IF EXISTS `jz_service_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jz_service_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL COMMENT '服务种类',
  `created_time` timestamp NULL DEFAULT NULL,
  `updated_time` timestamp NULL DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL COMMENT '修改人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jz_service_type`
--

LOCK TABLES `jz_service_type` WRITE;
/*!40000 ALTER TABLE `jz_service_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `jz_service_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jz_service_types_of_orders`
--

DROP TABLE IF EXISTS `jz_service_types_of_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jz_service_types_of_orders` (
  `order_id` bigint(20) NOT NULL,
  `type_id` int(11) NOT NULL,
  PRIMARY KEY (`order_id`,`type_id`),
  KEY `fk_jz_offline_orders_has_jz_service_type_jz_service_type1_idx` (`type_id`),
  KEY `fk_jz_offline_orders_has_jz_service_type_jz_offline_orders1_idx` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jz_service_types_of_orders`
--

LOCK TABLES `jz_service_types_of_orders` WRITE;
/*!40000 ALTER TABLE `jz_service_types_of_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `jz_service_types_of_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jz_user`
--

DROP TABLE IF EXISTS `jz_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jz_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL COMMENT '用户名',
  `password_hash` varchar(500) DEFAULT NULL,
  `password_reset_token` varchar(500) DEFAULT NULL,
  `email` varchar(500) DEFAULT NULL COMMENT '邮箱',
  `auth_key` varchar(1000) DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0' COMMENT '状态',
  `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `name` varchar(200) DEFAULT NULL COMMENT '姓名',
  `access_token` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jz_user`
--

LOCK TABLES `jz_user` WRITE;
/*!40000 ALTER TABLE `jz_user` DISABLE KEYS */;
INSERT INTO `jz_user` VALUES (1,'18661775819','$2y$13$HlOGbubWIp5BjlQewXcKtOWPJ2VvpASfBqkNHl5zG.AHGLEeEI9AW',NULL,'',NULL,10,'2015-05-25 11:02:06','2015-05-25 11:26:42','李大伟',NULL),(2,'18661775818','$2y$13$Fmcqdx7.lg.2e4lFL/x8Nu37tX5x/XTwVz24u/qQuWOZNrMUZudd.',NULL,NULL,NULL,10,'2015-05-25 11:02:47','2015-05-25 11:02:47',NULL,NULL),(3,'18661775816','$2y$13$tnHvN2GdxVDRHPuf3DTTIORL0rRjUU7OppOlH8O8jn6S4NW3PgaW2',NULL,NULL,NULL,10,'2015-05-25 16:12:15','2015-05-25 16:12:15',NULL,NULL);
/*!40000 ALTER TABLE `jz_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jz_user_has_service_type`
--

DROP TABLE IF EXISTS `jz_user_has_service_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jz_user_has_service_type` (
  `user_id` int(11) NOT NULL,
  `service_type_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`service_type_id`),
  KEY `fk_jz_user_has_jz_service_type_jz_service_type1_idx` (`service_type_id`),
  KEY `fk_jz_user_has_jz_service_type_jz_user1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jz_user_has_service_type`
--

LOCK TABLES `jz_user_has_service_type` WRITE;
/*!40000 ALTER TABLE `jz_user_has_service_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `jz_user_has_service_type` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-05-26 20:40:03
