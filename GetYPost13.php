<?php

// Películas disponibles por género 
$peliculas = [
    "Acción" => ["Mad Max", "John Wick", "Gladiator"],
    "Comedia" => ["Superbad", "Ocho apellidos vascos", "Resacón en Las Vegas"],
    "Ciencia ficción" => ["Interestelar", "Blade Runner 2049", "Matrix"],
    "Terror" => ["El resplandor", "Hereditary", "Expediente Warren"]
];

// Tipos de entrada y su descuento
$tipos = [
    "Normal" => 0,
    "Estudiante" => 25,
    "Jubilado" => 40
];

$precioBase = 8;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Get y Set 13</title>
</head>
<body>

    <h1>Reservas de sesiones</h1>

    <h2>Consulta de películas</h2>

    <form action="" method="GET">
        <label for="genero">Género:</label>
        <select id="genero" name="genero" required>
            <option value=""> Selecciona un género </option>
            <?php foreach ($peliculas as $genero => $lista) { ?>
                <option value="<?php echo htmlspecialchars($genero); ?>"><?php echo htmlspecialchars($genero); ?></option>
            <?php } ?>
        </select>
        <br><br>

        <button type="submit">Consultar</button>
    </form>

    <?php

    // Resultado de la consulta
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['genero'])) {

        $genero = trim($_GET['genero']);

        if ($genero === '') {
            echo "<p>Selecciona un género para consultar.</p>";
        } else if (!array_key_exists($genero, $peliculas)) {
            echo "<p>El género seleccionado no es válido.</p>";
        } else {
            echo "<p>Películas disponibles:</p>";
            echo "<ul>";
            foreach ($peliculas[$genero] as $pelicula) {
                echo "<li>" . htmlspecialchars($pelicula) . "</li>";
            }
            echo "</ul>";
        }
    }

    ?>

    <hr>

    <h2>Reserva de entradas</h2>

    <form action="" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br><br>

        <label for="pelicula">Película:</label>
        <select id="pelicula" name="pelicula" required>
            <option value="">Selecciona una película </option>
            <?php foreach ($peliculas as $genero => $lista) { ?>
                <optgroup label="<?php echo htmlspecialchars($genero); ?>">
                    <?php foreach ($lista as $pelicula) { ?>
                        <option value="<?php echo htmlspecialchars($pelicula); ?>"><?php echo htmlspecialchars($pelicula); ?></option>
                    <?php } ?>
                </optgroup>
            <?php } ?>
        </select>
        <br><br>

        <label for="entradas">Número de entradas:</label>
        <input type="number" id="entradas" name="entradas" required>
        <br><br>

        <label for="tipo">Tipo de entrada:</label>
        <select id="tipo" name="tipo" required>
            <?php foreach ($tipos as $tipo => $descuento) { ?>
                <option value="<?php echo $tipo; ?>"><?php echo $tipo; ?></option>
            <?php } ?>
        </select>
        <br><br>

        <button type="submit">Reservar</button>
    </form>

    <hr>

    <h2>Resultado de la reserva</h2>

    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'], $_POST['pelicula'], $_POST['entradas'], $_POST['tipo'])) {

        $nombre   = htmlspecialchars(trim($_POST['nombre']));
        $pelicula = trim($_POST['pelicula']);
        $entradas = trim($_POST['entradas']);
        $tipo     = trim($_POST['tipo']);

        // Comprueba si la película existe dentro del género
        $peliculaValida = false;
        foreach ($peliculas as $lista) {
            if (in_array($pelicula, $lista, true)) {
                $peliculaValida = true;
            }
        }

        if ($nombre === '' || $pelicula === '' || $entradas === '' || $tipo === '') {
            echo "<p>Todos los campos son obligatorios.</p>";
        } else if (!$peliculaValida) {
            echo "<p>La película seleccionada no es válida.</p>";
        } else if (!array_key_exists($tipo, $tipos)) {
            echo "<p>El tipo de entrada no es válido.</p>";
        } else if (filter_var($entradas, FILTER_VALIDATE_INT) === false || (int) $entradas <= 0) {
            echo "<p>La cantidad de entradas no es válida.</p>";
        } else {

            $entradas  = (int) $entradas;
            $descuento = $tipos[$tipo];

            $precioEntrada = $precioBase * (1 - $descuento / 100);
            $precioTotal   = $precioEntrada * $entradas;

            echo "<p>Nombre: $nombre</p>";
            echo "<p>Película: " . htmlspecialchars($pelicula) . "</p>";
            echo "<p>Entradas: $entradas</p>";
            echo "<p>Tipo: $tipo</p>";
            echo "<p>Precio base de una entrada: " . number_format($precioBase, 2, ',', '.') . " €</p>";
            echo "<p>Descuento aplicado: $descuento %</p>";
            echo "<p>Precio de una entrada: " . number_format($precioEntrada, 2, ',', '.') . " €</p>";
            echo "<p>Precio total: " . number_format($precioTotal, 2, ',', '.') . " €</p>";

            if ($entradas >= 5) {
                echo "<p>Reserva para un grupo numeroso.</p>";
            }
        }

    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "<p>Faltan datos en la reserva.</p>";
    } else {
        echo "<p>No se ha realizado ninguna reserva todavía.</p>";
    }

    ?>

</body>
</html>