
-- Base de datos: `satpro`
--
USE satpro;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_permisosglobal`
--
DROP TABLE IF EXISTS tbl_permisosglobal;

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
  `IdUsuario` int(11) NOT NULL,
  PRIMARY KEY(IdPermisosGlobal),
  FOREIGN KEY(IdUsuario) REFERENCES tbl_usuario(idUsuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_permisosglobal`
--

INSERT INTO `tbl_permisosglobal` (`IdPermisosGlobal`, `Madmin`, `Mcont`, `Mplan`, `Macti`, `Minve`, `Miva`, `Mbanc`, `Mcxc`, `Mcxp`, `Ag`, `Ed`, `El`, `IdUsuario`) VALUES
(1, 1, 2, 4, 8, 16, 32, 64, 128, 256, 0, 0, 4, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_permisosglobal`
--
/*ALTER TABLE `tbl_permisosglobal`
  ADD PRIMARY KEY (`IdPermisosGlobal`),
  ADD KEY `IdUsuario` (`IdUsuario`);
COMMIT;*/

