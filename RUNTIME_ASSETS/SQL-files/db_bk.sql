-- MySQL dump 10.13  Distrib 5.5.30, for Linux (x86_64)
--
-- Host: localhost    Database: botb_podcast
-- ------------------------------------------------------
-- Server version	5.5.30-30.1

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
-- Table structure for table `podcast_access_levels`
--

DROP TABLE IF EXISTS `podcast_access_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `podcast_access_levels` (
  `user_access_level` varchar(15) NOT NULL,
  `user_access_write` tinyint(1) NOT NULL,
  `user_access_read` tinyint(1) NOT NULL,
  `user_access_delete` tinyint(1) NOT NULL,
  `user_podcast_all` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_access_level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `podcast_access_levels`
--

LOCK TABLES `podcast_access_levels` WRITE;
/*!40000 ALTER TABLE `podcast_access_levels` DISABLE KEYS */;
INSERT INTO `podcast_access_levels` VALUES ('admin',1,1,1,0),('root',1,1,1,1),('standard',1,1,0,0);
/*!40000 ALTER TABLE `podcast_access_levels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `podcast_category_options`
--

DROP TABLE IF EXISTS `podcast_category_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `podcast_category_options` (
  `category_id` int(10) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(45) NOT NULL,
  `category_parent` int(10) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=170 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `podcast_category_options`
--

LOCK TABLES `podcast_category_options` WRITE;
/*!40000 ALTER TABLE `podcast_category_options` DISABLE KEYS */;
INSERT INTO `podcast_category_options` VALUES (2,'Arts',2),(62,'Design',2),(63,'Fashion & Beauty',2),(64,'Food',2),(65,'Literature',2),(66,'Performing Arts',2),(67,'Spoken Word',2),(68,'Visual Arts',2);
/*!40000 ALTER TABLE `podcast_category_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `podcast_config`
--

DROP TABLE IF EXISTS `podcast_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `podcast_config` (
  `podcast_config_id` int(11) NOT NULL AUTO_INCREMENT,
  `podcast_title` varchar(300) NOT NULL,
  `podcast_link` varchar(700) NOT NULL,
  `podcast_language` varchar(10) NOT NULL,
  `podcast_subtitle` varchar(700) NOT NULL,
  `podcast_summary` varchar(700) NOT NULL,
  `podcast_description` varchar(700) NOT NULL,
  `podcast_owner_name` varchar(150) NOT NULL,
  `podcast_owner_email` varchar(150) NOT NULL,
  `podcast_image` varchar(700) NOT NULL,
  `podcast_keywords` varchar(700) NOT NULL,
  `podcast_categories` varchar(700) NOT NULL,
  `podcast_podcast_loc` varchar(700) NOT NULL,
  `podcast_type` varchar(45) NOT NULL,
  PRIMARY KEY (`podcast_config_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf16;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `podcast_config`
--

