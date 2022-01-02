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
-- Table structure for table `tbl_actividades_inter`
--

DROP TABLE IF EXISTS `tbl_actividades_inter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_actividades_inter` (
  `idActividadInter` int(3) NOT NULL AUTO_INCREMENT,
  `nombreActividad` varchar(50) NOT NULL,
  PRIMARY KEY (`idActividadInter`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_actividades_inter`
--

LOCK TABLES `tbl_actividades_inter` WRITE;
/*!40000 ALTER TABLE `tbl_actividades_inter` DISABLE KEYS */;
INSERT INTO `tbl_actividades_inter` VALUES (1,'Instalación'),(2,'No tiene señal'),(3,'Mala señal'),(6,'Cable UTP reventado'),(7,'Cambio de contraseña'),(8,'Posible fuente quemada'),(9,'Equipo quemado'),(10,'Cambio de equipo'),(12,'Renovacion de contrato de internet'),(13,'Cobro'),(14,'Orden anulada'),(15,'Internet lento'),(16,'Cableado reventado'),(17,'Recuperación de ONU'),(18,'Recuperación de Antena'),(19,'Recuperación de Router'),(20,'Verificación de cobertura, nuevo cliente'),(21,'Otros'),(22,'Cable bajo'),(23,'Mover poste'),(24,'Mover cable'),(25,'Modificar'),(26,'Reconexion'),(27,'Mover ONU'),(28,'Mover Antena'),(29,'Cambio de ONU'),(30,'Cambio de Antena'),(31,'Inspeccion');
/*!40000 ALTER TABLE `tbl_actividades_inter` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-12-03  8:53:35
