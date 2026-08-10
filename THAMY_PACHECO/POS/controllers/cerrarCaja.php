<?php

session_start();

require "../config/db.php";


if($_SERVER['REQUEST_METHOD']=="POST"){



    $id_usuario = $_SESSION['id_usuario'];


    $id_apertura = intval($_POST['id_apertura']);


    $monto_final = floatval($_POST['monto_final']);


    $observacion = $_POST['observacion'];




    if(empty($id_apertura)){


        $_SESSION['mensaje'] =
        "Apertura no válida.";


        $_SESSION['tipo']="danger";


        header("Location: ../cerrarCaja.php");

        exit;

    }



    try{


        $conn->begin_transaction();



        // Validar apertura del usuario


        $query="

        SELECT *

        FROM aperturas_caja

        WHERE id_apertura=?

        AND id_usuario=?

        AND estado='ABIERTA'

        LIMIT 1

        ";



        $stmt=$conn->prepare($query);


        $stmt->bind_param(

            "ii",

            $id_apertura,

            $id_usuario

        );



        $stmt->execute();



        $apertura=$stmt->get_result()
                       ->fetch_assoc();



        if(!$apertura){


            throw new Exception(
                "La caja no está disponible."
            );


        }





        // Calcular ventas realizadas


        $query="

        SELECT

        SUM(total) AS ventas


        FROM ventas


        WHERE id_apertura=?

        AND estado='ACTIVA'


        ";



        $stmt=$conn->prepare($query);



        $stmt->bind_param(

            "i",

            $id_apertura

        );



        $stmt->execute();



        $resultado=$stmt->get_result()
                        ->fetch_assoc();



        $ventas = $resultado['ventas'] ?? 0;




        // Efectivo esperado

        // Solo se toma efectivo

        $query="

        SELECT

        SUM(v.total) AS efectivo


        FROM ventas v


        INNER JOIN formas_pago fp

        ON v.id_forma_pago=fp.id_forma_pago


        WHERE v.id_apertura=?

        AND fp.forma_pago='Efectivo'


        AND v.estado='ACTIVA'


        ";



        $stmt=$conn->prepare($query);



        $stmt->bind_param(

            "i",

            $id_apertura

        );



        $stmt->execute();



        $resultado=$stmt->get_result()
                        ->fetch_assoc();



        $efectivoVentas = 
        $resultado['efectivo'] ?? 0;



        $efectivoEsperado = 
        $apertura['monto_inicial'] 
        + 
        $efectivoVentas;



        $diferencia =
        $monto_final - $efectivoEsperado;




        // Actualizar cierre


        $query="

        UPDATE aperturas_caja

        SET

        fecha_cierre = NOW(),

        monto_final=?,

        diferencia=?,

        observacion=?,

        estado='CERRADA'


        WHERE id_apertura=?


        ";



        $stmt=$conn->prepare($query);



        $stmt->bind_param(

            "ddsi",

            $monto_final,

            $diferencia,

            $observacion,

            $id_apertura

        );



        $stmt->execute();




        $conn->commit();




        $_SESSION['mensaje'] =

        "Caja cerrada correctamente. Diferencia: L. "
        .
        number_format($diferencia,2);



        $_SESSION['tipo']="success";




        header("Location: ../aperturaCaja.php");


        exit;



    }catch(Exception $e){



        $conn->rollback();



        $_SESSION['mensaje'] =
        $e->getMessage();



        $_SESSION['tipo']="danger";



        header("Location: ../cerrarCaja.php");


        exit;



    }




}



header("Location: ../cerrarCaja.php");

?>