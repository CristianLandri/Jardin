-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-10-2025 a las 18:32:03
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
-- Base de datos: `jardin_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

CREATE TABLE `docentes` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `docentes`
--

INSERT INTO `docentes` (`id`, `usuario`, `contrasena`) VALUES
(1, 'Docente1', '$2y$10$XSjRMvfmNt1Wc1qbGkbBH.jLDL/1U7xRrECdNi5YWWsPCLEfhEP/W'),
(2, 'Docente2', '$2y$10$Y0cnkvVxwWI0Ez6FVOMCEesjmPiFO0utMYtCdeqGAemlkEGls8g9i');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntos`
--

CREATE TABLE `puntos` (
  `id` int(11) NOT NULL,
  `nombre_alumno` varchar(100) NOT NULL,
  `puntos` int(11) DEFAULT 0,
  `ultima_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `puntos`
--

INSERT INTO `puntos` (`id`, `nombre_alumno`, `puntos`, `ultima_actualizacion`) VALUES
(3, 'Matias', 20, '2025-10-15 23:50:24'),
(4, 'Matias', 30, '2025-10-15 23:50:25'),
(5, 'Matias', 40, '2025-10-15 23:50:26'),
(6, 'Matias', 50, '2025-10-15 23:50:28'),
(7, 'Matias', 60, '2025-10-15 23:50:28'),
(8, 'Matias', 70, '2025-10-15 23:50:29'),
(9, 'Matias', 80, '2025-10-15 23:50:29'),
(10, 'Matias', 100, '2025-10-15 23:50:29'),
(11, 'Matias', 100, '2025-10-15 23:50:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros_docentes`
--

CREATE TABLE `registros_docentes` (
  `id` int(11) NOT NULL,
  `docente_id` int(11) DEFAULT NULL,
  `hora_entrada` datetime DEFAULT NULL,
  `hora_salida` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registros_docentes`
--

INSERT INTO `registros_docentes` (`id`, `docente_id`, `hora_entrada`, `hora_salida`) VALUES
(8, 2, '2025-10-07 20:52:38', NULL),
(9, 2, '2025-10-07 20:59:21', NULL),
(10, 2, '2025-10-07 21:02:46', NULL),
(11, 2, '2025-10-07 21:12:00', NULL),
(12, 2, '2025-10-08 16:18:04', NULL),
(13, 2, '2025-10-10 17:43:17', NULL),
(14, 2, '2025-10-10 18:22:39', NULL),
(15, 2, '2025-10-13 02:36:15', NULL),
(16, 1, '2025-10-13 02:37:13', NULL),
(17, 2, '2025-10-15 01:13:07', NULL),
(18, 2, '2025-10-15 01:40:06', NULL),
(19, 2, '2025-10-15 03:21:14', NULL),
(20, 2, '2025-10-15 03:22:51', NULL),
(21, 2, '2025-10-15 20:38:54', NULL),
(22, 1, '2025-10-15 23:22:25', NULL),
(23, 1, '2025-10-16 01:01:51', NULL),
(24, 2, '2025-10-16 01:47:34', NULL),
(25, 1, '2025-10-20 14:00:22', NULL),
(26, 1, '2025-10-20 15:01:17', NULL),
(27, 1, '2025-10-20 15:31:18', NULL),
(28, 1, '2025-10-23 17:12:07', NULL),
(29, 2, '2025-10-23 18:02:27', NULL),
(30, 1, '2025-10-23 18:18:08', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `puntos` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `puntos`) VALUES
(3, 'Damian', 0),
(4, 'Laura', 0),
(5, 'Gonzalo', 0),
(6, 'Fenix', 0),
(7, 'Mile', 20),
(8, 'Master', 910),
(9, 'mago', 590),
(10, 'matador', 60),
(11, 'Matias', 350),
(12, 'Lucas', 0),
(13, 'Tomas', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `puntos`
--
ALTER TABLE `puntos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `registros_docentes`
--
ALTER TABLE `registros_docentes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `docente_id` (`docente_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `docentes`
--
ALTER TABLE `docentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `puntos`
--
ALTER TABLE `puntos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `registros_docentes`
--
ALTER TABLE `registros_docentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `puntos`
--
ALTER TABLE `puntos`
  ADD CONSTRAINT `puntos_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `registros_docentes`
--
ALTER TABLE `registros_docentes`
  ADD CONSTRAINT `registros_docentes_ibfk_1` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
