<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Control de Envíos</title>

    <style>
        body{
            font-family:Arial, sans-serif;
            margin:30px;
}
.alerta{
    background-color: #ff4d4d;
    color: #4d0000;
    padding: 15px;
    border-radius: 5px;
}
.autorizado{
    background-color: #28a046;
    color: #4d0000;
    padding: 15px;
    border-radius: 5px;

        

        }
    </style>

</head>
<body>
    <h3>Registro de salidas de camiones</h3>

<form method="POST" action="">

<label>Nombre del conductor</label>
<input type= "text" name="nombre">
<br><br>
<label>Codigo de la maquina</label>
<input type= "text" name="codigo">
<br><br>

<label>Peso de la carga en kilogramos</label>
<input type="number" name="peso">

<button type="submit" name="registrar">Registrar salidas</button>


</form>

<?php
if ($_POST){
    
$nombre = $_POST['nombre'];
$codigo = $_POST['codigo'];
$peso = $_POST['peso'];

if($peso > 5000){
    $mensaje = "Alerta: El camión requiere un pago de impuesto por sobrepeso";
    $claseCSS = "alerta";
}else
 {
    $mensaje = "Tránsito autorizado: Peso dentro del límite legal";
    $claseCSS = "autorizado";
    }




?>

<div class="<?php echo $claseCSS; ?>">
    <p><strong><?php echo $mensaje; ?></strong></p>
</div>

<h2>Resumen del registro  </h2>
<p>Conductor: <?php echo $nombre; ?></p>
<p>Codigo del camion: <?php echo $codigo; ?></p>
<p>Peso de la carga: <?php echo number_format($peso, 0, '', ','); ?> kg</p>

 <?php
}
?>
</body>
</html>
