
 En este ejemplo, exploraremos el Front End de la gestión de usuarios, centrándonos en el formulario de registro de usuario y la interacción entre el cliente y el servidor mediante AJAX.

### Gestión de Usuarios: FRONT END

1. **Registrar Usuario:**
El código HTML proporciona la estructura básica para el formulario de registro de usuario. Utiliza Bootstrap para estilos y jQuery para simplificar la manipulación del DOM y las solicitudes AJAX. El formulario incluye campos para el correo electrónico y la contraseña, junto con un botón de registro.

index.html:
```html
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Registro de Usuario</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <!-- Sweet Alert CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h4>Registro de Usuario</h4>
          </div>
          <div class="card-body">
            <form id="registroForm">
              <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <button type="submit" class="btn btn-primary">Registrar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and Popper.js -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <!-- Sweet Alert JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <!-- Custom JS -->
  <script src="registro.js"></script>
</body>
</html>
```

El archivo JavaScript (`registro.js`) contiene la lógica del cliente para manejar la interacción del usuario cuando el usuario hace clic en el botón de registro. (Dentro de una función), se recopilan los datos del formulario y se realiza una solicitud AJAX utilizando jQuery. La respuesta del servidor se procesa para mostrar un mensaje SweetAlert que informa al usuario sobre el resultado de la operación.


registro.js
```javascript
$(document).ready(function () {
  // Intercepta el envío del formulario
  $('#registroForm').submit(function (e) {
    e.preventDefault(); // Evita que el formulario se envíe de la manera tradicional

    // Realiza la solicitud AJAX al microservicio
    $.ajax({
      type: 'POST',
      url: 'microservicio.php', // Ajusta la ruta según la ubicación de tu microservicio
      data: $(this).serialize(),
      dataType: 'json',
      success: function (response) {
        // Muestra el Sweet Alert según la respuesta del microservicio
        if (response.status === 'exito') {
          Swal.fire('Éxito', response.message, 'success');
        } else {
          Swal.fire('Error', response.message, 'error');
        }
      },
      error: function () {
        // Muestra un Sweet Alert en caso de error en la solicitud AJAX
        Swal.fire('Error', 'Error de comunicación con el servidor', 'error');
      }
    });
  });
});

```
El lado del servidor está representado por el archivo PHP (`registrar_usuario.php`). Aquí se maneja la lógica de registro real. Se reciben los datos del formulario, se realizan las validaciones necesarias y se inserta el nuevo usuario en la base de datos. La respuesta al cliente incluye un título, un mensaje y un tipo para personalizar la notificación de SweetAlert.

Este enfoque de gestión de usuarios garantiza una experiencia de registro fluida y segura para los usuarios, al mismo tiempo que proporciona un manejo adecuado de los datos en el lado del servidor. La integración de tecnologías como jQuery y SweetAlert mejora la usabilidad y la presentación de mensajes al usuario, facilitando el entendimiento de la interacción.


2. **Verificar Usuario:**
El código HTML proporciona la estructura básica de la interfaz de usuario para la verificación del usuario. Se utiliza Bootstrap para el diseño y estilos responsivos. La interfaz incluye un botón de verificación que el usuario puede hacer clic para confirmar su cuenta.

```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Verificación de Usuario</title>
    <!-- Enlace a la biblioteca jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Enlace a la biblioteca SweetAlert -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Verificación de Usuario</h2>
            <p>Haz clic en el botón para verificar tu cuenta:</p>
            <button type="button" class="btn btn-primary" onclick="verificarUsuario()">Verificar Cuenta</button>
        </div>
    </div>
</div>

<!-- Incluir el script JavaScript -->
<script src="script.js"></script>

</body>
</html>
```

**Verificar Usuario: JavaScript (script.js):**
El archivo JavaScript (`script.js`) contiene la lógica del cliente para manejar la interacción del usuario. La función `verificarUsuario()` se activa cuando el usuario hace clic en el botón de verificación. Dentro de esta función, se realiza una solicitud AJAX utilizando jQuery para comunicarse con el servidor.

```javascript
// script.js

function verificarUsuario() {
    // Realizar la petición AJAX con jQuery
    $.ajax({
        type: 'POST',
        url: 'procesar_verificacion.php',
        success: function (response) {
            // Mostrar SweetAlert con la respuesta del servidor
            swal(response.title, response.message, response.type);
        },
        error: function () {
            // Mostrar SweetAlert en caso de error
            swal("Error", "Hubo un error en la solicitud. Por favor, inténtalo de nuevo.", "error");
        }
    });
}
```

