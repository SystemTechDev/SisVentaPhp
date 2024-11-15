-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-11-2024 a las 21:16:15
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `system_integrado`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acceso`
--

CREATE TABLE `acceso` (
  `idperfil` int(11) NOT NULL,
  `idopcion` int(11) NOT NULL,
  `estado` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `acceso`
--

INSERT INTO `acceso` (`idperfil`, `idopcion`, `estado`) VALUES
(1, 1, 1),
(1, 2, 1),
(1, 3, 1),
(1, 4, 1),
(1, 5, 1),
(1, 6, 1),
(1, 7, 1),
(1, 8, 1),
(1, 9, 1),
(1, 10, 1),
(1, 11, 1),
(1, 12, 1),
(1, 13, 1),
(1, 14, 1),
(1, 15, 1),
(1, 16, 1),
(1, 17, 1),
(1, 18, 1),
(2, 5, 1),
(2, 6, 1),
(3, 1, 1),
(3, 2, 1),
(3, 5, 1),
(3, 6, 1),
(3, 7, 1),
(3, 9, 0),
(4, 1, 1),
(4, 2, 1),
(4, 6, 0),
(4, 7, 1),
(7, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adelanto`
--

CREATE TABLE `adelanto` (
  `idadelanto` int(11) NOT NULL,
  `personal_id` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `monto` decimal(15,2) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `adelanto`
--

INSERT INTO `adelanto` (`idadelanto`, `personal_id`, `fecha`, `monto`, `estado`) VALUES
(1, 1, '2022-12-07', 100.00, 1),
(2, 2, '0000-00-00', 2022.00, 2022),
(3, 3, '2022-12-09', 30.00, 1),
(4, 2, '2024-11-14', 55.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afectacion`
--

CREATE TABLE `afectacion` (
  `idafectacion` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `afectacion`
--

INSERT INTO `afectacion` (`idafectacion`, `descripcion`) VALUES
(10, 'GRAVADAS'),
(20, 'EXONERADAS'),
(30, 'INAFECTAS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `idasistencia` int(11) NOT NULL,
  `personal_id` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `asistio` char(2) NOT NULL,
  `tiempo` varchar(50) NOT NULL,
  `justificacion` varchar(200) DEFAULT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistencia`
--

INSERT INTO `asistencia` (`idasistencia`, `personal_id`, `fecha`, `asistio`, `tiempo`, `justificacion`, `estado`) VALUES
(1, 1, '2022-12-07', 'SI', 'Mediodia', 'Este dia ha trabjado en centro poblado divisoria', 1),
(2, 2, '2022-12-09', 'SI', 'Completo', 'todo ok', 1),
(3, 3, '2022-12-20', 'SI', 'Completo', 'hoy trabajo en inicial', 1),
(4, 1, '2024-11-14', 'SI', 'Completo', 'TODO EL DIA WEBEO J', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idcategoria` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `estado` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcategoria`, `nombre`, `estado`) VALUES
(1, 'FIERROSXYZ', 1),
(2, 'BEBIDAS', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoriamenu`
--

CREATE TABLE `categoriamenu` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `orden` int(11) NOT NULL,
  `icono` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoriamenu`
--

INSERT INTO `categoriamenu` (`id`, `nombre`, `orden`, `icono`, `estado`) VALUES
(1, 'CONFIGURACION', 1, 'nav-icon fas fa-cogs', 1),
(2, 'ADMINISTRACION', 2, 'nav-icon fas fa-user-circle', 1),
(3, 'ALMACEN', 3, 'nav-icon fas fa-list', 1),
(4, 'COMPRAS', 4, 'nav-icon fas fa-truck-moving', 1),
(5, 'VENTAS', 5, 'nav-icon fas fa-cart-plus', 1),
(6, 'INVENTARIO', 6, 'nav-icon fas fa-boxes', 1),
(7, 'REPORTES', 7, 'nav-icon fas fa-chart-bar', 1),
(8, 'PERSONAL', 8, 'nav-icon fas fa-user-astronaut', 1),
(9, 'HERRAMIENTAS', 9, 'nav-icon fas fa-motorcycle', 1),
(10, 'GALERIA', 10, 'nav-icon fas fa-images', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL,
  `nombre` varchar(200) DEFAULT NULL,
  `idtipodocumento` char(1) DEFAULT NULL,
  `nrodocumento` varchar(20) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `estado` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idcliente`, `nombre`, `idtipodocumento`, `nrodocumento`, `direccion`, `estado`) VALUES
(1, 'JUAN PEREZ', '1', '12345699', 'MANUEL NRO 123 - CERCADO DE LIMA', 1),
(2, 'TAQINI TECHNOLOGY S.A.C.', '6', '20602814425', 'CAL.JUAN CUGLIEVAN NRO. 216 CERCADO DE CHICLAYO  (OFICINA NRO. 301)  LAMBAYEQUE - CHICLAYO - CHICLAYO', 1),
(3, 'JUNTA DE USUARIOS DEL SECTOR HIDRAULICO MENOR SAN LORENZO', '6', '20161500292', 'AV.REFORMA AGRARIA NRO. S N CRUCETA  (EX DRENAJE)  PIURA - PIURA - TAMBO GRANDE', 1),
(4, 'KEL RIVADENEIRA FABIAN', '6', '10751237877', 'jr ucayali mz E lt 10 -BOQUERON', 1),
(5, 'EUSEBIO KELVIN RIVADENEIRA FABIAN', '1', '75123787', 'NUEVA DIRECCION', 1),
(6, 'hola mundo', '1', '12345678', 'holaaaa world', 1),
(7, 'MUNICIPALIDAD DISTRITAL DE BOQUERON', '6', '20607827983', 'Boqueron del Padre abad-ucayali', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle`
--

CREATE TABLE `detalle` (
  `iddetalle` int(11) NOT NULL,
  `idventa` int(11) DEFAULT NULL,
  `idproducto` int(11) DEFAULT NULL,
  `cantidad` decimal(15,2) DEFAULT NULL,
  `unidad` char(3) DEFAULT NULL,
  `pventa` decimal(15,2) DEFAULT NULL,
  `igv` decimal(15,2) DEFAULT NULL,
  `icbper` decimal(15,2) DEFAULT NULL,
  `descuento` decimal(15,2) DEFAULT NULL,
  `total` decimal(15,2) DEFAULT NULL,
  `idafectacion` int(11) DEFAULT NULL,
  `estado` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `detalle`
--

INSERT INTO `detalle` (`iddetalle`, `idventa`, `idproducto`, `cantidad`, `unidad`, `pventa`, `igv`, `icbper`, `descuento`, `total`, `idafectacion`, `estado`) VALUES
(1, 1, 1, 2.00, 'NIU', 7.00, 0.00, 0.00, 0.00, 14.00, 20, 1),
(2, 1, 2, 2.00, 'NIU', 8.00, 0.00, 0.00, 0.00, 16.00, 20, 1),
(3, 3, 3, 1.00, 'PQT', 15.00, 0.00, 0.00, 0.00, 15.00, 20, 1),
(4, 3, 1, 1.00, 'NIU', 7.00, 0.00, 0.00, 0.00, 7.00, 20, 1),
(5, 3, 2, 1.00, 'NIU', 8.00, 0.00, 0.00, 0.00, 8.00, 20, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallemovimiento`
--

CREATE TABLE `detallemovimiento` (
  `id` int(10) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL,
  `preciounitario` decimal(9,2) NOT NULL,
  `subtotal` decimal(9,2) NOT NULL,
  `producto_id` int(10) UNSIGNED NOT NULL,
  `movimiento_id` int(10) UNSIGNED NOT NULL,
  `estado` char(1) NOT NULL COMMENT 'N= Normal, A= Anulado, E= Eliminado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emisor`
--

CREATE TABLE `emisor` (
  `id` int(11) NOT NULL,
  `tipodoc` char(1) DEFAULT NULL,
  `ruc` char(11) DEFAULT NULL,
  `razon_social` varchar(100) DEFAULT NULL,
  `nombre_comercial` varchar(100) DEFAULT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` char(20) NOT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `lema` varchar(150) NOT NULL,
  `pais` varchar(100) DEFAULT NULL,
  `departamento` varchar(100) DEFAULT NULL,
  `provincia` varchar(100) DEFAULT NULL,
  `distrito` varchar(100) DEFAULT NULL,
  `ubigeo` char(6) DEFAULT NULL,
  `usuario_sol` varchar(20) DEFAULT NULL,
  `clave_sol` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `emisor`
--

INSERT INTO `emisor` (`id`, `tipodoc`, `ruc`, `razon_social`, `nombre_comercial`, `correo`, `telefono`, `direccion`, `lema`, `pais`, `departamento`, `provincia`, `distrito`, `ubigeo`, `usuario_sol`, `clave_sol`) VALUES
(1, '6', '10751237877', 'SYSTEM TECH SOLUCIONES TECNOLOGICOS E.I.R.L', 'SYSTEM TECH', 'systemtech.com.pe@gmail.com', '985171277', 'Jr uacali mz e lt10 boqueron padre abad ucayali', 'Solucion a tu alzance', 'PE', 'Ucayali', 'Padre Bad', 'Boqueron', '000000', 'MODDATOS', 'MODDATOS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `herramienta`
--

CREATE TABLE `herramienta` (
  `idherramienta` int(11) NOT NULL,
  `cantidad` decimal(15,2) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `serie` varchar(50) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `color` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `herramienta`
--

INSERT INTO `herramienta` (`idherramienta`, `cantidad`, `nombre`, `marca`, `modelo`, `serie`, `descripcion`, `color`, `estado`) VALUES
(1, 2.00, 'AMOLADORA', 'TRUPER', 'TRUPER', '09878647', 'ALGUNA DESCRIPCION', 'AZUL', 1),
(2, 5.00, 'MARTILLO', 'TRUPER', 'MARDOCE', '10203040', 'GRANDE', 'PLOMO', 1),
(3, 1.00, 'ESCALERA', 'ESCALA', 'ESCALA', '10203041', '5 METROS', 'PLOMO', 1),
(4, 1.00, 'COMPUTADORA', 'HP', '0987635', '10203044', 'CASE HALION', 'NEGRO', 1),
(5, 1.00, 'FURGONETA', 'VELOREX', 'VLX250', '10203046', 'TODO TERRENO', 'AZUL', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kardex`
--

CREATE TABLE `kardex` (
  `id` int(10) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `tipo` char(1) NOT NULL COMMENT 'I=Ingreso, S = Salida',
  `cantidad` int(11) NOT NULL,
  `stockanterior` int(11) NOT NULL,
  `stockactual` int(11) NOT NULL,
  `producto_id` int(10) UNSIGNED NOT NULL,
  `detallemovimiento_id` int(10) UNSIGNED NOT NULL,
  `estado` char(1) NOT NULL COMMENT 'N= Normal, A= Anulado, E= Eliminado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moneda`
--

CREATE TABLE `moneda` (
  `idmoneda` char(3) NOT NULL,
  `nombre` varchar(20) DEFAULT NULL,
  `estado` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `moneda`
--

INSERT INTO `moneda` (`idmoneda`, `nombre`, `estado`) VALUES
('PEN', 'SOLES', 1),
('USD', 'DOLARES', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento`
--

CREATE TABLE `movimiento` (
  `id` int(10) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `idtipocomprobante` char(2) NOT NULL,
  `serie` varchar(6) NOT NULL,
  `correlativo` int(11) NOT NULL,
  `fechaemision` date DEFAULT NULL,
  `comprobantecompra` varchar(50) NOT NULL,
  `seriecomprobante` varchar(6) NOT NULL,
  `numerodocumento` varchar(10) NOT NULL,
  `formapagocompra` char(10) NOT NULL,
  `persona_id` int(10) UNSIGNED NOT NULL,
  `tipomovimiento_id` int(10) UNSIGNED NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `igv` decimal(15,2) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `estado` char(1) NOT NULL COMMENT 'N= Normal, A= Anulado, E= Eliminado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opcion`
--

CREATE TABLE `opcion` (
  `idopcion` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `iconon` varchar(20) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `orden` int(11) NOT NULL,
  `categoriamenu_id` int(11) UNSIGNED NOT NULL,
  `estado` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `opcion`
--

INSERT INTO `opcion` (`idopcion`, `descripcion`, `iconon`, `url`, `orden`, `categoriamenu_id`, `estado`) VALUES
(1, 'Categorias', 'fa-tags', 'vista/Almacen/categorias.php', 2, 3, 1),
(2, 'Productos', 'fa-list', 'vista/Almacen/productos.php', 3, 3, 1),
(3, 'Perfiles', 'fa-user-lock', 'vista/Administracion/perfiles.php', 1, 2, 1),
(4, 'Usuarios', 'fa-user-circle', 'vista/Administracion/usuarios.php', 2, 2, 1),
(5, 'Clientes', 'fa-users', 'vista/Venta/clientes.php', 1, 5, 1),
(6, 'Ventas', 'fa-cart-plus', 'vista/Venta/ventas.php', 2, 5, 1),
(7, 'Inventario', 'fa-boxes', 'vista/Inventario/inventario.php', 1, 6, 1),
(8, 'Reportes', 'fa-chart-bar', 'vista/Reporte/reportes.php', 1, 7, 1),
(9, 'Asistencia', 'fa-money-bill-alt', 'vista/Personal/asistencia.php', 2, 8, 1),
(10, 'Proveedores', '', 'vista/Proveedor/adminProveedor.php', 1, 4, 1),
(11, 'Datos Empresa', NULL, 'vista/Empresa/empresa.php', 1, 1, 1),
(12, 'Galeria', NULL, 'vista/Galeria/galeria.php', 1, 10, 1),
(13, 'Trabajadores', NULL, 'vista/Personal/personal.php', 1, 8, 1),
(14, 'Compras', NULL, 'vista/Compra/adminCompra.php', 2, 4, 1),
(15, 'Adelantos', NULL, 'vista/Personal/adelanto.php', 3, 8, 1),
(16, 'Unidad Medida', NULL, 'vista/Almacen/unidad.php', 1, 3, 1),
(17, 'Lista Herramientas', NULL, 'vista/Herramientas/herramientas.php', 1, 9, 1),
(18, 'Prestamos Bienes', NULL, 'vista/Herramientas/prestamos.php', 2, 9, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `idperfil` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `estado` smallint(6) DEFAULT NULL COMMENT '0 -> INACTIVO \n1 -> ACTIVO\n2 -> ELIMINADO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`idperfil`, `nombre`, `estado`) VALUES
(1, 'SUPER ADMINISTRADOR', 1),
(2, 'ADMINISTRADOR', 1),
(3, 'VENDEDOR', 1),
(4, 'ALMACENERO', 1),
(5, 'CAJERO', 1),
(6, 'SOPORTE', 1),
(7, 'LIMPIEZA', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombres` varchar(150) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `dni` char(8) NOT NULL,
  `ruc` char(11) NOT NULL,
  `razon_social` varchar(150) NOT NULL,
  `tipopersona` char(1) NOT NULL,
  `direccion` text NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `tipocliente` char(1) NOT NULL,
  `tipoproveedor` char(1) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id`, `nombres`, `apellidos`, `dni`, `ruc`, `razon_social`, `tipopersona`, `direccion`, `telefono`, `tipocliente`, `tipoproveedor`, `estado`) VALUES
(1, '', '', '', '10751237877', 'SYSTEMKEL SA', 'E', 'Jr. Ucayali Mz.E Lt.10 Boqueron-Padre Abad-Ucayali', '985171277', 'N', 'S', 1),
(2, 'YOMILA', 'GONZALES', '12345678', '', '', 'P', 'centro poblado paujil', '987456123', 'N', 'S', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `idpersonal` int(11) NOT NULL,
  `tipodocumento_id` int(11) NOT NULL,
  `ndocumento` char(15) NOT NULL,
  `nombres` varchar(250) NOT NULL,
  `fechan` date DEFAULT NULL,
  `correo` varchar(100) NOT NULL,
  `cargo` varchar(80) NOT NULL,
  `celular` char(12) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `sueldo` decimal(15,2) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`idpersonal`, `tipodocumento_id`, `ndocumento`, `nombres`, `fechan`, `correo`, `cargo`, `celular`, `direccion`, `sueldo`, `estado`) VALUES
(1, 1, '87456123', 'Juan Lucas Mori Campos', '2000-12-02', 'lucasmoricampos@gmail.com', 'Soldador', '987654321', 'Loreto loreto loreto uacayali peru', 1500.00, 1),
(2, 1, '62250619', 'Ludy Mori Campos', '1998-10-08', 'ludy@gmail.com', 'Administrativo', '975123456', 'conta lore peru', 1800.00, 1),
(3, 6, '10751237871', 'hola mundo', '2022-12-07', 'aaaaaa', 'Ayudante', '1111', 'boqueron', 1234.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo`
--

CREATE TABLE `prestamo` (
  `idprestamo` int(11) NOT NULL,
  `personal_id` int(11) NOT NULL,
  `herramienta_id` int(11) NOT NULL,
  `fechaentrega` date NOT NULL,
  `fechadevolucion` date NOT NULL,
  `cantidad` decimal(15,2) NOT NULL,
  `observacion` varchar(150) NOT NULL,
  `estadoprestamo` varchar(50) NOT NULL,
  `observaciondev` varchar(100) DEFAULT NULL,
  `fechadevuelto` date DEFAULT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `prestamo`
--

INSERT INTO `prestamo` (`idprestamo`, `personal_id`, `herramienta_id`, `fechaentrega`, `fechadevolucion`, `cantidad`, `observacion`, `estadoprestamo`, `observaciondev`, `fechadevuelto`, `estado`) VALUES
(1, 1, 5, '2022-12-16', '2022-12-20', 2.00, 'Con 19 piezas completo', 'Devuelto', 'sin observacion', '2022-12-18', 1),
(2, 2, 4, '2022-12-19', '2022-12-19', 1.00, 'aa', 'Devuelto', 'todo ok', '2022-12-19', 1),
(3, 3, 5, '2024-11-14', '2024-11-15', 1.00, 'PERFECTO Y LIMPIO', 'Prestado', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo2`
--

CREATE TABLE `prestamo2` (
  `idprestamo` int(11) NOT NULL,
  `personal_id` int(11) NOT NULL,
  `herramienta_id` int(11) NOT NULL,
  `cantidad` decimal(15,2) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `prestamo2`
--

INSERT INTO `prestamo2` (`idprestamo`, `personal_id`, `herramienta_id`, `cantidad`, `estado`) VALUES
(1, 3, 4, 5.00, 1),
(2, 3, 4, 5.00, 1),
(3, 1, 4, 5.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idproducto` int(11) NOT NULL,
  `nombre` varchar(200) DEFAULT NULL,
  `codigobarra` varchar(100) DEFAULT NULL,
  `pventa` decimal(15,2) DEFAULT NULL,
  `pcompra` decimal(15,2) DEFAULT NULL,
  `stock` decimal(15,2) DEFAULT NULL,
  `idunidad` char(3) DEFAULT NULL,
  `urlimagen` varchar(200) DEFAULT NULL,
  `idcategoria` int(11) DEFAULT NULL,
  `idafectacion` int(11) DEFAULT NULL,
  `afectoicbper` smallint(6) DEFAULT NULL,
  `estado` smallint(6) DEFAULT NULL,
  `stockseguridad` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idproducto`, `nombre`, `codigobarra`, `pventa`, `pcompra`, `stock`, `idunidad`, `urlimagen`, `idcategoria`, `idafectacion`, `afectoicbper`, `estado`, `stockseguridad`) VALUES
(1, 'PRODUCTO01 holaaaaaaaaaaa holaaaaaa holaaaaa ho', '0000000', 7.00, 5.00, 34.00, 'NIU', NULL, 1, 20, 0, 1, 20.00),
(2, 'PRODUCTO02', '11111111', 8.00, 6.00, 39.00, 'NIU', 'imagenes/productos/IMG_2_img_04.jpg', 1, 20, 0, 1, 20.00),
(3, 'PRODUCTO NUEVO FULL STACK', '', 15.00, 10.00, 1.00, 'PQT', 'imagenes/productos/IMG_3_login.jpg', 2, 20, 0, 1, 10.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `serie`
--

CREATE TABLE `serie` (
  `idserie` int(11) NOT NULL,
  `idtipocomprobante` char(2) DEFAULT NULL,
  `serie` varchar(6) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `estado` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `serie`
--

INSERT INTO `serie` (`idserie`, `idtipocomprobante`, `serie`, `correlativo`, `estado`) VALUES
(1, '01', 'F001', 1, 1),
(2, '01', 'F002', 0, 1),
(3, '03', 'B001', 0, 1),
(4, '03', 'B002', 0, 1),
(5, '05', '2022', 0, 1),
(6, '06', '2022', 0, 1),
(7, '02', 'P', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocomprobante`
--

CREATE TABLE `tipocomprobante` (
  `idtipocomprobante` char(2) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `estado` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tipocomprobante`
--

INSERT INTO `tipocomprobante` (`idtipocomprobante`, `nombre`, `estado`) VALUES
('01', 'FACTURA', 1),
('02', 'PROFORMA ', 1),
('03', 'BOLETA', 1),
('05', 'COMPRA', 1),
('06', 'COTIZACION', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipodocumento`
--

CREATE TABLE `tipodocumento` (
  `idtipodocumento` char(1) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `estado` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tipodocumento`
--

INSERT INTO `tipodocumento` (`idtipodocumento`, `nombre`, `estado`) VALUES
('0', 'SIN DOCUMENTO', 1),
('1', 'DNI', 1),
('4', 'CARNET DE EXTRANJERIA', 1),
('6', 'RUC', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad`
--

CREATE TABLE `unidad` (
  `idunidad` char(3) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `estado` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `unidad`
--

INSERT INTO `unidad` (`idunidad`, `descripcion`, `estado`) VALUES
('BOX', 'CAJA', 1),
('HL', 'HOLA C', 1),
('KGM', 'KILOGRAMO', 1),
('MIL', 'MILLAR', 1),
('NIU', 'UNIDAD', 1),
('PQT', 'PAQUETE', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `clave` text DEFAULT NULL,
  `idperfil` int(11) NOT NULL,
  `estado` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `usuario`, `clave`, `idperfil`, `estado`) VALUES
(1, 'Kelvin RF', 'admin', '7e957d9933fff5a06e8b37d6e57a682bc121da9a', 1, 1),
(2, 'LUDY CAMPOS', 'LUCAMPOS', '2d53e2f319eb818957d761e025487640f2979626', 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `idventa` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `idtipocomprobante` char(2) DEFAULT NULL,
  `serie` varchar(6) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `total` decimal(15,2) DEFAULT NULL,
  `total_gravado` decimal(15,2) DEFAULT NULL,
  `total_exonerado` decimal(15,2) DEFAULT NULL,
  `total_inafecto` decimal(15,2) DEFAULT NULL,
  `total_igv` decimal(15,2) DEFAULT NULL,
  `total_icbper` decimal(15,2) DEFAULT NULL,
  `total_descuento` decimal(15,2) DEFAULT NULL,
  `formapago` char(1) DEFAULT NULL,
  `idmoneda` char(3) DEFAULT NULL,
  `vencimiento` date DEFAULT NULL,
  `guiaremision` varchar(20) DEFAULT NULL,
  `ordencompra` varchar(20) DEFAULT NULL,
  `modalidad` varchar(60) NOT NULL,
  `tipocontrato` varchar(60) NOT NULL,
  `tiempocuotas` varchar(60) NOT NULL,
  `tiempoentrega` varchar(100) NOT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `estado` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`idventa`, `fecha`, `idcliente`, `idtipocomprobante`, `serie`, `correlativo`, `total`, `total_gravado`, `total_exonerado`, `total_inafecto`, `total_igv`, `total_icbper`, `total_descuento`, `formapago`, `idmoneda`, `vencimiento`, `guiaremision`, `ordencompra`, `modalidad`, `tipocontrato`, `tiempocuotas`, `tiempoentrega`, `idusuario`, `estado`) VALUES
(1, '2022-12-10', 5, '02', 'P', 1, 30.00, 0.00, 30.00, 0.00, 0.00, 0.00, 0.00, 'C', 'PEN', '0000-00-00', '', '', 'TODO COSTO', 'SALDO CONTRA ENTREGA', '0', '15 DIAS', 1, 1),
(2, '2022-12-10', 5, '02', 'P', 2, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'C', 'PEN', '0000-00-00', '', '', 'TODO COSTO', 'CUOTAS', 'SEMANAL', '15 DIAS', 1, 1),
(3, '2024-11-14', 7, '01', 'F001', 1, 30.00, 0.00, 30.00, 0.00, 0.00, 0.00, 0.00, 'C', 'PEN', '0000-00-00', '', '', 'TODO COSTO', 'SALDO CONTRA ENTREGA', '0', '20dias', 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acceso`
--
ALTER TABLE `acceso`
  ADD PRIMARY KEY (`idperfil`,`idopcion`) USING BTREE;

--
-- Indices de la tabla `adelanto`
--
ALTER TABLE `adelanto`
  ADD PRIMARY KEY (`idadelanto`);

--
-- Indices de la tabla `afectacion`
--
ALTER TABLE `afectacion`
  ADD PRIMARY KEY (`idafectacion`) USING BTREE;

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`idasistencia`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcategoria`) USING BTREE;

--
-- Indices de la tabla `categoriamenu`
--
ALTER TABLE `categoriamenu`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`) USING BTREE;

--
-- Indices de la tabla `detalle`
--
ALTER TABLE `detalle`
  ADD PRIMARY KEY (`iddetalle`) USING BTREE;

--
-- Indices de la tabla `detallemovimiento`
--
ALTER TABLE `detallemovimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `movimiento_id` (`movimiento_id`);

--
-- Indices de la tabla `emisor`
--
ALTER TABLE `emisor`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `herramienta`
--
ALTER TABLE `herramienta`
  ADD PRIMARY KEY (`idherramienta`);

--
-- Indices de la tabla `kardex`
--
ALTER TABLE `kardex`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `detallemovimiento_id` (`detallemovimiento_id`);

--
-- Indices de la tabla `moneda`
--
ALTER TABLE `moneda`
  ADD PRIMARY KEY (`idmoneda`) USING BTREE;

--
-- Indices de la tabla `movimiento`
--
ALTER TABLE `movimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `persona_id` (`persona_id`),
  ADD KEY `tipomovimiento_id` (`tipomovimiento_id`);

--
-- Indices de la tabla `opcion`
--
ALTER TABLE `opcion`
  ADD PRIMARY KEY (`idopcion`) USING BTREE;

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`idperfil`) USING BTREE;

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`idpersonal`);

--
-- Indices de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD PRIMARY KEY (`idprestamo`);

--
-- Indices de la tabla `prestamo2`
--
ALTER TABLE `prestamo2`
  ADD PRIMARY KEY (`idprestamo`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idproducto`) USING BTREE;

--
-- Indices de la tabla `serie`
--
ALTER TABLE `serie`
  ADD PRIMARY KEY (`idserie`) USING BTREE;

--
-- Indices de la tabla `tipocomprobante`
--
ALTER TABLE `tipocomprobante`
  ADD PRIMARY KEY (`idtipocomprobante`) USING BTREE;

--
-- Indices de la tabla `tipodocumento`
--
ALTER TABLE `tipodocumento`
  ADD PRIMARY KEY (`idtipodocumento`) USING BTREE;

--
-- Indices de la tabla `unidad`
--
ALTER TABLE `unidad`
  ADD PRIMARY KEY (`idunidad`) USING BTREE;

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`) USING BTREE;

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`idventa`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `adelanto`
--
ALTER TABLE `adelanto`
  MODIFY `idadelanto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `idasistencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `categoriamenu`
--
ALTER TABLE `categoriamenu`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `detalle`
--
ALTER TABLE `detalle`
  MODIFY `iddetalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `detallemovimiento`
--
ALTER TABLE `detallemovimiento`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `emisor`
--
ALTER TABLE `emisor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `herramienta`
--
ALTER TABLE `herramienta`
  MODIFY `idherramienta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `kardex`
--
ALTER TABLE `kardex`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movimiento`
--
ALTER TABLE `movimiento`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `opcion`
--
ALTER TABLE `opcion`
  MODIFY `idopcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `idperfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `idpersonal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  MODIFY `idprestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `prestamo2`
--
ALTER TABLE `prestamo2`
  MODIFY `idprestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `serie`
--
ALTER TABLE `serie`
  MODIFY `idserie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `idventa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
