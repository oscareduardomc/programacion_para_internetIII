<?php
require_once "config/conexion.php";

class EmpleadoController {
    public static function listar(){
        global $conexion;
        $stmt = $conexion->prepare("SELECT * FROM empleados ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
      public static function guardar($nombre, $puesto, $salario){
        global $conexion;
        $stmt = $conexion->prepare("INSERT INTO empleados (nombre, puesto, salario) VALUES (:nombre, :puesto, :salario)");
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":puesto", $puesto);
        $stmt->bindParam(":salario", $salario);
        if($stmt->execute()){
            header("Location: index.php?msg=guardado");
        }
    }

}

?>
