<?php
require 'conexion.php';

// Cargar categorías dinámicamente para el select
$stmt = $pdo->query("SELECT id, nombre_categoria FROM categorias_repuesto");
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Procesar el formulario si se envía por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = trim($_POST['codigo_pieza'] ?? '');
    $nombre = trim($_POST['nombre'] ?? '');
    $id_categoria = $_POST['id_categoria'] ?? '';
    $stock = $_POST['stock'] ?? '';
    $precio = $_POST['precio'] ?? '';

    // Validación Estricta en el Backend
    if (empty($codigo) || empty($nombre) || empty($id_categoria) || $stock === '' || empty($precio)) {
        $error = "Todos los campos son obligatorios y no deben estar vacíos.";
    } elseif (!is_numeric($stock) || intval($stock) < 0) {
        $error = "El stock debe ser un número entero válido mayor o igual a cero.";
    } elseif (!is_numeric($precio) || floatval($precio) <= 0) {
        $error = "El precio debe ser un número decimal válido mayor a cero.";
    } else {
        // Guardar en la base de datos
        try {
            $stmt = $pdo->prepare("INSERT INTO repuestos (codigo_pieza, nombre, id_categoria, stock, precio) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$codigo, $nombre, $id_categoria, intval($stock), floatval($precio)]);
            header("Location: index.php?msg=Repuesto agregado con éxito");
            exit;
        } catch (PDOException $e) {
            $error = "Error al guardar el registro: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Repuesto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

    <h2>Registrar Nuevo Repuesto</h2>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form action="agregar.php" method="POST" class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Código de la Pieza</label>
            <input type="text" name="codigo_pieza" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Nombre del Repuesto</label>
            <input type="text" name="nombre" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Categoría</label>
            <select name="id_categoria" class="form-select">
                <option value="">-- Seleccione una Categoría --</option>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= $cat['nombre_categoria'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Stock Inicial</label>
            <input type="number" name="stock" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Precio</label>
            <input type="text" name="precio" class="form-control" placeholder="Ej: 45.50">
        </div>
        
        <button type="submit" class="btn btn-success">Guardar Pieza</button>
        <a href="index.php" class="btn btn-secondary">Regresar</a>
    </form>
</body>
</html>
