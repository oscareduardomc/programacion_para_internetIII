<?php

    session_start();
    require "../config/db.php";
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $usuario = trim($_POST['usuario'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($usuario) || empty($password)){
            $_SESSION['mensaje'] = "Por favor, complete todos los campos";
            $_SESSION['tipo'] = "danger";

            header("Location: ../login.php");
            exit;
        }

        $query = "SELECT
                    u.id_usuario,
                    u.nombre,
                    u.usuario,
                    u.correo,
                    u.password,
                    u.id_rol,
                    u.estado,
                    r.nombre as nombre_rol

                    FROM usuarios u
                    INNER JOIN roles r
                        ON u.id_rol = r.id_rol
                        WHERE u.usuario = ?
                        LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0){
            $datos_usuario = $resultado->fetch_assoc();

            if ($datos_usuario['estado'] != 1){
                $_SESSION['mensaje'] = "El usuario se encuentra inactivo";
                $_SESSION['tipo'] = "danger";
                header("Location: ../login.php");
                exit;
            }
            if (password_verify($password, $datos_usuario['password'])){
                session_regenerate_id(true);
                $_SESSION['id_usuario'] = $datos_usuario['id_usuario'];
                $_SESSION['nombre'] = $datos_usuario['nombre'];
                $_SESSION['usuario'] = $datos_usuario['usuario'];
                $_SESSION['correo'] = $datos_usuario['correo'];
                $_SESSION['id_rol'] = $datos_usuario['id_rol'];
                $_SESSION['nombre_rol'] = $datos_usuario['nombre_rol'];
                $_SESSION['logueado'] = true ;

                // Actualizar la fecha del ultimo acceso
                $query_actualizar = "
                UPDATE usuarios set ultimo_acceso = NOW() where id_usuario = ?";
                $stmt_actualizar = $conn->prepare($query_actualizar);
                $stmt_actualizar->bind_param("i", $datos_usuario['id_usuario']);
                $stmt_actualizar->execute();
                $stmt_actualizar->close();

                header("Location: ../dashboard.php");
                exit;

            }else{
                $_SESSION['mensaje'] = "Usuario o clave incorrectos";
                $_SESSION['tipo'] = "danger";

                header("Location: ../login.php");
                exit;
            }

        }else{
                $_SESSION['mensaje'] = "Usuario o clave incorrectos";
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