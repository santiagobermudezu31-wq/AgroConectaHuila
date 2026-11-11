-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 11-11-2026 a las 02:32:40
-- Versión del servidor: 8.4.7
-- Versión de PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `agroconecta_huila`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aceptacion_politicas`
--

DROP TABLE IF EXISTS `aceptacion_politicas`;
CREATE TABLE IF NOT EXISTS `aceptacion_politicas` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario_id` int UNSIGNED NOT NULL,
  `tipo_politica` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version_politica` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_aceptacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_aceptacion_usuario` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `aceptacion_politicas`
--

INSERT INTO `aceptacion_politicas` (`id`, `usuario_id`, `tipo_politica`, `version_politica`, `fecha_aceptacion`) VALUES
(1, 2, 'tratamiento_datos', '1.0', '2026-11-10 03:32:14'),
(2, 3, 'tratamiento_datos', '1.0', '2026-11-10 04:27:51'),
(3, 4, 'tratamiento_datos', '1.0', '2026-11-10 04:27:51'),
(4, 5, 'tratamiento_datos', '1.0', '2026-11-10 04:27:51'),
(5, 6, 'tratamiento_datos', '1.0', '2026-11-10 04:27:51'),
(6, 7, 'tratamiento_datos', '1.0', '2026-11-10 04:27:51'),
(7, 8, 'tratamiento_datos', '1.0', '2026-11-10 04:27:51'),
(8, 9, 'tratamiento_datos', '1.0', '2026-11-10 04:27:51'),
(9, 10, 'tratamiento_datos', '1.0', '2026-11-10 04:27:51'),
(10, 11, 'tratamiento_datos', '1.0', '2026-11-10 04:27:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` enum('activa','inactiva') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activa',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `imagen`, `estado`, `fecha_creacion`) VALUES
(1, 'Café y derivados', 'Café especial, molido, tostado y derivados del café.', NULL, 'activa', '2026-11-10 03:00:03'),
(2, 'Frutas y productos agrícolas', 'Frutas frescas y productos agrícolas de la región.', NULL, 'activa', '2026-11-10 03:00:03'),
(3, 'Productos agrícolas transformados', 'Panela, mermeladas, procesados y artesanales.', NULL, 'activa', '2026-11-10 03:00:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuraciones`
--

DROP TABLE IF EXISTS `configuraciones`;
CREATE TABLE IF NOT EXISTS `configuraciones` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `clave` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` text COLLATE utf8mb4_unicode_ci,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clave` (`clave`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_publicaciones`
--

DROP TABLE IF EXISTS `historial_publicaciones`;
CREATE TABLE IF NOT EXISTS `historial_publicaciones` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `producto_id` int UNSIGNED NOT NULL,
  `usuario_id` int UNSIGNED NOT NULL,
  `accion` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `fecha_accion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_historial_usuario` (`usuario_id`),
  KEY `idx_historial_producto` (`producto_id`,`fecha_accion`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `historial_publicaciones`
--

INSERT INTO `historial_publicaciones` (`id`, `producto_id`, `usuario_id`, `accion`, `descripcion`, `fecha_accion`) VALUES
(1, 1, 2, 'crear', 'Producto creado', '2026-11-10 03:37:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_productos`
--

DROP TABLE IF EXISTS `imagenes_productos`;
CREATE TABLE IF NOT EXISTS `imagenes_productos` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `producto_id` int UNSIGNED NOT NULL,
  `url_imagen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `es_principal` tinyint(1) NOT NULL DEFAULT '0',
  `orden` int NOT NULL DEFAULT '0',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_imagenes_producto` (`producto_id`,`orden`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `imagenes_productos`
--

INSERT INTO `imagenes_productos` (`id`, `producto_id`, `url_imagen`, `es_principal`, `orden`, `fecha_creacion`) VALUES
(1, 1, 'storage/uploads/products/e13e39e9dd9ccb262206102cdef66463.webp', 1, 0, '2026-11-10 03:37:03'),
(2, 2, 'storage\\uploads\\products\\Café molido tostado.webp', 2, 0, '2026-11-11 02:04:57'),
(3, 3, 'storage\\uploads\\products\\Café en grano tostado.webp', 3, 0, '2026-11-11 02:07:28'),
(4, 4, 'storage\\uploads\\products\\CAFELAESPERANZA125GR_1800x1800.webp', 4, 0, '2026-11-11 02:14:25'),
(5, 5, 'storage\\uploads\\products\\Café tostado en grano.webp', 5, 0, '2026-11-11 02:15:35'),
(6, 6, 'storage\\uploads\\products\\MORA DE CASTILLA.jpg', 6, 0, '2026-11-11 02:25:50'),
(7, 7, 'storage\\uploads\\products\\Mora sin espinas.jpg', 7, 0, '2026-11-11 02:24:57'),
(8, 8, 'storage\\uploads\\products\\Mermelada de mora.jpg', 8, 0, '2026-11-11 02:32:00'),
(9, 9, 'storage\\uploads\\products\\Mermelada de guayaba.jpg', 9, 0, '2026-11-11 02:31:02'),
(10, 10, 'storage\\uploads\\products\\Aguacate Hass.jpg', 10, 0, '2026-11-11 02:23:52'),
(11, 11, 'storage\\uploads\\products\\AGUACATE-PAPELILLO.jpg', 11, 0, '2026-11-11 02:23:06'),
(12, 12, 'storage\\uploads\\products\\Granadilla.jpg', 12, 0, '2026-11-11 02:22:22'),
(13, 13, 'storage\\uploads\\products\\Granadilla extra.jpg', 13, 0, '2026-11-11 02:21:19'),
(14, 14, 'storage\\uploads\\products\\Panela pulverizada.png', 14, 0, '2026-11-11 02:30:08'),
(15, 15, 'storage\\uploads\\products\\Panela en bloque.jpg', 15, 0, '2026-11-11 02:29:24'),
(16, 16, 'storage\\uploads\\products\\Café tostado molido El Rosario.jpg', 16, 0, '2026-11-11 02:16:44'),
(17, 17, 'storage\\uploads\\products\\Naranja.jpg', 17, 0, '2026-11-10 05:34:15'),
(18, 18, 'storage\\uploads\\products\\mandarin-3835620_1280.jpg', 18, 0, '2026-11-11 02:20:14'),
(19, 19, 'storage\\uploads\\products\\limon-img-02.jpg', 19, 0, '2026-11-11 02:19:39'),
(20, 20, 'storage\\uploads\\products\\Conserva de mora.jpg', 20, 0, '2026-11-11 02:27:52'),
(21, 21, 'storage\\uploads\\products\\Salsa de tomate artesanal.jpg', 21, 0, '2026-11-11 02:26:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productores`
--

DROP TABLE IF EXISTS `productores`;
CREATE TABLE IF NOT EXISTS `productores` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario_id` int UNSIGNED NOT NULL,
  `nombre_productor` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_unidad_productiva` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zona_vereda` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `municipio` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'La Plata',
  `departamento` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Huila',
  `telefono_comercial` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mostrar_telefono` tinyint(1) NOT NULL DEFAULT '0',
  `imagen_perfil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario_id` (`usuario_id`),
  KEY `idx_productores_municipio` (`municipio`),
  KEY `idx_productores_vereda` (`zona_vereda`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productores`
--

INSERT INTO `productores` (`id`, `usuario_id`, `nombre_productor`, `nombre_unidad_productiva`, `zona_vereda`, `municipio`, `departamento`, `telefono_comercial`, `mostrar_telefono`, `imagen_perfil`, `fecha_registro`, `fecha_actualizacion`) VALUES
(1, 2, 'Carlos Alberto Muñoz', 'Finca El Porvenir', 'Vereda San Miguel', 'La Plata', 'Huila', '3201234567', 1, NULL, '2026-11-10 03:32:14', '2026-11-10 03:32:14'),
(2, 3, 'María Fernanda Rojas', 'Finca La Esperanza', 'Vereda La Esperanza', 'La Plata', 'Huila', '3112345678', 1, NULL, '2026-11-10 04:27:51', '2026-11-10 04:27:51'),
(3, 4, 'José Ignacio Perdomo', 'Finca Los Arrayanes', 'Vereda La Argentina', 'La Plata', 'Huila', '3153456789', 1, NULL, '2026-11-10 04:27:51', '2026-11-10 04:27:51'),
(4, 5, 'Luz Marina Cardozo', 'Asociación Dulce Campo', 'Vereda Monserrate', 'La Plata', 'Huila', '3184567890', 1, NULL, '2026-11-10 04:27:51', '2026-11-10 04:27:51'),
(5, 6, 'Hernán Darío Trujillo', 'Finca Aguas Claras', 'Vereda Alto Cauca', 'La Plata', 'Huila', '3125678901', 1, NULL, '2026-11-10 04:27:51', '2026-11-10 04:27:51'),
(6, 7, 'Diana Carolina Vásquez', 'Finca La Granadilla', 'Vereda La Palma', 'La Plata', 'Huila', '3206789012', 1, NULL, '2026-11-10 04:27:51', '2026-11-10 04:27:51'),
(7, 8, 'Wilson Andrés Gutiérrez', 'Trapiche El Edén', 'Vereda Bajo Horizonte', 'La Plata', 'Huila', '3137890123', 1, NULL, '2026-11-10 04:27:51', '2026-11-10 04:27:51'),
(8, 9, 'Ana Milena Quintero', 'Finca El Rosario', 'Vereda El Rosario', 'La Plata', 'Huila', '3198901234', 1, NULL, '2026-11-10 04:27:51', '2026-11-10 04:27:51'),
(9, 10, 'Pedro Antonio Cuenca', 'Finca Los Cítricos', 'Vereda Villa Nueva', 'La Plata', 'Huila', '3219012345', 1, NULL, '2026-11-10 04:27:51', '2026-11-10 04:27:51'),
(10, 11, 'Sandra Patricia Tovar', 'Delicias del Huila', 'Vereda El Pedregal', 'La Plata', 'Huila', '3100123456', 1, NULL, '2026-11-10 04:27:51', '2026-11-10 04:27:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `productor_id` int UNSIGNED NOT NULL,
  `categoria_id` int UNSIGNED NOT NULL,
  `nombre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_producto` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unidad_comercializacion` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` decimal(12,2) DEFAULT NULL,
  `disponibilidad` enum('en_stock','agotado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en_stock',
  `estado_publicacion` enum('pendiente','activo','retirado','rechazado','suspendido') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_productos_nombre` (`nombre`),
  KEY `idx_productos_categoria` (`categoria_id`),
  KEY `idx_productos_estado` (`estado_publicacion`),
  KEY `idx_productos_productor` (`productor_id`),
  KEY `idx_productos_fecha` (`fecha_creacion`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `productor_id`, `categoria_id`, `nombre`, `descripcion`, `tipo_producto`, `unidad_comercializacion`, `precio`, `disponibilidad`, `estado_publicacion`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 1, 1, 'Café especial Castillo', 'Café de altura cultivado a 1.750 msnm. Tueste medio, notas a chocolate y cítricos.', 'Café especial', 'Kilogramo', 25000.00, 'en_stock', 'activo', '2026-11-10 03:37:03', '2026-11-10 03:37:42'),
(2, 1, 1, 'Café molido tostado', 'Café tostado y molido listo para preparar. Bolsa de 500 g.', 'Café molido', 'Bolsa', 22000.00, 'en_stock', 'activo', '2026-11-10 04:29:02', '2026-11-10 04:29:02'),
(3, 1, 1, 'Café en grano tostado', 'Grano entero tostado, conserva mejor el aroma. 1 kg.', 'Café tostado', 'Kilogramo', 30000.00, 'en_stock', 'activo', '2026-11-10 04:29:02', '2026-11-10 04:29:02'),
(4, 2, 1, 'Café especial de La Esperanza', 'Lote limitado, proceso honey. Taza balanceada con cuerpo sedoso.', 'Café especial', 'Kilogramo', 28000.00, 'en_stock', 'activo', '2026-11-10 04:29:02', '2026-11-10 04:29:02'),
(5, 2, 1, 'Café tostado en grano', 'Tueste medio-alto ideal para espresso. 1 kg.', 'Café tostado', 'Kilogramo', 27000.00, 'en_stock', 'activo', '2026-11-10 04:29:02', '2026-11-10 04:29:35'),
(6, 3, 2, 'Mora castilla', 'Mora fresca cosechada a diario. Ideal para jugos y postres.', 'Mora', 'Kilogramo', 6000.00, 'en_stock', 'activo', '2026-11-10 04:29:02', '2026-11-10 04:29:02'),
(7, 3, 2, 'Mora sin espinas', 'Variedad mejorada, más dulce y con mayor rendimiento.', 'Mora', 'Kilogramo', 7000.00, 'en_stock', 'activo', '2026-11-10 04:29:02', '2026-11-10 04:29:02'),
(8, 4, 3, 'Mermelada de mora', 'Mermelada artesanal 100% natural. Frasco de 250 g.', 'Mermeladas', 'Frasco', 12000.00, 'en_stock', 'activo', '2026-11-10 04:29:02', '2026-11-10 04:29:02'),
(9, 4, 3, 'Mermelada de guayaba', 'Receta tradicional del Huila. Frasco de 250 g.', 'Mermeladas', 'Frasco', 11000.00, 'en_stock', 'activo', '2026-11-10 04:29:02', '2026-11-10 04:29:02'),
(10, 5, 2, 'Aguacate Hass', 'Aguacate Hass de excelente calidad. Cosecha semanal.', 'Aguacate', 'Kilogramo', 5500.00, 'en_stock', 'activo', '2026-11-10 04:29:02', '2026-11-10 04:29:02'),
(11, 5, 2, 'Aguacate papelillo', 'Variedad criolla, textura cremosa y sabor suave.', 'Aguacate', 'Kilogramo', 4000.00, 'agotado', 'activo', '2026-11-10 04:29:02', '2026-11-10 04:29:02'),
(12, 6, 2, 'Granadilla', 'Granadilla fresca, dulce y aromática. Caja de 5 kg.', 'Granadilla', 'Caja', 22000.00, 'en_stock', 'activo', '2026-11-10 04:29:02', '2026-11-10 04:29:02'),
(13, 6, 2, 'Granadilla extra', 'Frutos grandes de exportación. Caja de 5 kg.', 'Granadilla', 'Caja', 25000.00, 'en_stock', 'activo', '2026-11-10 04:29:02', '2026-11-10 04:29:30'),
(14, 7, 3, 'Panela pulverizada', 'Panela 100% de caña, sin blanqueadores. Bolsa de 1 kg.', 'Panela', 'Bolsa', 4000.00, 'en_stock', 'activo', '2026-11-10 04:29:02', '2026-11-10 04:29:02'),
(15, 7, 3, 'Panela en bloque', 'Bloque tradicional de 500 g. Trapiche artesanal.', 'Panela', 'Unidad', 3500.00, 'en_stock', 'activo', '2026-11-10 04:29:02', '2026-11-10 04:29:02'),
(16, 8, 1, 'Café tostado molido El Rosario', 'Bolsa de 500 g. Tueste medio, ideal para prensa francesa.', 'Café molido', 'Bolsa', 24000.00, 'en_stock', 'activo', '2026-11-10 04:29:02', '2026-11-10 04:29:02'),
(17, 9, 2, 'Naranja Valencia', 'Naranja dulce para jugo. Cosecha de la semana.', 'Cítricos', 'Kilogramo', 2500.00, 'en_stock', 'activo', '2026-11-10 04:29:02', '2026-11-10 05:24:42'),
(18, 9, 2, 'Mandarina', 'Mandarina jugosa, sin semilla.', 'Cítricos', 'Kilogramo', 3000.00, 'en_stock', 'activo', '2026-11-10 04:29:02', '2026-11-10 05:14:29'),
(19, 9, 2, 'Limón Tahití', 'Limón grande, cáscara fina, muy jugoso.', 'Cítricos', 'Libra', 3500.00, 'en_stock', 'activo', '2026-11-10 04:29:02', '2026-11-10 05:14:32'),
(20, 10, 3, 'Conserva de mora', 'Conserva artesanal de mora con panela. Frasco de 300 g.', 'Productos procesados', 'Frasco', 14000.00, 'en_stock', 'activo', '2026-11-10 04:29:02', '2026-11-10 04:29:02'),
(21, 10, 3, 'Salsa de tomate artesanal', 'Salsa casera de tomate chonto, albahaca y especias. Frasco de 350 g.', 'Productos procesados', 'Frasco', 10000.00, 'en_stock', 'activo', '2026-11-10 04:29:02', '2026-11-10 04:29:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recuperacion_password`
--

DROP TABLE IF EXISTS `recuperacion_password`;
CREATE TABLE IF NOT EXISTS `recuperacion_password` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario_id` int UNSIGNED NOT NULL,
  `token_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_expiracion` datetime NOT NULL,
  `usado` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_recuperacion_token` (`token_hash`),
  KEY `idx_recuperacion_usuario` (`usuario_id`,`usado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rol` enum('administrador','productor') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'productor',
  `estado` enum('activo','suspendido','pendiente') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  UNIQUE KEY `correo` (`correo`),
  KEY `idx_usuarios_correo` (`correo`),
  KEY `idx_usuarios_usuario` (`nombre_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_usuario`, `correo`, `password_hash`, `rol`, `estado`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'admin', 'admin@agroconectahuila.local', '$2y$10$gaOMAsFW2tV256m/hhIHqOMA0PnQ61KGiBExxPQHjNVQnUesvF20G', 'administrador', 'activo', '2026-11-10 03:22:55', '2026-11-10 03:22:55'),
(2, 'carlos.munoz', 'carlos.munoz@gmail.com', '$2y$10$bTt467JTOmDVFItuoyFnb.oiW/cn0b6So9KNdU7iFl7Bc8pcdQPpS', 'productor', 'activo', '2026-11-10 03:32:14', '2026-11-10 03:32:14'),
(3, 'maria.rojas', 'maria.rojas@agroconecta.local', '$2y$10$GE0CMHMg5iIDz/MHDBDLkOA4oTyphkjkmja/ks3yW6StE8djaENHy', 'productor', 'activo', '2026-11-10 04:27:51', '2026-11-10 04:27:51'),
(4, 'jose.perdomo', 'jose.perdomo@agroconecta.local', '$2y$10$GE0CMHMg5iIDz/MHDBDLkOA4oTyphkjkmja/ks3yW6StE8djaENHy', 'productor', 'activo', '2026-11-10 04:27:51', '2026-11-10 04:27:51'),
(5, 'luz.cardozo', 'luz.cardozo@agroconecta.local', '$2y$10$GE0CMHMg5iIDz/MHDBDLkOA4oTyphkjkmja/ks3yW6StE8djaENHy', 'productor', 'activo', '2026-11-10 04:27:51', '2026-11-10 04:27:51'),
(6, 'hernan.trujillo', 'hernan.trujillo@agroconecta.local', '$2y$10$GE0CMHMg5iIDz/MHDBDLkOA4oTyphkjkmja/ks3yW6StE8djaENHy', 'productor', 'activo', '2026-11-10 04:27:51', '2026-11-10 04:27:51'),
(7, 'diana.vasquez', 'diana.vasquez@agroconecta.local', '$2y$10$GE0CMHMg5iIDz/MHDBDLkOA4oTyphkjkmja/ks3yW6StE8djaENHy', 'productor', 'activo', '2026-11-10 04:27:51', '2026-11-10 04:27:51'),
(8, 'wilson.gutierrez', 'wilson.gutierrez@agroconecta.local', '$2y$10$GE0CMHMg5iIDz/MHDBDLkOA4oTyphkjkmja/ks3yW6StE8djaENHy', 'productor', 'activo', '2026-11-10 04:27:51', '2026-11-10 04:27:51'),
(9, 'ana.quintero', 'ana.quintero@agroconecta.local', '$2y$10$GE0CMHMg5iIDz/MHDBDLkOA4oTyphkjkmja/ks3yW6StE8djaENHy', 'productor', 'activo', '2026-11-10 04:27:51', '2026-11-10 04:27:51'),
(10, 'pedro.cuenca', 'pedro.cuenca@agroconecta.local', '$2y$10$GE0CMHMg5iIDz/MHDBDLkOA4oTyphkjkmja/ks3yW6StE8djaENHy', 'productor', 'activo', '2026-11-10 04:27:51', '2026-11-10 04:27:51'),
(11, 'sandra.tovar', 'sandra.tovar@agroconecta.local', '$2y$10$GE0CMHMg5iIDz/MHDBDLkOA4oTyphkjkmja/ks3yW6StE8djaENHy', 'productor', 'activo', '2026-11-10 04:27:51', '2026-11-10 04:27:51');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aceptacion_politicas`
--
ALTER TABLE `aceptacion_politicas`
  ADD CONSTRAINT `fk_aceptacion_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `historial_publicaciones`
--
ALTER TABLE `historial_publicaciones`
  ADD CONSTRAINT `fk_historial_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_historial_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `imagenes_productos`
--
ALTER TABLE `imagenes_productos`
  ADD CONSTRAINT `fk_imagenes_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productores`
--
ALTER TABLE `productores`
  ADD CONSTRAINT `fk_productores_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_productos_productor` FOREIGN KEY (`productor_id`) REFERENCES `productores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `recuperacion_password`
--
ALTER TABLE `recuperacion_password`
  ADD CONSTRAINT `fk_recuperacion_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
