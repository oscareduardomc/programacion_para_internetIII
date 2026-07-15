<?php
require_once 'controlador.php';
require_once 'conexion.php';

try {
    $stmt = $conexion->prepare("SELECT * FROM clientes");
    $stmt->execute();
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestion de Proyectos</title>
    <link href="bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">    
    <div class="container mt-5">
        <h1 class="text-center mb-4">Agencia - Gestion de Proyectos</h1>
        
        <?php if (isset($_GET['mensaje'])): ?>
            <div class="alert alert-success"><?php echo $_GET['mensaje']; ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo $_GET['error']; ?></div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm p-4">
                    <h4 class="card-title mb-3">Nuevo Proyecto</h4>

                    <form action="index.php" method="POST">
                        <div class="mb-3">
                            <label for="" class="form-label">Titulo Proyecto:</label>
                            <input type="text" name="titulo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Descripcion:</label>
                            <textarea name="descripcion" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Cliente:</label>
                            <select name="id_cliente" class="form-select" required>
                                <option value="">Seleccione...</option>
                                <?php
                                foreach ($clientes as $cli) {
                                    echo "<option value='" . $cli['id'] . "'>" . $cli['nombre_empresa'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Presupuesto:</label>
                            <input type="number" step="0.01" name="presupuesto" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Fecha Entrega:</label>
                            <input type="date" name="fecha_entrega" class="form-control" required>
                        </div>
                        <button type="submit" name="btn_registrar" class="btn btn-warning w-100">Guardar Proyecto</button>
                    </form>

                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm p-4">
                    <h4 class="card-title mb-3">Proyectos en Desarrollo</h4>
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Titulo</th>
                                <th>Cliente</th>
                                <th>Presupuesto</th>
                                <th>Entrega</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($lista_proyectos) > 0): ?>
                                <?php foreach ($lista_proyectos as $pro): ?>
                                    <tr>
                                        <td><strong><?php echo $pro['titulo']; ?></strong></td>
                                        <td><?php echo $pro['nombre_empresa']; ?></td>
                                        <td><?php echo "$" . number_format($pro['presupuesto'], 2); ?></td>
                                        <td><?php echo $pro['fecha_entrega']; ?></td>
                                        <td>
                                            <a href="index.php?accion=logico&id=<?php echo $pro['id']; ?>" class="btn btn-warning btn-sm">Pausar</a>
                                            <a href="index.php?accion=fisico&id=<?php echo $pro['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>   
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No hay proyectos registrados aun.</td>
                                </tr>  
                            <?php endif; ?>  
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</body>
</html>
