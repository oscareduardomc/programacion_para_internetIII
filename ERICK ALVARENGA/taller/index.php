<?php
require 'conexion.php';

// Borrado lógico(Soft Delete) 
if (isset($_GET['soft_delete'])) {
    $id = $_GET['soft_delete'];
    $stmt = $pdo->prepare("UPDATE repuestos SET estado_activos = 0 WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php?msg=Repuesto inactivado correctamente");
    exit;
}

// Borrado físico (Hard Delete) 
if (isset($_GET['hard_delete'])) {
    $id = $_GET['hard_delete'];
    
    // Validar primero si el stock está en 0
    $stmt = $pdo->prepare("SELECT stock FROM repuestos WHERE id = ?");
    $stmt->execute([$id]);
    $repuesto = $stmt->fetch();
    
    if ($repuesto && $repuesto['stock'] == 0) {
        $stmt = $pdo->prepare("DELETE FROM repuestos WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: index.php?msg=Repuesto eliminado físicamente");
    } else {
        header("Location: index.php?error=No se puede eliminar físicamente: El stock no es 0");
    }
    exit;
}

// Consulta principal (Solo activos)
$query = "SELECT r.*, c.nombre_categoria 
          FROM repuestos r 
          INNER JOIN categorias_repuesto c ON r.id_categoria = c.id 
          WHERE r.estado_activos = 1";
$stmt = $pdo->query($query);
$repuestos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario de Repuestos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

    <h2>Lista de Piezas y Repuestos</h2>
    
    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['msg']) ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <a href="agregar.php" class="btn btn-primary mb-3">Registrar Nueva Pieza</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Stock</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($repuestos as $r): ?>
                <?php 
                    // Reto específico - si el stock es menor a 5, pintar de table-warning
                    $claseFila = ($r['stock'] < 5) ? 'table-warning' : ''; 
                ?>
                <tr class="<?= $claseFila ?>">
                    <td><?= $r['codigo_pieza'] ?></td>
                    <td><?= $r['nombre'] ?></td>
                    <td><?= $r['nombre_categoria'] ?></td>
                    <td><?= $r['stock'] ?></td>
                    <td>$<?= number_format($r['precio'], 2) ?></td>
                    <td>
                        <a href="index.php?soft_delete=<?= $r['id'] ?>" class="btn btn-sm btn-secondary">Inactivar</a>
                        <a href="index.php?hard_delete=<?= $r['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar permanentemente?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
