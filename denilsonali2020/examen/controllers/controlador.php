<?php
require_once '../config/conexion.php';

// 2. Iniciar variables globales que la vista necesita leer

$mensaje = '';
$lista_clientes = [];

// variables de edicion
$modo_edicion = false;
$id_editar_cliente = "";
$nombre_editar_cliente = "";
$correo_editar_cliente = "";
$telefono_editar_cliente = "";
$id_eliminar_cliente = "";

// 3. Procesar el registro listo
if (isset($_POST['btn_registrar_clientes'])) {
    $nombre_empresa = trim($_POST['nombre_empresa']);
    $correo_contacto = trim($_POST['correo_contacto']);
    $telefono = trim($_POST['telefono']);

    if (!empty($nombre_empresa) && !empty($correo_contacto) && !empty($telefono)) {
        try {
            $sql = 'INSERT INTO clientes (nombre_empresa, correo_contacto, telefono) VALUES (:nombre_empresa, :correo_contacto, :telefono)';
            $stmp = $conexion->prepare($sql);
            $stmp->bindParam(':nombre_empresa', $nombre_empresa);
            $stmp->bindParam(':correo_contacto', $correo_contacto);
            $stmp->bindParam(':telefono', $telefono);
            $stmp->execute();

            $mensaje = "<div>Cliente registrado con exito.</div>";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } catch (PDOException $error) {
            $mensaje = "<div>Error al guardar: " . $error->getMessage() . "</div>";
        }
    } else {
        $mensaje = "<div>Hay campos vacios.</div>";
    }
};

// 4.Obtener los clientes
try {
    $sql_leer = 'SELECT * FROM clientes ORDER BY id DESC';
    $stmp_leer = $conexion->prepare($sql_leer);
    $stmp_leer->execute();

    $lista_clientes = $stmp_leer->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    $mensaje .= "<div>Error al listar clientes: " . $error->getMessage() . "</div>";
}



// 5. Edicion
if (isset($_GET['editar_cliente'])) {
    $modo_edicion = true;
    $id_editar_cliente = $_GET['editar_cliente'];

    $sql = 'SELECT * FROM clientes where id = :id';
    $stmp = $conexion->prepare($sql);
    $stmp->bindParam(':id', $id_editar_cliente);
    $stmp->execute();

    $cliente = $stmp->fetch(PDO::FETCH_ASSOC);
    if ($cliente) {
        $nombre_editar_cliente = $cliente['nombre_empresa'];
        $correo_editar_cliente = $cliente['correo_contacto'];
        $telefono_editar_cliente = $cliente['telefono'];
    }
}

// 5. Actualizar
if (isset($_POST['btn_actualizar'])) {
    $id = $_POST['id'];

    $nombre_empresa = trim($_POST['nombre_empresa']);
    $correo_contacto = trim($_POST['correo_contacto']);
    $telefono = trim($_POST['telefono']);

    if (!empty($nombre_empresa) && !empty($correo_contacto) && !empty($telefono)) {
        try {
            $sql = "UPDATE clientes SET nombre_empresa = :nombre_empresa, correo_contacto = :correo_contacto, telefono = :telefono WHERE id = :id";
            $stmp = $conexion->prepare($sql);
            $stmp->bindParam(':nombre_empresa', $nombre_empresa);
            $stmp->bindParam(':correo_contacto', $correo_contacto);
            $stmp->bindParam(':telefono', $telefono);
            $stmp->bindParam(':id', $id);
            $stmp->execute();

            $mensaje = "<div>Cliente actualizado con exito.</div>";
        } catch (PDOException $error) {
            $mensaje = "<div>Error al actualizar: " . $error->getMessage() . "</div>";
        }
    } else {
        $mensaje = "<div>Hay campos vacios.</div>";
    }
};

// boton de limpiar formulario y url y id de edicion
if (isset($_POST['btn_cancelar'])) {
    $id = '';
    $nombre_editar = "";
    $correo_editar = "";
    header("Location: " . $_SERVER['PHP_SELF']);
}


// 6. Eliminar
if (isset($_GET['eliminar_cliente'])) {
    $id_eliminar = $_GET['eliminar_cliente'];

    try {
        $sql = 'DELETE FROM clientes where id = :id';
        $stmp = $conexion->prepare($sql);
        $stmp->bindParam(':id', $id_eliminar);
        $stmp->execute();
    } catch (PDOException $error) {
        $mensaje = "<div>Error al eliminar: " . $error->getMessage() . "</div>";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
}
