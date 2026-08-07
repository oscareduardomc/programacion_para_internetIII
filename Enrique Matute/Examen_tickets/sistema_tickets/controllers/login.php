<?php

session_start();
require "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['txtEmail']);
    $password = trim($_POST['txtPassword']);

    try {
        $sql = "SELECT id, nombre, password, rol FROM usuarios WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Credenciales correctas, se guarda la sesion
            $_SESSION['id'] = $user['id'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['rol'] = $user['rol'];

            header("Location: ../listado.php");
            exit();
        } else {
            // Credenciales incorrectas
            header("Location: ../login.php?error=1");
            exit();
        }

    } catch (PDOException $error) {
        die("Error de conexion: " . $error->getMessage());
    }
}
?><?php
// 1. Iniciar sesion y conectar a la base de datos
session_start();
require "../config/db.php";

// 2. Verificar que el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 3. Validar que los campos existan antes de leerlos
    if (isset($_POST['txtEmail']) && isset($_POST['txtPassword'])) {

        $email = trim($_POST['txtEmail']);
        $password = trim($_POST['txtPassword']);

        try {
            // 4. Buscar el usuario por correo
            $sql = "SELECT id, nombre, password, rol FROM usuarios WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // 5. Verificar la contrasena encriptada
            if ($user && password_verify($password, $user['password'])) {

                // 6. Guardar los datos de la sesion
                $_SESSION['id'] = $user['id'];
                $_SESSION['nombre'] = $user['nombre'];
                $_SESSION['rol'] = $user['rol'];

                header("Location: ../listado.php");
                exit();
            } else {
                header("Location: ../login.php?error=1");
                exit();
            }

        } catch (PDOException $error) {
            die("Error de conexion: " . $error->getMessage());
        }

    } else {
        header("Location: ../login.php?error=1");
        exit();
    }
}
?>