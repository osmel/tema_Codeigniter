-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 15, 2017 at 11:04 AM
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
-- Table structure for table `inven_catalogo_cargos`
--

CREATE TABLE IF NOT EXISTS `inven_catalogo_cargos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cargo` varchar(100) DEFAULT NULL,
  `activo` bigint(1) NOT NULL DEFAULT '1',
  `id_usuario` varchar(36) NOT NULL,
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `inven_catalogo_cargos`
--

INSERT INTO `inven_catalogo_cargos` (`id`, `cargo`, `activo`, `id_usuario`, `fecha_mac`) VALUES
(1, 'Cargo.1', 1, '65350f7e-d031-11e5-b036-04015a6da701', '2017-01-27 23:57:29'),
(2, 'Cargo.2', 1, 'b69d7d2b-582b-11e6-aeb5-7071bce181c3', '2016-08-19 18:53:39'),
(3, 'Cargo.3', 1, 'b69d7d2b-582b-11e6-aeb5-7071bce181c3', '2016-08-19 18:53:45'),
(4, 'Cargo.4', 1, 'b69d7d2b-582b-11e6-aeb5-7071bce181c3', '2017-02-15 15:00:18'),
(5, 'Cargo.5', 1, 'b69d7d2b-582b-11e6-aeb5-7071bce181c3', '2017-02-15 15:00:20'),
(6, 'Cargo.6', 1, 'b69d7d2b-582b-11e6-aeb5-7071bce181c3', '2017-02-15 15:00:21');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `inven_catalogo_configuraciones`
--

