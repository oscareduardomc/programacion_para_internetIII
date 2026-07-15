<?php

require_once __DIR__ . '/../config/conexion.php';

class EmpleadoController
{

    public static function textoEstado($activo)
    {
        switch ((int)$activo) {
            case 0: return 'Inactivo';
            case 1: return 'Activo';
            case 2: return 'Despedido';
            default: return 'Desconocido';
        }
    }

    public static function listar($filtro_estado = null)
    {
        global $conexion;
        try {
            if ($filtro_estado !== null) {
                $sql = 'SELECT * FROM empleados WHERE activo = :estado ORDER BY id DESC';
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':estado', $filtro_estado);
            } else {
                $sql = 'SELECT * FROM empleados ORDER BY id DESC';
                $stmt = $conexion->prepare($sql);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            return ["error" => "Error al listar empleados: " . $error->getMessage()];
        }
    }


    public static function guardar($nombre, $puesto, $salario)
    {
        global $conexion;
        $nombre = trim($nombre);
        $puesto = trim($puesto);
        $salario = trim($salario);

        if (empty($nombre) || empty($puesto) || empty($salario)) {
            return "<div>Hay campos vacíos.</div>";
        }

        try {
            $sql = 'INSERT INTO empleados (nombre, puesto ,salario) VALUES (:nombre, :puesto, :salario)';
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':puesto', $puesto);
            $stmt->bindParam(':salario', $salario);
            $stmt->execute();

            header("Location: index.php?mensaje=Empleado guardado exitosamente");
            exit();
        } catch (PDOException $error) {
            return "<div>Error al guardar: " . $error->getMessage() . "</div>";
        }
    }



    public static function obtenerPorId($id)
    {
        global $conexion;
        try {
            $sql = 'SELECT * FROM empleados WHERE id = :id';
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            return "<div>Error al obtener empleado: " . $error->getMessage() . "</div>";
        }
    }


    public static function actualizar($id, $nombre, $puesto, $salario, $activo = null)
    {
        global $conexion;
        $nombre = trim($nombre);
        $puesto = trim($puesto);
        $salario = trim($salario);

        if (empty($id) || empty($nombre) || empty($puesto) || empty($salario)) {
            return "<div>Hay campos vacíos.</div>";
        }

        try {
            if ($activo !== null) {
                $sql = "UPDATE empleados SET nombre = :nombre, puesto = :puesto, salario = :salario, activo = :activo WHERE id = :id";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':activo', $activo);
            } else {
                $sql = "UPDATE empleados SET nombre = :nombre, puesto = :puesto, salario = :salario WHERE id = :id";
                $stmt = $conexion->prepare($sql);
            }
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':puesto', $puesto);
            $stmt->bindParam(':salario', $salario);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            header("Location: index.php?mensaje=Empleado actualizado exitosamente");
            exit();
        } catch (PDOException $error) {
            return "<div>Error al actualizar: " . $error->getMessage() . "</div>";
        }
    }


    public static function cambiarEstado($id, $estado)
    {
        global $conexion;
        try {
            $sql = 'UPDATE empleados SET activo = :estado WHERE id = :id';
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $texto = self::textoEstado($estado);
            header("Location: index.php?mensaje=Empleado cambiado a $texto");
            exit();
        } catch (PDOException $error) {
            return "<div>Error al cambiar estado: " . $error->getMessage() . "</div>";
        }
    }

    public static function eliminar($id)
    {
        global $conexion;
        try {
            $sql = 'DELETE FROM empleados WHERE id = :id';
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $error) {
            return "<div>Error al eliminar: " . $error->getMessage() . "</div>";
        }

        header("Location: index.php?mensaje=Empleado eliminado exitosamente");
        exit();
    }
}
