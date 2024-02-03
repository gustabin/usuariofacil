$(document).ready(function () {
    // Intercepta el envío del formulario
    $('#registroForm').submit(function (e) {
        e.preventDefault(); // Evita que el formulario se envíe de la manera tradicional

        // Realiza la solicitud AJAX al microservicio
        $.ajax({
            type: 'POST',
            url: 'registrar_usuario.php', // Ajusta la ruta según la ubicación de tu microservicio
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

    $("#irAlLogin").click(function () {
        // Redirigir a la página de login
        window.location.href = '../login/index.html';
    });
});