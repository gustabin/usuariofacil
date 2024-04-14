Definir las funciones y procesos es un paso esencial para la gestión efectiva de usuarios, perfiles, pagos y pedidos. A continuación, te proporcionaré funciones y procedimientos básicos que puedes adaptar según tus necesidades específicas. Estos ejemplos están escritos en lenguaje SQL y PHP, pero recuerda que pueden variar según la tecnología y el lenguaje que estés utilizando en tu aplicación.
Es una buena práctica utilizar consultas preparadas en PHP con MySQLi para prevenir ataques de inyección SQL y mejorar la seguridad de la aplicación. 

### Gestión de Usuarios:

1. **Registrar Usuario:**

   ```php
   // Conexión a la base de datos (usando MySQLi)
   $conexion = new mysqli('localhost', 'usuario_db', 'contraseña_db', 'nombre_db');

   // Variables de entrada
   $email = $_POST['email'];
   $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

   // Consulta preparada para insertar un nuevo usuario
   $query = "INSERT INTO Usuarios (Email, PasswordHash) VALUES (?, ?)";
   $stmt = $conexion->prepare($query);
   $stmt->bind_param('ss', $email, $password);
   $stmt->execute();

   // Cerrar la conexión
   $stmt->close();
   $conexion->close();
   ```

2. **Verificar Usuario:**

   ```php
   // Conexión a la base de datos

   // Variable de entrada
   $usuarioID = 1;

   // Consulta preparada para marcar un usuario como verificado
   $query = "UPDATE Usuarios SET Verificado = true WHERE UsuarioID = ?";
   $stmt = $conexion->prepare($query);
   $stmt->bind_param('i', $usuarioID);
   $stmt->execute();

   // Cerrar la conexión
   $stmt->close();
   $conexion->close();
   ```

3. **Autenticar Usuario:**

   ```php
   // Conexión a la base de datos

   // Variables de entrada
   $email = $_POST['email'];
   $password = $_POST['password'];

   // Consulta preparada para obtener el hash de la contraseña del usuario
   $query = "SELECT PasswordHash FROM Usuarios WHERE Email = ?";
   $stmt = $conexion->prepare($query);
   $stmt->bind_param('s', $email);
   $stmt->execute();
   $stmt->bind_result($hashAlmacenado);
   $stmt->fetch();

   // Verificar la contraseña usando password_verify
   // Comparar el hash almacenado con la contraseña proporcionada

   // Cerrar la conexión
   $stmt->close();
   $conexion->close();
   ```

### Recuperación de Contraseña:

1. **Solicitar Restablecimiento de Contraseña:**
Para manejar el restablecimiento de contraseña, de debe modificar la estructura de la tabla de la siguiente manera:

```sql
ALTER TABLE Usuarios
ADD COLUMN TokenRecuperacion VARCHAR(255),
ADD COLUMN FechaRecuperacion TIMESTAMP;
```

Este script SQL añadirá dos nuevas columnas a la tabla `Usuarios`: `TokenRecuperacion` para almacenar el token único generado para el restablecimiento de contraseña, y `FechaRecuperacion` para almacenar la fecha en que se solicitó el restablecimiento.

Después de ejecutar este script, puedes utilizar el código siguiente:

[Enviar un email](MODULO_REESTABLECER_PASSWORD.md)

   ```php
   // Conexión a la base de datos

   // Variable de entrada
   $email = $_POST['email'];

   // Generar un token único para el restablecimiento de contraseña
   $token = bin2hex(random_bytes(32));

   // Almacenar el token y la fecha de solicitud en la base de datos
   $query = "UPDATE Usuarios SET TokenRecuperacion = ?, FechaRecuperacion = NOW() WHERE Email = ?";
   $stmt = $conexion->prepare($query);
   $stmt->bind_param('ss', $token, $email);
   $stmt->execute();

   // Enviar un email al usuario con el enlace de restablecimiento que incluye el token

   // Cerrar la conexión
   $stmt->close();
   $conexion->close();
   ```