**Procesar Verificación: PHP (procesar_verificacion.php):**
El lado del servidor está representado por el archivo PHP (`procesar_verificacion.php`). Aquí se maneja la lógica de marcar al usuario como verificado en la base de datos.

```php
// procesar_verificacion.php

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

// Enviar respuesta al cliente en formato JSON
echo json_encode(['title' => 'Éxito', 'message' => '¡Tu cuenta ha sido verificada!', 'type' => 'success']);
```

3. **Autenticar Usuario:**
El código HTML establece la estructura de la interfaz de usuario para la autenticación. Bootstrap se utiliza para el diseño y estilos. La interfaz incluye campos para ingresar el correo electrónico y la contraseña, así como un botón para enviar la solicitud de autenticación.

```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Autenticación de Usuario</title>
    <!-- Enlace a la biblioteca jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Enlace a la biblioteca SweetAlert -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Autenticación de Usuario</h2>
            <form id="autenticarForm">
                <div class="form-group">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="button" class="btn btn-primary" onclick="autenticarUsuario()">Iniciar Sesión</button>
            </form>
        </div>
    </div>
</div>

<!-- Incluir el script JavaScript -->
<script src="script.js"></script>

</body>
</html>
```

**Autenticar Usuario: JavaScript (script.js):**
El archivo JavaScript (`script.js`) contiene la lógica del cliente para manejar la autenticación del usuario. La función `autenticarUsuario()` se activa cuando el usuario hace clic en el botón de iniciar sesión. Dentro de esta función, se realiza una solicitud AJAX utilizando jQuery para enviar las credenciales al servidor y procesar la respuesta.

```javascript
// script.js

function autenticarUsuario() {
    // Obtener los datos del formulario
    var email = $('#email').val();
    var password = $('#password').val();

    // Realizar la petición AJAX con jQuery
    $.ajax({
        type: 'POST',
        url: 'procesar_autenticacion.php',
        data: { email: email, password: password },
        success: function (response) {
            // Mostrar SweetAlert con la respuesta del servidor
            swal(response.title, response.message, response.type);
        },
        error: function () {
            // Mostrar SweetAlert en caso de error
            swal("Error", "Hubo un error en la solicitud. Por favor, inténtalo de nuevo.", "error");
        }
    });
}
```

En este punto, el archivo `procesar_autenticacion.php` en el lado del servidor manejaría la lógica de autenticación real.


**Autenticar Usuario: PHP (procesar_autenticacion.php):**
Este archivo PHP maneja la lógica de autenticación. Compara las credenciales proporcionadas con las almacenadas en la base de datos y devuelve una respuesta en formato JSON.

```php
<?php
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
if (password_verify($password, $hashAlmacenado)) {
    // Contraseña válida
    $respuesta = ['title' => 'Éxito', 'message' => '¡Inicio de sesión exitoso!', 'type' => 'success'];
} else {
    // Contraseña incorrecta
    $respuesta = ['title' => 'Error', 'message' => 'Credenciales incorrectas. Inténtalo de nuevo.', 'type' => 'error'];
}

// Cerrar la conexión
$stmt->close();
$conexion->close();

// Enviar respuesta al cliente en formato JSON
echo json_encode($respuesta);
?>
```

En este código, después de verificar la contraseña utilizando `password_verify`, se crea un array `$respuesta` que contiene el título, el mensaje y el tipo de respuesta. Este array se convierte a JSON y se envía al cliente como respuesta.

### Recuperación de Contraseña:


**Solicitud de Restablecimiento de Contraseña: HTML:**
El código HTML establece la estructura de la interfaz de usuario para la solicitud de restablecimiento de contraseña. Se utiliza Bootstrap para el diseño y estilos. La interfaz incluye un campo para ingresar el correo electrónico y un botón para enviar la solicitud.

```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Solicitud de Restablecimiento de Contraseña</title>
    <!-- Enlace a la biblioteca jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Enlace a la biblioteca SweetAlert -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Solicitud de Restablecimiento de Contraseña</h2>
            <form id="solicitudForm">
                <div class="form-group">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <button type="button" class="btn btn-primary" onclick="solicitarRestablecimiento()">Enviar Solicitud</button>
            </form>
        </div>
    </div>
</div>

<!-- Incluir el script JavaScript -->
<script src="script.js"></script>

</body>
</html>
```

