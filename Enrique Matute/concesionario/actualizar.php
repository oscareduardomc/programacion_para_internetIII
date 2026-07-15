<?php
// 1. Verificar que llegaron los datos por POST
if (isset($_POST['txtId'])) {

    // 2. Recoger y sanear los datos
    $id = $_POST['txtId'];
    $placa = trim($_POST['txtPlaca']);
    $modelo = trim($_POST['txtModelo']);
    $idMarca = $_POST['txtMarca'];
    $anio = $_POST['txtAnio'];
    $precio = $_POST['txtPrecio'];

    // 3. Validación estricta
    $errores = false;

    if (empty($placa) || empty($modelo) || empty($idMarca) || empty($anio) || empty($precio)) {
        $errores = true;
    }

    if (!is_numeric($idMarca) || !is_numeric($anio) || !is_numeric($precio)) {
        $errores = true;
    }

    if ($errores == true) {
        header("Location: index.php?action=listar&msg=error");
        exit;
    }

    // 4. Actualizar con consulta preparada
    try {
        $sql = "UPDATE vehiculos
                SET placa = :placa, modelo = :modelo, id_marca = :idMarca,
                    anio = :anio, precio = :precio
                WHERE id = :id";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(":placa", $placa);
        $consulta->bindParam(":modelo", $modelo);
        $consulta->bindParam(":idMarca", $idMarca);
        $consulta->bindParam(":anio", $anio);
        $consulta->bindParam(":precio", $precio);
        $consulta->bindParam(":id", $id);
        $consulta->execute();

        // 5. Redirigir con alerta de éxito
        header("Location: index.php?action=listar&msg=actualizado");
        exit;

    } catch (PDOException $error) {
        // Si la placa nueva choca con otra (UNIQUE), cae aquí
        header("Location: index.php?action=listar&msg=error");
        exit;
    }
}
?>