<?php

// E6. Cacería de vulnerabilidades (busqueda.php)
//
// CÓDIGO VULNERABLE ORIGINAL:
//   $q = $_GET['q'] ?? '';
//   echo "<h1>Resultados para: $q</h1>";
//   $res = $conexion->query("SELECT * FROM productos WHERE nombre LIKE '%$q%'");
//
// Vulnerabilidades:
//   - XSS: $q se imprime sin escapar.
//   - Inyección SQL: $q se concatena en la consulta.
//   - Sin validación: acepta vacío, solo espacios y textos enormes.
//
// Este archivo es la VERSIÓN CORREGIDA. Usa una base de datos SQLite en memoria con unos productos de ejemplo.

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// Base de datos de ejemplo (se crea en memoria en cada petición)
$bd = new PDO('sqlite::memory:');
$bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$bd->exec("CREATE TABLE productos (id INTEGER PRIMARY KEY, nombre TEXT, precio REAL)");
$bd->exec("INSERT INTO productos (nombre, precio) VALUES
            ('Teclado mecánico', 59.90), ('Ratón inalámbrico', 19.99), ('Monitor 24 pulgadas', 129.00),
            ('Portátil 15 pulgadas', 649.00), ('Auriculares Bluetooth', 39.95), ('Cable HDMI', 7.50)");

$maxLongitud = 50;
$q           = '';
$error       = '';
$resultados  = [];
$buscado     = false;

// 1) Validación de la entrada
if (isset($_GET['q'])) {

    if (!is_string($_GET['q'])) {
        $error = "La búsqueda no es válida.";
    } else {
        $q = trim($_GET['q']);

        if ($q === '') {
            $error = "Introduce un término de búsqueda.";
        } else if (mb_strlen($q) > $maxLongitud) {
            $error = "La búsqueda no puede superar los $maxLongitud caracteres.";
            $q = mb_substr($q, 0, $maxLongitud);   // solo para volver a mostrarlo sin llenar la página
        } else {
            $buscado = true;
        }
    }
}

// 2) Consulta preparada
if ($buscado) {
    // Los comodines % y _ escritos por el usuario se tratan como texto normal
    $patron = '%' . str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $q) . '%';

    $consulta = $bd->prepare("SELECT nombre, precio FROM productos WHERE nombre LIKE :patron ESCAPE '\\'");
    $consulta->execute([':patron' => $patron]);
    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validación E6</title>
    <style>.error { color: #b00020; }</style>
</head>
<body>

    <h1>Buscador de productos</h1>

    <form action="" method="GET">
        <label for="q">Buscar:</label>
        <!-- 3) Escapado con ENT_QUOTES: una comilla doble ya no puede cerrar el atributo value -->
        <input type="text" id="q" name="q" value="<?php echo e($q); ?>">
        <button type="submit">Buscar</button>
    </form>

    <?php if ($error !== '') { ?>

        <p class="error"><?php echo e($error); ?></p>

    <?php } else if ($buscado) { ?>

        <h2>Resultados para: <?php echo e($q); ?></h2>

        <?php if (count($resultados) === 0) { ?>
            <p>No se han encontrado productos.</p>
        <?php } else { ?>
            <ul>
                <?php foreach ($resultados as $fila) { ?>
                    <li><?php echo e($fila['nombre']); ?> - <?php echo number_format((float) $fila['precio'], 2, ',', '.'); ?> €</li>
                <?php } ?>
            </ul>
        <?php } ?>

    <?php } ?>

    <hr>

    <h2>Tabla de pruebas</h2>

    <table border="1" cellpadding="4">
        <tr>
            <th>Entrada de prueba</th>
            <th>Qué se espera que ocurra</th>
            <th>Antes de corregir</th>
            <th>Después de corregir</th>
        </tr>
        <tr>
            <td><code>&lt;script&gt;alert(1)&lt;/script&gt;</code></td>
            <td>Ejecución de JavaScript (XSS)</td>
            <td>Se ejecuta el script y aparece la ventana con «1». La consulta no devuelve productos.</td>
            <td>Se muestra como texto (&amp;lt;script&amp;gt;...). No se ejecuta nada y sale «No se han encontrado productos».</td>
        </tr>
        <tr>
            <td><code>&lt;img src=x onerror=alert(1)&gt;</code></td>
            <td>Ejecución de JavaScript (XSS)</td>
            <td>La imagen no carga (src=x), salta el evento onerror y aparece la ventana con «1».</td>
            <td>Se muestra como texto escapado. No se crea ninguna etiqueta img y no se ejecuta nada.</td>
        </tr>
        <tr>
            <td><code>' OR '1'='1</code></td>
            <td>Devuelve todos los productos (SQL injection)</td>
            <td>La consulta queda como <code>LIKE '%' OR '1'='1%'</code>; el <code>LIKE '%'</code> coincide con todo y se listan todos los productos.</td>
            <td>Se busca el texto literal «' OR '1'='1»: no coincide con ningún producto y se muestra «No se han encontrado productos».</td>
        </tr>
        <tr>
            <td><code>'</code></td>
            <td>Error de SQL visible</td>
            <td>La comilla rompe la sintaxis (<code>LIKE '%'%'</code>) y aparece un error de SQL, que además revela detalles de la base de datos.</td>
            <td>Se busca la comilla como texto normal: sin error y con «No se han encontrado productos».</td>
        </tr>
        <tr>
            <td><code>"onmouseover="alert(1)</code></td>
            <td>Rompe un atributo HTML</td>
            <td>En el &lt;h1&gt; solo se ve como texto, pero al repetirlo en el campo <code>value="..."</code> del buscador la comilla cierra el atributo y se añade un evento onmouseover que ejecuta JavaScript.</td>
            <td>Las comillas se convierten en <code>&amp;quot;</code>, así que todo queda dentro del value como texto. No se crea ningún evento.</td>
        </tr>
        <tr>
            <td>Solo espacios</td>
            <td>Búsqueda vacía</td>
            <td>Se lanza la consulta con <code>LIKE '%   %'</code> y se muestra un título vacío; resultados inútiles.</td>
            <td>trim() lo deja vacío y se muestra «Introduce un término de búsqueda». No se consulta la base de datos.</td>
        </tr>
        <tr>
            <td>10 000 letras «a»</td>
            <td>Entrada excesiva</td>
            <td>La página repite las 10 000 letras en el título y se lanza una consulta enorme: carga innecesaria para el servidor.</td>
            <td>Se rechaza con «La búsqueda no puede superar los 50 caracteres». No se consulta la base de datos.</td>
        </tr>
    </table>

</body>
</html>
