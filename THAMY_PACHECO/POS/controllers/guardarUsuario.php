<?php

session_start();

require "../config/db.php";


if($_SERVER['REQUEST_METHOD'] == "POST"){


    $nombre  = trim($_POST['nombre']);
    $usuario = trim($_POST['usuario']);
    $correo  = trim($_POST['correo']);
    $password = $_POST['password'];
    $id_rol = intval($_POST['id_rol']);
    $estado = intval($_POST['estado']);



    // Validar campos obligatorios

    if(
        empty($nombre) ||
        empty($usuario) ||
        empty($password) ||
        empty($id_rol)
    ){

        $_SESSION['mensaje'] = "Complete todos los campos obligatorios.";
        $_SESSION['tipo'] = "danger";

        header("Location: ../nuevoUsuario.php");
        exit;

    }



    // Verificar usuario existente

    $consulta = "
        SELECT id_usuario 
        FROM usuarios 
        WHERE usuario = ?
    ";


    $stmt = $conn->prepare($consulta);

    $stmt->bind_param(
        "s",
        $usuario
    );


    $stmt->execute();


    $resultado = $stmt->get_result();



    if($resultado->num_rows > 0){


        $_SESSION['mensaje'] = "El nombre de usuario ya existe.";
        $_SESSION['tipo'] = "warning";


        header("Location: ../nuevoUsuario.php");

        exit;

    }



    // Encriptar contraseña

    $password_hash = password_hash(
        $password,
        PASSWORD_DEFAULT
    );



    // Insertar usuario

    $query = "

        INSERT INTO usuarios
        (
            nombre,
            usuario,
            correo,
            password,
            id_rol,
            estado
        )

        VALUES
        (
            ?,
            ?,
            ?,
            ?,
            ?,
            ?
        )

    ";



    $stmt = $conn->prepare($query);



    $stmt->bind_param(
        "ssssii",
        $nombre,
        $usuario,
        $correo,
        $password_hash,
        $id_rol,
        $estado
    );



    if($stmt->execute()){


        $_SESSION['mensaje'] = "Usuario registrado correctamente.";
        $_SESSION['tipo'] = "success";


        header("Location: ../usuarios.php");

        exit;


    }else{


        $_SESSION['mensaje'] = "Error al guardar el usuario.";
        $_SESSION['tipo'] = "danger";


        header("Location: ../nuevoUsuario.php");

        exit;

    }



}else{


    header("Location: ../usuarios.php");

    exit;

}


$conn->close();

?>