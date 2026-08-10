<?php
require "../includes/session.php";
require "../config/db.php";

if ($_SESSION['rol'] !== 'usuario') {
  header("Location: ../tickets.php");
  exit;
}

$id_usuario = $_SESSION['id_usuario'];

$titulo = $_POST['titulo'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$prioridad = $_POST['prioridad'] ?? '';


if (empty($titulo) === '' || empty($descripcion) === ''|| !in_array($prioridad, ['Baja','Media','Alta'])) {
  $_SESSION['mensaje'] = "Datos inválidos";
  $_SESSION['tipo'] = "danger";
  header("Location: ../crearTickets.php");
  exit;
}

$query = "INSERT INTO tickets 
(
id_usuario, 
titulo, 
descripcion, 
prioridad
)
VALUES 
(
?, 
?, 
?, 
?
)
";
$stmt = $conn->prepare($query);
$stmt->bind_param("isss", $id_usuario, $titulo, $descripcion, $prioridad);
$stmt->execute();

$_SESSION['mensaje'] = "Ticket registrado correctamente";
$_SESSION['tipo'] = "success";
header("Location: ../tickets.php");
exit;
