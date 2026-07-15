<!DOCTYPE html>
<html>
<head>
    <title>Agregar Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h2 class="text-center">Nuevo Cliente</h2>

    <form action="guardar.php" method="POST" class="card p-4 shadow mt-4">

        <input type="text" name="nombre_empresa" class="form-control mb-3" placeholder="Nombre empresa" required>

        <input type="email" name="correo_contacto" class="form-control mb-3" placeholder="Correo" required>

        <input type="text" name="telefono" class="form-control mb-3" placeholder="Teléfono">

        <button class="btn btn-success">Guardar</button>
        <a href="index.php" class="btn btn-secondary">Volver</a>

    </form>

</div>

</body>
</html>