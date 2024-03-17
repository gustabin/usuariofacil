$(document).ready(function () {
    $("#loginForm").submit(function (event) {
        event.preventDefault();

        var email = $("#email").val();
        var password = $("#password").val();

        $.ajax({
            type: "POST",
            url: "autenticar_usuario.php",
            data: {
                email: email,
                password: password
            },
            dataType: "json",
            success: function (response) {
                if (response.status === 'exito') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: response.message
                    });
                    if (response.intentar_pago) {
                        // Redirigir a la página de pago
                        window.location.href = '../';
                    } else {
                        // Redirigir a la página de login
                        window.location.href = '../sistema/index.php';
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al procesar la solicitud.'
                });
            }
        });
    });

    $('#restablecerForm').submit(function (event) {
        event.preventDefault();

        // Obtener los datos del formulario
        var formData = {
            email: $('#email').val(),
        };

        // Enviar la solicitud Ajax
        $.ajax({
            type: 'POST',
            url: 'reestablecer_password.php',
            data: formData,
            dataType: 'json',
            success: function (response) {
                // Mostrar SweetAlert según el status de la respuesta
                if (response.status === 'exito') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: response.message,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                    });
                }
            },
            error: function (xhr, status, error) {
                // Mostrar SweetAlert en caso de error en la solicitud Ajax
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error en la solicitud Ajax: ' + error,
                });
            }
        });
    });

    $('#cambiarPasswordForm').submit(function (event) {
        event.preventDefault();

        // Obtener los datos del formulario
        var formData = {
            password: $('#password').val(),
            retipearPassword: $('#retipearPassword').val(),
            token: $('#token').val()
        };

        // Enviar la solicitud Ajax
        $.ajax({
            type: 'POST',
            url: 'cambiar_password.php',
            data: formData,
            dataType: 'json',
            success: function (response) {
                // Mostrar SweetAlert según el status de la respuesta
                if (response.status === 'exito') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: response.message,
                    });
                    // Redirigir a la página de login
                    window.location.href = 'index.html';
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                    });
                }
            },
            error: function (xhr, status, error) {
                // Mostrar SweetAlert en caso de error en la solicitud Ajax
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error en la solicitud Ajax: ' + error,
                });
            }
        });
    });

    $("#recuperarPassword").click(function () {
        // Redirigir a la página de restablecer contraseña
        window.location.href = 'reestablecer_password.html';
    });


    $("#registrarUsuario").click(function () {
        // Redirigir a la página de registrar Usuario
        window.location.href = '../usuarios/index.html';
    });

    $("#irAlLogin").click(function () {
        // Redirigir a la página de login
        window.location.href = 'index.html';
    });
});
