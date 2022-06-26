-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Creación de Base de datos: `cotizaciones`
--
CREATE DATABASE IF NOT EXISTS `cotizaciones` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cotizaciones`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ajustes`
--

CREATE TABLE `ajustes` (
  `idUsuario` bigint(20) UNSIGNED NOT NULL,
  `remitente` varchar(100) DEFAULT NULL,
  `mensajePresentacion` varchar(512) DEFAULT NULL,
  `mensajeAgradecimiento` varchar(512) DEFAULT NULL,
  `mensajePie` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caracteristicas_cotizaciones`
--

CREATE TABLE `caracteristicas_cotizaciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idCotizacion` bigint(20) UNSIGNED NOT NULL,
  `caracteristica` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idUsuario` bigint(20) UNSIGNED NOT NULL,
  `identificacion` varchar(13) NOT NULL,
  `razonSocial` varchar(255) NOT NULL,
  `direccion` varchar(80) NOT NULL,
  `celular` varchar(15) NOT NULL,
  `correo` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones`
--

CREATE TABLE `cotizaciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idUsuario` bigint(20) UNSIGNED NOT NULL,
  `idCliente` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones_detalle`
--

CREATE TABLE `cotizaciones_detalle` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_cotizacion` bigint(20) UNSIGNED NOT NULL,
  `id_producto` bigint(20) UNSIGNED NOT NULL,
  `costo_unitario` double NOT NULL,
  `cantidad` int(11) UNSIGNED NOT NULL,
  `costo_total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parameters`
--

CREATE TABLE `parameters` (
  `id` bigint(20) NOT NULL,
  `nemonico` varchar(20) NOT NULL,
  `descripcion` varchar(80) NOT NULL,
  `tipo` varchar(1) NOT NULL,
  `valorInt` int(11) NOT NULL,
  `valorChar` varchar(20) NOT NULL,
  `valorFloat` float NOT NULL,
  `valorDate` date NOT NULL,
  `valorNum` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla de parámetros';

--
-- Volcado de datos para la tabla `parameters`
--

INSERT INTO `parameters` (`id`, `nemonico`, `descripcion`, `tipo`, `valorInt`, `valorChar`, `valorFloat`, `valorDate`, `valorNum`) VALUES
(1, 'IVA', 'VALOR DEL IVA', 'N', 0, '', 0, '0000-00-00', 0.12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `valor` double NOT NULL,
  `calculaIva` varchar(2) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesiones`
--

CREATE TABLE `sesiones` (
  `id` varchar(255) NOT NULL,
  `datos` text NOT NULL,
  `ultimo_acceso` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `correo` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Creación de indices --------------------------------------
--
-- Indices de la tabla `ajustes`
--
ALTER TABLE `ajustes`
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `caracteristicas_cotizaciones`
--
ALTER TABLE `caracteristicas_cotizaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCotizacion` (`idCotizacion`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCliente` (`idCliente`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `cotizaciones_detalle`
--
ALTER TABLE `cotizaciones_detalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCotizacion` (`id_cotizacion`),
  ADD KEY `idProducto` (`id_producto`) USING BTREE;

--
-- Indices de la tabla `parameters`
--
ALTER TABLE `parameters`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `servicios_cotizaciones`
--
ALTER TABLE `servicios_cotizaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCotizacion` (`idCotizacion`);

--
-- Indices de la tabla `sesiones`
--
ALTER TABLE `sesiones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas 
--

--
-- AUTO_INCREMENT de la tabla `caracteristicas_cotizaciones`
--
ALTER TABLE `caracteristicas_cotizaciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cotizaciones_detalle`
--
ALTER TABLE `cotizaciones_detalle`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `parameters`
--
ALTER TABLE `parameters`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas 
--

--
-- Filtros para la tabla `ajustes`
--
ALTER TABLE `ajustes`
  ADD CONSTRAINT `ajustes_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `caracteristicas_cotizaciones`
--
ALTER TABLE `caracteristicas_cotizaciones`
  ADD CONSTRAINT `caracteristicas_cotizaciones_ibfk_1` FOREIGN KEY (`idCotizacion`) REFERENCES `cotizaciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD CONSTRAINT `cotizaciones_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cotizaciones_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cotizaciones_detalle`
--
ALTER TABLE `cotizaciones_detalle`
  ADD CONSTRAINT `cotizaciones_detalle_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `cotizaciones_detalle_ibfk_2` FOREIGN KEY (`id_cotizacion`) REFERENCES `cotizaciones` (`id`);
COMMIT;


