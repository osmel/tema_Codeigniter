-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 01, 2017 at 05:07 PM
-- Server version: 5.5.50-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gestion_proyecto`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `SUBSTR_COUNT`(`s` VARCHAR(255), `ss` VARCHAR(255)) RETURNS tinyint(3) unsigned
    READS SQL DATA
BEGIN
      DECLARE v_count, v_haystack_len, v_needle_len, v_offset, v_endpos int unsigned DEFAULT 0;

      SET v_haystack_len = CHAR_LENGTH(in_haystack),
          v_needle_len   = CHAR_LENGTH(in_needle),
          v_offset       = IF(in_offset IS NOT NULL AND in_offset > 0, in_offset, 1),
          v_endpos       = IF(in_length IS NOT NULL AND in_length > 0, v_offset + in_length, v_haystack_len);

      -- The last offset to use with LOCATE is at v_endpos - v_needle_len.
      -- That also means that if v_needlen > v_endpos, the count is trivially 0
      IF (v_endpos > v_needle_len) THEN
         SET v_endpos = v_endpos - v_needle_len;
         WHILE (v_offset < v_endpos) DO
            SET v_offset = LOCATE(in_needle, in_haystack, v_offset);
            IF (v_offset > 0) THEN
               -- v_offset is now the position of the first letter in the needle.
               -- Skip the length of the needle to avoid double counting.
               SET v_count  = v_count  + 1,
                  v_offset = v_offset + v_needle_len;
            ELSE
               -- The needle was not found. Set v_offset = v_endpos to exit the loop.
               SET v_offset = v_endpos;
            END IF;
         END WHILE;
      END IF;

      RETURN v_count;
   END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `inven_bitacora_entornos`
--

CREATE TABLE IF NOT EXISTS `inven_bitacora_entornos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` varchar(36) NOT NULL,
  `operacion` varchar(1) NOT NULL,
  `id_entorno` int(11) NOT NULL,
  `entorno` varchar(256) NOT NULL,
  `tabla` varchar(100) NOT NULL,
  `profundidad` int(11) NOT NULL,
  `ruta` text NOT NULL,
  `tooltip` varchar(256) NOT NULL,
  `id_usuario` varchar(36) NOT NULL,
  `id_user_cambio` varchar(36) NOT NULL,
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

-- --------------------------------------------------------

--
-- Table structure for table `inven_bitacora_proyectos`
--

CREATE TABLE IF NOT EXISTS `inven_bitacora_proyectos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` varchar(36) NOT NULL,
  `operacion` varchar(1) NOT NULL,
  `id_proyecto` int(11) NOT NULL,
  `id_entorno` int(11) NOT NULL,
  `importe` float(10,2) NOT NULL,
  `Proyecto` varchar(256) NOT NULL,
  `tabla` varchar(100) NOT NULL,
  `profundidad` int(11) NOT NULL,
  `ruta` text NOT NULL,
  `tooltip` varchar(256) NOT NULL,
  `id_usuario` varchar(36) NOT NULL,
  `id_user_cambio` varchar(36) NOT NULL,
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=106 ;

--
-- Dumping data for table `inven_bitacora_proyectos`
--

INSERT INTO `inven_bitacora_proyectos` (`id`, `id_user`, `operacion`, `id_proyecto`, `id_entorno`, `importe`, `Proyecto`, `tabla`, `profundidad`, `ruta`, `tooltip`, `id_usuario`, `id_user_cambio`, `fecha_mac`) VALUES
(70, '65350f7e-d031-11e5-b036-04015a6da701', 'c', 79, 1, 0.00, 'Proyectos_20170224091034BQMc018', '20170224091034BQMc018', 1, 'Proyectos_20170224091034BQMc018', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 15:10:34'),
(71, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 79, 1, 0.00, 'Proyectos_20170224091034BQMc018', '20170224091034BQMc018', 1, 'Proyectos_20170224091034BQMc018', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 15:10:36'),
(72, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 79, 1, 0.00, 'osmel', '20170224091034BQMc018', 2, 'osmel / uno', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 15:10:50'),
(73, '65350f7e-d031-11e5-b036-04015a6da701', 'c', 80, 1, 0.00, 'Proyectos_20170224094241VJCq816', '20170224094241VJCq816', 1, 'Proyectos_20170224094241VJCq816', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 15:42:41'),
(74, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 80, 1, 0.00, 'Proyectos_20170224094241VJCq816', '20170224094241VJCq816', 1, 'Proyectos_20170224094241VJCq816', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 15:42:44'),
(75, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 80, 1, 3000.00, 'otro', '20170224094241VJCq816', 1, 'otro', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 15:42:55'),
(76, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 80, 1, 90000.00, 'otro', '20170224094241VJCq816', 2, 'otro / asdas', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 16:55:15'),
(77, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 79, 1, 20.00, 'osmel', '20170224091034BQMc018', 4, 'osmel / uno / dos / tres / cuatro / cinco', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 16:58:27'),
(78, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 79, 1, 20.00, 'osmel', '20170224091034BQMc018', 4, 'osmel / uno / dos / tres / cuatro / cinco', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 17:05:48'),
(79, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 79, 1, 20.00, 'osmel', '20170224091034BQMc018', 4, 'osmel / uno / dos / tres / cuatro / cinco', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 17:06:18'),
(80, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 79, 1, 20.00, 'osmel', '20170224091034BQMc018', 4, 'osmel / uno / dos / tres / cuatro / cinco', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 17:19:44'),
(81, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 79, 1, 20.00, 'osmel', '20170224091034BQMc018', 4, 'osmel / uno / dos / tres / cuatro / cinco', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 17:27:54'),
(82, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 79, 1, 30000.00, 'osmel', '20170224091034BQMc018', 4, 'osmel / uno / dos / tres / cuatro / cinco', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-27 14:25:41'),
(83, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 79, 1, 30000.00, 'osmel', '20170224091034BQMc018', 4, 'osmel / uno / dos / tres / cuatro / cinco', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-27 15:00:49'),
(84, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 79, 1, 30000.00, 'osmel', '20170224091034BQMc018', 4, 'osmel / uno / dos / tres / cuatro / cinco', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-27 17:03:14'),
(85, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 79, 1, 30000.00, 'osmel', '20170224091034BQMc018', 4, 'osmel / uno / dos / tres / cuatro / cinco', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-27 17:03:22'),
(86, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 79, 1, 30000.00, 'osmel', '20170224091034BQMc018', 4, 'osmel / uno / dos / tres / cuatro / cinco', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-27 17:04:13'),
(87, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 79, 1, 30000.00, 'osmel', '20170224091034BQMc018', 4, 'osmel / uno / dos / tres / cuatro / cinco', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-27 17:07:34'),
(88, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 79, 1, 30000.00, 'osmel', '20170224091034BQMc018', 4, 'osmel / uno / dos / tres / cuatro / cinco', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-27 17:08:15'),
(89, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 79, 1, 30000.00, 'osmel', '20170224091034BQMc018', 4, 'osmel / uno / dos / tres / cuatro / cinco', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-27 17:08:42'),
(90, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 79, 1, 30000.00, 'osmel', '20170224091034BQMc018', 4, 'osmel / uno / dos / tres / cuatro / cinco', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-27 22:58:37'),
(91, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 79, 1, 30000.00, 'osmel', '20170224091034BQMc018', 4, 'osmel / uno / dos / tres / cuatro / cinco', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-27 22:58:59'),
(92, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 79, 1, 30000.00, 'osmel', '20170224091034BQMc018', 4, 'osmel / uno / dos / tres / cuatro / cinco', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-27 23:00:18'),
(93, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 79, 1, 30000.00, 'osmel', '20170224091034BQMc018', 4, 'osmel / uno / dos / tres / cuatro / cinco', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-28 14:22:13'),
(94, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 79, 1, 30000.00, 'osmel', '20170224091034BQMc018', 4, 'osmel / uno / dos / tres / cuatro / cinco', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-28 14:23:06'),
(95, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 79, 1, 30000.00, 'osmel', '20170224091034BQMc018', 4, 'osmel / uno / dos / tres / cuatro / cinco', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-28 17:06:52'),
(96, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 79, 1, 30000.00, 'osmel', '20170224091034BQMc018', 4, 'osmel / uno / dos / tres / cuatro / cinco', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-28 17:08:12'),
(97, '65350f7e-d031-11e5-b036-04015a6da701', 'c', 81, 1, 0.00, 'Proyectos_20170301122535dNDW429', '20170301122535dNDW429', 1, 'Proyectos_20170301122535dNDW429', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-03-01 18:25:37'),
(98, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 81, 1, 0.00, 'Proyectos_20170301122535dNDW429', '20170301122535dNDW429', 1, 'Proyectos_20170301122535dNDW429', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-03-01 18:25:39'),
(99, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 81, 1, 0.00, 'iniciativa', '20170301122535dNDW429', 2, 'iniciativa / uno / dos / tres', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-03-01 18:29:13'),
(100, '65350f7e-d031-11e5-b036-04015a6da701', 'c', 82, 1, 0.00, 'Proyectos_20170301123116UblE405', '20170301123116UblE405', 1, 'Proyectos_20170301123116UblE405', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-03-01 18:31:17'),
(101, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 82, 1, 0.00, 'Proyectos_20170301123116UblE405', '20170301123116UblE405', 1, 'Proyectos_20170301123116UblE405', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-03-01 18:31:20'),
(102, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 82, 1, 0.00, 'ventas de auto', '20170301123116UblE405', 2, 'ventas de auto / auto1 / auto2', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-03-01 18:31:36'),
(103, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 82, 1, 0.00, 'ventas de auto', '20170301123116UblE405', 2, 'ventas de auto / auto1 / auto2', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-03-01 18:32:26'),
(104, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 82, 1, 0.00, 'ventas de auto', '20170301123116UblE405', 2, 'ventas de auto / auto1 / auto2', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-03-01 18:33:14'),
(105, '65350f7e-d031-11e5-b036-04015a6da701', 'm', 80, 1, 1.00, 'otro', '20170224094241VJCq816', 3, 'otro / uno / dos', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-03-01 21:18:47');

-- --------------------------------------------------------

--
-- Table structure for table `inven_catalogo_cargos`
--

CREATE TABLE IF NOT EXISTS `inven_catalogo_cargos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cargo` varchar(100) DEFAULT NULL,
  `lider` bigint(20) NOT NULL,
  `activo` bigint(1) NOT NULL DEFAULT '1',
  `id_usuario` varchar(36) NOT NULL,
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `inven_catalogo_cargos`
--

INSERT INTO `inven_catalogo_cargos` (`id`, `cargo`, `lider`, `activo`, `id_usuario`, `fecha_mac`) VALUES
(1, 'Desarrollador Backend', 0, 1, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-17 17:54:52'),
(2, 'Desarrollador web', 0, 1, 'b69d7d2b-582b-11e6-aeb5-7071bce181c3', '2017-02-16 18:27:55'),
(3, 'Director TI', 0, 1, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-17 17:18:46'),
(4, 'DiseÃ±ador', 0, 1, 'b69d7d2b-582b-11e6-aeb5-7071bce181c3', '2017-02-16 18:28:20'),
(5, 'Director de DiseÃ±o', 0, 1, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-17 17:18:30'),
(6, 'Investigador', 0, 1, 'b69d7d2b-582b-11e6-aeb5-7071bce181c3', '2017-02-16 18:41:09'),
(7, 'Director', 0, 1, 'b69d7d2b-582b-11e6-aeb5-7071bce181c3', '2017-02-16 21:59:25'),
(8, 'otros', 0, 1, 'b69d7d2b-582b-11e6-aeb5-7071bce181c3', '2017-02-16 21:59:21');

-- --------------------------------------------------------

--
-- Table structure for table `inven_catalogo_configuraciones`
--

CREATE TABLE IF NOT EXISTS `inven_catalogo_configuraciones` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `configuracion` text NOT NULL,
  `valor` bigint(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` float(10,2) NOT NULL,
  `activo` bigint(1) NOT NULL DEFAULT '0',
  `tooltip` varchar(256) NOT NULL,
  `consecutivo` int(11) NOT NULL,
  `fecha_pc` int(11) NOT NULL,
  `id_usuario` varchar(36) NOT NULL,
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `orden` int(11) NOT NULL,
  `grupo` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `inven_catalogo_configuraciones`
