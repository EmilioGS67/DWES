<?php

$asuntos = ["Consulta general", "Soporte técnico", "Facturación"];

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

$errores = [];  
$nombre = '';
$email = '';
$asunto = '';
$mensaje = '';
$acepto = false;
$enviado = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre  = isset($_POST['nombre'])  && is_string($_POST['nombre'])  ? trim($_POST['nombre'])  : '';
    $email   = isset($_POST['email'])   && is_string($_POST['email'])   ? trim($_POST['email'])   : '';
    $asunto  = isset($_POST['asunto'])  && is_string($_POST['asunto'])  ? trim($_POST['asunto'])  : '';
    $mensaje = isset($_POST['mensaje']) && is_string($_POST['mensaje']) ? trim($_POST['mensaje']) : '';
    $acepto  = isset($_POST['acepto']);

    $mensaje = str_replace("\r\n", "\n", $mensaje);

    // Nombre
    if ($nombre === '') {
        $errores['nombre'] = "El nombre es obligatorio.";
    } else if (preg_match('/^\p{L}[\p{L} \'’-]{1,39}$/uD', $nombre) !== 1) {
        $errores['nombre'] = "El nombre no es válido (2-40 letras, espacios, guiones o apóstrofos).";
    }

    // Email
    if ($email === '') {
        $errores['email'] = "El email es obligatorio.";
    } else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errores['email'] = "El email no es válido.";
    }

    // Asunto
    if ($asunto === '') {
        $errores['asunto'] = "Selecciona un asunto.";
    } else if (!in_array($asunto, $asuntos, true)) {
        $errores['asunto'] = "El asunto seleccionado no es válido.";
    }

    // Mensaje
    $longitud = mb_strlen($mensaje);
    if ($mensaje === '') {
        $errores['mensaje'] = "El mensaje es obligatorio.";
    } else if ($longitud < 10 || $longitud > 500) {
        $errores['mensaje'] = "El mensaje debe tener entre 10 y 500 caracteres (ahora tiene $longitud).";
    }

    // Condiciones
    if (!$acepto) {
        $errores['acepto'] = "Debes aceptar las condiciones.";
    }

    if (count($errores) === 0) {
        $enviado = true;
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contacto</title>
    <style>.error { color: #b00020; }</style>
</head>
<body>

    <h1>Formulario de contacto</h1>

    <?php if ($enviado) { ?>

        <h2>Resumen del mensaje</h2>
        <p>Nombre: <?php echo e($nombre); ?></p>
        <p>Email: <?php echo e($email); ?></p>
        <p>Asunto: <?php echo e($asunto); ?></p>
        <p>Mensaje:<br><?php echo nl2br(htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8')); ?></p>
        <p><strong>Gracias por contactar con nosotros.</strong></p>

    <?php } else { ?>

        <form action="" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo e($nombre); ?>">
            <?php if (isset($errores['nombre'])) { echo '<span class="error">' . e($errores['nombre']) . '</span>'; } ?>
            <br><br>

            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="<?php echo e($email); ?>">
            <?php if (isset($errores['email'])) { echo '<span class="error">' . e($errores['email']) . '</span>'; } ?>
            <br><br>

            <label for="asunto">Asunto:</label>
            <select id="asunto" name="asunto">
                <option value="">Selecciona un asunto</option>
                <?php foreach ($asuntos as $opcion) { ?>
                    <option value="<?php echo e($opcion); ?>"<?php echo $asunto === $opcion ? ' selected' : ''; ?>><?php echo e($opcion); ?></option>
                <?php } ?>
            </select>
            <?php if (isset($errores['asunto'])) { echo '<span class="error">' . e($errores['asunto']) . '</span>'; } ?>
            <br><br>

            <label for="mensaje">Mensaje (10-500 caracteres):</label><br>
            <textarea id="mensaje" name="mensaje" rows="5" cols="50"><?php echo e($mensaje); ?></textarea>
            <?php if (isset($errores['mensaje'])) { echo '<br><span class="error">' . e($errores['mensaje']) . '</span>'; } ?>
            <br><br>

            <input type="checkbox" id="acepto" name="acepto"<?php echo $acepto ? ' checked' : ''; ?>>
            <label for="acepto">Acepto las condiciones</label>
            <?php if (isset($errores['acepto'])) { echo '<span class="error">' . e($errores['acepto']) . '</span>'; } ?>
            <br><br>

            <button type="submit">Enviar</button>
        </form>

    <?php } ?>

</body>
</html>
