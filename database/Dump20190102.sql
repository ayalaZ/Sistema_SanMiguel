CREATE DATABASE  IF NOT EXISTS `satpro` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `satpro`;
-- MySQL dump 10.16  Distrib 10.1.36-MariaDB, for Win32 (AMD64)
--
-- Host: 127.0.0.1    Database: satpro
-- ------------------------------------------------------
-- Server version	10.1.36-MariaDB

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
-- Table structure for table `tbl_articulo`
--

DROP TABLE IF EXISTS `tbl_articulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_articulo` (
  `IdArticulo` int(11) NOT NULL AUTO_INCREMENT,
  `Codigo` varchar(11) NOT NULL,
  `NombreArticulo` varchar(35) NOT NULL,
  `Descripcion` varchar(35) DEFAULT NULL,
  `Cantidad` double NOT NULL,
  `PrecioCompra` double NOT NULL,
  `PrecioVenta` double NOT NULL,
  `FechaEntrada` date NOT NULL,
  `IdUnidadMedida` int(11) NOT NULL,
  `IdTipoProducto` int(11) DEFAULT NULL,
  `IdSubCategoria` int(11) DEFAULT NULL,
  `IdProveedor` int(11) DEFAULT NULL,
  `IdBodega` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdArticulo`),
  KEY `UnidadM_idx` (`IdUnidadMedida`),
  KEY `SubCate_idx` (`IdSubCategoria`),
  KEY `Proveedor_idx` (`IdProveedor`),
  KEY `Bodega_idx` (`IdBodega`),
  CONSTRAINT `Bodega` FOREIGN KEY (`IdBodega`) REFERENCES `tbl_bodega` (`IdBodega`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `Proveedor` FOREIGN KEY (`IdProveedor`) REFERENCES `tbl_proveedor` (`IdProveedor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `SubCate` FOREIGN KEY (`IdSubCategoria`) REFERENCES `tbl_subcategoria` (`IdSubCategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `UnidadM` FOREIGN KEY (`IdUnidadMedida`) REFERENCES `tbl_unidadmedida` (`IdUnidadMedida`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_articulo`
--

LOCK TABLES `tbl_articulo` WRITE;
/*!40000 ALTER TABLE `tbl_articulo` DISABLE KEYS */;
INSERT INTO `tbl_articulo` VALUES (2,'123-01','HP ENVY 13','Computadora Portatil',10,566.9,600.89,'2018-12-02',1,1,1,1,2),(3,'123-02','OMEN X HP','Computadora de uso personal portati',4,700.9,800.89,'2018-12-02',1,1,1,1,1),(5,'123-04','modem Zyxel 600 ','--',10,80.9,100.89,'2018-12-02',1,1,3,1,1),(6,'123-04','módem zyxel p660 HW-T1','--',10,80.9,100.89,'2018-12-02',1,1,3,1,1);
/*!40000 ALTER TABLE `tbl_articulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_bodega`
--

DROP TABLE IF EXISTS `tbl_bodega`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_bodega` (
  `IdBodega` int(11) NOT NULL AUTO_INCREMENT,
  `NombreBodega` varchar(25) NOT NULL,
  `Direccion` varchar(25) NOT NULL,
  `State` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdBodega`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_bodega`
--

LOCK TABLES `tbl_bodega` WRITE;
/*!40000 ALTER TABLE `tbl_bodega` DISABLE KEYS */;
INSERT INTO `tbl_bodega` VALUES (1,'Bodega Central','Calle el progreso 1',1),(2,'Bodega Oriente','17 av sur',1);
/*!40000 ALTER TABLE `tbl_bodega` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_categoria`
--

DROP TABLE IF EXISTS `tbl_categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_categoria` (
  `IdCategoria` int(11) NOT NULL AUTO_INCREMENT,
  `NombreCategoria` varchar(20) NOT NULL,
  `state` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdCategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_categoria`
--

LOCK TABLES `tbl_categoria` WRITE;
/*!40000 ALTER TABLE `tbl_categoria` DISABLE KEYS */;
INSERT INTO `tbl_categoria` VALUES (1,'Computadoras',1),(2,'Modems',1);
/*!40000 ALTER TABLE `tbl_categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_departamento`
--

DROP TABLE IF EXISTS `tbl_departamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_departamento` (
  `IdDepartamento` int(11) NOT NULL AUTO_INCREMENT,
  `Codigo` varchar(100) NOT NULL,
  `NombreDepartamento` varchar(20) NOT NULL,
  `Descripcion` varchar(140) NOT NULL,
  `State` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdDepartamento`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_departamento`
--

LOCK TABLES `tbl_departamento` WRITE;
/*!40000 ALTER TABLE `tbl_departamento` DISABLE KEYS */;
INSERT INTO `tbl_departamento` VALUES (1,'001','Administrativo','Permisos Generales del Sistema',1);
/*!40000 ALTER TABLE `tbl_departamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_detallereporte`
--

DROP TABLE IF EXISTS `tbl_detallereporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_detallereporte` (
  `IdDetalleReporte` int(11) NOT NULL AUTO_INCREMENT,
  `IdReporte` int(11) DEFAULT NULL,
  `IdArticulo` int(11) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdDetalleReporte`),
  KEY `Articulo_idx` (`IdArticulo`),
  KEY `Reporte_idx` (`IdReporte`),
  CONSTRAINT `Articulo` FOREIGN KEY (`IdArticulo`) REFERENCES `tbl_articulo` (`IdArticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `Reporte` FOREIGN KEY (`IdReporte`) REFERENCES `tbl_reporte` (`IdReporte`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_detallereporte`
--

LOCK TABLES `tbl_detallereporte` WRITE;
/*!40000 ALTER TABLE `tbl_detallereporte` DISABLE KEYS */;
INSERT INTO `tbl_detallereporte` VALUES (3,3,2,15,1),(4,3,3,15,1),(5,4,2,2,1),(6,4,3,3,1),(7,5,3,2,1),(8,5,6,4,1),(9,6,2,5,1),(10,6,3,6,1),(11,6,5,7,1),(12,6,6,6,1),(13,7,2,2,1),(14,7,3,3,1),(15,7,5,4,1),(16,7,6,5,1),(17,8,2,2,1),(18,8,3,3,1),(19,8,5,3,1),(20,8,6,3,1),(21,9,2,5,1),(22,9,3,2,1),(23,9,5,2,1),(24,9,6,2,1),(25,10,2,2,1),(26,10,5,1,1),(27,10,6,1,1),(28,12,2,8,1),(29,12,3,2,1),(30,13,2,3,1),(31,13,3,2,1),(32,14,3,2,1),(33,14,6,3,1),(34,15,2,9,1),(35,15,3,2,1),(36,15,5,5,1),(37,15,6,4,1),(38,16,2,3,2),(39,16,5,3,2),(40,17,2,4,2),(41,17,3,3,2);
/*!40000 ALTER TABLE `tbl_detallereporte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_empleado`
--

DROP TABLE IF EXISTS `tbl_empleado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_empleado` (
  `IdEmpleado` int(11) NOT NULL AUTO_INCREMENT,
  `Codigo` varchar(100) NOT NULL,
  `Nombres` varchar(100) NOT NULL,
  `Apellidos` varchar(100) NOT NULL,
  `Direccion` varchar(140) NOT NULL,
  `Dui` varchar(11) NOT NULL,
  `Nit` varchar(18) NOT NULL,
  `Isss` varchar(15) NOT NULL,
  `E_Familiar` varchar(15) NOT NULL,
  `G_Academico` varchar(25) NOT NULL,
  `FechaNacimiento` date NOT NULL,
  `Telefono` varchar(10) NOT NULL,
  `IdReferencia` int(11) DEFAULT NULL,
  `IdUsuario` int(11) DEFAULT NULL,
  `IdDepartamento` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdEmpleado`),
  KEY `Referencia_idx` (`IdReferencia`),
  KEY `Usuario_idx` (`IdUsuario`),
  KEY `Departamento_idx` (`IdDepartamento`),
  CONSTRAINT `Departamen` FOREIGN KEY (`IdDepartamento`) REFERENCES `tbl_departamento` (`IdDepartamento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `Referencia` FOREIGN KEY (`IdReferencia`) REFERENCES `tbl_referencia` (`IdReferencia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `Usuario` FOREIGN KEY (`IdUsuario`) REFERENCES `tbl_usuario` (`IdUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_empleado`
--

LOCK TABLES `tbl_empleado` WRITE;
/*!40000 ALTER TABLE `tbl_empleado` DISABLE KEYS */;
INSERT INTO `tbl_empleado` VALUES (3,'00-001','Franklin Armando','Pocasangre Mejia','Urb. Cimas de San Bartolo','123456789','987654321','12345','Soltero','Universidad','1998-12-03','73516621',1,1,1,1);
/*!40000 ALTER TABLE `tbl_empleado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_proveedor`
--

DROP TABLE IF EXISTS `tbl_proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_proveedor` (
  `IdProveedor` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(25) NOT NULL,
  `Representate` varchar(25) NOT NULL,
  `Telefono` varchar(10) NOT NULL,
  `Correo` varchar(35) NOT NULL,
  `Nrc` varchar(15) NOT NULL,
  `Nit` varchar(18) NOT NULL,
  `Nacionalidad` varchar(25) NOT NULL,
  `state` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdProveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_proveedor`
--

LOCK TABLES `tbl_proveedor` WRITE;
/*!40000 ALTER TABLE `tbl_proveedor` DISABLE KEYS */;
INSERT INTO `tbl_proveedor` VALUES (1,'HP','Carlos Acevedo','22589696','Carlos@hotmail.com','123456789','987654321','Estadounidense',1);
/*!40000 ALTER TABLE `tbl_proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_referencia`
--

DROP TABLE IF EXISTS `tbl_referencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_referencia` (
  `IdReferencia` int(11) NOT NULL AUTO_INCREMENT,
  `IdEmpleado` int(11) DEFAULT NULL,
  `Referencia_1` varchar(50) DEFAULT NULL,
  `Telefono_1` varchar(10) DEFAULT NULL,
  `Referencia_2` varchar(50) DEFAULT NULL,
  `Telefono_2` varchar(10) DEFAULT NULL,
  `State` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdReferencia`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_referencia`
--

LOCK TABLES `tbl_referencia` WRITE;
/*!40000 ALTER TABLE `tbl_referencia` DISABLE KEYS */;
INSERT INTO `tbl_referencia` VALUES (1,1,'Tec.Juan Perez','22964541','Ing.Carlos Campos','22858986',1),(2,1,'Tec.Juan Perez','22964541','Ing.Carlos Campos','22858986',1);
/*!40000 ALTER TABLE `tbl_referencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_reporte`
--

DROP TABLE IF EXISTS `tbl_reporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_reporte` (
  `IdReporte` int(11) NOT NULL AUTO_INCREMENT,
  `IdEmpleado` int(11) DEFAULT NULL,
  `Fecha` datetime DEFAULT NULL,
  `IdBodegaSaliente` int(11) DEFAULT NULL,
  `IdBodegaEntrante` int(11) DEFAULT NULL,
  `Razon` varchar(200) NOT NULL,
  `state` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdReporte`),
  KEY `Emple_idx` (`IdEmpleado`),
  CONSTRAINT `Emple` FOREIGN KEY (`IdEmpleado`) REFERENCES `tbl_empleado` (`IdEmpleado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_reporte`
--

LOCK TABLES `tbl_reporte` WRITE;
/*!40000 ALTER TABLE `tbl_reporte` DISABLE KEYS */;
INSERT INTO `tbl_reporte` VALUES (3,3,'2018-02-02 00:00:00',1,2,'',1),(4,3,'2018-12-28 00:00:00',1,2,'Se utilizara el producto en la bodega de Oriente',1),(5,3,'2018-12-28 00:00:00',2,1,'No hay venido el pedido, y Se utilizara ese material en una instalacion',1),(6,NULL,'2018-12-28 00:00:00',2,2,'Solicito producto la bodega Central',1),(7,NULL,'2018-12-28 00:00:00',2,2,'Solicito producto la bodega Oriente',1),(8,NULL,'2018-12-28 00:00:00',1,2,'Solicito producto la bodega Oriente',1),(9,3,'2018-12-28 00:00:00',1,2,'Solicito Producto la bodega Oriente',1),(10,3,'2018-12-31 00:00:00',1,2,'Se utilizara para una instalacion',1),(11,3,'2018-02-02 07:47:00',1,2,'ABCD',1),(12,3,'0000-00-00 00:00:00',2,1,'ASDF',1),(13,3,'2019-01-02 09:20:00',2,1,'ZXCV',1),(14,3,'2019-01-02 11:01:00',1,2,'QWER',1),(15,3,'2019-01-02 01:55:00',1,2,'JKLÑ',1),(16,3,'2019-01-02 04:53:00',1,2,'ZXCV',1),(17,3,'2019-01-02 05:02:00',1,2,'VBNM',2);
/*!40000 ALTER TABLE `tbl_reporte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_subcategoria`
--

DROP TABLE IF EXISTS `tbl_subcategoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_subcategoria` (
  `IdSubCategoria` int(11) NOT NULL AUTO_INCREMENT,
  `NombreSubCategoria` varchar(25) NOT NULL,
  `IdCategoria` int(11) DEFAULT NULL,
  `State` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdSubCategoria`),
  KEY `Cate_idx` (`IdCategoria`),
  CONSTRAINT `Cate` FOREIGN KEY (`IdCategoria`) REFERENCES `tbl_categoria` (`IdCategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_subcategoria`
--

LOCK TABLES `tbl_subcategoria` WRITE;
/*!40000 ALTER TABLE `tbl_subcategoria` DISABLE KEYS */;
INSERT INTO `tbl_subcategoria` VALUES (1,'Computadoras',1,1),(2,'Laptos',1,1),(3,'Modems',2,1);
/*!40000 ALTER TABLE `tbl_subcategoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_unidadmedida`
--

DROP TABLE IF EXISTS `tbl_unidadmedida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_unidadmedida` (
  `IdUnidadMedida` int(11) NOT NULL AUTO_INCREMENT,
  `NombreUnidadMedida` varchar(100) NOT NULL,
  `Abreviatura` varchar(5) NOT NULL,
  `state` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdUnidadMedida`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_unidadmedida`
--

LOCK TABLES `tbl_unidadmedida` WRITE;
/*!40000 ALTER TABLE `tbl_unidadmedida` DISABLE KEYS */;
INSERT INTO `tbl_unidadmedida` VALUES (1,'Cantidad ','Cant',1);
/*!40000 ALTER TABLE `tbl_unidadmedida` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_usuario`
--

DROP TABLE IF EXISTS `tbl_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_usuario` (
  `IdUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `Usuario` varchar(30) NOT NULL,
  `Clave` varchar(25) NOT NULL,
  `State` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_usuario`
--

LOCK TABLES `tbl_usuario` WRITE;
/*!40000 ALTER TABLE `tbl_usuario` DISABLE KEYS */;
INSERT INTO `tbl_usuario` VALUES (1,'Frank','123',1);
/*!40000 ALTER TABLE `tbl_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'satpro'
--

--
-- Dumping routines for database 'satpro'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-01-02 17:03:40