**Solicitud de Restablecimiento de Contraseña: JavaScript (script.js):**
El archivo JavaScript (`script.js`) contiene la lógica del cliente para manejar la solicitud de restablecimiento de contraseña. La función `solicitarRestablecimiento()` se activa cuando el usuario hace clic en el botón de enviar solicitud. Dentro de esta función, se realiza una solicitud AJAX utilizando jQuery para enviar el correo electrónico al servidor y procesar la respuesta.

```javascript
// script.js

function solicitarRestablecimiento() {
    // Obtener el correo electrónico del formulario
    var email = $('#email').val();

    // Realizar la petición AJAX con jQuery
    $.ajax({
        type: 'POST',
        url: 'procesar_solicitud.php',
        data: { email: email },
        success: function (response) {
            // Mostrar SweetAlert con la respuesta del servidor
            swal(response.title, response.message, response.type);
        },
        error: function () {
            // Mostrar SweetAlert en caso de error
            swal("Error", "Hubo un error en la solicitud. Por favor, inténtalo de nuevo.", "error");
        }
    });
}
```

**Solicitud de Restablecimiento de Contraseña: PHP (procesar_solicitud.php):**
Este archivo PHP (`procesar_solicitud.php`) maneja la lógica de la solicitud de restablecimiento. Genera un token único, actualiza la base de datos con el token y la fecha de solicitud, y puede enviar un correo electrónico al usuario con el enlace de restablecimiento.

```php
<?php
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

// Simular el envío de un correo electrónico al usuario con el enlace de restablecimiento

// Cerrar la conexión
$stmt->close();
$conexion->close();

// Enviar respuesta al cliente en formato JSON
echo json_encode(['title' => 'Éxito', 'message' => '¡Solicitud enviada con éxito!', 'type' => 'success']);
?>
```


2. **Procesar enlace de Restablecimiento de Contraseña:**
La interfaz incluye campos para ingresar la nueva contraseña y un botón para enviar la solicitud de restablecimiento.

```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Restablecimiento de Contraseña</title>
    <!-- Enlace a la biblioteca jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Enlace a la biblioteca SweetAlert -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Restablecimiento de Contraseña</h2>
            <form id="restablecerForm">
                <div class="form-group">
                    <label for="password">Nueva Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirmar Contraseña:</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                </div>
                <button type="button" class="btn btn-primary" onclick="restablecerContraseña()">Restablecer Contraseña</button>
            </form>
        </div>
    </div>
</div>

<!-- Incluir el script JavaScript -->
<script src="script.js"></script>

</body>
</html>
```

**Restablecimiento de Contraseña: JavaScript (script.js):**
El archivo JavaScript (`script.js`) contiene la lógica del cliente para manejar el restablecimiento de contraseña. La función `restablecerContraseña()` se activa cuando el usuario hace clic en el botón para restablecer la contraseña. Dentro de esta función, se realiza una solicitud AJAX utilizando jQuery para enviar la nueva contraseña al servidor y procesar la respuesta.

```javascript
// script.js

function restablecerContraseña() {
    // Obtener los datos del formulario
    var password = $('#password').val();
    var confirmPassword = $('#confirmPassword').val();

    // Verificar que las contraseñas coincidan
    if (password === confirmPassword) {
        // Realizar la petición AJAX con jQuery
        $.ajax({
            type: 'POST',
            url: 'procesar_restablecimiento.php',
            data: { password: password },
            success: function (response) {
                // Mostrar SweetAlert con la respuesta del servidor
                swal(response.title, response.message, response.type);
            },
            error: function () {
                // Mostrar SweetAlert en caso de error
                swal("Error", "Hubo un error en la solicitud. Por favor, inténtalo de nuevo.", "error");
            }
        });
    } else {
        // Mostrar SweetAlert indicando que las contraseñas no coinciden
        swal("Error", "Las contraseñas no coinciden. Por favor, verifica.", "error");
    }
}
```

**Restablecimiento de Contraseña: PHP (procesar_restablecimiento.php):**
Este archivo PHP (`procesar_restablecimiento.php`) maneja la lógica del restablecimiento de contraseña. En este punto, deberías tener la lógica necesaria para actualizar la contraseña del usuario en la base de datos. En este ejemplo, simplemente se muestra un mensaje de éxito.

