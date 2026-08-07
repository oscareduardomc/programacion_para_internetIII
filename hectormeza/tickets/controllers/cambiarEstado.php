<?php

session_start();

require "../config/db.php";

if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true){
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['rol'] !== 'tecnico'){
    header("Location: ../tickets.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $id_ticket = intval($_POST['id_ticket']);
    $estado = trim($_POST['estado']);

    $estadosValidos = ['Pendiente', 'En Proceso', 'Resuelto'];

    if (empty($id_ticket) || !in_array($estado, $estadosValidos)){
        $_SESSION['mensaje'] = "Datos invalidos para actualizar el ticket.";
        $_SESSION['tipo'] = "danger";

        header("Location: ../tickets.php");
        exit;
    }

    $query = "UPDATE tickets SET estado = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $estado, $id_ticket);

    if ($stmt->execute()){
        $_SESSION['mensaje'] = "Estado del ticket actualizado correctamente.";
        $_SESSION['tipo'] = "success";
    }else{
        $_SESSION['mensaje'] = "Ocurrio un error al actualizar el ticket.";
        $_SESSION['tipo'] = "danger";
    }

    $stmt->close();
    $conn->close();

    header("Location: ../tickets.php");
    exit;

}else{
    header("Location: ../tickets.php");
    exit;
}

?>
