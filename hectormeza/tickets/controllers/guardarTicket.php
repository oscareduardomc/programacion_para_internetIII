<?php

session_start();

require "../config/db.php";

if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true){
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['rol'] !== 'usuario'){
    header("Location: ../tickets.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $departamento = trim($_POST['departamento']);
    $prioridad = trim($_POST['prioridad']);

    // Validar campos obligatorios

    if (
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
        (id_usuario, titulo, descripcion, departamento, prioridad, estado)
        VALUES (?, ?, ?, ?, ?, 'Pendiente')
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "issss",
        $_SESSION['id_usuario'],
        $titulo,
        $descripcion,
        $departamento,
        $prioridad
    );

    if ($stmt->execute()){
        $_SESSION['mensaje'] = "Ticket registrado correctamente.";
        $_SESSION['tipo'] = "success";
    }else{
        $_SESSION['mensaje'] = "Ocurrio un error al registrar el ticket.";
        $_SESSION['tipo'] = "danger";
    }

    $stmt->close();
    $conn->close();

    header("Location: ../tickets.php");
    exit;

}else{
    header("Location: ../nuevoTicket.php");
    exit;
}

?>
