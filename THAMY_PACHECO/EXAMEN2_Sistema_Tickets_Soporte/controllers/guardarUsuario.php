<?php
session_start();
require "../config/db.php";

if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    header("Location: ../login.php");
    exit;
}

// Solo los usuarios con rol Técnico pueden agregar nuevos usuarios
if ($_SESSION['rol'] !== 'tecnico') {
    $_SESSION['mensaje'] = "Acceso denegado. Solo el perfil Técnico puede registrar nuevos usuarios.";
    $_SESSION['tipo'] = "danger";
    header("Location: ../dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = trim($_POST['nombre'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $rol      = trim($_POST['rol'] ?? 'usuario');

    // Validar campos obligatorios
    if (empty($nombre) || empty($email) || empty($password) || empty($rol)) {
        $_SESSION['mensaje'] = "Por favor complete todos los campos obligatorios.";
        $_SESSION['tipo'] = "warning";
        header("Location: ../nuevoUsuario.php");
        exit;
    }

    // Validar formato de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['mensaje'] = "El correo electrónico ingresado no tiene un formato válido.";
        $_SESSION['tipo'] = "warning";
        header("Location: ../nuevoUsuario.php");
        exit;
    }

    // Validar rol permitido
    if (!in_array($rol, ['usuario', 'tecnico'])) {
        $rol = 'usuario';
    }

    // Verificar si el correo ya existe
    $query_check = "SELECT id FROM usuarios WHERE email = ? LIMIT 1";
    $stmt_check = $conn->prepare($query_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $res_check = $stmt_check->get_result();

    if ($res_check && $res_check->num_rows > 0) {
        $_SESSION['mensaje'] = "El correo electrónico '$email' ya se encuentra registrado.";
        $_SESSION['tipo'] = "warning";
        header("Location: ../nuevoUsuario.php");
        exit;
    }
    $stmt_check->close();

    // Cifrar la contraseña
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Insertar nuevo usuario
    $query = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        $_SESSION['mensaje'] = "Error al preparar la consulta de registro de usuario.";
        $_SESSION['tipo'] = "danger";
        header("Location: ../nuevoUsuario.php");
        exit;
    }

    $stmt->bind_param("ssss", $nombre, $email, $passwordHash, $rol);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "¡Usuario registrado correctamente!";
        $_SESSION['tipo'] = "success";
        header("Location: ../usuarios.php");
        exit;
    } else {
        $_SESSION['mensaje'] = "Error al registrar el usuario en la base de datos.";
        $_SESSION['tipo'] = "danger";
        header("Location: ../nuevoUsuario.php");
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../usuarios.php");
    exit;
}
?>
