-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-03-2025 a las 02:01:16
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
-- Base de datos: `laylist`
--
CREATE DATABASE IF NOT EXISTS `laylist` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `laylist`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

DROP TABLE IF EXISTS `tareas`;
CREATE TABLE `tareas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `completada` tinyint(1) DEFAULT 0,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `tareas`:
--   `usuario_id`
--       `usuarios` -> `id`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `foto_perfil` varchar(255) DEFAULT 'IMG/default_perfil.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `usuarios`:
--

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` VALUES(5, 'Adriana Bonilla', 'email@email.com', '$2y$10$zsQaEQAbrkvPEpML63F0Ke6dVpD5n2jgj8s2w2mw6Iz1V4QVN.8nS', NULL, '2025-03-01 23:18:03', 'IMG/default_perfil.jpg');
INSERT INTO `usuarios` VALUES(16, 'Mimi', 'mimi@gmail.com', '$2y$10$hypZats23xN3iGtyNJ0n0.qacfTdxgUIaK8Bnu0IAm6MLTnmkOrrm', NULL, '2025-03-02 00:04:07', 'IMG/perfil_16.jpg');
INSERT INTO `usuarios` VALUES(19, 'Cari', 'cari@gmail.com', '$2y$10$0.2LZ7R4iF2FeGSc2/P/puNp9NLnWxfBVflJuuYgnxfTk.4XgA3qq', NULL, '2025-03-02 00:26:11', 'IMG/perfil_19.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
