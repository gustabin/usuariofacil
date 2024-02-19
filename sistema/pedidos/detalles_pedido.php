<?php
// Incluir el archivo de configuración
require '../../tools/config.php';

// Conexión a la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
mysqli_set_charset($conexion, 'utf8');
try {
    // Obtener el ID del pedido desde la consulta GET
    $pedidoID = $_GET['pedidoID'];

    // Consulta SQL para obtener detalles del pedido con información del producto
    $query = "SELECT pp.Cantidad, p.Nombre AS NombreProducto, p.Descripcion AS DescProducto, p.Precio, p.ImagenURL
        FROM ProductosPedidos pp
        JOIN Productos p ON pp.ProductoID = p.ProductoID
        WHERE pp.PedidoID = ?";

    // Preparar la consulta
    $stmt = $conexion->prepare($query);

    if ($stmt) {
        // Vincular el parámetro
        $stmt->bind_param("i", $pedidoID);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $result = $stmt->get_result();

        if ($result) {
            $detalles = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($detalles);
        } else {
            throw new Exception("Error al obtener los detalles del pedido");
        }

        // Cerrar el statement
        $stmt->close();
    } else {
        throw new Exception("Error al preparar la consulta");
    }
} catch (Exception $e) {
    echo json_encode(array('error' => $e->getMessage()));
}

// Cierra la conexión
$conexion->close();
