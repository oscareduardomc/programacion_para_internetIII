<?php

require "includes/session.php";
require "config/db.php";

$query = "SELECT * FROM categorias ORDER BY id_categoria DESC";
$resultado = $conn->query($query);

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";

?>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fa-solid fa-tags"></i>
            Categorías
        </h2>
        <a class="btn btn-primary" href="nuevaCategoria.php">
            <i class="fa-solid fa-plus"></i>
            Nueva Categoría
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
                            <th>Categoría</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($cat = $resultado->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $cat['id_categoria']; ?></td>
                                <td><?php echo $cat['categoria']; ?></td>
                                <td><?php echo $cat['descripcion'] ?? '—'; ?></td>
                                <td>
                                    <?php if ($cat['estado'] == 1) { ?>
                                        <span class="badge bg-success">Activo</span>
                                    <?php } else { ?>
                                        <span class="badge bg-danger">Inactivo</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="editarCategoria.php?id=<?php echo $cat['id_categoria']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <?php if ($cat['estado'] == 1) { ?>
                                        <a href="controllers/eliminarCategoria.php?id=<?php echo $cat['id_categoria']; ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('¿Desea desactivar esta categoría?')">
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