```php
<?php
// Conexión a la base de datos

// Variables de entrada
$password = $_POST['password'];

// Actualizar la contraseña del usuario en la base de datos (agrega la lógica necesaria)
// ...

// Cerrar la conexión

// Enviar respuesta al cliente en formato JSON
echo json_encode(['title' => 'Éxito', 'message' => 'Contraseña restablecida con éxito.', 'type' => 'success']);
?>
```

3. **Restablecer Contraseña:**
La funcionalidad de "Restablecer Contraseña" permite a los usuarios cambiar su contraseña después de solicitar un restablecimiento mediante un token único. Este proceso involucra la verificación del token y la fecha de solicitud antes de permitir el restablecimiento de la contraseña.

```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Restablecer Contraseña</title>
    <!-- Enlace a la biblioteca jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Enlace a la biblioteca SweetAlert -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Restablecer Contraseña</h2>
            <form id="restablecerForm">
                <div class="form-group">
                    <label for="token">Token:</label>
                    <input type="text" class="form-control" id="token" name="token" required>
                </div>
                <div class="form-group">
                    <label for="nuevaContraseña">Nueva Contraseña:</label>
                    <input type="password" class="form-control" id="nuevaContraseña" name="nuevaContraseña" required>
                </div>
                <button type="button" class="btn btn-primary" onclick="restablecerContraseña()">Restablecer Contraseña</button>
            </form>
        </div>
    </div>
</div>

<!-- Incluir el script JavaScript -->
<script src="script.js"></script>

</body>
</html>
```

**Restablecer Contraseña: JavaScript (script.js):**
El archivo JavaScript (`script.js`) contiene la lógica del cliente para manejar el restablecimiento de contraseña. La función `restablecerContraseña()` se activa cuando el usuario hace clic en el botón para restablecer la contraseña. Dentro de esta función, se realiza una solicitud AJAX utilizando jQuery para enviar el token y la nueva contraseña al servidor y procesar la respuesta.

```javascript
// script.js

function restablecerContraseña() {
    // Obtener los datos del formulario
    var token = $('#token').val();
    var nuevaContraseña = $('#nuevaContraseña').val();

    // Realizar la petición AJAX con jQuery
    $.ajax({
        type: 'POST',
        url: 'procesar_restablecimiento.php',
        data: { token: token, nuevaContraseña: nuevaContraseña },
        success: function (response) {
            // Mostrar SweetAlert con la respuesta del servidor
            swal(response.title, response.message, response.type);
        },
        error: function () {
            // Mostrar SweetAlert en caso de error
            swal("Error", "Hubo un error en la solicitud. Por favor, inténtalo de nuevo.", "error");
        }
    });
}
```

**Restablecer Contraseña: PHP (procesar_restablecimiento.php):**
Este archivo PHP (`procesar_restablecimiento.php`) maneja la lógica del restablecimiento de contraseña. Verifica la validez del token y la fecha de solicitud antes de actualizar la contraseña del usuario en la base de datos.

```php
<?php
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

    //

 Informar al usuario que la contraseña ha sido restablecida
    $respuesta = ['title' => 'Éxito', 'message' => 'Contraseña restablecida con éxito.', 'type' => 'success'];
} else {
    // Informar al usuario que el token no es válido o ha expirado
    $respuesta = ['title' => 'Error', 'message' => 'Token no válido o expirado. Por favor, solicita un nuevo restablecimiento.', 'type' => 'error'];
}

// Cerrar la conexión
$stmt->close();
$conexion->close();

// Enviar respuesta al cliente en formato JSON
echo json_encode($respuesta);
?>
```


### Gestión de Perfiles:

La "Gestión de Perfiles" implica la obtención de información específica del perfil de un usuario almacenada en la base de datos. 

El código HTML establece la estructura de la interfaz de usuario para obtener el perfil de un usuario. 
La interfaz incluye un área donde se mostrarán los detalles del perfil y un botón para activar la solicitud de obtención del perfil.

```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Obtener Perfil de Usuario</title>
    <!-- Enlace a la biblioteca jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Enlace a la biblioteca SweetAlert -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Obtener Perfil de Usuario</h2>
            <button type="button" class="btn btn-primary" onclick="obtenerPerfil()">Obtener Perfil</button>
            <div id="perfilInfo" class="mt-3">
                <!-- Aquí se mostrará la información del perfil -->
            </div>
        </div>
    </div>
</div>

<!-- Incluir el script JavaScript -->
<script src="script.js"></script>

</body>
</html>
```

