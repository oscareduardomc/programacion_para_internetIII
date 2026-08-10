<?php

require "includes/session.php";
require "config/db.php";

$query = "SELECT * FROM clientes ORDER BY id_cliente DESC";
$resultado = $conn->query($query);

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";

?>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fa-solid fa-address-book"></i>
            Clientes
        </h2>
        <a class="btn btn-primary" href="ingresarCliente.php">
            <i class="fa-solid fa-plus"></i>
            Ingresar Cliente
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
                            <th>Identidad</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Límite Crédito</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($cli = $resultado->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $cli['id_cliente']; ?></td>
                                <td><?php echo $cli['nombre']; ?></td>
                                <td><?php echo $cli['identidad'] ?? '—'; ?></td>
                                <td><?php echo $cli['telefono'] ?? '—'; ?></td>
                                <td><?php echo $cli['correo'] ?? '—'; ?></td>
                                <td>L <?php echo number_format($cli['limite_credito'], 2); ?></td>
                                <td>
                                    <?php if ($cli['estado'] == 1) { ?>
                                        <span class="badge bg-success">Activo</span>
                                    <?php } else { ?>
                                        <span class="badge bg-danger">Inactivo</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="editarCliente.php?id=<?php echo $cli['id_cliente']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <?php if ($cli['estado'] == 1) { ?>
                                        <a href="controllers/eliminarCliente.php?id=<?php echo $cli['id_cliente']; ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('¿Desea desactivar este cliente?')">
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
