<?php

session_start();

require "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $id_usuario = intval($_POST['id_usuario']);
    $nombre     = trim($_POST['nombre']);
    $usuario    = trim($_POST['usuario']);
    $correo     = trim($_POST['correo']);
    $password   = trim($_POST['password']);
    $id_rol     = intval($_POST['id_rol']);
    $estado     = intval($_POST['estado']);


    if (
        empty($id_usuario) ||
        empty($nombre) ||
        empty($usuario) ||
        empty($id_rol)
    ) {

        $_SESSION['mensaje'] = "Complete todos los campos obligatorios.";
        $_SESSION['tipo'] = "danger";

        header("Location: ../editarUsuario.php?id=".$id_usuario);
        exit;
    }


    // Verificar que el usuario no exista en otro registro

    $query = "SELECT id_usuario
              FROM usuarios
              WHERE usuario = ?
              AND id_usuario <> ?";

    $stmt = $conn->prepare($query);

    $stmt->bind_param("si", $usuario, $id_usuario);

    $stmt->execute();

    $resultado = $stmt->get_result();


    if ($resultado->num_rows > 0) {

        $_SESSION['mensaje'] = "El nombre de usuario ya existe.";
        $_SESSION['tipo'] = "warning";

        header("Location: ../editarUsuario.php?id=".$id_usuario);
        exit;
    }


    // Si escribió contraseña se actualiza
    // Si la dejó vacía se conserva la actual

    if (!empty($password)) {

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $query = "UPDATE usuarios
                  SET
                    nombre=?,
                    usuario=?,
                    correo=?,
                    password=?,
                    id_rol=?,
                    estado=?
                  WHERE id_usuario=?";

        $stmt = $conn->prepare($query);

        $stmt->bind_param(
            "ssssiii",
            $nombre,
            $usuario,
            $correo,
            $passwordHash,
            $id_rol,
            $estado,
            $id_usuario
        );

    } else {

        $query = "UPDATE usuarios
                  SET
                    nombre=?,
                    usuario=?,
                    correo=?,
                    id_rol=?,
                    estado=?
                  WHERE id_usuario=?";

        $stmt = $conn->prepare($query);

        $stmt->bind_param(
            "sssiii",
            $nombre,
            $usuario,
            $correo,
            $id_rol,
            $estado,
            $id_usuario
        );

    }


    if ($stmt->execute()) {

        $_SESSION['mensaje'] = "Usuario actualizado correctamente.";
        $_SESSION['tipo'] = "success";

    } else {

        $_SESSION['mensaje'] = "Error al actualizar el usuario.";
        $_SESSION['tipo'] = "danger";

    }

    header("Location: ../usuarios.php");
    exit;

}

header("Location: ../usuarios.php");
exit;

?>