**Obtener Perfil de Usuario: JavaScript (script.js):**
El archivo JavaScript (`script.js`) contiene la lógica del cliente para manejar la solicitud de obtención de perfil. La función `obtenerPerfil()` se activa cuando el usuario hace clic en el botón para obtener el perfil. Dentro de esta función, se realiza una solicitud AJAX utilizando jQuery para obtener los datos del perfil del servidor y procesar la respuesta.

```javascript
// script.js

function obtenerPerfil() {
    // Realizar la petición AJAX con jQuery
    $.ajax({
        type: 'POST',
        url: 'procesar_obtener_perfil.php',
        success: function (response) {
            // Mostrar SweetAlert con la respuesta del servidor
            swal(response.title, response.message, response.type);

            // Mostrar la información del perfil si la solicitud fue exitosa
            if (response.type === 'success') {
                $('#perfilInfo').html(response.profileInfo);
            }
        },
        error: function () {
            // Mostrar SweetAlert en caso de error
            swal("Error", "Hubo un error en la solicitud. Por favor, inténtalo de nuevo.", "error");
        }
    });
}
```

**Obtener Perfil de Usuario: PHP (procesar_obtener_perfil.php):**
Este archivo PHP (`procesar_obtener_perfil.php`) maneja la lógica de obtención del perfil de usuario. Realiza una consulta preparada para obtener los datos del perfil del usuario especificado por su `UsuarioID`. Los datos del perfil se formatean y se envían de vuelta al cliente en formato JSON.

```php
<?php
// Conexión a la base de datos

// Variable de entrada
$usuarioID = 1; // Este valor debe provenir de la sesión o de la interfaz de usuario

// Consulta preparada para obtener el perfil de un usuario
$query = "SELECT * FROM Perfiles WHERE UsuarioID = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('i', $usuarioID);
$stmt->execute();
$result = $stmt->get_result();

// Obtener los datos del perfil
if ($result->num_rows > 0) {
    $perfil = $result->fetch_assoc();
    $perfilInfo = '<p><strong>Nombre:</strong> ' . $perfil['Nombre'] . '</p>';
    $perfilInfo .= '<p><strong>Email:</strong> ' . $perfil['Email'] . '</p>';
    // Agregar más campos según la estructura de tu base de datos
} else {
    $perfilInfo = 'No se encontró información de perfil para el usuario.';
}

// Cerrar la conexión
$stmt->close();
$conexion->close();

// Enviar respuesta al cliente en formato JSON
echo json_encode(['title' => 'Éxito', 'message' => 'Perfil obtenido con éxito.', 'type' => 'success', 'profileInfo' => $perfilInfo]);
?>
```

Este código PHP realiza la consulta preparada para obtener los datos del perfil del usuario y formatea la información para enviarla de vuelta al cliente en formato JSON. 

2. **Actualizar Perfil de Usuario:**
**Introducción:**
La "Actualización de Perfil" permite a los usuarios modificar información específica en su perfil, como el nombre, el apellido y la URL del avatar.
La interfaz incluye formularios con campos para el nombre, apellido y la URL del avatar, así como un botón para activar la solicitud de actualización del perfil.

```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Actualizar Perfil</title>
    <!-- Enlace a la biblioteca jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Enlace a la biblioteca SweetAlert -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Actualizar Perfil</h2>
            <form id="perfilForm">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido:</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" required>
                </div>
                <div class="form-group">
                    <label for="avatarURL">URL del Avatar:</label>
                    <input type="text" class="form-control" id="avatarURL" name="avatarURL" required>
                </div>
                <button type="button" class="btn btn-primary" onclick="actualizarPerfil()">Actualizar Perfil</button>
            </form>
        </div>
    </div>
</div>

<!-- Incluir el script JavaScript -->
<script src="script.js"></script>

</body>
</html>
```

**Actualizar Perfil: JavaScript (script.js):**
El archivo JavaScript (`script.js`) contiene la lógica del cliente para manejar la solicitud de actualización del perfil. La función `actualizarPerfil()` se activa cuando el usuario hace clic en el botón para actualizar el perfil. Dentro de esta función, se obtienen los datos del formulario y se realiza una solicitud AJAX utilizando jQuery para enviar la información al servidor y procesar la respuesta.

