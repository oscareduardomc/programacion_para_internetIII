$("#guardarVenta").click(function(){


    if(carrito.length == 0){


        Swal.fire({

            icon:"warning",

            title:"Carrito vacío",

            text:"Debe agregar productos antes de finalizar la venta."

        });


        return;

    }



    let datos = {


        productos: JSON.stringify(carrito),


        id_cliente: $("#cliente").val(),


        subtotal: $("#subtotal").val(),


        impuesto: $("#impuesto").val(),


        descuento: $("#descuento").val(),


        total: $("#total").text(),




       id_forma_pago:
$("#forma_pago").val(),


referencia:
$("#referencia").val(),


banco:
$("#banco").val()


    };





    Swal.fire({

        title:"¿Confirmar venta?",

        text:"Se registrará la factura y se actualizará el inventario.",

        icon:"question",

        showCancelButton:true,

        confirmButtonText:"Sí, vender",

        cancelButtonText:"Cancelar"


    }).then((result)=>{


        if(result.isConfirmed){


            $.ajax({


                url:"controllers/guardarVenta.php",


                type:"POST",


                data:datos,



                success:function(respuesta){


                    window.location.href="facturas.php";


                },


                error:function(){


                    Swal.fire({

                        icon:"error",

                        title:"Error",

                        text:"No se pudo procesar la venta."

                    });


                }



            });



        }


    });



});