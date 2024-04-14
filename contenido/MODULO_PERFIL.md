Aquí tienes un ejemplo básico de cómo podrías crear la interfaz que permite a los usuarios ver y modificar su perfil, incluida la opción de cambiar su contraseña. Utilizaré Bootstrap, jQuery y SweetAlert.

1. **HTML (perfil-usuario.html):**

```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Perfil de Usuario</title>
    <!-- Incluir Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Incluir SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Perfil de Usuario</h2>
            <form id="perfilUsuarioForm">
                <div class="form-group">
                    <label for="inputNombre">Nombre:</label>
                    <input type="text" class="form-control" id="inputNombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="inputEmail">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="inputEmail" name="email" required>
                </div>
                <div class="form-group">
                    <label for="inputPasswordActual">Contraseña Actual:</label>
                    <input type="password" class="form-control" id="inputPasswordActual" name="password_actual">
                </div>
                <div class="form-group">
                    <label for="inputNuevoPassword">Nueva Contraseña:</label>
                    <input type="password" class="form-control" id="inputNuevoPassword" name="nuevo_password">
                </div>
                <button type="button" class="btn btn-primary btn-block" onclick="guardarCambios()">Guardar Cambios</button>
            </form>
        </div>
    </div>
</div>

<!-- Incluir Bootstrap JS y jQuery -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!-- Incluir SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<!-- Tu script personalizado -->
<script src="tu-script.js"></script>

</body>
</html>
```

2. **JavaScript (tu-script.js):**

```javascript
function cargarPerfilUsuario() {
    // Enviar solicitud AJAX para obtener los datos del perfil del usuario
    $.ajax({
        type: "GET",
        url: "ruta/a/tu/controlador_obtener_perfil.php", // Especifica la ruta a tu controlador PHP en el backend
        success: function (response) {
            // Procesar la respuesta del servidor y llenar el formulario con los datos del perfil
            if (response.success) {
                $("#inputNombre").val(response.data.nombre);
                $("#inputEmail").val(response.data.email);
            } else {
                // Mostrar SweetAlert de error
                Swal.fire({
                    icon: 'error',
                    title: 'Error al Cargar el Perfil',
                    text: 'Hubo un problema al cargar los datos del perfil. Inténtalo de nuevo.',
                });
            }
        },
        error: function () {
            // Mostrar SweetAlert de error en caso de fallo en la solicitud AJAX
            Swal.fire({
                icon: 'error',
                title: 'Error en la Solicitud',
                text: 'Hubo un problema al comunicarse con el servidor.',
            });
        }
    });
}

function guardarCambios() {
    // Obtener los datos del formulario
    var nombre = $("#inputNombre").val();
    var email = $("#inputEmail").val();
    var passwordActual = $("#inputPasswordActual").val();
    var nuevoPassword = $("#inputNuevoPassword").val();

    // Validar los datos (puedes agregar más validaciones según tus necesidades)

    // Enviar datos al servidor (puedes usar AJAX)
    $.ajax({
        type: "POST",
        url: "ruta/a/tu/controlador_guardar_cambios_perfil.php", // Especifica la ruta a tu controlador PHP en el backend
        data: {nombre: nombre, email: email, password_actual: passwordActual, nuevo_password: nuevoPassword},
        success: function (response) {
            // Procesar la respuesta del servidor
            if (response.success) {
                // Mostrar SweetAlert de éxito
                Swal.fire({
                    icon: 'success',
                    title: '¡Cambios Guardados!',
                    text: 'Los cambios en el perfil se guardaron correctamente.',
                });
            } else {
                // Mostrar SweetAlert de error
                Swal.fire({
                    icon: 'error',
                    title: 'Error al Guardar Cambios',
                    text: 'Hubo un problema al guardar los cambios en el perfil. Inténtalo de nuevo.',
                });
            }
        },
        error: function () {
            // Mostrar SweetAlert de error en caso de fallo en la solicitud AJAX
            Swal.fire({
                icon: 'error',
                title: 'Error en la Solicitud',
                text: 'Hubo un problema al comunicarse con el servidor.',
            });
        }
    });
}

// Cargar el perfil del usuario al cargar la página
$(document).ready(function () {
    cargarPerfilUsuario();
});
```

3. **PHP (controlador_obtener_perfil.php):**

```php
<?php
// Simula la obtención de datos del perfil del usuario desde la base de datos
$perfilUsuario = array(
    'nombre' => 'NombreUsuario',
    'email' => 'usuario@ejemplo.com'
);

// Devolver la respuesta como JSON
header('Content-Type: application/json');
echo json_encode(array('success' => true, 'data' => $perfilUsuario));
?>
```

4. **PHP (controlador_guardar_cambios_perfil.php):**

```php
<?php
// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$passwordActual = $_POST['password_actual'];
$nuevoPassword = $_POST['nuevo_password'];

// Validar los datos (puedes agregar más validaciones según tus necesidades)

// Simula la actualización de los datos del perfil en la base de datos
// Aquí deberías tener tu lógica de acceso a la base de datos
$actualizacionExitosa = true; // Cambia esto según tu lógica de actualización

// Devolver la respuesta como JSON
if ($actualizacionExitosa) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false));
}
?>
```

Este es un ejemplo básico, y debes ajustar las rutas, las validaciones y otros detalles según tu aplicación. Además, asegúrate de manejar adecuadamente la seguridad, el almacenamiento de contraseñas y la conexión segura con tu servidor.