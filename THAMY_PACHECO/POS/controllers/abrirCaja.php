<?php

session_start();

require "../config/db.php";


if($_SERVER['REQUEST_METHOD']=="POST"){


    $id_usuario = $_SESSION['id_usuario'];

    $id_caja = intval($_POST['id_caja']);

    $monto_inicial = floatval($_POST['monto_inicial']);

    $observacion = $_POST['observacion'];



    if(empty($id_caja) || $monto_inicial < 0){


        $_SESSION['mensaje'] = "Complete los datos de apertura.";

        $_SESSION['tipo'] = "danger";


        header("Location: ../aperturaCaja.php");

        exit;

    }



    // Verificar si ya tiene caja abierta

    $query = "

    SELECT id_apertura

    FROM aperturas_caja

    WHERE id_usuario = ?

    AND estado='ABIERTA'

    LIMIT 1

    ";



    $stmt = $conn->prepare($query);


    $stmt->bind_param(
        "i",
        $id_usuario
    );


    $stmt->execute();


    $resultado = $stmt->get_result();



    if($resultado->num_rows > 0){


        $_SESSION['mensaje'] = 
        "Ya tiene una caja abierta.";


        $_SESSION['tipo'] = "warning";


        header("Location: ../aperturaCaja.php");

        exit;

    }



    // Registrar apertura


    $query = "

    INSERT INTO aperturas_caja

    (

        id_caja,

        id_usuario,

        fecha_apertura,

        monto_inicial,

        observacion

    )

    VALUES

    (

        ?,

        ?,

        NOW(),

        ?,

        ?

    )

    ";



    $stmt = $conn->prepare($query);



    $stmt->bind_param(

        "iids",

        $id_caja,

        $id_usuario,

        $monto_inicial,

        $observacion

    );



    if($stmt->execute()){


        $_SESSION['mensaje'] = 
        "Caja abierta correctamente.";


        $_SESSION['tipo'] = "success";


    }else{


        $_SESSION['mensaje'] = 
        "Error al abrir la caja.";


        $_SESSION['tipo'] = "danger";

    }



    header("Location: ../aperturaCaja.php");

    exit;



}else{


    header("Location: ../aperturaCaja.php");

    exit;

}


?>