<?php

session_start();

require "../config/db.php";

if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['rol'] != 'usuario') {
    header("Location: ../dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $departamento = trim($_POST['departamento']);
    $prioridad = trim($_POST['prioridad']);
    $id_usuario = $_SESSION['id'];

    if (
        empty($titulo) ||
        empty($descripcion) ||
        empty($departamento) ||
        empty($prioridad)
    ) {
        $_SESSION['mensaje'] = "Complete todos los campos obligatorios.";
        $_SESSION['tipo'] = "danger";

        header("Location: ../nuevoTicket.php");
        exit;
    }

    $query = "INSERT INTO tickets
                (id_usuario, titulo, descripcion, departamento, prioridad)
              VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "issss",
        $id_usuario,
        $titulo,
        $descripcion,
        $departamento,
        $prioridad
    );

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Ticket registrado correctamente.";
        $_SESSION['tipo'] = "success";

        header("Location: ../dashboard.php");
        exit;
    } else {
        $_SESSION['mensaje'] = "Error al guardar el ticket.";
        $_SESSION['tipo'] = "danger";

        header("Location: ../nuevoTicket.php");
        exit;
    }

} else {
    header("Location: ../dashboard.php");
    exit;
}

$conn->close();
?>
