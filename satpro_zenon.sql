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
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `cod_cliente` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `nombre` varchar(70) DEFAULT NULL,
  `nombre_comercial` varchar(70) DEFAULT NULL,
  `tipo_de_contrato` varchar(10) DEFAULT NULL,
  `razon` varchar(60) DEFAULT NULL,
  `giro` text,
  `numero_nit` text,
  `numero_dui` text,
  `lugar_exp` text,
  `num_registro` text,
  `direccion_cobro` varchar(200) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `id_departamento` text,
  `id_municipio` text,
  `id_colonia` text,
  `telefonos` text,
  `numero_fax` text,
  `correo_electronico` text,
  `contacto2` text,
  `contactos` text,
  `telcon2` text,
  `dir2` text,
  `telcon1` text,
  `dir1` text,
  `saldo_actual` double DEFAULT NULL,
  `limite_credito` int(11) DEFAULT NULL,
  `forma_pago` int(11) DEFAULT NULL,
  `dias_credito` int(11) DEFAULT NULL,
  `id_cuenta` text,
  `aplica_retencion` text,
  `cod_vendedor` text,
  `fecha_ult_pago` text,
  `creado_por` text,
  `fecha_hora_creacion` text,
  `tipo_comprobante` int(11) DEFAULT NULL,
  `servicio_suspendido` char(1) DEFAULT NULL,
  `fecha_suspencion` text,
  `fecha_reinstalacion` text,
  `servicio_cortesia` char(1) DEFAULT NULL,
  `cortesia_desde` text,
  `cortesia_hasta` text,
  `dia_cobro` int(11) DEFAULT NULL,
  `valor_cuota` double DEFAULT NULL,
  `prepago` double DEFAULT NULL,
  `nacionalidad` text,
  `profesion` text,
  `fecha_instalacion` text,
  `id_tecnico` int(11) DEFAULT NULL,
  `cod_cobrador` varchar(3) DEFAULT NULL,
  `numero_derivaciones` int(11) DEFAULT NULL,
  `numero_contrato` text,
  `num_factura` text,
  `fecha_ult_nota` text,
  `tipo_servicio` int(11) DEFAULT NULL,
  `fecha_nacimiento` text,
  `cta_anticipo` text,
  `saldo_suspension` double DEFAULT NULL,
  `saldo_anticipo` double DEFAULT NULL,
  `lugar_trabajo` text,
  `tel_trabajo` text,
  `direccion_trabajo` text,
  `fecha_primer_factura` text,
  `ult_usuario` text,
  `cod_tap` text,
  `num_tap` text,
  `numero_salida` text,
  `cortesia_desde1` text,
  `cortesia_hasta1` text,
  `cod_gral` int(11) DEFAULT NULL,
  `nombre_gral` text,
  `id_tipo_cliente` text,
  `id_velocidad` text,
  `email` text,
  `tipo_facturacion` int(11) DEFAULT NULL,
  `fecha_instalacion_in` text,
  `fecha_primer_factura_in` text,
  `vencimiento_in` text,
  `cuota_in` double DEFAULT NULL,
  `prepago_in` double DEFAULT NULL,
  `dia_corbo_in` int(11) DEFAULT NULL,
  `tipo_servicio_in` int(11) DEFAULT NULL,
  `id_promocion` text,
  `dese_promocion_in` text,
  `hasta_promocion_in` text,
  `cuota_promocion` int(11) DEFAULT NULL,
  `fecha_suspencion_in` text,
  `fecha_reconexion_in` text,
  `estado_cliente_in` char(1) DEFAULT NULL,
  `mac_modem` text,
  `serie_modem` text,
  `fecha_instalacion_tel` text,
  `fecha_primer_cuota_tel` text,
  `dia_cobro_tel` int(11) DEFAULT NULL,
  `tipo_servicio_tel` int(11) DEFAULT NULL,
  `estado_cliente_tel` int(11) DEFAULT NULL,
  `fecha_suspencion_tel` text,
  `fecha_reconexion_tel` text,
  `id_tarifa` text,
  `valor_tarifa` int(11) DEFAULT NULL,
  `ultima_suspencion_in` text,
  `sin_servicio` text,
  `dire_cable` varchar(300) DEFAULT NULL,
  `dire_internet` varchar(300) DEFAULT NULL,
  `dire_telefonia` text,
  `no_contrato_inter` text,
  `dias_renova_cont_int` int(11) DEFAULT NULL,
  `periodo_contrato_int` int(11) DEFAULT NULL,
  `colilla` text,
  `id_tecnico_in` int(11) DEFAULT NULL,
  `nombre_conyuge` text,
  `ocu_conyuge` text,
  `mactv` varchar(15) DEFAULT NULL,
  `saldoCable` double DEFAULT NULL,
  `saldoInternet` double DEFAULT NULL,
  `tecnologia` text,
  `entrega_calidad` text,
  `costo_instalacion_in` double DEFAULT '0',
  `exento` char(1) DEFAULT NULL,
  `periodo_contrato_ca` int(11) DEFAULT NULL,
  `vencimiento_ca` text,
  `susp_ven_ca` text,
  `ult_ren_in` text,
  `marca_modem` text,
  `clave_modem` text,
  `recep_modem` double DEFAULT NULL,
  `trans_modem` double DEFAULT NULL,
  `ruido_modem` double DEFAULT NULL,
  `paren1` text,
  `paren2` text,
  `paren3` text,
  `contacto3` text,
  `telcon3` text,
  `dir3` text,
  `wanip` text,
  `conexion` text,
  `facebook` text,
  `jefe` text,
  `coordenadas` varchar(70) DEFAULT NULL,
  `observaciones` text,
  `M1` char(1) DEFAULT NULL,
  `M2` char(1) DEFAULT NULL,
  `M3` char(1) DEFAULT NULL,
  `Pago1` char(1) DEFAULT NULL,
  `Pago2` char(1) DEFAULT NULL,
  `Pago3` char(1) DEFAULT NULL,
  `Pago4` char(1) DEFAULT NULL,
  `Pago5` char(1) DEFAULT NULL,
  `Pago6` char(1) DEFAULT NULL,
  `Anexo` varchar(15) DEFAULT NULL,
  `cuotaCovidC` double DEFAULT NULL,
  `covidDesdeC` varchar(10) DEFAULT NULL,
  `covidHastaC` varchar(10) DEFAULT NULL,
  `cuotaCovidI` double DEFAULT NULL,
  `covidDesdeI` varchar(10) DEFAULT NULL,
  `covidHastaI` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`cod_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=3102 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_abonos`
--

