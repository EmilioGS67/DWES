<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Get y Post 6</title>
</head>
<body>

    <h2>Elige</h2>

    <form action="" method="GET">
        
        <select name="categoria" id="categoria">
            <option value="Ordenadores">Ordenadores</option>
            <option value="Periféricos">Periféricos</option>
            <option value="Móviles">Móviles</option>
            <option value="Componentes">Componentes</option>
        </select>
        <button type="submit">Enviar</button>
    </form>

    <br>

<?php

    if (isset($_GET['categoria'])) {
        
        $categoria = htmlspecialchars($_GET['categoria']);
        
        echo "<p>Categoría seleccionada: " . $categoria . "</p>";
    }
?>

</body>
</html>
