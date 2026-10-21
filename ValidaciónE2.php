<?php

$tiposIva = ['4', '10', '21'];

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

$errores = [];
$precioTxt = '';
$iva = '';
$resultado = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $precioTxt = isset($_POST['precio']) && is_string($_POST['precio']) ? trim($_POST['precio']) : '';
    $iva       = isset($_POST['iva'])    && is_string($_POST['iva'])    ? trim($_POST['iva'])    : '';

    if ($precioTxt === '') {
        $errores['precio'] = "El precio es obligatorio.";
    } else if (preg_match('/^[0-9]+([.,][0-9]{1,2})?$/D', $precioTxt) !== 1) {
        $errores['precio'] = "El precio debe ser un número positivo con un máximo de 2 decimales (19,99 o 19.99).";
    } else {
        
        $precio = (float) str_replace(',', '.', $precioTxt);

        if ($precio <= 0) {
            $errores['precio'] = "El precio debe ser mayor que 0.";
        }
    }

    // Tipo de IVA
    if ($iva === '') {
        $errores['iva'] = "Selecciona un tipo de IVA.";
    } else if (!in_array($iva, $tiposIva, true)) {
        $errores['iva'] = "El tipo de IVA no es válido.";
    }

    // Cálculo
    if (count($errores) === 0) {
        $base  = $precio;
        $cuota = round($base * ((int) $iva) / 100, 2);
        $total = $base + $cuota;

        $resultado = ['base' => $base, 'cuota' => $cuota, 'total' => $total];
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calculadora de IVA</title>
    <style>.error { color: #b00020; }</style>
</head>
<body>

    <h1>Calculadora de IVA</h1>

    <form action="" method="POST">
        <label for="precio">Precio (sin IVA):</label>
        <input type="text" id="precio" name="precio" value="<?php echo e($precioTxt); ?>">
        <?php if (isset($errores['precio'])) { echo '<span class="error">' . e($errores['precio']) . '</span>'; } ?>
        <br><br>

        <label for="iva">Tipo de IVA:</label>
        <select id="iva" name="iva">
            <option value="">Selecciona</option>
            <?php foreach ($tiposIva as $tipo) { ?>
                <option value="<?php echo $tipo; ?>"<?php echo $iva === $tipo ? ' selected' : ''; ?>><?php echo $tipo; ?> %</option>
            <?php } ?>
        </select>
        <?php if (isset($errores['iva'])) { echo '<span class="error">' . e($errores['iva']) . '</span>'; } ?>
        <br><br>

        <button type="submit">Calcular</button>
    </form>

    <hr>

    <?php if ($resultado !== null) { ?>
        <h2>Resultado</h2>
        <p>Base imponible: <?php echo number_format($resultado['base'], 2, ',', '.'); ?> €</p>
        <p>Cuota de IVA (<?php echo $iva; ?> %): <?php echo number_format($resultado['cuota'], 2, ',', '.'); ?> €</p>
        <p><strong>Total: <?php echo number_format($resultado['total'], 2, ',', '.'); ?> €</strong></p>
    <?php } else { ?>
        <p>Introduce un precio y un tipo de IVA.</p>
    <?php } ?>

</body>
</html>
