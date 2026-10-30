<?php
// ===== PEQUEÑA TIENDA ONLINE =====

// --- Saludos a los clientes ---
function saludar($nombre) {
    $saludo = "Hola, " . $nombre . "<br>";
    return $saludo;
}

echo saludar("Ana");
echo saludar("Luis");
echo saludar("Marta");

echo "<hr>";

// --- Precios con IVA (21%) ---
function precioConIVA($precio, $IVA = 21) {
    $IVA = ($precio * $IVA) / 100;
    $precio = $precio + $IVA;
    return $precio . "€ <br>";
}

echo "Pan: " . precioConIVA(2);
echo "Leche: " . precioConIVA(5);
echo "Queso: " . precioConIVA(12);
// Los productos de primera necesidad llevan IVA del 4%
echo "Harina: " . precioConIVA(3, 4);

echo "<hr>";

// --- Suma y producto de dos números --- 
function operaciones($i, $j, &$suma, &$producto) {
    $suma = $i + $j;
    $producto = $i * $j;
}

operaciones(4, 7, $suma1, $producto1);
echo "Suma: $suma1 - Producto: $producto1<br>";

operaciones(10, 3, $suma2, $producto2);
echo "Suma: $suma2 - Producto: $producto2<br>";

echo "<hr>";

// --- Contador de visitas --- 
function incrementa(&$n) {
    $n++;
}

$visitas = 0;
incrementa($visitas);
incrementa($visitas);
incrementa($visitas);
echo "Visitas: " . $visitas . "<br>";             

$visitasOferta = 10;
incrementa($visitasOferta);
incrementa($visitasOferta);
echo "Visitas oferta: " . $visitasOferta . "<br>"; 

// Pregunta: ¿qué pasa si olvidas el &?
// La función recibe una COPIA del valor, incrementa la copia y esta
// desaparece al terminar la función. La variable original no cambia.
function incrementaSinReferencia($n) {
    $n++;
}

$visitasPrueba = 0;
incrementaSinReferencia($visitasPrueba);
incrementaSinReferencia($visitasPrueba);
incrementaSinReferencia($visitasPrueba);
echo "Visitas sin &: " . $visitasPrueba . " (se queda en 0)<br>";

echo "<hr>";

// --- Cafetería de la tienda --- 
function cafe($temperatura, $tipo = "con leche") {
    return "Haciendo café $tipo $temperatura.<br>";
}

echo cafe("caliente");             
echo cafe("frío");                  
echo cafe("caliente", "solo");      
echo cafe("templado", "cortado");   

echo "<hr>";

// --- Descuentos --- 
$descuento = 0.10;

// Versión 1: usa la variable global $descuento con la sentencia global
function aplicarDescuento($precio) {
    global $descuento;
    return $precio - ($precio * $descuento);
}

$precioFinal1 = aplicarDescuento(100);
echo "Precio con descuento: " . $precioFinal1 . " euros<br>";   // 90

$descuento = 0.25;
$precioFinal2 = aplicarDescuento(80);
echo "Precio con descuento: " . $precioFinal2 . " euros<br>";   // 60
$precioFinal3 = aplicarDescuento(50);
echo "Precio con descuento: " . $precioFinal3 . " euros<br>";   // 37.5

// Versión 2: el descuento llega como parámetro
function aplicarDescuentoParam($precio, $descuento) {
    return $precio - ($precio * $descuento);
}

echo "Con parámetro: " . aplicarDescuentoParam(100, 0.10) . " euros<br>"; // 90
echo "Con parámetro: " . aplicarDescuentoParam(80, 0.25) . " euros<br>";  // 60
echo "Con parámetro: " . aplicarDescuentoParam(50, 0.25) . " euros<br>";  // 37.5

/*
 * Valoración: me parece mejor la versión con parámetro. La función depende
 * solo de lo que recibe, así que es más fácil de entender, de reutilizar y
 * de probar. La versión con global depende de una variable externa que
 * cualquier parte del programa puede cambiar, lo que genera errores difíciles
 * de localizar
 */

echo "<hr>";

// Ejercicio 7: Alcance local
function crearVariable() {
    $secreto = "Soy local";
    echo "Dentro de crearVariable(): $secreto<br>";
}

function intentarVerla() {
    // Si descomentas la línea siguiente, PHP muestra un aviso
    // "Warning: Undefined variable $secreto" y no imprime nada útil
    // echo $secreto;
    echo "¿Existe \$secreto aquí? " . (isset($secreto) ? "sí" : "no") . "<br>";
}

crearVariable();
intentarVerla();

/*
 * Una variable local es la que se crea dentro de una función. Solo existe
 * mientras la función se ejecuta y solo es visible dentro de ella. Otra
 * función (o el código de fuera) no puede verla, aunque tenga el mismo nombre, 
 * ya que serían variables distintas
 */

echo "<hr>";

// Reto 1: Devolver un array 
function operacionesArray($i, $j) {
    return [$i + $j, $i * $j];
}

[$suma, $producto] = operacionesArray(4, 7);
echo "Suma: $suma - Producto: $producto<br>";

echo "<hr>";

//Reto 2: Retorno de referencia
function &contadorGlobal() {
    static $contador = 0;
    return $contador;
}

echo "Valor inicial: " . contadorGlobal() . "<br>";   

$ref = &contadorGlobal(); // $ref apunta a la variable static de la función
$ref = 50;                 
echo "Tras \$ref = 50: " . contadorGlobal() . "<br>"; 

$ref++;
echo "Tras \$ref++: " . contadorGlobal() . "<br>";                                                                                                 
?>