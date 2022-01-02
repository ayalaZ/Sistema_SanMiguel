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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_articulo`
--

LOCK TABLES `tbl_articulo` WRITE;
/*!40000 ALTER TABLE `tbl_articulo` DISABLE KEYS */;
INSERT INTO `tbl_articulo` VALUES (2,'123-01','HP ENVY 13','Computadora Portatil',10,566.9,600.89,'2018-12-02',1,1,1,1,2),(3,'123-02','OMEN X HP','Computadora de uso personal portati',15,700.9,800.89,'2018-12-02',1,1,1,1,2),(5,'123-04','modem Zyxel 600 ','--',25,80.9,100.89,'2018-12-02',1,1,3,1,1),(7,'123-01','HP ENVY 13','Computadora Portatil',22,566.9,600.89,'2018-12-02',1,1,1,1,1),(8,'123-02','OMEN X HP','Computadora de uso personal',20,566.9,600.89,'2018-12-02',1,1,1,1,1);
/*!40000 ALTER TABLE `tbl_articulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_articulodepartamento`
--

DROP TABLE IF EXISTS `tbl_articulodepartamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_articulodepartamento` (
  `IdArticuloDepartamento` int(11) NOT NULL AUTO_INCREMENT,
  `Codigo` varchar(50) NOT NULL,
  `NombreArticulo` varchar(50) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `IdDepartamento` int(11) NOT NULL,
  `State` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdArticuloDepartamento`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_articulodepartamento`
--

LOCK TABLES `tbl_articulodepartamento` WRITE;
/*!40000 ALTER TABLE `tbl_articulodepartamento` DISABLE KEYS */;
INSERT INTO `tbl_articulodepartamento` VALUES (1,'123-04','modem Zyxel 600 ',11,2,0),(2,'123-02','OMEN X HP',5,2,0),(3,'123-02','OMEN X HP',8,1,0);
/*!40000 ALTER TABLE `tbl_articulodepartamento` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_bodega`
--

LOCK TABLES `tbl_bodega` WRITE;
/*!40000 ALTER TABLE `tbl_bodega` DISABLE KEYS */;
INSERT INTO `tbl_bodega` VALUES (1,'Bodega Quelepa','Calle el progreso 1',1),(2,'Bodega Santa Maria','17 av sur',1),(3,'Bodega Santiago De Maria','av sur 1',1);
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
  `IdEmpleado` int(11) DEFAULT NULL,
  `State` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdDepartamento`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_departamento`
--

