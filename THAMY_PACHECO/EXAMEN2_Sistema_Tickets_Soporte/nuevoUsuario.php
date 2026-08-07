<?php
require "includes/session.php";
require "config/db.php";

// Restricción: Solo el perfil técnico puede acceder a esta vista
if ($_SESSION['rol'] !== 'tecnico') {
    $_SESSION['mensaje'] = "Acceso denegado. Solo el perfil Técnico puede registrar nuevos usuarios.";
    $_SESSION['tipo'] = "danger";
    header("Location: dashboard.php");
    exit;
}

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";
?>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            Registrar Nuevo Usuario
        </h2>
    </div>

    <?php if (isset($_SESSION['mensaje'])) { ?>
        <div class="alert alert-<?php echo $_SESSION['tipo'] ?? 'info'; ?> alert-dismissible fade show shadow-sm mb-4">
            
            <?php echo $_SESSION['mensaje']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php 
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo']);
        }
        ?>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        Datos del Nuevo Usuario
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="controllers/guardarUsuario.php" method="POST" id="formNuevoUsuario">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label fw-bold">Nombre Completo <span class="text-danger"></span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese nombre y apellido" required autofocus>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-bold">Correo Electrónico <span class="text-danger"></span></label>
                                <div class="input-group">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="correo@empresa.com" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label fw-bold">Contraseña <span class="text-danger"></span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese clave inicial" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="rol" class="form-label fw-bold">Rol / Perfil <span class="text-danger"></span></label>
                                <div class="input-group">
                                    <select class="form-select" id="rol" name="rol" required>
                                        <option value="usuario">Usuario</option>
                                        <option value="tecnico">Técnico</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="usuarios.php" class="btn btn-secondary px-4">
                                 Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold">
                                Guardar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>
