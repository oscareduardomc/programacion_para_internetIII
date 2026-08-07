<?php

    session_start();
    require "../config/db.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)){
            $_SESSION['mensaje'] = "Por favor, complete todos los campos";
            $_SESSION['tipo'] = "danger";

            header("Location: ../login.php");
            exit;
        }

        $query = "SELECT
                    id,
                    nombre,
                    email,
                    password,
                    rol
                    FROM usuarios
                    WHERE email = ?
                    LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0){
            $datos_usuario = $resultado->fetch_assoc();

            if (password_verify($password, $datos_usuario['password'])){
                session_regenerate_id(true);
                $_SESSION['id'] = $datos_usuario['id'];
                $_SESSION['nombre'] = $datos_usuario['nombre'];
                $_SESSION['email'] = $datos_usuario['email'];
                $_SESSION['rol'] = $datos_usuario['rol'];
                $_SESSION['logueado'] = true;

                header("Location: ../dashboard.php");
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
