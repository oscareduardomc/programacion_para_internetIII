<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema de Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Sistema de Tickets</h4>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($_SESSION['mensaje'])) {
                        $tipo = $_SESSION['tipo'] ?? 'danger';
                        echo '<div class="alert alert-'.$tipo.'">'.$_SESSION['mensaje'].'</div>';
                        unset($_SESSION['mensaje'], $_SESSION['tipo']);
                    }
                    ?>
                    <form action="controllers/login.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Clave</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-center mt-3 text-muted">Programación para Internet III</p>
        </div>
    </div>
</div>
</body>
</html>
