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
-- Table structure for table `tbl_app_payments`
--

DROP TABLE IF EXISTS `tbl_app_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_app_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_transaccion` varchar(300) NOT NULL,
  `factura_banco` varchar(300) NOT NULL,
  `factura_cablesat` varchar(300) NOT NULL,
  `mes_facturado` varchar(50) NOT NULL,
  `servicio` varchar(50) NOT NULL,
  `cuota` varchar(20) NOT NULL,
  `created_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_app_payments`
--

LOCK TABLES `tbl_app_payments` WRITE;
/*!40000 ALTER TABLE `tbl_app_payments` DISABLE KEYS */;
INSERT INTO `tbl_app_payments` VALUES (1,'00004159719206121453','3589','19DS001F-0003577','02/2020','I','25.99','2020-04-03'),(2,'00004159719206121453','3589','19DS001F-0002721','01/2020','I','25.99','2020-04-03'),(3,'00004363718940104922','3433','19DS001F-0003421','02/2020','I','25.99','2020-04-04'),(4,'00004363718940104922','3433','19DS001F-0002561','01/2020','I','25.99','2020-04-04'),(5,'00004572710104015248','3487','19DS001F-0003475','02/2020','I','29.99','2020-04-07'),(6,'00005446702764043559','19845','20SD001F-0007800','12/2020','I','9.87','2021-01-22'),(7,'00006318723896050831','28902','21DS001F-0006801','04/2021','I','0.01','2021-06-01');
/*!40000 ALTER TABLE `tbl_app_payments` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-12-03  8:58:03
