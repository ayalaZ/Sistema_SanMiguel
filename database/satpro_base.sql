-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-01-2019 a las 15:10:23
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.2.12

DROP DATABASE IF EXISTS satpro;
CREATE DATABASE satpro;
USE satpro;

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
-- Estructura de tabla para la tabla `tbl_articulo`
--

CREATE TABLE `tbl_articulo` (
  `IdArticulo` int(11) NOT NULL,
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
  `IdBodega` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_articulo`
--

INSERT INTO `tbl_articulo` (`IdArticulo`, `Codigo`, `NombreArticulo`, `Descripcion`, `Cantidad`, `PrecioCompra`, `PrecioVenta`, `FechaEntrada`, `IdUnidadMedida`, `IdTipoProducto`, `IdSubCategoria`, `IdProveedor`, `IdBodega`) VALUES
(2, '123-01', 'HP ENVY 13', 'Computadora Portatil', 14, 566.9, 600.89, '2018-12-02', 1, 1, 1, 1, 2),
(3, '123-02', 'OMEN X HP', 'Computadora de uso personal portati', 18, 700.9, 800.89, '2018-12-02', 1, 1, 1, 1, 2),
(5, '123-04', 'modem Zyxel 600 ', '--', 10, 80.9, 100.89, '2018-12-02', 1, 1, 3, 1, 1),
(7, '123-01', 'HP ENVY 13', 'Computadora Portatil', 26, 566.9, 600.89, '2018-12-02', 1, 1, 1, 1, 1),
(8, '123-02', 'OMEN X HP', 'Computadora de uso personal', 30, 566.9, 600.89, '2018-12-02', 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_articulosasignados`
--

CREATE TABLE `tbl_articulosasignados` (
  `IdArticulo` int(11) NOT NULL,
  `Codigo` varchar(11) NOT NULL,
  `NombreArticulo` varchar(35) NOT NULL,
  `Responsable` varchar(35) NOT NULL,
  `Unidad` varchar(35) NOT NULL,
  `Descripcion` varchar(35) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `PrecioCompra` double NOT NULL,
  `PrecioVenta` double NOT NULL,
  `FechaEntrada` date NOT NULL,
  `IdUnidadMedida` int(11) NOT NULL,
  `IdTipoProducto` int(11) NOT NULL,
  `IdSubCategoria` int(11) NOT NULL,
  `IdProveedor` int(11) NOT NULL,
  `IdBodega` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_articulosasignados`
--

INSERT INTO `tbl_articulosasignados` (`IdArticulo`, `Codigo`, `NombreArticulo`, `Responsable`, `Unidad`, `Descripcion`, `Cantidad`, `PrecioCompra`, `PrecioVenta`, `FechaEntrada`, `IdUnidadMedida`, `IdTipoProducto`, `IdSubCategoria`, `IdProveedor`, `IdBodega`) VALUES
(2, '123-01', 'HP ENVY 13', 'Depto. Informática', 'Diego Herrera', 'Computadora Portatil', 14, 566.9, 600.89, '2018-12-02', 1, 1, 1, 1, 2),
(3, '123-02', 'OMEN X HP', 'Depto. Informática', 'Diego Herrera', 'Computadora de uso personal portati', 18, 700.9, 800.89, '2018-12-02', 1, 1, 1, 1, 2),
(5, '123-04', 'modem Zyxel 600 ', 'Depto. Informática', 'Diego Herrera', '--', 10, 80.9, 100.89, '2018-12-02', 1, 1, 3, 1, 1),
(7, '123-01', 'HP ENVY 13', 'Depto. Informática', 'Diego Herrera', 'Computadora Portatil', 26, 566.9, 600.89, '2018-12-02', 1, 1, 1, 1, 1),
(8, '123-02', 'OMEN X HP', 'Depto. Informática', 'Diego Herrera', 'Computadora de uso personal', 30, 566.9, 600.89, '2018-12-02', 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_bodega`
--

CREATE TABLE `tbl_bodega` (
  `IdBodega` int(11) NOT NULL,
  `NombreBodega` varchar(25) NOT NULL,
  `Direccion` varchar(25) NOT NULL,
  `State` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_bodega`
--

INSERT INTO `tbl_bodega` (`IdBodega`, `NombreBodega`, `Direccion`, `State`) VALUES
(1, 'Bodega Quelepa', 'Calle el progreso 1', 1),
(2, 'Bodega Santa Maria', '17 av sur', 1),
(3, 'Bodega Santiago De Maria', 'av sur 1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_categoria`
--

CREATE TABLE `tbl_categoria` (
  `IdCategoria` int(11) NOT NULL,
  `NombreCategoria` varchar(20) NOT NULL,
  `state` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_categoria`
--

INSERT INTO `tbl_categoria` (`IdCategoria`, `NombreCategoria`, `state`) VALUES
(1, 'Computadoras', 1),
(2, 'Modems', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_departamento`
--

CREATE TABLE `tbl_departamento` (
  `IdDepartamento` int(11) NOT NULL,
  `Codigo` varchar(100) NOT NULL,
  `NombreDepartamento` varchar(20) NOT NULL,
  `Descripcion` varchar(140) NOT NULL,
  `State` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_departamento`
--

INSERT INTO `tbl_departamento` (`IdDepartamento`, `Codigo`, `NombreDepartamento`, `Descripcion`, `State`) VALUES
(1, '001', 'Administrativo', 'Permisos Generales del Sistema', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_detallereporte`
--

CREATE TABLE `tbl_detallereporte` (
  `IdDetalleReporte` int(11) NOT NULL,
  `IdReporte` int(11) DEFAULT NULL,
  `IdArticulo` int(11) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_detallereporte`
--

INSERT INTO `tbl_detallereporte` (`IdDetalleReporte`, `IdReporte`, `IdArticulo`, `Cantidad`, `state`) VALUES
(1, 1, 2, 4, 2),
(2, 1, 3, 3, 2),
(3, 2, 2, 5, 2),
(4, 2, 3, 5, 2),
(5, 3, 7, 10, 2),
(6, 3, 8, 15, 2),
(7, 4, 2, 2, 2),
(8, 5, 2, 2, 2),
(9, 5, 3, 2, 2),
(10, 6, 2, 1, 2),
(11, 7, 2, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_empleado`
--

CREATE TABLE `tbl_empleado` (
  `IdEmpleado` int(11) NOT NULL,
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
  `state` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_empleado`
--

INSERT INTO `tbl_empleado` (`IdEmpleado`, `Codigo`, `Nombres`, `Apellidos`, `Direccion`, `Dui`, `Nit`, `Isss`, `E_Familiar`, `G_Academico`, `FechaNacimiento`, `Telefono`, `IdReferencia`, `IdUsuario`, `IdDepartamento`, `state`) VALUES
(3, '00-001', 'Franklin Armando', 'Pocasangre Mejia', 'Urb. Cimas de San Bartolo', '123456789', '987654321', '12345', 'Soltero', 'Universidad', '1998-12-03', '73516621', 1, 1, 1, 1),
(4, '00-002', 'Diego Josue', 'Herrera Hernandez', 'sulutan', '123456789', '987654321', '12345', 'Soltero', 'Universidad', '1998-12-03', '73516621', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_proveedor`
--

CREATE TABLE `tbl_proveedor` (
  `IdProveedor` int(11) NOT NULL,
  `Nombre` varchar(25) NOT NULL,
  `Representate` varchar(25) NOT NULL,
  `Telefono` varchar(10) NOT NULL,
  `Correo` varchar(35) NOT NULL,
  `Nrc` varchar(15) NOT NULL,
  `Nit` varchar(18) NOT NULL,
  `Nacionalidad` varchar(25) NOT NULL,
  `state` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_proveedor`
--

INSERT INTO `tbl_proveedor` (`IdProveedor`, `Nombre`, `Representate`, `Telefono`, `Correo`, `Nrc`, `Nit`, `Nacionalidad`, `state`) VALUES
(1, 'HP', 'Carlos Acevedo', '22589696', 'Carlos@hotmail.com', '123456789', '987654321', 'Estadounidense', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_referencia`
--

CREATE TABLE `tbl_referencia` (
  `IdReferencia` int(11) NOT NULL,
  `IdEmpleado` int(11) DEFAULT NULL,
  `Referencia_1` varchar(50) DEFAULT NULL,
  `Telefono_1` varchar(10) DEFAULT NULL,
  `Referencia_2` varchar(50) DEFAULT NULL,
  `Telefono_2` varchar(10) DEFAULT NULL,
  `State` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_referencia`
--

INSERT INTO `tbl_referencia` (`IdReferencia`, `IdEmpleado`, `Referencia_1`, `Telefono_1`, `Referencia_2`, `Telefono_2`, `State`) VALUES
(1, 1, 'Tec.Juan Perez', '22964541', 'Ing.Carlos Campos', '22858986', 1),
(2, 1, 'Tec.Juan Perez', '22964541', 'Ing.Carlos Campos', '22858986', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_reporte`
--

CREATE TABLE `tbl_reporte` (
  `IdReporte` int(11) NOT NULL,
  `IdEmpleadoOrigen` int(11) DEFAULT NULL,
  `FechaOrigen` datetime DEFAULT NULL,
  `IdEmpleadoDestino` int(11) DEFAULT NULL,
  `FechaDestino` datetime DEFAULT NULL,
  `IdBodegaSaliente` int(11) DEFAULT NULL,
  `IdBodegaEntrante` int(11) DEFAULT NULL,
  `Razon` varchar(200) NOT NULL,
  `state` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_reporte`
--

INSERT INTO `tbl_reporte` (`IdReporte`, `IdEmpleadoOrigen`, `FechaOrigen`, `IdEmpleadoDestino`, `FechaDestino`, `IdBodegaSaliente`, `IdBodegaEntrante`, `Razon`, `state`) VALUES
(1, 3, '2019-01-04 10:17:00', 4, '2019-01-04 10:17:00', 2, 1, 'El Encargado Solicito producto', 1),
(2, 3, '2019-01-04 10:19:00', 4, '2019-01-04 10:20:00', 2, 1, 'Producto se ocupara para una instalación', 1),
(3, 3, '2019-01-04 11:25:00', 4, '2019-01-04 11:38:00', 1, 2, 'ASDF', 1),
(4, 3, '2019-01-04 11:31:00', 4, '2019-01-04 04:54:00', 2, 1, 'ASDF', 1),
(5, 3, '2019-01-04 11:33:00', 4, '2019-01-04 11:39:00', 2, 1, 'ASAD', 1),
(6, 3, '2019-01-04 04:57:00', 4, '2019-01-04 04:57:00', 2, 1, 'Movimiento prueba 04042019', 1),
(7, 3, '2019-01-04 05:01:00', 4, '2019-01-07 08:56:00', 2, 1, 'Movimiento Prueba 2', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_subcategoria`
--

CREATE TABLE `tbl_subcategoria` (
  `IdSubCategoria` int(11) NOT NULL,
  `NombreSubCategoria` varchar(25) NOT NULL,
  `IdCategoria` int(11) DEFAULT NULL,
  `State` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_subcategoria`
--

INSERT INTO `tbl_subcategoria` (`IdSubCategoria`, `NombreSubCategoria`, `IdCategoria`, `State`) VALUES
(1, 'Computadoras', 1, 1),
(2, 'Laptos', 1, 1),
(3, 'Modems', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipoproducto`
--

CREATE TABLE `tbl_tipoproducto` (
  `IdTipoProducto` int(11) NOT NULL,
  `NombreTipoProducto` varchar(35) NOT NULL,
  `Abreviatura` varchar(5) NOT NULL,
  `state` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_tipoproducto`
--

INSERT INTO `tbl_tipoproducto` (`IdTipoProducto`, `NombreTipoProducto`, `Abreviatura`, `state`) VALUES
(1, 'Instalaciones ', 'inst', 1),
(2, 'Oficina ', 'ofi', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_unidadmedida`
--

CREATE TABLE `tbl_unidadmedida` (
  `IdUnidadMedida` int(11) NOT NULL,
  `NombreUnidadMedida` varchar(100) NOT NULL,
  `Abreviatura` varchar(5) NOT NULL,
  `state` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_unidadmedida`
--

INSERT INTO `tbl_unidadmedida` (`IdUnidadMedida`, `NombreUnidadMedida`, `Abreviatura`, `state`) VALUES
(1, 'Cantidad ', 'Cant', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuario`
--

CREATE TABLE `tbl_usuario` (
  `IdUsuario` int(11) NOT NULL,
  `Nombres` varchar(35) NOT NULL,
  `Apellidos` varchar(35) NOT NULL,
  `Usuario` varchar(30) NOT NULL,
  `Clave` varchar(25) NOT NULL,
  `Rol` varchar(25) NOT NULL,
  `State` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_usuario`
--

INSERT INTO `tbl_usuario` (`IdUsuario`, `Nombres`, `Apellidos`, `Usuario`, `Clave`, `Rol`, `State`) VALUES
(1, 'Diego Armando', 'Herrera Flores', 'diego', '1', 'administrador', 1),
(2, 'Franklin Armando', 'Guevara Castro', 'frank', '2', 'jefe informatica', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_articulo`
--
ALTER TABLE `tbl_articulo`
  ADD PRIMARY KEY (`IdArticulo`),
  ADD KEY `UnidadM_idx` (`IdUnidadMedida`),
  ADD KEY `SubCate_idx` (`IdSubCategoria`),
  ADD KEY `Proveedor_idx` (`IdProveedor`),
  ADD KEY `Bodega_idx` (`IdBodega`);

--
-- Indices de la tabla `tbl_articulosasignados`
--
ALTER TABLE `tbl_articulosasignados`
  ADD PRIMARY KEY (`IdArticulo`),
  ADD KEY `IdUnidadMedida` (`IdUnidadMedida`),
  ADD KEY `IdTipoProducto` (`IdTipoProducto`),
  ADD KEY `IdSubCategoria` (`IdSubCategoria`),
  ADD KEY `IdProveedor` (`IdProveedor`),
  ADD KEY `IdBodega` (`IdBodega`);

--
-- Indices de la tabla `tbl_bodega`
--
ALTER TABLE `tbl_bodega`
  ADD PRIMARY KEY (`IdBodega`);

--
-- Indices de la tabla `tbl_categoria`
--
ALTER TABLE `tbl_categoria`
  ADD PRIMARY KEY (`IdCategoria`);

--
-- Indices de la tabla `tbl_departamento`
--
ALTER TABLE `tbl_departamento`
  ADD PRIMARY KEY (`IdDepartamento`);

--
-- Indices de la tabla `tbl_detallereporte`
--
ALTER TABLE `tbl_detallereporte`
  ADD PRIMARY KEY (`IdDetalleReporte`),
  ADD KEY `Articulo_idx` (`IdArticulo`),
  ADD KEY `Reporte_idx` (`IdReporte`);

--
-- Indices de la tabla `tbl_empleado`
--
ALTER TABLE `tbl_empleado`
  ADD PRIMARY KEY (`IdEmpleado`),
  ADD KEY `Referencia_idx` (`IdReferencia`),
  ADD KEY `Usuario_idx` (`IdUsuario`),
  ADD KEY `Departamento_idx` (`IdDepartamento`);

--
-- Indices de la tabla `tbl_proveedor`
--
ALTER TABLE `tbl_proveedor`
  ADD PRIMARY KEY (`IdProveedor`);

--
-- Indices de la tabla `tbl_referencia`
--
ALTER TABLE `tbl_referencia`
  ADD PRIMARY KEY (`IdReferencia`);

--
-- Indices de la tabla `tbl_reporte`
--
ALTER TABLE `tbl_reporte`
  ADD PRIMARY KEY (`IdReporte`),
  ADD KEY `Emple_idx` (`IdEmpleadoOrigen`);

--
-- Indices de la tabla `tbl_subcategoria`
--
ALTER TABLE `tbl_subcategoria`
  ADD PRIMARY KEY (`IdSubCategoria`),
  ADD KEY `Cate_idx` (`IdCategoria`);

--
-- Indices de la tabla `tbl_tipoproducto`
--
ALTER TABLE `tbl_tipoproducto`
  ADD PRIMARY KEY (`IdTipoProducto`);

--
-- Indices de la tabla `tbl_unidadmedida`
--
ALTER TABLE `tbl_unidadmedida`
  ADD PRIMARY KEY (`IdUnidadMedida`);

--
-- Indices de la tabla `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  ADD PRIMARY KEY (`IdUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_articulo`
--
ALTER TABLE `tbl_articulo`
  MODIFY `IdArticulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tbl_bodega`
--
ALTER TABLE `tbl_bodega`
  MODIFY `IdBodega` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_categoria`
--
ALTER TABLE `tbl_categoria`
  MODIFY `IdCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_departamento`
--
ALTER TABLE `tbl_departamento`
  MODIFY `IdDepartamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_detallereporte`
--
ALTER TABLE `tbl_detallereporte`
  MODIFY `IdDetalleReporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tbl_empleado`
--
ALTER TABLE `tbl_empleado`
  MODIFY `IdEmpleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_proveedor`
--
ALTER TABLE `tbl_proveedor`
  MODIFY `IdProveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_referencia`
--
ALTER TABLE `tbl_referencia`
  MODIFY `IdReferencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_reporte`
--
ALTER TABLE `tbl_reporte`
  MODIFY `IdReporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tbl_subcategoria`
--
ALTER TABLE `tbl_subcategoria`
  MODIFY `IdSubCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_unidadmedida`
--
ALTER TABLE `tbl_unidadmedida`
  MODIFY `IdUnidadMedida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  MODIFY `IdUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_articulo`
--
ALTER TABLE `tbl_articulo`
  ADD CONSTRAINT `Bodega` FOREIGN KEY (`IdBodega`) REFERENCES `tbl_bodega` (`IdBodega`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Proveedor` FOREIGN KEY (`IdProveedor`) REFERENCES `tbl_proveedor` (`IdProveedor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `SubCate` FOREIGN KEY (`IdSubCategoria`) REFERENCES `tbl_subcategoria` (`IdSubCategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `UnidadM` FOREIGN KEY (`IdUnidadMedida`) REFERENCES `tbl_unidadmedida` (`IdUnidadMedida`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_articulosasignados`
--
ALTER TABLE `tbl_articulosasignados`
  ADD CONSTRAINT `tbl_articulosasignados_ibfk_1` FOREIGN KEY (`IdUnidadMedida`) REFERENCES `tbl_unidadmedida` (`IdUnidadMedida`) ON DELETE NO ACTION,
  ADD CONSTRAINT `tbl_articulosasignados_ibfk_2` FOREIGN KEY (`IdTipoProducto`) REFERENCES `tbl_tipoproducto` (`IdTipoProducto`) ON DELETE NO ACTION,
  ADD CONSTRAINT `tbl_articulosasignados_ibfk_3` FOREIGN KEY (`IdSubCategoria`) REFERENCES `tbl_subcategoria` (`IdSubCategoria`) ON DELETE NO ACTION,
  ADD CONSTRAINT `tbl_articulosasignados_ibfk_4` FOREIGN KEY (`IdProveedor`) REFERENCES `tbl_proveedor` (`IdProveedor`) ON DELETE NO ACTION,
  ADD CONSTRAINT `tbl_articulosasignados_ibfk_5` FOREIGN KEY (`IdBodega`) REFERENCES `tbl_bodega` (`IdBodega`) ON DELETE NO ACTION;

--
-- Filtros para la tabla `tbl_detallereporte`
--
ALTER TABLE `tbl_detallereporte`
  ADD CONSTRAINT `Articulo` FOREIGN KEY (`IdArticulo`) REFERENCES `tbl_articulo` (`IdArticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `reporte` FOREIGN KEY (`IdReporte`) REFERENCES `tbl_reporte` (`IdReporte`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_empleado`
--
ALTER TABLE `tbl_empleado`
  ADD CONSTRAINT `Departamen` FOREIGN KEY (`IdDepartamento`) REFERENCES `tbl_departamento` (`IdDepartamento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Referencia` FOREIGN KEY (`IdReferencia`) REFERENCES `tbl_referencia` (`IdReferencia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Usuario` FOREIGN KEY (`IdUsuario`) REFERENCES `tbl_usuario` (`IdUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_reporte`
--
ALTER TABLE `tbl_reporte`
  ADD CONSTRAINT `Emple` FOREIGN KEY (`IdEmpleadoOrigen`) REFERENCES `tbl_empleado` (`IdEmpleado`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_subcategoria`
--
ALTER TABLE `tbl_subcategoria`
  ADD CONSTRAINT `Cate` FOREIGN KEY (`IdCategoria`) REFERENCES `tbl_categoria` (`IdCategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
