-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 21, 2017 at 10:05 PM
-- Server version: 5.5.49-0ubuntu0.14.04.1
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

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
  `Proyecto` varchar(256) NOT NULL,
  `tabla` varchar(100) NOT NULL,
  `profundidad` int(11) NOT NULL,
  `ruta` text NOT NULL,
  `tooltip` varchar(256) NOT NULL,
  `id_usuario` varchar(36) NOT NULL,
  `id_user_cambio` varchar(36) NOT NULL,
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `inven_catalogo_configuraciones`
--

INSERT INTO `inven_catalogo_configuraciones` (`id`, `configuracion`, `valor`, `nombre`, `precio`, `activo`, `tooltip`, `consecutivo`, `fecha_pc`, `id_usuario`, `fecha_mac`, `orden`, `grupo`) VALUES
(1, 'Profundidad Ãrbol Entorno', 6, '', 0.00, 1, '', 0, 0, 'b69d7d2b-582b-11e6-aeb5-7071bce181c3', '2017-02-20 15:39:28', 0, ''),
(2, 'Entorno por defecto simple', 0, '', 16.00, 1, '', 0, 0, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-17 15:24:02', 0, ''),
(3, 'Proyecto por defecto Multiple', 1, '', 0.00, 0, '', 0, 0, '', '2017-02-11 19:39:00', 0, '');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

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
  `id_user_cambio` varchar(36) NOT NULL,
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=74 ;

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
  `fecha_creacion` datetime NOT NULL,
  `fecha_inicial` datetime NOT NULL,
  `fecha_final` datetime NOT NULL,
  `id_val` text NOT NULL,
  `json_items` text NOT NULL,
  `id_usuario` varchar(36) NOT NULL,
  `id_user_cambio` varchar(36) NOT NULL,
  `fecha_mac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=177 ;

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

INSERT INTO `inven_usuarios` (`id`, `activo`, `email`, `contrasena`, `creacion`, `telefono`, `extension`, `nombre`, `Apellidos`, `estado`, `id_perfil`, `fecha_pc`, `id_usuario`, `fecha_mac`, `coleccion_id_operaciones`, `coleccion_id_cargos`, `id_cliente`, `sala`, `num_partida`, `id_cargo`, `especial`) VALUES
('00e10de5-f491-11e6-b097-7071bce181c3', 1, 'FV)g5S¤®éùôš°Ö–³3mÆïFK6)!mÈÆs¾>\rÈ‹eC„ŒÎ', '#RŞØ¾Ÿîmó¡½|¦', 1487281430, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Osmel', 'CalderÃ³n', 0, 4, 1487353952, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-20 14:40:08', 'null', '[]', 8, 3, '', 2, 0),
('02f6dc95-f533-11e6-aa7b-7071bce181c3', 0, 'ıVDÃ#1é#øø{#¨kŠØæ»&È ôû@Æı.', '#RŞØ¾Ÿîmó¡½|¦', 1487351012, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Erick', 'Bravo', 0, 4, 1487354201, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-20 14:40:08', 'null', '[]', 8, 3, '', 1, 0),
('127a8866-f22f-11e6-8df6-7071bce181c3', 3, 'ˆeß«|Ğš®Çƒá`g„åÓZSO-\0*ÕH“<»–', '#RŞØ¾Ÿîmó¡½|¦', 1487019466, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Mariana', 'PÃ©rez', 0, 4, 1487279472, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-20 14:40:08', 'null', '[]', 6, 3, '', 4, 0),
('27e4ad13-f22f-11e6-8df6-7071bce181c3', 1, '	50ÈÆ«·‹÷h­\\%øëk°Ü­8)2drÊ', '#RŞØ¾Ÿîmó¡½|¦', 1487019502, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Luis', 'Diaz', 0, 3, 1487281694, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-20 14:40:20', 'null', '[]', 6, 3, '', 5, 0),
('538c36af-f48f-11e6-b097-7071bce181c3', 1, 'ïEºVßÒT?Ë(ünzİÓZSO-\0*ÕH“<»–', '#RŞØ¾Ÿîmó¡½|¦', 1487280710, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Rodrigo', 'VÃ¡zquez', 0, 4, 1487280710, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-20 14:40:08', 'null', '[]', 4, 3, '', 8, 0),
('65350f7e-d031-11e5-b036-04015a6da701', 1, 'IoC¥Œq_¨ßÚRQ©oø¨kŠØæ»&È ôû@Æı.', 'ß|Ôÿ¬Ğb£@Íf®)½J“', 1455134627, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Jorge', 'Bobadilla', 0, 1, 1487281272, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-16 22:00:52', 'null', '[]', 1, 3, '', 7, 0),
('6e78e365-f48f-11e6-b097-7071bce181c3', 1, '(¿Uê¶ÏRİm)½ë&+µ1M–iã¿ù‹/ƒ£¸)í„&', '#RŞØ¾Ÿîmó¡½|¦', 1487280755, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Sandra', 'Rodriguez', 0, 4, 1487280755, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-20 14:40:08', 'null', '[]', 4, 3, '', 8, 0),
('8c4ef380-f48f-11e6-b097-7071bce181c3', 1, 'ØşvE©ûbÛÀJ-©…M–iã¿ù‹/ƒ£¸)í„&', '#RŞØ¾Ÿîmó¡½|¦', 1487280805, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Andrea', 'CÃ©sar', 0, 3, 1487281642, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-20 14:40:20', 'null', '[]', 3, 3, '', 8, 0),
('b3728c39-f48f-11e6-b097-7071bce181c3', 1, 'VHÃç‹G‚5*FßY,:ÙqÓZSO-\0*ÕH“<»–', '#RŞØ¾Ÿîmó¡½|¦', 1487280870, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Marissa', 'Martinez', 0, 2, 1487281626, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-16 22:00:26', 'null', '[]', 2, 3, '', 8, 0),
('bceed19e-f22e-11e6-8df6-7071bce181c3', 1, '8…r1YS’\rÏ\ZÜ”eÒë\\M–iã¿ù‹/ƒ£¸)í„&', '#RŞØ¾Ÿîmó¡½|¦', 1487019323, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Ulises', 'Flores', 0, 4, 1487279807, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-20 14:40:08', 'null', '[]', 8, 3, '', 2, 0),
('c2656b07-f48c-11e6-b097-7071bce181c3', 1, 'GúÉL5h»Å©x Œñ›ü¨kŠØæ»&È ôû@Æı.', '#RŞØ¾Ÿîmó¡½|¦', 1487279607, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Angel', 'NuÃ±ez', 0, 4, 1487281322, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-20 14:40:08', 'null', '[]', 6, 3, '', 4, 0),
('cc28e2de-f537-11e6-aa7b-7071bce181c3', 0, '÷"½£T÷0ÅŞŠ¦¢•™‡ù¯~	ë!úØÛ¤ÍbJ:Q“ÄûÍIG²gª6¸Ú', '#RŞØ¾Ÿîmó¡½|¦', 1487353067, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Guillermo', 'Huerta', 0, 4, 1487354112, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-20 14:40:08', 'null', '[]', 8, 3, '', 1, 0),
('d6ce3eff-f48f-11e6-b097-7071bce181c3', 1, '^^cÁw¹!şC „–A}y™‡ù¯~	ë!úØÛ¤ÍbJ:Q“ÄûÍIG²gª6¸Ú', '#RŞØ¾Ÿîmó¡½|¦', 1487280930, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Margarita', 'Sayavedra', 0, 4, 1487280930, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-20 14:40:08', 'null', '[]', 2, 3, '', 8, 0),
('d86270f7-f22e-11e6-8df6-7071bce181c3', 1, 'i.+zŸ½áÂ„‚…c·ãM–iã¿ù‹/ƒ£¸)í„&', '#RŞØ¾Ÿîmó¡½|¦', 1487019369, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Adrian', 'Guerrero', 0, 3, 1487601083, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-20 14:40:20', 'null', '[]', 8, 3, '', 3, 0),
('e24edcf7-f48d-11e6-b097-7071bce181c3', 1, '¾%€›lqFÖ Ø·	S9M–iã¿ù‹/ƒ£¸)í„&', '#RŞØ¾Ÿîmó¡½|¦', 1487280090, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Lucero', 'Dominguez', 0, 4, 1487280090, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-20 14:40:08', 'null', '[]', 5, 3, '', 8, 0),
('e57dc15e-f393-11e6-a437-7071bce181c3', 1, '³·g6'';¢P}*¿LôM–iã¿ù‹/ƒ£¸)í„&', '#RŞØ¾Ÿîmó¡½|¦', 1487172721, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Roxana', 'Luviano', 0, 4, 1487279965, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-20 14:40:08', '["2"]', '[]', 7, 3, '', 8, 0),
('eda8cc65-f48f-11e6-b097-7071bce181c3', 1, '3ûÎOáªZñuEYÓZSO-\0*ÕH“<»–', '#RŞØ¾Ÿîmó¡½|¦', 1487280968, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Olympia', 'de la Puente', 0, 4, 1487281798, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-20 14:40:08', 'null', '[]', 2, 3, '', 8, 0),
('f963a139-122e-11e6-8df6-7071bce181c3', 1, '¥X€FÒÆ«B]É-°úÓZSO-\0*ÕH“<»–', '#RŞØ¾Ÿîmó¡½|¦', 1487019424, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Ariadna', 'Miranda', 0, 3, 1487281666, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-20 14:40:20', 'null', '[]', 5, 3, '', 8, 0),
('f963a239-f22e-11e6-8df6-7071bce181c3', 1, '&ÇÏRšÈ¦VÕÀzêÇ<æøëk°Ü­8)2drÊ', '#RŞØ¾Ÿîmó¡½|¦', 1487019424, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Gina', 'Tejada', 0, 4, 1487280032, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-20 14:40:08', 'null', '[]', 5, 3, '', 8, 0),
('f963a339-222e-11e6-8df6-7071bce181c3', 1, '|Keo4‰\\@æReÀh©Û^M–iã¿ù‹/ƒ£¸)í„&', '#RŞØ¾Ÿîmó¡½|¦', 1487019424, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Rebeca', 'Bravo', 0, 4, 1487280609, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-20 14:40:08', 'null', '[]', 5, 3, '', 8, 0),
('f963a439-322e-11e6-8df6-7071bce181c3', 1, 'd§¼¡&µÆUruÖà’,Åøëk°Ü­8)2drÊ', '#RŞØ¾Ÿîmó¡½|¦', 1487019424, 'ö·§*…GûA¥qåFA÷“Ù', '', 'Ilse', 'Salazar', 0, 4, 1487280559, '65350f7e-d031-11e5-b036-04015a6da701', '2017-02-20 14:40:08', 'null', '[]', 5, 3, '', 8, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
