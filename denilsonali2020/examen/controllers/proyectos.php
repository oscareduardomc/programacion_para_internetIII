<?php
require_once '../config/conexion.php';

// 2. Iniciar variables globales que la vista necesita leer
$lista_clientes_for_proyects = [];
$mensaje = '';
$lista_proyectos = [];

// variables de edicion
$modo_edicion_proyectos = false;
$id_editar_proyecto = "";
$id_eliminar = "";
$titulo_editar_proyecto = "";
$descripcion_editar_proyecto = "";
$cliente_editar_proyecto = "";
$presupuesto_editar_proyecto = "";
$fecha_entrega_editar_proyecto = "";



// 3. Procesar el registro
if (isset($_POST['btn_registrar_proyecto'])) {

    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $id_cliente = trim($_POST['id_cliente']);
    $presupuesto = trim($_POST['presupuesto']);
    $fecha_entrega = trim($_POST['fecha_entrega']);
    $estado_activo = true;


    $fecha_elegida = new DateTime($fecha_entrega);
    $fecha_hoy = new DateTime();

    if ($fecha_elegida > $fecha_hoy) {
        if (!empty($titulo) && !empty($descripcion) && !empty($id_cliente) && !empty($presupuesto) && !empty($fecha_entrega)) {
            try {
                $sql = 'INSERT INTO proyectos (titulo, descripcion , id_cliente , presupuesto , fecha_entrega , estado_activo) VALUES (:titulo, :descripcion , :id_cliente , :presupuesto , :fecha_entrega , :estado_activo)';
                $stmp = $conexion->prepare($sql);
                $stmp->bindParam(':titulo', $titulo);
                $stmp->bindParam(':descripcion', $descripcion);
                $stmp->bindParam(':id_cliente', $id_cliente);
                $stmp->bindParam(':presupuesto', $presupuesto);
                $stmp->bindParam(':fecha_entrega', $fecha_entrega);
                $stmp->bindParam(':estado_activo', $estado_activo);
                $stmp->execute();

                $mensaje = "<div>Proyecto registrado con exito.</div>";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } catch (PDOException $error) {
                $mensaje = "<div>Error al guardar: " . $error->getMessage() . "</div>";
            }
        } else {
            $mensaje = "<div>Hay campos vacios.</div>";
        }
    } else {
        $mensaje = "Fecha invalida";
    }
};

// 4.Obtener los proyectos
try {
    $sql_leer = 'SELECT proyectos.*, clientes.nombre_empresa as nombre_cliente from proyectos INNER JOIN clientes on proyectos.id_cliente = clientes.id where estado_activo = true ORDER BY proyectos.id DESC';
    $stmp_leer = $conexion->prepare($sql_leer);
    $stmp_leer->execute();

    $lista_proyectos = $stmp_leer->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    $mensaje .= "<div>Error al listar proyectos: " . $error->getMessage() . "</div>";
}



// 5. Edicion
if (isset($_GET['editar_proyecto'])) {
    $modo_edicion_proyectos = true;
    $id_editar_proyecto = $_GET['editar_proyecto'];

    $sql = 'SELECT * FROM proyectos where id = :id';
    $stmp = $conexion->prepare($sql);
    $stmp->bindParam(':id', $id_editar_proyecto);
    $stmp->execute();

    $proyecto = $stmp->fetch(PDO::FETCH_ASSOC);
    if ($proyecto) {
        $titulo_editar_proyecto = $proyecto['titulo'];
        $descripcion_editar_proyecto = $proyecto['descripcion'];
        $cliente_editar_proyecto = $proyecto['id_cliente'];
        $presupuesto_editar_proyecto = $proyecto['presupuesto'];
        $fecha_entrega_editar_proyecto = $proyecto['fecha_entrega'];
    }
}

// 5. Actualizar
if (isset($_POST['btn_actualizar_proyecto'])) {
    $id = $_POST['id_proyecto'];

    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $id_cliente = trim($_POST['id_cliente']);
    $presupuesto = trim($_POST['presupuesto']);
    $fecha_entrega = trim($_POST['fecha_entrega']);

    if (!empty($titulo) && !empty($descripcion) && !empty($id_cliente) && !empty($presupuesto) && !empty($fecha_entrega)) {
        try {
            $sql = "UPDATE proyectos SET titulo = :titulo, descripcion = :descripcion, id_cliente = :id_cliente, presupuesto = :presupuesto, fecha_entrega = :fecha_entrega WHERE id = :id";
            $stmp = $conexion->prepare($sql);
            $stmp->bindParam(':titulo', $titulo);
            $stmp->bindParam(':descripcion', $descripcion);
            $stmp->bindParam(':id_cliente', $id_cliente);
            $stmp->bindParam(':presupuesto', $presupuesto);
            $stmp->bindParam(':fecha_entrega', $fecha_entrega);
            $stmp->bindParam(':id', $id);
            $stmp->execute();

            $mensaje = "<div>Proyecto actualizado con exito.</div>";
        } catch (PDOException $error) {
            $mensaje = "<div>Error al actualizar: " . $error->getMessage() . "</div>";
        }
    } else {
        $mensaje = "<div>Hay campos vacios.</div>";
    }
};

// boton de limpiar formulario y url y id de edicion
if (isset($_POST['btn_cancelar'])) {
    $id_editar_proyecto = "";
    $id_eliminar = "";
    $titulo_editar_proyecto = "";
    $descripcion_editar_proyecto = "";
    $cliente_editar_proyecto = "";
    $presupuesto_editar_proyecto = "";
    $fecha_entrega_editar_proyecto = "";
    header("Location: " . $_SERVER['PHP_SELF']);
}


// 6. Eliminar
if (isset($_GET['eliminar_proyecto'])) {
    $id_eliminar = $_GET['eliminar_proyecto'];

    try {
        $sql = 'DELETE FROM proyectos where id = :id';
        $stmp = $conexion->prepare($sql);
        $stmp->bindParam(':id', $id_eliminar);
        $stmp->execute();
    } catch (PDOException $error) {
        $mensaje = "<div>Error al eliminar: " . $error->getMessage() . "</div>";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
}


// 7. Obtener los clientes
try {
    $sql_leer = 'SELECT * FROM clientes ORDER BY id DESC';
    $stmp_leer = $conexion->prepare($sql_leer);
    $stmp_leer->execute();

    $lista_clientes_for_proyects = $stmp_leer->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    $mensaje .= "<div>Error al listar clientes: " . $error->getMessage() . "</div>";
}

// 8. Cambiar de estado 
if (isset($_GET['cambiar_estado'])) {
    $id = $_GET['cambiar_estado'];
    $estado = $_GET['estado'];

    if ($estado == 1) {
        $estado = 0;
    } else if ($estado == 0) {
        $estado = 1;
    }

    try {
        $sql = 'UPDATE proyectos set estado_activo = :estado  where id = :id';
        $stmp = $conexion->prepare($sql);
        $stmp->bindParam(':id', $id);
        $stmp->bindParam(':estado', $estado);
        $stmp->execute();
    } catch (PDOException $error) {
        $mensaje = "<div>Error al cambiar estado: " . $error->getMessage() . "</div>";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
}
