-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-08-2019 a las 17:18:40
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `satpro`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cargos`
--

CREATE TABLE `tbl_cargos` (
  `idFactura` int(11) NOT NULL,
  `numeroFactura` int(11) NOT NULL,
  `tipoFactura` tinyint(1) NOT NULL,
  `numeroRecibo` int(11) NOT NULL,
  `codigoCliente` varchar(6) NOT NULL,
  `cuotaCable` double DEFAULT NULL,
  `cuotaInternet` double DEFAULT NULL,
  `saldoCable` double DEFAULT NULL,
  `saldoInternet` double DEFAULT NULL,
  `fechaCobro` date DEFAULT NULL,
  `fechaFactura` date DEFAULT NULL,
  `fechaVencimiento` date DEFAULT NULL,
  `fechaAbonado` date DEFAULT NULL,
  `mesCargo` varchar(10) DEFAULT '',
  `formaPago` varchar(10) DEFAULT '',
  `tipoServicio` char(1) NOT NULL,
  `estado` varchar(9) DEFAULT '',
  `cargoImpuesto` double NOT NULL,
  `anulada` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_cargos`
--

INSERT INTO `tbl_cargos` (`idFactura`, `numeroFactura`, `tipoFactura`, `numeroRecibo`, `codigoCliente`, `cuotaCable`, `cuotaInternet`, `saldoCable`, `saldoInternet`, `fechaCobro`, `fechaFactura`, `fechaVencimiento`, `fechaAbonado`, `mesCargo`, `formaPago`, `tipoServicio`, `estado`, `cargoImpuesto`, `anulada`) VALUES
(1, 0, 1, 25899, '00028', 13.03, NULL, 13.03, NULL, '2019-02-16', '2019-03-16', '2019-03-24', NULL, '02/2019', '', 'C', 'pendiente', 0.05, 0),
(2, 0, 1, 25899, '00030', 13.03, NULL, 13.03, NULL, '2019-02-16', '2019-03-16', '2019-03-24', NULL, '02/2019', '', 'C', 'pendiente', 0.05, 0),
(3, 0, 1, 25899, '00031', 13.03, NULL, 13.03, NULL, '2019-02-16', '2019-03-16', '2019-03-24', NULL, '02/2019', '', 'C', 'pendiente', 0.05, 0),
(4, 0, 1, 25899, '00037', 13.03, NULL, 13.03, NULL, '2019-02-16', '2019-03-16', '2019-03-24', NULL, '02/2019', '', 'C', 'pendiente', 0.05, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_cargos`
--
ALTER TABLE `tbl_cargos`
  ADD PRIMARY KEY (`idFactura`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_cargos`
--
ALTER TABLE `tbl_cargos`
  MODIFY `idFactura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
