<?php
// Incluir el archivo de configuración
require '../../tools/config.php';

// Conexión a la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
mysqli_set_charset($conexion, 'utf8');

try {
    // Obtener el ID del pedido desde la consulta GET
    $pedidoID = filter_var($_GET['pedidoID'], FILTER_VALIDATE_INT);

    if ($pedidoID === false || $pedidoID <= 0) {
        // Manejar el caso de un ID de pedido no válido
        echo json_encode(array('error' => 'ID de pedido no válido'));
        exit();
    }

    // Consulta SQL para obtener detalles del pedido con información del producto
    $query = "SELECT pp.Cantidad, p.Nombre AS NombreProducto, p.Descripcion AS DescProducto, p.Precio, p.ImagenURL
        FROM productospedidos pp
        JOIN productos p ON pp.ProductoID = p.ProductoID
        WHERE pp.PedidoID = ?";

    // Preparar la consulta
    $stmt = $conexion->prepare($query);

    if (!$stmt) {
        echo json_encode(array('error' => 'Error al preparar la consulta: ' . $conexion->error));
        exit();
    }

    // Vincular el parámetro
    $stmt->bind_param("i", $pedidoID);

    // Ejecutar la consulta
    $stmt->execute();

    // Verificar si hay errores en la ejecución
    if ($stmt->errno) {
        echo json_encode(array('error' => 'Error en la ejecución de la consulta: ' . $stmt->error));
        exit();
    }

    // Obtener el resultado
    $result = $stmt->get_result();

    // Verificar si el resultado está vacío
    if ($result->num_rows === 0) {
        echo json_encode(array('error' => 'No se encontraron detalles para el pedido especificado.'));
    } else {
        $detalles = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($detalles);
    }

    // Cerrar el statement
    $stmt->close();
} catch (Exception $e) {
    echo json_encode(array('error' => $e->getMessage()));
}

// Cierra la conexión
$conexion->close();
