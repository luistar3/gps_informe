-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 13-10-2021 a las 22:39:39
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `gps_cliente`
--

INSERT INTO `gps_cliente` (`idCliente`, `idPersona`, `idJuridico`, `ultimoPago`, `estado`, `created_at`, `updated_at`) VALUES
(1, 5, NULL, '2021-07-06 00:00:00', 1, '2021-07-30 21:53:03', '0000-00-00 00:00:00'),
(2, NULL, 1, '2021-07-19 00:00:00', 1, '2021-07-19 05:00:00', '0000-00-00 00:00:00'),
(17, NULL, 17, NULL, 1, '2021-08-07 02:21:25', '0000-00-00 00:00:00');

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
  `contrato` mediumtext COLLATE utf8mb4_spanish2_ci,
  `estado` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idContrato`),
  KEY `idCliente` (`idCliente`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `gps_contrato`
--

INSERT INTO `gps_contrato` (`idContrato`, `idCliente`, `fechaInicio`, `fechaFin`, `mensualidad`, `contrato`, `estado`, `created_at`, `updated_at`) VALUES
(22, 2, '2021-10-11', '2022-10-11', '50', NULL, 1, '2021-10-11 23:17:00', '0000-00-00 00:00:00'),
(23, 2, '2021-10-11', '2022-10-11', '50', NULL, 1, '2021-10-12 00:32:44', '0000-00-00 00:00:00'),
(24, 2, '2021-10-11', '2022-10-11', '50', NULL, 1, '2021-10-12 00:43:42', '0000-00-00 00:00:00'),
(25, 2, '2021-10-11', '2022-10-11', '50', NULL, 1, '2021-10-12 00:48:41', '0000-00-00 00:00:00'),
(26, 2, '2021-10-11', '2022-10-11', '50', NULL, 1, '2021-10-12 00:48:59', '0000-00-00 00:00:00'),
(27, 2, '2021-10-11', '2022-10-11', '50', NULL, 1, '2021-10-12 00:51:15', '0000-00-00 00:00:00'),
(28, 2, '2021-10-11', '2022-10-11', '50', NULL, 1, '2021-10-12 00:52:04', '0000-00-00 00:00:00'),
(29, 2, '2021-10-11', '2022-10-11', '50', NULL, 1, '2021-10-12 00:58:25', '0000-00-00 00:00:00'),
(30, 2, '2021-10-11', '2022-10-11', '50', NULL, 1, '2021-10-12 00:59:53', '0000-00-00 00:00:00'),
(31, 2, '2021-10-11', '2022-10-11', '4', NULL, 1, '2021-10-12 01:01:24', '0000-00-00 00:00:00'),
(32, 2, '2021-10-11', '2022-10-11', '4', NULL, 1, '2021-10-12 01:04:20', '0000-00-00 00:00:00'),
(33, 2, '2021-10-11', '2022-10-11', '4', NULL, 1, '2021-10-12 01:06:33', '0000-00-00 00:00:00'),
(34, 2, '2021-10-11', '2022-10-11', '4', NULL, 1, '2021-10-12 01:06:42', '0000-00-00 00:00:00'),
(35, 2, '2021-10-11', '2022-10-11', '4', NULL, 1, '2021-10-12 01:07:06', '0000-00-00 00:00:00'),
(36, 2, '2021-10-11', '2022-10-11', '4', NULL, 1, '2021-10-12 01:08:07', '0000-00-00 00:00:00'),
(37, 2, '2021-10-11', '2022-10-11', '4', NULL, 1, '2021-10-12 01:08:26', '0000-00-00 00:00:00'),
(38, 2, '2021-10-11', '2022-10-11', '4', NULL, 1, '2021-10-12 01:09:29', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_contrato_vehiculo`
--

