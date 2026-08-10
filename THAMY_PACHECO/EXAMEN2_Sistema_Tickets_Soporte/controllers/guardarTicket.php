<?php
session_start();
require "../config/db.php";

if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario   = $_SESSION['id_usuario'];
    $titulo       = trim($_POST['titulo'] ?? '');
    $descripcion  = trim($_POST['descripcion'] ?? '');
    $departamento = trim($_POST['departamento'] ?? '');
    $prioridad    = trim($_POST['prioridad'] ?? 'Media');

   
    if (empty($titulo) || empty($descripcion) || empty($departamento) || empty($prioridad)) {
        $_SESSION['mensaje'] = "Por favor complete todos los campos obligatorios del ticket.";
        $_SESSION['tipo'] = "warning";
        header("Location: ../nuevoTicket.php");
        exit;
    }

    
    $prioridades_validas = ['Baja', 'Media', 'Alta'];
    if (!in_array($prioridad, $prioridades_validas)) {
        $prioridad = 'Media';
    }

    $query = "INSERT INTO tickets (id_usuario, titulo, descripcion, departamento, prioridad, estado, fecha_creacion) 
              VALUES (?, ?, ?, ?, ?, 'Pendiente', NOW())";
    
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        $_SESSION['mensaje'] = "Error al preparar la consulta de registro.";
        $_SESSION['tipo'] = "danger";
        header("Location: ../nuevoTicket.php");
        exit;
    }

    $stmt->bind_param("issss", $id_usuario, $titulo, $descripcion, $departamento, $prioridad);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "¡Ticket # " . $stmt->insert_id . " registrado exitosamente!";
        $_SESSION['tipo'] = "success";
        header("Location: ../tickets.php");
        exit;
    } else {
        $_SESSION['mensaje'] = "Ocurrió un error al guardar el ticket en la base de datos.";
        $_SESSION['tipo'] = "danger";
        header("Location: ../nuevoTicket.php");
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../tickets.php");
    exit;
}
?>
