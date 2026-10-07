EJERCICIOS DE DEPURACIÓN PHP
=============================

Copia cada programa en un archivo .php diferente.
Todos los programas contienen errores.
Corrige los errores hasta conseguir que funcionen correctamente.


------------------------------------------------------------
EJERCICIO 1 - NOTAS
------------------------------------------------------------

<?php

$notas = [
    "Ana" => 8.5,
    "Luis" => 4.2,
    "Marta" => 6.7,
    "Carlos" => 3.8,
    "Laura" => 9.1
];

$aprobados = 0;
$suma = 0;

foreach ($notas as $alumno => $nota) { // => en vez de ,

    if ($nota >= 5) {
        echo $alumno . ": " . $nota . " - APROBADO<br>";
        $aprobados++;
    } else {
        echo $alumno . ": " . $nota . " - SUSPENSO<br>";
    }

    $suma = $nota;
}

$media = $suma / count($notas);

echo "<hr>";
echo "Aprobados: " . $aprobados . "<br>";
echo "Nota media: " . $media;

?>


------------------------------------------------------------
EJERCICIO 2 - INVENTARIO
------------------------------------------------------------

<?php

$productos = [
    "Teclado" => 15,
    "Ratón" => 7,
    "Monitor" => 4,
    "Webcam" => 12,
    "Auriculares" => 3
];

$total = 0;
$productoMayor = "";
$mayorStock = 0;

foreach ($productos as $producto => $stock) {

    echo $producto . ": " . $stock . " unidades<br>";

    $total += $stock;

    if ($stock < 5) {
        echo "STOCK BAJO<br>";
    }

    if ($stock < $mayorStock) {
        $mayorStock = $stock;
        $productoMayor = $producto;
    }
}

echo "<hr>";

echo "Total de unidades: " . $total . "<br>";
echo "Producto con mayor stock: " . $productoMayor . "<br>";
echo "Mayor stock: " . $mayorStock;

?>


------------------------------------------------------------
EJERCICIO 3 - TORNEO
------------------------------------------------------------

<?php

$jugadores = [
    "Ana" => 850,
    "Carlos" => 420,
    "Marta" => 1250,
    "Luis" => 670,
    "Laura" => 980
];

$totalPuntos = 0;
$jugadores500 = 0;
$mayorPuntuacion = 0;
$ganador = "";

echo "<h1>TORNEO DE VIDEOJUEGOS</h1>";

foreach ($jugadores as $nombre => $puntos) {

    if ($puntos < 500) {
        $categoria = "Principiante";
    } elseif ($puntos < 800) {
        $categoria = "Intermedio";
    } elseif ($puntos < 1000) {
        $categoria = "Avanzado";
    } else {
        $categoria = "Experto";
    }

    echo $nombre . ": " . $puntos . " puntos - " . $categoria . "<br>";

    $totalPuntos = $puntos;

    if ($puntos > 500) {
        $jugadores500++;
    }

    if ($puntos > $mayorPuntuacion) {
        $mayorPuntuacion = $puntos;
        $ganador = $nombre;
    }
}

$media = $totalPuntos / count($jugadores);

echo "<hr>";

echo "Número de jugadores: " . count($jugadores) . "<br>";
echo "Jugadores con 500 puntos o más: " . $jugadores500 . "<br>";
echo "Puntuación media: " . $media . "<br>";
echo "Ganador: " . $ganador . "<br>";
echo "Mayor puntuación: " . $mayorPuntuacion . "<br>";

?>


------------------------------------------------------------
EJERCICIO 4 - MENÚ Y ESTADÍSTICAS
------------------------------------------------------------

<?php

$ventas = [
    "Ana" => 3250,
    "Luis" => 1850,
    "Marta" => 4720,
    "Carlos" => 2900,
    "Laura" => 5100
];

$totalVentas = 0;
$mayorVenta = 0;
$comercialMayor = "";
$opcion = 3;

foreach ($ventas as $comercial => $venta) {

    $totalVentas += $venta;

    if ($venta > $mayorVenta) {
        $mayorVenta = $venta;
        $comercialMayor = $comercial;
    }
}

$media = $totalVentas / count($ventas);

echo "<h1>EMPRESA</h1>";

echo "1. Mostrar ventas<br>";
echo "2. Mostrar mayor venta<br>";
echo "3. Estadísticas<br>";
echo "4. Salir<br>";

echo "<hr>";

switch ($opcion) {

    case 1:

        foreach ($ventas as $comercial => $venta) {
            echo $comercial . ": " . $venta . " euros<br>";
        }

        break;

    case 2:

        echo "Mayor venta: " . $comercialMayor . "<br>";
        echo "Cantidad: " . $mayorVenta . " euros";

        break;

    case 3:

        echo "Total vendido: " . $totalVentas . " euros<br>";
        echo "Media: " . $media . " euros<br>";
        echo "Número de comerciales: " . count($ventas) . "<br>";

        break;

    case 4:

        echo "Fin del programa.";

        break;

    default:

        echo "Opción incorrecta.";
}

?>