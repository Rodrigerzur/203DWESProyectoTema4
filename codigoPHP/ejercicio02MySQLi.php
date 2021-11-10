<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio 02 MySQLi</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
        </style>
    </head>
    <body>
        <h1>Atributos de la conexión</h1>

        <?php
        require_once '../config/confDBMySQL.php'; //Archivo con configuracion de mysqli


        // Establecimiento de la conexión.
        $myDB = new mysqli();
        $myDB->connect(HOST, USER, PASSWORD, DB);
        
        /*
         * Código de error de la conexión. Si no hay ninguno, muestra que la conexión se ha realizado correctamente.
         */
        $iError = $myDB->connect_errno;
        if($iError!=0){
            echo "<div>Código de error de la última llamada: $iError</div>";
        }
        
        
        /*
         * Query de selección de todo el contenido de la tabla.
         * 
         * Devuelve un mysqli_result
         */
        $sConsulta = 'SELECT * FROM Departamento';
        $oResultadoConsulta = $myDB->query($sConsulta);
        
        /*
         * número de filas devueltas por el query.
         */
        echo '<div>La tabla Departamentos tiene '.$oResultadoConsulta->num_rows.' registros.</div>';

        /*
         * información devuelta por el query con fetch_all.
         */
        echo '<h2>Mediante fetch_all</h2>';
        $aQuery = $oResultadoConsulta->fetch_all();
        echo '<table>';
        foreach ($aQuery as $aFila) {
            echo '<tr>';
            foreach ($aFila as $valor) {
                echo "<td>$valor</td>";
            }
            echo '</tr>'; 
        }
        echo '</table>';
        
      
        /*
         * Reselección de la información 
         */
        $oResultadoConsulta = $myDB->query($sConsulta);
        
        // Cierre de la conexión.
        $myDB->close();
        
        
        ?>
    </body>
</html>