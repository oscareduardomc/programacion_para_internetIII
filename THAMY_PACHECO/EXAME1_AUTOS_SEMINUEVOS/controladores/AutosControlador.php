<?php
require_once "config/conexion.php";

class AutosControlador {
    
    //ENLISTAREMOS LOS VEHICULOS
    public static function enlistarVehiculos($soloActivos = true) {
        global $conexion;
        $estado = $soloActivos ? 1 : 0;
        $stmt = $conexion->prepare("SELECT v.id AS id, v.placa, v.modelo, v.id_marca, v.anio, v.precio, v.estado_activo,
                                           m.nombre_marca, m.pais_origen 
                                    FROM vehiculos v 
                                    INNER JOIN marcas m ON v.id_marca = m.id 
                                    WHERE v.estado_activo = :estado 
                                    ORDER BY v.id DESC");
        $stmt->bindParam(":estado", $estado, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //ENLISTAREMOS LAS MARCAS
    public static function enlistarMarcas() {
        global $conexion;
        $stmt = $conexion->prepare("SELECT * FROM marcas ORDER BY nombre_marca ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //OBTENDREMOS LA MARCA POR MEDIO DE ID
    public static function obtenerPorIdMarca($id) {
        global $conexion;
        $stmt = $conexion->prepare("SELECT * FROM marcas WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //OBTENDREMOS EL VEHICULO POR MEDIO DE ID
    public static function obtenerPorIdVehiculo($id) {
        global $conexion;
        $stmt = $conexion->prepare("SELECT v.*, m.nombre_marca FROM vehiculos v 
                                    INNER JOIN marcas m ON v.id_marca = m.id 
                                    WHERE v.id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //METODO PARA GUARDAR UNA MARCA
    public static function GUARDAR_MARCA($nombre_marca, $pais_origen) {
        global $conexion;
        $stmt = $conexion->prepare("INSERT INTO marcas (nombre_marca, pais_origen) VALUES (:nombre_marca, :pais_origen)");
        $stmt->bindParam(":nombre_marca", $nombre_marca);
        $stmt->bindParam(":pais_origen", $pais_origen);
        if ($stmt->execute()) {
            header("Location: index.php?msg=Marca guardada con éxito");
        }
    }

    //METODO PARA GUARDAR UN VEHICULO
    public static function GUARDAR_VEHICULO($placa, $modelo, $id_marca, $anio, $precio) {
        global $conexion;
        $stmt = $conexion->prepare("INSERT INTO vehiculos (placa, modelo, id_marca, anio, precio, estado_activo) 
                                    VALUES (:placa, :modelo, :id_marca, :anio, :precio, 1)");
        $stmt->bindParam(":placa", $placa);
        $stmt->bindParam(":modelo", $modelo);
        $stmt->bindParam(":id_marca", $id_marca);
        $stmt->bindParam(":anio", $anio);
        $stmt->bindParam(":precio", $precio);
        if ($stmt->execute()) {
            header("Location: index.php?msg=Vehículo guardado con éxito");
        }
    }

    //METODO PARA ACTUALIZAR LOS DATOS DE UNA MARCA
    public static function ACTUALIZAR_MARCA($id, $nombre_marca, $pais_origen) {
        global $conexion;
        $stmt = $conexion->prepare("UPDATE marcas SET nombre_marca = :nombre_marca, pais_origen = :pais_origen WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nombre_marca", $nombre_marca);
        $stmt->bindParam(":pais_origen", $pais_origen);
        if ($stmt->execute()) {
            header("Location: index.php?msg=Marca actualizada con éxito");
        }
    }

    //METODO PARA ACTUALIZAR LOS DATOS DE UN VEHICULO
    public static function ACTUALIZAR_VEHICULO($id, $placa, $modelo, $id_marca, $anio, $precio) {
        global $conexion;
        $stmt = $conexion->prepare("UPDATE vehiculos SET placa = :placa, modelo = :modelo, id_marca = :id_marca, anio = :anio, precio = :precio WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":placa", $placa);
        $stmt->bindParam(":modelo", $modelo);
        $stmt->bindParam(":id_marca", $id_marca);
        $stmt->bindParam(":anio", $anio);
        $stmt->bindParam(":precio", $precio);
        if ($stmt->execute()) {
            header("Location: index.php?msg=Vehículo actualizado con éxito");
        }
    }

    //METODO PARA ELIMINAR UNA MARCA
    public static function ELIMINAR_MARCA($id) {
        global $conexion;
        $stmt = $conexion->prepare("DELETE FROM marcas WHERE id = :id");
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            header("Location: index.php?msg=Marca eliminada con éxito");
        }
    }

    //METODO PARA DESACTIVAR UN VEHICULO
    public static function DESACTIVAR_VEHICULO($id) {
        global $conexion;
        $stmt = $conexion->prepare("UPDATE vehiculos SET estado_activo = 0 WHERE id = :id");
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            header("Location: index.php?msg=Vehículo marcado como vendido con éxito");
        }
    }

    //METODO PARA REACTIVAR UN VEHICULO
    public static function ACTIVAR_VEHICULO($id) {
        global $conexion;
        $stmt = $conexion->prepare("UPDATE vehiculos SET estado_activo = 1 WHERE id = :id");
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            header("Location: index.php?msg=Vehículo reactivado con éxito");
        }
    }

    //METODO PARA ELIMINAR UN VEHICULO
    public static function ELIMINAR_VEHICULO($id) {
        global $conexion;
        $stmt = $conexion->prepare("DELETE FROM vehiculos WHERE id = :id");
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            header("Location: index.php?msg=Vehículo eliminado con éxito");
        }
    }
}
?>