<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio01 MySQLi</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
        </style>
    </head>
    <body>
        <h1>Conexión mediante MySQLi.</h1>

        <?php
        require_once '../config/confDBMySQL.php'; //Archivo con configuracion de mysqli
        
// Establecimiento de la conexión.
        $myDB = new mysqli();
        $myDB->connect(HOST, USER, PASSWORD, DB);

        /*
         * Error
         */
        $iError = $myDB->connect_errno;
        if ($iError != 0) {
            echo "<div>Código de error de la última llamada: $iError</div>";
        } else {
            echo "<div>Conexión sin errores.</div>";
        }

        /*
         * Estado de la conexion
         */
        echo '<h2>Estado de la conexión.</h2><table>';
        foreach ($myDB->get_connection_stats() as $sStat => $value) {
            echo "<tr><td>$sStat</td>";
            echo "<td>$value</td></tr>";
        }
        echo '</table>';


        // Cierre de la conexión.
        $myDB->close();
        ?>
    </body>
</html>