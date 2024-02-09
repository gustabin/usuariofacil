$(document).ready(function () {
    // Llamar a la función para cargar productos al cargar la página
    cargarProductos();

    // Mostrar el carrito después de cargar los productos
    mostrarCarrito();
});

function cargarProductos() {
    $.ajax({
        url: 'compras/productos.php',
        method: 'GET',
        dataType: 'json',
        success: function (productos) {
            console.log(productos);
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