2. **Procesar enlace de Restablecimiento de Contraseña:**
El código del archivo `restablecer.php` generalmente incluiría la lógica para procesar la solicitud de restablecimiento de contraseña utilizando el token proporcionado en el enlace. 
```php
<?php
// Conexión a la base de datos y configuración de la sesión
$conexion = new mysqli('localhost', 'root', '', 'usuariofacil');

// Verificar si se proporcionó un token en la URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Consultar la base de datos para encontrar un usuario con el token proporcionado
    $query = "SELECT UsuarioID FROM Usuarios WHERE TokenRecuperacion = ? AND FechaRecuperacion > DATE_SUB(NOW(), INTERVAL 1 HOUR)";
    // Ejecutar la consulta (asegúrate de tener una conexión a la base de datos establecida)
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->bind_result($usuarioID);
    $stmt->fetch();


    // Verificar si se encontró un usuario con el token válido
    if ($usuarioID) {
        if (true) { // En este punto, deberías haber verificado si se encontró un usuario válido en la base de datos
            // Presentar formulario para restablecer la contraseña
            echo "Formulario para restablecer la contraseña";
        } else {
            // Token no válido, mostrar mensaje de error o redirigir a una página de error
            echo "Token no válido. Por favor, verifica el enlace o realiza una nueva solicitud.";
        }
    } else {
        // No se proporcionó un token en la URL, mostrar mensaje de error o redirigir a una página de error
        echo "Token no proporcionado. Por favor, utiliza el enlace proporcionado en tu correo electrónico.";
    }
}
// Cerrar la conexión
$stmt->close();
$conexion->close();
?>
```


3. **Restablecer Contraseña:**

   ```php
   // Conexión a la base de datos

   // Variables de entrada
   $token = $_POST['token'];
   $nuevaContraseña = password_hash($_POST['nuevaContraseña'], PASSWORD_DEFAULT);

   // Verificar la validez del token y la fecha de solicitud
   $query = "SELECT UsuarioID FROM Usuarios WHERE TokenRecuperacion = ? AND FechaRecuperacion > DATE_SUB(NOW(), INTERVAL 1 HOUR)";
   $stmt = $conexion->prepare($query);
   $stmt->bind_param('s', $token);
   $stmt->execute();
   $stmt->store_result();

   // Si la consulta devuelve un resultado, el token es válido
   if ($stmt->num_rows > 0) {
       // Actualizar la contraseña del usuario
       $stmt->bind_result($usuarioID);
       $stmt->fetch();

       $updateQuery = "UPDATE Usuarios SET PasswordHash = ?, TokenRecuperacion = NULL, FechaRecuperacion = NULL WHERE UsuarioID = ?";
       $updateStmt = $conexion->prepare($updateQuery);
       $updateStmt->bind_param('si', $nuevaContraseña, $usuarioID);
       $updateStmt->execute();

       // Informar al usuario que la contraseña ha sido restablecida
   } else {
       // Informar al usuario que el token no es válido o ha expirado
   }

   // Cerrar la conexión
   $stmt->close();
   $conexion->close();
   ```
   

### Gestión de Perfiles:

1. **Obtener Perfil de Usuario:**

   ```php
   // Conexión a la base de datos

   // Variable de entrada
   $usuarioID = 1;

   // Consulta preparada para obtener el perfil de un usuario
   $query = "SELECT * FROM Perfiles WHERE UsuarioID = ?";
   $stmt = $conexion->prepare($query);
   $stmt->bind_param('i', $usuarioID);
   $stmt->execute();
   $result = $stmt->get_result();

   // Obtener los datos del perfil

   // Cerrar la conexión
   $stmt->close();
   $conexion->close();
   ```

2. **Actualizar Perfil de Usuario:**

   ```php
   // Conexión a la base de datos

   // Variables de entrada
   $usuarioID = 1;
   $nombre = $_POST['nombre'];
   $apellido = $_POST['apellido'];
   $avatarURL = $_POST['avatarURL'];

   // Consulta preparada para actualizar el perfil de un usuario
   $query = "UPDATE Perfiles SET Nombre = ?, Apellido = ?, AvatarURL = ? WHERE UsuarioID = ?";
   $stmt = $conexion->prepare($query);
   $stmt->bind_param('sssi', $nombre, $apellido, $avatarURL, $usuarioID);

   // Verificar si hay algún error en la preparación de la consulta
   if (!$stmt) {
      die('Error en la preparación de la consulta: ' . $conexion->error);
   }

   $stmt->execute();

   // Verificar si la operación fue exitosa
   if ($stmt->affected_rows > 0) {
      $mensaje = "Perfil actualizado correctamente.";
   } else {
      $mensaje = "Error al actualizar el perfil: " . $stmt->error;
   }

   // Cerrar la conexión
   $stmt->close();
   $conexion->close();

   // Mostrar el mensaje
   echo $mensaje;
   ```
