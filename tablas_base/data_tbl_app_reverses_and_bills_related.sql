-- MySQL dump 10.16  Distrib 10.1.48-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: satpro_sm
-- ------------------------------------------------------
-- Server version	10.1.48-MariaDB-0+deb9u2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_app_reverses_and_bills_related`
--

DROP TABLE IF EXISTS `tbl_app_reverses_and_bills_related`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_app_reverses_and_bills_related` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_reverse` int(11) DEFAULT NULL,
  `numero_de_factura` varchar(45) NOT NULL,
  `created_at` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_reverse` (`id_reverse`),
  CONSTRAINT `tbl_app_reverses_and_bills_related_ibfk_1` FOREIGN KEY (`id_reverse`) REFERENCES `tbl_app_reverses_pendings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_app_reverses_and_bills_related`
--

LOCK TABLES `tbl_app_reverses_and_bills_related` WRITE;
/*!40000 ALTER TABLE `tbl_app_reverses_and_bills_related` DISABLE KEYS */;
INSERT INTO `tbl_app_reverses_and_bills_related` VALUES (5,5,'20SD001F-0007800','2021-01-21'),(6,6,'20SD001F-0007873','2021-01-28'),(7,7,'21DS001F-0002311','2021-04-03'),(8,8,'21DS001F-0006801','2021-05-31'),(9,9,'21DS001F-0006801','2021-06-01'),(10,10,'21DS001F-0006801','2021-06-01'),(11,11,'21DS001F-0007192','2021-06-02');
/*!40000 ALTER TABLE `tbl_app_reverses_and_bills_related` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-12-03  8:59:09