DROP TABLE IF EXISTS `tbl_abonos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_abonos` (
  `idAbono` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(70) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `idMunicipio` varchar(40) DEFAULT NULL,
  `idColonia` varchar(20) DEFAULT NULL,
  `numeroFactura` varchar(50) DEFAULT NULL,
  `tipoFactura` tinyint(1) NOT NULL,
  `numeroRecibo` varchar(50) DEFAULT NULL,
  `codigoCliente` varchar(6) NOT NULL,
  `codigoCobrador` varchar(6) NOT NULL,
  `cobradoPor` varchar(6) NOT NULL,
  `cuotaCable` double DEFAULT NULL,
  `cuotaInternet` double DEFAULT NULL,
  `saldoCable` double DEFAULT '0',
  `saldoInternet` double DEFAULT '0',
  `fechaCobro` date DEFAULT NULL,
  `fechaFactura` date DEFAULT NULL,
  `fechaVencimiento` date DEFAULT NULL,
  `fechaAbonado` date DEFAULT NULL,
  `mesCargo` varchar(10) DEFAULT '',
  `anticipo` double NOT NULL DEFAULT '0',
  `formaPago` varchar(10) DEFAULT '',
  `tipoServicio` char(1) NOT NULL,
  `estado` varchar(9) DEFAULT '',
  `anticipado` char(2) DEFAULT NULL,
  `cargoImpuesto` double DEFAULT NULL,
  `totalImpuesto` double DEFAULT NULL,
  `cargoIva` double DEFAULT NULL,
  `totalIva` double DEFAULT NULL,
  `recargo` double DEFAULT '0',
  `exento` varchar(2) DEFAULT NULL,
  `anulada` tinyint(1) DEFAULT '0',
  `idFactura` int(11) DEFAULT NULL,
  `creadoPor` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idAbono`)
) ENGINE=InnoDB AUTO_INCREMENT=45434 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Table structure for table `tbl_afps`
--

DROP TABLE IF EXISTS `tbl_afps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_afps` (
  `id_afp` int(2) NOT NULL AUTO_INCREMENT,
  `nombre_afp` varchar(25) DEFAULT NULL,
  `porcentaje_afp` double DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_afp`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_app_login_users`
--

DROP TABLE IF EXISTS `tbl_app_login_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_app_login_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(500) DEFAULT NULL,
  `userpassword` varchar(500) DEFAULT NULL,
  `code_client` int(5) unsigned zerofill DEFAULT NULL,
  `status` tinyint(11) NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `session` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cod_cliente` (`code_client`),
  CONSTRAINT `tbl_app_login_users_ibfk_1` FOREIGN KEY (`code_client`) REFERENCES `clientes` (`cod_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Table structure for table `tbl_articulo`
--

DROP TABLE IF EXISTS `tbl_articulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_articulo` (
  `IdArticulo` int(11) NOT NULL AUTO_INCREMENT,
  `Codigo` varchar(11) NOT NULL,
  `NombreArticulo` varchar(100) NOT NULL,
  `Descripcion` varchar(35) DEFAULT NULL,
  `Cantidad` double NOT NULL,
  `PrecioCompra` double DEFAULT NULL,
  `PrecioVenta` double DEFAULT NULL,
  `FechaEntrada` date NOT NULL,
  `nFactura` varchar(35) NOT NULL,
  `pGarantia` int(11) NOT NULL,
  `IdUnidadMedida` int(11) DEFAULT NULL,
  `IdTipoProducto` int(11) DEFAULT NULL,
  `IdCategoria` int(11) DEFAULT NULL,
  `IdProveedor` int(11) DEFAULT NULL,
  `IdBodega` int(11) NOT NULL,
  PRIMARY KEY (`IdArticulo`),
  KEY `UnidadM_idx` (`IdUnidadMedida`),
  KEY `SubCate_idx` (`IdCategoria`),
  KEY `Proveedor_idx` (`IdProveedor`),
  KEY `Bodega_idx` (`IdBodega`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_articuloempleado`
--

DROP TABLE IF EXISTS `tbl_articuloempleado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_articuloempleado` (
  `IdArticuloEmpleado` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoEmpleado` varchar(20) DEFAULT NULL,
  `NombreEmpleado` varchar(50) DEFAULT NULL,
  `IdArticuloDepartamento` int(11) DEFAULT NULL,
  `Comentario` varchar(50) DEFAULT NULL,
  `Cantidad` double DEFAULT NULL,
  `FechaEntregado` datetime DEFAULT NULL,
  `IdDepartamento` int(11) DEFAULT NULL,
  `State` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdArticuloEmpleado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_articulointernet`
--

DROP TABLE IF EXISTS `tbl_articulointernet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_articulointernet` (
  `IdArticulo` int(11) NOT NULL AUTO_INCREMENT,
  `nombreProducto` varchar(200) DEFAULT NULL,
  `Mac` varchar(25) DEFAULT NULL,
  `Serie` varchar(25) DEFAULT NULL,
  `Estado` int(11) DEFAULT NULL,
  `IdBodega` int(11) DEFAULT NULL,
  `Marca` varchar(25) DEFAULT NULL,
  `Modelo` varchar(25) DEFAULT NULL,
  `Descripcion` varchar(50) DEFAULT NULL,
  `Proveedor` varchar(40) DEFAULT NULL,
  `Fabricante` varchar(150) NOT NULL,
  `Categoria` varchar(15) DEFAULT NULL,
  `Tecnologia` varchar(15) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `fechaSalida` date DEFAULT NULL,
  `fechaRecuperado` date DEFAULT NULL,
  `condicion` varchar(40) DEFAULT NULL,
  `Garantia` int(11) DEFAULT NULL,
  `nFactura` varchar(30) NOT NULL,
  PRIMARY KEY (`IdArticulo`)
) ENGINE=InnoDB AUTO_INCREMENT=4184 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_articulosasignados`
--

DROP TABLE IF EXISTS `tbl_articulosasignados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_articulosasignados` (
  `IdArticulo` int(11) NOT NULL AUTO_INCREMENT,
  `Codigo` varchar(30) DEFAULT NULL,
  `NombreArticulo` varchar(30) DEFAULT NULL,
  `Responsable` varchar(50) DEFAULT NULL,
  `Unidad` varchar(50) DEFAULT NULL,
  `Descripcion` varchar(100) DEFAULT NULL,
  `Cantidad` double DEFAULT NULL,
  `PrecioCompra` double DEFAULT NULL,
  `PrecioVenta` double DEFAULT NULL,
  `FechaEntrada` date DEFAULT NULL,
  `IdUnidadMedida` int(11) DEFAULT NULL,
  `IdTipoProducto` int(11) DEFAULT NULL,
  `IdSubCategoria` int(11) DEFAULT NULL,
  `IdProveedor` int(11) DEFAULT NULL,
  `IdBodega` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdArticulo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_bancos`
--

DROP TABLE IF EXISTS `tbl_bancos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_bancos` (
  `id_banco` int(11) NOT NULL,
  `nombre_banco` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_banco`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_bodega`
--

DROP TABLE IF EXISTS `tbl_bodega`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_bodega` (
  `IdBodega` int(11) NOT NULL AUTO_INCREMENT,
  `NombreBodega` varchar(100) NOT NULL,
  `Direccion` varchar(25) NOT NULL,
  `State` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdBodega`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_cargos`
--

DROP TABLE IF EXISTS `tbl_cargos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_cargos` (
  `idFactura` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(70) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `idMunicipio` varchar(40) DEFAULT NULL,
  `idColonia` varchar(20) DEFAULT NULL,
  `numeroFactura` varchar(50) DEFAULT NULL,
  `tipoFactura` tinyint(1) DEFAULT NULL,
  `numeroRecibo` varchar(50) DEFAULT NULL,
  `codigoCliente` varchar(6) NOT NULL,
  `codigoCobrador` varchar(3) DEFAULT NULL,
  `cuotaCable` double DEFAULT NULL,
  `cuotaInternet` double DEFAULT NULL,
  `saldoCable` double DEFAULT '0',
  `saldoInternet` double DEFAULT '0',
  `prepago_cargos` double NOT NULL,
  `fechaCobro` date DEFAULT NULL,
  `fechaFactura` date DEFAULT NULL,
  `fechaVencimiento` date DEFAULT NULL,
  `fechaAbonado` date DEFAULT NULL,
  `mesCargo` varchar(10) DEFAULT '',
  `anticipo` double DEFAULT NULL,
  `formaPago` varchar(10) DEFAULT '',
  `tipoServicio` char(1) NOT NULL,
  `estado` varchar(9) DEFAULT '',
  `anticipado` char(2) DEFAULT NULL,
  `cargoImpuesto` double DEFAULT NULL,
  `totalImpuesto` double DEFAULT NULL,
  `retencion` double DEFAULT NULL,
  `cargoIva` double DEFAULT NULL,
  `totalIva` double DEFAULT NULL,
  `recargo` double DEFAULT '0',
  `exento` varchar(2) DEFAULT NULL,
  `anulada` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`idFactura`)
) ENGINE=InnoDB AUTO_INCREMENT=57197 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_categoria`
--

DROP TABLE IF EXISTS `tbl_categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_categoria` (
  `IdCategoria` int(11) NOT NULL AUTO_INCREMENT,
  `NombreCategoria` varchar(100) NOT NULL,
  `Descripcion` varchar(50) DEFAULT NULL,
  `State` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdCategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_cobradores`
--

DROP TABLE IF EXISTS `tbl_cobradores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_cobradores` (
  `codigoCobrador` int(3) unsigned zerofill NOT NULL,
  `nombreCobrador` varchar(70) DEFAULT NULL,
  `porcentajeComision` double DEFAULT NULL,
  `idEmpleado` varchar(11) DEFAULT NULL,
  `prefijoRe` varchar(11) DEFAULT NULL,
  `numeroAsignador` varchar(30) DEFAULT NULL,
  `desdeNumero` int(11) DEFAULT NULL,
  `hastaNumero` int(11) DEFAULT NULL,
  `prefijoCobro` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`codigoCobrador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_colonias_cxc`
--

DROP TABLE IF EXISTS `tbl_colonias_cxc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_colonias_cxc` (
  `idColonia` varchar(8) DEFAULT NULL,
  `nombreColonia` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_company_info`
--

DROP TABLE IF EXISTS `tbl_company_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_company_info` (
  `nombre` varchar(70) DEFAULT NULL,
  `nrc` varchar(20) DEFAULT NULL,
  `nit` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_contrato`
--

DROP TABLE IF EXISTS `tbl_contrato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_contrato` (
  `id_contrato` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_contrato` varchar(10) DEFAULT NULL,
  `prefijo_contrato` varchar(4) CHARACTER SET utf8 NOT NULL,
  `num_contrato` int(11) NOT NULL,
  `cod_cliente` int(11) NOT NULL,
  `numero_dui` varchar(10) CHARACTER SET utf8 NOT NULL,
  `numero_nit` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `tipo_servicio` char(1) CHARACTER SET utf8 NOT NULL,
  `velocidad` text CHARACTER SET utf8 NOT NULL,
  `cantidad` double NOT NULL,
  `periodo_contrato` int(4) NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(7) CHARACTER SET utf32 NOT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_contrato`)
) ENGINE=InnoDB AUTO_INCREMENT=2113 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_departamento`
--

DROP TABLE IF EXISTS `tbl_departamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_departamento` (
  `IdDepartamento` int(11) NOT NULL,
  `CodigoDepartamento` varchar(100) NOT NULL,
  `NombreDepartamento` varchar(20) NOT NULL,
  `Descripcion` varchar(140) NOT NULL,
  `IdEmpleado` int(11) DEFAULT NULL,
  `State` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdDepartamento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_departamentos_cxc`
--

DROP TABLE IF EXISTS `tbl_departamentos_cxc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_departamentos_cxc` (
  `idDepartamento` varchar(2) DEFAULT NULL,
  `nombreDepartamento` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  KEY `arttt_idx` (`IdArticulo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_detalledb`
--

DROP TABLE IF EXISTS `tbl_detalledb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_detalledb` (
  `IdDetalleDB` int(11) NOT NULL,
  `IdReporteDB` int(11) NOT NULL,
  `IdArticulo` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `State` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdDetalleDB`),
  KEY `ArtDb_idx` (`IdReporteDB`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_detallereporte`
--

DROP TABLE IF EXISTS `tbl_detallereporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_detallereporte` (
  `IdDetalleReporte` int(11) NOT NULL,
  `IdReporte` int(11) DEFAULT NULL,
  `IdArticulo` int(11) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdDetalleReporte`),
  KEY `Articulo_idx` (`IdArticulo`),
  KEY `Reporte_idx` (`IdReporte`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_empleado`
--

DROP TABLE IF EXISTS `tbl_empleado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_empleado` (
  `IdEmpleado` int(11) NOT NULL,
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
  KEY `Departamento_idx` (`IdDepartamento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_empleados`
--

DROP TABLE IF EXISTS `tbl_empleados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_empleados` (
  `id_empleado` int(5) NOT NULL,
  `nombres` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `apellidos` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `nombre_isss` varchar(70) CHARACTER SET latin1 DEFAULT NULL,
  `sexo` int(11) DEFAULT NULL,
  `municipio` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `departamento` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `direccion` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `telefonos` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `celular` varchar(9) CHARACTER SET latin1 DEFAULT NULL,
  `numero_nit` varchar(17) CHARACTER SET latin1 DEFAULT NULL,
  `no_licencia` varchar(17) CHARACTER SET latin1 DEFAULT NULL,
  `no_documento` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `extendido_en` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `fecha_expedicion` varchar(12) CHARACTER SET latin1 DEFAULT NULL,
  `no_isss` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `no_nup` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `profesion_oficio` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `lugar_nacimiento` int(11) DEFAULT NULL,
  `nacionalidad` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `estado_civil` varchar(25) DEFAULT NULL,
  `fecha_nacimiento` varchar(12) CHARACTER SET latin1 DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `nivel_estudios` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `clase` int(11) DEFAULT NULL,
  `estatura` double DEFAULT NULL,
  `peso` double DEFAULT NULL,
  `tipo_sangre` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `doc_lugarext` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `senales_especiales` varchar(30) DEFAULT NULL,
  `nombre_padre` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `nombre_madre` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `nombre_conyuge` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `trabajo_conyuge` varchar(70) CHARACTER SET latin1 DEFAULT NULL,
  `id_centro` varchar(40) DEFAULT NULL,
  `persona_autorizada` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `id_afp` int(11) DEFAULT NULL,
  `id_banco` int(11) DEFAULT NULL,
  `id_departamento` int(11) DEFAULT NULL,
  `tipo_contratacion` int(11) DEFAULT NULL,
  `id_plaza` int(11) DEFAULT NULL,
  `rol` varchar(30) DEFAULT NULL,
  `numero_cuenta` int(11) DEFAULT NULL,
  `por_afp` double DEFAULT NULL,
  `aplicar_isss` int(11) DEFAULT NULL,
  `cuota_seguro` int(11) DEFAULT NULL,
  `fecha_ingreso` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
  `fecha_contratacion` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
  `salario_ordinario` double DEFAULT NULL,
  `fecha_salario` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
  `empresa_refer1` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `cargo_refer1` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `jefe_refer1` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `tiempo_refer1` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `motivo_retiro1` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `empresa_refer2` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `cargo_refer2` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `jefe_refer2` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `tiempo_refer2` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `motivo_retiro2` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `nomb_ref_per1` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `tel_ref_per1` varchar(9) CHARACTER SET latin1 DEFAULT NULL,
  `nomb_ref_per2` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `tel_ref_per2` varchar(9) CHARACTER SET latin1 DEFAULT NULL,
  `nomb_ref_per3` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `tel_ref_per3` varchar(9) CHARACTER SET latin1 DEFAULT NULL,
  `nombre_ref_fam1` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `nombre_ref_fam2` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `nombre_ref_fam3` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `paren_ref_fam1` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `paren_ref_fam2` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `paren_ref_fam3` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `direc_ref_fam1` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `direc_ref_fam2` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `direc_ref_fam3` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `benef1` varchar(60) CHARACTER SET latin1 DEFAULT NULL,
  `parentesco1` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `porce1` double DEFAULT NULL,
  `benef2` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `parentesco2` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `porce2` double DEFAULT NULL,
  `benef3` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `parentesco3` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `porce3` double DEFAULT NULL,
  `benef4` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `parentesco4` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `porce4` double DEFAULT NULL,
  `pro_retiro` int(11) DEFAULT NULL,
  `estado_empleado` tinyint(2) DEFAULT NULL,
  `fecha1` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
  `fecha2` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
  `id_cuenta1` int(11) DEFAULT NULL,
  `id_cuenta2` int(11) DEFAULT NULL,
  `id_cuenta3` int(11) DEFAULT NULL,
  `anio_salario` double DEFAULT NULL,
  `salario_primer_semestre` double DEFAULT NULL,
  `renta_primer_semestre` double DEFAULT NULL,
  `salario_segundo_semestre` double DEFAULT NULL,
  `renta_segundo_semestre` double DEFAULT NULL,
  `IdUsuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_empleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_facturas`
--

DROP TABLE IF EXISTS `tbl_facturas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_facturas` (
  `idFactura` int(11) NOT NULL,
  `numeroFactura` int(11) NOT NULL,
  `tipoFactura` varchar(20) NOT NULL,
  `numeroRecibo` int(11) NOT NULL,
  `codigoCliente` varchar(6) NOT NULL,
  `cuotaCable` double NOT NULL,
  `cuotaInternet` double NOT NULL,
  `saldoCable` double NOT NULL,
  `saldoInternet` double NOT NULL,
  `fechaCobro` date DEFAULT NULL,
  `fechaFactura` date DEFAULT NULL,
  `fechaVencimiento` date DEFAULT NULL,
  `montoCancelado` double DEFAULT '0',
  `fechaCancelado` date DEFAULT NULL,
  `mesCancelado` varchar(3) DEFAULT '',
  `formaPago` varchar(10) DEFAULT '',
  `tipoServicio` char(1) NOT NULL,
  `anticipado` tinyint(1) DEFAULT '0',
  `impuesto` double NOT NULL,
  `impuestoAbonado` double DEFAULT '0',
  `anulada` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`idFactura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_facturas_config`
--

DROP TABLE IF EXISTS `tbl_facturas_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_facturas_config` (
  `idConfig` int(11) NOT NULL,
  `prefijoFactura` varchar(11) DEFAULT NULL,
  `prefijoFiscal` varchar(11) DEFAULT NULL,
  `prefijoFacturaPeque` varchar(11) DEFAULT NULL,
  `ultimaFactura` int(11) DEFAULT NULL,
  `ultimaFiscal` int(11) DEFAULT NULL,
  `ultimaPeque` int(11) DEFAULT NULL,
  `rangoDesdeFactura` int(6) DEFAULT NULL,
  `rangoHastaFactura` int(6) DEFAULT NULL,
  `rangoDesdeFiscal` int(6) DEFAULT NULL,
  `rangoHastaFiscal` int(6) DEFAULT NULL,
  `rangoDesdePeque` int(6) DEFAULT NULL,
  `rangoHastaPeque` int(6) DEFAULT NULL,
  PRIMARY KEY (`idConfig`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_forma_facturar`
--

DROP TABLE IF EXISTS `tbl_forma_facturar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_forma_facturar` (
  `idFormaFacturar` int(1) NOT NULL,
  `nombreForma` varchar(10) NOT NULL,
  PRIMARY KEY (`idFormaFacturar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_forma_pago`
--

DROP TABLE IF EXISTS `tbl_forma_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_forma_pago` (
  `idFormaPago` int(1) NOT NULL,
  `nombreFormaPago` varchar(18) NOT NULL,
  PRIMARY KEY (`idFormaPago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_formas_pago`
--

DROP TABLE IF EXISTS `tbl_formas_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_formas_pago` (
  `idFormaPago` int(1) NOT NULL AUTO_INCREMENT,
  `nombreFormaPago` varchar(25) NOT NULL,
  PRIMARY KEY (`idFormaPago`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_generos`
--

DROP TABLE IF EXISTS `tbl_generos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_generos` (
  `idGenero` int(1) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  PRIMARY KEY (`idGenero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_gestion_clientes`
--

DROP TABLE IF EXISTS `tbl_gestion_clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_gestion_clientes` (
  `idGestionCliente` int(6) NOT NULL AUTO_INCREMENT,
  `fechaGestion` varchar(15) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `gestion` varchar(1) DEFAULT NULL,
  `fechaSuspension` varchar(15) DEFAULT NULL,
  `tipoServicio` char(1) NOT NULL,
  `creadoPor` varchar(50) NOT NULL,
  `idGestionGeneral` int(6) NOT NULL,
  PRIMARY KEY (`idGestionCliente`),
  KEY `idGestionGeneral` (`idGestionGeneral`),
  CONSTRAINT `tbl_gestion_clientes_ibfk_1` FOREIGN KEY (`idGestionGeneral`) REFERENCES `tbl_gestion_general` (`idGestionGeneral`)
) ENGINE=InnoDB AUTO_INCREMENT=3605 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_gestion_general`
--

DROP TABLE IF EXISTS `tbl_gestion_general`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_gestion_general` (
  `idGestionGeneral` int(6) NOT NULL AUTO_INCREMENT,
  `codigoCliente` int(5) unsigned zerofill DEFAULT NULL,
  `saldoCable` double NOT NULL,
  `saldoInternet` double NOT NULL,
  `diaCobro` int(2) DEFAULT NULL,
  `idCobrador` int(2) NOT NULL,
  `nombreCliente` varchar(50) NOT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `telefonos` varchar(25) NOT NULL,
  `creadoPor` varchar(50) NOT NULL,
  PRIMARY KEY (`idGestionGeneral`)
) ENGINE=InnoDB AUTO_INCREMENT=2281 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_histoingreso`
--

DROP TABLE IF EXISTS `tbl_histoingreso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_histoingreso` (
  `IdHistoIngreso` int(11) NOT NULL,
  `FechaIngreso` datetime DEFAULT NULL,
  `IdArticulo` int(11) DEFAULT NULL,
  `Cantidad` double DEFAULT NULL,
  `IdBodega` int(11) DEFAULT NULL,
  `IdEmpleado` int(11) DEFAULT NULL,
  `Tipo` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdHistoIngreso`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_historialentradas`
--

DROP TABLE IF EXISTS `tbl_historialentradas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_historialentradas` (
  `idHistorial` int(11) NOT NULL AUTO_INCREMENT,
  `nombreArticulo` varchar(40) DEFAULT NULL,
  `nombreEmpleado` varchar(40) DEFAULT NULL,
  `fechaHora` datetime DEFAULT NULL,
  `tipoMovimiento` varchar(40) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `bodega` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idHistorial`)
) ENGINE=InnoDB AUTO_INCREMENT=4228 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_historialregistros`
--

DROP TABLE IF EXISTS `tbl_historialregistros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_historialregistros` (
  `IdHistorialRegistros` int(11) NOT NULL,
  `IdEmpleado` int(11) DEFAULT NULL,
  `FechaHora` datetime DEFAULT NULL,
  `Tipo_Movimiento` int(11) DEFAULT NULL,
  `Descripcion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`IdHistorialRegistros`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_impuestos`
--

DROP TABLE IF EXISTS `tbl_impuestos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_impuestos` (
  `idImpuesto` int(11) NOT NULL,
  `nombreImpuesto` varchar(25) NOT NULL,
  `siglasImpuesto` varchar(10) NOT NULL,
  `valorImpuesto` double NOT NULL,
  `ultimaActualizacion` date DEFAULT NULL,
  PRIMARY KEY (`idImpuesto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_isss`
--

DROP TABLE IF EXISTS `tbl_isss`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_isss` (
  `idIsss` int(1) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `porcentaje` double NOT NULL,
  PRIMARY KEY (`idIsss`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_modulos`
--

DROP TABLE IF EXISTS `tbl_modulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_modulos` (
  `IdModulo` int(11) NOT NULL,
  `Nombre` varchar(20) NOT NULL,
  `Valor` int(11) NOT NULL,
  PRIMARY KEY (`IdModulo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_municipios_cxc`
--

DROP TABLE IF EXISTS `tbl_municipios_cxc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_municipios_cxc` (
  `idMunicipio` varchar(4) DEFAULT NULL,
  `nombreMunicipio` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_ordenes_reconexion`
--

DROP TABLE IF EXISTS `tbl_ordenes_reconexion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_ordenes_reconexion` (
  `idOrdenReconex` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `codigoCliente` int(5) unsigned zerofill DEFAULT NULL,
  `fechaOrden` date NOT NULL,
  `tipoOrden` varchar(20) NOT NULL,
  `tipoReconexCable` varchar(30) NOT NULL,
  `tipoReconexInter` varchar(30) NOT NULL,
  `saldoCable` double NOT NULL,
  `saldoInter` double NOT NULL,
  `diaCobro` int(2) DEFAULT NULL,
  `nombreCliente` varchar(50) NOT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `telefonos` varchar(25) NOT NULL,
  `macModem` varchar(25) DEFAULT NULL,
  `serieModem` varchar(25) DEFAULT NULL,
  `velocidad` varchar(10) DEFAULT NULL,
  `colilla` varchar(10) DEFAULT NULL,
  `fechaReconexCable` varchar(15) DEFAULT NULL,
  `fechaReconexInter` varchar(15) DEFAULT NULL,
  `fechaReconex` varchar(15) DEFAULT NULL,
  `ultSuspCable` varchar(15) DEFAULT NULL,
  `ultSuspInter` varchar(15) DEFAULT NULL,
  `idTecnico` int(6) DEFAULT NULL,
  `mactv` varchar(25) DEFAULT NULL,
  `observaciones` varchar(80) DEFAULT NULL,
  `tipoServicio` char(1) NOT NULL,
  `creadoPor` varchar(50) NOT NULL,
  `coordenadas` varchar(25) DEFAULT NULL,
  `servRecox` int(11) NOT NULL,
  PRIMARY KEY (`idOrdenReconex`)
) ENGINE=InnoDB AUTO_INCREMENT=165 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_ordenes_suspension`
--

DROP TABLE IF EXISTS `tbl_ordenes_suspension`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_ordenes_suspension` (
  `idOrdenSuspension` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `codigoCliente` int(5) unsigned zerofill DEFAULT NULL,
  `fechaOrden` date NOT NULL,
  `tipoOrden` varchar(20) NOT NULL,
  `diaCobro` int(2) DEFAULT NULL,
  `nombreCliente` varchar(50) NOT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `actividadCable` tinyint(1) DEFAULT NULL,
  `saldoCable` double DEFAULT NULL,
  `actividadInter` tinyint(1) DEFAULT NULL,
  `saldoInter` double DEFAULT NULL,
  `ordenaSuspension` varchar(20) DEFAULT NULL,
  `macModem` varchar(25) DEFAULT NULL,
  `serieModem` varchar(25) DEFAULT NULL,
  `velocidad` varchar(10) DEFAULT NULL,
  `colilla` varchar(10) DEFAULT NULL,
  `fechaSuspension` varchar(10) DEFAULT NULL,
  `idTecnico` int(6) DEFAULT NULL,
  `mactv` varchar(25) DEFAULT NULL,
  `observaciones` varchar(300) DEFAULT NULL,
  `tipoServicio` char(1) NOT NULL,
  `creadoPor` varchar(50) NOT NULL,
  `coordenadas` varchar(25) DEFAULT NULL,
  `servSusp` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idOrdenSuspension`)
) ENGINE=InnoDB AUTO_INCREMENT=2141 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_ordenes_trabajo`
--

DROP TABLE IF EXISTS `tbl_ordenes_trabajo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_ordenes_trabajo` (
  `idOrdenTrabajo` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `codigoCliente` int(5) unsigned zerofill DEFAULT NULL,
  `fechaOrdenTrabajo` date NOT NULL,
  `tipoOrdenTrabajo` varchar(20) NOT NULL,
  `diaCobro` int(2) DEFAULT NULL,
  `nombreCliente` varchar(50) NOT NULL,
  `telefonos` varchar(25) NOT NULL,
  `idMunicipio` varchar(10) NOT NULL,
  `actividadCable` varchar(40) DEFAULT NULL,
  `saldoCable` double DEFAULT NULL,
  `direccionCable` varchar(150) DEFAULT NULL,
  `actividadInter` varchar(40) DEFAULT NULL,
  `saldoInter` double DEFAULT NULL,
  `direccionInter` varchar(150) DEFAULT NULL,
  `macModem` varchar(25) DEFAULT NULL,
  `serieModem` varchar(25) DEFAULT NULL,
  `velocidad` varchar(10) DEFAULT NULL,
  `rx` varchar(6) DEFAULT NULL,
  `tx` varchar(6) DEFAULT NULL,
  `snr` varchar(6) DEFAULT NULL,
  `colilla` varchar(10) DEFAULT NULL,
  `fechaTrabajo` varchar(10) DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `fechaProgramacion` varchar(30) DEFAULT NULL,
  `idTecnico` int(6) DEFAULT NULL,
  `mactv` varchar(25) DEFAULT NULL,
  `coordenadas` varchar(50) DEFAULT NULL,
  `marcaModelo` varchar(25) DEFAULT NULL,
  `tecnologia` varchar(20) DEFAULT NULL,
  `observaciones` varchar(300) DEFAULT NULL,
  `nodo` varchar(20) DEFAULT NULL,
  `idVendedor` int(6) NOT NULL,
  `recepcionTv` varchar(10) DEFAULT NULL,
  `tipoServicio` char(1) NOT NULL,
  `creadoPor` varchar(50) NOT NULL,
  `checksoporte` int(11) DEFAULT NULL,
  PRIMARY KEY (`idOrdenTrabajo`)
) ENGINE=InnoDB AUTO_INCREMENT=11618 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_ordenes_traslado`
--

DROP TABLE IF EXISTS `tbl_ordenes_traslado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_ordenes_traslado` (
  `idOrdenTraslado` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `codigoCliente` int(5) unsigned zerofill DEFAULT NULL,
  `fechaOrden` date NOT NULL,
  `tipoOrden` varchar(20) NOT NULL,
  `saldoCable` double NOT NULL,
  `saldoInter` double DEFAULT NULL,
  `diaCobro` int(2) DEFAULT NULL,
  `nombreCliente` varchar(50) NOT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `direccionTraslado` varchar(150) DEFAULT NULL,
  `idDepartamento` int(6) DEFAULT NULL,
  `idMunicipio` int(6) DEFAULT NULL,
  `idColonia` int(6) DEFAULT NULL,
  `telefonos` varchar(25) NOT NULL,
  `macModem` varchar(25) DEFAULT NULL,
  `serieModem` varchar(25) DEFAULT NULL,
  `velocidad` int(6) DEFAULT NULL,
  `colilla` varchar(10) DEFAULT NULL,
  `fechaTraslado` varchar(15) DEFAULT NULL,
  `idTecnico` int(6) DEFAULT NULL,
  `mactv` varchar(25) DEFAULT NULL,
  `observaciones` varchar(80) DEFAULT NULL,
  `tipoServicio` char(1) NOT NULL,
  `creadoPor` varchar(50) NOT NULL,
  `coordenadas` varchar(25) DEFAULT NULL,
  `coordenadasNuevas` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`idOrdenTraslado`)
) ENGINE=InnoDB AUTO_INCREMENT=298 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_permisos`
--

DROP TABLE IF EXISTS `tbl_permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_permisos` (
  `IdPermisos` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `valor` int(11) NOT NULL,
  PRIMARY KEY (`IdPermisos`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_permisosglobal`
--

DROP TABLE IF EXISTS `tbl_permisosglobal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_permisosglobal` (
  `IdPermisosGlobal` int(11) NOT NULL AUTO_INCREMENT,
  `Madmin` int(11) NOT NULL,
  `Mcont` int(11) NOT NULL,
  `Mplan` int(11) NOT NULL,
  `Macti` int(11) NOT NULL,
  `Minve` int(11) NOT NULL,
  `Miva` int(11) NOT NULL,
  `Mbanc` int(11) NOT NULL,
  `Mcxc` int(11) NOT NULL,
  `Mcxp` int(11) NOT NULL,
  `Ag` int(11) NOT NULL,
  `Ed` int(11) NOT NULL,
  `El` int(11) NOT NULL,
  `GenCont` int(11) NOT NULL,
  `ImpCont` int(11) NOT NULL,
  `IdUsuario` int(11) NOT NULL,
  PRIMARY KEY (`IdPermisosGlobal`),
  KEY `IdUsuario` (`IdUsuario`),
  CONSTRAINT `tbl_permisosglobal_ibfk_1` FOREIGN KEY (`IdUsuario`) REFERENCES `tbl_usuario` (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_permisosusuario`
--

DROP TABLE IF EXISTS `tbl_permisosusuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_permisosusuario` (
  `IdPermisosUsuario` int(11) NOT NULL,
  `IdPermisos` int(11) NOT NULL,
  `IdUsuario` int(11) NOT NULL,
  PRIMARY KEY (`IdPermisosUsuario`),
  KEY `IdPermisos` (`IdPermisos`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_permisosusuariomodulo`
--

DROP TABLE IF EXISTS `tbl_permisosusuariomodulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_permisosusuariomodulo` (
  `IdPermisosUsuarioModulo` int(11) NOT NULL,
  `IdModulo` int(11) NOT NULL,
  `IdUsuario` int(11) NOT NULL,
  PRIMARY KEY (`IdPermisosUsuarioModulo`),
  KEY `IdModulo` (`IdModulo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_plazas`
--

DROP TABLE IF EXISTS `tbl_plazas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_plazas` (
  `idPlaza` int(11) NOT NULL,
  `nombrePlaza` varchar(35) NOT NULL,
  `descripcionPlaza` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`idPlaza`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_proveedor`
--

DROP TABLE IF EXISTS `tbl_proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_proveedor` (
  `IdProveedor` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) NOT NULL,
  `Representante` varchar(100) NOT NULL,
  `Telefono` varchar(10) NOT NULL,
  `Correo` varchar(50) NOT NULL,
  `Nrc` varchar(15) NOT NULL,
  `Nit` varchar(18) NOT NULL,
  `Nacionalidad` varchar(25) NOT NULL,
  `state` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdProveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_puntos_venta`
--

DROP TABLE IF EXISTS `tbl_puntos_venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_puntos_venta` (
  `idPunto` int(2) NOT NULL AUTO_INCREMENT,
  `nombrePuntoVenta` varchar(50) NOT NULL,
  `descripcion` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`idPunto`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_referencia`
--

DROP TABLE IF EXISTS `tbl_referencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_referencia` (
  `IdReferencia` int(11) NOT NULL,
  `IdEmpleado` int(11) DEFAULT NULL,
  `Referencia_1` varchar(50) DEFAULT NULL,
  `Telefono_1` varchar(10) DEFAULT NULL,
  `Referencia_2` varchar(50) DEFAULT NULL,
  `Telefono_2` varchar(10) DEFAULT NULL,
  `State` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdReferencia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
  KEY `Emple_idx` (`IdEmpleadoOrigen`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_reportead`
--

DROP TABLE IF EXISTS `tbl_reportead`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_reportead` (
  `IdReporteAd` int(11) NOT NULL AUTO_INCREMENT,
  `IdDepartamento` int(11) NOT NULL,
  `IdBodega` int(11) NOT NULL,
  `IdEmpleadoEnvio` int(11) NOT NULL,
  `FechaEnvio` datetime DEFAULT NULL,
  `ComentarioEnvio` varchar(50) DEFAULT NULL,
  `IdEmpleadoRecibe` int(11) DEFAULT NULL,
  `FechaRecibe` datetime DEFAULT NULL,
  `ComentarioRecibe` varchar(50) DEFAULT NULL,
  `State` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdReporteAd`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_reportedb`
--

DROP TABLE IF EXISTS `tbl_reportedb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_reportedb` (
  `IdReporteDB` int(11) NOT NULL AUTO_INCREMENT,
  `IdDepartamento` int(11) NOT NULL,
  `IdBodega` int(11) DEFAULT NULL,
  `IdEmpleadoEnvio` int(11) DEFAULT NULL,
  `FechaEnvio` datetime DEFAULT NULL,
  `ComentarioEnvio` varchar(100) DEFAULT NULL,
  `IdEmpleadoRecibe` int(11) DEFAULT NULL,
  `FechaRecibe` datetime DEFAULT NULL,
  `ComentarioRecibe` varchar(100) DEFAULT NULL,
  `State` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdReporteDB`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_roles`
--

DROP TABLE IF EXISTS `tbl_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_roles` (
  `idRol` int(2) NOT NULL,
  `nombreRol` varchar(30) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idRol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_servicios_cable`
--

DROP TABLE IF EXISTS `tbl_servicios_cable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_servicios_cable` (
  `idServicioCable` int(1) NOT NULL,
  `nombreServicioCable` varchar(15) NOT NULL,
  PRIMARY KEY (`idServicioCable`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_servicios_inter`
--

DROP TABLE IF EXISTS `tbl_servicios_inter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_servicios_inter` (
  `idServicioInter` int(1) NOT NULL,
  `nombreServicioInter` varchar(15) NOT NULL,
  PRIMARY KEY (`idServicioInter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_tbl_colonias_cxc`
--

DROP TABLE IF EXISTS `tbl_tbl_colonias_cxc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tbl_colonias_cxc` (
  `idColonia` varchar(8) DEFAULT NULL,
  `nombreColonia` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_tecnicos_cxc`
--

DROP TABLE IF EXISTS `tbl_tecnicos_cxc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tecnicos_cxc` (
  `idTecnico` int(3) unsigned zerofill DEFAULT NULL,
  `nombreTecnico` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_tecnologias`
--

DROP TABLE IF EXISTS `tbl_tecnologias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tecnologias` (
  `idTecnologia` int(1) NOT NULL,
  `nombreTecnologia` varchar(15) NOT NULL,
  PRIMARY KEY (`idTecnologia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_tipo_comprobante`
--

DROP TABLE IF EXISTS `tbl_tipo_comprobante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tipo_comprobante` (
  `idComprobante` int(1) NOT NULL,
  `nombreComprobante` varchar(18) NOT NULL,
  PRIMARY KEY (`idComprobante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_tipo_venta`
--

DROP TABLE IF EXISTS `tbl_tipo_venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tipo_venta` (
  `idTipoVenta` int(1) NOT NULL AUTO_INCREMENT,
  `nombreTipo` varchar(25) NOT NULL,
  PRIMARY KEY (`idTipoVenta`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_tipoproducto`
--

DROP TABLE IF EXISTS `tbl_tipoproducto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tipoproducto` (
  `IdTipoProducto` int(11) NOT NULL AUTO_INCREMENT,
  `NombreTipoProducto` varchar(100) NOT NULL,
  `state` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdTipoProducto`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_tipos_clientes`
--

DROP TABLE IF EXISTS `tbl_tipos_clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tipos_clientes` (
  `idTipoCliente` int(4) unsigned zerofill DEFAULT NULL,
  `nombreTipoCliente` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_tv_box`
--

DROP TABLE IF EXISTS `tbl_tv_box`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tv_box` (
  `idBox` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `boxNum` int(5) NOT NULL,
  `cast` varchar(30) NOT NULL,
  `serialBox` varchar(30) NOT NULL,
  `brand` varchar(30) DEFAULT NULL,
  `clientCode` int(5) unsigned zerofill NOT NULL,
  `beforeClientCode` int(5) unsigned zerofill DEFAULT NULL,
  `activeDate` varchar(10) DEFAULT NULL,
  `user` varchar(80) NOT NULL,
  `observation` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`idBox`)
) ENGINE=InnoDB AUTO_INCREMENT=1412 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_unidadmedida`
--

DROP TABLE IF EXISTS `tbl_unidadmedida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_unidadmedida` (
  `IdUnidadMedida` int(11) NOT NULL,
  `NombreUnidadMedida` varchar(100) NOT NULL,
  `Abreviatura` varchar(5) NOT NULL,
  `state` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdUnidadMedida`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Table structure for table `tbl_velocidades`
--

DROP TABLE IF EXISTS `tbl_velocidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_velocidades` (
  `idVelocidad` int(4) unsigned zerofill NOT NULL,
  `nombreVelocidad` varchar(20) NOT NULL,
  `precio` double DEFAULT NULL,
  PRIMARY KEY (`idVelocidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_vendedores`
--

DROP TABLE IF EXISTS `tbl_vendedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_vendedores` (
  `idVendedor` int(4) NOT NULL,
  `nombresVendedor` varchar(40) NOT NULL,
  `apellidosVendedor` varchar(40) NOT NULL,
  `state` tinyint(1) NOT NULL,
  PRIMARY KEY (`idVendedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_ventas_anuladas`
--

DROP TABLE IF EXISTS `tbl_ventas_anuladas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_ventas_anuladas` (
  `idVenta` int(1) NOT NULL AUTO_INCREMENT,
  `prefijo` varchar(15) NOT NULL,
  `numeroComprobante` varchar(20) NOT NULL,
  `tipoComprobante` tinyint(1) NOT NULL,
  `fechaComprobante` varchar(12) NOT NULL,
  `codigoCliente` int(5) unsigned zerofill NOT NULL,
  `nombreCliente` varchar(70) DEFAULT NULL,
  `direccionCliente` varchar(100) DEFAULT NULL,
  `municipio` varchar(30) DEFAULT NULL,
  `departamento` varchar(20) DEFAULT NULL,
  `giro` varchar(30) DEFAULT NULL,
  `numeroRegistro` varchar(20) DEFAULT NULL,
  `nit` varchar(20) DEFAULT NULL,
  `formaPago` tinyint(1) DEFAULT NULL,
  `fechaVencimiento` varchar(15) DEFAULT NULL,
  `codigoVendedor` varchar(3) DEFAULT NULL,
  `tipoVenta` tinyint(1) DEFAULT NULL,
  `ventaTitulo` varchar(30) DEFAULT NULL,
  `ventaAfecta` double DEFAULT NULL,
  `ventaExenta` double DEFAULT NULL,
  `valorIva` double DEFAULT NULL,
  `totalComprobante` double DEFAULT NULL,
  `idPunto` tinyint(2) DEFAULT NULL,
  `creadoPor` varchar(50) NOT NULL,
  `fechaHora` varchar(25) NOT NULL,
  `impuesto` double DEFAULT NULL,
  `tipoServicio` char(2) DEFAULT NULL,
  PRIMARY KEY (`idVenta`)
) ENGINE=InnoDB AUTO_INCREMENT=1930239 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_ventas_manuales`
--

DROP TABLE IF EXISTS `tbl_ventas_manuales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_ventas_manuales` (
  `idVenta` int(1) NOT NULL AUTO_INCREMENT,
  `prefijo` varchar(15) NOT NULL,
  `numeroComprobante` varchar(20) NOT NULL,
  `tipoComprobante` tinyint(1) NOT NULL,
  `fechaComprobante` varchar(12) NOT NULL,
  `codigoCliente` int(5) unsigned zerofill NOT NULL,
  `nombreCliente` varchar(70) DEFAULT NULL,
  `direccionCliente` varchar(100) DEFAULT NULL,
  `municipio` varchar(30) DEFAULT NULL,
  `departamento` varchar(20) DEFAULT NULL,
  `giro` varchar(30) DEFAULT NULL,
  `numeroRegistro` varchar(20) DEFAULT NULL,
  `nit` varchar(20) DEFAULT NULL,
  `formaPago` tinyint(1) DEFAULT NULL,
  `fechaVencimiento` varchar(15) DEFAULT NULL,
  `codigoVendedor` varchar(3) DEFAULT NULL,
  `tipoVenta` tinyint(1) DEFAULT NULL,
  `ventaTitulo` varchar(30) DEFAULT NULL,
  `ventaAfecta` double DEFAULT NULL,
  `ventaExenta` double DEFAULT NULL,
  `valorIva` double DEFAULT NULL,
  `totalComprobante` double DEFAULT NULL,
  `anulada` tinyint(1) DEFAULT NULL,
  `cableExtra` char(1) DEFAULT NULL,
  `decodificador` char(1) DEFAULT NULL,
  `derivacion` char(1) DEFAULT NULL,
  `instalacionTemporal` char(1) DEFAULT NULL,
  `pagoTardio` char(1) DEFAULT NULL,
  `reconexion` char(1) DEFAULT NULL,
  `servicioPrestado` char(1) DEFAULT NULL,
  `traslados` char(1) DEFAULT NULL,
  `reconexionTraslado` char(1) DEFAULT NULL,
  `cambioFecha` char(1) DEFAULT NULL,
  `otros` char(1) DEFAULT NULL,
  `proporcion` char(1) DEFAULT NULL,
  `idPunto` tinyint(2) DEFAULT NULL,
  `creadoPor` varchar(50) NOT NULL,
  `fechaHora` varchar(25) NOT NULL,
  `montoCable` double DEFAULT NULL,
  `montoInternet` double DEFAULT NULL,
  `impuesto` double DEFAULT NULL,
  PRIMARY KEY (`idVenta`)
) ENGINE=InnoDB AUTO_INCREMENT=5758 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `traslado_servicio`
--

DROP TABLE IF EXISTS `traslado_servicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `traslado_servicio` (
  `idTraslado` decimal(11,0) DEFAULT NULL,
  `numeroTraslado` char(11) DEFAULT NULL,
  `codigoCliente` char(11) DEFAULT NULL,
  `fechaPago` date DEFAULT NULL,
  `direccion` char(200) DEFAULT NULL,
  `direccion2` char(200) DEFAULT NULL,
  `idColonia` char(8) DEFAULT NULL,
  `idDepartamento` char(2) DEFAULT NULL,
  `idMunicipio` char(4) DEFAULT NULL,
  `fechaOrdenoTraslado` date DEFAULT NULL,
  `saldo` decimal(12,2) DEFAULT NULL,
  `observaciones` char(200) DEFAULT NULL,
  `hechoPor` char(15) DEFAULT NULL,
  `fechaHora` date DEFAULT NULL,
  `idTecnico` char(3) DEFAULT NULL,
  `fechaTraslado` date DEFAULT NULL,
  `fechaElaborada` date DEFAULT NULL,
  `telefono` char(30) DEFAULT NULL,
  `codTap` char(10) DEFAULT NULL,
  `numTap` char(10) DEFAULT NULL,
  `numeroSalida` char(10) DEFAULT NULL,
  `ejecutada` int(11) DEFAULT NULL,
  `fechaProgramacion` date DEFAULT NULL,
  `internet` char(1) DEFAULT NULL,
  `cable` char(1) DEFAULT NULL,
  `telefonia` char(1) DEFAULT NULL,
  `mac` char(25) DEFAULT NULL,
  `serie` char(25) DEFAULT NULL,
  `idVelocidad` char(11) DEFAULT NULL,
  `saldoInter` decimal(11,2) DEFAULT NULL,
  `colilla` char(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-11-29 16:12:41
