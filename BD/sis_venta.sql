-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-12-2023 a las 14:25:09
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sis_venta`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`` PROCEDURE `actualizar_precio_producto` (IN `n_cantidad` INT, IN `n_precio` DECIMAL(10,2), IN `codigo` INT)   BEGIN
DECLARE nueva_existencia int;
DECLARE nuevo_total decimal(10,2);
DECLARE nuevo_precio decimal(10,2);

DECLARE cant_actual int;
DECLARE pre_actual decimal(10,2);

DECLARE actual_existencia int;
DECLARE actual_precio decimal(10,2);

SELECT precio, existencia INTO actual_precio, actual_existencia FROM producto WHERE codproducto = codigo;

SET nueva_existencia = actual_existencia + n_cantidad;
SET nuevo_total = n_precio;
SET nuevo_precio = nuevo_total;

UPDATE producto SET existencia = nueva_existencia, precio = nuevo_precio WHERE codproducto = codigo;

SELECT nueva_existencia, nuevo_precio;
END$$

CREATE DEFINER=`` PROCEDURE `add_detalle_temp` (`codigo` INT, `cantidad` INT, `token_user` VARCHAR(50))   BEGIN
DECLARE precio_actual decimal(10,2);
SELECT precio INTO precio_actual FROM producto WHERE codproducto = codigo;
INSERT INTO detalle_temp(token_user, codproducto, cantidad, precio_venta) VALUES (token_user, codigo, cantidad, precio_actual);
SELECT tmp.correlativo, tmp.codproducto, p.descripcion, tmp.cantidad, tmp.precio_venta FROM detalle_temp tmp INNER JOIN producto p ON tmp.codproducto = p.codproducto WHERE tmp.token_user = token_user;
END$$

CREATE DEFINER=`` PROCEDURE `data` ()   BEGIN
DECLARE usuarios int;
DECLARE clientes int;
DECLARE proveedores int;
DECLARE productos int;
DECLARE ventas int;
SELECT COUNT(*) INTO usuarios FROM usuario;
SELECT COUNT(*) INTO clientes FROM cliente;
SELECT COUNT(*) INTO proveedores FROM proveedor;
SELECT COUNT(*) INTO productos FROM producto;
SELECT COUNT(*) INTO ventas FROM factura WHERE fecha > CURDATE();

SELECT usuarios, clientes, proveedores, productos, ventas;

END$$

CREATE DEFINER=`` PROCEDURE `del_detalle_temp` (`id_detalle` INT, `token` VARCHAR(50))   BEGIN
DELETE FROM detalle_temp WHERE correlativo = id_detalle;
SELECT tmp.correlativo, tmp.codproducto, p.descripcion, tmp.cantidad, tmp.precio_venta FROM detalle_temp tmp INNER JOIN producto p ON tmp.codproducto = p.codproducto WHERE tmp.token_user = token;
END$$

CREATE DEFINER=`` PROCEDURE `procesar_venta` (IN `cod_usuario` INT, IN `cod_cliente` INT, IN `token` VARCHAR(50))   BEGIN
DECLARE factura INT;
DECLARE registros INT;
DECLARE total DECIMAL(10,2);
DECLARE nueva_existencia int;
DECLARE existencia_actual int;

DECLARE tmp_cod_producto int;
DECLARE tmp_cant_producto int;
DECLARE a int;
SET a = 1;

CREATE TEMPORARY TABLE tbl_tmp_tokenuser(
	id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    cod_prod BIGINT,
    cant_prod int);
SET registros = (SELECT COUNT(*) FROM detalle_temp WHERE token_user = token);
IF registros > 0 THEN
INSERT INTO tbl_tmp_tokenuser(cod_prod, cant_prod) SELECT codproducto, cantidad FROM detalle_temp WHERE token_user = token;
INSERT INTO factura (usuario,codcliente) VALUES (cod_usuario, cod_cliente);
SET factura = LAST_INSERT_ID();

INSERT INTO detallefactura(nofactura,codproducto,cantidad,precio_venta) SELECT (factura) AS nofactura, codproducto, cantidad,precio_venta FROM detalle_temp WHERE token_user = token;
WHILE a <= registros DO
	SELECT cod_prod, cant_prod INTO tmp_cod_producto,tmp_cant_producto FROM tbl_tmp_tokenuser WHERE id = a;
    SELECT existencia INTO existencia_actual FROM producto WHERE codproducto = tmp_cod_producto;
    SET nueva_existencia = existencia_actual - tmp_cant_producto;
    UPDATE producto SET existencia = nueva_existencia WHERE codproducto = tmp_cod_producto;
    SET a=a+1;
END WHILE;
SET total = (SELECT SUM(cantidad * precio_venta) FROM detalle_temp WHERE token_user = token);
UPDATE factura SET totalfactura = total WHERE nofactura = factura;
DELETE FROM detalle_temp WHERE token_user = token;
TRUNCATE TABLE tbl_tmp_tokenuser;
SELECT * FROM factura WHERE nofactura = factura;
ELSE
SELECT 0;
END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL,
  `dni` int(8) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` int(15) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `dni` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `razon_social` varchar(100) NOT NULL,
  `telefono` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `direccion` text NOT NULL,
  `igv` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `dni`, `nombre`, `razon_social`, `telefono`, `email`, `direccion`, `igv`) VALUES