### Módulo de Avatares:

1. **Subir Avatar:**

   ```php
   // Conexión a la base de datos

   // Variables de entrada
   $usuarioID = 1;
   $avatar = $_FILES['avatar']; // Suponiendo que se ha enviado el archivo mediante un formulario

   // Verificar y mover el archivo a la ubicación deseada en el servidor
   // Generar una URL o ruta de almacenamiento y almacenarla en la base de datos
   $rutaAlmacenamiento = "ruta/del/almacenamiento/" . $avatar['name'];
   move_uploaded_file($avatar['tmp_name'], $rutaAlmacenamiento);

   // Actualizar la URL del avatar en la base de datos
   $updateQuery = "UPDATE Perfiles SET AvatarURL = ? WHERE UsuarioID = ?";
   $updateStmt = $conexion->prepare($updateQuery);
   $updateStmt->bind_param('si', $rutaAlmacenamiento, $usuarioID);
   $updateStmt->execute();

   // Cerrar la conexión
   $updateStmt->close();
   $conexion->close();
   ```

2. **Eliminar Avatar:**

   ```php
   // Conexión a la base de datos

   // Variable de entrada
   $usuarioID = 1;

   // Obtener la URL del avatar actual en la base de datos
   $selectQuery = "SELECT AvatarURL FROM Perfiles WHERE UsuarioID = ?";
   $selectStmt = $conexion->prepare($selectQuery);
   $selectStmt->bind_param('i', $usuarioID);
   $selectStmt->execute();
   $selectStmt->bind_result($avatarURL);
   $selectStmt->fetch();

   // Eliminar el archivo de la ubicación de almacenamiento
   unlink($avatarURL);

   // Actualizar la URL del avatar en la base de datos
   $updateQuery = "UPDATE Perfiles SET AvatarURL = NULL WHERE UsuarioID = ?";
   $updateStmt = $conexion->prepare($updateQuery);
   $updateStmt->bind_param('i', $usuarioID);
   $updateStmt->execute();

   // Cerrar la conexión
   $selectStmt->close();
   $updateStmt->close();
   $conexion->close();
   ```
   
### Gestión de Pagos:

1. **Obtener Pagos de Usuario:**

   ```php
   // Conexión a la base de datos

   // Variable de entrada
   $usuarioID = 1;

   // Consulta preparada para obtener los pagos de un usuario
   $query = "SELECT * FROM Pagos WHERE UsuarioID = ?";
   $stmt = $conexion->prepare($query);
   $stmt->bind_param('i', $usuarioID);
   $stmt->execute();
   $result = $stmt->get_result();

   // Obtener los datos de los pagos

   // Cerrar la conexión
   $stmt->close();
   $conexion->close();
   ```

2. **Registrar Pago:**

   ```php
   // Conexión a la base de datos

   // Variables de entrada
   $usuarioID = 1;
   $producto = $_POST['producto'];
   $monto = $_POST['monto'];

   // Consulta preparada para registrar un nuevo pago
   $query = "INSERT INTO Pagos (UsuarioID, Producto, Monto) VALUES (?, ?, ?)";
   $stmt = $conexion->prepare($query);
   $stmt->bind_param('iss', $usuarioID, $producto, $monto);
   $stmt->execute();

   // Cerrar la conexión
   $stmt->close();
   $conexion->close();
   ```

### Gestión de Pedidos:

