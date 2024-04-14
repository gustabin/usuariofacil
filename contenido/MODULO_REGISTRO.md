Este es un ejemplo básico de cómo podrías crear la interfaz para que los usuarios se registren utilizando Bootstrap, jQuery y SweetAlert. Asegúrate de incluir las bibliotecas de Bootstrap, jQuery y SweetAlert en tu proyecto antes de utilizar este código. Puedes descargarlas e incluirlas en tus archivos o utilizar enlaces CDN.

Aquí tienes un ejemplo:

1. **HTML (registro.html):**

```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registro de Usuario</title>
    <!-- Incluir Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Incluir SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Registro de Usuario</h2>
            <form id="registroForm">
                <div class="form-group">
                    <label for="inputEmail">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="inputEmail" name="email" required>
                </div>
                <div class="form-group">
                    <label for="inputPassword">Contraseña:</label>
                    <input type="password" class="form-control" id="inputPassword" name="password" required>
                </div>
                <button type="button" class="btn btn-primary btn-block" onclick="registrarUsuario()">Registrar</button>
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
function registrarUsuario() {
    // Obtener los datos del formulario
    var email = $("#inputEmail").val();
    var password = $("#inputPassword").val();

    // Validar los datos (puedes agregar más validaciones según tus necesidades)

    // Enviar datos al servidor (puedes usar AJAX)
    $.ajax({
        type: "POST",
        url: "ruta/a/tu/controlador.php", // Especifica la ruta a tu controlador PHP en el backend
        data: {email: email, password: password},
        success: function (response) {
            // Procesar la respuesta del servidor
            if (response.success) {
                // Mostrar SweetAlert de éxito
                Swal.fire({
                    icon: 'success',
                    title: '¡Registro Exitoso!',
                    text: 'El usuario se ha registrado correctamente.',
                }).then(function () {
                    // Redirigir a otra página o realizar alguna acción adicional si es necesario
                    window.location.href = "tu-pagina-de-bienvenida.html";
                });
            } else {
                // Mostrar SweetAlert de error
                Swal.fire({
                    icon: 'error',
                    title: 'Error en el Registro',
                    text: 'Hubo un problema al registrar el usuario. Inténtalo de nuevo.',
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
```

Este es un ejemplo básico y deberás adaptarlo según la estructura de tu aplicación y cómo manejas las solicitudes en el backend. Asegúrate de manejar adecuadamente la seguridad, la validación de datos y la conexión segura con tu servidor.