LOCK TABLES `tbl_departamento` WRITE;
/*!40000 ALTER TABLE `tbl_departamento` DISABLE KEYS */;
INSERT INTO `tbl_departamento` VALUES (1,'001','Administrativo','Permisos Generales del Sistema',NULL,1),(2,'002','Informatica','',3,1);
/*!40000 ALTER TABLE `tbl_departamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_detallead`
--

DROP TABLE IF EXISTS `tbl_detallead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_detallead` (
  `IdDetalleAD` int(11) NOT NULL AUTO_INCREMENT,
  `IdReporteAD` int(11) NOT NULL,
  `IdArticulo` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `State` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdDetalleAD`),
  KEY `deta_idx` (`IdReporteAD`),
  KEY `arttt_idx` (`IdArticulo`),
  CONSTRAINT `arte` FOREIGN KEY (`IdArticulo`) REFERENCES `tbl_articulo` (`IdArticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `repo` FOREIGN KEY (`IdReporteAD`) REFERENCES `tbl_reportead` (`IdReporteAd`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_detallead`
--

LOCK TABLES `tbl_detallead` WRITE;
/*!40000 ALTER TABLE `tbl_detallead` DISABLE KEYS */;
INSERT INTO `tbl_detallead` VALUES (1,1,5,6,0),(2,1,8,5,0),(3,2,3,3,0),(4,3,8,5,0),(5,4,5,4,0),(6,5,5,1,0);
/*!40000 ALTER TABLE `tbl_detallead` ENABLE KEYS */;
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
  CONSTRAINT `reporte` FOREIGN KEY (`IdReporte`) REFERENCES `tbl_reporte` (`IdReporte`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_detallereporte`
--

LOCK TABLES `tbl_detallereporte` WRITE;
/*!40000 ALTER TABLE `tbl_detallereporte` DISABLE KEYS */;
INSERT INTO `tbl_detallereporte` VALUES (1,1,2,4,2),(2,1,3,3,2),(3,2,2,5,2),(4,2,3,5,2),(5,3,7,10,2),(6,3,8,15,2),(7,4,2,2,2),(8,5,2,2,2),(9,5,3,2,2),(10,6,2,1,2),(11,7,2,1,2),(12,8,5,1,2);
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
  `Codigo` varchar(20) NOT NULL,
  `Nombres` varchar(40) NOT NULL,
  `Apellidos` varchar(45) NOT NULL,
  `Direccion` varchar(100) NOT NULL,
  `Dui` varchar(11) NOT NULL,
  `Nit` varchar(18) NOT NULL,
  `Isss` varchar(15) NOT NULL,
  `Afp` varchar(15) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_empleado`
--

LOCK TABLES `tbl_empleado` WRITE;
/*!40000 ALTER TABLE `tbl_empleado` DISABLE KEYS */;
INSERT INTO `tbl_empleado` VALUES (1,'00-001','Diego Armando','Herrera Flores','Usulután','123456789','987654321','12345','','Soltero','Universidad','1998-12-03','73516621',1,1,1,1),(2,'00-002','Franklin Armando','Mejía Pocasangre','San Salvador','123456789','987654321','12345','','Soltero','Universidad','1998-12-03','73516621',1,2,1,1);
/*!40000 ALTER TABLE `tbl_empleado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_permisos`
--

DROP TABLE IF EXISTS `tbl_permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_permisos` (
  `IdPermisos` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) NOT NULL,
  `valor` int NOT NULL,
  PRIMARY KEY (`IdPermisos`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_permisos`
--

/*LOCK TABLES `tbl_permisos` WRITE;*/
/*!40000 ALTER TABLE `tbl_permisos` DISABLE KEYS */;
INSERT INTO `tbl_permisos` VALUES (1,'ACCESO',1),(2,'AGREGAR',2),(3,'MODIFICAR',4),(4,'ELIMINAR',8);
/*!40000 ALTER TABLE `tbl_permisos` ENABLE KEYS */;
/*UNLOCK TABLES;*/

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
  `IdEmpleadoOrigen` int(11) DEFAULT NULL,
  `FechaOrigen` datetime DEFAULT NULL,
  `IdEmpleadoDestino` int(11) DEFAULT NULL,
  `FechaDestino` datetime DEFAULT NULL,
  `IdBodegaSaliente` int(11) DEFAULT NULL,
  `IdBodegaEntrante` int(11) DEFAULT NULL,
  `Razon` varchar(200) NOT NULL,
  `state` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdReporte`),
  KEY `Emple_idx` (`IdEmpleadoOrigen`),
  CONSTRAINT `Emple` FOREIGN KEY (`IdEmpleadoOrigen`) REFERENCES `tbl_empleado` (`IdEmpleado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_reporte`
--

LOCK TABLES `tbl_reporte` WRITE;
/*!40000 ALTER TABLE `tbl_reporte` DISABLE KEYS */;
INSERT INTO `tbl_reporte` VALUES (1,3,'2019-01-04 10:17:00',4,'2019-01-04 10:17:00',2,1,'El Encargado Solicito producto',1),(2,3,'2019-01-04 10:19:00',4,'2019-01-04 10:20:00',2,1,'Producto se ocupara para una instalación',1),(3,3,'2019-01-04 11:25:00',4,'2019-01-04 11:38:00',1,2,'ASDF',1),(4,3,'2019-01-04 11:31:00',4,'2019-01-04 04:54:00',2,1,'ASDF',1),(5,3,'2019-01-04 11:33:00',4,'2019-01-04 11:39:00',2,1,'ASAD',1),(6,3,'2019-01-04 04:57:00',4,'2019-01-04 04:57:00',2,1,'Movimiento prueba 04042019',1),(7,3,'2019-01-04 05:01:00',4,'2019-01-07 08:56:00',2,1,'Movimiento Prueba 2',1),(8,3,'2019-01-11 09:10:00',NULL,NULL,1,2,'ASDF',2);
/*!40000 ALTER TABLE `tbl_reporte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_reportead`
--

DROP TABLE IF EXISTS `tbl_reportead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_reportead` (
  `IdReporteAd` int(11) NOT NULL AUTO_INCREMENT,
  `IdDepartamento` int(11) NOT NULL,
  `IdEmpleado` int(11) NOT NULL,
  `IdBodega` int(11) NOT NULL,
  `Fecha` datetime DEFAULT NULL,
  `State` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdReporteAd`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_reportead`
--

LOCK TABLES `tbl_reportead` WRITE;
/*!40000 ALTER TABLE `tbl_reportead` DISABLE KEYS */;
INSERT INTO `tbl_reportead` VALUES (1,2,3,1,'2019-01-11 03:38:00',0),(2,1,3,2,'2019-01-11 03:40:00',0),(3,1,3,1,'2019-01-11 03:41:00',0),(4,2,3,1,'2019-01-11 04:03:00',0),(5,2,3,1,'2019-01-11 05:28:00',0);
/*!40000 ALTER TABLE `tbl_reportead` ENABLE KEYS */;
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
-- Table structure for table `tbl_tipoproducto`
--

DROP TABLE IF EXISTS `tbl_tipoproducto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tipoproducto` (
  `IdTipoProducto` int(11) NOT NULL,
  `NombreTipoProducto` varchar(35) NOT NULL,
  `Abreviatura` varchar(5) NOT NULL,
  `state` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdTipoProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_tipoproducto`
--

LOCK TABLES `tbl_tipoproducto` WRITE;
/*!40000 ALTER TABLE `tbl_tipoproducto` DISABLE KEYS */;
INSERT INTO `tbl_tipoproducto` VALUES (1,'Instalaciones ','inst',1),(2,'Oficina ','ofi',1);
/*!40000 ALTER TABLE `tbl_tipoproducto` ENABLE KEYS */;
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
-- Table structure for table `tbl_permisosUsuario`
--

DROP TABLE IF EXISTS `tbl_permisosUsuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_permisosUsuario` (
  `IdPermisosUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `IdPermisos` int NOT NULL,
  `IdUsuario` int NOT NULL,
  PRIMARY KEY (`IdPermisosUsuario`),
  FOREIGN KEY (`IdPermisos`) REFERENCES `tbl_permisos` (`IdPermisos`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_usuario`
--

LOCK TABLES `tbl_permisosUsuario` WRITE;
/*!40000 ALTER TABLE `tbl_permisosUsuario` DISABLE KEYS */;
INSERT INTO `tbl_permisosUsuario` VALUES (1,1,1),(2,2,2), (3,3,1);
/*!40000 ALTER TABLE `tbl_permisosUsuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_modulos`
--

DROP TABLE IF EXISTS `tbl_modulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_modulos` (
  `IdModulo` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(20) NOT NULL,
  `Valor` int NOT NULL,
  PRIMARY KEY (`IdModulo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_modulos`
--

LOCK TABLES `tbl_modulos` WRITE;
/*!40000 ALTER TABLE `tbl_modulos` DISABLE KEYS */;
INSERT INTO `tbl_modulos` VALUES (1,'ADMINISTRACION',1),(2,'CONTABILIDAD',2), (3,'PLANILLA',4), (4,'ACTIVOFIJO',8), (5,'INVENTARIO',16), (6,'IVA',32), (7,'BANCOS',64), (8,'CXC',128), (9,'CXP',256);
/*!40000 ALTER TABLE `tbl_modulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_permisosUsuarioModulo`
--

DROP TABLE IF EXISTS `tbl_permisosUsuarioModulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_permisosUsuarioModulo` (
  `IdPermisosUsuarioModulo` int(11) NOT NULL AUTO_INCREMENT,
  `IdModulo` int NOT NULL,
  `IdUsuario` int NOT NULL,
  PRIMARY KEY (`IdPermisosUsuarioModulo`),
  FOREIGN KEY (`IdModulo`) REFERENCES `tbl_modulos` (`IdModulo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_permisosUsuarioModulo`
--

LOCK TABLES `tbl_permisosUsuarioModulo` WRITE;
/*!40000 ALTER TABLE `tbl_permisosUsuarioModulo` DISABLE KEYS */;
INSERT INTO `tbl_permisosUsuarioModulo` VALUES (1,1,1),(2,2,2), (3,3,1), (4,2,1), (5,4,1), (6,5,1), (7,6,1), (8,7,1), (9,8,1), (10,9,1);
/*!40000 ALTER TABLE `tbl_permisosUsuarioModulo` ENABLE KEYS */;
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
  `Rol` varchar(25) NOT NULL,
  `IdPermisosUsuario` int(3) DEFAULT NULL,
  `IdPermisosUsuarioModulo` int(3) DEFAULT NULL,
  `State` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdUsuario`),
  FOREIGN KEY (IdPermisosUsuarioModulo) REFERENCES tbl_permisosUsuarioModulo(IdPermisosUsuarioModulo) ON DELETE NO ACTION ON UPDATE NO ACTION,
  KEY `permi_idx` (`IdPermisosUsuario`),
  CONSTRAINT `permi` FOREIGN KEY (`IdPermisosUsuario`) REFERENCES `tbl_permisosUsuario` (`IdPermisosUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_usuario`
--

LOCK TABLES `tbl_usuario` WRITE;
/*!40000 ALTER TABLE `tbl_usuario` DISABLE KEYS */;
INSERT INTO `tbl_usuario` VALUES (1,'diego','1','administrador',1, 1, 1),(2,'frank','2','jefatura',2, 2, 1);
/*!40000 ALTER TABLE `tbl_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'satpro'
--

--
-- Table structure for table `tbl_permisosGlobal`
--

DROP TABLE IF EXISTS `tbl_permisosGlobal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_permisosGlobal` (
  `IdPermisosGlobal` int(11) NOT NULL AUTO_INCREMENT,
  `Madmin` int NOT NULL,
  `Mcont` int NOT NULL,
  `Mplan` int NOT NULL,
  `Macti` int NOT NULL,
  `Minve` int NOT NULL,
  `Miva` int NOT NULL,
  `Mbanc` int NOT NULL,
  `Mcxc` int NOT NULL,
  `Mcxp` int NOT NULL,
  `Ag` int NOT NULL,
  `Ed` int NOT NULL,
  `El` int NOT NULL,
  `IdUsuario` int NOT NULL,
  PRIMARY KEY (`IdPermisosGlobal`),
  FOREIGN KEY (`IdUsuario`) REFERENCES `tbl_usuario` (`IdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_permisosGlobal`
--

LOCK TABLES `tbl_permisosGlobal` WRITE;
/*!40000 ALTER TABLE `tbl_permisosGlobal` DISABLE KEYS */;
INSERT INTO `tbl_permisosGlobal` VALUES (1,1,2,4,8,16,32,64,128,256,1,2,4,1),(2,0,2,4,8,0,0,64,128,0,1,2,0,2);
/*!40000 ALTER TABLE `tbl_permisosGlobal` ENABLE KEYS */;
UNLOCK TABLES;

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

-- Dump completed on 2019-01-11 17:42:39
