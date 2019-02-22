-- MySQL dump 10.13  Distrib 5.7.17, for Linux (x86_64)
--
-- Host: localhost    Database: problem07
-- ------------------------------------------------------
-- Server version	5.7.17

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
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) unsigned NOT NULL,
  `title` varchar(300) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `comment` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `age` date NOT NULL,
  `home` varchar(50) NOT NULL,
  `deleted` timestamp NULL DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (49,'NAOYA','ARAI','0000-00-00','京都',NULL,'2019-02-20 00:19:26','2019-02-20 00:19:26'),(50,'NAOYA','ARAI','0000-00-00','京都',NULL,'2019-02-20 00:29:40','2019-02-20 00:29:40'),(51,'NAOYA','ARAI','0000-00-00','大阪府',NULL,'2019-02-20 00:37:10','2019-02-20 00:37:10'),(52,'NAOYA','ARAI','0000-00-00','大阪府',NULL,'2019-02-20 01:25:41','2019-02-20 01:49:02'),(53,'NAOYA','ARAI','0000-00-00','京都',NULL,'2019-02-20 01:41:18','2019-02-20 02:23:03'),(55,'NAOYA','ARAI','0000-00-00','京都',NULL,'2019-02-20 02:28:09','2019-02-20 02:29:12'),(56,'NAOYA','ARAI','0000-00-00','岐阜県',NULL,'2019-02-20 02:32:29','2019-02-20 02:32:29'),(57,'NAOYA','ARAI','0000-00-00','京都',NULL,'2019-02-20 03:16:48','2019-02-20 03:16:48'),(58,'NAOYA','ARAI','0000-00-00','京都',NULL,'2019-02-20 03:18:20','2019-02-20 03:18:20'),(59,'NAOYA','ARAI','0000-00-00','京都',NULL,'2019-02-20 03:18:23','2019-02-20 03:18:23'),(60,'NAOYA','ARAI','0000-00-00','京都',NULL,'2019-02-20 03:19:03','2019-02-20 03:19:03'),(61,'NAOYA','ARAI','0000-00-00','京都',NULL,'2019-02-20 03:20:57','2019-02-20 03:20:57'),(62,'NAOYA','ARAI','0000-00-00','京都',NULL,'2019-02-20 03:22:15','2019-02-20 03:22:15'),(63,'NAOYA','ARAI','0000-00-00','京都',NULL,'2019-02-20 03:22:45','2019-02-20 03:22:45'),(64,'NAOYA','ARAI','0000-00-00','京都',NULL,'2019-02-20 03:22:59','2019-02-20 03:22:59'),(65,'NAOYA','ARAI','1992-01-01','京都',NULL,'2019-02-20 03:23:12','2019-02-21 23:34:01'),(66,'hoge','hoge','1990-10-11','岐阜県',NULL,'2019-02-22 01:47:12','2019-02-22 01:47:12'),(67,'hoge','hoge','1322-01-10','京都',NULL,'2019-02-22 01:48:31','2019-02-22 01:48:31');
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(30) NOT NULL,
  `deleted` timestamp NULL DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'test@test.jp','testest','テストさん',NULL,'2019-02-18 03:29:44','2019-02-18 03:29:44'),(2,'test@test.jp','testest','テストさん',NULL,'2019-02-18 03:30:49','2019-02-18 03:30:49'),(3,'test@test.jp','testest','テストさん',NULL,'2019-02-18 03:31:28','2019-02-18 03:31:28'),(4,'test@test.jp','testtest','テストさん',NULL,'2019-02-20 06:38:34','2019-02-20 06:38:34'),(5,'unlimited-possibities@softbank.ne.jp','testtesst','NAOYA ARAI',NULL,'2019-02-20 06:39:32','2019-02-20 06:39:32'),(6,'test@test.jp','ksjandfkjasnfkjdsna','テストさん',NULL,'2019-02-20 06:44:47','2019-02-20 06:44:47'),(7,'kyahyo17@yahoo.co.jp','hotehote','新井',NULL,'2019-02-20 22:27:50','2019-02-20 22:27:50'),(8,'kyahyo17@yahoo.co.jp','ewroqheowq','新井',NULL,'2019-02-20 22:27:57','2019-02-20 22:27:57'),(9,'kyahyo17@yahoo.co.jp','huhbibyuvu','新井',NULL,'2019-02-20 22:28:33','2019-02-20 22:28:33'),(10,'kyahyo17@yahoo.co.jp','kjbknkjnkj','新井',NULL,'2019-02-20 22:30:21','2019-02-20 22:30:21'),(11,'kyahyo17@yahoo.co.jp','jinnonlknlk','新井',NULL,'2019-02-20 22:30:54','2019-02-20 22:30:54'),(12,'kyahyo17@yahoo.co.jp','kkjnkjnkjnkjn','新井',NULL,'2019-02-20 22:31:02','2019-02-20 22:31:02'),(13,'kyahyo17@yahoo.co.jp','joijiojiojoiji','新井',NULL,'2019-02-20 22:31:19','2019-02-20 22:31:19'),(14,'kyahyo17@yahoo.co.jp','dsfafasdfa','新井',NULL,'2019-02-20 22:32:16','2019-02-20 22:32:16'),(15,'kyahyo17@yahoo.co.jp','aaafdasfdafafsa','新井',NULL,'2019-02-20 22:32:25','2019-02-20 22:32:25'),(16,'kyahyo17@yahoo.co.jp','aaafdasfdafafsa','新井',NULL,'2019-02-20 22:32:58','2019-02-20 22:32:58'),(17,'kyahyo17@yahoo.co.jp','gfdsfdssssssd','新井',NULL,'2019-02-20 22:33:03','2019-02-20 22:33:03'),(18,'kyahyo17@yahoo.co.jp','cdsacds','新井',NULL,'2019-02-20 22:59:51','2019-02-20 22:59:51'),(19,'kyahyo17@yahoo.co.jp','fdasdsaa','新井',NULL,'2019-02-20 23:00:26','2019-02-20 23:00:26'),(20,'kyahyo17@yahoo.co.jp','acsdddddddda','新井',NULL,'2019-02-20 23:01:52','2019-02-20 23:01:52'),(21,'kyahyo17@yahoo.co.jp','okpokopkpkp','新井',NULL,'2019-02-20 23:02:01','2019-02-20 23:02:01'),(22,'kyahyo17@yahoo.co.jp','frewqfewqfwqf','新井',NULL,'2019-02-20 23:02:30','2019-02-20 23:02:30'),(23,'kyahyo17@yahoo.co.jp','vsavsdavvvvvvda','新井',NULL,'2019-02-20 23:03:13','2019-02-20 23:03:13'),(24,'kyahyo17@yahoo.co.jp','kopkpokopkpk','新井',NULL,'2019-02-20 23:04:38','2019-02-20 23:04:38'),(25,'kyahyo17@yahoo.co.jp','kopokpokpokpo','新井',NULL,'2019-02-20 23:05:09','2019-02-20 23:05:09'),(26,'kyahyo17@yahoo.co.jp','dsafafa','新井',NULL,'2019-02-20 23:17:30','2019-02-20 23:17:30'),(27,'kyahyo17@yahoo.co.jp','fasfdsafasfsa','新井',NULL,'2019-02-20 23:18:15','2019-02-20 23:18:15'),(28,'kyahyo17@yahoo.co.jp','sddddddddac','新井',NULL,'2019-02-20 23:18:59','2019-02-20 23:18:59'),(29,'kyahyo17@yahoo.co.jp','csssadddddddddddddas','新井',NULL,'2019-02-20 23:19:06','2019-02-20 23:19:06'),(30,'kyahyo17@yahoo.co.jp','ccccsds','新井',NULL,'2019-02-20 23:19:22','2019-02-20 23:19:22'),(31,'sda','dsaa','asdfa',NULL,'2019-02-20 23:22:27','2019-02-20 23:22:27'),(32,'kyahyo17@yahoo.co.jp','nknk','新井',NULL,'2019-02-20 23:50:40','2019-02-20 23:50:40'),(33,'kyahyo17@yahoo.co.jp','kk','新井',NULL,'2019-02-20 23:51:23','2019-02-20 23:51:23'),(34,'kyahyo17@yahoo.co.jp','ko','新井',NULL,'2019-02-20 23:53:02','2019-02-20 23:53:02'),(35,'kyahyo17@yahoo.co.jp','ss','新井',NULL,'2019-02-20 23:53:21','2019-02-20 23:53:21'),(36,'kyahyo17@yahoo.co.jp','ss','新井',NULL,'2019-02-20 23:53:46','2019-02-20 23:53:46'),(37,'kyahyo17@yahoo.co.jp','kk','新井',NULL,'2019-02-20 23:57:11','2019-02-20 23:57:11'),(38,'unlimited-possibities@softbank.ne.jp','57c3dd950b3072ca042bd3f85e67c7bd1cf8a03f','NAOYA ARAI',NULL,'2019-02-21 01:16:13','2019-02-21 01:16:13');
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

-- Dump completed on 2019-02-22 11:17:27
