<?php
// 1. Validar sesion activa y conectar a la base de datos
require "../includes/session.php";
require "../config/db.php";

// 2. Solo el tecnico puede cambiar el estado de un ticket
if ($_SESSION['rol'] !== 'tecnico') {
    header("Location: ../listado.php");
    exit();
}

// 3. Verificar que el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 4. Validar que los campos existan antes de leerlos
    if (isset($_POST['id']) && isset($_POST['estado'])) {

        $ticketId = trim($_POST['id']);
        $status = trim($_POST['estado']);

        try {
            // 5. Actualizar el estado del ticket
            $sql = "UPDATE tickets SET estado = :estado WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':estado', $status);
            $stmt->bindParam(':id', $ticketId);
            $stmt->execute();

            header("Location: ../listado.php");
            exit();

        } catch (PDOException $error) {
            die("Error al actualizar el estado: " . $error->getMessage());
        }

    } else {
        header("Location: ../listado.php");
        exit();
    }
}
?>