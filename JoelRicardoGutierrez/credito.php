<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Credito</title>
    <style>
        body {
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
margin: 30px;       
        }
        .Aprobado {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
        }

        .Rechazado {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
        }
        </style>
</head>
<body>
    <h1>Sistema de aprobación de Creditos corporativos</h1>
    <?php
    $montoSolicitado = 850000;
    $ingresosMensuales = 900;
    
    //calcular
    if ($ingresosMensuales >= 10000) {
        $interesMensual = $montoSolicitado * 0.10;
        $totalPagar = $montoSolicitado + $interesMensual;
        $mensaje="Eres candidato para el préstamo. El total a pagar después de un mes será: L" . number_format($totalPagar, 2) . "</p>";
    $clasescss="Aprobado";
        } 
        else {
        $mensaje="No eres candidato para el préstamo debido a ingresos insuficientes.";
   $clasescss="Rechazado";
        }

     ?>
     <div>
       <div class="<?php echo $clasescss; ?>">
        <p><strong>Estado:</strong> <?php echo $mensaje; ?></p>
    </div>

    <h3>Detalles de la Soliciitud</h3>
    <ul>
        <li>
            <strong>Monto Solicitado:</strong>
            L. <?php echo number_format($montoSolicitado, 2); ?>
        </li>
        <li>
            <strong>Ingresos Mensuales:</strong>
            L. <?php echo number_format($ingresosMensuales, 2); ?>
        </li>
    </ul>

     </div>
</body>
</html>
