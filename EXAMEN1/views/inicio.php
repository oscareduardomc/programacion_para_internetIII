<?php 
    $repuestos = RepuestoControllers::listar();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Lista de Repuestos</h2>
    <a href="index.php?action=crear" class="btn btn-primary">Nuevo Repuesto</a>
</div>


<?php 
      if (isset($_GET['mensaje'])) {
    if ($_GET['mensaje'] == 'error_stock') echo "<div class='alert alert-danger'>Error: No  puede eliminar por completo si el stock es mayor a 0.</div>";
    else echo "<div class='alert alert-success'>Operación realizada con éxito.</div>";
}
?>

<table class="table table-hover border">
    <thead class="table-dark">
        <tr>
            <th>Codigo</th>
              <th>Nombre</th>
                <th>Categoría</th>
            <th>Precio</th>
              <th>Stock</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($repuestos as $p): 

            $clase = ($p['stock'] < 5) ? 'table-warning' : '';
        ?>
            <tr class="<?php echo $clase; ?>">
                <td><?php echo ($p['codigo_pieza']); ?></td>
                <td><?php echo ($p['nombre']); ?></td>
                <td><?php echo ($p['nombre_categoria']); ?></td>
                <td><?php echo number_format($p['precio'], 2); ?></td>
                <td><?php echo ($p['stock']); ?></td>
                <td>
                    <a href="index.php?action=editar&id=<?php echo $p['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="index.php?action=desactivar&id=<?php echo $p['id']; ?>" class="btn btn-secondary btn-sm" onclick="return confirm('Seguro que deseas inactivar el repuesto?')">Inactivar</a>
                    
                   
                    <a href="index.php?action=eliminar&id=<?php echo $p['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Eliminar por completo? ')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>