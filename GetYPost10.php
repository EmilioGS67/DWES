<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Get y Post 10</title>
</head>
<body>

    <h2>Introduce tu rango de precio</h2>

    <form action="" method="GET">
        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" required>
        <br><br>
        
        <button type="submit">Enviar</button>
    </form>

    <br>

    <?php

if ($_GET['precio']) {

    $precio = htmlspecialchars($_GET['precio']);

    if ($precio < 20) {

        echo "Productos económicos";
    } else if ($precio >= 20 && $precio <= 50) {
        echo "Productos de precio medio";
    }

    if ($precio > 50){
        echo "Productos de gama alta";
    }
}
    ?>

</body>
</html>

