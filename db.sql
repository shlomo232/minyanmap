-- MySQL dump 10.13  Distrib 5.5.44, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: maindb
-- ------------------------------------------------------
-- Server version	5.5.44-0ubuntu0.14.04.1

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
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cities` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_nameen` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `city_namehe` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cities`
--

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (1,'Haifa','חיפה');
INSERT INTO `cities` VALUES (4,'Jerusalem','ירושלים');
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `minyans`
--

DROP TABLE IF EXISTS `minyans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `minyans` (
  `minyan_id` int(11) NOT NULL AUTO_INCREMENT,
  `minyan_shul` int(11) NOT NULL,
  `minyan_whichprayer` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `minyan_time` int(11) NOT NULL,
  `minyan_day` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`minyan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `minyans`
--

LOCK TABLES `minyans` WRITE;
/*!40000 ALTER TABLE `minyans` DISABLE KEYS */;
INSERT INTO `minyans` VALUES (1,8,'shacharit',700,'123456');
INSERT INTO `minyans` VALUES (2,8,'shacharit',800,'123456');
INSERT INTO `minyans` VALUES (5,7,'shacharit',700,'123456');
/*!40000 ALTER TABLE `minyans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `neighborhoods`
--

DROP TABLE IF EXISTS `neighborhoods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `neighborhoods` (
  `neighborhood_id` int(11) NOT NULL AUTO_INCREMENT,
  `neighborhood_nameen` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `neighborhood_namehe` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `neighborhood_city` int(11) NOT NULL,
  PRIMARY KEY (`neighborhood_id`),
  UNIQUE KEY `neighborhood_id` (`neighborhood_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `neighborhoods`
--

LOCK TABLES `neighborhoods` WRITE;
/*!40000 ALTER TABLE `neighborhoods` DISABLE KEYS */;
INSERT INTO `neighborhoods` VALUES (1,'Ziv','זיו',1);
INSERT INTO `neighborhoods` VALUES (2,'Ramot','רמות',4);
INSERT INTO `neighborhoods` VALUES (3,'Hadar','הדר',1);
INSERT INTO `neighborhoods` VALUES (6,'Katamon Hayeshana','קטמון הישנה',4);
INSERT INTO `neighborhoods` VALUES (7,'Baka','בקעה',4);
/*!40000 ALTER TABLE `neighborhoods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shuls`
--

DROP TABLE IF EXISTS `shuls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shuls` (
  `shul_id` int(11) NOT NULL AUTO_INCREMENT,
  `shul_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `shul_city` int(11) NOT NULL,
  `shul_neighborhood` int(11) NOT NULL,
  `shul_address` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `shul_lat` float NOT NULL,
  `shul_lon` float NOT NULL,
  `shul_nusach` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `shul_contactinfo` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`shul_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shuls`
--

LOCK TABLES `shuls` WRITE;
/*!40000 ALTER TABLE `shuls` DISABLE KEYS */;
INSERT INTO `shuls` VALUES (4,'Some ramot shul',4,2,'1 Golda',1,2,'ashkenaz','hello');
INSERT INTO `shuls` VALUES (6,'Or Vishua',1,1,'96 trumpledor',32.7854,35.017,'ashkenaz','rav zini');
INSERT INTO `shuls` VALUES (7,'רמב\"ן',4,2,'אמציה 2',31.7623,35.2152,'ashkenaz','');
INSERT INTO `shuls` VALUES (8,'ניצנים',4,7,'אשר 2',31.759,35.2162,'ashkenaz','');
/*!40000 ALTER TABLE `shuls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uc_configuration`
--

DROP TABLE IF EXISTS `uc_configuration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `value` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_configuration`
--

LOCK TABLES `uc_configuration` WRITE;
/*!40000 ALTER TABLE `uc_configuration` DISABLE KEYS */;
INSERT INTO `uc_configuration` VALUES (1,'website_name','UserCake');
INSERT INTO `uc_configuration` VALUES (2,'website_url','localhost/');
INSERT INTO `uc_configuration` VALUES (3,'email','noreply@ILoveUserCake.com');
INSERT INTO `uc_configuration` VALUES (4,'activation','false');
INSERT INTO `uc_configuration` VALUES (5,'resend_activation_threshold','0');
INSERT INTO `uc_configuration` VALUES (6,'language','models/languages/en.php');
INSERT INTO `uc_configuration` VALUES (7,'template','models/site-templates/default.css');
/*!40000 ALTER TABLE `uc_configuration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uc_pages`
--

DROP TABLE IF EXISTS `uc_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(150) NOT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_pages`
--

LOCK TABLES `uc_pages` WRITE;
/*!40000 ALTER TABLE `uc_pages` DISABLE KEYS */;
INSERT INTO `uc_pages` VALUES (1,'account.php',1);
INSERT INTO `uc_pages` VALUES (2,'activate-account.php',0);
INSERT INTO `uc_pages` VALUES (3,'admin_configuration.php',1);
INSERT INTO `uc_pages` VALUES (4,'admin_page.php',1);
INSERT INTO `uc_pages` VALUES (5,'admin_pages.php',1);
INSERT INTO `uc_pages` VALUES (6,'admin_permission.php',1);
INSERT INTO `uc_pages` VALUES (7,'admin_permissions.php',1);
INSERT INTO `uc_pages` VALUES (8,'admin_user.php',1);
INSERT INTO `uc_pages` VALUES (9,'admin_users.php',1);
INSERT INTO `uc_pages` VALUES (10,'forgot-password.php',0);
INSERT INTO `uc_pages` VALUES (11,'index.php',0);
INSERT INTO `uc_pages` VALUES (12,'left-nav.php',0);
INSERT INTO `uc_pages` VALUES (13,'login.php',0);
INSERT INTO `uc_pages` VALUES (14,'logout.php',1);
INSERT INTO `uc_pages` VALUES (15,'register.php',0);
INSERT INTO `uc_pages` VALUES (16,'resend-activation.php',0);
INSERT INTO `uc_pages` VALUES (17,'user_settings.php',1);
/*!40000 ALTER TABLE `uc_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uc_permission_page_matches`
--

DROP TABLE IF EXISTS `uc_permission_page_matches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_permission_page_matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_permission_page_matches`
--

LOCK TABLES `uc_permission_page_matches` WRITE;
/*!40000 ALTER TABLE `uc_permission_page_matches` DISABLE KEYS */;
INSERT INTO `uc_permission_page_matches` VALUES (1,1,1);
INSERT INTO `uc_permission_page_matches` VALUES (2,1,14);
INSERT INTO `uc_permission_page_matches` VALUES (3,1,17);
INSERT INTO `uc_permission_page_matches` VALUES (4,2,1);
INSERT INTO `uc_permission_page_matches` VALUES (5,2,3);
INSERT INTO `uc_permission_page_matches` VALUES (6,2,4);
INSERT INTO `uc_permission_page_matches` VALUES (7,2,5);
INSERT INTO `uc_permission_page_matches` VALUES (8,2,6);
INSERT INTO `uc_permission_page_matches` VALUES (9,2,7);
INSERT INTO `uc_permission_page_matches` VALUES (10,2,8);
INSERT INTO `uc_permission_page_matches` VALUES (11,2,9);
INSERT INTO `uc_permission_page_matches` VALUES (12,2,14);
INSERT INTO `uc_permission_page_matches` VALUES (13,2,17);
/*!40000 ALTER TABLE `uc_permission_page_matches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uc_permissions`
--

DROP TABLE IF EXISTS `uc_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_permissions`
--

LOCK TABLES `uc_permissions` WRITE;
/*!40000 ALTER TABLE `uc_permissions` DISABLE KEYS */;
INSERT INTO `uc_permissions` VALUES (1,'New Member');
INSERT INTO `uc_permissions` VALUES (2,'Administrator');
/*!40000 ALTER TABLE `uc_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uc_user_permission_matches`
--

DROP TABLE IF EXISTS `uc_user_permission_matches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_user_permission_matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_user_permission_matches`
--

LOCK TABLES `uc_user_permission_matches` WRITE;
/*!40000 ALTER TABLE `uc_user_permission_matches` DISABLE KEYS */;
INSERT INTO `uc_user_permission_matches` VALUES (1,1,2);
INSERT INTO `uc_user_permission_matches` VALUES (2,1,1);
/*!40000 ALTER TABLE `uc_user_permission_matches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uc_users`
--

DROP TABLE IF EXISTS `uc_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uc_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `display_name` varchar(50) NOT NULL,
  `password` varchar(225) NOT NULL,
  `email` varchar(150) NOT NULL,
  `activation_token` varchar(225) NOT NULL,
  `last_activation_request` int(11) NOT NULL,
  `lost_password_request` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `title` varchar(150) NOT NULL,
  `sign_up_stamp` int(11) NOT NULL,
  `last_sign_in_stamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uc_users`
--

LOCK TABLES `uc_users` WRITE;
/*!40000 ALTER TABLE `uc_users` DISABLE KEYS */;
INSERT INTO `uc_users` VALUES (1,'ericeric','ericeric','6be6f432ffc5c5c996509ff5d3dbe3c566e44c841e9100f9bb7560fd25f044951','shlomo.katz@gmail.com','a673fd26dd7972a66677d72d35f3b1f6',1439543508,0,1,'New Member',1439543508,1439543558);
/*!40000 ALTER TABLE `uc_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-08-20 18:58:23
