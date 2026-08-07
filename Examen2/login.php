<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Soporte Técnico</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- CSS propio -->
    <link rel="stylesheet" href="assets/css/styleLogin.css">
</head>
<body>

    <div class="login-container">

        <div class="login-card">

            <div class="login-header">
                <i class=""></i>
                <h3>Soporte Técnico</h3>
                <p>Inicia sesión para continuar</p>
            </div>

            <div class="card-body">

                <?php if (isset($_SESSION['mensaje'])) { ?>
                    <div class="alert alert-<?php echo $_SESSION['tipo']; ?> alert-dismissible fade show">
                        <?php echo $_SESSION['mensaje']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php
                    unset($_SESSION['mensaje']);
                    unset($_SESSION['tipo']);
                } ?>

                <form action="controllers/login.php" method="POST">

                    <div class="mb-3">
                        <label class="form-label">Usuario</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-user"></i>
                            </span>
                            <input type="email" name="email" class="form-control"
                                   placeholder="correo@ejemplo.com" required autofocus>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Clave</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input type="password" name="password" id="password"
                                   class="form-control" placeholder="••••••••" required>
                            <button type="button" class="btn btn-outline-secondary"
                                    onclick="mostrarPassword()">
                                <i class="fa-solid fa-eye" id="iconoPassword"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-login text-white">
                            <i class="fa-solid fa-right-to-bracket"></i>
                            Iniciar Sesión
                        </button>
                    </div>

                </form>

            </div>

        </div>

        <div class="footer-login">
            Sistema de Soporte Técnico — Programación para Internet III
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function mostrarPassword() {
            const password = document.getElementById("password");
            const icono    = document.getElementById("iconoPassword");

            if (password.type === "password") {
                password.type = "text";
                icono.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                password.type = "password";
                icono.classList.replace("fa-eye-slash", "fa-eye");
            }
        }
    </script>

</body>
</html>