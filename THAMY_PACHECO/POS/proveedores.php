<?php

require "includes/session.php";
require "config/db.php";

$query = "SELECT * FROM proveedores ORDER BY id_proveedor DESC";
$resultado = $conn->query($query);

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";

?>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fa-solid fa-truck"></i>
            Proveedores
        </h2>
        <a class="btn btn-primary" href="nuevoProveedor.php">
            <i class="fa-solid fa-plus"></i>
            Nuevo Proveedor
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
                            <th>Nombre / Empresa</th>
                            <th>Contacto</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($prov = $resultado->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $prov['id_proveedor']; ?></td>
                                <td><?php echo $prov['nombre']; ?></td>
                                <td><?php echo $prov['contacto'] ?? '—'; ?></td>
                                <td><?php echo $prov['telefono'] ?? '—'; ?></td>
                                <td><?php echo $prov['email'] ?? '—'; ?></td>
                                <td>
                                    <?php if ($prov['estado'] == 1) { ?>
                                        <span class="badge bg-success">Activo</span>
                                    <?php } else { ?>
                                        <span class="badge bg-danger">Inactivo</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="editarProveedor.php?id=<?php echo $prov['id_proveedor']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <?php if ($prov['estado'] == 1) { ?>
                                        <a href="controllers/eliminarProveedor.php?id=<?php echo $prov['id_proveedor']; ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('¿Desea desactivar este proveedor?')">
                                            <i class="fa-solid fa-user-slash"></i>
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include "includes/footer.php";
?>
