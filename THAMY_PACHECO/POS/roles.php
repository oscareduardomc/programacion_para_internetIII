<?php

require "includes/session.php";
require "config/db.php";

$query = "
    SELECT r.id_rol,
    r.nombre,
    r.descripcion,
    r.estado,
    r.fecha_creacion,
    COUNT(u.id_usuario) as total_usuarios
    FROM roles r
    LEFT JOIN usuarios u ON u.id_rol = r.id_rol AND u.estado = 1
    GROUP BY r.id_rol
    ORDER BY r.id_rol ASC
";
$resultado = $conn->query($query);

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";

?>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fa-solid fa-user-shield"></i>
            Roles
        </h2>
        <a class="btn btn-primary" href="nuevoRol.php">
            <i class="fa-solid fa-plus"></i>
            Nuevo Rol
        </a>
    </div>

    <?php if (isset($_SESSION['mensaje'])) { ?>
        <div class="alert alert-<?php echo $_SESSION['tipo']; ?>">
            <?php echo $_SESSION['mensaje']; ?>
        </div>
    <?php
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo']);
    } ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Usuarios Activos</th> 
                            <th>Fecha de creación</th>                 
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($rol = $resultado->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $rol['id_rol']; ?></td>
                                <td><?php echo $rol['nombre']; ?></td>
                                <td><?php echo $rol['descripcion'] ?? '—'; ?></td>
                                <td>
                                    <span class="badge bg-primary">
                                        <?php echo $rol['total_usuarios']; ?>
                                    </span>

                                </td>

                                <td><?php echo $rol['fecha_creacion']; ?></td>


                                <td>
                                    <?php if ($rol['estado'] == 1 && $rol['total_usuarios'] == 0 && $rol['id_rol'] != 1) { ?>

                                        <a href="controllers/estadoRol.php?id=<?php echo $rol['id_rol']; ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Desea desactivar este rol?')">
                                            <i class="fa-solid fa-ban"></i> Desactivar
                                        </a>

                                    <?php } elseif ($rol['estado'] == 0) { ?>

                                        <a href="controllers/estadoRol.php?id=<?php echo $rol['id_rol']; ?>"
                                            class="btn btn-success btn-sm"
                                            onclick="return confirm('¿Desea activar este rol?')">
                                            <i class="fa-solid fa-check"></i> Activar
                                        </a>

                                    <?php } else { ?>
                                        <span class="text-muted small">—</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="editarRol.php?id=<?php echo $rol['id_rol']; ?>"
                                        class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-pen"></i> Editar
                                    </a>
                                </td>
                                <td>

                                </td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>