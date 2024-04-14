Aquí tienes un ejemplo básico de cómo podrías crear la interfaz de inicio de sesión y la funcionalidad correspondiente utilizando Bootstrap, jQuery y SweetAlert.

1. **HTML (login.html):**

```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Iniciar Sesión</title>
    <!-- Incluir Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Incluir SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Iniciar Sesión</h2>
            <form id="loginForm">
                <div class="form-group">
                    <label for="inputEmail">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="inputEmail" name="email" required>
                </div>
                <div class="form-group">
                    <label for="inputPassword">Contraseña:</label>
                    <input type="password" class="form-control" id="inputPassword" name="password" required>
                </div>
                <button type="button" class="btn btn-primary btn-block" onclick="iniciarSesion()">Iniciar Sesión</button>
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
function iniciarSesion() {
    // Obtener los datos del formulario
    var email = $("#inputEmail").val();
    var password = $("#inputPassword").val();

    // Validar los datos (puedes agregar más validaciones según tus necesidades)

    // Enviar datos al servidor (puedes usar AJAX)
    $.ajax({
        type: "POST",
        url: "ruta/a/tu/controlador_iniciar_sesion.php", // Especifica la ruta a tu controlador PHP en el backend
        data: {email: email, password: password},
        success: function (response) {
            // Procesar la respuesta del servidor
            if (response.success) {
                // Mostrar SweetAlert de éxito y redirigir a otra página
                Swal.fire({
                    icon: 'success',
                    title: '¡Inicio de Sesión Exitoso!',
                    text: 'Has iniciado sesión correctamente.',
                }).then(function () {
                    window.location.href = "tu-pagina-de-bienvenida.html";
                });
            } else {
                // Mostrar SweetAlert de error
                Swal.fire({
                    icon: 'error',
                    title: 'Error en el Inicio de Sesión',
                    text: 'Las credenciales proporcionadas no son válidas. Inténtalo de nuevo.',
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

Ajusta las rutas, las validaciones y otros detalles según tu aplicación. Este es un ejemplo básico y puede necesitar modificaciones según tus necesidades específicas. Además, asegúrate de manejar las credenciales de forma segura y utilizar conexiones HTTPS para proteger la información durante la transmisión.