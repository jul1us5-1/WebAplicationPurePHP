-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-01-2026 a las 17:30:03
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
-- Base de datos: `servissana_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id_comentario` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contenido` text NOT NULL,
  `fecha_comentario` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id_comentario`, `id_post`, `user_id`, `contenido`, `fecha_comentario`) VALUES
(1, 5, 9, 'Nice Elephant', '2026-01-04 14:03:11'),
(3, 6, 12, 'Nice pic', '2026-01-05 15:31:21'),
(5, 6, 9, 'haram', '2026-01-06 14:53:58'),
(6, 6, 12, 'haram x2', '2026-01-06 14:56:51'),
(7, 5, 12, 'Nice color', '2026-01-07 11:53:54'),
(9, 6, 9, ' alert(\'hello world\')', '2026-01-07 12:28:40'),
(10, 7, 12, 'wode', '2026-01-14 13:05:50'),
(11, 7, 9, ' alert(\'hello world\')', '2026-01-14 13:06:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes`
--

CREATE TABLE `likes` (
  `id_like` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fecha_like` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `likes`
--

INSERT INTO `likes` (`id_like`, `id_post`, `user_id`, `fecha_like`) VALUES
(6, 6, 9, '2026-01-06 16:01:40'),
(9, 5, 12, '2026-01-07 12:53:46'),
(11, 7, 12, '2026-01-14 14:06:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE `publicaciones` (
  `id_post` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contenido` text NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `fecha_publicacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `publicaciones`
--

INSERT INTO `publicaciones` (`id_post`, `user_id`, `contenido`, `imagen`, `fecha_publicacion`) VALUES
(2, 9, 'Hello', 'img_1765978025_6942afa96f5c4.png', '2025-12-17 13:27:05'),
(5, 9, 'Haram', 'post_1766069114_6944137a796e5.jpg', '2025-12-18 14:45:14'),
(6, 12, 'Holly molly', 'post_1767627059_695bd93337c3d.jpeg', '2026-01-05 15:30:59'),
(7, 12, 'Hola', 'post_1768395838_6967943e59e7e.jpg', '2026-01-14 13:03:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_has` varchar(255) NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `activation_code` varchar(6) DEFAULT NULL,
  `code_expiration` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `es_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_has`, `fullname`, `activation_code`, `code_expiration`, `is_active`, `created_at`, `es_admin`) VALUES
(9, 'jul1us5_', 'usuario1@ejemplo.com', '$2y$10$pmUYKkFhWzzXxs6lKbbphuq9hW.EWh0uJ5FLDPPw6Ldu8iLVeZZ06', 'Julio Junco Velasco', NULL, NULL, 1, '2025-11-30 15:25:12', 1),
(12, 'Almas21', 'usuario2@ejemplo.com', '$2y$10$pmUYKkFhWzzXxs6lKbbphuq9hW.EWh0uJ5FLDPPw6Ldu8iLVeZZ06', 'Almas Kelgenov', NULL, NULL, 1, '2026-01-03 19:56:16', 0),
(14, 'Pedronavajas21', 'usuario3@ejemplo.com', '$2y$10$pmUYKkFhWzzXxs6lKbbphuq9hW.EWh0uJ5FLDPPw6Ldu8iLVeZZ06', 'Pedro navajas', NULL, '2026-01-14 14:23:23', 1, '2026-01-14 13:18:23', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id_comentario`),
  ADD KEY `fk_post` (`id_post`),
  ADD KEY `fk_usuario_comenta` (`user_id`);

--
-- Indices de la tabla `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id_like`),
  ADD UNIQUE KEY `id_post` (`id_post`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD PRIMARY KEY (`id_post`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id_comentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `likes`
--
ALTER TABLE `likes`
  MODIFY `id_like` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `fk_post` FOREIGN KEY (`id_post`) REFERENCES `publicaciones` (`id_post`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario_comenta` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `publicaciones` (`id_post`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD CONSTRAINT `publicaciones_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
