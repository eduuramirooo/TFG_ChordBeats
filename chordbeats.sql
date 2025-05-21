-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-05-2025 a las 21:57:08
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `chordbeats`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artistas`
--

CREATE TABLE `artistas` (
  `id` int(11) NOT NULL,
  `spotify_id` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `imagen` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `artistas`
--

INSERT INTO `artistas` (`id`, `spotify_id`, `nombre`, `imagen`) VALUES
(1, '6goQbtqjPhPns8RVRXTyp7', 'Mda', 'https://i.scdn.co/image/ab6761610000e5eb57a358cc48fdd03e8d1b5cd0'),
(2, '5o7fmoqHl79fzoCzeApdxm', 'Sticky M.A.', 'https://i.scdn.co/image/ab6761610000e5eb30b40b1a52a54a77721d382e'),
(3, '31VgmAag1FUVTzQpASIeFo', 'Biberon', 'https://i.scdn.co/image/ab6761610000e5eb8d47332cd3bb4cd6e19ed6d0'),
(4, '1Xyo4u8uXC1ZmMpatF05PJ', 'The Weeknd', 'https://i.scdn.co/image/ab6761610000e5eb9e528993a2820267b97f6aae'),
(5, '66CXWjxzNUsdJxJ2JdwvnR', 'Ariana Grande', 'https://i.scdn.co/image/ab6761610000e5eb6725802588d7dc1aba076ca5'),
(6, '3TVXtAsR1Inumwj472S9r4', 'Drake', 'https://i.scdn.co/image/ab6761610000e5eb4293385d324db8558179afd9'),
(7, '6eUKZXaKkcviH0Ku9w2n3V', 'Ed Sheeran', 'https://i.scdn.co/image/ab67616100005174784daff754ecfe0464ddbeb9'),
(8, '53XhwfbYqKCa1cC15pYq2q', 'Imagine Dragons', 'https://i.scdn.co/image/ab6761610000e5ebab47d8dae2b24f5afe7f9d38'),
(9, '1uNFoZAHBGtllmzznpCI3s', 'Justin Bieber', 'https://i.scdn.co/image/ab6761610000e5eb8ae7f2aaa9817a704a87ea36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artista_usuario`
--

CREATE TABLE `artista_usuario` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `artista_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `artista_usuario`
--

INSERT INTO `artista_usuario` (`id`, `usuario_id`, `artista_id`) VALUES
(4, 2, 1),
(5, 2, 2),
(6, 2, 3),
(1, 3, 1),
(2, 3, 2),
(3, 3, 3),
(7, 5, 1),
(8, 5, 2),
(9, 5, 3),
(10, 6, 1),
(22, 6, 2),
(11, 6, 4),
(13, 7, 1),
(12, 7, 2),
(28, 7, 5),
(14, 8, 3),
(15, 8, 4),
(29, 8, 6),
(17, 9, 2),
(16, 9, 5),
(30, 9, 7),
(18, 10, 3),
(19, 10, 6),
(31, 10, 8),
(21, 11, 5),
(20, 11, 6),
(32, 11, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `id_usuario1` int(11) NOT NULL,
  `id_usuario2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `chats`
--

INSERT INTO `chats` (`id`, `id_usuario1`, `id_usuario2`) VALUES
(10, 5, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `id_chats` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `id_chats`, `id_usuario`, `mensaje`, `fecha`) VALUES
(9, 10, 5, 'Hey!!! Qué tal? He visto que te gusta Ariana Grande, me encanta.', '2025-05-21 21:41:15'),
(10, 10, 7, 'Siiii la verdad que canta genial a mi tambien me encanta.', '2025-05-21 21:41:42'),
(11, 10, 5, 'Tienes razón he visto que tú tambien eres de Parla, que curioso', '2025-05-21 21:42:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `spotify_id` varchar(255) DEFAULT NULL,
  `username` varchar(250) NOT NULL,
  `foto_perfil` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `spotify_id`, `username`, `foto_perfil`) VALUES
(1, '0', 'Marcsss', 'https://i.scdn.co/image/ab6775700000ee856f1e3304803a274bc8442de6'),
(2, '0', 'eduuramirooo', 'https://i.scdn.co/image/ab6775700000ee857321b537a142bf63de083671'),
(3, '0', '31c6vcq7okyww6dv3cdmkkgwo2rq', 'https://i.scdn.co/image/ab6775700000ee857321b537a142bf63de083671'),
(4, '0', 'Usuario', 'https://via.placeholder.com/150'),
(5, '31c6vcq7okyww6dv3cdmkkgwo2rq', 'eduuramirooo', 'https://i.scdn.co/image/ab6775700000ee857321b537a142bf63de083671'),
(6, 'spotify_001', 'Marcos', 'https://i.pravatar.cc/150?img=1'),
(7, 'spotify_002', 'Lucía', 'https://i.pravatar.cc/150?img=2'),
(8, 'spotify_003', 'Alejandro', 'https://i.pravatar.cc/150?img=3'),
(9, 'spotify_004', 'Melisa', 'https://i.pravatar.cc/150?img=16'),
(10, 'spotify_005', 'Carlos', 'https://i.pravatar.cc/150?img=11'),
(11, 'spotify_006', 'Laura', 'https://i.pravatar.cc/150?img=9');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `artistas`
--
ALTER TABLE `artistas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `spotify_id` (`spotify_id`);

--
-- Indices de la tabla `artista_usuario`
--
ALTER TABLE `artista_usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_id` (`usuario_id`,`artista_id`),
  ADD KEY `artista_id` (`artista_id`);

--
-- Indices de la tabla `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario1` (`id_usuario1`),
  ADD KEY `id_usuario2` (`id_usuario2`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_chats` (`id_chats`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `artistas`
--
ALTER TABLE `artistas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `artista_usuario`
--
ALTER TABLE `artista_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `artista_usuario`
--
ALTER TABLE `artista_usuario`
  ADD CONSTRAINT `artista_usuario_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `artista_usuario_ibfk_2` FOREIGN KEY (`artista_id`) REFERENCES `artistas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`id_usuario1`) REFERENCES `usuario` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chats_ibfk_2` FOREIGN KEY (`id_usuario2`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`id_chats`) REFERENCES `chats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
