
--
-- Base de datos: `satpro`
--
USE satpro;
DROP TABLE IF EXISTS tbl_ordenes_trabajo;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ordenes_trabajo`
--

CREATE TABLE `tbl_ordenes_trabajo` (
  `idOrdenTrabajo` int(6) ZEROFILL NOT NULL AUTO_INCREMENT,
  `codigoCliente` int(5) ZEROFILL DEFAULT NULL,
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
  `fechaTrabajo` VARCHAR(10) DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `fechaProgramacion` VARCHAR(10) DEFAULT NULL,
  `idTecnico` int(6) DEFAULT NULL,
  `mactv` varchar(25) DEFAULT NULL,
  `coordenadas` varchar(50) DEFAULT NULL,
  `marcaModelo` varchar(25) DEFAULT NULL,
  `tecnologia` varchar(20) DEFAULT NULL,
  `observaciones` varchar(80) DEFAULT NULL,
  `nodo` varchar(20) DEFAULT NULL,
  `idVendedor` int(6) NOT NULL,
  `recepcionTv` varchar(10) DEFAULT NULL,
  `tipoServicio` char(1) NOT NULL,
  `creadoPor` varchar(50) NOT NULL,
  PRIMARY KEY (idOrdenTrabajo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE tbl_ordenes_trabajo AUTO_INCREMENT=1;