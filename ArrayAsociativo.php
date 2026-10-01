<?php

// Ejercicio 1

$telefonos = ["Ana" => "600123456","Luis" => "611234567","Marta" => "622345678","Carlos" => "633456789"];

foreach($telefonos as $nombres => $numeros){
    echo $nombres, " => ", $numeros, "<br>";
}

// Ejercicio 2

echo "<br>";

$notas = ["Ana" => 8.5,"Luis" => 4.2,"Marta" => 6.7,"Carlos" => 3.8,"Laura" => 9.1];

$aprobados = 0;
$suspensos = 0;
$notaMedia = 0;

foreach($notas as $nombreAlumnos => $nota){
    echo $nombreAlumnos, " => ", $nota, "<br>";

    if ($nota < 5){
        $suspensos++;
    }

    if ($nota >= 5){
        $aprobados++;
    }

    $notaMedia = $notaMedia + $nota;
}

echo "<br>";

echo "Hay ", count($notas), " alumnos <br>";

echo "<br>";

echo "Hay ", $aprobados, " alumnos aprobados y ", $suspensos, " suspensos <br>"; 

echo "<br>";

echo "La nota media de la case es ", $notaMedia/count($notas), "<br>";

// Ejercicio 3

echo "<br>";

$mayorStock = 0;
$menorStock = 0;
$totalStock = 0;

$auxMa = 0;
$auxMe = 999;

$productos = ["Teclado" => 15,"Ratón" => 7,"Monitor" => 4,"Webcam" => 12,"Auriculares" => 3,"Impresora" => 8];

foreach($productos as $prod => $stock){
    echo $prod, " => ", $stock, "<br>";

    if ($stock < 5){
        echo $prod, " tiene un stock bajo <br>";
    }

    if ($stock > $auxMa){
        $mayorStock = $prod;
        $auxMa = $stock;
    }

    if ($stock < $auxMe){
        $menorStock = $prod;
        $auxMe = $stock;
    }
}

echo "<br>";

echo "Hay ", count($productos), " tipos diferentes de productos <br>";
echo "El stock total es ", $totalStock, " unidades <br>";

echo "<br>";

echo "El artículo con mayor stock es ", $mayorStock, ", con ", $auxMa, " unidades <br>";
echo "El artículo con menor stock es ", $menorStock, ", con ", $auxMe, " unidades <br>";

// Ejercicio 4

echo "<br>";

$ventas = ["Ana" => 3250,"Luis" => 1850,"Marta" => 4720,"Carlos" => 2900,"Laura" => 5100,"Pedro" => 2150];

$mayorVenta = 0;
$menorVenta = 0;
$mediaVentas = 0;
$venMas3k = 0;

$auxMaV = 0;
$auxMeV = 9999;

foreach($ventas as $vendedor => $venta){
    if ($venta < 2000){
        echo"Ventas menores a 2000€ <br>";
        echo $vendedor, " => ", $venta, "€<br>";
        
    }

    if ($venta > 2000 && $venta <= 2999){
        echo"Ventas mayores de 2000€ y menores de 3000 <br>";
        echo $vendedor, " => ", $venta, "€<br>";
    }

    if ($venta >= 3000 && $venta <= 4499){
        echo"Ventas mayores o iguales a 3000€ y menores de 4500 <br>";
        echo $vendedor, " => ", $venta, "€<br>";

        $venMas3k++;
    }

    if ($venta >= 4500){
        echo"Ventas mayores o iguales a 4500 <br>";
        echo $vendedor, " => ", $venta, "€<br>";
    }

    if ($venta > $auxMaV){
        $mayorVenta = $vendedor;
        $auxMaV = $venta;
    }

    if ($venta < $auxMeV){
        $menorVenta = $vendedor;
        $auxMeV = $venta;
    }

    $mediaVentas = $mediaVentas + $venta;
}

echo "<br>";

echo "La nota media de la case es ", $notaMedia/count($notas), "<br>";
echo "Hay un total de ", count($notas), " comerciales <br>";
echo $venMas3k, " vendedor(es) ha(n) tenido ventas superiores a 3000€";

echo"<br>";
echo"<br>";

echo "El vendedor con la mayor venta es ", $mayorVenta, ", con un valor de ", $auxMaV, " € <br>";
echo "El vendedor con la menor venta es ", $menorVenta, ", con un valor de ", $auxMeV, " € <br>";
?>