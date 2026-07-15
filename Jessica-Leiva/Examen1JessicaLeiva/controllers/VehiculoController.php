<?php

require_once 'config/conexion.php';

class VehiculoController
{

    public static function listar($estado = 1)
    {
        global $conexion;

        $stmt = $conexion->prepare("SELECT vehiculos.*, marcas.nombre_marca FROM vehiculos INNER JOIN marcas ON vehiculos.id_marca=marcas.id WHERE vehiculos.estado_activo=:estado ORDER BY vehiculos.id DESC");
        $stmt->bindParam(":estado", $estado);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function marcas()
    {
        global $conexion;

        $stmt = $conexion->prepare("SELECT * FROM marcas WHERE activo=1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function guardar($placa, $modelo, $marca, $fecha_vehiculo, $precio)
    {
        global $conexion;

        $stmt = $conexion->prepare("INSERT INTO vehiculos (placa,modelo,id_marca,fecha_vehiculo,precio) VALUES (:placa,:modelo,:marca,:fecha_vehiculo,:precio)");

        $stmt->bindParam(":placa", $placa);
        $stmt->bindParam(":modelo", $modelo);
        $stmt->bindParam(":marca", $marca);
        $stmt->bindParam(":fecha_vehiculo", $fecha_vehiculo);
        $stmt->bindParam(":precio", $precio);

        try {

            $stmt->execute();

            header("Location:index.php?msg=guardado");
        } catch (PDOException $e) {

            header("Location:index.php?action=crear&msg=placa");
        }
    }


    public static function obtener($id)
    {
        global $conexion;

        $stmt = $conexion->prepare("SELECT * FROM vehiculos WHERE id=:id");

        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public static function actualizar($id, $placa, $modelo, $marca, $fecha_vehiculo, $precio)
    {
        global $conexion;

        $stmt = $conexion->prepare("UPDATE vehiculos SET placa=:placa, modelo=:modelo, id_marca=:marca, fecha_vehiculo =:fecha_vehiculo, precio=:precio WHERE id=:id");

        $stmt->bindParam(":placa", $placa);
        $stmt->bindParam(":modelo", $modelo);
        $stmt->bindParam(":marca", $marca);
        $stmt->bindParam(":fecha_vehiculo", $fecha_vehiculo);
        $stmt->bindParam(":precio", $precio);
        $stmt->bindParam(":id", $id);

        $stmt->execute();
        header("Location:index.php?msg=actualizado");
    }


    public static function vender($id)
    {
        global $conexion;

        $stmt = $conexion->prepare("UPDATE vehiculos SET estado_activo=0 WHERE id=:id");

        $stmt->bindParam(":id", $id);
        $stmt->execute();

        header("Location:index.php?msg=inactivo");
    }


    public static function eliminar($id)
    {
        global $conexion;

        $stmt = $conexion->prepare("DELETE FROM vehiculos WHERE id=:id");

        $stmt->bindParam(":id", $id);
        $stmt->execute();

        header("Location:index.php?estado=0&msg=eliminado");
    }
}
