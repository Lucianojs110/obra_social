-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 25-02-2021 a las 14:56:11
-- Versión del servidor: 5.7.21
-- Versión de PHP: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `new_adrianpo_obrasocial`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afip`
--

DROP TABLE IF EXISTS `afip`;
CREATE TABLE IF NOT EXISTS `afip` (
  `id_afip` int(11) NOT NULL AUTO_INCREMENT,
  `cbteFch` datetime NOT NULL,
  `tipoCbteNumero` tinyint(4) NOT NULL,
  `nroCbte` varchar(17) NOT NULL,
  `caeNum` varchar(17) NOT NULL,
  `caeFvto` date NOT NULL,
  `docTipo` tinyint(4) NOT NULL,
  `docNro` varchar(15) NOT NULL,
  `nombreRS` varchar(35) NOT NULL,
  `tipoPago` char(100) DEFAULT NULL,
  `impNeto` decimal(7,2) NOT NULL,
  `impIVA` decimal(7,2) NOT NULL,
  `impTotal` decimal(7,2) NOT NULL,
  `cbteAsoc` varchar(17) NOT NULL,
  `codigoBarra` varchar(45) NOT NULL,
  `servicios` varchar(100) DEFAULT NULL,
  `concepto` varchar(100) DEFAULT NULL,
  `fdesde` date DEFAULT NULL,
  `fhasta` date DEFAULT NULL,
  `fvtopag` date DEFAULT NULL,
  PRIMARY KEY (`id_afip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afip_certificados`
--

DROP TABLE IF EXISTS `afip_certificados`;
CREATE TABLE IF NOT EXISTS `afip_certificados` (
  `id_certificado` int(11) NOT NULL AUTO_INCREMENT,
  `certkey` varchar(500) NOT NULL,
  `certcrt` varchar(500) NOT NULL,
  `ptovta` int(15) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_certificado`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `beneficiario`
--

