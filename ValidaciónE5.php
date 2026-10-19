<?php

// E5. Mini librería de validación (validador.php)
// validar(array $datos, array $reglas): array  ->  devuelve los errores encontrados.
//
// Reglas disponibles:
//   requerido           el campo no puede estar vacío
//   email               email válido
//   nombre              nombre propio (2-40 letras, espacios, guiones y apóstrofos)
//   entero:min:max      entero entre min y max (ambos opcionales: entero, entero:18, entero:18:99)
//   telefono            teléfono español (regla añadida)
//   url                 URL http o https (regla añadida)
//
// Los campos que NO son requeridos y vienen vacíos se consideran correctos (se saltan el resto de reglas).

function validar(array $datos, array $reglas): array
{
    $errores = [];

    foreach ($reglas as $campo => $listaReglas) {

        $valor = $datos[$campo] ?? '';

        // Si llega un array u otro tipo (p. ej. nombre[]=a), no es un valor válido
        if (!is_string($valor)) {
            $errores[$campo] = "El campo $campo no es válido.";
            continue;
        }

        $valor = trim($valor);

        // ¿Es obligatorio?
        if (in_array('requerido', $listaReglas, true) && $valor === '') {
            $errores[$campo] = "El campo $campo es obligatorio.";
            continue;
        }

        // Campo opcional vacío: no hay nada que validar
        if ($valor === '') {
            continue;
        }

        foreach ($listaReglas as $regla) {

            // "entero:18:99" -> nombre = "entero", parámetros = ["18", "99"]
            $partes = explode(':', $regla);
            $nombreRegla = array_shift($partes);

            switch ($nombreRegla) {

                case 'requerido':
                    // ya comprobada arriba
                    break;

                case 'email':
                    if (filter_var($valor, FILTER_VALIDATE_EMAIL) === false) {
                        $errores[$campo] = "El campo $campo no es un email válido.";
                    }
                    break;

                case 'nombre':
                    if (preg_match('/^\p{L}[\p{L} \'’-]{1,39}$/uD', $valor) !== 1) {
                        $errores[$campo] = "El campo $campo no es un nombre válido (2-40 letras, espacios, guiones o apóstrofos).";
                    }
                    break;

                case 'entero':
                    $opciones = [];
                    if (isset($partes[0]) && $partes[0] !== '') {
                        $opciones['min_range'] = (int) $partes[0];
                    }
                    if (isset($partes[1]) && $partes[1] !== '') {
                        $opciones['max_range'] = (int) $partes[1];
                    }

                    if (filter_var($valor, FILTER_VALIDATE_INT, ['options' => $opciones]) === false) {
                        $mensaje = "El campo $campo debe ser un número entero";
                        if (isset($opciones['min_range'], $opciones['max_range'])) {
                            $mensaje .= " entre {$opciones['min_range']} y {$opciones['max_range']}";
                        } else if (isset($opciones['min_range'])) {
                            $mensaje .= " mayor o igual que {$opciones['min_range']}";
                        } else if (isset($opciones['max_range'])) {
                            $mensaje .= " menor o igual que {$opciones['max_range']}";
                        }
                        $errores[$campo] = $mensaje . ".";
                    }
                    break;

                case 'telefono':
                    if (preg_match('/^[6-9][0-9]{8}$/D', str_replace(' ', '', $valor)) !== 1) {
                        $errores[$campo] = "El campo $campo no es un teléfono español válido.";
                    }
                    break;

                case 'url':
                    $esquema = strtolower((string) parse_url($valor, PHP_URL_SCHEME));
                    if (filter_var($valor, FILTER_VALIDATE_URL) === false || ($esquema !== 'http' && $esquema !== 'https')) {
                        $errores[$campo] = "El campo $campo no es una URL válida (http o https).";
                    }
                    break;

                default:
                    // Error del programador, no del usuario: mejor avisar que ignorarlo en silencio
                    throw new InvalidArgumentException("Regla de validación desconocida: $nombreRegla");
            }

            // Un solo error por campo: nos quedamos con el primero que falle
            if (isset($errores[$campo])) {
                break;
            }
        }
    }

    return $errores;
}

// ---------- Demostración ----------

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

$reglas = [
    'nombre'   => ['requerido', 'nombre'],
    'email'    => ['requerido', 'email'],
    'edad'     => ['requerido', 'entero:18:99'],
    'telefono' => ['telefono'],   // opcional
    'web'      => ['url']         // opcional
];

$etiquetas = ['nombre' => 'Nombre', 'email' => 'Email', 'edad' => 'Edad', 'telefono' => 'Teléfono (opcional)', 'web' => 'Web (opcional)'];

$errores = [];
$enviado = false;
$valores = array_fill_keys(array_keys($reglas), '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errores = validar($_POST, $reglas);
    $enviado = true;

    foreach ($valores as $campo => $v) {
        $valores[$campo] = isset($_POST[$campo]) && is_string($_POST[$campo]) ? trim($_POST[$campo]) : '';
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validación E5</title>
    <style>.error { color: #b00020; }</style>
</head>
<body>

    <h1>E5. Mini librería de validación</h1>

    <form action="" method="POST">
        <?php foreach ($reglas as $campo => $r) { ?>
            <label for="<?php echo $campo; ?>"><?php echo e($etiquetas[$campo]); ?>:</label>
            <input type="text" id="<?php echo $campo; ?>" name="<?php echo $campo; ?>" value="<?php echo e($valores[$campo]); ?>">
            <?php if (isset($errores[$campo])) { echo '<span class="error">' . e($errores[$campo]) . '</span>'; } ?>
            <br><br>
        <?php } ?>

        <button type="submit">Validar</button>
    </form>

    <hr>

    <?php
    if ($enviado && count($errores) === 0) {
        echo "<p><strong>Todos los datos son correctos.</strong></p>";
    } else if ($enviado) {
        echo "<p><strong>Se han encontrado " . count($errores) . " error(es).</strong></p>";
    } else {
        echo "<p>Rellena el formulario y pulsa Validar.</p>";
    }
    ?>

</body>
</html>
