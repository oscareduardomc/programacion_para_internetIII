<?php
require_once 'config/conexion.php';

class ProyectoController {

    private static function limpiarTexto($valor) {
        return trim(htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8'));
    }

    private static function validarProyecto($post) {
        $errores = [];

        $titulo = self::limpiarTexto($post['titulo'] ?? '');
        $descripcion = self::limpiarTexto($post['descripcion'] ?? '');
        $id_cliente = $post['id_cliente'] ?? '';
        $presupuesto = $post['presupuesto'] ?? '';
        $fecha_entrega = $post['fecha_entrega'] ?? '';
        $estado_proyecto = self::limpiarTexto($post['estado_proyecto'] ?? '');

        $estadosPermitidos = ['En Proceso', 'Pausado', 'Cancelado', 'Finalizado'];
        

        if ($titulo === '' || strlen($titulo) < 3) {
            $errores[] = 'El título es obligatorio.';
        }

        if ($descripcion === '' || strlen($descripcion) < 5) {
            $errores[] = 'La descripción es obligatoria.';
        }

        if (!filter_var($id_cliente, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]])) {
            $errores[] = 'Debe seleccionar un cliente válido.';
        }

        if (!is_numeric($presupuesto) || $presupuesto <= 0) {
            $errores[] = 'El presupuesto debe ser un número mayor que 0.';
        }

        $fechaObj = DateTime::createFromFormat('Y-m-d', $fecha_entrega);
        $hoy = new DateTime('today');
        if (!$fechaObj || $fechaObj->format('Y-m-d') !== $fecha_entrega) {
            $errores[] = 'La fecha de entrega tiene un formato inválido.';
        } elseif ($fechaObj <= $hoy) {
            $errores[] = 'La fecha de entrega debe ser posterior a la fecha actual.';
        }

        if (!in_array($estado_proyecto, $estadosPermitidos, true)) {
            $errores[] = 'El estado del proyecto no es válido.';
        }

        return [
            'errores' => $errores,
            'datos' => [
                'titulo' => $titulo,
                'descripcion' => $descripcion,
                'id_cliente' => (int)$id_cliente,
                'presupuesto' => (float)$presupuesto,
                'fecha_entrega' => $fecha_entrega,
                'estado_proyecto' => $estado_proyecto
            ]
        ];
    }

    public static function listar() {
        global $conexion;
        $sql = "SELECT p.id, p.titulo, p.descripcion, p.presupuesto, p.fecha_entrega, p.estado_proyecto, c.nombre_empresa AS cliente
                FROM proyectos p INNER JOIN clientes c ON p.id_cliente = c.id WHERE p.activo = 1
                AND p.estado_proyecto NOT IN ('Pausado', 'Cancelado') ORDER BY p.fecha_entrega ASC";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function listarInactivos() {
        global $conexion;
        $sql = "SELECT p.id, p.titulo, p.presupuesto, p.fecha_entrega, p.estado_proyecto, p.activo, c.nombre_empresa AS cliente
                FROM proyectos p INNER JOIN clientes c ON p.id_cliente = c.id WHERE p.activo = 0 OR p.estado_proyecto IN ('Pausado', 'Cancelado')
                ORDER BY p.id DESC";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function obtenerPorId($id) {
        global $conexion;
        if (!filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]])) {
            header('Location: index.php?msg=error_id');
            exit;
        }
        $stmt = $conexion->prepare("SELECT * FROM proyectos WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function guardar($post) {
        global $conexion;
        $validacion = self::validarProyecto($post);
        if (!empty($validacion['errores'])) {
            header('Location: index.php?action=crear&msg=error_validacion');
            exit;
        }
        $d = $validacion['datos'];
        $sql = "INSERT INTO proyectos (titulo, descripcion, id_cliente, presupuesto, fecha_entrega, estado_proyecto)
                VALUES (:titulo, :descripcion, :id_cliente, :presupuesto, :fecha_entrega, :estado_proyecto)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(':titulo', $d['titulo'], PDO::PARAM_STR);
        $stmt->bindValue(':descripcion', $d['descripcion'], PDO::PARAM_STR);
        $stmt->bindValue(':id_cliente', $d['id_cliente'], PDO::PARAM_INT);
        $stmt->bindValue(':presupuesto', $d['presupuesto']);
        $stmt->bindValue(':fecha_entrega', $d['fecha_entrega'], PDO::PARAM_STR);
        $stmt->bindValue(':estado_proyecto', $d['estado_proyecto'], PDO::PARAM_STR);
        $stmt->execute();
        header('Location: index.php?msg=guardado');
        exit;
    }

    public static function actualizar($id, $post) {
        global $conexion;
        if (!filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]])) {
            header('Location: index.php?msg=error_id');
            exit;
        }
        $validacion = self::validarProyecto($post);
        if (!empty($validacion['errores'])) {
            header('Location: index.php?action=editar&id=' . (int)$id . '&msg=error_validacion');
            exit;
        }
        $d = $validacion['datos'];
        $sql = "UPDATE proyectos
                SET titulo = :titulo, descripcion = :descripcion, id_cliente = :id_cliente, presupuesto = :presupuesto, fecha_entrega = :fecha_entrega, estado_proyecto = :estado_proyecto
                WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':titulo', $d['titulo'], PDO::PARAM_STR);
        $stmt->bindValue(':descripcion', $d['descripcion'], PDO::PARAM_STR);
        $stmt->bindValue(':id_cliente', $d['id_cliente'], PDO::PARAM_INT);
        $stmt->bindValue(':presupuesto', $d['presupuesto']);
        $stmt->bindValue(':fecha_entrega', $d['fecha_entrega'], PDO::PARAM_STR);
        $stmt->bindValue(':estado_proyecto', $d['estado_proyecto'], PDO::PARAM_STR);
        $stmt->execute();
        header('Location: index.php?msg=actualizado');
        exit;
    }

    public static function softDelete($id) {
        global $conexion;
        if (!filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]])) {
            header('Location: index.php?msg=error_id');
            exit;
        }
        $stmt = $conexion->prepare("UPDATE proyectos SET activo = 0 WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        header('Location: index.php?msg=soft_delete');
        exit;
    }

    public static function hardDelete($id) {
        global $conexion;
        if (!filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]])) {
            header('Location: index.php?action=admin&msg=error_id');
            exit;
        }
        $stmt = $conexion->prepare("DELETE FROM proyectos WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        header('Location: index.php?action=admin&msg=hard_delete');
        exit;
    }
}
?>
