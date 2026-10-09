<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Get y Post 4</title>
</head>
<body>

    <h2>Introduce tus datos</h2>

    <form action="" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br><br>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required>
        <br><br>
        
        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" required>
        <br><br>
        
        <button type="submit">Enviar</button>
    </form>

    <br>

    <?php

    if (isset($_POST['nombre']) && isset($_POST['edad']) && isset($_POST['apellidos'])) {
        
        $nombre = htmlspecialchars($_POST['nombre']);
        $apellidos = htmlspecialchars($_POST['apellidos']);
        $edad = htmlspecialchars($_POST['edad']);

        echo "<p>Nombre: " . $nombre . "</p>";
        echo "<p>Apellidos: " . $apellidos . "</p>";
        echo "<p>Edad: " . $edad . "</p>";
    }
    ?>

</body>
</html>

