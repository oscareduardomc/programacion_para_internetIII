<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
session_start();
// Si ya hay sesion activa, manda directo al listado
if (isset($_SESSION['id'])) {
    header("Location: listado.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion - Sistema de Tickets</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
        body {
            background-color: #0d6efd;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 380px;
        }
        .login-icon {
            font-size: 40px;
            color: #0d6efd;
        }
    </style>
</head>
<body>

    <div class="card login-card shadow p-4">
        <div class="text-center mb-3">
            <i class="fa-solid fa-headset login-icon"></i>
            <h4 class="fw-bold mt-2">Sistema de Tickets</h4>
            <p class="text-muted">Inicia sesion para continuar</p>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger py-2">
                Usuario o contrasena incorrectos.
            </div>
        <?php endif; ?>

        <form action="controllers/login.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Correo</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                    <input type="email" name="txtEmail" class="form-control" placeholder="Ingrese su correo" required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Clave</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="txtPassword" class="form-control" placeholder="Ingrese su clave" required>
                </div>
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-right-to-bracket"></i> Iniciar Sesion
                </button>
            </div>
        </form>
    </div>

</body>
</html>