<?php

session_start();

require "../config/db.php";


if($_SERVER['REQUEST_METHOD'] == "POST"){


    $id_usuario   = $_SESSION['id'];
    $titulo       = trim($_POST['titulo']);
    $descripcion  = trim($_POST['descripcion']);
    $departamento = trim($_POST['departamento']);
    $prioridad    = $_POST['prioridad'];



    // Validar campos obligatorios

    if(
        empty($titulo) ||
        empty($descripcion) ||
        empty($departamento) ||
        empty($prioridad)
    ){

        $_SESSION['mensaje'] = "Complete todos los campos obligatorios.";
        $_SESSION['tipo'] = "danger";

        header("Location: ../nuevoTicket.php");
        exit;

    }




    $query = "

        INSERT INTO tickets
        (
            id_usuario,
            titulo,
            descripcion,
            departamento,
            prioridad
        )

        VALUES
        (
            ?,
            ?,
            ?,
            ?,
            ?
        )

    ";



    $stmt = $conn->prepare($query);



    $stmt->bind_param(
        "issss",
        $id_usuario,
        $titulo,
        $descripcion,
        $departamento,
        $prioridad
    );



    if($stmt->execute()){


        $_SESSION['mensaje'] = "Ticket registrado correctamente.";
        $_SESSION['tipo'] = "success";


        header("Location: ../tickets.php");

        exit;


    }else{


        $_SESSION['mensaje'] = "Error al registrar el ticket.";
        $_SESSION['tipo'] = "danger";


        header("Location: ../nuevoTicket.php");

        exit;

    }



}else{


    header("Location: ../tickets.php");

    exit;

}


$conn->close();

?>