<?php
require_once 'config/conexion.php';

class ClienteController {
    public static function listarActivos() {
        global $conexion;
        $stmt = $conexion->prepare("SELECT * FROM clientes WHERE activo = 1 ORDER BY nombre_empresa ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>
