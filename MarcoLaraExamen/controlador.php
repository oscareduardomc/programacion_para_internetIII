<?php
require_once 'conexion.php';

$mensaje = "";
$lista_proyectos = [];

if (isset($_POST['btn_registrar'])) {
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $id_cliente = trim($_POST['id_cliente']);
    $presupuesto = trim($_POST['presupuesto']);
    $fecha_entrega = trim($_POST['fecha_entrega']);

    $fecha_actual = date('Y-m-d');

    if (empty($titulo) || empty($descripcion) || empty($id_cliente) || empty($presupuesto) || empty($fecha_entrega)) {
        header("Location: index.php?error=Por favor llene todos los campos");
        exit();
    } else {
        if ($fecha_entrega <= $fecha_actual) {
            header("Location: index.php?error=La fecha debe ser futura");
            exit();
        } else {
            try {
                $sql = "INSERT INTO proyectos (titulo, descripcion, id_cliente, presupuesto, fecha_entrega) VALUES (:titulo, :descripcion, :id_cliente, :presupuesto, :fecha_entrega)";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':titulo', $titulo);
                $stmt->bindParam(':descripcion', $descripcion);
                $stmt->bindParam(':id_cliente', $id_cliente);
                $stmt->bindParam(':presupuesto', $presupuesto);
                $stmt->bindParam(':fecha_entrega', $fecha_entrega);
                $stmt->execute();

                header("Location: index.php?mensaje=Proyecto guardado con exito");
                exit();
            } catch (PDOException $e) {
                header("Location: index.php?error=" . $e->getMessage());
                exit();
            }
        }
    }
}

if (isset($_GET['accion']) && isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_GET['accion'] == 'logico') {
        try {
            $sql = "UPDATE proyectos SET estado_activo = 0 WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            header("Location: index.php?mensaje=Proyecto pausado con exito");
            exit();
        } catch (PDOException $e) {
            header("Location: index.php?error=" . $e->getMessage());
            exit();
        }
    }

    if ($_GET['accion'] == 'fisico') {
        try {
            $sql = "DELETE FROM proyectos WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            header("Location: index.php?mensaje=Proyecto eliminado de la base de datos");
            exit();
        } catch (PDOException $e) {
            header("Location: index.php?error=" . $e->getMessage());
            exit();
        }
    }
}

try {
    $sql_leer = "SELECT proyectos.*, clientes.nombre_empresa FROM proyectos INNER JOIN clientes ON proyectos.id_cliente = clientes.id WHERE proyectos.estado_activo = 1 ORDER BY proyectos.id DESC";
    $stmt_leer = $conexion->prepare($sql_leer);
    $stmt_leer->execute();
    $lista_proyectos = $stmt_leer->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    header("Location: index.php?error=" . $e->getMessage());
    exit();
}
?>
<?php
require_once 'conexion.php';

$mensaje = "";
$lista_proyectos = [];

if (isset($_POST['btn_registrar'])) {
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $id_cliente = trim($_POST['id_cliente']);
    $presupuesto = trim($_POST['presupuesto']);
    $fecha_entrega = trim($_POST['fecha_entrega']);

    $fecha_actual = date('Y-m-d');

    if (empty($titulo) || empty($descripcion) || empty($id_cliente) || empty($presupuesto) || empty($fecha_entrega)) {
        header("Location: index.php?error=Por favor llene todos los campos");
        exit();
    } else {
        if ($fecha_entrega <= $fecha_actual) {
            header("Location: index.php?error=La fecha debe ser futura");
            exit();
        } else {
            try {
                $sql = "INSERT INTO proyectos (titulo, descripcion, id_cliente, presupuesto, fecha_entrega) VALUES (:titulo, :descripcion, :id_cliente, :presupuesto, :fecha_entrega)";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':titulo', $titulo);
                $stmt->bindParam(':descripcion', $descripcion);
                $stmt->bindParam(':id_cliente', $id_cliente);
                $stmt->bindParam(':presupuesto', $presupuesto);
                $stmt->bindParam(':fecha_entrega', $fecha_entrega);
                $stmt->execute();

                header("Location: index.php?mensaje=Proyecto guardado con exito");
                exit();
            } catch (PDOException $e) {
                header("Location: index.php?error=" . $e->getMessage());
                exit();
            }
        }
    }
}

if (isset($_GET['accion']) && isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_GET['accion'] == 'logico') {
        try {
            $sql = "UPDATE proyectos SET estado_activo = 0 WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            header("Location: index.php?mensaje=Proyecto pausado con exito");
            exit();
        } catch (PDOException $e) {
            header("Location: index.php?error=" . $e->getMessage());
            exit();
        }
    }

    if ($_GET['accion'] == 'fisico') {
        try {
            $sql = "DELETE FROM proyectos WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            header("Location: index.php?mensaje=Proyecto eliminado de la base de datos");
            exit();
        } catch (PDOException $e) {
            header("Location: index.php?error=" . $e->getMessage());
            exit();
        }
    }
}

try {
    $sql_leer = "SELECT proyectos.*, clientes.nombre_empresa FROM proyectos INNER JOIN clientes ON proyectos.id_cliente = clientes.id WHERE proyectos.estado_activo = 1 ORDER BY proyectos.id DESC";
    $stmt_leer = $conexion->prepare($sql_leer);
    $stmt_leer->execute();
    $lista_proyectos = $stmt_leer->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    header("Location: index.php?error=" . $e->getMessage());
    exit();
}
?>
