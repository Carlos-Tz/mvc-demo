-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 06-06-2022 a las 09:18:53
-- Versión del servidor: 5.7.38-log-cll-lve
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inomacmx_pruebas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subrancho`
--

CREATE TABLE `subrancho` (
  `num_subrancho` int(11) NOT NULL,
  `nombre` tinytext,
  `status` tinyint(4) DEFAULT NULL,
  `unidad` int(11) DEFAULT NULL,
  `id_cultivo` int(11) DEFAULT NULL,
  `logo` tinytext,
  `id_compactacionerosion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `subrancho`
--

INSERT INTO `subrancho` (`num_subrancho`, `nombre`, `status`, `unidad`, `id_cultivo`, `logo`, `id_compactacionerosion`) VALUES
(1, 'PabloIhuatzio', 1, NULL, 1, NULL, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
