$(document).ready(function () {
    // Llamar a la función para cargar productos al cargar la página
    cargarProductos();

    // Obtener el carrito del servidor
    obtenerCarrito();

    // Mostrar el carrito después de cargar los productos
    // mostrarCarrito();
});

function cargarProductos() {
    $.ajax({
        url: 'compras/productos.php',
        method: 'GET',
        dataType: 'json',
        success: function (productos) {
            // console.log(productos);
            // Elemento contenedor de las tarjetas
            const container = $('#product-cards');
            window.productos = productos;

            // Iterar sobre cada producto y crear la tarjeta correspondiente
            $.each(productos, function (_, producto) {
                const card = $('<div class="col">').html(`
                <div class="card mb-4 rounded-3 shadow-sm">
                    <div class="card-header py-3">
                    <h4 class="my-0 fw-normal">${producto.Nombre}</h4>
                    </div>
                    <div class="card-body">
                    <img src="${producto.ImagenURL}" alt="${producto.Nombre}" class="img-fluid mb-3">
                    <p class="card-text">${producto.Descripcion}</p>
                    <h2 class="card-title pricing-card-title">$${producto.Precio}<small class="text-body-secondary fw-light"></small></h2>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>${producto.Stock} unidades en stock</li>
                        <!-- Agrega más detalles según tus necesidades -->
                    </ul>
                    <button type="button" class="btn btn-primary btn-block agregarAlCarritoBtn" data-productoid="${producto.ProductoID}">Agregar al Carrito</button>
                    </div>
                </div>
                `);
                // Agregar la tarjeta al contenedor
                container.append(card);
            });
        },
        error: function (error) {
            console.error('Error al cargar productos: ', error);
        }
    });
}

// Declaración de la variable carritoProductos
var carritoProductos = [];

// Función para obtener el carrito del servidor
function obtenerCarrito() {
    $.ajax({
        url: 'compras/obtener_carrito.php',
        method: 'GET',
        dataType: 'json',
        success: function (carrito) {
            // Actualizar la variable global del carrito
            carritoProductos = carrito;

            // Mostrar el carrito después de obtenerlo
            mostrarCarrito();
        },
        error: function (error) {
            console.error('Error al obtener el carrito: ', error);
        }
    });
}



// Función para mostrar el carrito y total
function mostrarCarrito() {
    var carritoContainer = $("#carrito");
    carritoContainer.empty();
    for (var i = 0; i < carritoProductos.length; i++) {
        var carritoItem = carritoProductos[i];

        var itemCarrito = `
            <div class="col-12 mb-3">
                <div class="row">
                    <div class="col">${carritoItem.producto.Nombre}</div>
                    <div class="col">Cantidad: ${carritoItem.cantidad}</div>
                    <div class="col">Precio: $${carritoItem.producto.Precio}</div>
                    <div class="col">Total: ${(carritoItem.cantidad * carritoItem.producto.Precio)}</div>
                </div>
            </div>
        `;

        carritoContainer.append(itemCarrito);
    }

    var totalPagar = calcularTotalPagar();
    document.getElementById("totalPagar").textContent = totalPagar;
}

// Función para calcular el total a pagar
function calcularTotalPagar() {
    var total = 0;
    for (var i = 0; i < carritoProductos.length; i++) {
        // Verificar que el precio sea un número antes de sumarlo
        // Obtener el precio del producto y la cantidad
        var precioProducto = parseFloat(carritoProductos[i].producto.Precio);
        var cantidad = carritoProductos[i].cantidad;

        // Verificar que el precio sea un número válido antes de sumarlo
        if (!isNaN(precioProducto) && isFinite(precioProducto) && cantidad > 0) {
            total += precioProducto * cantidad;
        }
    }

    // Verificar que total sea un número antes de devolverlo
    if (typeof total === 'number' && !isNaN(total)) {
        return total.toFixed(2); // Asegurarse de que el total tenga dos decimales
    } else {
        console.error('Error: El cálculo del total no devolvió un número válido.', total);
        return '0.00'; // Devolver un valor predeterminado en caso de error
    }
}

$(document).on('click', '.agregarAlCarritoBtn', function () {
    var productoId = $(this).data('productoid');
    agregarAlCarrito(productoId);
    mostrarCarrito();
})

// Función para agregar un producto al carrito
function agregarAlCarrito(productoId) {
    // Buscar el producto en el carrito
    var productoEnCarrito = carritoProductos.find(item => item.producto.ProductoID === productoId);

    // Buscar el producto en la lista de productos
    var producto = productos.find(p => p.ProductoID === productoId);

    // Verificar si el producto está en stock
    if (producto && producto.Stock > 0) {
        if (productoEnCarrito) {
            // Si el producto ya está en el carrito, incrementar la cantidad
            productoEnCarrito.cantidad++;
        } else {
            // Si el producto no está en el carrito, agregarlo con cantidad 1
            carritoProductos.push({ producto: producto, cantidad: 1 });
        }

        // Actualizar el stock del producto
        producto.Stock--;

        // Actualizar la interfaz gráfica del producto afectado
        actualizarTarjetaProducto(producto);
    } else {
        Swal.fire({
            icon: 'error',
            title: 'No disponible',
            text: `El producto con ProductoID ${productoId} no está disponible en stock.`,
        });
    }

    // Actualizar la interfaz gráfica del carrito
    mostrarCarrito();
}

// Función para actualizar la tarjeta de un producto específico
function actualizarTarjetaProducto(producto) {
    // Buscar el contenedor de la tarjeta del producto específico
    var tarjetaProducto = $(`#tarjetaProducto${producto.ProductoID}`);

    // Actualizar la información en la tarjeta
    tarjetaProducto.find('.card-img-top').attr('src', producto.ImagenURLmagen);
    tarjetaProducto.find('.card-title').text(producto.Nombre);
    tarjetaProducto.find('.card-description').text(producto.Descripcion);
    tarjetaProducto.find('.precio').text(`$${producto.Precio}`);
    tarjetaProducto.find('.codigo').text(`Código: ${producto.Codigo}`);
    tarjetaProducto.find('.stock').text(`Stock: ${producto.Stock} unidades`);
}

$(document).on('click', '#realizarPagoBtn', function () {
    realizarPago();
})

function realizarPago() {
    if (carritoProductos.length > 0) {
        // Enviar la información del carrito al servidor
        $.ajax({
            url: 'compras/procesar_pago.php',
            method: 'POST',
            data: { productos: carritoProductos },
            dataType: 'json',
            success: function (response) {
                if (response.redirect) {
                    // Redirige al usuario si es necesario
                    window.location.href = response.redirect;
                } else {
                    if (response.status === 'exito') {
                        // La lógica de procesamiento de pago fue exitosa en el servidor
                        Swal.fire({
                            icon: 'success',
                            title: 'Pago realizado',
                            text: `Pago de $${response.totalPagar} realizado con éxito.`,
                        });

                        // Vaciar el carrito
                        carritoProductos = [];
                        // Actualizar la interfaz gráfica del carrito
                        mostrarCarrito();
                    } else {
                        // Hubo un error en el servidor
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al procesar el pago',
                            text: response.message,
                        });
                    }
                }
            },
            error: function (error) {
                console.error('Error al procesar el pago en el servidor', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error al procesar el pago',
                    text: 'Hubo un error al comunicarse con el servidor.',
                });
            }
        });
    } else {
        Swal.fire({
            icon: 'info',
            title: 'Carrito vacío',
            text: 'Agrega productos al carrito antes de realizar un pago.',
        });
    }
}

