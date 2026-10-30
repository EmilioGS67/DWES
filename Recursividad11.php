<?php
// Ejercicio 11 · Suma de un array anidado

function sumaAnidado($arr)
{
    $suma = 0;
    foreach ($arr as $elemento) {
        if (is_array($elemento)) {
            // Caso recursivo: el elemento es otro array
            $suma += sumaAnidado($elemento);
        } else {
            // Caso base: el elemento es un número
            $suma += $elemento;
        }
    }
    return $suma;
}

$datos = [1, [2, 3], [4, [5, 6]]];
echo "sumaAnidado([1, [2, 3], [4, [5, 6]]]) = " . sumaAnidado($datos) . "<br>"; // 21
