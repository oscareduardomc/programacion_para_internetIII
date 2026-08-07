<?php

session_start();

require "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $id     = intval($_POST['id']);
    $estado = trim($_POST['estado']);


    if (
        empty($id) ||
        empty($estado)
    ) {

        $_SESSION['mensaje'] = "Complete todos los campos obligatorios.";
        $_SESSION['tipo'] = "danger";

        header("Location: ../verTicket.php?id=".$id);
        exit;
    }


    // Actualizar estado del ticket

    $query = "UPDATE tickets
              SET
                estado=?
              WHERE id=?";

    $stmt = $conn->prepare($query);

    $stmt->bind_param(
        "si",
        $estado,
        $id
    );


    if ($stmt->execute()) {

        $_SESSION['mensaje'] = "Estado actualizado correctamente.";
        $_SESSION['tipo'] = "success";

    } else {

        $_SESSION['mensaje'] = "Error al actualizar el estado.";
        $_SESSION['tipo'] = "danger";

    }

    header("Location: ../verTicket.php?id=".$id);
    exit;

}

header("Location: ../tickets.php");
exit;

?>