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
-- Table structure for table `tbl_actividades_cable`
--

DROP TABLE IF EXISTS `tbl_actividades_cable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_actividades_cable` (
  `idActividadCable` int(3) NOT NULL AUTO_INCREMENT,
  `nombreActividad` varchar(50) NOT NULL,
  PRIMARY KEY (`idActividadCable`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_actividades_cable`
--

LOCK TABLES `tbl_actividades_cable` WRITE;
/*!40000 ALTER TABLE `tbl_actividades_cable` DISABLE KEYS */;
INSERT INTO `tbl_actividades_cable` VALUES (1,'Instalación'),(2,'No tiene señal'),(3,'Mala señal'),(4,'Revisar spliter'),(5,'Cambiar spliter'),(6,'Cable reventado'),(7,'Derivación'),(8,'Renovacion de contrato de cable'),(10,'Cobro'),(11,'Orden anulada'),(12,'Recuperación de caja digital'),(13,'Recuperación de micro nodo'),(14,'Verificación de cobertura, nuevo cliente'),(15,'Otros'),(16,'Programar TV'),(17,'Cable bajo'),(18,'Mover poste'),(19,'Mover cable'),(20,'Modificar'),(21,'Reconexion'),(22,'Mover micronodo'),(23,'Micronodo dañado'),(24,'Cambio de micronodo'),(25,'Inspeccion');
/*!40000 ALTER TABLE `tbl_actividades_cable` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-12-03  8:52:17
