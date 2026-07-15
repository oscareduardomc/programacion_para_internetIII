<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Registrar Categoría</h2>
    <a href="index.php?action=categorias" class="btn btn-secondary">Volver</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="index.php?action=guardar_categoria" method="POST">

            <div class="mb-3">
                <label class="form-label">Nombre de la Categoria</label>
                <input type="text" name="nombre_categoria" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <input type="text" name="descripcion" class="form-control" required>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="index.php?action=categorias" class="btn btn-outline-secondary">Cancelar</a>
            </div>

        </form>
    </div>
</div>