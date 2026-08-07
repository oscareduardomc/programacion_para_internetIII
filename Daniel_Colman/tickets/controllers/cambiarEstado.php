<?php
session_start();
require "../config/db.php";

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'tecnico') {
    $_SESSION['mensaje'] = "Solo el técnico puede cambiar estados.";
    $_SESSION['tipo']    = "danger";
    header("Location: ../tickets.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_ticket = intval($_POST['id_ticket'] ?? 0);
    $estado    = $_POST['estado'] ?? '';

    if ($id_ticket <= 0 || empty($estado)) {
        $_SESSION['mensaje'] = "Datos inválidos.";
        $_SESSION['tipo']    = "danger";
        header("Location: ../tickets.php");
        exit;
    }

    $query = "
        UPDATE tickets
        SET estado = ?
        WHERE id = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $estado, $id_ticket);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Estado actualizado correctamente.";
        $_SESSION['tipo']    = "success";
    } else {
        $_SESSION['mensaje'] = "Error al actualizar el estado.";
        $_SESSION['tipo']    = "danger";
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
