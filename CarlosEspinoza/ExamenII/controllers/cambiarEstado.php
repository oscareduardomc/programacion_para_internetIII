<?php

session_start();

require "../config/db.php";

if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['rol'] != 'tecnico') {
    header("Location: ../dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $id = intval($_POST['id']);
    $estado = trim($_POST['estado']);

    $estados_validos = array('Pendiente', 'En Proceso', 'Resuelto');

    if (empty($id) || !in_array($estado, $estados_validos)) {
        $_SESSION['mensaje'] = "Estado no valido.";
        $_SESSION['tipo'] = "danger";

        header("Location: ../dashboard.php");
        exit;
    }

    $query = "UPDATE tickets SET estado = ? WHERE id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $estado, $id);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Estado del ticket actualizado correctamente.";
        $_SESSION['tipo'] = "success";
    } else {
        $_SESSION['mensaje'] = "Error al actualizar el estado.";
        $_SESSION['tipo'] = "danger";
    }

    header("Location: ../dashboard.php");
    exit;

} else {
    header("Location: ../dashboard.php");
    exit;
}

$conn->close();
?>
