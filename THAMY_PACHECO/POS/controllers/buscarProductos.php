<?php

require "../config/db.php";


if(isset($_POST['buscar'])){


    $buscar = trim($_POST['buscar']);


    $buscar = "%".$buscar."%";



    $query = "

    SELECT 

        id_producto,
        codigo,
        nombre,
        precio_venta,
        stock

    FROM productos

    WHERE 

        estado = 1

    AND

    (
        nombre LIKE ?

        OR

        codigo LIKE ?

    )

    LIMIT 20

    ";



    $stmt = $conn->prepare($query);



    $stmt->bind_param(

        "ss",

        $buscar,

        $buscar

    );



    $stmt->execute();



    $resultado = $stmt->get_result();



    $productos = [];



    while($producto = $resultado->fetch_assoc()){


        $productos[] = $producto;


    }



    echo json_encode($productos);



}else{


    echo json_encode([]);


}



$conn->close();

?>