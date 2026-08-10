<?php

require "includes/session.php";
require "config/db.php";

$query = "SELECT * FROM empresa ORDER BY id_empresa ASC LIMIT 1";
$resultado = $conn->query($query);
$empresa = $resultado->fetch_assoc();

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";

?>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fa-solid fa-building"></i>
            Datos de la Empresa
        </h2>
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
            <form action="controllers/guardarEmpresa.php" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre de la Empresa <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" class="form-control" required value="<?php echo $empresa['nombre'] ?? ''; ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">RTN</label>
                        <input type="text" name="rtn" class="form-control" value="<?php echo $empresa['rtn'] ?? ''; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="<?php echo $empresa['telefono'] ?? ''; ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Correo</label>
                        <input type="email" name="correo" class="form-control" value="<?php echo $empresa['correo'] ?? ''; ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="direccion" class="form-control" value="<?php echo $empresa['direccion'] ?? ''; ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Pie de Factura</label>
                    <textarea name="pie_factura" class="form-control" rows="2" placeholder="Mensaje que aparece al final de la factura..."><?php echo $empresa['pie_factura'] ?? ''; ?></textarea>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Guardar Cambios
                </button>
            </form>
        </div>
    </div>
</div>

<?php
include "includes/footer.php";
?>