DROP TABLE IF EXISTS `gps_contrato_vehiculo`;
CREATE TABLE IF NOT EXISTS `gps_contrato_vehiculo` (
  `idContratoVehiculo` bigint(20) NOT NULL AUTO_INCREMENT,
  `idContrato` bigint(20) NOT NULL,
  `idVehiculo` bigint(20) NOT NULL,
  `montoPago` decimal(10,0) NOT NULL,
  `frecuenciaPago` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idContratoVehiculo`),
  KEY `idVehiculo` (`idVehiculo`),
  KEY `idContrato` (`idContrato`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_juridico`
--

DROP TABLE IF EXISTS `gps_juridico`;
CREATE TABLE IF NOT EXISTS `gps_juridico` (
  `idJuridico` bigint(20) NOT NULL AUTO_INCREMENT,
  `razonSocial` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `ruc` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `idRepresentanteLegal` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idJuridico`),
  KEY `idRepresentanteLegal` (`idRepresentanteLegal`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `gps_juridico`
--

INSERT INTO `gps_juridico` (`idJuridico`, `razonSocial`, `ruc`, `correo`, `idRepresentanteLegal`, `created_at`, `updated_at`) VALUES
(1, 'EMPRESA 1', '10713913206', 'EMPRESA1@GMAIL.COM', 3, '2021-08-06 20:14:59', '0000-00-00 00:00:00'),
(2, 'EMPRESA 2', '20713913206', 'EMPRESA2@GMAIL.COM', 4, '2021-07-20 04:20:25', '0000-00-00 00:00:00'),
(17, 'MUNICIPALIDAD DISTRITAL DE POCOLLAY', '20147796987', 'muni@muni.com', 34, '2021-08-07 02:21:25', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_marca_vehiculo`
--

DROP TABLE IF EXISTS `gps_marca_vehiculo`;
CREATE TABLE IF NOT EXISTS `gps_marca_vehiculo` (
  `idMarcaVehiculo` bigint(20) NOT NULL AUTO_INCREMENT,
  `marca` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idMarcaVehiculo`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `gps_marca_vehiculo`
--

INSERT INTO `gps_marca_vehiculo` (`idMarcaVehiculo`, `marca`, `created_at`, `updated_at`) VALUES
(1, 'LEXUS ', '2021-08-07 21:35:13', '0000-00-00 00:00:00'),
(2, 'MAZDA', '2021-08-07 21:35:13', '0000-00-00 00:00:00'),
(3, 'TOYOTA', '2021-08-07 21:36:22', '0000-00-00 00:00:00'),
(4, 'PORSCHE', '2021-08-07 21:36:22', '0000-00-00 00:00:00'),
(5, 'GENESIS', '2021-08-07 21:37:49', '0000-00-00 00:00:00'),
(6, 'HYUNDAI', '2021-08-07 21:37:49', '0000-00-00 00:00:00'),
(7, 'SUBARU', '2021-08-07 21:37:49', '0000-00-00 00:00:00'),
(8, 'DODGE', '2021-08-07 21:37:49', '0000-00-00 00:00:00'),
(9, 'KIA', '2021-08-07 21:37:49', '0000-00-00 00:00:00'),
(10, 'MINI', '2021-08-07 21:37:49', '0000-00-00 00:00:00'),
(11, 'NISSAN', '2021-08-07 21:37:49', '0000-00-00 00:00:00'),
(12, 'HONDA', '2021-08-07 21:37:49', '0000-00-00 00:00:00'),
(13, 'INFINITI', '2021-08-07 21:37:49', '0000-00-00 00:00:00'),
(14, 'AUDI', '2021-08-07 21:37:49', '0000-00-00 00:00:00'),
(15, 'LINCOLN', '2021-08-07 21:38:46', '0000-00-00 00:00:00'),
(16, 'FORD', '2021-08-07 21:38:46', '0000-00-00 00:00:00'),
(17, 'BMW', '2021-08-07 21:38:46', '0000-00-00 00:00:00'),
(18, 'BUICK', '2021-08-07 21:38:46', '0000-00-00 00:00:00'),
(19, 'CHRYSLER', '2021-08-07 21:38:46', '0000-00-00 00:00:00'),
(20, 'MITSUBISHI', '2021-08-07 21:38:46', '0000-00-00 00:00:00'),
(21, 'MERCEDES-BENZ', '2021-08-07 21:38:46', '0000-00-00 00:00:00'),
(22, 'GMC', '2021-08-07 21:38:46', '0000-00-00 00:00:00'),
(24, 'VOLVO', '2021-08-07 21:39:11', '0000-00-00 00:00:00'),
(25, 'CHEVROLET', '2021-08-07 21:39:11', '0000-00-00 00:00:00'),
(26, 'JEEP', '2021-08-07 21:39:27', '0000-00-00 00:00:00'),
(27, 'VOLKSWAGEN', '2021-08-07 21:39:27', '0000-00-00 00:00:00'),
(28, 'ACURA', '2021-08-07 21:39:35', '0000-00-00 00:00:00'),
(29, 'ALFA ROMEO', '2021-08-07 21:39:35', '0000-00-00 00:00:00'),
(30, 'CADILLAC', '2021-08-07 21:39:41', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_modulo`
--

DROP TABLE IF EXISTS `gps_modulo`;
CREATE TABLE IF NOT EXISTS `gps_modulo` (
  `idModulo` int(11) NOT NULL AUTO_INCREMENT,
  `modulo` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `estado` int(11) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idModulo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `gps_modulo`
--

INSERT INTO `gps_modulo` (`idModulo`, `modulo`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'USUARIO', 'USUARIO', 1, '2021-07-06 23:16:33', '0000-00-00 00:00:00'),
(2, 'EMPLEADO', 'EMPLEADO', 1, '2021-07-20 00:23:17', '0000-00-00 00:00:00'),
(3, 'CLIENTE_PUBLICO', 'MODULOS PARA CLIENTES EXTERNOS', 1, '2021-07-06 23:18:02', '0000-00-00 00:00:00'),
(4, 'CONTRATO', 'GESTION DE CONTRATO PARA LOS CLIENTEA', 1, '2021-07-20 01:57:48', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `gps_modulo_rol`
--

INSERT INTO `gps_modulo_rol` (`idModuloRol`, `idModulo`, `idRol`, `estado`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2021-07-06 23:19:10', '0000-00-00 00:00:00'),
(3, 2, 1, 1, '2021-07-20 00:22:40', '0000-00-00 00:00:00'),
(4, 3, 1, 1, '2021-07-20 00:21:27', '0000-00-00 00:00:00'),
(5, 2, 2, 1, '2021-07-06 23:19:23', '0000-00-00 00:00:00'),
(6, 3, 3, 1, '2021-07-06 23:19:27', '0000-00-00 00:00:00'),
(7, 4, 1, 1, '2021-07-20 01:58:07', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_pago`
--

DROP TABLE IF EXISTS `gps_pago`;
CREATE TABLE IF NOT EXISTS `gps_pago` (
  `idPago` bigint(20) NOT NULL AUTO_INCREMENT,
  `idContratoVehiculo` bigint(20) NOT NULL,
  `fechaPago` date DEFAULT NULL,
  `montoPago` decimal(10,0) NOT NULL,
  `montoPagoContratoVehiculo` decimal(10,0) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idPago`),
  KEY `idContratoVehiculo` (`idContratoVehiculo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_persona_natural`
--

DROP TABLE IF EXISTS `gps_persona_natural`;
CREATE TABLE IF NOT EXISTS `gps_persona_natural` (
  `idPersona` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `apellidos` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `dni` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `correo` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idPersona`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `gps_persona_natural`
--

INSERT INTO `gps_persona_natural` (`idPersona`, `nombres`, `apellidos`, `telefono`, `dni`, `direccion`, `correo`, `created_at`, `updated_at`) VALUES
(1, 'LUIS ALFREDO', 'CHAMBILLA LANCHIPA', '900220862', '71391320', 'AV.MIRAFLORES', 'LUISTAR3@GMIAL.COM', '2021-07-20 06:03:32', '0000-00-00 00:00:00'),
(2, 'ANLLY', 'URURI CAUNA', '976818988', '71581515', 'CALLE LIMONEROS', 'CCRANLLY@GMAIL.COM', '2021-07-20 06:03:20', '0000-00-00 00:00:00'),
(3, 'JUNIOR', 'CARDENAZ CONTRERAS', '976818989', '71391817', 'CALLE ACASIA NRO 45 . ALTO ALIANZA', 'JUNIOR@GMAIL.COM', '2021-07-20 06:03:02', '0000-00-00 00:00:00'),
(4, 'CHRISTIAN', 'CALLA CEVALLOZ', '900818988', '71591817', 'CALLE LAS FLORES NRO 145 . NATIVIDAD', 'CHRIS@GMAIL.COM', '2021-07-20 06:03:10', '0000-00-00 00:00:00'),
(5, 'ROGGER ALESSANDRO', 'DIAZ VILLEGAS', '952171718', '71251417', 'ASOC. 24 JUNIO. PUEBLO LIBRE', 'ROGGER@GMAIL.COM', '2021-07-30 21:50:38', '0000-00-00 00:00:00'),
(14, 'CARMEN GUADALUPE', 'GRIMALDO REYES', '952818776', '71585448', 'av miralfore', 'lui@gmail.com', '2021-07-31 04:36:10', '0000-00-00 00:00:00'),
(15, 'MANUEL HERIBERTO', 'CARLOS DAVILA', '952818776', '71817188', 'av miralfore', 'manuel@gmial.com', '2021-07-31 04:53:21', '0000-00-00 00:00:00'),
(16, 'MARGARITA ISABEL', 'HERNANDEZ EGOAVIL', '952181718', '71252624', 'direccion marga', 'lmarga@gmail.com', '2021-07-31 05:14:49', '0000-00-00 00:00:00'),
(17, 'MIRELA FERNANDA', 'LLANQUI TORRES', '958844847', '71584952', 'direccion muni pocollay', 'mirella@gmial.com', '2021-08-02 23:00:19', '0000-00-00 00:00:00'),
(20, 'YESSICA', 'CORNEJO MONTEAGUDO', '958484744', '71391514', 'direccion yessica', 'yesiu@gmial.com', '2021-08-06 19:56:39', '0000-00-00 00:00:00'),
(34, 'ALBERT STEFANO', 'TORRES COLLANTES', '952251415', '71362514', 'alberot@gmia.lcom', 'alberto@gmail.com', '2021-08-07 02:18:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_rol`
--

DROP TABLE IF EXISTS `gps_rol`;
CREATE TABLE IF NOT EXISTS `gps_rol` (
  `idRol` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `estado` int(11) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `gps_rol`
--

INSERT INTO `gps_rol` (`idRol`, `nombre`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'ADMIN', 1, '2021-07-06 23:18:20', '0000-00-00 00:00:00'),
(2, 'EMPLEADO', 1, '2021-07-06 23:18:28', '0000-00-00 00:00:00'),
(3, 'CLIENTE', 1, '2021-07-06 23:18:49', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_usuario`
--

DROP TABLE IF EXISTS `gps_usuario`;
CREATE TABLE IF NOT EXISTS `gps_usuario` (
  `idUsuario` bigint(20) NOT NULL AUTO_INCREMENT,
  `idPersona` bigint(20) NOT NULL,
  `idRol` int(11) NOT NULL,
  `usuario` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `contrasena` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idUsuario`),
  KEY `idPersona` (`idPersona`),
  KEY `idRol` (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `gps_usuario`
--

INSERT INTO `gps_usuario` (`idUsuario`, `idPersona`, `idRol`, `usuario`, `contrasena`, `estado`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'ADMIN', '', 1, '2021-07-06 23:22:01', '0000-00-00 00:00:00'),
(2, 2, 2, 'ANLLY', '', 1, '2021-07-20 00:19:32', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_vehiculo`
--

DROP TABLE IF EXISTS `gps_vehiculo`;
CREATE TABLE IF NOT EXISTS `gps_vehiculo` (
  `idVehiculo` bigint(20) NOT NULL AUTO_INCREMENT,
  `idMarcaVehiculo` bigint(20) NOT NULL,
  `placa` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `modelo` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `anio` int(11) DEFAULT NULL,
  `gps` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `imei` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fechaInstalacion` date DEFAULT NULL,
  `estado` int(11) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idVehiculo`),
  KEY `idMarcaVehiculo` (`idMarcaVehiculo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `gps_vehiculo`
--

INSERT INTO `gps_vehiculo` (`idVehiculo`, `idMarcaVehiculo`, `placa`, `modelo`, `anio`, `gps`, `imei`, `fechaInstalacion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 28, 'asd-234', '', NULL, '', '', '0000-00-00', 1, '2021-10-12 00:48:41', '0000-00-00 00:00:00'),
(2, 28, 'asd-234', '', NULL, '', '', '0000-00-00', 1, '2021-10-12 00:48:59', '0000-00-00 00:00:00'),
(3, 28, 'asd-256', 'masda', 2020, 'cobna', '321651356556', '2021-10-30', 1, '2021-10-12 01:07:06', '0000-00-00 00:00:00'),
(4, 28, 'asd-256', 'masda', 2020, 'cobna', '321651356556', '2021-10-30', 1, '2021-10-12 01:08:07', '0000-00-00 00:00:00'),
(5, 28, 'asd-256', 'masda', 2020, 'cobna', '321651356556', '2021-10-30', 1, '2021-10-12 01:08:26', '0000-00-00 00:00:00'),
(6, 28, 'asd-256', 'masda', 2020, 'cobna', '321651356556', '2021-10-30', 1, '2021-10-12 01:09:29', '0000-00-00 00:00:00');

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
-- Filtros para la tabla `gps_contrato_vehiculo`
--
ALTER TABLE `gps_contrato_vehiculo`
  ADD CONSTRAINT `gps_contrato_vehiculo_ibfk_1` FOREIGN KEY (`idContrato`) REFERENCES `gps_contrato` (`idContrato`),
  ADD CONSTRAINT `gps_contrato_vehiculo_ibfk_2` FOREIGN KEY (`idVehiculo`) REFERENCES `gps_vehiculo` (`idVehiculo`);

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
-- Filtros para la tabla `gps_pago`
--
ALTER TABLE `gps_pago`
  ADD CONSTRAINT `gps_pago_ibfk_1` FOREIGN KEY (`idContratoVehiculo`) REFERENCES `gps_contrato_vehiculo` (`idContratoVehiculo`);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