```javascript
// script.js

function actualizarPerfil() {
    // Obtener los datos del formulario
    var nombre = $('#nombre').val();
    var apellido = $('#apellido').val();
    var avatarURL = $('#avatarURL').val();

    // Realizar la petición AJAX con jQuery
    $.ajax({
        type: 'POST',
        url: 'procesar_actualizar_perfil.php',
        data: { nombre: nombre, apellido: apellido, avatarURL: avatarURL },
        success: function (response) {
            // Mostrar SweetAlert con la respuesta del servidor
            swal("Mensaje", response, "info");
        },
        error: function () {
            // Mostrar SweetAlert en caso de error
            swal("Error", "Hubo un error en la solicitud. Por favor, inténtalo de nuevo.", "error");
        }
    });
}
```

**Actualizar Perfil: PHP (procesar_actualizar_perfil.php):**
Este archivo PHP (`procesar_actualizar_perfil.php`) maneja la lógica de actualización del perfil de usuario. Recibe los datos del formulario, realiza una consulta preparada para actualizar el perfil en la base de datos y envía un mensaje de éxito o error al cliente.

```php
<?php
// Conexión a la base de datos

// Variables de entrada
$usuarioID = 1; // Este valor debe provenir de la sesión o de la interfaz de usuario
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
?>
```

Este código PHP recibe los datos del formulario, ejecuta la consulta preparada para actualizar el perfil y envía un mensaje de éxito o error de vuelta al cliente. 

### Módulo de Avatares:

1. **Subir Avatar:**
La funcionalidad de "Cargar Avatar" permite a los usuarios seleccionar y cargar una imagen de perfil personalizada. La imagen se procesa en el servidor y se almacena en una ubicación específica.
La interfaz incluye un formulario con un campo de entrada de archivo para seleccionar el avatar y un botón para activar la solicitud de carga del avatar.

```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cargar Avatar</title>
    <!-- Enlace a la biblioteca jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Enlace a la biblioteca SweetAlert -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Cargar Avatar</h2>
            <form id="avatarForm" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="avatar">Seleccionar Avatar:</label>
                    <input type="file" class="form-control-file" id="avatar" name="avatar" accept="image/*" required>
                </div>
                <button type="button" class="btn btn-primary" onclick="cargarAvatar()">Cargar Avatar</button>
            </form>
        </div>
    </div>
</div>

<!-- Incluir el script JavaScript -->
<script src="script.js"></script>

</body>
</html>
```

**Cargar Avatar: JavaScript (script.js):**
El archivo JavaScript (`script.js`) contiene la lógica del cliente para manejar la solicitud de carga del avatar. La función `cargarAvatar()` se activa cuando el usuario hace clic en el botón para cargar el avatar. Dentro de esta función, se obtiene el formulario y se realiza una solicitud AJAX utilizando jQuery para enviar el archivo al servidor y procesar la respuesta.

```javascript
// script.js

function cargarAvatar() {
    // Obtener el formulario y los datos del archivo
    var formData = new FormData($('#avatarForm')[0]);

    // Realizar la petición AJAX con jQuery
    $.ajax({
        type: 'POST',
        url: 'procesar_cargar_avatar.php',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            // Mostrar SweetAlert con la respuesta del servidor
            swal("Mensaje", response, "info");
        },
        error: function () {
            // Mostrar SweetAlert en caso de error
            swal("Error", "Hubo un error en la solicitud. Por favor, inténtalo de nuevo.", "error");
        }
    });
}
```

**Cargar Avatar: PHP (procesar_cargar_avatar.php):**
Este archivo PHP (`procesar_cargar_avatar.php`) maneja la lógica de carga del avatar en el servidor. Recibe el archivo, lo verifica y lo mueve a la ubicación deseada. Luego, actualiza la URL del avatar en la base de datos y envía un mensaje de éxito o error al cliente.

```php
<?php
// Conexión a la base de datos

// Variables de entrada
$usuarioID = 1; // Este valor debe provenir de la sesión o de la interfaz de usuario
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

// Verificar si la operación fue exitosa
if ($updateStmt->affected_rows > 0) {
    $mensaje = "Avatar cargado y actualizado correctamente.";
} else {
    $mensaje = "Error al cargar el avatar: " . $updateStmt->error;
}

// Cerrar la conexión
$updateStmt->close();
$conexion->close();

// Mostrar el mensaje
echo $mensaje;
?>
```

