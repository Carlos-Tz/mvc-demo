-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 12-07-2022 a las 13:36:48
-- Versión del servidor: 5.7.38-log-cll-lve
-- Versión de PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inomacmx_ihuatzio23`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle`
--

CREATE TABLE `detalle` (
  `id_requisicion` int(11) NOT NULL,
  `consecutivo` int(4) DEFAULT NULL,
  `id_prod` int(11) NOT NULL,
  `rfc` varchar(13) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `cantidad` decimal(10,4) NOT NULL,
  `saldo` float(10,2) DEFAULT NULL,
  `precio` float(10,2) DEFAULT NULL,
  `IVA` float(10,2) DEFAULT NULL,
  `status` varchar(15) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `detalle`
--

INSERT INTO `detalle` (`id_requisicion`, `consecutivo`, `id_prod`, `rfc`, `cantidad`, `saldo`, `precio`, `IVA`, `status`) VALUES
(1, 1, 3814, 'GAFG4212219EA', '120.0000', 0.00, 140.00, 0.00, 'Programado'),
(2, 1, 3003, '00000', '6.0000', 0.00, 240.14, 0.16, 'Programado'),
(2, 1, 2999, '00000', '7.0000', 0.00, 240.14, 0.16, 'Programado'),
(2, 1, 3000, '00000', '11.0000', 0.00, 240.14, 0.16, 'Programado'),
(2, 1, 3001, '00000', '4.0000', 0.00, 240.14, 0.16, 'Programado'),
(2, 1, 3002, '00000', '2.0000', 0.00, 240.14, 0.16, 'Programado'),
(2, 1, 2998, '00000', '5.0000', 0.00, 240.14, 0.16, 'Programado'),
(3, NULL, 3815, 'MOVR701222E1', '2.0000', NULL, 31.03, 0.16, 'Pedido'),
(3, NULL, 3816, 'MOVR701222E1', '1.0000', NULL, 44.83, 0.16, 'Pedido'),
(3, NULL, 3817, 'MOVR701222E1', '1.0000', NULL, 112.07, 0.16, 'Pedido'),
(3, NULL, 3699, 'VEP931210HU8', '2.0000', NULL, 7.33, 0.16, 'Pedido'),
(3, NULL, 3818, 'MOVR701222E1', '4.0000', NULL, 24.92, 0.16, 'Pedido'),
(3, NULL, 3795, 'MOVR701222E1', '2.0000', NULL, 14.66, 0.16, 'Pedido'),
(3, NULL, 3819, 'MOVR701222E1', '50.0000', NULL, 83.62, 0.16, 'Pedido'),
(3, NULL, 3820, 'MOVR701222E1', '2.0000', NULL, 107.76, 0.16, 'Pedido'),
(3, NULL, 3821, NULL, '2.0000', NULL, NULL, NULL, NULL),
(3, NULL, 3822, NULL, '1.0000', NULL, NULL, NULL, NULL),
(3, NULL, 3823, NULL, '1.0000', NULL, NULL, NULL, NULL),
(4, 1, 3824, 'MOVR701222E1', '2.0000', 0.00, 65.52, 0.16, 'Programado'),
(5, 1, 3825, 'RBM830810LS5', '2.0000', 0.00, 361.34, 0.16, 'Programado'),
(5, 1, 3826, 'RBM830810LS5', '1.0000', 0.00, 1657.52, 0.16, 'Programado'),
(5, 1, 3827, 'RBM830810LS5', '8.0000', 0.00, 81.82, 0.16, 'Programado'),
(5, 1, 3828, 'RBM830810LS5', '1.0000', 0.00, 319.48, 0.16, 'Programado'),
(5, 1, 3829, 'RBM830810LS5', '1.0000', 0.00, 905.95, 0.16, 'Programado'),
(5, 1, 3830, 'RBM830810LS5', '1.0000', 0.00, 367.29, 0.16, 'Programado'),
(6, 1, 3530, 'IST700911FD5', '266.3800', 0.00, 23.29, 0.00, 'Programado'),
(7, NULL, 3831, 'IRC1202077D6', '2.0000', NULL, 27.59, 0.16, 'Pedido'),
(7, NULL, 3832, 'IRC1202077D6', '1.0000', NULL, 65.00, 0.16, 'Pedido'),
(7, NULL, 3833, 'IRC1202077D6', '15.0000', NULL, 76.00, 0.16, 'Pedido'),
(7, NULL, 3834, 'IRC1202077D6', '2.0000', NULL, 210.00, 0.16, 'Pedido'),
(7, NULL, 3835, 'IRC1202077D6', '8.0000', NULL, 95.00, 0.16, 'Pedido'),
(7, NULL, 3836, 'IRC1202077D6', '2.0000', NULL, 190.50, 0.16, 'Pedido'),
(7, NULL, 3377, 'IRC1202077D6', '1.0000', NULL, 194.00, 0.16, 'Pedido'),
(7, NULL, 3837, NULL, '2.0000', NULL, NULL, NULL, NULL),
(7, NULL, 3838, 'IRC1202077D6', '1.0000', NULL, 7.76, 0.16, 'Pedido'),
(7, NULL, 3689, 'IRC1202077D6', '1.0000', NULL, 372.00, 0.16, 'Pedido'),
(7, NULL, 3839, NULL, '1.0000', NULL, NULL, NULL, NULL),
(7, NULL, 3840, NULL, '2.0000', NULL, NULL, NULL, NULL),
(7, NULL, 3841, NULL, '1.0000', NULL, NULL, NULL, NULL),
(7, NULL, 3842, NULL, '1.0000', NULL, NULL, NULL, NULL),
(8, 1, 3843, 'MSP940906IF7', '1.0000', 0.00, 5700.00, 0.00, 'Programado'),
(9, 1, 3844, 'MOVR701222E1', '1.0000', 0.00, 87.00, 0.00, 'Programado'),
(9, 1, 3845, 'MOVR701222E1', '2.0000', 0.00, 15.00, 0.00, 'Programado'),
(9, 1, 3846, 'MOVR701222E1', '1.5000', 0.00, 61.33, 0.00, 'Programado'),
(9, 1, 3847, 'MOVR701222E1', '1.0000', 0.00, 480.00, 0.00, 'Programado'),
(10, 1, 3854, 'VEP931210HU8', '0.0000', 0.00, 11.19, 0.16, 'Programado'),
(10, 1, 3855, 'VEP931210HU8', '3.0000', 0.00, 23.53, 0.16, 'Programado'),
(10, 1, 3856, 'VEP931210HU8', '6.0000', 0.00, 103.09, 0.16, 'Programado'),
(10, 1, 3857, 'VEP931210HU8', '1.0000', 0.00, 77.74, 0.16, 'Programado'),
(10, 1, 3850, 'VEP931210HU8', '4.0000', 0.00, 59.96, 0.16, 'Programado'),
(10, 1, 3858, 'VEP931210HU8', '3.0000', 0.00, 150.96, 0.16, 'Programado'),
(10, 1, 3859, 'VEP931210HU8', '1.0000', 0.00, 195.78, 0.16, 'Programado'),
(10, 1, 3860, 'VEP931210HU8', '5.0000', 0.00, 153.22, 0.16, 'Programado'),
(10, 1, 3861, 'VEP931210HU8', '1.0000', 0.00, 400.66, 0.16, 'Programado'),
(11, 1, 3833, 'IRC1202077D6', '1.0000', 0.00, 76.00, 0.16, 'Programado'),
(11, 1, 3862, 'IRC1202077D6', '1.0000', 0.00, 210.00, 0.16, 'Programado'),
(11, 1, 3863, 'IRC1202077D6', '4.0000', 0.00, 340.00, 0.16, 'Programado'),
(11, 1, 3864, 'IRC1202077D6', '4.0000', 0.00, 246.33, 0.16, 'Programado'),
(11, 1, 3835, 'IRC1202077D6', '2.0000', 0.00, 190.00, 0.16, 'Programado'),
(11, 1, 3865, 'IRC1202077D6', '2.0000', 0.00, 46.01, 0.16, 'Programado'),
(12, 1, 3848, 'VEP931210HU8', '1.0000', 0.00, 602.96, 0.00, 'Programado'),
(12, 1, 3849, 'VEP931210HU8', '1.0000', 0.00, 57.03, 0.00, 'Programado'),
(12, 1, 3850, 'VEP931210HU8', '3.0000', 0.00, 155.88, 0.00, 'Programado'),
(12, 1, 3851, 'VEP931210HU8', '2.0000', 0.00, 64.78, 0.00, 'Programado'),
(12, 1, 3852, 'VEP931210HU8', '1.0000', 0.00, 84.05, 0.00, 'Programado'),
(12, 1, 3853, 'VEP931210HU8', '2.0000', 0.00, 201.29, 0.00, 'Programado'),
(13, 1, 3866, 'VEP931210HU8', '2.0000', 0.00, 449.76, 0.16, 'Programado'),
(13, 1, 3867, 'VEP931210HU8', '5.0000', 0.00, 14.40, 0.16, 'Programado'),
(14, 1, 3868, 'IST700911FD5', '40.0000', 0.00, 20.19, 0.16, 'Programado'),
(14, 1, 3530, 'IST700911FD5', '40.0000', 0.00, 20.19, 0.16, 'Programado'),
(15, 1, 3869, 'IPF280320223V', '30.0000', 0.00, 2581.76, 0.00, 'Programado'),
(15, 1, 3870, 'IPF280320223V', '26.0000', 0.00, 2001.55, 0.00, 'Programado'),
(16, 1, 3868, 'IST700911FD5', '40.0000', 0.00, 23.35, 0.00, 'Programado'),
(17, 1, 3868, 'IST700911FD5', '108.8700', 0.00, 18.67, 0.16, 'Programado'),
(19, 1, 3873, 'VEP931210HU8', '3.0000', 0.00, 15.60, 0.00, 'Programado'),
(20, NULL, 3896, 'IRC1202077D6', '4.0000', NULL, 4.00, 0.00, 'Pedido'),
(20, NULL, 3895, 'IRC1202077D6', '2.0000', NULL, 326.00, 0.00, 'Pedido'),
(20, NULL, 3894, NULL, '2.0000', NULL, NULL, NULL, NULL),
(20, NULL, 3893, NULL, '6.0000', NULL, NULL, NULL, NULL),
(20, NULL, 3892, 'IRC1202077D6', '2.0000', NULL, 1.00, 0.00, 'Pedido'),
(20, NULL, 3891, 'IRC1202077D6', '3.0000', NULL, 204.00, 0.00, 'Pedido'),
(20, NULL, 3890, NULL, '4.0000', NULL, NULL, NULL, NULL),
(20, NULL, 3889, NULL, '3.0000', NULL, NULL, NULL, NULL),
(20, NULL, 3888, 'IRC1202077D6', '9.0000', NULL, 22.00, 0.00, 'Pedido'),
(20, NULL, 3887, 'IRC1202077D6', '1.0000', NULL, 11.00, 0.00, 'Pedido'),
(20, NULL, 3886, 'IRC1202077D6', '1.0000', NULL, 40.00, 0.00, 'Pedido'),
(20, NULL, 3885, 'IRC1202077D6', '1.0000', NULL, 32.00, 0.00, 'Pedido'),
(20, NULL, 3888, 'IRC1202077D6', '1.0000', NULL, 22.00, 0.00, 'Pedido'),
(20, NULL, 3888, 'IRC1202077D6', '1.0000', NULL, 22.00, 0.00, 'Pedido'),
(21, 1, 3897, 'VEP931210HU8', '4.0000', 0.00, 198.82, 0.16, 'Programado'),
(21, 1, 3898, 'VEP931210HU8', '1.0000', 0.00, 152.77, 0.16, 'Programado'),
(23, 1, 3868, 'IST700911FD5', '100.0000', 0.00, 20.18, 0.16, 'Programado'),
(23, 1, 3487, 'IST700911FD5', '76.4200', 0.00, 18.67, 0.16, 'Programado'),
(25, 1, 3900, 'FJAM1265893S1', '1.0000', 0.00, 9236.33, 0.16, 'Programado'),
(26, 1, 3901, 'RIFA810408C40', '2.0000', 0.00, 340.00, 0.00, 'Programado'),
(27, 1, 3296, '2452255565', '1.0000', 0.00, 2442.00, 0.16, 'Completo'),
(28, 1, 3074, 'CAGF780413140', '1.0000', 0.00, 981.90, 0.16, 'Programado'),
(29, 1, 3902, 'CCG1005047R7', '7.0000', 0.00, 12500.00, 0.00, 'Completo'),
(30, 1, 3487, 'IST700911FD5', '57.0500', NULL, 18.68, 0.16, 'Pedido'),
(31, 1, 3398, 'AGUS96081EP8', '1.0000', 0.00, 5008.33, 0.00, 'Completo'),
(31, 2, 3121, 'FADO9010199G3', '1.0000', 0.00, 65041.41, 0.00, 'Completo'),
(32, 1, 3398, 'AGUS96081EP8', '1.0000', 0.00, 42196.58, 0.00, 'Completo'),
(32, 2, 3121, 'FADO9010199G3', '1.0000', 0.00, 2198.00, 0.00, 'Completo'),
(34, 1, 3220, ' BIO090817EB9', '4.0000', 0.00, 750.00, 0.00, 'Completo'),
(34, 1, 3222, ' BIO090817EB9', '3.2000', 0.00, 937.50, 0.00, 'Completo'),
(34, 1, 3221, ' BIO090817EB9', '4.0000', 0.00, 750.00, 0.00, 'Completo'),
(35, 1, 3394, 'AGUS96081EP8', '14.0000', 0.00, 832.00, 0.00, 'Completo'),
(35, 1, 3393, 'AGUS96081EP8', '5.0000', 0.00, 1732.00, 0.00, 'Completo'),
(35, 1, 3395, 'AGUS96081EP8', '1.0000', 0.00, 1732.00, 0.00, 'Completo'),
(36, 1, 3537, 'PGO110127IX5', '3.0000', NULL, 499.33, 0.00, 'Pedido'),
(36, 2, 3454, 'RDI841003QJ3', '2.0000', NULL, 279.00, 0.00, 'Pedido'),
(37, 1, 3487, 'IST700911FD5', '247.9800', NULL, 21.58, 0.00, 'Pedido'),
(37, 1, 3530, 'IST700911FD5', '89.9700', NULL, 23.34, 0.00, 'Pedido'),
(38, 1, 3904, 'IRC1202077D6', '1.0000', NULL, 182.70, 0.00, 'Pedido'),
(38, 1, 3905, 'IRC1202077D6', '1.0000', NULL, 663.50, 0.00, 'Pedido'),
(38, 1, 3369, 'IRC1202077D6', '2.0000', NULL, 218.00, 0.00, 'Pedido'),
(38, 1, 3864, 'IRC1202077D6', '7.0000', NULL, 180.00, 0.00, 'Pedido'),
(38, 1, 3908, 'IRC1202077D6', '5.0000', NULL, 190.00, 0.00, 'Pedido'),
(38, 1, 3909, 'IRC1202077D6', '1.0000', NULL, 190.00, 0.00, 'Pedido'),
(38, 1, 3910, 'IRC1202077D6', '500.0000', NULL, 8.50, 0.00, 'Pedido'),
(38, 1, 3343, 'IRC1202077D6', '500.0000', NULL, 3.50, 0.00, 'Pedido'),
(39, 1, 3689, 'IRC1202077D6', '2.0000', NULL, 365.00, 0.00, 'Pedido'),
(39, 1, 3714, 'IRC1202077D6', '2.0000', NULL, 212.00, 0.00, 'Pedido'),
(39, 1, 3375, 'IRC1202077D6', '2.0000', NULL, 190.00, 0.00, 'Pedido'),
(40, 1, 3910, 'IRC1202077D6', '150.0000', NULL, 8.50, 0.16, 'Pedido'),
(40, 1, 3343, 'IRC1202077D6', '200.0000', NULL, 3.50, 0.16, 'Pedido'),
(40, 1, 3831, 'IRC1202077D6', '2.0000', NULL, 28.45, 0.16, 'Pedido'),
(41, 1, 3894, 'IRC1202077D6', '2.0000', NULL, 105.00, 0.00, 'Pedido'),
(42, 1, 3343, 'IRC1202077D6', '200.0000', NULL, 3.50, 0.00, 'Pedido'),
(42, 1, 3912, 'IRC1202077D6', '200.0000', NULL, 2.50, 0.00, 'Pedido'),
(42, 1, 3909, 'IRC1202077D6', '2.0000', NULL, 68.00, 0.00, 'Pedido'),
(42, 1, 3891, 'IRC1202077D6', '1.0000', NULL, 199.00, 0.00, 'Pedido'),
(42, 1, 3914, 'IRC1202077D6', '2.0000', NULL, 130.02, 0.00, 'Pedido'),
(42, 1, 3915, 'IRC1202077D6', '1.0000', NULL, 1150.00, 0.00, 'Pedido'),
(42, 1, 3916, 'IRC1202077D6', '1.0000', NULL, 87.00, 0.00, 'Pedido'),
(42, 1, 3887, 'IRC1202077D6', '4.0000', NULL, 12.08, 0.00, 'Pedido'),
(42, 1, 3864, 'IRC1202077D6', '2.0000', NULL, 61.33, 0.00, 'Pedido'),
(43, 1, 3917, 'LEFE651104P93', '10.0000', NULL, 40.00, 0.04, 'Pedido'),
(44, 1, 3923, 'VEP931210HU8', '1.0000', NULL, 49.14, 0.00, 'Pedido'),
(44, 1, 3924, 'VEP931210HU8', '40.0000', NULL, 11.16, 0.00, 'Pedido'),
(44, 1, 3925, 'VEP931210HU8', '1.0000', NULL, 380.26, 0.00, 'Pedido'),
(45, 1, 3921, 'VEP931210HU8', '3.0000', NULL, 91.24, 0.00, 'Pedido'),
(45, 1, 3922, 'VEP931210HU8', '10.0000', NULL, 47.07, 0.00, 'Pedido'),
(46, 1, 3920, 'PECJ810403U40', '200.0000', NULL, 3.50, 0.00, 'Pedido'),
(47, 1, 3919, 'PECJ810403U40', '100.0000', NULL, 4.00, 0.00, 'Pedido'),
(48, 2, 3918, 'PECJ810403U40', '2.0000', NULL, 105.00, 0.00, 'Pedido'),
(48, 1, 3910, 'IRC1202077D6', '50.0000', NULL, 9.90, 0.00, 'Pedido'),
(49, 1, 3911, 'IRC1202077D6', '100.0000', NULL, 4.00, 0.00, 'Pedido'),
(49, 2, 3920, 'PECJ810403U40', '100.0000', NULL, 3.50, 0.00, 'Pedido'),
(49, 2, 3918, 'PECJ810403U40', '2.0000', NULL, 105.00, 0.00, 'Pedido'),
(50, 1, 3352, 'AME970109GW0', '1.0000', NULL, 2429.00, 0.00, 'Pedido'),
(51, NULL, 3926, 'XXXXXX', '1.0000', NULL, 463.79, 0.16, 'Pedido'),
(51, NULL, 3927, NULL, '2.0000', NULL, NULL, NULL, NULL),
(51, NULL, 3928, 'XXXXXX', '2.0000', NULL, 463.79, 0.00, 'Pedido'),
(51, NULL, 3926, 'XXXXXX', '1.0000', NULL, 463.79, 0.16, 'Pedido'),
(51, NULL, 3929, NULL, '1.0000', NULL, NULL, NULL, NULL),
(52, 1, 3870, 'IPF280320223V', '6.0000', NULL, 2530.84, 0.00, 'Pedido'),
(53, 1, 3122, 'RCM021004MV4', '1.0000', NULL, 706.00, 0.00, 'Pedido'),
(54, 1, 3930, 'GAFG4212219EA', '20.0000', 0.00, 135.40, 0.00, 'Completo'),
(55, NULL, 3105, NULL, '1.0000', NULL, NULL, NULL, NULL),
(56, NULL, 3105, NULL, '1.0000', NULL, NULL, NULL, NULL),
(57, NULL, 3931, NULL, '1.0000', NULL, NULL, NULL, NULL),
(57, NULL, 3932, NULL, '7.0000', NULL, NULL, NULL, NULL),
(57, NULL, 3933, NULL, '1.0000', NULL, NULL, NULL, NULL),
(58, NULL, 3934, NULL, '200.0000', NULL, NULL, NULL, NULL),
(59, NULL, 3935, NULL, '2.0000', NULL, NULL, NULL, NULL),
(59, NULL, 3936, NULL, '2.0000', NULL, NULL, NULL, NULL),
(59, NULL, 3937, NULL, '2.0000', NULL, NULL, NULL, NULL),
(59, NULL, 3938, NULL, '1.0000', NULL, NULL, NULL, NULL),
(60, NULL, 3454, NULL, '1.0000', NULL, NULL, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalle`
--
ALTER TABLE `detalle`
  ADD KEY `id_prod` (`id_prod`),
  ADD KEY `id_requisicion` (`id_requisicion`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle`
--
ALTER TABLE `detalle`
  ADD CONSTRAINT `detalle_ibfk_1` FOREIGN KEY (`id_prod`) REFERENCES `producto` (`id_prod`),
  ADD CONSTRAINT `detalle_ibfk_2` FOREIGN KEY (`id_requisicion`) REFERENCES `requisicion` (`id_requisicion`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
