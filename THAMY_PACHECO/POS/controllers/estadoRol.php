<?php

session_start();

require "../config/db.php";


if (!isset($_GET['id'])) {

    header("Location: ../roles.php");
    exit;
}


$id_rol = intval($_GET['id']);



$query = "SELECT *
          FROM roles
          WHERE id_rol = ?";

$stmt = $conn->prepare($query);

$stmt->bind_param("i", $id_rol);

$stmt->execute();

$resultado = $stmt->get_result();


if ($resultado->num_rows == 0) {

    $_SESSION['mensaje'] = "El rol no existe.";
    $_SESSION['tipo'] = "warning";

    header("Location: ../roles.php");
    exit;

}

$rol = $resultado->fetch_assoc();

$nuevo_estado = ($rol['estado'] == 1) ? 0 : 1;



if ($nuevo_estado == 0) {

    if ($id_rol == 1) {

        $_SESSION['mensaje'] = "No se puede desactivar el rol Administrador principal.";
        $_SESSION['tipo'] = "warning";

        header("Location: ../roles.php");
        exit;

    }

    $query_usuarios = "SELECT COUNT(*) as total 
                       FROM usuarios 
                       WHERE id_rol = ?";

    $stmt_u = $conn->prepare($query_usuarios);

    $stmt_u->bind_param("i", $id_rol);

    $stmt_u->execute();

    $total_usuarios = $stmt_u->get_result()->fetch_assoc()['total'];


    if ($total_usuarios > 0) {

        $_SESSION['mensaje'] = "No se puede desactivar el rol porque tiene usuarios asignados.";
        $_SESSION['tipo'] = "warning";

        header("Location: ../roles.php");
        exit;

    }

}




$query = "UPDATE roles
          SET estado = ?
          WHERE id_rol = ?";


$stmt = $conn->prepare($query);

$stmt->bind_param("ii", $nuevo_estado, $id_rol);


if ($stmt->execute()) {

    $mensaje = ($nuevo_estado == 1) ? "Rol activado correctamente." : "Rol desactivado correctamente.";
    $_SESSION['mensaje'] = $mensaje;
    $_SESSION['tipo'] = "success";

} else {

    $mensaje = ($nuevo_estado == 1) ? "Error al activar el rol." : "Error al desactivar el rol.";
    $_SESSION['mensaje'] = $mensaje;
    $_SESSION['tipo'] = "danger";

}


header("Location: ../roles.php");
exit;

?>