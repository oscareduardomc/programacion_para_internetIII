<?php
session_start();
require "../config/db.php";

if (!isset($_SESSION['id'])) {
    $_SESSION['mensaje'] = "Debe iniciar sesión.";
    $_SESSION['tipo']    = "danger";
    header("Location: ../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario   = $_SESSION['id'];
    $titulo       = trim($_POST['titulo'] ?? '');
    $descripcion  = trim($_POST['descripcion'] ?? '');
    $departamento = trim($_POST['departamento'] ?? '');
    $prioridad    = $_POST['prioridad'] ?? '';

    if (empty($titulo) || empty($descripcion) || empty($departamento) || empty($prioridad)) {
        $_SESSION['mensaje'] = "Complete todos los campos.";
        $_SESSION['tipo']    = "danger";
        header("Location: ../nuevoTicket.php");
        exit;
    }

    $query = "
        INSERT INTO tickets
        (id_usuario, titulo, descripcion, prioridad, estado, departamento, fecha_creacion)
        VALUES
        (?, ?, ?, ?, 'Pendiente', ?, NOW())
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("issss", $id_usuario, $titulo, $descripcion, $prioridad, $departamento);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Ticket registrado correctamente.";
        $_SESSION['tipo']    = "success";
        header("Location: ../tickets.php");
    } else {
        $_SESSION['mensaje'] = "Error al registrar el ticket.";
        $_SESSION['tipo']    = "danger";
        header("Location: ../nuevoTicket.php");
    }

    $stmt->close();
    $conn->close();
    exit;
} else {
    header("Location: ../tickets.php");
    exit;
}
?>
