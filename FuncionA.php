<?php
// ===== NOTAS DE LA CLASE DE DAW =====

function media($nota1, $nota2, $nota3){
    $media = ($nota1 + $nota2 + $nota3) / 3;

    return $media;
}

function resultado($nombre, $media, $minimo = 5){
    if ($media >= $minimo) {
        return $nombre . ": aprobado";
    } else {
        return $nombre . ": suspenso";
    }
}

function incrementa(&$contador){
    $contador = $contador + 1;
}

function intercambiar(&$a, &$b){
    $aux = $a;
    $a = $b;
    $b = $aux;
}

// --- Media de cada alumno ---
$ana1 = 7; $ana2 = 5; $ana3 = 9;
$mediaAna = media($ana1, $ana2, $ana3);
echo "Ana: " . $mediaAna . "<br>";
$luis1 = 4; $luis2 = 6; $luis3 = 5;
$mediaLuis = media($luis1, $luis2, $luis3);
echo "Luis: " . $mediaLuis . "<br>";
$marta1 = 3; $marta2 = 4; $marta3 = 2;
$mediaMarta = media($marta1, $marta2, $marta3);
echo "Marta: " . $mediaMarta . "<br>";
$pablo1 = 8; $pablo2 = 8; $pablo3 = 10;
$mediaPablo = media($pablo1, $pablo2, $pablo3);
echo "Pablo: " . $mediaPablo . "<br>";
echo "<hr>";

// --- Aprobado o suspenso (nota mínima: 5) ---
echo resultado("Ana", $mediaAna) . "<br>";
echo resultado("Luis", $mediaLuis) . "<br>";
echo resultado("Marta", $mediaMarta) . "<br>";
echo resultado("Pablo", $mediaPablo) . "<br>";
// En la recuperación la nota mínima es 4
echo resultado("Marta (recuperación)", $mediaMarta, 4) . "<br>";
echo "<hr>";

// --- Contadores ---
$aprobados = 0;
$suspensos = 0;
incrementa($aprobados); // Ana
incrementa($aprobados); // Luis
incrementa($suspensos); // Marta
incrementa($aprobados); // Pablo
echo "Aprobados: " . $aprobados . " - Suspensos: " . $suspensos . "<br>";
echo "<hr>";

// --- Intercambiar dos notas ---
$notaX = 3;
$notaY = 9;
echo "Antes: " . $notaX . " y " . $notaY . "<br>";
intercambiar($notaX, $notaY);
echo "Después: " . $notaX . " y " . $notaY . "<br>";
$notaP = 6;
$notaQ = 2;
echo "Antes: " . $notaP . " y " . $notaQ . "<br>";
intercambiar($notaP, $notaQ);
echo "Después: " . $notaP . " y " . $notaQ . "<br>";
?>
