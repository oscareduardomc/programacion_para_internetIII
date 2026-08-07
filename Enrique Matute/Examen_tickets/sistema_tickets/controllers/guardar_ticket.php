<?php
// 1. Validar sesion activa y conectar a la base de datos
require "../includes/session.php";
require "../config/db.php";

// 2. Verificar que el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 3. Validar que todos los campos existan antes de leerlos
    if (
        isset($_POST['txtTitulo']) &&
        isset($_POST['txtDescripcion']) &&
        isset($_POST['txtDepartamento']) &&
        isset($_POST['txtPrioridad'])
    ) {

        $title = trim($_POST['txtTitulo']);
        $description = trim($_POST['txtDescripcion']);
        $department = trim($_POST['txtDepartamento']);
        $priority = trim($_POST['txtPrioridad']);

        // 4. Validar que ningun campo llegue vacio
        if ($title === '' || $description === '' || $department === '' || $priority === '') {
            header("Location: ../registrar_ticket.php?error=1");
            exit();
        }

        try {
            // 5. Insertar el nuevo ticket
            $sql = "INSERT INTO tickets (id_usuario, titulo, descripcion, prioridad, estado)
                    VALUES (:id_usuario, :titulo, :descripcion, :prioridad, 'Pendiente')";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_usuario', $_SESSION['id']);
            $stmt->bindParam(':titulo', $title);
            $stmt->bindParam(':descripcion', $description);
            $stmt->bindParam(':prioridad', $priority);
            $stmt->execute();

            header("Location: ../listado.php");
            exit();

        } catch (PDOException $error) {
            die("Error al guardar el ticket: " . $error->getMessage());
        }

    } else {
        header("Location: ../registrar_ticket.php?error=1");
        exit();
    }
}
?>