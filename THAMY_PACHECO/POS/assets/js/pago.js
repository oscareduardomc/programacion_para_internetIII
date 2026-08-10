$("#forma_pago").change(function(){



    let pago = $(this).val();



    if(
        pago == 2 ||
        pago == 3 ||
        pago == 4
    ){


        $("#datosPago").show();



    }else{


        $("#datosPago").hide();


        $("#referencia").val("");

        $("#banco").val("");

    }



});