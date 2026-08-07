<?php
session_start();

if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true || ($_SESSION['rol'] ?? '') !== 'tecnico') {
    header("Location: ../login.php");
    exit;
}

require "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../dashboard.php");
    exit;
}

$idTicket = (int) ($_POST['id_ticket'] ?? 0);
$estado = trim($_POST['estado'] ?? '');
$estadosValidos = ['Pendiente', 'En Proceso', 'Resuelto'];

if ($idTicket <= 0 || !in_array($estado, $estadosValidos, true)) {
    $_SESSION['mensaje'] = 'Datos inválidos para actualizar el ticket.';
    $_SESSION['tipo'] = 'danger';
    header("Location: ../dashboard.php");
    exit;
}

$query = 'UPDATE tickets SET estado = ? WHERE id = ?';
$stmt = $conn->prepare($query);
$stmt->bind_param('si', $estado, $idTicket);

if ($stmt->execute()) {
    $_SESSION['mensaje'] = 'Estado del ticket actualizado correctamente.';
    $_SESSION['tipo'] = 'success';
} else {
    $_SESSION['mensaje'] = 'No se pudo actualizar el estado del ticket.';
    $_SESSION['tipo'] = 'danger';
}

header("Location: ../dashboard.php");
exit;
