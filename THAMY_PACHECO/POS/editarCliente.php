<?php

require "includes/session.php";
require "config/db.php";

if (!isset($_GET['id'])) {

    header("Location: clientes.php");
    exit;
}

$id_cliente = intval($_GET['id']);

$query = "SELECT * FROM clientes WHERE id_cliente = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {

    header("Location: clientes.php");
    exit;
}

$cli = $resultado->fetch_assoc();

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";

?>
<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fa-solid fa-user-pen"></i>
            Editar Cliente
        </h2>
        <a href="clientes.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Regresar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="controllers/actualizarCliente.php" method="POST">
                <input type="hidden" name="id_cliente" value="<?php echo $cli['id_cliente']; ?>">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre Completo</label>
                        <input type="text" name="nombre" class="form-control" required value="<?php echo $cli['nombre']; ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Identidad / RTN</label>
                        <input type="text" name="identidad" class="form-control" value="<?php echo $cli['identidad'] ?? ''; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="<?php echo $cli['telefono'] ?? ''; ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" name="correo" class="form-control" value="<?php echo $cli['correo'] ?? ''; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Dirección</label>
                        <textarea name="direccion" class="form-control" rows="3"><?php echo $cli['direccion'] ?? ''; ?></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Límite de Crédito (L)</label>
                        <input type="number" step="0.01" name="limite_credito" class="form-control" value="<?php echo $cli['limite_credito']; ?>">
                        <small class="text-muted">Monto máximo que se le permite fiar/crédito.</small>
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Actualizar Cliente
                </button>
            </form>
        </div>
    </div>
</div>

<?php
include "includes/footer.php";
?>
