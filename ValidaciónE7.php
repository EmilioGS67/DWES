<?php

// E7. Batería de pruebas (tests.php)
// Prueba validarDNI, validarTelefono y validarCP (definidas en funciones.php, misma carpeta).

require_once __DIR__ . '/funciones.php';

// Cada caso: [valor, resultado esperado, descripción]
$casos = [

    'validarDNI' => [
        ['12345678Z', true,  'Válido'],
        ['00000000T', true,  'Válido (resto 0)'],
        ['87654321X', true,  'Válido'],
        ['12345678z', true,  'Válido en minúscula (se normaliza)'],
        ['12345678A', false, 'Letra incorrecta'],
        ['1234567Z',  false, 'Solo 7 números'],
        ['123456789Z', false, 'Demasiados números'],
        ['12345678',  false, 'Falta la letra'],
        ['ABCDEFGHZ', false, 'Sin números'],
        ['',          false, 'Vacío'],
        ['00000000R', false, 'LÍMITE: el número es correcto pero la letra es la de otro resto']
    ],

    'validarTelefono' => [
        ['612345678',   true,  'Móvil válido'],
        ['712345678',   true,  'Móvil válido (empieza por 7)'],
        ['912345678',   true,  'Fijo válido'],
        ['612 345 678', true,  'Válido con espacios'],
        ['512345678',   false, 'LÍMITE: empieza por 5'],
        ['61234567',    false, 'Solo 8 dígitos'],
        ['6123456789',  false, 'Demasiados dígitos'],
        ['61234567a',   false, 'Contiene una letra'],
        ['+34612345678', false, 'Con prefijo (no admitido)'],
        ['',            false, 'Vacío']
    ],

    'validarCP' => [
        ['28001', true,  'Madrid'],
        ['01001', true,  'LÍMITE: primera provincia (01)'],
        ['52999', true,  'LÍMITE: última provincia (52)'],
        ['00999', false, 'LÍMITE: provincia 00 no existe'],
        ['53000', false, 'LÍMITE: provincia 53 no existe'],
        ['2800',  false, 'Solo 4 dígitos'],
        ['280011', false, 'Demasiados dígitos'],
        ['abcde', false, 'Letras'],
        ['28 01', false, 'Con espacio'],
        ['',      false, 'Vacío']
    ]
];

$total  = 0;
$fallos = 0;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validación E7</title>
    <style>
        .ok    { color: #0a7a28; font-weight: bold; }
        .fallo { color: #b00020; font-weight: bold; }
    </style>
</head>
<body>

    <h1>E7. Batería de pruebas</h1>

    <?php foreach ($casos as $funcion => $lista) { ?>

        <h2><?php echo $funcion; ?>()</h2>

        <table border="1" cellpadding="4">
            <tr><th>Valor</th><th>Descripción</th><th>Esperado</th><th>Obtenido</th><th>Resultado</th></tr>
            <?php foreach ($lista as $caso) {
                $valor    = $caso[0];
                $esperado = $caso[1];
                $obtenido = $funcion($valor);
                $correcto = $obtenido === $esperado;

                $total++;
                if (!$correcto) {
                    $fallos++;
                } ?>
                <tr>
                    <td><code><?php echo htmlspecialchars($valor === '' ? '(vacío)' : $valor, ENT_QUOTES, 'UTF-8'); ?></code></td>
                    <td><?php echo htmlspecialchars($caso[2], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo $esperado ? 'Válido' : 'No válido'; ?></td>
                    <td><?php echo $obtenido ? 'Válido' : 'No válido'; ?></td>
                    <td class="<?php echo $correcto ? 'ok' : 'fallo'; ?>"><?php echo $correcto ? 'OK' : 'FALLO'; ?></td>
                </tr>
            <?php } ?>
        </table>

    <?php } ?>

    <hr>

    <p><strong>Resumen:</strong> <?php echo $total - $fallos; ?> de <?php echo $total; ?> pruebas correctas
       (<?php echo $fallos; ?> fallo<?php echo $fallos === 1 ? '' : 's'; ?>).</p>

</body>
</html>
