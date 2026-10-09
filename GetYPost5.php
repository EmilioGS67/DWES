<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Get y Post 5</title>
</head>
<body>

    <h2>Introduce tus datos</h2>

    <form action="" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br><br>

        <label for="correo">Correo electrónico:</label>
        <input type="email" id="correo" name="correo" required>
        <br><br>
        
        <label for="mensaje">Mensaje:</label>
        <input type="text" id="mensaje" name="mensaje" required>
        <br><br>
        
        <button type="submit">Enviar</button>
    </form>

    <br>

    <?php

    if (isset($_POST['nombre']) && isset($_POST['mensaje']) && isset($_POST['correo'])) {
        
        $nombre = htmlspecialchars($_POST['nombre']);
        $correo = htmlspecialchars($_POST['correo']);
        $mensaje = htmlspecialchars($_POST['mensaje']);

        echo "<p>Nombre: " . $nombre . "</p>";
        echo "<p>correo: " . $correo . "</p>";
        echo "<p>mensaje: " . $mensaje . "</p>";
    }
    ?>

</body>
</html>

