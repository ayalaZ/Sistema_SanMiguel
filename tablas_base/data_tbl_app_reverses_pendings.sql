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
-- Table structure for table `tbl_app_reverses_pendings`
--

DROP TABLE IF EXISTS `tbl_app_reverses_pendings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_app_reverses_pendings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_de_cliente` varchar(45) DEFAULT NULL,
  `numero_de_factura` varchar(45) NOT NULL,
  `monto` varchar(45) DEFAULT NULL,
  `created_at` date NOT NULL,
  `estado` varchar(45) NOT NULL DEFAULT 'pendiente',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_app_reverses_pendings`
--

LOCK TABLES `tbl_app_reverses_pendings` WRITE;
/*!40000 ALTER TABLE `tbl_app_reverses_pendings` DISABLE KEYS */;
INSERT INTO `tbl_app_reverses_pendings` VALUES (5,'01105','19845','9.87','2021-01-21','APROBADA'),(6,'01201','19918','37.48','2021-01-28','APROBADA'),(7,'01105','24386','9.87','2021-04-03','APROBADA'),(8,'00339','28902','0.01','2021-05-31','APROBADA'),(9,'00339','28902','28.85','2021-06-01','APROBADA'),(10,'00339','28902','0.01','2021-06-01','APROBADA'),(11,'01105','29293','9.87','2021-06-02','APROBADA');
/*!40000 ALTER TABLE `tbl_app_reverses_pendings` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-12-03  9:00:57
