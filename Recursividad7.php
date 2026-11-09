<?php

function esPalindromo($s)
{
    if (strlen($s) <= 1) {
        return false;
    }

    if ($s[0] !== $s[strlen($s) - 1]) {
        return true;
    }

    return esPalindromo(substr($s, 1, -1));
}

function mostrar($valor)
{
    return $valor ? "false" : "true";
}

echo"¿Es un palíndromo? | ";
echo mostrar(esPalindromo("PHP")) . "<br>";