1. **Obtener Pedidos de Usuario:**

   ```php
   // Conexión a la base de datos

   // Variable de entrada
   $usuarioID = 1;

   // Consulta preparada para obtener los pedidos de un usuario
   $query = "SELECT * FROM Pedidos WHERE UsuarioID = ?";
   $stmt = $conexion->prepare($query);
   $stmt->bind_param('i', $usuarioID);
   $stmt->execute();
   $result = $stmt->get_result();

   // Obtener los datos de los pedidos

   // Cerrar la conexión
   $stmt->close();
   $conexion->close();
   ```

2. **Realizar Pedido:**

   ```php
   // Conexión a la base de datos

   // Variables de entrada
   $usuarioID = 1;
   $producto = $_POST['producto'];
   $cantidad = $_POST['cantidad'];
   $fechaPedido = date("Y-m-d"); // Obtener la fecha actual

   // Consulta preparada para realizar un nuevo pedido
   $query = "INSERT INTO Pedidos (UsuarioID, Producto, Cantidad, FechaPedido) VALUES (?, ?, ?, ?)";
   $stmt = $conexion->prepare($query);
   $stmt->bind_param('iss', $usuarioID, $producto, $cantidad, $fechaPedido);
   $stmt->execute();

   // Cerrar la conexión
   $stmt->close();
   $conexion->close();
   ```

Estos ejemplos utilizan consultas preparadas para garantizar la seguridad de las operaciones en la base de datos. Asegúrate de adaptar estos ejemplos según la estructura específica de tu base de datos y los requisitos de tu aplicación.
Además, ten en cuenta que estos ejemplos asumen que se han implementado medidas de seguridad adecuadas, como la validación y escapado de datos para prevenir inyecciones SQL.


# Actualizar Stock (Front y Back)

### Paso 1: Modificar la función `agregarAlCarrito` en el archivo JavaScript (`compras.js`):

```javascript
$(document).on('click', '.agregarAlCarritoBtn', function () {
    var productoId = $(this).data('productoid');
    agregarAlCarrito(productoId);
    mostrarCarrito();
    actualizarStockEnFront(productoId); // Agrega esta línea para actualizar el stock en el front
});

// Nueva función para actualizar el stock en el front
function actualizarStockEnFront(productoId) {
    var producto = productos.find(p => p.ProductoID === productoId);
    if (producto && producto.Stock > 0) {
        producto.Stock--; // Decrementa la cantidad de unidades en stock
        actualizarTarjetaProducto(producto); // Actualiza la tarjeta del producto en el front
    }
}
```

### Paso 2: Modificar la función `realizarPago` en el archivo JavaScript (`compras.js`):

```javascript
$(document).on('click', '#realizarPagoBtn', function () {
    realizarPago();
});

function realizarPago() {
    if (carritoProductos.length > 0) {
        // Enviar la información del carrito al servidor
        $.ajax({
            url: 'compras/procesar_pago.php',
            method: 'POST',
            data: { productos: carritoProductos },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'exito') {
                    // La lógica de procesamiento de pago fue exitosa en el servidor
                    Swal.fire({
                        icon: 'success',
                        title: 'Pago realizado',
                        text: `Pago de $${response.totalPagar} realizado con éxito.`,
                    });

                    // Decrementar la cantidad de unidades en stock en la base de datos
                    decrementarStockEnBaseDeDatos(carritoProductos);

                    // Vaciar el carrito
                    carritoProductos = [];
                    // Actualizar la interfaz gráfica del carrito
                    mostrarCarrito();
                } else {
                    // Hubo un error en el servidor
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al procesar el pago',
                        text: response.message,
                    });
                }
            },
            error: function (error) {
                console.error('Error al procesar el pago en el servidor', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error al procesar el pago',
                    text: 'Hubo un error al comunicarse con el servidor.',
                });
            }
        });
    } else {
        Swal.fire({
            icon: 'info',
            title: 'Carrito vacío',
            text: 'Agrega productos al carrito antes de realizar un pago.',
        });
    }
}

// Nueva función para decrementar la cantidad de unidades en stock en la base de datos
function decrementarStockEnBaseDeDatos(productos) {
    $.ajax({
        url: 'compras/decrementar_stock.php',
        method: 'POST',
        data: { productos: productos },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'exito') {
                console.log('Stock decrementado en la base de datos');
            } else {
                console.error('Error al decrementar el stock en la base de datos:', response.message);
            }
        },
        error: function (error) {
            console.error('Error al comunicarse con el servidor para decrementar el stock:', error);
        }
    });
}
```

