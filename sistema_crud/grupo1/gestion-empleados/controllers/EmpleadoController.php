<?php
require_once 'config/conexion.php';

class EmpleadoController {
    
    public static function listar() {
       global $conexion;
        $stmt = $conexion->prepare("SELECT * FROM empleados");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function guardar($nombre, $puesto, $salario) {
        global $conexion;
        $stmt = $conexion->prepare("INSERT INTO empleados (nombre, puesto, salario) VALUES (:nombre, :puesto, :salario)");
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':puesto', $puesto, PDO::PARAM_STR);
        $stmt->bindParam(':salario', $salario, PDO::PARAM_STR);
        
       $stmt->execute();
        header("Location: index.php");
        exit;
    }
}

 public static function actualizar($id, $nombre, $puesto, $salario) {
        global $conexion;
        $stmt = $conexion->prepare("UPDATE empleados SET nombre = :nombre, puesto = :puesto, salario = :salario WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':puesto', $puesto, PDO::PARAM_STR);
        $stmt->bindParam(':salario', $salario, PDO::PARAM_STR);
    
        if($stmt->execute()){
            header("Location: index.php?msg=actualizado");
    }
    }

     
     public static function eliminar($id) {
        global $conexion;
        $stmt = $conexion->prepare("DELETE FROM empleados WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
   if($stmt->execute()){
            header("Location: index.php?msg=eliminado");
}
     }

        public static function obtenerPorId($id) {
        global $conexion;
        $stmt = $conexion->prepare("SELECT * FROM empleados WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
             
}
?>
