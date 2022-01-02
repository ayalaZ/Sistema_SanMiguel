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
-- Table structure for table `tbl_usuario`
--

DROP TABLE IF EXISTS `tbl_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_usuario` (
  `idUsuario` int(4) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(70) NOT NULL,
  `apellido` varchar(150) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `clave` varchar(70) NOT NULL,
  `rol` varchar(25) NOT NULL,
  `state` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_usuario`
--

LOCK TABLES `tbl_usuario` WRITE;
/*!40000 ALTER TABLE `tbl_usuario` DISABLE KEYS */;
INSERT INTO `tbl_usuario` VALUES (1,'ADMINISTRADOR DE SISTEMA','','sysAdmin','$2y$10$xXVL8CMvbbpttg3wyvhEfuTeAc24FV9/xEZxA0KIbJ1EKLPNrXpKO','administracion',1),(2,'Gabriela Ramos','','gaby1','$2y$10$g1wMD9BGXZnnMLrlG/epNuBZiTlvDUfjqQgoA21yKPZ0Det1lWe8q','informatica',0),(3,'Vanessa Mejía','','vanessa','$2y$10$F.kafmu9UoXsCWFxlTMzd.PKoXu5aLbXIeDn/JKpnFQK8ILrtPtzK','atencion',1),(4,'Informática en general','','informatica1','$2y$10$GBa0kRcSRK0UdFTirBW8We61XaRSRCQHeiV4/Gma7at1YMgR9gYpK','informatica',1),(5,'Jennifer Zelaya','','JZelaya','$2y$10$i92VuG5VpvNOdmhk1AQKmu7dBhSdVJULNAz4zZQ9H4K3ZbP3ReSLu','administracion',1),(6,'Manuel Mejía','','manuel','$2y$10$usozkWNyWnnv0TjI5xr3ZO9rnaBaKZCjgZ06hbDidsG7pGj.zvG8G','administracion',1),(7,'Sara Jiménes','','sara','$2y$10$FRgeks.pCtjOfxj6kF6F6OF8Oj4OSlrhDxb6CH3niRNcNsltx8ht6','jefatura',1),(9,'Xiomara Chávez','','xiomarachavez','$2y$10$pCWL6U/kyorsmYESMpfI0upsP6izKgrQKRmA4l/nobNjUwxSEY4fi','subgerencia',1),(10,'Adalberto Machado','','AMachado','$2y$10$Liuuf0Hpyti4L0a6CkFttODA3RyIqVgbPWkpU/atH2.i1QynJ2evq','informatica',1),(11,'Zenón Ayala','','ZAyala','$2y$10$v739ZiW6xtCf2UKF2GERNujAGBqIHR3KKpOlnRdIAEvsUFskRGY.q','administracion',1),(12,'Janice Milla','','jani','$2y$10$PDbyxXTewYSFLEJvLh7vfuAtMESDNkRHOpBJio2t4D8RXugsStP2.','jefatura',1),(13,'Rafael Adalberto Machado Marin','','rmachado','$2y$10$29VbF3pXkPS2HkGcOnYrNu6qQTZUpENchq7dpEdE361P/pNqfYhOW','administracion',1),(14,'Redes Sociales','','redes1','$2y$10$pH3pcyhk29aysFe0e6Rbr.7zlbbasNgWnzkQd.Qa8t87/8q0ZndqC','informatica',1),(16,'Atencion al cliente Usulutan','','atencionUsu','$2y$10$N5NE6tpYqjPDU1L9D5t4Cu/unJOnxe9SVBj5HJvmPGBKPbQsD9Ujy','atencion',1),(17,'DURJAN ALVARADO','','durjan','$2y$10$aZcS6BMwM8UqvXNKoqdCDum8Bp0O1v8T4Fdxt22vTfHhBFjZD1zWu','informatica',1),(18,'Josue Benitez','','jbenitez','$2y$10$TTELaKN2dAaK6uOA9QSZbeQx7Q3kF3.9MYoz2UfzncvvvU574CuVO','contabilidad',1),(19,'SUSANA REYES','','sreyes92','$2y$10$DubeAxmLzPFlbznhnynZGe3fjlb97UOCiQgDBPASvb5dS/GN36swq','jefatura',1),(20,'Ana Benavides','','abenavides','$2y$10$SJnvV1R2f1Br6ifePXMCT.45Rq6QfQNArXfZKg6.vf2cC2nZ72PL2','informatica',1),(21,'José Fernando Beltrán Bermúdez','','FernandoBeltran','$2y$10$c34EK/fWHHV6CXLezq4WPeHBu87AM4tdj28uzpqaDQUvWRKtkt4Xq','contabilidad',1),(22,'Edgar Isaac Aparicio López','','IsaacAparicio','$2y$10$hZI7154iSto0TD/Knb3tke4zUfQ0GqEE/wgDQTOr/7zK4sRlQ9uhK','contabilidad',1),(23,'Marcos Isaias Ramirez','','isaiasR96','$2y$10$c3clcz2.37oTxae1tyDIzOchH2Vk1c2tQ87xQnVRZJRrQnw.sDYcG','contabilidad',1),(24,'Julissa Sura','','jsura','$2y$10$Bg8FJlp2P.0wbLMDREcNP.B5lwNBmwFd0eGK6QugCNxrd3gn/klka','atencion',1),(25,'Manuel Cisneros','','mcisneros','$2y$10$3K6uGP36TnowuOICzuoLqOvaUNAbl.MHkG9ZvvtOOBRaAXN86/FvG','subgerencia',1),(26,'Kerin Aparicio','','kaparicio','$2y$10$HeAWq4/64fIRNv80x4YqOevPL24Amon8NLd63YAPZjM2I3xZXJtmy','administracion',1),(27,'OMAR ALEXANDER COREAS GOMEZ','','ogomez','$2y$10$7v1.Yc/bIy38l9pg74MyC.pHEYepGIs2RSagCHF9UDioD8qhiUSZ.','informatica',1),(28,'Noe Vargas','','NOE','$2y$10$/KBDV56CHkqMPvdDRsNhK.etn2aGSlk/yKHc7GbrcTUTOm4t5mlvq','jefatura',1),(29,'Julio Lopez','','jlopez','$2y$10$18ql5iqZEgFHGusFwGklP.0mt0njv60qaTRbGX3DkHL9CFUlKhMxe','informatica',1);
/*!40000 ALTER TABLE `tbl_usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-11-29 15:37:03
