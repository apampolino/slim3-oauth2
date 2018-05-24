-- MySQL dump 10.13  Distrib 5.6.39, for Linux (x86_64)
--
-- Host: localhost    Database: authorization
-- ------------------------------------------------------
-- Server version	5.6.39

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
-- Table structure for table `oauth2_access_tokens`
--

DROP TABLE IF EXISTS `oauth2_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth2_access_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` varchar(50) DEFAULT NULL,
  `access_token` varchar(120) DEFAULT NULL,
  `user_identifier` int(10) DEFAULT NULL,
  `expiry` int(11) DEFAULT NULL,
  `scopes` text,
  `revoked` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth2_access_tokens`
--

LOCK TABLES `oauth2_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth2_access_tokens` DISABLE KEYS */;
INSERT INTO `oauth2_access_tokens` VALUES (4,'alex','d975fbbeead6476bb4b46d5bfef71ad03dc791ab98422c12b6c2da4201ee9d0b93bfaa0f813a3666',NULL,1527166460,'basic',0),(5,'alex','23e5c3be9729481c9e8eb7ce6fc3ea3bfd8b722b7d7a7ed585ab70f3c9e523f4fc0c6d99e1e16d4f',1,1527166506,'basic,email',1),(6,'alex','42884941b4fc3275ad948f8047dbfca135b3ac4d3e1af0512c6d79bc98ce81b19c1bff88073c3d3a',1,1527166707,'basic,email',0),(7,'alex','4d76829c43eab95d5ced8d22707b489ba87265bec3fe30af49b5aa9acfabe9535976f54922325884',1,1527181897,'basic,email',0);
/*!40000 ALTER TABLE `oauth2_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth2_auth_codes`
--

DROP TABLE IF EXISTS `oauth2_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth2_auth_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` varchar(50) DEFAULT NULL,
  `auth_code` varchar(120) DEFAULT NULL,
  `user_identifier` int(11) DEFAULT NULL,
  `expiry` int(11) unsigned zerofill DEFAULT NULL,
  `scopes` text,
  `revoked` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth2_auth_codes`
--

LOCK TABLES `oauth2_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth2_auth_codes` DISABLE KEYS */;
INSERT INTO `oauth2_auth_codes` VALUES (4,'alex','3d8b236ee08aa3e23e20cc5441e0aca8f172d066b88441369a5933360115dfee345fff5f22e58e84',1,01527163490,'basic',1);
/*!40000 ALTER TABLE `oauth2_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth2_clients`
--

DROP TABLE IF EXISTS `oauth2_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth2_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` varchar(50) DEFAULT NULL,
  `client_secret` varchar(150) DEFAULT NULL,
  `app_name` varchar(100) DEFAULT NULL,
  `redirect_uri` varchar(50) DEFAULT NULL,
  `is_confidential` int(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth2_clients`
--

LOCK TABLES `oauth2_clients` WRITE;
/*!40000 ALTER TABLE `oauth2_clients` DISABLE KEYS */;
INSERT INTO `oauth2_clients` VALUES (1,'test','$2y$10$Y3xgz9Rf/dfppTBvFlzDn.TqssE7Wi5DZ5ELzzAnuEkYRW5Hk2CVK','Test App','77.77.77.2:8000/auth',1,'2018-04-27 16:20:56','2018-04-27 16:50:56'),(2,'test2','$2y$10$Y3xgz9Rf/dfppTBvFlzDn.TqssE7Wi5DZ5ELzzAnuEkYRW5Hk2CVK','Test App 2','http://77.77.77.2:8000/',1,'2018-04-27 16:22:00','2018-05-24 11:38:20'),(3,'john','$2y$10$Y3xgz9Rf/dfppTBvFlzDn.TqssE7Wi5DZ5ELzzAnuEkYRW5Hk2CVK','Test App 3','http://77.77.77.2:8000/',1,'2018-04-30 20:29:57','2018-05-24 11:38:19'),(4,'alex','$2y$10$Y3xgz9Rf/dfppTBvFlzDn.TqssE7Wi5DZ5ELzzAnuEkYRW5Hk2CVK','Test App 4','http://77.77.77.2:8000/',1,'2018-05-04 15:27:32','2018-05-24 11:12:07');
/*!40000 ALTER TABLE `oauth2_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth2_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth2_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth2_refresh_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `refresh_token` varchar(120) DEFAULT NULL,
  `access_token` varchar(120) DEFAULT NULL,
  `expiry` int(11) DEFAULT NULL,
  `revoked` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth2_refresh_tokens`
--

LOCK TABLES `oauth2_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth2_refresh_tokens` DISABLE KEYS */;
INSERT INTO `oauth2_refresh_tokens` VALUES (4,'72b2299794a7f83ab2f219e0f67e669a2d92e97fdb671b9c2cb17b9ea9e79ab8ec1496900289a02d','23e5c3be9729481c9e8eb7ce6fc3ea3bfd8b722b7d7a7ed585ab70f3c9e523f4fc0c6d99e1e16d4f',1529841306,1),(5,'1ff494427673cb73d76815a4a908a2ccd17f5332d5a969e4db5da95fcde3f8a42cc89349eacd0fdb','42884941b4fc3275ad948f8047dbfca135b3ac4d3e1af0512c6d79bc98ce81b19c1bff88073c3d3a',1529841507,NULL),(6,'8cd44a0b803c9650ba7248d8dceb341410e02833f213a32fc1d6036228d386d434cab1d07a7f0972','4d76829c43eab95d5ced8d22707b489ba87265bec3fe30af49b5aa9acfabe9535976f54922325884',1529856697,NULL);
/*!40000 ALTER TABLE `oauth2_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth2_scopes`
--

DROP TABLE IF EXISTS `oauth2_scopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth2_scopes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type` int(1) DEFAULT '1',
  `scope` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth2_scopes`
--

LOCK TABLES `oauth2_scopes` WRITE;
/*!40000 ALTER TABLE `oauth2_scopes` DISABLE KEYS */;
INSERT INTO `oauth2_scopes` VALUES (1,1,'basic'),(2,1,'email'),(3,1,'username'),(4,1,'password');
/*!40000 ALTER TABLE `oauth2_scopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(120) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(120) DEFAULT NULL,
  `role` int(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'','aaron','16d7a4fca7442dda3ad93c9a726597e4',1);
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

-- Dump completed on 2018-05-24 16:14:47
