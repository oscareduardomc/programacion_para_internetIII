<?php
    require_once __DIR__ . '/../config/conexion.php';

class ProyectosController {

    // Lista proyectos activos con INNER JOIN para mostrar nombre del cliente
    public static function listar() {
        global $conexion;
        $stmt = $conexion->prepare(
            "SELECT p.*, c.nombre
             FROM proyectos p
             INNER JOIN clientes c ON p.id_cliente = c.id
             WHERE p.activo = 1
             ORDER BY p.id DESC"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lista proyectos inactivos (papelera)
    public static function listarInactivos() {
        global $conexion;
        $stmt = $conexion->prepare(
            "SELECT p.*, c.nombre
             FROM proyectos p
             INNER JOIN clientes c ON p.id_cliente = c.id
             WHERE p.activo = 0
             ORDER BY p.id DESC"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener todos los clientes para el <select>
    public static function listarClientes() {
        global $conexion;
        $stmt = $conexion->prepare("SELECT id, nombre FROM clientes ORDER BY nombre ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Guardar nuevo proyecto con validaciones
    public static function guardar($titulo, $descripcion, $id_cliente, $presupuesto, $fecha_entrega) {
        global $conexion;

        // Validaciones backend
        if (empty(trim($titulo)) || empty(trim($descripcion)) || empty(trim($fecha_entrega))) {
            header("Location: index.php?action=crear&msg=error_vacios");
            exit;
        }
        if (!filter_var($presupuesto, FILTER_VALIDATE_FLOAT) || $presupuesto <= 0) {
            header("Location: index.php?action=crear&msg=error_presupuesto");
            exit;
        }
        if (!filter_var($id_cliente, FILTER_VALIDATE_INT) || $id_cliente <= 0) {
            header("Location: index.php?action=crear&msg=error_cliente");
            exit;
        }
        // Validar que fecha_entrega sea posterior a hoy
        if (strtotime($fecha_entrega) <= strtotime(date('Y-m-d'))) {
            header("Location: index.php?action=crear&msg=error_fecha");
            exit;
        }

        $stmt = $conexion->prepare(
            "INSERT INTO proyectos (titulo, descripcion, id_cliente, presupuesto, fecha_entrega)
             VALUES (:titulo, :descripcion, :id_cliente, :presupuesto, :fecha_entrega)"
        );
        $stmt->bindParam(':titulo',        $titulo);
        $stmt->bindParam(':descripcion',   $descripcion);
        $stmt->bindParam(':id_cliente',    $id_cliente, PDO::PARAM_INT);
        $stmt->bindParam(':presupuesto',   $presupuesto);
        $stmt->bindParam(':fecha_entrega', $fecha_entrega);

        if ($stmt->execute()) {
            header("Location: index.php?msg=guardado");
            exit;
        }
    }

    // Obtener un proyecto por ID
    public static function obtenerPorId($id) {
        global $conexion;
        $stmt = $conexion->prepare("SELECT * FROM proyectos WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Editar proyecto con validaciones
    public static function editar($id, $titulo, $descripcion, $id_cliente, $presupuesto, $fecha_entrega) {
        global $conexion;

        if (empty(trim($titulo)) || empty(trim($descripcion)) || empty(trim($fecha_entrega))) {
            header("Location: index.php?action=editar&id=$id&msg=error_vacios");
            exit;
        }
        if (!filter_var($presupuesto, FILTER_VALIDATE_FLOAT) || $presupuesto <= 0) {
            header("Location: index.php?action=editar&id=$id&msg=error_presupuesto");
            exit;
        }
        if (!filter_var($id_cliente, FILTER_VALIDATE_INT) || $id_cliente <= 0) {
            header("Location: index.php?action=editar&id=$id&msg=error_cliente");
            exit;
        }
        if (strtotime($fecha_entrega) <= strtotime(date('Y-m-d'))) {
            header("Location: index.php?action=editar&id=$id&msg=error_fecha");
            exit;
        }

        $stmt = $conexion->prepare(
            "UPDATE proyectos
             SET titulo = :titulo, descripcion = :descripcion, id_cliente = :id_cliente,
                 presupuesto = :presupuesto, fecha_entrega = :fecha_entrega
             WHERE id = :id"
        );
        $stmt->bindParam(':id',           $id,           PDO::PARAM_INT);
        $stmt->bindParam(':titulo',       $titulo);
        $stmt->bindParam(':descripcion',  $descripcion);
        $stmt->bindParam(':id_cliente',   $id_cliente,   PDO::PARAM_INT);
        $stmt->bindParam(':presupuesto',  $presupuesto);
        $stmt->bindParam(':fecha_entrega',$fecha_entrega);

        if ($stmt->execute()) {
            header("Location: index.php?msg=actualizado");
            exit;
        }
    }

    // Soft Delete: cambia activo = 0
    public static function desactivar($id) {
        global $conexion;
        $stmt = $conexion->prepare("UPDATE proyectos SET activo = 0 WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            header("Location: index.php?msg=pausado");
            exit;
        }
    }

    // Hard Delete: elimina el registro completamente
    public static function eliminar($id) {
        global $conexion;
        $stmt = $conexion->prepare("DELETE FROM proyectos WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            header("Location: index.php?action=papelera&msg=eliminado");
            exit;
        }
    }
}
?>
