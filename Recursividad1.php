<?php 
function Suma($n){
    if ($n == 0) return 0;

    return $n + Suma($n-1);
}

echo Suma(5);
?>