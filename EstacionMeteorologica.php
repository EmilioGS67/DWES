<?php

$ciudades = [
    "Santander"       => 21,
    "Torrelavega"     => 24,
    "Reinosa"         => 17,
    "Castro Urdiales" => 22,
    "Potes"           => 28,
    "Laredo"          => 23
];

$totalCiudades = count($ciudades);
$tempTotal = 0;
$ciudadesMasCalidas = 0;

$maxTemp = -INF;
$maxLoc = "";
$minTemp = INF;
$minLoc = "";

foreach ($ciudades as $ciudad => $temp) {
    $tempTotal += $temp;

    if ($temp >= 23) {
        $ciudadesMasCalidas++;
    }

    if ($temp > $maxTemp) {
        $maxTemp = $temp;
        $maxLoc = $ciudad;
    }

    if ($temp < $minTemp) {
        $minTemp = $temp;
        $minLoc = $ciudad;
    }
}

$temperaturaMedia = $tempTotal / $totalCiudades;


$masMediaLoc = [];
$menosMediaLoc = [];

foreach ($ciudades as $ciudad => $temp) {
    if ($temp > $temperaturaMedia) {
        $masMediaLoc[] = "$ciudad ($temp °C)";
    } elseif ($temp < $temperaturaMedia) {
        $menosMediaLoc[] = "$ciudad ($temp °C)";
    }
}

$numMMLoc = count($masMediaLoc);
$numMeMLoc = count($menosMediaLoc);


function clasificarTemperatura($temp) {
    if ($temp < 18) {
        return "Temperatura baja";
    } elseif ($temp >= 18 && $temp < 23) {
        return "Temperatura moderada";
    } elseif ($temp >= 23 && $temp < 27) {
        return "Temperatura alta";
    } else {
        return "Temperatura muy alta";
    }
}

$opcion = isset($_GET['opcion']) ? intval($_GET['opcion']) : 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estación Meteorológica</title>
    <link rel="stylesheet" type="text/css" href="EstacionMeteorologicaCSS.css">
</head>
<body>

    <h1>Estación Meteorológica de Cantabria</h1>

    <p>
        <a href="?opcion=1">1. Mostrar ciudades y temperaturas</a> | 
        <a href="?opcion=2">2. Ciudad con la temperatura más alta</a> | 
        <a href="?opcion=3">3. Ciudad con la temperatura más baja</a> | 
        <a href="?opcion=4">4. Estadísticas generales</a> |
        <a href="?opcion=5">5. Ránking de ciudades</a> | 
        <a href="?opcion=6">6. Salir</a>
    </p>

    <hr>

    <?php if ($opcion === 0): ?>
        <p>Selecciona una opción del menú.</p>

    <?php elseif ($opcion === 1): ?>
        <h3>Listado de ciudades:</h3>
        <ul>
            <?php foreach ($ciudades as $ciudad => $temp): ?>
                <li><?php echo $ciudad; ?>: <?php echo $temp; ?> °C - <?php echo clasificarTemperatura($temp); ?></li>
            <?php endforeach; ?>
        </ul>

    <?php elseif ($opcion === 2): ?>
        <h3>Temperatura Más Alta:</h3>
        <p>La ciudad con la temperatura más alta es <?php echo $maxLoc; ?> con <?php echo $maxTemp; ?> °C (<?php echo clasificarTemperatura($maxTemp); ?>).</p>

    <?php elseif ($opcion === 3): ?>
        <h3>Temperatura Más Baja:</h3>
        <p>La ciudad con la temperatura más baja es <?php echo $minLoc; ?> con <?php echo $minTemp; ?> °C (<?php echo clasificarTemperatura($minTemp); ?>).</p>

    <?php elseif ($opcion === 4): ?>
        <h3>Resumen Estadístico:</h3>
        <p>Número de ciudades registradas: <?php echo $totalCiudades; ?></p>
        <p>Temperatura total acumulada: <?php echo $tempTotal; ?> °C</p>
        <p>Temperatura media: <?php echo round($temperaturaMedia, 2); ?> °C</p>
        <p>Número de ciudades con 23 °C o más: <?php echo $ciudadesMasCalidas; ?></p>
        <p>Ciudad con la temperatura más alta: <?php echo $maxLoc; ?> (<?php echo $maxTemp; ?> °C)</p>
        <p>Ciudad con la temperatura más baja: <?php echo $minLoc; ?> (<?php echo $minTemp; ?> °C)</p>
        

        <p>Comparativa con la Temperatura Media (<?php echo round($temperaturaMedia, 2); ?> °C):</p>
        <p>Localidades por encima de la media (<?php echo $numMMLoc; ?>): <?php echo implode(", ", $masMediaLoc); ?></p>
        <p>Localidades por debajo de la media (<?php echo $numMeMLoc; ?>): <?php echo implode(", ", $menosMediaLoc); ?></p>

    <?php elseif ($opcion === 5): ?>
        <h3>Ránking de ciudades</h3>
        <?php 
            $ciudadesOrdenadas = $ciudades;
            arsort($ciudadesOrdenadas);
            
            $posicion = 1;
        ?>
        <ol>
            <?php foreach ($ciudadesOrdenadas as $ciudad => $temp): ?>
                <li><?php echo $ciudad; ?> - <?php echo $temp; ?> °C</li>
            <?php endforeach; ?>
        </ol>
    
    <?php elseif ($opcion === 6): ?>
        <h3>Aplicación Finalizada</h3>
        <p>El análisis ha terminado. Puede volver al <a href="?opcion=0">Inicio</a>.</p>

    <?php else: ?>
        <p>Opción incorrecta.</p>
    <?php endif; ?>

</body>
</html>
