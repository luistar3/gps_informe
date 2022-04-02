-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-04-2022 a las 20:19:58
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 7.3.31

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

CREATE TABLE `gps_cliente` (
  `idCliente` bigint(20) NOT NULL,
  `idPersona` bigint(20) DEFAULT NULL,
  `idJuridico` bigint(20) DEFAULT NULL,
  `ultimoPago` datetime DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `gps_cliente`
--

INSERT INTO `gps_cliente` (`idCliente`, `idPersona`, `idJuridico`, `ultimoPago`, `estado`, `created_at`, `updated_at`) VALUES
(1, 5, NULL, '2021-07-06 00:00:00', 1, '2021-07-30 21:53:03', '0000-00-00 00:00:00'),
(2, NULL, 1, '2021-07-19 00:00:00', 1, '2021-07-19 05:00:00', '0000-00-00 00:00:00'),
(17, NULL, 17, NULL, 1, '2021-08-07 02:21:25', '0000-00-00 00:00:00'),
(18, NULL, 18, NULL, 1, '2021-10-29 04:40:57', '0000-00-00 00:00:00'),
(19, NULL, 19, NULL, 1, '2021-10-29 05:00:02', '0000-00-00 00:00:00'),
(20, NULL, 20, NULL, 1, '2021-10-29 05:12:19', '0000-00-00 00:00:00'),
(21, NULL, 21, NULL, 1, '2021-10-29 05:22:44', '0000-00-00 00:00:00'),
(22, 1, NULL, NULL, 1, '2021-11-06 20:51:49', '0000-00-00 00:00:00'),
(23, 35, NULL, NULL, 1, '2021-12-29 04:56:35', '0000-00-00 00:00:00'),
(37, 2, NULL, NULL, 1, '2022-01-15 19:09:13', '0000-00-00 00:00:00'),
(38, 3, NULL, NULL, 1, '2022-01-15 19:09:30', '0000-00-00 00:00:00'),
(39, 4, NULL, NULL, 1, '2022-03-06 02:02:02', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_contrato`
--

CREATE TABLE `gps_contrato` (
  `idContrato` bigint(20) NOT NULL,
  `idCliente` bigint(20) NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaFin` date NOT NULL,
  `mensualidad` decimal(10,0) NOT NULL,
  `contrato` mediumtext COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `gps_contrato`
--

INSERT INTO `gps_contrato` (`idContrato`, `idCliente`, `fechaInicio`, `fechaFin`, `mensualidad`, `contrato`, `estado`, `created_at`, `updated_at`) VALUES
(1, 21, '2021-11-02', '2021-12-03', '50', 'asd.pdf', 0, '2021-12-04 18:25:58', '0000-00-00 00:00:00'),
(2, 21, '2021-11-02', '2022-11-02', '50', NULL, 1, '2021-11-03 01:04:28', '0000-00-00 00:00:00'),
(3, 21, '2021-11-02', '2022-11-02', '50', NULL, 1, '2021-11-03 02:55:21', '0000-00-00 00:00:00'),
(4, 21, '2021-11-02', '2022-11-02', '50', NULL, 1, '2021-11-03 02:55:52', '0000-00-00 00:00:00'),
(5, 21, '2021-11-02', '2022-11-02', '50', NULL, 1, '2021-11-03 02:59:03', '0000-00-00 00:00:00'),
(6, 21, '2021-11-02', '2022-11-02', '50', NULL, 1, '2021-11-03 02:59:09', '0000-00-00 00:00:00'),
(7, 21, '2021-11-02', '2022-11-02', '50', NULL, 1, '2021-11-03 02:59:15', '0000-00-00 00:00:00'),
(8, 21, '2021-11-02', '2022-11-02', '50', NULL, 1, '2021-11-03 02:59:24', '0000-00-00 00:00:00'),
(9, 21, '2021-11-02', '2022-11-02', '50', NULL, 1, '2021-11-03 02:59:52', '0000-00-00 00:00:00'),
(10, 21, '2021-11-02', '2022-11-02', '50', NULL, 1, '2021-11-03 03:01:36', '0000-00-00 00:00:00'),
(11, 21, '2021-11-02', '2022-11-02', '50', NULL, 1, '2021-11-03 03:25:26', '0000-00-00 00:00:00'),
(12, 21, '2021-11-02', '2022-11-02', '50', NULL, 1, '2021-11-03 03:27:17', '0000-00-00 00:00:00'),
(13, 21, '2021-11-02', '2022-11-02', '50', NULL, 1, '2021-11-03 03:27:44', '0000-00-00 00:00:00'),
(14, 21, '2021-11-02', '2022-11-02', '50', NULL, 1, '2021-11-03 03:28:19', '0000-00-00 00:00:00'),
(15, 21, '2021-11-02', '2022-11-02', '50', NULL, 1, '2021-11-03 03:29:10', '0000-00-00 00:00:00'),
(16, 21, '2021-11-02', '2022-11-02', '50', NULL, 1, '2021-11-03 03:30:06', '0000-00-00 00:00:00'),
(17, 21, '2021-11-02', '2022-11-02', '50', NULL, 1, '2021-11-03 03:30:30', '0000-00-00 00:00:00'),
(18, 21, '2021-11-02', '2022-11-02', '50', NULL, 1, '2021-11-03 03:34:42', '0000-00-00 00:00:00'),
(19, 21, '2021-11-02', '2022-11-02', '50', '../../archivos/contratos/pdf_TRICOTA letra dynamite.pdf_61b41fd899056_2539.pdf', 1, '2021-12-11 03:49:44', '2021-12-11 03:49:44'),
(20, 21, '2021-11-02', '2022-11-02', '50', '../../archivos/contratos/pdf_TRICOTA_V2.pdf_61b41f8678fc6_3887.pdf', 1, '2021-12-11 03:48:22', '2021-12-11 03:48:22'),
(21, 21, '2021-11-02', '2022-11-02', '50', '../../archivos/contratos/pdf_TRICOTA_V2.pdf_61b420108a3a2_4629.pdf', 1, '2021-12-11 03:50:40', '2021-12-11 03:50:40'),
(22, 17, '2021-11-02', '2022-11-02', '20', '../../archivos/contratos/pdf_TRICOTA_corel_2020.pdf_61e31c82af9d3_4743.pdf', 1, '2022-01-15 19:12:02', '2022-01-15 19:12:02'),
(23, 17, '2021-11-02', '2022-11-02', '20', NULL, 1, '2021-11-03 03:45:16', '0000-00-00 00:00:00'),
(24, 17, '2021-11-02', '2022-11-02', '20', NULL, 1, '2021-11-03 03:45:19', '0000-00-00 00:00:00'),
(25, 17, '2021-11-02', '2022-11-02', '20', NULL, 1, '2021-11-03 03:46:12', '0000-00-00 00:00:00'),
(26, 17, '2021-11-02', '2025-11-02', '50', NULL, 1, '2021-11-03 03:51:20', '0000-00-00 00:00:00'),
(27, 22, '2021-11-06', '2022-07-01', '35', '../../archivos/contratos/pdf_TRICOTA_V2.pdf_61b6ba4b17a6f_566.pdf', 1, '2021-12-13 03:13:15', '2021-12-13 03:13:15'),
(28, 17, '2021-12-06', '2022-12-06', '120', NULL, 1, '2021-12-07 00:54:15', '0000-00-00 00:00:00'),
(29, 22, '2021-12-06', '2022-12-06', '120', '../../archivos/contratos/pdf_TRICOTA letra dynamite.pdf_61bd67c309cb3_3757.pdf', 1, '2021-12-18 04:46:59', '2021-12-18 04:46:59'),
(30, 18, '2021-12-14', '2022-12-14', '50', '../../archivos/contratos/pdf_TRICOTA.pdf_61c8f17b57cc4_3931.pdf', 1, '2021-12-26 22:49:31', '2021-12-26 22:49:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_contrato_vehiculo`
--

CREATE TABLE `gps_contrato_vehiculo` (
  `idContratoVehiculo` bigint(20) NOT NULL,
  `idContrato` bigint(20) NOT NULL,
  `idVehiculo` bigint(20) NOT NULL,
  `montoPago` decimal(10,0) NOT NULL,
  `frecuenciaPago` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fechaInstalacion` date NOT NULL,
  `fechaTermino` date DEFAULT NULL,
  `estado` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `gps_contrato_vehiculo`
--

INSERT INTO `gps_contrato_vehiculo` (`idContratoVehiculo`, `idContrato`, `idVehiculo`, `montoPago`, `frecuenciaPago`, `fechaInstalacion`, `fechaTermino`, `estado`, `created_at`, `updated_at`) VALUES
(1, 18, 1, '10', '3', '2021-11-17', NULL, 1, '2021-11-03 03:36:26', NULL),
(2, 18, 2, '20', '2', '2021-11-05', NULL, 1, '2021-11-03 03:36:59', NULL),
(3, 18, 3, '30', '2', '2021-11-16', NULL, 1, '2021-11-03 03:37:00', NULL),
(4, 19, 1, '10', '3', '2021-11-17', NULL, 1, '2021-11-03 03:38:25', NULL),
(5, 19, 2, '20', '2', '2021-11-05', NULL, 1, '2021-11-03 03:38:25', NULL),
(6, 19, 3, '30', '2', '2021-11-16', NULL, 1, '2021-11-03 03:38:26', NULL),
(7, 20, 1, '10', '3', '2021-11-17', NULL, 1, '2021-11-03 03:41:08', NULL),
(8, 20, 2, '20', '2', '2021-11-05', NULL, 1, '2021-11-03 03:41:10', NULL),
(9, 20, 3, '30', '2', '2021-11-16', NULL, 1, '2021-11-03 03:41:12', NULL),
(10, 21, 1, '10', '3', '2021-11-17', NULL, 1, '2021-11-03 03:41:23', NULL),
(11, 21, 2, '20', '2', '2021-11-05', NULL, 1, '2021-11-03 03:41:23', NULL),
(12, 21, 3, '30', '2', '2021-11-16', NULL, 1, '2021-11-03 03:41:23', NULL),
(13, 22, 1, '30', '3', '2021-11-10', NULL, 0, '2022-02-17 02:33:49', NULL),
(14, 23, 1, '30', '3', '2021-11-10', NULL, 0, '2022-01-15 19:14:12', NULL),
(15, 24, 1, '30', '3', '2021-11-10', NULL, 1, '2021-11-03 03:45:19', NULL),
(16, 25, 2, '30', '3', '2021-11-10', NULL, 1, '2021-11-03 03:46:12', NULL),
(17, 26, 1, '10', '3', '2021-11-23', NULL, 1, '2021-11-03 03:51:20', NULL),
(18, 27, 4, '30', '1', '2021-11-08', '2021-12-31', 1, '2021-12-18 06:34:07', '2021-12-18 00:21:18'),
(23, 27, 3, '12', '1', '2021-12-04', '2022-02-24', 1, '2021-12-18 00:21:36', '2021-12-18 00:21:36'),
(24, 30, 6, '10', '1', '2021-12-17', '0000-00-00', 1, '2021-12-14 05:11:02', NULL),
(25, 30, 1, '15', '1', '2021-12-22', '0000-00-00', 1, '2021-12-14 05:11:02', NULL),
(26, 30, 7, '30', '6', '2021-12-23', '0000-00-00', 1, '2021-12-14 05:11:02', NULL),
(27, 27, 2, '25', '6', '2021-12-17', '2022-02-17', 1, '2021-12-18 07:00:36', '2021-12-18 00:21:50'),
(29, 2, 1, '30', '1', '2021-12-28', '2022-06-28', 1, '2021-12-29 03:19:25', NULL),
(30, 23, 3, '20', '1', '2022-01-15', '0000-00-00', 1, '2022-01-15 19:13:51', NULL),
(31, 23, 1, '20', '1', '2022-01-15', '0000-00-00', 1, '2022-01-15 19:14:24', NULL),
(32, 29, 1, '100', '1', '2022-02-16', '2022-05-16', 1, '2022-02-17 02:33:23', NULL),
(33, 22, 1, '100', '1', '2022-02-16', '2022-04-16', 1, '2022-02-17 02:34:14', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_juridico`
--

CREATE TABLE `gps_juridico` (
  `idJuridico` bigint(20) NOT NULL,
  `razonSocial` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `ruc` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `idRepresentanteLegal` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `gps_juridico`
--

INSERT INTO `gps_juridico` (`idJuridico`, `razonSocial`, `ruc`, `correo`, `idRepresentanteLegal`, `created_at`, `updated_at`) VALUES
(1, 'EMPRESA 1', '10713913206', 'EMPRESA11@GMAIL.COM', 5, '2021-12-28 03:45:54', '2021-12-28 03:45:54'),
(2, 'EMPRESA 2', '20713913206', 'EMPRESA2@GMAIL.COM', 5, '2021-12-27 05:22:54', '2021-12-27 05:22:54'),
(17, 'MUNICIPALIDAD DISTRITAL DE POCOLLAY', '20147796987', 'muni@muni.com', 34, '2021-08-07 02:21:25', '0000-00-00 00:00:00'),
(18, 'URURI CAUNA ANLLY LARISA', '10478602257', 'anlly@gmail.com', 35, '2021-12-27 05:29:55', '2021-12-27 05:29:55'),
(19, 'AGROINDUSTRIA CASABLANCA S.A.C.', '20452302951', 'casa@empresa.com', 36, '2021-12-27 05:31:36', '2021-12-27 05:31:36'),
(20, 'ENT.PREST.SERVICIOS DE SANEAMIENTO TACNA S.A.', '20134052989', 'epsnuerv@eps.com', 37, '2021-12-28 03:45:47', '2021-12-28 03:45:47'),
(21, 'UNIVERSIDAD PRIVADA DE TACNA', '20119917698', 'upt@upt.edu.pe', 38, '2021-12-27 05:28:11', '2021-12-27 05:28:11'),
(25, 'MUNICIPALIDAD DISTRITAL DE PACHIA', '20142438365', 'pachia@gmial.com', 3, '2021-12-27 05:31:28', '2021-12-27 05:31:28'),
(26, 'MUNICIPALIDAD DISTRITAL DE MIRAFLORES', '20131377224', 'miralofres', 4, '2021-12-27 05:30:41', '0000-00-00 00:00:00'),
(27, 'CLINICA LA LUZ S.A.C.', '20537489295', 'hilda_emrpesa@hilda.com', 47, '2021-12-27 05:44:40', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_marca_vehiculo`
--

CREATE TABLE `gps_marca_vehiculo` (
  `idMarcaVehiculo` bigint(20) NOT NULL,
  `marca` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

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

CREATE TABLE `gps_modulo` (
  `idModulo` int(11) NOT NULL,
  `modulo` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `estado` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `gps_modulo`
--

INSERT INTO `gps_modulo` (`idModulo`, `modulo`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'USUARIO', 'USUARIO', 1, '2021-07-06 23:16:33', '0000-00-00 00:00:00'),
(2, 'EMPLEADO', 'EMPLEADO', 1, '2021-07-20 00:23:17', '0000-00-00 00:00:00'),
(3, 'CLIENTE_PUBLICO', 'MODULOS PARA CLIENTES EXTERNOS', 1, '2021-07-06 23:18:02', '0000-00-00 00:00:00'),
(4, 'CONTRATO', 'GESTION DE CONTRATO PARA LOS CLIENTEA', 1, '2021-07-20 01:57:48', '0000-00-00 00:00:00'),
(5, 'VEHICULO', 'VEHICULO', 1, '2021-07-06 23:18:02', '0000-00-00 00:00:00'),
(6, 'CLIENTE', 'CLIENTE', 1, '2021-12-19 02:46:59', '0000-00-00 00:00:00'),
(7, 'PERSONA', 'MODULO DE GESTION DE PERSONA', 1, '2021-12-28 03:47:53', '2021-12-28 03:47:53'),
(8, 'INICIO', 'PANEL DE INICIO', 1, '2022-03-01 03:27:10', '2022-03-01 03:27:10'),
(9, 'PERMISOS', 'PERMISOS', 1, '2022-03-08 03:22:46', '2022-03-08 03:22:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_modulo_rol`
--

CREATE TABLE `gps_modulo_rol` (
  `idModuloRol` int(11) NOT NULL,
  `idModulo` int(11) NOT NULL,
  `idRol` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `gps_modulo_rol`
--

INSERT INTO `gps_modulo_rol` (`idModuloRol`, `idModulo`, `idRol`, `estado`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2021-07-06 23:19:10', '0000-00-00 00:00:00'),
(3, 2, 1, 1, '2021-07-20 00:22:40', '0000-00-00 00:00:00'),
(4, 3, 1, 1, '2021-07-20 00:21:27', '0000-00-00 00:00:00'),
(5, 2, 2, 1, '2021-07-06 23:19:23', '0000-00-00 00:00:00'),
(6, 3, 3, 1, '2021-07-06 23:19:27', '0000-00-00 00:00:00'),
(7, 4, 1, 1, '2021-07-20 01:58:07', '0000-00-00 00:00:00'),
(8, 5, 1, 1, '2021-07-06 23:19:10', '0000-00-00 00:00:00'),
(9, 6, 1, 1, '2021-12-19 02:49:17', '0000-00-00 00:00:00'),
(10, 7, 1, 1, '2021-12-28 03:49:15', '2021-12-28 03:49:15'),
(11, 8, 1, 1, '2022-03-01 03:28:11', '2022-03-01 03:28:11'),
(12, 4, 2, 1, '2022-03-01 04:21:54', '2022-03-01 04:21:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_pago`
--

CREATE TABLE `gps_pago` (
  `idPago` bigint(20) NOT NULL,
  `idContratoVehiculo` bigint(20) NOT NULL,
  `fechaPago` date DEFAULT NULL,
  `montoPago` decimal(10,2) NOT NULL,
  `montoPagoContratoVehiculo` decimal(10,2) NOT NULL,
  `idTipoPago` int(10) NOT NULL,
  `observacion` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `archivo` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `estado` int(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `gps_pago`
--

INSERT INTO `gps_pago` (`idPago`, `idContratoVehiculo`, `fechaPago`, `montoPago`, `montoPagoContratoVehiculo`, `idTipoPago`, `observacion`, `archivo`, `estado`, `created_at`, `updated_at`) VALUES
(1, 10, '2021-11-14', '20.30', '30.00', 1, 'esta e suna opbservacion', '', 1, '2021-11-15 02:22:32', NULL),
(2, 10, '2021-11-14', '20.30', '30.00', 1, 'esta e suna opbservacion', '', 0, '2021-11-15 02:22:36', NULL),
(3, 11, '2021-11-07', '20.30', '30.00', 2, 'esta e suna opbservacion', '', 1, '2021-11-15 03:02:25', NULL),
(4, 12, '2021-11-07', '20.30', '30.00', 1, 'esta e suna opbservacion', '', 1, '2021-11-08 00:48:20', NULL),
(5, 13, '2021-11-11', '20.30', '30.00', 2, 'esta e suna opbservacion', '', 1, '2021-11-15 03:00:57', NULL),
(6, 11, '2021-11-11', '20.30', '30.00', 1, 'esta e suna opbservacion', '', 1, '2021-11-15 00:56:22', NULL),
(7, 15, '2021-11-13', '20.30', '30.00', 1, 'esta e suna opbservacion', '', 1, '2021-11-15 00:56:22', NULL),
(8, 17, '2021-11-11', '20.30', '30.00', 1, 'esta e suna opbservacion', '', 1, '2021-11-15 00:56:22', NULL),
(9, 12, '2021-11-11', '20.30', '30.00', 1, 'esta e suna opbservacion', '', 1, '2021-11-15 00:56:22', NULL),
(10, 15, '2021-11-13', '20.30', '30.00', 4, 'asdasd', '', 1, '2021-11-27 04:59:17', NULL),
(11, 15, '2021-11-13', '20.30', '30.00', 1, 'esta e suna opbservacion', '', 1, '2021-11-15 00:56:22', NULL),
(12, 15, '2021-11-13', '20.30', '30.00', 2, 'esta e suna opbservacion', '', 1, '2021-11-15 03:01:00', NULL),
(13, 1, '2021-11-11', '20.30', '30.00', 1, 'esta e suna opbservacion', '', 1, '2021-11-15 00:56:22', NULL),
(14, 11, '2021-11-11', '20.30', '30.00', 1, 'esta e suna opbservacion', '', 1, '2021-11-15 00:56:22', NULL),
(15, 13, '2021-11-11', '20.30', '30.00', 1, 'esta e suna opbservacion', '', 1, '2021-11-15 00:56:22', NULL),
(16, 7, '2021-11-11', '20.30', '30.00', 1, 'esta e suna opbservacion', '', 1, '2021-11-15 00:56:22', NULL),
(17, 13, '2021-11-11', '20.30', '30.00', 2, 'esta e suna opbservacion', '', 1, '2021-11-15 03:01:06', NULL),
(18, 11, '2021-11-11', '20.30', '30.00', 1, 'esta e suna opbservacion', '', 1, '2021-11-15 00:56:22', NULL),
(19, 5, '2021-11-11', '20.30', '30.00', 1, 'esta e suna opbservacion', '', 1, '2021-11-15 00:56:22', NULL),
(20, 4, '2021-11-11', '20.30', '30.00', 1, 'esta e suna opbservacion', '', 1, '2021-11-15 00:56:22', NULL),
(21, 10, '2021-10-20', '33.00', '50.00', 3, 'pago por yape', '../../../../archivos/comprovantes/pdf_CICLO 2.png_6199b36440345_6365.png', 1, '2021-11-21 03:43:32', NULL),
(22, 10, '2021-10-20', '33.00', '50.00', 3, 'pago por yape', '../../../../archivos/comprovantes/img_CICLO 2.png_6199b3e515644_6555.png', 1, '2021-11-21 03:43:42', NULL),
(23, 10, '2021-10-20', '33.00', '50.00', 3, 'pago por yape', '../../../../archivos/comprovantes/img_TRICOTA_corel_2020.png_6199b3f6dddae_2379.png', 1, '2021-11-21 03:43:53', NULL),
(24, 10, '2021-10-20', '2134.00', '50.00', 3, 'asdasd', '', 0, '2021-11-27 09:04:00', '2021-11-27 09:04:00'),
(25, 10, '2021-10-20', '44.00', '50.00', 1, '444444', '', 1, '2021-11-21 03:01:00', NULL),
(26, 10, '2021-10-20', '111.00', '50.00', 1, '11111', '', 1, '2021-11-21 03:09:17', NULL),
(27, 10, '2021-10-20', '11.00', '50.00', 3, 'asdasd', '', 1, '2021-11-21 03:10:04', NULL),
(28, 10, '2021-10-20', '11.00', '50.00', 1, 'asdasd', '', 1, '2021-11-21 03:10:24', NULL),
(29, 10, '2021-10-20', '55.00', '50.00', 1, 'sdfsdf', '', 1, '2021-11-21 03:11:04', NULL),
(30, 10, '2021-10-20', '200.00', '50.00', 4, 'sdsdf', '', 1, '2021-11-21 03:13:45', NULL),
(31, 10, '2021-10-20', '20.00', '50.00', 3, 'yape', '', 1, '2021-11-21 03:14:38', NULL),
(32, 10, '2021-10-20', '77.00', '50.00', 2, 'yapesss', '../../archivos/comprovantes/img_Captura.PNG_6199b9c58a335_3751.png', 1, '2021-11-21 03:15:17', NULL),
(33, 10, '2021-10-20', '111.00', '50.00', 1, 'asdasd', '', 1, '2021-11-21 03:49:40', NULL),
(34, 10, '2021-09-14', '20.00', '50.00', 3, 'asda', '', 1, '2021-11-22 02:53:00', NULL),
(35, 10, '2021-10-21', '30.00', '50.00', 2, 'sdf', '', 1, '2021-11-22 02:53:51', NULL),
(36, 10, '2021-09-03', '30.00', '50.00', 2, 'sdf', '', 1, '2021-11-22 02:54:16', NULL),
(37, 10, '2021-11-05', '20.30', '50.00', 2, 'sdfs', '../../archivos/comprovantes/img_Captura.PNG_61aae2b831880_2847.png', 1, '2021-12-04 03:38:32', '2021-12-04 03:38:32'),
(38, 10, '2021-10-20', '11.00', '50.00', 3, 'qwe', '', 1, '2021-11-22 02:59:26', NULL),
(39, 10, '2021-11-22', '11.00', '50.00', 4, 'venta', '', 1, '2021-11-22 03:00:15', NULL),
(40, 10, '2021-11-21', '11.00', '50.00', 1, 'aaaaa', '', 0, '2021-12-04 03:38:50', '2021-12-04 03:38:50'),
(41, 10, '2021-11-21', '99.00', '50.00', 2, 'esta e un pago de la mensualidad', '../../archivos/comprovantes/img_TRICOTA_corel_2020.png_61b41ee54c822_9771.png', 1, '2021-12-11 03:45:41', '2021-12-11 03:45:41'),
(42, 10, '2021-11-21', '33.00', '50.00', 3, 'asdasd', '', 0, '2021-11-27 09:02:22', '2021-11-27 09:02:22'),
(43, 10, '2021-11-21', '22.00', '50.00', 3, 'asdas', '', 1, '2021-11-22 03:09:30', NULL),
(44, 10, '2021-11-21', '11.00', '50.00', 3, 'asdasd', '', 1, '2021-11-22 03:10:39', NULL),
(45, 10, '2021-10-21', '111.00', '50.00', 4, 'asdasd', '../../archivos/comprovantes/img_CICLO.png_619b0a7c646bf_6800.png', 1, '2021-11-22 03:11:56', NULL),
(46, 10, '2021-10-21', '11.00', '50.00', 4, 'dasd', '../../archivos/comprovantes/img_cortesur.png_619b0abab5d03_9538.png', 1, '2021-11-22 03:12:58', NULL),
(47, 10, '2021-10-21', '22.00', '50.00', 4, 'asdaswd', '../../archivos/comprovantes/img_COST.png_619b0b20c4bf5_2092.png', 1, '2021-11-22 03:14:40', NULL),
(48, 10, '2021-11-21', '22.00', '50.00', 4, 'asdasd', '../../archivos/comprovantes/img_TRICOTA_corel_2020.png_619b0b3acb8bf_3766.png', 1, '2021-11-22 03:15:06', NULL),
(49, 10, '2021-11-21', '123.00', '50.00', 4, 'asdasd', '../../archivos/comprovantes/img_CICLO.png_619b0d62ce4f1_7007.png', 0, '2021-12-04 03:37:46', '2021-12-04 03:37:46'),
(50, 10, '2021-11-21', '200.00', '50.00', 4, 'asdasd', '../../archivos/comprovantes/img_Captura.PNG_619b0d9fbdb0c_230.png', 0, '2021-12-04 03:37:51', '2021-12-04 03:37:51'),
(51, 10, '2021-11-21', '88.00', '50.00', 4, 'asdas', '../../archivos/comprovantes/img_70.png_619b0fe3e2bd8_8033.png', 1, '2021-11-22 03:34:59', NULL),
(52, 10, '2021-11-21', '77.00', '50.00', 4, 'asdasd', '../../archivos/comprovantes/img_67.png_619b10907f514_5778.png', 1, '2021-11-27 05:30:59', '2021-11-27 05:30:59'),
(53, 10, '2020-07-22', '22.00', '50.00', 2, '2020', '../../archivos/comprovantes/img_70.png_619c6222a4261_564.png', 1, '2021-11-23 03:38:10', NULL),
(54, 10, '2021-10-24', '66.00', '50.00', 1, 'esta es una menuslio', '../../archivos/comprovantes/img_69.png_619f0b794084b_6144.png', 1, '2021-11-25 04:05:13', NULL),
(55, 10, '2021-10-24', '55.00', '50.00', 1, 'asdasda', '', 1, '2021-11-25 04:08:30', NULL),
(56, 10, '2021-10-24', '231.00', '50.00', 1, 'asdasd', '', 1, '2021-11-25 04:09:34', NULL),
(57, 10, '2021-10-24', '10.00', '50.00', 1, 'sdsd', '', 1, '2021-11-25 04:13:34', NULL),
(58, 10, '2021-10-24', '10.00', '50.00', 1, 'asdasd', '', 1, '2021-11-25 04:15:25', NULL),
(59, 10, '2021-11-24', '22.11', '50.00', 1, 'asdasd', '', 1, '2021-11-25 04:18:42', NULL),
(60, 10, '2021-08-12', '30.00', '50.00', 1, 'asdas', '', 1, '2021-11-25 04:19:05', NULL),
(61, 10, '2020-12-09', '100.00', '50.00', 1, 'asdas', '', 1, '2021-11-25 04:19:42', NULL),
(62, 10, '2021-11-26', '100.00', '50.00', 1, 'df', '../../archivos/comprovantes/img_69.png_61a1a0b15b40e_9532.png', 0, '2021-11-27 09:02:41', '2021-11-27 09:02:41'),
(63, 10, '2021-11-26', '123123.00', '50.00', 3, 'casado', '../../archivos/comprovantes/img_COST.png_61a1c898cc9db_6053.png', 0, '2021-11-27 09:02:16', '2021-11-27 09:02:16'),
(64, 10, '2021-11-26', '22.00', '50.00', 2, 'holamnudoi', '../../archivos/comprovantes/img_69.png_61a1c7d17257d_9196.png', 0, '2021-11-27 07:18:22', '2021-11-27 07:18:22'),
(65, 10, '2021-11-27', '100.00', '50.00', 2, 'esta e sun prueba', '../../archivos/comprovantes/img_TRICOTA_corel_2020.png_61a1c88548d39_2780.png', 0, '2021-11-27 07:18:18', '2021-11-27 07:18:18'),
(66, 10, '2021-07-21', '100.00', '50.00', 2, 'pago de yaope', '../../archivos/comprovantes/img_TRICOTA_corel_2020.png_61a1c84f80f30_9928.png', 1, '2021-11-27 05:55:27', NULL),
(67, 18, '2021-12-03', '60.00', '30.00', 1, 'esta es una mesualidad', '../../archivos/comprovantes/img_CICLO 2.png_620db4c0023b6_3916.png', 1, '2022-02-17 02:37:48', '2022-02-17 02:37:48'),
(68, 10, '2021-12-03', '100.00', '50.00', 1, '100 msoles', '', 1, '2021-12-04 04:12:59', NULL),
(69, 18, '2021-12-07', '20.00', '30.00', 1, 'pago de que', '../../archivos/comprovantes/img_TRICOTA_corel_2020.png_620db49811d30_6032.png', 0, '2022-02-17 02:38:25', '2022-02-17 02:38:25'),
(70, 25, '2021-12-14', '20.00', '50.00', 1, 'asdasd', '', 1, '2021-12-14 05:12:51', NULL),
(71, 27, '2021-12-18', '30.00', '35.00', 1, 'asdasd', '../../archivos/comprovantes/img_VECTOR.png_61bd875954f4d_8635.png', 1, '2021-12-18 07:01:45', NULL),
(72, 23, '2021-12-27', '20.00', '35.00', 1, 'pago de ', '../../archivos/comprovantes/img_Captura.PNG_61c9531038d56_1179.png', 1, '2021-12-27 05:45:52', NULL),
(73, 29, '2021-12-28', '30.00', '50.00', 1, '12', '', 1, '2021-12-29 03:19:59', NULL),
(74, 27, '2022-01-15', '50.30', '35.00', 1, 'pago', '../../archivos/comprovantes/img_TRICOTA_corel_2020.png_61e2eb3c3d185_5065.png', 1, '2022-01-15 15:41:48', NULL),
(75, 31, '2022-01-15', '50.00', '20.00', 1, 'observac', '../../archivos/comprovantes/img_VECTOR.png_61e31d306f2b1_6442.png', 1, '2022-01-15 19:14:56', NULL),
(76, 18, '2021-12-07', '10.00', '35.00', 1, 'ASDASD', '../../archivos/comprovantes/img_cortesur.png_620db4d61e06b_2760.png', 1, '2022-02-17 02:37:10', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_persona_natural`
--

CREATE TABLE `gps_persona_natural` (
  `idPersona` bigint(20) NOT NULL,
  `nombres` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `apellidos` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `dni` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `correo` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `gps_persona_natural`
--

INSERT INTO `gps_persona_natural` (`idPersona`, `nombres`, `apellidos`, `telefono`, `dni`, `direccion`, `correo`, `created_at`, `updated_at`) VALUES
(1, 'LUIS ALFREDO', 'CHAMBILLA LANCHIPA', '900220862', '71391320', 'AV.MIRAFLORES', 'LUISTAR3@GMIAL.COM', '2021-07-20 06:03:32', '0000-00-00 00:00:00'),
(2, 'ANLLY', 'URURI CAUNA', '976818988', '00581515', 'CALLE LIMONEROS', 'CCRANLLY@GMAIL.COM', '2021-12-28 03:45:39', '2021-12-28 03:45:39'),
(3, 'JUNIOR', 'CARDENAZ CONTRERAS', '976818989', '71391817', 'CALLE ACASIA NRO 45 . ALTO ALIANZA', 'JUNIOR@GMAIL.COM', '2021-07-20 06:03:02', '0000-00-00 00:00:00'),
(4, 'CHRISTIAN', 'CALLA CEVALLOZ', '900818988', '71591817', 'CALLE LAS FLORES NRO 145 . NATIVIDAD', 'CHRIS@GMAIL.COM', '2021-07-20 06:03:10', '0000-00-00 00:00:00'),
(5, 'ROGGER ALESSANDRO', 'DIAZ VILLEGAS', '952171718', '71251417', 'ASOC. 24 JUNIO. PUEBLO LIBRE', 'ROGGER@GMAIL.COM', '2021-07-30 21:50:38', '0000-00-00 00:00:00'),
(14, 'CARMEN GUADALUPE', 'GRIMALDO REYES', '952818776', '71585448', 'av miralfore', 'lui@gmail.com', '2021-07-31 04:36:10', '0000-00-00 00:00:00'),
(15, 'MANUEL HERIBERTO', 'CARLOS DAVILA', '952818776', '71817188', 'av miralfore', 'manuel@gmial.com', '2021-07-31 04:53:21', '0000-00-00 00:00:00'),
(16, 'MARGARITA ISABEL', 'HERNANDEZ EGOAVIL', '952181718', '71252624', 'direccion marga', 'lmarga@gmail.com', '2021-07-31 05:14:49', '0000-00-00 00:00:00'),
(17, 'MIRELA FERNANDA', 'LLANQUI TORRES', '958844847', '71584952', 'direccion muni pocollay', 'mirella@gmial.com', '2021-08-02 23:00:19', '0000-00-00 00:00:00'),
(20, 'YESSICA', 'CORNEJO MONTEAGUDO', '958484744', '71391514', 'direccion yessica', 'yesiu@gmial.com', '2021-08-06 19:56:39', '0000-00-00 00:00:00'),
(34, 'ALBERT STEFANOS', 'TORRES COLLANTESS', '952251415', '71362514', 'DIRECCIONS', 'ALBERTOS@GMAIL.COM', '2021-12-23 04:17:55', '2021-12-23 04:17:55'),
(35, 'anlly larisa 2', 'ururi cauna', '900220862', '47860225', 'direccion empresa anlly', 'anlly@empresa.com', '2022-01-15 18:21:43', '0000-00-00 00:00:00'),
(36, 'manuel', 'masias', '911220862', '45230295', 'sin direccion', 'manue@gmial.com', '2021-10-29 05:00:02', '0000-00-00 00:00:00'),
(37, 'samuel', 'cardenas', '900220814', '71361526', 'sin direccion', 'cardenas@gmail.com', '2021-10-29 05:04:48', '0000-00-00 00:00:00'),
(38, 'juan', 'calisaya', '900720862', '71251558', 'capanique', 'calisaya@upt.pe', '2021-10-29 05:22:37', '0000-00-00 00:00:00'),
(41, 'TRIPASECA', 'ROBALO', '952818448', '71391321', 'DIRECCION', 'CHEPI@GMAIL.COM', '2021-12-22 05:58:51', '0000-00-00 00:00:00'),
(47, 'HILDA', 'LANCHIPA', '952818776', '00420862', 'DIRECCION HILDA', 'HILDA@GMIAL.COM', '2021-12-29 04:59:53', '2021-12-29 04:59:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_rol`
--

CREATE TABLE `gps_rol` (
  `idRol` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `estado` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `gps_rol`
--

INSERT INTO `gps_rol` (`idRol`, `nombre`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'ADMIN', 1, '2021-07-06 23:18:20', '0000-00-00 00:00:00'),
(2, 'EMPLEADO', 1, '2021-07-06 23:18:28', '0000-00-00 00:00:00'),
(3, 'CLIENTE', 1, '2021-07-06 23:18:49', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_tipo_pago`
--

CREATE TABLE `gps_tipo_pago` (
  `idTipoPago` int(10) NOT NULL,
  `tipoPago` varchar(25) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `gps_tipo_pago`
--

INSERT INTO `gps_tipo_pago` (`idTipoPago`, `tipoPago`) VALUES
(1, 'MENSUALIDAD'),
(2, 'ACTIVACION'),
(3, 'INSTALACION'),
(4, 'VENTA DISPOSITIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_usuario`
--

CREATE TABLE `gps_usuario` (
  `idUsuario` bigint(20) NOT NULL,
  `idPersona` bigint(20) NOT NULL,
  `idRol` int(11) NOT NULL,
  `usuario` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `contrasena` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `gps_usuario`
--

INSERT INTO `gps_usuario` (`idUsuario`, `idPersona`, `idRol`, `usuario`, `contrasena`, `estado`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'ADMIN', '$2y$07$BCryptRequires22Chrcte/VlQH0piJtjXl.0t1XkA8pw9dMXTpOq', 1, '2022-02-17 05:12:25', '0000-00-00 00:00:00'),
(2, 2, 2, 'ANLLY', '$2y$07$BCryptRequires22Chrcte/VlQH0piJtjXl.0t1XkA8pw9dMXTpOq', 1, '2022-03-06 01:49:56', '2022-03-06 01:49:56'),
(3, 3, 3, 'HBERRIOS', '$2y$07$BCryptRequires22Chrcte/VlQH0piJtjXl.0t1XkA8pw9dMXTpOq', 1, '2022-03-01 04:19:51', '2022-03-01 04:19:51'),
(7, 4, 3, 'CCALLA', '$2y$10$gcPvStUTfe0RI5tksfJBbu0OE5Ier4tmXB85bjqnIwmNPXHUg4dFS', 1, '2022-03-06 01:55:41', '2022-03-06 01:55:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gps_vehiculo`
--

CREATE TABLE `gps_vehiculo` (
  `idVehiculo` bigint(20) NOT NULL,
  `idMarcaVehiculo` bigint(20) NOT NULL,
  `placa` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `modelo` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `anio` int(11) DEFAULT NULL,
  `gps` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `imei` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `estado` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `gps_vehiculo`
--

INSERT INTO `gps_vehiculo` (`idVehiculo`, `idMarcaVehiculo`, `placa`, `modelo`, `anio`, `gps`, `imei`, `estado`, `created_at`, `updated_at`) VALUES
(1, 12, 'xxx-123', 'model 1', 2021, 'coban', '0001', 1, '2021-12-21 03:18:19', '2021-12-14 05:11:02'),
(2, 15, 'xxx-125', 'model 2', 2021, 'coban', '0001', 1, '2021-11-03 03:46:12', '2021-11-03 03:46:12'),
(3, 1, 'xxx-127', 'model 3', 2021, 'coban', '0001', 1, '2021-11-03 03:41:23', '2021-11-03 03:41:23'),
(4, 14, 'aaa-123', 'MODEL 1', 1999, 'COBAN', '000021', 1, '2022-03-08 03:20:46', '2022-03-08 03:20:46'),
(5, 25, 'XXX-156', 'modelo 33', 2021, 'coban 3030b', '000212121212', 1, '2021-12-13 02:02:06', NULL),
(6, 28, 'xxx-265', 'model', 2021, 'coban', '0001511', 1, '2021-12-14 05:11:02', NULL),
(7, 17, 'asd-123', 'model 1', 2021, 'coban', '000021', 1, '2021-12-21 05:10:53', '2021-12-21 05:10:53'),
(8, 28, 'wss-236', 'modloe 4', 1995, 'xoAS', '000022', 1, '2021-12-21 05:11:00', '2021-12-21 05:11:00'),
(9, 26, 'ZZZ-254', 'JEEEPP', 1998, 'COBAN JEE', '01111', 1, '2021-12-21 05:11:05', '2021-12-21 05:11:05'),
(10, 16, 'QQQ-266', 'MODELO4', 1992, 'COBAN', '0002121', 1, '2021-12-22 03:20:02', '2021-12-22 03:20:02'),
(11, 5, 'WWW-213', 'MODELO GENENSIS', 1992, 'COBAN 303 B', '0023121', 1, '2021-12-21 03:56:35', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `gps_cliente`
--
ALTER TABLE `gps_cliente`
  ADD PRIMARY KEY (`idCliente`),
  ADD KEY `idPersona` (`idPersona`),
  ADD KEY `idJuridico` (`idJuridico`);

--
-- Indices de la tabla `gps_contrato`
--
ALTER TABLE `gps_contrato`
  ADD PRIMARY KEY (`idContrato`),
  ADD KEY `idCliente` (`idCliente`);

--
-- Indices de la tabla `gps_contrato_vehiculo`
--
ALTER TABLE `gps_contrato_vehiculo`
  ADD PRIMARY KEY (`idContratoVehiculo`),
  ADD KEY `idVehiculo` (`idVehiculo`),
  ADD KEY `idContrato` (`idContrato`);

--
-- Indices de la tabla `gps_juridico`
--
ALTER TABLE `gps_juridico`
  ADD PRIMARY KEY (`idJuridico`),
  ADD KEY `idRepresentanteLegal` (`idRepresentanteLegal`);

--
-- Indices de la tabla `gps_marca_vehiculo`
--
ALTER TABLE `gps_marca_vehiculo`
  ADD PRIMARY KEY (`idMarcaVehiculo`);

--
-- Indices de la tabla `gps_modulo`
--
ALTER TABLE `gps_modulo`
  ADD PRIMARY KEY (`idModulo`);

--
-- Indices de la tabla `gps_modulo_rol`
--
ALTER TABLE `gps_modulo_rol`
  ADD PRIMARY KEY (`idModuloRol`),
  ADD KEY `idModulo` (`idModulo`),
  ADD KEY `idRol` (`idRol`);

--
-- Indices de la tabla `gps_pago`
--
ALTER TABLE `gps_pago`
  ADD PRIMARY KEY (`idPago`),
  ADD KEY `idContratoVehiculo` (`idContratoVehiculo`);

--
-- Indices de la tabla `gps_persona_natural`
--
ALTER TABLE `gps_persona_natural`
  ADD PRIMARY KEY (`idPersona`);

--
-- Indices de la tabla `gps_rol`
--
ALTER TABLE `gps_rol`
  ADD PRIMARY KEY (`idRol`);

--
-- Indices de la tabla `gps_tipo_pago`
--
ALTER TABLE `gps_tipo_pago`
  ADD PRIMARY KEY (`idTipoPago`);

--
-- Indices de la tabla `gps_usuario`
--
ALTER TABLE `gps_usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `idPersona` (`idPersona`),
  ADD KEY `idRol` (`idRol`);

--
-- Indices de la tabla `gps_vehiculo`
--
ALTER TABLE `gps_vehiculo`
  ADD PRIMARY KEY (`idVehiculo`),
  ADD UNIQUE KEY `placa` (`placa`),
  ADD KEY `idMarcaVehiculo` (`idMarcaVehiculo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `gps_cliente`
--
ALTER TABLE `gps_cliente`
  MODIFY `idCliente` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `gps_contrato`
--
ALTER TABLE `gps_contrato`
  MODIFY `idContrato` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `gps_contrato_vehiculo`
--
ALTER TABLE `gps_contrato_vehiculo`
  MODIFY `idContratoVehiculo` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `gps_juridico`
--
ALTER TABLE `gps_juridico`
  MODIFY `idJuridico` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `gps_marca_vehiculo`
--
ALTER TABLE `gps_marca_vehiculo`
  MODIFY `idMarcaVehiculo` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `gps_modulo`
--
ALTER TABLE `gps_modulo`
  MODIFY `idModulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `gps_modulo_rol`
--
ALTER TABLE `gps_modulo_rol`
  MODIFY `idModuloRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `gps_pago`
--
ALTER TABLE `gps_pago`
  MODIFY `idPago` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT de la tabla `gps_persona_natural`
--
ALTER TABLE `gps_persona_natural`
  MODIFY `idPersona` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `gps_rol`
--
ALTER TABLE `gps_rol`
  MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `gps_tipo_pago`
--
ALTER TABLE `gps_tipo_pago`
  MODIFY `idTipoPago` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `gps_usuario`
--
ALTER TABLE `gps_usuario`
  MODIFY `idUsuario` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `gps_vehiculo`
--
ALTER TABLE `gps_vehiculo`
  MODIFY `idVehiculo` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
