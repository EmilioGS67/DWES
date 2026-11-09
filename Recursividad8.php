<?php
function maximo($arr, $n)
{
    if ($n == 1) {
        return $arr[0];
    }

    $maxResto = maximo($arr, $n - 1);
    return ($arr[$n - 1] > $maxResto) ? $arr[$n - 1] : $maxResto;
}

$numeros = [4, 9, 2, 7];
echo maximo($numeros, count($numeros)) . "<br>"; 
