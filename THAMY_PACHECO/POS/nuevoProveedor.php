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
            <i class="fa-solid fa-truck"></i>
            Nuevo Proveedor
        </h2>
        <a href="proveedores.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Regresar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="controllers/guardarProveedor.php" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Nombre / Empresa</label>
                        <input type="text" class="form-control" name="nombre" placeholder="Ej. Cervecería Hondureña" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Persona de Contacto</label>
                        <input type="text" class="form-control" name="contacto" placeholder="Ej. Lic. Carlos Mendoza">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" name="telefono" placeholder="Ej. 2234-5678">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" name="email" placeholder="ventas@proveedor.com">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Dirección</label>
                    <textarea class="form-control" name="direccion" rows="3" placeholder="Escribe la dirección de la empresa o distribuidor..."></textarea>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i>
                    Guardar Proveedor
                </button>
            </form>
        </div>
    </div>
</div>

<?php
include "includes/footer.php";
?>
