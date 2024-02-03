$(document).ready(function () {
    cargarPerfil();

    // Guarda una referencia al campo de archivo
    var inputAvatar = $("#avatarURL");

    // Al cerrar el modal
    $('#myModal').on('hidden.bs.modal', function () {
        // Limpia el campo de archivo
        inputAvatar.val('');
    });

    $("#perfilForm").submit(function (event) {
        event.preventDefault();

        var nombre = $("#nombre").val();
        var apellido = $("#apellido").val();

        // Datos que se enviarían al microservicio
        const datos = {
            nombre: nombre,
            apellido: apellido,
        };

        // Petición AJAX al microservicio
        $.ajax({
            type: 'POST',
            url: 'perfil/actualizar_usuario.php',
            data: new FormData(this), // Use FormData to handle file uploads
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                // Mostrar mensaje con SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Perfil Actualizado',
                    text: response.message
                }).then(() => {
                    // Cerrar la modal
                    $('#myModal').modal('hide');
                    // Refrescar los datos en la ventana principal
                    $("#nombreSpan").text(response.nombre);
                    $("#apellidoSpan").text(response.apellido);
                    // Puedes agregar la actualización del avatar aquí si es necesario
                    if (response.avatarURL) {
                        $("#avatarSpan").attr("src", "perfil/" + response.avatarURL);
                    }
                    // Limpia el campo de archivo
                    inputAvatar.val('');
                });
            },
            error: function () {
                // Mostrar mensaje de error con SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al actualizar el perfil.'
                });
            }
        });
    });
});

function cargarPerfil() {
    // Peticion AJAX para obtener el perfil del usuario
    $.ajax({
        type: 'GET',
        url: 'perfil/perfil_usuario.php',
        success: function (response) {
            // El servidor responderá con los datos del perfil en formato JSON
            const perfilDatos = JSON.parse(response);

            // Llama a la función para mostrar el perfil
            mostrarPerfil(perfilDatos);
        },
        error: function () {
            // Manejo de errores, puedes mostrar un mensaje o realizar otras acciones
            console.error('Error al cargar el perfil del usuario');
        }
    });
}

function mostrarPerfil(perfilDatos) {
    // Obtener el elemento del card donde se mostrarán los datos del perfil
    const nombreElemento = document.getElementById('nombreSpan');
    const apellidoElemento = document.getElementById('apellidoSpan');
    const avatarElemento = document.getElementById('avatarSpan');

    // Mostrar los datos del perfil
    nombreElemento.textContent = `${perfilDatos.nombre}`;
    apellidoElemento.textContent = `${perfilDatos.apellido}`;
    avatarElemento.src = `perfil/${perfilDatos.avatarURL}`;
}
