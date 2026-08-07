<?php

    session_start();
    require "../config/db.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $correo = trim($_POST['correo'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($correo) || empty($password)){
            $_SESSION['mensaje'] = "Por favor, complete todos los campos";
            $_SESSION['tipo'] = "danger";

            header("Location: ../login.php");
            exit;
        }

        $query = "SELECT id, nombre, correo, password, rol
                    FROM usuarios
                    WHERE correo = ?
                    LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0){
            $datos_usuario = $resultado->fetch_assoc();

            if (password_verify($password, $datos_usuario['password'])){
                session_regenerate_id(true);
                $_SESSION['id_usuario'] = $datos_usuario['id'];
                $_SESSION['nombre'] = $datos_usuario['nombre'];
                $_SESSION['correo'] = $datos_usuario['correo'];
                $_SESSION['rol'] = $datos_usuario['rol'];
                $_SESSION['logueado'] = true;

                header("Location: ../tickets.php");
                exit;

            }else{
                $_SESSION['mensaje'] = "Correo o clave incorrectos";
                $_SESSION['tipo'] = "danger";

                header("Location: ../login.php");
                exit;
            }

        }else{
            $_SESSION['mensaje'] = "Correo o clave incorrectos";
            $_SESSION['tipo'] = "danger";

            header("Location: ../login.php");
            exit;
        }

        $stmt->close();
    }else{
        header("Location: ../login.php");
        exit;
    }
    $conn->close();
?>
