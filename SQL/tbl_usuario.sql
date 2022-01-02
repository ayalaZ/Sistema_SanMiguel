
--
-- Base de datos: `satpro`
--
USE satpro;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuario`
--
DROP TABLE IF EXISTS tbl_usuario;

CREATE TABLE `tbl_usuario` (
  `idUsuario` int(4) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(70) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `clave` varchar(70) NOT NULL,
  `rol` varchar(25) NOT NULL,
  `state` tinyint(2) DEFAULT NULL,
  PRIMARY KEY(idUsuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_usuario`
--

INSERT INTO `tbl_usuario` (`idUsuario`, nombre, `usuario`, `clave`, `rol`, `state`) VALUES
(1, 'Diego Armando Herrera Flores', 'diego', '$2y$10$LKAHJo0V/XOhNZO9vAsDvemknDGdS2magNP8GJVOP6LyuHc.bvgaC', 'administracion', 1);

--
-- Índices para tablas volcadas
--
ALTER TABLE tbl_usuario AUTO_INCREMENT = 2;