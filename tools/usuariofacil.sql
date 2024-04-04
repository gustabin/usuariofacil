-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2024 at 07:55 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `usuariofacil`
--

-- --------------------------------------------------------

--
-- Table structure for table `contactos`
--

CREATE TABLE `contactos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `telefono` varchar(25) COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `mensaje` text COLLATE utf8_spanish2_ci NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `contactos`
--

INSERT INTO `contactos` (`id`, `nombre`, `telefono`, `email`, `mensaje`, `fecha`) VALUES
(27, 'Tester User', '98765432', 'testeruser@test.com', 'Es una prueba', '2024-03-21 13:48:54'),
(28, 'Jane Doe', '123456', 'janedoe@test.com', 'Es otra prueba mas.', '2024-03-21 13:49:36');

-- --------------------------------------------------------

--
-- Table structure for table `pagos`
--

CREATE TABLE `pagos` (
  `PagoID` int(11) NOT NULL,
  `UsuarioID` int(11) DEFAULT NULL,
  `Monto` decimal(10,2) NOT NULL,
  `Pagado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Dumping data for table `pagos`
--

INSERT INTO `pagos` (`PagoID`, `UsuarioID`, `Monto`, `Pagado`) VALUES
(151, 50, '225.50', 0),
(152, 50, '318.75', 0),
(153, 50, '432.00', 0),
(154, 50, '545.25', 0),
(155, 50, '612.99', 0),
(156, 50, '428.50', 0),
(157, 54, '544.25', 0),
(158, 54, '1158.24', 0),
(159, 54, '654.00', 0),
(160, 50, '1089.50', 0),
(161, 50, '545.25', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pedidos`
--

CREATE TABLE `pedidos` (
  `PedidoID` int(11) NOT NULL,
  `UsuarioID` int(11) DEFAULT NULL,
  `FechaPedido` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Dumping data for table `pedidos`
--

INSERT INTO `pedidos` (`PedidoID`, `UsuarioID`, `FechaPedido`) VALUES
(181, 50, '2024-03-21'),
(182, 50, '2024-03-21'),
(183, 50, '2024-03-21'),
(184, 50, '2024-03-21'),
(185, 50, '2024-03-21'),
(186, 50, '2024-03-21'),
(187, 54, '2024-03-21'),
(188, 54, '2024-03-21'),
(189, 54, '2024-03-21'),
(190, 50, '2024-03-21'),
(191, 50, '2024-03-26');

-- --------------------------------------------------------

--
-- Table structure for table `perfiles`
--

CREATE TABLE `perfiles` (
  `PerfilID` int(11) NOT NULL,
  `UsuarioID` int(11) DEFAULT NULL,
  `Nombre` varchar(50) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `Apellido` varchar(50) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `AvatarURL` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Dumping data for table `perfiles`
--

INSERT INTO `perfiles` (`PerfilID`, `UsuarioID`, `Nombre`, `Apellido`, `AvatarURL`) VALUES
(37, 50, 'John', 'Doe', 'imagen/user_default.png'),
(38, 54, 'John', 'Doe', 'imagen/user_default.png');

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `ProductoID` int(11) NOT NULL,
  `Nombre` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `Descripcion` text COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `Precio` decimal(10,2) NOT NULL,
  `Stock` int(11) NOT NULL,
  `Codigo` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `ImagenURL` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`ProductoID`, `Nombre`, `Descripcion`, `Precio`, `Stock`, `Codigo`, `ImagenURL`) VALUES
(1, 'TechMaster X1', 'Experimenta un rendimiento extraordinario y diseño vanguardista con el TechMaster X1, el compañero ideal para tu vida digital.', '225.50', 6, 'COD1', 'productos/imagen1.jpg'),
(2, 'Quantum Nexus Z', 'Conecta con la potencia del futuro. Quantum Nexus Z redefine la innovación, ofreciendo funcionalidades avanzadas y estilo excepcional.', '318.75', 8, 'COD2', 'productos/imagen2.jpg'),
(3, 'CyberWave Vortex 9', 'Sumérgete en la revolución tecnológica con el CyberWave Vortex 9. Rápido, elegante y lleno de características inteligentes.', '432.00', 10, 'COD3', 'productos/imagen3.jpg'),
(4, 'SwiftConnect Epsilon', 'Descubre la velocidad de la conectividad sin límites. SwiftConnect Epsilon te ofrece un rendimiento ágil y funciones intuitivas.', '545.25', 4, 'COD4', 'productos/imagen4.jpg'),
(5, 'Infinity Fusion Pro', 'Experimenta la fusión perfecta de elegancia y rendimiento con el Infinity Fusion Pro. Un teléfono que supera tus expectativas.', '612.99', 17, 'COD5', 'productos/imagen5.jpg'),
(6, 'Galaxy Pulse Neo', 'Siente el pulso de la innovación con Galaxy Pulse Neo. Diseño moderno y funciones avanzadas para mantenerte conectado con el futuro.', '428.50', 4, 'COD6', 'productos/imagen6.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `productospedidos`
--

CREATE TABLE `productospedidos` (
  `ProductoPedidoID` int(11) NOT NULL,
  `PedidoID` int(11) DEFAULT NULL,
  `ProductoID` int(11) DEFAULT NULL,
  `Cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Dumping data for table `productospedidos`
--

INSERT INTO `productospedidos` (`ProductoPedidoID`, `PedidoID`, `ProductoID`, `Cantidad`) VALUES
(92, 181, 1, 1),
(93, 182, 2, 1),
(94, 183, 3, 1),
(95, 184, 4, 1),
(96, 185, 5, 1),
(97, 186, 6, 1),
(98, 187, 1, 1),
(99, 187, 2, 1),
(100, 188, 4, 1),
(101, 188, 5, 1),
(102, 189, 6, 1),
(103, 189, 1, 1),
(104, 190, 1, 1),
(105, 190, 2, 1),
(106, 190, 4, 1),
(107, 191, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `UsuarioID` int(11) NOT NULL,
  `Email` varchar(80) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `PasswordHash` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `Verificado` int(1) DEFAULT 0,
  `TokenRecuperacion` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `FechaRecuperacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Rol` int(1) NOT NULL DEFAULT 0 COMMENT '0: usuario;\r\n1: administrador;'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`UsuarioID`, `Email`, `PasswordHash`, `Verificado`, `TokenRecuperacion`, `FechaRecuperacion`, `Rol`) VALUES
(50, 'gustavoarias@outlook.com', '$2y$10$96JITi1Z8fIa7cKEh2YPqOBffesJXutapkkKhMVodTuuyNkVcXY3m', 1, '$2y$10$bbwU/CTf1UQp7F6RvErLkOD.eQPDso7CNLiTxK.7nue6bUHZEceky', '2024-03-21 19:20:57', 1),
(54, 'gustabin@yahoo.com', '$2y$10$96JITi1Z8fIa7cKEh2YPqOBffesJXutapkkKhMVodTuuyNkVcXY3m', 1, 'fdaffde5ee614dcd9c65a619906930a77d21d20e651bf1284de93b3844695b5c', '2024-03-26 11:10:37', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`PagoID`),
  ADD KEY `FK_UsuarioPago` (`UsuarioID`);

--
-- Indexes for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`PedidoID`),
  ADD KEY `FK_UsuarioPedido` (`UsuarioID`);