(1, 1, 'Nexera', '', 2, 'nexera@nexera', 'California UE', 1.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cslb_data`
--

CREATE TABLE `cslb_data` (
  `id` int(11) NOT NULL,
  `numero_licencia` int(11) NOT NULL,
  `business` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `entity` varchar(255) NOT NULL,
  `entity_issued` varchar(255) NOT NULL,
  `entity_expire` varchar(255) NOT NULL,
  `classifications` varchar(255) NOT NULL,
  `workers_comp` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `effective_date` varchar(255) NOT NULL,
  `expire_date` varchar(255) NOT NULL,
  `ceo_primary` varchar(255) NOT NULL,
  `holder_type` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cslb_data`
--

INSERT INTO `cslb_data` (`id`, `numero_licencia`, `business`, `address`, `city`, `state`, `zip`, `phone`, `entity`, `entity_issued`, `entity_expire`, `classifications`, `workers_comp`, `status`, `effective_date`, `expire_date`, `ceo_primary`, `holder_type`, `notes`, `created_at`) VALUES
(46, 1000043, 'VELA ROBERT JR', '4427 N BOND AVENUE', 'FRESNO', 'CA', 93726, '(559) 240 6645', 'Sole Owner', '2015-01-10T00:00:00.000Z', '2015-01-10T00:00:00.000Z', 'C60', '', 'Exempt', '2023-01-20T00:00:00.000Z', '2025-01-31T00:00:00.000Z', ' VELA                               ROBERT                     JR', 'Sole Owner', 'hola esto es una prueba', '2023-12-06 23:13:31'),
(47, 1011196, 'JMC DEVELOPMENT GROUP INC', '3802 ROSECRANS ST #185', 'SAN DIEGO', 'CA', 92110, '(619) 818 1040', 'Corporation', '2016-02-12T00:00:00.000Z', '2016-02-12T00:00:00.000Z', 'A| B| C27', '', 'Workers\' Compensation Insurance', '2023-09-22T00:00:00.000Z', '2024-02-29T00:00:00.000Z', ' CARDENAS                           YANET', 'Corporation', 'hola esto es una prueba ', '2023-12-06 23:32:17'),
(48, 1011196, 'JMC DEVELOPMENT GROUP INC', '3802 ROSECRANS ST #185', 'SAN DIEGO', 'CA', 92110, '(619) 818 1040', 'Corporation', '2016-02-12T00:00:00.000Z', '2016-02-12T00:00:00.000Z', 'A| B| C27', '', 'Workers\' Compensation Insurance', '2023-09-22T00:00:00.000Z', '2024-02-29T00:00:00.000Z', ' CARDENAS                           YANET', 'Corporation', 'hola esto es una prueba ', '2023-12-06 23:32:17'),
(49, 1062310, 'SUMMIT BUILDING COMPANY', '8175 E KAISER BLVD SUITE 102', 'ANAHEIM', 'CA', 92808, '(714) 783 9444', 'Corporation', '2020-01-14T00:00:00.000Z', '2020-01-14T00:00:00.000Z', 'B', '', 'Workers\' Compensation Insurance', '2023-07-01T00:00:00.000Z', '2024-01-31T00:00:00.000Z', ' RAMIREZ                            FRANCISCO      JAVIER', 'Corporation', '', '2023-12-06 23:40:39'),
(50, 1062310, 'SUMMIT BUILDING COMPANY', '8175 E KAISER BLVD SUITE 102', 'ANAHEIM', 'CA', 92808, '(714) 783 9444', 'Corporation', '2020-01-14T00:00:00.000Z', '2020-01-14T00:00:00.000Z', 'B', '', 'Workers\' Compensation Insurance', '2023-07-01T00:00:00.000Z', '2024-01-31T00:00:00.000Z', ' RAMIREZ                            FRANCISCO      JAVIER', 'Corporation', '', '2023-12-06 23:40:39'),
(51, 1000045, 'GEISINGER DEBORAH J', 'P O BOX 3511', 'IDYLLWILD', 'CA', 92549, '(951) 966 1094', 'Sole Owner', '2015-01-10T00:00:00.000Z', '2015-01-10T00:00:00.000Z', 'D49', '', 'Workers\' Compensation Insurance', '2023-01-01T00:00:00.000Z', '2025-01-31T00:00:00.000Z', ' GEISINGER                          DEBORAH        JANINE', 'Sole Owner', 'prueba', '2023-12-07 14:04:08'),
(52, 1100033, 'VELUX AMERICA LLC', '4848 RONSON CT SUITE E', 'SAN DIEGO', 'CA', 92111, '(858) 268 9940', 'Limited Liability', '2022-12-27T00:00:00.000Z', '2022-12-27T00:00:00.000Z', 'B', '', 'Workers\' Compensation Insurance', '2023-03-01T00:00:00.000Z', '2024-12-31T00:00:00.000Z', ' TVC HOLDINGS LLC', 'Limited Liability', 'prueba', '2023-12-08 01:10:22'),
(53, 1000048, 'GEISINGER DEBORAH J', 'P O BOX 3511', 'IDYLLWILD', 'CA', 92549, '(951) 966 1094', 'Sole Owner', '2015-01-10T00:00:00.000Z', '2015-01-10T00:00:00.000Z', 'D49', '', 'Workers\' Compensation Insurance', '2023-01-01T00:00:00.000Z', '2025-01-31T00:00:00.000Z', ' GEISINGER                          DEBORAH        JANINE', 'Sole Owner', 'prueba', '2023-12-08 01:22:01'),
(54, 1000046, 'BAYSIDE ELECTRIC', '131 SUNSET AVE STE E-337', 'SUISUN CITY', 'CA', 94585, '(707) 753 1884', 'Corporation', '2015-01-10T00:00:00.000Z', '2015-01-10T00:00:00.000Z', 'C10', '', 'Workers\' Compensation Insurance', '2023-07-01T00:00:00.000Z', '2025-08-31T00:00:00.000Z', ' TABBERT                            MICHAEL        JOHN', 'Corporation', 'prueba ', '2023-12-08 01:40:42'),
(55, 1000049, 'PERFECTION + PAINTING', '629 FALCONER RD', 'ESCONDIDO', 'CA', 92027, '(760) 855 4617', 'Sole Owner', '2015-01-10T00:00:00.000Z', '2015-01-10T00:00:00.000Z', 'C33', '', 'Exempt', '2022-12-09T00:00:00.000Z', '2025-01-31T00:00:00.000Z', ' CEDANO                             ANTHONY', 'Sole Owner', 'prueba', '2023-12-08 01:49:09'),
(56, 1000075, 'VELA ROBERT JR', '4427 N BOND AVENUE', 'FRESNO', 'CA', 93726, '(559) 240 6645', 'Sole Owner', '2015-01-10T00:00:00.000Z', '2015-01-10T00:00:00.000Z', 'C60', '', 'Exempt', '2023-01-20T00:00:00.000Z', '2025-01-31T00:00:00.000Z', ' VELA                               ROBERT                     JR', 'Sole Owner', '', '2023-12-08 01:58:07'),
(57, 1001139, 'P C R BUILDERS INC', '1114 MESA DRIVE UNIT A', 'SAN JOSE', 'CA', 95118, '(408) 881 4965', 'Corporation', '2015-02-13T00:00:00.000Z', '2015-02-13T00:00:00.000Z', 'B', '', 'Workers\' Compensation Insurance', '2018-07-03T00:00:00.000Z', '2025-02-28T00:00:00.000Z', ' RIVAS AGUILAR                      PAOOLO         CESAR| RIVAS                              PAOOLO         CESAR', 'Corporation', 'prueba', '2023-12-08 02:26:08'),
(58, 1100031, 'CANON CONSTRUCTION', '10556 COMBIE RD #6386', 'AUBURN', 'CA', 95602, '(530) 913 8777', 'Sole Owner', '2022-12-27T00:00:00.000Z', '2022-12-27T00:00:00.000Z', 'B', '', 'Exempt', '2022-12-10T00:00:00.000Z', '2024-12-31T00:00:00.000Z', ' CANON                              DANIEL         JAMES', 'Sole Owner', 'hola esto es una prueba', '2023-12-08 02:30:34'),
(59, 1000053, 'RACE TRACK SPECIALTIES', '4290 PALA RD', 'FALLBROOK', 'CA', 92028, '(760) 908 7337', 'Sole Owner', '2015-01-10T00:00:00.000Z', '2015-01-10T00:00:00.000Z', 'C12', '', 'Exempt', '2023-01-06T00:00:00.000Z', '2025-01-31T00:00:00.000Z', ' BUCALO                             JOHN           HARRISON    III', 'Sole Owner', 'prueba 27', '2023-12-08 03:19:20'),
(60, 1113367, 'NEW LEVEL ELECTRICAL CONTRACTING', '21714 PERRY ST', 'PERRIS', 'CA', 92570, '(951) 472 5102', 'Sole Owner', '2023-11-30T00:00:00.000Z', '2023-11-30T00:00:00.000Z', 'C10', '', 'Exempt', '2023-11-15T00:00:00.000Z', '2025-11-30T00:00:00.000Z', ' ROJAS                              ABEL           ALEJANDRO', 'Sole Owner', 'prueba 33', '2023-12-08 03:29:52'),
(61, 1000078, 'WENDTCO INC', '45725 PARADISE VALLEY RD', 'INDIAN WELLS', 'CA', 92210, '(626) 497 6320', 'Corporation', '2015-01-12T00:00:00.000Z', '2015-01-12T00:00:00.000Z', 'B| C-6', '', 'Workers\' Compensation Insurance', '2023-10-11T00:00:00.000Z', '2025-01-31T00:00:00.000Z', ' WENDT                              REYNALDO       ALBERTO', 'Corporation', 'prueba ', '2023-12-08 03:36:17'),
(62, 1001140, 'ALPHA EXPLOSIVES', 'P O BOX 310', 'LINCOLN', 'CA', 95648, '(916) 645 3377', 'Corporation', '2015-02-13T00:00:00.000Z', '2015-02-13T00:00:00.000Z', 'A| D09', '', 'Workers\' Compensation Insurance', '2021-04-01T00:00:00.000Z', '2025-02-28T00:00:00.000Z', ' TOWNES                             BRUCE          CARLTON', 'Corporation', 'prueba', '2023-12-08 03:42:02'),
(63, 1100300, 'IWIRED AUDIO VIDEO DATA LLC', '17412 VENTURA BLVD #692', 'ENCINO', 'CA', 91316, '(818) 744 3549', 'Limited Liability', '2023-01-06T00:00:00.000Z', '2023-01-06T00:00:00.000Z', 'C-7', '', 'Exempt', '2022-12-10T00:00:00.000Z', '2025-01-31T00:00:00.000Z', ' VASILOAIA                          ANDREI         GEORGEL', 'Limited Liability', 'prueba ', '2023-12-08 13:19:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallefactura`
--

CREATE TABLE `detallefactura` (
  `correlativo` bigint(20) NOT NULL,
  `nofactura` bigint(20) NOT NULL,
  `codproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_temp`
--

CREATE TABLE `detalle_temp` (
  `correlativo` int(11) NOT NULL,
  `token_user` varchar(50) NOT NULL,
  `codproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

CREATE TABLE `entradas` (
  `correlativo` int(11) NOT NULL,
  `codproducto` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `nofactura` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario` int(11) NOT NULL,
  `codcliente` int(11) NOT NULL,
  `totalfactura` decimal(10,2) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `codproducto` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `proveedor` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `existencia` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`codproducto`, `descripcion`, `proveedor`, `precio`, `existencia`, `usuario_id`) VALUES
(8, 'advertising', 7, 0.00, 0, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `codproveedor` int(11) NOT NULL,
  `proveedor` varchar(100) NOT NULL,
  `contacto` varchar(100) NOT NULL,
  `telefono` int(11) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`codproveedor`, `proveedor`, `contacto`, `telefono`, `direccion`, `usuario_id`) VALUES
(7, 'Marketing', '000001', 0, '', 9),
(8, 'Business consulting', '0022023', 0, '', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` int(11) NOT NULL,
  `rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Vendedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `rol` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `url_server` varchar(255) DEFAULT NULL,
  `pbx_username` varchar(50) DEFAULT NULL,
  `password_pbx` varchar(50) DEFAULT NULL,
  `cid` varchar(50) DEFAULT NULL,
  `extension_src` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `correo`, `usuario`, `clave`, `rol`, `address`, `url_server`, `pbx_username`, `password_pbx`, `cid`, `extension_src`) VALUES
(9, 'Juan Olmedo', 'juan.o@nevtis.com', 'JuanCEO', '8ca06733d5a4f8e986cb50d1103f8f55', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'Ezequiel Alarcon', 'ezequiel.a@nevtis.com', 'EzequielTech', 'd858df4de82507a818e27a14be87367d', 1, NULL, 'https://nevtishq.nevtisvoice.com/app/click_to_call/click_to_call.php?', 'ezequiel.a', '9fc6934e2676d57b2f068fa196b8ac2d', '', ''),
(12, 'ventas', 'ventas@nevtis.com', 'vendedor', '25f9e794323b453885f5181f1b624d0b', 2, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'supervisor', 'supervisor.a@nevtis.com', 'super', 'd2547e480d627973039c3a1ea10081b9', 2, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cslb_data`
--
ALTER TABLE `cslb_data`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD PRIMARY KEY (`correlativo`);

--
-- Indices de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD PRIMARY KEY (`correlativo`);

--
-- Indices de la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`correlativo`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`nofactura`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`codproducto`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`codproveedor`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cslb_data`
--
ALTER TABLE `cslb_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  MODIFY `correlativo` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `entradas`
--
ALTER TABLE `entradas`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `nofactura` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `codproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `codproveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
