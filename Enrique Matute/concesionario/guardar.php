<?php
// 1. Verificar que llegaron los datos por POST
if (isset($_POST['txtPlaca'])) {

    // 2. Recoger y sanear los datos (trim quita espacios sobrantes)
    $placa = trim($_POST['txtPlaca']);
    $modelo = trim($_POST['txtModelo']);
    $idMarca = $_POST['txtMarca'];
    $anio = $_POST['txtAnio'];
    $precio = $_POST['txtPrecio'];

    // 3. Validación estricta en el backend
    $errores = false;

    // 3.1 Ningún campo puede estar vacío
    if (empty($placa) || empty($modelo) || empty($idMarca) || empty($anio) || empty($precio)) {
        $errores = true;
    }

    // 3.2 Año, marca y precio deben ser numéricos
    if (!is_numeric($idMarca) || !is_numeric($anio) || !is_numeric($precio)) {
        $errores = true;
    }

    // 4. Si hay errores, regresar con alerta
    if ($errores == true) {
        header("Location: index.php?action=listar&msg=error");
        exit;
    }

    // 5. Si todo bien, insertar con consulta preparada
    try {
        $sql = "INSERT INTO vehiculos (placa, modelo, id_marca, anio, precio, estado_activo)
                VALUES (:placa, :modelo, :idMarca, :anio, :precio, 1)";
        $consulta = $conexion->prepare($sql);
        $consulta->bindParam(":placa", $placa);
        $consulta->bindParam(":modelo", $modelo);
        $consulta->bindParam(":idMarca", $idMarca);
        $consulta->bindParam(":anio", $anio);
        $consulta->bindParam(":precio", $precio);
        $consulta->execute();

        // 6. Redirigir con alerta de éxito
        header("Location: index.php?action=listar&msg=creado");
        exit;

    } catch (PDOException $error) {
        // Si la placa está duplicada (UNIQUE), cae aquí
        header("Location: index.php?action=listar&msg=error");
        exit;
    }
}
?>