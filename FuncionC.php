<?php
function propina($cuenta, $propina = 0.10)
{
    return $cuenta + $cuenta * $propina;
}
function menu($primero, $segundo, $postre = "flan")
{
    return $primero . ", " . $segundo . " y " . $postre . "<br>";
}
function calcularMinMax($a, $b, $c, &$min, &$max)
{
    $min = min($a, $b, $c);
    $max = max($a, $b, $c);
}
// La ventaja consiste en tener menos variables que calcular, con la inconveniencia de requerir 
// más percepción de las restantes
function calcularMinMaxV2($a, $b, $c)
{
    $minYMax = [];
    $minYMax[0] = min($a, $b, $c);
    $minYMax[1] = max($a, $b, $c);
    return $minYMax;
}
function ocuparMesa(&$mesas)
{
    $mesas += 1;
}
function precioBebida($precio)
{
    global $descuentoBebida;
    return $precio - ($precio * $descuentoBebida);
}
// ===== RESTAURANTE "EL FUNCIONARIO" =====
// --- Cuenta con propina (por defecto, 10%) ---
$cuenta1 = 40;
echo "Mesa 1: " . propina($cuenta1) . " €<br>";
$cuenta2 = 85;
echo "Mesa 2: " . propina($cuenta2) . " €<br>";
$cuenta3 = 120;
echo "Mesa 3 (servicio especial): " . propina($cuenta3, 0.15) . " €<br>";
echo "<hr>";
// --- Menú del día (el postre por defecto es flan) ---
echo "Menú: " . menu("sopa", "pollo");
echo "Menú: " . menu("ensalada", "merluza");
echo "Menú: " . menu("lentejas", "ternera", "helado");
echo "<hr>";
// --- Ventas: mínimo y máximo de tres días ---
$lunes = 300;
$martes = 450;
$miercoles = 280;
calcularMinMax($lunes, $martes, $miercoles, $min1, $max1);
echo "Semana 1 - Mínimo: " . $min1 . " - Máximo: " . $max1 . "<br>";
$jueves = 500;
$viernes = 320;
$sabado = 610;
calcularMinMax($jueves, $viernes, $sabado, $min2, $max2);
echo "Semana 2 - Mínimo: " . $min2 . " - Máximo: " . $max2 . "<br>";
echo "<hr>";
// --- Ventas: mínimo y máximo de tres días V2 ---
$lunes = 300;
$martes = 450;
$miercoles = 280;
echo "Semana 1 - Mínimo: " . calcularMinMaxV2($lunes, $martes, $miercoles)[0] . " - Máximo: " . calcularMinMaxV2($lunes, $martes, $miercoles)[1] . "<br>";
$jueves = 500;
$viernes = 320;
$sabado = 610;
echo "Semana 2 - Mínimo: " . calcularMinMaxV2($jueves, $viernes, $sabado)[0] . " - Máximo: " . calcularMinMaxV2($jueves, $viernes, $sabado)[1] . "<br>";
echo "<hr>";
// --- Mesas ocupadas ---
$mesas = 0;
ocuparMesa($mesas);
ocuparMesa($mesas);
ocuparMesa($mesas);
echo "Mesas ocupadas: " . $mesas . "<br>";
echo "<hr>";
// --- Happy hour: descuento global en bebidas ---
$descuentoBebida = 0.20;
echo "Cerveza: " . precioBebida(5) . " €<br>";
echo "Vino: " . precioBebida(8) . " €<br>";
$descuentoBebida = 0.50; // última hora
echo "Cerveza (última hora): " . precioBebida(5) . " €<br>";
?>