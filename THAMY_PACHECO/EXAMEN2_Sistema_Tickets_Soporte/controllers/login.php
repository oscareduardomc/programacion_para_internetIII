<?php
session_start();
require "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $_SESSION['mensaje'] = "Por favor, llene todos los campos obligatorios.";
        $_SESSION['tipo'] = "warning";
        header("Location: ../login.php");
        exit;
    }

    $query = "SELECT id, nombre, email, password, rol FROM usuarios WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        $_SESSION['mensaje'] = "Error en la consulta a la base de datos.";
        $_SESSION['tipo'] = "danger";
        header("Location: ../login.php");
        exit;
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado && $resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($password, $usuario['password']) || $password === $usuario['password']) {
            session_regenerate_id(true);

            $_SESSION['id_usuario'] = $usuario['id'];
            $_SESSION['nombre']     = $usuario['nombre'];
            $_SESSION['email']      = $usuario['email'];
            $_SESSION['rol']        = $usuario['rol'];
            $_SESSION['logueado']   = true;

            $_SESSION['mensaje'] = "¡Bienvenido/a, " . htmlspecialchars($usuario['nombre']) . "!";
            $_SESSION['tipo']    = "success";

            header("Location: ../dashboard.php");
            exit;
        } else {
            $_SESSION['mensaje'] = "La contraseña ingresada es incorrecta.";
            $_SESSION['tipo']    = "danger";
            header("Location: ../login.php");
            exit;
        }
    } else {
        $_SESSION['mensaje'] = "No existe una cuenta registrada con este correo.";
        $_SESSION['tipo']    = "danger";
        header("Location: ../login.php");
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../login.php");
    exit;
}
?>
