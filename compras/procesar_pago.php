<?php
session_start();

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productos = isset($_POST['productos']) ? $_POST['productos'] : [];

    // Validar la sesión
    if (!isset($_SESSION['usuarioID'])) {
        $_SESSION['intentar_pago'] = true;
        $_SESSION['carrito'] = $productos;
        $response['redirect'] = 'login/index.html';
        $response['message'] = 'Usuario no autenticado';
        echo json_encode($response);
        exit();
    } else {
        $usuarioID = $_SESSION['usuarioID'];
        unset($_SESSION['intentar_pago']);

        try {
            // Calcular el total a pagar en el servidor
            $totalPagar = calcularTotalPagar($productos);

            // Guardar el pedido y obtener el resultado
            guardarPedidoEnBaseDeDatos($productos, $totalPagar, $usuarioID);

            $response['status'] = 'exito';
            $response['message'] = 'Pago realizado con éxito';
            echo json_encode($response);
        } catch (Exception $e) {
            $response['status'] = 'error';
            $response['message'] = 'Error: ' . $e->getMessage();
            echo json_encode($response);
        }
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Método de solicitud no válido. Se esperaba una solicitud POST.';
    echo json_encode($response);
    exit();
}

function calcularTotalPagar($productos)
{
    try {
        // Validar que la entrada sea un array de productos
        if (!is_array($productos)) {
            throw new Exception("La entrada debe ser un array de productos.");
        }

        $totalPagar = 0;

        // Incluir el archivo de configuración
        require '../tools/config.php';

        // Conexión a la base de datos
        $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // Validar la conexión
        if ($conexion->connect_error) {
            throw new Exception("Error de conexión a la base de datos: " . $conexion->connect_error);
        }

        foreach ($productos as $productoDetalle) {
            if (!is_array($productoDetalle) || !array_key_exists('producto', $productoDetalle) || !array_key_exists('cantidad', $productoDetalle)) {
                throw new Exception("Detalles de producto incorrectos.");
            }

            $productoID = intval($productoDetalle['producto']['ProductoID']);
            $cantidad = intval($productoDetalle['cantidad']);

            if ($cantidad < 0) {
                throw new Exception("Cantidad negativa en los detalles del producto.");
            }

            $queryPrecio = "SELECT Precio FROM productos WHERE ProductoID = ?";
            $stmtPrecio = $conexion->prepare($queryPrecio);
            $stmtPrecio->bind_param('i', $productoID);
            $stmtPrecio->execute();
            $resultPrecio = $stmtPrecio->get_result();

            if ($resultPrecio->num_rows > 0) {
                $rowPrecio = $resultPrecio->fetch_assoc();
                $precio = floatval($rowPrecio['Precio']);

                if ($precio < 0) {
                    throw new Exception("Valores negativos en el precio del producto.");
                }

                $totalPagar += $precio * $cantidad;
            } else {
                throw new Exception("No se encontró el producto con ID $productoID.");
            }

            $stmtPrecio->close();
        }

        $conexion->close();
        return $totalPagar;
    } catch (Exception $e) {
        echo "Error al calcular el total a pagar: " . $e->getMessage();
        return null;
    }
}

function guardarPedidoEnBaseDeDatos($productos, $totalPagar, $usuarioID)
{
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if ($conexion->connect_error) {
        throw new Exception("Error de conexión a la base de datos: " . $conexion->connect_error);
    }

    $stmtPedido = null;
    $stmtProductosPedidos = null;
    $stmtPagos = null;

    try {
        $conexion->begin_transaction();

        $queryPedido = "INSERT INTO pedidos (UsuarioID, FechaPedido) VALUES (?, NOW())";
        $stmtPedido = $conexion->prepare($queryPedido);
        $stmtPedido->bind_param('i', $usuarioID);
        $stmtPedido->execute();

        $pedidoId = $stmtPedido->insert_id;

        $queryProductosPedidos = "INSERT INTO productospedidos (PedidoID, ProductoID, Cantidad) VALUES (?, ?, ?)";
        $stmtProductosPedidos = $conexion->prepare($queryProductosPedidos);

        foreach ($productos as $productoDetalle) {
            $producto = $productoDetalle['producto'];
            $cantidad = intval($productoDetalle['cantidad']);

            $stmtProductosPedidos->bind_param('iii', $pedidoId, $producto['ProductoID'], $cantidad);
            $stmtProductosPedidos->execute();
        }

        $queryPagos = "INSERT INTO pagos (UsuarioID, Monto, Pagado) VALUES (?, ?, false)";
        $stmtPagos = $conexion->prepare($queryPagos);
        $stmtPagos->bind_param('id', $usuarioID, $totalPagar);
        $stmtPagos->execute();

        $conexion->commit();
        $response['status'] = 'exito';
        $response['message'] = 'Pedido registrado correctamente';
        $response['totalPagar'] = $totalPagar;
    } catch (Exception $e) {
        $conexion->rollback();

        $response['status'] = 'error';
        $response['message'] = 'Error al registrar el pedido: ' . $e->getMessage();
    }

    if ($stmtPedido !== null) {
        $stmtPedido->close();
    }

    if ($stmtProductosPedidos !== null) {
        $stmtProductosPedidos->close();
    }

    if ($stmtPagos !== null) {
        $stmtPagos->close();
    }

    $conexion->close();

    unset($_SESSION['carrito']);

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
