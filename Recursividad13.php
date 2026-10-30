<?php
// Ejercicio 13 · Listar un directorio recursivamente

function listarDirectorio($ruta, $nivel = 0)
{
    $elementos = scandir($ruta);

    foreach ($elementos as $elemento) {
        // Saltamos las entradas especiales
        if ($elemento === "." || $elemento === "..") {
            continue;
        }

        $rutaCompleta = $ruta . DIRECTORY_SEPARATOR . $elemento;
        $sangria = str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $nivel);

        if (is_dir($rutaCompleta)) {
            echo $sangria . "📁 " . htmlspecialchars($elemento) . "<br>";
            // Caso recursivo: listar la subcarpeta con un nivel más
            listarDirectorio($rutaCompleta, $nivel + 1);
        } else {
            // Caso base: es un archivo
            echo $sangria . "📄 " . htmlspecialchars($elemento) . "<br>";
        }
    }
}

// Cambia "proyecto" por la carpeta que quieras listar
$carpeta = __DIR__ . DIRECTORY_SEPARATOR . "proyecto";

if (is_dir($carpeta)) {
    echo "<strong>" . basename($carpeta) . "</strong><br>";
    listarDirectorio($carpeta, 1);
} else {
    echo "La carpeta '$carpeta' no existe. Crea una carpeta 'proyecto' junto a este archivo.";
}
