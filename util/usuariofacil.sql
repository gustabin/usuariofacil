-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2024 at 06:49 PM
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
(126, 24, '3290.23', 0),
(127, 24, '1953.50', 0),
(128, 24, '428.50', 0),
(129, 24, '1225.98', 0),
(130, 24, '318.75', 0),
(131, 24, '1089.50', 0);

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
(156, 24, '2024-02-16'),
(157, 24, '2024-02-16'),
(158, 24, '2024-02-16'),
(159, 24, '2024-02-16'),
(160, 24, '2024-02-16'),
(161, 24, '2024-02-16');

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
(1, 1, 'John', 'Doe', 'avatar1.jpg'),
(2, 2, 'Nombre2', 'Apellido2', 'avatar2.jpg'),
(3, 3, 'Nombre3', 'Apellido3', 'avatar3.jpg'),
(4, 4, 'Nombre4', 'Apellido4', 'avatar4.jpg'),
(5, 5, 'Nombre5', 'Apellido5', 'avatar5.jpg'),
(6, 6, 'Nombre6', 'Apellido6', 'avatar6.jpg'),
(7, 7, 'Nombre7', 'Apellido7', 'avatar7.jpg'),
(8, 8, 'Nombre8', 'Apellido8', 'avatar8.jpg'),
(9, 24, 'Gustavo', 'Arias', 'imagen/24_download (5).jpg');

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
(1, 'TechMaster X1', 'Experimenta un rendimiento extraordinario y diseño vanguardista con el TechMaster X1, el compañero ideal para tu vida digital.', '225.50', 13, 'COD1', 'productos/imagen1.jpg'),
(2, 'Quantum Nexus Z', 'Conecta con la potencia del futuro. Quantum Nexus Z redefine la innovación, ofreciendo funcionalidades avanzadas y estilo excepcional.', '318.75', 18, 'COD2', 'productos/imagen2.jpg'),
(3, 'CyberWave Vortex 9', 'Sumérgete en la revolución tecnológica con el CyberWave Vortex 9. Rápido, elegante y lleno de características inteligentes.', '432.00', 5, 'COD3', 'productos/imagen3.jpg'),
(4, 'SwiftConnect Epsilon', 'Descubre la velocidad de la conectividad sin límites. SwiftConnect Epsilon te ofrece un rendimiento ágil y funciones intuitivas.', '545.25', 13, 'COD4', 'productos/imagen4.jpg'),
(5, 'Infinity Fusion Pro', 'Experimenta la fusión perfecta de elegancia y rendimiento con el Infinity Fusion Pro. Un teléfono que supera tus expectativas.', '612.99', 21, 'COD5', 'productos/imagen5.jpg'),
(6, 'Galaxy Pulse Neo', 'Siente el pulso de la innovación con Galaxy Pulse Neo. Diseño moderno y funciones avanzadas para mantenerte conectado con el futuro.', '428.50', 10, 'COD6', 'productos/imagen6.jpg');

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
(55, 156, 4, 3),
(56, 156, 5, 2),
(57, 156, 6, 1),
(58, 157, 4, 1),
(59, 157, 1, 1),
(60, 157, 2, 1),
(61, 157, 3, 2),
(62, 158, 6, 1),
(63, 159, 5, 2),
(64, 160, 2, 1),
(65, 161, 1, 1),
(66, 161, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `UsuarioID` int(11) NOT NULL,
  `Email` varchar(80) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `PasswordHash` varchar(255) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `Verificado` tinyint(1) DEFAULT 0,
  `TokenRecuperacion` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `FechaRecuperacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`UsuarioID`, `Email`, `PasswordHash`, `Verificado`, `TokenRecuperacion`, `FechaRecuperacion`) VALUES
(1, 'usuario1@email.com', 'hash1', 1, NULL, '2024-01-03 19:09:54'),
(2, 'usuario2@email.com', 'hash2', 1, NULL, '2024-01-03 19:09:54'),
(3, 'usuario3@email.com', 'hash3', 1, NULL, '2024-01-03 19:09:54'),
(4, 'usuario4@email.com', 'hash4', 0, NULL, '2024-01-03 19:09:54'),
(5, 'usuario5@email.com', 'hash5', 1, NULL, '2024-01-03 19:09:54'),
(6, 'usuario6@email.com', 'hash6', 0, NULL, '2024-01-03 19:09:54'),
(7, 'usuario7@email.com', 'hash7', 1, NULL, '2024-01-03 19:09:54'),
(8, 'usuario8@email.com', 'hash8', 0, NULL, '2024-01-03 19:09:54'),
(9, 'usuario9@email.com', 'hash9', 1, NULL, '2024-01-03 19:09:54'),
(10, 'usuario10@email.com', 'hash10', 0, NULL, '2024-01-03 19:09:54'),
(11, 'user@demo.com', '$2y$10$ZwZxKvZIZGXiBjQAlTp7WOXvpd7y23F6RM2KTsTpxZr9Eh4wFtDOa', 0, NULL, '2024-01-03 19:09:54'),
(14, 'stackcodelab@gmail.com', '$2y$10$IX9rdru3VNfdHPyBbPHuY.zfTpcgYMQ9keE94y1/aSVSdDl8HyXYS', 1, 'f0108fe037965a273946a71299314501af2d13460a741c296d06f036a2f410dd', '2024-01-12 11:05:35'),
(15, 'testing1@prueba.com', '$2y$10$WWN6uoOCfGsF9WiXMFZmjOe0Sl1Uux1xzOe6WCa1HOqGscI./ybpq', 0, NULL, '2024-01-14 22:56:05'),
(16, 'testing2@prueba.com', '$2y$10$vfhi8d825AEBBUvmQ.K97.JwGX7.NrqOFcOombPbkGcjigvt3OgR2', 0, NULL, '2024-01-14 23:21:02'),
(24, 'testing3@prueba.com', '$2y$10$wWqedoaEPUSElPnNKNPYhOOc0kqKVJMaAoo7QrsdMafSBJkSnTSU6', 0, 'a8cf2971793acb5b972408bc0491615f71278d70617a2ec3b355d72fd9793c0a', '2024-01-17 19:48:59'),
(25, 'test@gamil.com', '$2y$10$8yNd./kiXapkyBWafhHlrunkqfvKVnSzOc6oD4jlc/iXypCwbIWi6', 0, NULL, '2024-01-15 11:34:29'),
(26, 'prueba123@email.com', '$2y$10$zvspPOuoO8D3GZiNpJL9eOnpJarHT0Ws0/9OjdCaF9KNK8lCht/jS', 0, NULL, '2024-01-15 23:59:27'),
(28, 'stackcodelab2@gmail.com', '$2y$10$CkdxH4RD9O5OtNIIEUg0AObpA.ecTz82rIHiv39yQU9g5tOzjzYPG', 1, '1d9efab800443df59ccd7c8ff346ffd3f5305ca619a071b073b1d7dcd36ab1f1', '2024-01-16 17:20:39'),
(42, 'stackcodelab3@gmail.com', '$2y$10$JU1RfxAIc4pP2o271kAv.eLyxtnYoHsVz5sQhGkAdzCbydYMMYWQG', 0, 'ed2521b5eb553e7f3608f07eb830e12ac27fe496b3c274b92d9c1c4aa7578146', '2024-01-16 15:40:31');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `pagos`
--
ALTER TABLE `pagos`
  MODIFY `PagoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `PedidoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `PerfilID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `ProductoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `productospedidos`
--
ALTER TABLE `productospedidos`
  MODIFY `ProductoPedidoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `UsuarioID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

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
