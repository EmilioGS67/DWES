<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Get y Post 2</title>
</head>
<body>

    <h2>Introduce tu ciudad</h2>

    <form action="" method="get">
        <label for="ciudad">Ciudad:</label>
        <input type="text" id="ciudad" name="ciudad" required>
        <br><br>
        
        <button type="submit">Enviar</button>
    </form>

    <br>

    <?php

    if (isset($_GET['ciudad'])) {
        
        $ciudad = htmlspecialchars($_GET['ciudad']);

        echo "<p>Vives en " . $ciudad . "</p>";
    }
    ?>

</body>
</html>

