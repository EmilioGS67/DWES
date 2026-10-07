<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Get y Post 1</title>
</head>
<body>

    <h2>Introduce tus datos</h2>

    <form action="" method="get">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br><br>
        
        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" required>
        <br><br>
        
        <button type="submit">Enviar</button>
    </form>

    <br>

    <?php

    if (isset($_GET['nombre']) && isset($_GET['edad'])) {
        
        $nombre = htmlspecialchars($_GET['nombre']);
        $edad = htmlspecialchars($_GET['edad']);

        echo "<p>Nombre: " . $nombre . "</p>";
        echo "<p>Edad: " . $edad . "</p>";
    }
    ?>

</body>
</html>

