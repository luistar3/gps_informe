--
-- Base de datos: `gpstel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_cliente`
--

DROP TABLE IF EXISTS `gps_cliente`;
CREATE TABLE IF NOT EXISTS `gps_cliente` (
  `idCliente` bigint(20) NOT NULL AUTO_INCREMENT,
  `idPersona` bigint(20) DEFAULT NULL,
  `idJuridico` bigint(20) DEFAULT NULL,
  `ultimoPago` datetime DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idCliente`),
  KEY `idPersona` (`idPersona`),
  KEY `idJuridico` (`idJuridico`)
) 

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_contrato`
--

DROP TABLE IF EXISTS `gps_contrato`;
CREATE TABLE IF NOT EXISTS `gps_contrato` (
  `idContrato` bigint(20) NOT NULL AUTO_INCREMENT,
  `idCliente` bigint(20) NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaFin` date NOT NULL,
  `mensualidad` decimal(10,0) NOT NULL,
  `contrato` text,
  `estado` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idContrato`),
  KEY `idCliente` (`idCliente`)
) 

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_juridico`
--

DROP TABLE IF EXISTS `gps_juridico`;
CREATE TABLE IF NOT EXISTS `gps_juridico` (
  `idJuridico` bigint(20) NOT NULL AUTO_INCREMENT,
  `razonSocial` varchar(255) NOT NULL,
  `ruc` varchar(255) NOT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `idRepresentanteLegal` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idJuridico`),
  KEY `idRepresentanteLegal` (`idRepresentanteLegal`)
) 

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_modulo`
--

DROP TABLE IF EXISTS `gps_modulo`;
CREATE TABLE IF NOT EXISTS `gps_modulo` (
  `idModulo` int(11) NOT NULL AUTO_INCREMENT,
  `modulo` varchar(255) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `estado` int(11) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idModulo`)
) 

--
-- Volcado de datos para la tabla `gps_modulo`
--

INSERT INTO `gps_modulo` (`idModulo`, `modulo`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'USUARIO', 'USUARIO', 1, '2021-07-06 18:16:33', '0000-00-00 00:00:00'),
(2, 'EMPLEADO', 'EMPLEADO', 1, '2021-07-06 18:17:43', '0000-00-00 00:00:00'),
(3, 'CLIENTE_PUBLICO', 'MODULOS PARA CLIENTES EXTERNOS', 1, '2021-07-06 18:18:02', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_modulo_rol`
--

DROP TABLE IF EXISTS `gps_modulo_rol`;
CREATE TABLE IF NOT EXISTS `gps_modulo_rol` (
  `idModuloRol` int(11) NOT NULL AUTO_INCREMENT,
  `idModulo` int(11) NOT NULL,
  `idRol` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idModuloRol`),
  KEY `idModulo` (`idModulo`),
  KEY `idRol` (`idRol`)
) 

--
-- Volcado de datos para la tabla `gps_modulo_rol`
--

INSERT INTO `gps_modulo_rol` (`idModuloRol`, `idModulo`, `idRol`, `estado`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2021-07-06 18:19:10', '0000-00-00 00:00:00'),
(3, 1, 2, 1, '2021-07-06 18:19:14', '0000-00-00 00:00:00'),
(4, 1, 3, 1, '2021-07-06 18:19:18', '0000-00-00 00:00:00'),
(5, 2, 2, 1, '2021-07-06 18:19:23', '0000-00-00 00:00:00'),
(6, 3, 3, 1, '2021-07-06 18:19:27', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_persona_natural`
--

DROP TABLE IF EXISTS `gps_persona_natural`;
CREATE TABLE IF NOT EXISTS `gps_persona_natural` (
  `idPersona` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(255) DEFAULT NULL,
  `apellidos` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `dni` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idPersona`)
) 

--
-- Volcado de datos para la tabla `gps_persona_natural`
--

INSERT INTO `gps_persona_natural` (`idPersona`, `nombres`, `apellidos`, `telefono`, `dni`, `direccion`, `correo`, `created_at`, `updated_at`) VALUES
(1, 'LUIS', 'CHAMBILLA', '900220862', '71391320', 'AV.MIRAFLORES', 'LUISTAR3@GMIAL.COM', '2021-07-06 18:20:40', '0000-00-00 00:00:00'),
(2, 'ANLLY', 'URURI', '976818988', '71581515', 'CALLE LIMONEROS', 'CCRANLLY@GMAIL.COM', '2021-07-07 22:09:12', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_rol`
--

DROP TABLE IF EXISTS `gps_rol`;
CREATE TABLE IF NOT EXISTS `gps_rol` (
  `idRol` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `estado` int(11) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idRol`)
) 

--
-- Volcado de datos para la tabla `gps_rol`
--

INSERT INTO `gps_rol` (`idRol`, `nombre`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'ADMIN', 1, '2021-07-06 18:18:20', '0000-00-00 00:00:00'),
(2, 'EMPLEADO', 1, '2021-07-06 18:18:28', '0000-00-00 00:00:00'),
(3, 'CLIENTE', 1, '2021-07-06 18:18:49', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_usuario`
--

DROP TABLE IF EXISTS `gps_usuario`;
CREATE TABLE IF NOT EXISTS `gps_usuario` (
  `idUsuario` bigint(20) NOT NULL AUTO_INCREMENT,
  `idPersona` bigint(20) NOT NULL,
  `idRol` int(11) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idUsuario`),
  KEY `idPersona` (`idPersona`),
  KEY `idRol` (`idRol`)
) 

--
-- Volcado de datos para la tabla `gps_usuario`
--

