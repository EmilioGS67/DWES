<?php

function aBinario($n)
{

    if ($n < 2) {
        return (string)$n;
    }

    return aBinario(intdiv($n, 2)) . ($n % 2);
}

echo '10 en binario es "' . aBinario(10) . '"<br>'; 
echo '255 en binario es "' . aBinario(255) . '"<br>'; 
