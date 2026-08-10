let carrito = [];


// ========================================
// BUSCAR PRODUCTOS
// ========================================


$("#buscarProducto").on("keyup", function(){


    let texto = $(this).val();



    if(texto.length < 2){

        $("#resultadoProductos").html("");

        return;

    }



    $.ajax({

        url:"controllers/buscarProductos.php",

        type:"POST",

        data:{
            buscar:texto
        },


        success:function(respuesta){

        console.log(respuesta);

            let productos = JSON.parse(respuesta);



            let html="";



            productos.forEach(function(producto){



                html += `

                <button 
                type="button"
                class="list-group-item list-group-item-action"
                onclick='seleccionarProducto(${JSON.stringify(producto)})'>


                <strong>
                ${producto.nombre}
                </strong>


                <br>


                Código:
                ${producto.codigo}


                | Stock:
                ${producto.stock}


                | Precio:
                L. ${producto.precio_venta}



                </button>


                `;



            });



            $("#resultadoProductos").html(html);



        }



    });



});





// ========================================
// SELECCIONAR PRODUCTO
// ========================================


function seleccionarProducto(producto){

console.log("seleccionarProducto ejecutada", producto);
console.trace();

    let existe = carrito.find(

        p => p.id_producto == producto.id_producto

    );



    if(existe){


        if(existe.cantidad + 1 <= producto.stock){

            existe.cantidad++;

        }


    }else{


        carrito.push({

            id_producto:producto.id_producto,

            nombre:producto.nombre,

            precio:parseFloat(producto.precio_venta),

            stock:parseFloat(producto.stock),

            cantidad:1

        });


    }



    $("#buscarProducto").val("");

    $("#resultadoProductos").html("");



    mostrarCarrito();


}





// ========================================
// MOSTRAR CARRITO
// ========================================


function mostrarCarrito(){


    let html="";



    carrito.forEach(function(producto,index){



        let total =
        producto.cantidad *
        producto.precio;



        html += `

        <tr>


        <td>

        ${producto.nombre}

        <br>

        <small>
        Stock:
        ${producto.stock}
        </small>

        </td>



        <td>


        <input 

        type="number"

        min="1"

        max="${producto.stock}"

        class="form-control"

        value="${producto.cantidad}"

        onchange="cambiarCantidad(${index},this.value)"


        >



        </td>



        <td>

        L.
        ${producto.precio.toFixed(2)}

        </td>



        <td>

        L.
        ${total.toFixed(2)}

        </td>



        <td>


        <button

        class="btn btn-danger btn-sm"

        onclick="eliminarProducto(${index})">


        <i class="fa fa-trash"></i>


        </button>


        </td>



        </tr>


        `;


    });



    $("#detalleVenta").html(html);


    calcularTotales();


}





// ========================================
// CAMBIAR CANTIDAD
// ========================================


function cambiarCantidad(index,cantidad){



    cantidad=parseFloat(cantidad);



    if(cantidad > carrito[index].stock){


        cantidad = carrito[index].stock;


    }



    carrito[index].cantidad=cantidad;



    mostrarCarrito();


}





// ========================================
// ELIMINAR PRODUCTO
// ========================================


function eliminarProducto(index){


    carrito.splice(index,1);


    mostrarCarrito();


}





// ========================================
// CALCULOS
// ========================================


function calcularTotales(){


    let subtotal=0;



    carrito.forEach(function(producto){


        subtotal += 
        producto.cantidad *
        producto.precio;


    });



    let impuesto =
    subtotal * 0.15;



    let descuento =
    parseFloat($("#descuento").val())
    ||0;



    let total =
    subtotal + impuesto - descuento;



    $("#subtotal")
    .val(subtotal.toFixed(2));


    $("#impuesto")
    .val(impuesto.toFixed(2));


    $("#total")
    .text(total.toFixed(2));



}