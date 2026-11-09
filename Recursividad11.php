<?php

function sumaAnidado($arr)
{
    $suma = 0;
    foreach ($arr as $elemento) {
        if (is_array($elemento)) {

            $suma += sumaAnidado($elemento);
        } else {

            $suma += $elemento;
        }
    }
    return $suma;
}

$datos = [1, [2, 3], [4, [5, 6]]];
echo sumaAnidado($datos) . "<br>"; 
