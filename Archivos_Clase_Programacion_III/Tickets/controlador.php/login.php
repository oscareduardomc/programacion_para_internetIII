<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema de Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .login-card { max-width: 400px; margin: 80px auto; border-radius: 12px; border: none; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="container">
    <div class="card login-card p-4">
        <div class="text-center mb-4">
            <i class="fa-solid fa-headset fa-3x text-primary mb-2"></i>
            <h4>Sistema de Tickets</h4>
            <p class="text-muted">Inicia sesión para continuar</p>
        </div>

  
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-<?php echo $_SESSION['tipo']; ?> alert-dismissible fade show">
                <?php 
                    echo $_SESSION['mensaje']; 
                    unset($_SESSION['mensaje']);
                    unset($_SESSION['tipo']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>


        <form action="controllers/login.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Correo Electrónico</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="correo@ejemplo.com" required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="••••" required>
                </div>
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-right-to-bracket"></i> Iniciar Sesión
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>