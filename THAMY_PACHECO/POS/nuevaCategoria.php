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
            <i class="fa-solid fa-tags"></i>
            Nueva Categoría
        </h2>
        <a href="categorias.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Regresar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="controllers/guardarCategoria.php" method="POST">
                <div class="mb-3">
                    <label for="" class="form-label">Nombre de la Categoría</label>
                    <input type="text" class="form-control" name="categoria" placeholder="Ej. Bebidas" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Descripción</label>
                    <textarea class="form-control" name="descripcion" rows="3" placeholder="Escribe una breve descripción..."></textarea>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i>
                    Guardar Categoría
                </button>
            </form>
        </div>
    </div>
</div>

<?php
include "includes/footer.php";
?>
