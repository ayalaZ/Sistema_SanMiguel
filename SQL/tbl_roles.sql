-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-11-2019 a las 22:20:15
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
USE satpro;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_roles`
--
DROP TABLE IF EXISTS tbl_roles;
CREATE TABLE `tbl_roles` (
  `idRol` int(2) NOT NULL,
  `nombreRol` varchar(30) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_roles`
--

INSERT INTO `tbl_roles` (`idRol`, `nombreRol`, `descripcion`) VALUES
(1, 'Administración', NULL),
(2, 'Subgerencia', NULL),
(3, 'Jefatura', NULL),
(4, 'Informática', NULL),
(5, 'Contabilidad', NULL),
(6, 'Atencion', NULL),
(7, 'Técnico', NULL),
(8, 'Vendedor', NULL),
(9, 'Cobrador', NULL),
(10, 'Mantenimiento', NULL),
(11, 'Seguridad', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`idRol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
