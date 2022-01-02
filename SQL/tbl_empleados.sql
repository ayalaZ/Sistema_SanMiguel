-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-08-2019 a las 16:49:03
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
-- Estructura de tabla para la tabla `tbl_empleados`
--

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
  `IdUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_empleados`
--

INSERT INTO `tbl_empleados` (`id_empleado`, `nombres`, `apellidos`, `nombre_isss`, `sexo`, `municipio`, `departamento`, `direccion`, `telefonos`, `celular`, `numero_nit`, `no_licencia`, `no_documento`, `extendido_en`, `fecha_expedicion`, `no_isss`, `no_nup`, `profesion_oficio`, `lugar_nacimiento`, `nacionalidad`, `estado_civil`, `fecha_nacimiento`, `edad`, `nivel_estudios`, `clase`, `estatura`, `peso`, `tipo_sangre`, `doc_lugarext`, `senales_especiales`, `nombre_padre`, `nombre_madre`, `nombre_conyuge`, `trabajo_conyuge`, `id_centro`, `persona_autorizada`, `id_afp`, `id_banco`, `id_departamento`, `tipo_contratacion`, `id_plaza`, `rol`, `numero_cuenta`, `por_afp`, `aplicar_isss`, `cuota_seguro`, `fecha_ingreso`, `fecha_contratacion`, `salario_ordinario`, `fecha_salario`, `empresa_refer1`, `cargo_refer1`, `jefe_refer1`, `tiempo_refer1`, `motivo_retiro1`, `empresa_refer2`, `cargo_refer2`, `jefe_refer2`, `tiempo_refer2`, `motivo_retiro2`, `nomb_ref_per1`, `tel_ref_per1`, `nomb_ref_per2`, `tel_ref_per2`, `nomb_ref_per3`, `tel_ref_per3`, `nombre_ref_fam1`, `nombre_ref_fam2`, `nombre_ref_fam3`, `paren_ref_fam1`, `paren_ref_fam2`, `paren_ref_fam3`, `direc_ref_fam1`, `direc_ref_fam2`, `direc_ref_fam3`, `benef1`, `parentesco1`, `porce1`, `benef2`, `parentesco2`, `porce2`, `benef3`, `parentesco3`, `porce3`, `benef4`, `parentesco4`, `porce4`, `pro_retiro`, `estado_empleado`, `fecha1`, `fecha2`, `id_cuenta1`, `id_cuenta2`, `id_cuenta3`, `anio_salario`, `salario_primer_semestre`, `renta_primer_semestre`, `salario_segundo_semestre`, `renta_segundo_semestre`, `IdUsuario`) VALUES
(1, 'Diego Armando', 'Herrera Flores', 'Diego Armando Herrera Flores', 1, '0117', '07', 'Barrio la Merced, Usulután', '7022-1905', NULL, '1123-201190-102-6', '15566', '123', 'a', '1999-05-03', '0400899', '123654', 'Ingeniero de Sistemas Informáticos', NULL, 'Salvadoreño', 'Casado', '2019-05-03', 28, 'Universidad', 0, 181, 195, 'AB Positivo', NULL, 'Alto', 'Adán Serrano', 'Yesenia Quintanilla', 'Diana Serrano', 'UES-FMO', 'a', 'a', 1, 1, 3, 0, 2, '4', 0, 0.0725, NULL, 0, '2019-05-08', '2019-05-09', 188.47, '2019-05-12', 'ab', 'ab', 'ab', 'ab', 'ab', 'ab', 'ab', 'ab', 'ab', 'ab', 'ab', 'ab', 'ab', 'ab', 'ab', 'ab', 'ab', 'ab', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_empleados`
--
ALTER TABLE `tbl_empleados`
  ADD PRIMARY KEY (`id_empleado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_empleados`
--
ALTER TABLE `tbl_empleados`
  MODIFY `id_empleado` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
