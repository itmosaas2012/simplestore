-- MySQL dump 10.13  Distrib 5.1.55, for portbld-freebsd8.2 (amd64)
--
-- Host: mysql.thedox.z8.ru    Database: db_thedox_18
-- ------------------------------------------------------
-- Server version	5.0.77-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES cp1251 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `brand_1`
--

DROP TABLE IF EXISTS `brand_1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brand_1` (
  `brandID` int(8) NOT NULL auto_increment,
  `name` varchar(64) NOT NULL,
  `site` varchar(64) default NULL,
  `description` text,
  PRIMARY KEY  (`brandID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brand_1`
--

LOCK TABLES `brand_1` WRITE;
/*!40000 ALTER TABLE `brand_1` DISABLE KEYS */;
/*!40000 ALTER TABLE `brand_1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_1`
--

DROP TABLE IF EXISTS `category_1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_1` (
  `categoryID` int(8) NOT NULL auto_increment,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY  (`categoryID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_1`
--

LOCK TABLES `category_1` WRITE;
/*!40000 ALTER TABLE `category_1` DISABLE KEYS */;
/*!40000 ALTER TABLE `category_1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company` (
  `companyID` int(8) NOT NULL auto_increment,
  `nick` varchar(32) NOT NULL,
  `logo` mediumblob,
  `address` varchar(128) default NULL,
  `name` varchar(32) default NULL,
  `deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`companyID`),
  UNIQUE KEY `nick` (`nick`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` VALUES (1,'bbb',NULL,NULL,NULL,0);
/*!40000 ALTER TABLE `company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deliveryObject_1`
--

DROP TABLE IF EXISTS `deliveryObject_1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deliveryObject_1` (
  `objectID` int(10) NOT NULL,
  `deliveryID` int(10) NOT NULL,
  `count` int(8) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deliveryObject_1`
--

LOCK TABLES `deliveryObject_1` WRITE;
/*!40000 ALTER TABLE `deliveryObject_1` DISABLE KEYS */;
/*!40000 ALTER TABLE `deliveryObject_1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delivery_1`
--

DROP TABLE IF EXISTS `delivery_1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delivery_1` (
  `deliveryID` int(10) NOT NULL auto_increment,
  `responsible` varchar(256) default NULL,
  `dispatchTime` datetime default NULL,
  `arrivalTime` datetime default NULL,
  `from` int(8) default NULL,
  `to` int(8) default NULL,
  PRIMARY KEY  (`deliveryID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery_1`
--

LOCK TABLES `delivery_1` WRITE;
/*!40000 ALTER TABLE `delivery_1` DISABLE KEYS */;
/*!40000 ALTER TABLE `delivery_1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_1`
--

DROP TABLE IF EXISTS `item_1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_1` (
  `itemID` int(10) NOT NULL auto_increment,
  `name` varchar(1024) NOT NULL,
  `description` text,
  `cost` int(8) default NULL,
  `volume` int(8) default NULL,
  `categoryID` int(8) default NULL,
  `brandID` int(8) default NULL,
  PRIMARY KEY  (`itemID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_1`
--

LOCK TABLES `item_1` WRITE;
/*!40000 ALTER TABLE `item_1` DISABLE KEYS */;
/*!40000 ALTER TABLE `item_1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_1`
--

DROP TABLE IF EXISTS `log_1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_1` (
  `date` datetime NOT NULL,
  `login` varchar(60) NOT NULL,
  `description` varchar(2048) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_1`
--

LOCK TABLES `log_1` WRITE;
/*!40000 ALTER TABLE `log_1` DISABLE KEYS */;
/*!40000 ALTER TABLE `log_1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `object_1`
--

DROP TABLE IF EXISTS `object_1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `object_1` (
  `objectID` int(10) NOT NULL auto_increment,
  `count` int(8) default '0',
  `itemID` int(10) NOT NULL,
  `workplaceID` int(8) NOT NULL,
  PRIMARY KEY  (`objectID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `object_1`
--

LOCK TABLES `object_1` WRITE;
/*!40000 ALTER TABLE `object_1` DISABLE KEYS */;
/*!40000 ALTER TABLE `object_1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rank`
--

DROP TABLE IF EXISTS `rank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rank` (
  `rankID` int(2) NOT NULL auto_increment,
  `name` varchar(40) NOT NULL,
  PRIMARY KEY  (`rankID`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rank`
--

LOCK TABLES `rank` WRITE;
/*!40000 ALTER TABLE `rank` DISABLE KEYS */;
INSERT INTO `rank` VALUES (1,'Администратор'),(2,'Товаровед склада'),(3,'Логист склада'),(4,'Продавец магазина'),(5,'Товароввед магазина'),(6,'Закупщик магазина');
/*!40000 ALTER TABLE `rank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `request_1`
--

DROP TABLE IF EXISTS `request_1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `request_1` (
  `requestID` int(10) NOT NULL auto_increment,
  `userID` int(8) default NULL,
  `objectID` int(10) default NULL,
  `count` int(8) default NULL,
  PRIMARY KEY  (`requestID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `request_1`
--

LOCK TABLES `request_1` WRITE;
/*!40000 ALTER TABLE `request_1` DISABLE KEYS */;
/*!40000 ALTER TABLE `request_1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `soldObject_1`
--

DROP TABLE IF EXISTS `soldObject_1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `soldObject_1` (
  `soldID` int(10) NOT NULL,
  `objectID` int(10) NOT NULL,
  `count` int(8) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `soldObject_1`
--

LOCK TABLES `soldObject_1` WRITE;
/*!40000 ALTER TABLE `soldObject_1` DISABLE KEYS */;
/*!40000 ALTER TABLE `soldObject_1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sold_1`
--

DROP TABLE IF EXISTS `sold_1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sold_1` (
  `soldID` int(10) NOT NULL auto_increment,
  `date` datetime default NULL,
  PRIMARY KEY  (`soldID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sold_1`
--

LOCK TABLES `sold_1` WRITE;
/*!40000 ALTER TABLE `sold_1` DISABLE KEYS */;
/*!40000 ALTER TABLE `sold_1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userRank_1`
--

DROP TABLE IF EXISTS `userRank_1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userRank_1` (
  `userRankID` int(8) NOT NULL auto_increment,
  `rankID` int(2) NOT NULL,
  `userID` int(8) NOT NULL,
  PRIMARY KEY  (`userRankID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userRank_1`
--

LOCK TABLES `userRank_1` WRITE;
/*!40000 ALTER TABLE `userRank_1` DISABLE KEYS */;
INSERT INTO `userRank_1` VALUES (1,1,1);
/*!40000 ALTER TABLE `userRank_1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_1`
--

DROP TABLE IF EXISTS `user_1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_1` (
  `userID` int(8) NOT NULL auto_increment,
  `login` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `email` varchar(32) NOT NULL,
  `name` varchar(60) default NULL,
  `surname` varchar(60) default NULL,
  `patronymic` varchar(630) default NULL,
  `tell` varchar(15) default NULL,
  `series` varchar(10) default NULL,
  `number` varchar(10) default NULL,
  `activated` tinyint(1) default '0',
  `sex` tinyint(1) default NULL COMMENT '1-male,0-female',
  `workplaceID` int(8) default NULL,
  PRIMARY KEY  (`userID`),
  UNIQUE KEY `login` (`login`,`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_1`
--

LOCK TABLES `user_1` WRITE;
/*!40000 ALTER TABLE `user_1` DISABLE KEYS */;
INSERT INTO `user_1` VALUES (1,'bbbff','ttttttt','wetwe@sdg.com',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL);
/*!40000 ALTER TABLE `user_1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workplace_1`
--

DROP TABLE IF EXISTS `workplace_1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workplace_1` (
  `workplaceID` int(8) NOT NULL auto_increment,
  `wpTypeID` int(1) NOT NULL,
  `address` varchar(256) default NULL,
  `capacity` int(8) default NULL,
  `responsible` int(8) default NULL,
  PRIMARY KEY  (`workplaceID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workplace_1`
--

LOCK TABLES `workplace_1` WRITE;
/*!40000 ALTER TABLE `workplace_1` DISABLE KEYS */;
/*!40000 ALTER TABLE `workplace_1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wpType`
--

DROP TABLE IF EXISTS `wpType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wpType` (
  `wpTypeID` int(1) NOT NULL auto_increment,
  `description` varchar(32) NOT NULL,
  PRIMARY KEY  (`wpTypeID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wpType`
--

LOCK TABLES `wpType` WRITE;
/*!40000 ALTER TABLE `wpType` DISABLE KEYS */;
INSERT INTO `wpType` VALUES (1,'wh'),(2,'shop');
/*!40000 ALTER TABLE `wpType` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-12-05 22:20:46
