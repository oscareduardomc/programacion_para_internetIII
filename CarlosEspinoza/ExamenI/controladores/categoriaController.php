<?php
class categoriaController
{
    private $conexion;

    public function __construct($pdo)
    {
        $this->conexion = $pdo;
    }

    public function listar()
    {
        $sql = "SELECT * FROM categorias_respuestos";
        return $this->conexion->query($sql);
    }
}
