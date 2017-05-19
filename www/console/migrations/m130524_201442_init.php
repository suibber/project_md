<?php

use yii\db\Schema;
use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $sqls = 
        "-- MySQL dump 10.13  Distrib 5.6.19, for debian-linux-gnu (x86_64)
        --
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
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        /*!40101 SET character_set_client = @saved_cs_client */;

        --
        -- Dumping data for table `jz_freetime`
        --

        LOCK TABLES `jz_freetime` WRITE;
        /*!40000 ALTER TABLE `jz_freetime` DISABLE KEYS */;
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
        ) ENGINE=InnoDB AUTO_INCREMENT=10000000000 DEFAULT CHARSET=utf8;
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
        ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
        /*!40101 SET character_set_client = @saved_cs_client */;

        --
        -- Dumping data for table `jz_resume`
        --

        LOCK TABLES `jz_resume` WRITE;
        /*!40000 ALTER TABLE `jz_resume` DISABLE KEYS */;
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
          PRIMARY KEY (`id`),
          UNIQUE KEY `username_UNIQUE` (`username`)
        ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
        /*!40101 SET character_set_client = @saved_cs_client */;

        --
        -- Dumping data for table `jz_user`
        --

        LOCK TABLES `jz_user` WRITE;
        /*!40000 ALTER TABLE `jz_user` DISABLE KEYS */;
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

        -- Dump completed on 2015-05-26  3:45:35";

        foreach (explode(';', $sqls) as $sql){
            $this->db->createCommand($sql)->execute();
        }
    }

    public function down()
    {
        echo "could not revert , you can drop table directly";
        return false;
    }
}
