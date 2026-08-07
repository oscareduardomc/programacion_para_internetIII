<?php 
session_start();

if (isset($_SESSION['logueado']) && $_SESSION['logueado'] === true) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema de Tickets de Soporte</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="assets/css/styleLogin.css" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="card login-card">
            <div class="login-header">
                
                <h3>Sistema de Tickets de Soporte</h3>
                <p class="text-muted">Inicia sesión para gestionar tus tickets</p>
            </div>

            <div class="card-body p-4 pt-1">
                <?php
                if (isset($_SESSION['mensaje'])) {
                    $tipo = isset($_SESSION['tipo']) ? $_SESSION['tipo'] : 'danger';
                ?>
                    <div class="alert alert-<?php echo $tipo; ?> alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-exclamation me-2"></i>
                        <?php echo $_SESSION['mensaje']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                    unset($_SESSION['mensaje']);
                    unset($_SESSION['tipo']);
                }
                ?>

                <form action="controllers/login.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Correo Electrónico</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-envelope"></i>
                            </span>
                            <input type="email" name="email" class="form-control" placeholder="ejemplo@empresa.com" required autofocus>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Ingrese su clave" required>
                            <button type="button" class="btn btn-outline-secondary" onclick="mostrarPassword()">
                                <i class="fa-solid fa-eye" id="iconoPassword"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-login">
                            <i class="fa-solid fa-right-to-bracket me-2"></i>Iniciar Sesión
                        </button>
                    </div>
                </form>

            </div>
        </div>

        <div class="footer-login">
            Sistema de Tickets de Soporte | Examen II Programación para Internet III
            <hr>
            Realizado por Thamy Pacheco
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function mostrarPassword() {
            const password = document.getElementById("password");
            const icono = document.getElementById("iconoPassword");
            if (password.type === "password") {
                password.type = "text";
                icono.classList.remove("fa-eye");
                icono.classList.add("fa-eye-slash");
            } else {
                password.type = "password";
                icono.classList.remove("fa-eye-slash");
                icono.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html>