LOCK TABLES `podcast_config` WRITE;
/*!40000 ALTER TABLE `podcast_config` DISABLE KEYS */;
INSERT INTO `podcast_config` VALUES (1,'Test Show','www.google.com','gb-en','This is test text','This is test text','This is test text','Alex Brown','test@test.com','1_1400_1400','test me silly','Food','Test_show','standard-a'),(2,'qwefwfwefwefwef','www.google.com','en-gb',' wrgfw rgfw r  wrgfw rgfw r  wrgfw rgfw r  wrgfw rgfw r  wrgfw rgfw r  wrgfw rgfw r  wrgfw rgfw r  wrgfw rgfw r ',' wrgfw rgfw r  wrgfw rgfw r  wrgfw rgfw r  wrgfw rgfw r  wrgfw rgfw r  wrgfw rgfw r  wrgfw rgfw r  wrgfw rgfw r ',' wrgfw rgfw r  wrgfw rgfw r  wrgfw rgfw r  wrgfw rgfw r  wrgfw rgfw r  wrgfw rgfw r  wrgfw rgfw r  wrgfw rgfw r ','Apexc ff','test@test.com','2_1400_1400.png','hey hey hey ','Food','qwefwfwefwefwef','stAudioType'),(3,'This Is A New Show','www.google.com','en-gb','thethetheth eth tr thethetheth eth tr thethetheth eth tr thethetheth eth tr thethetheth eth tr thethetheth eth tr ','thethetheth eth tr thethetheth eth tr thethetheth eth tr thethetheth eth tr thethetheth eth tr thethetheth eth tr ','thethetheth eth tr thethetheth eth tr thethetheth eth tr thethetheth eth tr thethetheth eth tr thethetheth eth tr ','Alex Brown','test@test.com','3_1400_1400.png','sddv dsd d sd ','Food','This_Is_A_New_Show','stAudioType'),(4,'This is for sam ','www.bestofthebets.com','en-gb','avksdvjk svjklsdnhv avksdvjk svjklsdnhv avksdvjk svjklsdnhv avksdvjk svjklsdnhv ','avksdvjk svjklsdnhv avksdvjk svjklsdnhv avksdvjk svjklsdnhv avksdvjk svjklsdnhv ','avksdvjk svjklsdnhv avksdvjk svjklsdnhv avksdvjk svjklsdnhv avksdvjk svjklsdnhv ','tHIS IS SAM','test@test.com','4_1400_1400.png','swgfwegwer','Food','This_is_for_sam_','stAudioType');
/*!40000 ALTER TABLE `podcast_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `podcast_shows`
--

DROP TABLE IF EXISTS `podcast_shows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `podcast_shows` (
  `podcast_count_id` int(11) NOT NULL AUTO_INCREMENT,
  `podcast_id` int(11) NOT NULL,
  `podcast_publish_date` date NOT NULL,
  `podcast_title` varchar(250) NOT NULL,
  `podcast_description` varchar(2000) NOT NULL,
  `podcast_asset_url` varchar(300) NOT NULL,
  `podcast_link` varchar(300) NOT NULL,
  `podcast_length` int(11) NOT NULL,
  `podcast_tidy_length` time NOT NULL,
  `podcast_category` varchar(300) NOT NULL,
  `podcast_tags` varchar(45) NOT NULL,
  `podcast_config_id` int(11) NOT NULL,
  PRIMARY KEY (`podcast_count_id`),
  UNIQUE KEY `podcast_count_id_UNIQUE` (`podcast_count_id`),
  KEY `podcast_show_related_id` (`podcast_config_id`),
  CONSTRAINT `podcast_show_related_id` FOREIGN KEY (`podcast_config_id`) REFERENCES `podcast_config` (`podcast_config_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf16;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `podcast_shows`
--

LOCK TABLES `podcast_shows` WRITE;
/*!40000 ALTER TABLE `podcast_shows` DISABLE KEYS */;
INSERT INTO `podcast_shows` VALUES (5,1,'2012-01-01','This is for sam  #1','avksdvjk svjklsdnhv avksdvjk svjklsdnhv avksdvjk svjklsdnhv avksdvjk svjklsdnhv ','3409da9e429833be165f9dcde6ccb6fdc9ddb70f.mp3','3409da9e429833be165f9dcde6ccb6fdc9ddb70f.mp3',4842585,'00:03:20','Food','swgfwegwer',4);
/*!40000 ALTER TABLE `podcast_shows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `podcast_types`
--

DROP TABLE IF EXISTS `podcast_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `podcast_types` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(45) NOT NULL,
  `type_extension` varchar(10) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf16;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `podcast_types`
--

LOCK TABLES `podcast_types` WRITE;
/*!40000 ALTER TABLE `podcast_types` DISABLE KEYS */;
INSERT INTO `podcast_types` VALUES (1,'standard-audio','mp3'),(2,'satndard-video','mp4');
/*!40000 ALTER TABLE `podcast_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `podcast_users`
--

DROP TABLE IF EXISTS `podcast_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `podcast_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(45) NOT NULL,
  `user_hash` varchar(45) NOT NULL,
  `user_account_assoc` int(11) NOT NULL,
  `user_access_level` varchar(15) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name_UNIQUE` (`user_name`),
  KEY `podcast_user_lvl_id` (`user_access_level`),
  KEY `podcast_user_podcast_config_id` (`user_account_assoc`),
  CONSTRAINT `podcast_user_podcast_config_id` FOREIGN KEY (`user_account_assoc`) REFERENCES `podcast_config` (`podcast_config_id`),
  CONSTRAINT `podcast_user_lvl_id` FOREIGN KEY (`user_access_level`) REFERENCES `podcast_access_levels` (`user_access_level`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf16;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `podcast_users`
--

LOCK TABLES `podcast_users` WRITE;
/*!40000 ALTER TABLE `podcast_users` DISABLE KEYS */;
INSERT INTO `podcast_users` VALUES (1,'test','dd6c91bb9286800c71d6eb5ee33cff343e3dfdca',1,'root'),(2,'heyheyhey','dd6c91bb9286800c71d6eb5ee33cff343e3dfdca',2,'root'),(3,'stump1000','dd6c91bb9286800c71d6eb5ee33cff343e3dfdca',3,'root'),(4,'samishere','dd6c91bb9286800c71d6eb5ee33cff343e3dfdca',4,'root');
/*!40000 ALTER TABLE `podcast_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-04-08 16:15:50