--

INSERT INTO `inven_catalogo_configuraciones` (`id`, `configuracion`, `valor`, `nombre`, `precio`, `activo`, `tooltip`, `consecutivo`, `fecha_pc`, `id_usuario`, `fecha_mac`, `orden`, `grupo`) VALUES
(1, 'Profundidad Ãrbol Entorno', 6, '', 0.00, 1, '', 0, 0, 'b69d7d2b-582b-11e6-aeb5-7071bce181c3', '2017-02-20 15:39:28', 0, ''),
(2, 'Entorno por defecto simple', 0, '', 16.00, 1, '', 0, 0, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-17 15:24:02', 0, ''),
(3, 'Proyecto por defecto Multiple', 1, '', 0.00, 0, '', 0, 0, '', '2017-02-11 19:39:00', 0, ''),
(4, 'Gastos Administrativos', 40000, '', 40000.00, 1, '', 0, 0, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 14:39:12', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `inven_catalogo_empresas`
--

CREATE TABLE IF NOT EXISTS `inven_catalogo_empresas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(45) DEFAULT NULL,
  `area` varchar(45) DEFAULT NULL,
  `monto` float(8,2) DEFAULT NULL,
  `dias_ctas_pagar` int(11) NOT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `id_usuario` varchar(36) NOT NULL,
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `coleccion_id_actividad` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `inven_catalogo_empresas`
--

INSERT INTO `inven_catalogo_empresas` (`id`, `uid`, `area`, `monto`, `dias_ctas_pagar`, `direccion`, `telefono`, `id_usuario`, `fecha_mac`, `coleccion_id_actividad`) VALUES
(1, NULL, 'DirecciÃ³n', 90000.00, 0, '', '103', '32683212-21d2-11e5-aa7c-04015a6da701', '2017-02-16 21:06:29', '["1"]'),
(2, NULL, 'AdministraciÃ³n', 9000.00, 0, '', '106', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-17 15:15:30', '["1"]'),
(3, NULL, 'InvestigaciÃ³n', 90000.00, 0, 'MANUFACTURAS KALTEX, S.A. DE C.V.', '105', '00e922a0-b632-11e5-b036-04015a6da701', '2017-02-16 21:06:44', '["1"]'),
(4, NULL, 'Cuentas', 90000.00, 0, '', '107', '32683212-21d2-11e5-aa7c-04015a6da701', '2017-02-16 21:06:50', '["1"]'),
(5, NULL, 'Marketing Digital\n', 90000.00, 0, '', '108', '32683212-21d2-11e5-aa7c-04015a6da701', '2017-02-16 21:06:56', '["1"]'),
(6, 'NULL', 'DiseÃ±o', 90000.00, 0, '', '104', '32683212-21d2-11e5-aa7c-04015a6da701', '2017-02-16 21:16:13', '["1"]'),
(7, '', 'Comercial', 90000.00, 0, NULL, '200', '', '2017-02-16 21:16:24', '["1"]'),
(8, '', 'Tecnologias de la InformaciÃ³n', 90000.00, 0, NULL, '201', '', '2017-02-16 21:16:26', '["1"]');

-- --------------------------------------------------------

--
-- Table structure for table `inven_catalogo_entornos`
--

CREATE TABLE IF NOT EXISTS `inven_catalogo_entornos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entorno` varchar(256) NOT NULL,
  `tabla` varchar(100) NOT NULL,
  `profundidad` int(11) NOT NULL,
  `ruta` text NOT NULL,
  `tooltip` varchar(256) NOT NULL,
  `id_usuario` varchar(36) NOT NULL,
  `id_user_cambio` varchar(36) NOT NULL,
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `inven_catalogo_entornos`
--

INSERT INTO `inven_catalogo_entornos` (`id`, `entorno`, `tabla`, `profundidad`, `ruta`, `tooltip`, `id_usuario`, `id_user_cambio`, `fecha_mac`) VALUES
(1, 'General', 'osmel10125630aPJR256', 4, 'Proyecto / Etapas / Tarea / SubTareas', '', '65350f7e-d031-11e5-b036-04015a6da701', '', '2017-02-13 21:13:15');

-- --------------------------------------------------------

--
-- Table structure for table `inven_catalogo_operaciones`
--

CREATE TABLE IF NOT EXISTS `inven_catalogo_operaciones` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `operacion` text NOT NULL,
  `tooltip` varchar(256) NOT NULL,
  `consecutivo` int(11) NOT NULL,
  `conse_factura` int(11) NOT NULL,
  `conse_remision` int(11) NOT NULL,
  `conse_surtido` int(11) NOT NULL,
  `conse_ajuste_factura` int(11) NOT NULL,
  `conse_ajuste_remision` int(11) NOT NULL,
  `fecha_pc` int(11) NOT NULL,
  `id_usuario` varchar(36) NOT NULL,
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `orden` int(11) NOT NULL,
  `grupo` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `inven_catalogo_operaciones`
--

INSERT INTO `inven_catalogo_operaciones` (`id`, `operacion`, `tooltip`, `consecutivo`, `conse_factura`, `conse_remision`, `conse_surtido`, `conse_ajuste_factura`, `conse_ajuste_remision`, `fecha_pc`, `id_usuario`, `fecha_mac`, `orden`, `grupo`) VALUES
(1, 'Entornos', 'Permite el acceso a la secciÃ³n de generar Entradas al AlmacÃ©n.', 0, 1, 1, 0, 4, 5, 0, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-09 21:59:18', 1, 'Operaciones'),
(2, 'Proyectos', 'Permite el acceso a la secciÃ³n de generar Salidas del AlmacÃ©n.', 0, 0, 0, 0, 7, 9, 0, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-09 21:59:24', 3, 'Operaciones'),
(3, 'Usuarios', 'Permite el acceso a la administraciÃ³n de alta/baja de usuarios.', 0, 0, 0, 0, 0, 0, 0, '', '2017-02-23 20:20:13', 0, ''),
(4, 'Todos los CatÃ¡logos', '', 0, 0, 0, 0, 0, 0, 0, '', '2017-02-23 21:02:23', 0, ''),
(5, 'Reportes', '', 0, 0, 0, 0, 0, 0, 0, '', '2017-02-28 15:04:57', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `inven_catalogo_proyectos`
--

CREATE TABLE IF NOT EXISTS `inven_catalogo_proyectos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_entorno` int(11) NOT NULL,
  `importe` float(10,2) NOT NULL,
  `Proyecto` varchar(256) NOT NULL,
  `tabla` varchar(100) NOT NULL,
  `profundidad` int(11) NOT NULL,
  `ruta` text NOT NULL,
  `tooltip` varchar(256) NOT NULL,
  `id_usuario` varchar(36) NOT NULL,
  `id_user_cambio` varchar(36) NOT NULL,
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=83 ;

--
-- Dumping data for table `inven_catalogo_proyectos`
--

INSERT INTO `inven_catalogo_proyectos` (`id`, `id_entorno`, `importe`, `Proyecto`, `tabla`, `profundidad`, `ruta`, `tooltip`, `id_usuario`, `id_user_cambio`, `fecha_mac`) VALUES
(79, 1, 30000.00, 'osmel', '20170224091034BQMc018', 4, 'osmel / uno / dos / tres / cuatro / cinco / otro / otro2', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-03-01 18:28:52'),
(80, 1, 1.00, 'otro', '20170224094241VJCq816', 3, 'otro / uno / dos', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-27 18:59:55'),
(81, 1, 0.00, 'iniciativa', '20170301122535dNDW429', 2, 'iniciativa / uno / dos / tres', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-03-01 18:29:13'),
(82, 1, 0.00, 'ventas de auto', '20170301123116UblE405', 2, 'ventas de auto / auto1 / auto2', '', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-03-01 18:31:36');

-- --------------------------------------------------------

--
-- Table structure for table `inven_data_osmel10125630aPJR256`
--

CREATE TABLE IF NOT EXISTS `inven_data_osmel10125630aPJR256` (
  `id` int(11) unsigned NOT NULL,
  `nm` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inven_data_osmel10125630aPJR256`
--

INSERT INTO `inven_data_osmel10125630aPJR256` (`id`, `nm`) VALUES
(1, 'Proyecto'),
(2, 'Etapas'),
(3, 'Tarea'),
(4, 'SubTareas');

-- --------------------------------------------------------

--
-- Table structure for table `inven_historico_acceso`
--

CREATE TABLE IF NOT EXISTS `inven_historico_acceso` (
  `id_usuario` varchar(36) DEFAULT NULL,
  `email` varbinary(128) DEFAULT NULL,
  `id_perfil` int(2) DEFAULT NULL,
  `fecha` int(11) DEFAULT NULL,
  `estatus` varchar(1) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL,
  `user_agent` varchar(120) NOT NULL,
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inven_pdata_20170224091034BQMc018`
--

CREATE TABLE IF NOT EXISTS `inven_pdata_20170224091034BQMc018` (
  `id` int(11) unsigned NOT NULL,
  `nm` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inven_pdata_20170224091034BQMc018`
--

INSERT INTO `inven_pdata_20170224091034BQMc018` (`id`, `nm`) VALUES
(1, 'osmel'),
(2, 'uno'),
(3, 'dos'),
(4, 'tres'),
(5, 'cuatro'),
(6, 'cinco'),
(7, 'otro'),
(8, 'otro2');

-- --------------------------------------------------------

--
-- Table structure for table `inven_pdata_20170224094241VJCq816`
--

CREATE TABLE IF NOT EXISTS `inven_pdata_20170224094241VJCq816` (
  `id` int(11) unsigned NOT NULL,
  `nm` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inven_pdata_20170224094241VJCq816`
--

INSERT INTO `inven_pdata_20170224094241VJCq816` (`id`, `nm`) VALUES
(1, 'otro'),
(2, 'uno'),
(3, 'dos');

-- --------------------------------------------------------

--
-- Table structure for table `inven_pdata_20170301122535dNDW429`
--

CREATE TABLE IF NOT EXISTS `inven_pdata_20170301122535dNDW429` (
  `id` int(11) unsigned NOT NULL,
  `nm` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inven_pdata_20170301122535dNDW429`
--

INSERT INTO `inven_pdata_20170301122535dNDW429` (`id`, `nm`) VALUES
(1, 'iniciativa'),
(2, 'uno'),
(3, 'dos'),
(4, 'tres');

-- --------------------------------------------------------

--
-- Table structure for table `inven_pdata_20170301123116UblE405`
--

CREATE TABLE IF NOT EXISTS `inven_pdata_20170301123116UblE405` (
  `id` int(11) unsigned NOT NULL,
  `nm` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inven_pdata_20170301123116UblE405`
--

INSERT INTO `inven_pdata_20170301123116UblE405` (`id`, `nm`) VALUES
(1, 'ventas de auto'),
(2, 'auto1'),
(3, 'auto2');

-- --------------------------------------------------------

--
-- Table structure for table `inven_perfiles`
--

CREATE TABLE IF NOT EXISTS `inven_perfiles` (
  `id_perfil` int(2) NOT NULL,
  `perfil` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `operacion` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'R' COMMENT 'CRUD V-Votar F-Finalista M-Mover obsoleto',
  `id_usuario` varchar(36) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_perfil`),
  KEY `id_perfil` (`id_perfil`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `inven_perfiles`
--

INSERT INTO `inven_perfiles` (`id_perfil`, `perfil`, `operacion`, `id_usuario`, `fecha_mac`) VALUES
(1, 'Super Administrador', 'CRUDFGM', '', '0000-00-00 00:00:00'),
(4, 'Trabajador', 'R', '', '2017-02-20 14:37:46'),
(2, 'Administrador', 'R', '', '0000-00-00 00:00:00'),
(3, 'Lider', 'R', '', '2017-02-20 14:37:42');

-- --------------------------------------------------------

--
-- Table structure for table `inven_pstruct_20170224091034BQMc018`
--

CREATE TABLE IF NOT EXISTS `inven_pstruct_20170224091034BQMc018` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lft` int(11) unsigned NOT NULL,
  `rgt` int(11) unsigned NOT NULL,
  `lvl` int(11) unsigned NOT NULL,
  `pid` int(11) unsigned NOT NULL,
  `pos` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `inven_pstruct_20170224091034BQMc018`
--

INSERT INTO `inven_pstruct_20170224091034BQMc018` (`id`, `lft`, `rgt`, `lvl`, `pid`, `pos`) VALUES
(1, 1, 16, 0, 0, 0),
(2, 2, 11, 1, 1, 0),
(3, 3, 8, 2, 2, 0),
(4, 4, 5, 3, 3, 0),
(5, 6, 7, 3, 3, 1),
(6, 9, 10, 2, 2, 1),
(7, 12, 13, 1, 1, 1),
(8, 14, 15, 1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `inven_pstruct_20170224094241VJCq816`
--

CREATE TABLE IF NOT EXISTS `inven_pstruct_20170224094241VJCq816` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lft` int(11) unsigned NOT NULL,
  `rgt` int(11) unsigned NOT NULL,
  `lvl` int(11) unsigned NOT NULL,
  `pid` int(11) unsigned NOT NULL,
  `pos` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `inven_pstruct_20170224094241VJCq816`
--

INSERT INTO `inven_pstruct_20170224094241VJCq816` (`id`, `lft`, `rgt`, `lvl`, `pid`, `pos`) VALUES
(1, 1, 6, 0, 0, 0),
(2, 2, 5, 1, 1, 0),
(3, 3, 4, 2, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `inven_pstruct_20170301122535dNDW429`
--

CREATE TABLE IF NOT EXISTS `inven_pstruct_20170301122535dNDW429` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lft` int(11) unsigned NOT NULL,
  `rgt` int(11) unsigned NOT NULL,
  `lvl` int(11) unsigned NOT NULL,
  `pid` int(11) unsigned NOT NULL,
  `pos` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `inven_pstruct_20170301122535dNDW429`
--

INSERT INTO `inven_pstruct_20170301122535dNDW429` (`id`, `lft`, `rgt`, `lvl`, `pid`, `pos`) VALUES
(1, 1, 8, 0, 0, 0),
(2, 2, 3, 1, 1, 0),
(3, 4, 5, 1, 1, 1),
(4, 6, 7, 1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `inven_pstruct_20170301123116UblE405`
--

CREATE TABLE IF NOT EXISTS `inven_pstruct_20170301123116UblE405` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lft` int(11) unsigned NOT NULL,
  `rgt` int(11) unsigned NOT NULL,
  `lvl` int(11) unsigned NOT NULL,
  `pid` int(11) unsigned NOT NULL,
  `pos` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `inven_pstruct_20170301123116UblE405`
--

INSERT INTO `inven_pstruct_20170301123116UblE405` (`id`, `lft`, `rgt`, `lvl`, `pid`, `pos`) VALUES
(1, 1, 6, 0, 0, 0),
(2, 2, 3, 1, 1, 0),
(3, 4, 5, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `inven_registro_nivel2`
--

CREATE TABLE IF NOT EXISTS `inven_registro_nivel2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_entorno` int(11) NOT NULL,
  `id_proyecto` int(11) NOT NULL,
  `id_nivel` int(11) NOT NULL,
  `profundidad` int(11) NOT NULL,
  `nombre` varchar(256) NOT NULL,
  `descripcion` text NOT NULL,
  `costo` float(10,2) NOT NULL,
  `tiempo_disponible` float(10,2) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `fecha_inicial` datetime NOT NULL,
  `fecha_final` datetime NOT NULL,
  `id_val` text NOT NULL,
  `json_items` text NOT NULL,
  `id_usuario` varchar(36) NOT NULL,
  `id_user_cambio` varchar(36) NOT NULL,
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `inven_registro_nivel2`
--

INSERT INTO `inven_registro_nivel2` (`id`, `id_entorno`, `id_proyecto`, `id_nivel`, `profundidad`, `nombre`, `descripcion`, `costo`, `tiempo_disponible`, `fecha_creacion`, `fecha_inicial`, `fecha_final`, `id_val`, `json_items`, `id_usuario`, `id_user_cambio`, `fecha_mac`) VALUES
(10, 1, 79, 2, 2, 'cinco', '', 0.00, 3.00, '2017-02-24 00:00:00', '2017-02-26 00:00:00', '2017-02-27 00:00:00', '"65350f7e-d031-11e5-b036-04015a6da701,00e10de5-f491-11e6-b097-7071bce181c3"', '[{"id":"65350f7e-d031-11e5-b036-04015a6da701","nombre":"Jorge"},{"id":"00e10de5-f491-11e6-b097-7071bce181c3","nombre":"Osmel"}]', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-03-01 18:29:32'),
(11, 1, 80, 2, 2, 'dos', '', 0.00, 3.00, '2017-02-24 00:00:00', '1969-12-31 00:00:00', '1969-12-31 00:00:00', '"d86270f7-f22e-11e6-8df6-7071bce181c3"', '[{"id":"d86270f7-f22e-11e6-8df6-7071bce181c3","nombre":"Adrian"}]', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-03-01 21:18:34'),
(12, 1, 82, 2, 2, 'ventas de auto', '', 0.00, 0.00, '2017-03-01 00:00:00', '1969-12-31 00:00:00', '1969-12-31 00:00:00', '"00e10de5-f491-11e6-b097-7071bce181c3"', '[{"id":"00e10de5-f491-11e6-b097-7071bce181c3","nombre":"Osmel"}]', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-03-01 18:35:13'),
(13, 1, 82, 3, 2, 'auto1', '', 0.00, 0.00, '2017-03-01 00:00:00', '1969-12-31 00:00:00', '1969-12-31 00:00:00', '""', '[]', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-03-01 18:35:06'),
(14, 1, 81, 3, 2, 'tres', '', 0.00, 0.00, '2017-03-01 00:00:00', '1969-12-31 00:00:00', '1969-12-31 00:00:00', '""', '[]', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-03-01 18:35:49'),
(15, 1, 81, 4, 2, 'iniciativa', '', 0.00, 0.00, '2017-03-01 00:00:00', '1969-12-31 00:00:00', '1969-12-31 00:00:00', '""', '[]', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-03-01 18:35:50'),
(16, 1, 81, 2, 2, 'iniciativa', '', 0.00, 0.00, '2017-03-01 00:00:00', '1969-12-31 00:00:00', '1969-12-31 00:00:00', '""', '[]', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-03-01 18:35:47');

-- --------------------------------------------------------

--
-- Table structure for table `inven_registro_nivel3`
--

CREATE TABLE IF NOT EXISTS `inven_registro_nivel3` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_entorno` int(11) NOT NULL,
  `id_proyecto` int(11) NOT NULL,
  `id_nivel` int(11) NOT NULL,
  `profundidad` int(11) NOT NULL,
  `nombre` varchar(256) NOT NULL,
  `descripcion` text NOT NULL,
  `costo` float(10,2) NOT NULL,
  `tiempo_disponible` float(10,2) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `fecha_inicial` datetime NOT NULL,
  `fecha_final` datetime NOT NULL,
  `id_val` text NOT NULL,
  `json_items` text NOT NULL,
  `id_usuario` varchar(36) NOT NULL,
  `id_user_cambio` varchar(36) NOT NULL,
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `inven_registro_nivel3`
--

INSERT INTO `inven_registro_nivel3` (`id`, `id_entorno`, `id_proyecto`, `id_nivel`, `profundidad`, `nombre`, `descripcion`, `costo`, `tiempo_disponible`, `fecha_creacion`, `fecha_inicial`, `fecha_final`, `id_val`, `json_items`, `id_usuario`, `id_user_cambio`, `fecha_mac`) VALUES
(5, 1, 79, 3, 3, 'uno', '', 0.00, 0.00, '2017-02-24 00:00:00', '2017-02-26 00:00:00', '2017-02-27 00:00:00', '"65350f7e-d031-11e5-b036-04015a6da701,00e10de5-f491-11e6-b097-7071bce181c3"', '[{"id":"65350f7e-d031-11e5-b036-04015a6da701","nombre":"Jorge"},{"id":"00e10de5-f491-11e6-b097-7071bce181c3","nombre":"Osmel"}]', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-28 17:26:15'),
(6, 1, 79, 6, 3, 'tres', '', 0.00, 0.00, '2017-02-24 00:00:00', '1969-12-31 00:00:00', '1969-12-31 00:00:00', '""', '[]', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-03-01 18:29:37'),
(7, 1, 80, 3, 3, 'dos', '', 0.00, 0.00, '2017-02-24 00:00:00', '1969-12-31 00:00:00', '1969-12-31 00:00:00', '"b3728c39-f48f-11e6-b097-7071bce181c3"', '[{"id":"b3728c39-f48f-11e6-b097-7071bce181c3","nombre":"Marissa"}]', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-03-01 21:18:50');

-- --------------------------------------------------------

--
-- Table structure for table `inven_registro_nivel4`
--

CREATE TABLE IF NOT EXISTS `inven_registro_nivel4` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_entorno` int(11) NOT NULL,
  `id_proyecto` int(11) NOT NULL,
  `id_nivel` int(11) NOT NULL,
  `profundidad` int(11) NOT NULL,
  `nombre` varchar(256) NOT NULL,
  `descripcion` text NOT NULL,
  `costo` float(10,2) NOT NULL,
  `tiempo_disponible` float(10,2) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `fecha_inicial` datetime NOT NULL,
  `fecha_final` datetime NOT NULL,
  `id_val` text NOT NULL,
  `json_items` text NOT NULL,
  `id_usuario` varchar(36) NOT NULL,
  `id_user_cambio` varchar(36) NOT NULL,
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `inven_registro_nivel4`
--

INSERT INTO `inven_registro_nivel4` (`id`, `id_entorno`, `id_proyecto`, `id_nivel`, `profundidad`, `nombre`, `descripcion`, `costo`, `tiempo_disponible`, `fecha_creacion`, `fecha_inicial`, `fecha_final`, `id_val`, `json_items`, `id_usuario`, `id_user_cambio`, `fecha_mac`) VALUES
(1, 1, 79, 5, 4, 'cinco', '', 0.00, 0.00, '2017-02-24 00:00:00', '1969-12-31 00:00:00', '1969-12-31 00:00:00', '"d6ce3eff-f48f-11e6-b097-7071bce181c3"', '[{"id":"d6ce3eff-f48f-11e6-b097-7071bce181c3","nombre":"Margarita"}]', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-28 14:37:36'),
(2, 1, 79, 4, 4, 'cuatro', '', 0.00, 0.00, '2017-02-24 00:00:00', '2017-02-26 00:00:00', '2017-02-26 00:00:00', '"b3728c39-f48f-11e6-b097-7071bce181c3"', '[{"id":"b3728c39-f48f-11e6-b097-7071bce181c3","nombre":"Marissa"}]', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-03-01 18:29:39');

-- --------------------------------------------------------

--
-- Table structure for table `inven_registro_nivel5`
--

CREATE TABLE IF NOT EXISTS `inven_registro_nivel5` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_entorno` int(11) NOT NULL,
  `id_proyecto` int(11) NOT NULL,
  `id_nivel` int(11) NOT NULL,
  `profundidad` int(11) NOT NULL,
  `nombre` varchar(256) NOT NULL,
  `descripcion` text NOT NULL,
  `costo` float(10,2) NOT NULL,
  `tiempo_disponible` float(10,2) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `fecha_inicial` datetime NOT NULL,
  `fecha_final` datetime NOT NULL,
  `id_val` text NOT NULL,
  `json_items` text NOT NULL,
  `id_usuario` varchar(36) NOT NULL,
  `id_user_cambio` varchar(36) NOT NULL,
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `inven_registro_proyecto`
--

CREATE TABLE IF NOT EXISTS `inven_registro_proyecto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_entorno` int(11) NOT NULL,
  `id_proyecto` int(11) NOT NULL,
  `id_nivel` int(11) NOT NULL DEFAULT '1',
  `profundidad` int(11) NOT NULL DEFAULT '1',
  `proyecto` varchar(256) NOT NULL,
  `descripcion` text NOT NULL,
  `privacidad` bigint(20) NOT NULL,
  `costo` float(10,2) NOT NULL,
  `tiempo_disponible` float(10,2) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `fecha_inicial` datetime NOT NULL,
  `fecha_final` datetime NOT NULL,
  `contrato_firmado` bit(1) NOT NULL,
  `pago_anticipado` bit(1) NOT NULL,
  `factura_enviada` bit(1) NOT NULL,
  `id_val` text NOT NULL,
  `json_items` text NOT NULL,
  `id_usuario` varchar(36) NOT NULL,
  `id_user_cambio` varchar(36) NOT NULL,
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `inven_registro_proyecto`
--

INSERT INTO `inven_registro_proyecto` (`id`, `id_entorno`, `id_proyecto`, `id_nivel`, `profundidad`, `proyecto`, `descripcion`, `privacidad`, `costo`, `tiempo_disponible`, `fecha_creacion`, `fecha_inicial`, `fecha_final`, `contrato_firmado`, `pago_anticipado`, `factura_enviada`, `id_val`, `json_items`, `id_usuario`, `id_user_cambio`, `fecha_mac`) VALUES
(38, 1, 79, 1, 1, 'osmel', 'Nuevo Proyecto', 1, 0.00, 1.00, '2017-02-24 00:00:00', '2017-02-24 00:00:00', '2017-02-28 00:00:00', b'0', b'0', b'0', '"65350f7e-d031-11e5-b036-04015a6da701,00e10de5-f491-11e6-b097-7071bce181c3"', '[{"id":"65350f7e-d031-11e5-b036-04015a6da701","nombre":"Jorge"},{"id":"00e10de5-f491-11e6-b097-7071bce181c3","nombre":"Osmel"}]', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-28 17:08:12'),
(39, 1, 80, 1, 1, 'otro', 'Nuevo Proyecto', 1, 0.00, 1.00, '2017-02-24 00:00:00', '1969-12-31 00:00:00', '1969-12-31 00:00:00', b'0', b'0', b'0', '"eda8cc65-f48f-11e6-b097-7071bce181c3"', '[{"id":"eda8cc65-f48f-11e6-b097-7071bce181c3","nombre":"Olympia"}]', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-03-01 21:18:47'),
(40, 1, 81, 1, 1, 'iniciativa', 'Nuevo Proyecto', 1, 0.00, 0.00, '2017-03-01 00:00:00', '1969-12-31 00:00:00', '1969-12-31 00:00:00', b'0', b'0', b'0', '""', '[]', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-03-01 18:29:13'),
(41, 1, 82, 1, 1, 'ventas de auto', 'Nuevo Proyecto', 1, 0.00, 0.00, '2017-03-01 00:00:00', '1969-12-31 00:00:00', '1969-12-31 00:00:00', b'0', b'0', b'0', '""', '[]', '65350f7e-d031-11e5-b036-04015a6da701', '65350f7e-d031-11e5-b036-04015a6da701', '2017-03-01 18:33:14');

-- --------------------------------------------------------

--
-- Table structure for table `inven_registro_user_proy`
--

CREATE TABLE IF NOT EXISTS `inven_registro_user_proy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_entorno` int(11) NOT NULL,
  `id_proyecto` int(11) NOT NULL,
  `identificador` int(11) NOT NULL,
  `id_nivel` int(11) NOT NULL,
  `profundidad` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `horas` float(10,2) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_usuario` varchar(36) NOT NULL,
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=413 ;

--
-- Dumping data for table `inven_registro_user_proy`
--

INSERT INTO `inven_registro_user_proy` (`id`, `id_entorno`, `id_proyecto`, `identificador`, `id_nivel`, `profundidad`, `descripcion`, `horas`, `fecha`, `id_usuario`, `fecha_mac`) VALUES
(401, 1, 79, 10, 2, 2, '', 4.00, '2017-02-28 00:00:00', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-28 17:05:43'),
(402, 1, 79, 5, 3, 3, '', 5.00, '2017-02-28 00:00:00', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-28 17:05:43'),
(403, 1, 79, 10, 2, 2, '', 6.00, '2017-02-27 00:00:00', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-28 17:05:48'),
(404, 1, 79, 5, 3, 3, '', 7.00, '2017-02-27 00:00:00', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-28 17:05:48'),
(405, 1, 79, 38, 1, 1, '', 12.00, '2017-02-28 00:00:00', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-28 17:07:01'),
(406, 1, 79, 38, 1, 1, '', 13.00, '2017-02-27 00:00:00', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-28 17:07:05'),
(407, 1, 79, 38, 1, 1, '', 1.00, '2017-02-28 00:00:00', '00e10de5-f491-11e6-b097-7071bce181c3', '2017-02-28 17:08:50'),
(408, 1, 79, 10, 2, 2, '', 30.00, '2017-02-28 00:00:00', '00e10de5-f491-11e6-b097-7071bce181c3', '2017-02-28 17:23:36'),
(409, 1, 79, 5, 3, 3, '', 1.00, '2017-02-28 00:00:00', '00e10de5-f491-11e6-b097-7071bce181c3', '2017-02-28 17:08:50'),
(410, 1, 79, 38, 1, 1, '', 2.00, '2017-02-27 00:00:00', '00e10de5-f491-11e6-b097-7071bce181c3', '2017-02-28 17:08:59'),
(411, 1, 79, 10, 2, 2, '', 2.00, '2017-02-27 00:00:00', '00e10de5-f491-11e6-b097-7071bce181c3', '2017-02-28 17:08:59'),
(412, 1, 79, 5, 3, 3, '', 2.00, '2017-02-27 00:00:00', '00e10de5-f491-11e6-b097-7071bce181c3', '2017-02-28 17:08:59');

-- --------------------------------------------------------

--
-- Table structure for table `inven_sessions`
--

CREATE TABLE IF NOT EXISTS `inven_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inven_struct_osmel10125630aPJR256`
--

CREATE TABLE IF NOT EXISTS `inven_struct_osmel10125630aPJR256` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lft` int(11) unsigned NOT NULL,
  `rgt` int(11) unsigned NOT NULL,
  `lvl` int(11) unsigned NOT NULL,
  `pid` int(11) unsigned NOT NULL,
  `pos` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `inven_struct_osmel10125630aPJR256`
--

INSERT INTO `inven_struct_osmel10125630aPJR256` (`id`, `lft`, `rgt`, `lvl`, `pid`, `pos`) VALUES
(1, 1, 8, 0, 0, 0),
(2, 2, 7, 1, 1, 0),
(3, 3, 6, 2, 2, 0),
(4, 4, 5, 3, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `inven_usuarios`
--

CREATE TABLE IF NOT EXISTS `inven_usuarios` (
  `id` varchar(36) NOT NULL,
  `activo` bigint(1) NOT NULL DEFAULT '1',
  `salario` float(10,2) NOT NULL,
  `email` varbinary(128) NOT NULL,
  `contrasena` varbinary(128) NOT NULL,
  `creacion` int(11) NOT NULL,
  `telefono` varbinary(128) NOT NULL,
  `extension` varchar(10) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `Apellidos` varchar(40) NOT NULL,
  `estado` int(11) NOT NULL,
  `id_perfil` int(2) NOT NULL,
  `fecha_pc` int(11) NOT NULL,
  `id_usuario` varchar(36) NOT NULL,
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `coleccion_id_operaciones` varchar(80) NOT NULL DEFAULT '[]',
  `coleccion_id_cargos` varchar(80) NOT NULL DEFAULT '[]',
  `id_cliente` int(11) NOT NULL,
  `sala` int(11) NOT NULL DEFAULT '3',
  `num_partida` varchar(100) NOT NULL,
  `id_cargo` int(11) NOT NULL,
  `especial` int(1) NOT NULL,
  UNIQUE KEY `uid` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inven_usuarios`
--

INSERT INTO `inven_usuarios` (`id`, `activo`, `salario`, `email`, `contrasena`, `creacion`, `telefono`, `extension`, `nombre`, `Apellidos`, `estado`, `id_perfil`, `fecha_pc`, `id_usuario`, `fecha_mac`, `coleccion_id_operaciones`, `coleccion_id_cargos`, `id_cliente`, `sala`, `num_partida`, `id_cargo`, `especial`) VALUES
('00e10de5-f491-11e6-b097-7071bce181c3', 1, 5000.00, 'FV)g5S¤®éùôš°Ö–³3mÆïFK6)!mÈÆs¾>\rÈ‹eC„ŒÎ', '#RŞØ¾Ÿîmó¡½|¦', 1487281430, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Osmel', 'CalderÃ³n', 0, 4, 1487353952, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 17:40:43', 'null', '[]', 8, 3, '', 2, 0),
('02f6dc95-f533-11e6-aa7b-7071bce181c3', 0, 10000.00, 'ıVDÃ#1é#øø{#¨kŠØæ»&È ôû@Æı.', '#RŞØ¾Ÿîmó¡½|¦', 1487351012, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Erick', 'Bravo', 0, 4, 1487354201, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 14:40:47', 'null', '[]', 8, 3, '', 1, 0),
('127a8866-f22f-11e6-8df6-7071bce181c3', 3, 10000.00, 'ˆeß«|Ğš®Çƒá`g„åÓZSO-\0*ÕH“<»–', '#RŞØ¾Ÿîmó¡½|¦', 1487019466, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Mariana', 'PÃ©rez', 0, 4, 1487279472, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 14:40:47', 'null', '[]', 6, 3, '', 4, 0),
('27e4ad13-f22f-11e6-8df6-7071bce181c3', 1, 10000.00, '	50ÈÆ«·‹÷h­\\%øëk°Ü­8)2drÊ', '#RŞØ¾Ÿîmó¡½|¦', 1487019502, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Luis', 'Diaz', 0, 3, 1487281694, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 14:40:47', 'null', '[]', 6, 3, '', 5, 0),
('538c36af-f48f-11e6-b097-7071bce181c3', 1, 10000.00, 'ïEºVßÒT?Ë(ünzİÓZSO-\0*ÕH“<»–', '#RŞØ¾Ÿîmó¡½|¦', 1487280710, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Rodrigo', 'VÃ¡zquez', 0, 4, 1487280710, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 14:40:47', 'null', '[]', 4, 3, '', 8, 0),
('65350f7e-d031-11e5-b036-04015a6da701', 1, 10000.00, 'IoC¥Œq_¨ßÚRQ©oø¨kŠØæ»&È ôû@Æı.', 'ß|Ôÿ¬Ğb£@Íf®)½J“', 1455134627, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Jorge', 'Bobadilla', 0, 1, 1487281272, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 14:40:47', 'null', '[]', 1, 3, '', 7, 0),
('6e78e365-f48f-11e6-b097-7071bce181c3', 1, 10000.00, '(¿Uê¶ÏRİm)½ë&+µ1M–iã¿ù‹/ƒ£¸)í„&', '#RŞØ¾Ÿîmó¡½|¦', 1487280755, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Sandra', 'Rodriguez', 0, 4, 1487280755, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 14:40:47', 'null', '[]', 4, 3, '', 8, 0),
('8c4ef380-f48f-11e6-b097-7071bce181c3', 1, 10000.00, 'ØşvE©ûbÛÀJ-©…M–iã¿ù‹/ƒ£¸)í„&', '#RŞØ¾Ÿîmó¡½|¦', 1487280805, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Andrea', 'CÃ©sar', 0, 3, 1487281642, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 14:40:47', 'null', '[]', 3, 3, '', 8, 0),
('b3728c39-f48f-11e6-b097-7071bce181c3', 1, 10000.00, 'VHÃç‹G‚5*FßY,:ÙqÓZSO-\0*ÕH“<»–', '#RŞØ¾Ÿîmó¡½|¦', 1487280870, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Marissa', 'Martinez', 0, 2, 1487281626, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 14:40:47', 'null', '[]', 2, 3, '', 8, 0),
('bceed19e-f22e-11e6-8df6-7071bce181c3', 1, 10000.00, '8…r1YS’\rÏ\ZÜ”eÒë\\M–iã¿ù‹/ƒ£¸)í„&', '#RŞØ¾Ÿîmó¡½|¦', 1487019323, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Ulises', 'Flores', 0, 4, 1487279807, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 14:40:47', 'null', '[]', 8, 3, '', 2, 0),
('c2656b07-f48c-11e6-b097-7071bce181c3', 1, 10000.00, 'GúÉL5h»Å©x Œñ›ü¨kŠØæ»&È ôû@Æı.', '#RŞØ¾Ÿîmó¡½|¦', 1487279607, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Angel', 'NuÃ±ez', 0, 4, 1487281322, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 14:40:47', 'null', '[]', 6, 3, '', 4, 0),
('cc28e2de-f537-11e6-aa7b-7071bce181c3', 0, 10000.00, '÷"½£T÷0ÅŞŠ¦¢•™‡ù¯~	ë!úØÛ¤ÍbJ:Q“ÄûÍIG²gª6¸Ú', '#RŞØ¾Ÿîmó¡½|¦', 1487353067, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Guillermo', 'Huerta', 0, 4, 1487354112, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 14:40:47', 'null', '[]', 8, 3, '', 1, 0),
('d6ce3eff-f48f-11e6-b097-7071bce181c3', 1, 10000.00, '^^cÁw¹!şC „–A}y™‡ù¯~	ë!úØÛ¤ÍbJ:Q“ÄûÍIG²gª6¸Ú', '#RŞØ¾Ÿîmó¡½|¦', 1487280930, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Margarita', 'Sayavedra', 0, 4, 1487280930, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 14:40:47', 'null', '[]', 2, 3, '', 8, 0),
('d86270f7-f22e-11e6-8df6-7071bce181c3', 1, 10000.00, 'i.+zŸ½áÂ„‚…c·ãM–iã¿ù‹/ƒ£¸)í„&', '#RŞØ¾Ÿîmó¡½|¦', 1487019369, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Adrian', 'Guerrero', 0, 3, 1487601083, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 14:40:47', 'null', '[]', 8, 3, '', 3, 0),
('e24edcf7-f48d-11e6-b097-7071bce181c3', 1, 10000.00, '¾%€›lqFÖ Ø·	S9M–iã¿ù‹/ƒ£¸)í„&', '#RŞØ¾Ÿîmó¡½|¦', 1487280090, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Lucero', 'Dominguez', 0, 4, 1487280090, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 14:40:47', 'null', '[]', 5, 3, '', 8, 0),
('e57dc15e-f393-11e6-a437-7071bce181c3', 1, 10000.00, '³·g6'';¢P}*¿LôM–iã¿ù‹/ƒ£¸)í„&', '#RŞØ¾Ÿîmó¡½|¦', 1487172721, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Roxana', 'Luviano', 0, 4, 1487279965, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 14:40:47', '["2"]', '[]', 7, 3, '', 8, 0),
('eda8cc65-f48f-11e6-b097-7071bce181c3', 1, 10000.00, '3ûÎOáªZñuEYÓZSO-\0*ÕH“<»–', '#RŞØ¾Ÿîmó¡½|¦', 1487280968, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Olympia', 'de la Puente', 0, 4, 1487281798, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 14:40:47', 'null', '[]', 2, 3, '', 8, 0),
('f963a139-122e-11e6-8df6-7071bce181c3', 1, 10000.00, '¥X€FÒÆ«B]É-°úÓZSO-\0*ÕH“<»–', '#RŞØ¾Ÿîmó¡½|¦', 1487019424, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Ariadna', 'Miranda', 0, 3, 1487281666, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 14:40:47', 'null', '[]', 5, 3, '', 8, 0),
('f963a239-f22e-11e6-8df6-7071bce181c3', 1, 10000.00, '&ÇÏRšÈ¦VÕÀzêÇ<æøëk°Ü­8)2drÊ', '#RŞØ¾Ÿîmó¡½|¦', 1487019424, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Gina', 'Tejada', 0, 4, 1487280032, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 14:40:47', 'null', '[]', 5, 3, '', 8, 0),
('f963a339-222e-11e6-8df6-7071bce181c3', 1, 10000.00, '|Keo4‰\\@æReÀh©Û^M–iã¿ù‹/ƒ£¸)í„&', '#RŞØ¾Ÿîmó¡½|¦', 1487019424, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Rebeca', 'Bravo', 0, 4, 1487280609, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 14:40:47', 'null', '[]', 5, 3, '', 8, 0),
('f963a439-322e-11e6-8df6-7071bce181c3', 1, 10000.00, 'd§¼¡&µÆUruÖà’,Åøëk°Ü­8)2drÊ', '#RŞØ¾Ÿîmó¡½|¦', 1487019424, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Ilse', 'Salazar', 0, 4, 1487280559, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-24 14:40:47', 'null', '[]', 5, 3, '', 8, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
