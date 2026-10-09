<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Get y Post 9</title>
</head>
<body>

    <h2>Introduce los datos</h2>

    <form action="" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br><br>

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" required>
        <br><br>
        
        <button type="submit">Enviar</button>
    </form>

    <br>

    <?php

if (isset($_POST['nombre'])) {
        
        $nombre = htmlspecialchars($_POST['nombre']);
        $precio = htmlspecialchars($_POST['precio']);

        $rebaja = $precio/10;
        
        echo "<p>Producto: " . $nombre . "</p>";
        echo "<p>Precio sin rebaja: " . $precio . "€</p>";
        echo "<p>Rebaja: " . $rebaja . "€</p>";
        echo "<p>Precio con rebaja: " . $precio-$rebaja . "€</p>";
    }
    ?>

</body>
</html>

