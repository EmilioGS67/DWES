<?php
function invertir($texto)
{
    if (strlen($texto) <= 1) {
        return $texto;
    }

    return invertir(substr($texto, 1)) . $texto[0];
}

echo invertir("Cascanueces") . "<br>";

