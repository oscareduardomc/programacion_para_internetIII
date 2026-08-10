<?php

require "includes/session.php";
require "config/db.php";

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";

?>
<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fa-solid fa-user-plus"></i>
            Ingresar Cliente
        </h2>
        <a href="clientes.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Regresar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="controllers/guardarCliente.php" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" name="nombre" placeholder="Ej. Juan Carlos Pérez" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Identidad / RTN</label>
                        <input type="text" class="form-control" name="identidad" placeholder="Ej. 0801199012345">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" name="telefono" placeholder="Ej. 9988-7766">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" name="correo" placeholder="ejemplo@correo.com">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Dirección</label>
                        <textarea class="form-control" name="direccion" rows="3" placeholder="Escribe la dirección del cliente..."></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Límite de Crédito (L)</label>
                        <input type="number" step="0.01" class="form-control" name="limite_credito" value="0.00">
                        <small class="text-muted">Monto máximo que se le permite fiar/crédito.</small>
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i>
                    Guardar Cliente
                </button>
            </form>
        </div>
    </div>
</div>

<?php
include "includes/footer.php";
?>
