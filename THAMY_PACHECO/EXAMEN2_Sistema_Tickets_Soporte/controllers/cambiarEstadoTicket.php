<?php
session_start();
require "../config/db.php";

// Protección de perfil técnico
if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['rol'] !== 'tecnico') {
    $_SESSION['mensaje'] = "Acceso denegado. Solo los usuarios con rol Técnico pueden cambiar el estado de los tickets.";
    $_SESSION['tipo'] = "danger";
    header("Location: ../tickets.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_ticket = intval($_POST['id_ticket'] ?? 0);
    $estado    = trim($_POST['estado'] ?? '');

    $estados_validos = ['Pendiente', 'En Proceso', 'Resuelto'];

    if ($id_ticket <= 0 || !in_array($estado, $estados_validos)) {
        $_SESSION['mensaje'] = "Datos de actualización de estado no válidos.";
        $_SESSION['tipo'] = "warning";
        header("Location: ../tickets.php");
        exit;
    }

    $query = "UPDATE tickets SET estado = ? WHERE id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        $_SESSION['mensaje'] = "Error de preparación en la base de datos.";
        $_SESSION['tipo'] = "danger";
        header("Location: ../tickets.php");
        exit;
    }

    $stmt->bind_param("si", $estado, $id_ticket);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "El estado del Ticket #$id_ticket se ha actualizado a '$estado' correctamente.";
        $_SESSION['tipo'] = "success";
    } else {
        $_SESSION['mensaje'] = "No se pudo actualizar el estado del ticket.";
        $_SESSION['tipo'] = "danger";
    }

    $stmt->close();
    $conn->close();

    header("Location: ../tickets.php");
    exit;
} else {
    header("Location: ../tickets.php");
    exit;
}
?>