INSERT INTO `inven_catalogo_configuraciones` (`id`, `configuracion`, `valor`, `nombre`, `precio`, `activo`, `tooltip`, `consecutivo`, `fecha_pc`, `id_usuario`, `fecha_mac`, `orden`, `grupo`) VALUES
(1, 'Profundidad Ãrbol Entorno', 5, '', 0.00, 1, '', 0, 0, 'b69d7d2b-582b-11e6-aeb5-7071bce181c3', '2017-02-12 03:21:02', 0, ''),
(2, 'Entorno por defecto simple', 0, '', 16.00, 1, '', 0, 0, 'b69d7d2b-582b-11e6-aeb5-7071bce181c3', '2017-02-11 14:14:17', 0, ''),
(3, 'Proyecto por defecto Multiple', 1, '', 0.00, 0, '', 0, 0, '', '2017-02-11 19:39:00', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `inven_catalogo_empresas`
--

CREATE TABLE IF NOT EXISTS `inven_catalogo_empresas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(45) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `dias_ctas_pagar` int(11) NOT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `id_usuario` varchar(36) NOT NULL,
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `coleccion_id_actividad` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=113 ;

--
-- Dumping data for table `inven_catalogo_empresas`
--

INSERT INTO `inven_catalogo_empresas` (`id`, `uid`, `nombre`, `codigo`, `dias_ctas_pagar`, `direccion`, `telefono`, `id_usuario`, `fecha_mac`, `coleccion_id_actividad`) VALUES
(1, NULL, 'AdministraciÃ³n', '00008', 0, '', '', '32683212-21d2-11e5-aa7c-04015a6da701', '2017-02-15 14:10:10', '["1"]'),
(2, NULL, 'Cuentas', '0009', 0, '', '', '32683212-21d2-11e5-aa7c-04015a6da701', '2017-02-15 14:10:12', '["1"]'),
(3, NULL, 'TI', '00001', 0, 'MANUFACTURAS KALTEX, S.A. DE C.V.', '', '00e922a0-b632-11e5-b036-04015a6da701', '2017-02-15 14:10:22', '["1"]'),
(4, NULL, 'DiseÃ±o', '00002', 0, '', '', '32683212-21d2-11e5-aa7c-04015a6da701', '2017-02-15 14:10:24', '["1"]'),
(5, NULL, 'ComunicaciÃ³n', '00004', 0, '', '', '32683212-21d2-11e5-aa7c-04015a6da701', '2017-02-15 14:10:26', '["1"]'),
(6, NULL, 'Marketing Digital', '00006', 0, '', '', '32683212-21d2-11e5-aa7c-04015a6da701', '2017-02-15 14:10:31', '["1"]');

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
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `inven_catalogo_entornos`
--

INSERT INTO `inven_catalogo_entornos` (`id`, `entorno`, `tabla`, `profundidad`, `ruta`, `tooltip`, `id_usuario`, `fecha_mac`) VALUES
(1, 'General', 'osmel10125630aPJR256', 4, 'Proyecto / Etapas / Tarea / SubTareas', '', '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-13 21:13:15');

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
(1, 'Entornos', 'Permite el acceso a la secciÃ³n de generar Entradas al AlmacÃ©n.', 0, 1, 1, 0, 4, 5, 0, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-09 15:59:18', 1, 'Operaciones'),
(2, 'Proyectos', 'Permite el acceso a la secciÃ³n de generar Salidas del AlmacÃ©n.', 0, 0, 0, 0, 7, 9, 0, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-09 15:59:24', 3, 'Operaciones');

-- --------------------------------------------------------

--
-- Table structure for table `inven_catalogo_proyectos`
--

CREATE TABLE IF NOT EXISTS `inven_catalogo_proyectos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_entorno` int(11) NOT NULL,
  `Proyecto` varchar(256) NOT NULL,
  `tabla` varchar(100) NOT NULL,
  `profundidad` int(11) NOT NULL,
  `ruta` text NOT NULL,
  `tooltip` varchar(256) NOT NULL,
  `id_usuario` varchar(36) NOT NULL,
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

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
-- Table structure for table `inven_perfiles`
--

CREATE TABLE IF NOT EXISTS `inven_perfiles` (
  `id_perfil` int(2) NOT NULL,
  `perfil` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `operacion` varchar(10) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'R' COMMENT 'CRUD V-Votar F-Finalista M-Mover obsoleto',
  PRIMARY KEY (`id_perfil`),
  KEY `id_perfil` (`id_perfil`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `inven_perfiles`
--

INSERT INTO `inven_perfiles` (`id_perfil`, `perfil`, `operacion`) VALUES
(1, 'Super Administrador', 'CRUDFGM'),
(3, 'Trabajador', 'R');

-- --------------------------------------------------------

--
-- Table structure for table `inven_registro_proyecto`
--

CREATE TABLE IF NOT EXISTS `inven_registro_proyecto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_entorno` int(11) NOT NULL,
  `id_proyecto` int(11) NOT NULL,
  `proyecto` varchar(256) NOT NULL,
  `descripcion` text NOT NULL,
  `privacidad` bigint(20) NOT NULL,
  `costo` float(10,2) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `fecha_inicial` datetime NOT NULL,
  `fecha_final` datetime NOT NULL,
  `contrato_firmado` bit(1) NOT NULL,
  `pago_anticipado` bit(1) NOT NULL,
  `factura_enviada` bit(1) NOT NULL,
  `id_val` text NOT NULL,
  `json_items` text NOT NULL,
  `id_usuario` varchar(36) NOT NULL,
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `inven_registro_user_proy`
--

CREATE TABLE IF NOT EXISTS `inven_registro_user_proy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_entorno` int(11) NOT NULL,
  `id_proyecto` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `horas` float(10,2) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_usuario` varchar(36) NOT NULL,
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

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
  `email` varbinary(128) NOT NULL,
  `contrasena` varbinary(128) NOT NULL,
  `creacion` int(11) NOT NULL,
  `telefono` varbinary(128) NOT NULL,
  `extension` varchar(10) NOT NULL,
  `activo` tinyint(2) NOT NULL,
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

INSERT INTO `inven_usuarios` (`id`, `email`, `contrasena`, `creacion`, `telefono`, `extension`, `activo`, `nombre`, `Apellidos`, `estado`, `id_perfil`, `fecha_pc`, `id_usuario`, `fecha_mac`, `coleccion_id_operaciones`, `coleccion_id_cargos`, `id_cliente`, `sala`, `num_partida`, `id_cargo`, `especial`) VALUES
('127a8866-f22f-11e6-8df6-7071bce181c3', 'úšµ¢. ÞÓ?œVÇrqbJ:Q“ÄûÍIG²gª6¸Ú', '#RÞØ¾Ÿîmó¡½|¦', 1487019466, 'ö·§*…GûA¥qåFA÷“Ù', '', 0, 'mariana', 'mma', 0, 3, 1487019466, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-15 14:59:11', 'false', '[]', 4, 3, '', 1, 0),
('27e4ad13-f22f-11e6-8df6-7071bce181c3', '“—‘8„«Iâô«lsÓ', '#RÞØ¾Ÿîmó¡½|¦', 1487019502, 'ö·§*…GûA¥qåFA÷“Ù', '', 0, 'luis', 'ooosso', 0, 3, 1487019502, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-15 14:59:12', 'false', '[]', 4, 3, '', 2, 0),
('65350f7e-d031-11e5-b036-04015a6da701', '¶­ÔFp¨0P´E8w¹ŽU', 'ß|Ôÿ¬Ðb£@Íf®)½J“', 1455134627, 'ö·§*…GûA¥qåFA÷“Ù', '', 0, 'Jorge', 'Bobadilla', 0, 1, 1487177590, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-15 16:53:10', 'null', '[]', 1, 3, '', 0, 1),
('bceed19e-f22e-11e6-8df6-7071bce181c3', 'ÍÒñæ÷«R_ÍqÄn×®*Ö’¦/¥íhA¬Ú¦Q`K\r>', '#RÞØ¾Ÿîmó¡½|¦', 1487019323, 'ö·§*…GûA¥qåFA÷“Ù', '', 0, 'ulises', 'flores', 0, 3, 1487019323, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-15 14:59:15', 'false', '[]', 3, 3, '', 4, 0),
('d86270f7-f22e-11e6-8df6-7071bce181c3', '-.n\0)å=”%CŠ–', '#RÞØ¾Ÿîmó¡½|¦', 1487019369, 'ö·§*…GûA¥qåFA÷“Ù', '', 0, 'panas', 'panas', 0, 3, 1487173028, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-15 15:37:08', 'null', '[]', 3, 3, '', 0, 0),
('e57dc15e-f393-11e6-a437-7071bce181c3', 'RÌj¨”x|Û•?ž', '#RÞØ¾Ÿîmó¡½|¦', 1487172721, 'ö·§*…GûA¥qåFA÷“Ù', '', 0, 'pepe', 'pepe', 0, 3, 1487172721, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-15 15:32:01', '["2"]', '[]', 6, 3, '', 0, 0),
('f963a239-f22e-11e6-8df6-7071bce181c3', '¥ÈÊ)QâYÅA’''3²WÁ_ïRŸÔqV*â', '#RÞØ¾Ÿîmó¡½|¦', 1487019424, 'ö·§*…GûA¥qåFA÷“Ù', '', 0, 'osmel', 'calderon', 0, 3, 1487019424, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-15 14:59:22', 'false', '[]', 3, 3, '', 6, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
