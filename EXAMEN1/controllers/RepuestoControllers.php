<?php
require_once '../config/conexion.php';

class RepuestoControllers{


    public static function listar() {
        global $conexion;
        $stmt = $conexion->prepare("SELECT r.id, r.codigo_pieza, r.nombre, r.stock, r.precio, c.nombre_categoria 
FROM repuestos r 
INNER JOIN categorias_repuesto c ON r.id_categoria = c.id 
WHERE r.estado_activo = 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public static function guardar($codigo, $nombre, $id_categoria, $stock,$precio){
 global $conexion;
        $stmt = $conexion->prepare("INSERT INTO repuestos (codigo_pieza, nombre, id_categoria, stock, precio) VALUES (:codigo, :nombre, :id_categoria, :stock, :precio)");
        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':precio', $precio);
        $stmt->execute();

        header("Location: index.php?msg=guardado");
        exit;

    }




    public static function actualizar($id, $codigo, $nombre, $id_categoria, $stock,$precio){
        global $conexion;
        $stmt = $conexion->prepare("UPDATE repuestos SET codigo_pieza = :codigo, nombre = :nombre, id_categoria = :id_categoria, stock = :stock, precio = :precio WHERE id = :id");
        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        header("Location: index.php?msg=actualizado");
        exit;
    }

   public static function obtenerCategorias() {
        global $conexion;
        $stmt = $conexion->prepare("SELECT * FROM categorias_repuesto");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function obtenerPorId($id) {
        global $conexion;
        $stmt = $conexion->prepare("SELECT * FROM repuestos WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function eliminar($id) {
        global $conexion;
        $stmt = $conexion->prepare("DELETE FROM repuestos WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($stmt->execute()){
            header("Location: index.php?mensaje=eliminado");
        }
    }
    public static function desactivar($id) {
        global $conexion;
        $stmt = $conexion->prepare("UPDATE repuestos SET estado_activo = 0 WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        header("Location: index.php?mensaje=desactivado");
    }

}