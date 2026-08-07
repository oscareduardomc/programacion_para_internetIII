<?php
session_start();

if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true || ($_SESSION['rol'] ?? '') !== 'usuario') {
    header("Location: ../login.php");
    exit;
}

require "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../nuevoTicket.php");
    exit;
}

$titulo = trim($_POST['titulo'] ?? '');
$descripcion = trim($_POST['descripcion'] ?? '');
$departamento = trim($_POST['departamento'] ?? '');
$prioridad = trim($_POST['prioridad'] ?? '');
$prioridadesValidas = ['Baja', 'Media', 'Alta'];

if ($titulo === '' || $descripcion === '' || $departamento === '' || !in_array($prioridad, $prioridadesValidas, true)) {
    $_SESSION['mensaje'] = 'Complete todos los campos obligatorios correctamente.';
    $_SESSION['tipo'] = 'danger';
    header("Location: ../nuevoTicket.php");
    exit;
}

$descripcionCompleta = 'Departamento: ' . $departamento . '. ' . $descripcion;
$idUsuario = (int) $_SESSION['id'];

$query = 'INSERT INTO tickets (id_usuario, titulo, descripcion, prioridad, estado)
          VALUES (?, ?, ?, ?, "Pendiente")';
$stmt = $conn->prepare($query);
$stmt->bind_param('isss', $idUsuario, $titulo, $descripcionCompleta, $prioridad);

if ($stmt->execute()) {
    $_SESSION['mensaje'] = 'Ticket registrado correctamente.';
    $_SESSION['tipo'] = 'success';
} else {
    $_SESSION['mensaje'] = 'No se pudo registrar el ticket.';
    $_SESSION['tipo'] = 'danger';
}

header("Location: ../dashboard.php");
exit;
