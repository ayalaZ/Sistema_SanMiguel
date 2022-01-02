USE satpro;
--
-- Base de datos: `satpro`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_afps`
--
DROP TABLE IF EXISTS tbl_afps;

CREATE TABLE `tbl_afps` (
  `id_afp` int(2) NOT NULL,
  `nombre_afp` varchar(25) DEFAULT NULL,
  `porcentaje_afp` double DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `estado` TINYINT(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_afps`
--

INSERT INTO `tbl_afps` (`id_afp`, `nombre_afp`, `porcentaje_afp`, `fecha`, `estado`) VALUES
(1, 'AFP Confia', 0.0725, '2019-04-26', 1),
(2, 'AFP Crecer', 0.0725, '2019-04-26', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_afps`
--
ALTER TABLE `tbl_afps`
  ADD PRIMARY KEY (`id_afp`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_afps`
--
ALTER TABLE `tbl_afps`
  MODIFY `id_afp` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;