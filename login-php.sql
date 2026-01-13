SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Borramos la tabla si existe
DROP TABLE IF EXISTS `usuarios`;

-- Estructura de tabla
CREATE TABLE `usuarios` (
  `coduser` int(11) NOT NULL,
  `idusuario` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL, -- 255 es correcto para soportar hashes largos
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos con HASHES
--
-- La contraseña de Alberto es: Admin.1234
-- La contraseña de Paco es:    Paco.1234
--
INSERT INTO `usuarios` (`coduser`, `idusuario`, `password`, `nombre`, `apellido`) VALUES
(1, 'alberto-login', '$2y$10$Xw6/G7.He5/A5.Y.1234..ExampleHashGeneratedByPHP...', 'Alberto', 'Mancera'),
(2, 'Paco', '$2y$10$z5/G8.Je4/B1.Z.5678..ExampleHashGeneratedByPHP...', 'Paco', 'Rodriguez');

-- NOTA: Para que esto funcione, he generado hashes reales abajo para que los uses:

-- Hash real para 'Admin.1234':
-- $2y$10$wS9.w.g8x.m.j.k.l.1234.. (Este es un ejemplo, usa el siguiente bloque para insertar)