### Paso 3: Crear un nuevo archivo PHP llamado `decrementar_stock.php` para manejar la lógica de decrementar el stock en la base de datos:

```php
<?php
session_start();

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
           

 $stmtUpdateStock->close();
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
?>
```

Asegúrate de que esta nueva lógica de decrementar el stock en la base de datos sea segura y cumpla con los requisitos de tu aplicación.




# 🛒 Integración de PayPal

**Paso 1: Incluir la biblioteca de PayPal en tu HTML**

Añade el siguiente script en la sección `<head>` de tu archivo HTML para incluir la biblioteca de PayPal.

```html
<!-- Asegúrate de reemplazar 'TU_CLIENT_ID' con tu ID de cliente de PayPal -->
<script src="https://www.paypal.com/sdk/js?client-id=TU_CLIENT_ID&currency=USD"></script>
```

**Paso 2: Agregar un contenedor para el botón de PayPal en tu HTML**

En tu HTML, crea un contenedor con un identificador específico donde se renderizará el botón de PayPal.

```html
<div id="paypal-button-container"></div>
```

**Paso 3: Modificar tu JavaScript**

Reemplaza tu código JavaScript actual con el siguiente código modificado:

```javascript
// Reemplaza con tu ID de cliente de PayPal
const clientId = 'TU_CLIENT_ID';

// Configuración de PayPal
paypal.Buttons({
  createOrder: function(data, actions) {
    return actions.order.create({
      purchase_units: [{
        amount: {
          currency_code: 'USD',
          value: calcularTotalPagar().toFixed(2),
        },
        description: 'Descripción del pago',
        items: carritoProductos.map(item => {
          return {
            name: item.producto.Nombre,
            description: item.producto.Descripcion,
            unit_amount: {
              currency_code: 'USD',
              value: item.producto.Precio.toFixed(2),
            },
            quantity: item.cantidad,
          };
        }),
      }],
      application_context: {
        shipping_preference: 'NO_SHIPPING',
      },
    });
  },
  onApprove: function(data, actions) {
    return actions.order.capture().then(function(details) {
      // Aquí puedes realizar acciones adicionales después de la aprobación del pago
      alert('Pago completado por ' + details.payer.name.given_name);
    });
  },
  onError: function(err) {
    console.error('Error al procesar el pago:', err);
    // Puedes manejar errores aquí según tus necesidades
  }
}).render('#paypal-button-container');  // ID del contenedor HTML donde se renderizará el botón

function calcularTotalPagar() {
  var total = 0;
  for (var i = 0; i < carritoProductos.length; i++) {
    // Verificar que el precio sea un número antes de sumarlo
    // Obtener el precio del producto y la cantidad
    var precioProducto = parseFloat(carritoProductos[i].producto.Precio);
    var cantidad = carritoProductos[i].cantidad;

    // Verificar que el precio sea un número válido antes de sumarlo
    if (!isNaN(precioProducto) && isFinite(precioProducto) && cantidad > 0) {
      total += precioProducto * cantidad;
    }
  }

  // Verificar que total sea un número antes de devolverlo
  if (typeof total === 'number' && !isNaN(total)) {
    return total; // No es necesario redondear aquí
  } else {
    console.error('Error: El cálculo del total no devolvió un número válido.', total);
    return 0; // Devolver un valor predeterminado en caso de error
  }
}
```

**Paso 4: Ajustes en el servidor (PHP)**

En tu archivo PHP (`procesar_pago.php`), asegúrate de que estás manejando la respuesta de PayPal correctamente después de la aprobación del pago. Puedes usar el objeto `$_POST` para obtener la información relevante.

**Paso 5: Estilo opcional con CSS**

Puedes agregar estilos CSS según tus necesidades para mejorar la apariencia de tu botón de PayPal y otros elementos.

Este es un esquema básico que debería ayudarte a implementar la integración de PayPal en tu aplicación web. Asegúrate de reemplazar 'TU_CLIENT_ID' con tu ID de cliente de PayPal en todos los lugares necesarios.
