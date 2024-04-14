Aquí tienes ejemplos de queries para insertar 10 registros en cada una de las tablas necesarias, manteniendo la integridad referencial. Ten en cuenta que estos son ejemplos, y los valores específicos pueden variar según tus necesidades y la estructura exacta de tus tablas.

```sql
-- Insertar registros en la tabla de usuarios
INSERT INTO usuarios (Email, PasswordHash, Verificado) VALUES
('usuario1@email.com', 'hash1', true),
('usuario2@email.com', 'hash2', false),
('usuario3@email.com', 'hash3', true),
('usuario4@email.com', 'hash4', false),
('usuario5@email.com', 'hash5', true),
('usuario6@email.com', 'hash6', false),
('usuario7@email.com', 'hash7', true),
('usuario8@email.com', 'hash8', false),
('usuario9@email.com', 'hash9', true),
('usuario10@email.com', 'hash10', false);

-- Insertar registros en la tabla de perfiles
INSERT INTO perfiles (UsuarioID, Nombre, Apellido, AvatarURL) VALUES
(1, 'Nombre1', 'Apellido1', 'avatar1.jpg'),
(2, 'Nombre2', 'Apellido2', 'avatar2.jpg'),
(3, 'Nombre3', 'Apellido3', 'avatar3.jpg'),
(4, 'Nombre4', 'Apellido4', 'avatar4.jpg'),
(5, 'Nombre5', 'Apellido5', 'avatar5.jpg'),
(6, 'Nombre6', 'Apellido6', 'avatar6.jpg'),
(7, 'Nombre7', 'Apellido7', 'avatar7.jpg'),
(8, 'Nombre8', 'Apellido8', 'avatar8.jpg'),
(9, 'Nombre9', 'Apellido9', 'avatar9.jpg'),
(10, 'Nombre10', 'Apellido10', 'avatar10.jpg');

-- Insertar registros en la tabla de pagos
INSERT INTO pagos (UsuarioID, Producto, Monto, Pagado) VALUES
(1, 'Producto1', 50.00, true),
(2, 'Producto2', 75.00, false),
(3, 'Producto3', 30.50, true),
(4, 'Producto4', 20.00, false),
(5, 'Producto5', 45.75, true),
(6, 'Producto6', 60.00, false),
(7, 'Producto7', 15.25, true),
(8, 'Producto8', 90.50, false),
(9, 'Producto9', 25.00, true),
(10, 'Producto10', 35.50, false);


-- Insertar registros en la tabla de pedidos
INSERT INTO pedidos (UsuarioID, Producto, Cantidad, FechaPedido) VALUES
(1, 'ProductoA', 2, '2023-01-01'),
(2, 'ProductoB', 1, '2023-01-02'),
(3, 'ProductoC', 3, '2023-01-03'),
(4, 'ProductoD', 2, '2023-01-04'),
(5, 'ProductoE', 4, '2023-01-05'),
(6, 'ProductoF', 1, '2023-01-06'),
(7, 'ProductoG', 3, '2023-01-07'),
(8, 'ProductoH', 2, '2023-01-08'),
(9, 'ProductoI', 5, '2023-01-09'),
(10, 'ProductoJ', 1, '2023-01-10');

```

Estos ejemplos asumen que tienes una columna `usuario_id` en las tablas que establece la relación con la tabla de usuarios. Asegúrate de ajustar los nombres de las columnas y los valores según la estructura real de tus tablas.