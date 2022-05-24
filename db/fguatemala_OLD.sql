-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 06-05-2022 a las 10:12:04
-- Versión del servidor: 10.1.48-MariaDB-0ubuntu0.18.04.1
-- Versión de PHP: 7.2.24-0ubuntu0.18.04.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `fguatemala`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `abono_credito`
--

CREATE TABLE `abono_credito` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_abono_credito` int(11) NOT NULL,
  `id_credito` int(11) NOT NULL,
  `abono` float NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `tipo_doc` varchar(25) NOT NULL,
  `num_doc` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `access_conf`
--

CREATE TABLE `access_conf` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_conf` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `hash` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `access_conf`
--

INSERT INTO `access_conf` (`id_server`, `unique_id`, `id_conf`, `id_sucursal`, `hash`) VALUES
(1, 'O60d7df1a6e0ba6.40217911', 1, 1, 'OIQWAjLkd79ggETQkaSF3UW5x4wPRQkmfHqJsHLVY7aKPbs642CaWcON3+3OMUrKnjc6j6Qd0PvrNLwP11cGioWaHob/OFyq5fx2lBwzT8UK4iLKjzbr/6lpk9KNOKxM8TRtYmJjpaVFUKGU4EOYaW9CeFXbJNZdvrNJpIhxRFg=');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `altclitocli`
--

CREATE TABLE `altclitocli` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id` int(11) NOT NULL,
  `datax` text NOT NULL,
  `id_sucursal_origen` int(11) NOT NULL,
  `id_sucursal_destino` int(11) NOT NULL,
  `ejecutado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apertura_caja`
--

CREATE TABLE `apertura_caja` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_apertura` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `caja` int(11) NOT NULL,
  `turno_vigente` tinyint(1) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `turno` int(11) NOT NULL,
  `monto_apertura` double NOT NULL,
  `monto_ch` decimal(10,2) NOT NULL,
  `monto_ch_actual` decimal(10,2) NOT NULL,
  `tiket_inicia` int(11) NOT NULL,
  `factura_inicia` int(11) NOT NULL,
  `credito_fiscal_inicia` int(11) NOT NULL,
  `dev_inicia` int(11) NOT NULL,
  `vigente` tinyint(1) NOT NULL,
  `monto_vendido` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `apertura_caja`
--

INSERT INTO `apertura_caja` (`id_server`, `unique_id`, `id_sucursal`, `id_apertura`, `fecha`, `hora`, `caja`, `turno_vigente`, `id_empleado`, `turno`, `monto_apertura`, `monto_ch`, `monto_ch_actual`, `tiket_inicia`, `factura_inicia`, `credito_fiscal_inicia`, `dev_inicia`, `vigente`, `monto_vendido`) VALUES
(0, 'S626971d3933663.86143635', 1, 1, '2022-04-27', '10:39:46', 1, 1, 1, 1, 20, '0.00', '0.00', 0, 0, 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banco`
--

CREATE TABLE `banco` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_banco` int(1) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `logo` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `banco`
--

INSERT INTO `banco` (`id_server`, `unique_id`, `id_sucursal`, `id_banco`, `nombre`, `logo`) VALUES
(1, 'O60d7df1abbd429.49149694', 1, 1, 'banco agricola', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_caja` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `serie` varchar(11) NOT NULL,
  `desde` int(11) NOT NULL,
  `hasta` int(11) NOT NULL,
  `correlativo_dispo` int(11) NOT NULL,
  `resolucion` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `activa` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`id_server`, `unique_id`, `id_sucursal`, `id_caja`, `nombre`, `serie`, `desde`, `hasta`, `correlativo_dispo`, `resolucion`, `fecha`, `activa`) VALUES
(1, 'O60d7df1abdfca2.64813667', 1, 1, 'Caja 1', '22MS0000001', 1, 100000, 4, 'ASC-15041-042714-2022', '2022-02-22', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `nombre_cat` varchar(30) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `id_sucursal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_server`, `unique_id`, `id_categoria`, `nombre_cat`, `descripcion`, `id_sucursal`) VALUES
(0, 'S62544778751f13.71569844', 1, 'VARIOS', 'VARIOS', 1),
(0, 'S625459d5e2e285.59065763', 2, 'FLOR DE COLOMBIA', 'TODAS LAS FLORES DE COLOMBIA', 1),
(0, 'S625460a25a1470.53361411', 3, 'FLOR DE GUATEMALA', 'FLOAR DE GUATEMALA', 1),
(0, 'S625460bd432d48.37407106', 4, 'FLOR DE ECUADOR', 'FLOR DE ECUADOR ', 1),
(0, 'S625460d0bc5e60.87341253', 5, 'FLOR DE COSTA RICA', 'FLOR DE COSTA RICA', 1),
(0, 'S6254615ddbb3a5.59045973', 6, 'FLOR SALVADOREÑA', 'FLOR SALVADOREÑA', 1),
(0, 'S625469c00ec1c9.57632015', 7, 'OASIS', 'OASIS', 1),
(0, 'S625ee6324062e1.87879948', 8, 'CHOCOLATE', 'CHOCOLATE', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_proveedor`
--

CREATE TABLE `categoria_proveedor` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categoria_proveedor`
--

INSERT INTO `categoria_proveedor` (`id_server`, `unique_id`, `id_categoria`, `nombre`, `descripcion`) VALUES
(1, 'O60d7df1c049da6.37304596', 1, 'Consumidor', ''),
(2, 'O60d7df1c061301.99757941', 2, 'Contribuyente', ''),
(3, 'O60d7df1c082b28.77418638', 3, 'Gran Contribuyente', ''),
(4, 'O60d7df1c0a3282.63575036', 4, 'Contribuyente Exento', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cheque`
--

CREATE TABLE `cheque` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_cheque` int(11) NOT NULL,
  `cheque` varchar(50) DEFAULT NULL,
  `monto` float NOT NULL,
  `id_movimiento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `categoria` int(1) DEFAULT NULL,
  `nombre` varchar(200) DEFAULT NULL,
  `razon_social` varchar(250) NOT NULL,
  `direccion` text,
  `municipio` varchar(100) DEFAULT NULL,
  `depto` varchar(100) DEFAULT NULL,
  `pais` varchar(11) DEFAULT NULL,
  `dui` varchar(15) DEFAULT NULL,
  `nit` varchar(20) DEFAULT NULL,
  `nrc` varchar(12) DEFAULT NULL,
  `giro` varchar(40) DEFAULT NULL,
  `telefono1` varchar(12) DEFAULT NULL,
  `telefono2` varchar(12) DEFAULT NULL,
  `fax` varchar(12) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `ultventa` date DEFAULT NULL,
  `acumulado` int(1) DEFAULT NULL,
  `saldo` int(1) DEFAULT NULL,
  `percibe` int(1) DEFAULT NULL,
  `retiene` int(10) DEFAULT NULL,
  `retiene10` tinyint(1) NOT NULL,
  `inactivo` tinyint(1) NOT NULL,
  `latitud` double NOT NULL,
  `longitud` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_server`, `unique_id`, `id_sucursal`, `id_cliente`, `categoria`, `nombre`, `razon_social`, `direccion`, `municipio`, `depto`, `pais`, `dui`, `nit`, `nrc`, `giro`, `telefono1`, `telefono2`, `fax`, `email`, `ultventa`, `acumulado`, `saldo`, `percibe`, `retiene`, `retiene10`, `inactivo`, `latitud`, `longitud`) VALUES
(-1, 'O60d7df1c0de0a9.76843526', 1, -1, 1, 'MOSTRADOR', '', '', '81', '13', NULL, '', '0000-000000-000-0', '000000-0', '', '0000-0000', '', '', '', NULL, NULL, NULL, 0, 0, 0, 0, 0, 0),
(0, 'S62697cf2913da5.08837724', 1, 1, 1, 'FREDY ERNESTO TURCIOS REYES', '', 'COLONIA CIUDAD PACIFICA', '81', '13', NULL, '05203761-3', '1515-181518-158-8', '61561616-4', 'VENTA DE OTRO ARTÍCULOS DE PRIMERA NECES', '', '', '', '', NULL, NULL, NULL, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `numero_doc` varchar(20) NOT NULL,
  `fecha` date DEFAULT NULL,
  `iva` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `hora` time DEFAULT NULL,
  `fecha_ingreso` date NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `alias_tipodoc` char(5) NOT NULL,
  `total_percepcion` float NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `dias_credito` int(11) NOT NULL,
  `anulada` tinyint(1) NOT NULL,
  `finalizada` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_configuracion` int(11) NOT NULL,
  `sms` int(11) NOT NULL,
  `user` varchar(100) NOT NULL,
  `hash` varchar(512) NOT NULL,
  `iva` decimal(10,4) NOT NULL,
  `utilidad` decimal(10,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id_server`, `unique_id`, `id_configuracion`, `sms`, `user`, `hash`, `iva`, `utilidad`) VALUES
(1, 'O60d7df1d6fafc9.45867129', 1, 0, '', '', '13.0000', '30.0000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config_dir`
--

CREATE TABLE `config_dir` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_config_dir` int(11) NOT NULL,
  `dir_print_script` varchar(50) NOT NULL,
  `shared_printer_matrix` varchar(50) NOT NULL,
  `shared_printer_pos` varchar(50) NOT NULL,
  `shared_print_barcode` varchar(250) NOT NULL,
  `rollo_etiqueta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `config_dir`
--

INSERT INTO `config_dir` (`id_server`, `unique_id`, `id_sucursal`, `id_config_dir`, `dir_print_script`, `shared_printer_matrix`, `shared_printer_pos`, `shared_print_barcode`, `rollo_etiqueta`) VALUES
(1, 'O60d7df1d6b5f57.53225294', 1, 1, 'localhost/imprecionFG/', '//localhost/facturacion', '//localhost/ticket', '//localhost/barcode', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config_pos`
--

CREATE TABLE `config_pos` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_config_pos` int(11) NOT NULL,
  `alias_tipodoc` char(4) NOT NULL,
  `header1` varchar(50) NOT NULL,
  `header2` varchar(50) NOT NULL,
  `header3` varchar(50) NOT NULL,
  `header4` varchar(50) NOT NULL,
  `header5` varchar(50) NOT NULL,
  `header6` varchar(50) NOT NULL,
  `header7` varchar(50) NOT NULL,
  `header8` varchar(50) NOT NULL,
  `header9` varchar(50) NOT NULL,
  `header10` varchar(50) NOT NULL,
  `footer1` varchar(50) NOT NULL,
  `footer2` varchar(50) NOT NULL,
  `footer3` varchar(50) NOT NULL,
  `footer4` varchar(50) NOT NULL,
  `footer5` varchar(50) NOT NULL,
  `footer6` varchar(50) NOT NULL,
  `footer7` varchar(50) NOT NULL,
  `footer8` varchar(50) NOT NULL,
  `footer9` varchar(50) NOT NULL,
  `footer10` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `config_pos`
--

INSERT INTO `config_pos` (`id_server`, `unique_id`, `id_sucursal`, `id_config_pos`, `alias_tipodoc`, `header1`, `header2`, `header3`, `header4`, `header5`, `header6`, `header7`, `header8`, `header9`, `header10`, `footer1`, `footer2`, `footer3`, `footer4`, `footer5`, `footer6`, `footer7`, `footer8`, `footer9`, `footer10`) VALUES
(1, 'O60d7df1d6d7820.44563245', 1, 1, 'TIK', '', '', 'VENTA DE PRODUCTOS VARIOS', '', '', '', '', '', '', '', 'GRACIAS POR SU COMPRA, VUELVA PRONTO...', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consignacion`
--

CREATE TABLE `consignacion` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_consignacion` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `concepto` text NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `numero_doc` varchar(30) NOT NULL,
  `total` float NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `anulada` tinyint(1) NOT NULL DEFAULT '0',
  `id_sucursal` int(11) NOT NULL,
  `finalizada` tinyint(1) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `saldo` float NOT NULL,
  `abono` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consignacion_detalle`
--

CREATE TABLE `consignacion_detalle` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_consignacion_detalle` int(11) NOT NULL,
  `id_consignacion` int(11) NOT NULL,
  `id_prod_serv` int(11) NOT NULL,
  `cantidad` float NOT NULL,
  `costo` float NOT NULL,
  `precio_venta` float NOT NULL,
  `subtotal` float NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `tipo_prod_serv` varchar(30) NOT NULL COMMENT 'PRODUCTO o SERVICIO',
  `id_sucursal` int(11) NOT NULL,
  `cant_facturado` float NOT NULL,
  `id_presentacion` int(11) NOT NULL,
  `presentacion` int(11) NOT NULL,
  `unidad` int(11) NOT NULL,
  `cantidad_faltante` int(11) NOT NULL,
  `saldo` float NOT NULL,
  `abono` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `controlcaja`
--

CREATE TABLE `controlcaja` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_corte` int(11) NOT NULL,
  `fecha` varchar(10) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_apertura` int(11) NOT NULL,
  `caja` varchar(3) DEFAULT NULL,
  `turno` int(1) DEFAULT NULL,
  `cajero` varchar(10) DEFAULT NULL,
  `fecha_corte` date NOT NULL,
  `hora_corte` time NOT NULL,
  `tiket` int(11) NOT NULL,
  `ticket_e` int(11) NOT NULL,
  `tinicio` int(5) DEFAULT NULL,
  `tfinal` int(5) DEFAULT NULL,
  `totalnot` int(2) DEFAULT NULL,
  `texento` double DEFAULT NULL,
  `tgravado` double DEFAULT NULL,
  `totalt` double DEFAULT NULL,
  `finicio` int(5) DEFAULT NULL,
  `ffinal` int(5) DEFAULT NULL,
  `totalnof` int(2) DEFAULT NULL,
  `fexento` double DEFAULT NULL,
  `fgravado` double DEFAULT NULL,
  `totalf` double DEFAULT NULL,
  `cfinicio` int(4) DEFAULT NULL,
  `cffinal` int(4) DEFAULT NULL,
  `totalnocf` int(1) DEFAULT NULL,
  `cfexento` double DEFAULT NULL,
  `cfgravado` double DEFAULT NULL,
  `totalcf` double DEFAULT NULL,
  `rinicio` int(11) NOT NULL,
  `rfinal` int(11) NOT NULL,
  `totalnor` int(11) NOT NULL,
  `rexento` double NOT NULL,
  `rgravado` double NOT NULL,
  `totalr` double NOT NULL,
  `cashinicial` double DEFAULT NULL,
  `vtacontado` double DEFAULT NULL,
  `vtaefectivo` double DEFAULT NULL,
  `vtatcredito` double DEFAULT NULL,
  `totalgral` double DEFAULT NULL,
  `subtotal` double DEFAULT NULL,
  `cashfinal` double DEFAULT NULL,
  `diferencia` double DEFAULT NULL,
  `totalnodev` int(1) DEFAULT NULL,
  `totalnoanu` int(1) DEFAULT NULL,
  `depositos` decimal(6,2) DEFAULT NULL,
  `vales` double DEFAULT NULL,
  `tarjetas` double DEFAULT NULL,
  `depositon` int(1) DEFAULT NULL,
  `valen` int(1) DEFAULT NULL,
  `tarjetan` int(1) DEFAULT NULL,
  `ingresos` double DEFAULT NULL,
  `tcredito` int(1) DEFAULT NULL,
  `ncortex` int(1) DEFAULT NULL,
  `ncortez` int(1) DEFAULT NULL,
  `ncortezm` int(1) DEFAULT NULL,
  `cerrado` int(1) DEFAULT NULL,
  `tipo_corte` varchar(20) NOT NULL,
  `monto_ch` float NOT NULL,
  `retencion` float NOT NULL,
  `tinicio_e` int(11) NOT NULL,
  `tfinal_e` int(11) NOT NULL,
  `tdoctexe` int(11) NOT NULL,
  `tottexe` decimal(10,2) NOT NULL,
  `finicio_e` int(11) NOT NULL,
  `ffinal_e` int(11) NOT NULL,
  `tdocfexe` int(11) NOT NULL,
  `totfexe` decimal(10,2) NOT NULL,
  `cfinicio_e` int(11) NOT NULL,
  `cffinal_e` int(11) NOT NULL,
  `tdoccfexe` int(11) NOT NULL,
  `totcfexe` decimal(10,2) NOT NULL,
  `czxe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correlativo`
--

CREATE TABLE `correlativo` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_numdoc` int(11) NOT NULL,
  `tik` int(11) NOT NULL,
  `cof` int(11) NOT NULL,
  `ccf` int(11) NOT NULL,
  `ref` int(11) NOT NULL,
  `ii` int(11) NOT NULL,
  `di` int(11) NOT NULL,
  `ai` int(11) NOT NULL,
  `ti` int(11) NOT NULL,
  `voc` int(11) NOT NULL,
  `aj` int(11) NOT NULL,
  `cot` int(11) NOT NULL,
  `tre` int(11) NOT NULL,
  `trr` int(11) NOT NULL,
  `dev` int(11) NOT NULL,
  `nc` int(11) NOT NULL,
  `pd` int(11) NOT NULL,
  `pdp` int(11) NOT NULL,
  `cof_e` int(11) NOT NULL,
  `ccf_e` int(11) NOT NULL,
  `nc_e` int(11) NOT NULL,
  `dev_e` int(11) NOT NULL,
  `con` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `correlativo`
--

INSERT INTO `correlativo` (`id_server`, `unique_id`, `id_sucursal`, `id_numdoc`, `tik`, `cof`, `ccf`, `ref`, `ii`, `di`, `ai`, `ti`, `voc`, `aj`, `cot`, `tre`, `trr`, `dev`, `nc`, `pd`, `pdp`, `cof_e`, `ccf_e`, `nc_e`, `dev_e`, `con`) VALUES
(1, 'O60d7df1e21cb29.22895557', 1, 1, 0, 1, 1, 0, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacion`
--

CREATE TABLE `cotizacion` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_cotizacion` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `vigencia` int(11) NOT NULL,
  `numero_doc` varchar(15) NOT NULL,
  `total` float NOT NULL,
  `impresa` tinyint(1) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacion_detalle`
--

CREATE TABLE `cotizacion_detalle` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_detalle` int(11) NOT NULL,
  `id_cotizacion` int(11) NOT NULL,
  `id_prod_serv` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` float NOT NULL,
  `subtotal` float NOT NULL,
  `tipo_prod_serv` varchar(20) NOT NULL,
  `id_presentacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `credito`
--

CREATE TABLE `credito` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_credito` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `tipo_doc` varchar(50) NOT NULL,
  `numero_doc` varchar(50) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `dias` int(11) NOT NULL,
  `total` float NOT NULL,
  `abono` float NOT NULL,
  `saldo` float NOT NULL,
  `finalizada` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas_por_pagar_abonos`
--

CREATE TABLE `cuentas_por_pagar_abonos` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_abono` int(11) NOT NULL,
  `id_cuentas_por_pagar` int(11) NOT NULL,
  `abono` decimal(10,4) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta_banco`
--

CREATE TABLE `cuenta_banco` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_cuenta` int(11) NOT NULL,
  `numero_cuenta` varchar(50) NOT NULL,
  `nombre_cuenta` varchar(100) NOT NULL,
  `id_banco` int(11) NOT NULL,
  `observaciones` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cuenta_banco`
--

INSERT INTO `cuenta_banco` (`id_server`, `unique_id`, `id_sucursal`, `id_cuenta`, `numero_cuenta`, `nombre_cuenta`, `id_banco`, `observaciones`) VALUES
(1, 'O60d7df1e3cca68.66763819', 0, 1, '87141516', 'cuenta corriente', 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta_pagar`
--

CREATE TABLE `cuenta_pagar` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_cuenta_pagar` int(11) NOT NULL,
  `id_compra` int(11) DEFAULT NULL,
  `hora` time NOT NULL,
  `numero_doc` varchar(15) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `monto` float DEFAULT NULL,
  `saldo_pend` float NOT NULL,
  `fecha_vence` date DEFAULT NULL,
  `comentario` varchar(10) DEFAULT NULL,
  `dias_credito` int(3) DEFAULT NULL,
  `alias_tipodoc` char(5) NOT NULL,
  `id_empleado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_departamento` int(11) NOT NULL COMMENT 'ID del departamento',
  `nombre_departamento` varchar(30) NOT NULL COMMENT 'Nombre del departamento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Departamentos de El Salvador';

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id_server`, `unique_id`, `id_departamento`, `nombre_departamento`) VALUES
(1, 'O60d7df1e55b259.94639046', 1, 'Ahuachapán'),
(2, 'O60d7df1e574b96.30477807', 2, 'Santa Ana'),
(3, 'O60d7df1e594646.42936928', 3, 'Sonsonate'),
(4, 'O60d7df1e5b5147.46090564', 4, 'La Libertad'),
(5, 'O60d7df1e5d6ca8.51505396', 5, 'Chalatenango'),
(6, 'O60d7df1e5f9483.12632339', 6, 'San Salvador'),
(7, 'O60d7df1e6191f2.34714250', 7, 'Cuscatlán'),
(8, 'O60d7df1e63be58.70522487', 8, 'La Paz'),
(9, 'O60d7df1e65c640.57582666', 9, 'Cabañas'),
(10, 'O60d7df1e67e0b6.31201543', 10, 'San Vicente'),
(11, 'O60d7df1e69e1a6.75867318', 11, 'Usulután'),
(12, 'O60d7df1e6bee97.87512541', 12, 'Morazán'),
(13, 'O60d7df1e6e04a6.79246797', 13, 'San Miguel'),
(14, 'O60d7df1e703980.80281832', 14, 'La Unión');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_apertura`
--

CREATE TABLE `detalle_apertura` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_detalle` int(11) NOT NULL,
  `id_apertura` int(11) NOT NULL,
  `turno` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `vigente` tinyint(1) NOT NULL,
  `caja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_apertura`
--

INSERT INTO `detalle_apertura` (`id_server`, `unique_id`, `id_sucursal`, `id_detalle`, `id_apertura`, `turno`, `id_usuario`, `fecha`, `hora`, `vigente`, `caja`) VALUES
(0, 'S626971d436c434.20996398', 1, 0, 1, 1, 1, '2022-04-27', '10:39:46', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_det_compra` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `id_server_prod` int(11) NOT NULL,
  `cantidad` decimal(10,4) DEFAULT NULL,
  `ultcosto` decimal(5,2) DEFAULT NULL,
  `exento` tinyint(1) NOT NULL,
  `subtotal` float NOT NULL,
  `id_presentacion` int(11) NOT NULL,
  `id_server_presen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_voucher`
--

CREATE TABLE `detalle_voucher` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_detalle` int(11) NOT NULL,
  `fecha` varchar(11) DEFAULT NULL,
  `numero` varchar(50) DEFAULT NULL,
  `cargo` varchar(11) DEFAULT NULL,
  `porcentage` varchar(11) DEFAULT NULL,
  `descuento` varchar(11) DEFAULT NULL,
  `devolucion` varchar(11) DEFAULT NULL,
  `bonificacion` varchar(11) DEFAULT NULL,
  `retencion` varchar(11) DEFAULT NULL,
  `vin` varchar(11) DEFAULT NULL,
  `saldo` varchar(11) DEFAULT NULL,
  `id_cuenta_pagar` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devoluciones`
--

CREATE TABLE `devoluciones` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_dev` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `id_factura_dev` int(11) NOT NULL,
  `cant` int(11) NOT NULL,
  `monto` float NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `nombre` text NOT NULL,
  `dui` text NOT NULL,
  `telefono` int(11) NOT NULL,
  `exento` decimal(10,2) NOT NULL,
  `gravado` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devoluciones_corte`
--

CREATE TABLE `devoluciones_corte` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_dev` int(11) NOT NULL,
  `id_corte` int(11) NOT NULL,
  `n_devolucion` varchar(30) NOT NULL,
  `t_devolucion` double NOT NULL,
  `afecta` varchar(30) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `exento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devoluciones_det`
--

CREATE TABLE `devoluciones_det` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_dev_det` int(11) NOT NULL,
  `id_dev` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cant` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `id_factura_detalle` int(11) NOT NULL,
  `exento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `nit` varchar(20) NOT NULL,
  `dui` varchar(16) NOT NULL,
  `direccion` varchar(250) NOT NULL,
  `telefono1` varchar(12) NOT NULL,
  `telefono2` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `salariobase` float NOT NULL,
  `id_tipo_empleado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id_server`, `unique_id`, `id_sucursal`, `id_empleado`, `nombre`, `apellido`, `nit`, `dui`, `direccion`, `telefono1`, `telefono2`, `email`, `salariobase`, `id_tipo_empleado`) VALUES
(-1, 'O60d7df1fbc7114.40400621', 0, -1, 'Mostrador', '', '', '', '', '', '', '', 0, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `idempresa` int(1) NOT NULL,
  `nombre` varchar(15) DEFAULT NULL,
  `razonsocial` varchar(30) DEFAULT NULL,
  `direccion` varchar(25) DEFAULT NULL,
  `ubicacion` varchar(23) DEFAULT NULL,
  `nrc` varchar(6) DEFAULT NULL,
  `nit` varchar(17) DEFAULT NULL,
  `giro` varchar(16) DEFAULT NULL,
  `telefono1` varchar(10) DEFAULT NULL,
  `depto` varchar(10) DEFAULT NULL,
  `direccion2` varchar(32) DEFAULT NULL,
  `telefono2` varchar(9) DEFAULT NULL,
  `logo` varchar(250) NOT NULL,
  `iva` decimal(5,2) NOT NULL,
  `monto_retencion1` decimal(5,2) NOT NULL,
  `monto_retencion10` decimal(5,2) NOT NULL,
  `monto_percepcion` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id_server`, `unique_id`, `idempresa`, `nombre`, `razonsocial`, `direccion`, `ubicacion`, `nrc`, `nit`, `giro`, `telefono1`, `depto`, `direccion2`, `telefono2`, `logo`, `iva`, `monto_retencion1`, `monto_retencion10`, `monto_percepcion`) VALUES
(1, 'O60d7df1fc4b5c2.47201482', 1, 'CALZADO MAYORGA', 'Edgar Rodolfo Mayorga Ascencio', '4a Calle Poniente No. 214', 'San Miguel, El Salvador', '2404-0', '1217-090236-001-0', 'Venta de Calzado', '2661-1836', 'SAN MIGUEL', 'Sucursal Metrocentro Local 64/65', '2667-0452', 'img/5af09749a77c6_logo_sys.png', '13.00', '100.00', '100.00', '100.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estante`
--

CREATE TABLE `estante` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_estante` int(11) NOT NULL,
  `id_ubicacion` int(11) NOT NULL,
  `descripcion` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `numero_doc` varchar(30) NOT NULL,
  `referencia` varchar(15) NOT NULL,
  `numero_ref` int(11) NOT NULL,
  `subtotal` float NOT NULL,
  `sumas` float NOT NULL,
  `suma_gravado` float NOT NULL,
  `iva` float NOT NULL,
  `retencion` float NOT NULL,
  `venta_exenta` float NOT NULL,
  `total_menos_retencion` float NOT NULL,
  `total` float NOT NULL,
  `descuento` float NOT NULL,
  `porcentaje` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `anulada` tinyint(1) NOT NULL DEFAULT '0',
  `id_empleado` int(11) NOT NULL,
  `finalizada` tinyint(1) NOT NULL,
  `impresa` tinyint(1) NOT NULL,
  `tipo` varchar(30) NOT NULL,
  `serie` varchar(25) NOT NULL,
  `serie_e` varchar(25) NOT NULL,
  `num_fact_impresa` varchar(30) NOT NULL,
  `hora` time NOT NULL,
  `turno` int(11) NOT NULL,
  `id_apertura` int(11) NOT NULL,
  `id_apertura_pagada` int(11) NOT NULL,
  `credito` tinyint(1) NOT NULL,
  `abono` float NOT NULL,
  `saldo` float NOT NULL,
  `afecta` int(11) NOT NULL,
  `tipo_documento` varchar(20) NOT NULL,
  `caja` int(11) NOT NULL,
  `numero_doc_e` varchar(30) NOT NULL,
  `num_fact_impresa_e` varchar(30) NOT NULL,
  `nombre` text NOT NULL,
  `direccion` text NOT NULL,
  `precio_aut` int(11) NOT NULL,
  `clave` varchar(6) NOT NULL,
  `cargo_tarjeta` decimal(10,2) NOT NULL,
  `efectivo` text,
  `cambio` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`id_server`, `unique_id`, `id_sucursal`, `id_factura`, `id_cliente`, `fecha`, `numero_doc`, `referencia`, `numero_ref`, `subtotal`, `sumas`, `suma_gravado`, `iva`, `retencion`, `venta_exenta`, `total_menos_retencion`, `total`, `descuento`, `porcentaje`, `id_usuario`, `anulada`, `id_empleado`, `finalizada`, `impresa`, `tipo`, `serie`, `serie_e`, `num_fact_impresa`, `hora`, `turno`, `id_apertura`, `id_apertura_pagada`, `credito`, `abono`, `saldo`, `afecta`, `tipo_documento`, `caja`, `numero_doc_e`, `num_fact_impresa_e`, `nombre`, `direccion`, `precio_aut`, `clave`, `cargo_tarjeta`, `efectivo`, `cambio`) VALUES
(0, 'S6269721f3f6965.38322137', 1, 0, 1, '2022-04-27', '0000000001_COF', '', 0, 12, 12, 12, 0, 0, 0, 12, 12, 0, 0, 1, 0, 1, 1, 0, 'FACTURA CONSUMIDOR', '18NU000F', '0', '', '10:41:02', 1, 1, 1, 0, 0, 0, 0, 'COF', 1, '0', '0', '', '', 0, '', '0.00', NULL, NULL),
(0, 'S6269876bb41d34.09483176', 1, 1, 1, '2022-04-27', '0000000001_CCF', '', 0, 105, 92.92, 92.92, 12.08, 0, 0, 105, 105, 0, 0, 1, 0, 1, 1, 0, 'CREDITO FISCAL', '18UN000C', '0', '', '12:11:55', 1, 1, 1, 0, 0, 0, 0, 'CCF', 1, '0', '0', '', '', 0, '', '0.00', NULL, NULL),
(0, 'S6269959a3f3258.11273139', 1, 2, 1, '2022-04-27', '0000000001_TIK', '', 0, 7.5, 7.5, 7.5, 0, 0, 0, 7.5, 7.5, 0, 0, 1, 0, 1, 1, 0, 'TICKET', '22MS0000001', '0', '1', '13:12:26', 1, 1, 1, 0, 0, 0, 0, 'TIK', 1, '0', '0', '', '', 0, '', '0.00', NULL, NULL),
(0, 'S6269a749372767.40984088', 1, 3, -1, '2022-04-27', '0000000002_TIK', '', 0, 1, 1, 1, 0, 0, 0, 1, 1, 0, 0, 1, 0, 1, 1, 0, 'TICKET', '22MS0000001', '0', '2', '14:27:53', 1, 1, 1, 0, 0, 0, 0, 'TIK', 1, '0', '0', '', '', 0, '', '0.00', NULL, NULL),
(0, 'S6269a91c5a1202.33426792', 1, 4, -1, '2022-04-27', '0000000003_TIK', '', 0, 1.25, 1.25, 1.25, 0, 0, 0, 1.25, 1.25, 0, 0, 1, 0, 1, 1, 1, 'TICKET', '22MS0000001', '0', '3', '14:35:40', 1, 1, 1, 0, 0, 0, 0, 'TIK', 1, '0', '0', '', '', 0, '', '0.00', '5', '3.75');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_detalle`
--

CREATE TABLE `factura_detalle` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_factura_detalle` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `id_prod_serv` int(11) NOT NULL,
  `description` text,
  `id_server_prod` int(11) NOT NULL,
  `cantidad` decimal(11,4) NOT NULL,
  `precio_venta` decimal(11,4) NOT NULL,
  `subtotal` decimal(11,2) NOT NULL,
  `descuento` float NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `tipo_prod_serv` varchar(30) NOT NULL COMMENT 'PRODUCTO o SERVICIO',
  `id_factura_dia` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `impresa_lote` tinyint(1) NOT NULL,
  `hora` time NOT NULL,
  `id_presentacion` int(11) NOT NULL,
  `id_server_presen` int(11) NOT NULL,
  `exento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `factura_detalle`
--

INSERT INTO `factura_detalle` (`id_server`, `unique_id`, `id_sucursal`, `id_factura_detalle`, `id_factura`, `id_prod_serv`, `description`, `id_server_prod`, `cantidad`, `precio_venta`, `subtotal`, `descuento`, `id_empleado`, `tipo_prod_serv`, `id_factura_dia`, `fecha`, `impresa_lote`, `hora`, `id_presentacion`, `id_server_presen`, `exento`) VALUES
(0, 'S6269721f400ab9.80087686', 1, 0, 0, 2, '', 0, '12.0000', '12.0000', '12.00', 0, 1, 'PRODUCTO', 0, '2022-04-27', 0, '10:41:03', 4, 0, 0),
(0, 'S6269876bc4cf56.63139529', 1, 1, 1, 3, '', 0, '30.0000', '24.0000', '63.72', 0, 1, 'PRODUCTO', 0, '2022-04-27', 0, '12:11:55', 7, 0, 0),
(0, 'S6269876bc76102.03282135', 1, 2, 1, 5, '', 0, '36.0000', '11.0000', '29.20', 0, 1, 'PRODUCTO', 0, '2022-04-27', 0, '12:11:55', 16, 0, 0),
(0, 'S6269959ad78024.03462827', 1, 3, 2, 3, '', 0, '3.0000', '2.5000', '7.50', 0, 1, 'PRODUCTO', 0, '2022-04-27', 0, '13:12:26', 9, 0, 0),
(0, 'S6269a74952bbe8.83626539', 1, 4, 3, 2, '', 0, '1.0000', '1.0000', '1.00', 0, 1, 'PRODUCTO', 0, '2022-04-27', 0, '14:27:53', 6, 0, 0),
(0, 'S6269a91c5af740.42537515', 1, 5, 4, 1, '', 0, '1.0000', '1.2500', '1.25', 0, 1, 'PRODUCTO', 0, '2022-04-27', 0, '14:35:40', 2, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Hoja1`
--

CREATE TABLE `Hoja1` (
  `id_producto` int(11) NOT NULL,
  `Codigo` varchar(23) DEFAULT NULL,
  `Nombre` varchar(57) DEFAULT NULL,
  `Precio_de_venta` decimal(7,4) DEFAULT NULL,
  `Precio_de_compra` decimal(8,6) DEFAULT NULL,
  `Cantidad` int(4) DEFAULT NULL,
  `Marca` varchar(20) DEFAULT NULL,
  `Descuento` int(1) DEFAULT NULL,
  `Descripcion` varchar(36) DEFAULT NULL,
  `Imagen` varchar(38) DEFAULT NULL,
  `Ubicacion` varchar(40) DEFAULT NULL,
  `StockMinimo` int(3) DEFAULT NULL,
  `PrecioMayoreo` int(1) DEFAULT NULL,
  `PrecioDistribuidor` varchar(10) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `Hoja1`
--

INSERT INTO `Hoja1` (`id_producto`, `Codigo`, `Nombre`, `Precio_de_venta`, `Precio_de_compra`, `Cantidad`, `Marca`, `Descuento`, `Descripcion`, `Imagen`, `Ubicacion`, `StockMinimo`, `PrecioMayoreo`, `PrecioDistribuidor`, `id_categoria`) VALUES
(1, '7702011273215', 'GALLETAS NAVIDEÑAS COLOMBINA CAJA', '1.5000', '1.150000', 4, 'Golocinas', 0, 'Caja Roja con pinguinos', NULL, 'Estante inferior 1', 2, NULL, NULL, 2),
(2, '7401007600003', 'TUCAN TEMPERA JUNIOR 6 UNIDADES', '1.7500', '1.110000', 30, NULL, 0, 'Color amarillo', NULL, NULL, 3, NULL, NULL, 1),
(3, '7401007600966', 'TUCAN TEMPERAS COLOR VERDE 45 g', '0.3600', '0.300000', 12, 'Escolar', 0, 'BOTE COLOR VERDE', NULL, 'VITRINA 5 LADO IZQUIERDO', NULL, NULL, NULL, 3),
(4, '7401007600942', 'TUCAN TEMPERA COLOR NEGRO 45 g', '0.6500', '0.300000', 11, 'Escolar', 0, 'BOTE COLOR NEGRO', NULL, 'VITRINA 4 LADO IZQUIERDO', 3, NULL, NULL, 3),
(5, '7401007600911', 'TUCAN TEMPERA COLOR AZUL 45 g', '0.6500', '0.300000', 9, 'Escolar', 0, 'AZUL', NULL, 'VITRINA 4 LADO IZQUIERDO', 3, NULL, NULL, 3),
(6, '7401007602434', 'TUCAN TEMPERA COLOR PIEL 45g', '0.6500', '0.300000', 5, 'Escolar', 0, 'BOTE COLOR PIEL', NULL, 'VITRINA 4 LAZO IZQUIERDO', NULL, NULL, NULL, 3),
(7, '7401007612952', 'TUCAN TEMPERA COLOR ROSADO 45 g', '0.6500', '0.300000', 4, 'Escolar', 0, NULL, NULL, 'BOTE COLOR ROSADO', 3, NULL, NULL, 3),
(8, '7401007600935', 'TUCAN TEMPERA COLOR ROJO 45 g', '0.6500', '0.300000', 13, 'Escolar', 0, 'BOTE COLOR ROJO', NULL, 'VITRINA 4 LADO IZQUIERDO', 3, NULL, NULL, 3),
(9, '7401007600928', 'TUCAN TEMPERA COLOR AMARILLO 45 g', '0.6500', '0.300000', 13, 'Escolar', 0, 'BOTE COLOR AMARILLO', NULL, 'VITRINA 4 LADO IZQUIERDO', 3, NULL, NULL, 3),
(10, '7401007602342', 'TUCAN TEMPERA VERDE LIMA 45g', '0.6500', '0.300000', 2, 'Escolar', 0, 'BOTE COLOR VERDE LIMA', NULL, 'VITRINA 4 LADO IZQUIERDO', 3, NULL, NULL, 3),
(11, '7401007601024', 'TUCAN TEMPERA COLOR VIOLETA 45g', '0.6500', '0.300000', 2, 'Escolar', 0, 'BOTE COLOR VIOLETA', NULL, 'VITRINA 4 LADO IZQUIERDO', 3, NULL, NULL, 3),
(12, '7401007600959', 'TUCAN TEMPERA COLOR BLANCO 45 g', '0.6500', '0.300000', 9, 'Escolar', 0, 'BOTE COLOR BLANCO', NULL, 'VITRINA 4 LADO IZQUIERDO', 3, NULL, NULL, 3),
(13, '7401007603295', 'ACURELA DE ALTA CALIDAD TUCAN 12 COLORES', '1.7500', '1.200000', 8, 'Escolar', 0, NULL, NULL, 'VITRINA 4 LADO IZQUIERDO', 3, NULL, NULL, 3),
(14, '7401007600089', 'TUCAN CRAYONES DE CERA12 u.', '1.0000', '0.710000', 79, 'Escolar', 0, NULL, NULL, 'VITRINA 4 LADO IZQUIERDO', 3, NULL, NULL, 3),
(15, '7401007699007', 'TUCAN CRAYONES CERA TRIANGULAR JUMBO 12 U.', '2.0000', '1.050000', 6, 'Escolar', 0, NULL, NULL, 'VITRINA 4 LADO IZQUIERDO', 3, NULL, NULL, 3),
(16, '6938802660129', 'ACUARELA WATER COLOR 12 UNIDADES', '2.2500', '1.450000', 1, 'Escolar', 0, NULL, NULL, 'VITRINA 4 LADO IZQUIERDO', 3, NULL, NULL, 3),
(17, '071662005252', 'CRAYOLA WATER COLOR 8 COLORES', '1.6000', '1.050000', 0, 'Escolar', 0, NULL, NULL, 'VITRINA 4 LADO IZQUIERDO', 3, NULL, NULL, 3),
(18, '7401007600171', 'TUCAN PLASTICINA 10 COLORES 180 g', '0.8000', '0.450000', 48, NULL, 0, NULL, NULL, 'VITRINA 4 LADO IZQUIERDO', 3, NULL, NULL, 1),
(19, '9787557515034', 'LIBRITO FOAMY DE MULTIPLICAR', '2.0000', '1.000000', 7, 'Escolar', 0, NULL, NULL, 'VITRINA 4 LADO IZQUIERDO', 3, NULL, NULL, 3),
(20, '071662077228', 'CRAYOLA MARKERS 10 COLORES ', '3.0000', '1.500000', 7, 'Escolar', 0, NULL, NULL, 'VITRINA 4 LADO IZQUIERDO', 3, NULL, NULL, 3),
(21, '7501015205693', 'CRAYONES DE CERA METALICO PELICAN 6 U.', '1.7500', '0.875000', 4, 'Escolar', 0, NULL, NULL, 'VITRINA 4 LADO IZQUIERDO', 3, NULL, NULL, 3),
(22, '7702111490161', 'MARCADORES METALOIZADOS KIUT 6 U.', '6.0000', '3.000000', 4, 'Escolar', 0, NULL, NULL, 'VITRINA 4 LADO IZQUIERDO', 2, NULL, NULL, 3),
(23, '7807265007569', 'PLUOMNES PUNTA DELGADA PROARTE 12 U.', '1.7500', '0.875000', 2, 'Escolar', 0, NULL, NULL, 'VITRINA 4 LADO IZQUIERDO', 3, NULL, NULL, 3),
(24, '7401007600775', 'TUCAN CRAYONES ECCO 12 U. CORTOS', '0.8500', '0.590000', 57, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(25, '7401007626188', 'TUCAN MOJIS BORRADOR 30 U', '1.7500', '0.875000', 9, 'Escolar', 0, NULL, NULL, 'VITRINA 4 EN MEDIO', 1, NULL, NULL, 3),
(26, '7702111507579', 'MARCADORES KIUT GLITTER 10 U.', '11.0000', '5.500000', 0, 'Escolar', 0, NULL, NULL, 'VITRINA 4 EN MEDIO', 2, NULL, NULL, 3),
(27, '768497212022', 'FACELA LAPICES DE COLORES CARIBE 12 U. CORTOS', '1.3500', '0.949900', 21, NULL, 0, NULL, NULL, 'VITRINA 4 EN MEDIO', 3, NULL, NULL, 1),
(28, '7417200604007', 'PARROT LAPICES DE COLOR LARGO 12 U.', '1.7500', '0.875000', 7, 'Escolar', 0, NULL, NULL, 'VITRINA 4 LADO DERECHO', 3, NULL, NULL, 3),
(29, '3154148296003', 'MAPED LAPICES DE COLOR COLOR PEPS DUO LARGOS', '3.5000', '2.120000', 12, 'Escolar', 0, NULL, NULL, 'VITRINA 4 LADO DERECHO', 3, NULL, NULL, 3),
(30, '3154148627128', 'MAPED COLOR PEPS STRONG LARGO 12 U.', '2.5000', '1.470000', 1, 'Escolar', 0, NULL, NULL, 'VITRINA 4 LADO DERECHO', 3, NULL, NULL, 3),
(31, '3154148322122', 'MAPED COLOR PEPS ANIMALS LARGOS 12 U.', '3.2500', '2.120000', 6, 'Escolar', 0, NULL, NULL, 'VITRINA 4 LADO DERECHO', 3, NULL, NULL, 3),
(32, '7702111540255', 'NOMRA 12 LAPICES 15 COLORES', '3.2500', '2.685600', 6, NULL, 0, NULL, NULL, 'VITRINA 4 LADO DERECHO', 3, NULL, NULL, 1),
(33, '4011169654344', 'STICKY NOTES INFO ORGANISE YOUR WORK AMARILLO', '0.8500', '0.425000', 5, 'Escolar', 0, NULL, NULL, 'VITRINA 4 LADO DERECHO', 3, NULL, NULL, 3),
(34, '7453015108125', 'STUDMARK STICKY NOTES ROSA', '0.8500', '0.425000', 4, 'Escolar', 0, NULL, NULL, 'VITRINA 4 LADO DERECHO', 3, NULL, NULL, 3),
(35, '6942310506411', 'XINGLY G-3 STICKY NOTES FIGURA 100 U.', '1.0000', '0.500000', NULL, 'Escolar', 0, NULL, NULL, 'VITRINA 4 LADO DERECHO', 3, NULL, NULL, 3),
(36, '6979945610022', 'STICKY NOTES FIGURA DINOSAURIOS 7 U.', '1.0000', '0.500000', 2, 'Escolar', 0, NULL, NULL, 'VITRINA 4 LADO DERECHO', 3, NULL, NULL, 3),
(37, '4974052846342', 'ARTLINE BORRADOR MAGNETICO', '2.5000', '1.250000', 1, 'Escolar', 0, NULL, NULL, 'VITRINA 4 LADO DERECHO', 3, NULL, NULL, 3),
(38, '3154148457220', 'MAPED COLORS PEPS OCEAN 24 U.', '4.9500', '2.475000', 0, 'Escolar', 0, NULL, NULL, 'VITRINA 4 LADO DERECHO', 3, NULL, NULL, 3),
(39, '7401007616974', 'TUCAN SKETCHING SET LAPICES DE DIBUJO 12 U.', '4.2500', '2.125000', 1, 'Escolar', 0, NULL, NULL, 'VITRINA 4 LADO DRECHO', 3, NULL, NULL, 3),
(40, '446841183441', 'FACELA VITAL ALCHOOL GEL 30 ml', '1.0000', '0.500000', 9, 'SALUD Y LIMPIEZA', 0, NULL, NULL, 'VITRINA 4 LADO DERECHO', 3, NULL, NULL, 4),
(41, '7702010420320', 'PROTEX JAVON LIQUIDO ALOE 221 ml', '2.8500', '1.425000', 2, 'SALUD Y LIMPIEZA', 0, NULL, NULL, 'VITRINA 4 LADO DERECHO', 1, NULL, NULL, 4),
(42, '7702010420313', 'PROTEX JABON LIQUIDO AVENA 221 ,l', '2.8500', '1.425000', 2, 'SALUD Y LIMPIEZA', 0, NULL, NULL, 'VITRINA 4 LADO DERECHO', 1, NULL, NULL, 4),
(43, '768497212046', 'FACELA CARIBE 24 COLRS CON SACAPUNTA', '4.9500', '3.390000', 22, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(44, '531852726804', 'BEBE CON PONY ', '5.0000', '2.500000', 2, 'BEBE', 0, NULL, NULL, NULL, 1, NULL, NULL, 5),
(45, '248138646384', 'ATOMIZADOR 100 ml', '1.0000', '0.350000', -2, 'SALUD Y LIMPIEZA', 0, NULL, NULL, 'VITRINA 4 LADO DERECHO', 4, NULL, NULL, 4),
(46, '7453086105641', 'BAMBARY LISTON PARA CHONGA MORADO LILA GRUESA 100 YARDAS', '3.2500', '1.625000', 1, 'Escolar', 0, NULL, NULL, 'VITRINA 4 SEGUNDO ESTANTE LADO IZQUIERDO', 1, NULL, NULL, 3),
(47, '7453026705535', 'BAMBARY LISTON PARA CHONGA NARANJA CLARO 100 YARDAS', '3.2500', '1.625000', 1, 'Escolar', 0, NULL, NULL, 'VITRINA 4 SEGUNDO ESTANTE LADO IZQUIERDO', 1, NULL, NULL, 3),
(48, '7453086105665', 'BAMBARY LISTON PARA CHONGA NEGRO GRUESA 100 YARDAS', '3.2500', '1.625000', 2, 'Escolar', 0, NULL, NULL, 'VITRINA 4 SEGUNDO ESTANTE LADO IZQUIERDO', 1, NULL, NULL, 3),
(49, '7453086105597', 'BAMBARY LISTON PARA CHONGA GRUESA VERDE CLARO 100 YARDAS', '3.2500', '1.625000', 1, 'Escolar', 0, NULL, NULL, 'VITRINA 4 SEGUNDO ESTANTE LADO IZQUIERDO', 1, NULL, NULL, 3),
(50, '7453086105528', 'BAMBARY LISTON PARA CHONGA BLANCO 100 YARDAS', '3.2500', '1.625000', 1, 'Escolar', 0, NULL, NULL, 'VITRINA 4 SEGUNDO ESTANTE LADO IZQUIERDO', 1, NULL, NULL, 3),
(51, '7453026705498', 'BAMBARY LISTON PARA CHONGA DELGADA MORADO LILA 100 YARDAS', '2.0000', '1.000000', NULL, 'Escolar', 0, NULL, NULL, 'VITRINA 4 SEGUNDO ESTANTE LADO IZQUIERDO', 1, NULL, NULL, 3),
(52, '7453086105511', 'BAMBARY LISTON PRA CHONGA NEGRO DELGADA 100 YARDAS', '2.0000', '1.000000', 2, 'Escolar', 0, NULL, NULL, 'VITRINA 4 SEGUNDO ESTANTE LADO IZQUIERDO', 1, NULL, NULL, 3),
(53, '7453086105450', 'BAMBARY LISTON PARA CHONGA DELGADA VERDE MUZGO 100 YARDAS', '2.0000', '1.000000', 1, 'Escolar', 0, NULL, NULL, 'VITRINA 4 SEGUNDO ESTANTE LADO IZQUIERDO', 1, NULL, NULL, 3),
(54, '7426500812425', 'LIBRETA DE APUNTES PEQUEÑA', '0.4000', '0.200000', 1, 'Escolar', 0, NULL, NULL, 'VITRINA 4 SEGUNDO ESTANTE LADO IZQUIERDO', 3, NULL, NULL, 3),
(55, '7426500801832', 'LIBRERTA MINIMASTER ', '1.2500', '0.625000', 1, 'Escolar', 0, NULL, NULL, 'VITRINA 4 SEGUNDO ESTANTE LADO IZQUIERDO', 2, NULL, NULL, 3),
(56, '41618271', 'CONQUISTADOR CUADERNO COCIDO 100 HOJAS 200 PAGS CUAD.', '1.5000', '0.750000', 13, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(57, '7410032120349', 'GRAFIX CUADERNO COSIDO DOBLE RAYA 200 PAGS', '1.5000', '0.750000', 3, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(58, '7410032120332', 'GRAFIX COSIDO CUADRICULADO COSIDO 200 PAGS.', '1.5000', '0.750000', 2, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(59, '7417200623985', 'BEXCELLENT COSIDO GRANDE 100 HOJAS RAYADO', '1.5000', '0.750000', 7, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(60, '7702111558786', 'NORMA COSIDO GRANDE CUAD. 100 PAGS.', '2.0000', '1.000000', 0, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(61, '7702111558823', 'NORMA COSIDO GRANDE RAYADO 100 PAGS.', '2.0000', '1.000000', -22, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(62, '7702111558793', 'NORMA COSIDO GRANDE DOBLE RAYA 100 PAGS.', '2.0000', '1.000000', 1, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(63, '7416500271650', 'CONQUISTADOR COSIDO CUAD. 100 PAGS', '1.5000', '0.750000', NULL, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(64, '222714256118', 'LIBRO DE COLOREO DE BOLSILLO', '0.4000', '0.200000', 41, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(65, '7410062030120', 'Alchool Gel Dr. Plus 120 ml', '1.0000', '0.500000', -5, 'SALUD Y LIMPIEZA', 0, NULL, NULL, NULL, 5, NULL, NULL, 4),
(66, '7411001203766', 'SET MILDER BABY ACEITE JABON SHAMPOO', '5.5000', '4.300000', 4, 'BEBE', 0, NULL, NULL, NULL, 1, NULL, NULL, 5),
(67, '7411001200567', 'COLONIA MILDER 120 ML. NIÑO', '2.7500', '1.950000', 2, 'BEBE', 0, NULL, NULL, NULL, 2, NULL, NULL, 5),
(68, '7415815900019', 'DILISA LISTON ROJO ANCHO', '3.2500', '1.000000', 6, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(69, '7453086105498', 'BAMBARY LISTON DELGADO ', '2.0000', '1.000000', 4, 'FIESTA', 0, NULL, NULL, NULL, 2, NULL, NULL, 6),
(70, '7411001200574', 'COLONIA PARA BEBITA MILDER 120 ML. NIÑA', '2.7500', '2.200000', 4, 'BEBE', 0, NULL, NULL, NULL, 1, NULL, NULL, 5),
(71, '4891985036810', 'BABY CRISTY CLIP', '0.9000', '0.500000', 12, 'BEBE', 0, NULL, NULL, NULL, 4, NULL, NULL, 5),
(72, '634222104278', 'ACEITE PARA BEBE CHIQUITIN ECO.', '0.7500', '0.290000', NULL, 'BEBE', 0, NULL, NULL, NULL, 3, NULL, NULL, 5),
(73, '6922680200560', 'AGENDA NOTBOOK PEQUEÑA', '0.9500', '0.475000', 2, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(74, '681677425658', 'LIBRETAS MINI FIGURAS', '0.3500', '0.175000', 21, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(75, '043736838154', 'LIBRETA A-79 FIGURAS MINI TINKERBELL', '0.6500', '0.325000', 2, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(76, '6985449650006', 'TABLA CON CLIP FIGURA MEDIANA', '2.7500', '1.375000', 2, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(77, '214518154157', 'SILABARIO CLASICO', '0.7500', '0.375000', 7, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(78, '202342016504', 'SILABARIO CON AREA DE APRESTO', '2.5000', '1.250000', 2, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(79, '472734330244', 'SILABARIO HISPANOAMERICANO DE COLOR', '2.5000', '1.250000', 0, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(80, '289936787890', 'ROXY CUADERNO ASPIRAL #1 RAYADO 140 PAGS', '1.0000', '0.500000', -4, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(81, '7417200623596', 'BEXCELELLENT CUADERNO #1 140 PAGS. CUAD.', '1.0000', '0.500000', 7, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(82, '7417200623640', 'BEXCELLLENT CUADERNO #3 140 PAGS. CUAD.', '0.9500', '0.620000', 62, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(83, '7410032120325', 'GRAFIX CUADERNO ASPIRAL #3 140 PAGS. RAYADO', '1.0000', '0.500000', 2, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(84, '7501017351411', 'SCRIBE CUADERNO 50 G RAYADO DOBLE ARO', '1.5000', '0.900000', 13, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(85, '7417200623893', 'BEXCELLENT RAYA ANCHA COSIDO PEQUEÑO 200 PAGS.', '0.9000', '0.450000', 18, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(86, '7416500226452', 'CONQUISTADOR CUAD. COSIDO 200 PAGS CUADRO', '0.9000', '0.450000', NULL, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(87, '7417200623770', 'BEXCELLENT DO. RAYA GRAPADO 200 PAGS.', '0.6500', '0.325000', 124, NULL, 0, NULL, NULL, NULL, 12, NULL, NULL, 1),
(88, '7417200623732', 'BEXCELLENT GRAPADO RAYADO 200 PAGS.', '0.6500', '0.325000', 3, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(89, '7417200623763', 'BEXCELLENT GRAPADO LISO 200 PAGS.', '0.6500', '0.325000', -3, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(90, '7417200623749', 'BEXCELLENT GRAPADO CUADRO 200 PAGS.', '0.6500', '0.325000', 4, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(91, '7416500210475', 'CONQUISTADOR GRAPADO RAYADO 200 PAGS.', '0.6500', '0.325000', 74, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(92, '4007817530948', 'STAEDTLER BORRADOR CON ESCOBILLA ', '2.5000', '1.250000', 3, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(93, '377403281421', 'LAPIZ RCP', '0.2000', '0.100000', 8, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(94, '564412680546', 'LAPIZ PARROT PLUS GRAFITO 2 HB', '0.2000', '0.100000', 172, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(95, '562307524753', 'LAPIZ CHINA 2', '0.2000', '0.100000', 5, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(96, '511155221384', 'LAPIZ ECCO NEW TECH TUCAN', '0.2000', '0.100000', 31, 'Escolar', 0, NULL, NULL, NULL, 10, NULL, NULL, 3),
(97, '768497112100', 'LAPIZ FACELA ESCOLAR 2 HB', '0.2500', '0.125000', 1113, 'Escolar', 0, NULL, NULL, NULL, 36, NULL, NULL, 3),
(98, '7807265008832', 'PROARTE LAZPI GRAFITO HEXAGONAL N°2 HB', '0.2500', '0.125000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(99, '768497111189', 'LAPIZ FACELA JUMBO 2 HB', '0.2500', '0.125000', 27, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(100, '461324531414', 'LAPIZ SENCILLO DE COLORES BORRADOR NEGRO Y NARANJA', '0.3500', '0.175000', 11, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(101, '7453078548067', 'POINTER LAPIZ PERLADO 2 HB TRIANG.', '0.3500', '0.175000', 106, 'Escolar', 0, NULL, NULL, NULL, 20, NULL, NULL, 3),
(102, '3154148517214', 'MAPED LAPIZ 2 HB BLACKPERS TRIANG.', '0.3500', '0.175000', 12, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(103, '827321224403', 'TUCAN LAPIZ HB TRIANGULAR', '0.3500', '0.175000', 62, 'Escolar', 0, NULL, NULL, NULL, 20, NULL, NULL, 3),
(104, '588580668716', 'LAPICERO UNICORNIO ', '0.7500', '0.250000', 28, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(105, '065247824614', 'LAPICERO AGUACATE TINTA NEGRA', '0.7500', '0.250000', 0, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(106, '607715710555', 'LAPICERO UNICORNIO DE COLORES', '0.7500', '0.250000', 5, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(107, '8638551633013', 'LAPICERO AGUACATE 3 PUNTAS DE COLOR', '2.0000', '0.750000', 1, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(108, '6970897030036', 'LAPICERO TALBOT MEDIUM NEGRO', '0.2500', '0.125000', 30, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(109, '6970897030029', 'LAPICERO TALBOT MEDIUM AZUL', '0.2500', '0.125000', 12, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(110, '468046573380', 'LAPICERO STUDMARK 3103 NEGRO', '0.2500', '0.125000', 9, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(111, '655011038671', 'LAPICERO TUCAN INKER 1.0 MM NEGRO', '0.1000', '0.050000', 29, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(112, '110866847012', 'LAPICERO TUCAN INKER 1.0 MM ROJO', '0.1000', '0.050000', 23, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(113, '759364663108', 'LAPICERO BOLIK ULTRA NEGRO ', '0.2500', '0.125000', 52, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(114, '759364663115', 'LAPICERO BOLIK ULTRA ROJO PUNTA FINA', '0.2500', '0.125000', 38, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(115, '759364663092', 'LAPICERO BOLIK ULTRA AZUL PUNTA FINA', '0.2500', '0.125000', 77, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(116, '077768453144', 'LAPICERO BIC CRISTAL INTENSO CELESTE 1.6 MM', '0.3500', '0.175000', 4, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(117, '070330189140', 'LAPICERO BIC ROJO CRISTAL INTENSO 1.6 MM', '0.3500', '0.175000', 30, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(118, '070330179172', 'LAPICERO BIC CRISTAL AZUL INTENSO 1.6 MM', '0.3500', '0.175000', 39, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(119, '773886727771', 'LAPICERO BIC CRISTAL MORADO INTENSO 1.6 MM', '0.3500', '0.175000', 5, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(120, '070330179165', 'LAPICERO BIC CRISTAL NEGRO INTENSO 1.6 MM', '0.3500', '0.175000', 56, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(121, '070330189119', 'LAPICERO BIC CRISTAL ROSA INTENSO 1.6 MM', '0.3500', '0.175000', 6, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(122, '230532745263', 'LAPICERO BIC CRISTAL ROSA FASHION', '0.3500', '0.175000', 5, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(123, '250841547158', 'LAPICERO BIC CRISTAL NARANJA INTENSO 1.6 MM', '0.3500', '0.175000', 0, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(124, '724353710108', 'LAPICERO BIC CRISTAL CLASICO MORADO TRANSPARENTE', '0.2500', '0.125000', 1, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(125, '651570264252', 'LAPICERO BIC CRISTAL ROSA ULTRA FINO', '0.3500', '0.175000', 9, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(126, '443625831703', 'LAPICERO BIC CRISTAL VERDE CLARO ULTRA FINO', '0.3500', '0.175000', 4, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(127, '070330178083', 'LAPICERO BIC 4 COLORES ', '2.2500', '1.400000', 5, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(128, '163187531160', 'LAPICERO BIC CRISTAL MORADO ULTRA FINO', '0.3500', '0.175000', 7, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(129, '562053805560', 'LAPICERO BIC CRISTAL CELESTE ULTRA FINO', '0.3500', '0.175000', 6, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(130, '350076126575', 'LAPICERO BIC CRISTAL MORADO FASHION', '0.2500', '0.125000', 16, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(131, '723051815326', 'LAPICERO BIC MORADO', '0.2500', '0.125000', 1, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(132, '466260170570', 'LAPICERO BIC CRISTAL CLASICO ROJO', '0.2500', '0.120000', 332, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(133, '653322410384', 'LAPICERO BIC CRISTAL CLASICO AZUL', '0.2500', '0.120000', 444, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(134, '618474756013', 'LAPICERO BIC CRISTAL CLASICO NEGRO', '0.2500', '0.120000', 310, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(135, '028360581748', 'LAPICERO BIC CRISTAL NEGRO ULTRA FINO', '0.3500', '0.175000', 26, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(136, '7503486013104', 'LAPICERO PAPER MATE INKJOY VERDE 100 RT 1.0M', '0.6500', '0.325000', 9, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(137, '7503486013074', 'LAPICERO PAPER MATE INKJOY MORADO 100 RT 1.0 M', '0.6500', '0.325000', 6, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(138, '7503486013081', 'LAPICERO PAPER MATE INKJOY ROSADO 100 RT 1.0 M', '0.6500', '0.325000', 3, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(139, '7503486013067', 'LAPICERO PAPER MATE INKJOY CELESTE 100 RT 1.0 M', '0.6500', '0.325000', 4, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(140, '7503486013029', 'LAPICERO PAPER MATE INKJOY NEGRO 100 RT 1.0 M', '0.6500', '0.325000', 3, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(141, '402874831166', 'LAPICERO PAPER MATE INKJOY AZUL 100 RT 1.0 M', '0.6500', '0.325000', 4, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(142, '7702111337534', 'NORMA CUAD KIUT ESPIRAL PROF. RAYADO 20X200', '9.5000', '5.983915', 14, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(143, '250865841418', 'LAPICERO PROARTE GLITTER GEL', '0.5000', '0.260000', 28, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(144, '30102460', 'LAPICERO MAPED DARK GREEN 80%', '0.4000', '0.200000', 3, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(145, '043627533671', 'LAPICERO AZOR PINPOINT NEGRO 0.7 MM', '0.4000', '0.200000', 12, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(146, '7754111010351', 'LAPICERO ICE 061 FABER CASTELL ROSA', '0.7500', '0.375000', 12, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(147, '7754111001328', 'LAPICERO ICE 061 FABER CASTELL AZUL', '0.7500', '0.375000', 26, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(148, '7754111001335', 'LAPICERO ICE 061 FABER CASTELL ROJO', '0.7500', '0.375000', 11, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(149, '7754111021555', 'LAPICERO ICE 061 FABER CASTELL VERDE', '0.7500', '0.375000', 12, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(150, '4901681219179', 'LAPICERO ZEBRA F301 0.7 MM BP', '3.5000', '1.750000', 0, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(151, '4006381416603', 'LAPICERO STABILO BLACK', '2.0000', '1.000000', 2, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(152, '734484453037', 'LAPICERO LINE BALL MONAMI 0.7 MM ROJO', '0.5000', '0.250000', 34, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(153, '568400455783', 'LAPICERO LINE BALL MONAMI 0.7 MM AZUL', '0.5000', '0.250000', 0, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(154, '845561202136', 'LAPICERO MARLETTO MULTICOR 4 PUNTAS', '1.0000', '0.500000', 1, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(155, '4974052862687', 'ARTLINE LAPIZ PORTAMINA 0.5 MM CON BORRADOR', '1.0000', '0.500000', 7, 'Escolar', 0, 'COVERTURA AZUL', NULL, NULL, 6, NULL, NULL, 3),
(156, '6930358804330', 'LAPIZ PORTAMINA 201 2B', '0.7500', '0.375000', 11, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(157, '7807265024917', 'ISOFIT LAPIZ PORTAMINA 5000.0.5', '2.0000', '1.000000', NULL, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(158, '7754111001342', 'LAPICERO ICE 061 FABER CASTELL NEGRO', '0.7500', '0.375000', 17, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(159, '7754111010399', 'LAPICERO ICE 061 FABER CASTELL MORADO', '0.7500', '0.375000', 11, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(160, '531507335771', 'LAPICERO CON BORRADOR PAPER MATE ERASERMATE 1.0 MM AZUL', '1.0000', '0.500000', 15, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(161, '683720575706', 'LAPICERO CON BORRADOR PAPER MATE ERASERMATE 1.0 MM NEGRO', '1.0000', '0.500000', 24, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(162, '838434505055', 'LAPICERO AZOR PINPOINT ROJO 0.7 MM', '0.5000', '0.250000', 3, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(163, '4549441003202', 'LAPICERO ARTLINE SG-1 0.7 MM ROJO', '0.5000', '0.250000', 47, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(164, '4549441003196', 'LAPICERO ARTLINE SG-1 0.7 MM AZUL', '0.5000', '0.250000', 21, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(165, '766458752215', 'LAPICERO BIC CRISTAL ROJO ULTRA FINO', '0.3500', '0.175000', 8, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(166, '4549441003189', 'LAPICERO ARTLINE SG-1 0.7 MM NEGRO', '0.5000', '0.250000', 25, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(167, '4005401511519', 'PLUMA FABER CASTLE FINEPEN 1511 DOCUMENT AZUL', '1.0000', '0.500000', 11, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(168, '4005401511212', 'PLUMA FABER CASTLE FINEPEN 1511 DOCUMENT ROJO', '1.0000', '0.500000', 12, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(169, '4974052830006', 'PLUMA ARTLINE 200 FINA 0.4 NEGRO', '1.0000', '0.500000', 2, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(170, '4974052830600', 'PLUMA ARTLINE 210 MEDIUM 0.6 NEGRO', '1.0000', '0.500000', 7, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(171, '4974052830020', 'PLUMA ARTLINE 200 FINA 0.4 ROJO', '1.0000', '0.500000', 4, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(172, '4974052830617', 'PLUMA ARTLINE 210 MEDIUM 0.6 AZUL', '1.0000', '0.500000', 18, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(173, '4974052830013', 'PLUMA ARTLINE 200 FINA 0.4 AZUL', '1.0000', '0.500000', 9, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(174, '4902505239670', 'LAPICERO PILOT SUPER-GP 0.7 NEGRO', '0.5000', '0.250000', 46, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(175, '4902505239694', 'LAPICERO PILOT SUPER-GP 0.7 AZUL', '0.5000', '0.250000', 37, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(176, '4902505239687', 'LAPICERO PILOT SUPER-GP 0.7 ROJO', '0.5000', '0.250000', 10, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(177, '4006381114196', 'PLUMA STABILO SENSOR F 0.3 MM NEGRO', '1.7500', '0.875000', 4, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(178, '4006381114172', 'PLUMA STABILO SENSOR F 0.3 MM ROJO', '1.7500', '0.875000', 8, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(179, '4006381114189', 'PLUMA STABILO SENSOR F 0.3 MM AZUL', '1.7500', '0.875000', NULL, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(180, '071641301290', 'MARCADOR PERMANENTE SHARPIE FINEPOINT VERDE LIMA', '1.5000', '0.750000', 1, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(181, '071641320819', 'MARCADOR PERMANENTE SHARPIE FINEPOINT ROSADO C.', '1.5000', '0.750000', 2, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(182, '071641300354', 'MARCADOR PERMANENTE SHARPIE FINEPOINT AMARILLO', '1.5000', '0.750000', 2, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(183, '071641320888', 'MARCADOR PERMANENTE SHARPIE FINEPOINT MORADO L.', '1.5000', '0.750000', 2, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(184, '071641300378', 'MARCADOR PERMANENTE SHARPIE FINEPOINT CAFE', '1.5000', '0.750000', 1, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(185, '071641300361', 'MARCADOR PERMANENTE SHARPIE FINEPOINT NARANJA', '1.5000', '0.750000', 2, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(186, '071641300347', 'MARCADOR PERMANENTE SHARPIE FINEPOINT VERDE O.', '1.5000', '0.750000', 2, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(187, '071641300385', 'MARCADOR PERMANENTE SHARPIE FINEPOINT MORADO F.', '1.5000', '0.750000', 2, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(188, '071641301337', 'MARCADOR PERMANENTE SHARPIE FINEPOINT CELESTE', '1.5000', '0.750000', 1, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(189, '071641300521', 'MARCADOR PERMANENTE SHARPIE FINEPOINT ROJO', '1.5000', '0.750000', 0, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(190, '071641320833', 'MARCADOR PERMANENTE SHARPIE FINEPOINT CELESTE C.', '1.5000', '0.750000', 2, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(191, '4006381105255', 'PLUMILLA STABILO POINT 88 0.4 VERDE', '1.0000', '0.500000', 9, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(192, '4006381105316', 'PLUMILLA STABILO POINT 88 0.4 NEGRO', '1.0000', '0.500000', 8, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(193, '4006381105293', 'PLUMILLA STABILO POINT 88 0.4 AMARILLO', '1.0000', '0.500000', 9, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(194, '4006381105262', 'PLUMILLA STABILO POINT 88 0.4 ROJO', '1.0000', '0.500000', 9, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(195, '4006381105279', 'PLUMILLA STABILO POINT 88 0.4 AZUL', '1.0000', '0.500000', 8, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(196, '4006381105347', 'PLUMILLA STABILO POINT 88 0.4 ROSADO', '1.0000', '0.500000', 9, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(197, '4006381105330', 'PLUMILLA STABILO POINT 88 0.4 MORADO', '1.0000', '0.500000', 8, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(198, '4713294983428', 'FAST RESALTADOR R300 5 MM TURQUESA', '0.7500', '0.375000', 5, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(199, '77963987', 'PELIKAN MARCADOR FLASH VERDE PASTEL', '1.0000', '0.500000', 0, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(200, '77963970', 'PELIKAN MARCADOR FLASH ROSA PASTEL', '1.0000', '0.500000', 0, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(201, '77968807', 'PELIKAN MARCADOR FLASH GRIS PASTEL', '1.0000', '0.500000', 2, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(202, '7501015213551', 'PELIKAN MARCATEXTOS 414 NARANJA', '0.5000', '0.250000', 2, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(203, '7501015213575', 'PELIKAN MARCATEXTOS 414 VERDE', '0.5000', '0.250000', 3, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(204, '77963963', 'PELIKAN MARCADOR FLASH CELESTE PASTEL', '1.0000', '0.500000', 0, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(205, '768497411074', 'FACELA MARCADOR HIGHLIGHTER VERDE', '0.7500', '0.375000', 25, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(206, '768497992986', 'FACELA MARCADOR HIGHLIGHTER NARANJA', '0.7500', '0.375000', 18, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(207, '768497992979', 'FACELA MARCADOR HIGHLIGHTER AMARILLLO N.', '0.7500', '0.375000', 1, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(208, '6954941713106', 'MARCADOR GIXIN HIGHLIGHTER VERDE', '0.7500', '0.375000', 2, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(209, '77965103', 'PELIKAN MARCADOR FLASH AMARILLO PASTEL', '1.0000', '0.500000', 2, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(210, '356666800221', 'MARCADOR SPLENDID FLUORECENTE CY-100 VERDE', '0.5000', '0.250000', 1, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(211, '77968784', 'PELIKAN MARCADOR FLASH VERDE C. PASTEL', '1.0000', '0.500000', 2, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(212, '4713294983374', 'FAST RESALTADOR R300 5 MM AMARILLO PASTEL', '0.7500', '0.375000', 7, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(213, '4713294983411', 'FAST RESALTADOR R300 5 MM ROSADO PASTEL', '0.7500', '0.375000', 0, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(214, '4713294983404', 'FAST RESALTADOR R300 5 MM PIEL PASTEL', '0.7500', '0.375000', 7, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(215, '4713294983381', 'FAST RESALTADOR R300 5 MM AQUA PASTEL', '0.7500', '0.375000', 5, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(216, '4713294983398', 'FAST RESALTADOR R300 5 MM MORADO PASTEL', '0.7500', '0.375000', 1, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(217, '4974052865749', 'MARCADOR PERMANENTE ARTLINE SUPREME EPF-700 VERDE LIMA', '1.0000', '0.500000', 0, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(218, '4549441010620', 'MARCADOR ARTLINE DECORITE EDF-F AZUL', '1.2500', '0.625000', 1, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(219, '4974052865787', 'MARCADOR PERMANENTE ARTLINE SUPREME EPF-700 AMARILLO', '1.0000', '0.500000', 2, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(220, '4974052865732', 'MARCADOR PERMANENTE ARTLINE SUPREME EPF-700 NARANJA', '1.0000', '0.500000', 0, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(221, '4974052865701', 'MARCADOR PERMANENTE ARTLINE SUPREME EPF-700 VERDE MUZGO', '1.0000', '0.500000', 1, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(222, '4974052865756', 'MARCADOR PERMANENTE ARTLINE SUPREME EPF-700 CELESTE', '1.0000', '0.500000', 0, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(223, '4974052865718', 'MARCADOR PERMANENTE ARTLINE SUPREME EPF-700 ROSADO', '1.0000', '0.500000', 3, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(224, '4549441010644', 'MARCADOR ARTLINE DECORITE EDF-F ROJO', '1.2500', '0.625000', 6, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(225, '886488158034', 'TIRRO BLUE BOLD DELGADO', '1.0000', '0.770000', 8, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(226, '7453015106992', 'STUDMARK CORRECTOR 0.8 MM', '0.7500', '0.360000', 50, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(227, '6931100514552', 'FAST CORRECTOR TIPO PLUMA ', '0.7500', '0.350000', 4, 'Escolar', 0, 'DE COLORES', NULL, NULL, 12, NULL, NULL, 3),
(228, '466818671268', 'MARCADOR PROBADOR DE BILLETE', '0.7500', '0.375000', 3, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(229, '8854556000524', 'LIQUID PAPER MATE LAPIZ CORRECTOR 7ML', '1.5000', '0.750000', 41, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(230, '071641054905', 'SHARPIE MARCADOR PERMA. GOLD METALLIC.', '2.2500', '1.125000', 12, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(231, '4974052821608', 'ARTLINE PLUMON 509 NEGRO PIZARRA', '1.2500', '0.800000', 31, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(232, '4974052802300', 'ARTLINE PLUMON 90 HIGH PERFORMACE NEGRO PERMA.', '1.0000', '0.650000', 16, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(233, '4974052802317', 'ARTLINE PLUMON 90 HIGH PERFORMACE AZUL PERMA.', '1.0000', '0.680000', 48, 'Escolar', 0, NULL, NULL, NULL, 10, NULL, NULL, 3),
(234, '4974052821615', 'ARTLINE PLUMON 509 AZUL PIZARRA', '1.2500', '0.800000', 33, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(235, '4549441006067', 'ARTLINE PLUMON MULTIPROPOSITO 1.5 MM NEGRO', '1.2500', '0.625000', 1, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(236, '4974052802348', 'ARTLINE PLUMON 90 HIGH PERFORMACE CAFE PERMA.', '1.0000', '0.680000', 12, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(237, '4974052802386', 'ARTLINE PLUMON 90 HIGH PERFORMACE ROSA PERMA.', '1.0000', '0.680000', 11, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(238, '4974052802355', 'ARTLINE PLUMON 90 HIGH PERFORMACE NARANJA PERMA.', '1.0000', '0.680000', 13, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(239, '4974052802362', 'ARTLINE PLUMON 90 HIGH PERFORMACE MORADO PERMA.', '1.0000', '0.680000', 11, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(240, '4974052802331', 'ARTLINE PLUMON 90 HIGH PERFORMACE VERDE PERMA.', '1.0000', '0.680000', 10, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(241, '4974052802393', 'ARTLINE PLUMON 90 HIGH PERFORMACE CELESTE PERMA.', '1.0000', '0.680000', 28, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(242, '4974052802379', 'ARTLINE PLUMON 90 HIGH PERFORMACE AMARILLO PERMA.', '1.0000', '0.680000', 15, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(243, '4974052821622', 'ARTLINE PLUMON 509 ROJO PIZARRA', '1.2500', '0.800000', 35, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(244, '4974052802324', 'ARTLINE PLUMON 90 HIGH PERFORMACE ROJO PERMA.', '1.0000', '0.680000', 42, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(245, '6922721700134', 'PLUMON HAIJIAV BI-NB6 6% PERMA. ROJO', '0.7500', '0.250000', 11, 'Escolar', 0, 'XYLENE FREE', NULL, NULL, 6, NULL, NULL, 3),
(246, '4974052865688', 'MARCADOR PERMANENTE ARTLINE SUPREME EPF-700 AZUL', '1.0000', '0.500000', 3, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(247, '4974052865695', 'MARCADOR PERMANENTE ARTLINE SUPREME EPF-700 ROJO', '1.0000', '0.500000', 3, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(248, '661536018183', 'LAPICERO BIC CRISTAL AZUL ULTRA FINO', '0.3500', '0.175000', 19, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(249, '4901681610211', 'ZEBRA MINAS PUNTILLAS CONT. 12 PIEZ. HB 0.5', '0.9000', '0.450000', 9, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(250, '682008861036', 'LAPIZ FACELA BICOLOR CHECKLINE 810 R.A', '0.2500', '0.125000', 121, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(251, '256228830723', 'RIXING PAPEL CLIP 50 MM', '0.0500', '0.025000', 103, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(252, '6939564325813', 'PAPER CLIPS CJA, 100 PCS. RIXING', '1.2500', '0.625000', 11, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(253, '413145672777', 'CLIPS DE COLORES INDIVIDUAL', '0.0500', '0.025000', 122, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(254, '6939564325967', 'RIXING PAPEL CLIPS 100 PCS. PEQ. CJA.', '0.7500', '0.375000', 10, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(255, '6953642800023', 'MINA 2.0 PENCIL LEAD TY-630', '0.2500', '0.125000', 17, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(256, '7401007602335', 'TUCAN BORRADOR MEDIANO', '0.2500', '0.125000', 49, 'Escolar', 0, NULL, NULL, NULL, 25, NULL, NULL, 3),
(257, '7401007608771', 'TUCAN BORRADOR GRDE.', '0.2500', '0.125000', 0, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(258, '7401007661110', 'SINA FINA CLIP METALICO PORTA PAPEL', '0.1000', '0.050000', 34, 'Escolar', 0, '19 MM', NULL, NULL, 12, NULL, NULL, 3),
(259, '7401007661134', 'TUCAN CLIP MATELICO PORTA PAPEL', '0.3000', '0.150000', 20, 'Escolar', 0, '32 MM', NULL, NULL, NULL, NULL, NULL, 3),
(260, '7401007621794', 'TUCAN PIN. ACRILICA AMARILLO 45 G', '1.0000', '0.500000', 4, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(261, '7401007621961', 'TUCAN PIN. ACRILICA MORADO LILA 45 G', '1.0000', '0.500000', 1, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(262, '7401007621824', 'TUCAN PIN. ACRILICA VERDE 45 G', '1.0000', '0.500000', 1, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(263, '7401007621862', 'TUCAN PIN. ACRILICA VIOLETA 45 G', '1.0000', '0.500000', 3, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(264, '7401007621886', 'TUCAN PIN. ACRILICA CELESTE 45 G', '1.0000', '0.500000', 2, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(265, '7401007621947', 'TUCAN PIN. ACRILICA VERDE MANZANA 45 G', '1.0000', '0.500000', 3, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(266, '7401007621879', 'TUCAN PIN. ACRILICA CAFE 45 G', '1.0000', '0.500000', 2, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(267, '7401007621954', 'TUCAN PIN. ACRILICA MAGENTA 45 G', '1.0000', '0.500000', 2, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(268, '7401007602359', 'TUCAN PIN. ACRILICA FUCCIA 45 G', '1.0000', '0.500000', 2, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(269, '7401007621800', 'TUCAN PIN. ACRILICA ROJO 45 G', '1.0000', '0.500000', 2, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(270, '7401007621893', 'TUCAN PIN. ACRILICA ROSADO 45 G', '1.0000', '0.500000', 4, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(271, '7401007621855', 'TUCAN PIN. ACRILICA NARANJA 45 G', '1.0000', '0.500000', 2, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(272, '7401007617582', 'TUCAN ACRILICO TUB. 60 ML VERDE SABIA', '2.0000', '1.000000', 4, 'Escolar', 0, 'HIGH QUALITY', NULL, NULL, 6, NULL, NULL, 3),
(273, '7401007617520', 'TUCAN ACRILICO TUB. 60 ML ESCARLATA', '2.0000', '1.000000', 4, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(274, '7401007617605', 'TUCAN ACRILICO TUB. 60 ML SOMBRA TOSTADA', '2.0000', '1.000000', 1, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(275, '7401007602465', 'TUCAN GLUE STICK 20 G', '1.0000', '0.630000', 38, 'Escolar', 0, 'ADHESIVO FUERTE', NULL, NULL, 6, NULL, NULL, 3),
(276, '7401007602458', 'TUCAN GLUE STICK 10 G', '0.6500', '0.370000', 74, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(277, '7401007602472', 'TUCAN GLUE STICK 40 G', '1.6500', '1.110000', 10, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(278, '7441035388023', 'RESISTOL GOMA EN BARRA 20 G', '0.9000', '0.450000', 0, 'Escolar', 0, 'BOTE ROJO', NULL, NULL, 12, NULL, NULL, 3),
(279, '7401007608788', 'TUCAN BORRADOR PEQUEÑO', '0.1500', '0.075000', 32, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(280, '768497512610', 'FACELA BORRADOR SUAVE JUNIOR', '0.2500', '0.125000', 9, 'Escolar', 0, 'NO MANCHA AL BORRAR', NULL, NULL, 12, NULL, NULL, 3),
(281, '7453015103885', 'STUDMARK BORRADOR 4B NEGRO', '0.3500', '0.175000', 18, 'Escolar', 0, 'ST-03201-A', NULL, NULL, 12, NULL, NULL, 3),
(282, '7401007623248', 'TUCAN GLITTER GLUE AZUL CLARO 60 ML', '1.2500', '0.660000', 10, 'Escolar', 0, 'GOMA CON DIAMANTINA', NULL, NULL, 6, NULL, NULL, 3),
(283, '7401007623187', 'TUCAN GLITTER GLUE PLATA 60 ML', '1.2500', '0.660000', 9, NULL, 0, NULL, NULL, NULL, 6, NULL, NULL, 1),
(284, '7401007623194', 'TUCAN GLITTER GLUE VERDE 60 ML', '1.2500', '0.625000', 3, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(285, '7401007623200', 'TUCAN GLITTER GLUE VIOLETA 60 ML', '1.2500', '0.660000', 13, NULL, 0, NULL, NULL, NULL, 6, NULL, NULL, 1),
(286, '7401007623224', 'TUCAN GLITTER GLUE FUCSIA 60 ML', '1.2500', '0.660000', 15, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(287, '7401007623217', 'TUCAN GLITTER GLUE ROJO 60 ML', '1.2500', '0.660000', 14, NULL, 0, NULL, NULL, NULL, 6, NULL, NULL, 1),
(288, '7401007623170', 'TUCAN GLITTER GLUE GOLD 60 ML', '1.2500', '0.625000', 0, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(289, '7417200604151', 'PARROT GLITTER GLUE 50 ML', '1.0000', '0.500000', 11, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(290, '7401007604247', 'TUCAN SILICON LIQUIDO 60 ML', '1.0000', '0.500000', 2, 'Escolar', 0, 'KREATINA', NULL, NULL, 6, NULL, NULL, 3),
(291, '7401007606678', 'TUCAN SILICON LIQUIDO 30 ML', '0.5000', '0.230000', 89, 'Escolar', 0, 'KREATINA', NULL, NULL, 6, NULL, NULL, 3),
(292, '7401007622036', 'TUCAN SILICON LIQUIDO 500 ML', '4.5000', '3.410000', 13, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(293, '7453015101195', 'STUDMARK WHITE GLUE 40 ML', '0.5000', '0.250000', 1, 'Escolar', 0, 'PEGAMENTO BLANCO', NULL, NULL, 6, NULL, NULL, 3),
(294, '7401007600416', 'TUCAN GOMA ESCOLAR 125 G', '0.9000', '0.540000', 39, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(295, '7401007600423', 'TUCAN GOMA ESCOLAR 240 G', '1.6000', '0.950000', 42, 'Sin Departamento', 0, NULL, NULL, NULL, 5, NULL, NULL, 7),
(296, '7401007600393', 'TUCAN GOMA ESCOLAR 30 G', '0.5000', '0.270000', 71, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(297, '7401007604216', 'TUCAN GOMA ESCOLAR 500 G', '2.7500', '1.770000', 15, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(298, '758167875523', 'ABRO CINTA ADHESIVA DELGADA PEQ. 1/2 27 Y', '0.2500', '0.150000', 255, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(299, '277574071414', 'CINTA ADHESIVA ANCHA PEQ. 3/4 7Y', '0.3500', '0.220000', 169, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(300, '367385235863', 'ABRO TAPE 2 X 100 YARDAS.', '1.5000', '0.750000', -3, 'Escolar', 0, 'CINTA ADHESIVA GRANDE', NULL, NULL, 12, NULL, NULL, 3),
(301, '217230808630', 'ABRO TAPE 2 X 300 YARDAS', '4.5000', '2.250000', 5, NULL, 0, 'CINTA ADHESIVA EXTRA GRANDE', NULL, NULL, 6, NULL, NULL, 1),
(302, '3154140178116', 'MAPED SACAPUNTA ABEJA', '3.0000', '1.500000', 10, 'Escolar', 0, '2 ORIFICIOS', NULL, NULL, 3, NULL, NULL, 3),
(303, '7441002705358', 'SCOTCH CINTA MAGICA ', '3.0000', '1.500000', 10, 'Escolar', 0, '19 MM X 25 MM 100% INVISIBLE', NULL, NULL, 6, NULL, NULL, 3),
(304, '456288715108', 'BORRADOR MULTICOLOR LAPIZ', '0.7500', '0.250000', 3, 'Escolar', 0, 'TUBO DE DIFERENTES COLORES', NULL, NULL, 6, NULL, NULL, 3),
(305, '768848615510', 'MAPED SACAPUNTA COLORES', '0.2500', '0.125000', 111, 'Escolar', 0, NULL, NULL, NULL, 25, NULL, NULL, 3),
(306, '3154140066000', 'MAPED SACAPUNTA METALICA ', '0.8500', '0.425000', 4, 'Escolar', 0, '1 ORIFICIO', NULL, NULL, 12, NULL, NULL, 3),
(307, '3154145071009', 'MAPED SACAPUNTA CON RESIDUAL', '0.6500', '0.325000', 5, 'Escolar', 0, 'SACAPUNTA COLORES', NULL, NULL, 6, NULL, NULL, 3),
(308, '553878074250', 'FACELA SACAPUNTA METALICA', '0.2500', '0.125000', 0, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(309, '715606563030', 'BORRADOR MOJIS INDIVIDUAL', '0.0500', '0.025000', 58, 'Escolar', 0, 'COLORES', NULL, NULL, 12, NULL, NULL, 3),
(310, '137514346056', 'SACAPUNTA ECONOMICA PLASTICA', '0.1000', '0.050000', 38, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(311, '7401007620018', 'TUCAN PISTOLA SILICON', '3.5000', '1.750000', 0, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(312, '3154140176112', 'MAPED SACAPUNTA CON RESIDUAL CONEJO', '2.0000', '1.000000', 4, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(313, '7401007608849', 'PALETAS DE MADERA 50 U. COLORES', '1.0000', '0.500000', 15, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(314, '7401007608832', 'TUCAN PALETAS DE MADERA 50 U.', '1.0000', '0.500000', 17, 'Escolar', 0, 'SIN COLOR', NULL, NULL, 6, NULL, NULL, 3),
(315, '4710887400829', 'SKY SACAGRAPAS', '1.5000', '0.750000', 10, 'Escolar', 0, 'S508B', NULL, NULL, 3, NULL, NULL, 3),
(316, '031032321040', 'EVANO FINGER MOISTER 40 ML', '1.5000', '0.750000', 5, 'Escolar', 0, 'CUENTA FACIL', NULL, NULL, 3, NULL, NULL, 3),
(317, '3154145404005', 'MAPED GRAPADOR DE BOLSILLO', '2.0000', '1.000000', 9, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(318, '3154140620004', 'MAPED PERFORADOR ', '5.5000', '2.750000', 2, 'Escolar', 0, 'UNIVERSAL MATEAL', NULL, NULL, 1, NULL, NULL, 3),
(319, '655571560450', 'AOS ENGRAPADORA METALICA', '4.0000', '2.000000', 1, 'Escolar', 0, 'TIRA COMPLETA', NULL, NULL, 3, NULL, NULL, 3),
(320, '6923989302221', 'HUAPUDA ENGRAPADOR', '4.0000', '2.000000', 8, 'Escolar', 0, 'N° 0222', NULL, NULL, 3, NULL, NULL, 3),
(321, '7453015102482', 'STUDMARK PERFORADORA DE 1 HUECO', '2.0000', '1.000000', 0, 'Escolar', 0, '1 HOLE PUNCH', NULL, NULL, 3, NULL, NULL, 3),
(322, '768497166684', 'FACELA FASTENER METALICO CJA. ECO', '1.1000', '0.760000', 26, NULL, 0, '8 CMS', NULL, NULL, 6, NULL, NULL, 1),
(323, '17401007660332', 'TUCAN FASTENER CJA. 50 U.', '1.9000', '1.450000', 12, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(324, '7401007660373', 'SINA FINA PERFORADOR', '2.5000', '1.250000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(325, '7401007607583', 'SINA FINA DISPENSADOR DE CINTA', '2.5000', '1.250000', 2, 'Escolar', 0, 'DISPENSADOR DE TAPE', NULL, NULL, 1, NULL, NULL, 3),
(326, '7453015103069', 'STUDMARK DISPENSADOR DE CINTA', '4.0000', '2.000000', 9, 'Escolar', 0, 'GRANDE METALICO TAPE DISPENSER', NULL, NULL, 3, NULL, NULL, 3),
(327, '157265276684', 'COLGANTE PARA CARNET EL SALVADOR', '1.0000', '0.500000', 5, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(328, '288534760326', 'COLGANTE PARA CARNET AZUL', '0.5000', '0.250000', 6, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(329, '7664067170088', 'PORTA CARNET ID CARD ', '0.4000', '0.200000', 18, 'Escolar', 0, 'HORIZONTAL', NULL, NULL, 12, NULL, NULL, 3),
(330, '586472778057', 'LAPICERO BIC CRISTAL ROJO INTENSO 1.6 MM', '0.3500', '0.175000', 33, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(331, '21-226', 'BRICHO NEVADO 9 CM', '1.0000', '0.600000', 42, 'Navideño', 0, NULL, NULL, NULL, 8, NULL, NULL, 8),
(332, '21-234', 'ESFERA EN BOLA 6 CM 6 PCS TEXTURA', '2.5000', '1.500000', 7, 'Navideño', 0, NULL, NULL, NULL, 3, NULL, NULL, 8),
(333, '21-233', 'ESFERA EN BOLSA 6 CM HEXAGONAL', '2.5000', '1.500000', 11, 'Navideño', 0, NULL, NULL, NULL, 3, NULL, NULL, 8),
(334, '627872530480', 'DRESSMAKER PINS 100 PCS', '0.8500', '0.425000', 2, 'Escolar', 0, '1.1/2\" ALFILERES CON CABEZA', NULL, NULL, 6, NULL, NULL, 3),
(335, '7807265988424', 'ISOFIT ALFILERES CROMADOS', '0.7500', '0.375000', 7, 'Escolar', 0, 'OFFICE PINS SIN CABEZA', NULL, NULL, 3, NULL, NULL, 3),
(336, '7401007660519', 'SINAFINA TACHUELA PLASTICA', '0.7500', '0.375000', 9, 'Escolar', 0, 'PUSH PINS', NULL, NULL, 3, NULL, NULL, 3),
(337, '6988468013586', 'STATIONARY PINS CLIPS', '1.0000', '0.500000', 4, 'Escolar', 0, 'TACHUELA METALICA', NULL, NULL, 3, NULL, NULL, 3),
(338, '537761455476', 'TUCAN FASTENER', '0.1500', '0.075000', -37, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(339, '075651081303', 'FASTENER PLASTICO COLOR', '0.2500', '0.125000', 316, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(340, '7401007660212', 'SINAFINA CUCHILLA 18 MM', '0.8500', '0.425000', 28, 'Escolar', 0, 'CUTTER ', NULL, NULL, 3, NULL, NULL, 3),
(341, '768497013056', 'FACELA REGLA 30 CM', '0.3000', '0.150000', 7, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(342, '6970113773013', 'XLPQ REGLA FLEXIBLE 30 CM', '0.5000', '0.250000', 6, 'Escolar', 0, 'NO: 4016', NULL, NULL, 6, NULL, NULL, 3),
(343, '187847580004', 'MAPED REGLA 30 CM', '0.3000', '0.150000', 1, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(344, '7807265973734', 'PROARTE PINCEL ESCOLAR #1', '0.6000', '0.300000', 9, 'Escolar', 0, 'PELO CAMELLO', NULL, NULL, 3, NULL, NULL, 3),
(345, '7807265973741', 'PROARTE PINCEL ESCOLAR #2', '0.4500', '0.225000', 10, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(346, '7807265011115', 'PROARTE PINCEL ESCOLAR #3', '0.4000', '0.200000', 11, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(347, '7807265011122', 'PROARTE PINCEL ESCOLAR #4', '0.4500', '0.225000', 12, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(348, '2844265011184', 'PROARTE PINCEL ESCOLAR #10', '0.7500', '0.375000', 5, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(349, '7807265011207', 'PROARTE PINCEL ESCOLAR #12', '1.0000', '0.500000', 8, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(350, '7401007608825', 'TUCAN SET DE PINCELES 6 U.', '1.7500', '0.875000', 7, 'Escolar', 0, NULL, NULL, NULL, 4, NULL, NULL, 3),
(351, '9301330890011', 'TALBOT JUEGO DE PINCELES', '3.5000', '1.750000', 1, 'Escolar', 0, '8 UNIDADES', NULL, NULL, 3, NULL, NULL, 3),
(352, '177337645071', 'PAINTING BRUSH SET', '1.0000', '0.500000', 2, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(353, '7401007615229', 'TUCAN PINCHOS DE MADERA 50 U.', '1.3500', '0.675000', 3, 'Escolar', 0, 'KREATIVA', NULL, NULL, 6, NULL, NULL, 3),
(354, '7401007612327', 'SINAFINA TIJERA 19.5 CM', '2.0000', '1.000000', 1, 'Escolar', 0, 'ACERO INOXIDABLE', NULL, NULL, 3, NULL, NULL, 3),
(355, '7453038460491', 'POINTER LIMPIA PIPA SET 30 PCS', '1.7500', '0.875000', 8, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(356, '7401007608870', 'TUCAN PALETA PARA MEZCLAR', '1.0000', '0.500000', 10, 'Escolar', 0, 'MEZCLAR COLORES', NULL, NULL, 3, NULL, NULL, 3);
INSERT INTO `Hoja1` (`id_producto`, `Codigo`, `Nombre`, `Precio_de_venta`, `Precio_de_compra`, `Cantidad`, `Marca`, `Descuento`, `Descripcion`, `Imagen`, `Ubicacion`, `StockMinimo`, `PrecioMayoreo`, `PrecioDistribuidor`, `id_categoria`) VALUES
(357, '555755753756', 'LIMPIA PIPA CON BRILLO', '0.1000', '0.050000', 1144, 'Escolar', 0, NULL, NULL, NULL, 100, NULL, NULL, 3),
(358, '768510685617', 'COMPAS SET', '0.5000', '0.250000', 12, 'Escolar', 0, 'COMPAS CON LAPIZ', NULL, NULL, 1, NULL, NULL, 3),
(359, '122153487770', 'REGLA BARBIE 30 CM', '0.1500', '0.075000', 5, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(360, '4717480704972', 'NOKY JUEGO DE GEOMETRIA #1', '0.5000', '0.250000', 4, 'Escolar', 0, 'REGLA DE 20 CM', NULL, NULL, 3, NULL, NULL, 3),
(361, '4710887406340', 'NOKY JUEGO DE GEOMETRIA #2', '0.7500', '0.250000', 4, 'Escolar', 0, 'REGLA DE 30 CM', NULL, NULL, 3, NULL, NULL, 3),
(362, '3154144642705', 'MAPED TIJERA PEQUEÑA', '0.7500', '0.360000', 0, NULL, 0, 'STAINLESS', NULL, NULL, NULL, NULL, NULL, 1),
(363, '768497160521', 'FACELA TIJERA ', '0.5000', '0.260000', 2, 'Escolar', 0, 'STAINLESS STEEL', NULL, NULL, 3, NULL, NULL, 3),
(364, '7401007603226', 'TUCAN COMPAS ESCOLAR', '1.4000', '0.700000', 10, 'Escolar', 0, 'INCLUYE LAPIZ Y SACAPUNTAS', NULL, NULL, 3, NULL, NULL, 3),
(365, '3154144681100', 'MAPED TIJERA ESSENTIALS 21 CM', '1.9000', '1.080000', 4, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(366, '331250818266', 'SELLO MULTIDISEÑOS', '2.0000', '1.000000', 25, 'Golocinas', 0, NULL, NULL, NULL, 6, NULL, NULL, 2),
(367, '414425176161', 'RUBBER BANDS', '0.5000', '0.250000', 56, 'Escolar', 0, 'BANDAS ELASTICAS', NULL, NULL, 12, NULL, NULL, 3),
(368, '7453015101935', 'STUDMARK BANDAS ELASTCIAS 113 G', '1.2500', '0.625000', 2, 'Escolar', 0, 'NO. 33', NULL, NULL, 2, NULL, NULL, 3),
(369, '7453015102642', 'BIÑETA PRA PRECIO ROSA', '1.0000', '0.500000', 3, 'Escolar', 0, 'STR-PRS-04', NULL, NULL, 2, NULL, NULL, 3),
(370, '7453015102635', 'VIÑETA PARA PRECIO VERDE', '1.0000', '0.500000', 0, 'Escolar', 0, 'ST-PRS-03', NULL, NULL, 2, NULL, NULL, 3),
(371, '7453015102437', 'VIÑETA PARA PRECIO NARANJA', '1.0000', '0.500000', 3, 'Escolar', 0, 'ST-PRS-02', NULL, NULL, 2, NULL, NULL, 3),
(372, '7453015102871', 'VIÑETA PARA PRECIO VERDE O.', '1.0000', '0.500000', 5, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(373, '6954884595036', 'KEYROAD TIJETA ZIC ZAC', '1.3500', '0.675000', 8, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(374, '238126638256', 'ABRO CINTA ADHESIVA MEDIANA', '0.8500', '0.425000', 1, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(375, '790920324712', 'ABRO PVC ELECTRICAL TAPE', '0.5000', '0.250000', 12, 'Escolar', 0, 'CINTA AISLANTE', NULL, NULL, 3, NULL, NULL, 3),
(376, '8881488258655', 'MOUNTING TAPE 900 G', '1.0000', '0.500000', 0, 'Escolar', 0, 'CINTA DOBLE CARA', NULL, NULL, 3, NULL, NULL, 3),
(377, '750285235523', 'ABRO TIRRO DELGADO ', '1.0000', '0.600000', -1, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(378, '572057055042', 'ABRO CINTA DOBLE CARA', '3.2500', '1.625000', 0, 'Escolar', 0, 'COLOR BEIGE', NULL, NULL, 4, NULL, NULL, 3),
(379, '5713911827622', 'NORMA CUAD. CSIDO. RAYADO 200 PAGS', '4.2500', '3.028400', 12, 'Escolar', 0, 'PELUCHES NIÑA', NULL, NULL, 3, NULL, NULL, 3),
(380, '7702111835825', 'NORMA CUAD. CSIDO. MINIE RAYA 80 H', '3.7500', '2.611200', 8, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(381, '7702111811966', 'NORMA KIUT CSIDO. RAYA 100 H', '4.5000', '3.392300', 1, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(382, '7702111815391', 'NORMA ANIMAL BOOK CSIDO RAY ', '4.5000', '3.374900', 6, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(383, '7702111835665', 'NORMA INCREIBLES CSIDO RAY 100 H', '4.2500', '3.028400', 10, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(384, '7702111835887', 'NORMA FERRARI CSIDO RAY 100 H', '4.4500', '3.374900', 6, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(385, '7702111827561', 'NORMA CSIDO D. BALL S. RAY 100 H', '4.9500', '3.026100', 5, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(386, '7702111800526', 'NORMA STREET RCER CSIDO RAY 100 H', '4.5000', '2.351500', 6, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(387, '7702111835900', 'NORMA MIKEY CSIDO RAY 80 H', '3.7500', '2.610400', 10, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(388, '7702111293885', 'NORMA KIUT ASPRAL CUADRO 80 H', '4.0500', '2.977500', 9, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(389, '7702111333666', 'NORMA J. BOOK MM RAY 200 H', '12.5000', '8.482300', 8, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(390, '842135001169', 'CUARDERNO J BEXCELENT 4 MATERIAS', '3.1500', '1.980000', 29, NULL, 0, NULL, NULL, NULL, 5, NULL, NULL, 1),
(391, '7702111287204', 'NORMA KIUT DURABOOK MM RAY 160 H', '12.5000', '9.295400', 1, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(392, '7702111333697', 'NORMA J BOOK ASPIRAL RAY 100 H', '3.9000', '2.794500', 7, 'Escolar', 0, NULL, NULL, NULL, 4, NULL, NULL, 3),
(393, '7702111273504', 'NORMA KIUT ASPIRAL RAY 100 H', '3.9000', '2.794500', 14, 'Escolar', 0, 'CUADERNO PEQUEÑO', NULL, NULL, 4, NULL, NULL, 3),
(394, '7702111337282', 'NORMA J BOOK D. ASPIRAL RAY 80 H', '6.0000', '4.178400', 2, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(395, '7702111337275', 'NORMA J BOOK ASPIRAL CUADRO ', '6.0000', '4.170000', 3, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(396, '7702111840751', 'NORMA XPRESARTE MM ASPIRAL 200 H', '8.5000', '5.905400', 8, 'Escolar', 0, NULL, NULL, NULL, 4, NULL, NULL, 3),
(397, '7702111840799', 'NORMA BIA SPIRAL RAY 100 H', '3.5000', '2.703000', 1, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(398, '7702111826199', 'NORMA D. BALL Z SPIRAL RAY 100 H', '4.9000', '3.771600', 6, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(399, '7702111835511', 'NORMA D. BALL S. SPIRAL RAY 80 H', '4.9000', '3.721500', 13, 'Escolar', 0, NULL, NULL, NULL, 4, NULL, NULL, 3),
(400, '7702111835528', 'NORMA D. BALL S. SPIRAL CUADRO 80 H', '4.9000', '3.771600', 2, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(401, '7702111835450', 'NORMA ANDALUZ RAY 70 H', '2.0000', '1.310000', 5, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(402, '7702111831117', 'NORMA SIMPSONS SPIRAL RAY 80 H', '4.9000', '3.721400', 1, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(403, '325335258758', 'GUIA MULTICOLOR LED 100 LUCES', '6.0000', '2.250000', 9, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(404, '564676422643', 'CORTINA LED BLANCA', '8.0000', '4.000000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(405, '644321256171', 'GUIA LED VERDE 100 LCES', '4.0000', '1.750000', 6, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(406, '534121054148', 'GUIA LED 200 LUCES VERDE', '10.0000', '3.250000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(407, '742312263635', 'GUIA LED 200 LUCES AZUL', '10.0000', '3.250000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(408, '784783641284', 'GUIA LED MUSICAL MULTICOLOR ', '12.0000', '3.600000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(409, '206544124063', 'GUIA LED MULTICOLOR 200 LUCES', '12.0000', '3.250000', 4, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(410, '221084082700', 'PAPEL STICKER DECORADO', '0.4000', '0.200000', 89, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(411, '531473255703', 'POINTER PPEL SCARCHAD LSER GRIS', '0.3500', '0.175000', 4, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(412, '301772624477', 'POINTER PPEL SCARCHAD LSER VERDE', '0.3500', '0.175000', 20, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(413, '234875485851', 'POINTER PPEL SCARCHAD LSER MORADO', '0.3500', '0.175000', 15, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(414, '613445152638', 'POINTER PPEL SCARCHAD LSER VRDE OSCU', '0.3500', '0.175000', 10, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(415, '441682701602', 'POINTER PPEL SCARCHAD LSER ROJO', '0.3500', '0.175000', 10, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(416, '700066248054', 'POINTER PPEL SCARCHAD LSER FUCSIA', '0.3500', '0.175000', 10, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(417, '582430213705', 'POINTER PPEL SCARCHAD LSER AZUL', '0.3500', '0.175000', 10, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(418, '7807265057472', 'PROARTE FOMY DECO LISO CARTA', '0.4000', '0.200000', 10, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(419, '7807265057489', 'PROARTE FOMY LSO DECO 4 DISEÑS', '0.4000', '0.200000', 17, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(420, '768497998094', 'FACELA CRESPON MORADO', '0.2500', '0.125000', 38, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(421, '310075465264', 'PANDA CRESPON MORADO OSCURO', '0.2500', '0.125000', 29, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(422, '768497998131', 'FACELA CRESPON ROSA', '0.2500', '0.125000', 11, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(423, '8019959514362', 'EVANO CRESPON FUCSIA', '0.2500', '0.125000', 46, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(424, '768497998070', 'FACELA CRESPON FUCSIA', '0.2500', '0.125000', 29, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(425, '7401007601888', 'TUCAN CRESPON AMARILLO', '0.2500', '0.125000', 8, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(426, '17401007602035', 'TUCAN CRESPON CELESTE', '0.2500', '0.125000', 7, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(427, '7401007602052', 'TUCAN CRESPON NARANJA', '0.2500', '0.125000', 3, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(428, '8019959514515', 'EVANO CRESPON CELESTE O', '0.2500', '0.125000', 11, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(429, '8019959514423', 'EVANO CRESPON ROJO', '0.2500', '0.125000', 56, NULL, 0, NULL, NULL, NULL, 5, NULL, NULL, 1),
(430, '526358102571', 'PANDA CRESPON NARANJA', '0.2500', '0.125000', 26, NULL, 0, NULL, NULL, NULL, 5, NULL, NULL, 1),
(431, '505708427184', 'EVANO CRESPON NARANJA', '0.2500', '0.125000', 5, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(432, '505857274623', 'PANDA CRESPON AZUL', '0.2500', '0.125000', 76, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(433, '768497998063', 'FACELA CRESPON CAFE', '0.2500', '0.125000', 29, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(434, '513721860624', 'PANDA CRESPON VERDE CLARO', '0.2500', '0.125000', 3, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(435, '266438570816', 'TUCAN CRESPON CAFE', '0.2500', '0.125000', 2, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(436, '250647842066', 'EVAN CRESPON VERDE MUSGO', '0.2500', '0.125000', 2, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(437, '8019959514348', 'EVANO CRESPON CAFE', '0.2500', '0.125000', 4, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(438, '8019959514331', 'EVAN CRESPON BLANCO', '0.2500', '0.125000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(439, '768497998032', 'FACELA CRESPON BLANCO', '0.2500', '0.125000', 21, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(440, '768497999923', 'FACELA CRESPON DORADO', '0.5500', '0.275000', 0, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(441, '768497999701', 'FACELA CRESPON PLATEADO', '0.5500', '0.275000', 7, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(442, '017717764522', 'PANDA CRESPON TURQUESA', '0.2500', '0.125000', 7, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(443, '17401007602011', 'TUCAN CRESPON BLANCO', '0.2500', '0.125000', 110, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(444, '17401007602004', 'TUCAN CRESPON AZUL', '0.2500', '0.125000', 49, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(445, '768497998162', 'FACELA CRESPON CELESTE', '0.2500', '0.125000', 19, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(446, '441831263855', 'PANDA CRESPON VERDE', '0.2500', '0.125000', 20, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(447, '8019959514294', 'EVANO CRESPON VERDE LIMA', '0.2500', '0.125000', 41, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(448, '8019959514416', 'EVANO CRESPON NEGRO', '0.2500', '0.125000', 70, NULL, 0, NULL, NULL, NULL, 6, NULL, NULL, 1),
(449, '828042222475', 'PANDA CRESPON NARANJA CLARO', '0.2500', '0.125000', 41, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(450, '17401007602073', 'TUCAN CRESPON ROJO', '0.2500', '0.125000', 26, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(451, '085223580451', 'PANDA CRESPON AMARILLO', '0.2500', '0.125000', 29, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(452, '678538350003', 'PANDA CRESPON BLANCO', '0.2500', '0.125000', 28, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(453, '860326011640', 'PANDA FOMY CARTA LSO MORADO', '0.2000', '0.100000', 17, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(454, '332488370611', 'PARROT FOMY CARTA LSO LILA', '0.2000', '0.100000', -1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(455, '476871566022', 'AOS FOMY CARTA LSO ROJO', '0.2000', '0.100000', 1, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(456, '665746515505', 'PANDA FOMY CARTA LSO ROSADO C', '0.2000', '0.100000', 1, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(457, '413622544156', 'PARROT FOMY CARTA LSO NARANJA', '0.2000', '0.100000', 6, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(458, '304084517521', 'PANDA FOMY CARTA LSO AMARILLO', '0.2000', '0.100000', 2, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(459, '550544143057', 'PARROT FOMY CARTA LSO AMARILLO', '0.2000', '0.100000', 5, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(460, '607112161131', 'PANDA FOMY CARTA LSO CAFE', '0.2000', '0.100000', 2, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(461, '518627325450', 'PANDA FOMY CARTA LSO GRIS', '0.2000', '0.100000', 2, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(462, '545546381617', 'PANDA FOMY CARTA LSO DURAZNO', '0.2000', '0.100000', 13, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(463, '558420538715', 'AOS FOMY CARTA LSO MORADO', '0.2000', '0.100000', 4, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(464, '530463017854', 'PANDA FOMY CARTA LSO ROJO', '0.2000', '0.100000', 3, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(465, '416665871228', 'PANDA FOMY CARTA LSO CELESTE C', '0.2000', '0.100000', 8, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(466, '503707450751', 'PANDA FOMY CARTA LSO AZUL', '0.2000', '0.100000', -1, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(467, '227645875468', 'PANDA FOMY CARTA LSO CELESTE', '0.2000', '0.100000', 7, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(468, '611674277100', 'PANDA FOMY CARTA LSO PIEL', '0.2000', '0.100000', -4, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(469, '061360833524', 'PARROT FOMY CARTA LSO MENTA', '0.2000', '0.100000', 8, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(470, '757063052340', 'PANDA FOMY CARTA LSO NARANJA', '0.2000', '0.100000', -1, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(471, '853408872242', 'AOS FOMY CARTA LSO NARANJA', '0.2000', '0.100000', 2, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(472, '852665273313', 'PARROT FOMY CARTA LSO ROSADO', '0.2000', '0.100000', 5, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(473, '534724023362', 'PARROT FOMY CARTA LSO VERDE M', '0.2000', '0.100000', 7, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(474, '7401007609419', 'TUCAN FOMY CARTA LSO NEGRO', '0.2000', '0.100000', 36, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(475, '038107582122', 'PARROT FOMY CARTA LSO VERDE C', '0.2000', '0.100000', 8, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(476, '405748708104', 'PANDA FOMY CARTA LSO VERDE ', '0.2000', '0.100000', 2, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(477, '551876367067', 'AOS FOMY CARTA LSO BLANCO', '0.2000', '0.100000', -10, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(478, '586012224223', 'AOS FOMY CARTA LSO GRIS', '0.2000', '0.100000', 5, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(479, '770377213453', 'PARROT FOMY CARTA LSO CELESTE', '0.2000', '0.100000', 6, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(480, '752648482226', 'PANDA FOMY CARTA LSO VERDE LIMA', '0.2000', '0.100000', 9, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(481, '487827365654', 'PANDA FOMY CARTA LSO FUCSIA', '0.2000', '0.100000', 13, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(482, '376011600666', 'PARROT FOMY CARTA LSO PIEL ', '0.2000', '0.100000', 10, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(483, '7401007609426', 'TUCAN FOMY CARTA LSO ROJO', '0.2000', '0.100000', 13, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(484, '7401007609570', 'TUCAN FOMY CARTA LSO ROSADO', '0.2000', '0.100000', 22, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(485, '7401007609402', 'TUCAN FOMY CARTA LSO BLANCO', '0.2000', '0.100000', 10, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(486, '7401007609433', 'TUCAN FOMY CARTA LSO AMARILLO', '0.2000', '0.100000', 14, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(487, '7401007609440', 'TUCAN FOMY CARTA LSO AZUL', '0.2000', '0.100000', 16, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(488, '507307884567', 'PARROT FOMY CARTA LSO CAFE CLARO', '0.2000', '0.100000', 0, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(489, '266636887127', 'PARROT FOMY CARTA LSO VERDE', '0.2000', '0.100000', 6, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(490, '320868578887', 'PARROT FOMY BRLLO CRTA CAFE', '0.5000', '0.250000', 20, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(491, '763736105004', 'AOS FOMY BRLLO CRTA CELESTE', '0.5000', '0.250000', -7, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(492, '323752876147', 'PANDA FOMY BRLLO CRTA ROSADO', '0.5000', '0.250000', 0, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(493, '7401007603127', 'TUCAN FOMY BRLLO CRTA ROSADO', '0.5000', '0.250000', 5, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(494, '316445585652', 'FOMY BRLLO CRTA NARANJA', '0.5000', '0.250000', 2, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(495, '845211255543', 'PARROT FOMY BRLLO CRTA AZUL', '0.5000', '0.250000', 24, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(496, '402013400854', 'PANDA FOMY BRLLO CRTA FUCSIA', '0.5000', '0.250000', 2, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(497, '646408576537', 'PANDA FOMY BRLLO CRTA NEGRO', '0.5000', '0.250000', 3, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(498, '7401007603097', 'TUCAN FOMY BRLLO CRTA NEGRO', '0.5000', '0.250000', 18, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(499, '157744074257', 'FOMY BRLLO CRTA AMARILLO', '0.5000', '0.250000', 0, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(500, '070747202754', 'FOMY BRLLO CRTA VERDE', '0.5000', '0.250000', 15, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(501, '433776118704', 'FOMY BRLLO CRTA MORADO', '0.5000', '0.250000', 12, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(502, '7401007603110', 'TUCAN FOMY BRLLO CRTA CELESTE', '0.5000', '0.250000', 27, 'Escolar', 0, NULL, NULL, NULL, 4, NULL, NULL, 3),
(503, '870538540453', 'PANDA FOMY BRLLO CRTA VERDE MUZ', '0.5000', '0.250000', 3, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(504, '586417205488', 'PARROT FOMY BRLLO CRTA VERDE MUZ', '0.5000', '0.250000', 13, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(505, '684811377733', 'PARROT FOMY BRLLO CRTA VERDE CL', '0.5000', '0.250000', 18, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(506, '046266027052', 'PARROT FOMY BRLLO CRTA BLANCO', '0.5000', '0.250000', 7, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(507, '672532681870', 'PARROT FOMY BRLLO CRTA ROJO', '0.5000', '0.250000', 11, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(508, '206302133166', 'PARROT FOMY BRLLO CRTA GRIS', '0.5000', '0.250000', 7, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(509, '035276872111', 'PARROT FOMY BRLLO CRTA FUCSIA', '0.5000', '0.250000', 44, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(510, '418835543251', 'AOS LANA BOYO BLANCA', '0.5000', '0.250000', 7, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(511, '7401007604605', 'TUCAN LANA BOYO CELESTE', '0.5000', '0.250000', 10, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(512, '061118354045', 'AOS LANA BOYO AMARILLO', '0.5000', '0.250000', 9, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(513, '702557582280', 'RCP LANA BOYO NARANJA', '0.5000', '0.250000', 8, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(514, '7453038401234', 'POINTER LANA BOYO CAFE', '0.5000', '0.250000', 10, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(515, '7401007604490', 'TUCAN LANA BOYO AMARILLO', '0.5000', '0.250000', 10, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(516, '734385231744', 'TIBURON LANA BOYO NEGRO', '0.5000', '0.310000', 42, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(517, '376472415362', 'RCP LANA BOYO CAFE', '0.5000', '0.250000', 23, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(518, '630853165843', 'RCP LANA BOYO VERDE MUZ', '0.5000', '0.250000', 8, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(519, '173857328463', 'AOS LANA BOYO AZUL', '0.5000', '0.250000', 20, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(520, '586373375445', 'AOS LANA BOYO VERDE LIMON', '0.5000', '0.250000', 12, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(521, '167515013123', 'AOS LANA BOYO VERDE MUZGO', '0.5000', '0.250000', 20, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(522, '484111454026', 'RCP LANA BOYO ROSADO', '0.5000', '0.250000', 11, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(523, '206586840808', 'AOS LANA BOYO ROSADO', '0.5000', '0.250000', 19, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(524, '804216135506', 'TUCAN LANA BOYO NARANJA', '0.5000', '0.250000', 10, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(525, '123540670821', 'RCP LANA BOYO MORADO', '0.5000', '0.250000', 7, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(526, '475880844207', 'RCP LANA BOYO ROSADO CLARO', '0.5000', '0.250000', 4, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(527, '680051686603', 'AOS LANA BOYO CELESTE', '0.5000', '0.250000', 13, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(528, '364506840436', 'RCP LANA BOYO ROSADO VIEJA', '0.5000', '0.250000', 6, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(529, '441888146000', 'TIBURON LANA BOYO MORADO', '0.5000', '0.310000', 30, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(530, '078012661686', 'TUBURON LANA BOYO CAFE OSCURO', '0.5000', '0.250000', 1, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(531, '322637556765', 'TUCAN LANA BOYO VIOLETA', '0.5000', '0.250000', 7, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(532, '857707458770', 'TIBURON LANA BOYO AZUL MARINO', '0.5000', '0.310000', 35, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(533, '410177475474', 'AOS LANA BOYO MORADO', '0.5000', '0.250000', 6, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(534, '451173322562', 'RCP LANA BOYO AMARILLO', '0.5000', '0.250000', 5, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(535, '434363886362', 'AOS LANA BOYO ROJO', '0.5000', '0.250000', 5, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(536, '846711873818', 'RCP LANA BOYO ROJO', '0.5000', '0.250000', 9, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(537, '184720272571', 'TIBURON LANA BOYO NARANJA', '0.5000', '0.310000', 27, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(538, '844213674277', 'TIBURON LANA BOYO GRIS', '0.5000', '0.310000', 29, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(539, '857186867833', 'TIBURON LANA BOYO CAFE', '0.5000', '0.310000', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(540, '218216838227', 'RCP LANA BOYO CELESTE', '0.5000', '0.250000', 2, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(541, '220758654262', 'TUCAN LANA BOYO GRIS', '0.5000', '0.250000', 4, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(542, '025348402336', 'TIBURON LANA BOYO CELESTE', '0.5000', '0.310000', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(543, '277367263434', 'RCP LANA BOYO AZUL', '0.5000', '0.250000', 1, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(544, '122645083370', 'TIBURON LANA BOYO AZUL', '0.5000', '0.310000', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(545, '076835335366', 'RCP LANA BOYO FUCSIA', '0.5000', '0.250000', 5, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(546, '7416501953739', 'IRASA FOLDER COLOR OFICIO LILA', '0.2500', '0.125000', 9, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(547, '121346024102', 'FOLDER COLOR OFICIO MORADO', '0.2500', '0.125000', 6, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(548, '7416501953661', 'IRASA FOLDER COLOR OFICIO MORADO', '0.2500', '0.125000', 15, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(549, '7416501953623', 'IRASA FOLDER COLOR OFICIO VERDE LIMON', '0.2500', '0.125000', 1, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(550, '7416501953678', 'IRASA FOLDER COLOR OFICIO NEGRO', '0.2500', '0.125000', 9, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(551, '7416501953654', 'IRASA FOLDER COLOR OFICIO GRIS', '0.2500', '0.125000', 9, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(552, '7416501953586', 'IRASA FOLDER COLOR OFICIO NARANJA', '0.2500', '0.125000', 0, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(553, '7416501959250', 'IRASA FOLDER COLOR OFICIO AMARILLO H', '0.2500', '0.125000', 12, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(554, '7416501953593', 'IRASA FOLDER COLOR OFICIO AMARILLO', '0.2500', '0.125000', 18, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(555, '7416501953630', 'IRASA FOLDER COLOR OFICIO ROSADO', '0.2500', '0.125000', 19, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(556, '126812547854', 'FOLDER OFICIO CORRIENTE ', '0.2000', '0.100000', 16, 'Escolar', 0, NULL, NULL, NULL, 8, NULL, NULL, 3),
(557, '547086001552', 'FOLDER CRTA COLOR NARANJA', '0.2000', '0.100000', 17, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(558, '7417200601464', 'BEXCELENT FOLDER CRTA COLOR AMARILLO H', '0.2000', '0.100000', 4, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(559, '7416501930105', 'IRASA FOLDER CRTA COLOR GRIS C', '0.2000', '0.100000', 2, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(560, '762725603402', 'FOLDER CRTA COLOR AMARILLO', '0.2000', '0.100000', 12, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(561, '7416501930198', 'IRASA FOLDER CRTA COLOR LILA', '0.2000', '0.100000', 1, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(562, '022130618508', 'FOLDER CRTA COLOR AQUA', '0.2000', '0.100000', 20, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(563, '528180711073', 'FOLDER CRTA COLOR NEGRO', '0.2000', '0.100000', 5, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(564, '525817880553', 'FOLDER CRTA COLOR AZUL OSC', '0.2000', '0.100000', 5, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(565, '811081816750', 'FOLDER CRTA COLOR ROJO', '0.2000', '0.100000', 6, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(566, '174270842525', 'FOLDER CRTA COLOR FUCSIA', '0.2000', '0.100000', 23, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(567, '031235250665', 'FOLDER CRTA COLOR VERDE LIMA', '0.2000', '0.100000', 15, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(568, '525478576151', 'FOLDER CRTA COLOR GRIS OSC', '0.2000', '0.100000', 16, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(569, '245842315228', 'FOLDER CRTA COLOR GRIS CLARO', '0.2000', '0.100000', 25, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(570, '125434817476', 'FOLDER CRTA COLOR CELESTE', '0.2000', '0.100000', 14, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(571, '7416500805152', 'HISPACOLOR FOLDER CRTA COLOR MORADO', '0.2000', '0.100000', 22, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(572, '148811301307', 'FOLDER CRTA COLOR MORADO CLARO', '0.2000', '0.100000', 14, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(573, '607738570248', 'FOLDER CRTA COLOR GRIS CLARO TEX', '0.2000', '0.100000', 6, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(574, '172060407563', 'FOLDER CRTA COLOR ROSADO', '0.2000', '0.100000', 13, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(575, '7416501959526', 'IRASA FOLDER CRTA COLOR VERDE LIMON', '0.2000', '0.100000', -14, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(576, '7416501902645', 'IRASA FOLDER CRTA COLOR VERDE MUZGO', '0.2000', '0.100000', -3, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(577, '216364412830', 'FOLDER CRTA COLOR AZUL CLAR', '0.2000', '0.100000', -5, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(578, '768497013346', 'FACELA FOLDER CRRIENTE CRTA', '0.1000', '0.040000', 724, NULL, 0, NULL, NULL, NULL, 24, NULL, NULL, 1),
(579, '366532867686', 'SOBRE MANILA 6 X 9\"', '0.1000', '0.028000', 83, 'Escolar', 0, 'EL MAS PEQUEÑO', NULL, NULL, 24, NULL, NULL, 3),
(580, '8991389923139', 'SOBRE MANILA 7 X 10\"', '0.1500', '0.037000', 96, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(581, '8991389923153', 'SOBRE MANILA 10 X 13 \"', '0.2000', '0.062500', 89, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(582, '248030548652', 'SOBRE MANILA 10 X 15\"', '0.2500', '0.077100', 50, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(583, '678066771225', 'SOBRE MANILA 9 X 11/1/2\"', '0.2000', '0.100000', 13, 'Escolar', 0, NULL, NULL, NULL, 8, NULL, NULL, 3),
(584, '8991389923146', 'SOBRE MANILA 9 X 12\"', '0.2000', '0.100000', 94, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(585, '765656800250', 'SOBRE MANILA 12 X 15\"', '0.3500', '0.175000', 81, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(586, '7401158100438', 'SOBRE MANILA 11 X 15\"', '0.2500', '0.125000', 99, 'Escolar', 0, 'GOLDEN', NULL, NULL, 24, NULL, NULL, 3),
(587, '474472074846', 'LIBRO APRENDIENDO A SCRIBR Y L.', '2.5000', '1.500000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(588, '471071145817', 'SILABARIO A COLORES', '2.2500', '1.250000', 1, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(589, '478774627433', 'SILABARIO CLASICO ECO', '0.7500', '0.300000', 9, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(590, '014263311112', 'SILABARIO LEE ESCRIBE COLOREA', '1.5000', '0.708300', 2, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(591, '754440850876', 'FOLLETO PUNTITOS 4', '2.0000', '0.750000', 6, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(592, '172723860104', 'PUNTITOS PRESCOLAR 1', '2.0025', '0.750000', 5, 'Golocinas', 0, 'UNETE Y COLOREA NUEVA EDICION', NULL, NULL, 2, NULL, NULL, 2),
(593, '380878371586', 'SUPER CUENTOS', '1.5000', '0.750000', 7, 'Golocinas', 0, 'PORTADA DEL LIBRO DE LA SELVA', NULL, NULL, 3, NULL, NULL, 2),
(594, '588214085684', 'APRENDAMOS MATEMATICAS', '2.0000', '0.900000', 6, 'Golocinas', 0, NULL, NULL, NULL, 3, NULL, NULL, 2),
(595, '031144528788', 'RECORTAREAS', '4.9000', '3.750000', 7, 'Golocinas', 0, 'LIBRETA DE CROMOS', NULL, NULL, 3, NULL, NULL, 2),
(596, '466656256375', 'LIBRO PASATIEMPOS', '3.0000', '2.000000', 5, 'Golocinas', 0, NULL, NULL, NULL, 3, NULL, NULL, 2),
(597, '6972545185532', 'BOLSA REG S CTON GLOBO ', '1.0000', '0.650000', 27, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(598, '367701348532', 'BOLSA REG MED BRLLO CORAZONES', '1.0000', '0.621500', 8, 'Escolar', 0, NULL, NULL, NULL, 4, NULL, NULL, 3),
(599, '786143521815', 'BOLSA REG GRAN BRLLO CORAZONES', '1.5000', '0.960500', 4, 'Escolar', 0, NULL, NULL, NULL, 4, NULL, NULL, 3),
(600, '124065456112', 'CUENTOS CLASICOS NIÑO ALBERT SALES', '2.5000', '1.650000', -1, 'Escolar', 0, 'JERRY MADINE VERSION ESPAÑOL', NULL, NULL, 3, NULL, NULL, 3),
(601, '144775466351', 'LIBRETA D CROMOS MULTICOLRES', '2.0000', '1.000000', 8, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(602, '671783062074', 'CUENTOS CLASICOS NIÑA ALBERT SALES', '2.5000', '1.650000', 1, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(603, 'Na9788449921032', 'LIBRO NACHO 01', '5.6000', '4.327900', 9, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(604, '9788459922210', 'LIBRO NACHO 1 ', '5.6000', '4.327900', 12, 'Escolar', 0, 'PRIMERAS LECTURAS', NULL, NULL, 3, NULL, NULL, 3),
(605, '7467634942985', 'LIBRO LECTURA INCIAL PINOCHO', '3.2500', '2.825000', 10, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(606, '7467634942039', 'LIBRO PRMERAS LECTURAS PINOCHO', '3.2500', '2.825000', 12, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(607, '9789945122404', 'LIBRO NACHO 2', '6.5000', '5.710000', 12, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(608, '351871152680', 'LIBRO BERNARDITO', '8.2500', '7.342175', 10, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(609, '9788430512423', 'NUEVO SILABARIO', '6.7500', '5.717800', 6, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(610, '627118473506', 'METODO PALMER', '0.9500', '0.711900', 18, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(611, '7416601800100', 'NUEVO SILABARIO HISPANOAMERICA', '0.7500', '0.361600', 18, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(612, '9789706073587', 'DICCIONARIO LAROUSE BASICO', '5.0000', '4.380000', 12, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(613, '9789992376621', 'DICCIONARIO BASICO SANTA INEZ', '3.2500', '2.373000', 8, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(614, '9789945122725', 'MI CALIGRAFIA NACHO 0', '2.9500', '2.169600', 3, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(615, '9789945122732', 'MI CALIGRAFIA NACHO 1', '2.9500', '2.169600', 6, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(616, '9789945122749', 'MI CALIGRAFIA NACHO 2', '2.9500', '2.169600', 2, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(617, '9789945122756', 'MI CALIGRAFIA NACHO 3', '2.9500', '2.169600', 6, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(618, '9789945122763', 'MI CALIGRAFIA NACHO 4', '2.9500', '2.169600', 5, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(619, '9789945122770', 'MI CALIGRAFIA NACHO 5', '2.9500', '2.169600', 5, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(620, '9789945122787', 'MI CALIGRAFIA NACHO 6', '2.9500', '2.169600', 6, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(621, '9789945122794', 'MI CALIGRAFIA NACHO 7', '2.9500', '2.169600', 6, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(622, '9789945122800', 'MI CALIGRAFIA NACHO 8', '2.9500', '2.169600', 6, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(623, '802617213441', 'LIBRO DE COLOREO DIVERSOS', '1.0000', '0.450000', 50, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(624, '123774660626', 'APRENDIENDO CON TRACITOS', '2.0000', '0.900000', 2, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(625, '230027253660', 'FOLLETO PUNTITOS 3', '2.0000', '0.900000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(626, '710162803223', 'PRESCOLAR PUNTITOS 2', '2.0000', '0.900000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(627, '571605416171', 'ATLAS MUNDIAL GEOGRAFICO', '2.0000', '0.900000', 2, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(628, '487765022048', 'MITOS Y LEYENDAS EL SALVADOR', '2.0000', '0.900000', 2, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(629, '534337857613', 'CUENTOS CLASICOS 2 DIVERSOS', '2.0000', '0.900000', -1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(630, '346266233072', 'CUENTOS CLASICOS 1 DIVERSOS', '2.0000', '0.900000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(631, '053685526325', 'LIBRETA PINTO Y RAYO', '4.0000', '2.000000', 6, 'Escolar', 0, 'COLOREA TRAZA APRENDE DIVIERTETE', NULL, NULL, 2, NULL, NULL, 3),
(632, '4710581421540', 'TALBOT ARCHIVO DE ACORDEON', '5.0000', '3.500000', 2, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(633, '7453015106695', 'GLASS MALETIN A-4', '4.5000', '3.300000', 3, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(634, '4710581424190', 'TALBOT ARCHIVO D ACORDEON 13 ARCH', '4.5000', '3.600000', 1, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(635, '4710581317096', 'CARPETA DE PRESENTACION ', '2.0000', '1.250000', 2, 'Escolar', 0, 'CON HOJAS PROTECTORAS PLASTICAS', NULL, NULL, 1, NULL, NULL, 3),
(636, '511476272017', 'FLODER MY CLEAR PLASTICO CRTA', '0.4500', '0.250000', 20, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(637, '756366713174', 'FLODER MY CLEAR PLASTICO OFCIO', '0.5000', '0.300000', 7, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(638, '7453015115413', 'FOLDER FASTENER A4', '1.5000', '0.900000', 1, 'Escolar', 0, 'FOLDER CON GANCHO', NULL, NULL, 3, NULL, NULL, 3),
(639, '6990120000926', 'FOLDER MARTIPLE WJD-FC-35-1', '1.0000', '0.600000', 11, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(640, '6970807240029', 'FOLDER MARTIPLE WJD-FC-24-1', '1.0000', '0.600000', 1, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(641, '186004362416', 'FOLDER PLASTICO TRANSPARENTE', '0.7500', '0.360000', 2, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(642, '307568544742', 'RCP TBLA CON CLIP CARTA', '1.9000', '1.150000', 3, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(643, '177545500236', 'IMAN ESCOLAR', '0.2500', '0.120000', 34, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(644, '6998428502012', 'PIONER GLITTER BAG', '0.1500', '0.080000', 120, 'Escolar', 0, 'BRILLANTINA', NULL, NULL, 20, NULL, NULL, 3),
(645, '7453015115666', 'STUDMARK GLITTERS ESCARCHAS', '0.1500', '0.080000', 57, 'Escolar', 0, NULL, NULL, NULL, 15, NULL, NULL, 3),
(646, '7410063015201', 'RADIOSHACK BATERIAS AAA', '1.5000', '0.900000', 20, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(647, '303472153220', 'HUATAI BATERIAS AA', '0.5000', '0.250000', 13, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(648, '342512255710', 'BRILLANTINA VERDE', '0.1500', '0.080000', 8, 'Escolar', 0, 'TODO FOMY CREACIONES ELIZABETH', NULL, NULL, 2, NULL, NULL, 3),
(649, '000763488481', 'OJOS MOVIBLES ', '0.2500', '0.150000', 233, 'Escolar', 0, NULL, NULL, NULL, 20, NULL, NULL, 3),
(650, '17401007622187', 'TUCAN PAPEL DE CHINA ROSADO INTENSO', '0.1000', '0.040000', 173, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(651, '17401007620718', 'TUCAN PAPEL DE CHINA NEGRO', '0.1000', '0.040000', 155, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(652, '17401007622194', 'TUCAN PAPEL DE CHINA AZUL', '0.1000', '0.040000', 221, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(653, '17401007622163', 'TUCAN PAPEL DE CHINA ROJO INTENSO', '0.1000', '0.040000', 290, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(654, '17401007620640', 'TUCAN PAPEL DE CHINA BLANCO', '0.1000', '0.040000', 164, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(655, '125411673772', 'TUCAN PAPEL DE CHINA NARANJA PAL', '0.1000', '0.040000', 80, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(656, '642846730237', 'TUCAN PAPEL DE CHINA VERDE MUZGO', '0.1000', '0.040000', 61, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(657, '7401007603233', 'TUCAN PAPEL DE CHINA FUCCIA', '0.1000', '0.040000', 15, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(658, '075002862750', 'PAPEL CHINA LINEAS DORADAS', '0.2500', '0.120000', 44, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(659, '666570338673', 'PAPEL CHINA NAVIDAD', '0.2500', '0.120000', 15, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(660, '044613025832', 'PAPEL CHINA CORAZON ROJO', '0.2500', '0.120000', 46, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(661, '180112185103', 'PAPEL CHINA BRILLA COPO DE NIEVE', '0.2500', '0.120000', 19, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(662, '046085310225', 'PAPEL CHINA CORAZON COLOR', '0.2500', '0.120000', 25, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(663, '031170417033', 'PAPEL CHINA ARCOIRIS', '0.2500', '0.120000', 17, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(664, '504582121466', 'PAPEL CHINA GLOBO', '0.2500', '0.120000', 22, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(665, '107851421767', 'PAPEL CHINA HOJAS', '0.2500', '0.120000', 19, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(666, '642301600804', 'PAPEL CHINA FIESTA', '0.2500', '0.120000', 49, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(667, '7401007626492', 'TUCAN PAPEL DE CHINA ORO PERLADO', '0.2500', '0.130000', 64, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(668, '7401007626478', 'TUCAN PAPEL DE CHINA BLANCO PERLADO', '0.2500', '0.130000', 86, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(669, '17401007603711', 'TUCAN PAPEL DE CHINA VERDE LIMA', '0.1000', '0.040000', 64, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(670, '7401007620698', 'TUCAN PAPEL DE CHINA AMARILLO ORO', '0.1000', '0.040000', 18, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(671, '7401007620742', 'TUCAN PAPEL DE CHINA CELESTE', '0.1000', '0.040000', 58, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(672, '7401007604391', 'TUCAN PAPEL DE CHINA LILA', '0.1000', '0.040000', 52, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(673, '17401007620756', 'TUCAN PAPEL DE CHINA CAFE', '0.1000', '0.040000', 108, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(674, '032175887127', 'TUCAN PAPEL DE CHINA CAFE CLARO', '0.1000', '0.040000', 5, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(675, '183871473547', 'TUCAN PAPEL DE CHINA SALMON', '0.1000', '0.040000', 4, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(676, '778851288355', 'TUCAN PAPEL DE CHINA NARANJA ', '0.1000', '0.040000', 17, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(677, '218840568653', 'FACTURA COMERCIAL GRANDE', '0.5000', '0.220000', 67, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(678, '188272311548', 'FACTURA COMERCIAL PEQUEÑA', '0.2500', '0.120000', 38, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(679, '834176732640', 'TALONARIOS DE RECIBO', '0.3500', '0.180000', 94, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(680, '608574231602', 'LETRA DE CAMBIO', '0.5000', '0.300000', 6, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(681, '342464256862', 'PAPEL BOND COLOR SALMON', '0.0500', '0.020000', 120, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(682, '412454105353', 'PAPEL BOND COLOR CELESTE', '0.0500', '0.020000', -14, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(683, '753888887177', 'PAPEL BOND COLOR NEGRO', '0.0500', '0.020000', -18, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(684, '088154475642', 'PAPEL BOND COLOR CAFE', '0.0500', '0.020000', 33, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(685, '015671860427', 'PAPEL BOND COLOR AZUL', '0.0500', '0.020000', 51, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(686, '852384213401', 'PAPEL BOND COLOR MORADO', '0.0500', '0.020000', -2, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(687, '886824053402', 'PAPEL BOND COLOR AMARILLO', '0.0500', '0.020000', 99, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(688, '206857388322', 'PAPEL BOND COLOR VERDE MUZGO', '0.0500', '0.020000', 49, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(689, '324886615382', 'PAPEL BOND COLOR ROJO', '0.0500', '0.020000', 27, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(690, '331841321372', 'PAPEL BOND COLOR LILA', '0.0500', '0.020000', -6, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(691, '417201140881', 'PAPEL BOND COLOR COLOR PIEL', '0.0500', '0.020000', 3, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(692, '083221545535', 'PAPEL BOND COLOR NARANJA CLARO', '0.0500', '0.020000', 37, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(693, '788201380336', 'PAPEL BOND COLOR CELESTE CLARO', '0.0500', '0.020000', 7, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(694, '548062052805', 'PAPEL BOND COLOR NARANJA OSCURO', '0.0500', '0.020000', 52, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(695, '020822183523', 'PAPEL BOND COLOR LILA CLARO', '0.0500', '0.020000', 20, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(696, '753815855116', 'PAPEL BOND COLOR ROSADO', '0.0500', '0.020000', 57, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(697, '247331181858', 'PAPEL BOND COLOR VERDE ', '0.0500', '0.020000', 23, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(698, '273338843846', 'PAPEL BOND COLOR VERDE LIMA', '0.0500', '0.020000', 36, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(699, '363025166454', 'PAPEL BOND COLOR VERDE CLARO', '0.0500', '0.020000', 91, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(700, '674587116727', 'PAPEL BOND COLOR VERDE LIMON', '0.0500', '0.020000', 59, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(701, '4713294973931', 'NOKY PLAST. ADHESIV AMARILLO 1.5', '1.5000', '0.650000', 2, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(702, '4713294973924', 'NOKY PLAST. ADHESIV NARANJA 1.5', '1.5000', '0.650000', 3, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(703, '4713294973955', 'NOKY PLAST. ADHESIV MORADO 1.5', '1.5000', '0.650000', 0, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(704, '4713294973979', 'NOKY PLAST. ADHESIV AZUL 1.5', '1.5000', '0.650000', 1, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(705, '4713294973917', 'NOKY PLAST. ADHESIV ROJO 1.5', '1.5000', '0.650000', 0, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(706, '4717480709069', 'NOKY PLAST. ADHESIV TRANSPA 1.5', '1.5000', '0.750000', 0, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(707, '7417200603635', 'PARROT PLAST. ADHESIV TRANSPA 1.5', '1.5000', '0.750000', 0, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(708, '7417200603642', 'NOKY PLAST. ADHESIV TRANSPA 3.0', '3.0000', '1.650000', 0, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(709, '7401007604445', 'TUCAN PLAST. ADHESIV TRANS PRIMAV 1.5', '1.5000', '0.650000', -1, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(710, '7401007600232', 'TUCAN PLAST. ADHESIV TRANS CUADR 1.5', '1.6000', '0.650000', 0, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(711, '501636421348', 'SENSOR DE BIENVENIDA', '18.0000', '12.000000', 3, 'Tecnología', 0, NULL, NULL, NULL, 2, NULL, NULL, 9),
(712, '6932897400004', 'CARTULINAS DE COLORES A4', '1.5000', '0.800000', 6, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(713, '742832906708', 'RESISTOL BARRAS DE SILICON DELGADAS', '0.2500', '0.120000', 85, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(714, '7401007618497', 'ARCOIRIS SET DE PAPEL DE COLORES', '3.2500', '1.950000', 1, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(715, '7807265042621', 'PROARTE CARTON PRIEDRA', '0.5000', '0.280000', 14, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(716, '7401111901560', 'LIBRO DE ACTAS N°120', '1.5000', '0.900000', 7, 'Escolar', 0, NULL, NULL, NULL, 4, NULL, NULL, 3),
(717, '7416601800094', 'LIBRETA MILIMETRADA', '1.5000', '0.850000', 2, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(718, '7417200601211', 'PAPEL MILIMETRADO', '0.0500', '0.020000', 19, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(719, '501140544885', 'PRACTICAS DE CONTABILIDAD', '1.0000', '0.550000', 18, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(720, '7416601800087', 'LIBRETA DE DIBUJOS Y RECORTES', '1.0000', '0.600000', 3, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(721, '7416601800124', 'LIBRETA DE DIBUJOS Y RECORTES ANIMALES', '1.0000', '0.600000', 8, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(722, '768497345645', 'FACELA LIBRETA DE DIBUJO', '1.0000', '0.600000', 6, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(723, '4717480707393', 'PAPEL CARBON INDIVIDUAL', '0.1500', '0.070000', 83, 'Escolar', 0, NULL, NULL, NULL, 20, NULL, NULL, 3),
(724, '416453243670', 'PAPEL JADE TEXTURA', '0.5000', '0.250000', 97, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(725, '798302090446', 'KLIPXTREME PPEL FOTOGRAFICO', '0.5000', '0.191600', 197, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(726, '521407327870', 'SOBRE OFICIO BLANCO', '0.1000', '0.040000', 857, 'Escolar', 0, NULL, NULL, NULL, 100, NULL, NULL, 3),
(727, '620357756755', 'SOBRE CARTA BLANCO', '0.0500', '0.020000', 255, 'Escolar', 0, NULL, NULL, NULL, 100, NULL, NULL, 3),
(728, '707615113672', 'TUCAN FOMY PLIEGO BRLLO NEGRO', '1.9500', '1.400000', 10, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(729, '120162152381', 'TUCAN FOMY PLIEGO BRLLO AZUL', '1.9500', '1.400000', -1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(730, '160161411568', 'TUCAN FOMY PLIEGO BRLLO ROJO', '1.9500', '1.400000', 2, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(731, '867445308162', 'TUCAN FOMY PLIEGO BRLLO VERDE L', '1.9500', '1.400000', 2, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(732, '007656757116', 'AOS FOMY PLIEGO BRLLO MORADO', '1.9500', '1.400000', 3, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(733, '108705254383', 'AOS FOMY PLIEGO BRLLO ROSADO', '1.9500', '1.400000', 19, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(734, '577161027355', 'TUCAN FOMY PLIEGO BRLLO CELESTE', '1.9500', '1.400000', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(735, '617783116563', 'TUCAN FOMY PLIEGO BRLLO VERDE CLA', '1.9500', '1.400000', 10, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(736, '615526178073', 'TUCAN FOMY PLIEGO BRLLO DORADO', '1.9500', '1.400000', -1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(737, '323088650755', 'TUCAN FOMY PLIEGO BRLLO CAFE CLA', '1.9500', '1.400000', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(738, '612304606117', 'TUCAN FOMY PLIEGO BRLLO CAFE OSCU', '1.9500', '1.400000', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(739, '114673255373', 'TUCAN FOMY PLIEGO BRLLO CAFE', '1.9500', '1.400000', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(740, '822807870735', 'TUCAN FOMY PLIEGO BRLLO NARANJA', '1.9500', '1.400000', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(741, '185450145480', 'TUCAN FOMY PLIEGO BRLLO AZUL CROMO', '1.9500', '1.400000', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(742, '6985805171343', 'CURLY', '2.2500', '1.000000', 5, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(743, '6925871660198', 'CARGADOR EWTO TC', '8.0000', '4.000000', 7, 'Tecnología', 0, NULL, NULL, NULL, 2, NULL, NULL, 9),
(744, '4971850091387', 'CALCULADORA CASIO HL-815L', '5.2500', '3.500000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(745, '453166553062', 'PAPEL CELOFAN', '0.5000', '0.360000', 61, 'Escolar', 0, NULL, NULL, NULL, 24, NULL, NULL, 3),
(746, '740617282290', 'KINGSTON 64 GB USB', '17.0000', '11.000000', 1, 'Tecnología', 0, NULL, NULL, NULL, 2, NULL, NULL, 9),
(747, '740617309720', 'KINGSTON 32 GB USB NEGRA', '12.0000', '6.550000', 0, 'Tecnología', 0, NULL, NULL, NULL, 2, NULL, NULL, 9);
INSERT INTO `Hoja1` (`id_producto`, `Codigo`, `Nombre`, `Precio_de_venta`, `Precio_de_compra`, `Cantidad`, `Marca`, `Descuento`, `Descripcion`, `Imagen`, `Ubicacion`, `StockMinimo`, `PrecioMayoreo`, `PrecioDistribuidor`, `id_categoria`) VALUES
(748, '740617314335', 'KINGSTON 32 GB USB BLANCA', '12.0000', '6.550000', 0, 'Tecnología', 0, NULL, NULL, NULL, 2, NULL, NULL, 9),
(749, '810033030000', 'HYUNDAI 16 GB USB 2.0 METALICA', '8.0000', '5.900000', 0, 'Tecnología', 0, NULL, NULL, NULL, 2, NULL, NULL, 9),
(750, '7410063008852', 'RADIOSHACK 8 GB USB 2.0', '6.0000', '4.650000', 4, 'Tecnología', 0, NULL, NULL, NULL, 2, NULL, NULL, 9),
(751, '7410063008876', 'RADIOSHACK 32 GB USB 2.0', '9.0000', '6.200000', 4, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(752, '4549526607219', 'CALCULADORA CASIO FX-82', '17.0000', '12.640000', 1, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(753, '6932177476033', 'KADIO CALCULADORA KD-3866B-C', '6.0000', '3.150000', 1, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(754, '6989532512530', 'AUDIFONO BT P47', '18.0000', '12.000000', 1, 'Tecnología', 0, NULL, NULL, NULL, 0, NULL, NULL, 9),
(755, '4905524987553', 'AUDIFONO BT SONY 951BT', '20.0000', '12.000000', 0, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(756, '010343885301', 'EPSON TINTA 664 CYAN', '16.5000', '13.000000', 3, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(757, '886540000287', 'ARGOM AUDIFONO HS525 NEGRO', '6.0000', '3.900000', 2, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(758, '886540000294', 'ARGOM AUDIFONO HS525 AZUL', '6.0000', '3.900000', 2, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(759, '886540000300', 'ARGOM AUDIFONO HS525 ROJO', '6.0000', '3.900000', 2, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(760, '798302061736', 'KLIPXTREME EARPHONES KS-105BL CELESTE', '6.0000', '3.900000', 3, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(761, '798302061705', 'KLIPXTREME EARPHONES KS-105BK', '6.0000', '3.900000', 3, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(762, '6925871615563', 'EWTO ET-A1556M ', '5.0000', '1.750000', 2, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(763, '6925871613026', 'EWTO ET-A1302M', '5.0000', '1.750000', 4, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(764, '6925871613293', 'EWTO ET-A1329M', '5.0000', '1.750000', 0, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(765, '742486764608', 'TYPE-C HEADSET XC-PG3', '8.0000', '4.000000', 6, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(766, '6925871610216', 'EWTO ET-A1021M', '12.0000', '8.000000', 2, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(767, '860100201052', 'GALAXY S4 S-JY-01052', '1.5000', '1.000000', 2, 'Tecnología', 0, NULL, NULL, NULL, 2, NULL, NULL, 9),
(768, '311007407884', 'SET DE ESTRELLAS ', '1.7500', '0.800000', 8, 'Navideño', 0, NULL, NULL, NULL, 2, NULL, NULL, 8),
(769, '687536805487', 'BOTAS BLANCAS PEQUEÑAS', '1.0000', '0.600000', 7, 'Navideño', 0, NULL, NULL, NULL, 2, NULL, NULL, 8),
(770, '800550588372', 'COPO DE NIEVE', '1.9500', '1.150000', 7, 'Navideño', 0, NULL, NULL, NULL, 2, NULL, NULL, 8),
(771, '027872314267', 'CHONGA GRNDE NAV', '2.7500', '1.750000', 5, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(772, '850571786084', 'LUZ LED 100 L MULTICOLOR', '6.0000', '3.000000', 2, 'Navideño', 0, NULL, NULL, NULL, 2, NULL, NULL, 8),
(773, '533107183544', 'SET DE CITY CARS', '4.7500', '2.000000', 1, 'Juguetes Niño', 0, NULL, NULL, NULL, 2, NULL, NULL, 10),
(774, '860100201273', 'EARPHONES IG935', '2.0000', '1.000000', 2, 'Tecnología', 0, NULL, NULL, NULL, 2, NULL, NULL, 9),
(775, '6922309812808', 'EARPHONES GALAXY S6', '2.0000', '1.000000', 1, 'Tecnología', 0, NULL, NULL, NULL, 2, NULL, NULL, 9),
(776, '7410063010299', 'RADIOSHACK BT 53017', '18.0000', '12.000000', 3, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(777, '6969699995384', 'EARPHONE TWS LOOGKE', '20.0000', '13.500000', 0, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(778, '632220835125', 'CARTONCILLO BLANCO', '0.6000', '0.300000', 19, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(779, '163241505502', 'PAPEL ESTAÑADO', '1.0000', '0.650000', 23, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(780, '4548759774682', 'STICKER MARIPOSA PEQUEÑA', '1.5000', '0.750000', -1, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(781, '6925871643207', 'EWTO CABLE V8 ET-E4320M-120', '3.0000', '1.750000', 7, 'Tecnología', 0, NULL, NULL, NULL, 2, NULL, NULL, 9),
(782, '757528040444', 'CHIPS SABOR FUEGO 42 G', '0.5000', '0.420000', 0, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(783, '757528013479', 'TAKIS FUEGO 56 G', '0.5000', '0.420000', 0, 'Golocinas', 0, NULL, NULL, NULL, 3, NULL, NULL, 2),
(784, '6925871603614', 'EWTO CABLE TYPE-C ET-E4320C-120', '4.0000', '1.700000', 7, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(785, '371808733380', 'CHONGA MAGICA GRANDE', '0.5000', '0.250000', 17, 'Sin Departamento', 0, NULL, NULL, NULL, 12, NULL, NULL, 7),
(786, '6970088842417', 'QUICK DATA CABLE TYPE C PS003', '4.0000', '2.000000', 4, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(787, '326753312512', 'TRAVEL CHARGER S10 CABLE', '3.0000', '1.500000', 2, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(788, '40000514251', 'SNICKER 52.7 G', '1.2000', '0.750000', 9, 'Golocinas', 0, NULL, NULL, NULL, 3, NULL, NULL, 2),
(789, '40000514480', 'MYMS CHOCOLATE', '1.2000', '0.750000', 11, 'Golocinas', 0, NULL, NULL, NULL, 3, NULL, NULL, 2),
(790, '024474007396', 'FRUTADO 600 ML MANZANA', '0.5000', '0.400000', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(791, '7401005403637', 'DOROSA ESMALTE BLANCO', '0.7500', '0.370000', 4, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(792, '7401005403057', 'DOROSA ESMALTE NATURAL', '0.7500', '0.370000', 2, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(793, '7401005403071', 'DOROSA ESMALTE ROJO', '0.7500', '0.370000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(794, '7401005499265', 'DOROSA ESMALTE ROSA PASTEL', '0.7500', '0.370000', 3, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(795, '7401005497032', 'DOROSA ESMALTE AQUA', '0.7500', '0.370000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(796, '7401005493805', 'DOROSA ESMALTE ROSA CANELA', '0.7500', '0.370000', 2, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(797, '7401005492846', 'DOROSA ESMALTE AZUL ELECTRICO', '0.7500', '0.370000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(798, '7401005460555', 'DOROSA ESMALTE CAFE CLARO', '0.7500', '0.370000', 0, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(799, '7406305000227', 'DOROSA ESMALTE ROSADO', '0.7500', '0.370000', 2, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(800, '7406305002061', 'DOROSA ESMALTE ROSA CON BRILLO', '0.7500', '0.370000', 0, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(801, '7401005403279', 'DOROSA ESMALTE VERDE NEON', '0.7500', '0.370000', 2, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(802, '7401005485503', 'DOROSA ESMALTE DESTELLO', '0.7500', '0.370000', 0, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(803, '7401005403170', 'DOROSA ESMALTE KORA AZUL', '0.7500', '0.370000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(804, '7401005491405', 'DOROSA ESMALTE AMARILLO NEON', '0.7500', '0.370000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(805, '7401005403729', 'DOROSA ESMALTE CHISPITA', '0.7500', '0.370000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(806, '7401005492273', 'DOROSA ESMALTE AZUL METALICO', '0.7500', '0.370000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(807, '7401005496981', 'DOROSA ESMALTE FUCSIA SHINE', '0.7500', '0.370000', 2, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(808, '7401005492082', 'DOROSA ESMALTE ROSADP GLITTER', '0.7500', '0.370000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(809, '7401005492839', 'DOROSA ESMALTE ROSA SALMON', '0.7500', '0.370000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(810, '7401005495915', 'DOROSA ESMALTE FLUORENSCENTE', '0.7500', '0.370000', 2, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(811, '7401005492020', 'DOROSA ESMALTE AZUL CELESTE', '0.7500', '0.370000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(812, '7401005461057', 'DOROSA ESMALTE TEEN SHINE', '0.7500', '0.370000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(813, '7401005403224', 'DOROSA ESMALTE FUCSIA', '0.7500', '0.370000', -1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(814, '7401005493232', 'DOROSA ESMALTE TURQUESA TORNASOL', '0.7500', '0.370000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(815, '226534327440', 'BOTA ADORNO 4 DISEÑOS', '1.5000', '0.750000', 22, 'Navideño', 0, NULL, NULL, NULL, 2, NULL, NULL, 8),
(816, '654433381861', 'HERSHEY BLANCO 27 G', '1.0000', '0.650000', -2, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(817, '7441029515268', 'MARINELA PRINCIPE LIMON 85 G', '0.6000', '0.500000', 4, 'Golocinas', 0, NULL, NULL, NULL, 3, NULL, NULL, 2),
(818, '7411204804463', 'FRUTADO PERA 355ML', '0.2500', '0.200000', 1, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(819, '258378135034', 'TARJETA DE BOLSA CORAZONES', '0.2500', '0.120000', 38, 'Sin Departamento', 0, NULL, NULL, NULL, 12, NULL, NULL, 7),
(820, '362463046800', 'FAROL DE PAPEL COLORES PEQ.', '0.7500', '0.400000', 10, 'Navideño', 0, NULL, NULL, NULL, 2, NULL, NULL, 8),
(821, '046122326508', 'SET DE 4 ESFERAS', '1.5000', '0.750000', 0, 'Navideño', 0, NULL, NULL, NULL, 1, NULL, NULL, 8),
(822, '552682716175', 'SET DE CASCABELES', '2.0000', '1.000000', 17, 'Navideño', 0, NULL, NULL, NULL, 3, NULL, NULL, 8),
(823, '7441163410146', 'POZUELO FAMILIA GALLETAS', '1.7500', '1.200000', 5, 'Golocinas', 0, NULL, NULL, NULL, 3, NULL, NULL, 2),
(824, '036731393715', 'GATORADE 600 ML LIMA', '1.0000', '0.650000', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(825, '721282300540', 'LAYS QUESO MAX 80 G', '1.3500', '0.910000', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(826, '74000685', 'MARINELA PINGUINOS 80 G', '1.0000', '0.840000', 3, 'Golocinas', 0, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(827, '74001187', 'MARINELA DALMATA', '0.5500', '0.460000', 1, 'Golocinas', 0, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(828, '036731393692', 'GATORADE NARANJA 600 ML', '1.0000', '0.500000', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(829, '74000708', 'GANSITO', '0.5500', '0.460000', -3, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(830, '7441029502107', 'MARINELA CHOCO CHISPAS', '0.3500', '0.170000', 8, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(831, '7441029516951', 'MARINELA SPONCH SMORE 90 G', '0.6000', '0.490000', 2, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(832, '74001200', 'MARINELA SPONCH FRESA', '0.6000', '0.490000', 0, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 1),
(833, '7702011084170', 'GRISSLY GOMAS YOGURT', '0.6500', '0.500000', 0, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(834, '074323078879', 'RICOLINO PALETA PAYASO', '0.5000', '0.400000', 6, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(835, '7441029515961', 'BIMBO NITO 39 G', '0.3500', '0.250000', 7, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(836, '757528022563', 'RICOLINO PANDITAS ROJOS', '0.6000', '0.500000', 1, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(837, '757528028541', 'RICOLINO GOMILOCAS DIENTES 70 G', '0.6000', '0.500000', 0, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(838, '537272060636', 'OSOS DE PELUCHE MEDIANO ', '10.0000', '5.000000', 5, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(839, '6955271222696', 'BOLSA DE REGALO XS', '0.5000', '0.350000', 19, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(840, '7441029506181', 'MARINELA PRINCIPE CHOCO BLANCO 85 G', '0.6000', '0.460000', 6, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(841, '7441029520132', 'MARINELA PRINCIPE FRESA 85 G', '0.6000', '0.500000', 3, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(842, '7441029504613', 'MARINELA PRINCIPE CHOCOLATE 85 G', '0.6000', '0.460000', 7, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(843, '7441029518276', 'MARINELA PLATIVOLOS 94 G', '0.5000', '0.330000', 1, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(844, '74000661', 'MARINELA SUBMARINOS 64 G', '0.6000', '0.500000', 5, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(845, '086581110888', 'GALLETA CHICKY 40 G', '0.2500', '0.200000', 4, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(846, '040000514251', 'BARRA SNICKERS 52.7 G', '1.2000', '0.750000', 29, 'Golocinas', 0, NULL, NULL, NULL, 12, NULL, NULL, 2),
(847, '04010508', 'BARRA SNICKERS ALMOND 49.9 G', '1.2000', '0.750000', 31, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(848, '022000018489', 'SKITTLES WILD BERRY', '1.2000', '0.750000', 8, 'Golocinas', 0, NULL, NULL, NULL, 6, NULL, NULL, 2),
(849, '022000018465', 'SKITTLES ORIGINAL', '1.2000', '0.750000', 32, 'Golocinas', 0, NULL, NULL, NULL, 3, NULL, NULL, 2),
(850, '7506174502645', 'BARRA SNICKERS 21.5 G', '0.5000', '0.350000', 140, 'Golocinas', 0, NULL, NULL, NULL, 24, NULL, NULL, 2),
(851, '040000422068', 'BARRA MILKYWAY 52.2 G', '1.2000', '0.750000', 33, 'Golocinas', 0, NULL, NULL, NULL, 12, NULL, NULL, 2),
(852, '040000002376', 'MYMS MINIS TUBO', '1.2000', '0.750000', 0, 'Golocinas', 0, NULL, NULL, NULL, 12, NULL, NULL, 2),
(853, '040000514510', 'MYMS PEANUT', '1.2000', '0.750000', 45, 'Golocinas', 0, NULL, NULL, NULL, 12, NULL, NULL, 2),
(854, '040000514480', 'MYMS MILK CHOCOLATE', '1.2000', '0.750000', 43, 'Golocinas', 0, NULL, NULL, NULL, 12, NULL, NULL, 2),
(855, '022000018779', 'PEPPERMINT COBALT ', '2.2500', '1.350000', 8, 'Golocinas', 0, NULL, NULL, NULL, 3, NULL, NULL, 2),
(856, '022000116390', 'MENTA VERDE VIDRANTE RAIN', '2.2500', '1.350000', 1, 'Golocinas', 0, NULL, NULL, NULL, 3, NULL, NULL, 2),
(857, '02289902', 'EXTRA SPEARMINT LONG LASTING', '2.2500', '1.350000', 1, 'Golocinas', 0, NULL, NULL, NULL, 3, NULL, NULL, 2),
(858, '02283801', 'EXTRA SWEET WATERMELON', '2.2500', '1.350000', 12, 'Golocinas', 0, NULL, NULL, NULL, 3, NULL, NULL, 2),
(859, '02217808', 'WINTERFRESH', '0.4500', '0.225000', 72, 'Golocinas', 0, NULL, NULL, NULL, 12, NULL, NULL, 2),
(860, '02217109', 'SPEARMINT ', '0.4500', '0.225000', 16, 'Golocinas', 0, NULL, NULL, NULL, 12, NULL, NULL, 2),
(861, '02217206', 'DOUBLEMINT', '0.4500', '0.225000', 47, 'Golocinas', 0, NULL, NULL, NULL, 12, NULL, NULL, 2),
(862, '02217303', 'JUICY FRUIT', '0.4500', '0.225000', 3, 'Golocinas', 0, NULL, NULL, NULL, 6, NULL, NULL, 2),
(863, '040000464082', 'SNICKERS FUN SIZE 6 PACK', '2.5000', '1.484800', 0, 'Golocinas', 0, NULL, NULL, NULL, 3, NULL, NULL, 2),
(864, '034000249862', 'BARRA HERSHEY MILK CHOCOLATE 43 G', '1.3500', '0.910000', 20, 'Golocinas', 0, NULL, NULL, NULL, 12, NULL, NULL, 2),
(865, '03424102', 'BARRA HERSHEY ALMONDS 41 G', '1.3500', '0.910000', 3, 'Golocinas', 0, NULL, NULL, NULL, 12, NULL, NULL, 2),
(866, '03423909', 'BARRA HERSHEY COOCKIS N CREME 43 G', '1.3500', '0.910000', 12, 'Golocinas', 0, NULL, NULL, NULL, 6, NULL, NULL, 2),
(867, '034000241330', 'BARRA HERSHEY WHITE ALMONDS 41 G', '1.3500', '0.910000', 5, 'Golocinas', 0, NULL, NULL, NULL, 6, NULL, NULL, 2),
(868, '7501024514946', 'BARRA HERSHEY COOCKIES N CREME 27 G', '1.0000', '0.450000', 23, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(869, '7501024595594', 'BARRA HERSHEY MILK CHOCOLATE 27 G', '1.0000', '0.450000', 42, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(870, '6942836720605', 'BARRA HERSHEY MILK CHOCOLATE 15 G', '0.4000', '0.260000', 51, 'Golocinas', 0, NULL, NULL, NULL, 12, NULL, NULL, 2),
(871, '6942836712228', 'BARRA HERSHEY COOCKIES N CREME 15 G', '0.4000', '0.260000', 23, 'Golocinas', 0, NULL, NULL, NULL, 12, NULL, NULL, 2),
(872, '866421374367', 'HERSHEY KISSES 50 UNIDADES', '4.7500', '2.248700', 2, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(873, '677613627626', 'HERSHEY KISSES BLANCO 50 UNIDADES', '4.7500', '2.248700', 2, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(874, '477625110763', 'HERSHEY KISSES UNITARIO', '0.1000', '0.045000', 125, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(875, '787830011543', 'HERSHEY KISSES BLANCO UNITARIO', '0.1000', '0.045000', 24, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(876, '838100025720', 'BOLSA NUGGETS 30 UNIDADES', '5.9000', '3.900000', 2, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(877, '405064836634', 'HERSHEY MINIATURA BOLSA 30 U.', '5.9000', '3.900000', 4, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(878, '401167032711', 'HERSHEY MINIATURA UNITARIO', '0.2500', '0.130000', 76, 'Golocinas', 0, NULL, NULL, NULL, 12, NULL, NULL, 2),
(879, '036731001757', 'GATORADE 350MLFRUIT PUNCH', '0.6000', '0.490000', 3, NULL, 0, NULL, NULL, NULL, 2, NULL, NULL, 1),
(880, '036731001733', 'GATORADE 350ML UVA', '0.6000', '0.490000', 2, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(881, '036731001740', 'GATORADE 350ML NARANJA', '0.6000', '0.490000', 0, 'Golocinas', 0, NULL, NULL, NULL, NULL, 3, NULL, 2),
(882, '036731001764', 'GATORADE 350MLLEMON LIME', '0.6000', '0.490000', 5, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(883, '202050585340', 'AGENDA A4', '7.7500', '5.750000', 3, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(884, '747786861108', 'AGENDA ESQUINA DORADA 2022', '4.5000', '3.500000', 1, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 1),
(885, '574403634045', 'AGENDA LARGA 2022', '3.0000', '1.750000', 13, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(886, '728518112342', 'accesorios varios', '1.0000', '0.650000', 1000, 'Sin Departamento', 0, NULL, NULL, NULL, NULL, 3, NULL, 7),
(887, '735058838116', 'ACCESORIOS B', '0.5000', '0.250000', 100, 'Sin Departamento', 0, NULL, NULL, NULL, 10, NULL, NULL, 7),
(888, '7401005988592', 'AQUA ECO PEPSI 750ML', '0.5000', '0.400000', 17, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(889, '036731393685', 'GATORADE FRUIT PUNCH 600 ML', '1.0000', '0.800000', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(890, '036731393708', 'GATORADE UVA 600 ML', '1.0000', '0.800000', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(891, '036731002495', 'GATORADE BERRY BLUE', '1.0000', '0.800000', 0, 'Golocinas', 0, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(892, '024474007433', 'SQUIZ JUGO PETIT 600 ML', '0.5000', '0.400000', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(893, '024474007402', 'FRUTADO PERA 600 ML', '0.5000', '0.400000', 0, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(894, '024474007426', 'FRUTADO FRUIT PUNCH 600ML', '0.5000', '0.400000', 1, NULL, 0, NULL, NULL, NULL, 2, NULL, NULL, 1),
(895, '024474007389', 'FRUTADO UVA 600 ML', '0.5000', '0.400000', 5, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(896, '024474007419', 'FRUTADO DURAZNO', '0.5000', '0.400000', 2, NULL, 0, NULL, NULL, NULL, 2, NULL, NULL, 1),
(897, '7401005910180', 'LIPTON DURAZNO 500ML', '1.0000', '0.800000', -5, 'Golocinas', 0, NULL, NULL, NULL, 3, NULL, NULL, 2),
(898, '7401005910173', 'LIPTON LIMON 500ML', '1.0000', '0.800000', 0, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(899, '7401005910197', 'LIPTON FRANMBUESA', '1.0000', '0.800000', -1, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(900, '7401005988813', 'PEPSI 355ML ', '0.5000', '0.350000', 5, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(901, '7411204804456', 'FRUTADO MANZANA 355ML', '0.2500', '0.200000', 14, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(902, '7401005904035', 'SEVEN UP LATA 355 ML', '0.6000', '0.490000', 3, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(903, '7401005904011', 'PEPSI LATA 355 ML', '0.6000', '0.490000', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(904, '7401005904110', 'MIRINDA NARANJA LATA 355 ML', '0.6000', '0.490000', 2, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(905, '6871719328358', 'MAGUERA MULTICOLOR LED 5 M', '12.0000', '6.200000', 13, 'Navideño', 0, NULL, NULL, NULL, 3, NULL, NULL, 8),
(906, '786273729588', 'AGUA EN BOLSA OASIS', '0.1500', '0.080000', 1, 'Golocinas', 0, NULL, NULL, NULL, 3, NULL, NULL, 2),
(907, '032014511313', 'BARRA DE SILICON', '0.3000', '0.150000', -3, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(908, '873080884380', 'DIADEMA PERLAS', '2.5000', '1.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(909, '614108660327', 'PLIEGO CELOFAN DECORADO 70X100', '0.4000', '0.120000', 68, 'FIESTA', 0, NULL, NULL, NULL, 12, NULL, NULL, 6),
(910, '6952525800822', 'TALBOT CALCULADORA CIENTIF TK82', '5.2500', '2.610300', 5, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(911, '4006381118002', 'STABILO OTHELLO 282 2H', '0.6000', '0.271200', 24, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(912, '8595147804380', 'STABILO OTHELLO 282 5H', '0.6000', '0.271200', 11, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(913, '4006381117890', 'STABILO OTHELLO 282 H', '0.6000', '0.271200', 34, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(914, '4006381118033', 'STABILO OTHELLO 282 3B', '0.6000', '0.271200', 23, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(915, '4006381118095', 'STABILO OTHELLO 282 4B', '0.6000', '0.271200', 20, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(916, '8595147804038', 'STABILO OTHELLO 282 7B', '0.6000', '0.271200', 23, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(917, '4006381117944', 'STABILO OTHELLO 282 HB', '0.6000', '0.271200', 79, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(918, '8595147804045', 'STABILO OTHELLO 282 8B', '0.6000', '0.271200', 20, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(919, '4006381118125', 'STABILO OTHELLO 282 4H', '0.6000', '0.271200', 23, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(920, '4006381170314', 'STABILO OTHELLO 282 5B', '0.6000', '0.271200', 10, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(921, '4006381117975', 'STABILO OTHELLO 282 2B', '0.6000', '0.271200', 84, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(922, '4006381117876', 'STABILO OTHELLO 282 F', '0.6000', '0.271200', 23, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(923, '4006381117852', 'STABILO OTHELLO 282 B', '0.6000', '0.271200', 23, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(924, '4006381170321', 'STABILO OTHELLO 282 6B', '0.6000', '0.271200', 23, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(925, '4006381118064', 'STABILO OTHELLO 282 3H', '0.6000', '0.271200', 24, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(926, '190199040670', 'IPHONE USB-C POWER ADAPTER', '15.0000', '9.250000', 5, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(927, '885909627363', 'IPHONE LIGHTING USB ADAPTER', '10.0000', '6.250000', 3, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(928, '885909627424', 'IPHONE LIGHTING TO USB CABLE', '8.0000', '4.000000', 2, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(929, '8806086511162', 'SAMSUNG TRAVEL ADAPTER ', '8.0000', '4.000000', 2, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(930, '6925871643498', 'ET-A4349B EXTRA BASS', '20.0000', '12.500000', 3, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(931, '6925871646987', 'ET-A4698B SUPER BASS', '20.0000', '11.300000', 2, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(932, '757085465257', 'INPODS 12 SIMPLE', '15.0000', '9.000000', 1, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(933, '455732828625', 'AIRBUDS', '18.0000', '12.000000', 0, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(934, '6999881518183', 'HEADSET 150 CM', '5.0000', '2.500000', 0, 'Tecnología', 0, NULL, NULL, NULL, 0, NULL, NULL, 9),
(935, '6925871628303', 'BATERIA PORTATIL ET-E2830', '18.0000', '7.680000', 3, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(936, '6925871603027', 'CARGADOR CARRO 3.8A V8', '5.0000', '2.500000', 3, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(937, '862797101001', 'MOBILE OTG CONNECT KIT V8', '3.0000', '1.500000', 12, 'Tecnología', 0, NULL, NULL, NULL, 3, NULL, NULL, 9),
(938, '862797101031', 'OTG USB FLASH DRIVER TYPE-C', '5.0000', '2.500000', 8, 'Tecnología', 0, NULL, NULL, NULL, 2, NULL, NULL, 9),
(939, '862797101019', 'MICRO SD CARD READER', '2.5000', '1.250000', 2, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(940, '748367742486', 'CABLE AUX. DE 1 A 1', '2.5000', '1.250000', 1, 'Tecnología', 0, NULL, NULL, NULL, 3, NULL, NULL, 9),
(941, '810427184424', 'CABLE AUX. DE 2 A 1 AZUL', '2.5000', '1.250000', 2, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(942, '505578332654', 'CABLE AUX. DE 2 A 1 NEGRO', '2.5000', '1.250000', 4, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(943, '886540002724', 'ARGOM 2.5 ENCLOUSER HARD DRIVE', '12.0000', '6.850000', 3, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(944, '798302165021', 'MOUSE XTM175', '8.0000', '5.800000', 1, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(945, '6912316510002', 'LCD CHARGER UNIVERSAL TRALVEL', '3.0000', '1.500000', 1, 'Tecnología', 0, NULL, NULL, NULL, 0, NULL, NULL, 9),
(946, '8518383484550', 'SWAT LAMP 98455', '12.0000', '7.650000', 1, 'Tecnología', 0, NULL, NULL, NULL, 0, NULL, NULL, 9),
(947, '230734313143', 'LINTERNA LUZ FUERTE ET-F8908', '7.0000', '3.500000', 1, 'Tecnología', 0, NULL, NULL, NULL, 0, NULL, NULL, 9),
(948, '646611283808', 'LAMPARA HJ-998', '0.5000', '0.250000', 1, 'Tecnología', 0, NULL, NULL, NULL, 0, NULL, NULL, 9),
(949, '5642265494313', 'LAMPARA AYT-3288', '2.7500', '1.250000', 2, 'Tecnología', 0, 'COLOR NARANJA', NULL, NULL, 0, NULL, NULL, 9),
(950, '6992550445148', 'LAMPARA JOYSOURCE YG-2017', '2.0000', '0.850000', 1, 'Tecnología', 0, NULL, NULL, NULL, 0, NULL, NULL, 9),
(951, '922267489193', 'HIGH SPEED CABLE', '1.5000', '0.450000', 19, 'Tecnología', 0, NULL, NULL, NULL, 3, NULL, NULL, 9),
(952, '475628875651', 'CABLE ECONOMICO V8', '1.5000', '0.450000', 1, 'Tecnología', 0, NULL, NULL, NULL, 0, NULL, NULL, 9),
(953, '7411512410141', 'TREB FOCO INTELIGENTE B. TOOTH', '15.0000', '7.800000', 2, 'Tecnología', 0, NULL, NULL, NULL, 0, NULL, NULL, 9),
(954, '585781261360', 'CABLE PARA IPHONE ', '10.0000', '6.000000', 2, 'Tecnología', 0, NULL, NULL, NULL, 0, NULL, NULL, 9),
(955, '8716309083836', 'ETOUCH CABLE HDMI 15 PIES', '9.0000', '6.900000', 3, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(956, '860100201550', 'CABLE AUX. 3.5 CAJA', '2.5000', '1.250000', 1, 'Tecnología', 0, NULL, NULL, NULL, 0, NULL, NULL, 9),
(957, '7506240606987', 'LUZ DE NOCHE VOLTECK KIDS', '2.5000', '1.250000', 1, 'Tecnología', 0, NULL, NULL, NULL, 0, NULL, NULL, 9),
(958, '574070047377', 'BOMBA MANUAL VEJIGA', '2.0000', '1.250000', 4, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(959, '7593980016831', 'LISTON MAYA 3 YRDS', '2.9500', '1.750000', 5, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(960, '031244477033', 'BASE PARA GLOBO CON LUZ', '5.7500', '3.500000', 2, 'FIESTA', 0, NULL, NULL, NULL, 2, NULL, NULL, 6),
(961, '330845173721', 'ARBOL 90 CM LAVAPACHA', '16.0000', '9.000000', 1, 'Navideño', 0, NULL, NULL, NULL, 0, NULL, NULL, 8),
(962, '200451562352', 'ARBOL BLANCO LAVAPACHA 150 CM', '35.0000', '28.000000', 3, 'Navideño', 0, NULL, NULL, NULL, 0, NULL, NULL, 8),
(963, '721282300526', 'LAYS ORIGINAL 80 G', '1.3500', '0.910000', 7, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(964, '721282300793', 'FIESTA SNAX 80 G', '1.3500', '0.910000', 1, NULL, 0, NULL, NULL, NULL, 2, NULL, NULL, 1),
(965, '721282300397', 'DORITOS NACHO ATREVIDO', '1.2500', '0.910000', 4, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(966, '721282300434', 'DORITOS QUESO ACELERADO 150 G', '1.2500', '0.910000', 3, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(967, '721282301042', 'CHETOS HORNEADOS 80 G', '1.0000', '0.780000', 2, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(968, '721282301059', 'CHEETOS CRUNCHY EXTRA QUESO 120 G', '1.0000', '0.780000', -1, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(969, '721282202738', 'LAYS ORIGINAL 26 G', '0.5000', '0.390000', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(970, '842730405548', 'PAPEL DE REGALO BODA', '0.3500', '0.150000', 10, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 6, NULL, NULL, 13),
(971, '315856510156', 'TARJETA PARA REGLAO', '0.1500', '0.070000', 44, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 3, NULL, NULL, 13),
(972, '264677736456', 'CHONGA DE REGALO MAGICA', '0.5000', '0.250000', 76, 'FIESTA', 0, NULL, NULL, NULL, 12, NULL, NULL, 6),
(973, '721282202370', 'LAYS BARBACOA AMERI 26 G', '0.5000', '0.260000', 1, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(974, '4260000003005', 'BOLSA GLOBO DECORADO', '2.0000', '1.000000', -1, 'FIESTA', 0, NULL, NULL, NULL, 2, NULL, NULL, 6),
(975, '244744511583', 'GLOBO NUMERO #32', '1.7500', '0.875000', 12, 'FIESTA', 0, NULL, NULL, NULL, 2, NULL, NULL, 6),
(976, '648713871161', 'ABRO CINTA DOBLE CARA BLANCA', '1.5000', '0.900000', 4, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(977, '888325418653', 'PAPEL CELOFAN AZUL', '0.5000', '0.250000', 3, 'FIESTA', 0, NULL, NULL, NULL, 2, NULL, NULL, 6),
(978, '013573532567', 'FOMY DECO ', '1.0000', '0.750000', 0, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(979, '038866226400', 'TABLOIDE DIVERSOS ', '1.5000', '0.600000', 99, 'Escolar', 0, NULL, NULL, NULL, 20, NULL, NULL, 3),
(980, '260000788784', 'GLOBO PALMERITO AZUL 100U', '3.9000', '2.560000', -1, 'FIESTA', 0, NULL, NULL, NULL, NULL, NULL, NULL, 6),
(981, '335338647503', 'VEJIGA BLANCA BANDERA', '5.8000', '2.300000', 1, 'FIESTA', 0, NULL, NULL, NULL, 0, NULL, NULL, 6),
(982, '721282203964', 'LAYS MAX QUESO 26G', '0.5000', '0.330000', 0, 'Sin Departamento', 0, NULL, NULL, NULL, 2, NULL, NULL, 7),
(983, '721282203971', 'LAYS MAX ESPECIAS 26 G', '0.5000', '0.330000', -3, 'Sin Departamento', 0, NULL, NULL, NULL, NULL, NULL, NULL, 7),
(984, '721282402336', 'CHEETOS CRUNCHY EXTRA QUESO 28 G', '0.2500', '0.200000', 3, 'Sin Departamento', 0, NULL, NULL, NULL, NULL, NULL, NULL, 7),
(985, '721282303725', 'CHEETOS HORNEADOS POFFS QUESO', '0.2500', '0.200000', 4, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(986, '721282202745', 'FIESTA SNAX', '0.5000', '0.400000', 1, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(987, '721282403593', 'DORITOS QUESO ACELERADO 24G', '0.2500', '0.200000', 10, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(988, '721282403579', 'DORITOS NACHO ATREVIDO 24G', '0.2500', '0.200000', 2, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(989, '721282405368', 'NATUCHIPS 19G', '0.2500', '0.200000', 8, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(990, '4717480701872', 'FAST SUPRA P-10 PERFORADOR', '2.2500', '1.770000', 12, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(991, '7453015153200', 'ENGRAPADORA STUDMARK FULL STRIP STAPLER TIRA COM', '3.9500', '3.040000', 12, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(992, '768497212039', 'FACELA 12 LAPIZ DE COLOR LARGO', '2.9500', '1.880000', 2, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(993, '466806886311', 'CORTINA DE CUMPLEAÑOS P Y D', '3.0000', '1.500000', 13, 'FIESTA', 0, NULL, NULL, NULL, 2, NULL, NULL, 6),
(994, '814351284214', 'LETRAS FELIZ CUMPLEAÑOS', '2.0000', '1.000000', 19, 'FIESTA', 0, NULL, NULL, NULL, 2, NULL, NULL, 6),
(995, '768497512719', 'FACELA BORRADOR GRANDE ', '0.3000', '0.250000', 56, 'Escolar', 0, NULL, NULL, NULL, 10, NULL, NULL, 3),
(996, '7501014511030', 'CAJA BIC CRISTAL CLASICO ROJO', '2.2500', '1.550000', 13, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(997, '7501014511023', 'CAJA BIC CRISTAL CLASICO NEGRO', '2.2500', '1.550000', 12, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(998, '7501014511016', 'CAJA BIC CRISTAL CLASICO AZUL', '2.2500', '1.550000', 8, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(999, '4712914156952', 'PERFORADOR SUPRA P-25', '4.8500', '3.730000', 7, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1000, '7453015116632', 'CUCHILLA STUDMARK 9MM ST-4102', '0.5000', '0.270000', 25, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(1001, '4710887411184', 'TIJERA ESCOLAR FAST 5 CM', '0.4500', '0.260000', 34, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(1002, '809861200013', 'PAPEL DE REGALO NAVIDEÑO ECO', '0.3500', '0.180000', 321, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1003, '4710887401987', 'NOKY CAJA FASTENER PLASTICOS COLOR', '2.0000', '1.020000', 5, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1004, '7503002923160', 'FAST LAPIZ DE COLOR TRIANGULAR 12U.', '1.4500', '0.950000', 23, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1005, '7503002923146', 'FAST LAPIZ DE COLOR CORTO TRIANG.', '0.7000', '0.470000', 23, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(1006, '4711213849190', 'FAST MINI ENGRAPADOR ', '1.0000', '0.620000', 23, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(1007, '768497166516', 'GRAPAS STANDAR FACELA ', '1.5000', '0.900000', 16, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(1008, '768497121027', 'CAJA DE LAPIZ FACELA 144 U', '18.9500', '11.830000', 6, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(1009, '554830364245', 'BOLSA REGALO SEMI MED. HOMBRE', '1.5000', '0.800000', 11, 'BOLSAS', 0, NULL, NULL, NULL, 2, NULL, NULL, 14),
(1010, '460742651861', 'PAPEL DE REGALO INFANTIL', '0.3500', '0.175000', 54, 'FIESTA', 0, NULL, NULL, NULL, 12, NULL, NULL, 6),
(1011, '388106406670', 'SET DE ESFERAS 6 CM TUBO', '5.5000', '2.750000', 7, 'Navideño', 0, NULL, NULL, NULL, 2, NULL, NULL, 8),
(1012, '7450008485737', 'ETIQUETAS ESCOLARES MERLETTO 12U', '2.2500', '1.760000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1013, '631881116315', 'PEGA PARA UÑA', '1.2500', '0.900000', 8, 'Accesorios de Mujer', 0, 'PROFESSIONAL NAIL GLUE', NULL, NULL, 1, NULL, NULL, 11),
(1014, '7450008117041', 'ETIQUETAS ESCOLARES', '2.5000', '1.760000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1015, '768497347120', 'COMPAS CON LAIPZ FACELA ECONOMICO', '0.7000', '0.470000', NULL, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1016, '768497347137', 'FACELA COMPAS NUEVO DISENO', '1.0000', '0.650000', 10, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1017, '7450008488097', 'SELLOS MERLETTO DISEÑOS', '0.6000', '0.290000', 44, NULL, 0, NULL, NULL, NULL, 12, NULL, NULL, 1),
(1018, '7417200604076', 'PLUMONES PARROT ECONO', '1.5000', '0.950000', 17, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1019, '7417200604021', 'PARROT LAPIZ DE COLOR CORTO 12U.', '0.7500', '0.530000', 24, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1020, '7453015108187', 'STUDMARK STICK NOTES 1.5X2', '1.5000', '0.860000', 17, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1021, '7453010064822', 'CINTA ADHESIVA DEVORATIVA TORNASOL POINTER', '0.9500', '0.570000', 23, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1022, '7453078530857', 'CINTA ADHESIVA DECORATIVA POINTER SURTIDO', '0.9500', '0.550000', 11, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(1023, '7453038460187', 'POINTER BORRADOR BRILLANTINA ', '0.6000', '0.400000', 36, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(1024, '7506129454937', 'SCRIBE PROTECT OUR HOME ECO', '4.9500', '3.190000', 0, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1025, '7506129454890', 'SCRIBE SPIRAL MAGIC IS REAL UNICORN', '5.1000', '3.680000', 3, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1026, '7506129454111', 'SCRIBE SPIRAL BLACK 200 PGS', '5.1000', '3.680000', 3, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1027, '7506129454982', 'SCRIBE COSIDO HAPPY MAGICAL 200 PGS', '3.7500', '2.510000', 5, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1028, '7506129454180', 'SCRIBE COSIDO LI SUNSH INCOLOR 200 PGS', '6.4000', '4.290000', 5, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1029, '7506129451233', 'SCRIBE CSIDO LOLSURPRISE 200 PGS', '4.7500', '2.950000', 0, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1030, '7506129443764', 'SCRIBE CSIDO RAY SPIDERMAN 200 P', '3.7500', '2.330000', 0, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1031, '7506129443788', 'SCRIBE CSIDO CUAD. OSCORP IND. 200 PAGS', '3.7500', '2.330000', 0, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1032, '7506129436704', 'SCRIBE COS RAY AVENGERS 200 PAGS', '4.7560', '2.890000', NULL, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1033, '7702111285705', 'NORMA CUAD RAY KIUT SPIRAL 80H PD', '6.9000', '4.840000', 16, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(1034, '813632824438', 'SOBRE DECORADO ECO', '0.2500', '0.125000', -67, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1035, '654444054145', 'BINCHA PARA PELO Y CARTERA', '2.0000', '1.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 3, NULL, NULL, 11),
(1036, '754245866440', 'SET COLAS ', '1.2500', '0.650000', -4, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(1037, '7450008484945', 'SELLO DECORADO DIDACTICO', '0.5000', '0.260000', 71, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(1038, '016208700087', 'DIADEMAS DECORADAS', '1.5000', '1.000000', 17, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 5, NULL, NULL, 11),
(1039, '222243784476', 'VINCHAS PELO ', '1.5000', '1.000000', 15, 'Accesorios de Mujer', 0, NULL, NULL, NULL, NULL, NULL, NULL, 11),
(1040, '833256684420', 'COLETAS/ COLAS ', '1.5000', '1.000000', 15, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(1041, '608235718522', 'COLAS ECONOMICAS ', '0.2500', '0.125000', 11, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(1042, '406146704661', 'GANCHO METALICO', '2.5000', '1.250000', 10, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 3, NULL, NULL, 11),
(1043, '618710231022', 'GANCHO ECONOMICO GRANDE', '1.5000', '1.000000', 8, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(1044, '082353010189', 'LAPIZ DE OJO ITALIA ', '0.7500', '0.500000', 0, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1045, '104186534566', 'BOLSA DE REGALO CERO ', '0.4000', '0.220000', 26, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1046, '7416600990031', 'BOLSA DE REGALO S ROSA ', '1.0000', '0.650000', 1, 'BOLSAS', 0, NULL, NULL, NULL, 0, NULL, NULL, 14),
(1047, '7416600990024', 'BOLSA DE REGALO S # 2', '0.7500', '0.600000', -2, 'BOLSAS', 0, NULL, NULL, NULL, 0, NULL, NULL, 14),
(1048, '580272350242', 'SET DE GANCHOS PARA NIÑA', '1.5000', '1.000000', 6, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1049, '052100080', 'KML ', '7.0000', '3.500000', 0, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1050, '102100061', 'KML CORAZON FLECHADOS', '11.0000', '5.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1051, '062100261', 'KML DELFINES', '9.0000', '4.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(1052, '172768708512', 'SOBRE PREMIUNDE REALO', '1.2500', '0.650000', 20, 'FIESTA', 0, NULL, NULL, NULL, 10, NULL, NULL, 6),
(1053, '082000662', 'KML CADENA ESTRELLA', '18.0000', '9.000000', 2, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1054, '072100318', 'KML LLAVES', '11.0000', '5.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1055, '072100419', 'KML FLOR EN CIRCULO', '5.0000', '2.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1056, '022100065', 'KML SET LUNA', '8.0000', '4.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1057, '375380115174', 'MASCARILLA NIÑO INDIVIDUAL 2X1', '0.2500', '0.125000', 48, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 3, NULL, NULL, 13),
(1058, '022100064', 'KML ESTRELLAS', '8.0000', '4.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1059, '092021006', 'KML SET CIRCULOS DORADAS', '5.0000', '2.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1060, '102100067', 'KML SET DE DELFINES DORADAS', '7.0000', '3.500000', 1, 'Sin Departamento', 0, NULL, NULL, NULL, 1, NULL, NULL, 7),
(1061, '022100069', 'KML SET CORAZONES ACERO', '8.0000', '4.000000', 1, 'Sin Departamento', 0, NULL, NULL, NULL, 1, NULL, NULL, 7),
(1062, '092021011', 'KML SET DE MARIPOSAS DORADAS', '5.0000', '2.500000', 1, 'Sin Departamento', 0, NULL, NULL, NULL, 1, NULL, NULL, 7),
(1063, '092021007', 'KML SET ELAFANTE PALTEADO', '5.0000', '2.500000', 1, 'Sin Departamento', 0, NULL, NULL, NULL, 1, NULL, NULL, 7),
(1064, '102000564', 'KML SET DE CIRCULOS ARCOIRIS ', '12.0000', '6.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1065, '022100066', 'KML SET DE CACTUS ', '8.0000', '4.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1066, '052100030', 'KML SET DE KITTY ', '5.0000', '2.500000', NULL, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1067, '092021008', 'KML SET CORAZON DORADO ', '5.0000', '2.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1068, '072100317', 'KML SET LUNA DORADA', '11.0000', '5.500000', NULL, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1069, '062100279', 'KML SET DE LLAVES DORADAS', '11.0000', '5.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1070, '082100111', 'KML ARITOS TORNASOL', '2.0000', '1.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1071, '092021036', 'KML ARITOS COLORES ', '2.0000', '1.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1072, '082100109', 'KML ARITOS PERLA TORNASOL', '2.0000', '1.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1073, '164238005561', 'KML ARITOS SOL ACERO', '4.0000', '2.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1074, '092021037', 'KML ARITOS TRIANGULARES ', '2.0000', '1.000000', NULL, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1075, '022100108', 'KML ARITOS PLATEADOS REDONDOS ', '4.0000', '2.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1076, '072100468', 'KML ARITOS CARDIO ', '2.0000', '1.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1077, '102100072', 'KML ARITOS CORAZON MORADO', '3.0000', '1.500000', 0, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1078, '102000573', 'KML PULSERA ELEFANTE ', '11.0000', '5.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1079, '026751387007', 'KML CADENA DE FLOR DORADA', '6.0000', '3.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1080, '072100342', 'KML TOBILLAS LIBELULA ', '5.0000', '2.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1081, '052100263', 'KML TOBILLERA ESTRELLA Y FLOR', '5.0000', '2.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1082, '052100264', 'KML TOBILLERA LIBELULA Y ESTRELLA', '5.0000', '2.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1083, '082100101', 'KML ARGOLLA PLATEADA ', '4.0000', '2.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1084, '102100079', 'KML ARGOLLA PLATEADA PLANA', '2.0000', '1.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1085, '20\'388', 'COCHE PLASTICO ECO', '6.0000', '3.000000', 4, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1086, '093905293233', 'BEBE HORA DE DORMIR', '20.0000', '10.000000', 2, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 1),
(1087, '064314725376', 'CAMAPANAS NAVIDEÑAS GRANDES', '2.2500', '1.125000', 3, 'Juguetes Niño', 0, NULL, NULL, NULL, 1, NULL, NULL, 10),
(1088, '243017251524', 'LLAVERO COLA DE CONEJO', '0.7500', '0.375000', 1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 2, NULL, NULL, 13),
(1089, '7502211251996', 'BOLSA BEJIGA FUCSIA CLARO', '3.7500', '1.875000', 0, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(1090, '578174331445', 'SOBRE DECORADO', '1.2500', '0.625000', 24, 'FIESTA', 0, NULL, NULL, NULL, 2, NULL, NULL, 6),
(1091, '823077141577', 'BOLSA DE VEJIGA SUTIDA 100 U', '3.9000', '1.950000', -1, 'FIESTA', 0, NULL, NULL, NULL, 2, NULL, NULL, 6),
(1092, '157742078370', 'BOMBA PARA INFLAR ', '2.0000', '1.000000', NULL, 'FIESTA', 0, NULL, NULL, NULL, 4, NULL, NULL, 6),
(1093, '072100443', 'KML ARGOLLA DORADA', '4.0000', '2.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1094, '092021044', 'KML ARITOS REDONDOS DORADOS', '3.0000', '1.500000', 2, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1095, '072100434', 'KML ARGOLLA PLANA ACERO', '3.0000', '1.500000', NULL, 'Accesorios de Mujer', 0, NULL, NULL, NULL, NULL, NULL, NULL, 11),
(1096, '092021038', 'KML ARITOS TREBOL DORADOS', '2.0000', '1.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1097, '062100419', 'KML ARGOLLA ESTRELLA DORADA', '5.0000', '2.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, NULL, 1, NULL, 11),
(1098, '072100516', 'KML ARITOS BICOLOR ', '7.0000', '3.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1099, '102100085', 'KML ARGOLLAS BICOLOR PLANA', '4.0000', '2.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1100, '082100113', 'KML ARITOS FLOR PUNTA', '2.0000', '1.000000', 0, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1101, '072100453', 'KML ARITOS ESTRELLAS DORADAS', '2.0000', '1.000000', 2, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1102, '062100412', 'KML ARGOLLA LARGA PLANA GOTA', '4.0000', '2.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1103, '082100110', 'KML OSITOS DORADOS ', '2.0000', '1.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1104, '092021043', 'KML ARITOS ACCE PERLA ', '3.0000', '1.500000', 0, 'Sin Departamento', 0, NULL, NULL, NULL, 1, NULL, NULL, 7),
(1105, '872168857522', 'PAR DE ARITOS MULTIDISEÑOS ', '0.2500', '0.125000', 220, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 20, NULL, NULL, 11),
(1106, '712138315052', 'ARGOLLA MULTIDISEÑOS ECO', '0.3500', '0.175000', 9, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1107, '744110383727', 'ARITOS LARGOS ECONIMICOS', '1.0000', '0.500000', 2, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1108, '6982125125124', 'MI GRADUACION BANNER', '3.0000', '1.500000', 5, 'Sin Departamento', 0, NULL, NULL, NULL, 2, NULL, NULL, 7),
(1109, '252344460101', 'GLOBO GRADUACION', '5.5000', '2.750000', 0, 'BEBE', 0, NULL, NULL, NULL, 1, NULL, NULL, 5),
(1110, '883885186372', 'STICKER LETRA Y NUMOEROS', '1.0000', '0.500000', 4, 'FIESTA', 0, NULL, NULL, NULL, 2, NULL, NULL, 6),
(1111, '265484274274', 'LLAVERO EMOJIS', '0.5000', '0.250000', 0, 'FIESTA', 0, NULL, NULL, NULL, 2, NULL, NULL, 6),
(1112, '7502211250180', 'BOLSA DE VEJIGA CELESTE 50 U', '2.3500', '1.175000', 1, 'FIESTA', 0, NULL, NULL, NULL, 2, NULL, NULL, 6),
(1113, '648553362543', 'GLOBO NUMERO DORADO METALIZADO', '1.7500', '0.875000', 22, 'FIESTA', 0, NULL, NULL, NULL, 6, NULL, NULL, 6),
(1114, '102100137', 'KML GANCHO DORADO CORAZON', '2.0000', '1.000000', 1, 'Sin Departamento', 0, NULL, NULL, NULL, 1, NULL, NULL, 7),
(1115, '102100141', 'KML GANCHO DORADO/PLATEADO', '2.0000', '1.000000', -3, 'Accesorios de Mujer', 0, NULL, NULL, NULL, NULL, NULL, NULL, 11),
(1116, '102100142', 'KML GANCHO TRIANGULAR ', '2.0000', '1.000000', 2, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1117, '244636252876', 'KML GANCHO PERLA', '1.7500', '0.875000', 29, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1118, '7506129454401', 'CUADERNO SCRIBE 200P CUADRO COSIDO PEQUEÑO', '1.0000', '0.710000', 140, 'Escolar', 0, NULL, NULL, NULL, 20, NULL, NULL, 3),
(1119, '7441029520286', 'CANELITAS CHOCOLATE ', '0.6000', '0.500000', 2, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(1120, '74000593', 'CANELITAS VAINIL', '0.6250', '0.500000', 2, 'Golocinas', 0, NULL, NULL, NULL, 3, NULL, NULL, 2),
(1121, '768497167544', 'RESMA 500 HOJAS FAC', '5.0000', '3.750000', 23, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(1122, '246452116183', 'CHONGA MAGICA PEQUEÑA', '0.1500', '0.100000', 19, NULL, 0, NULL, NULL, NULL, 2, NULL, NULL, 1),
(1123, '7506129456337', 'SCRIBE COS. ANOTA RAY PEQUEÑO', '0.9500', '0.700000', 62, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(1124, '7506129454746', 'SCRIBE COS. ANOTA RAY GNDE 200 PGS', '1.9000', '1.050000', 76, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1125, '573351404770', 'DURAPAX PLIEGO DELGADO', '1.7500', '0.875000', 3, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1126, '328070122708', 'DURAPAX PLIEGO GRUESO', '2.0000', '1.380000', 9, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1127, '798302077669', 'KLIP XTREME MOUSE INALAMBRICO', '12.5000', '7.760000', 0, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(1128, '798302077676', 'KLIP XTREME MOUSE INALA. AZUL', '12.5000', '7.768750', 0, 'Tecnología', 0, NULL, NULL, NULL, NULL, NULL, NULL, 9),
(1129, '062087560535', 'BANNER FELIZ CUMPLEAÑOS', '2.0000', '1.000000', 10, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1130, '055840803112', 'CORTINA SURTIDA CUMPLE', '2.5000', '1.250000', 35, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1131, '802863090002', 'BOLSA VEJIGA SURTIDA 100U', '3.9000', '1.950000', 6, 'Sin Departamento', 0, NULL, NULL, NULL, 2, NULL, NULL, 7),
(1132, '755578362822', 'JUGUETE BEBE DIDACTICO', '8.0000', '4.000000', 2, 'Juguetes Bebe', 0, NULL, NULL, NULL, 1, NULL, NULL, 16),
(1133, '752066128802', 'MUÑECA SIRENA CON LUZ', '1.7500', '0.875000', 8, 'Juguetes Niña', 0, NULL, NULL, NULL, 2, NULL, NULL, 15),
(1134, '661586342653', 'TARJETA NAVIDEÑA ECO', '0.5000', '0.250000', 9, 'Navideño', 0, NULL, NULL, NULL, 3, NULL, NULL, 8),
(1135, '802863090057', 'GLOBOS PALMERITO ROSADO', '3.9000', '2.600000', 2, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(1136, '802863090163', 'GLOBOS PALMERITO FUSCIA', '3.9000', '2.600000', 3, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(1137, '432505442502', 'GLOBOS PALMERITO NEGRO 100 U', '3.9000', '2.600000', 4, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6);
INSERT INTO `Hoja1` (`id_producto`, `Codigo`, `Nombre`, `Precio_de_venta`, `Precio_de_compra`, `Cantidad`, `Marca`, `Descuento`, `Descripcion`, `Imagen`, `Ubicacion`, `StockMinimo`, `PrecioMayoreo`, `PrecioDistribuidor`, `id_categoria`) VALUES
(1138, '9789996191480', 'LIBRO VICTORIA ', '4.8500', '3.600000', 11, 'Escolar', 0, 'LIBRE PRIMERO DE LECTURA Y ESCRITURA', NULL, NULL, 3, NULL, NULL, 3),
(1139, '586217287187', 'CHICAGO DICCIONARIO S-E E-S', '1.9000', '1.320000', 12, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(1140, '311441280774', 'PAPEL BOND HOJA', '0.0200', '0.010000', 785, 'Escolar', 0, NULL, NULL, NULL, 100, NULL, NULL, 3),
(1141, '740617298680', 'KINGSTONE MCSD 32 GB C. 10 ', '11.5000', '5.990000', 2, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(1142, '740617298697', 'KINGSTONE MCSD 64 GB C. 10 ', '20.0000', '10.740000', 3, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(1143, '13032405', 'ADATA MCSD 16 GB C. 10', '8.0000', '4.980000', 2, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(1144, '017542821100', 'PLIEGO PAPEL BOND BLANCO', '0.2500', '0.125000', 405, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(1145, '468203806742', 'VEJIGA POR UNIDAD', '0.0500', '0.025500', -94, 'FIESTA', 0, NULL, NULL, NULL, 12, NULL, NULL, 6),
(1146, '7453074540485', 'LONCHERA PJMASK B0646', '10.0000', '6.780000', 0, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1147, '7453074540560', 'LONCHERA PJMASK JM-B0646', '10.0000', '6.780000', 0, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1148, '7453074538116', 'LONCHERA SHOPKINS B0562', '10.0000', '6.780000', 0, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1149, '7417200604250', 'PARROT CROYONES YUMBO STANDARD', '1.6000', '0.900000', 0, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1150, '7453069772747', 'LONCHERA DELTA-17L HERMETICA', '14.7500', '9.040000', 0, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1151, '760460621538', 'BOLSA NAVIDEÑA ROJA PEQ.', '1.2500', '0.625000', 2, 'Navideño', 0, NULL, NULL, NULL, 1, NULL, NULL, 8),
(1152, '380276806667', 'CARTERA DE PERRITO', '6.0000', '3.000000', 0, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 0, NULL, NULL, 11),
(1153, '7501091825020', 'BOLSA DE REGALO S ROSAS ', '1.0000', '0.500000', 0, 'BOLSAS', 0, NULL, NULL, NULL, 0, NULL, NULL, 14),
(1154, '6972526711217', 'BOLSA MY CHRISTMAS WISH LIST', '1.2500', '0.625000', 1, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(1155, '233260140537', 'SET VEJIGAS DECORADAS', '2.0000', '1.000000', 7, 'FIESTA', 0, NULL, NULL, NULL, 2, NULL, NULL, 6),
(1156, '304044514330', 'CORONA NAVIDEÑA ECO', '1.0000', '0.500000', 7, 'Navideño', 0, NULL, NULL, NULL, 3, NULL, NULL, 8),
(1157, '7702111293816', 'NORMA JEAN BOOK TRY IT AGAIN 80 H', '5.0000', '2.980000', 12, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(1158, '538618857301', 'TARJETAS DE INVITACION 10U. ', '1.5000', '0.750000', 100, 'FIESTA', 0, NULL, NULL, NULL, 20, NULL, NULL, 6),
(1159, '226660647706', 'GLOBO NUMERO #16', '1.0000', '0.500000', 2, 'FIESTA', 0, NULL, NULL, NULL, 3, NULL, NULL, 6),
(1160, '6965154175032', 'BOLSA NAVIDEÑA CHINI M. NIEVE PQ.', '0.7500', '0.375000', 0, 'Navideño', 0, NULL, NULL, NULL, 2, NULL, NULL, 8),
(1161, '6972608380041', 'BOLSA NAVIDEÑA ESFERA PEQ', '0.7500', '0.375000', 4, 'Navideño', 0, NULL, NULL, NULL, 2, NULL, NULL, 8),
(1162, '6972526711255', 'BOLSA NAVIDEÑA ARBOLES GRDE', '2.0000', '1.000000', -4, 'Navideño', 0, NULL, NULL, NULL, 1, NULL, NULL, 8),
(1163, '6965154174813', 'BOLSA NAVIDEÑA L CARTON BOTAS', '2.0000', '1.000000', -23, NULL, 0, NULL, NULL, NULL, 2, NULL, NULL, 1),
(1164, '8615315831526', 'PAPEL DE REGALO IDO', '2.5000', '1.250000', 4, 'FIESTA', 0, NULL, NULL, NULL, 2, NULL, NULL, 6),
(1165, '708027776647', 'PAPEL DE REGALO UN PLIEGO NAVI', '1.2500', '0.625000', 20, 'FIESTA', 0, NULL, NULL, NULL, 3, NULL, NULL, 6),
(1166, '162755405483', 'PAPEL CRAFT', '0.1000', '0.050000', 1, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(1167, '6996555872268', 'LUMINOUS STICKERS 3D', '1.0000', '0.500000', 13, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 2, NULL, NULL, 13),
(1168, '643750677308', 'SET 10 BOLSAS PARA DULCES', '1.5000', '0.750000', 19, 'FIESTA', 0, NULL, NULL, NULL, 2, NULL, NULL, 6),
(1169, '577341208242', 'POP IT HEXAGONAL ECO', '1.0000', '0.500000', 10, 'Juguetes Unisex', 0, NULL, NULL, NULL, 2, NULL, NULL, 12),
(1170, '20\'76', 'TREN NAVIDEÑO 23 PCS', '25.0000', '12.500000', 1, 'Navideño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 8),
(1171, '8615315831519', 'PAPEL DE REGALO NA. PREMIUM', '1.2500', '0.625000', 6, 'Navideño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 8),
(1172, '6972526711248', 'BOLA NAVIDEÑA ARBOLES 2', '1.5000', '0.750000', -2, 'Sin Departamento', 0, NULL, NULL, NULL, 2, NULL, NULL, 7),
(1173, '815364128754', 'SET VEJIGAS METALIZADAS', '3.0000', '1.500000', 1, 'FIESTA', 0, NULL, NULL, NULL, 2, NULL, NULL, 6),
(1174, '561265384237', 'BOLSA CELOFAN MEDIANO', '0.3500', '0.175000', 69, 'FIESTA', 0, NULL, NULL, NULL, 10, NULL, NULL, 6),
(1175, '143684672718', 'BOLSITA CELOFAN PEQUEÑA', '0.1500', '0.075000', 46, 'FIESTA', 0, NULL, NULL, NULL, 10, NULL, NULL, 6),
(1176, '886540006920', 'TECLADO ARGOM', '10.0000', '5.000000', 0, 'Sin Departamento', 0, NULL, NULL, NULL, 1, NULL, NULL, 7),
(1177, '7441163400741', 'GALLETA POZUELO NAVIDEÑO', '1.2500', '1.000000', 6, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(1178, '200701800535', 'SET DE JUGUETES', '2.0000', '1.000000', 0, 'Juguetes Niño', 0, NULL, NULL, NULL, 2, NULL, NULL, 10),
(1179, '046241270145', 'GLOBO METALIZADO #32', '2.0000', '1.000000', 46, 'FIESTA', 0, NULL, NULL, NULL, 5, NULL, NULL, 6),
(1180, '126313105733', 'PAPEL COFRADO', '0.6500', '0.325000', 26, 'FIESTA', 0, NULL, NULL, NULL, 10, NULL, NULL, 6),
(1181, '030028606254', 'PAPEL LINO BEIGE', '0.1500', '0.075000', 13, 'FIESTA', 0, NULL, NULL, NULL, 10, NULL, NULL, 6),
(1182, '148360305270', 'CARTULINA LINO BLANCO', '0.1500', '0.075000', 6, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(1183, '854234366085', 'FRUTA DESHIDRATADA ', '1.0000', '0.750000', 4, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1184, '6971244350401', 'CABLE PARA IPHONE ECO', '5.0000', '2.500000', 4, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(1185, '6972608389853', 'BOLSA DE REGALO S CARTON # 2', '0.7500', '0.450000', 7, 'BOLSAS', 0, NULL, NULL, NULL, 1, NULL, NULL, 14),
(1186, '881070705174', 'BOLSA DE REGALO S CARTON CORAZONES ', '0.7500', '0.500000', 1, 'BOLSAS', 0, NULL, NULL, NULL, 1, NULL, NULL, 14),
(1187, '6855271222583', 'BOLSA DE REGALO S ECONOMICA HOMBRE ', '0.5000', '0.350000', 6, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 1),
(1188, '565573437054', 'BOLSA DE REGALO S ECONOMICA SURTI.', '0.5000', '0.350000', 28, 'BOLSAS', 0, NULL, NULL, NULL, 1, NULL, NULL, 14),
(1189, '03424005', 'BARRA HERSHEY MILK CHOCOLATE 43 G 2', '1.3500', '0.910000', 48, 'Golocinas', 0, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(1190, '7502230948372', 'OSITA BON O BON 225G', '3.8000', '2.780000', 23, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1191, '7898142852662', 'OSITO BON O BON 225GR', '3.8000', '2.780000', 22, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(1192, '7410031970112', 'RAMO ROSAS BON O BON 225G', '3.5500', '2.770000', 10, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1193, '7410031970129', 'CAJA DESLIZABLE BON O BON 225 GR', '3.5500', '2.770000', 2, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(1194, '7502230942356', 'BON O BON CAJA 30U 450GR LECHE', '6.5000', '4.200000', -2, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1195, '75027988', 'BON O BON BLANCO 15G', '0.2500', '0.140000', 7, 'Golocinas', 0, NULL, NULL, NULL, 3, NULL, NULL, 2),
(1196, '7500443001785', 'BON O BON 15GR COOKIES Y CREAM', '0.2500', '0.140000', 14, 'Golocinas', 0, NULL, NULL, NULL, 3, NULL, NULL, 2),
(1197, '75046910', 'BON O BON CHOCOLATE 15GR', '0.2500', '0.140000', 16, 'Golocinas', 0, NULL, NULL, NULL, 3, NULL, NULL, 2),
(1198, '75027971', 'BON O BON CLASICO 15GR', '0.2500', '0.140000', -1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1199, '77922694', 'MENTHOPLUS BARRA MENTA', '0.2500', '0.150000', 12, 'Golocinas', 0, NULL, NULL, NULL, 5, NULL, NULL, 2),
(1200, '785381016528', 'GALLETA AVENA MANTEQUILLA', '0.3500', '0.280000', 9, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1201, '785381016535', 'GALLETA AVENA MANZANA CANELA', '0.3500', '0.280000', 3, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(1202, '785381016511', 'GALLETA DE AVENA CON CHOCOLATE', '0.3500', '0.280000', 3, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(1203, '785381016542', 'GALLETA AVENA CON PASAS ', '0.3500', '0.280000', 4, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(1204, '7500443003987', 'TABLETA CHOCOLATE CON LECHE ARCOR', '0.8500', '0.590000', 16, 'Golocinas', 0, NULL, NULL, NULL, 3, NULL, NULL, 2),
(1205, '7500443004007', 'TABLETA BON O BON ', '0.8500', '0.590000', 1, 'Golocinas', 0, NULL, NULL, NULL, 3, NULL, NULL, 2),
(1206, '7500443004359', 'TABLETA ARCOR ROCKLETS', '0.8500', '0.590000', -1, 'Golocinas', 0, NULL, NULL, NULL, 3, NULL, NULL, 2),
(1207, '7896058258004', 'FORMIS CHOCOFRESA GALLETA ARCOR', '0.5000', '0.320000', 2, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(1208, '7401007600782', 'TUCAN CRAYONES ECO 12 COLORS', '1.7500', '1.060000', 50, 'Escolar', 0, NULL, NULL, NULL, 10, NULL, NULL, 3),
(1209, '7401007604766', 'BORRADOR TUCAN RETRACTIL LAPIZ', '1.5000', '0.770000', 11, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(1210, '878426343408', 'PLIEGO CARTON PIEDRA 2.0MM', '2.2500', '1.500000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1211, '784562428588', 'STICKER EMOTIONS ', '0.5000', '0.250000', 20, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1212, '6925721123538', 'VELAS CUMPLE CON LETRAS', '1.5000', '0.750000', 2, 'FIESTA', 0, NULL, NULL, NULL, 2, NULL, NULL, 6),
(1213, '186250784472', 'POP IT MEDIANO', '6.0000', '3.000000', 4, 'Juguetes Unisex', 0, NULL, NULL, NULL, 2, NULL, NULL, 12),
(1214, '7401007624405', 'GOMA ESCOLAR BLANCA 1/2 GALON', '5.4500', '3.760000', 11, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1215, '7401007602229', 'TUCAN JUMBO EXAGONAL 12 COLORS', '1.6500', '1.000000', 5, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1216, '7401007619272', 'TUCAN BORRADOR RETRACTIL UFFO', '1.2500', '0.700000', 20, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1217, '7401007623316', 'TUCAN GABACHA INFANTIL DOBLE 14.5X18.5', '3.5000', '2.580000', 11, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1218, '7401007622760', 'FOLDER PLASTICO TUCAN A4 FUCSIA', '0.5500', '0.330000', 6, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1219, '7401007622753', 'FOLDER PLASTICO A4 TUCAN AMARILLO', '0.5500', '0.330000', 2, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1220, '7401007622777', 'FOLDER PLASTICO TUCAN A4 AZUL', '0.5500', '0.330000', 5, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1221, '7401007622784', 'FOLDER PLASTICO TUCAN A4 TRANS', '0.5500', '0.330000', 6, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1222, '7401007624535', 'SACAPUNTA TWIIN TUCAN PRO OVALO', '1.0000', '0.630000', 19, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1223, '7401007624498', 'SACAPUNTA 2 AGUJEROS TUCAN TWIIN PRO CIRCULO', '1.0000', '0.630000', 13, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1224, '7401007602403', 'SACAPUNTA METALICA TUCAN 1 AGUJERO ', '0.2500', '0.120000', 102, NULL, 0, NULL, NULL, NULL, 20, NULL, NULL, 1),
(1225, '142450874164', 'SET DE VEJIGA CUMPLEAÑOS DIS', '1.0000', '0.500000', -6, 'Sin Departamento', 0, NULL, NULL, NULL, 1, NULL, NULL, 7),
(1226, '077136154067', 'BOLSA VEJIGAS METALIZADAS 50U FUSCIA', '5.5000', '2.750000', 9, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(1227, '723272150287', 'GORRO CUMPLEAÑERO ECONOMICO', '0.3000', '0.200000', 33, 'FIESTA', 0, NULL, NULL, NULL, 5, NULL, NULL, 6),
(1228, '6586654989907', 'STICKER PERLAS ', '0.7500', '0.375000', 3, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(1229, '7401007612877', 'DCOTAC ROLLO MATE 1.5MT NEGRO', '1.5000', '0.900000', 11, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1230, '7401007600263', 'DCOTAC ROLLO MATE 1.5MT AZUL ', '1.5000', '0.900000', 0, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1231, '7401007600300', 'DCOTAC ROLLO MATE 1.5MT NARANJA', '1.5000', '0.900000', 10, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1232, '7401007609662', 'DCOTAC ROLLO MATE 1.5MT CELESTE', '1.5000', '0.900000', -1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1233, '7401007620445', 'DCOTAC TRANSPARENTE ROLLO 1.5M', '1.4000', '0.770000', -2, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1234, '573534201007', 'CESEROLA JUGUETES', '2.2500', '1.330000', 6, 'Sin Departamento', 0, NULL, NULL, NULL, 1, NULL, NULL, 7),
(1235, '246813434221', 'SET JUGUETE CASEROLA', '2.2500', '1.330000', 8, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 1),
(1236, '7401007600317', 'DCOTAC ROLLO MATE 1.5MT ROJO', '1.5000', '0.900000', 0, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1237, '7401007600256', 'DCOTAC ROLLO MATE 1.5MT AMARILLO', '1.5000', '0.900000', 5, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1238, '1628942377012', 'STICKER DIAMENTE NIÑA', '0.7500', '0.375000', 1, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1239, '6950413242792', 'STICKER SURTIDO DECO MEDIANO', '0.5000', '0.250000', 1, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1240, '6955878854429', 'STICKER SURTIDO MEDIANO 2', '0.5000', '0.250000', 4, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1241, '384531306223', 'FOMY FIGURAS ADHESIVAS PEQ.', '0.3000', '0.200000', 65, 'Escolar', 0, NULL, NULL, NULL, 10, NULL, NULL, 3),
(1242, '113080117332', 'STICKER MEDIANO EMOTIONS CUARTO', '2.0000', '1.000000', 9, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(1243, '6984581234129', 'STICKER UNICORNIO MEDIANO CUARTO', '1.5000', '0.750000', 0, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1244, '7450009187975', 'MERLETO ADHRSIVO DE FOMI BUITO', '2.0000', '1.000000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1245, '7450008488257', 'MERLETO ADHESIVO FOMI NUMEROS', '1.7500', '0.880000', 0, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1246, '473771771065', 'SLINE TUBO GRANDE ', '3.0000', '1.500000', 6, 'Juguetes Unisex', 0, NULL, NULL, NULL, 3, NULL, NULL, 12),
(1247, '118635717330', 'BRILLANTINA SURTIDA BOLSITA 10G', '0.1500', '0.075000', 48, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1248, '271773732686', 'TARJETAS DE/PARA REGALO', '0.0500', '0.025000', 12, 'FIESTA', 0, NULL, NULL, NULL, 5, NULL, NULL, 6),
(1249, '483828257753', 'CYZON IN LOVE', '15.0000', '7.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1250, '474242674133', 'CAJA LARGA DECORADA', '1.0000', '0.500000', 21, NULL, 0, NULL, NULL, NULL, 5, NULL, NULL, 1),
(1251, '642153073161', 'TAZA NAVIDEÑAS ECONOMICAS', '1.5000', '0.750000', 14, 'Navideño', 0, NULL, NULL, NULL, 2, NULL, NULL, 8),
(1252, '482033503167', 'CAJITA PARA ARITO CHINI', '0.5000', '0.250000', 24, 'FIESTA', 0, NULL, NULL, NULL, 2, NULL, NULL, 6),
(1253, '176204167277', 'chonga pequeña magica regalo', '0.2500', '0.125000', 78, 'FIESTA', 0, NULL, NULL, NULL, 20, NULL, NULL, 6),
(1254, '367030707062', 'manita rascadora colors ', '0.7500', '0.250000', 5, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1255, '832570561678', 'hulitos en bolsa elasticos colors ', '0.2500', '0.125000', 46, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 10, NULL, NULL, 11),
(1256, '7502211250029', 'BOLSA DE VEJIGA 100 PIEZAS ', '3.9500', '2.650000', 5, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(1257, '541361532848', 'HULITOS BOLSA YFF', '0.3000', '0.150000', 23, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 5, NULL, NULL, 11),
(1258, '854620156404', 'DEADEMA DE TELA ', '1.0000', '0.500000', 6, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1259, '701803777250', 'DEADEMA PLASTICA ', '0.2500', '0.125000', 9, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1260, '017643887003', 'COLA ELASTICA ECONOMICA ', '0.2500', '0.125000', 60, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1261, '634443562253', 'COLA AZUL BLANCA CON RAYAS ', '0.2500', '0.125000', 30, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 3, NULL, NULL, 11),
(1262, '567031658150', 'SET DE DOS COLAS ', '0.5000', '0.250000', 5, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1263, '521541026402', 'SET DE BRILLANTE 12UNID', '0.7500', '0.500000', 2, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1264, '641080560685', 'GANCHOS METALICOS COLORS ', '1.0000', '0.600000', 7, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(1265, '746278878784', 'SET DE COLAS NIÑA DECORADA ', '0.7500', '0.400000', 13, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 3, NULL, NULL, 11),
(1266, '867277023811', 'GANCHO DE MARIPOSA ', '0.2500', '0.125000', 3, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1267, '682481620730', 'COLAS DE ALGODON DE COLORES ', '0.1500', '0.075000', 16, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 3, NULL, NULL, 11),
(1268, '7401007623231', 'TUCAN GLITTER GLUE AZUL 60 ML', '1.2500', '0.660000', 12, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(1269, '7441029522402', 'GALLETA KRONK CHOCOLATE VAINILLA', '0.2500', '0.200000', 20, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(1270, '7441029522396', 'GALLETA KRONK MANI CHOCOLATE', '0.2500', '0.200000', 16, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1271, '445515735625', 'SET DE MUÑECAS SECADORA', '3.7500', '1.750000', 6, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1272, '411585122206', 'SET DE RIZADORA Y CARTERA', '3.7450', '1.750000', 2, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1273, '21\'046', 'SET TIJERA LENTES ', '2.0000', '1.000000', 6, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1274, '21\'183', 'SET DE BISUTERIA NIÑA', '5.0000', '2.500000', 2, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1275, '21\'062', 'SET CORONA NIÑA', '2.7500', '1.375000', 6, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1276, '7453105015067', 'SET DE SOMBRA PONI', '4.5000', '2.250000', NULL, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1277, '885600000151', 'SET ESPEJO BROCHAS', '3.0000', '1.500000', 1, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1278, '21\'029', 'SET PONI 2', '4.2500', '2.125000', 3, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1279, '21\'047', 'SET CARTERA SECADORA TIJERA', '5.5000', '2.750000', 2, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1280, '21\'028', 'SET DE SOMBRAS Y PASTELITOS', '4.0000', '2.000000', 2, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1281, '885600064924', 'SET DE COCINA VERDURAS', '3.2500', '1.625000', 3, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1282, '885600003145', 'SET DE COCINA ROSADO', '4.0000', '2.000000', 2, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1283, '21\'36', 'SET DE COCINA VERDE', '3.0000', '1.500000', 2, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1284, '862433504266', 'SIRENA CON LUZ', '1.7500', '0.875000', 3, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1285, '568841872088', 'SIRENA PELO LARGO', '1.2500', '0.625000', 7, 'Juguetes Niña', 0, NULL, NULL, NULL, 3, NULL, NULL, 15),
(1286, '20\'143', 'MUÑECA BELLA DURMIENTE', '10.0000', '6.000000', 1, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1287, '21\'045', 'SET PEQUEÑO TELEFONO SECADORA', '2.2500', '1.125000', 5, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1288, '840101469470', 'MUÑECA ANLILY ', '8.0000', '4.000000', 3, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1289, '4052351018124', 'MUÑECA STEFY PARA PEINAR ', '13.5000', '6.750000', 0, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1290, '21\'160', 'MAQUILLAJE TIPO DONA', '4.2500', '2.125000', 0, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1291, '21\'056', 'TRANSFORMERS DINOSAURIO COLORES ', '6.0000', '3.000000', 5, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1292, '465745827632', 'MUÑECA MARIPOSA PEQUEÑA', '2.2500', '1.125000', 5, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1293, '584100656877', 'MUÑECA PEQUEÑA CON UNICORNIO', '1.0000', '0.500000', 7, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1294, '21\'412', 'SET DE BAÑERA MEDIANA', '10.0000', '5.000000', 2, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1295, '6923450656187', 'MUÑECA MUSICAL MEDIANA', '6.0000', '3.000000', 4, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1296, '4892980221508', 'MUÑECA MUSICAL CON SOMBRERO', '15.0000', '9.000000', 3, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1297, '4892980022433', 'MUÑECA SIN SOMBRERO', '15.0000', '9.000000', 2, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1298, '608287826824', 'MUÑECA DE TRAPO GRANDE', '18.7500', '12.000000', 1, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1299, '153761332783', 'MUÑECA SANDRITA MUSICAL', '9.0000', '6.500000', 3, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 1),
(1300, '093905154794', 'BEBE BAÑO', '18.0000', '10.000000', 5, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1301, '20\'267', 'BARBIE Y KEEN', '8.5000', '4.250000', 2, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1302, '20\'260', 'MUÑECA CON ACCESORIOS', '8.0000', '4.000000', 2, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1303, '20\'262', 'MUÑECA CON BEBE', '6.2500', '3.125000', 3, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1304, '21\'108', 'SET SOMBRAS UÑAS ', '3.5000', '2.000000', 3, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1305, '20\'265', 'MUÑECA CON BICICLETA CON BEBE', '15.0000', '10.000000', 0, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1306, '093905144788', 'BEBE FANTASY CONTRA EL AGUA', '20.0000', '10.000000', 3, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1307, '093905144016', 'BEBE FANTASY TOMA Y MOJA', '20.0000', '10.000000', 2, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1308, '093905293349', 'BEBE MAGGIE FANTASY', '18.0000', '10.000000', 3, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1309, '093905293387', 'MUÑECA 12 PULGADAS', '20.0000', '10.000000', 2, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1310, '769658062609', 'MUÑECA LOVELY DOLL CON PANPER', '23.0000', '12.000000', 0, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1311, '21\'123', 'SET DE HERRAMIENTAS', '9.0000', '4.500000', 3, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1312, '21\'059', 'SET DE CONSTRUCCION CON GAFAS', '10.0000', '5.000000', 3, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1313, '21\'104', 'SET DE PISTOLA Y ESPOSAS', '7.0000', '3.500000', 5, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1314, '19\'455', 'SET DE DOCTOR', '2.0000', '1.000000', 1, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1315, '7775551008005', 'PISTOLA DE AGUA', '14.0000', '7.500000', 1, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(1316, '20\'015', 'CAMION CON ESCABADORA', '20.0000', '10.000000', 2, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1317, '21\'408', 'CAMION DE CARGA', '11.5000', '5.750000', 2, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1318, '21\'027', 'CAMION ESCABADORA Y CARGA', '8.0000', '4.000000', 1, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1319, '21\'150', 'MAQUINA ESCABADORA Y CARGA AMARILLO', '11.5000', '6.000000', 1, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1320, '20\'311', 'PERRITO DE BATERIA', '5.0000', '2.500000', 0, 'Juguetes Unisex', 0, NULL, NULL, NULL, NULL, NULL, NULL, 12),
(1321, '307813555325', 'BURBUJA PEQUEÑA ', '0.5000', '0.300000', 10, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(1322, '6965872308095', 'BOLSA DE REGALO M EMOJIS Y UNICOR NAVI', '1.5000', '0.900000', 30, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 1),
(1323, '314005566582', 'CORTAUÑA MED.', '1.2500', '0.625000', 6, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 2, NULL, NULL, 13),
(1324, '8422608050843', 'TOE NAILS', '0.7500', '0.375000', 6, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1325, '21-138', 'CAMION DE BOMBEROS ROJO ', '11.0000', '5.500000', 6, 'Juguetes Niño', 0, 'RACING KING', NULL, NULL, 2, NULL, NULL, 10),
(1326, '21\'127', 'CARRO DEPORTIVO GRANDE NARANJA ', '16.0000', '10.000000', 1, 'Juguetes Niño', 0, '55 CHAMPION ', NULL, NULL, NULL, NULL, NULL, 10),
(1327, '221068071117', 'DEPOSITO PARA GEL FIGURAS', '1.0000', '0.480000', 3, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1328, '20\'307', 'BEBE PIJAMA CON SONIDO PELON', '10.0000', '5.000000', 3, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1329, '21\'010', 'CAMION MULTIFUNCION', '10.0000', '5.000000', 3, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1330, '087840765042', 'PAPEL LUSTRE PLIEGO GRIS ', '0.2000', '0.110000', 25, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1331, '21\'125', 'CARRO DEPORTIVO GRANDE ROJO ', '16.0000', '10.000000', 1, 'Juguetes Niño', 0, '88 RED BLURR', NULL, NULL, NULL, NULL, NULL, 10),
(1332, '21\'126', 'CARRO DEPORTIVO GRANDE AZUL', '16.0000', '10.000000', 0, 'Juguetes Niño', 0, 'THUNDERBOLT 2 ', NULL, NULL, NULL, NULL, NULL, 10),
(1333, '446408853570', 'SET 3 PASCUAS PEQ', '1.5000', '0.750000', 6, 'Navideño', 0, NULL, NULL, NULL, 2, NULL, NULL, 8),
(1334, '767047282034', 'LUCES LED 100 L VERDE', '6.0000', '3.000000', 2, 'Navideño', 0, NULL, NULL, NULL, 1, NULL, NULL, 8),
(1335, '521660287268', 'SET BASTONES GRANDES NAV.', '2.0000', '1.000000', 7, 'Juguetes Unisex', 0, NULL, NULL, NULL, 2, NULL, NULL, 12),
(1336, '408507307833', 'MASCARILLAS AZUL Y NEGRO 2X1', '0.2500', '0.125000', 151, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1337, '052100285', 'WALLET LIGNUM PIRAMIDE', '18.0000', '10.000000', 2, 'Accesorios de Hombre', 0, NULL, NULL, NULL, 0, NULL, NULL, 17),
(1338, '052100287', 'WALLET LIGNUM CAMPANA CAFE', '18.0000', '10.000000', 3, 'Accesorios de Hombre', 0, NULL, NULL, NULL, 0, NULL, NULL, 17),
(1339, '260284062462', 'CABALLITO BALANCIN MADERA', '45.0000', '30.000000', 1, 'Juguetes Unisex', 0, NULL, NULL, NULL, 0, NULL, NULL, 12),
(1340, '620850761637', 'PLIEGO NAVIDEÑO IDOL', '1.2500', '0.625000', 9, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(1341, '166625151084', 'LABIAL MAGICO', '0.7500', '0.375000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1342, '21\'035', 'CARRO DEPORTIVO DE POLICIA A CONTROL', '15.0000', '8.000000', 1, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1343, '21\'169', 'CARRO DEPORTIVO A CONTROL', '15.0000', '8.000000', 4, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1344, '21-016', 'CAMION GRUA AMARILLO VERDEE', '11.0000', '6.000000', 2, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1345, '885600798195', 'JEEP CON REMOLQUE', '8.0000', '4.000000', 2, 'Juguetes Niño', 0, NULL, NULL, NULL, 1, NULL, NULL, 10),
(1346, '21-084', 'FERRARI ROJO MEDIANO', '8.0000', '4.000000', 3, 'Juguetes Niño', 0, NULL, NULL, NULL, 1, NULL, NULL, 10),
(1347, '784131051624', 'CONFETI', '1.2500', '0.625000', -1, 'FIESTA', 0, NULL, NULL, NULL, 0, NULL, NULL, 6),
(1348, '547422856376', 'MUÑECO POLICIA GRANDE', '2.0000', '1.000000', 5, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1349, '21\'401', 'CAMION TIPO GRUA CON ESCABADORA', '7.0000', '3.500000', 5, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1350, '276524040205', 'SET DE 4 CAMIONES ROJOS', '3.7500', '1.875000', -4, 'Juguetes Niño', 0, NULL, NULL, NULL, 1, NULL, NULL, 10),
(1351, '871405461361', 'SET MOTO AMBULANCIA POLICIA BUS ESCOLAR CARRO POSTAL', '4.7500', '2.380000', 0, 'Juguetes Bebe', 0, NULL, NULL, NULL, 0, NULL, NULL, 16),
(1352, '333547160710', 'BINOCULARES ', '0.7500', '0.380000', 5, 'Juguetes Niño', 0, NULL, NULL, NULL, 1, NULL, NULL, 10),
(1353, '405880034682', 'SEDAN TIPO VOCHO', '1.2500', '0.630000', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1354, '722448801444', 'HOMBRE POLICIA PEQUEÑO', '1.0000', '0.500000', 4, 'Juguetes Niño', 0, NULL, NULL, NULL, 1, NULL, NULL, 10),
(1355, '21\'199', 'CARRO CONTROL REMOTO MEDIANO', '15.0000', '8.000000', 2, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1356, '681449050155', 'CARRO CONTROL REMOTO GRUA', '18.0000', '12.000000', 0, 'Juguetes Niño', 0, NULL, NULL, NULL, 1, NULL, NULL, 10),
(1357, '21\'391', 'MUÑECA SIRENA ART. CON ANIMALES', '10.0000', '5.500000', 3, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1358, '21\'032', 'SIRENA CON LUZ CAJA', '7.0000', '3.500000', 3, 'Juguetes Niña', 0, 'MERMAID', NULL, NULL, NULL, NULL, NULL, 15),
(1359, '4892980231651', 'BEBE GINGER PELON GRANDE', '20.0000', '12.000000', 3, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1360, '8615315831540', 'PAPEL DE REGALO PREMIUN CELESTE', '1.2500', '0.625000', -8, 'Navideño', 0, NULL, NULL, NULL, 1, NULL, NULL, 8),
(1361, '717218285088', 'HORSE LOVELY SET', '2.5000', '1.250000', 2, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1362, '305186618220', 'COOK KITCHEN SET', '0.7500', '0.375000', 11, 'Juguetes Niña', 0, NULL, NULL, NULL, 2, NULL, NULL, 15),
(1363, '21\'058', 'SET KITCHEN GRANDE', '6.0000', '3.000000', 2, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1364, '885600061121', 'SET DOCTORA MEDIANO ROSA', '2.7500', '1.500000', 3, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1365, '21\'018', 'DINOSAUR WORLD BOLSA GRDE 9 PCS', '8.0000', '4.000000', 3, 'Juguetes Unisex', 0, NULL, NULL, NULL, NULL, NULL, NULL, 12),
(1366, '6941368540088', 'MEINFUREN BEAUTIFUL LADY', '1.5000', '0.750000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 0, NULL, NULL, 11),
(1367, '255331781846', 'MICROBUS PLASTICO TIPO PANEL', '0.7500', '0.375000', 9, 'Juguetes Niño', 0, NULL, NULL, NULL, 1, NULL, NULL, 10),
(1368, '768497166578', 'FACELA DISPENZADOR CINTA AD', '3.5000', '2.080000', 11, 'Escolar', 0, '3/4X25', NULL, NULL, NULL, NULL, NULL, 3),
(1369, '6504801501000', 'DOBLE JEEP CON REMOLQUE', '18.0000', '10.000000', 1, 'Juguetes Niño', 0, NULL, NULL, NULL, 1, NULL, NULL, 10),
(1370, '21\'082', 'SPEED RACE JEEP', '15.0000', '10.000000', NULL, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1371, '21\'406', 'CAMION CON JAULA Y DINOSAURIO', '9.0000', '4.000000', 1, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1372, '21\'097', 'RACING EJECTION PISTA', '20.0000', '15.000000', 2, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1373, '21\'043', 'CITY TRUCK SET', '28.0000', '20.000000', 1, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1374, '21\'147', 'MOTORCYCLE TRACK PISTA', '15.0000', '9.000000', 3, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1375, '7450077121321', 'SUPER POWER TRANSPORT CAMION', '10.0000', '6.000000', 0, 'Juguetes Niño', 0, NULL, NULL, NULL, 1, NULL, NULL, 10),
(1376, '212307286320', 'CAMION MEZCLADOR NARANJA', '6.5000', '3.000000', 4, 'Juguetes Niño', 0, NULL, NULL, NULL, 1, NULL, NULL, 10),
(1377, '21\'065', 'POTENT TOP TRAILER Y CAMION BOMBERO', '5.5000', '2.500000', 1, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1378, '7450077063935', 'BUS ESCOLAR AMARILLO', '4.2500', '2.000000', 0, 'Juguetes Niño', 0, NULL, NULL, NULL, 0, NULL, NULL, 10),
(1379, '21\'128', 'POWER TRUCK-CAR JEEP', '8.5000', '4.000000', 3, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1380, '21\'129', 'XR GOKRS HUMMER', '9.0000', '4.000000', 3, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1381, '19\'507', 'KITCHEN SERIES SET ', '0.7500', '0.400000', 1, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1382, '19\'509', 'KITCHEN COSPLAY WITH ME SET', '0.7500', '0.400000', 3, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1383, '19\'508', 'KITCHEN NEW STYLE SET', '0.7500', '0.400000', 1, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1384, '536168888581', 'BOLSA DESPACHO PEQUEÑA', '1.0000', '0.500000', 11, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 2, NULL, NULL, 13),
(1385, '5050841644913', 'TEAMSTERS CITY TRUCK', '8.0000', '5.000000', 0, 'Juguetes Niño', 0, NULL, NULL, NULL, 1, NULL, NULL, 10),
(1386, '21\'068', 'FIRE PROTECCION SET HELICOPTERO', '6.0000', '3.000000', 4, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1387, '205068242132', 'CAMION DE BOMBEROS PEQUEÑO ROJO', '4.5000', '2.000000', 1, 'Juguetes Niño', 0, NULL, NULL, NULL, 0, NULL, NULL, 10),
(1388, '21\'413', 'HV 1000 CUATRIMOTO ', '4.0000', '2.000000', 1, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1389, '21\'151', 'MAQUINA EXCABADORA PEQ.', '5.0000', '2.750000', 0, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1390, '21\'120', 'POWER KING BOARSE JEEP', '7.0000', '3.500000', 3, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1391, '418562178453', 'VEHICLE HIGH QUALITY LAMBO ', '1.0000', '0.600000', 4, 'Juguetes Niño', 0, NULL, NULL, NULL, 1, NULL, NULL, 10),
(1392, '160841700784', 'HEAVY TRUCKS CAMION PEQUEÑO', '1.0000', '0.600000', 7, 'Juguetes Niño', 0, NULL, NULL, NULL, 2, NULL, NULL, 10),
(1393, '101034856550', 'SEDAN PLASTICO ECO.', '0.7500', '0.400000', 6, 'Juguetes Niño', 0, NULL, NULL, NULL, 2, NULL, NULL, 10),
(1394, '486127477383', '.U.K PICK UP PEQUEÑO.', '1.0000', '0.550000', 3, 'Juguetes Niño', 0, NULL, NULL, NULL, 1, NULL, NULL, 10),
(1395, '856602541147', 'OSO DE PELUCHE CON SONIDO', '6.0000', '3.000000', 0, 'Navideño', 0, NULL, NULL, NULL, 1, NULL, NULL, 8),
(1396, '174417072236', 'GORRO NAVIDEÑO FELIZ N.', '1.0000', '0.600000', 23, 'Navideño', 0, NULL, NULL, NULL, 1, NULL, NULL, 8),
(1397, '510608183673', 'CAJA ARMABLE LETI', '4.5000', '2.250000', 2, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(1398, '764474022553', 'LUCES 24 M MULTIMUSICAL', '20.0000', '10.000000', 0, 'Navideño', 0, NULL, NULL, NULL, 0, NULL, NULL, 8),
(1399, '432482657770', 'LUCES MULTICOLOS 16M', '12.0000', '6.000000', 2, 'Navideño', 0, NULL, NULL, NULL, 0, NULL, NULL, 8),
(1400, '6900197210074', 'ROMPECABEZAS GRANDE', '2.0000', '0.600000', 4, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(1401, '6942246645642', 'ROMPECABEZA PEQUEÑO', '1.2500', '0.350000', 10, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(1402, '075656010291', 'RING FLYER ', '4.5000', '2.750000', 5, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(1403, '21-166', 'PIRAMIDE DE FIGURAS', '8.0000', '4.000000', 4, 'Juguetes Bebe', 0, NULL, NULL, NULL, 1, NULL, NULL, 16),
(1404, '8881681300199', 'BOLSA DE REGALO OSO', '1.0000', '0.500000', 1, 'BOLSAS', 0, NULL, NULL, NULL, 1, NULL, NULL, 14),
(1405, '7501091826072', 'BOLSA DE REGALO L CARTON DE UN COLOR Y FLORES', '2.0000', '1.000000', 12, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1406, '7702011202215', 'GALLETA MERRY CHRISTHMAS COLUMBINA ', '1.5000', '0.750000', 1, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(1407, '022472778010', 'PISTOLA DE AGUA TIPO AGUJA', '2.5000', '1.250000', 5, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(1408, '4716528093207', 'BLOKES 50 U BLOCKS', '15.0000', '10.000000', 4, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(1409, '4716528091104', 'BLOQUES 160 PIEZAS', '30.0000', '25.000000', 2, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(1410, '4716528093306', 'BLOQUES 100 PIESAS ', '25.0000', '12.500000', 1, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(1411, '6971283122908', 'VALDE PLAYERO GRANDE', '5.0000', '3.500000', 3, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(1412, '715732212062', 'AVACO DE JUGUETE', '1.5000', '0.750000', 2, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(1413, '631881154720', 'UÑAS PARA PIES', '0.9000', '0.450000', 5, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1414, '6855271122869', 'BOLSAS DE REGALO M UNICORNIO ECO.', '1.0000', '0.500000', -1, 'BOLSAS', 0, NULL, NULL, NULL, 1, NULL, NULL, 14),
(1415, '6972526718889', 'BOLSA GRANDE NAVIDEÑA', '2.5000', '1.250000', 4, 'BOLSAS', 0, NULL, NULL, NULL, 1, NULL, NULL, 14),
(1416, '844518002022', 'BOLSA DE DISNEY', '1.0000', '0.500000', 5, 'BOLSAS', 0, NULL, NULL, NULL, 3, NULL, NULL, 14),
(1417, '270062368126', 'PALETON DE CAJETA', '0.1500', '0.075000', 23, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1418, '773118706086', 'PLIEGO DE PAPEL BOND COLORES', '0.4500', '0.240000', 98, 'Escolar', 0, NULL, NULL, NULL, 10, NULL, NULL, 3),
(1419, '6965872308095', 'BOLSA MEDIANA DE REGALO ', '1.2500', '0.750000', 3, 'Navideño', 0, NULL, NULL, NULL, 1, NULL, NULL, 8),
(1420, '385685656802', 'MOCHILA TIPO AGUACATE ', '7.0000', '3.500000', 0, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(1421, '204231045070', 'CADENA DE ACERO MARIPOSA ', '5.0000', '2.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1422, '570702767778', 'FOMI LETRAS PEQUEÑAS COLORES', '1.4000', '0.700000', 5, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(1423, '033377016301', 'FOMI FORMA CORAZON PEQUEÑO', '0.2500', '0.125000', -2, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(1424, '064055557238', 'FOMI FORMA CORAZON GRANDE', '0.3000', '0.150000', 3, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(1425, '813756488517', 'FOMI TIPO FRUTAS', '0.5000', '0.250000', 4, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(1426, '308804808483', 'FOMI FIGURA NUMEROS COLORES', '2.5000', '1.250000', 2, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(1427, '737261005766', 'FOMI FIGURA DULCE PASTEL COLORES', '0.5000', '0.250000', 4, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(1428, '455516860551', 'FOMI FIGURA LETRAS GRANDES COLORES', '2.0000', '1.000000', 2, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(1429, '383374278775', 'BOLSA CELOFAN DECORADA ', '0.6500', '0.350000', 18, 'Navideño', 0, NULL, NULL, NULL, 10, NULL, NULL, 8),
(1430, '6970116403894', 'CARTUCHERA METALICA PARIS', '2.0000', '0.850000', 6, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(1431, '6970116405614', 'CARTUCHERA METALICA UNICORNIO', '2.0000', '0.850000', 1, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(1432, '407577220741', 'CARTUCHERA DE TELA', '2.5000', '1.730000', 1, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(1433, '870562883862', 'GLOBO NUMERO 40 P', '2.5000', '1.250000', 15, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(1434, '720473878004', 'TARJETAS HALLMARK', '1.9500', '1.200000', 29, 'Navideño', 0, NULL, NULL, NULL, 1, NULL, NULL, 8),
(1435, '385681361223', 'BILLETERA PEQUEÑA KML', '8.0000', '4.000000', 3, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1436, '7450077052472', 'TINCLE PERFILADOR DE CEJAS ', '1.5000', '0.750000', 3, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1437, '060080166413', 'LUCES LED BLANCAS ', '7.0000', '3.500000', 0, 'Navideño', 0, NULL, NULL, NULL, 0, NULL, NULL, 8),
(1438, '414575730152', 'BOLSA NAVIDEÑA YUMBO NAV.', '3.0000', '1.500000', 2, 'Sin Departamento', 0, NULL, NULL, NULL, NULL, NULL, NULL, 7),
(1439, '474301435757', 'BOLSA DE REGALO EXTRA JUMBO', '3.0000', '1.500000', 6, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(1440, '312820852217', 'LLAVERO AGUACATE CORAZON', '1.0000', '0.500000', -1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 2, NULL, NULL, 13),
(1441, '735080010730', 'BOLSA PIÑATERA DULCES', '4.9500', '3.160000', 3, 'Sin Departamento', 0, NULL, NULL, NULL, 1, NULL, NULL, 7),
(1442, '6958288885229', 'BOLSA DE REGALO S CARTON SURTI.', '1.0000', '0.650000', 8, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1443, '218174511627', 'CONFETI SURTIDO', '2.2500', '1.125000', 1, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(1444, '348260858228', 'COJIN UNICORNIO', '5.0000', '2.500000', 0, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1445, '74000654', 'MARINELA SUBMARINOS 64 G VAINILLA', '0.6000', '0.500000', 1, 'Golocinas', 0, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(1446, '7441029503074', 'MARIA GALLETA DULCE ', '0.6000', '0.500000', 3, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(1447, '221816156354', 'OSO DE PELUCHE MEDIANOS', '10.0000', '5.000000', 5, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1448, '727747628865', 'POP IT LLAVERO', '2.5000', '1.250000', 7, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1449, '6932897402725', 'CRAFT POMPONES', '1.0000', '0.650000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1450, '7502247339729', 'TOALLITAS HUMEDAS BRAZIL ', '1.0000', '0.810000', 0, 'BEBE', 0, NULL, NULL, NULL, 1, NULL, NULL, 5),
(1451, '7502247330030', 'TOALLITAS HUMEDAS BABYSEC', '1.0000', '0.870000', 6, 'BEBE', 0, NULL, NULL, NULL, 1, NULL, NULL, 5),
(1452, '7502211251156', 'BOSA DE VEJIGA GRIS METALIZADA ', '3.7500', '1.870000', 6, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(1453, '6911220021062', 'LLAVERO AGUACATE GRANDE ', '6.0000', '3.000000', 3, 'Sin Departamento', 0, NULL, NULL, NULL, 1, NULL, NULL, 7),
(1454, '4710409890671', 'LABIAL HIDRATANTE ', '1.2500', '0.625000', 3, 'Sin Departamento', 0, NULL, NULL, NULL, 1, NULL, NULL, 7),
(1455, '7417200623671', 'CUADERNO ESPIRAL BEXELEN # 3 BOBLE RAYA', '0.9500', '0.620000', 77, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(1456, '331381360881', 'AUDIFONOS INALAMBRICOS', '18.0000', '9.000000', 1, 'Tecnología', 0, NULL, NULL, NULL, 3, NULL, NULL, 9),
(1457, '7417200623633', 'CUADERNO RAYADO ESPIRAL # 3 BEXCELENT ', '0.9500', '0.620000', 102, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(1458, '102100015', 'KML CARTERA MEDIANA CON CIPER', '16.0000', '8.000000', 2, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1459, '102100020', 'KML CARTERA TORRBA FOREVER LOVELY', '8.0000', '4.000000', 2, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1460, '052100221', 'KML CARTEEA PEQUEÑA FLOR', '8.0000', '4.000000', 2, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1461, '102100021', 'KML CARTERA ELEFANTE ROSA', '8.0000', '4.000000', 0, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1462, '775321134303', 'KML BILLETERA CON BROCHE', '14.0000', '7.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1463, '052100224', 'KML CARTERA DE BROCHE HELLO AVACADO', '14.0000', '7.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1464, '855101014872', 'KML BILLETERA GRANDE 2 CIPERES', '16.0000', '8.000000', 2, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1465, '072100491', 'KML BILLETERA VINO BLANCO UN SIPER', '11.0000', '5.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1466, '406601032480', 'KLM BILLETERA CON CORREA FLORES PERLA', '164.0000', '82.000000', NULL, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1467, '082000531', 'KML BILLERETA DE CUADROS BLANCO Y NEGRO', '16.0000', '8.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1468, '606166468384', 'KLM BILLETERA DOBLE SIPER FOREVER ROMANCE', '16.0000', '8.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1469, '022100017', 'KLM BILLETERA UN SIPER 3 FLORES', '16.0000', '8.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1470, '504055647751', 'KLM CARTERA PORTACELULAR ROSA', '12.0000', '6.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1471, '720375207225', 'KLM CARTERA PORTACELULAR CON SIPER', '16.0000', '8.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1472, '042100354', 'KLM MONEDERO ROSA', '5.0000', '2.500000', 2, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1473, '306445780532', 'KLM CARTERA TIPO OSO HULE', '6.5000', '3.250000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1474, '668433527700', 'CARTERA TIPO FROZEN', '2.5000', '1.250000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1475, '417717117568', 'MONEDERO ECONOMICO', '1.0000', '0.650000', 3, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1476, '042100314', 'SPLASH GLAM ANGEL', '7.5000', '3.750000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1477, '042100306', 'SPLASH CAKE CONFETI', '7.5000', '3.750000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1478, '082100036', 'SPLAH MOONLIT DAHLIA', '7.0000', '3.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1479, '082100037', 'SPLASH PUNCHY BLOOMS', '7.5000', '2.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1480, '082100038', 'SPLASH SHOT OF COCONUT', '7.5000', '2.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1481, '085447276336', 'PERFUME CYZONE SWEET BLACK', '15.0000', '7.500000', 2, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1482, '360160033566', 'PERFUME ESIKA VIBRANZA BLANC', '20.0000', '9.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, NULL, NULL, NULL, 11),
(1483, '510715047763', 'PERFUME CYZONE FEEL', '15.0000', '7.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1484, '042100333', 'PERFUME CABALLERO RACING CLUB BLACK', '16.0000', '8.000000', 1, 'Accesorios de Hombre', 0, NULL, NULL, NULL, 1, NULL, NULL, 17),
(1485, '547304261724', 'PERFUME CABALLERO ESIKA LEYENDA ABSOLUTE', '28.0000', '14.000000', 1, 'Accesorios de Hombre', 0, NULL, NULL, NULL, 1, NULL, NULL, 17),
(1486, '042100341', 'PERFUME CABALLERO KML SEVEN FIVE SEVEN PARTY', '16.0000', '8.000000', 1, 'Accesorios de Hombre', 0, NULL, NULL, NULL, 1, NULL, NULL, 17),
(1487, '042100325', 'PERFUMRE CABALLERO KLM ARMY SPORT', '16.0000', '8.000000', 1, 'Accesorios de Hombre', 0, NULL, NULL, NULL, 1, NULL, NULL, 17),
(1488, '042100331', 'PERFUME CABALLERO KLM SEVEN FIVE SEVEN GRIS', '16.0000', '8.000000', 1, 'Accesorios de Hombre', 0, NULL, NULL, NULL, 1, NULL, NULL, 17),
(1489, '446365652161', 'PERFUME CABALLERO CYZONE FIST', '15.0000', '7.500000', 4, 'Accesorios de Hombre', 0, NULL, NULL, NULL, 1, NULL, NULL, 17),
(1490, '032110560763', 'PERFUME DE CABALLERO ESIKA MAGNAT', '28.0000', '14.000000', 4, 'Accesorios de Hombre', 0, NULL, NULL, NULL, 1, NULL, NULL, 17),
(1491, '7501035908246', 'ACEITE BABY MAGIC 100ML', '2.2500', '1.600000', 2, 'BEBE', 0, NULL, NULL, NULL, 1, NULL, NULL, 5),
(1492, '7702031260486', 'VASELINA BABY JOHNSON\'S 100G', '4.7500', '3.900000', NULL, 'BEBE', 0, NULL, NULL, NULL, 2, NULL, NULL, 5),
(1493, '7891010031046', 'ACEITE BABY JOHNOSON\'S 100ML', '2.5000', '1.600000', 3, 'BEBE', 0, NULL, NULL, NULL, 3, NULL, NULL, 5),
(1494, '7501035908123', 'TALCO BABY MAGIC 100G', '2.0000', '1.600000', 3, 'BEBE', 0, NULL, NULL, NULL, 3, NULL, NULL, 5),
(1495, '7702031293231', 'SHAMPOO JOHNSON\'S BABY 200ML', '5.0000', '2.200000', 3, 'BEBE', 0, NULL, NULL, NULL, 3, NULL, NULL, 5),
(1496, '052100072', 'SPORT FASHION KML NIÑA', '18.0000', '10.500000', 0, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1497, '441404854827', 'SPORT TORBA KML NIÑO', '18.0000', '10.500000', 2, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1498, '741045446231', 'ACETONA GLAMOUR 70ML', '0.7500', '0.375000', 12, 'Sin Departamento', 0, NULL, NULL, NULL, 0, NULL, NULL, 7),
(1499, '001171377075', 'Lego Bolsa Pequeña', '3.0000', '1.500000', 0, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(1500, '765717217871', 'PAPEL BOND PLIEGO ROJO', '0.4500', '0.220000', 14, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1501, '437560037074', 'PAPEL BOND PLIEGO AMARILLO', '0.4500', '0.220000', 12, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1502, '847104853110', 'PAPEL BOND PLIEGO NARANJA ', '0.4500', '0.220000', 21, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1503, '305872464706', 'PAPEL BOND PLIEGO NARANJA PALIDO ', '0.4500', '0.220000', 24, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1504, '045365783856', 'PAPEL BOND PLIEGO VERDE PLANTA', '0.4500', '0.220000', 11, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1505, '874384361060', 'PAPEL BOND PLIEGO CELESTE', '0.4500', '0.220000', 15, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1506, '428382887565', 'PAPEL BOND PLIEGO ROSADO', '0.4500', '0.220000', 15, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1507, '373334008348', 'PAPEL BOND PLIEGO ROSADO PALIDO', '0.4500', '0.220000', 23, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1508, '508187730521', 'PAPEL BOND PLIEGO NEGRO', '0.4500', '0.220000', 12, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1509, '185203243035', 'PAPEL BOND PLIEGO MORADO OSCURO', '0.4500', '0.220000', 18, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1510, '505033020064', 'PAPEL BOND PLIEGO MORADO LILA', '0.4500', '0.220000', 24, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1511, '034618740021', 'PAPEL BOND PLIEGO VERDE CLARO', '0.4500', '0.220000', 19, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1512, '775278344508', 'PAPEL BOND PLIEGO VERDE LIMON', '0.4500', '0.220000', 18, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1513, '766617731531', 'PAPEL BOND PLIEGO AZUL OSCURO', '0.4500', '0.220000', 14, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1514, '858763327224', 'PAPEL BOND PLIEGO BLANCO', '0.2500', '0.120000', 411, 'Escolar', 0, NULL, NULL, NULL, 10, NULL, NULL, 3),
(1515, '201862675250', 'AOS FOMY PLIEGO LSO NEGRO', '1.4500', '0.900000', 7, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1516, '365674075002', 'AOS FOMY PLIEGO LSO SALMON ', '1.4500', '0.900000', 8, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1517, '667112641103', 'AOS FOMY PLIEGO LSO CELESTE ', '1.4500', '0.900000', 4, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1518, '247262676510', 'AOS FOMY PLIEGO LSO VERDE CLARO', '1.4500', '0.900000', 9, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3);
INSERT INTO `Hoja1` (`id_producto`, `Codigo`, `Nombre`, `Precio_de_venta`, `Precio_de_compra`, `Cantidad`, `Marca`, `Descuento`, `Descripcion`, `Imagen`, `Ubicacion`, `StockMinimo`, `PrecioMayoreo`, `PrecioDistribuidor`, `id_categoria`) VALUES
(1519, '533143466056', 'AOS FOMY PLIEGO LSO ROSA', '1.4500', '0.900000', 10, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1520, '055402532563', 'AOS FOMY PLIEGO LSO AZUL OSCURO', '1.4500', '0.900000', 6, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1521, '221826080220', 'AOS FOMY PLIEGO LSO MORADO OSCURO', '1.4500', '0.900000', 10, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1522, '534423667864', 'TUCAN FOMY PLIEGO LSO ROJO ', '1.4500', '0.900000', 7, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1523, '785348221533', 'TUCAN FOMY PLIEGO LSO NEGRO', '1.4500', '0.900000', 10, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1524, '878131150562', 'TUCAN FOMY PLIEGO LSO AMARILLO', '1.4500', '0.900000', 9, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1525, '741133043758', 'TUCAN FOMY PLIEGO LSO BLANCO', '1.4500', '0.900000', 8, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1526, '175283488376', 'TUCAN FOMY PLIEGO LSO MORADO OSCURO', '1.4500', '0.900000', 7, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1527, '027514613776', 'TUCAN FOMY PLIEGO LSO CAFE', '1.4500', '0.900000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1528, '832432858040', 'TUCAN FOMY PLIEGO LSO NARANJA', '1.4500', '0.900000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1529, '630340571124', 'PAPEL LUSTRE PLIEGO AZUL ', '0.2000', '0.110000', 7, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1530, '465505231070', 'PAPEL LUSTRE PLIEGO AMARILLO', '0.2000', '0.110000', 10, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(1531, '270676087033', 'PAPEL LUSTRE PLIEGO VERDE CLARO', '0.2000', '0.110000', 2, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(1532, '387726453835', 'PAPEL LUSTRE PLIEGO NARANJA ', '0.2000', '0.110000', 30, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(1533, '373267680126', 'PAPEL LUSTRE PLIEGO CELESTE', '0.2000', '0.110000', -6, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(1534, '602663403267', 'PAPEL LUSTRE PLIEGO MORADO', '0.2000', '0.110000', 43, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(1535, '143713216051', 'PAPEL LUSTRE PLIEGO ROSADO', '0.2000', '0.110000', 36, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(1536, '821211831238', 'PAPEL LUSTRE PLIEGO VERDE OSCURO', '0.2000', '0.110000', 42, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(1537, '788843827230', 'PAPEL LUSTRE PLIEGO NEGRO', '0.2000', '0.110000', 46, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(1538, '673238566776', 'PAPEL LUSTRE PLIEGO CAFE', '0.2000', '0.110000', 25, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(1539, '450110727087', 'PAPEL LUSTRE PLIEGO ROSA VIEJA', '0.2000', '0.110000', 37, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(1540, '673675381460', 'PAPEL LUSTRE PLIEGO BLANCO ANGEL', '0.2000', '0.110000', 25, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(1541, '622532360844', 'PAPEL LUSTRE PLIEGO VERDE TURQUEZA', '0.2000', '0.110000', 40, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(1542, '281361772307', 'PAPEL LUSTRE PLIEGO ROJO', '0.2000', '0.110000', -5, NULL, 0, NULL, NULL, NULL, 3, NULL, NULL, 1),
(1543, '330730051558', 'MOCHILA TRANSPARENTE COLORES', '12.0000', '8.500000', 9, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1544, '315471851108', 'ESTUCHE ZIPER FOLDER CARTA', '2.0000', '1.250000', 23, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(1545, '834416086657', 'ESTUCHE TELA NIÑA EVA', '2.5000', '1.500000', 5, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1546, '146160488521', 'PORTALAPIZ IMPERMEABLE SURTIDO', '1.2500', '0.750000', 9, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(1547, '520216468533', 'PORTALAPIZ TRANSPARENTE SURTIDO', '1.2500', '0.750000', 25, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(1548, '562410125162', 'CARTUCHERA RECTANGULAR SATIN', '2.5000', '1.500000', 7, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1549, '583225432585', 'PORTALAPIZ ACORDEON TELA', '3.5000', '2.250000', 3, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1550, '7502230941649', 'BON O BON CAJA LISTON', '3.2500', '2.540000', 13, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(1551, '7502230949867', 'BON O BON VITROLERO', '3.9500', '3.050000', 3, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(1552, '8434153180012', 'BANNER FALIZ CUMPLEAÑOS ECO', '1.5000', '0.650000', 9, 'FIESTA', 0, NULL, NULL, NULL, 2, NULL, NULL, 6),
(1553, '551105343012', 'BAMBARY LISTON PARA CHONGA DELGADA BLANCO 100 YARDAS', '2.0000', '1.000000', 0, 'Escolar', 0, NULL, NULL, NULL, 0, NULL, NULL, 3),
(1554, '038165607560', 'JUGUETES CARTON POR UNIDAD ', '0.2500', '0.125000', 9, 'Juguetes Unisex', 0, NULL, NULL, NULL, 5, NULL, NULL, 12),
(1555, '243787243447', 'JUGUETES CARTON UNIDAD', '0.5000', '0.250000', 20, 'Juguetes Niño', 0, NULL, NULL, NULL, 5, NULL, NULL, 10),
(1556, '144315744503', 'SET DE GANCHOS NIÑA', '1.5000', '0.900000', 6, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(1557, '060127764683', 'TIRRO BLUE BOLD 2X30 YRDS', '3.2500', '2.110000', 12, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1558, '724688247174', 'PAPEL CARTULINA INDEX BLANCO ', '0.2500', '0.110000', 21, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1559, '775858017782', 'PAPEL CARTULINA INDEX VERDE', '0.2500', '0.110000', 136, NULL, 0, NULL, NULL, NULL, 5, NULL, NULL, 1),
(1560, '630248350778', 'PAPEL CARTULINA INDEX CELESTE ', '0.2500', '0.110000', 140, NULL, 0, NULL, NULL, NULL, 5, NULL, NULL, 1),
(1561, '422453621424', 'PAPEL CARTULINA INDEX ROSADO ', '0.2500', '0.110000', 135, NULL, 0, NULL, NULL, NULL, 5, NULL, NULL, 1),
(1562, '876340030134', 'PAPEL CARTULINA INDEX AMARILLO', '0.2500', '0.110000', 96, NULL, 0, NULL, NULL, NULL, 5, NULL, NULL, 1),
(1563, '781850851647', 'BOLSA DE REGALO MEDIANO', '2.0000', '1.100000', 29, 'FIESTA', 0, NULL, NULL, NULL, 2, NULL, NULL, 6),
(1564, '6916112435408', 'STICKERS LABELS ROTULADOR CUADERNO', '0.3000', '0.150000', 47, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1565, '6938128389889', 'STICKER ROTULADOR CUADERNO CON DISEÑO', '0.2500', '0.080000', 19, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1566, '816836680285', 'POP IT COLLAR COLORES', '3.0000', '1.750000', 4, 'Juguetes Unisex', 0, NULL, NULL, NULL, 3, NULL, NULL, 12),
(1567, '20\'38', 'mini funny telephone ', '10.0000', '5.000000', -1, 'Juguetes Unisex', 0, NULL, NULL, NULL, NULL, NULL, NULL, 12),
(1568, '426885863208', 'THE TORTOISE WILL LAY EGGS', '8.0000', '4.000000', 0, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(1569, '21\'008', 'CHICKEN TUMBLER', '10.0000', '5.000000', 1, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1570, '18\'199', 'BALANCE CARTOON CAR ELEFANTE', '16.0000', '8.000000', 2, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(1571, '21\'117', 'GUITARRA MUSICAL ', '4.0000', '2.000000', 2, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1572, '21\'067', 'ANIMAL PUZZLE TOYS', '3.7500', '1.875000', 4, 'Navideño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 8),
(1573, '075656011786', 'SQUIRT DUCKIE', '2.5000', '1.250000', 7, 'Juguetes Unisex', 0, NULL, NULL, NULL, NULL, NULL, NULL, 12),
(1574, '140747720184', 'TAMBOR CHINESE CABBAGE', '1.5000', '0.750000', 2, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1575, '887961780604', 'SET FISHER PRICE PARA BEBE', '28.0000', '14.000000', 1, 'Juguetes Bebe', 0, NULL, NULL, NULL, NULL, NULL, NULL, 16),
(1576, '887961178692', 'CHUPETE FISHER PRICE AGITA SUENA MUERDE', '8.5000', '4.250000', 4, 'Juguetes Bebe', 0, NULL, NULL, NULL, 1, NULL, NULL, 16),
(1577, '21\'093', 'BLOKS EXPAND Y IMAGINATION CON BOLSO', '9.0000', '4.500000', 3, 'Juguetes Unisex', 0, NULL, NULL, NULL, NULL, NULL, NULL, 12),
(1578, '887961179453', 'AGITADOR FISHER PRICE', '8.0000', '4.000000', 3, 'Juguetes Bebe', 0, NULL, NULL, NULL, 1, NULL, NULL, 16),
(1579, '551638856512', 'BABY SOCKS PARA NIÑA ', '1.7500', '0.875000', 4, 'BEBE', 0, NULL, NULL, NULL, 1, NULL, NULL, 5),
(1580, '075656012479', 'TOY TUNES ', '4.5000', '2.250000', 1, 'Juguetes Niño', 0, NULL, NULL, NULL, 1, NULL, NULL, 10),
(1581, '4895038546264', 'AGITADOR WINFUN', '15.5000', '7.750000', 1, 'Juguetes Bebe', 0, NULL, NULL, NULL, 1, NULL, NULL, 16),
(1582, '039897012445', 'JUGUETE SOFIA ', '12.0000', '6.000000', 1, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1583, '4895038502369', 'CUPETE WINFUN', '10.2500', '5.125000', 1, 'Juguetes Bebe', 0, NULL, NULL, NULL, 1, NULL, NULL, 16),
(1584, '887961168655', 'SONIDOS GRACIOSOS FISHER PRICE', '15.0000', '7.500000', 1, 'Juguetes Bebe', 0, NULL, NULL, NULL, 1, NULL, NULL, 16),
(1585, '252708522237', 'SONAJA CON FIJURAS', '1.0000', '0.500000', 2, 'Juguetes Bebe', 0, NULL, NULL, NULL, 1, NULL, NULL, 16),
(1586, '423760253742', 'PONY FIESTA HAZBRO', '5.0000', '2.500000', 1, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(1587, '317323112828', 'PELOTA DESARMABLE', '3.5000', '1.750000', 1, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(1588, '533081018655', 'PONY PELO LARGO HAZBRO', '5.0000', '2.500000', 1, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(1589, '102128444338', 'BICICLETA TIPO CARRUAJE', '4.0000', '2.500000', 2, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1590, '507842103113', 'CAJA DE REGALO PEQUEÑA', '1.0000', '0.650000', 5, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1591, '014737876356', 'CAJITA DE REGALO CUADRADA PARA ANILLO', '0.5000', '0.300000', 14, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1592, '457716072070', 'CAJITAS DE REGALO REDONDAS', '0.6500', '0.300000', 15, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1593, '724527572580', 'CAJA DE REGALO GRANDE', '1.5000', '0.750000', 5, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1594, '047715463186', 'CAJAS ARMABLES DECORADAS ', '0.3000', '0.130000', 32, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 5, NULL, NULL, 13),
(1595, '637510166654', 'CAJA DE CART ON ARMABLE ', '4.5000', '2.250000', 2, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1596, '862887507538', 'BOLSITAS DE CHOCOLATE ', '1.0000', '0.400000', 9, 'FIESTA', 0, NULL, NULL, NULL, 2, NULL, NULL, 6),
(1597, '822882883381', 'CAJITA DE CHOCOLATA SIRENITA', '0.5000', '0.270000', 6, 'FIESTA', 0, NULL, NULL, NULL, 2, NULL, NULL, 6),
(1598, '240224006763', 'OSITOS PEQUEÑOS', '2.0000', '0.500000', 4, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1599, '824805535283', 'ROSAS ROJAS LOVE', '0.7500', '0.350000', 13, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1600, '783383302144', 'OSITO DE ROSA', '0.5000', '0.250000', 1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1601, '220381460464', 'OSITOS POLARES PEQUEÑOS', '0.7500', '0.375000', 3, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1602, '121524031051', 'BASE PARA ARREGLO PEQUEÑO', '2.0000', '1.000000', 2, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1603, '223784121182', 'BASE PARA ARREGLO GRANDE', '3.5000', '1.750000', 3, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1604, '075146013336', 'PELOTA DE FUT BOL REFALO', '2.0000', '1.250000', 2, 'Sin Departamento', 0, NULL, NULL, NULL, 1, NULL, NULL, 7),
(1605, '553783774314', 'BOLSA DE CHOCOLATE ROJA', '0.7500', '0.400000', 2, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(1606, '420141253861', 'CAJA DE CHOCOLATE CON VENTANA', '2.2300', '1.750000', 6, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(1607, '121144253704', 'TAZA DE AMOR', '2.5000', '1.400000', -8, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(1608, '016183608325', 'CAJA DE VIDRIO ', '1.0000', '0.650000', 5, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(1609, '813688377652', 'PAPEL CHINA ROSADO PALIDO', '0.1000', '0.050000', 16, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(1610, '848431124428', 'FOLLETO EDUCACTIVO NIÑA', '1.0000', '0.500000', 5, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1611, '4712302211881', 'CONKI EQUIPO DE GEOMETRIA 20 CM', '0.6000', '0.340000', 22, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1612, '768497347106', 'FACELA ESTUCHE DE GEOMETRIA 30 CM', '1.5000', '1.050000', 20, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1613, '768497347113', 'FACELA ESTUCHE DE GEOMETRIA CON COMPAS 20 CM', '1.5000', '1.050000', 8, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1614, '165522433254', 'TIBURON LANA BOYO VERDE CLARO', '0.5000', '0.310000', 30, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 5, NULL, NULL, 13),
(1615, '336307633755', 'TIBURON LANA BOYO VERDE OSCURO', '0.5000', '0.310000', 31, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 5, NULL, NULL, 13),
(1616, '510474217574', 'TIBURON LANA BOYO ROJO', '0.5000', '0.310000', 28, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 5, NULL, NULL, 13),
(1617, '625313161224', 'TIBURON LANA BOYO BLANCO', '0.5000', '0.310000', 29, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 5, NULL, NULL, 13),
(1618, '065552082136', 'TIBURON LANA BOYO AMARILLO POLLO', '0.5000', '0.310000', 30, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 5, NULL, NULL, 13),
(1619, '058367736868', 'TIBURON LANA BOYO ROSADO PALIDO', '0.5000', '0.310000', 30, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 5, NULL, NULL, 13),
(1620, '511477377085', 'TIBURON LANA BOYO ROSADO MARAVILLA', '0.5000', '0.310000', 30, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 5, NULL, NULL, 13),
(1621, '272572671228', 'PALO PARA GLOBO CABEZA PEQUEÑA', '0.2500', '0.125000', 33, 'FIESTA', 0, NULL, NULL, NULL, 5, NULL, NULL, 6),
(1622, '587742042173', 'GLOBO METALIZADO PEQUEÑO SURTIDO', '1.0000', '0.500000', 45, 'FIESTA', 0, NULL, NULL, NULL, 5, NULL, NULL, 6),
(1623, '457784745834', 'OSO DE PELUCHE 1 METRO', '28.0000', '20.000000', 1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1624, '758262312328', 'OSO DE PELUCHE METRO 20', '35.0000', '25.000000', 1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1625, '768497998117', 'FACELA CRESPON NARANJA', '0.2500', '0.125000', 35, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1626, '768497998087', 'FACELA CRESPON MORADO LILA', '0.2500', '0.125000', 10, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1627, '8019959514461', 'EVANO CRESPON AMARILLO MOSTAZA', '0.2500', '0.125000', 40, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1628, '8019959514317', 'EVANO CRESPON AMARILLO', '0.2500', '0.125000', 18, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1629, '8019959514355', 'EVANO CRESPON CELESTE CLARO #2', '0.2500', '0.125000', 40, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(1630, '8019959514454', 'EVANO CRESPON VERDE CLARO', '0.2500', '0.125000', 54, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1631, '8019959514447', 'EVANO CRESPON MUSGO', '0.2500', '0.125000', 58, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(1632, '8019959514430', 'EVANO CRESPON ROSADO #1', '0.2500', '0.125000', 30, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1633, '8019959514386', 'EVANO CRESPON MORADO OSCURO', '0.2500', '0.125000', 19, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1634, '577745472042', 'PANDA CRESPON MORADO LILA', '0.2500', '0.125000', 29, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1635, '336326002766', 'PANDA CRESPON MORADO CLARO', '0.2500', '0.125000', 20, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1636, '231764450551', 'PANDA CRESPON SALMON', '0.2500', '0.125000', 30, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1637, '023153152333', 'PANDA CRESPON FUSCIA ', '0.2500', '0.125000', 4, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(1638, '536857312325', 'PANDA CRESPON LILA #2', '0.2500', '0.125000', 20, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1639, '836184236172', 'PANDA CRESPON CELESTE', '0.2500', '0.125000', 29, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1640, '241757654626', 'PANDA CRESPON GRIS ', '0.2500', '0.125000', 50, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1641, '487814728704', 'LIMA PARA UÑA GRANDE ', '0.7500', '0.375000', 0, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1642, '612603156416', 'LIMA PARA UÑA PEQUEÑA ', '0.5000', '0.250000', -1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1643, '7401007600706', 'PLASTICINA BLOCK ROJO', '0.8000', '0.440000', 6, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1644, '7401007600744', 'PLASTICINA BLOCK CAFE', '0.8000', '0.440000', 6, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1645, '7401007600751', 'PLASTICINA BLOCK NARANJA', '0.8000', '0.440000', 6, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1646, '7401007600270', 'PLASTICINA BLOCK GRIS', '0.8000', '0.440000', 6, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1647, '7401007600737', 'PLASTICINA BLOCK NEGRO', '0.8000', '0.440000', 6, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1648, '7401007600683', 'PLASTICINA BLOCK AZUL', '0.8000', '0.440000', 5, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1649, '7401007600720', 'PLASTICINA BLOCK BLANCO', '0.8000', '0.440000', 4, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1650, '7401007607774', 'PLASTICINA BLOCK VIOLETA', '0.8000', '0.440000', 6, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1651, '525706757774', 'OSITO DE PERRITO CAFE', '3.0000', '1.500000', 0, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(1652, '512277117307', 'OSO DE PELUCHE MEDIANO', '12.0000', '6.000000', -1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1653, '7401007600713', 'PLASTICINA BLOCK VERDE', '0.8000', '0.440000', 6, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1654, '7401007600690', 'PLASTICINA BLOCK AMARILLO', '0.8000', '0.440000', 6, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1655, '172317064103', 'BALDE PLAYERO PEQUEÑO', '1.5000', '0.750000', 9, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(1656, '7401007607781', 'PLASTICINA BLOCK AMARILLO ORO', '0.8000', '0.440000', 6, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1657, '7401007607736', 'PLASTICINA BLOCK VERDE LIMA', '0.8000', '0.440000', 6, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1658, '7401007600768', 'PLASTICINA BLOCK ROSADO', '0.8000', '0.440000', 6, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1659, '7401007607767', 'PLASTICINA BLOCK PIEL', '0.8000', '0.440000', 6, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1660, '7401007607743', 'PLASTICINA BLOCK CELESTE', '0.8000', '0.440000', 6, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1661, '7401007607750', 'PLASTICINA BLOCK FUCHSIA', '0.8000', '0.440000', 6, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1662, '782353023102', 'SOBRA DE CEJAS ', '2.0000', '1.000000', 4, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1663, '514320641062', 'OSO DE PELUCHE CON DETALLES ', '15.0000', '7.500000', -1, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(1664, '814700026442', 'TROLLS VOCALES Y NUMEROS ', '1.0000', '0.500000', 3, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(1665, '8823613000173', 'BANNER FELIZ CUMPLEAÑOS ROSA', '3.2500', '2.000000', 3, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(1666, '6980100814940', 'LLAVERO DE LLAMA', '2.5000', '1.250000', 0, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(1667, '771687624887', 'THE TORTOISE WILL LAY EGGS DIS', '4.0000', '2.000000', 0, 'Juguetes Unisex', 0, NULL, NULL, NULL, 0, NULL, NULL, 12),
(1668, '644335457205', 'PAPEL BOND 0.25', '0.2500', '0.130000', 23, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(1669, '738828487133', 'ARO DE LUZ LED CON TRIPODE ', '20.0000', '12.000000', 4, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(1670, '7453086105627', 'BABBARY LISTON GRUESO', '3.2500', '2.200000', 5, 'FIESTA', 0, NULL, NULL, NULL, NULL, NULL, NULL, 6),
(1671, '128415302366', 'LIBRETA PARA COLOREAR', '1.0000', '0.500000', 71, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1672, '77968791', 'PELIKAN TEXTMARKER FLASH', '1.0000', '0.500000', -1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1673, '7410032120257', 'CUADERNO RAYADO #1 SANREY ESPIRAL', '1.0000', '0.600000', 44, 'Escolar', 0, NULL, NULL, NULL, 20, NULL, NULL, 3),
(1674, '7410032120226', 'CUADERNO CUADRO #1 SANREY', '1.0000', '0.600000', 56, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(1675, '75024635', 'CREMINO', '0.2500', '0.125000', 15, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1676, '674102541380', 'PULPITO ROSA REVERSIBLE ', '5.0000', '2.500000', 2, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1677, '6855271226536', 'BOLSA DE REGALO S ECO NIÑA ', '0.5000', '0.350000', 10, 'BOLSAS', 0, NULL, NULL, NULL, 1, NULL, NULL, 14),
(1678, '306308602751', 'LAMINA ESCOLAR SURTIDA', '1.5000', '0.750000', 76, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1679, '574187446247', 'BOLSA DE REGALO M CORAZONES CARTON ', '1.5000', '1.100000', 6, 'BOLSAS', 0, NULL, NULL, NULL, 1, NULL, NULL, 14),
(1680, '513068887684', 'BOLSA DE REGALO S CTON MARIPOSAS ', '1.0000', '0.650000', 8, 'BOLSAS', 0, NULL, NULL, NULL, 1, NULL, NULL, 14),
(1681, '8808739000054', 'BOLSA DE REGALO KML CPRAZON', '1.2500', '0.900000', 0, 'BOLSAS', 0, NULL, NULL, NULL, 0, NULL, NULL, 14),
(1682, '221457624370', 'BOLSA DE REGALO XS CON PESTAÑA ', '1.2500', '0.900000', 5, 'BOLSAS', 0, NULL, NULL, NULL, 1, NULL, NULL, 14),
(1683, '0074323011616', 'BUBU LUBU MINI', '0.2500', '0.125000', 2, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(1684, '8881691606700', 'BOLSA DE REGALO M OSO ECO.', '1.0000', '0.650000', 12, 'BOLSAS', 0, NULL, NULL, NULL, 1, NULL, NULL, 14),
(1685, '8881691607424', 'BOLSA DE REGALO M MARIPOSA ECO.', '1.0000', '0.650000', 3, 'BOLSAS', 0, NULL, NULL, NULL, 1, NULL, NULL, 14),
(1686, '6965154170723', 'BOLSA DE REGALO M CARTON CORAZONES ', '1.5000', '0.900000', 7, 'BOLSAS', 0, NULL, NULL, NULL, 1, NULL, NULL, 14),
(1687, '6935702899079', 'BOLSA DE REGALO M CARTON TRIAGULAR ', '1.5000', '0.900000', 7, 'BOLSAS', 0, NULL, NULL, NULL, 1, NULL, NULL, 14),
(1688, '6958288885236', 'BOLSA DE REGALO M CARTON CON GLOBOS ', '1.5000', '0.900000', 8, 'BOLSAS', 0, NULL, NULL, NULL, 1, NULL, NULL, 14),
(1689, '385207572720', 'BOLSA DE REGALO M SURTIDA ', '1.0000', '0.650000', 21, 'BOLSAS', 0, NULL, NULL, NULL, 1, NULL, NULL, 14),
(1690, '877616725722', 'BOLSA DE REGALO M CARTON SUTIDA ', '1.5000', '0.900000', 37, 'BOLSAS', 0, NULL, NULL, NULL, 5, NULL, NULL, 14),
(1691, '6666600016113', 'BOLSA DE REGALO M CARTON SOLO FONDO', '2.0000', '1.450000', 0, 'BOLSAS', 0, NULL, NULL, NULL, 1, NULL, NULL, 14),
(1692, '844518006495', 'BOLSA DE REGALO L SOLO FONDO', '2.0000', '1.450000', 7, 'BOLSAS', 0, NULL, NULL, NULL, 2, NULL, NULL, 14),
(1693, '8201107165124', 'BOLSA DE REGALO L GRADUACION ECO', '1.2500', '0.750000', 4, 'BOLSAS', 0, NULL, NULL, NULL, 2, NULL, NULL, 14),
(1694, '1698588021419', 'BOLSA DE REGALO L CARTON OSO', '2.0000', '1.600000', 8, 'BOLSAS', 0, NULL, NULL, NULL, 2, NULL, NULL, 14),
(1695, '246485720174', 'BOLSA DE REGALO L OSO ECO', '1.5000', '0.900000', 1, 'BOLSAS', 0, NULL, NULL, NULL, 2, NULL, NULL, 14),
(1696, '883316235734', 'BOLSA DE REGALO L CARTON BLANCO NEGRO GRIS', '2.0000', '1.450000', 4, 'BOLSAS', 0, NULL, NULL, NULL, 2, NULL, NULL, 14),
(1697, '888626687261', 'BOLSA DE REGALO L CARTON ROSAS', '2.0000', '1.450000', 8, 'BOLSAS', 0, NULL, NULL, NULL, 2, NULL, NULL, 14),
(1698, '6958288885656', 'BOLSAS DE REGALO L CUMPLEAÑOS ECO', '1.5000', '0.900000', 2, 'BOLSAS', 0, NULL, NULL, NULL, 2, NULL, NULL, 14),
(1699, '835137200514', 'BOLSA DE REGALO L CARTON BODA ', '2.0000', '1.450000', 12, 'BOLSAS', 0, NULL, NULL, NULL, 2, NULL, NULL, 14),
(1700, '7501091817070', 'BOLSA DE REGALO L CARTON NAVIDEÑA FROZEN', '2.0000', '1.450000', 11, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1701, '6979007919322', 'BOLSA DE REGALO L CARTON CUMPLEAÑOS', '2.0000', '1.450000', 6, 'BOLSAS', 0, NULL, NULL, NULL, 2, NULL, NULL, 14),
(1702, '516241625088', 'BOLSA DE REGALO S PAPEL CRAFT NARANJA', '0.5000', '0.350000', -4, 'BOLSAS', 0, NULL, NULL, NULL, 2, NULL, NULL, 14),
(1703, '489299141012', 'BOLSA DE REGALO M BODA ECO', '0.7500', '0.450000', 4, 'BOLSAS', 0, NULL, NULL, NULL, 2, NULL, NULL, 14),
(1704, '6972526711231', 'BOLSA DE REGALO S CARTON MERRY CHRISTMAS', '1.2500', '0.900000', 1, 'BOLSAS', 0, NULL, NULL, NULL, 2, NULL, NULL, 14),
(1705, '6972526714126', 'BOLSA DE REGALO PARA VINO', '2.0000', '1.450000', 5, 'BOLSAS', 0, NULL, NULL, NULL, 2, NULL, NULL, 14),
(1706, '122100725', 'DIADEMAS PERLA DORADA KML', '2.5000', '1.250000', 7, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(1707, '122100724', 'DIADEMA PERLA DOS LINEAS PEQUEÑA', '2.5000', '1.250000', 9, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(1708, '122100014', 'MOCHILA PARA NIÑA KML COLORES', '16.0000', '9.350000', 5, 'Escolar', 0, NULL, NULL, NULL, NULL, 0, NULL, 3),
(1709, '122100017', 'MOCHILA SPORT JINGPIN COLORES', '18.0000', '10.200000', 0, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1710, '668663261527', 'ARREGLO EN CAJA CON PELUCHE', '2.5000', '0.750000', 10, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 2, NULL, NULL, 13),
(1711, '7417200623787', 'BEXCELENT GRAPADO RAYADO 100 H', '0.4500', '0.270000', 200, NULL, 0, NULL, NULL, NULL, 12, NULL, NULL, 1),
(1712, '6925871616317', 'AUDIFONOS ET-A1631M', '5.0000', '2.000000', 4, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(1713, '860100201580', 'CABLE AUX. 3.5 S-JY-01-580', '2.5000', '1.500000', 5, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(1714, 'EHS61ASFWE)GH59\'11849A=', 'SAMSUNG GALAXY AUDIFONOS PASTILLA', '3.5000', '1.750000', 0, 'Tecnología', 0, NULL, NULL, NULL, NULL, NULL, NULL, 9),
(1715, '6925871618281', 'EWTTO ET-A1828M AUDIFONOS', '5.0000', '1.750000', 5, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(1716, '782547006670', 'HEADLIGHT LAMPARA PARA CABEZA', '18.0000', '8.500000', 2, 'Tecnología', 0, 'INCLUYE BATERIAS RECARGABLES', NULL, NULL, 0, NULL, NULL, 9),
(1717, '721282405351', 'NATUCHIPS LAYS', '0.2500', '0.125000', 6, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1718, '876066124180', 'STICKER FLORES FOMY', '0.3000', '0.150000', -49, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1719, '215450068216', 'CARTUCHERA ZIPPER TRANSPARENTE SURTIDA', '0.5000', '0.250000', 1, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1720, '8840168875131', 'CARTUCHERA ECO. UNICORNIO', '0.7500', '0.200000', 2, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1721, '7702993032954', 'NEXT MENTA MASTICABLE FRESA', '0.1500', '0.075000', 82, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(1722, '7702993030165', 'NEXT MENTA MASTICABLE MENTA', '0.1500', '0.075000', 72, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(1723, '7501017351589', 'SCRIBE CUAD. MM RAY 300 PAGS', '3.2500', '1.900000', 6, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1724, '251586752808', 'BOLSA CELOFAN PEQUEÑA CORAZONES', '0.1500', '0.075000', 82, 'FIESTA', 0, NULL, NULL, NULL, 6, NULL, NULL, 6),
(1725, '753227003380', 'COLOURED HAIR-ELASTICS', '1.0000', '0.500000', 3, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1726, '662730634725', 'SORPRESAS NIÑO', '0.2500', '0.125000', 4, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(1727, '2020112516310', 'GLOBO FELIX CUMPLEAÑOS', '3.9000', '1.800000', 1, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(1728, '2020082489331', 'GLOBO FELIZ CUMPLEAÑOS NIÑA', '3.9000', '1.800000', 1, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(1729, '2020122932155', 'GLOBO FELIZ DIA ', '3.9000', '1.800000', 1, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(1730, '2020090212310', 'FELIZ CUMPLEAÑOS POW', '3.9000', '1.800000', 1, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(1731, '182863564284', 'PULPO LLAVERO PEQUEÑO ', '3.0000', '0.500000', 0, 'Sin Departamento', 0, NULL, NULL, NULL, 2, NULL, NULL, 7),
(1732, '021427507424', 'PAPEL BOND PAQUETE DE COLOR 20 H', '1.0000', '0.750000', -14, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 1),
(1733, '7506129454395', 'SCRIBE COS. ANOTA CUADRO GNDE 200 PGS', '1.9000', '1.050000', 86, 'Escolar', 0, NULL, NULL, NULL, 12, NULL, NULL, 3),
(1734, '721282403616', 'LAYS CAMPERO 24G', '0.5000', '0.400000', 6, 'Golocinas', 0, NULL, NULL, NULL, 0, NULL, NULL, 2),
(1735, '721282403692', 'CRUJITOS QUESO CHILE 17G', '0.2500', '0.200000', 0, 'Sin Departamento', 0, NULL, NULL, NULL, NULL, NULL, NULL, 7),
(1736, '7502230941656', 'BON O BON CORAZON DILO', '2.5500', '2.020000', 10, 'Golocinas', 0, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(1737, '885841162556', 'BUTTER TOFFES CHOKKO DULCES', '0.0500', '0.037000', 134, 'Golocinas', 0, NULL, NULL, NULL, 10, NULL, NULL, 2),
(1738, '7790040613706', 'BON O BON ALFAJOR', '0.5500', '0.400000', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1739, '422182042184', 'LLAVERO AGUACATE CON BRILLOS', '3.0000', '1.500000', 1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1740, '176575784705', 'BEXCELENT FOLDER CRTA COLOR MORADO', '0.2000', '0.100000', 29, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(1741, '574040507872', 'BEXCELENT FOLDER CRTA COLOR CAFE', '0.2000', '0.100000', 30, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1742, '873440158272', 'BEXCELENT FOLDER CRTA COLOR SALMON', '0.2000', '0.100000', 24, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1743, '078126631338', 'BEXCELENT FOLDER CRTA COLOR ROJO', '0.2000', '0.100000', 30, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1744, '824008126861', 'BEXCELENT FOLDER CRTA COLOR FUXIA', '0.2000', '0.100000', 30, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1745, '463274786204', 'OPALINA 10 UNIDADES ', '1.5000', '1.000000', 11, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(1746, '731153356776', 'BEXCELENT FOLDER CRTA COLOR MORADO LILA', '0.2000', '0.100000', 10, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1747, '682731367671', 'BEXCELENT FOLDER CRTA COLOR ANARANJADO', '0.2000', '0.100000', 28, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1748, '482357636876', 'BEXCELENT FOLDER CRTA COLOR VERDE', '0.2000', '0.100000', 30, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1749, '627003684270', 'BEXCELENT FOLDER CRTA COLOR AMARILO', '0.2000', '0.100000', 30, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1750, '677353380172', 'BEXCELENT FOLDER CRTA COLOR NEGRO', '0.2000', '0.100000', 29, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1751, '001230476616', 'BEXCELENT FOLDER CRTA COLOR CAFE OSCURO', '0.2000', '0.100000', 29, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1752, '084127225613', 'BEXCELENT FOLDER CRTA COLOR VERDE OSCURO', '0.2000', '0.100000', 29, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1753, '371158838645', 'CAJA DE SACAPUNTAS TUCAN', '3.5000', '2.900000', 0, 'Escolar', 0, NULL, NULL, NULL, 0, NULL, NULL, 3),
(1754, '473015680817', 'CAJA DE BIC SURTIDA ', '2.2500', '1.900000', 0, 'Escolar', 0, NULL, NULL, NULL, 0, NULL, NULL, 3),
(1755, '576733135754', 'CAJA DE LAPIZ FACELA 144 UNI.', '17.2800', '14.400000', 0, 'Escolar', 0, NULL, NULL, NULL, 0, NULL, NULL, 3),
(1756, '743155686155', 'RESMA DE PAPEL COLOR SURTIDA', '10.5000', '8.500000', 0, 'Escolar', 0, NULL, NULL, NULL, 0, NULL, NULL, 3),
(1757, '165220284713', 'IRASA FOLDER COLOR OFICIO VERDE OSCURO', '0.2500', '0.125000', 9, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(1758, '678335526202', 'IRASA FOLDER COLOR OFICIO ROSADO PALIDO', '0.2500', '0.125000', 7, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1759, '747224067605', 'IRASA FOLDER COLOR OFICIO OCRE', '0.2500', '0.125000', 3, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1760, '836246052085', 'IRASA FOLDER COLOR OFICIO CELESTE', '0.2500', '0.125000', 9, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1761, '051583806132', 'IRASA FOLDER COLOR OFICIO AZUL', '0.2500', '0.125000', 8, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1762, '622347202617', 'IRASA FOLDER COLOR OFICIO ROJO', '0.2500', '0.125000', 1, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1763, '276612021362', 'LLAVERO EQUIPO ECO', '0.2500', '0.125000', 7, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1764, '7410032120769', 'CUADERNO COSIDO PEQUE ACADEMICO LISO', '1.0000', '0.700000', 49, 'Escolar', 0, NULL, NULL, NULL, 10, NULL, NULL, 3),
(1765, '7416500226445', 'CUADERNO DOBLE RAYA PEQUE CONQUISTADOR', '1.0000', '0.630000', 45, 'Escolar', 0, NULL, NULL, NULL, 10, NULL, NULL, 3),
(1766, '7450030268186', 'BOTELLA PLASTICA PRINCESA 500ML.', '5.9000', '3.860000', 6, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1767, '371206014628', 'BOTELLA PLASTICA FENG HONG 500ML', '5.3500', '3.500000', 0, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1768, '768497135284', 'LIBRO ORDER FACELA 144 PG.', '1.5000', '0.950000', 9, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1769, '7453037803923', 'BOLSON MED RUSTY', '10.0000', '5.550000', 2, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1770, '9788492808274', 'BOLSON PEQUE ABACUS MARIPOSA ', '10.0000', '7.350000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1771, '216440847687', 'BOLSON MINNIE MOCHILA', '15.0000', '9.890000', 2, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1772, '7453037846388', 'BOLSON PRINCESA DISNEY ', '15.0000', '9.200000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1773, '7453074525079', 'BOLSON PRINCESA SOFIA ', '12.0000', '7.910000', 0, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1774, '7453037834828', 'BOLSON PHINEAS Y FERB ', '15.0000', '9.580000', 0, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1775, '7453037816749', 'BOLSON CRUZADO TRANSP SAMSPORT', '8.0000', '3.980000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1776, '7453038492706', 'BARRA DE SILICON GRUESA', '0.3500', '0.240000', 50, 'Escolar', 0, NULL, NULL, NULL, 10, NULL, NULL, 3),
(1777, '6755668935648', 'STIKER DIAMANTE ', '1.0000', '0.450000', 7, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(1778, '6922468691085', 'PORTA LAPIZ METALICA SURTIDO', '2.0000', '0.800000', 8, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(1779, '230420417856', 'STICKER PEQUEÑO CELULAR ', '0.2500', '0.110000', 37, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1780, '585746061275', 'PORTA LAPIZ TELA ECONOMICO', '0.7500', '0.300000', 19, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(1781, '357588845820', 'LONCHERA ECONOMICA SURTIDA', '2.2500', '1.500000', 5, NULL, 0, NULL, NULL, NULL, 4, NULL, NULL, 1),
(1782, '283626850131', 'MOCHILA PEQUEÑA SURTIDA ', '5.0000', '3.750000', 6, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1783, '541863225234', 'MOCHILA SPORT ECONOMICA', '7.0000', '4.500000', 12, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(1784, '073537107187', 'ATOMIZADOR DE 50ML.', '0.7500', '0.300000', 20, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 6, NULL, NULL, 13),
(1785, '682238408126', 'CARTULINA IRIS AMARILLO', '0.4000', '0.230000', 17, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1786, '346704035620', 'CARTULINA IRIS AZUL OSCURO', '0.4000', '0.230000', 12, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1787, '436688552317', 'CARTULINA IRIS MORADO', '0.4000', '0.230000', 5, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1788, '504452545435', 'CARTULINA IRIS CAFE', '0.4000', '0.230000', 4, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1789, '315388413817', 'CARTULINA IRIS NARANJA', '0.4000', '0.230000', 5, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1790, '833566432263', 'CARTULINA IRIS VERDE OSCURO', '0.4000', '0.230000', 2, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1791, '332571131214', 'GANCHO CORAZON PERLA', '2.0000', '1.000000', 3, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1792, '850157658353', 'GANCHO BANANA ECO', '1.0000', '0.500000', 5, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1793, '310238860306', 'FIGURA FOMY ESTRELLA', '0.2500', '0.120000', 0, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(1794, '423312702186', 'GANCHO GRANDE DE PELO', '0.7500', '0.375000', 3, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 1),
(1795, '331484133087', 'GANCHO MEDIANO DE PELO', '0.2500', '0.125000', 20, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1796, '200768255284', 'GANCHO DE PELO AVANICO', '0.3500', '0.175000', 10, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1797, '845384028841', 'STICKER HOME DECOR GRANDE', '2.5000', '1.250000', 13, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 2, NULL, NULL, 13),
(1798, '7807265057687', 'PAPEL CORRUGADO SURTIDO', '0.4000', '0.200000', 13, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1799, '8435373023745', 'PAPEL FIELTRO CARTA SURTIDO', '0.3500', '0.150000', 37, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(1800, '877337667654', 'CARTULINA IRIS NEGRA', '0.4500', '0.225000', 0, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1801, '265288506522', 'FOMY PEQUEÑO NUMEROS ', '0.2500', '0.125000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1802, '7401007600010', 'TUCAN TEMPERA CLASICA 6 COLORES', '2.3000', '1.590000', 23, 'Escolar', 0, NULL, NULL, NULL, 10, NULL, NULL, 3),
(1803, '4895038501836', 'WINFUN SONAJERO BEBE', '5.9000', '2.950000', 2, 'Juguetes Bebe', 0, NULL, NULL, NULL, 1, NULL, NULL, 16),
(1804, '7401005403033', 'ESMALTE BLANCO DORASA', '0.7500', '0.550000', 2, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1805, '7702111835641', 'NORMA CUAD. RAY XPRESARTE GDE. 80 H', '3.5000', '1.980000', 7, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1806, '7702111453241', 'NORMA LAPICEZ GRAFITO 12 U. TRIANG', '2.4000', '1.125000', 0, 'Escolar', 0, NULL, NULL, NULL, 0, NULL, NULL, 3),
(1807, '7702111811980', 'NORMA CSIDO KIUT GDE C7 100 H', '4.9000', '3.380000', 8, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1808, '782877334112', 'CARTULINA BLANCA GOLDEN ', '0.3500', '0.175000', 35, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(1809, '7502211255017', 'VEJIGA METALIZADA VERDE', '3.7500', '1.875000', 2, 'Sin Departamento', 0, NULL, NULL, NULL, 1, NULL, NULL, 7),
(1810, '084416718657', 'CABEZAL DE CARGA APPLE', '3.5000', '1.750000', 9, 'Tecnología', 0, NULL, NULL, NULL, 2, NULL, NULL, 9),
(1811, '602465401534', 'CARGADOR MTMAX 2.4 A', '5.0000', '2.500000', 0, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(1812, '438252838306', 'CUADERNILLA RAYADA OFICIO', '0.2500', '0.125000', 97, 'Escolar', 0, NULL, NULL, NULL, 10, NULL, NULL, 3),
(1813, '6531990522660', 'STICKER ABECEDARIO SURTIDO', '1.0000', '0.500000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1814, '7896075701040', 'PINZAS PARA CEJAS', '0.5000', '0.250000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 2, NULL, NULL, 11),
(1815, '378343834148', 'KNAIL UÑAS POSTIZAS', '1.0000', '0.750000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 0, NULL, NULL, 11),
(1816, '163553016000', 'FRUTA SECA DESHIDRATADA', '1.0000', '0.500000', 1, 'Golocinas', 0, NULL, NULL, NULL, 2, NULL, NULL, 2),
(1817, '7401007606685', 'TUCAN SILICON LIQUIDO 100 ML ', '1.4000', '0.900000', 3, 'Escolar', 0, NULL, NULL, NULL, 5, NULL, NULL, 3),
(1818, '7401007606692', 'TUCAN SILICON LIQUIDO 250 ML', '3.1500', '1.950000', 9, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1819, '7417200623794', 'BEXCELENT GRAPADO CUADRO 100 H', '0.4500', '0.270000', 214, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(1820, '686157231053', 'UÑAS POSTIZAS DECORADAS', '2.7500', '1.750000', 2, 'Accesorios de Mujer', 0, NULL, NULL, NULL, NULL, NULL, NULL, 11),
(1821, '507658666781', 'LIMA PARA UÑAS', '0.2500', '0.150000', 7, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 3, NULL, NULL, 11),
(1822, '466833473635', 'PELUCHE OSO PANDA GRANDE 22\"', '45.0000', '20.000000', 1, 'PELUCHES', 0, NULL, NULL, NULL, 1, NULL, NULL, 18),
(1823, '674325145177', 'PELUCHE PERRO GRIS GRANDE 35´´', '49.9900', '20.000000', 1, 'PELUCHES', 0, NULL, NULL, NULL, 1, NULL, NULL, 18),
(1824, '582385274614', 'PELUCHE PERRO CAFE CLARO 32 P', '45.9900', '20.000000', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1825, '621285376830', 'PELOTA DE CORCHO PEQUEÑO', '0.6000', '0.450000', 23, 'Juguetes Unisex', 0, NULL, NULL, NULL, 5, NULL, NULL, 12),
(1826, '776348676428', 'PORTA MASCARILLA', '2.0000', '1.500000', -15, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1827, '063687313177', 'HAIR ACCESSORIES GANCHOS', '1.0000', '0.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 0, NULL, NULL, 11),
(1828, '741253123775', 'PELUCHE CONEJA ROSADA 44 P', '47.9900', '20.000000', 1, 'PELUCHES', 0, NULL, NULL, NULL, 1, NULL, NULL, 18),
(1829, '442172234238', 'PELUCHE RINOCERONTE GRIS 24 P', '47.9900', '20.000000', 1, 'PELUCHES', 0, NULL, NULL, NULL, 1, NULL, NULL, 18),
(1830, '037660367266', 'PELUCHE PERRO GOLDEN RITRIEVER 30 P', '35.0000', '20.000000', 1, 'PELUCHES', 0, NULL, NULL, NULL, 1, NULL, NULL, 18),
(1831, '665472756161', 'PELUCHE OSO CAFE 35 P', '45.0000', '20.000000', 1, 'PELUCHES', 0, NULL, NULL, NULL, 1, NULL, NULL, 18),
(1832, '781371561861', 'PELUCHE DE OSO DE 28 P', '40.0000', '20.000000', 1, 'PELUCHES', 0, NULL, NULL, NULL, 1, NULL, NULL, 18),
(1833, '777643338014', 'PELUCHE OSO CAFE OSCURO 33 P', '45.0000', '20.000000', 1, 'PELUCHES', 0, NULL, NULL, NULL, 1, NULL, NULL, 18),
(1834, '186034755086', 'PAPEL LUSTRE PLIEGO MOSTAZA', '0.2000', '0.100000', 7, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(1835, '6902021692698', 'AIRBUDS PRO 4 BLUETOOTH', '20.0000', '11.300000', 5, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(1836, '343507214042', 'OSO DE PELUCHE 37\"', '40.0000', '20.000000', 1, 'PELUCHES', 0, NULL, '\\Imagenes\\oso-de-felpa-12-scaled.jpg', NULL, 0, NULL, NULL, 18),
(1837, '033128624687', 'OSO DE PELUCHE DE 26\"', '29.9900', '15.000000', 1, 'PELUCHES', 0, NULL, '\\Imagenes\\oso-de-peluche-26-scaled.jpg', NULL, 0, NULL, NULL, 18),
(1838, '056148106005', 'OSO DE PELUCHE DE 28\"', '40.0000', '20.000000', 1, 'PELUCHES', 0, NULL, '\\Imagenes\\3.jpg', NULL, 0, NULL, NULL, 18),
(1839, '607047788212', 'OSO DE PELUCHE HUGS 20\"', '21.9900', '10.000000', 1, 'PELUCHES', 0, NULL, '\\Imagenes\\4.jpg', NULL, 0, NULL, NULL, 18),
(1840, '381665013132', 'OSO DE PELUCHE MEDIANO 25\"', '29.9900', '15.000000', 1, 'PELUCHES', 0, NULL, '\\Imagenes\\5.jpg', NULL, 0, NULL, NULL, 18),
(1841, '727473773445', 'OSO DE PELUCHE CONEJA OREJAS GRANDES BLANCA 22\"', '24.9900', '15.000000', -1, NULL, 0, NULL, '\\Imagenes\\6.jpg', NULL, 0, NULL, NULL, 1),
(1842, '442838585437', 'OSO DE PELUCHE CONEJA ROSADA 44\"', '47.9900', '20.000000', 1, 'PELUCHES', 0, NULL, '\\Imagenes\\7.jpg', NULL, 0, NULL, NULL, 18),
(1843, '652206003527', 'OSO DE PELUCHE LEON 22\"', '20.9900', '10.000000', 1, 'PELUCHES', 0, NULL, '\\Imagenes\\8.jpg', NULL, 0, NULL, NULL, 18),
(1844, '568077463656', 'OSO DE PELUCHE OSO BLANCO MEDIANO 22\"', '24.9900', '15.000000', 1, 'PELUCHES', 0, NULL, '\\Imagenes\\9.jpg', NULL, 0, NULL, NULL, 18),
(1845, '106463853766', 'OSO DE PELUCHE CAFE ', '42.0000', '20.000000', 1, 'PELUCHES', 0, NULL, '\\Imagenes\\10.jpg', NULL, 0, NULL, NULL, 18),
(1846, '784862614143', 'OSO DE PELUCHE CAFE 35\"', '45.0000', '20.000000', 1, 'PELUCHES', 0, NULL, '\\Imagenes\\11.jpg', NULL, 0, NULL, NULL, 18),
(1847, '560356110180', 'OSO DE PELUCHE CAFE OSCURO 33\"', '45.0000', '20.000000', 1, 'PELUCHES', 0, NULL, '\\Imagenes\\12.jpg', NULL, 0, NULL, NULL, 18),
(1848, '427700341640', 'OSO DE PELUCHE MEDIANO FACE OSCURO 23.5\"', '19.9900', '10.000000', 1, 'PELUCHES', 0, NULL, '\\Imagenes\\13.jpg', NULL, 0, NULL, NULL, 18),
(1849, '573601736247', 'OSO DE PELUCHE PEQUEÑO CAFE OSCURO19\"', '19.9900', '10.000000', 1, 'PELUCHES', 0, NULL, '\\Imagenes\\14.jpg', NULL, 0, NULL, NULL, 18),
(1850, '805625036800', 'OSO DE PELUCHE ROJO 16\"', '19.9900', '10.000000', 1, 'PELUCHES', 0, NULL, '\\Imagenes\\15.jpg', NULL, 0, NULL, NULL, 18),
(1851, '525614005161', 'OSO DE PELUCHE RATON GRIS 22\"', '21.9900', '10.000000', 1, 'PELUCHES', 0, NULL, '\\Imagenes\\16.jpg', NULL, 0, NULL, NULL, 18),
(1852, '741583874672', 'OSO DE PELUCHE PERRO GOLDEN RETRIEVER 30\"', '35.0000', '20.000000', 1, 'PELUCHES', 0, NULL, '\\Imagenes\\18.jpg', NULL, 0, NULL, NULL, 18),
(1853, '6953256201230', 'VELITAS DE CUMPLEAÑOS DE COLORES', '0.7500', '0.450000', 3, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(1854, '7702111521704', 'LAPICES DE COLORES KIUT', '7.0000', '4.320000', 5, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1855, '411061761278', 'ARREIGLO DE TASA Y CHOCOLATE', '3.5000', '1.750000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1856, '7896058257991', 'GALLETA ARCO FORMIS', '0.5000', '0.250000', 8, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1857, '355173858471', 'TABLA PERIODICA CON BORDE ROJO', '1.0000', '0.500000', 1, 'Escolar', 0, NULL, NULL, NULL, 0, NULL, NULL, 3),
(1858, '651228415445', 'TABLA PERIODICA PEQUEÑA ', '0.5000', '0.250000', 7, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1859, '872643811558', 'CARTAPACIO CARTA ', '3.0000', '2.500000', 2, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1860, '063520562288', '25 HOJAS DE PAPEL BOND', '0.4000', '0.175000', 24, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1861, '288437004185', 'CHIN CHIN SONAJA ECO', '0.7500', '0.375000', 10, 'Juguetes Unisex', 0, NULL, NULL, NULL, 2, NULL, NULL, 12),
(1862, '215426571445', 'llavero balon', '1.5000', '0.750000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(1863, '658176216756', 'TUBO BURBUJAS AMARILLO', '0.7500', '0.375000', 0, 'Juguetes Unisex', 0, NULL, NULL, NULL, 0, NULL, NULL, 12),
(1864, '848268317681', '15 PAGINAS PAPEL BOND', '0.2500', '0.125000', NULL, 'Escolar', 0, NULL, NULL, NULL, 0, NULL, NULL, 3),
(1865, '7702111827622', 'NORMA CUADERNO COSIDO RAY PELUCHES', '4.2500', '2.950000', 2, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1866, '7401007608016', 'PAPAEL ADHESIVO 20 M TUCAN ', '16.5000', '12.000000', 3, 'Escolar', 0, NULL, NULL, NULL, 0, NULL, NULL, 3),
(1867, '6925871611473', 'EWTTO ET-P1147B SPEAKER BLUETOOTH', '15.0000', '9.000000', 3, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(1868, '8594015302010', 'PORTAFOLIO CARTA', '3.0000', '1.500000', 8, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1869, '7501906611664', 'PESTAÑOL MANZAN ', '2.0000', '1.500000', 0, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1870, '285167153346', 'CARTULINA IRIS ROJO', '0.4000', '0.230000', 3, 'Escolar', 0, NULL, NULL, NULL, 0, NULL, NULL, 3),
(1871, '801870241700', 'UÑAS DECORACION ', '1.7500', '1.000000', 0, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1872, '602561186886', 'CHONGA', '1.5000', '0.750000', 8, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1873, '7807265011184', 'PROARTE PINCEL #10', '0.7500', '0.450000', 4, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1874, '320283513151', 'PORTAGLOBO', '0.2500', '0.125000', 15, 'FIESTA', 0, NULL, NULL, NULL, 5, NULL, NULL, 6),
(1875, '7502230946927', 'BON O BON GALLETA 12X48G', '6.8500', '4.560000', 3, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(1876, '7891118025329', 'BOLSA DULCES PARTY MIX 4 LB', '7.0000', '5.750000', 2, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(1877, '6855894380684', 'LAPICERO FIGURA 6 COLORES LUZ', '2.7500', '1.000000', 4, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1878, '6965828510121', 'LAPICERO AGUACATE 12 COLORES ', '3.0000', '1.000000', 5, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1879, '658614855260', 'CD EN BLANCO', '0.5000', '0.250000', 22, 'Tecnología', 0, NULL, NULL, NULL, 3, NULL, NULL, 9),
(1880, '6971548800008', 'CINTA DECORADA ', '1.0000', '0.230000', 55, 'Escolar', 0, NULL, NULL, NULL, 10, NULL, NULL, 3),
(1881, '6920150947045', 'ROSA LOVE CON OSITO', '1.2500', '0.500000', 7, 'FIESTA', 0, NULL, NULL, NULL, 2, NULL, NULL, 6),
(1882, '6975254865429', 'STICKY NOTES UNICORNIO', '2.0000', '1.000000', 6, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 2, NULL, NULL, 13),
(1883, '6909620885865', 'AVOCADO AGUACATE ', '2.0000', '1.000000', 6, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 2, NULL, NULL, 13),
(1884, '021082307223', 'PORTALAPIZ TRANSPARENTE AGUACATE', '2.7500', '1.500000', 5, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1885, '7453038403825', 'ALMOHADILLA METALICA AZUL', '2.0000', '1.020000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1886, '7453038403504', 'ALMOHADILLA METALICA NEGRA', '2.0000', '1.020000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1887, '7501428700518', 'ROLAPLICA TINTA PARA ALMOHADILLA', '2.2500', '1.130000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1888, '2021102195720', 'CAJA TASA CON CUCHARA', '4.0000', '2.250000', 1, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(1889, '2021102195737', 'CAJA CON TASA Y CUCHARA LOVE', '4.0000', '2.250000', 1, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(1890, '6906220494121', 'LLAVERO DE STICH CASCABEL', '4.0000', '2.250000', 7, 'FIESTA', 0, NULL, NULL, NULL, 0, NULL, NULL, 6),
(1891, '6906220494152', 'LLAVERO DE MARIO BRO', '4.0000', '2.000000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(1892, '6900200933020', 'LLAVERO JUEGO DEL CALAMAR ', '2.5000', '1.250000', 1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(1893, '6902100870078', 'LLAVERO PALETA ', '2.5000', '1.500000', 2, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(1894, '7410063008869', 'RADIOSHACK 16 GB USB 2.0', '7.0000', '4.950000', 3, 'Tecnología', 0, NULL, NULL, NULL, 0, NULL, NULL, 9),
(1895, '7410063008920', 'RADIOSHACK 8 GB MICROSD 2.0', '8.0000', '5.550000', 3, 'Tecnología', 0, NULL, NULL, NULL, 0, NULL, NULL, 9),
(1896, '514013630347', 'CHOCOLATE REES\'S ', '0.2500', '0.100000', 43, 'Golocinas', 0, NULL, NULL, NULL, 6, NULL, NULL, 2),
(1897, '7702111811973', 'NORMA CUADER. CSIDO KIUT DOBLE RAYA 100 H', '5.5000', '3.380000', 3, 'Escolar', 0, NULL, NULL, NULL, 0, NULL, NULL, 3);
INSERT INTO `Hoja1` (`id_producto`, `Codigo`, `Nombre`, `Precio_de_venta`, `Precio_de_compra`, `Cantidad`, `Marca`, `Descuento`, `Descripcion`, `Imagen`, `Ubicacion`, `StockMinimo`, `PrecioMayoreo`, `PrecioDistribuidor`, `id_categoria`) VALUES
(1898, '7702111800465', 'NORMA CSIDO H. KITTY RAY 100 H', '5.5000', '3.770000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1899, '7702111831544', 'NORMA SPIRAL VARIEDAD DISEÑO C7 70 H', '2.0000', '1.000000', 6, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1900, '7702111324978', 'NORMA SPIRAL H. KITTY RAY 80 H', '5.9000', '3.820000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1901, '7702111830998', 'NOMRA CSIDO RAY CARS MCQUEEN 100 H', '5.2500', '3.030000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1902, '7702111830974', 'NORMA CSIDO RAY J. LEAGUE 100 H', '5.2500', '3.030000', 2, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1903, '012200582', 'STAINLESSTEEL PULSERAS PARA PAREJAS', '11.0000', '5.500000', 5, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 3, NULL, NULL, 13),
(1904, '122100658', 'STAINLESSTEEL PULSERA DORADA KML', '6.0000', '3.000000', 0, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1905, '122100656', 'PULSERA DE CADENA GRUESA KML', '10.0000', '5.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1906, '012200620', 'STAINLESTEEL PULSERAS LOVE DORARA Y PLATEADA', '10.0000', '5.000000', 0, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1907, '012200632', 'STAINLESSTEEL SET DE CADENA', '10.0000', '5.000000', 0, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1908, '122100646', 'KML SET DE CADENA MEDIA LUNA ', '4.0000', '2.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1909, '112100968', 'KML SET DE CADENA ESTRELLA', '4.0000', '2.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1910, '122100651', 'KML SET DE CADENA TORRE PARIS', '7.0000', '3.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1911, '102100158', 'KML SET CADENA OSO Y CONEJITOS', '4.0000', '2.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1912, '102100160', 'KML SET DE CADENA Y MARIPOSA', '4.0000', '2.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1913, '012200587', 'KML SET CADENA CRUZ DORADA', '14.0000', '7.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1914, '012200295', 'KML SET CADENA CON CORAZON ', '9.0000', '4.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1915, '012200282', 'KML SET DE ARGOLLAS DORADAS ', '8.0000', '4.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1916, '122100647', 'KML SET CADENA CORAZON FLECHADO ', '4.0000', '2.000000', 0, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1917, '122100717', 'KML SET DE ARITOS OSITOS Y BRILLANTES', '5.0000', '2.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1918, '012200585', 'KML SET DE PULSERA CORAZON DE COLORES', '15.0000', '7.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1919, '012200287', 'KML SET CADENA ESTRELLA ', '15.0000', '7.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1920, '122100710', 'KML SET DE ARITOS MARIPOSAS', '2.0000', '1.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1921, '122100719', 'KML SET DE ARITOS CUADRADO', '2.0000', '1.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1922, '122100721', 'KML SET DE ARITOS CORAZON', '2.0000', '1.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1923, '122100718', 'KML SET DE ARITOS ESTRELLAS', '2.0000', '1.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1924, '122100702', 'KML SET DE ARITOS PERLA', '3.0000', '1.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1925, '112100860', 'KML SET DE ARITOS PIERDA MULTICOLOR', '4.0000', '2.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1926, '012200589', 'KML SET DE ARITOS MARIPOSA NEGRA', '8.0000', '4.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1927, '122100703', 'KML SET DE ARITOS PIEDRA CON ESTRELLA', '3.0000', '1.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1928, '122100709', 'KML SET DE ARITOS FLOR VIOLETA', '3.0000', '1.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1929, '082100054', 'KML SPLASH WORTH IT ANGEL', '14.0000', '7.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1930, '122100067', 'SPLASH VIVA LAS VEGAS SWEET ', '13.0000', '6.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1931, '122100071', 'SPLASH KIMBERLY SWEET PEACH ', '13.0000', '6.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1932, '122100068', 'KML SPLASH KIMBERLY SWEET CHERRY ', '13.0000', '6.500000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, NULL, NULL, NULL, 11),
(1933, '122100095', 'KML PERFUME SWEETHEART WOMDERLAND ', '16.0000', '8.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1934, '018527171742', 'STICKER SURTIDO WE HAVE HOPE', '0.4000', '0.170000', 182, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1935, '408467243738', 'PAPEL LEYER PAQUETE', '1.0000', '0.500000', NULL, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1936, '804532107252', 'PAPEL LEYER POR UNIDAD', '0.1000', '0.050000', 6, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1937, '024652058155', 'JUANCITO PRIMER GRADO', '5.9500', '4.250000', 7, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1938, '7506129446888', 'CUADERNO ESPIRAL UNICORNIO SCRIBE 2 MATERIAS', '5.1500', '3.680000', 0, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1939, '7506129427092', 'CUADERNO ESPIRAL INCOLOR SCRIBE 2 MATERIAS', '5.5000', '3.190000', 0, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1940, '7506129454999', 'CUADERNO COS GDE MAGICAL CUADRO', '3.9900', '2.510000', 2, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1941, '7506129455231', 'CUADERNO COS GDE PRINCESA RAYADO', '4.7500', '2.950000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1942, '863340707336', 'MOUSE ECONOMICOS', '8.0000', '3.500000', 6, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(1943, '6920141324237', 'ESTUCHE DE GEOMETRIA FLEXIBLE 20 CM ', '1.6500', '0.980000', 5, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1944, '547502250273', 'ARREGLO MEDIANO', '10.0000', '6.000000', 0, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(1945, '77968791', 'MARCADOR PELIKAN COLOR ICE', '1.0000', '0.500000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1946, '77968821', 'MARCADOR PELIKAN COLOR BANANA', '1.0000', '0.500000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1947, '77965097', 'MARCADOR PELIKAN COLOR PEACH ROSA', '1.0000', '0.500000', 0, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1948, '77964069', 'MARCADOR PELIKAN COLOR LAVENDER LILA', '1.0000', '0.500000', 0, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1949, '723001714465', 'DIAMANTINA DE COLOR LA UNICA', '0.2500', '0.160000', 117, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 10, NULL, NULL, 11),
(1950, '065621702673', 'MI LIBRO DE ARTISTICA TERCER GRADO ', '5.9500', '4.250000', 2, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1951, '475012234166', 'MI LIBRO DE ARTISTICO SEGUNDO GRADO ', '5.9500', '4.250000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1952, '744704674682', 'MI LIBRO ARTISTICO PRIMER GRADO ', '5.9500', '4.250000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1953, '604323664132', 'MI LIBRO CALIGRAFICO SEGUNDO GRADO', '5.9500', '4.250000', 7, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1954, '233368826578', 'MI LIBRO CALIGRAFICO PRIMER GRADO', '5.9500', '4.250000', 5, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1955, '878824563171', 'MI LIBRO CALIGRAFICO TERCER GRADO', '5.9500', '4.250000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1956, '648578325761', 'MI LIBRO CALIGRAFICO SEXTO GRADO ', '5.9500', '4.250000', 7, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 1),
(1957, '358811466058', 'MI LIBRO CALIGRAFICO QUINTO GRADO', '5.9500', '4.250000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1958, '674761587808', 'AVION PEQUEÑO ', '0.3500', '0.175000', 0, 'Juguetes Niño', 0, NULL, NULL, NULL, 1, NULL, NULL, 10),
(1959, '9789996191466', 'LIBRO EL SEMBRADOR QUINTO GRADO', '10.0000', '5.460000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1960, '9789996191442', 'LIBRO EL SEMBRADOR SEGUNDO GRADO', '10.0000', '5.300000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1961, '9789996191435', 'LIBRO EL SEMBRADOR CUARTO GRADO', '10.0000', '5.460000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1962, '9789996191428', 'LIBRO EL SEMBRADOR PRIMER GRADO', '9.0000', '4.430000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1963, '811246233010', 'PELOTA SUPER MIKASA', '15.0000', '7.340000', 1, 'Accesorios de Hombre', 0, NULL, NULL, NULL, 1, NULL, NULL, 17),
(1964, '787241656655', 'AOS FOMY CARTA LISO AZUL', '0.2000', '0.110000', 10, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(1965, '006507258402', 'FOMY BLANCO CARTA BRILLANTE ADHESIVO', '0.5000', '0.339000', 10, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1966, '561884201063', 'FOMY ROJO CARTA BRILLANTE ADHESIVO', '0.5000', '0.339000', 10, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1967, '270306048352', 'FOMY FUXIA CARTA BRILLANTE ADHESIVO', '0.5000', '0.339000', 10, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1968, '885188726260', 'FOMY PLATEADO CARTA BRILLANTE ADHESIVO', '0.5000', '0.339000', 20, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 1),
(1969, '643313217412', 'FOMY MORADO CARTA BRILLANTE ADHESIVO', '0.5000', '0.339000', 10, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1970, '525724212831', 'FOMY VERDE OSCURO CARTA BRILLANTE ADHESIVO', '0.5000', '0.339000', 10, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1971, '762567801702', 'FOMY NEGRO CARTA BRILLANTE ADHESIVO', '0.5000', '0.339000', 10, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1972, '848530468440', 'FOMY AMARILLO CARTA BRILLANTE ADHESIVO', '0.5000', '0.339000', 20, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1973, '265255231822', 'FOMY CAFE CARTA BRILLANTE ADHESIVO', '0.5000', '0.339000', 10, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1974, '642228434543', 'FOMY ROSADO CARTA BRILLANTE ADHESIVO', '0.5000', '0.339000', 10, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1975, '7441029517002', 'MINI BARRITAS MARINELA PIÑA', '0.6500', '0.440000', 1, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(1976, '7441029517149', 'MINI BARRITA MARINELA FRESA', '0.6500', '0.440000', 0, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(1977, '7441029522471', 'PLATIVOLOS 52.5 GRAMOS', '0.2500', '0.180000', 3, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(1978, '122100099', 'KIMBERLY SWEET PEACH ', '16.0000', '8.000000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(1979, '7701103689446', 'COLORES ESCRIBE 12 LARGOS', '3.8500', '2.400000', 11, 'Sin Departamento', 0, NULL, NULL, NULL, 1, NULL, NULL, 7),
(1980, '257324205113', 'DECOTAC TUCAN 3.5 MTS TRANS', '3.3000', '2.200000', 0, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(1981, '6941057402871', 'INTEX FLOTADOR TIPO SALVAVIDAS CARS ', '2.5000', '1.250000', 8, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 1),
(1982, '6941057455709', 'INTEX FLOTADOR PATO Y TORTUGA ', '10.4000', '5.200000', 2, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 1),
(1983, '6941057402161', 'INTEX FLOTADOR DE BRAZO NARANJA', '2.5000', '1.250000', 3, 'Juguetes Niño', 0, NULL, NULL, NULL, 1, NULL, NULL, 10),
(1984, '6941057452517', 'INTEX FLOTADOR GRANDE COLORES ', '6.0000', '3.000000', 5, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(1985, '6942138915839', 'FLOTADOR SWIM SAFE AMARILO', '7.0000', '2.500000', 3, 'Juguetes Niño', 0, NULL, NULL, NULL, 1, NULL, NULL, 10),
(1986, '6942138915761', 'FOTADOR SWIM SAFE AMARILLO', '5.0000', '2.500000', 2, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(1987, '6942138928105', 'BEST WAY FLOTADOR TIPO TABLA', '8.0000', '4.000000', 1, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(1988, '6941057402253', 'INTEX FLOTADOR GRANDE CON AGARRADERAS', '18.0000', '6.000000', 3, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 1),
(1989, '6941057455617', 'INTEX FLOTADOR TIPO ORCA INFLABLE', '15.0000', '7.500000', 1, 'Juguetes Niño', 0, NULL, NULL, NULL, 1, NULL, NULL, 10),
(1990, '6942138934274', 'BEST WAY FLOTADOR TIPO ELEFANTE', '9.0000', '4.500000', 1, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(1991, '6941057401072', 'INTEX ALBERCA INFLABLE 2.29 M X 1.52 M', '35.0000', '17.500000', 1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1992, '694105740006', 'INTEX ALBERCA INFLABLE 1.8 M', '35.0000', '17.500000', 1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1993, '6941057458847', 'INTEX ALBERCA INFLABLE 3.05 M X 1.83 M', '55.0000', '27.500000', 1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(1994, '6941057403250', 'INTEX AQUAFLOW PLAY LENTES DE AGUA', '3.0000', '1.500000', 3, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, NULL, NULL, NULL, 13),
(1995, '6925568220123', 'MUÑECA CON ESPEJO', '1.5000', '0.750000', 9, 'Juguetes Niña', 0, NULL, NULL, NULL, NULL, NULL, NULL, 15),
(1996, '6971354477784', 'STICKER BROZING', '0.4000', '0.170000', 12, 'Sin Departamento', 0, NULL, NULL, NULL, NULL, NULL, NULL, 7),
(1997, '8620201483055', 'LLAVERO OSO CON BRILLANTINA', '5.0000', '3.750000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(1998, '6935263586326', 'LLAVERO STEECH PELUCHE', '4.1000', '2.500000', 1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(1999, 'G82390', 'LLAVERO PON PON ', '2.2500', '1.000000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2000, '9300633003876', 'LLAVERO AGUACATE BRILLANTE ROJO', '3.2500', '1.750000', 3, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2001, '6589658532490', 'MOCHILA AZUL Y NARANJA PEQUEÑA', '10.0000', '7.000000', 0, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2002, '8981106945070', 'ROSA CAJA AZUL', '3.0000', '1.500000', 1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2003, '6936380682489', 'ALCANCIA UNICORNIO CAJA', '7.0000', '3.250000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2004, '350341543817', 'FLOR CAJA ROJA', '2.9000', '1.250000', NULL, 'Sin Departamento', 0, NULL, NULL, NULL, NULL, NULL, NULL, 7),
(2005, '050474817725', 'CADENA BEST FRIENS', '9.5000', '2.500000', 2, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 0, NULL, NULL, 11),
(2006, '656781048682', 'CADENA DUO TE AMO ACERO', '9.5000', '2.500000', 2, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 0, NULL, NULL, 11),
(2007, '9876000396969', 'CHONGA GRANDE ROJA ', '0.5000', '0.170000', 30, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(2008, '6914984948040', 'FLOR ROJA PEQ.', '1.0000', '0.310000', 10, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2009, '6963484421591', 'FLOR CAJA RAYADA', '1.5000', '0.750000', 4, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2010, '087121046540', 'RAMO DE TRES ROSAS EN CAJA ROSEONLY', '4.5000', '2.250000', 3, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2011, '318104628844', 'PELUCHE DINOSAURIO PEQUEÑO', '12.0000', '6.000000', 3, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2012, '6901630163155', 'SET DE GLOBO TE AMO', '4.5000', '1.650000', 12, 'FIESTA', 0, NULL, NULL, NULL, 0, NULL, NULL, 6),
(2013, '027301241512', 'MOTO JUGUETE', '1.5000', '0.750000', 0, 'Juguetes Niño', 0, NULL, NULL, NULL, 0, NULL, NULL, 10),
(2014, '123428614154', 'BOLSA FIESTA PARTY GOODS', '1.5000', '0.750000', 30, 'FIESTA', 0, NULL, NULL, NULL, 0, NULL, NULL, 6),
(2015, '6954541500021', 'FOIL BALLOON GLOBOS METALIZADOS', '1.7500', '0.750000', 7, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2016, '6971544456049', 'WOBEN BOTTELA 800ML', '7.0000', '3.500000', 3, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(2017, '6239568102510', 'PILLON 6 UNIDADES PELOTAS DE BAÑO', '5.0000', '2.500000', 3, 'Juguetes Bebe', 0, NULL, NULL, NULL, 1, NULL, NULL, 16),
(2018, '6901082581224', 'MUSIC PHONE CELULAR DE BEBE ESPEJO', '7.1000', '3.500000', 3, 'Juguetes Bebe', 0, NULL, NULL, NULL, 1, NULL, NULL, 16),
(2019, '6239568102534', 'PILLON 1 UNIDAD ', '2.0000', '0.850000', 3, 'Juguetes Bebe', 0, NULL, NULL, NULL, 1, NULL, NULL, 16),
(2020, '126324587663', 'COLA CON PUNTOS ', '1.5000', '0.750000', 2, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(2021, '6621000072565', 'COLA BUFANDA DOBLE ', '2.5000', '1.250000', 0, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(2022, '618684732157', 'COLA LOVE COLORES', '0.2500', '0.050000', 12, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(2023, 'T1234567261', 'COLA PON PON GATO', '0.7500', '0.350000', 3, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(2024, '562553762427', 'COLA CON CARITA', '1.5000', '1.000000', 3, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(2025, '856656174644', 'COLA DE CONEJO ', '0.7500', '0.350000', 3, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(2026, '6900000121511', 'COLA PELUDA CONEJO', '0.7500', '0.300000', 3, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(2027, '848647723023', 'COLA COLOR PUNTO NEON', '0.2500', '0.125000', 12, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(2028, '621714263430', 'COLA RESORTE CORAZON ', '0.2500', '0.125000', 6, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(2029, '860001624657', 'DEADEMA PELUDA CON POM PON COLORES', '3.2500', '1.500000', 3, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(2030, '6902021087449', 'BILLETERA LLAMA ', '6.0000', '2.750000', 3, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(2031, '6902021087432', 'BILLETERA LLAMA 2', '6.0000', '2.750000', 3, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(2032, '6984640156386', 'TARJETERO UNICORNIO ', '3.9900', '2.000000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2033, 'DL660', 'MONEDERO UNICORNIO', '5.0000', '2.500000', 3, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(2034, '8698732101632', 'VINCHA CON PERLAS ', '1.7500', '1.000000', 2, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(2035, '6954831569738', 'JOYERO CON FLOR ', '3.0000', '1.250000', 0, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2036, '6904517143868', 'CAJA DE CORAZON CON ROSAS ', '3.5000', '2.250000', 3, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2037, '554716766658', 'CAJA CORAZON ROSA ADORNO', '2.0000', '1.000000', 6, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2038, '203834572753', 'CAJA CORAZON FLOR ', '1.2500', '0.600000', 2, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2039, '6930187408617', 'ADORNO CAJA CON OSO Y FLOR ', '3.5000', '1.750000', 2, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(2040, '6914984948019', 'ROSA CON OSO EN BOLSITA', '1.5000', '0.750000', 8, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2041, '838766288760', 'GLOBO CORAZON #16', '1.0000', '0.160000', 7, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2042, '6478478454542', 'FLOR CON HOJAS ', '1.0000', '0.400000', 12, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2043, '203450266503', 'CAJITA PARA JOYERIA ', '1.5000', '0.500000', 6, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(2044, '855551403730', 'CAJITA PARA JOYERIA 2', '1.2500', '0.370000', 59, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(2045, '234834366640', 'LAPICERO DE PRESION ', '0.9500', '0.320000', 10, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2046, '047625624605', 'LAPICERO FINO DE PRESION', '6.3000', '3.250000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2047, '305234823835', 'PAPEL FOLDCOTE', '0.4500', '0.225000', 26, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2048, '421146171743', 'MOCHILA SAN MARTIN UNICORNIO', '10.0000', '7.000000', 0, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2049, '6920150947076', 'ROSA EN PAPEL ', '2.5000', '1.250000', 0, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 1),
(2050, '240560820178', 'PELOTA SURTIDA CON MAYA', '1.5000', '0.750000', 22, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 2, NULL, NULL, 13),
(2051, '012167634146', 'PULPO DE SATIN', '6.0000', '3.000000', 3, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(2052, '150307166247', 'LAPICEROS PROMOCION', '0.1000', '0.050000', 14, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2053, '6972608389990', 'BOLSA DE REGALO M CORAZON M', '2.0000', '1.150000', 5, 'FIESTA', 0, NULL, NULL, NULL, 0, NULL, NULL, 6),
(2054, '047022537885', 'PELUCHE MEDIANO', '15.0000', '7.500000', 7, 'FIESTA', 0, NULL, NULL, NULL, 0, NULL, NULL, 6),
(2055, '7502211250449', 'VEJIGA NEGRO 100 PIEZAS', '3.9500', '2.650000', 1, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2056, '7502211250364', 'VEJIGAS AMARILLO100 PIEZAS', '3.9500', '2.650000', 2, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2057, '7502211250319', 'VEJIFAS BLANCAS 100 PIEZAS', '3.9500', '2.650000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2058, '7502211250340', 'VEJIGAS AZIL 100 PIEZAS ', '3.9500', '2.650000', 2, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2059, '7502211250357', 'VEJIGAS ROJO 100 PIEZAS ', '3.9500', '2.650000', 0, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2060, '802863090149', 'VEJIGAS VERDE 100 U', '3.9500', '2.650000', 2, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2061, '7502211251514', 'VEJIGA ROJO PERLA 50 PIEZAS', '3.9500', '2.650000', 1, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2062, '237340024476', 'GLOBOS PALMERITO 100 U', '3.9500', '2.650000', 2, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2063, '453043087110', 'CARULINA IRIS VERDE CLARO', '0.4000', '0.200000', 19, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2064, '7702993035245', 'TRULULU MASMELOS RELLENO CARAMELO', '0.5500', '0.400000', 7, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(2065, '7702993036839', 'TRULULU MASMELO RELLENO LIMON', '0.5500', '0.400000', 6, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(2066, '02289106', 'WRIGLEYS EXTRA PEPPERMINT ', '2.2500', '1.350000', 10, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(2067, '21\'084', 'CARRO ROJO MEDIANO', '8.0000', '4.000000', 1, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(2068, '574382235715', 'GOMITAS TRULULU AROS ', '0.1000', '0.030000', 94, 'Golocinas', 0, NULL, NULL, NULL, 10, NULL, NULL, 2),
(2069, '7401007600195', 'METRO TUCAN', '5.0000', '2.500000', 4, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2070, '617816614050', 'TABLA CON CLIP RCP', '1.9000', '0.950000', 2, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2071, '142144757858', 'TECLADO USB ', '10.0000', '3.500000', 6, 'Tecnología', 0, NULL, NULL, NULL, 2, NULL, NULL, 9),
(2072, '000486424712', 'POWER STYLE LINTERNA LED MULTIFUNCION', '8.5000', '4.500000', 2, 'Accesorios de Hombre', 0, NULL, NULL, NULL, 1, NULL, NULL, 17),
(2073, '748272715324', 'POWER STYLE LINTERNA PEQUEÑA MULTIFUNCION', '4.0000', '2.500000', 2, 'Accesorios de Hombre', 0, NULL, NULL, NULL, 1, NULL, NULL, 17),
(2074, '040700204626', 'TTARJETA MEDIANA CARTA SAN VALENTIN', '0.5000', '0.300000', 18, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2075, '246134273200', 'PULPO REVERSIBLE', '4.0000', '2.000000', 3, 'Juguetes Unisex', 0, NULL, NULL, NULL, 1, NULL, NULL, 12),
(2076, '5413501082195', 'SET DE CANCHA JUNIOR ', '60.0000', '30.000000', 1, 'Accesorios de Hombre', 0, NULL, NULL, NULL, 1, NULL, NULL, 17),
(2077, '036731001825', 'GATORADE NARANJA 600ML', '1.0000', '0.830000', 0, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(2078, '036731001818', 'GATORADE DE UVA 600ML', '1.0000', '0.830000', 0, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(2079, '380518581566', 'TAZAS DECORADAS', '2.5000', '1.560000', -19, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(2080, 'MA008', 'MOCHILA BIG CHERRY VARON', '18.5000', '12.500000', 2, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2081, '7401007626850', 'ESRUCHE PLASTICO LAPICES GRD DBL', '6.5000', '3.250000', 6, 'Escolar', 0, NULL, NULL, NULL, 0, NULL, NULL, 3),
(2082, '7401007660366', 'PERFORADOR DE UN AGUJERO ', '2.2000', '1.100000', 6, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2083, '7401007633018', 'PINTA CARITA 6 COLORES CAJA FACE BODY', '1.0000', '0.450000', 12, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(2084, '422063780448', 'ANILLADOS NEGROS GRANDES ', '2.5000', '1.250000', 8, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2085, '7401007601826', 'CRAYON PASTEL REDONDO 12 COLORES', '1.4000', '0.740000', 12, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(2086, '17401007620695', 'TUCAN PAPEL PLIEGO CHINA AMARILLO MOSTAZA', '0.1000', '0.040000', 96, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(2087, '17401007604381', 'TUCAN PAPEL CHINA PLIEGO', '0.1000', '0.040000', 96, 'Escolar', 0, NULL, NULL, NULL, 10, NULL, NULL, 3),
(2088, '17401007603230', 'TUCAN PAPEL CHINA FUCSIA PLEGO ', '0.1000', '0.040000', 97, 'Escolar', 0, NULL, NULL, NULL, 10, NULL, NULL, 3),
(2089, '17401007620732', 'TUCAN PAPEL CHINA VIOLETA PLIEGO', '0.1000', '0.040000', 95, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(2090, '058165288367', 'PRO 6 AIR PODS', '28.0000', '15.000000', 2, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(2091, '7401007601734', 'MARCADORES TUCAN 12 COLORES', '2.7500', '1.550000', 12, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(2092, '7401007604186', 'TUCAN GALON GOMA ESCOL', '9.5000', '6.410000', 3, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(2093, '7401007600409', 'GOMA ESCOLAR BLANCA 20Z', '0.7500', '0.340000', 31, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(2094, '7401007603103', 'TUCAN FOMY PLIEGO BRLLO BLANCO', '0.5000', '0.220000', 10, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(2095, '231225558238', 'PAPEL CHINA ESTRELLAS', '0.2500', '0.120000', 25, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(2096, '846065761335', 'CORAZONES EN BARITA', '0.5000', '0.250000', 51, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2097, '121666281683', 'GLOBO CORAZON #18', '2.0000', '0.500000', 20, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2098, '265535122261', 'ROSA I LOVE YOU CON OSITO ', '1.0000', '0.460000', 29, 'BEBE', 0, NULL, NULL, NULL, 5, NULL, NULL, 5),
(2099, '125858403281', 'ROSA Y CORAZON EN CAJA TRANSPARENTE', '1.5000', '0.750000', 3, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2100, '778988636169', 'JUEGO DE DOMINO', '3.2500', '1.625000', 1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(2101, '6982282088164', 'CAJA CORAZON MEDIANA', '6.0000', '3.000000', -1, 'Sin Departamento', 0, NULL, NULL, NULL, 0, NULL, NULL, 7),
(2102, '6965456495012', 'OSO 1.5 M CAFE CLARO', '79.9900', '59.000000', 0, 'Juguetes Unisex', 0, NULL, NULL, NULL, 0, NULL, NULL, 12),
(2103, '082257882415', 'ARREGLO DE OSO CELESTE CON CHOCOLATES', '20.0000', '12.000000', 1, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2104, '643344063758', 'ARREGLO JUNGLE BOOGIE TIGRE CON CHOCOLATE', '21.0000', '12.000000', 1, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2105, '430606374414', 'ARREGLO OSO CONEJITA ROSADA CON CHOCOLATES', '25.0000', '14.000000', 1, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2106, '557817578534', 'ARREGLO OSO ELEFANTE ROSADO CON CHOCOLATES ', '20.0000', '12.000000', 1, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2107, '781525407620', 'ARREGLO OSO CONEJO CAFE Y AZUL CON CHOCOLATES', '25.0000', '14.000000', 1, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2108, '262652041883', 'ARREGLO OSO MAPACHE AZUL BLANCO CON CHOCOLATES ', '24.0000', '16.000000', 0, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2109, '565346083643', 'PLIEGO CARTON CRAFT', '1.5000', '0.900000', 9, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2110, '654231682071', 'BOLSA DE REGALO M CORAZONES NEGRO DORADO ', '1.5000', '0.900000', 11, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(2111, '6972545310125', 'BOLSA CARTON M OSO Y CORAZON', '1.5000', '0.900000', 7, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 1),
(2112, '6932589185523', 'BOLSA DE REGALO AZUL M FELIZ CUMPLEAÑOS', '1.5000', '0.900000', 11, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 1),
(2113, '348700152260', 'BOLSA DE REGALO CARTON M JIRAFITA', '1.5000', '0.900000', 3, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 1),
(2114, '575851841142', 'BOLSA DE REGALO CARTON M ELEFANTITO HELLO', '1.5000', '0.900000', 2, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 1),
(2115, '485074317620', 'BOLSA DE REGALO CARTON M CONEJITA CUTE', '1.5000', '0.900000', 3, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 1),
(2116, '434531777402', 'BOLSA DE REGALO CARTON M PANDA HI', '1.5000', '0.900000', 0, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 1),
(2117, '6972545315120', 'BOLSA DE REGALO CARTON M LOVE ', '1.5000', '0.900000', 21, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 1),
(2118, '1234567891217', 'MICRO PERLAS PLASTICAS ', '2.2500', '1.000000', 12, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2119, '6972545505033', 'BOLSA DE REGALO S ESTRELLAS', '1.0000', '0.650000', 10, 'BOLSAS', 0, NULL, NULL, NULL, 1, NULL, NULL, 14),
(2120, '6972545310132', 'BOLSA DE REGALO CARTON S ', '1.0000', '0.650000', 18, 'BOLSAS', 0, NULL, NULL, NULL, NULL, NULL, NULL, 14),
(2121, '435464587386', 'BOLSA DE REGALO S ROJA CORAZON ', '0.7500', '0.300000', 21, 'BOLSAS', 0, NULL, NULL, NULL, 2, NULL, NULL, 14),
(2122, '783164303133', 'CHONGA MAGICA ROJA DORADA ', '0.1500', '0.050000', 11, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(2123, '187801766813', 'ARREIGLO DE PELUCHE PERRO CON CHOCOLATES', '25.0000', '18.000000', 1, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2124, '335172074665', 'ARREIGLO DE OSO PEQUEÑO CON BON O BON ', '5.0000', '2.000000', 0, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2125, '264842385240', 'ARREIGLO DE PELUCHE TIGRE ALBINO CON BON O BON', '5.0000', '2.000000', 0, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2126, '077538853446', 'ARREIGLO PEQUEÑO DE CONEJITO CHINO CON BON O BON ', '5.0000', '2.000000', 1, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2127, '041103138026', 'ARREGLO OSO LEON CON CHOCOLATES', '20.0000', '15.000000', 1, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2128, '843956850790', 'OSO DE PELUCHE DE UN METRO ', '46.9900', '22.000000', 3, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2129, '613280301645', 'ARREIGLO OSO POLLITO AMARILLO CON CHOCOLATES ', '14.0000', '8.000000', 1, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2130, '521826334451', 'ARREIGLO PEQUEÑO DOBLE CON BON O BON', '5.5000', '4.000000', 1, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2131, '721282406563', 'CHETOR HORNEADOS 142G', '1.7500', '1.230000', 7, 'Golocinas', 0, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(2132, '6972608389976', 'BOLSA DE REGALO CARTON S CORAZONES ', '1.0000', '0.650000', 3, 'BOLSAS', 0, NULL, NULL, NULL, NULL, NULL, NULL, 14),
(2133, '6932589186339', 'BOLSA DE REGALO CARTON S YOU AND ME', '1.0000', '0.650000', 10, 'BOLSAS', 0, NULL, NULL, NULL, NULL, NULL, NULL, 14),
(2134, '708108680115', 'ACCESORIOS CAJA $6', '6.0000', '3.000000', 3, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(2135, '668787110754', 'ORGANZA COLRES', '0.5000', '0.250000', 4, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2136, '843956957260', 'OSO BLANCO UN METRO ', '46.9900', '22.000000', 0, 'PELUCHES', 0, NULL, NULL, NULL, 1, NULL, NULL, 18),
(2137, '344248060712', 'TUCAN FOMY PLIEGO BRLLO PLATA', '1.9500', '1.350000', 7, 'Escolar', 0, NULL, NULL, NULL, 3, NULL, NULL, 3),
(2138, '810045710013', 'PELUCHE UNICORNIO GRANDE MULTICOLOR ', '94.9900', '60.790000', 1, 'PELUCHES', 0, NULL, NULL, NULL, 1, NULL, NULL, 18),
(2139, '066264160140', 'PELUCHE UNICORNIO ROSADO GRANDE ', '94.9900', '57.590000', 1, 'PELUCHES', 0, NULL, NULL, NULL, 1, NULL, NULL, 18),
(2140, '667531315240', 'DIADEMA ESTRALLA NEGRA', '0.7500', '0.375000', 0, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(2141, '810045710068', 'OSO PELUCHE MEDIANO CAFE ', '34.9900', '23.020000', 2, 'PELUCHES', 0, NULL, NULL, NULL, 1, NULL, NULL, 18),
(2142, '066264140296', 'PELUCHE OSO BEICE UN METRO', '46.9900', '36.620000', 1, 'PELUCHES', 0, NULL, NULL, NULL, 1, NULL, NULL, 18),
(2143, '810045710051', 'OSO PELUCHE 1 METRO BEICE ', '34.9900', '23.020000', 3, 'Sin Departamento', 0, NULL, NULL, NULL, 1, NULL, NULL, 7),
(2144, '810045710020', 'OSO DE PELICHE BEICE', '46.9900', '36.620000', 1, 'PELUCHES', 0, NULL, NULL, NULL, 1, NULL, NULL, 18),
(2145, '810045710044', 'OSO DE PELUCHE PERRO HUSKY', '49.9900', '27.000000', 2, 'PELUCHES', 0, NULL, NULL, NULL, 1, NULL, NULL, 18),
(2146, '372081028700', 'ROSA EN CAJA ROJA ', '3.0000', '1.500000', 2, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 1),
(2147, '564752863167', 'ARREGLO OSO GRIS BE MY VALENTINE', '17.0000', '9.000000', 1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2148, '830242540762', 'ARREIGLO CON OSITO Y GLOBO TE AMO', '15.0000', '7.500000', 0, 'Sin Departamento', 0, NULL, NULL, NULL, 1, NULL, NULL, 7),
(2149, '238271861227', 'ARREIGLO DE TIGRE CON GLOBO ', '21.0000', '10.500000', 0, 'PELUCHES', 0, NULL, NULL, NULL, 1, NULL, NULL, 18),
(2150, '105075188710', 'ARREIGLO PANDA CON GLOBO', '21.0000', '10.500000', 0, 'PELUCHES', 0, NULL, NULL, NULL, 1, NULL, NULL, 18),
(2151, '534175755037', 'ARREIGLO DE LLAMA CUZCO CON GLOBO', '21.0000', '10.500000', 1, 'PELUCHES', 0, NULL, NULL, NULL, 1, NULL, NULL, 18),
(2152, '744660478810', 'ARREIGLO ALMOHADA EMOGI CON GLOBO', '10.0000', '5.000000', NULL, 'PELUCHES', 0, NULL, NULL, NULL, 1, NULL, NULL, 18),
(2153, '532725817667', 'ARREIGLO TAZAS Y PELUCHE', '6.0000', '3.000000', 2, 'PELUCHES', 0, NULL, NULL, NULL, NULL, NULL, NULL, 18),
(2154, '8411865053803', 'FROZEN PIANO Y MICROFONO ', '15.0000', '7.500000', 1, 'Juguetes Niña', 0, NULL, NULL, NULL, 1, NULL, NULL, 15),
(2155, '536421346386', 'ARREIGLO TAZA CON PERRITO ', '7.5000', '3.750000', 0, 'PELUCHES', 0, NULL, NULL, NULL, 1, NULL, NULL, 18),
(2156, '843956850806', 'OSO DE PELUCHE CAFE CONHA ROJA', '46.9900', '26.500000', 3, 'PELUCHES', 0, NULL, NULL, NULL, 1, NULL, NULL, 18),
(2157, '748287372751', 'ARREGLO CON TAZA Y CHOCOLATES', '5.0000', '2.500000', -2, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2158, '713754883018', 'GLOBVO LOVE #32', '2.5000', '1.250000', 11, 'FIESTA', 0, NULL, NULL, NULL, 1, NULL, NULL, 6),
(2159, '860772442745', 'TAZA DE AMOR UNIDAD', '1.5000', '0.750000', -4, 'FIESTA', 0, NULL, NULL, NULL, 0, NULL, NULL, 6),
(2160, '351723705538', 'OSO EN CAJA', '3.0000', '1.500000', 0, 'Sin Departamento', 0, NULL, NULL, NULL, 1, NULL, NULL, 7),
(2161, '423148503540', 'ARREGLO DE TAZAS CON OSOS', '5.0000', '2.500000', 4, 'Sin Departamento', 0, NULL, NULL, NULL, 1, NULL, NULL, 7),
(2162, '3070601502033', 'TAZA EN CAJA Y CHOCOLATES ', '3.5000', '1.750000', 0, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 1),
(2163, '6020173077061', 'TAZA EN CAJA Y CHOCOLATES TE QUIERO MUCH', '3.5000', '1.750000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(2164, '1320150623614', 'TAZA EN CAJA Y CHOCOLATES TE AMO', '3.5000', '1.750000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2165, '3070101502038', 'TAZA EN CAJA Y CHOCOLATES UNIVERSO INFINITO', '3.5000', '1.750000', -1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2166, '6020173076088', 'TAZA EN CAJA Y CHOCOLATES FLORES', '3.5000', '1.750000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2167, '6958688585620', 'SET DE ACCESORIOS ', '1.9500', '0.975000', 0, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 0, NULL, NULL, 11),
(2168, '641018315108', 'RISADOR DE PESTAÑA', '1.2500', '0.625000', 0, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 0, NULL, NULL, 11),
(2169, '427361124201', 'ACCESORIOS CAJA $8', '8.0000', '4.000000', 4, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(2170, '516221542076', 'ACCESORIOS CAJA $4', '4.0000', '2.000000', 1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(2171, '541686102743', 'CORAZON CON PALITO Y LISTON ROJO', '0.5000', '0.250000', 7, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(2172, '216812317375', 'ARREIGLO PERRITO BLANCO CON CHOCO', '6.0000', '3.000000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2173, '704674830548', 'ARREIGLO PERRITA PET CHOCOLATE ', '7.0000', '3.500000', 1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2174, '883125208785', 'TAZA CON OSITO BLANCO CHONGA ROJA', '4.0000', '2.500000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2175, '407502253864', 'TAZA Y CONEJO PATITAS CAFE ', '6.0000', '3.000000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2176, '161444115543', 'TAZA Y PERRITO CAFE NARIZON ', '4.0000', '2.500000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2177, '445871056427', 'TAZA CON OSO CELESTE ', '5.0000', '3.000000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2178, '091671964791', 'TAZA CON MONO ', '4.0000', '2.500000', 1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2179, '831723824816', 'TAZA CON SNOOPY ', '4.0000', '2.500000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2180, '178200586271', 'TAZA CON MUÑECO VERDE ', '4.0000', '2.500000', 1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2181, '680271084214', 'TAZA CON OSITO CAFE OSCURO', '4.0000', '2.500000', 1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2182, '383136153800', 'TAZA CON PELUCHE AVE AZUL', '4.0000', '2.000000', 1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2183, '105755644601', 'TAZA CON PELUCHE PATAS ROJAS ', '4.5000', '2.500000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2184, '063725871778', 'TAZA CON PELUCHE MY LITTLE ANGEL', '5.0000', '2.500000', NULL, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2185, '184616820806', 'PAR DE ARITOS COLOR PLATA', '4.5000', '2.250000', 1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, NULL, NULL, NULL, 13),
(2186, '6920055385768', 'DINOSAURIO PELUCHE ', '10.0000', '4.000000', 5, 'Accesorios de Hombre', 0, NULL, NULL, NULL, 1, NULL, NULL, 17),
(2187, '768620567204', 'PULSIRA BORDADA', '1.0000', '0.500000', 2, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(2188, '223087080041', 'BOLSA CELOFAN DE $0.25', '0.2500', '0.125000', 18, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(2189, '7988900198108', 'OSO DE PELUCHE BLANCO PEQUEÑO', '3.5000', '1.750000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2190, '037202164670', 'CAJA PARA REGALO FELIZ DIA', '4.0000', '2.000000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2191, '488266544517', 'ROSA CAJA ROJA', '3.0000', '1.500000', 1, 'Sin Departamento', 0, NULL, NULL, NULL, 0, NULL, NULL, 7),
(2192, '543754777558', 'TAZA CON PELUCHE ROJO Y CHOCOLATES', '5.0000', '2.500000', -1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2193, '343800872764', 'TAZA Y CONEJO OREJAS ROSADAS ', '4.0000', '2.500000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2194, '061372477880', 'TAZA Y PELUCHE OREJAS PURPURAS', '4.0000', '2.000000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2195, '470422114350', 'TAZA CON OSITO CAFE PATITAS BLANCAS ', '4.0000', '2.000000', 1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2196, '117111507864', 'TAZA Y OSO PANDA ', '4.0000', '2.500000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2197, '283605053653', 'ROSA CELESTE EN CAJA TRANSPARENTE', '4.0000', '2.000000', 2, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(2198, '721872211535', 'TAZA CON OSITO ROSADO', '5.0000', '2.500000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2199, '7453010092948', 'POINTER ABACO ESCOLAR ', '2.9500', '2.010000', 6, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2200, '7453015129489', 'STUDAMARK PAPEL FOTOGRAFICO UNIDAD', '0.5000', '0.170000', 73, 'Escolar', 0, NULL, NULL, NULL, 6, NULL, NULL, 3),
(2201, '6972545185723', 'BOLSA DE REGALO HAPPY BIRTHDAY M', '2.0000', '0.960000', 11, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(2202, '639277631343', 'TAZA CON OSITO Y CHOCOLATES', '5.0000', '2.500000', -1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2203, '054380228472', 'OSO ROSADO CON CHONGA ROSA ', '6.0000', '3.000000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2204, '133406528665', 'CAJA CORAZON $8', '8.0000', '4.000000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2205, '671585412153', 'CAJA TE QUIERO MUCHO GRANDE', '32.5000', '16.250000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2206, '342444803281', 'CAJA ACRILICA GRANDE 35 X20', '12.0000', '4.250000', 11, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(2207, '746775036720', 'JUEGO UNO DE MESA', '14.0000', '9.000000', 2, 'Juguetes Unisex', 0, NULL, NULL, NULL, 0, NULL, NULL, 12),
(2208, '374314106231', 'OSO DE PELUCHE CAFE CON CHONGA GRIS OSCURO', '6.0000', '3.000000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2209, '270683026076', 'ARREGLO DE CAJA ACRILICA GRANDE CON OSO', '25.0000', '12.500000', 1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2210, '775463816633', 'OSITA ROSA ', '10.0000', '5.000000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2211, '21\'080', 'CARRO PICK UP AZUL', '7.0000', '3.500000', 2, 'Juguetes Niño', 0, NULL, NULL, NULL, NULL, NULL, NULL, 10),
(2212, '620874820553', 'SNICKER MINIATURA', '0.2500', '0.125000', 4, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(2213, '625256462887', 'ARREGLO TAZA CON UNICORNIO CELESTE', '10.0000', '5.000000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2214, '682366484484', 'TAZA CON CONEJO PELUDO BLANCO', '4.0000', '2.000000', 1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, NULL, NULL, NULL, 13),
(2215, '616086434033', 'PELUCHE BE MINE', '10.0000', '5.000000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2216, '420588624284', 'ARREGLO CAJA ROSA CON CHOCOLATES', '13.0000', '6.500000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2217, '8436734620542', 'TAZA EN CAJA CON CHOCOLATE', '3.5000', '1.750000', NULL, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, NULL, NULL, NULL, 13),
(2218, '231137142353', 'PELUCHE LOVO GRIS CON BLANCO', '3.0000', '1.500000', NULL, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, NULL, NULL, NULL, 13),
(2219, '136465168372', 'GLOBO PEQUEÑO TE AMO ', '1.2500', '0.625000', NULL, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, NULL, NULL, NULL, 13),
(2220, '370870025144', 'OSO DE PELUCHE CON CAJA DE CORAZONES', '14.9500', '7.500000', 1, 'PELUCHES', 0, NULL, NULL, NULL, 0, NULL, NULL, 18),
(2221, '743045814148', 'ARREGLO OSO MUSICAL CAFE CORAZON', '16.5000', '10.000000', NULL, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, NULL, NULL, NULL, 13),
(2222, '543043186584', 'PARDE ARITOS GRANDES', '0.5000', '0.250000', 18, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(2223, '667888254224', 'BUTTERFLY STICKERS MARIPOSAS ', '2.0000', '1.250000', 6, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2224, '667888327638', 'CRAFLO STICKER MARIPOSA ', '1.7500', '1.000000', 3, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 0, NULL, NULL, 13),
(2225, '667888323760', 'CRAFLO STIICKER MARIPOSA ', '2.5000', '1.250000', 4, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2226, '667888202751', 'CRAFLO STICKER PERLA AZUL Y BLANCA', '4.0000', '2.000000', 2, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2227, '667888373772', 'CRAFLO STICKER FLOR ROSADA ', '2.5000', '1.250000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2228, '667888198702', 'CRAFLO STICKER PERLA BLANCA GRANDE Y PEQUEÑA', '2.0000', '1.000000', 0, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2229, '667888234608', 'CRAFLO STICKER MARIPOSA SET 10', '3.0000', '1.500000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2230, '667888303991', 'CRAFLO STICKER PERLAS BLANCAS', '3.0000', '1.500000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2231, '667888014583', 'MOUSE PAD AZUL', '2.2500', '1.250000', 10, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(2232, '667888372003', 'CRAFLO ABCEDARIO TIPO MOLDE', '2.0000', '1.000000', 5, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2233, '6972543655099', 'WIRELESS MOUSE INALAMBRICO USB ', '10.0000', '4.500000', 12, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(2234, '6904517143844', 'DINOSAURIO VERDE AMARILLO', '10.0000', '5.000000', 4, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(2235, '005647676536', 'HULA HULA GRANDE', '2.5000', '2.000000', 1, 'Juguetes Unisex', 0, NULL, NULL, NULL, 0, NULL, NULL, 12),
(2236, '184327027384', 'HULA HULA MEDIANO', '2.2500', '1.750000', 3, 'Juguetes Unisex', 0, NULL, NULL, NULL, 0, NULL, NULL, 12),
(2237, '870685782378', 'PAPEL VEGETAL CARTA 8 HOJAS', '2.0000', '1.000000', 12, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2238, '7401007601857', 'REGLA TUCAN 60 CM', '2.2500', '1.250000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2239, '6941057466125', 'INTEX INFLADOR DOBLE QUIK ', '5.0000', '2.500000', 1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(2240, '6941057403274', 'CLICK NAZAL Y TAPONES DE OIDO', '1.0000', '0.500000', 3, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(2241, '578010823214', 'PELOTAS DE PLAYA', '1.0000', '0.500000', 4, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(2242, '4549292054729', 'TINTA CANNON 190 BK BOTEELA NEGRA', '16.5000', '10.290000', 3, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(2243, '4549292041842', 'TINTA CANNON 190M MAGENTA', '15.5000', '10.250000', 1, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(2244, '4549292041866', 'TINTA CANNON 190Y AMARIILA', '15.5000', '10.250000', 1, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(2245, '010343938748', 'TINTA EPSON NEGRA 504', '18.2500', '12.990000', 2, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(2246, '010343885318', 'TINTA EPSON 664 MAGENTA', '16.5000', '12.990000', 2, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(2247, '010343885325', 'EPSON 664 AMARILLA', '16.5000', '13.000000', 1, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(2248, '010343885295', 'TINTA EPSON 664BK NEGRA ', '18.0000', '14.300000', 3, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(2249, '6935364051242', 'ROUTER INALÁMBRICO', '30.0000', '23.000000', 1, 'Tecnología', 0, NULL, NULL, NULL, 1, NULL, NULL, 9),
(2250, '7502233375731', 'RESMA DE APEL SCRIBE 500 HOJAS', '5.0000', '3.990000', 9, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2251, '753651826336', 'PAQUETE PERLA CARTA', '1.7500', '1.000000', 19, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(2252, '617266101541', 'CUADERNILLA CUADRO OFICIO', '0.2500', '0.125000', 14, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(2253, '7453074537966', 'MOCHILA SHOPHINS ROSA ', '12.5000', '8.500000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2254, '738744722083', 'PAPEL FABRIAN 10 HOJAS', '2.0000', '1.000000', 8, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13),
(2255, '015546250860', 'SET DIEZ MOÑOS MULTICOLOR', '1.5000', '0.750000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(2256, '082353010011', 'ULTRA FINO DELINEADOR ', '0.7500', '0.400000', 2, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(2257, '853525572580', 'ARREIGLO OSO PERRO CON CHOCOLATES', '14.5000', '7.500000', 0, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, NULL, NULL, NULL, 13),
(2258, '9003182070404', 'TABLERO DE DIBUJO ARISTO A4', '35.0000', '24.370000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2259, '9003182070305', 'TABLERO DE DIBUJO ARISTO A3', '48.0000', '33.740000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2260, '4007817148075', 'STAEDTLER ESCALIMETRO PARA INGENIERIA', '8.0000', '4.870000', 6, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(2261, '320743422027', 'PROMO LAPICERO EMOGI MARRON ', '0.5000', '0.400000', 11, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2262, '4007817567036', 'ESCUADRA BISELADA Y GRADUADA 32 CM 45G STAEDTLER', '4.2500', '2.815000', 6, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2263, '4007817567043', 'ESCUADRA BISELADA Y GRADUADA 32 CM 30-60 G STAEDTLER', '4.2500', '2.815000', 6, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2264, '4007817007624', 'COMPAS DE PRESICION AUTOMATICA EXTENCION STAEDTLER', '24.5000', '17.620000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2265, '4007817015759', 'COMPAS DE PRESICION STAEDTLER', '21.0000', '13.840000', 3, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2266, '083680033677', 'PORTA GRAFICA 27X40 CM ', '1.1000', '0.370000', 12, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(2267, '776500124087', 'PORTA GRAFICA 1/4 39X52', '2.0000', '0.820000', 12, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2268, '7453078530406', 'PINTER MARACDOR PARA PIZARRA ', '2.7500', '1.240000', 6, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2269, '6941057452630', 'INTEX FLOTADOR TIPO MEDIANO', '8.0000', '4.000000', 1, 'ACCESORIOS VARIOS', 0, NULL, NULL, NULL, 1, NULL, NULL, 13);
INSERT INTO `Hoja1` (`id_producto`, `Codigo`, `Nombre`, `Precio_de_venta`, `Precio_de_compra`, `Cantidad`, `Marca`, `Descuento`, `Descripcion`, `Imagen`, `Ubicacion`, `StockMinimo`, `PrecioMayoreo`, `PrecioDistribuidor`, `id_categoria`) VALUES
(2270, '8006919000119', 'PRIMO YESO PARA PIZARRA BLANCO', '2.0000', '0.710000', 12, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2271, '8006919000140', 'PRIMO YESO PARA PIZARRA COLORES', '2.5000', '0.930000', 6, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2272, '7790580259402', 'MOGUL MORAS', '1.4000', '0.950000', 4, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(2273, '7790580259600', 'MOGUL DIENTES', '1.4000', '0.950000', 4, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(2274, '6802021188002', 'BOLSA DE REGALO TAMAÑO S', '0.7500', '0.400000', 36, 'FIESTA', 0, NULL, NULL, NULL, 0, NULL, NULL, 6),
(2275, '7401005403712', 'ESMALTE DAROSA NEGRO', '0.7500', '0.470000', 3, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 0, NULL, NULL, 11),
(2276, '7401005403040', 'ESMALTE DAROSA BRILLO', '0.7500', '0.480000', 3, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 0, NULL, NULL, 11),
(2277, '7401005403088', 'ESMALTE DAROSA 1003', '0.7500', '0.480000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 0, NULL, NULL, 11),
(2278, '7401005403309', 'ESMALTE DAROSA NACARADO', '0.7500', '0.480000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 0, NULL, NULL, 11),
(2279, '7401005496004', 'ESMALTE DAROSA VERDE FLUORESCENTE', '0.7500', '0.480000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 0, NULL, NULL, 11),
(2280, '7401005492099', 'ESMALTE DAROSA CAFÉ OBSCURO', '0.7500', '0.480000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 0, NULL, NULL, 11),
(2281, '7406305005604', 'ESMALTE DAROSA ROSA VIEJA', '0.7500', '0.480000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 0, NULL, NULL, 11),
(2282, '7401005491474', 'ESMALTE DAROSA KORA ROSA NEON', '0.7500', '0.480000', NULL, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 0, NULL, NULL, 11),
(2283, '7406305002009', 'ESMALTE DAROSA AMARILLO', '0.7500', '0.480000', 2, 'Accesorios de Mujer', 0, NULL, NULL, NULL, NULL, NULL, NULL, 11),
(2284, '7401005403835', 'ESMALTE DAROSA CHISPA', '0.7500', '0.480000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 0, NULL, NULL, 11),
(2285, '7401005403149', 'ESMALTE DAROSA MORADO', '0.7500', '0.480000', 1, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 0, NULL, NULL, 11),
(2286, '6989137895069', 'UÑAS STICKER DECORACION', '0.6000', '0.350000', 10, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(2287, '481808253820', 'UÑAS MODERN SALON', '1.0000', '0.375000', 12, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(2288, '776840568381', 'UÑAS BY MAGNETIC', '1.2500', '0.660000', 12, 'Accesorios de Mujer', 0, NULL, NULL, NULL, 1, NULL, NULL, 11),
(2289, '433002168200', 'PAQUETE DE PAPEL BOND OFICIO', '0.4500', '0.225000', 4, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2290, '6954884594046', 'KEYROAD COLORES TRIANGULAR 12 COLORES', '4.2500', '1.890000', 12, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2291, '4044355787007', 'INFO NOTA CORAZON', '3.2500', '1.640000', 1, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 1),
(2292, '326820464245', 'PAQUETE PAPEL LEDGER 10 X15', '1.0000', '0.500000', 10, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(2293, '4044355791424', 'INFO NOTES LAPIZ', '3.1000', '1.810000', 12, 'Escolar', 0, NULL, NULL, NULL, 2, NULL, NULL, 3),
(2294, '4011169590055', 'INFO NOTES BANDERITA COLORES', '1.9000', '0.960000', 12, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2295, '4011169830397', 'INFO NOTA MANZANA', '3.2500', '1.640000', 1, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(2296, '4011169583514', 'INFO NOTA BURBUGA', '3.2500', '1.645000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2297, '4044355787069', 'INFO NOTA ENGRANAJE', '3.2500', '1.645000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2298, '4044355787106', 'INFO NOTA BONBILLA', '3.2500', '1.645000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2299, '4044355787083', 'INFO NOTA FLECHA', '3.2500', '1.645000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2300, '4044355787045', 'INFO NOTA MANO', '3.2500', '1.645000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2301, '4044355787021', 'INFO NOTA CARRO', '3.2500', '1.645000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2302, '4044355787120', 'INFO NOTA CAMISA', '3.2500', '1.645000', 0, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2303, '4006381530194', 'STABILO PEN 68 METALLIC DORADO', '2.2500', '1.160000', 15, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2304, '4006381530132', 'STABILO PEN 68 METALLIC GRIS', '2.2500', '1.160000', 15, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2305, '4006381530224', 'STABILO PEN 68 METALLIC CELESTE', '2.2500', '1.160000', 10, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2306, '4006381530163', 'STABILO PEN 68 METALLIC AMARILLO', '2.2500', '1.160000', 10, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2307, '4006381530286', 'STABILO PEN 68 METALLIC VERDE', '2.2500', '1.160000', 10, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2308, '7807265021695', 'MINAS ISOFIT 0.5\'2B', '0.3500', '0.140000', 24, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2309, '4044355788240', 'INFO NOTES DECORATIVAS', '1.5000', '0.660000', 60, 'Escolar', 0, NULL, NULL, NULL, NULL, NULL, NULL, 3),
(2310, '4044355784242', 'INFO NOTES CREATIVE ', '1.5000', '0.660000', 60, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2311, '7441029521221', 'BIMBO DONITAS ESPOLVOREADAS ', '1.0000', '0.710000', 2, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(2312, '7807265062537', 'PROARTE FOMY PLIEGO BRILLO MORADO', '1.9500', '1.160000', 10, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2313, '7807265062551', 'PROARTE FOMY PLIEGO BRILLO ORO', '1.9500', '1.160000', 10, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2314, '7807265062582', 'PROARTE FOMY PLIEGO BRILLO ROJO', '1.9500', '1.160000', 10, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2315, '7807265062568', 'PROARTE FOMY PLIEGO BRILLO PLATA', '1.9500', '1.160000', 10, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2316, '7807265062513', 'PROARTE FOMY PLIEGO BRILLO BLANCO', '1.9500', '1.160000', 10, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2317, '7401006712349', 'PANQUEXITOS SABOR VAINILLA', '1.0000', '0.710000', 3, 'Golocinas', 0, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(2318, '74000517', 'BIMBOLETES 55G', '0.7500', '0.500000', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(2319, '7401006712301', 'PANQUE CON PASAS 250 G', '1.6000', '1.330000', 2, 'Golocinas', 0, NULL, NULL, NULL, 1, NULL, NULL, 2),
(2320, '7401006712127', 'ROLES DE CANELA 210G', '1.0000', '0.710000', 2, 'Golocinas', 0, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(2321, '653110235042', 'ALEGRIA DE MI PREPARATORIA 6 AÑOS', '5.9500', '4.250000', 10, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2322, '526078270627', 'MOCHILA DYUNIQUE ', '15.0000', '7.800000', 2, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2323, '461078067711', 'MOCHILA VE-AIVISI', '18.0000', '9.500000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2324, '553876363118', 'MOCHILA ST SPORT AZUL', '18.0000', '9.500000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3),
(2325, '6965201911064', 'MOCHILA VE BLACK PACK', '20.0000', '12.000000', 1, 'Escolar', 0, NULL, NULL, NULL, 1, NULL, NULL, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_cambio_local`
--

CREATE TABLE `log_cambio_local` (
  `id_log_cambio` int(11) NOT NULL,
  `id_server` int(11) DEFAULT NULL,
  `process` varchar(250) NOT NULL,
  `tabla` varchar(250) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_sucursal` int(11) DEFAULT NULL,
  `id_primario` int(11) DEFAULT NULL,
  `subido` int(11) NOT NULL,
  `verificado` int(11) NOT NULL,
  `prioridad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `log_cambio_local`
--

INSERT INTO `log_cambio_local` (`id_log_cambio`, `id_server`, `process`, `tabla`, `fecha`, `hora`, `id_usuario`, `id_sucursal`, `id_primario`, `subido`, `verificado`, `prioridad`) VALUES
(0, 0, 'update', 'correlativo', '2022-04-27', '10:41:03', 1, 1, 1, 1, 0, 1),
(1, 0, 'insert', 'producto', '2022-04-11', '11:05:03', 1, 1, 1, 1, 0, 1),
(2, 0, 'update', 'correlativo', '2022-04-11', '11:06:36', 1, 1, 1, 1, 0, 1),
(3, 0, 'insert', 'producto', '2022-04-11', '11:28:27', 1, 1, 2, 1, 0, 1),
(4, 0, 'update', 'correlativo', '2022-04-11', '11:29:24', 1, 1, 1, 1, 0, 1),
(5, 0, 'insert', 'producto', '2022-04-11', '11:38:04', 1, 1, 3, 1, 0, 1),
(6, 0, 'update', 'correlativo', '2022-04-11', '11:39:09', 1, 1, 1, 1, 0, 1),
(7, 0, 'insert', 'producto', '2022-04-11', '11:53:17', 1, 1, 4, 1, 0, 1),
(8, 0, 'update', 'correlativo', '2022-04-11', '11:53:59', 1, 1, 1, 1, 0, 1),
(9, 0, 'insert', 'producto', '2022-04-19', '10:51:33', 1, 1, 5, 1, 0, 1),
(10, 0, 'update', 'correlativo', '2022-04-19', '10:53:58', 1, 1, 1, 1, 0, 1),
(11, 0, 'insert', 'producto', '2022-04-19', '11:07:41', 1, 1, 6, 1, 0, 1),
(12, 0, 'insert', 'producto', '2022-04-19', '11:24:10', 1, 1, 7, 1, 0, 1),
(13, 0, 'insert', 'producto', '2022-04-19', '11:29:19', 1, 1, 8, 1, 0, 1),
(14, 0, 'insert', 'producto', '2022-04-19', '11:43:18', 1, 1, 9, 1, 0, 1),
(15, 0, 'insert', 'producto', '2022-04-19', '11:46:19', 1, 1, 10, 1, 0, 1),
(16, 0, 'insert', 'producto', '2022-04-19', '11:52:30', 1, 1, 11, 1, 0, 1),
(17, 0, 'insert', 'producto', '2022-04-19', '11:55:25', 1, 1, 12, 1, 0, 1),
(18, 0, 'insert', 'producto', '2022-04-19', '11:58:12', 1, 1, 13, 1, 0, 1),
(19, 0, 'insert', 'producto', '2022-04-19', '12:01:55', 1, 1, 14, 1, 0, 1),
(20, 0, 'insert', 'producto', '2022-04-19', '12:06:23', 1, 1, 15, 1, 0, 1),
(21, 0, 'update', 'producto', '2022-04-19', '12:07:13', 1, 1, 1, 1, 0, 2),
(22, NULL, 'update', 'presentacion_producto', '2022-04-19', '12:07:13', 1, 1, 1, 1, 0, 2),
(23, NULL, 'update', 'presentacion_producto', '2022-04-19', '12:07:13', 1, 1, 2, 1, 0, 2),
(24, 0, 'update', 'producto', '2022-04-19', '12:07:50', 1, 1, 15, 1, 0, 2),
(25, NULL, 'update', 'presentacion_producto', '2022-04-19', '12:07:50', 1, 1, 45, 1, 0, 2),
(26, NULL, 'update', 'presentacion_producto', '2022-04-19', '12:07:50', 1, 1, 46, 1, 0, 2),
(27, 0, 'insert', 'producto', '2022-04-19', '12:09:43', 1, 1, 16, 1, 0, 1),
(28, 0, 'insert', 'producto', '2022-04-19', '12:11:55', 1, 1, 17, 1, 0, 1),
(29, 0, 'insert', 'producto', '2022-04-19', '12:15:56', 1, 1, 18, 1, 0, 1),
(30, 0, 'insert', 'producto', '2022-04-19', '12:18:34', 1, 1, 19, 1, 0, 1),
(31, 0, 'insert', 'producto', '2022-04-19', '12:54:13', 1, 1, 20, 1, 0, 1),
(32, 0, 'insert', 'producto', '2022-04-19', '12:56:43', 1, 1, 21, 1, 0, 1),
(33, 0, 'update', 'producto', '2022-04-19', '12:57:06', 1, 1, 21, 1, 0, 2),
(34, NULL, 'update', 'presentacion_producto', '2022-04-19', '12:57:06', 1, 1, 57, 1, 0, 2),
(35, NULL, 'update', 'presentacion_producto', '2022-04-19', '12:57:06', 1, 1, 58, 1, 0, 2),
(36, 0, 'update', 'producto', '2022-04-19', '12:57:11', 1, 1, 21, 1, 0, 2),
(37, NULL, 'update', 'presentacion_producto', '2022-04-19', '12:57:11', 1, 1, 57, 1, 0, 2),
(38, NULL, 'update', 'presentacion_producto', '2022-04-19', '12:57:11', 1, 1, 58, 1, 0, 2),
(39, 0, 'insert', 'producto', '2022-04-19', '13:14:55', 1, 1, 22, 1, 0, 1),
(40, 0, 'insert', 'producto', '2022-04-25', '17:42:28', 1, 1, 23, 1, 0, 1),
(41, 0, 'update', 'producto', '2022-04-25', '17:42:40', 1, 1, 23, 1, 0, 2),
(42, NULL, 'update', 'presentacion_producto', '2022-04-25', '17:42:40', 1, 1, 61, 1, 0, 2),
(43, NULL, 'update', 'presentacion_producto', '2022-04-25', '17:42:40', 1, 1, 62, 1, 0, 2),
(44, 0, 'update', 'producto', '2022-04-25', '17:44:56', 1, 1, 23, 1, 0, 2),
(45, NULL, 'update', 'presentacion_producto', '2022-04-25', '17:44:56', 1, 1, 61, 1, 0, 2),
(46, NULL, 'update', 'presentacion_producto', '2022-04-25', '17:44:56', 1, 1, 62, 1, 0, 2),
(47, 0, 'update', 'producto', '2022-04-25', '17:45:16', 1, 1, 23, 1, 0, 2),
(48, NULL, 'update', 'presentacion_producto', '2022-04-25', '17:45:16', 1, 1, 61, 1, 0, 2),
(49, NULL, 'update', 'presentacion_producto', '2022-04-25', '17:45:16', 1, 1, 62, 1, 0, 2),
(50, 0, 'insert', 'producto', '2022-04-25', '17:53:23', 1, 1, 24, 1, 0, 1),
(51, 0, 'insert', 'producto', '2022-04-25', '18:01:25', 1, 1, 25, 1, 0, 1),
(52, 0, 'update', 'producto', '2022-04-25', '18:01:38', 1, 1, 23, 1, 0, 2),
(53, NULL, 'update', 'presentacion_producto', '2022-04-25', '18:01:38', 1, 1, 61, 1, 0, 2),
(54, NULL, 'update', 'presentacion_producto', '2022-04-25', '18:01:38', 1, 1, 62, 1, 0, 2),
(55, 0, 'update', 'producto', '2022-04-25', '18:02:15', 1, 1, 23, 1, 0, 2),
(56, NULL, 'update', 'presentacion_producto', '2022-04-25', '18:02:15', 1, 1, 61, 1, 0, 2),
(57, NULL, 'update', 'presentacion_producto', '2022-04-25', '18:02:15', 1, 1, 62, 1, 0, 2),
(58, 0, 'insert', 'producto', '2022-04-25', '18:33:54', 1, 1, 26, 1, 0, 1),
(59, 0, 'insert', 'producto', '2022-04-25', '18:36:31', 1, 1, 27, 1, 0, 1),
(60, 0, 'insert', 'producto', '2022-04-25', '18:39:06', 1, 1, 28, 1, 0, 1),
(61, 0, 'insert', 'producto', '2022-04-25', '18:42:53', 1, 1, 29, 1, 0, 1),
(62, 0, 'update', 'producto', '2022-04-25', '18:43:09', 1, 1, 28, 1, 0, 2),
(63, NULL, 'update', 'presentacion_producto', '2022-04-25', '18:43:09', 1, 1, 71, 1, 0, 2),
(64, NULL, 'update', 'presentacion_producto', '2022-04-25', '18:43:09', 1, 1, 72, 1, 0, 2),
(65, 0, 'insert', 'producto', '2022-04-25', '18:47:28', 1, 1, 30, 1, 0, 1),
(66, 0, 'insert', 'producto', '2022-04-25', '18:52:56', 1, 1, 31, 1, 0, 1),
(67, 0, 'update', 'producto', '2022-04-25', '18:53:31', 1, 1, 30, 1, 0, 2),
(68, NULL, 'update', 'presentacion_producto', '2022-04-25', '18:53:31', 1, 1, 75, 1, 0, 2),
(69, NULL, 'update', 'presentacion_producto', '2022-04-25', '18:53:31', 1, 1, 76, 1, 0, 2),
(70, 0, 'insert', 'producto', '2022-04-25', '18:55:36', 1, 1, 32, 1, 0, 1),
(71, 0, 'update', 'producto', '2022-04-25', '18:57:18', 1, 1, 3, 1, 0, 2),
(72, NULL, 'update', 'presentacion_producto', '2022-04-25', '18:57:18', 1, 1, 7, 1, 0, 2),
(73, NULL, 'update', 'presentacion_producto', '2022-04-25', '18:57:18', 1, 1, 8, 1, 0, 2),
(74, NULL, 'update', 'presentacion_producto', '2022-04-25', '18:57:18', 1, 1, 9, 1, 0, 2),
(75, 0, 'update', 'producto', '2022-04-25', '19:00:29', 1, 1, 7, 1, 0, 2),
(76, NULL, 'update', 'presentacion_producto', '2022-04-25', '19:00:29', 1, 1, 23, 1, 0, 2),
(77, NULL, 'update', 'presentacion_producto', '2022-04-25', '19:00:29', 1, 1, 24, 1, 0, 2),
(78, NULL, 'update', 'presentacion_producto', '2022-04-25', '19:00:29', 1, 1, 25, 1, 0, 2),
(79, NULL, 'update', 'presentacion_producto', '2022-04-25', '19:00:29', 1, 1, 26, 1, 0, 2),
(80, 0, 'insert', 'producto', '2022-04-25', '19:45:44', 1, 1, 33, 1, 0, 1),
(81, 0, 'insert', 'producto', '2022-04-25', '19:58:34', 1, 1, 34, 1, 0, 1),
(82, 0, 'insert', 'producto', '2022-04-25', '20:15:16', 1, 1, 35, 1, 0, 1),
(83, 0, 'insert', 'producto', '2022-04-25', '20:30:39', 1, 1, 36, 1, 0, 1),
(84, 0, 'insert', 'producto', '2022-04-25', '20:36:29', 1, 1, 37, 1, 0, 1),
(85, 0, 'insert', 'producto', '2022-04-25', '20:38:10', 1, 1, 38, 1, 0, 1),
(86, 0, 'insert', 'producto', '2022-04-25', '20:41:32', 1, 1, 39, 1, 0, 1),
(87, 0, 'insert', 'producto', '2022-04-25', '20:44:11', 1, 1, 40, 1, 0, 1),
(88, 0, 'insert', 'producto', '2022-04-25', '20:49:50', 1, 1, 41, 1, 0, 1),
(89, 0, 'insert', 'producto', '2022-04-25', '20:53:35', 1, 1, 42, 1, 0, 1),
(90, 0, 'insert', 'producto', '2022-04-25', '21:05:41', 1, 1, 43, 1, 0, 1),
(91, 0, 'insert', 'producto', '2022-04-25', '21:12:43', 1, 1, 44, 1, 0, 1),
(92, 0, 'insert', 'producto', '2022-04-25', '21:17:58', 1, 1, 45, 1, 0, 1),
(93, 0, 'update', 'producto', '2022-04-26', '11:28:48', 1, 1, 23, 1, 0, 2),
(94, NULL, 'update', 'presentacion_producto', '2022-04-26', '11:28:48', 1, 1, 61, 1, 0, 2),
(95, NULL, 'update', 'presentacion_producto', '2022-04-26', '11:28:48', 1, 1, 62, 1, 0, 2),
(96, 0, 'insert', 'producto', '2022-04-26', '11:43:46', 1, 1, 46, 1, 0, 1),
(97, NULL, 'insert', 'presentacion_producto', '2022-04-26', '11:44:28', 1, 1, 110, 1, 0, 1),
(98, NULL, 'insert', 'presentacion_producto', '2022-04-26', '11:46:52', 1, 1, 111, 1, 0, 1),
(99, 0, 'update', 'producto', '2022-04-26', '11:52:21', 1, 1, 45, 1, 0, 2),
(100, NULL, 'update', 'presentacion_producto', '2022-04-26', '11:52:21', 1, 1, 104, 1, 0, 2),
(101, NULL, 'update', 'presentacion_producto', '2022-04-26', '11:52:21', 1, 1, 105, 1, 0, 2),
(102, NULL, 'update', 'presentacion_producto', '2022-04-26', '11:52:21', 1, 1, 110, 1, 0, 2),
(103, NULL, 'update', 'presentacion_producto', '2022-04-26', '11:52:21', 1, 1, 111, 1, 0, 2),
(104, 0, 'update', 'producto', '2022-04-26', '11:52:50', 1, 1, 45, 1, 0, 2),
(105, NULL, 'update', 'presentacion_producto', '2022-04-26', '11:52:50', 1, 1, 104, 1, 0, 2),
(106, NULL, 'update', 'presentacion_producto', '2022-04-26', '11:52:50', 1, 1, 105, 1, 0, 2),
(107, NULL, 'update', 'presentacion_producto', '2022-04-26', '11:52:50', 1, 1, 110, 1, 0, 2),
(108, NULL, 'update', 'presentacion_producto', '2022-04-26', '11:52:50', 1, 1, 111, 1, 0, 2),
(109, 0, 'insert', 'producto', '2022-04-26', '12:03:29', 1, 1, 47, 1, 0, 1),
(110, 0, 'insert', 'producto', '2022-04-26', '12:38:52', 1, 1, 48, 1, 0, 1),
(111, 0, 'insert', 'producto', '2022-04-26', '12:39:52', 1, 1, 49, 1, 0, 1),
(112, 0, 'insert', 'producto', '2022-04-26', '12:40:59', 1, 1, 50, 1, 0, 1),
(113, 0, 'insert', 'producto', '2022-04-26', '12:41:58', 1, 1, 51, 1, 0, 1),
(114, 0, 'insert', 'producto', '2022-04-26', '12:42:40', 1, 1, 52, 1, 0, 1),
(115, 0, 'insert', 'producto', '2022-04-26', '12:43:34', 1, 1, 53, 1, 0, 1),
(116, 0, 'insert', 'producto', '2022-04-26', '13:14:51', 1, 1, 54, 1, 0, 1),
(117, 0, 'insert', 'producto', '2022-04-26', '13:22:49', 1, 1, 55, 1, 0, 1),
(118, 0, 'insert', 'producto', '2022-04-26', '13:26:06', 1, 1, 56, 1, 0, 1),
(119, 0, 'update', 'producto', '2022-04-26', '13:26:22', 1, 1, 46, 1, 0, 2),
(120, NULL, 'update', 'presentacion_producto', '2022-04-26', '13:26:22', 1, 1, 106, 1, 0, 2),
(121, NULL, 'update', 'presentacion_producto', '2022-04-26', '13:26:22', 1, 1, 107, 1, 0, 2),
(122, NULL, 'update', 'presentacion_producto', '2022-04-26', '13:26:22', 1, 1, 108, 1, 0, 2),
(123, NULL, 'update', 'presentacion_producto', '2022-04-26', '13:26:22', 1, 1, 109, 1, 0, 2),
(124, 0, 'update', 'producto', '2022-04-26', '13:27:57', 1, 1, 55, 1, 0, 2),
(125, NULL, 'update', 'presentacion_producto', '2022-04-26', '13:27:57', 1, 1, 123, 1, 0, 2),
(126, NULL, 'update', 'presentacion_producto', '2022-04-26', '13:27:57', 1, 1, 124, 1, 0, 2),
(127, NULL, 'update', 'presentacion_producto', '2022-04-26', '13:27:57', 1, 1, 125, 1, 0, 2),
(128, NULL, 'update', 'presentacion_producto', '2022-04-26', '13:27:57', 1, 1, 126, 1, 0, 2),
(129, 0, 'insert', 'producto', '2022-04-26', '13:30:16', 1, 1, 57, 1, 0, 1),
(130, 0, 'insert', 'producto', '2022-04-26', '13:38:56', 1, 1, 58, 1, 0, 1),
(131, 0, 'update', 'producto', '2022-04-26', '13:40:19', 1, 1, 57, 1, 0, 2),
(132, NULL, 'update', 'presentacion_producto', '2022-04-26', '13:40:19', 1, 1, 131, 1, 0, 2),
(133, NULL, 'update', 'presentacion_producto', '2022-04-26', '13:40:19', 1, 1, 132, 1, 0, 2),
(134, NULL, 'update', 'presentacion_producto', '2022-04-26', '13:40:19', 1, 1, 133, 1, 0, 2),
(135, NULL, 'update', 'presentacion_producto', '2022-04-26', '13:40:19', 1, 1, 134, 1, 0, 2),
(136, 0, 'update', 'producto', '2022-04-26', '13:40:37', 1, 1, 57, 1, 0, 2),
(137, NULL, 'update', 'presentacion_producto', '2022-04-26', '13:40:37', 1, 1, 131, 1, 0, 2),
(138, NULL, 'update', 'presentacion_producto', '2022-04-26', '13:40:37', 1, 1, 132, 1, 0, 2),
(139, NULL, 'update', 'presentacion_producto', '2022-04-26', '13:40:37', 1, 1, 133, 1, 0, 2),
(140, NULL, 'update', 'presentacion_producto', '2022-04-26', '13:40:37', 1, 1, 134, 1, 0, 2),
(141, 0, 'update', 'producto', '2022-04-26', '13:41:36', 1, 1, 58, 1, 0, 2),
(142, NULL, 'update', 'presentacion_producto', '2022-04-26', '13:41:36', 1, 1, 135, 1, 0, 2),
(143, NULL, 'update', 'presentacion_producto', '2022-04-26', '13:41:36', 1, 1, 136, 1, 0, 2),
(144, NULL, 'update', 'presentacion_producto', '2022-04-26', '13:41:36', 1, 1, 137, 1, 0, 2),
(145, NULL, 'update', 'presentacion_producto', '2022-04-26', '13:41:36', 1, 1, 138, 1, 0, 2),
(146, 0, 'update', 'producto', '2022-04-26', '13:42:19', 1, 1, 58, 1, 0, 2),
(147, NULL, 'update', 'presentacion_producto', '2022-04-26', '13:42:19', 1, 1, 135, 1, 0, 2),
(148, NULL, 'update', 'presentacion_producto', '2022-04-26', '13:42:19', 1, 1, 136, 1, 0, 2),
(149, NULL, 'update', 'presentacion_producto', '2022-04-26', '13:42:19', 1, 1, 137, 1, 0, 2),
(150, NULL, 'update', 'presentacion_producto', '2022-04-26', '13:42:19', 1, 1, 138, 1, 0, 2),
(151, 0, 'insert', 'producto', '2022-04-26', '13:44:46', 1, 1, 59, 1, 0, 1),
(152, 0, 'insert', 'producto', '2022-04-26', '13:48:37', 1, 1, 60, 1, 0, 1),
(153, 0, 'insert', 'producto', '2022-04-26', '13:51:18', 1, 1, 61, 1, 0, 1),
(154, 0, 'insert', 'producto', '2022-04-26', '14:02:10', 1, 1, 62, 1, 0, 1),
(155, 0, 'insert', 'producto', '2022-04-26', '14:08:42', 1, 1, 63, 1, 0, 1),
(156, 0, 'update', 'producto', '2022-04-26', '14:09:32', 1, 1, 62, 1, 0, 2),
(157, NULL, 'update', 'presentacion_producto', '2022-04-26', '14:09:32', 1, 1, 149, 1, 0, 2),
(158, NULL, 'update', 'presentacion_producto', '2022-04-26', '14:09:32', 1, 1, 150, 1, 0, 2),
(159, NULL, 'update', 'presentacion_producto', '2022-04-26', '14:09:32', 1, 1, 151, 1, 0, 2),
(160, 0, 'insert', 'producto', '2022-04-26', '14:16:56', 1, 1, 64, 1, 0, 1),
(161, 0, 'insert', 'producto', '2022-04-26', '14:20:45', 1, 1, 65, 1, 0, 1),
(162, 0, 'insert', 'producto', '2022-04-26', '14:23:26', 1, 1, 66, 1, 0, 1),
(163, 0, 'insert', 'producto', '2022-04-26', '14:27:58', 1, 1, 67, 1, 0, 1),
(164, 0, 'insert', 'producto', '2022-04-26', '14:29:59', 1, 1, 68, 1, 0, 1),
(165, 0, 'insert', 'producto', '2022-04-26', '14:31:18', 1, 1, 69, 1, 0, 1),
(166, 0, 'insert', 'producto', '2022-04-26', '14:33:07', 1, 1, 70, 1, 0, 1),
(167, 0, 'insert', 'producto', '2022-04-26', '14:34:45', 1, 1, 71, 1, 0, 1),
(168, 0, 'insert', 'producto', '2022-04-26', '14:36:25', 1, 1, 72, 1, 0, 1),
(169, 0, 'insert', 'producto', '2022-04-26', '14:39:16', 1, 1, 73, 1, 0, 1),
(170, 0, 'insert', 'producto', '2022-04-26', '14:42:20', 1, 1, 74, 1, 0, 1),
(171, 0, 'insert', 'producto', '2022-04-26', '14:51:09', 1, 1, 75, 1, 0, 1),
(172, 0, 'insert', 'producto', '2022-04-26', '15:46:11', 1, 1, 76, 1, 0, 1),
(173, 0, 'insert', 'producto', '2022-04-26', '15:48:05', 1, 1, 77, 1, 0, 1),
(174, 0, 'insert', 'producto', '2022-04-26', '15:49:30', 1, 1, 78, 1, 0, 1),
(175, 0, 'insert', 'producto', '2022-04-26', '15:52:23', 1, 1, 79, 1, 0, 1),
(176, 0, 'insert', 'producto', '2022-04-26', '15:54:27', 1, 1, 80, 1, 0, 1),
(177, 0, 'insert', 'producto', '2022-04-26', '15:56:16', 1, 1, 81, 1, 0, 1),
(178, 0, 'insert', 'producto', '2022-04-26', '16:01:16', 1, 1, 82, 1, 0, 1),
(179, 0, 'insert', 'producto', '2022-04-26', '16:08:56', 1, 1, 83, 1, 0, 1),
(180, 0, 'insert', 'producto', '2022-04-26', '16:11:17', 1, 1, 84, 1, 0, 1),
(181, 0, 'insert', 'producto', '2022-04-26', '16:16:36', 1, 1, 85, 1, 0, 1),
(182, 0, 'insert', 'producto', '2022-04-26', '16:20:13', 1, 1, 86, 1, 0, 1),
(183, 0, 'insert', 'producto', '2022-04-26', '16:24:38', 1, 1, 87, 1, 0, 1),
(184, 0, 'insert', 'producto', '2022-04-26', '16:26:15', 1, 1, 88, 1, 0, 1),
(185, 0, 'insert', 'producto', '2022-04-26', '16:29:04', 1, 1, 89, 1, 0, 1),
(186, 0, 'insert', 'producto', '2022-04-26', '16:31:16', 1, 1, 90, 1, 0, 1),
(187, 0, 'insert', 'producto', '2022-04-26', '16:34:18', 1, 1, 91, 1, 0, 1),
(188, 0, 'insert', 'producto', '2022-04-26', '16:36:53', 1, 1, 92, 1, 0, 1),
(189, 0, 'insert', 'producto', '2022-04-26', '16:42:13', 1, 1, 93, 1, 0, 1),
(190, 0, 'insert', 'producto', '2022-04-26', '16:46:48', 1, 1, 94, 1, 0, 1),
(191, 0, 'update', 'producto', '2022-04-26', '16:47:17', 1, 1, 94, 1, 0, 2),
(192, NULL, 'update', 'presentacion_producto', '2022-04-26', '16:47:17', 1, 1, 216, 1, 0, 2),
(193, 0, 'insert', 'producto', '2022-04-26', '16:50:36', 1, 1, 95, 1, 0, 1),
(194, 0, 'insert', 'producto', '2022-04-26', '16:52:23', 1, 1, 96, 1, 0, 1),
(195, 0, 'insert', 'producto', '2022-04-26', '16:54:46', 1, 1, 97, 1, 0, 1),
(196, 0, 'insert', 'producto', '2022-04-26', '16:56:45', 1, 1, 98, 1, 0, 1),
(197, 0, 'update', 'correlativo', '2022-04-27', '12:11:55', 1, 1, 1, 1, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_detalle_cambio_local`
--

CREATE TABLE `log_detalle_cambio_local` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_detalle_cambio` int(11) NOT NULL,
  `id_log_cambio` int(11) NOT NULL,
  `tabla` varchar(250) NOT NULL,
  `id_verificador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `log_detalle_cambio_local`
--

INSERT INTO `log_detalle_cambio_local` (`id_server`, `unique_id`, `id_detalle_cambio`, `id_log_cambio`, `tabla`, `id_verificador`) VALUES
(0, 'S62545fbfc32ca9.55918962', 1, 1, 'producto', 1),
(0, 'S6254653b59fe13.21493786', 2, 3, 'producto', 2),
(0, 'S6254677c65d1e3.40819715', 3, 5, 'producto', 3),
(0, 'S62546b0d85da68.84983733', 4, 7, 'producto', 4),
(0, 'S625ee895e3af08.67599346', 5, 9, 'producto', 5),
(0, 'S625eec5d548189.15134670', 6, 11, 'producto', 6),
(0, 'S625ef03ab99e45.85651265', 7, 12, 'producto', 7),
(0, 'S625ef16fb508a4.75007329', 8, 13, 'producto', 8),
(0, 'S625ef4b62ab012.35603908', 9, 14, 'producto', 9),
(0, 'S625ef56b3999d6.51214447', 10, 15, 'producto', 10),
(0, 'S625ef6de9bb5f2.09675125', 11, 16, 'producto', 11),
(0, 'S625ef78d180182.80339392', 12, 17, 'producto', 12),
(0, 'S625ef8347adad4.12605197', 13, 18, 'producto', 13),
(0, 'S625ef913e42de8.60283356', 14, 19, 'producto', 14),
(0, 'S625efa1f228ef9.33976321', 15, 20, 'producto', 15),
(0, 'S625efa51c253e5.55756305', 16, 22, 'presentacion_producto', 1),
(0, 'S625efa51c2cda4.02949801', 17, 23, 'presentacion_producto', 2),
(0, 'S625efa76b6bd31.11663726', 18, 25, 'presentacion_producto', 45),
(0, 'S625efa76b78381.79900756', 19, 26, 'presentacion_producto', 46),
(0, 'S625efae78fa6f2.94907761', 20, 27, 'producto', 16),
(0, 'S625efb6bc4f513.13280167', 21, 28, 'producto', 17),
(0, 'S625efc5c255997.16415520', 22, 29, 'producto', 18),
(0, 'S625efcfa366e78.16216261', 23, 30, 'producto', 19),
(0, 'S625f05552622e5.99411939', 24, 31, 'producto', 20),
(0, 'S625f05ebbd7a16.38208260', 25, 32, 'producto', 21),
(0, 'S625f0602198693.60124060', 26, 34, 'presentacion_producto', 57),
(0, 'S625f06021a9b40.58519788', 27, 35, 'presentacion_producto', 58),
(0, 'S625f060769cc75.31605101', 28, 37, 'presentacion_producto', 57),
(0, 'S625f06076a4d12.25576905', 29, 38, 'presentacion_producto', 58),
(0, 'S625f0a2fb627f5.50533243', 30, 39, 'producto', 22),
(0, 'S626731e4b42827.78214325', 31, 40, 'producto', 23),
(0, 'S626731f07beba5.25866334', 32, 42, 'presentacion_producto', 61),
(0, 'S626731f07c5d74.35870568', 33, 43, 'presentacion_producto', 62),
(0, 'S626732786a44b2.67744932', 34, 45, 'presentacion_producto', 61),
(0, 'S626732786b1f22.98650159', 35, 46, 'presentacion_producto', 62),
(0, 'S6267328c03a9a2.43949623', 36, 48, 'presentacion_producto', 61),
(0, 'S6267328c044208.95688746', 37, 49, 'presentacion_producto', 62),
(0, 'S62673473a94775.24406177', 38, 50, 'producto', 24),
(0, 'S6267365581fd63.60812684', 39, 51, 'producto', 25),
(0, 'S62673662ec9dd4.19949157', 40, 53, 'presentacion_producto', 61),
(0, 'S62673662ed0112.22228559', 41, 54, 'presentacion_producto', 62),
(0, 'S62673687832a47.44987817', 42, 56, 'presentacion_producto', 61),
(0, 'S6267368783bed7.14470062', 43, 57, 'presentacion_producto', 62),
(0, 'S62673df29d7d25.64389273', 44, 58, 'producto', 26),
(0, 'S62673e8f62c7f8.41690234', 45, 59, 'producto', 27),
(0, 'S62673f2a1ac2e9.46501621', 46, 60, 'producto', 28),
(0, 'S6267400d7814e5.76765354', 47, 61, 'producto', 29),
(0, 'S6267401d76bfb9.17725671', 48, 63, 'presentacion_producto', 71),
(0, 'S6267401d775af8.42552693', 49, 64, 'presentacion_producto', 72),
(0, 'S62674120e89c15.29775672', 50, 65, 'producto', 30),
(0, 'S626742684a5450.70843333', 51, 66, 'producto', 31),
(0, 'S6267428b9510e2.23096015', 52, 68, 'presentacion_producto', 75),
(0, 'S6267428b956f60.30625145', 53, 69, 'presentacion_producto', 76),
(0, 'S626743086ec321.27843614', 54, 70, 'producto', 32),
(0, 'S6267436ec1b134.01902475', 55, 72, 'presentacion_producto', 7),
(0, 'S6267436ec22d71.17064301', 56, 73, 'presentacion_producto', 8),
(0, 'S6267436ec29da8.14146927', 57, 74, 'presentacion_producto', 9),
(0, 'S6267442dbc0122.19669881', 58, 76, 'presentacion_producto', 23),
(0, 'S6267442dbd0bd2.22609550', 59, 77, 'presentacion_producto', 24),
(0, 'S6267442dbd8ff8.69766695', 60, 78, 'presentacion_producto', 25),
(0, 'S6267442dbe09a9.18076050', 61, 79, 'presentacion_producto', 26),
(0, 'S62674ec8ac1914.38584206', 62, 80, 'producto', 33),
(0, 'S626751cad81e96.66373827', 63, 81, 'producto', 34),
(0, 'S626755b47ccc45.04475459', 64, 82, 'producto', 35),
(0, 'S6267594fc7baf7.33786535', 65, 83, 'producto', 36),
(0, 'S62675aad66baa8.46469478', 66, 84, 'producto', 37),
(0, 'S62675b12be49e5.68302806', 67, 85, 'producto', 38),
(0, 'S62675bdc4d6649.20400851', 68, 86, 'producto', 39),
(0, 'S62675c7b6d0c46.13322449', 69, 87, 'producto', 40),
(0, 'S62675dce3dc5d3.50942798', 70, 88, 'producto', 41),
(0, 'S62675eafb00139.70442704', 71, 89, 'producto', 42),
(0, 'S62676185273522.27219526', 72, 90, 'producto', 43),
(0, 'S6267632b102eb6.34712306', 73, 91, 'producto', 44),
(0, 'S62676466029777.74281416', 74, 92, 'producto', 45),
(0, 'S62682bd0627968.27086411', 75, 94, 'presentacion_producto', 61),
(0, 'S62682bd0630ec9.38986472', 76, 95, 'presentacion_producto', 62),
(0, 'S62682f522d0026.97791474', 77, 96, 'producto', 46),
(0, 'S62682f7c2bfe26.04323470', 78, 97, 'presentacion_producto', 110),
(0, 'S6268300c165502.81161589', 79, 98, 'presentacion_producto', 111),
(0, 'S6268315593e7c6.95690682', 80, 100, 'presentacion_producto', 104),
(0, 'S62683155946995.88103107', 81, 101, 'presentacion_producto', 105),
(0, 'S62683155950697.48509370', 82, 102, 'presentacion_producto', 110),
(0, 'S6268315596b150.67517841', 83, 103, 'presentacion_producto', 111),
(0, 'S626831728c7521.69588808', 84, 105, 'presentacion_producto', 104),
(0, 'S626831728d3315.54073849', 85, 106, 'presentacion_producto', 105),
(0, 'S626831728dd669.09685749', 86, 107, 'presentacion_producto', 110),
(0, 'S626831728e5182.29888246', 87, 108, 'presentacion_producto', 111),
(0, 'S626833f1e05777.75208207', 88, 109, 'producto', 47),
(0, 'S62683c3c054f00.36300403', 89, 110, 'producto', 48),
(0, 'S62683c78f3b1f6.47682397', 90, 111, 'producto', 49),
(0, 'S62683cbbd40091.83773612', 91, 112, 'producto', 50),
(0, 'S62683cf6443b34.12208154', 92, 113, 'producto', 51),
(0, 'S62683d20cebaf8.61319169', 93, 114, 'producto', 52),
(0, 'S62683d56b2ca20.51365740', 94, 115, 'producto', 53),
(0, 'S626844ab42d3e7.53661857', 95, 116, 'producto', 54),
(0, 'S62684689285d28.82120554', 96, 117, 'producto', 55),
(0, 'S6268474e2b29a6.64721284', 97, 118, 'producto', 56),
(0, 'S6268475e3571a3.00300575', 98, 120, 'presentacion_producto', 106),
(0, 'S6268475e35e016.58340358', 99, 121, 'presentacion_producto', 107),
(0, 'S6268475e363e94.01270399', 100, 122, 'presentacion_producto', 108),
(0, 'S6268475e36a145.96500106', 101, 123, 'presentacion_producto', 109),
(0, 'S626847bd2a7078.05520623', 102, 125, 'presentacion_producto', 123),
(0, 'S626847bd2aefa0.31338016', 103, 126, 'presentacion_producto', 124),
(0, 'S626847bd2b5cf9.46405373', 104, 127, 'presentacion_producto', 125),
(0, 'S626847bd2bbbb8.30752581', 105, 128, 'presentacion_producto', 126),
(0, 'S626848487815b3.03063487', 106, 129, 'producto', 57),
(0, 'S62684a505cb372.30265597', 107, 130, 'producto', 58),
(0, 'S62684aa32526e0.12174041', 108, 132, 'presentacion_producto', 131),
(0, 'S62684aa325c037.58095196', 109, 133, 'presentacion_producto', 132),
(0, 'S62684aa3264d43.91095234', 110, 134, 'presentacion_producto', 133),
(0, 'S62684aa326d991.11068564', 111, 135, 'presentacion_producto', 134),
(0, 'S62684ab59b1c48.59125995', 112, 137, 'presentacion_producto', 131),
(0, 'S62684ab59bab42.83714897', 113, 138, 'presentacion_producto', 132),
(0, 'S62684ab59c3508.48929956', 114, 139, 'presentacion_producto', 133),
(0, 'S62684ab59cbd34.66839488', 115, 140, 'presentacion_producto', 134),
(0, 'S62684af0bdfa78.16122938', 116, 142, 'presentacion_producto', 135),
(0, 'S62684af0be7e81.12408007', 117, 143, 'presentacion_producto', 136),
(0, 'S62684af0bef495.22369920', 118, 144, 'presentacion_producto', 137),
(0, 'S62684af0bf7494.81814372', 119, 145, 'presentacion_producto', 138),
(0, 'S62684b1b22e552.53394229', 120, 147, 'presentacion_producto', 135),
(0, 'S62684b1b239f25.77187342', 121, 148, 'presentacion_producto', 136),
(0, 'S62684b1b248af5.92502104', 122, 149, 'presentacion_producto', 137),
(0, 'S62684b1b24ebe3.81111782', 123, 150, 'presentacion_producto', 138),
(0, 'S62684baee2f981.24244874', 124, 151, 'producto', 59),
(0, 'S62684c95ec9a43.40834681', 125, 152, 'producto', 60),
(0, 'S62684d360e3144.37644520', 126, 153, 'producto', 61),
(0, 'S62684fc2a18166.02223160', 127, 154, 'producto', 62),
(0, 'S6268514aedd629.78588543', 128, 155, 'producto', 63),
(0, 'S6268517c8dfe70.83212509', 129, 157, 'presentacion_producto', 149),
(0, 'S6268517c8e7826.65581901', 130, 158, 'presentacion_producto', 150),
(0, 'S6268517c8efca0.67936209', 131, 159, 'presentacion_producto', 151),
(0, 'S62685338f30a32.85748772', 132, 160, 'producto', 64),
(0, 'S6268541d69d621.96893482', 133, 161, 'producto', 65),
(0, 'S626854bedd72d8.39168426', 134, 162, 'producto', 66),
(0, 'S626855ceafb588.96839527', 135, 163, 'producto', 67),
(0, 'S62685647aead07.80701251', 136, 164, 'producto', 68),
(0, 'S62685696172cd6.80141611', 137, 165, 'producto', 69),
(0, 'S62685703c71727.71261067', 138, 166, 'producto', 70),
(0, 'S62685765d72ea7.73612600', 139, 167, 'producto', 71),
(0, 'S626857c9047bc9.22441653', 140, 168, 'producto', 72),
(0, 'S62685874adaa69.64031598', 141, 169, 'producto', 73),
(0, 'S6268592c8f4216.92602550', 142, 170, 'producto', 74),
(0, 'S62685b3d556f13.64159788', 143, 171, 'producto', 75),
(0, 'S626868232b6381.41150206', 144, 172, 'producto', 76),
(0, 'S62686895a86f99.64084213', 145, 173, 'producto', 77),
(0, 'S626868ea1d5426.76185109', 146, 174, 'producto', 78),
(0, 'S626869970c5400.97299047', 147, 175, 'producto', 79),
(0, 'S62686a13228065.55108332', 148, 176, 'producto', 80),
(0, 'S62686a80a79418.56112307', 149, 177, 'producto', 81),
(0, 'S62686bac53c300.43461558', 150, 178, 'producto', 82),
(0, 'S62686d7861c172.08399819', 151, 179, 'producto', 83),
(0, 'S62686e052e7138.16407664', 152, 180, 'producto', 84),
(0, 'S62686f44295c45.11369231', 153, 181, 'producto', 85),
(0, 'S6268701d3873c6.69597085', 154, 182, 'producto', 86),
(0, 'S62687126bf9639.23862455', 155, 183, 'producto', 87),
(0, 'S626871870f3170.84365614', 156, 184, 'producto', 88),
(0, 'S62687230459890.07218405', 157, 185, 'producto', 89),
(0, 'S626872b47ec0b6.17100817', 158, 186, 'producto', 90),
(0, 'S6268736a543d37.01740493', 159, 187, 'producto', 91),
(0, 'S62687405dd4943.24725282', 160, 188, 'producto', 92),
(0, 'S6268754535b200.33828382', 161, 189, 'producto', 93),
(0, 'S626876580e2910.04490495', 162, 190, 'producto', 94),
(0, 'S62687675348a59.18487990', 163, 192, 'presentacion_producto', 216),
(0, 'S6268773c13fd41.97718235', 164, 193, 'producto', 95),
(0, 'S626877a7df4a34.23046556', 165, 194, 'producto', 96),
(0, 'S626878365162f8.58741696', 166, 195, 'producto', 97),
(0, 'S626878ad2298c8.77551307', 167, 196, 'producto', 98);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_update_local`
--

CREATE TABLE `log_update_local` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_log_cambio` int(11) NOT NULL,
  `query` text NOT NULL,
  `tabla` varchar(250) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_sucursal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lote`
--

CREATE TABLE `lote` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_lote` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `fecha_entrada` date NOT NULL,
  `numero` int(11) NOT NULL,
  `cantidad` decimal(11,4) NOT NULL,
  `precio` decimal(11,4) NOT NULL,
  `id_presentacion` int(11) NOT NULL,
  `vencimiento` date DEFAULT NULL,
  `estado` varchar(25) NOT NULL,
  `referencia` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `lote`
--

INSERT INTO `lote` (`id_server`, `unique_id`, `id_sucursal`, `id_lote`, `id_producto`, `fecha_entrada`, `numero`, `cantidad`, `precio`, `id_presentacion`, `vencimiento`, `estado`, `referencia`) VALUES
(0, 'S6254601c0bffb8.33449475', 1, 1, 1, '2022-04-11', 1, '199.0000', '3.0000', 1, NULL, 'VIGENTE', '0000001_II'),
(0, 'S625465747cbc19.77426666', 1, 2, 2, '2022-04-11', 1, '587.0000', '10.0008', 3, NULL, 'VIGENTE', '0000002_II'),
(0, 'S625467bd76c059.88646652', 1, 3, 3, '2022-04-11', 1, '67.0000', '15.0000', 7, NULL, 'VIGENTE', '0000003_II'),
(0, 'S62546b372f4e60.39737022', 1, 4, 4, '2022-04-11', 1, '1200.0000', '23.0016', 10, NULL, 'VIGENTE', '0000004_II'),
(0, 'S625ee92640b7f7.87606780', 1, 5, 5, '2022-04-19', 1, '1164.0000', '10.0008', 15, NULL, 'VIGENTE', '0000005_II');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_menu` int(11) NOT NULL,
  `nombre` varchar(250) DEFAULT NULL,
  `prioridad` int(11) DEFAULT NULL,
  `icono` varchar(250) NOT NULL,
  `visible` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id_server`, `unique_id`, `id_menu`, `nombre`, `prioridad`, `icono`, `visible`) VALUES
(1, 'O60d7df55068935.53249569', 1, 'Productos', 5, 'fa fa-archive', 1),
(2, 'O60d7df5507d609.84496391', 2, 'Clientes', 1, 'fa fa-users', 1),
(3, 'O60d7df550a83d7.68720876', 3, 'Proveedores', 2, 'fa fa-truck', 1),
(4, 'O60d7df550b3908.32464233', 4, 'Ubicaciones', 4, 'fa fa-database', 1),
(5, 'O60d7df550d6733.13525706', 5, 'Facturación', 8, 'fa fa-money', 1),
(6, 'O60d7df550f4507.44116249', 6, 'Inventario', 7, 'fa fa-table', 1),
(7, 'O60d7df55115309.45560699', 7, 'Caja', 12, 'fa fa-money', 1),
(8, 'O60d7df551369b1.68239316', 8, 'Cuentas por Cobrar', 10, ' fa fa-credit-card', 1),
(9, 'O60d7df55158550.67166195', 9, 'Empleados', 3, 'fa fa-users', 1),
(10, 'O60d7df55179443.96567625', 10, 'Bancos', 9, 'fa fa-bank', 0),
(11, 'O60d7df5519a1f8.34444108', 11, 'Compras', 6, 'fa fa-cart-arrow-down', 1),
(12, 'O60d7df551baa74.56659208', 12, 'Cuentas por Pagar', 11, 'fa fa-balance-scale', 1),
(13, 'O60d7df551dc836.75570782', 13, 'Cotizaciones', 13, 'fa fa-file-pdf-o', 1),
(14, 'O60d7df551fd460.24595789', 14, 'Traslados', 15, 'fa fa-exchange', 0),
(15, 'O60d7df5521f0f8.07652929', 15, 'Utilidades', 16, 'fa fa-gears', 1),
(16, 'O60d7df55240a13.24187446', 16, 'Pedidos', 14, 'fa fa-file', 0),
(17, 'O60d7df55262252.08193710', 17, 'Reportes', 15, 'fa fa-file-pdf-o', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE `modulo` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `nombre` varchar(250) DEFAULT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `filename` varchar(250) DEFAULT NULL,
  `mostrarmenu` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`id_server`, `unique_id`, `id_modulo`, `id_menu`, `nombre`, `descripcion`, `filename`, `mostrarmenu`) VALUES
(1, 'O60d7df55290a33.25415397', 1, 2, 'Admin Clientes', 'Admin Clientes', 'admin_cliente.php', 1),
(2, 'O60d7df552a3371.38537014', 2, 2, 'Agregar Cliente', 'Agregar Cliente', 'agregar_cliente.php', 0),
(3, 'O60d7df552c4f66.87756158', 3, 2, 'Editar Cliente', 'Editar Cliente', 'editar_cliente.php', 0),
(4, 'O60d7df552e7ac8.42710402', 4, 0, 'Borrar Cliente', 'Borrar Cliente', 'borrar_cliente.php', 0),
(5, 'O60d7df55308472.42586169', 5, 2, 'Ver Cliente', 'Ver Cliente', 'ver_cliente.php', 0),
(6, 'O60d7df553295c0.15447232', 6, 1, 'Admin Productos', 'Admin Productos', 'admin_producto.php', 1),
(7, 'O60d7df5534acb5.61555055', 7, 1, 'Agregar Producto', 'Agregar Producto', 'agregar_producto.php', 0),
(8, 'O60d7df5536c747.81899312', 8, 1, 'Editar Producto', 'Editar Producto', 'editar_producto.php', 0),
(9, 'O60d7df5538ce97.19100735', 9, 0, 'Borrar Producto', 'Borrar Producto', 'borrar_producto.php', 0),
(10, 'O60d7df553ad593.38154235', 10, 1, 'Ver Producto', 'Ver Producto', 'ver_producto.php', 0),
(11, 'O60d7df553ce322.30936788', 11, 1, 'Admin Categorías', 'Admin Categorías', 'admin_categoria.php', 1),
(12, 'O60d7df553f0c10.85487193', 12, 1, 'Agregar Categoría', 'Agregar Categoría', 'agregar_categoria.php', 0),
(13, 'O60d7df55411655.26330011', 13, 1, 'Editar Categoría', 'Editar Categoría', 'editar_categoria.php', 0),
(14, 'O60d7df554327a7.98756650', 14, 1, 'Borrar Categoría', 'Borrar Categoría', 'borrar_categoria.php', 0),
(15, 'O60d7df554523a9.58037361', 15, 1, 'Admin Presentaciones', 'Admin Presentaciones', 'admin_presentacion.php', 1),
(16, 'O60d7df55475625.54594148', 16, 1, 'Agregar Presentación', 'Agregar Presentación', 'agregar_presentacion.php', 0),
(17, 'O60d7df55495b56.07721965', 17, 1, 'Editar Presentación', 'Editar Presentación', 'editar_presentacion.php', 0),
(18, 'O60d7df554b6983.85897144', 18, 0, 'Borrar Presentación', 'Borrar Presentación', 'borrar_presentacion.php', 0),
(19, 'O60d7df554d7b44.68567392', 19, 3, 'Admin Proveedores', 'Admin Proveedores', 'admin_proveedor.php', 1),
(20, 'O60d7df554f9b11.90458590', 20, 3, 'Agregar Proveedor', 'Agregar Proveedor', 'agregar_proveedor.php', 0),
(21, 'O60d7df5551a0f6.23816012', 21, 3, 'Editar Proveedor', 'Editar Proveedor', 'editar_proveedor.php', 0),
(22, 'O60d7df5553ada0.53406272', 22, 3, 'Borrar Proveedor', 'Borrar Proveedor', 'borrar_proveedor.php', 0),
(23, 'O60d7df5555c3d6.65296021', 23, 3, 'Ver Proveedor', 'Ver Proveedor', 'ver_proveedor.php', 0),
(24, 'O60d7df5557d294.06038287', 24, 4, 'Ubicaciones', 'Administrar Ubicaciones', 'admin_ubicacion.php', 1),
(25, 'O60d7df5559e4b1.38601145', 25, 4, 'Agregar Ubicación', 'Agregar  Ubicación', 'agregar_ubicacion.php', 0),
(26, 'O60d7df555bf159.32722407', 26, 4, 'Editar Ubicación', 'Editar Ubicación', 'editar_ubicacion.php', 0),
(27, 'O60d7df555e1155.22982975', 27, 4, 'Borrar Ubicación', 'Borrar Ubicación', 'borrar_ubicacion.php', 0),
(28, 'O60d7df556026f3.66302559', 28, 4, 'Estantes', 'Administrar Estantes', 'admin_estante.php', 0),
(29, 'O60d7df55623a93.80667618', 29, 4, 'Agregar Estante', 'Agregar Estante', 'agregar_estante.php', 0),
(30, 'O60d7df556444f6.28317204', 30, 4, 'Editar Estante', 'Editar  Estante', 'editar_estante.php', 0),
(31, 'O60d7df55664ed1.22669129', 31, 4, 'Borrar Estante', 'Borrar  Estante', 'borrar_estante.php', 0),
(32, 'O60d7df55686d18.16576595', 32, 4, 'Admin Asignación', 'Admin Asignación', 'admin_asignacion.php', 0),
(33, 'O60d7df556a6d42.30841890', 33, 4, 'Agregar Asignación', 'Agregar Asignación', 'agregar_asignacion.php', 0),
(34, 'O60d7df556c8261.79562350', 34, 4, 'Admin no Asignado', 'Admin no Asignado', 'admin_producto_no_asignado.php', 0),
(35, 'O60d7df556e8836.67453788', 35, 5, 'Pre Venta', 'Pre Venta', 'preventa.php', 1),
(36, 'O60d7df5570aaf6.70862800', 36, 5, 'Venta', 'Venta', 'venta.php', 1),
(37, 'O60d7df5572a995.82583574', 37, 6, 'Cargas de Inventario', 'Cargas de Inventario', 'ingreso_inventario.php', 1),
(38, 'O60d7df5574c723.69004790', 38, 6, 'Descargos de Inventario', 'Descargos de Inventario', 'descargo_inventario.php', 1),
(39, 'O60d7df5576d295.26505082', 39, 4, 'Movimientos', 'Movimientos', 'admin_movimiento_asignacion.php', 0),
(40, 'O60d7df5578fec7.96940159', 40, 4, 'Ver Detalle Movimiento', 'Ver Detalle Movimiento', 'ver_detalle_mov.php', 0),
(41, 'O60d7df557b04d5.78190708', 41, 7, 'Admin Corte', 'Admin Corte', 'admin_corte.php', 1),
(42, 'O60d7df557d0ee1.34057895', 42, 7, 'Admin Caja', 'Admin Caja', 'admin_caja.php', 0),
(43, 'O60d7df557f1f92.46881732', 43, 8, 'Admin Créditos', 'Admin Créditos', 'admin_credito.php', 1),
(44, 'O60d7df558144e4.20429203', 44, 8, 'Abono Crédito', 'Abono Crédito', 'abono_credito.php', 0),
(45, 'O60d7df558354c1.67313669', 45, 9, 'Admin Empleados', 'Admin Empleados', 'admin_empleado.php', 1),
(46, 'O60d7df55856b83.01918524', 46, 9, 'Agregar Empleado', 'Agregar Empleado', 'agregar_empleado.php', 0),
(47, 'O60d7df55877b42.85729112', 47, 9, 'Editar Empleado', 'Editar Empleado', 'editar_empleado.php', 0),
(48, 'O60d7df558999d5.63678253', 48, 9, 'Borrar Empleado', 'Borrar Empleado', 'borrar_empleado.php', 0),
(49, 'O60d7df558b9d22.65927455', 49, 9, 'Ver Empleado', 'Ver Empleado', 'ver_empleado.php', 0),
(50, 'O60d7df558daaf6.28936153', 50, 6, 'Consultar Stock', 'Consultar Stock', 'admin_stock.php', 1),
(54, 'O60d7df558fef46.83356817', 54, 10, 'Admin Bancos', 'Admin Bancos', 'admin_banco.php', 1),
(55, 'O60d7df5591ebc8.01677374', 55, 10, 'Agregar Banco', 'Agregar Banco', 'agregar_banco.php', 0),
(56, 'O60d7df559405f7.64684550', 56, 10, 'Editar Banco', 'Editar Banco', 'editar_banco.php', 0),
(57, 'O60d7df55962e81.51285306', 57, 10, 'Borrar Banco', 'Borrar Banco', 'borrar_banco.php', 0),
(58, 'O60d7df55985a93.21312934', 58, 10, 'Ver Banco', 'Ver Banco', 'ver_banco.php', 0),
(59, 'O60d7df559a5849.62206596', 59, 10, 'Admin Cuentas', 'Admin Cuentas', 'cuenta_banco.php', 0),
(60, 'O60d7df559c7428.99997621', 60, 10, 'Agregar Cuenta', 'Agregar Cuenta', 'agregar_cuenta_banco.php', 0),
(61, 'O60d7df559e9095.24682312', 61, 10, 'Editar Cuenta', 'Editar Cuenta', 'editar_cuenta_banco.php', 0),
(62, 'O60d7df55a09295.96285306', 62, 10, 'Borrar Cuenta', 'Borrar Cuenta', 'cuenta_banco.php', 0),
(63, 'O60d7df55a2a930.68376531', 63, 10, 'Admin Movimientos', 'Admin Movimiento', 'admin_mov_cta_banco.php', 1),
(64, 'O60d7df55a4b7e7.87060684', 64, 10, 'Agregar Movimientos', 'Agregar Movimiento', 'agreg_mov_cta_banco.php', 0),
(65, 'O60d7df55a6d489.38577383', 65, 10, 'Editar Movimientos', 'Editar Movimiento', 'editar_mov_cta_banco.php', 0),
(66, 'O60d7df55a8cea0.37228207', 66, 10, 'Borrar Movimientos', 'Borrar Movimiento', 'borrar_mov_cta_banco.php', 0),
(68, 'O60d7df55aad5b3.23454182', 68, 11, 'Admin Compras', 'Admin Compras', 'admin_compra.php', 1),
(69, 'O60d7df55acdc90.84768584', 69, 6, 'Ajuste de Inventario', 'Ajuste de Inventario', 'ajuste_inventario.php', 1),
(70, 'O60d7df55aef926.19411491', 70, 6, 'Reporte Ajuste', 'Reporte Ajuste', 'reporte_ajuste.php', 0),
(71, 'O60d7df55b10624.76839180', 71, 0, 'Hoja de conteo', 'Hoja de conteo', 'hoja_conteo.php', 0),
(72, 'O60d7df55b30af8.59645577', 72, 12, 'Admin Pagos', 'Admin Pagos', 'admin_voucher.php', 0),
(73, 'O60d7df55b52b41.81283284', 73, 12, 'Generar Pago', 'Generar Pago', 'pago_proveedor.php', 0),
(74, 'O60d7df55b755b6.03541919', 74, 12, 'Editar Pago', 'Editar Pago', 'editar_pago_proveedor.php', 0),
(75, 'O60d7df55b94c99.66167697', 75, 12, 'Finalizar Pago', 'Finalizar Pago', 'finalizar_mov_cta_banco.php', 0),
(76, 'O60d7df55bb5de2.01027936', 76, 12, 'Imprimir Pago', 'Imprimir Pago', 'voucher.php', 0),
(77, 'O60d7df55bd6e99.61826529', 77, 13, 'Admin Cotizaciones', 'Admin Cotizaciones', 'admin_cotizacion.php', 1),
(78, 'O60d7df55bf8aa3.69156812', 78, 13, 'Agregar Cotización', 'Agregar Cotización', 'agregar_cotizacion.php', 0),
(79, 'O60d7df55c18ff9.14321430', 79, 13, 'Editar Cotización', 'Editar Cotización', 'editar_cotizacion.php', 0),
(80, 'O60d7df55c3a091.11143342', 80, 13, 'Borrar Cotización', 'Borrar Cotización', 'borrar_cotizacion.php', 0),
(81, 'O60d7df55c5a860.31574617', 81, 13, 'Imprimir Cotización', 'Imprimir Cotización', 'cotizacion.php', 0),
(82, 'O60d7df55c7c978.79014805', 82, 11, 'Agregar Compra', 'Agregar Compra', 'compras.php', 0),
(83, 'O60d7df55c9c3c6.27449608', 83, 11, 'Ver Compra', 'Ver Compra', 'ver_compra.php', 0),
(84, 'O60d7df55cbe824.65649251', 84, 6, 'Admin Ajuste', 'Admin Ajuste', 'admin_ajuste.php', 1),
(85, 'O60d7df55cdf546.63906696', 85, 14, 'Admin Traslado', 'Admin Traslado', 'admin_traslados.php', 1),
(86, 'O60d7df55d01aa9.91512432', 86, 14, 'Realizar Traslado', 'Realizar Traslado', 'traslado_producto.php', 0),
(87, 'O60d7df55d21be6.15706044', 87, 14, 'Anular Traslado ', 'Anular Traslado ', 'anular_traslado.php', 0),
(88, 'O60d7df55d43386.05994162', 88, 14, 'Ver Traslado ', 'Ver Traslado ', 'ver_traslado.php', 0),
(89, 'O60d7df55d64ca3.18992317', 89, 14, 'Reporte Traslado ', 'Reporte Traslado ', 'reporte_traslado.php', 0),
(90, 'O60d7df55d87184.45328263', 90, 14, 'Reporte Traslado Recibido ', 'Reporte Traslado ', 'reporte_traslado.php', 0),
(91, 'O60d7df55da70e9.69752187', 91, 14, 'Recibir Traslado', 'Recibir Traslado', 'recibir_traslado.php', 0),
(92, 'O60d7df55dc7b20.77955378', 92, 15, 'Admin Usuario', 'Admin Usuario', 'admin_usuarios.php', 1),
(93, 'O60d7df55de93c9.78552804', 93, 15, 'Agregar Usuario', 'Agregar Usuario', 'agregar_usuario.php', 0),
(94, 'O60d7df55e0a8f6.40801158', 94, 15, 'Editar Usuario', 'Editar Usuario', 'editar_usuario.php', 0),
(95, 'O60d7df55e2bba9.98846865', 95, 15, 'Borrar Usuario', 'Borrar Usuario', 'borrar_usuario.php', 0),
(96, 'O60d7df55e4cec1.14785961', 96, 15, 'Permisos Usuario', 'Permisos Usuario', 'permiso_usuario.php', 0),
(97, 'O60d7df55e6dd21.24076164', 97, 15, 'Admin Empresa', 'Admin Empresa', 'admin_empresa.php', 1),
(98, 'O60d7df55e8fdf8.30821174', 98, 16, 'Admin Pedidos', 'Admin Pedidos', 'admin_pedido.php', 1),
(99, 'O60d7df55eb00c8.37320563', 99, 16, 'Agregar Pedido', 'Agregar Pedido', 'agregar_pedido.php', 0),
(100, 'O60d7df55ed16e7.52227238', 100, 16, 'Editar Pedido', 'Editar Pedido', 'editar_pedido.php', 0),
(101, 'O60d7df55ef2683.03931971', 101, 16, 'Borrar Pedido', 'Anular Pedido', 'borrar_pedido.php', 0),
(103, 'O60d7df55f14f76.20743945', 103, 16, 'Reporte Pedido', 'Reporte Pedido', 'reporte_pedido.php', 0),
(106, 'O60d7df55f354e8.09517237', 106, 5, 'Admin Facturas', 'Admin Facturas', 'admin_factura_rangos.php', 1),
(107, 'O60d7df56013f93.68632932', 107, 5, 'Ver Factura', 'Ver Factura', 'ver_factura.php', 0),
(108, 'O60d7df560354a2.34283282', 108, 5, 'Reimprimir Factura ', 'Reimprimir Factura ', 'reimprimir_factura.php', 0),
(109, 'O60d7df56056c16.21286696', 109, 5, 'Anular Factura ', 'Anular Factura ', 'anular_factura.php', 0),
(110, 'O60d7df560772c2.39699661', 110, 5, 'Devolución', 'Devolución', 'devolucion.php', 0),
(111, 'O60d7df56098540.92336207', 111, 7, 'Admin Movimiento Caja', 'Admin Movimiento Caja', 'admin_movimiento_caja.php', 1),
(112, 'O60d7df560b9a29.99622830', 112, 7, 'Agregar ingreso caja', 'Agregar ingreso caja', 'agregar_ingreso_caja.php', 0),
(113, 'O60d7df560dba61.70984449', 113, 7, 'Agregar salida caja', 'Agregar salida caja', 'agregar_salida_caja.php', 0),
(114, 'O60d7df560fc346.74618363', 114, 7, 'Editar Movimiento caja', 'Editar Movimiento caja', 'editar_movimiento_caja.php', 0),
(115, 'O60d7df5611d1d9.52983316', 115, 7, 'Imprimir Movimiento', 'Imprimir Movimiento', 'imprimir_movimiento.php', 0),
(116, 'O60d7df5613f390.36238038', 116, 7, 'Borrar Movimiento caja', 'Borrar Movimiento caja', 'Borrar_movimiento_caja.php', 0),
(117, 'O60d7df56161508.22838816', 117, 7, 'Corte de Caja', 'Corte de caja diario', 'corte_caja_diario.php', 0),
(118, 'O60d7df56181b00.47138098', 118, 5, 'Facturas Pendientes', 'Admin Facturas Pendientes', 'admin_pendiente_rangos.php', 1),
(119, 'O60d7df561a2ef5.46280507', 119, 17, 'Hoja de conteo', 'Hoja de conteo', 'generar_hoja.php', 1),
(120, 'O60d7df561c4098.77873395', 120, 5, 'Admin Devoluciones', 'Devoluciones ', 'admin_devoluciones_rangos.php', 0),
(121, 'O60d7df561e5b85.70320154', 121, 17, 'Kardex', 'Reporte Kardex', 'reporte_kardex.php', 1),
(122, 'O60d7df56206592.92543470', 122, 17, 'Inventario', 'Inventario', 'ver_reporte_inventario.php', 1),
(123, 'O60d7df56227dc1.88580315', 123, 17, 'Libro de compras ', 'Libro de compras ', 'ver_libro_compras.php', 1),
(124, 'O60d7df56248eb7.95511946', 124, 0, 'Reposición de producto', 'Reposición de producto', 'admin_movimiento_pendiente.php', 0),
(126, 'O60d7df5626a513.08028685', 126, 17, 'Kardex General', 'Reporte Kardex General', 'reporte_kardex_general.php', 1),
(127, 'O60d7df5628b131.87703463', 127, 7, 'Resumen de vales', 'Resumen de vales', 'resumen_vale.php', 1),
(128, 'O60d7df562abca2.37345431', 128, 17, 'Ventas a Contribuyentes', 'Libro de Ventas a Contribuyentes', 'ver_libro_ventas_a_contribuyente.php', 1),
(129, 'O60d7df562ce368.38192987', 129, 17, 'Ventas a Consumidores', 'Libro de Ventas a Consumidores', 'ver_libro_ventas_a_consumidores.php', 1),
(130, 'O60d7df562ef9b7.29797856', 130, 17, 'Reporte Fiscal', 'Reporte Fiscal', 'ver_reporte_fiscal.php', 1),
(132, 'O60d7df56310538.11111272', 132, 7, 'Apertura de caja', 'Apertura de caja', 'apertura_caja.php', 0),
(133, 'O60d7df56330f30.10140084', 133, 6, 'Administrar lotes', 'administrar lotes', 'admin_lotes.php', 0),
(134, 'O60d7df56352802.22715339', 134, 12, 'Admin cuentas por pagar', 'Admin cuentas por pagar', 'admin_cxp_p.php', 0),
(135, 'O60d7df56373185.90344335', 135, 0, 'Admin cuentas por pagar proveedor', 'Admin cuentas por pagar proveedor', 'admin_cxp.php', 0),
(136, 'O60d7df56394668.42070599', 136, 4, 'Agregar Reasignación', 'Agregar Reasignación', 'agregar_reasignacion.php', 0),
(137, 'O60d7df563b53b4.99815870', 137, 15, 'Backup', 'Backup', 'backup.php', 1),
(138, 'O60d7df563d8608.65441460', 138, 17, 'Ticket de auditoria', 'Ticket de auditoria', 'ticket_dia.php', 1),
(139, 'O60d7df563f8122.54131008', 139, 0, 'Depuracion', 'Depuracion', 'depuracion.php', 0),
(140, 'O60d7df56418d58.40437404', 140, 4, 'Admin transferencias', 'Admin transferencias', 'admin_transferencia.php', 1),
(141, 'O60d7df5643a001.41140082', 141, 4, 'Agregar Transferencia', 'Agregar Transferencia', 'agregar_transferencia.php', 0),
(142, 'O60d7df5645c693.83132957', 142, 5, 'Admin Autorización', 'Admin Autorización', 'admin_autorizacion.php', 1),
(143, 'O60d7df5647c350.65517017', 143, 5, 'Agregar Autorización', 'Agregar Autorización', 'agregar_autorizacion.php', 0),
(144, 'O60d7df5649da76.93841032', 144, 0, 'Reporte Ingresos y Egresos', 'Reporte Ingresos y Egresos', 'reporte_entrada_salida.php', 0),
(145, 'O60d7df564be8b7.50188341', 145, 17, 'Reporte de utilidades', 'Reporte de utilidades', 'ver_reporte_utilidad.php', 1),
(146, 'O60d7df564e1e14.11898223', 146, 17, 'Reporte de Reposicion', 'Reporte de Reposicion', 'ver_reporte_reposicion.php', 1),
(147, 'O60d7df565027a6.20252348', 147, 17, 'Reporte de utilidades Por dia', 'Reporte de utilidades Por dia', 'ver_reporte_utilidades_diarias.php', 1),
(148, 'O60d7df56523427.09370254', 148, 17, 'Reporte Z', 'Reporte Z', 'reportez.php', 1),
(149, 'O60d7df56543b50.54951509', 149, 17, 'Reporte ventas por vendedor', 'Reporte ventas por vendedor', 'ventas_vendedor.php', 1),
(150, 'O60d7df56566c14.03656476', 150, 17, 'Reporte Producto precios', 'Reporte Producto precios', 'ver_producto_precios.php', 1),
(151, 'O60d7df565861f7.60547051', 151, 17, '\nVentas al contado por Rango (PRODUCTOS)\n', '\nVentas al contado por Rango (PRODUCTOS)\n', 'ventas_rango.php', 1),
(152, 'O60d7df565a81e3.35545248', 152, 12, 'Admin cuentas por pagar', 'Admin cuentas por pagar', 'admin_cxp_p.php', 1),
(151, 'O60d7df565861f7.60547051', 153, 17, 'Detalle ventas por Documento', 'Detalle ventas por Documento', 'ventas_documento.php', 1),
(151, 'O60d7df565861f7.60547051', 154, 17, 'Vales por rango', 'Vales por rango', 'vales_emitidos.php', 1),
(151, 'O60d7df565861f7.60547051', 155, 17, 'Cuentas por pagar', 'Cuentas por pagar', 'cuentas_por_pagar.php', 1),
(151, 'O60d7df565861f7.60547051', 156, 17, 'Cuentas por Cobrar', 'Cuentas por Cobrar', 'cuentas_por_cobrar.php', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento_caja_tipo`
--

CREATE TABLE `movimiento_caja_tipo` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `ingreso` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento_producto`
--

CREATE TABLE `movimiento_producto` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_movimiento` int(11) NOT NULL,
  `correlativo` varchar(20) NOT NULL,
  `concepto` varchar(250) NOT NULL,
  `total` float NOT NULL,
  `tipo` varchar(13) CHARACTER SET utf8 NOT NULL,
  `proceso` varchar(50) NOT NULL,
  `referencia` varchar(30) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `id_suc_origen` int(11) NOT NULL,
  `id_suc_destino` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_traslado` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `conteo` varchar(100) NOT NULL,
  `sistema` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `movimiento_producto`
--

INSERT INTO `movimiento_producto` (`id_server`, `unique_id`, `id_sucursal`, `id_movimiento`, `correlativo`, `concepto`, `total`, `tipo`, `proceso`, `referencia`, `id_empleado`, `fecha`, `hora`, `id_suc_origen`, `id_suc_destino`, `id_proveedor`, `id_compra`, `id_traslado`, `id_factura`, `numero`, `conteo`, `sistema`) VALUES
(0, 'S6269721f3fbf99.88996040', 1, 0, '0000000001_COF', 'VENTA', 12, 'SALIDA', 'COF', '0000000001_COF', 1, '2022-04-27', '10:41:02', 1, 1, 0, 0, 0, 0, 0, '0', '0'),
(0, 'S6254601c0a9273.63150668', 1, 1, '0000001_II', 'INVENTARIO INICIAL', 150, 'ENTRADA', 'II', '0000001_II', 1, '2022-04-11', '11:06:36', 1, 1, 0, 0, 0, 0, 0, '0', '0'),
(0, 'S62546574794269.69819342', 1, 2, '0000002_II', 'INVENTARIO INICIAL', 250.02, 'ENTRADA', 'II', '0000002_II', 1, '2022-04-11', '11:29:24', 1, 1, 0, 0, 0, 0, 0, '0', '0'),
(0, 'S625467bd755ef5.56206594', 1, 3, '0000003_II', 'INVENTARIO INICIAL', 150, 'ENTRADA', 'II', '0000003_II', 1, '2022-04-11', '11:39:09', 1, 1, 0, 0, 0, 0, 0, '0', '0'),
(0, 'S62546b372d9239.58914830', 1, 4, '0000004_II', 'INVENTARIO INICIAL', 575.04, 'ENTRADA', 'II', '0000004_II', 1, '2022-04-11', '11:53:59', 1, 1, 0, 0, 0, 0, 0, '0', '0'),
(0, 'S625ee926345ae8.51550073', 1, 5, '0000005_II', 'INVENTARIO INICIAL', 500.04, 'ENTRADA', 'II', '0000005_II', 1, '2022-04-19', '10:53:58', 1, 1, 0, 0, 0, 0, 0, '0', '0'),
(0, 'S6269876bc44155.02209762', 1, 6, '0000000001_CCF', 'VENTA', 105, 'SALIDA', 'CCF', '0000000001_CCF', 1, '2022-04-27', '12:11:55', 1, 1, 0, 0, 0, 1, 0, '0', '0'),
(0, 'S6269959a3f79a8.64627626', 1, 7, '0000000001_TIK', 'VENTA', 7.5, 'SALIDA', 'TIK', '0000000001_TIK', 1, '2022-04-27', '13:12:26', 1, 1, 0, 0, 0, 2, 0, '0', '0'),
(0, 'S6269a749379bd8.71896827', 1, 8, '0000000002_TIK', 'VENTA', 1, 'SALIDA', 'TIK', '0000000002_TIK', 1, '2022-04-27', '14:27:53', 1, 1, 0, 0, 0, 3, 0, '0', '0'),
(0, 'S6269a91c5a8bd2.63015876', 1, 9, '0000000003_TIK', 'VENTA', 1.25, 'SALIDA', 'TIK', '0000000003_TIK', 1, '2022-04-27', '14:35:40', 1, 1, 0, 0, 0, 4, 0, '0', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento_producto_detalle`
--

CREATE TABLE `movimiento_producto_detalle` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_detalle` int(11) NOT NULL,
  `id_movimiento` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_server_prod` int(11) NOT NULL,
  `id_presentacion` int(11) NOT NULL,
  `id_server_presen` int(11) NOT NULL,
  `cantidad` decimal(11,4) NOT NULL,
  `costo` float NOT NULL,
  `precio` float NOT NULL,
  `stock_anterior` decimal(11,4) NOT NULL,
  `stock_actual` decimal(11,4) NOT NULL,
  `proceso` varchar(50) NOT NULL,
  `referencia` varchar(50) NOT NULL,
  `lote` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `movimiento_producto_detalle`
--

INSERT INTO `movimiento_producto_detalle` (`id_server`, `unique_id`, `id_sucursal`, `id_detalle`, `id_movimiento`, `id_producto`, `id_server_prod`, `id_presentacion`, `id_server_presen`, `cantidad`, `costo`, `precio`, `stock_anterior`, `stock_actual`, `proceso`, `referencia`, `lote`, `fecha`, `hora`) VALUES
(0, 'S6269721f414416.56547812', 1, 0, 0, 2, 0, 4, 0, '12.0000', 5.0004, 12, '600.0000', '588.0000', '0', '', 0, '2022-04-27', '10:41:02'),
(0, 'S6254601c0b3d19.05386771', 1, 1, 1, 1, 0, 1, 0, '200.0000', 3, 4.5, '0.0000', '200.0000', '0', '0', 1, '2022-04-11', '11:06:36'),
(0, 'S625465747aa9c5.97359828', 1, 2, 2, 2, 0, 3, 0, '600.0000', 10.0008, 22, '0.0000', '600.0000', '0', '0', 1, '2022-04-11', '11:29:24'),
(0, 'S625467bd762b63.59792140', 1, 3, 3, 3, 0, 7, 0, '100.0000', 15, 24, '0.0000', '100.0000', '0', '0', 1, '2022-04-11', '11:39:09'),
(0, 'S62546b372e8ca4.83890060', 1, 4, 4, 4, 0, 10, 0, '1200.0000', 23.0016, 30, '0.0000', '1200.0000', '0', '0', 1, '2022-04-11', '11:53:59'),
(0, 'S625ee9263ee045.56659592', 1, 5, 5, 5, 0, 15, 0, '1200.0000', 10.0008, 22, '0.0000', '1200.0000', '0', '0', 1, '2022-04-19', '10:53:58'),
(0, 'S6269876bc652f4.03395269', 1, 6, 6, 3, 0, 7, 0, '30.0000', 17, 24, '100.0000', '70.0000', '0', '', 0, '2022-04-27', '12:11:55'),
(0, 'S6269876beff030.86832101', 1, 7, 6, 5, 0, 16, 0, '36.0000', 5.0004, 11, '1200.0000', '1164.0000', '0', '', 0, '2022-04-27', '12:11:55'),
(0, 'S6269959ad8c064.37078107', 1, 8, 7, 3, 0, 9, 0, '3.0000', 1.7, 2.5, '70.0000', '67.0000', '0', '', 0, '2022-04-27', '13:12:26'),
(0, 'S6269a7496440e3.86804323', 1, 9, 8, 2, 0, 6, 0, '1.0000', 0.4167, 1, '588.0000', '587.0000', '0', '', 0, '2022-04-27', '14:27:53'),
(0, 'S6269a91c6de9a6.55822847', 1, 10, 9, 1, 0, 2, 0, '1.0000', 0.75, 1.25, '200.0000', '199.0000', '0', '', 0, '2022-04-27', '14:35:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento_producto_pendiente`
--

CREATE TABLE `movimiento_producto_pendiente` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_detalle` int(11) NOT NULL,
  `id_movimiento` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_server_prod` int(11) NOT NULL,
  `id_presentacion` int(11) NOT NULL,
  `id_server_presen` int(11) NOT NULL,
  `cantidad` decimal(11,4) NOT NULL,
  `costo` decimal(11,4) NOT NULL,
  `precio` decimal(11,4) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `repuesto` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento_stock_ubicacion`
--

CREATE TABLE `movimiento_stock_ubicacion` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_movimiento` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_server_prod` int(11) NOT NULL,
  `id_origen` int(11) NOT NULL,
  `id_destino` int(11) NOT NULL,
  `cantidad` decimal(11,4) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `anulada` int(11) NOT NULL,
  `afecta` int(11) NOT NULL,
  `id_presentacion` int(11) NOT NULL,
  `id_server_presen` int(11) NOT NULL,
  `id_mov_prod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `movimiento_stock_ubicacion`
--

INSERT INTO `movimiento_stock_ubicacion` (`id_server`, `unique_id`, `id_sucursal`, `id_movimiento`, `id_producto`, `id_server_prod`, `id_origen`, `id_destino`, `cantidad`, `fecha`, `hora`, `anulada`, `afecta`, `id_presentacion`, `id_server_presen`, `id_mov_prod`) VALUES
(0, 'S6269721f40c926.91627632', 1, 0, 2, 0, 2, 0, '12.0000', '2022-04-27', '10:41:02', 0, 0, 4, 0, 0),
(0, 'S6254601c0c3ee3.81308735', 1, 1, 1, 0, 0, 1, '200.0000', '2022-04-11', '11:06:36', 0, 0, 1, 0, 1),
(0, 'S625465747d3088.80481311', 1, 2, 2, 0, 0, 2, '600.0000', '2022-04-11', '11:29:24', 0, 0, 3, 0, 2),
(0, 'S625467bd76f098.88951509', 1, 3, 3, 0, 0, 3, '100.0000', '2022-04-11', '11:39:09', 0, 0, 7, 0, 3),
(0, 'S62546b372fa173.37438183', 1, 4, 4, 0, 0, 4, '1200.0000', '2022-04-11', '11:53:59', 0, 0, 10, 0, 4),
(0, 'S625ee9264523b1.10190778', 1, 5, 5, 0, 0, 5, '1200.0000', '2022-04-19', '10:53:58', 0, 0, 15, 0, 5),
(0, 'S6269876bc5cf72.60359659', 1, 6, 3, 0, 3, 0, '30.0000', '2022-04-27', '12:11:55', 0, 0, 7, 0, 6),
(0, 'S6269876be00a70.37949754', 1, 7, 5, 0, 5, 0, '36.0000', '2022-04-27', '12:11:55', 0, 0, 16, 0, 6),
(0, 'S6269959ad85601.72799916', 1, 8, 3, 0, 3, 0, '3.0000', '2022-04-27', '13:12:26', 0, 0, 9, 0, 7),
(0, 'S6269a74963d105.58831962', 1, 9, 2, 0, 2, 0, '1.0000', '2022-04-27', '14:27:53', 0, 0, 6, 0, 8),
(0, 'S6269a91c5be4b2.14548530', 1, 10, 1, 0, 1, 0, '1.0000', '2022-04-27', '14:35:40', 0, 0, 2, 0, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mov_caja`
--

CREATE TABLE `mov_caja` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(1) DEFAULT NULL,
  `id_movimiento` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `id_empleado` int(1) DEFAULT NULL,
  `idtransace` int(11) NOT NULL,
  `alias_tipodoc` char(4) NOT NULL,
  `numero_doc` varchar(30) NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `valor` float DEFAULT NULL,
  `concepto` varchar(50) DEFAULT NULL,
  `corte` int(1) DEFAULT NULL,
  `cobrado` tinyint(1) NOT NULL,
  `cliente` varchar(40) NOT NULL,
  `duui` varchar(10) NOT NULL,
  `entrada` tinyint(1) NOT NULL,
  `salida` tinyint(1) NOT NULL,
  `anulado` tinyint(1) NOT NULL,
  `turno` int(11) NOT NULL,
  `id_apertura` int(11) NOT NULL,
  `nombre_recibe` varchar(100) NOT NULL,
  `nombre_autoriza` varchar(100) NOT NULL,
  `nombre_proveedor` varchar(100) NOT NULL,
  `iva` float NOT NULL,
  `id_tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mov_cta_banco`
--

CREATE TABLE `mov_cta_banco` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_movimiento` int(11) NOT NULL,
  `id_cuenta` int(11) NOT NULL,
  `tipo` varchar(10) NOT NULL,
  `alias_tipodoc` varchar(15) NOT NULL,
  `numero_doc` varchar(50) NOT NULL,
  `entrada` float NOT NULL,
  `salida` float NOT NULL,
  `saldo` float NOT NULL,
  `fecha` date NOT NULL,
  `responsable` varchar(150) NOT NULL,
  `concepto` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipio`
--

CREATE TABLE `municipio` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_municipio` int(11) NOT NULL COMMENT 'ID del municipio',
  `nombre_municipio` varchar(60) NOT NULL COMMENT 'Nombre del municipio',
  `id_departamento_municipio` int(11) NOT NULL COMMENT 'Departamento al cual pertenece el municipio'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Municipios de El Salvador';

--
-- Volcado de datos para la tabla `municipio`
--

INSERT INTO `municipio` (`id_server`, `unique_id`, `id_municipio`, `nombre_municipio`, `id_departamento_municipio`) VALUES
(1, 'O60d7dfc2567143.61012554', 1, 'Ahuachapán', 1),
(2, 'O60d7dfc2572d73.36789738', 2, 'Jujutla', 1),
(3, 'O60d7dfc2592097.17590739', 3, 'Atiquizaya', 1),
(4, 'O60d7dfc25b36c3.37582718', 4, 'Concepción de Ataco', 1),
(5, 'O60d7dfc25d4d52.14030196', 5, 'El Refugio', 1),
(6, 'O60d7dfc25f6a20.76551260', 6, 'Guaymango', 1),
(7, 'O60d7dfc2617426.00539454', 7, 'Apaneca', 1),
(8, 'O60d7dfc26389d4.80924862', 8, 'San Francisco Menéndez', 1),
(9, 'O60d7dfc2659658.88425893', 9, 'San Lorenzo', 1),
(10, 'O60d7dfc267b2f1.00972186', 10, 'San Pedro Puxtla', 1),
(11, 'O60d7dfc269ca58.22717641', 11, 'Tacuba', 1),
(12, 'O60d7dfc26bd1c7.75327258', 12, 'Turín', 1),
(13, 'O60d7dfc26dee37.84006015', 13, 'Candelaria de la Frontera', 2),
(14, 'O60d7dfc26ff9b8.53421112', 14, 'Chalchuapa', 2),
(15, 'O60d7dfc2721105.56018326', 15, 'Coatepeque', 2),
(16, 'O60d7dfc2741c93.34808368', 16, 'El Congo', 2),
(17, 'O60d7dfc2762a22.99449691', 17, 'El Porvenir', 2),
(18, 'O60d7dfc27842d7.37436333', 18, 'Masahuat', 2),
(19, 'O60d7dfc27a5198.68801867', 19, 'Metapán', 2),
(20, 'O60d7dfc27c66a8.42779251', 20, 'San Antonio Pajonal', 2),
(21, 'O60d7dfc27e7373.56662266', 21, 'San Sebastián Salitrillo', 2),
(22, 'O60d7dfc2809582.80179224', 22, 'Santa Ana', 2),
(23, 'O60d7dfc282a935.28446603', 23, 'Santa Rosa Guachipilín', 2),
(24, 'O60d7dfc284b4f7.30039155', 24, 'Santiago de la Frontera', 2),
(25, 'O60d7dfc286c046.18551529', 25, 'Texistepeque', 2),
(26, 'O60d7dfc288e163.80385232', 26, 'Acajutla', 3),
(27, 'O60d7dfc28ae187.91857127', 27, 'Armenia', 3),
(28, 'O60d7dfc28cec71.05469694', 28, 'Caluco', 3),
(29, 'O60d7dfc28efd31.25622614', 29, 'Cuisnahuat', 3),
(30, 'O60d7dfc2911873.53562032', 30, 'Izalco', 3),
(31, 'O60d7dfc2932300.63842442', 31, 'Juayúa', 3),
(32, 'O60d7dfc29537a6.82623978', 32, 'Nahuizalco', 3),
(33, 'O60d7dfc2974454.05632431', 33, 'Nahulingo', 3),
(34, 'O60d7dfc2996727.90774840', 34, 'Salcoatitán', 3),
(35, 'O60d7dfc29b6267.22413518', 35, 'San Antonio del Monte', 3),
(36, 'O60d7dfc29d7d91.30059026', 36, 'San Julián', 3),
(37, 'O60d7dfc29f93e8.35139204', 37, 'Santa Catarina Masahuat', 3),
(38, 'O60d7dfc2a1b043.63356622', 38, 'Santa Isabel Ishuatán', 3),
(39, 'O60d7dfc2a3be72.58395613', 39, 'Santo Domingo de Guzmán', 3),
(40, 'O60d7dfc2a5cb19.05313137', 40, 'Sonsonate', 3),
(41, 'O60d7dfc2a7d834.76450785', 41, 'Sonzacate', 3),
(42, 'O60d7dfc2a9ec43.73011975', 42, 'Alegría', 4),
(43, 'O60d7dfc2abfc54.05409440', 43, 'Berlín', 11),
(44, 'O60d7dfc2ae5571.09552581', 44, 'California', 11),
(45, 'O60d7dfc2b057b4.89643938', 45, 'Concepción Batres', 11),
(46, 'O60d7dfc2b25fe4.29372325', 46, 'El Triunfo', 11),
(47, 'O60d7dfc2b46f73.74435515', 47, 'Ereguayquín', 11),
(48, 'O60d7dfc2b68f15.89066758', 48, 'Estanzuelas', 11),
(49, 'O60d7dfc2b89ef1.47395864', 49, 'Jiquilisco', 11),
(50, 'O60d7dfc2bab0e0.46459926', 50, 'Jucuapa', 11),
(51, 'O60d7dfc2bcc648.13066044', 51, 'Jucuarán', 11),
(52, 'O60d7dfc2bed650.21921163', 52, 'Mercedes Umaña', 11),
(53, 'O60d7dfc2c0e0f7.67843093', 53, 'Nueva Granada', 11),
(54, 'O60d7dfc2c2f158.92994793', 54, 'Ozatlán', 11),
(55, 'O60d7dfc2c504a3.75660680', 55, 'Puerto El Triunfo', 11),
(56, 'O60d7dfc2c732b9.20605438', 56, 'San Agustín', 11),
(57, 'O60d7dfc2c93328.80925621', 57, 'San Buenaventura', 11),
(58, 'O60d7dfc2cb44f7.48933488', 58, 'San Dionisio', 11),
(59, 'O60d7dfc2cd5fa3.58108080', 59, 'San Francisco Javier', 11),
(60, 'O60d7dfc2cf7789.84754671', 60, 'Santa Elena', 11),
(61, 'O60d7dfc2d17c01.59678164', 61, 'Santa María', 11),
(62, 'O60d7dfc2d393a2.81133486', 62, 'Santiago de María', 11),
(63, 'O60d7dfc2d5a411.28478426', 63, 'Tecapán', 11),
(64, 'O60d7dfc2d7ba11.66723119', 64, 'Usulután', 11),
(65, 'O60d7dfc2d9beb8.80465693', 65, 'Carolina', 13),
(66, 'O60d7dfc2dbcd48.41143500', 66, 'Chapeltique', 13),
(67, 'O60d7dfc2ddde66.87827437', 67, 'Chinameca', 13),
(68, 'O60d7dfc2dff303.92695434', 68, 'Chirilagua', 13),
(69, 'O60d7dfc2e20f28.64685971', 69, 'Ciudad Barrios', 13),
(70, 'O60d7dfc2e420f5.39159226', 70, 'Comacarán', 13),
(71, 'O60d7dfc2e62d15.78380005', 71, 'El Tránsito', 13),
(72, 'O60d7dfc2e855a1.04872391', 72, 'Lolotique', 13),
(73, 'O60d7dfc2ea4cb9.82809562', 73, 'Moncagua', 13),
(74, 'O60d7dfc2ec5fc3.43611192', 74, 'Nueva Guadalupe', 13),
(75, 'O60d7dfc2ee7d09.38323559', 75, 'Nuevo Edén de San Juan', 13),
(76, 'O60d7dfc2f09448.01327613', 76, 'Quelepa', 13),
(77, 'O60d7dfc2f28c89.80658035', 77, 'San Antonio del Mosco', 13),
(78, 'O60d7dfc3007fd1.45810404', 78, 'San Gerardo', 13),
(79, 'O60d7dfc3029333.61155872', 79, 'San Jorge', 13),
(80, 'O60d7dfc304ae70.29917833', 80, 'San Luis de la Reina', 13),
(81, 'O60d7dfc306b580.02199541', 81, 'San Miguel', 13),
(82, 'O60d7dfc308c4d7.98153133', 82, 'San Rafael Oriente', 13),
(83, 'O60d7dfc30ae050.99841041', 83, 'Sesori', 13),
(84, 'O60d7dfc30d01e9.74980208', 84, 'Uluazapa', 13),
(85, 'O60d7dfc30f0665.85048552', 85, 'Arambala', 12),
(86, 'O60d7dfc3111b95.80336723', 86, 'Cacaopera', 12),
(87, 'O60d7dfc31327b4.10047132', 87, 'Chilanga', 12),
(88, 'O60d7dfc3154b75.20731396', 88, 'Corinto', 12),
(89, 'O60d7dfc3174cf6.10770856', 89, 'Delicias de Concepción', 12),
(90, 'O60d7dfc31970f8.43515620', 90, 'El Divisadero', 12),
(91, 'O60d7dfc31b8879.40080851', 91, 'El Rosario', 12),
(92, 'O60d7dfc31da491.16599877', 92, 'Gualococti', 12),
(93, 'O60d7dfc31fa528.57889296', 93, 'Guatajiagua', 12),
(94, 'O60d7dfc321b130.04568481', 94, 'Joateca', 12),
(95, 'O60d7dfc323c947.70780501', 95, 'Jocoaitique', 12),
(96, 'O60d7dfc325ece7.76934984', 96, 'Jocoro', 12),
(97, 'O60d7dfc327fa05.19058705', 97, 'Lolotiquillo', 12),
(98, 'O60d7dfc32a0cd6.30455643', 98, 'Meanguera', 12),
(99, 'O60d7dfc32c1e38.60363826', 99, 'Osicala', 12),
(100, 'O60d7dfc32e47a9.93346153', 100, 'Perquín', 12),
(101, 'O60d7dfc3304004.72781875', 101, 'San Carlos', 12),
(102, 'O60d7dfc3325993.53743563', 102, 'San Fernando', 12),
(103, 'O60d7dfc3346470.05247119', 103, 'San Francisco Gotera', 12),
(104, 'O60d7dfc33680c6.13226926', 104, 'San Isidro', 12),
(105, 'O60d7dfc3388c22.70120804', 105, 'San Simón', 12),
(106, 'O60d7dfc33a9ec1.09030508', 106, 'Sensembra', 12),
(107, 'O60d7dfc33cb783.71278089', 107, 'Sociedad', 12),
(108, 'O60d7dfc33ec9b0.42169827', 108, 'Torola', 12),
(109, 'O60d7dfc340c686.09207552', 109, 'Yamabal', 12),
(110, 'O60d7dfc342d711.01531407', 110, 'Yoloaiquín', 12),
(111, 'O60d7dfc344ea12.00713520', 111, 'La Unión', 14),
(112, 'O60d7dfc3470e46.03823782', 112, 'San Alejo', 14),
(113, 'O60d7dfc3491b70.34327567', 113, 'Yucuaiquín', 14),
(114, 'O60d7dfc34b2f74.74697273', 114, 'Conchagua', 14),
(115, 'O60d7dfc34d3960.43581387', 115, 'Intipucá', 14),
(116, 'O60d7dfc34f5a98.28892241', 116, 'San José', 14),
(117, 'O60d7dfc3515e24.71538673', 117, 'El Carmen', 14),
(118, 'O60d7dfc3537612.58167217', 118, 'Yayantique', 14),
(119, 'O60d7dfc3557e44.85745144', 119, 'Bolívar', 14),
(120, 'O60d7dfc3579948.19880014', 120, 'Meanguera del Golfo', 14),
(121, 'O60d7dfc3599bf8.96384355', 121, 'Santa Rosa de Lima', 14),
(122, 'O60d7dfc35bae05.58416959', 122, 'Pasaquina', 14),
(123, 'O60d7dfc35dc6f3.36785027', 123, 'ANAMOROS', 14),
(124, 'O60d7dfc35fe9d8.45100900', 124, 'Nueva Esparta', 14),
(125, 'O60d7dfc361ecb1.04832009', 125, 'El Sauce', 14),
(126, 'O60d7dfc363fc10.96594716', 126, 'Concepción de Oriente', 14),
(127, 'O60d7dfc3661932.28420467', 127, 'Polorós', 14),
(128, 'O60d7dfc3683862.75231018', 128, 'Lislique ', 14),
(129, 'O60d7dfc36a3c91.51777660', 129, 'Antiguo Cuscatlán', 4),
(130, 'O60d7dfc36c4a81.82815673', 130, 'Chiltiupán', 4),
(131, 'O60d7dfc36e5885.14512567', 131, 'Ciudad Arce', 4),
(132, 'O60d7dfc3707618.84943249', 132, 'Colón', 4),
(133, 'O60d7dfc37275d6.57028660', 133, 'Comasagua', 4),
(134, 'O60d7dfc3748ec6.64497790', 134, 'Huizúcar', 4),
(135, 'O60d7dfc3769fe8.26506870', 135, 'Jayaque', 4),
(136, 'O60d7dfc378c211.73537977', 136, 'Jicalapa', 4),
(137, 'O60d7dfc37abfe7.41046441', 137, 'La Libertad', 4),
(138, 'O60d7dfc37cd981.84025611', 138, 'Santa Tecla', 4),
(139, 'O60d7dfc37eeaa6.40742695', 139, 'Nuevo Cuscatlán', 4),
(140, 'O60d7dfc3810ae9.99510266', 140, 'San Juan Opico', 4),
(141, 'O60d7dfc3830624.86498702', 141, 'Quezaltepeque', 4),
(142, 'O60d7dfc3852887.91305410', 142, 'Sacacoyo', 4),
(143, 'O60d7dfc3873c49.67812506', 143, 'San José Villanueva', 4),
(144, 'O60d7dfc3895e00.23505192', 144, 'San Matías', 4),
(145, 'O60d7dfc38b5a09.78515040', 145, 'San Pablo Tacachico', 4),
(146, 'O60d7dfc38d7298.62708376', 146, 'Talnique', 4),
(147, 'O60d7dfc38f7f75.58336114', 147, 'Tamanique', 4),
(148, 'O60d7dfc39197d3.03490424', 148, 'Teotepeque', 4),
(149, 'O60d7dfc3939fe4.41459343', 149, 'Tepecoyo', 4),
(150, 'O60d7dfc395ba73.62708260', 150, 'Zaragoza', 4),
(151, 'O60d7dfc397be30.78950971', 151, 'Agua Caliente', 5),
(152, 'O60d7dfc399d815.75347929', 152, 'Arcatao', 5),
(153, 'O60d7dfc39bd3f8.20406863', 153, 'Azacualpa', 5),
(154, 'O60d7dfc39ddd18.69153666', 154, 'Cancasque', 5),
(155, 'O60d7dfc39ffc64.82261181', 155, 'Chalatenango', 5),
(156, 'O60d7dfc3a22984.47913757', 156, 'Citalá', 5),
(157, 'O60d7dfc3a42765.24958312', 157, 'Comapala', 5),
(158, 'O60d7dfc3a64082.93258936', 158, 'Concepción Quezaltepeque', 5),
(159, 'O60d7dfc3a84cb6.68755517', 159, 'Dulce Nombre de María', 5),
(160, 'O60d7dfc3aa5a62.21342185', 160, 'El Carrizal', 5),
(161, 'O60d7dfc3ac7111.48596056', 161, 'El Paraíso', 5),
(162, 'O60d7dfc3aeae72.64518677', 162, 'La Laguna', 5),
(163, 'O60d7dfc3b0d1e2.38062581', 163, 'La Palma', 5),
(164, 'O60d7dfc3b2cf64.22695043', 164, 'La Reina', 5),
(165, 'O60d7dfc3b4dcc0.99908295', 165, 'Las Vueltas', 5),
(166, 'O60d7dfc3b6f150.83167234', 166, 'Nueva Concepción', 5),
(167, 'O60d7dfc3b8f484.69687337', 167, 'Nueva Trinidad', 5),
(168, 'O60d7dfc3bb03f2.62867078', 168, 'Nombre de Jesús', 5),
(169, 'O60d7dfc3bd1b11.65608633', 169, 'Ojos de Agua', 5),
(170, 'O60d7dfc3bf3c68.24834474', 170, 'Potonico', 5),
(171, 'O60d7dfc3c13f60.83075368', 171, 'San Antonio de la Cruz', 5),
(172, 'O60d7dfc3c35252.57276552', 172, 'San Antonio Los Ranchos', 5),
(173, 'O60d7dfc3c56766.69638637', 173, 'San Fernando', 5),
(174, 'O60d7dfc3c77d86.52159609', 174, 'San Francisco Lempa', 5),
(175, 'O60d7dfc3c98993.45305098', 175, 'San Francisco Morazán', 5),
(176, 'O60d7dfc3cb9cf0.78171333', 176, 'San Ignacio', 5),
(177, 'O60d7dfc3cdb4e7.28082916', 177, 'San Isidro Labrador', 5),
(178, 'O60d7dfc3cfd365.84817074', 178, 'Las Flores', 5),
(179, 'O60d7dfc3d1d513.26814426', 179, 'San Luis del Carmen', 5),
(180, 'O60d7dfc3d3eb06.90031067', 180, 'San Miguel de Mercedes', 5),
(181, 'O60d7dfc3d60163.00559891', 181, 'San Rafael', 5),
(182, 'O60d7dfc3d81c67.11904351', 182, 'Santa Rita', 5),
(183, 'O60d7dfc3da1964.19378600', 183, 'Tejutla', 5),
(184, 'O60d7dfc3dc2997.01731085', 184, 'Cojutepeque', 7),
(185, 'O60d7dfc3de36d0.12581578', 185, 'Candelaria', 7),
(186, 'O60d7dfc3e0dae8.67138132', 186, 'El Carmen', 7),
(187, 'O60d7dfc3e26e07.71783365', 187, 'El Rosario', 7),
(188, 'O60d7dfc3e45123.95913436', 188, 'Monte San Juan', 7),
(189, 'O60d7dfc3e4e764.75969883', 189, 'Oratorio de Concepción', 7),
(190, 'O60d7dfc3e71183.79052244', 190, 'San Bartolomé Perulapía', 7),
(191, 'O60d7dfc3e92516.36927699', 191, 'San Cristóbal', 7),
(192, 'O60d7dfc3eb3958.20880153', 192, 'San José Guayabal', 7),
(193, 'O60d7dfc3ed4077.61562735', 193, 'San Pedro Perulapán', 7),
(194, 'O60d7dfc3ef4d69.85877268', 194, 'San Rafael Cedros', 7),
(195, 'O60d7dfc3f162d3.68153420', 195, 'San Ramón', 7),
(196, 'O60d7dfc3f37991.14954567', 196, 'Santa Cruz Analquito', 7),
(197, 'O60d7dfc403c028.60785673', 197, 'Santa Cruz Michapa', 7),
(198, 'O60d7dfc405c965.26691167', 198, 'Suchitoto', 7),
(199, 'O60d7dfc407e237.09820904', 199, 'Tenancingo', 7),
(200, 'O60d7dfc409fd00.64657874', 200, 'Aguilares', 6),
(201, 'O60d7dfc40bf511.69188620', 201, 'Apopa', 6),
(202, 'O60d7dfc40e16e4.08681705', 202, 'Ayutuxtepeque', 6),
(203, 'O60d7dfc41028c6.41648737', 203, 'Cuscatancingo', 6),
(204, 'O60d7dfc4124150.14242223', 204, 'Ciudad Delgado', 6),
(205, 'O60d7dfc41442e4.18896530', 205, 'El Paisnal', 6),
(206, 'O60d7dfc4165d12.94983249', 206, 'Guazapa', 6),
(207, 'O60d7dfc4186fa3.89057486', 207, 'Ilopango', 6),
(208, 'O60d7dfc41a8210.80838029', 208, 'Mejicanos', 6),
(209, 'O60d7dfc41c8763.98075094', 209, 'Nejapa', 6),
(210, 'O60d7dfc41e9592.08907433', 210, 'Panchimalco', 6),
(211, 'O60d7dfc4210d83.14839653', 211, 'Rosario de Mora', 6),
(212, 'O60d7dfc4233190.31069952', 212, 'San Marcos', 6),
(213, 'O60d7dfc4252af3.96762995', 213, 'San Martín', 6),
(214, 'O60d7dfc4273fd4.03494247', 214, 'San Salvador', 6),
(215, 'O60d7dfc4295004.18169269', 215, 'Santiago Texacuangos', 6),
(216, 'O60d7dfc42b6023.89793965', 216, 'Santo Tomás', 6),
(217, 'O60d7dfc42d70f6.09775463', 217, 'Soyapango', 6),
(218, 'O60d7dfc42f79c8.83487142', 218, 'Tonacatepeque', 6),
(219, 'O60d7dfc4318ee7.00375654', 219, 'Zacatecoluca', 8),
(220, 'O60d7dfc4349f57.40470824', 220, 'Cuyultitán', 8),
(221, 'O60d7dfc436a326.29933814', 221, 'El Rosario', 8),
(222, 'O60d7dfc438ba62.95560138', 222, 'Jerusalén', 8),
(223, 'O60d7dfc43acd39.81787740', 223, 'Mercedes La Ceiba', 8),
(224, 'O60d7dfc43cdef2.29972344', 224, 'Olocuilta', 8),
(225, 'O60d7dfc43ef410.13245696', 225, 'Paraíso de Osorio', 8),
(226, 'O60d7dfc44103f4.33430712', 226, 'San Antonio Masahuat', 8),
(227, 'O60d7dfc4431378.51413412', 227, 'San Emigdio', 8),
(228, 'O60d7dfc4453d13.18413410', 228, 'San Francisco Chinameca', 8),
(229, 'O60d7dfc44740b2.44994769', 229, 'San Pedro Masahuat', 8),
(230, 'O60d7dfc44a8b39.79394771', 230, 'San Juan Nonualco', 8),
(231, 'O60d7dfc44c9ef9.33844772', 231, 'San Juan Talpa', 8),
(232, 'O60d7dfc44ebc81.71666187', 232, 'San Juan Tepezontes', 8),
(233, 'O60d7dfc450c4a4.12289423', 233, 'San Luis La Herradura', 8),
(234, 'O60d7dfc452d501.40434926', 234, 'San Luis Talpa', 8),
(235, 'O60d7dfc454e080.50874719', 235, 'San Miguel Tepezontes', 8),
(236, 'O60d7dfc456ffe9.72525533', 236, 'San Pedro Nonualco', 8),
(237, 'O60d7dfc4590855.45143569', 237, 'San Rafael Obrajuelo', 8),
(238, 'O60d7dfc45b17d4.12078345', 238, 'Santa María Ostuma', 8),
(239, 'O60d7dfc45d2ae1.45270102', 239, 'Santiago Nonualco', 8),
(240, 'O60d7dfc45f4338.23499763', 240, 'Tapalhuaca', 8),
(241, 'O60d7dfc4614848.83139884', 241, 'Cinquera', 9),
(242, 'O60d7dfc4635d11.82340768', 242, 'Dolores', 9),
(243, 'O60d7dfc4657d21.64809382', 243, 'Guacotecti', 9),
(244, 'O60d7dfc467a8b0.00397963', 244, 'Ilobasco', 9),
(245, 'O60d7dfc4699ba5.32875481', 245, 'Jutiapa', 9),
(246, 'O60d7dfc46bb247.43992669', 246, 'San Isidro', 9),
(247, 'O60d7dfc46dbd50.24328606', 247, 'Sensuntepeque', 9),
(248, 'O60d7dfc46fcdc6.69550970', 248, 'Tejutepeque', 9),
(249, 'O60d7dfc471c297.81486496', 249, 'Victoria', 9),
(250, 'O60d7dfc473e9a9.73724144', 250, 'Apastepeque', 10),
(251, 'O60d7dfc475f9f8.36297979', 251, 'Guadalupe', 10),
(252, 'O60d7dfc4781209.20142410', 252, 'San Cayetano Istepeque', 10),
(253, 'O60d7dfc47a1327.04883012', 253, 'San Esteban Catarina', 10),
(254, 'O60d7dfc47c2a70.27346841', 254, 'San Ildefonso', 10),
(255, 'O60d7dfc47e3f33.13853201', 255, 'San Lorenzo', 10),
(256, 'O60d7dfc48065b1.14497427', 256, 'San Sebastián', 10),
(257, 'O60d7dfc4827081.84469257', 257, 'San Vicente', 10),
(258, 'O60d7dfc4847b62.15835978', 258, 'Santa Clara', 10),
(259, 'O60d7dfc48681f2.08939028', 259, 'Santo Domingo', 10),
(260, 'O60d7dfc488afb4.72724259', 260, 'Tecoluca', 10),
(261, 'O60d7dfc48ab360.06135938', 261, 'Tepetitán', 10),
(262, 'O60d7dfc48cbac0.35960042', 262, 'Verapaz', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nc_corte`
--

CREATE TABLE `nc_corte` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_nc` int(11) NOT NULL,
  `id_corte` int(11) NOT NULL,
  `n_nc` int(11) NOT NULL,
  `t_nc` double NOT NULL,
  `afecta` varchar(30) NOT NULL,
  `tipo` varchar(30) NOT NULL,
  `exento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE `paises` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id` int(11) NOT NULL,
  `iso` char(2) DEFAULT NULL,
  `nombre` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `numero_doc` varchar(30) NOT NULL,
  `total` float NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `anulada` tinyint(1) NOT NULL DEFAULT '0',
  `id_sucursal` int(11) NOT NULL,
  `finalizada` tinyint(1) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `fecha_factura` date NOT NULL,
  `fecha_entrega` date NOT NULL,
  `lugar_entrega` varchar(80) CHARACTER SET utf8 NOT NULL,
  `transporte` varchar(20) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `id_municipio` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `observaciones` text CHARACTER SET utf8 NOT NULL,
  `hash` varchar(60) NOT NULL,
  `hora_pedido` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_detalle`
--

CREATE TABLE `pedido_detalle` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_pedido_detalle` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_prod_serv` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` float NOT NULL,
  `subtotal` float NOT NULL,
  `combo` tinyint(1) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_presentacion` int(11) NOT NULL,
  `tipo_prod_serv` varchar(30) NOT NULL COMMENT 'PRODUCTO o SERVICIO',
  `id_sucursal` int(11) NOT NULL,
  `cant_facturado` float NOT NULL,
  `unidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_prov`
--

CREATE TABLE `pedido_prov` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_pedido_prov` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `numero` varchar(30) NOT NULL,
  `total` float NOT NULL,
  `id_empleado_proceso` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `fecha_factura` date NOT NULL,
  `numero_factura` varchar(50) NOT NULL,
  `id_empleado_factura` int(11) NOT NULL,
  `fecha_entrega` date NOT NULL,
  `lugar_entrega` varchar(80) CHARACTER SET utf8 NOT NULL,
  `reservado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_prov_detalle`
--

CREATE TABLE `pedido_prov_detalle` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_pedido_detalle` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` decimal(11,4) NOT NULL,
  `id_presentacion` int(11) NOT NULL,
  `cantidad_enviar` decimal(11,4) NOT NULL,
  `precio_venta` decimal(11,4) NOT NULL,
  `subtotal` decimal(11,2) NOT NULL,
  `tipo_prod_serv` varchar(30) NOT NULL COMMENT 'PRODUCTO o SERVICIO',
  `id_sucursal` int(11) NOT NULL,
  `cant_facturado` decimal(11,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posicion`
--

CREATE TABLE `posicion` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_posicion` int(11) NOT NULL,
  `id_ubicacion` int(11) NOT NULL,
  `id_estante` int(11) NOT NULL,
  `posicion` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precio_aut`
--

CREATE TABLE `precio_aut` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id` int(11) NOT NULL,
  `clave` varchar(6) NOT NULL,
  `aplicado` tinyint(4) NOT NULL,
  `id_sucursal` tinyint(4) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_generado` date NOT NULL,
  `fecha_aplicado` date NOT NULL,
  `precio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `precio_aut`
--

INSERT INTO `precio_aut` (`id_server`, `unique_id`, `id`, `clave`, `aplicado`, `id_sucursal`, `id_usuario`, `fecha_generado`, `fecha_aplicado`, `precio`) VALUES
(1, 'O60d7dfc492ea99.86298358', 1, 'ca9mj8', 1, 1, 1, '2020-06-23', '2020-06-23', 3),
(2, 'O60d7dfc4938295.10224030', 2, 'y1asif', 1, 1, 9, '2020-10-31', '2020-10-31', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentacion`
--

CREATE TABLE `presentacion` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_presentacion` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `presentacion`
--

INSERT INTO `presentacion` (`id_server`, `unique_id`, `id_sucursal`, `id_presentacion`, `nombre`, `descripcion`) VALUES
(0, 'S625459f044f6f5.96211906', 1, 1, 'UNIDAD', 'UNIDAD'),
(0, 'S62545a0ad3b168.67421246', 1, 2, 'MANOJO', 'MANOJO'),
(0, 'S62546184293de6.89203127', 1, 3, 'PAQUETE 24', 'PAQUETE 24'),
(0, 'S625461994af843.54929985', 1, 4, 'MEDIA DOCENA ', 'MEDIA DOCENA '),
(0, 'S625461b91a49b0.13295459', 1, 5, 'DECENA ', 'DECENA'),
(0, 'S625461cfa004e3.68986613', 1, 6, 'ONCE', 'ONCE'),
(0, 'S6254637f1c0817.89688690', 1, 7, 'DOCENA', 'DOCENA'),
(0, 'S6254669a9f5743.41833290', 1, 8, 'MEDIA DECENA ', 'MEDIA DECENA'),
(0, 'S625469042074d6.79135535', 1, 9, 'CAJA', 'CAJA'),
(0, 'S62546915a34144.14088848', 1, 10, 'MEDIA CAJA', 'MEDIA CAJA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentacion_producto`
--

CREATE TABLE `presentacion_producto` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_pp` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_server_prod` int(11) NOT NULL,
  `id_presentacion` int(11) NOT NULL,
  `descripcion` varchar(20) CHARACTER SET utf8 NOT NULL,
  `unidad` float NOT NULL,
  `costo` decimal(10,4) NOT NULL,
  `costo_s_iva` int(11) NOT NULL,
  `precio` decimal(12,4) NOT NULL,
  `precio1` decimal(12,4) NOT NULL,
  `precio2` decimal(12,4) NOT NULL,
  `precio3` decimal(12,4) NOT NULL,
  `precio4` decimal(12,4) NOT NULL,
  `precio5` decimal(12,4) NOT NULL,
  `precio6` decimal(12,4) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `barcode` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `presentacion_producto`
--

INSERT INTO `presentacion_producto` (`id_server`, `unique_id`, `id_pp`, `id_producto`, `id_server_prod`, `id_presentacion`, `descripcion`, `unidad`, `costo`, `costo_s_iva`, `precio`, `precio1`, `precio2`, `precio3`, `precio4`, `precio5`, `precio6`, `activo`, `barcode`) VALUES
(0, 'S62545fbfc37584.86315026', 1, 1, 0, 2, '1X4', 4, '3.0000', 3, '4.5000', '4.0000', '3.7500', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62545fbfc3cff0.88893450', 2, 1, 0, 1, '1X1', 1, '0.7500', 1, '1.2500', '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6254653b5a43a5.56934447', 3, 2, 0, 3, '1X24', 24, '10.0008', 10, '22.0000', '20.0000', '18.0000', '16.0000', '15.0000', '13.0000', '0.0000', 1, ''),
(0, 'S6254653b5a81b2.11979586', 4, 2, 0, 7, '1X12', 12, '5.0004', 5, '12.0000', '10.0000', '9.0000', '8.0000', '7.5000', '0.0000', '0.0000', 1, ''),
(0, 'S6254653b5aca46.22563710', 5, 2, 0, 4, '1X6', 6, '2.5002', 3, '6.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6254653b5af485.86148529', 6, 2, 0, 1, '1X1', 1, '0.4167', 0, '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6254677c661462.74955433', 7, 3, 0, 5, '1X10', 10, '17.0000', 15, '24.0000', '22.0000', '20.0000', '18.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6254677c665e26.95698368', 8, 3, 0, 8, '1X5', 5, '8.5000', 8, '12.0000', '11.0000', '10.0000', '9.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6254677c66a749.44152374', 9, 3, 0, 1, '1X1', 1, '1.7000', 2, '2.5000', '2.0000', '1.7500', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62546b0d862346.29390912', 10, 4, 0, 9, '1X48', 48, '23.0016', 23, '30.0000', '29.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62546b0d866800.17120943', 11, 4, 0, 10, '1X24', 24, '11.5008', 12, '15.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62546b0d86bed7.20644358', 12, 4, 0, 7, '1X12', 12, '5.7504', 6, '10.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62546b0d8702c0.57284293', 13, 4, 0, 4, '1X6', 6, '2.8752', 3, '5.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62546b0d875314.55955892', 14, 4, 0, 1, '1X1', 1, '0.4792', 0, '1.0000', '0.7500', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625ee895e3f9e1.16611541', 15, 5, 0, 3, '1X24', 24, '10.0008', 10, '22.0000', '20.0000', '18.0000', '16.0000', '15.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625ee895e45556.52748762', 16, 5, 0, 7, '1X12', 12, '5.0004', 5, '11.0000', '10.0000', '9.0000', '8.0000', '7.5000', '0.0000', '0.0000', 1, ''),
(0, 'S625ee895e484c3.32739442', 17, 5, 0, 4, '1X6', 6, '2.5002', 3, '6.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625ee895e4c1e6.78715894', 18, 5, 0, 1, '1X1', 1, '0.4167', 0, '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625eec5d54bb19.80412055', 19, 6, 0, 3, '1X24', 24, '10.0008', 10, '22.0000', '20.0000', '18.0000', '16.0000', '15.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625eec5d54f902.45249280', 20, 6, 0, 7, '1X12', 12, '5.0004', 5, '11.0000', '10.0000', '9.0000', '8.0000', '7.5000', '0.0000', '0.0000', 1, ''),
(0, 'S625eec5d552949.61968269', 21, 6, 0, 4, '1X6', 6, '2.5002', 3, '6.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625eec5d555992.54027770', 22, 6, 0, 1, '1X1', 1, '0.4167', 0, '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625ef03ab9f2f1.66919224', 23, 7, 0, 3, '1X24', 24, '14.0000', 14, '25.0000', '22.0000', '20.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625ef03aba44b9.91612944', 24, 7, 0, 7, '1X12', 12, '7.0000', 7, '12.5000', '11.0000', '10.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625ef03aba7e58.47894091', 25, 7, 0, 4, '1X6', 6, '3.5000', 3, '12.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625ef03abab4f4.90252733', 26, 7, 0, 1, '1X1', 1, '0.5833', 1, '2.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625ef16fb54ef0.80419156', 27, 8, 0, 2, '1X4', 4, '3.0000', 3, '5.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625ef16fb58ab4.98119834', 28, 8, 0, 1, '1X1', 1, '0.7500', 1, '1.2500', '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625ef4b62afa43.34740938', 29, 9, 0, 7, '1X12', 12, '3.9996', 4, '9.0000', '8.0000', '7.5000', '7.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625ef4b62b3859.63438459', 30, 9, 0, 4, '1X6', 6, '1.9998', 2, '4.5000', '4.0000', '3.7500', '3.5000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625ef4b62b6d48.87467578', 31, 9, 0, 1, '1X1', 1, '0.3333', 0, '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625ef56b39db61.33236800', 32, 10, 0, 7, '1X12', 12, '3.9996', 4, '9.0000', '8.0000', '7.5000', '7.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625ef56b3a1da3.14697777', 33, 10, 0, 4, '1X6', 6, '1.9998', 2, '4.5000', '4.0000', '3.7500', '3.5000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625ef56b3a59d8.18497693', 34, 10, 0, 1, '1X1', 1, '0.3333', 0, '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625ef6de9c02d3.82067550', 35, 11, 0, 2, '1X4', 4, '5.0000', 5, '10.0000', '9.0000', '8.0000', '7.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625ef6de9c3714.29285300', 36, 11, 0, 1, '1X1', 1, '1.2500', 1, '2.5000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625ef78d185133.02817222', 37, 12, 0, 7, '1X12', 12, '5.0004', 5, '12.0000', '10.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625ef78d18a217.83778718', 38, 12, 0, 4, '1X6', 6, '2.5002', 3, '8.0000', '7.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625ef78d18ebb4.11456903', 39, 12, 0, 1, '1X1', 1, '0.4167', 0, '2.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625ef8347b24f5.11885219', 40, 13, 0, 5, '1X10', 10, '15.0000', 15, '24.0000', '22.0000', '20.0000', '18.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625ef8347c28d2.94471549', 41, 13, 0, 8, '1X5', 5, '7.5000', 8, '12.0000', '11.0000', '10.0000', '9.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625ef8347c7398.11495560', 42, 13, 0, 1, '1X1', 1, '1.5000', 2, '2.5000', '2.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625ef913e478f1.33021970', 43, 14, 0, 2, '1X4', 4, '2.5000', 3, '4.5000', '4.0000', '3.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625ef913e4b866.21211496', 44, 14, 0, 1, '1X1', 1, '0.6250', 1, '1.2500', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625efa1f22c3e2.77147090', 45, 15, 0, 2, '1X4', 4, '3.0000', 3, '4.5000', '4.0000', '3.7500', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625efa1f22fec7.27535010', 46, 15, 0, 1, '1X1', 1, '0.7500', 1, '1.2500', '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625efae78fe1a6.55781666', 47, 16, 0, 2, '1X4', 4, '3.0000', 3, '4.5000', '4.0000', '3.7500', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625efae7904985.82079732', 48, 16, 0, 1, '1X1', 1, '0.7500', 1, '1.2500', '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625efb6bc59611.82604036', 49, 17, 0, 2, '1X4', 4, '3.0000', 3, '5.0000', '4.5000', '4.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625efb6bc5d248.82461634', 50, 17, 0, 1, '1X1', 1, '0.7500', 1, '1.5000', '1.2500', '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625efc5c25c740.72866928', 51, 18, 0, 2, '1X4', 4, '3.5000', 4, '7.0000', '6.0000', '5.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625efc5c260c59.84470515', 52, 18, 0, 1, '1X1', 1, '0.8750', 1, '2.0000', '1.7500', '1.5000', '1.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625efcfa372035.79757746', 53, 19, 0, 2, '1X4', 4, '7.0000', 7, '12.0000', '10.0000', '9.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625efcfa377cc1.00647699', 54, 19, 0, 1, '1X1', 1, '1.7500', 2, '3.0000', '2.5000', '2.0000', '1.5000', '1.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625f0555265589.68281396', 55, 20, 0, 2, '1X4', 4, '3.0000', 3, '5.0000', '4.5000', '4.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625f0555269367.08228950', 56, 20, 0, 1, '1X1', 1, '0.7500', 1, '1.2500', '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625f05ebbe5ca6.85230624', 57, 21, 0, 2, '1X4', 4, '3.0000', 3, '6.0000', '5.5000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625f05ebbef716.77022790', 58, 21, 0, 1, '1X1', 1, '0.7500', 1, '1.5000', '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625f0a2fb68627.98180213', 59, 22, 0, 2, '1X4', 4, '3.5000', 4, '6.5000', '6.0000', '5.5000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S625f0a2fb6d865.67226302', 60, 22, 0, 1, '1X1', 1, '0.8750', 1, '1.7500', '1.5000', '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626731e4b471e6.73777994', 61, 23, 0, 2, '1X4', 10, '3.5000', 4, '6.5000', '6.0000', '5.5000', '0.0000', '0.0000', '0.0000', '0.0000', 0, ''),
(0, 'S626731e4b4c334.79058450', 62, 23, 0, 1, '1X1', 1, '0.3500', 0, '1.7500', '1.5000', '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62673473a98856.05956990', 63, 24, 0, 2, '1X4', 4, '3.5000', 4, '6.5000', '6.0000', '5.5000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62673473a9cec5.48408404', 64, 24, 0, 1, '1X1', 1, '0.8750', 1, '1.7500', '1.5000', '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62673655824e43.38752261', 65, 25, 0, 2, '1X4', 4, '3.0000', 3, '7.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6267365582ff71.91531691', 66, 25, 0, 1, '1X1', 1, '0.7500', 1, '1.0700', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62673df29dc023.42313913', 67, 26, 0, 2, '1X4', 4, '3.0000', 3, '6.0000', '5.5000', '5.5000', '4.5000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62673df29e1634.46850597', 68, 26, 0, 1, '1X1', 1, '0.7500', 1, '1.5000', '1.2500', '1.0000', '1.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62673e8f6318a7.66105729', 69, 27, 0, 2, '1X4', 4, '3.0000', 3, '6.0000', '5.5000', '5.0000', '4.5000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62673e8f6362d0.74237835', 70, 27, 0, 1, '1X1', 1, '0.7500', 1, '1.5000', '1.2500', '1.0000', '1.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62673f2a1af4d3.78886225', 71, 28, 0, 2, '1X4', 4, '4.0000', 4, '8.0000', '7.0000', '6.0000', '5.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62673f2a1b2ab4.06600817', 72, 28, 0, 1, '1X1', 1, '1.0000', 1, '2.0000', '1.7500', '1.5000', '1.2500', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6267400d78a361.43232901', 73, 29, 0, 5, '1X10', 10, '4.0000', 4, '9.0000', '8.0000', '7.0000', '6.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6267400d78e757.97558825', 74, 29, 0, 1, '1X1', 1, '0.4000', 0, '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62674120e8dc83.77980455', 75, 30, 0, 7, '1X12', 12, '6.0000', 5, '10.0000', '9.0000', '8.0000', '7.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62674120e917b0.62320241', 76, 30, 0, 1, '1X1', 1, '0.5000', 0, '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626742684ab097.68930402', 77, 31, 0, 7, '1X12', 12, '6.0000', 6, '10.0000', '9.0000', '8.0000', '7.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626742684b19c1.65413898', 78, 31, 0, 1, '1X1', 1, '0.5000', 1, '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626743086f0dc3.06239746', 79, 32, 0, 7, '1X12', 12, '5.0004', 5, '10.0000', '9.0000', '8.0000', '7.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626743086f78e3.45947226', 80, 32, 0, 1, '1X1', 1, '0.4167', 0, '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62674ec8ad8487.46588022', 81, 33, 0, 5, '1X12', 12, '3.5004', 4, '8.0000', '7.0000', '6.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62674ec8adf1b1.16702737', 82, 33, 0, 1, '1X1', 1, '0.2917', 0, '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626751cad85359.01516782', 83, 34, 0, 5, '1X10', 10, '18.0000', 18, '23.0000', '22.0000', '21.0000', '20.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626751cad95879.46901093', 84, 34, 0, 1, '1X1', 1, '1.8000', 2, '2.5000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626755b47d0264.79667163', 85, 35, 0, 2, '1X4', 4, '6.0000', 6, '10.0000', '9.0000', '8.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626755b47d5817.40995673', 86, 35, 0, 1, '1X1', 1, '1.5000', 2, '2.5000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6267594fc7f2e5.94841310', 87, 36, 0, 2, '1X4', 4, '3.0000', 3, '6.0000', '5.5000', '5.0000', '4.5000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6267594fc82d17.64729775', 88, 36, 0, 1, '1X1', 1, '0.7500', 1, '1.5000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62675aad66fd27.79334843', 89, 37, 0, 2, '1X4', 4, '3.5000', 4, '6.0000', '5.5000', '5.0000', '4.5000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62675aad675a48.32139050', 90, 37, 0, 1, '1X1', 1, '0.8750', 1, '1.5000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62675b12be8820.45907566', 91, 38, 0, 2, '1X4', 4, '4.0000', 4, '7.0000', '6.0000', '5.5000', '5.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62675b12bec7e0.67834730', 92, 38, 0, 1, '1X1', 1, '1.0000', 1, '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62675bdc4dbc76.52484556', 93, 39, 0, 1, '1X1', 1, '1.7500', 2, '3.0000', '2.7500', '2.5000', '2.2500', '2.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62675c7b6d5e29.69129427', 94, 40, 0, 2, '1X4', 4, '2.5000', 3, '4.5000', '4.0000', '3.5000', '3.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62675c7b6e22d0.12746552', 95, 40, 0, 1, '1X1', 1, '0.6250', 1, '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62675dce3e0798.04423276', 96, 41, 0, 2, '1X4', 4, '2.0000', 2, '4.5000', '4.0000', '3.5000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62675dce3e4773.51505131', 97, 41, 0, 1, '1X1', 1, '0.5000', 1, '0.9000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62675eafb0c2c3.85706569', 98, 42, 0, 5, '1X10', 10, '3.5000', 4, '6.0000', '5.5000', '5.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62675eafb11fa7.86807525', 99, 42, 0, 1, '1X1', 1, '0.3500', 0, '1.7000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62676185276721.94062244', 100, 43, 0, 2, '1X4', 4, '4.0000', 4, '8.0000', '7.0000', '6.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6267618527abb7.72168002', 101, 43, 0, 1, '1X1', 1, '1.0000', 1, '2.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6267632b106150.62964673', 102, 44, 0, 2, '1X4', 4, '3.5000', 4, '6.0000', '5.5000', '5.0000', '4.5000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6267632b109b92.79202028', 103, 44, 0, 1, '1X1', 1, '0.8750', 1, '1.2500', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6267646602c154.96126436', 104, 45, 0, 7, '1X12', 12, '11.0000', 21, '14.0000', '13.5000', '13.0000', '12.5000', '12.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6267646602ea72.36449462', 105, 45, 0, 1, '1X1', 1, '0.9167', 2, '2.5000', '2.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62682f522d37a5.97994080', 106, 46, 0, 3, '1X24', 24, '22.0008', 22, '28.0000', '27.0000', '26.0000', '24.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62682f522d7930.53406398', 107, 46, 0, 7, '1X12', 12, '11.0004', 11, '14.0000', '13.5000', '13.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62682f522dadd7.69139051', 108, 46, 0, 4, '1X6', 6, '5.5002', 6, '12.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62682f522de072.30046340', 109, 46, 0, 1, '1X1', 1, '0.9167', 1, '2.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62682f7c2ad095.48379791', 110, 45, 0, 3, '1X24', 24, '22.0000', 22, '28.0000', '27.0000', '26.0000', '25.0000', '24.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268300c1579b3.84291515', 111, 45, 0, 4, '1X6', 6, '5.5000', 6, '12.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626833f1e08839.68925533', 112, 47, 0, 9, '1X1', 1, '1.6500', 2, '2.0000', '1.7500', '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62683c3c058731.15878235', 113, 48, 0, 9, '1X1', 1, '3.2000', 3, '5.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62683c78f3d7a7.07333101', 114, 49, 0, 9, '1X1', 1, '5.1600', 5, '10.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62683cbbd437a7.22545777', 115, 50, 0, 9, '1X1', 1, '7.0000', 7, '12.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62683cf6446514.08468821', 116, 51, 0, 9, '1X1', 1, '9.0000', 9, '16.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62683d20cef529.71809063', 117, 52, 0, 9, '1X1', 1, '15.3000', 15, '20.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62683d56b2ef82.64796820', 118, 53, 0, 9, '1X1', 1, '6.1500', 6, '12.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626844ab435ff1.23007403', 119, 54, 0, 3, '1X24', 24, '22.0008', 22, '28.0000', '27.0000', '26.0000', '25.0000', '24.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626844ab43ad98.99869459', 120, 54, 0, 7, '1X12', 12, '11.0004', 11, '14.0000', '13.5000', '13.0000', '12.5000', '12.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626844ab43e7d1.51352644', 121, 54, 0, 4, '1X6', 6, '5.5002', 6, '12.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626844ab442719.30115923', 122, 54, 0, 1, '1X1', 1, '0.9167', 1, '3.0000', '2.5000', '2.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268468928a0b9.21789069', 123, 55, 0, 3, '1X24', 24, '28.0008', 28, '40.0000', '35.0000', '30.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626846892904e8.63479357', 124, 55, 0, 7, '1X12', 12, '14.0004', 14, '20.0000', '17.5000', '15.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62684689294698.33736125', 125, 55, 0, 4, '1X6', 6, '7.0002', 7, '18.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62684689298137.62848187', 126, 55, 0, 1, '1X1', 1, '1.1667', 1, '3.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268474e2b7c33.04347435', 127, 56, 0, 3, '1X24', 24, '30.0000', 30, '50.0000', '45.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268474e2bb3d7.29896075', 128, 56, 0, 7, '1X12', 12, '15.0000', 15, '25.0000', '22.5000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268474e2bdb31.27735056', 129, 56, 0, 4, '1X6', 6, '7.5000', 8, '18.0000', '18.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268474e2c1ac5.54693326', 130, 56, 0, 1, '1X1', 1, '1.2500', 1, '3.0000', '3.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62684848784918.19502759', 131, 57, 0, 3, '1X24', 24, '30.0000', 30, '50.0000', '45.0000', '40.0000', '35.0000', '32.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62684848788a68.06838272', 132, 57, 0, 7, '1X12', 12, '15.0000', 15, '25.0000', '22.5000', '20.0000', '17.5000', '16.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268484878c3a2.06949575', 133, 57, 0, 4, '1X6', 6, '7.5000', 8, '18.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62684848792c88.03090228', 134, 57, 0, 1, '1X1', 1, '1.2500', 1, '3.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62684a505d4ad2.87512868', 135, 58, 0, 3, '1X24', 24, '35.0000', 32, '50.0000', '45.0000', '40.0000', '35.0000', '32.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62684a505d9235.69836710', 136, 58, 0, 7, '1X12', 12, '17.5000', 16, '25.0000', '22.5000', '20.0000', '17.5000', '16.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62684a505dced0.89143873', 137, 58, 0, 4, '1X6', 6, '8.7500', 8, '18.0000', '18.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62684a505e12e5.45057971', 138, 58, 0, 1, '1X1', 1, '1.4583', 1, '3.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62684baee33501.08266694', 139, 59, 0, 3, '1X24', 24, '34.9992', 35, '50.0000', '45.0000', '40.0000', '35.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62684baee3bd45.03616365', 140, 59, 0, 7, '1X12', 12, '17.4996', 17, '25.0000', '22.5000', '20.0000', '17.5000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62684baee420b7.81674092', 141, 59, 0, 4, '1X6', 6, '8.7498', 9, '18.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62684baee456f9.27694872', 142, 59, 0, 1, '1X1', 1, '1.4583', 1, '3.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62684c95ecd3d7.96751487', 143, 60, 0, 3, '1X24', 24, '31.9992', 32, '50.0000', '45.0000', '40.0000', '35.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62684c95ed1709.10309789', 144, 60, 0, 7, '1X12', 12, '15.9996', 16, '25.0000', '22.5000', '20.0000', '17.5000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62684c95ed5191.76981014', 145, 60, 0, 4, '1X6', 6, '7.9998', 8, '18.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62684c95ed8b60.06673224', 146, 60, 0, 1, '1X1', 1, '1.3333', 1, '3.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62684d360e5c48.86816965', 147, 61, 0, 2, '1X4', 4, '8.0000', 8, '12.0000', '11.0000', '10.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62684d360e8e72.23342458', 148, 61, 0, 1, '1X1', 1, '2.0000', 2, '2.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62684fc2a1b564.82180922', 149, 62, 0, 7, '1X12', 12, '4.5000', 5, '9.0000', '8.0000', '7.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62684fc2a1f098.97355703', 150, 62, 0, 4, '1X6', 6, '2.2500', 2, '4.5000', '4.0000', '3.5000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62684fc2a22027.28845052', 151, 62, 0, 1, '1X1', 1, '0.3750', 0, '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268514aee10f2.61331757', 152, 63, 0, 7, '1X12', 12, '4.5000', 5, '10.0000', '9.0000', '8.0000', '7.0000', '6.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268514aee47f0.13986940', 153, 63, 0, 4, '1X6', 6, '2.2500', 2, '5.0000', '4.5000', '4.0000', '3.5000', '3.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268514aee7b34.96792896', 154, 63, 0, 1, '1X1', 1, '0.3750', 0, '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62685338f35f15.48318563', 155, 64, 0, 2, '1X4', 4, '8.0000', 8, '12.0000', '10.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62685338f3cf10.28224081', 156, 64, 0, 1, '1X1', 1, '2.0000', 2, '3.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268541d6a0978.99840819', 157, 65, 0, 7, '1X12', 12, '8.0004', 8, '12.0000', '10.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268541d6a3c57.23260218', 158, 65, 0, 4, '1X6', 6, '4.0002', 4, '6.0000', '5.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268541d6a68a4.02421433', 159, 65, 0, 1, '1X1', 1, '0.6667', 1, '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626854beddb6e0.15618092', 160, 66, 0, 5, '1X10', 10, '18.0000', 18, '26.0000', '25.0000', '24.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626854beddf388.00712942', 161, 66, 0, 8, '1X5', 5, '9.0000', 9, '13.0000', '12.5000', '12.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626854bede40d0.27329774', 162, 66, 0, 1, '1X1', 1, '1.8000', 2, '2.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626855ceafee55.02373682', 163, 67, 0, 2, '1X4', 4, '8.0000', 8, '10.0000', '9.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626855ceb026e7.05565542', 164, 67, 0, 1, '1X1', 1, '2.0000', 2, '2.5000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62685647aefb48.73660257', 165, 68, 0, 2, '1X4', 4, '8.0000', 8, '12.0000', '10.0000', '9.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62685647af5593.96051676', 166, 68, 0, 1, '1X1', 1, '2.0000', 2, '3.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62685696175fb5.12094046', 167, 69, 0, 2, '1X4', 4, '7.5000', 8, '12.0000', '10.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268569617a074.45986448', 168, 69, 0, 1, '1X1', 1, '1.8750', 2, '2.5000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62685703c74529.24114754', 169, 70, 0, 2, '1X4', 4, '6.0000', 6, '9.0000', '8.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62685703c77835.84132874', 170, 70, 0, 1, '1X1', 1, '1.5000', 2, '2.2500', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62685765d75a16.72962052', 171, 71, 0, 2, '1X4', 4, '6.0000', 6, '10.0000', '9.0000', '8.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62685765d77f28.13793853', 172, 71, 0, 1, '1X1', 1, '1.5000', 2, '2.5000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626857c904ad54.55187834', 173, 72, 0, 2, '1X4', 4, '5.0000', 5, '10.0000', '9.0000', '8.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626857c904df27.02748005', 174, 72, 0, 1, '1X1', 1, '1.2500', 1, '2.5000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62685874ade753.94119137', 175, 73, 0, 2, '1X4', 4, '3.0000', 3, '4.5000', '4.0000', '3.5000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62685874ae2a13.53050380', 176, 73, 0, 1, '1X1', 1, '0.7500', 1, '1.2500', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268592c8f87d6.63098471', 177, 74, 0, 10, '1X4', 4, '5.0000', 5, '8.0000', '7.0000', '6.5000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268592c8fddc6.48700521', 178, 74, 0, 1, '1X1', 1, '1.2500', 1, '2.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62685b3d55af52.50984861', 179, 75, 0, 5, '1X10', 10, '12.0000', 12, '24.0000', '22.0000', '20.0000', '18.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62685b3d55ed07.33688363', 180, 75, 0, 8, '1X5', 5, '6.0000', 6, '12.0000', '11.0000', '10.0000', '9.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62685b3d562166.98518898', 181, 75, 0, 1, '1X1', 1, '1.2000', 1, '2.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626868232baad7.52579735', 182, 76, 0, 5, '1X10', 10, '13.0000', 13, '20.0000', '18.0000', '16.0000', '14.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626868232ca217.23817852', 183, 76, 0, 8, '1X5', 5, '6.5000', 7, '10.0000', '9.0000', '8.0000', '7.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62686895a8ae20.29957164', 184, 77, 0, 2, '1X4', 4, '4.0000', 4, '8.0000', '7.0000', '6.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62686895a94360.67840343', 185, 77, 0, 1, '1X1', 1, '1.0000', 1, '2.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626868ea1d8197.44101130', 186, 78, 0, 2, '1X4', 4, '5.0000', 5, '10.0000', '9.0000', '8.0000', '7.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626868ea1db1e2.72904372', 187, 78, 0, 1, '1X1', 1, '1.2500', 1, '2.5000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626869970c8244.54414923', 188, 79, 0, 2, '1X4', 4, '7.0000', 7, '12.0000', '10.0000', '9.0000', '8.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626869970cb7a3.68915672', 189, 79, 0, 1, '1X1', 1, '1.7500', 2, '3.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62686a1322afc6.62351799', 190, 80, 0, 2, '1X4', 4, '7.0000', 7, '12.0000', '10.0000', '9.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62686a1322e367.46513359', 191, 80, 0, 1, '1X1', 1, '1.7500', 2, '3.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62686a80a7c470.72354681', 192, 81, 0, 5, '1X10', 10, '18.0000', 18, '25.0000', '24.0000', '22.0000', '20.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62686a80a7f375.99962710', 193, 81, 0, 1, '1X1', 1, '1.8000', 2, '2.5000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62686bac53e9c2.01443506', 194, 82, 0, 2, '1X4', 4, '7.5000', 8, '12.0000', '10.0000', '9.0000', '8.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62686bac5514f5.19901606', 195, 82, 0, 1, '1X1', 1, '1.8750', 2, '2.7500', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62686d7861f9e6.88937553', 196, 83, 0, 2, '1X4', 4, '6.0000', 6, '10.0000', '9.0000', '8.0000', '7.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62686d78622f55.53451463', 197, 83, 0, 1, '1X1', 1, '1.5000', 2, '2.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62686e052ea3b7.05849860', 198, 84, 0, 2, '1X4', 4, '3.5000', 4, '6.0000', '5.5000', '5.0000', '4.5000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62686e052ee0d3.46454979', 199, 84, 0, 1, '1X1', 1, '0.8750', 1, '1.2500', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62686f442a1519.35696815', 200, 85, 0, 2, '1X4', 4, '6.0000', 6, '9.0000', '8.0000', '7.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62686f442a5106.78525211', 201, 85, 0, 1, '1X1', 1, '1.5000', 2, '2.2500', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268701d38ac76.57865083', 202, 86, 0, 2, '1X4', 4, '3.5000', 4, '6.0000', '5.5000', '5.0000', '4.5000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268701d3908e6.26422116', 203, 86, 0, 1, '1X1', 1, '0.8750', 1, '1.5000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62687126bfd9e2.81894656', 204, 87, 0, 2, '1X4', 4, '6.0000', 6, '12.0000', '10.0000', '9.0000', '8.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62687126c01313.49400957', 205, 87, 0, 1, '1X1', 1, '1.5000', 2, '2.5000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626871870f6255.24257372', 206, 88, 0, 2, '1X4', 4, '3.0000', 3, '4.5000', '4.0000', '3.5000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626871870f9622.48317924', 207, 88, 0, 1, '1X1', 1, '0.7500', 1, '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268723045de63.80700187', 208, 89, 0, 5, '1X10', 10, '5.0000', 5, '12.0000', '11.0000', '10.0000', '9.0000', '8.0000', '7.0000', '0.0000', 1, ''),
(0, 'S626872304619c3.76480283', 209, 89, 0, 1, '1X1', 1, '0.5000', 1, '1.2500', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626872b47f0064.40818289', 210, 90, 0, 2, '1X4', 4, '7.0000', 7, '12.0000', '10.0000', '9.0000', '8.0000', '7.5000', '0.0000', '0.0000', 1, ''),
(0, 'S626872b47f5234.37808155', 211, 90, 0, 1, '1X1', 1, '1.7500', 2, '2.5000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268736a5480c9.83980326', 212, 91, 0, 2, '1X4', 4, '6.0000', 6, '10.0000', '9.0000', '8.0000', '7.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268736a54c394.78084162', 213, 91, 0, 1, '1X1', 1, '1.5000', 2, '2.5000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S62687405dd82b6.16848405', 214, 92, 0, 1, '1X1', 1, '18.0000', 18, '25.0000', '24.0000', '23.0000', '22.0000', '20.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268754535e057.37151417', 215, 93, 0, 1, '1X1', 1, '23.0000', 23, '40.0000', '35.0000', '30.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626876580e6034.03987950', 216, 94, 0, 1, '1X1', 1, '28.0000', 28, '45.0000', '40.0000', '35.0000', '30.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268773c1425d3.83039009', 217, 95, 0, 7, '1X12', 12, '3.9996', 4, '10.0000', '8.0000', '7.0000', '6.0000', '5.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268773c14a442.06133309', 218, 95, 0, 1, '1X1', 1, '0.3333', 0, '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626877a7df8469.43476591', 219, 96, 0, 7, '1X12', 12, '3.5004', 4, '5.0000', '4.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626877a7dfbe25.98268657', 220, 96, 0, 1, '1X1', 1, '0.2917', 0, '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268783651aca0.57196350', 221, 97, 0, 7, '1X12', 12, '5.0004', 5, '9.0000', '8.0000', '7.0000', '6.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S6268783651f0f1.15716666', 222, 97, 0, 1, '1X1', 1, '0.4167', 0, '1.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626878ad22c880.83324423', 223, 98, 0, 7, '1X12', 12, '2.4996', 2, '7.0000', '6.0000', '5.0000', '4.0000', '3.0000', '0.0000', '0.0000', 1, ''),
(0, 'S626878ad22fbe4.03336526', 224, 98, 0, 1, '1X1', 1, '0.2083', 0, '0.5000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0.0000', 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_server` int(11) NOT NULL,
  `unique_id` text COLLATE utf8_spanish_ci NOT NULL,
  `id_producto` int(11) NOT NULL,
  `barcode` varchar(15) CHARACTER SET latin1 DEFAULT NULL,
  `codart` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(250) CHARACTER SET latin1 NOT NULL,
  `composicion` text COLLATE utf8_spanish_ci NOT NULL,
  `marca` varchar(100) CHARACTER SET latin1 NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `perecedero` tinyint(1) NOT NULL,
  `exento` tinyint(1) NOT NULL,
  `minimo` int(11) NOT NULL,
  `decimals` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `imagen` varchar(250) CHARACTER SET latin1 NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `costo` float NOT NULL,
  `precio` float NOT NULL,
  `precio_mayoreo` float NOT NULL,
  `color` text COLLATE utf8_spanish_ci NOT NULL,
  `eval` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_server`, `unique_id`, `id_producto`, `barcode`, `codart`, `descripcion`, `composicion`, `marca`, `estado`, `perecedero`, `exento`, `minimo`, `decimals`, `id_categoria`, `id_proveedor`, `imagen`, `id_sucursal`, `costo`, `precio`, `precio_mayoreo`, `color`, `eval`) VALUES
(0, 'S62545fbfc28370.76156294', 1, '', '1', 'SHASTA BLANCA GUAT.', '', '', 1, 0, 0, 10, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S6254653b5952c1.94971581', 2, '', '2', 'ROSA BLANCA GUAT.', '', '', 1, 0, 0, 10, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S6254677c654323.13569419', 3, '', '3', 'LIRIOS BLANCOS GUAT.', '', '', 1, 0, 0, 5, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62546b0d8512c3.30499558', 4, '', '4', 'OASIS BLOQUE', '', '', 1, 0, 0, 25, 1, 7, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S625ee895d78233.75783177', 5, '', '5', 'ROSA ROJA GUAT.', '', '', 1, 0, 0, 10, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S625eec5d540448.03998570', 6, '', '6', 'ROSA COLORES GUAT.', '', '', 1, 0, 0, 10, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S625ef03ab91832.52058234', 7, '', '7', 'ROSA PINTADA GUAT.', '', '', 1, 0, 0, 10, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S625ef16fb489b8.68073328', 8, '', '8', 'BABY ROSE GUAT.', '', '', 1, 0, 0, 5, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S625ef4b6297598.42115371', 9, '', '9', 'GERBERA MIXTA GUAT.', '', '', 1, 0, 0, 5, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S625ef56b391000.98873288', 10, '', '10', 'GERBERAS COLORES GUAT.', '', '', 1, 0, 0, 5, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S625ef6de9ae9b9.50148332', 11, '', '11', 'CLAVELES COLORES GUAT.', '', '', 1, 0, 0, 5, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S625ef78d16c806.81374457', 12, '', '12', 'GIRASOL ESP GUAT.', '', '', 1, 0, 0, 5, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S625ef83479ad97.50664977', 13, '', '13', 'LIRIO ROSADO GUAT.', '', '', 1, 0, 0, 5, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S625ef913e33cc0.90120679', 14, '', '14', 'MINICLAVEL COLORES GUAT.', '', '', 1, 0, 0, 10, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S625efa1f220d22.76056677', 15, '', '15', 'SHASTA COLORES GUAT.', '', '', 1, 0, 0, 10, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S625efae78edb36.43950454', 16, '', '16', 'CENTRO VERDE GUAT.', '', '', 1, 0, 0, 5, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S625efb6bc47ba2.24879360', 17, '', '17', 'TIGRILLO GUAT.', '', '', 1, 0, 0, 3, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S625efc5c246e92.21236071', 18, '', '18', 'MECHUDO ESP GUATE.', '', '', 1, 0, 0, 5, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S625efcfa356468.96735886', 19, '', '19', 'LISIANTUS GUAT.', '', '', 1, 0, 0, 3, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S625f055525b310.55747110', 20, '', '20', 'DIANTUS GUAT.', '', '', 1, 0, 0, 3, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S625f05ebbcfbb3.03081663', 21, '', '21', 'REFINE GUAT.', '', '', 1, 0, 0, 3, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S625f0a2fb574c7.11005063', 22, '', '22', 'DRAGON BLANCO GUAT.', '', '', 1, 0, 0, 5, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S626731e4b1aef3.80364150', 23, '', '23', 'DRAGON COLORES GUAT.', '', '', 1, 0, 0, 5, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62673473a8bc12.62283331', 24, '', '24', 'STOCK COLORES GUAT.', '', '', 1, 0, 0, 5, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S626736558159c3.89132255', 25, '', '25', 'CARTAMUS GUAT.', '', '', 1, 0, 0, 3, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62673df29b6226.17570211', 26, '', '26', 'SOLO MIO GUAT.', '', '', 1, 0, 0, 3, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62673e8f614888.74800772', 27, '', '27', 'PERLITAS GUAT.', '', '', 1, 0, 0, 3, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62673f2a1a4106.28802786', 28, '', '28', 'MERYGOL GUAT.', '', '', 1, 0, 0, 3, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S6267400d77b139.66062558', 29, '', '29', 'ESTRELLA DE BELEN GUAT.', '', '', 1, 0, 0, 3, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62674120e80234.66725921', 30, '', '30', 'GLADIOLA BLANCA GUAT.', '', '', 1, 0, 0, 5, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62674268497e08.78825781', 31, '', '31', 'GLADIOLA COLORES GUAT.', '', '', 1, 0, 0, 5, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S626743086e5d72.33075667', 32, '', '32', 'NARDO GUAT.', '', '', 1, 0, 0, 5, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62674ec8ab7381.59197848', 33, '', '33', 'NARDOS ESA.', '', '', 1, 0, 0, 3, 1, 6, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S626751cad79e61.69399318', 34, '', '34', 'TULIPANES GUAT.', '', '', 1, 0, 0, 3, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S626755b47ba4c1.76969729', 35, '', '35', 'BABY GUAT.', '', '', 1, 0, 0, 5, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S6267594fc6fb63.08261024', 36, '', '36', 'SOLIDAGO GUAT.', '', '', 1, 0, 0, 5, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62675aad663099.22169515', 37, '', '37', 'MONTECASINO GUAT', '', '', 1, 0, 0, 3, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62675b12bdbc85.06043079', 38, '', '38', 'LIMONIUM GUAT.', '', '', 1, 0, 0, 3, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62675bdc4c03b3.03958984', 39, '', '39', 'HELECHO GUAT.', '', '', 1, 0, 0, 5, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62675c7b6c6a70.98339202', 40, '', '40', 'HIEDRA GUAT.', '', '', 1, 0, 0, 3, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62675dce3cebb5.91405690', 41, '', '41', 'ARALIA GUAT.', '', '', 1, 0, 0, 3, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62675eafaf6f23.86797145', 42, '', '42', 'CAMPANA IRLANDESA GUAT.', '', '', 1, 0, 0, 3, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S6267618526bb82.19901038', 43, '', '43', 'HIPERICON GUAT.', '', '', 1, 0, 0, 3, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S6267632b0f9fa8.32246386', 44, '', '44', 'RUSCUS GUAT.', '', '', 1, 0, 0, 3, 1, 3, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S626764660204d4.72013176', 45, '', '45', 'ROSA ROJA EC.', '', '', 1, 0, 0, 5, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62682f522c6b88.42795323', 46, '', '46', 'ROSA BLANCA EC.', '', '', 1, 0, 0, 5, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S626833f1dfccf7.56669413', 47, '', '47', 'CHOCOLATE T3', '', '', 1, 0, 0, 5, 1, 8, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62683c3c04cf60.18463910', 48, '', '48', 'CHOCOLATE T5', '', '', 1, 0, 0, 5, 1, 8, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62683c78f35920.34070741', 49, '', '49', 'CHOCOLATE T8', '', '', 1, 0, 0, 5, 1, 8, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62683cbbd37e01.58407730', 50, '', '50', 'CHOCOLATE T12', '', '', 1, 0, 0, 5, 1, 8, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62683cf64349c0.93195557', 51, '', '51', 'CHOCOLATE T16', '', '', 1, 0, 0, 5, 1, 8, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62683d20ce4ee3.22676598', 52, '', '52', 'CHOCOLATE T24', '', '', 1, 0, 0, 5, 1, 8, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62683d56b25a16.07112191', 53, '', '53', 'CHOCOLATE CORAZON T8', '', '', 1, 0, 0, 5, 1, 8, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S626844ab419f16.67094016', 54, '', '54', 'ROSA COLORES EC.', '', '', 1, 0, 0, 5, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S6268468927bb27.90475087', 55, '', '55', 'ROSA PINTADA EC.', '', '', 1, 0, 0, 5, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S6268474e2aa2e6.45627745', 56, '', '56', 'ROSA ARCOIRIS EC.', '', '', 1, 0, 0, 3, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S6268484876e918.14629481', 57, '', '57', 'ROSA MOTHER DAY EC.', '', '', 1, 0, 0, 5, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62684a505c2451.44477914', 58, '', '58', 'ROSA CIELO MIX EC.', '', '', 1, 0, 0, 3, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62684baee25982.18580262', 59, '', '59', 'ROSA CHICLE EC.', '', '', 1, 0, 0, 3, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62684c95ec15b6.47368117', 60, '', '60', 'ROSA CIELO EC.', '', '', 1, 0, 0, 5, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62684d360dcc34.32546559', 61, '', '61', 'BABY ROSE EC.', '', '', 1, 0, 0, 3, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62684fc2a105c1.37208020', 62, '', '62', 'GERBERAS MIXTA CR.', '', '', 1, 0, 0, 3, 1, 5, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S6268514aed5696.15327680', 63, '', '63', 'GERBERAS COLORES CR.', '', '', 1, 0, 0, 3, 1, 5, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62685338f1bb06.19977126', 64, '', '64', 'CLAVELES COLORES EC.', '', '', 1, 0, 0, 3, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S6268541d695ab1.66843336', 65, '', '65', 'GIRASOL ESP EC.', '', '', 1, 0, 0, 3, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S626854bedcb6d1.69041725', 66, '', '66', 'LIRIOS EC.', '', '', 1, 0, 0, 5, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S626855ceaf3a06.97762164', 67, '', '67', 'MINICLAVEL COLORES EC.', '', '', 1, 0, 0, 5, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62685647adffa5.32587960', 68, '', '68', 'FULLY COLOREC EC.', '', '', 1, 0, 0, 5, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62685696166480.62368634', 69, '', '69', 'CRISANTEMO EC.', '', '', 1, 0, 0, 5, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62685703c6ae06.17260441', 70, '', '70', 'HIPERICON EC.', '', '', 1, 0, 0, 3, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62685765d6bf69.42130184', 71, '', '71', 'RUSCUS EC.', '', '', 1, 0, 0, 3, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S626857c903fb31.13089135', 72, '', '72', 'EUCALIPTO EC.', '', '', 1, 0, 0, 3, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62685874acd3b6.16820270', 73, '', '73', 'SHASTA CR.', '', '', 1, 0, 0, 5, 1, 5, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S6268592c8ea978.63004189', 74, '', '74', 'FULLY COLORES CR.', '', '', 1, 0, 0, 5, 1, 5, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62685b3d54c209.62718386', 75, '', '75', 'LIRIOS AMARILLO Y NARANJA CR.', '', '', 1, 0, 0, 3, 1, 5, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S626868232ab6e2.95047940', 76, '', '76', 'LIRIO BLANCO Y ROSADO CR.', '', '', 1, 0, 0, 3, 1, 5, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62686895a7d4f2.71843564', 77, '', '77', 'CAMPANA IRLANDESA CR.', '', '', 1, 0, 0, 3, 1, 5, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S626868ea1ce276.53931121', 78, '', '78', 'CAMPANA IRLANDESA EC.', '', '', 1, 0, 0, 3, 0, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S626869970bc844.10979665', 79, '', '79', 'LISIANTUS EC.', '', '', 1, 0, 0, 3, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62686a13221336.18767638', 80, '', '80', 'ESTRELLA DE BELEN EC.', '', '', 1, 0, 0, 3, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62686a80a72b17.28839651', 81, '', '81', 'TULIPANES EC.', '', '', 1, 0, 0, 3, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62686bac5354d2.50454406', 82, '', '82', 'BABY EC.', '', '', 1, 0, 0, 3, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62686d78611ff9.38407768', 83, '', '83', 'SOLIDAGO EC.', '', '', 1, 0, 0, 3, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62686e052de9b5.60477638', 84, '', '84', 'MONTECASINO CR.', '', '', 1, 0, 0, 3, 0, 5, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62686f4428d632.63333556', 85, '', '85', 'MONTECASINO EC.', '', '', 1, 0, 0, 3, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S6268701d37e9e4.92035423', 86, '', '86', 'SOLIDAGO COLOM.', '', '', 1, 0, 0, 3, 1, 2, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62687126bec1b6.05746052', 87, '', '87', 'BABY CR.', '', '', 1, 0, 0, 3, 1, 5, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S626871870ebd46.04713423', 88, '', '88', 'SHASTA COLOM.', '', '', 1, 0, 0, 3, 1, 2, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S6268723044c5c9.58841734', 89, '', '89', 'CRISANTEMO COLOM.', '', '', 1, 0, 0, 3, 1, 2, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S626872b47e44b5.83258422', 90, '', '90', 'TIGRILLO EC.', '', '', 1, 0, 0, 3, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S6268736a53a336.86035963', 91, '', '91', 'LIMONIUM EC.', '', '', 1, 0, 0, 3, 1, 4, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S62687405dccad1.18236187', 92, '', '92', 'ORQUIDEA 1V.', '', '', 1, 0, 0, 3, 1, 6, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S626875453536a3.56255477', 93, '', '93', 'ORQUIDEA 2V.', '', '', 1, 0, 0, 3, 1, 6, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S626876580d5181.24688320', 94, '', '94', 'ORQUIDEA 3V.', '', '', 1, 0, 0, 3, 1, 6, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S6268773c137682.32762548', 95, '', '95', 'ANTURIO ES.', '', '', 1, 0, 0, 3, 1, 6, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S626877a7dec3f6.54557183', 96, '', '96', 'GINGER ES.', '', '', 1, 0, 0, 3, 1, 6, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S6268783650cf60.31263932', 97, '', '97', 'AVE DEL PARAISO ES.', '', '', 1, 0, 0, 3, 1, 6, 1, '', 1, 0, 0, 0, '', 0),
(0, 'S626878ad222f88.04233913', 98, '', '98', 'AVECILLAS ES.', '', '', 1, 0, 0, 3, 1, 6, 1, '', 1, 0, 0, 0, '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `categoria` int(1) DEFAULT NULL,
  `tipo` int(1) DEFAULT NULL,
  `codigoant` int(3) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `municipio` varchar(20) DEFAULT NULL,
  `depto` varchar(12) DEFAULT NULL,
  `pais` varchar(10) DEFAULT NULL,
  `contacto` varchar(40) DEFAULT NULL,
  `nrc` varchar(8) DEFAULT NULL,
  `nit` varchar(17) DEFAULT NULL,
  `dui` varchar(12) DEFAULT NULL,
  `giro` varchar(40) DEFAULT NULL,
  `telefono1` varchar(15) DEFAULT NULL,
  `telefono2` varchar(15) DEFAULT NULL,
  `celular` varchar(15) NOT NULL,
  `fax` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `ultcompra` date DEFAULT NULL,
  `acumulado` int(1) DEFAULT NULL,
  `saldo` int(1) DEFAULT NULL,
  `percibe` int(1) DEFAULT NULL,
  `retiene` int(1) DEFAULT NULL,
  `retiene10` int(1) DEFAULT NULL,
  `a30` int(1) DEFAULT NULL,
  `a60` int(1) DEFAULT NULL,
  `a90` int(1) DEFAULT NULL,
  `m90` int(1) DEFAULT NULL,
  `vencido` int(1) DEFAULT NULL,
  `pagadas` int(1) DEFAULT NULL,
  `pendientes` decimal(7,2) DEFAULT NULL,
  `total1` decimal(7,2) DEFAULT NULL,
  `nombreche` varchar(45) DEFAULT NULL,
  `viñeta` int(1) DEFAULT NULL,
  `nacionalidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id_server`, `unique_id`, `id_sucursal`, `id_proveedor`, `categoria`, `tipo`, `codigoant`, `nombre`, `direccion`, `municipio`, `depto`, `pais`, `contacto`, `nrc`, `nit`, `dui`, `giro`, `telefono1`, `telefono2`, `celular`, `fax`, `email`, `ultcompra`, `acumulado`, `saldo`, `percibe`, `retiene`, `retiene10`, `a30`, `a60`, `a90`, `m90`, `vencido`, `pagadas`, `pendientes`, `total1`, `nombreche`, `viñeta`, `nacionalidad`) VALUES
(0, '', 1, 1, NULL, NULL, NULL, 'NO DEFINIDO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutas`
--

CREATE TABLE `rutas` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `ruta` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock`
--

CREATE TABLE `stock` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_stock` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `stock` decimal(11,4) NOT NULL,
  `stock_local` decimal(11,4) NOT NULL,
  `precio_unitario` float NOT NULL,
  `costo_unitario` float NOT NULL,
  `create_date` date NOT NULL,
  `update_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `stock`
--

INSERT INTO `stock` (`id_server`, `unique_id`, `id_sucursal`, `id_stock`, `id_producto`, `stock`, `stock_local`, `precio_unitario`, `costo_unitario`, `create_date`, `update_date`) VALUES
(0, 'S6254601c0b8e07.12446803', 1, 1, 1, '199.0000', '200.0000', 1.25, 0.75, '2022-04-11', '2022-04-27'),
(0, 'S625465747aec37.22902999', 1, 2, 2, '587.0000', '600.0000', 1, 0.42, '2022-04-11', '2022-04-27'),
(0, 'S625467bd766113.77920480', 1, 3, 3, '67.0000', '100.0000', 2.5, 1.7, '2022-04-11', '2022-04-27'),
(0, 'S62546b372ed8a1.29842981', 1, 4, 4, '1200.0000', '1200.0000', 30, 23.0016, '2022-04-11', '2022-04-11'),
(0, 'S625ee926400f79.21519787', 1, 5, 5, '1164.0000', '1200.0000', 0.92, 0.42, '2022-04-19', '2022-04-27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stock_ubicacion`
--

CREATE TABLE `stock_ubicacion` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_su` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` decimal(11,4) NOT NULL,
  `id_ubicacion` int(11) NOT NULL,
  `id_estante` int(11) NOT NULL,
  `id_posicion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `stock_ubicacion`
--

INSERT INTO `stock_ubicacion` (`id_server`, `unique_id`, `id_sucursal`, `id_su`, `id_producto`, `cantidad`, `id_ubicacion`, `id_estante`, `id_posicion`) VALUES
(0, 'S6254601c0ae335.99976116', 1, 1, 1, '199.0000', 1, 0, 0),
(0, 'S6254657479c523.85506477', 1, 2, 2, '587.0000', 1, 0, 0),
(0, 'S625467bd75c050.68529452', 1, 3, 3, '67.0000', 1, 0, 0),
(0, 'S62546b372e1de8.24154619', 1, 4, 4, '1200.0000', 1, 0, 0),
(0, 'S625ee926394e74.51165616', 1, 5, 5, '1164.0000', 1, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursal`
--

CREATE TABLE `sucursal` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `telefono1` varchar(20) NOT NULL,
  `telefono2` varchar(20) NOT NULL,
  `casa_matriz` tinyint(1) NOT NULL,
  `iva` float NOT NULL,
  `monto_retencion1` float NOT NULL,
  `monto_retencion10` float NOT NULL,
  `monto_percepcion` float NOT NULL,
  `n_sucursal` int(11) NOT NULL,
  `vigencia_factura` int(11) NOT NULL,
  `vigencia_pedido` int(11) NOT NULL,
  `giro` varchar(100) NOT NULL,
  `nrc` varchar(100) NOT NULL,
  `nit` varchar(100) NOT NULL,
  `razon_social` varchar(150) NOT NULL,
  `logo` varchar(150) NOT NULL,
  `serie_cof` varchar(100) NOT NULL,
  `desde_cof` int(11) NOT NULL,
  `hasta_cof` int(11) NOT NULL,
  `serie_ccf` varchar(100) NOT NULL,
  `desde_ccf` int(11) NOT NULL,
  `hasta_ccf` int(11) NOT NULL,
  `ultima_act` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sucursal`
--

INSERT INTO `sucursal` (`id_server`, `unique_id`, `id_sucursal`, `descripcion`, `direccion`, `telefono1`, `telefono2`, `casa_matriz`, `iva`, `monto_retencion1`, `monto_retencion10`, `monto_percepcion`, `n_sucursal`, `vigencia_factura`, `vigencia_pedido`, `giro`, `nrc`, `nit`, `razon_social`, `logo`, `serie_cof`, `desde_cof`, `hasta_cof`, `serie_ccf`, `desde_ccf`, `hasta_ccf`, `ultima_act`) VALUES
(1, 'O60d7e01a674126.11597151', 1, 'FLORES GUATEMALA', 'SAN MIGUEL', '0000-0000', '', 1, 13, 100, 0, 100, 1, 1, 1, '-', '00000000-0', '0000-000000-000-0', '-', 'img/6269952c7af6c_LOGOFLORES.png', '18NU000F', 1, 5000, '18UN000C', 1, 5000, '0000-00-00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_empleado`
--

CREATE TABLE `tipo_empleado` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_tipo_empleado` int(11) NOT NULL,
  `descripcion` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_empleado`
--

INSERT INTO `tipo_empleado` (`id_server`, `unique_id`, `id_tipo_empleado`, `descripcion`) VALUES
(1, 'O60d7e01a692f23.65072778', 1, 'Administrador'),
(2, 'O60d7e01a6ab8e3.03454156', 2, 'Vendedor'),
(3, 'O60d7e01a6cd948.12915427', 3, 'Cajero'),
(4, 'O60d7e01a6ee4e4.87490483', 4, 'Bodeguero'),
(5, 'O60d7e01a70edc4.20991700', 5, 'Oficios Varios ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_pago`
--

CREATE TABLE `tipo_pago` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_tipopago` int(11) NOT NULL,
  `alias_tipopago` char(3) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `inactivo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_pago`
--

INSERT INTO `tipo_pago` (`id_server`, `unique_id`, `id_tipopago`, `alias_tipopago`, `descripcion`, `inactivo`) VALUES
(1, 'O60d7e01a739bd0.28959620', 1, 'CON', 'CONTADO', 0),
(2, 'O60d7e01a7527f1.26409344', 2, 'TAR', 'TARJETA DEBITO/CREDITO', 1),
(3, 'O60d7e01a772b32.72372250', 3, 'CRE', 'CREDITO', 0),
(4, 'O60d7e01a794fe3.89046432', 4, 'CHE', 'CHEQUE', 0),
(5, 'O60d7e01a7b5f40.49169259', 5, 'TRA', 'TRANSFERENCIA', 0),
(6, 'O60d7e01a7d86c1.04610920', 6, 'PEN', 'PENDIENTE', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_proveedor`
--

CREATE TABLE `tipo_proveedor` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_proveedor`
--

INSERT INTO `tipo_proveedor` (`id_server`, `unique_id`, `id_tipo`, `nombre`, `descripcion`) VALUES
(1, 'O60d7e01a7ffd47.94616796', 1, 'Costo', ''),
(2, 'O60d7e01a81a593.01566955', 2, 'Gasto', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `to_corte`
--

CREATE TABLE `to_corte` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `to_corte_producto`
--

CREATE TABLE `to_corte_producto` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id` int(11) NOT NULL,
  `id_corte` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `to_corte_producto_detalle`
--

CREATE TABLE `to_corte_producto_detalle` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id` int(11) NOT NULL,
  `id_ref` int(11) NOT NULL,
  `cantidad` decimal(10,4) DEFAULT NULL,
  `stock_anterior` decimal(10,4) DEFAULT NULL,
  `stock_actual` decimal(10,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traslado`
--

CREATE TABLE `traslado` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal_origen` int(11) NOT NULL,
  `id_sucursal_destino` int(11) NOT NULL,
  `id_traslado` int(11) NOT NULL,
  `n_vale` varchar(50) NOT NULL,
  `id_ubicacion_destino` int(11) NOT NULL,
  `concepto` varchar(50) DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `id_empleado_envia` int(11) NOT NULL,
  `id_empleado_recibe` int(11) NOT NULL,
  `empleado_envia` varchar(250) NOT NULL,
  `empleado_recibe` varchar(250) NOT NULL,
  `total` float NOT NULL,
  `anulada` tinyint(4) NOT NULL,
  `finalizada` tinyint(4) NOT NULL,
  `id_origen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traslado_detalle`
--

CREATE TABLE `traslado_detalle` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal_origen` int(11) NOT NULL,
  `id_sucursal_destino` int(11) NOT NULL,
  `id_detalle_traslado` int(11) NOT NULL,
  `id_traslado` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_server_prod` int(11) NOT NULL,
  `cantidad` decimal(11,4) NOT NULL,
  `unidad` int(11) NOT NULL,
  `costo` float NOT NULL,
  `id_presentacion` int(11) NOT NULL,
  `id_server_presen` int(11) NOT NULL,
  `presentacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traslado_detalle_g`
--

CREATE TABLE `traslado_detalle_g` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal_origen` int(11) NOT NULL,
  `id_sucursal_destino` int(11) NOT NULL,
  `id_detalle_traslado` int(11) NOT NULL,
  `id_traslado` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_server_prod` int(11) NOT NULL,
  `cantidad` decimal(11,4) NOT NULL,
  `unidad` int(11) NOT NULL,
  `costo` float NOT NULL,
  `id_presentacion` int(11) NOT NULL,
  `id_server_presen` int(11) NOT NULL,
  `presentacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traslado_detalle_recibido`
--

CREATE TABLE `traslado_detalle_recibido` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal_origen` int(11) NOT NULL,
  `id_sucursal_destino` int(11) NOT NULL,
  `id_detalle_traslado_recibido` int(11) NOT NULL,
  `id_traslado` int(11) NOT NULL,
  `id_traslado_server` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_server_prod` int(11) NOT NULL,
  `cantidad` decimal(11,4) NOT NULL,
  `recibido` decimal(11,4) NOT NULL,
  `unidad` int(11) NOT NULL,
  `id_presentacion` int(11) NOT NULL,
  `id_server_presen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traslado_g`
--

CREATE TABLE `traslado_g` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal_origen` int(11) NOT NULL,
  `id_sucursal_destino` int(11) NOT NULL,
  `id_traslado` int(11) NOT NULL,
  `n_vale` varchar(50) NOT NULL,
  `id_ubicacion_destino` int(11) NOT NULL,
  `concepto` varchar(50) DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `id_empleado_envia` int(11) NOT NULL,
  `id_empleado_recibe` int(11) NOT NULL,
  `empleado_envia` varchar(250) NOT NULL,
  `empleado_recibe` varchar(250) NOT NULL,
  `total` float NOT NULL,
  `anulada` tinyint(4) NOT NULL,
  `finalizada` tinyint(4) NOT NULL,
  `id_origen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE `ubicacion` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_ubicacion` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `bodega` tinyint(1) NOT NULL,
  `borrado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ubicacion`
--

INSERT INTO `ubicacion` (`id_server`, `unique_id`, `id_sucursal`, `id_ubicacion`, `descripcion`, `bodega`, `borrado`) VALUES
(1, 'O60d7e01a9df855.19389310', 1, 1, 'LOCAL DE VENTA', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `nombre` varchar(250) CHARACTER SET utf8 NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `password` varchar(250) NOT NULL,
  `admin` int(11) NOT NULL,
  `precios` int(11) NOT NULL,
  `latitud_ultima` double NOT NULL,
  `longitud_ultima` double NOT NULL,
  `fecha_tracking` date NOT NULL,
  `hora_tracking` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_server`, `unique_id`, `id_sucursal`, `id_usuario`, `id_empleado`, `nombre`, `usuario`, `password`, `admin`, `precios`, `latitud_ultima`, `longitud_ultima`, `fecha_tracking`, `hora_tracking`) VALUES
(0, 'S6254467cb5ccf2.74870569', 1, -1, 0, 'Soporte', 'soporte', 'f90d1250fd96b918b6d474a2e549510c', 1, 1, 0, 0, '0000-00-00', '00:00:00'),
(1, 'O60d7e01a9f01f1.82220007', 1, 1, 1, 'administrador', 'admin', 'f90d1250fd96b918b6d474a2e549510c', 1, 7, 0, 0, '0000-00-00', '00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_modulo`
--

CREATE TABLE `usuario_modulo` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_mod_user` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `voucher`
--

CREATE TABLE `voucher` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_voucher` int(11) NOT NULL,
  `forma_pago` varchar(50) NOT NULL,
  `referencia_pago` varchar(50) NOT NULL,
  `numero_doc` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `monto` float NOT NULL,
  `responsable` varchar(200) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `id_movimiento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `voucher_mov`
--

CREATE TABLE `voucher_mov` (
  `id_server` int(11) NOT NULL,
  `unique_id` text NOT NULL,
  `id_sucursal` int(11) NOT NULL,
  `id_mv` int(11) NOT NULL,
  `id_movimiento` int(11) NOT NULL,
  `id_cuenta_pagar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `abono_credito`
--
ALTER TABLE `abono_credito`
  ADD PRIMARY KEY (`id_abono_credito`);

--
-- Indices de la tabla `access_conf`
--
ALTER TABLE `access_conf`
  ADD PRIMARY KEY (`id_conf`);

--
-- Indices de la tabla `altclitocli`
--
ALTER TABLE `altclitocli`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `apertura_caja`
--
ALTER TABLE `apertura_caja`
  ADD PRIMARY KEY (`id_apertura`);

--
-- Indices de la tabla `banco`
--
ALTER TABLE `banco`
  ADD PRIMARY KEY (`id_banco`);

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id_caja`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `categoria_proveedor`
--
ALTER TABLE `categoria_proveedor`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `cheque`
--
ALTER TABLE `cheque`
  ADD PRIMARY KEY (`id_cheque`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id_compra`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id_configuracion`);

--
-- Indices de la tabla `config_dir`
--
ALTER TABLE `config_dir`
  ADD PRIMARY KEY (`id_config_dir`);

--
-- Indices de la tabla `config_pos`
--
ALTER TABLE `config_pos`
  ADD PRIMARY KEY (`id_config_pos`);

--
-- Indices de la tabla `consignacion`
--
ALTER TABLE `consignacion`
  ADD PRIMARY KEY (`id_consignacion`);

--
-- Indices de la tabla `consignacion_detalle`
--
ALTER TABLE `consignacion_detalle`
  ADD PRIMARY KEY (`id_consignacion_detalle`),
  ADD KEY `id_consignacion` (`id_consignacion`);

--
-- Indices de la tabla `controlcaja`
--
ALTER TABLE `controlcaja`
  ADD PRIMARY KEY (`id_corte`);

--
-- Indices de la tabla `correlativo`
--
ALTER TABLE `correlativo`
  ADD PRIMARY KEY (`id_numdoc`);

--
-- Indices de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD PRIMARY KEY (`id_cotizacion`);

--
-- Indices de la tabla `cotizacion_detalle`
--
ALTER TABLE `cotizacion_detalle`
  ADD PRIMARY KEY (`id_detalle`);

--
-- Indices de la tabla `credito`
--
ALTER TABLE `credito`
  ADD PRIMARY KEY (`id_credito`);

--
-- Indices de la tabla `cuentas_por_pagar_abonos`
--
ALTER TABLE `cuentas_por_pagar_abonos`
  ADD PRIMARY KEY (`id_abono`);

--
-- Indices de la tabla `cuenta_banco`
--
ALTER TABLE `cuenta_banco`
  ADD PRIMARY KEY (`id_cuenta`);

--
-- Indices de la tabla `cuenta_pagar`
--
ALTER TABLE `cuenta_pagar`
  ADD PRIMARY KEY (`id_cuenta_pagar`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id_departamento`);

--
-- Indices de la tabla `detalle_apertura`
--
ALTER TABLE `detalle_apertura`
  ADD PRIMARY KEY (`id_detalle`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`id_det_compra`);

--
-- Indices de la tabla `detalle_voucher`
--
ALTER TABLE `detalle_voucher`
  ADD PRIMARY KEY (`id_detalle`);

--
-- Indices de la tabla `devoluciones`
--
ALTER TABLE `devoluciones`
  ADD PRIMARY KEY (`id_dev`);

--
-- Indices de la tabla `devoluciones_corte`
--
ALTER TABLE `devoluciones_corte`
  ADD PRIMARY KEY (`id_dev`);

--
-- Indices de la tabla `devoluciones_det`
--
ALTER TABLE `devoluciones_det`
  ADD PRIMARY KEY (`id_dev_det`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id_empleado`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`idempresa`);

--
-- Indices de la tabla `estante`
--
ALTER TABLE `estante`
  ADD PRIMARY KEY (`id_estante`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id_factura`);

--
-- Indices de la tabla `factura_detalle`
--
ALTER TABLE `factura_detalle`
  ADD PRIMARY KEY (`id_factura_detalle`);

--
-- Indices de la tabla `Hoja1`
--
ALTER TABLE `Hoja1`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `log_cambio_local`
--
ALTER TABLE `log_cambio_local`
  ADD PRIMARY KEY (`id_log_cambio`);

--
-- Indices de la tabla `log_detalle_cambio_local`
--
ALTER TABLE `log_detalle_cambio_local`
  ADD PRIMARY KEY (`id_detalle_cambio`);

--
-- Indices de la tabla `log_update_local`
--
ALTER TABLE `log_update_local`
  ADD PRIMARY KEY (`id_log_cambio`);

--
-- Indices de la tabla `lote`
--
ALTER TABLE `lote`
  ADD PRIMARY KEY (`id_lote`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indices de la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`id_modulo`);

--
-- Indices de la tabla `movimiento_caja_tipo`
--
ALTER TABLE `movimiento_caja_tipo`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `movimiento_producto`
--
ALTER TABLE `movimiento_producto`
  ADD PRIMARY KEY (`id_movimiento`);

--
-- Indices de la tabla `movimiento_producto_detalle`
--
ALTER TABLE `movimiento_producto_detalle`
  ADD PRIMARY KEY (`id_detalle`);

--
-- Indices de la tabla `movimiento_producto_pendiente`
--
ALTER TABLE `movimiento_producto_pendiente`
  ADD PRIMARY KEY (`id_detalle`);

--
-- Indices de la tabla `movimiento_stock_ubicacion`
--
ALTER TABLE `movimiento_stock_ubicacion`
  ADD PRIMARY KEY (`id_movimiento`);

--
-- Indices de la tabla `mov_caja`
--
ALTER TABLE `mov_caja`
  ADD PRIMARY KEY (`id_movimiento`);

--
-- Indices de la tabla `mov_cta_banco`
--
ALTER TABLE `mov_cta_banco`
  ADD PRIMARY KEY (`id_movimiento`);

--
-- Indices de la tabla `municipio`
--
ALTER TABLE `municipio`
  ADD PRIMARY KEY (`id_municipio`);

--
-- Indices de la tabla `nc_corte`
--
ALTER TABLE `nc_corte`
  ADD PRIMARY KEY (`id_nc`);

--
-- Indices de la tabla `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`);

--
-- Indices de la tabla `pedido_detalle`
--
ALTER TABLE `pedido_detalle`
  ADD PRIMARY KEY (`id_pedido_detalle`),
  ADD KEY `id_pedido` (`id_pedido`);

--
-- Indices de la tabla `pedido_prov`
--
ALTER TABLE `pedido_prov`
  ADD PRIMARY KEY (`id_pedido_prov`);

--
-- Indices de la tabla `pedido_prov_detalle`
--
ALTER TABLE `pedido_prov_detalle`
  ADD PRIMARY KEY (`id_pedido_detalle`),
  ADD KEY `id_pedido` (`id_pedido`);

--
-- Indices de la tabla `posicion`
--
ALTER TABLE `posicion`
  ADD PRIMARY KEY (`id_posicion`);

--
-- Indices de la tabla `precio_aut`
--
ALTER TABLE `precio_aut`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  ADD PRIMARY KEY (`id_presentacion`);

--
-- Indices de la tabla `presentacion_producto`
--
ALTER TABLE `presentacion_producto`
  ADD PRIMARY KEY (`id_pp`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `rutas`
--
ALTER TABLE `rutas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id_stock`);

--
-- Indices de la tabla `stock_ubicacion`
--
ALTER TABLE `stock_ubicacion`
  ADD PRIMARY KEY (`id_su`);

--
-- Indices de la tabla `sucursal`
--
ALTER TABLE `sucursal`
  ADD PRIMARY KEY (`id_sucursal`);

--
-- Indices de la tabla `tipo_empleado`
--
ALTER TABLE `tipo_empleado`
  ADD PRIMARY KEY (`id_tipo_empleado`);

--
-- Indices de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  ADD PRIMARY KEY (`id_tipopago`);

--
-- Indices de la tabla `tipo_proveedor`
--
ALTER TABLE `tipo_proveedor`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `to_corte`
--
ALTER TABLE `to_corte`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `to_corte_producto`
--
ALTER TABLE `to_corte_producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `to_corte_producto_detalle`
--
ALTER TABLE `to_corte_producto_detalle`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `traslado`
--
ALTER TABLE `traslado`
  ADD PRIMARY KEY (`id_traslado`);

--
-- Indices de la tabla `traslado_detalle`
--
ALTER TABLE `traslado_detalle`
  ADD PRIMARY KEY (`id_detalle_traslado`);

--
-- Indices de la tabla `traslado_detalle_g`
--
ALTER TABLE `traslado_detalle_g`
  ADD PRIMARY KEY (`id_detalle_traslado`);

--
-- Indices de la tabla `traslado_detalle_recibido`
--
ALTER TABLE `traslado_detalle_recibido`
  ADD PRIMARY KEY (`id_detalle_traslado_recibido`);

--
-- Indices de la tabla `traslado_g`
--
ALTER TABLE `traslado_g`
  ADD PRIMARY KEY (`id_traslado`);

--
-- Indices de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD PRIMARY KEY (`id_ubicacion`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `usuario_modulo`
--
ALTER TABLE `usuario_modulo`
  ADD PRIMARY KEY (`id_mod_user`);

--
-- Indices de la tabla `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`id_voucher`);

--
-- Indices de la tabla `voucher_mov`
--
ALTER TABLE `voucher_mov`
  ADD PRIMARY KEY (`id_mv`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `abono_credito`
--
ALTER TABLE `abono_credito`
  MODIFY `id_abono_credito` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `access_conf`
--
ALTER TABLE `access_conf`
  MODIFY `id_conf` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `altclitocli`
--
ALTER TABLE `altclitocli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `apertura_caja`
--
ALTER TABLE `apertura_caja`
  MODIFY `id_apertura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `banco`
--
ALTER TABLE `banco`
  MODIFY `id_banco` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id_caja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `categoria_proveedor`
--
ALTER TABLE `categoria_proveedor`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `cheque`
--
ALTER TABLE `cheque`
  MODIFY `id_cheque` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id_configuracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `config_dir`
--
ALTER TABLE `config_dir`
  MODIFY `id_config_dir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `config_pos`
--
ALTER TABLE `config_pos`
  MODIFY `id_config_pos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `consignacion`
--
ALTER TABLE `consignacion`
  MODIFY `id_consignacion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `consignacion_detalle`
--
ALTER TABLE `consignacion_detalle`
  MODIFY `id_consignacion_detalle` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `controlcaja`
--
ALTER TABLE `controlcaja`
  MODIFY `id_corte` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `correlativo`
--
ALTER TABLE `correlativo`
  MODIFY `id_numdoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  MODIFY `id_cotizacion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cotizacion_detalle`
--
ALTER TABLE `cotizacion_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `credito`
--
ALTER TABLE `credito`
  MODIFY `id_credito` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cuentas_por_pagar_abonos`
--
ALTER TABLE `cuentas_por_pagar_abonos`
  MODIFY `id_abono` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cuenta_banco`
--
ALTER TABLE `cuenta_banco`
  MODIFY `id_cuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `cuenta_pagar`
--
ALTER TABLE `cuenta_pagar`
  MODIFY `id_cuenta_pagar` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `detalle_apertura`
--
ALTER TABLE `detalle_apertura`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `id_det_compra` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `detalle_voucher`
--
ALTER TABLE `detalle_voucher`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `devoluciones`
--
ALTER TABLE `devoluciones`
  MODIFY `id_dev` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `devoluciones_corte`
--
ALTER TABLE `devoluciones_corte`
  MODIFY `id_dev` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `devoluciones_det`
--
ALTER TABLE `devoluciones_det`
  MODIFY `id_dev_det` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `estante`
--
ALTER TABLE `estante`
  MODIFY `id_estante` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `factura_detalle`
--
ALTER TABLE `factura_detalle`
  MODIFY `id_factura_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `Hoja1`
--
ALTER TABLE `Hoja1`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2326;
--
-- AUTO_INCREMENT de la tabla `log_cambio_local`
--
ALTER TABLE `log_cambio_local`
  MODIFY `id_log_cambio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;
--
-- AUTO_INCREMENT de la tabla `log_detalle_cambio_local`
--
ALTER TABLE `log_detalle_cambio_local`
  MODIFY `id_detalle_cambio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;
--
-- AUTO_INCREMENT de la tabla `log_update_local`
--
ALTER TABLE `log_update_local`
  MODIFY `id_log_cambio` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `lote`
--
ALTER TABLE `lote`
  MODIFY `id_lote` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;
--
-- AUTO_INCREMENT de la tabla `movimiento_caja_tipo`
--
ALTER TABLE `movimiento_caja_tipo`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `movimiento_producto`
--
ALTER TABLE `movimiento_producto`
  MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `movimiento_producto_detalle`
--
ALTER TABLE `movimiento_producto_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `movimiento_producto_pendiente`
--
ALTER TABLE `movimiento_producto_pendiente`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `movimiento_stock_ubicacion`
--
ALTER TABLE `movimiento_stock_ubicacion`
  MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `mov_caja`
--
ALTER TABLE `mov_caja`
  MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `mov_cta_banco`
--
ALTER TABLE `mov_cta_banco`
  MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `municipio`
--
ALTER TABLE `municipio`
  MODIFY `id_municipio` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID del municipio', AUTO_INCREMENT=263;
--
-- AUTO_INCREMENT de la tabla `nc_corte`
--
ALTER TABLE `nc_corte`
  MODIFY `id_nc` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `paises`
--
ALTER TABLE `paises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `pedido_detalle`
--
ALTER TABLE `pedido_detalle`
  MODIFY `id_pedido_detalle` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `pedido_prov`
--
ALTER TABLE `pedido_prov`
  MODIFY `id_pedido_prov` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `pedido_prov_detalle`
--
ALTER TABLE `pedido_prov_detalle`
  MODIFY `id_pedido_detalle` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `posicion`
--
ALTER TABLE `posicion`
  MODIFY `id_posicion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `precio_aut`
--
ALTER TABLE `precio_aut`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  MODIFY `id_presentacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `presentacion_producto`
--
ALTER TABLE `presentacion_producto`
  MODIFY `id_pp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;
--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;
--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `rutas`
--
ALTER TABLE `rutas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `stock`
--
ALTER TABLE `stock`
  MODIFY `id_stock` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `stock_ubicacion`
--
ALTER TABLE `stock_ubicacion`
  MODIFY `id_su` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `sucursal`
--
ALTER TABLE `sucursal`
  MODIFY `id_sucursal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tipo_empleado`
--
ALTER TABLE `tipo_empleado`
  MODIFY `id_tipo_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  MODIFY `id_tipopago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `tipo_proveedor`
--
ALTER TABLE `tipo_proveedor`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `to_corte`
--
ALTER TABLE `to_corte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `to_corte_producto`
--
ALTER TABLE `to_corte_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `to_corte_producto_detalle`
--
ALTER TABLE `to_corte_producto_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `traslado`
--
ALTER TABLE `traslado`
  MODIFY `id_traslado` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `traslado_detalle`
--
ALTER TABLE `traslado_detalle`
  MODIFY `id_detalle_traslado` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `traslado_detalle_g`
--
ALTER TABLE `traslado_detalle_g`
  MODIFY `id_detalle_traslado` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `traslado_detalle_recibido`
--
ALTER TABLE `traslado_detalle_recibido`
  MODIFY `id_detalle_traslado_recibido` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `traslado_g`
--
ALTER TABLE `traslado_g`
  MODIFY `id_traslado` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `id_ubicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `usuario_modulo`
--
ALTER TABLE `usuario_modulo`
  MODIFY `id_mod_user` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `voucher`
--
ALTER TABLE `voucher`
  MODIFY `id_voucher` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `voucher_mov`
--
ALTER TABLE `voucher_mov`
  MODIFY `id_mv` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
