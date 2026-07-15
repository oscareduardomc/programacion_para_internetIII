<?php 
    require_once('./config/conexion.php');

class EmpleadosController{
    
    public static function listar(){
        global $conexion;
        $stmt = $conexion->prepare("SELECT * FROM empleados ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public static function GuardarEmpleados($nombre, $puesto, $salario, $fecha_ingreso){
        global $conexion;
        $stmt = $conexion->prepare("INSERT INTO empleados (nombre, puesto, salario, fecha_ingreso ) VALUES (:nombre, :puesto, :salario, :fecha_ingreso)");
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":puesto", $puesto);
        $stmt->bindParam(":salario", $salario);
        $stmt->bindParam(":fecha_ingreso", $fecha_ingreso);

        if($stmt->execute()){
            header("Location: index.php?msg=guardado");

        }
    }

    public static function ObtenerPorId($id){
        global $conexion;
        $stmt = $conexion->prepare("SELECT * FROM empleados WHERE id= :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function EditarEmpleado($id, $nombre, $puesto, $salario, $fecha_ingreso){
        global $conexion;
        $stmt = $conexion->prepare("UPDATE empleados  SET nombre = :nombre, puesto = :puesto, salario = :salario, fecha_ingreso = :fecha_ingreso WHERE id= :id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":puesto", $puesto);
        $stmt->bindParam(":salario", $salario);
        $stmt->bindParam(":fecha_ingreso", $fecha_ingreso);

        if($stmt->execute()){
            header("Location: index.php?msg=actualizado");

        }

    }

    public static function EliminarEmpleado($id){
        global $conexion;
        $stmt = $conexion->prepare("DELETE FROM empleados WHERE id = :id");
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()){
            header("Location: index.php?msg=eliminado");
        }
       

    }







}

    

?>