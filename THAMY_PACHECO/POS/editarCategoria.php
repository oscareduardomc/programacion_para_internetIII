<?php

require "includes/session.php";
require "config/db.php";

if (!isset($_GET['id'])) {

    header("Location: categorias.php");
    exit;
}

$id_categoria = intval($_GET['id']);

$query = "SELECT * FROM categorias WHERE id_categoria = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_categoria);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {

    header("Location: categorias.php");
    exit;
}

$cat = $resultado->fetch_assoc();

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";

?>
<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fa-solid fa-pen-to-square"></i>
            Editar Categoría
        </h2>
        <a href="categorias.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Regresar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="controllers/actualizarCategoria.php" method="POST">
                <input type="hidden" name="id_categoria" value="<?php echo $cat['id_categoria']; ?>">
                <div class="mb-3">
                    <label class="form-label">Nombre de la Categoría</label>
                    <input type="text" name="categoria" class="form-control" required value="<?php echo $cat['categoria']; ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="3"><?php echo $cat['descripcion'] ?? ''; ?></textarea>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Actualizar Categoría
                </button>
            </form>
        </div>
    </div>
</div>

<?php
include "includes/footer.php";
?>
