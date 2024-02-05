<?php
// Incluir el archivo de configuración
require '../../tools/config.php';
// Conexión a la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Variables de entrada
$producto = $_POST['producto'];
$cantidad = intval($_POST['cantidad']);

// Array para la respuesta JSON
$response = array();

try {
    // Validar datos del pedido
    if (empty($producto) || $cantidad <= 0) {
        throw new Exception('Datos de pedido no válidos.');
    }

    session_start();
    $usuarioID = $_SESSION['usuarioID'];

    // Consulta preparada para insertar un nuevo pedido
    $query = "INSERT INTO Pedidos (UsuarioID, Producto, Cantidad, FechaPedido) VALUES (?, ?, ?, CURRENT_DATE)";
    $stmt = $conexion->prepare($query);

    if (!$stmt) {
        throw new Exception('Error en la preparación de la consulta: ' . $conexion->error);
    }

    $stmt->bind_param('iss', $usuarioID, $producto, $cantidad);
    $stmt->execute();

    // Verificar si la operación fue exitosa
    if ($stmt->affected_rows > 0) {
        // Éxito al insertar el pedido
        $response['status'] = 'exito';
        $response['message'] = 'Pedido realizado correctamente.';
    } else {
        // Error al insertar el pedido
        throw new Exception('Error al realizar el pedido: No se realizaron cambios.');
    }
} catch (Exception $e) {
    // Manejar la excepción y proporcionar un mensaje de error personalizado
    $response['status'] = 'error';
    $response['message'] = 'Error al realizar el pedido: ' . $e->getMessage();
}

// Cerrar la conexión
$stmt->close();
$conexion->close();

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
