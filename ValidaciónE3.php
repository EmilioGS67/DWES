<?php

// E3. Comprobador de documentos (documentos.php)
// Las funciones de validación están en funciones.php (debe estar en la misma carpeta).

require_once __DIR__ . '/funciones.php';

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

// Campo del formulario => [etiqueta, función de validación]
$campos = [
    'dni'       => ['DNI',           'validarDNI'],
    'telefono'  => ['Teléfono',      'validarTelefono'],
    'cp'        => ['Código postal', 'validarCP'],
    'matricula' => ['Matrícula',     'validarMatricula']
];

$valores = ['dni' => '', 'telefono' => '', 'cp' => '', 'matricula' => ''];
$enviado = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $enviado = true;

    foreach ($campos as $clave => $datos) {
        $valores[$clave] = isset($_POST[$clave]) && is_string($_POST[$clave]) ? trim($_POST[$clave]) : '';
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validación E3</title>
</head>
<body>

    <h1>Comprobador de documentos</h1>

    <form action="" method="POST">
        <?php foreach ($campos as $clave => $datos) { ?>
            <label for="<?php echo $clave; ?>"><?php echo e($datos[0]); ?>:</label>
            <input type="text" id="<?php echo $clave; ?>" name="<?php echo $clave; ?>" value="<?php echo e($valores[$clave]); ?>">
            <br><br>
        <?php } ?>

        <button type="submit">Comprobar</button>
    </form>

    <hr>

    <h2>Resultado</h2>

    <?php if ($enviado) { ?>
        <table border="1" cellpadding="4">
            <tr><th>Campo</th><th>Valor escrito</th><th>Resultado</th></tr>
            <?php foreach ($campos as $clave => $datos) {
                $funcion = $datos[1];
                // Un campo vacío se considera no válido
                $valido = $valores[$clave] !== '' && $funcion($valores[$clave]); ?>
                <tr>
                    <td><?php echo e($datos[0]); ?></td>
                    <td><?php echo e($valores[$clave]); ?></td>
                    <td><?php echo $valido ? 'Válido' : 'No válido'; ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>Rellena los campos y pulsa Comprobar.</p>
    <?php } ?>

    <p>Pruebas sugeridas: 12345678Z · 612345678 · 28001 · 1234BCD (válidos) y 12345678A · 512345678 · 53000 · 1234AEI (no válidos).</p>

</body>
</html>
