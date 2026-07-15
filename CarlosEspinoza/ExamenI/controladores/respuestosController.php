<?php
require_once __DIR__ . '/../config/conexion.php';

class respuestosController
{
    public static function listar()
    {
        global $conexion;
        try {
            $sql = "SELECT r.*, c.nombre_categoria
                    FROM respuestos r
                    INNER JOIN categorias_respuestos c 
                    ON r.id_categoria = c.id
                    WHERE r.estado_activo = 1
                    ORDER BY r.id DESC";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ["error" => "Error al listar: " . $e->getMessage()];
        }
    }

    public static function listarInactivos()
    {
        global $conexion;
        try {
            $sql = "SELECT r.*, c.nombre_categoria
                    FROM respuestos r
                    INNER JOIN categorias_respuestos c ON r.id_categoria = c.id
                    WHERE r.estado_activo = 0
                    ORDER BY r.id DESC";
            $stmt = $conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ["error" => "Error al listar: " . $e->getMessage()];
        }
    }

    public static function guardar($codigo_pieza, $nombre, $id_categoria, $stock, $precio)
    {
        global $conexion;
        $codigo_pieza = trim($codigo_pieza);
        $nombre = trim($nombre);
        $id_categoria = trim($id_categoria);
        $stock = trim($stock);
        $precio = trim($precio);

        if (empty($codigo_pieza) || empty($nombre) || $id_categoria === '' || $stock === '' || $precio === '') {
            header("Location: index.php?action=crear&error=Todos los campos son obligatorios");
            exit();
        }
        if (!is_numeric($id_categoria) || !is_numeric($stock) || !is_numeric($precio)) {
            header("Location: index.php?action=crear&error=Tipo de dato invalido");
            exit();
        }

        try {
            $sql = "INSERT INTO respuestos (codigo_pieza, nombre, id_categoria, stock, precio)
                    VALUES (:codigo_pieza, :nombre, :id_categoria, :stock, :precio)";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':codigo_pieza', $codigo_pieza);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':id_categoria', $id_categoria);
            $stmt->bindParam(':stock', $stock);
            $stmt->bindParam(':precio', $precio);
            $stmt->execute();

            header("Location: index.php?mensaje=Repuesto guardado exitosamente");
            exit();
        } catch (PDOException $e) {
            header("Location: index.php?action=crear&error=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public static function obtenerPorId($id)
    {
        global $conexion;
        try {
            $sql = "SELECT r.*, c.nombre_categoria
                    FROM respuestos r
                    INNER JOIN categorias_respuestos c ON r.id_categoria = c.id
                    WHERE r.id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ["error" => "Error al obtener repuesto: " . $e->getMessage()];
        }
    }

    public static function actualizar($id, $codigo_pieza, $nombre, $id_categoria, $stock, $precio)
    {
        global $conexion;
        $codigo_pieza = trim($codigo_pieza);
        $nombre = trim($nombre);
        $id_categoria = trim($id_categoria);
        $stock = trim($stock);
        $precio = trim($precio);

        if (empty($id) || empty($codigo_pieza) || empty($nombre) || $id_categoria === '' || $stock === '' || $precio === '') {
            header("Location: index.php?action=editar&id=$id&error=Todos los campos son obligatorios");
            exit();
        }
        if (!is_numeric($id_categoria) || !is_numeric($stock) || !is_numeric($precio)) {
            header("Location: index.php?action=editar&id=$id&error=Tipo de dato invalido");
            exit();
        }

        try {
            $sql = "UPDATE respuestos SET codigo_pieza = :codigo_pieza, nombre = :nombre,
                    id_categoria = :id_categoria, stock = :stock, precio = :precio
                    WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':codigo_pieza', $codigo_pieza);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':id_categoria', $id_categoria);
            $stmt->bindParam(':stock', $stock);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            header("Location: index.php?mensaje=Repuesto actualizado exitosamente");
            exit();
        } catch (PDOException $e) {
            header("Location: index.php?action=editar&id=$id&error=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public static function cambiarEstado($id, $estado)
    {
        global $conexion;
        try {
            $sql = "UPDATE respuestos SET estado_activo = :estado WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $texto = ((int)$estado === 1) ? 'Activado' : 'Inactivo';
            header("Location: index.php?mensaje=Repuesto cambiado a $texto");
            exit();
        } catch (PDOException $e) {
            header("Location: index.php?error=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public static function eliminar($id)
    {
        global $conexion;
        try {
            $sql = "SELECT stock FROM respuestos WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $repuesto = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$repuesto) {
                header("Location: index.php?error=Repuesto no encontrado");
                exit();
            }

            if ((int)$repuesto['stock'] > 0) {
                header("Location: index.php?error=No se puede eliminar: el stock debe ser 0");
                exit();
            }

            $sql = "DELETE FROM respuestos WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            header("Location: index.php?mensaje=Repuesto eliminado permanentemente");
            exit();
        } catch (PDOException $e) {
            header("Location: index.php?error=" . urlencode($e->getMessage()));
            exit();
        }
    }
}
