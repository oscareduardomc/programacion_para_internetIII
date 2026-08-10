<?php

session_start();

require "../config/db.php";


if (!isset($_GET['id'])) {

    header("Location: ../usuarios.php");
    exit;
}


$id_usuario = intval($_GET['id']);


// Validar que exista

$query = "SELECT id_usuario
          FROM usuarios
          WHERE id_usuario = ?";

$stmt = $conn->prepare($query);

$stmt->bind_param("i", $id_usuario);

$stmt->execute();

$resultado = $stmt->get_result();


if ($resultado->num_rows == 0) {

    $_SESSION['mensaje'] = "El usuario no existe.";
    $_SESSION['tipo'] = "warning";

    header("Location: ../usuarios.php");
    exit;

}


// No permitir eliminar el usuario administrador principal

if ($id_usuario == 1) {

    $_SESSION['mensaje'] = "No se puede desactivar el usuario Administrador principal.";
    $_SESSION['tipo'] = "warning";

    header("Location: ../usuarios.php");
    exit;

}



// Cambiar estado

$query = "UPDATE usuarios
          SET estado = 0
          WHERE id_usuario = ?";


$stmt = $conn->prepare($query);

$stmt->bind_param("i", $id_usuario);


if ($stmt->execute()) {

    $_SESSION['mensaje'] = "Usuario desactivado correctamente.";
    $_SESSION['tipo'] = "success";

} else {

    $_SESSION['mensaje'] = "Error al desactivar el usuario.";
    $_SESSION['tipo'] = "danger";

}


header("Location: ../usuarios.php");
exit;

?>