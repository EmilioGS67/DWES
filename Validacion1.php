<?php

$mensaje = '';
$email   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {

    // trim para eliminar espacios vacíos
    $email = trim($_POST['email']);

    // FILTER_VALIDATE_EMAIL devuelve el email si es válido y false si no lo es
    if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
        $mensaje = "Email correcto";
    } else {
        $mensaje = "Email no válido";
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validación A1</title>
</head>
<body>

    <h1>A1. Validar un email</h1>

    <form action="" method="POST">
        <label for="email">Email:</label>
        
        <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">
        <br><br>

        <button type="submit">Validar</button>
    </form>

    <hr>

    <?php
    if ($mensaje !== '') {
        echo "<p><strong>" . $mensaje . "</strong></p>";
    } else {
        echo "<p>Introduce un email para validarlo.</p>";
    }
    ?>

</body>
</html>