DROP TABLE IF EXISTS `beneficiario`;
CREATE TABLE IF NOT EXISTS `beneficiario` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `prestador_id` int(11) DEFAULT NULL,
  `sesion_id` int(11) DEFAULT NULL,
  `id_provincia` int(11) DEFAULT NULL,
  `id_provincia_prestacion` int(11) DEFAULT NULL,
  `nombre` text COLLATE utf8mb4_unicode_ci,
  `apellido` varchar(75) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(75) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(75) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `localidad` varchar(75) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dni` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cuit` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion_prestacion` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `localidad_prestacion` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `km_ida` int(11) DEFAULT NULL,
  `km_vuelta` int(11) DEFAULT NULL,
  `viajes_ida` int(11) DEFAULT NULL,
  `viajes_vuelta` int(11) DEFAULT NULL,
  `turno` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dependencia` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_afiliado` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_seguridad` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad_solicitada` int(11) DEFAULT NULL,
  `transporte_a` text COLLATE utf8mb4_unicode_ci,
  `profesion` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_inactivo` date DEFAULT NULL,
  `discapacidad` date DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `tope` int(11) DEFAULT NULL,
  `dias_mensuales` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consentimiento` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_provincia` (`id_provincia`),
  KEY `id_provincia_prestacion` (`id_provincia_prestacion`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `beneficiario`
--

INSERT INTO `beneficiario` (`id`, `prestador_id`, `sesion_id`, `id_provincia`, `id_provincia_prestacion`, `nombre`, `apellido`, `email`, `telefono`, `direccion`, `localidad`, `dni`, `cuit`, `direccion_prestacion`, `localidad_prestacion`, `km_ida`, `km_vuelta`, `viajes_ida`, `viajes_vuelta`, `turno`, `dependencia`, `notas`, `numero_afiliado`, `codigo_seguridad`, `cantidad_solicitada`, `transporte_a`, `profesion`, `fecha_inactivo`, `discapacidad`, `activo`, `tope`, `dias_mensuales`, `consentimiento`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 69, 1, 5, 5, 'JUAN SOSA', NULL, NULL, NULL, 'Gral Paz 1595', 'Villa Dolores', '23.654.754', NULL, '25 de Mayo 54', 'Villa Dolores', 14, NULL, 8, 8, 'Mañana', 'No', NULL, '217764591051', '409', 168, NULL, NULL, '2021-02-01', '2022-03-01', 0, 20, '20', NULL, NULL, '2021-02-01 03:00:00', '2021-02-06 00:37:32'),
(2, 67, 1, 1, 1, 'Martin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-02-01', NULL, 0, NULL, NULL, NULL, NULL, '2021-02-01 03:00:00', '2021-02-06 22:30:06'),
(3, 67, 1, 5, 14, 'probando', NULL, 'email@email.com', '432432', 'Gral Paz 1595', 'Villa Dolores', '3423432', '32423424', NULL, NULL, 23, NULL, NULL, NULL, 'Mañana', NULL, NULL, '34234', NULL, 3, NULL, NULL, '2021-02-01', NULL, 0, NULL, NULL, NULL, NULL, '2020-02-01 03:00:00', '2021-02-06 22:30:00'),
(4, 70, 1, 15, 18, 'enero', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-02-01', NULL, 0, 3, NULL, 'Nueva cobertura', NULL, '2021-01-01 03:00:00', '2021-02-08 18:33:14'),
(5, 69, 1, 5, 5, 'AGUIRRES LUIS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-01', NULL, 0, NULL, NULL, 'Renovación de cobertura', NULL, '2021-01-01 03:00:00', '2021-02-06 12:57:37'),
(6, 67, 1, 12, 2, 'Maria Ines', NULL, NULL, '43', NULL, NULL, '43241243', '432412', NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '314123', NULL, 4, NULL, NULL, '2021-02-01', NULL, 0, NULL, NULL, 'Renovación de cobertura', NULL, '2021-01-01 03:00:00', '2021-02-09 14:03:54'),
(7, 69, 1, 6, 5, 'Enero', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-01', NULL, 0, NULL, NULL, 'Nueva cobertura', NULL, '2021-01-01 03:00:00', '2021-02-06 12:57:41'),
(8, 79, 1, 5, 5, 'diciembre20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-01', NULL, 0, NULL, NULL, 'Nueva cobertura', NULL, '2021-01-01 03:00:00', '2021-02-06 13:10:04'),
(9, 78, 1, 5, 5, 'diciembre20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-01', NULL, 0, NULL, NULL, 'Nueva cobertura', NULL, '2021-01-01 03:00:00', '2021-02-06 13:10:09'),
(10, 79, 1, 5, 5, 'diciembre20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, NULL, NULL, NULL, 'Mañana', 'No', NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-01', NULL, 0, 12, '12', 'Nueva cobertura', NULL, '2020-12-01 03:00:00', '2021-02-09 13:59:38'),
(11, 78, 1, 5, 5, 'diciembre20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-02-01', NULL, 0, NULL, NULL, NULL, NULL, '2021-02-06 10:19:58', '2021-02-06 13:23:14'),
(12, 78, 1, 5, 5, 'diciembre20 3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-02-01', NULL, 0, NULL, NULL, NULL, NULL, '2021-02-06 10:23:03', '2021-02-06 13:24:13'),
(13, 69, 1, 17, 4, 'JUNIO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-07-01', NULL, 0, NULL, NULL, 'Nueva cobertura', NULL, '2020-06-01 03:00:00', '2021-02-06 13:40:14'),
(14, 69, 1, 17, 4, 'JUNIO2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-07-01', NULL, 0, NULL, NULL, NULL, NULL, '2020-07-01 03:00:00', '2021-02-06 13:38:51'),
(15, 69, 1, 17, 4, 'JUNIO2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-07-01', NULL, 0, NULL, NULL, NULL, NULL, '2020-06-01 03:00:00', '2021-02-06 13:40:18'),
(16, 69, 1, 5, 5, 'ANDRADA JOAQUIN', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-02-01', NULL, 0, NULL, NULL, 'Renovación de cobertura', NULL, '2021-02-01 03:00:00', '2021-02-06 13:47:12'),
(17, 69, 1, 5, 5, 'AGUIRRE LUIS MARIA', NULL, NULL, NULL, 'Bolivar n°720', 'Villa Dolores', '6.697.102', NULL, '25 de Mayo n°54', 'Villa Dolores', 14, NULL, 12, 12, 'Mañana', 'No', NULL, '205902851075', '061', 168, NULL, NULL, '2021-01-01', NULL, 0, NULL, '12', 'Renovación de cobertura', NULL, '2021-01-01 03:00:00', '2021-02-09 13:59:49'),
(18, 69, 1, 5, 5, 'AGUIRRE LUIS', NULL, NULL, NULL, 'Bolivar n° 720', 'Villa Dolores', NULL, NULL, '25 de Mayo n°54', 'Villa Dolores', 14, NULL, NULL, NULL, 'Mañana', 'No', NULL, '205902851075', '601', 168, NULL, NULL, NULL, NULL, 1, NULL, '12', 'Renovación de cobertura', NULL, '2021-02-01 03:00:00', '2021-02-09 17:57:55'),
(19, 69, 1, 5, 5, 'CASTRO SOFIA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '123084421016', '597', 168, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Nueva cobertura', NULL, '2021-02-01 03:00:00', '2021-02-09 14:59:38'),
(20, 69, 1, 5, 5, 'CEJAS IAN', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '130202069034', '783', 168, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Nueva cobertura', NULL, '2021-02-01 03:00:00', '2021-02-09 15:03:34'),
(21, 69, 1, 5, 5, 'CEJAS IAN', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '130202069034', '783', 168, NULL, NULL, '2021-02-01', NULL, 0, NULL, NULL, 'Nueva cobertura', NULL, '2021-02-01 03:00:00', '2021-02-09 18:05:51'),
(22, 69, 1, 5, 5, 'DIAZ CARLOS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '210806666048', '997', 168, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Nueva cobertura', NULL, '2021-02-01 03:00:00', '2021-02-09 15:06:48'),
(23, 69, 1, 5, 5, 'GOMEZ MATIAS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '139476262005', '678', 168, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Nueva cobertura', NULL, '2021-02-01 03:00:00', '2021-02-09 15:07:26'),
(24, 69, 1, 5, 5, 'GUDIÑO VICENTE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '213484209056', '145', 168, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Nueva cobertura', NULL, '2021-02-01 03:00:00', '2021-02-09 15:08:08'),
(25, 69, 1, 5, 5, 'OVIEDO JOSE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '106697127007', '354', 336, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Nueva cobertura', NULL, '2021-02-01 03:00:00', '2021-02-09 15:09:16'),
(26, 69, 1, 5, 5, 'OVIEDO PABLO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '120916034012', '098', 168, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Nueva cobertura', NULL, '2021-02-01 03:00:00', '2021-02-09 15:24:14'),
(27, 69, 1, 5, 5, 'PAYERO HAYDEE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '204278134004', '755', 168, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Nueva cobertura', NULL, '2021-02-01 03:00:00', '2021-02-09 15:24:54'),
(28, 80, 1, 7, 7, 'Joaquin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Nueva cobertura', '2021-02-11 05:09:40', '2021-02-01 03:00:00', '2021-02-11 05:09:40'),
(29, 80, 1, 5, 5, 'HOAL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-02-01', NULL, 0, NULL, NULL, 'Nueva cobertura', NULL, '2021-02-01 03:00:00', '2021-02-10 13:56:50'),
(30, 80, 1, 5, 5, 'HOAL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-02-01', NULL, 0, NULL, NULL, 'Nueva cobertura', NULL, '2021-02-01 03:00:00', '2021-02-10 13:56:45'),
(31, 81, 1, 5, 5, 'Hola', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 12, NULL, 'Nueva cobertura', '2021-02-11 13:27:42', '2021-02-01 03:00:00', '2021-02-11 13:27:42'),
(32, 82, 1, 5, 5, 'JUAN', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-02-01', NULL, 0, 8, NULL, 'Nueva cobertura', NULL, '2021-02-01 03:00:00', '2021-02-12 00:02:17'),
(33, 82, 1, 6, 12, 'alberto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-02-01', NULL, 0, 8, NULL, 'Nueva cobertura', NULL, '2021-02-01 03:00:00', '2021-02-11 23:30:07'),
(34, 82, 1, 16, 5, 'prueba', NULL, NULL, '1135770931', 'Rosales 1166', 'Bariloche', '234234', '4565645646', NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '123456', '8400', 4, NULL, NULL, '2021-02-01', NULL, 0, NULL, NULL, 'Nueva cobertura', NULL, '2021-02-01 03:00:00', '2021-02-11 23:30:28'),
(35, 82, 1, 9, 12, 'Marzo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-02-01', NULL, 0, NULL, NULL, 'Nueva cobertura', NULL, '2021-02-01 03:00:00', '2021-02-11 23:30:21'),
(36, 82, 1, 12, 15, 'diciembre20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-02-01', NULL, 0, NULL, NULL, 'Nueva cobertura', NULL, '2021-02-01 03:00:00', '2021-02-11 23:30:35'),
(37, 82, 1, 5, 5, 'JUNIO2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-02-01', NULL, 0, NULL, NULL, 'Nueva cobertura', NULL, '2021-02-01 03:00:00', '2021-02-11 23:30:14'),
(38, 83, 1, 5, 5, 'ddd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Nueva cobertura', '2021-02-12 14:14:45', '2021-02-01 03:00:00', '2021-02-12 14:14:45'),
(39, 88, 1, 5, 5, 'Andrada Joaquin Ezequiel', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Renovación de cobertura', NULL, '2021-02-01 03:00:00', '2021-02-12 16:13:41'),
(40, 88, 1, 5, 5, 'Marzo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-02-01', NULL, 0, NULL, NULL, 'Renovación de cobertura', NULL, '2021-02-01 03:00:00', '2021-02-12 16:47:28'),
(41, 87, 1, 5, 5, 'ANDRADA JOAQUIN EZEQUIEL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '217764591051', '409', 1, NULL, NULL, '2020-02-01', NULL, 0, NULL, NULL, NULL, NULL, '2020-02-01 03:00:00', '2021-02-12 22:02:33'),
(42, 87, 1, 5, 5, 'ANDRADA JOAQUIN EZEQUIEL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '217764591051', '409', 1, NULL, NULL, '2020-02-01', NULL, 0, NULL, NULL, NULL, NULL, '2020-02-01 03:00:00', '2021-02-12 22:02:37'),
(43, 90, 1, 5, 5, 'Hola', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Nueva cobertura', '2021-02-13 04:40:38', '2021-02-01 03:00:00', '2021-02-13 04:40:38'),
(44, 91, 1, 5, 5, 'ANDRADA JOAQUIN EZEQUIEL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '217764591051', NULL, NULL, NULL, NULL, '2021-02-01', NULL, 0, NULL, NULL, 'Nueva cobertura', NULL, '2021-02-01 03:00:00', '2021-02-13 15:20:41'),
(45, 91, 1, 5, 5, 'ANDRADA JOAQUIN EZEQUIEL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '217764591051', NULL, NULL, NULL, NULL, '2021-02-01', NULL, 0, NULL, NULL, NULL, NULL, '2021-02-01 03:00:00', '2021-02-13 15:20:50'),
(46, 91, 1, 5, 5, 'ANDRADA JOAQUIN EZEQUIEL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '217764591051', NULL, NULL, NULL, NULL, '2021-02-01', NULL, 0, NULL, NULL, NULL, NULL, '2021-02-01 03:00:00', '2021-02-13 15:20:56'),
(47, 91, 1, 5, 5, 'AGUIRRE LUIS MARIA', NULL, NULL, NULL, 'Bolivar n°720', 'Villa Dolores', NULL, NULL, '25 de Mayo N°54', 'Villa Dolores', NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '205902851075', '061', 168, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Renovación de cobertura', NULL, '2021-01-01 03:00:00', '2021-02-18 22:29:02'),
(48, 91, 1, 5, 5, 'CASTRO SOFIA AGUSTINA', NULL, NULL, NULL, 'Mariano Moreno N°76', 'Villa Sarmiento', NULL, NULL, '25 de Mayo N°54', 'Villa Dolores', NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '123084421016', '597', 168, NULL, NULL, NULL, NULL, 1, 8, NULL, 'Nueva cobertura', NULL, '2021-01-01 03:00:00', '2021-02-16 05:44:11'),
(49, 92, 1, 5, 5, 'ANDRADA JOAQUIN EZEQUIEL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '2020-02-01 03:00:00', '2021-02-13 12:24:58'),
(50, 92, 1, 5, 5, 'CASTRO SOFIA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '123084421016', '597', 168, NULL, NULL, '2021-01-01', NULL, 0, NULL, NULL, NULL, NULL, '2021-01-01 03:00:00', '2021-02-13 15:28:39'),
(51, 91, 1, 5, 5, 'PERALTA CEJAS IAN FERNANDO', NULL, NULL, NULL, 'Alejandro Olmedo s/n', 'San Pedro', NULL, NULL, '25 de Mayo N°54', 'Villa Dolores', NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '130202069034', '783', 168, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Nueva cobertura', NULL, '2021-01-01 03:00:00', '2021-02-14 14:01:44'),
(52, 91, 1, 5, 5, 'DIAZ CARLOS JULIO', NULL, NULL, NULL, '9 de julio N°695', 'Villa Sarmiento', NULL, NULL, '25 de Mayo N°54', 'Villa Dolores', NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '210806666048', '597', 168, NULL, NULL, NULL, NULL, 1, 12, NULL, 'Nueva cobertura', NULL, '2021-01-01 03:00:00', '2021-02-16 06:00:19'),
(53, 91, 1, 5, 5, 'SOSA GOMEZ MATIAS NAHUEL', NULL, NULL, NULL, 'Av. San Martin N°1184', 'Villa Dolores', NULL, NULL, '25 de Mayo N°54', 'Villa Dolores', NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '139476262005', '061', 168, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Nueva cobertura', NULL, '2021-01-01 03:00:00', '2021-02-14 13:48:23'),
(54, 91, 1, 5, 5, 'GUDIÑO VICENTE DANIEL', NULL, NULL, NULL, 'Av España N° 900', 'Villa Sarmiento', NULL, NULL, '25 de Mayo N°54', 'Villa Dolores', NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '213484209056', '597', 168, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Nueva cobertura', NULL, '2021-01-01 03:00:00', '2021-02-14 13:40:52'),
(55, 91, 1, 5, 5, 'OVIEDO JOSE ESTEBAN', NULL, NULL, NULL, 'Ruta Nacional N°20. Km 206', 'Villa Dolores', NULL, NULL, '25 de Mayo N°54', 'Villa Dolores', NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '106697127007', '061', 336, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Nueva cobertura', NULL, '2021-01-01 03:00:00', '2021-02-17 22:43:21'),
(56, 91, 1, 5, 5, 'SOSA OVIEDO PABLO FACUNDO', NULL, NULL, NULL, 'Caceros n° 938', 'Villa Dolores', NULL, NULL, '25 de Mayo N°54', 'Villa Dolores', NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '120916034012', '061', 168, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Nueva cobertura', NULL, '2021-01-01 03:00:00', '2021-02-14 13:49:53'),
(57, 91, 1, 5, 5, 'PAYERO DOMINGA HAYDEE', NULL, NULL, NULL, 'Coronel Olmedo S/N°', 'San Pedro', NULL, NULL, '25 de Mayo N°54', 'Villa Dolores', NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '204278134004', '755', 168, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Nueva cobertura', NULL, '2021-01-01 03:00:00', '2021-02-14 13:42:30'),
(58, 91, 1, 5, 5, 'ROMERO MARIA DOLLY', NULL, NULL, NULL, '25 de mayo N°1816', 'Villa Dolores', NULL, NULL, '25 de Mayo N°54', 'Villa Dolores', NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '204133421002', '061', 168, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Nueva cobertura', NULL, '2021-01-01 03:00:00', '2021-02-14 13:45:38'),
(59, 91, 1, 5, 5, 'SOSA ROMERO AZUL FRANCESCA', NULL, NULL, NULL, 'Manuel Cuesta N° 117', 'Villa Dolores', NULL, NULL, '25 de Mayo N°54', 'Villa Dolores', NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '131586996016', '061', 168, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Nueva cobertura', NULL, '2021-01-01 03:00:00', '2021-02-14 13:50:26'),
(60, 91, 1, 5, 5, 'SABAS EMMA DE MARIA', NULL, NULL, NULL, 'Av. San Martín esq. España', 'Villa Dolores', NULL, NULL, '25 de Mayo N°54', 'Villa Dolores', NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '201140645005', '061', 168, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Nueva cobertura', NULL, '2021-01-01 03:00:00', '2021-02-14 13:46:45'),
(61, 91, 1, 5, 5, 'TEJEDA VEGA AARON TOMAS', NULL, NULL, NULL, 'Felipe Edrman N°289', 'Villa Dolores', NULL, NULL, '25 de Mayo N°54', 'Villa Dolores', NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '217112691045', '061', 168, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Nueva cobertura', NULL, '2021-01-01 03:00:00', '2021-02-14 13:52:27'),
(62, 91, 1, 5, 5, 'SOTELO NICOLAS FRANCISCO', NULL, NULL, NULL, 'Calle Publica S/N', 'Las Tapias', NULL, NULL, '25 de Mayo N°54', 'Villa Dolores', NULL, NULL, NULL, NULL, 'Mañana', NULL, NULL, '127757536059', '061', 112, NULL, NULL, NULL, NULL, 1, NULL, NULL, 'Nueva cobertura', NULL, '2021-01-01 03:00:00', '2021-02-14 14:01:05'),
(63, 96, 1, 2, 2, 'Gabriel Gomez', NULL, 'gabs@gmail.com', '154269222', 'waldino correa 372', 'San Fernando del Valle de catamarca', '35500319', '20-35500319-2', 'waldino correa 372', 'San Fernando del Valle de catamarca', 25, NULL, 5, 9, 'Mañana', 'No', 'asdasdas', '444', '256', 2, NULL, NULL, NULL, '2022-12-14', 1, NULL, NULL, 'Nueva cobertura', NULL, '2021-02-01 03:00:00', '2021-02-23 15:04:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Cat A'),
(2, 'Cat B'),
(3, 'Cat C');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturacion_electronica`
--

DROP TABLE IF EXISTS `facturacion_electronica`;
CREATE TABLE IF NOT EXISTS `facturacion_electronica` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `prestador_id` bigint(20) NOT NULL,
  `os_id` bigint(20) NOT NULL,
  `importe_total` double(8,2) NOT NULL,
  `importe_neto_no_gravado` double(8,2) NOT NULL,
  `importe_neto_gravado` double(8,2) NOT NULL,
  `importe_exento_iva` double(8,2) NOT NULL,
  `importe_total_iva` double(8,2) NOT NULL,
  `importe_total_tributos` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturacion_electronica_certificados`
--

DROP TABLE IF EXISTS `facturacion_electronica_certificados`;
CREATE TABLE IF NOT EXISTS `facturacion_electronica_certificados` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `cert_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `key_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `punto_venta` bigint(20) DEFAULT NULL,
  `tipo_comprobante` bigint(20) DEFAULT NULL,
  `concepto` bigint(20) DEFAULT NULL,
  `tipo_documento` bigint(20) DEFAULT NULL,
  `numero_documento` bigint(20) DEFAULT NULL,
  `moneda_id` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `moneda_cotizacion` bigint(20) DEFAULT NULL,
  `tipo_alicuota` bigint(20) DEFAULT NULL,
  `tipo_tributo` bigint(20) DEFAULT NULL,
  `tipo_opcion` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `feriados`
--

DROP TABLE IF EXISTS `feriados`;
CREATE TABLE IF NOT EXISTS `feriados` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fecha` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `feriados`
--

INSERT INTO `feriados` (`id`, `fecha`, `created_at`, `updated_at`) VALUES
(27, '01/01/2020', '2020-11-17 21:10:13', '2020-11-17 21:10:13'),
(28, '24/03/2020', '2020-11-17 21:11:00', '2020-11-17 21:11:00'),
(29, '02/04/2020', '2020-11-17 21:11:26', '2020-11-17 21:11:26'),
(30, '09/04/2020', '2020-11-17 21:12:00', '2020-11-17 21:12:00'),
(31, '10/04/2020', '2020-11-17 21:12:16', '2020-11-17 21:12:16'),
(32, '01/05/2020', '2020-11-17 21:12:49', '2020-11-17 21:12:49'),
(33, '25/05/2020', '2020-11-17 21:12:59', '2020-11-17 21:12:59'),
(34, '17/06/2020', '2020-11-17 21:13:21', '2020-11-17 21:13:21'),
(35, '20/06/2020', '2020-11-17 21:13:32', '2020-11-17 21:13:32'),
(36, '09/07/2020', '2020-11-17 21:13:53', '2020-11-17 21:13:53'),
(37, '17/08/2020', '2020-11-17 21:14:19', '2020-11-17 21:14:19'),
(38, '12/10/2020', '2020-11-17 21:14:46', '2020-11-17 21:14:46'),
(40, '23/11/2020', '2020-11-17 21:15:26', '2020-11-17 21:15:26'),
(41, '08/12/2020', '2020-11-17 21:15:58', '2020-11-17 21:15:58'),
(42, '25/12/2020', '2020-11-17 21:16:07', '2020-11-17 21:16:07'),
(44, '01/01/2021', '2021-01-13 21:53:09', '2021-01-13 21:53:09'),
(45, '15/02/2021', '2021-02-16 22:36:38', '2021-02-16 22:36:38'),
(46, '16/02/2021', '2021-02-16 22:36:45', '2021-02-16 22:36:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inactivos`
--

DROP TABLE IF EXISTS `inactivos`;
CREATE TABLE IF NOT EXISTS `inactivos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_ben` bigint(20) UNSIGNED DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_ben` (`id_ben`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `inactivos`
--

INSERT INTO `inactivos` (`id`, `id_ben`, `fecha`, `fecha_fin`, `updated_at`, `created_at`) VALUES
(26, 38, '2021-03-01', NULL, '2021-02-11 21:13:57', '2021-02-11 21:13:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inasistencias`
--

DROP TABLE IF EXISTS `inasistencias`;
CREATE TABLE IF NOT EXISTS `inasistencias` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `beneficiario_id` int(11) NOT NULL,
  `rango_fechas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mes` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anio` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `inasistencias`
--

INSERT INTO `inasistencias` (`id`, `beneficiario_id`, `rango_fechas`, `tipo`, `mes`, `anio`, `created_at`, `updated_at`) VALUES
(1, 6, '09/02/21 - 10/02/21', 'Inasistencia', '02', 2021, '2021-02-08 18:17:58', '2021-02-08 18:17:58'),
(2, 6, '01/02/21 - 16/02/21', 'Inasistencia', '02', 2021, '2021-02-08 18:18:27', '2021-02-08 18:18:27'),
(6, 28, '10/02/21 - 11/02/21', 'Inasistencia', '02', 2021, '2021-02-11 01:19:31', '2021-02-11 01:19:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_envia` int(11) NOT NULL,
  `id_recibe` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `mensaje` text NOT NULL,
  `archivo` varchar(100) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_envia` (`id_envia`),
  KEY `id_recibe` (`id_recibe`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `id_envia`, `id_recibe`, `titulo`, `mensaje`, `archivo`, `fecha`, `updated_at`, `created_at`) VALUES
(40, 22, 1, 'HOLA', 'HOLA', '', '2021-02-02 22:12:23', '2021-02-02 22:12:23', '2021-02-02 22:12:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_05_13_211628_create_prestador_table', 1),
(5, '2020_05_15_130138_create_obrasocial_table', 1),
(6, '2020_05_16_195618_create_beneficiario_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nomenclador`
--

DROP TABLE IF EXISTS `nomenclador`;
CREATE TABLE IF NOT EXISTS `nomenclador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `nomenclador`
--

INSERT INTO `nomenclador` (`id`, `fecha_inicio`, `fecha_fin`, `created_at`, `updated_at`) VALUES
(1, '2019-11-01', '2020-11-30', '2021-02-18 07:41:09', '2021-02-19 15:56:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obrasocial`
--

DROP TABLE IF EXISTS `obrasocial`;
CREATE TABLE IF NOT EXISTS `obrasocial` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(75) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_obra` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cuit` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ciudad` varchar(65) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(75) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condicion_iva` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor_sesion` decimal(10,2) DEFAULT NULL,
  `valor_km` decimal(10,2) DEFAULT NULL,
  `valor_modulo` decimal(10,2) DEFAULT NULL,
  `valor_mes` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomenclador` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `obrasocial`
--

INSERT INTO `obrasocial` (`id`, `nombre`, `tipo_obra`, `cuit`, `telefono`, `ciudad`, `direccion`, `email`, `condicion_iva`, `valor_sesion`, `valor_km`, `valor_modulo`, `valor_mes`, `nomenclador`, `created_at`, `updated_at`) VALUES
(1, 'OSECAC', NULL, '30550273558', NULL, 'BUENOS AIRES', 'MORENO N°648, CAPITAL FEDERAL', NULL, 'Iva Sujeto Exento', NULL, NULL, NULL, 'Definir', 1, '2020-05-27 19:50:18', '2021-02-18 21:54:27'),
(2, 'APROSS', NULL, '30999253675', '035144444', 'CÓRDOBA', 'Marcelo t. de Alvear n° 654', NULL, 'Iva Sujeto Exento', NULL, NULL, NULL, 'Definir', 0, '2020-06-13 15:32:27', '2021-01-25 17:39:17'),
(3, 'OSPIGPC', 'Nacional', '30652892317', NULL, 'CORDOBA', 'ARTIGAS N°60', NULL, 'Iva Sujeto Exento', NULL, NULL, NULL, 'Definir', 0, '2020-07-05 00:51:59', '2021-02-13 03:00:48'),
(4, 'OSPLYFC', NULL, '30565846538', NULL, 'CORDOBA', 'AV. GRAL. PAZ N°282 PISO: 1 - BARRIO CENTRO NORTE, CORDOBA', NULL, 'Iva Sujeto Exento', NULL, NULL, NULL, 'Definir', 0, '2020-07-10 01:45:15', '2020-07-10 02:31:08'),
(5, NULL, NULL, '111111111111111111112', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Definir', 0, '2021-01-30 14:52:34', '2021-02-13 02:58:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('adrianporcal@hotmail.com', '$2y$10$dBCps/kcq36mACJ0CcqCsOstGD2yuYiRNDTVNDPf73siJ176GYL/m', '2021-01-30 00:47:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestacion`
--

DROP TABLE IF EXISTS `prestacion`;
CREATE TABLE IF NOT EXISTS `prestacion` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `os_id` int(11) DEFAULT NULL,
  `id_categoria` tinyint(4) DEFAULT NULL,
  `nombre_pres` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_modulo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor_modulo` decimal(12,2) DEFAULT NULL,
  `planilla` smallint(6) DEFAULT NULL,
  `dividir` tinyint(4) DEFAULT NULL,
  `id_afip` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=259 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `prestacion`
--

INSERT INTO `prestacion` (`id`, `os_id`, `id_categoria`, `nombre_pres`, `codigo_modulo`, `valor_modulo`, `planilla`, `dividir`, `id_afip`, `created_at`, `updated_at`) VALUES
(155, 2, NULL, 'REHABILITACION FISIOKINESICA EN FIBROSIS QUISTICA- POR MES', '6501002', NULL, 1, NULL, NULL, '2021-02-13 00:19:10', '2021-02-13 00:19:10'),
(156, 2, NULL, 'MODULO INTEGRAL INTENSIVO-POR SEMANA-AMBULATORIO', '6501013', '5313.00', 1, 5, NULL, '2021-02-13 00:19:54', '2021-02-19 16:23:03'),
(157, 2, NULL, 'FONOAUDIOLOGIA -MIS-', '6501021', '2662.19', 1, 4, NULL, '2021-02-13 00:20:41', '2021-02-13 00:20:41'),
(158, 2, NULL, 'KINESIOLOGIA -MIS-', '6501022', '2662.19', 1, 4, NULL, '2021-02-13 00:21:36', '2021-02-13 00:21:36'),
(159, 2, NULL, 'PROF. EN EDUCACION DE SORDOS -MIS-', '6501025', '2662.19', 1, 4, NULL, '2021-02-13 00:22:07', '2021-02-13 00:22:07'),
(160, 2, NULL, 'PSICOLOGIA -MIS-', '6501026', '2662.19', 1, 4, NULL, '2021-02-13 00:22:35', '2021-02-13 00:22:35'),
(161, 2, NULL, 'PSICOMOTRICIDAD -MIS-', '6501027', '2662.19', 1, 4, NULL, '2021-02-13 00:23:20', '2021-02-13 00:23:20'),
(162, 2, NULL, 'PSICOPEDAGOGIA -MIS-', '6501028', '2662.19', 1, 4, NULL, '2021-02-13 00:24:21', '2021-02-13 00:24:21'),
(163, 2, NULL, 'TERAPISTA OCUPACIONAL -MIS-', '6501029', '2662.19', 1, 4, NULL, '2021-02-13 00:25:31', '2021-02-13 00:25:31'),
(164, 2, NULL, 'PROF. EN EDUCACION DE CIEGOS -MIS-', '6501030', '2662.19', 1, 4, NULL, '2021-02-13 00:26:01', '2021-02-13 00:26:01'),
(165, 2, NULL, 'HOSPITAL DE DÍA -SIMPLE-', '6502013', NULL, 1, NULL, NULL, '2021-02-13 00:26:41', '2021-02-13 00:26:41'),
(166, 2, NULL, 'HOSPITAL DE DÍA -DOBLE-', '6502023', NULL, 1, NULL, NULL, '2021-02-13 00:27:29', '2021-02-13 00:27:29'),
(167, 2, 1, 'CENTRO DE DÍA JORNADA SIMPLE', '6503011', NULL, 1, NULL, NULL, '2021-02-13 00:28:46', '2021-02-13 00:28:46'),
(168, 2, 2, 'CENTRO DE DÍA JORNADA SIMPLE', '6503012', '17183.76', 1, NULL, NULL, '2021-02-13 00:29:25', '2021-02-19 16:29:50'),
(169, 2, 3, 'CENTRO DE DÍA JORNADA SIMPLE', '6503013', NULL, 1, NULL, NULL, '2021-02-13 00:30:02', '2021-02-13 00:30:02'),
(170, 2, 1, 'CENTRO DE DÍA JORNADA DOBLE', '6503021', NULL, 1, NULL, NULL, '2021-02-13 00:31:20', '2021-02-13 00:31:20'),
(171, 2, 2, 'CENTRO DE DÍA JORNADA DOBLE', '6503022', NULL, 1, NULL, NULL, '2021-02-13 00:32:15', '2021-02-13 00:32:15'),
(172, 2, 3, 'CENTRO DE DÍA JORNADA DOBLE', '6503023', NULL, 1, NULL, NULL, '2021-02-13 03:04:35', '2021-02-13 03:04:35'),
(173, 2, NULL, 'C.R.P.M HEMIPLEJIA CON AFASIA O DISARTRIA (INTENSIVO)', '6504013', '26946.40', 1, NULL, NULL, '2021-02-13 03:06:22', '2021-02-13 03:08:09'),
(174, 2, NULL, 'C.R.P.M HEMIPLEJIA CON AFASIA O DISARTRIA (INTENSIDAD MEDIA)', '6504023', '13469.72', 1, NULL, NULL, '2021-02-13 03:09:35', '2021-02-13 03:09:35'),
(175, 2, NULL, 'C.R.P.M HEMIPLEJIA CON AFASIA O DISARTRIA (BAJA INTENSIDAD)', '6504033', NULL, 1, NULL, NULL, '2021-02-13 03:10:24', '2021-02-13 03:10:24'),
(176, 2, NULL, 'C.R.P.M HEMIPLEJIA SIN AFASIA O DISARTRIA (INTENSIVO)', '6504043', NULL, 1, NULL, NULL, '2021-02-13 03:11:06', '2021-02-13 03:11:06'),
(177, 2, NULL, 'C.R.P.M HEMIPLEJIA SIN AFASIA O DISARTRIA (INTENSIDAD MEDIA)', '6504053', NULL, 1, NULL, NULL, '2021-02-13 03:13:15', '2021-02-13 03:13:15'),
(178, 2, NULL, 'C.R.P.M HEMIPLEJIA SIN AFASIA O DISARTRIA (BAJA INTENSIDAD)', '6504063', NULL, 1, NULL, NULL, '2021-02-13 03:13:42', '2021-02-13 03:13:42'),
(179, 2, NULL, 'C.R.P.M SECUELA DE TRAU.CRANEO ENCEFALICO (INTENSIVO)', '6504073', NULL, 1, NULL, NULL, '2021-02-13 03:14:42', '2021-02-13 03:14:42'),
(180, 2, NULL, 'C.R.P.M SECUELA DE TRAU.CRANEO ENCEFALICO (INTENSIDAD MEDIA)', '6504083', NULL, 1, NULL, NULL, '2021-02-13 03:15:26', '2021-02-13 03:15:26'),
(181, 2, NULL, 'C.R.P.M SECUELA DE TRAU.CRANEO ENCEFALICO (BAJA INTENSIDAD)', '6504093', NULL, 1, NULL, NULL, '2021-02-13 03:16:10', '2021-02-13 03:16:10'),
(182, 2, NULL, 'C.R.P.M LESIONADO MEDULAR (INTENSIVO)', '6504103', NULL, 1, NULL, NULL, '2021-02-13 03:16:35', '2021-02-13 03:16:35'),
(183, 2, NULL, 'C.R.P.M LESIONADO MEDULAR (INTENSIDAD MEDIA)', '6504113', NULL, 1, NULL, NULL, '2021-02-13 03:17:05', '2021-02-13 03:17:05'),
(184, 2, NULL, 'C.R.P.M LESIONADO MEDULAR (BAJA INTENSIDAD)', '6504123', NULL, 1, NULL, NULL, '2021-02-13 03:17:33', '2021-02-13 03:17:33'),
(185, 2, NULL, 'C.R.P.M AMPUTADO MIEMBRO INFERIOR (INTENSIVO)', '6504133', NULL, 1, NULL, NULL, '2021-02-13 03:18:02', '2021-02-13 03:18:02'),
(186, 2, NULL, 'C.R.P.M AMPUTADO MIEMBRO INFERIOR (INTENSIDAD MEDIA)', '6504143', NULL, 1, NULL, NULL, '2021-02-13 03:19:17', '2021-02-13 03:19:17'),
(187, 2, NULL, 'C.R.P.M AMPUTADO MIEMBRO INFERIOR (BAJA INTENSIDAD)', '6504153', NULL, 1, NULL, NULL, '2021-02-13 03:19:54', '2021-02-13 03:19:54'),
(188, 2, NULL, 'C.R.P.M AMPUTADO MIEMBRO SUPERIOR (INTENSIVO)', '6504163', NULL, 1, NULL, NULL, '2021-02-13 03:20:23', '2021-02-13 03:20:23'),
(189, 2, NULL, 'C.R.P.M AMPUTADO MIEMBRO SUPERIOR (INTENSIDAD MEDIA)', '6504173', NULL, 1, NULL, NULL, '2021-02-13 03:20:48', '2021-02-13 03:20:48'),
(190, 2, NULL, 'C.R.P.M AMPUTADO MIEMBRO SUPERIOR (BAJA INTENSIDAD)', '6504183', NULL, 1, NULL, NULL, '2021-02-13 03:21:25', '2021-02-13 03:21:25'),
(191, 2, 1, 'CTRO. EDUC. TERAPEUTICO-JORNADA SIMPLE', '6505011', NULL, 2, NULL, NULL, '2021-02-13 03:22:38', '2021-02-13 03:23:19'),
(192, 2, 2, 'CTRO. EDUC. TERAPEUTICO-JORNADA SIMPLE', '6505012', NULL, 2, NULL, NULL, '2021-02-13 03:23:06', '2021-02-13 03:23:06'),
(193, 2, 3, 'CTRO. EDUC. TERAPEUTICO-JORNADA SIMPLE', '6505013', NULL, 1, NULL, NULL, '2021-02-13 03:25:45', '2021-02-13 03:25:45'),
(194, 2, 1, 'C.E.T. (JORNADA DOBLE)', '6505021', NULL, 2, NULL, NULL, '2021-02-13 03:26:36', '2021-02-19 16:41:15'),
(195, 2, 2, 'C.E.T. (JORNADA DOBLE)', '6505022', NULL, 2, NULL, NULL, '2021-02-13 03:27:03', '2021-02-19 16:41:33'),
(196, 2, 3, 'C.E.T. (JORNADA DOBLE)', '6505023', NULL, 2, NULL, NULL, '2021-02-13 03:27:41', '2021-02-19 16:41:50'),
(197, 2, 3, 'ESTIMULACION TEMPRANA-MENSUAL', '6506013', '14466.54', 1, NULL, NULL, '2021-02-13 03:29:13', '2021-02-13 03:29:13'),
(198, 2, NULL, 'ESTIMULACION TEMPRANA (POR HORA)', '6506023', '538.89', 1, NULL, NULL, '2021-02-13 03:33:36', '2021-02-13 03:33:36'),
(199, 2, 1, 'EDUCACION INICIAL-JORNADA SIMPLE', '6507011', '20455.05', 2, NULL, NULL, '2021-02-13 03:34:40', '2021-02-13 03:35:17'),
(200, 2, 2, 'EDUCACION INICIAL-JORNADA SIMPLE', '6507012', NULL, 2, NULL, NULL, '2021-02-13 03:36:08', '2021-02-13 03:36:08'),
(201, 2, 3, 'EDUCACION INICIAL-JORNADA SIMPLE', '6507013', NULL, 2, NULL, NULL, '2021-02-13 03:36:32', '2021-02-13 03:36:32'),
(202, 2, 1, 'EDUCACION INICIAL PRE PRIMARIA (JORNADA DOBLE)', '6507021', NULL, 2, NULL, NULL, '2021-02-13 13:39:56', '2021-02-13 13:39:56'),
(203, 2, 2, 'EDUCACION INICIAL PRE PRIMARIA (JORNADA DOBLE)', '6507022', NULL, 1, NULL, NULL, '2021-02-13 13:40:49', '2021-02-13 13:40:49'),
(204, 2, 3, 'EDUCACION INICIAL PRE PRIMARIA (JORNADA DOBLE)', '6507023', '17882.04', 2, NULL, NULL, '2021-02-13 13:41:41', '2021-02-13 13:41:41'),
(205, 2, 1, 'EDUC.GRAL.BASICA-JORNADA SIMPLE', '6507031', NULL, 2, NULL, NULL, '2021-02-13 13:51:16', '2021-02-13 13:51:30'),
(206, 2, 2, 'EDUC.GRAL.BASICA-JORNADA SIMPLE', '6507032', NULL, 2, NULL, NULL, '2021-02-13 13:54:04', '2021-02-13 13:54:04'),
(207, 2, 3, 'EDUC.GRAL.BASICA-JORNADA SIMPLE', '6507033', NULL, 2, NULL, NULL, '2021-02-13 13:55:10', '2021-02-13 13:55:10'),
(208, 2, 1, 'EDUC.GRAL.BASICA-JORNADA DOBLE', '6507041', NULL, 2, NULL, NULL, '2021-02-13 13:55:41', '2021-02-13 13:55:41'),
(210, 2, 2, 'EDUC.GRAL.BASICA-JORNADA DOBLE', '6507042', NULL, 2, NULL, NULL, '2021-02-13 13:56:45', '2021-02-13 13:56:45'),
(211, 2, 3, 'EDUCACION GENERAL BASICA PRIMARIA (JORNADA DOBLE)', '6507043', NULL, 2, NULL, NULL, '2021-02-13 13:58:37', '2021-02-13 13:58:37'),
(212, 2, NULL, 'APOYO A LA INTEGRACION ESCOLAR (MODULO)', '6507053', '18730.10', 2, 24, NULL, '2021-02-13 14:00:02', '2021-02-13 14:00:29'),
(213, 2, 3, 'APOYO A LA INTEGRACION ESCOLAR -HORA-', '6507063', '517.13', 2, NULL, NULL, '2021-02-13 14:01:38', '2021-02-13 14:01:38'),
(214, 2, NULL, 'MODULO DE APOYO A LA INT ESCOLAR. EN EQUIPO', '6507064', '29793.28', 2, NULL, NULL, '2021-02-13 14:04:55', '2021-02-13 14:04:55'),
(215, 2, 1, 'FORMACION-JORNADA SIMPLE-LABORAL Y/O REH', '6507071', NULL, 2, NULL, NULL, '2021-02-13 14:08:12', '2021-02-13 14:08:12'),
(216, 2, 2, 'FORMACION-JORNADA SIMPLE-LABORAL Y/O REH', '6507072', NULL, 2, NULL, NULL, '2021-02-13 14:08:42', '2021-02-13 14:08:42'),
(217, 2, 3, 'FORMACION-JORNADA SIMPLE-LABORAL Y/O REH', '6507073', NULL, 2, NULL, NULL, '2021-02-13 14:09:12', '2021-02-13 14:09:12'),
(218, 2, 1, 'FORMACION-JORNADA DOBLE-LABORAL Y/O REH', '6507081', NULL, 2, NULL, NULL, '2021-02-13 14:10:18', '2021-02-13 14:10:18'),
(219, 2, 2, 'FORMACION-JORNADA DOBLE-LABORAL Y/O REH', '6507082', NULL, 2, NULL, NULL, '2021-02-13 14:10:41', '2021-02-13 14:10:41'),
(220, 2, 3, 'FORMACION-JORNADA DOBLE-LABORAL Y/O REH', '6507083', NULL, 2, NULL, NULL, '2021-02-13 14:11:06', '2021-02-13 14:11:06'),
(221, 2, NULL, 'INTERNACION PARA REHABILITACION INTENSIVA-DIARIO', '6508012', NULL, 1, NULL, NULL, '2021-02-13 14:11:48', '2021-02-19 16:49:12'),
(222, 2, NULL, 'INTERNACION PARA REHABILITACION INTENSIVA-MENSUAL', '6508013', NULL, 1, NULL, NULL, '2021-02-13 14:12:21', '2021-02-19 16:49:36'),
(223, 2, NULL, 'INTERNACION PARA REHABILITACION DE PACIENTE CRONICO', '6508014', NULL, 1, NULL, NULL, '2021-02-13 14:12:50', '2021-02-13 14:12:50'),
(224, 2, 1, 'MODULO HOGAR (LUNES A VIERNES)', '6509011', NULL, 1, NULL, NULL, '2021-02-13 14:13:43', '2021-02-13 14:13:43'),
(225, 2, 2, 'MODULO HOGAR (LUNES A VIERNES)', '6509012', NULL, 1, NULL, NULL, '2021-02-13 14:14:07', '2021-02-13 14:14:07'),
(226, 2, 3, 'MODULO HOGAR (LUNES A VIERNES)', '6509013', NULL, 1, NULL, NULL, '2021-02-13 14:14:39', '2021-02-13 14:14:39'),
(227, 2, 1, 'MODULO HOGAR PERMANENTE', '6509021', NULL, 1, NULL, NULL, '2021-02-13 14:15:59', '2021-02-13 14:15:59'),
(228, 2, 2, 'MODULO HOGAR PERMANENTE', '6509022', NULL, 1, NULL, NULL, '2021-02-13 14:16:26', '2021-02-13 14:16:26'),
(229, 2, 3, 'MODULO HOGAR PERMANENTE', '6509023', NULL, 1, NULL, NULL, '2021-02-13 14:16:48', '2021-02-13 14:16:48'),
(230, 2, 1, 'HOGAR CON CENTRO DE DIA (LUNES A VIERNES)', '6509031', NULL, 1, NULL, NULL, '2021-02-13 14:17:37', '2021-02-13 14:17:37'),
(231, 2, 2, 'HOGAR CON CENTRO DE DIA (LUNES A VIERNES)', '6509032', NULL, 1, NULL, NULL, '2021-02-13 14:18:02', '2021-02-13 14:18:02'),
(232, 2, 3, 'HOGAR CON CENTRO DE DIA (LUNES A VIERNES)', '6509033', NULL, 1, NULL, NULL, '2021-02-13 14:18:22', '2021-02-13 14:18:22'),
(233, 2, 1, 'HOGAR PERMANENTE C/CTRO. DE DIA', '6509041', NULL, 1, NULL, NULL, '2021-02-13 14:19:06', '2021-02-13 14:19:06'),
(234, 2, 2, 'HOGAR PERMANENTE C/CTRO. DE DIA', '6509042', NULL, 1, NULL, NULL, '2021-02-13 14:19:34', '2021-02-13 14:19:34'),
(235, 2, 3, 'HOGAR PERMANENTE C/CTRO. DE DIA', '6509043', NULL, 1, NULL, NULL, '2021-02-13 14:19:55', '2021-02-13 14:19:55'),
(236, 2, 1, 'HOGAR CON C.E.T. (LUNES A VIERNES)', '6509051', NULL, 1, NULL, NULL, '2021-02-13 14:20:52', '2021-02-13 14:20:52'),
(237, 2, 2, 'HOGAR CON C.E.T. (LUNES A VIERNES)', '6509052', NULL, 1, NULL, NULL, '2021-02-13 14:21:11', '2021-02-13 14:21:11'),
(238, 2, 3, 'HOGAR CON C.E.T. (LUNES A VIERNES)', '6509053', NULL, 1, NULL, NULL, '2021-02-13 14:21:32', '2021-02-13 14:21:32'),
(239, 2, 1, 'HOGAR PERMANENTE CON C.E.T.', '6509061', NULL, 1, NULL, NULL, '2021-02-13 14:22:34', '2021-02-13 14:22:34'),
(240, 2, 2, 'HOGAR PERMANENTE CON C.E.T.', '6509062', NULL, 1, NULL, NULL, '2021-02-13 14:22:56', '2021-02-13 14:22:56'),
(241, 2, 3, 'HOGAR PERMANENTE CON C.E.T.', '6509063', NULL, 1, NULL, NULL, '2021-02-13 14:23:20', '2021-02-13 14:23:20'),
(242, 2, 1, 'PEQUEÑO HOGAR (LUNES A VIERNES)', '6509071', NULL, 1, NULL, NULL, '2021-02-13 14:24:37', '2021-02-13 14:24:37'),
(243, 2, 2, 'PEQUEÑO HOGAR (LUNES A VIERNES)', '6509072', NULL, 1, NULL, NULL, '2021-02-13 14:25:07', '2021-02-13 14:25:07'),
(244, 2, 3, 'PEQUEÑO HOGAR (LUNES A VIERNES)', '6509073', NULL, 1, NULL, NULL, '2021-02-13 14:25:29', '2021-02-13 14:25:29'),
(245, 2, 1, 'PEQUEÑO HOGAR PERMANENTE', '6509081', NULL, 1, NULL, NULL, '2021-02-13 14:26:27', '2021-02-13 14:26:27'),
(246, 2, 2, 'PEQUEÑO HOGAR PERMANENTE', '6509082', NULL, 1, NULL, NULL, '2021-02-13 14:26:57', '2021-02-13 14:26:57'),
(247, 2, 3, 'PEQUEÑO HOGAR PERMANENTE', '6509083', NULL, 1, NULL, NULL, '2021-02-13 14:27:26', '2021-02-13 14:27:26'),
(248, 2, NULL, 'TRANSPORTE POR KM RECORRIDO', '6501014', '28.33', 3, NULL, NULL, '2021-02-13 14:28:10', '2021-02-13 14:28:10'),
(252, 2, NULL, 'TRANSPORTE POR KM A INSTITUCION', '6501014', '28.33', 3, NULL, NULL, '2021-02-13 14:37:44', '2021-02-13 14:37:44'),
(253, 2, NULL, 'TRANSPORTE POR KM PARA TERAPIA', '6501015', '28.33', 3, NULL, NULL, '2021-02-13 14:38:09', '2021-02-13 14:38:09'),
(254, 2, NULL, 'ADICIONAL TRANSPORTE P/KM RECORRIDO', '6501024', '9.92', 3, NULL, NULL, '2021-02-13 14:38:40', '2021-02-13 14:38:40'),
(258, 2, NULL, 'Transporte en Auto POR KM PARA TERAPIA INTENSIVA', '0001', '1000.00', 3, NULL, NULL, '2021-02-23 17:29:29', '2021-02-23 17:29:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestacion_nomenclador`
--

DROP TABLE IF EXISTS `prestacion_nomenclador`;
CREATE TABLE IF NOT EXISTS `prestacion_nomenclador` (
  `id` double NOT NULL AUTO_INCREMENT,
  `id_nomenclador` int(11) NOT NULL,
  `id_prestacion` bigint(20) NOT NULL,
  `valor` decimal(12,2) DEFAULT NULL,
  `dividir` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_nomenclador` (`id_nomenclador`),
  KEY `id_prestacion` (`id_prestacion`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `prestacion_nomenclador`
--

INSERT INTO `prestacion_nomenclador` (`id`, `id_nomenclador`, `id_prestacion`, `valor`, `dividir`, `created_at`, `updated_at`) VALUES
(1, 1, 152, '4088.20', 4, '2021-02-18 14:44:47', '2021-02-18 23:08:05'),
(2, 1, 154, '2.00', NULL, '2021-02-18 14:44:47', '2021-02-18 14:44:47'),
(3, 1, 256, '2.00', NULL, '2021-02-18 14:44:47', '2021-02-18 14:44:47'),
(4, 1, 257, '30.74', NULL, '2021-02-18 22:48:58', '2021-02-18 23:08:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestador`
--

DROP TABLE IF EXISTS `prestador`;
CREATE TABLE IF NOT EXISTS `prestador` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `os_id` int(11) NOT NULL,
  `prestacion_id` int(11) NOT NULL,
  `id_nomenclador` int(11) DEFAULT NULL,
  `numero_prestador` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor_default` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor_prestacion` decimal(10,2) DEFAULT NULL,
  `mover_dias` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quitar_feriado` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tope` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prestacion_id` (`prestacion_id`),
  KEY `os_id` (`os_id`),
  KEY `user_id` (`user_id`),
  KEY `id_nomenclador` (`id_nomenclador`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `prestador`
--

INSERT INTO `prestador` (`id`, `user_id`, `os_id`, `prestacion_id`, `id_nomenclador`, `numero_prestador`, `valor_default`, `valor_prestacion`, `mover_dias`, `quitar_feriado`, `tope`, `created_at`, `updated_at`) VALUES
(91, 22, 2, 253, NULL, '5064', 'T', '0.00', 'No', 'Si', NULL, '2021-02-13 14:41:08', '2021-02-13 14:41:08'),
(92, 27, 2, 157, NULL, '2426', 'T', '0.00', 'No', 'No', NULL, '2021-02-13 15:24:42', '2021-02-13 15:24:42'),
(96, 22, 2, 258, NULL, '50666', 'T', '0.00', 'No', 'Si', NULL, '2021-02-23 03:00:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincias`
--

DROP TABLE IF EXISTS `provincias`;
CREATE TABLE IF NOT EXISTS `provincias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provincia` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `provincias`
--

INSERT INTO `provincias` (`id`, `provincia`) VALUES
(1, 'Buenos Aires'),
(2, 'Catamarca'),
(3, 'Chaco'),
(4, 'Chubut'),
(5, 'Cordoba'),
(6, 'Corrientes'),
(7, 'Entre Rios'),
(8, 'Formosa'),
(9, 'Jujuy'),
(10, 'La Pampa'),
(11, 'La Rioja'),
(12, 'Mendoza'),
(13, 'Misiones'),
(14, 'Neuquen'),
(15, 'Rio Negro'),
(16, 'Salta'),
(17, 'San Juan'),
(18, 'San Luis'),
(19, 'Santa Cruz'),
(20, 'Santa Fe'),
(21, 'Santiago del Estero'),
(22, 'Tierra del Fuego'),
(23, 'Tucuman');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesion`
--

DROP TABLE IF EXISTS `sesion`;
CREATE TABLE IF NOT EXISTS `sesion` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `beneficiario_id` int(11) DEFAULT NULL,
  `dia` tinyint(4) DEFAULT NULL,
  `hora` char(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tiempo` int(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sesion`
--

INSERT INTO `sesion` (`id`, `beneficiario_id`, `dia`, `hora`, `tiempo`, `created_at`, `updated_at`) VALUES
(5, 1, 1, '10:00', 210, '2021-02-05 13:57:02', '2021-02-05 13:57:02'),
(6, 1, 2, '10:00', 210, '2021-02-05 13:57:02', '2021-02-05 13:57:02'),
(7, 1, 3, '10:00', 210, '2021-02-05 13:57:02', '2021-02-05 13:57:02'),
(8, 1, 4, '10:00', 210, '2021-02-05 13:57:02', '2021-02-05 13:57:02'),
(9, 1, 5, '10:00', 210, '2021-02-05 13:57:02', '2021-02-05 13:57:02'),
(10, 17, 1, '11:00', 90, '2021-02-06 14:04:06', '2021-02-06 14:04:06'),
(11, 17, 3, '11:00', 90, '2021-02-06 14:04:06', '2021-02-06 14:04:06'),
(12, 17, 5, '11:00', 90, '2021-02-06 14:04:06', '2021-02-06 14:04:06'),
(31, 31, 1, '10:__', 1, '2021-02-11 05:11:20', '2021-02-11 05:11:20'),
(109, 33, 1, '10:00', 45, '2021-02-11 22:39:08', '2021-02-11 22:39:08'),
(110, 33, 3, '12:00', 45, '2021-02-11 22:39:22', '2021-02-11 22:39:22'),
(124, 48, 1, '11:00', 1, '2021-02-16 05:46:59', '2021-02-16 05:46:59'),
(125, 48, 3, '11:00', 1, '2021-02-16 05:46:59', '2021-02-16 05:46:59'),
(131, 52, 1, '11:00', 45, '2021-02-16 17:26:29', '2021-02-16 17:26:29'),
(132, 52, 3, '11:00', 45, '2021-02-16 17:26:29', '2021-02-16 17:26:29'),
(133, 52, 5, '11:00', 45, '2021-02-16 17:26:29', '2021-02-16 17:26:29'),
(134, 47, 1, '10:00', 38, '2021-02-16 21:41:23', '2021-02-16 21:41:23'),
(135, 47, 3, '10:00', 38, '2021-02-16 21:41:23', '2021-02-16 21:41:23'),
(136, 47, 5, '16:00', 38, '2021-02-16 21:41:43', '2021-02-16 21:41:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traditum`
--

DROP TABLE IF EXISTS `traditum`;
CREATE TABLE IF NOT EXISTS `traditum` (
  `beneficiario_id` int(11) DEFAULT NULL,
  `codigo` int(11) DEFAULT NULL,
  `mes` tinyint(2) DEFAULT NULL,
  `anio` int(4) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `beneficiario_id` (`beneficiario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `traditum`
--

INSERT INTO `traditum` (`beneficiario_id`, `codigo`, `mes`, `anio`, `updated_at`, `created_at`, `id`) VALUES
(1, 29890, 2, 2021, '2021-02-05 21:32:24', '2021-02-04 19:34:30', 1),
(2, NULL, 2, 2021, '2021-02-04 20:12:10', '2021-02-04 20:12:10', 2),
(3, NULL, 2, 2021, '2021-02-04 23:21:48', '2021-02-04 23:21:48', 3),
(4, NULL, 2, 2021, '2021-02-05 07:00:44', '2021-02-05 07:00:44', 4),
(5, NULL, 2, 2021, '2021-02-05 18:38:56', '2021-02-05 18:38:56', 5),
(6, NULL, 2, 2021, '2021-02-05 22:26:12', '2021-02-05 22:26:12', 6),
(7, NULL, 2, 2021, '2021-02-06 00:05:17', '2021-02-06 00:05:17', 7),
(8, NULL, 2, 2021, '2021-02-06 07:00:49', '2021-02-06 07:00:49', 8),
(9, NULL, 2, 2021, '2021-02-06 07:01:29', '2021-02-06 07:01:29', 9),
(10, NULL, 2, 2021, '2021-02-06 07:11:07', '2021-02-06 07:11:07', 10),
(11, NULL, 2, 2021, '2021-02-06 07:19:58', '2021-02-06 07:19:58', 11),
(12, NULL, 2, 2021, '2021-02-06 07:23:03', '2021-02-06 07:23:03', 12),
(13, NULL, 2, 2021, '2021-02-06 07:35:04', '2021-02-06 07:35:04', 13),
(14, NULL, 2, 2021, '2021-02-06 07:35:17', '2021-02-06 07:35:17', 14),
(15, NULL, 2, 2021, '2021-02-06 07:39:02', '2021-02-06 07:39:02', 15),
(16, NULL, 2, 2021, '2021-02-06 07:45:10', '2021-02-06 07:45:10', 16),
(17, NULL, 2, 2021, '2021-02-06 08:02:14', '2021-02-06 08:02:14', 17),
(18, 121, 2, 2021, '2021-02-09 14:53:58', '2021-02-09 11:53:23', 18),
(19, NULL, 2, 2021, '2021-02-09 11:59:38', '2021-02-09 11:59:38', 19),
(20, NULL, 2, 2021, '2021-02-09 12:03:34', '2021-02-09 12:03:34', 20),
(21, NULL, 2, 2021, '2021-02-09 12:03:34', '2021-02-09 12:03:34', 21),
(22, NULL, 2, 2021, '2021-02-09 12:06:48', '2021-02-09 12:06:48', 22),
(23, NULL, 2, 2021, '2021-02-09 12:07:26', '2021-02-09 12:07:26', 23),
(24, NULL, 2, 2021, '2021-02-09 12:08:08', '2021-02-09 12:08:08', 24),
(25, NULL, 2, 2021, '2021-02-09 12:09:16', '2021-02-09 12:09:16', 25),
(26, NULL, 2, 2021, '2021-02-09 12:24:14', '2021-02-09 12:24:14', 26),
(27, NULL, 2, 2021, '2021-02-09 12:24:54', '2021-02-09 12:24:54', 27),
(28, NULL, 2, 2021, '2021-02-09 23:41:11', '2021-02-09 23:41:11', 28),
(29, NULL, 2, 2021, '2021-02-10 07:56:35', '2021-02-10 07:56:35', 29),
(30, NULL, 2, 2021, '2021-02-10 07:56:35', '2021-02-10 07:56:35', 30),
(31, NULL, 2, 2021, '2021-02-10 23:10:29', '2021-02-10 23:10:29', 31),
(32, NULL, 2, 2021, '2021-02-11 08:07:25', '2021-02-11 08:07:25', 32),
(33, NULL, 2, 2021, '2021-02-11 16:25:53', '2021-02-11 16:25:53', 33),
(34, NULL, 2, 2021, '2021-02-11 16:54:18', '2021-02-11 16:54:18', 34),
(35, NULL, 2, 2021, '2021-02-11 16:56:26', '2021-02-11 16:56:26', 35),
(36, NULL, 2, 2021, '2021-02-11 17:21:47', '2021-02-11 17:21:47', 36),
(37, NULL, 2, 2021, '2021-02-11 17:27:18', '2021-02-11 17:27:18', 37),
(38, NULL, 2, 2021, '2021-02-11 18:05:07', '2021-02-11 18:05:07', 38),
(39, NULL, 2, 2021, '2021-02-12 08:16:01', '2021-02-12 08:16:01', 39),
(40, NULL, 2, 2021, '2021-02-12 10:47:06', '2021-02-12 10:47:06', 40),
(41, NULL, 2, 2021, '2021-02-12 15:59:56', '2021-02-12 15:59:56', 41),
(42, NULL, 2, 2021, '2021-02-12 16:01:21', '2021-02-12 16:01:21', 42),
(43, NULL, 2, 2021, '2021-02-12 19:34:23', '2021-02-12 19:34:23', 43),
(44, NULL, 2, 2021, '2021-02-13 08:48:32', '2021-02-13 08:48:32', 44),
(45, NULL, 2, 2021, '2021-02-13 08:51:14', '2021-02-13 08:51:14', 45),
(46, NULL, 2, 2021, '2021-02-13 08:51:15', '2021-02-13 08:51:15', 46),
(47, NULL, 2, 2021, '2021-02-13 09:21:43', '2021-02-13 09:21:43', 47),
(48, NULL, 2, 2021, '2021-02-13 09:22:21', '2021-02-13 09:22:21', 48),
(49, NULL, 2, 2021, '2021-02-13 09:24:58', '2021-02-13 09:24:58', 49),
(50, NULL, 2, 2021, '2021-02-13 09:28:11', '2021-02-13 09:28:11', 50),
(51, NULL, 2, 2021, '2021-02-13 09:29:34', '2021-02-13 09:29:34', 51),
(52, NULL, 2, 2021, '2021-02-13 09:31:36', '2021-02-13 09:31:36', 52),
(53, NULL, 2, 2021, '2021-02-13 09:32:07', '2021-02-13 09:32:07', 53),
(54, NULL, 2, 2021, '2021-02-13 09:32:36', '2021-02-13 09:32:36', 54),
(55, NULL, 2, 2021, '2021-02-13 09:33:05', '2021-02-13 09:33:05', 55),
(56, NULL, 2, 2021, '2021-02-13 09:33:42', '2021-02-13 09:33:42', 56),
(57, NULL, 2, 2021, '2021-02-13 09:34:15', '2021-02-13 09:34:15', 57),
(58, NULL, 2, 2021, '2021-02-13 09:34:41', '2021-02-13 09:34:41', 58),
(59, NULL, 2, 2021, '2021-02-13 09:35:19', '2021-02-13 09:35:19', 59),
(60, NULL, 2, 2021, '2021-02-13 09:35:46', '2021-02-13 09:35:46', 60),
(61, NULL, 2, 2021, '2021-02-13 09:36:19', '2021-02-13 09:36:19', 61),
(62, NULL, 2, 2021, '2021-02-13 09:37:59', '2021-02-13 09:37:59', 62),
(63, NULL, 2, 2021, '2021-02-23 12:04:19', '2021-02-23 12:04:19', 63);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_provincia` int(11) DEFAULT '1',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `localidad` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condicion_iva` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condicion_iibb` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cuit` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iibb` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entidad_bancaria` varchar(75) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cbu` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden_cheque` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lugar_pago` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_seguros` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poliza` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `mes` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anio` int(11) DEFAULT '2020',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `banned_until` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `id_provincia` (`id_provincia`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `id_provincia`, `email`, `password`, `name`, `surname`, `role`, `direccion`, `localidad`, `telefono`, `condicion_iva`, `condicion_iibb`, `cuit`, `iibb`, `entidad_bancaria`, `cbu`, `orden_cheque`, `lugar_pago`, `emp_seguros`, `poliza`, `active`, `mes`, `anio`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`, `banned_until`) VALUES
(1, 15, 'admin@dorita365.com', '$2y$10$qahyZuHx6ROttxYBvj8tyOLwATT1DklSJUaYzmR3yUmdM8PvvQumi', 'Admin', 'Dorita365', 'Administrador', 'direccion', 'Bariloche', '1135770931', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '01', 2021, NULL, 'w3jkas7jI3EAiH5trXfmoJFLVuZKwCUcvErNLUUWaAI4ArEmHMRfoUcxCdP2', '2020-05-27 18:54:49', '2021-02-03 20:55:43', NULL),
(22, 5, 'adrianporcal@hotmail.com', '$2y$10$rw/jhXwcHrngDhJeTbMZQeKpWJ2wgI/AGN6gtrbUjNs1tICEgRirK', 'ADRIAN MARTIN', 'PORCAL', 'Traslado', 'Pje. Reginaldo Hormaeche n°586, Villa Dolores', 'loca', '03544-15569043', 'Responsable Inscripto', 'Inscripto', '20-29846407-2', '280769126', 'BANCOR', '0200322911000030423426', 'Adrian Martin Porcal', 'CORDOBA', 'Rivadavia', '1234567833333333333333333331', 1, '02', 2021, NULL, NULL, '2021-02-02 01:21:06', '2021-02-07 13:33:30', NULL),
(23, 5, 'crecervdolores@hotmail.com', '$2y$10$qd1rPcO1q9TaWL3KcjE2RuCQaL1rj0OmYwDANsIRCB3yqlySYswcO', 'CRECER', 'S.H.', 'Institucion', '25 de Mayo n°54', NULL, '03544-423413', 'Responsable Inscripto', 'Inscripto', '30-71461771-7', '281383663', 'Bancor', '0200322901000025021601', 'CRECER', 'Córdoba', NULL, NULL, 1, NULL, 2020, NULL, NULL, '2021-02-02 01:43:57', '2021-02-04 20:55:27', NULL),
(25, 5, 'natyporcal@hotmail.com', '$2y$10$s.0QJFbkNlTwXe1Lv2z6LeZpHwPNAmTvlfeCIiVq65cspMGP7o8QW', 'MARIA NATALIA', 'PORCAL RUIZ', 'Traslado', 'Av. Los Pajaros n°565', NULL, '3516157763', 'Monotributo', 'Inscripto', '27-34562843-1', NULL, 'Banco de Córdoba', '0200339711000001806308', 'María Natalia Porcal Ruiz', 'Cordoba', 'Rivadavia', '5202608246', 1, '03', 2021, NULL, NULL, '2021-02-03 00:48:21', '2021-02-03 21:43:18', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videos`
--

DROP TABLE IF EXISTS `videos`;
CREATE TABLE IF NOT EXISTS `videos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_video` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `videos`
--

INSERT INTO `videos` (`id`, `description`, `url_video`, `url_document`, `created_at`, `updated_at`) VALUES
(4, 'COMO ESCUCHAR U2?', 'https://www.youtube.com/watch?v=co6WMzDOh1o', NULL, '2020-08-04 02:06:32', '2020-08-04 02:07:23'),
(5, 'VIDEO INSTRUCTIVO', 'https://www.youtube.com/watch?v=ysYztxSUrcw&t=1s', NULL, '2020-08-04 02:16:28', '2020-08-04 02:16:28'),
(6, '1-APROSS-TRASLADO-COMO VALIDAR!', NULL, '1612180266.pdf', '2020-08-12 21:55:21', '2021-02-01 14:51:06');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
