<?php 
require_once "config/conexion.php";

class RepuestoController {
    
    public static function listar(){
        global $conexion;
        $stmt = $conexion->prepare("SELECT r.*, c.nombre_categoria FROM repuestos r INNER JOIN categorias_repuesto c ON r.id_categoria = c.id WHERE r.estado_activo = 1 ORDER BY r.id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function guardar($codigo_pieza, $nombre, $id_categoria, $stock, $precio){
        global $conexion;
        $stmt = $conexion->prepare("INSERT INTO repuestos (codigo_pieza, nombre, id_categoria, stock, precio) VALUES (:codigo_pieza, :nombre, :id_categoria, :stock, :precio)");
        $stmt->bindParam(":codigo_pieza", $codigo_pieza);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":id_categoria", $id_categoria);
        $stmt->bindParam(":stock", $stock);
        $stmt->bindParam(":precio", $precio);
        if($stmt->execute()){
            header("Location: index.php?msg=guardado");
        }
    }

    public static function obtenerPorId($id){
        global $conexion;
        $stmt = $conexion->prepare("SELECT * FROM repuestos WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function actualizar($id, $codigo_pieza, $nombre, $id_categoria, $stock, $precio){
        global $conexion;
        $stmt = $conexion->prepare("UPDATE repuestos SET codigo_pieza = :codigo_pieza, nombre = :nombre, id_categoria = :id_categoria, stock = :stock, precio = :precio WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":codigo_pieza", $codigo_pieza);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":id_categoria", $id_categoria);
        $stmt->bindParam(":stock", $stock);
        $stmt->bindParam(":precio", $precio);
        if($stmt->execute()){
            header("Location: index.php?msg=actualizado");
        }
    }

    public static function desactivar($id){
        global $conexion;
        $stmt = $conexion->prepare("UPDATE repuestos SET estado_activo = 0 WHERE id = :id");
        $stmt->bindParam(":id", $id);
        if($stmt->execute()){
            header("Location: index.php?msg=desactivado");
        }
    }

    public static function eliminar($id){
        global $conexion;
        $consulta = $conexion->prepare("SELECT stock FROM repuestos WHERE id = :id");
        $consulta->bindParam(":id", $id);
        $consulta->execute();
        $repuesto = $consulta->fetch(PDO::FETCH_ASSOC);
        
        if($repuesto['stock'] == 0){
            $stmt = $conexion->prepare("DELETE FROM repuestos WHERE id = :id");
            $stmt->bindParam(":id", $id);
            if($stmt->execute()){
                header("Location: index.php?msg=eliminado");
            }
        }else{
            header("Location: index.php?msg=stock");
        }
    }
}
?>
