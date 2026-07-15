<?php
require_once "config/conexion.php";

class CategoriaController {

public static function listar(){
        global $conexion;
        $stmt = $conexion->prepare("SELECT * FROM categorias_repuesto ORDER BY nombre_categoria DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function guardar($nombre_categoria, $descripcion){
        global $conexion;
        $stmt = $conexion->prepare("INSERT INTO categorias_repuesto (nombre_categoria, descripcion) VALUES (:nombre, :descripcion)");
        $stmt->bindParam(":nombre", $nombre_categoria);
        $stmt->bindParam(":descripcion", $descripcion);
        if($stmt->execute()){
            header("Location: index.php?msg=guardado");
        }
    }

    public static function obtenerPorId($id){
        global $conexion;
        $stmt = $conexion->prepare("SELECT * FROM categorias_repuesto WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function actualizar($id, $nombre_categoria, $descripcion){
        global $conexion;
        $stmt = $conexion->prepare("UPDATE categorias_repuesto SET nombre_categoria = :nombre_categoria, descripcion = :descripcion WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nombre_categoria", $nombre_categoria);
        $stmt->bindParam(":descripcion", $descripcion);
        if($stmt->execute()){
            header("Location: index.php?msg=actualizado");
        }
    }

    public static function desactivar($id){
        global $conexion;
        $stmt = $conexion->prepare("UPDATE categorias_repuesto SET activo = 0 WHERE id = :id");
        $stmt->bindParam(":id", $id);
        if($stmt->execute()){
            header("Location: index.php?msg=desactivado");
        }
    }

    public static function eliminar($id){
        global $conexion;
        $stmt = $conexion->prepare("DELETE FROM categorias_repuesto WHERE id = :id");
        $stmt->bindParam(":id", $id);
        if($stmt->execute()){
            header("Location: index.php?msg=eliminado");
        }
    }
}
?>
