<?php
require "includes/session.php";
require "config/db.php";

// Restricción: Solo el perfil técnico puede acceder a esta gestión
if ($_SESSION['rol'] !== 'tecnico') {
    $_SESSION['mensaje'] = "Acceso denegado. Solo el perfil Técnico puede ver y gestionar usuarios.";
    $_SESSION['tipo'] = "danger";
    header("Location: dashboard.php");
    exit;
}

$query = "SELECT id, nombre, email, rol FROM usuarios ORDER BY id DESC";
$resultado = $conn->query($query);

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";
?>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fa-solid fa-users text-primary me-2"></i>Gestión de Usuarios
        </h2>
        <a href="nuevoUsuario.php" class="btn btn-primary shadow-sm">
            <i class="fa-solid fa-user-plus me-1"></i> Registrar Nuevo Usuario
        </a>
    </div>

    <?php if (isset($_SESSION['mensaje'])) { ?>
        <div class="alert alert-<?php echo $_SESSION['tipo'] ?? 'info'; ?> alert-dismissible fade show shadow-sm mb-4">
            <i class="fa-solid fa-circle-info me-2"></i>
            <?php echo $_SESSION['mensaje']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php 
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo']);
        }
        ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle datatable w-100">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 60px;">ID</th>
                            <th>Nombre Completo</th>
                            <th>Correo Electrónico</th>
                            <th>Rol / Perfil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($resultado && $resultado->num_rows > 0) { ?>
                            <?php while ($user = $resultado->fetch_assoc()) { ?>
                                <tr>
                                    <td><strong>#<?php echo $user['id']; ?></strong></td>
                                    <td class="fw-bold text-dark"><?php echo htmlspecialchars($user['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td>
                                        <?php if ($user['rol'] === 'tecnico') { ?>
                                            <span class="badge bg-danger px-3 py-2">
                                                <i class="fa-solid fa-user-gear me-1"></i>Técnico
                                            </span>
                                        <?php } else { ?>
                                            <span class="badge bg-primary px-3 py-2">
                                                <i class="fa-solid fa-user me-1"></i>Usuario
                                            </span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>