Este código PHP recibe el archivo del formulario, lo verifica y mueve a la ubicación deseada. Luego, actualiza la URL del avatar en la base de datos y envía un mensaje de éxito o error al cliente. 

2. **Eliminar Avatar:**
La funcionalidad de "Eliminar Avatar" permite a los usuarios eliminar su imagen de avatar actual. Esta acción implica la eliminación del archivo de la ubicación de almacenamiento y la actualización del registro en la base de datos. 
La interfaz incluye un botón que, al hacer clic, activará la solicitud de eliminación del avatar.

```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Eliminar Avatar</title>
    <!-- Enlace a la biblioteca jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Enlace a la biblioteca SweetAlert -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Eliminar Avatar</h2>
            <button type="button" class="btn btn-danger" onclick="eliminarAvatar()">Eliminar Avatar</button>
        </div>
    </div>
</div>

<!-- Incluir el script JavaScript -->
<script src="script.js"></script>

</body>
</html>
```

**Eliminar Avatar: JavaScript (script.js):**
El archivo JavaScript (`script.js`) contiene la lógica del cliente para manejar la solicitud de eliminación del avatar. La función `eliminarAvatar()` se activa cuando el usuario hace clic en el botón para eliminar el avatar. Dentro de esta función, se realiza una solicitud AJAX utilizando jQuery para enviar la solicitud al servidor y procesar la respuesta.

```javascript
// script.js

function eliminarAvatar() {
    // Realizar la petición AJAX con jQuery
    $.ajax({
        type: 'POST',
        url: 'procesar_eliminar_avatar.php',
        data: { usuarioID: 1 }, // Deberías obtener el usuarioID de la sesión o la interfaz de usuario
        success: function (response) {
            // Mostrar SweetAlert con la respuesta del servidor
            swal("Mensaje", response, "info");
        },
        error: function () {
            // Mostrar SweetAlert en caso de error
            swal("Error", "Hubo un error en la solicitud. Por favor, inténtalo de nuevo.", "error");
        }
    });
}
```

**Eliminar Avatar: PHP (procesar_eliminar_avatar.php):**
Este archivo PHP (`procesar_eliminar_avatar.php`) maneja la lógica de eliminación del avatar en el servidor. Recibe el ID del usuario, obtiene la URL del avatar actual, elimina el archivo de la ubicación de almacenamiento y actualiza la URL del avatar en la base de datos. Luego, envía un mensaje de éxito o error al cliente.

```php
<?php
// Conexión a la base de datos

// Variable de entrada
$usuarioID = $_POST['usuarioID'];

// Obtener la URL del avatar actual en la base de datos
$selectQuery = "SELECT AvatarURL FROM Perfiles WHERE UsuarioID = ?";
$selectStmt = $conexion->prepare($selectQuery);
$selectStmt->bind_param('i', $usuarioID);
$selectStmt->execute();
$selectStmt->bind_result($avatarURL);
$selectStmt->fetch();

// Verificar si la URL del avatar existe y eliminar el archivo de la ubicación de almacenamiento
if ($avatarURL) {
    unlink($avatarURL);

    // Actualizar la URL del avatar en la base de datos
    $updateQuery = "UPDATE Perfiles SET AvatarURL = NULL WHERE UsuarioID = ?";
    $updateStmt = $conexion->prepare($updateQuery);
    $updateStmt->bind_param('i', $usuarioID);
    $updateStmt->execute();

    // Verificar si la operación fue exitosa
    if ($updateStmt->affected_rows > 0) {
        $mensaje = "Avatar eliminado correctamente.";
    } else {
        $mensaje = "Error al actualizar el perfil: " . $updateStmt->error;
    }

    // Cerrar la conexión
    $updateStmt->close();
} else {
    $mensaje = "El usuario no tiene un avatar para eliminar.";
}

$selectStmt->close();
$conexion->close();

// Mostrar el mensaje
echo $mensaje;
?>
```

Este código PHP recibe el ID del usuario, elimina el archivo del avatar de la ubicación de almacenamiento y actualiza la URL del avatar en la base de datos. Luego, envía un mensaje de éxito o error al cliente.