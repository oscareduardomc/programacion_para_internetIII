<?php

require "includes/session.php";
require "config/db.php";

if (!isset($_GET['id'])) {

    header("Location: proveedores.php");
    exit;
}

$id_proveedor = intval($_GET['id']);

$query = "SELECT * FROM proveedores WHERE id_proveedor = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_proveedor);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {

    header("Location: proveedores.php");
    exit;
}

$prov = $resultado->fetch_assoc();

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";

?>
<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fa-solid fa-pen-to-square"></i>
            Editar Proveedor
        </h2>
        <a href="proveedores.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Regresar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="controllers/actualizarProveedor.php" method="POST">
                <input type="hidden" name="id_proveedor" value="<?php echo $prov['id_proveedor']; ?>">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre / Empresa</label>
                        <input type="text" name="nombre" class="form-control" required value="<?php echo $prov['nombre']; ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Persona de Contacto</label>
                        <input type="text" name="contacto" class="form-control" value="<?php echo $prov['contacto'] ?? ''; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="<?php echo $prov['telefono'] ?? ''; ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $prov['email'] ?? ''; ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Dirección</label>
                    <textarea name="direccion" class="form-control" rows="3"><?php echo $prov['direccion'] ?? ''; ?></textarea>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Actualizar Proveedor
                </button>
            </form>
        </div>
    </div>
</div>

<?php
include "includes/footer.php";
?>