INSERT INTO `gps_usuario` (`idUsuario`, `idPersona`, `idRol`, `usuario`, `contrasena`, `estado`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'ADMIN', '', 1, '2021-07-06 18:22:01', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_vehiculo`
--

DROP TABLE IF EXISTS `gps_vehiculo`;
CREATE TABLE IF NOT EXISTS `gps_vehiculo` (
  `idVehiculo` bigint(20) NOT NULL AUTO_INCREMENT,
  `idMarcaVehiculo` bigint(20) NOT NULL,
  `placa` varchar(255) NOT NULL,
  `modelo` varchar(255) DEFAULT NULL,
  `anio` int(11) DEFAULT NULL,
  `gps` varchar(255) NOT NULL,
  `imei` varchar(255) NOT NULL,
  `fechaInstalacion` date DEFAULT NULL,
  `estado` int(11) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idVehiculo`),  
  KEY `idMarcaVehiculo` (`idMarcaVehiculo`)
)

--
-- Estructura de tabla para la tabla `gps_marca_vehiculo`
--

DROP TABLE IF EXISTS `gps_marca_vehiculo`;
CREATE TABLE IF NOT EXISTS `gps_marca_vehiculo` (
  `idMarcaVehiculo` bigint(20) NOT NULL AUTO_INCREMENT,
  `marca` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idMarcaVehiculo`)
)


--
-- Estructura de tabla para la tabla `gps_contrato_vehiculo`
--
DROP TABLE IF EXISTS `gps_contrato_vehiculo`;
CREATE TABLE IF NOT EXISTS `gps_contrato_vehiculo` (
  `idContratoVehiculo` bigint(20) NOT NULL AUTO_INCREMENT,
  `idContrato` bigint(20) NOT NULL,
  `idVehiculo` bigint(20) NOT NULL,
  `montoPago` decimal(10,0) NOT NULL,
  `frecuenciaPago` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idMarcaVehiculo`),
  KEY `idVehiculo` (`idVehiculo`),
  KEY `idContrato` (`idContrato`)
)

--
-- Estructura de tabla para la tabla `gps_pago`
--
DROP TABLE IF EXISTS `gps_pago`;
CREATE TABLE IF NOT EXISTS `gps_pago` (
  `idPago` bigint(20) NOT NULL AUTO_INCREMENT,
  `idContratoVehiculo` bigint(20) NOT NULL,
  `fechaPago` date DEFAULT NULL,
  `montoPago` decimal(10,0) NOT NULL,
  `montoPagoPevisto` decimal(10,0) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idMarcaVehiculo`),
  KEY `idContratoVehiculo` (`idContratoVehiculo`)
)


--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `gps_cliente`
--
ALTER TABLE `gps_cliente`
  ADD CONSTRAINT `gps_cliente_ibfk_1` FOREIGN KEY (`idPersona`) REFERENCES `gps_persona_natural` (`idPersona`),
  ADD CONSTRAINT `gps_cliente_ibfk_2` FOREIGN KEY (`idJuridico`) REFERENCES `gps_juridico` (`idJuridico`);

--
-- Filtros para la tabla `gps_contrato`
--
ALTER TABLE `gps_contrato`
  ADD CONSTRAINT `gps_contrato_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `gps_cliente` (`idCliente`);

--
-- Filtros para la tabla `gps_juridico`
--
ALTER TABLE `gps_juridico`
  ADD CONSTRAINT `gps_juridico_ibfk_1` FOREIGN KEY (`idRepresentanteLegal`) REFERENCES `gps_persona_natural` (`idPersona`);

--
-- Filtros para la tabla `gps_modulo_rol`
--
ALTER TABLE `gps_modulo_rol`
  ADD CONSTRAINT `gps_modulo_rol_ibfk_1` FOREIGN KEY (`idModulo`) REFERENCES `gps_modulo` (`idModulo`),
  ADD CONSTRAINT `gps_modulo_rol_ibfk_2` FOREIGN KEY (`idRol`) REFERENCES `gps_rol` (`idRol`);

--
-- Filtros para la tabla `gps_usuario`
--
ALTER TABLE `gps_usuario`
  ADD CONSTRAINT `gps_usuario_ibfk_1` FOREIGN KEY (`idPersona`) REFERENCES `gps_persona_natural` (`idPersona`),
  ADD CONSTRAINT `gps_usuario_ibfk_2` FOREIGN KEY (`idRol`) REFERENCES `gps_rol` (`idRol`);

--
-- Filtros para la tabla `gps_vehiculo`
--
ALTER TABLE `gps_vehiculo`
  ADD CONSTRAINT `gps_vehiculo_ibfk_1` FOREIGN KEY (`idMarcaVehiculo`) REFERENCES `gps_marca_vehiculo` (`idMarcaVehiculo`);

--
-- Filtros para la tabla `gps_contrato_vehiculo`
--
ALTER TABLE `gps_contrato_vehiculo`
  ADD CONSTRAINT `gps_contrato_vehiculo_ibfk_1` FOREIGN KEY (`idContrato`) REFERENCES `gps_contrato` (`idContrato`);
  ADD CONSTRAINT `gps_contrato_vehiculo_ibfk_2` FOREIGN KEY (`idVehiculo`) REFERENCES `gps_vehiculo` (`idVehiculo`);

  --
-- Filtros para la tabla `gps_pago`
--
ALTER TABLE `gps_pago`
  ADD CONSTRAINT `gps_contrato_vehiculo_ibfk_1` FOREIGN KEY (`idContratoVehiculo`) REFERENCES `gps_contrato_vehiculo` (`idContratoVehiculo`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