--
-- Indexes for table `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`PerfilID`),
  ADD KEY `FK_UsuarioPerfil` (`UsuarioID`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`ProductoID`),
  ADD UNIQUE KEY `Codigo` (`Codigo`);

--
-- Indexes for table `productospedidos`
--
ALTER TABLE `productospedidos`
  ADD PRIMARY KEY (`ProductoPedidoID`),
  ADD KEY `PedidoID` (`PedidoID`),
  ADD KEY `ProductoID` (`ProductoID`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`UsuarioID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `pagos`
--
ALTER TABLE `pagos`
  MODIFY `PagoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `PedidoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT for table `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `PerfilID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `ProductoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `productospedidos`
--
ALTER TABLE `productospedidos`
  MODIFY `ProductoPedidoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `UsuarioID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `FK_UsuarioPago` FOREIGN KEY (`UsuarioID`) REFERENCES `usuarios` (`UsuarioID`),
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`UsuarioID`) REFERENCES `usuarios` (`UsuarioID`);

--
-- Constraints for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `FK_UsuarioPedido` FOREIGN KEY (`UsuarioID`) REFERENCES `usuarios` (`UsuarioID`),
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`UsuarioID`) REFERENCES `usuarios` (`UsuarioID`);

--
-- Constraints for table `perfiles`
--
ALTER TABLE `perfiles`
  ADD CONSTRAINT `FK_UsuarioPerfil` FOREIGN KEY (`UsuarioID`) REFERENCES `usuarios` (`UsuarioID`),
  ADD CONSTRAINT `perfiles_ibfk_1` FOREIGN KEY (`UsuarioID`) REFERENCES `usuarios` (`UsuarioID`);

--
-- Constraints for table `productospedidos`
--
ALTER TABLE `productospedidos`
  ADD CONSTRAINT `productospedidos_ibfk_1` FOREIGN KEY (`PedidoID`) REFERENCES `pedidos` (`PedidoID`),
  ADD CONSTRAINT `productospedidos_ibfk_2` FOREIGN KEY (`ProductoID`) REFERENCES `productos` (`ProductoID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
