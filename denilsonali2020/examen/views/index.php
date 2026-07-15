<?php
require_once __DIR__ . '/../controllers/controlador.php';
require_once __DIR__ . '/../controllers/proyectos.php';
?>




<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="bg-light">

    <!-- INICIO DE CLIENTES -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Clientes</h2>
        <?php echo $mensaje; ?>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm p-4">

                    <?php if ($modo_edicion):  ?>

                        <h4 class="card-tittle text-primary">
                            Editar Cliente
                        </h4>
                    <?php else: ?>
                        <h4 class="card-tittle text-success">
                            Nuevo Cliente
                        </h4>
                    <?php endif ?>

                    <!-- FORMULARIO DE REGISTRAR CLIENTES -->
                    <form action="index.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $id_editar_cliente; ?>">
                        <div class="mb-3">
                            <label for="" class="form-label mt-1">Nombre empresa</label>
                            <input type="text" class="form-control" name="nombre_empresa" autocomplete="off" required value="<?php echo $nombre_editar_cliente ?>">

                            <label for="" class="form-label mt-1">Email</label>
                            <input type="email" class="form-control" name="correo_contacto" autocomplete="off" required value="<?php echo $correo_editar_cliente ?>">

                            <label for="" class="form-label mt-1">Telefono</label>
                            <input type="tel" class="form-control" name="telefono" autocomplete="off" required value="<?php echo $telefono_editar_cliente ?>">

                        </div>

                        <?php if (!$modo_edicion): ?>
                            <button type="submit" class="btn btn-sm btn-primary" name="btn_registrar_clientes">Registra Cliente</button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-sm btn-primary" name="btn_actualizar">Actualizar Cliente</button>
                        <?php endif ?>


                        <?php if ($modo_edicion): ?>
                            <button type="submit" class="btn btn-sm btn-danger">Cancelar</button>
                        <?php endif ?>
                    </form>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm p-4">
                    <h4 class="card-tittle mb-3">
                        Clientes Registrados
                    </h4>

                    <table class="table table-striped table-sm table-hover aling-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>id</th>
                                <th>Nombre Empresa</th>
                                <th>Correo</th>
                                <th>Telefono</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($lista_clientes)): ?>
                                <?php foreach ($lista_clientes as $cliente): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($cliente['id']); ?></td>
                                        <td><?php echo htmlspecialchars($cliente['nombre_empresa']); ?></td>
                                        <td><?php echo htmlspecialchars($cliente['correo_contacto']); ?></td>
                                        <td><?php echo htmlspecialchars($cliente['telefono'] ?? ''); ?></td>
                                        <td>
                                            <a href="index.php?editar_cliente=<?php echo $cliente['id'] ?>" class="btn btn-sm btn-warning text-white">
                                                Editar
                                            </a>
                                            <a href="index.php?eliminar_cliente=<?php echo $cliente['id'] ?>" class="btn btn-sm btn-danger text-white" onclick="return confirm('Desea eliminar este cliente?')">
                                                Eliminar
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No hay clientes registrados.</td>
                                </tr>
                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN DE CLIENTES -->


    <!-- --------------------------------------------------------------------------------- -->
    <!-- --------------------------------------------------------------------------------- -->
    <!-- --------------------------------------------------------------------------------- -->
    <!-- --------------------------------------------------------------------------------- -->


    <!-- INICIO DE PROYECTOS -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Proyectos</h2>
        <?php echo $mensaje; ?>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm p-4">

                    <?php if ($modo_edicion_proyectos):  ?>

                        <h4 class="card-tittle text-primary">
                            Editar Proyecto
                        </h4>
                    <?php else: ?>
                        <h4 class="card-tittle text-success">
                            Nuevo Proyecto
                        </h4>
                    <?php endif ?>

                    <!-- FORMULARIO DE REGISTRAR PROYECTOS -->
                    <form action="index.php" method="post">
                        <input type="hidden" name="id_proyecto" value="<?php echo $id_editar_proyecto; ?>">
                        <div class="mb-3">
                            <label for="" class="form-label mt-1">Titulo</label>
                            <input type="text" class="form-control" name="titulo" autocomplete="off" required value="<?php echo $titulo_editar_proyecto ?>">

                            <label for="" class="form-label mt-1">Descripcion</label>
                            <input type="text" class="form-control" name="descripcion" autocomplete="off" required value="<?php echo $descripcion_editar_proyecto ?>">

                            <label for="" class="form-label mt-1">Cliente</label>
                            <select name="id_cliente" class="control form-control">
                                <option value="">Seleccione un Cliente</option>
                                <?php foreach ($lista_clientes_for_proyects as $cliente):  ?>
                                    <option value="<?php echo $cliente['id']; ?>" <?php echo ($cliente['id'] == $cliente_editar_proyecto) ? 'selected' : '' ?>><?php echo $cliente['nombre_empresa']; ?></option>
                                <?php endforeach; ?>
                            </select>

                            <label for="" class="form-label mt-1">Presupuesto</label>
                            <input type="number" class="form-control" name="presupuesto" autocomplete="off" required value="<?php echo $presupuesto_editar_proyecto ?>">

                            <label for="" class="form-label mt-1">Fecha entrega</label>
                            <input type="date" class="form-control" name="fecha_entrega" autocomplete="off" required
                                value="<?php echo date('Y-m-d', strtotime($fecha_entrega_editar_proyecto)); ?>">

                        </div>

                        <?php if (!$modo_edicion_proyectos): ?>
                            <button type="submit" class="btn btn-sm btn-primary" name="btn_registrar_proyecto">Registra Proyecto</button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-sm btn-primary" name="btn_actualizar_proyecto">Actualizar Proyecto</button>
                        <?php endif ?>


                        <?php if ($modo_edicion_proyectos): ?>
                            <button type="submit" class="btn btn-sm btn-danger">Cancelar</button>
                        <?php endif ?>
                    </form>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm p-4">
                    <h4 class="card-tittle mb-3">
                        Clientes Registrados
                    </h4>

                    <table class="table table-striped table-sm table-hover aling-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>id</th>
                                <th>Titulo</th>
                                <th>Descripcion</th>
                                <th>Cliente</th>
                                <th>Presupuesto</th>
                                <th>Fecha Entrega</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($lista_proyectos)): ?>
                                <?php foreach ($lista_proyectos as $proyecto): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($proyecto['id']); ?></td>
                                        <td><?php echo htmlspecialchars($proyecto['titulo']); ?></td>
                                        <td><?php echo htmlspecialchars($proyecto['descripcion']); ?></td>
                                        <td><?php echo htmlspecialchars($proyecto['nombre_cliente'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($proyecto['presupuesto'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($proyecto['fecha_entrega'] ?? ''); ?></td>
                                        <td>
                                            <?php if ($proyecto['estado_activo']) {
                                                echo "Activo";
                                            } else {
                                                echo "Inactivo";
                                            } ?>
                                        </td>
                                        <td>
                                            <a href="index.php?editar_proyecto=<?php echo $proyecto['id'] ?>" class="btn btn-sm btn-warning text-white">
                                                Editar
                                            </a>
                                            <a href="index.php?eliminar_proyecto=<?php echo $proyecto['id'] ?>" class="btn btn-sm btn-danger text-white" onclick="return confirm('Desea eliminar este proyecto?')">
                                                Eliminar
                                            </a>
                                            <a href="index.php?cambiar_estado=<?php echo $proyecto['id'] ?>&estado=<?php echo $proyecto['estado_activo']; ?>" class="btn btn-sm btn-success text-white"">
                                                Cambiar Estado
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan=" 4" class="text-center text-muted">No hay proyectos registrados.
                                        </td>
                                    </tr>
                                <?php endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN DE CLIENTES -->

</body>

</html>