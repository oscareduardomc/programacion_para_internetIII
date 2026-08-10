<?php
require "../includes/session.php";
require "../config/db.php";

if ($_SESSION['rol'] !== 'tecnico') {
  header("Location: ../tickets.php");
  exit;
}

$id_ticket = intval($_POST['id_ticket'] ?? 0);
$nuevo_estado = $_POST['nuevo_estado'] ?? '';

$estadosPermitidos = ['Pendiente', 'En Proceso', 'Resuelto'];
if ($id_ticket <= 0 || !in_array($nuevo_estado, $estadosPermitidos)) {
  $_SESSION['mensaje'] = "Estado inválido";
  $_SESSION['tipo'] = "danger";
  header("Location: ../tickets.php");
  exit;
}

$query = "UPDATE tickets 
SET estado = ? 
WHERE id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("si", $nuevo_estado, $id_ticket);
$stmt->execute();

$_SESSION['mensaje'] = "Estado actualizado";
$_SESSION['tipo'] = "success";
header("Location: ../tickets.php");
exit;
