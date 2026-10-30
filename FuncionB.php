<?php
function calcular($cantidad, $moneda = "€")
{
    return number_format($cantidad, 2) . " " . $moneda;
}
function ingresar(&$saldo, $cantidad)
{
    $saldo += $cantidad;
}
function retirar(&$saldo, $cantidad)
{
    if ($saldo >= $cantidad) {
        $saldo -= $cantidad;
        return true;
    } else {
        return false;
    }
}
function calcularComision($importe)
{
    global $comision;
    return calcular($comision * $importe);
}
// Creo que esta versión es más eficiente y cómoda a la hora de utilizarla en varios casos, ya que es solo una línea
function calcularComisionV2($importe, $comision)
{
    return $comision * $importe;
}
function interes($capital, $anios = 1){
    return calcular($capital * 0.03 * $anios);
}
// ===== CUENTA BANCARIA =====
$saldo = 1000;
echo "Saldo inicial: " . calcular($saldo) . "<br>";
// --- Ingresos ---
ingresar($saldo, 250);
echo "Ingreso de 250. Saldo: " . calcular($saldo) . "<br>";
ingresar($saldo, 100);
echo "Ingreso de 100. Saldo: " . calcular($saldo) . "<br>";
// --- Retiradas (solo si hay saldo suficiente) ---

if (retirar($saldo, 300) == true) {
    echo "Retirada de 300. Saldo: " . calcular($saldo) . "<br>";
} else {
    echo "Saldo insuficiente para retirar 300<br>";
}
if (retirar($saldo, 2000) == true) {
    echo "Retirada de 2000. Saldo: " . calcular($saldo) . "<br>";
} else {
    echo "Saldo insuficiente para retirar 2000<br>";
}
if (retirar($saldo, 50) == true) {
    echo "Retirada de 50. Saldo: " . calcular($saldo) . "<br>";
} else {
    echo "Saldo insuficiente para retirar 50<br>";
}
echo "<hr>";
// --- Comisión por transferencia ---
$comision = 0.02;
$transf1 = 500;
echo "Transferencia de " . $transf1 . ": comisión " . calcularComision($transf1) . "<br>";
$transf2 = 1200;
echo "Transferencia de " . $transf2 . ": comisión " . calcularComision($transf2) . "<br>";
$comision = 0.05; // sube la comisión
$transf3 = 800;
echo "Transferencia de " . $transf3 . ": comisión " . calcularComision($transf3) . "<br>";
echo "<hr>";
// --- Comisión por transferencia V2 ---
$comision = 0.02;
$transf1 = 500;
echo "Transferencia de " . $transf1 . ": comisión " . calcular(calcularComisionV2($transf1, 0.02)) . "<br>";
$transf2 = 1200;
echo "Transferencia de " . $transf2 . ": comisión " . calcular(calcularComisionV2($transf2, 0.02)) . "<br>";
$comision = 0.05; // sube la comisión
$transf3 = 800;
echo "Transferencia de " . $transf3 . ": comisión " . calcular(calcularComisionV2($transf3, 0.05)) . "<br>";
echo "<hr>";
// --- Intereses (interés simple; por defecto, 1 año) ---
$capital1 = 2000;
echo "Interés a 1 año de " . $capital1 . ": " . interes($capital1) . "<br>";
$capital2 = 5000;
echo "Interés a 1 año de " . $capital2 . ": " . interes($capital2) . "<br>";
$capital3 = 5000;
echo "Interés a 5 años de " . $capital3 . ": " . interes($capital3, 5) . "<br>";
?>