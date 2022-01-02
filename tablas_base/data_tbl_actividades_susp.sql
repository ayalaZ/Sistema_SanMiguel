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
-- Table structure for table `tbl_actividades_susp`
--

DROP TABLE IF EXISTS `tbl_actividades_susp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_actividades_susp` (
  `idActividadSusp` int(3) NOT NULL AUTO_INCREMENT,
  `nombreActividad` varchar(45) NOT NULL,
  PRIMARY KEY (`idActividadSusp`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_actividades_susp`
--

LOCK TABLES `tbl_actividades_susp` WRITE;
/*!40000 ALTER TABLE `tbl_actividades_susp` DISABLE KEYS */;
INSERT INTO `tbl_actividades_susp` VALUES (1,'Mora de 1 mes'),(2,'Mora de 2 meses'),(3,'Problemas económicos'),(4,'Motivo de viaje'),(5,'Ya no vive en esta dirección'),(6,'Ya no quiere el servicio'),(7,'Cierre de negocio'),(8,'Problemas personales'),(9,'Problemas con el cobrador'),(10,'Problemas de señal'),(11,'Cambio de nombre'),(12,'Traslado'),(13,'Cambió de compañía'),(14,'Cortesía'),(15,'Ya no vive en esta dirección'),(16,'El servicio no le funciona correctamente'),(17,'Otros');
/*!40000 ALTER TABLE `tbl_actividades_susp` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-12-03  8:54:43
