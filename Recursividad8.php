<?php
// Ejercicio 8 · Máximo de un array (sin max)

function maximo($arr, $n)
{
    // Caso base: un solo elemento
    if ($n == 1) {
        return $arr[0];
    }
    // Caso recursivo: máximo de los n-1 primeros comparado con el último
    $maxResto = maximo($arr, $n - 1);
    return ($arr[$n - 1] > $maxResto) ? $arr[$n - 1] : $maxResto;
}

$numeros = [4, 9, 2, 7];
echo "maximo([4, 9, 2, 7], 4) = " . maximo($numeros, count($numeros)) . "<br>"; // 9
