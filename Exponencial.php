<?php
function Ejemplo($n){
    if($n==0){
        return 1;
    }
    echo $n;
    Ejemplo($n-1);
        echo $n;
}

  Ejemplo(3);  
?>