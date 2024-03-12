<?php
session_start();

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productos = isset($_POST['productos']) ? $_POST['productos'] : [];

    if (!empty($productos)) {
        // Incluir el archivo de configuración
        require '../tools/config.php';

        // Conexión a la base de datos
        $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // Validar la conexión
        if ($conexion->connect_error) {
            $response['status'] = 'error';
            $response['message'] = 'Error de conexión a la base de datos: ' . $conexion->connect_error;
        } else {
            try {
                // Comprueba si la sesión está iniciada
                if (!isset($_SESSION['usuarioID'])) {
                    throw new Exception("La sesión no está iniciada correctamente.");
                }

                // Comienza una transacción
                $conexion->begin_transaction();

                foreach ($productos as $productoDetalle) {
                    $productoID = intval($productoDetalle['producto']['ProductoID']);
                    $cantidad = intval($productoDetalle['cantidad']);

                    // Actualizar el stock en la base de datos
                    $queryUpdateStock = "UPDATE Productos SET Stock = Stock - ? WHERE ProductoID = ?";
                    $stmtUpdateStock = $conexion->prepare($queryUpdateStock);
                    $stmtUpdateStock->bind_param('ii', $cantidad, $productoID);
                    $stmtUpdateStock->execute();

                    // Verificar si se ejecutó correctamente
                    if ($stmtUpdateStock->affected_rows === 0) {
                        throw new Exception("Error al decrementar el stock del producto con ID $productoID.");
                    }
                }

                // Confirmar la transacción
                $conexion->commit();
                $response['status'] = 'exito';
            } catch (Exception $e) {
                // Revertir la transacción en caso de error
                $conexion->rollback();
                $response['status'] = 'error';
                $response['message'] = 'Error al decrementar el stock en la base de datos: ' . $e->getMessage();
            }

            // Cerrar la conexión a la base de datos
            if (isset($stmtUpdateStock)) {
                $stmtUpdateStock->close();
            }

            $conexion->close();
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'No se proporcionaron productos para decrementar el stock.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Método de solicitud no válido. Se esperaba una solicitud POST.';
}

// Devolver la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
