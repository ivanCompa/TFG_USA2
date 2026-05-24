-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 24-05-2026 a las 23:04:38
-- Versión del servidor: 8.0.46
-- Versión de PHP: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `usa2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`) VALUES
(1, 'Electrónica'),
(2, 'Hogar'),
(3, 'Bricolaje'),
(4, 'Juguetes'),
(5, 'Moda'),
(6, 'Libros'),
(7, 'Otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `carrito_id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `producto_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `notificacion_id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `comprador_id` int DEFAULT NULL,
  `mensaje` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP,
  `leida` tinyint(1) DEFAULT '0',
  `tipo` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'normal',
  `extra_id` int DEFAULT NULL,
  `procesada` tinyint(1) NOT NULL DEFAULT '0',
  `estado` enum('pendiente','aceptada','rechazada') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`notificacion_id`, `usuario_id`, `comprador_id`, `mensaje`, `fecha`, `leida`, `tipo`, `extra_id`, `procesada`, `estado`) VALUES
(83, 6, 3, 'Ivan está solicitando la compra de tu producto: Teclado Mecánico', '2026-05-22 18:25:53', 1, 'solicitud', 8, 1, 'aceptada'),
(84, 3, 3, 'Has solicitado la compra del producto: Teclado Mecánico', '2026-05-22 18:25:53', 1, 'info', 8, 1, 'aceptada'),
(85, 3, 3, 'Tu solicitud para comprar \'Teclado Mecánico\' ha sido aceptada. Pulsa para proceder al pago.', '2026-05-22 18:31:17', 1, 'pago', 8, 0, 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `pedido_id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `fecha_pedido` datetime DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('Pendiente','Pagado','Enviado','Completado','Cancelado') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `producto_id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `estado` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_publicacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `categoria_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`producto_id`, `usuario_id`, `titulo`, `descripcion`, `precio`, `estado`, `imagen`, `fecha_publicacion`, `categoria_id`) VALUES
(1, 6, 'Tacones', 'Tacones elegantes en buen estado', 12.00, 'Nuevo', 'tacones.jpg', '2026-02-12 12:48:40', 5),
(2, 6, 'Balón', 'Balón de fútbol talla 5', 6.00, 'Usado', 'balon.jpg', '2026-02-12 12:48:40', 4),
(3, 6, 'Ratón', 'Ratón inalámbrico USB', 15.00, 'Nuevo', 'raton.jpg', '2026-02-12 12:48:40', 1),
(4, 3, 'Herramientas', 'Kit de herramientas básico', 12.00, 'Usado', 'herramientas.jpg', '2026-02-12 12:48:40', 3),
(5, 6, 'Auriculares Bluetooth', 'Auriculares inalámbricos con cancelación de ruido', 18.00, 'Nuevo', 'auriculares.jpg', '2026-03-09 18:08:13', 1),
(6, 6, 'Sudadera Nike', 'Sudadera Nike talla M en perfecto estado', 20.00, 'Como nuevo', 'sudadera_nike.jpg', '2026-03-09 18:08:13', 5),
(8, 6, 'Teclado Mecánico', 'Teclado mecánico RGB switches rojos', 25.00, 'Nuevo', 'teclado_mecanico.jpg', '2026-03-09 18:08:13', 1),
(9, 6, 'Cámara Deportiva', 'Cámara tipo GoPro con accesorios', 30.00, 'Usado', 'camara_deportiva.jpg', '2026-03-09 18:08:13', 1),
(10, 6, 'Chaqueta de cuero', 'Chaqueta de cuero auténtico talla L', 35.00, 'Usado', 'chaqueta_cuero.jpg', '2026-03-09 18:08:13', 5),
(11, 6, 'Patinete infantil', 'Patinete plegable para niños', 12.00, 'Buen estado', 'patinete.jpg', '2026-03-09 18:08:13', 4),
(12, 6, 'Monitor 24 pulgadas', 'Monitor Full HD 1080p', 45.00, 'Usado', 'monitor24.jpg', '2026-03-09 18:08:13', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productoimagen`
--

CREATE TABLE `productoimagen` (
  `imagen_id` int NOT NULL,
  `producto_id` int NOT NULL,
  `ruta` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productoimagen`
--

INSERT INTO `productoimagen` (`imagen_id`, `producto_id`, `ruta`) VALUES
(1, 1, 'tacones_1.jpg'),
(2, 1, 'tacones_2.jpg'),
(3, 1, 'tacones_3.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `contraseña` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `codigo_postal` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipo_usuario` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Estandar',
  `imagen` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `nombre`, `email`, `contraseña`, `codigo_postal`, `tipo_usuario`, `imagen`) VALUES
(1, 'Admin', 'admin@usa2.com', '$2y$10$0LfO4filSr/ucs5HyopoGu3FAZVvX6Vf2SttSJGvYu5ZVUHPD9saS', '31231', 'Administrador', 'pfp_Anonymous.jpg'),
(3, 'Ivan', 'icompa@gmail.com', '$2y$10$dLTmpjtrc3ksuIQa2EvhUuiVuDx.2ZWbpl41L/LDUDU5nAnELMEdu', '31230', 'Estandar', '1772448343_Sky_spyro2.webp'),
(6, 'David', 'dcompa@gmail.com', '$2y$10$fMcdVaP.rf33ISKhUFIPHOa7658NQBcOlTv36XOcae4vxwUy80Kfu', '31230', 'Estandar', 'pfp_Anonymous.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`carrito_id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`notificacion_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`pedido_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`producto_id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `fk_producto_categoria` (`categoria_id`);

--
-- Indices de la tabla `productoimagen`
--
ALTER TABLE `productoimagen`
  ADD PRIMARY KEY (`imagen_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `carrito_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `notificacion_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `pedido_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `producto_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `productoimagen`
--
ALTER TABLE `productoimagen`
  MODIFY `imagen_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `favoritos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`),
  ADD CONSTRAINT `favoritos_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`producto_id`);

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productoimagen`
--
ALTER TABLE `productoimagen`
  ADD CONSTRAINT `productoimagen_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`producto_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
