$(document).ready(function () {
    // Intercepta el envío del formulario
    $('#contactoForm').submit(function (e) {
        e.preventDefault(); // Evita que el formulario se envíe de la manera tradicional
        // Realiza la solicitud AJAX al microservicio
        $.ajax({
            type: 'POST',
            url: 'contacto/registrar_contacto.php', // Ajusta la ruta según la ubicación de tu microservicio
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                // Muestra el Sweet Alert según la respuesta del microservicio
                if (response.status === 'exito') {
                    // Muestra un Sweet Alert con un botón OK
                    Swal.fire({
                        title: 'Éxito',
                        text: response.message,
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'index.php';
                        }
                    });
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