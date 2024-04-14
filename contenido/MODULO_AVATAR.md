Aquí tienes un ejemplo básico de cómo podrías crear la interfaz que permite a los usuarios cargar, eliminar y reemplazar su avatar o foto de perfil. Utilizaré Bootstrap, jQuery y SweetAlert.

1. **HTML (gestion-avatar.html):**

```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Gestión de Avatar</title>
    <!-- Incluir Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Incluir SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Gestión de Avatar</h2>
            <div class="mb-4">
                <img id="avatarPreview" src="ruta/a/tu/controlador_obtener_avatar.php" alt="Avatar" class="img-fluid">
            </div>
            <input type="file" id="inputAvatar" class="mb-3">
            <button type="button" class="btn btn-success btn-block" onclick="cargarAvatar()">Cargar Avatar</button>
            <button type="button" class="btn btn-danger btn-block" onclick="eliminarAvatar()">Eliminar Avatar</button>
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
function cargarAvatar() {
    var inputAvatar = document.getElementById('inputAvatar');
    var file = inputAvatar.files[0];

    if (file) {
        var formData = new FormData();
        formData.append('avatar', file);

        // Enviar datos al servidor para cargar el avatar (puedes usar AJAX)
        $.ajax({
            type: "POST",
            url: "ruta/a/tu/controlador_cargar_avatar.php", // Especifica la ruta a tu controlador PHP en el backend
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                // Procesar la respuesta del servidor
                if (response.success) {
                    // Actualizar la vista previa del avatar
                    $("#avatarPreview").attr("src", "ruta/a/tu/controlador_obtener_avatar.php?" + new Date().getTime());
                    // Mostrar SweetAlert de éxito
                    Swal.fire({
                        icon: 'success',
                        title: '¡Avatar Cargado!',
                        text: 'El avatar se cargó correctamente.',
                    });
                } else {
                    // Mostrar SweetAlert de error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al Cargar el Avatar',
                        text: 'Hubo un problema al cargar el avatar. Inténtalo de nuevo.',
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
    } else {
        // Mostrar SweetAlert si no se seleccionó ningún archivo
        Swal.fire({
            icon: 'warning',
            title: 'Selecciona un Archivo',
            text: 'Por favor, selecciona un archivo de imagen.',
        });
    }
}

function eliminarAvatar() {
    // Enviar solicitud AJAX para eliminar el avatar (puedes usar AJAX)
    $.ajax({
        type: "POST",
        url: "ruta/a/tu/controlador_eliminar_avatar.php", // Especifica la ruta a tu controlador PHP en el backend
        success: function (response) {
            // Procesar la respuesta del servidor
            if (response.success) {
                // Actualizar la vista previa del avatar
                $("#avatarPreview").attr("src", "ruta/a/tu/controlador_obtener_avatar.php?" + new Date().getTime());
                // Mostrar SweetAlert de éxito
                Swal.fire({
                    icon: 'success',
                    title: 'Avatar Eliminado',
                    text: 'El avatar se eliminó correctamente.',
                });
            } else {
                // Mostrar SweetAlert de error
                Swal.fire({
                    icon: 'error',
                    title: 'Error al Eliminar el Avatar',
                    text: 'Hubo un problema al eliminar el avatar. Inténtalo de nuevo.',
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

3. **PHP (controlador_obtener_avatar.php):**

```php
<?php
// Simula la obtención de la ruta del avatar desde la base de datos
$rutaAvatar = 'ruta/a/tu/avatares/usuario_avatar.jpg'; // Cambia esto según tu lógica de obtención

// Devolver la respuesta como imagen
header('Content-Type: image/jpeg');
readfile($rutaAvatar);
?>
```

4. **PHP (controlador_cargar_avatar.php):**

```php
<?php
// Obtener el archivo de imagen del formulario
$avatar = $_FILES['avatar'];

// Validar el tipo de archivo (puedes agregar

 más validaciones según tus necesidades)

// Mover el archivo a la carpeta de avatares (debes asegurarte de tener permisos de escritura)
$rutaDestino = 'ruta/a/tu/avatares/';
$nombreArchivo = 'usuario_avatar.jpg'; // Puedes generar un nombre único aquí
$rutaCompleta = $rutaDestino . $nombreArchivo;

move_uploaded_file($avatar['tmp_name'], $rutaCompleta);

// Devolver la respuesta como JSON
echo json_encode(array('success' => true));
?>
```

5. **PHP (controlador_eliminar_avatar.php):**

```php
<?php
// Simula la eliminación del avatar en la base de datos (aquí deberías tener tu lógica de acceso a la base de datos)

// Devolver la respuesta como JSON
echo json_encode(array('success' => true));
?>
```

Este es un ejemplo básico, y debes ajustar las rutas, las validaciones y otros detalles según tu aplicación. Además, asegúrate de manejar adecuadamente la seguridad, el almacenamiento de archivos y la conexión segura con tu servidor.