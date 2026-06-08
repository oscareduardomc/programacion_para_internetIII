<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Creditos</title>
    <style>
        body{
            font-family: Arial, sans-serif;
            margin: 30px;
        }
        </style>
</head>
<body>
    <?php 
        $montoSolicitado = 25000;
        $ingresosMensuales = 45000;

        // Evaluacion del credito
        if(($ingresosMensuales*10) >= $montoSolicitado){
            $resultado = "APROBADO";
            $color = "green";
        } else {
            $resultado = "RECHAZADO";
            $color = "red";
        }

    ?>

    <h2>Sistema de Aprobacion de Creditos</h2>
    <ul>
    <li>
        <strong>Monto Solicitado:</strong>
        L. <?php echo number_format($montoSolicitado, 2); ?>
    </li>
    <li>
        <strong>Ingresos Mensuales:</strong>
        L. <?php echo number_format($ingresosMensuales, 2); ?>
    </li>
    <hr>
    <li>
        <strong>Resultado:</strong>
        <span style="color: <?php echo $color; ?>;">
            <?php echo $resultado; ?>
        </span>
    </li>
    </ul>
</body>
</html>