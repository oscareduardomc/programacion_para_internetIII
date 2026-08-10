<?php

session_start();

require "../config/db.php";


if($_SERVER['REQUEST_METHOD']=="POST"){


    $id_usuario = $_SESSION['id_usuario'];


    $id_cliente = !empty($_POST['id_cliente'])
        ? intval($_POST['id_cliente'])
        : null;


    $productos = json_decode(
        $_POST['productos'],
        true
    );


    $subtotal = floatval($_POST['subtotal']);

    $impuesto = floatval($_POST['impuesto']);

    $descuento = floatval($_POST['descuento']);

    $total = floatval($_POST['total']);


$id_forma_pago = intval($_POST['id_forma_pago']);


$referencia = trim($_POST['referencia'] ?? "");


$banco = trim($_POST['banco'] ?? "");



// ====================================
// VALIDACIONES FORMA DE PAGO
// ====================================


// Tarjeta

if($id_forma_pago == 2){


    if(empty($referencia)){


        $_SESSION['mensaje'] =
        "Debe ingresar el número de referencia.";

        $_SESSION['tipo']="warning";


        header("Location: ../ventas.php");

        exit;


    }

}



// Transferencia

if($id_forma_pago == 3){


    if(
        empty($referencia) ||
        empty($banco)
    ){


        $_SESSION['mensaje'] =
        "Para transferencia debe ingresar referencia y banco.";

        $_SESSION['tipo']="warning";


        header("Location: ../ventas.php");

        exit;


    }


}



// Crédito

if($id_forma_pago == 4){


    if(empty($id_cliente)){


        $_SESSION['mensaje'] =
        "Las ventas a crédito necesitan un cliente.";

        $_SESSION['tipo']="warning";


        header("Location: ../ventas.php");

        exit;


    }


}



    if(empty($productos)){


        $_SESSION['mensaje'] =
        "No hay productos en la venta.";

        $_SESSION['tipo']="danger";


        header("Location: ../ventas.php");

        exit;

    }



    try{


        $conn->begin_transaction();



        // ====================================
        // BUSCAR APERTURA ACTIVA
        // ====================================


        $query = "

        SELECT id_apertura

        FROM aperturas_caja

        WHERE id_usuario=?

        AND estado='ABIERTA'

        LIMIT 1

        ";


        $stmt=$conn->prepare($query);


        $stmt->bind_param(
            "i",
            $id_usuario
        );


        $stmt->execute();


        $apertura=$stmt->get_result()
                       ->fetch_assoc();



        if(!$apertura){


            throw new Exception(
                "No existe caja abierta."
            );


        }


        $id_apertura=$apertura['id_apertura'];




        // ====================================
        // NUMERO FACTURA
        // ====================================


       $numero_factura =
"FAC-".date("YmdHis").rand(100,999);




        // ====================================
        // INSERTAR VENTA
        // ====================================


        $query="

        INSERT INTO ventas

        (

        numero_factura,

        id_cliente,

        id_usuario,

        id_apertura,

        fecha,

        subtotal,

        impuesto,

        descuento,

        total,

        id_forma_pago,

        referencia,

        banco

        )

        VALUES

        (?,?,?,?,NOW(),?,?,?,?,?,?,?)

        ";


        $stmt=$conn->prepare($query);


        $stmt->bind_param(

            "siiiddddiss",

            $numero_factura,

            $id_cliente,

            $id_usuario,

            $id_apertura,

            $subtotal,

            $impuesto,

            $descuento,

            $total,

            $id_forma_pago,

            $referencia,

            $banco

        );



        $stmt->execute();



        $id_venta=$conn->insert_id;




        // ====================================
        // DETALLE DE VENTA
        // ====================================


        foreach($productos as $producto){



            $id_producto =
            intval($producto['id_producto']);


            $cantidad =
            floatval($producto['cantidad']);


            $precio =
            floatval($producto['precio']);



            // Validar stock


            $query="

            SELECT stock

            FROM productos

            WHERE id_producto=?

            FOR UPDATE

            ";



            $stmt=$conn->prepare($query);


            $stmt->bind_param(
                "i",
                $id_producto
            );


            $stmt->execute();


            $stockActual =
            $stmt->get_result()
                 ->fetch_assoc();



            if(
    !$stockActual ||
    $stockActual['stock'] < $cantidad ||
    $cantidad <= 0
){

                throw new Exception(
                    "Stock insuficiente."
                );

            }



            $subtotalProducto =
            $cantidad*$precio;




            // Insertar detalle


            $query="

            INSERT INTO detalle_ventas

            (

            id_venta,

            id_producto,

            cantidad,

            precio,

            subtotal

            )

            VALUES(?,?,?,?,?)

            ";



            $stmt=$conn->prepare($query);


            $stmt->bind_param(

                "iiddd",

                $id_venta,

                $id_producto,

                $cantidad,

                $precio,

                $subtotalProducto

            );


            $stmt->execute();




            // Descontar inventario


            $query="

            UPDATE productos

            SET stock = stock - ?

            WHERE id_producto=?

            ";


            $stmt=$conn->prepare($query);


            $stmt->bind_param(

                "di",

                $cantidad,

                $id_producto

            );


            $stmt->execute();



        }



        $conn->commit();



        $_SESSION['mensaje'] =
        "Venta registrada correctamente.";


        $_SESSION['tipo']="success";



        header(
            "Location: ../facturas.php"
        );


        exit;



    }catch(Exception $e){



        $conn->rollback();



        $_SESSION['mensaje'] =
        $e->getMessage();


        $_SESSION['tipo']="danger";



        header(
            "Location: ../ventas.php"
        );


        exit;


    }



}



header("Location: ../ventas.php");

?>