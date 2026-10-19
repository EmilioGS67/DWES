<?php

$comentario = '';
$seguro     = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comentario']) && is_string($_POST['comentario'])) {

    $comentario = trim($_POST['comentario']);

    $seguro = htmlspecialchars($comentario, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validación 5</title>
</head>
<body>

    <h1>Sanear un comentario</h1>

    <form action="" method="POST">
        <label for="comentario">Comentario:</label><br>
        <textarea id="comentario" name="comentario" rows="4" cols="50"><?php echo htmlspecialchars($comentario, ENT_QUOTES, 'UTF-8'); ?></textarea>
        <br><br>

        <button type="submit">Enviar</button>
    </form>

    <hr>

    <h2>Resultado</h2>

    <?php if ($comentario !== '') { ?>
        <p>Comentario mostrado de forma segura:</p>
        <blockquote><?php echo nl2br($seguro); ?></blockquote>

        <p>Código HTML que recibe el navegador:</p>
        <pre><?php echo htmlspecialchars($seguro, ENT_QUOTES, 'UTF-8'); ?></pre>
    <?php } else { ?>
        <p>Escribe un comentario, por ejemplo: &lt;script&gt;alert('hola')&lt;/script&gt;</p>
    <?php } ?>

    <hr>

</body>
</html>
