Para implementar la opción de recuperación de contraseña a través del correo electrónico, puedes seguir estos pasos. Asumiré que ya has configurado PHPMailer como se mencionó anteriormente.

1. **HTML (recuperar-password.html):**

```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Recuperar Contraseña</title>
    <!-- Incluir Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Incluir SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Recuperar Contraseña</h2>
            <form id="recuperarPasswordForm">
                <div class="form-group">
                    <label for="inputEmail">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="inputEmail" name="email" required>
                </div>
                <button type="button" class="btn btn-primary btn-block" onclick="recuperarContraseña()">Recuperar Contraseña</button>
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
function recuperarContraseña() {
    // Obtener el correo electrónico del formulario
    var email = $("#inputEmail").val();

    // Validar el correo electrónico (puedes agregar más validaciones según tus necesidades)

    // Enviar datos al servidor (puedes usar AJAX)
    $.ajax({
        type: "POST",
        url: "ruta/a/tu/controlador_recuperar_contraseña.php", // Especifica la ruta a tu controlador PHP en el backend
        data: {email: email},
        success: function (response) {
            // Procesar la respuesta del servidor
            if (response.success) {
                // Mostrar SweetAlert de éxito
                Swal.fire({
                    icon: 'success',
                    title: '¡Correo de Recuperación Enviado!',
                    text: 'Hemos enviado un correo con instrucciones para recuperar tu contraseña.',
                });
            } else {
                // Mostrar SweetAlert de error
                Swal.fire({
                    icon: 'error',
                    title: 'Error al Recuperar Contraseña',
                    text: 'No se encontró una cuenta asociada a este correo electrónico. Verifica la dirección proporcionada.',
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

3. **PHP (controlador_recuperar_contraseña.php):**

```php
<?php
// Incluir la biblioteca PHPMailer
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';

// Obtener el correo electrónico del formulario
$email = $_POST['email'];

// Validar el correo electrónico (puedes agregar más validaciones según tus necesidades)

// Verificar si el correo electrónico está registrado en la base de datos (aquí deberías tener tu lógica de acceso a la base de datos)
$usuarioRegistrado = true; // Debes implementar tu lógica para verificar si el correo está registrado

if ($usuarioRegistrado) {
    // Generar un token único para la recuperación de contraseña (puedes usar alguna función hash o generar un token aleatorio)
    $tokenRecuperacion = bin2hex(random_bytes(32));

    // Almacenar el token en la base de datos junto con el correo electrónico y la fecha de expiración (aquí deberías tener tu lógica de acceso a la base de datos)

    // Configuración del servidor SMTP
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'tu-servidor-smtp.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'tu-correo@gmail.com'; // Tu dirección de correo electrónico SMTP
    $mail->Password = 'tu-contrasena'; // Tu contraseña SMTP
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Configuración del correo
    $mail->setFrom('tu-correo@gmail.com', 'Tu Nombre');
    $mail->addAddress($email);
    $mail->Subject = 'Recuperación de Contraseña';
    $mail->Body = 'Haz clic en el siguiente enlace para restablecer tu contraseña: ' . 'tu-pagina-de-recuperacion.php?token=' . $tokenRecuperacion;

    // Enviar el correo
    if ($mail->send()) {
        // El correo se envió correctamente
        $respuesta = array('success' => true);
    } else {
        // Hubo un error al enviar el correo
        $respuesta = array('success' => false, 'message' => 'Error al enviar el correo de recuperación: ' . $mail->ErrorInfo);
    }
} else {
    // No se encontró una cuenta asociada a este correo electrónico
    $respuesta = array('success' => false);
}

// Devolver la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($respuesta);
?>
```

Este es un ejemplo básico, y debes ajustar las rutas, las validaciones y otros detalles según tu aplicación. Además, asegúrate de manejar adecuadamente la seguridad, el almacenamiento de tokens y la conexión segura con tu servidor.