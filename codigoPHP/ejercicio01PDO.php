<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once '../config/confDBPDO.php';//Archivo con configuracion de PDO

        try {
            echo '<h2>Conexion correcta </h2>';
            $miDB = new PDO(HOST, USER, PASSWORD);
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $aAtributosPDO = [
                "AUTOCOMMIT",
                "ERRMODE",
                "CASE",
                "CLIENT_VERSION",
                "CONNECTION_STATUS",
                "ORACLE_NULLS",
                "PERSISTENT",
                "SERVER_INFO",
                "SERVER_VERSION"
            ];

            echo '<table>';
            foreach ($aAtributosPDO as $atributo) {
                echo "<tr><td>PDO::ATTR_$atributo: </td>";
                echo '<td>' . $miDB->getAttribute(constant("PDO::ATTR_$atributo")) . "</td></tr>";
            }
            echo '</table>';

            echo "<h3><span style='collor: green;'>" . "Conexion establecida con exito </span></h3>";
        } catch (PDOException $excepcion) {//Codigo que se ejecuta si hay algun error
            $errorExcepcion = $excepcion->getCode(); //Obtengo el codigo del error y lo almaceno en la variable errorException
            $mensajeException = $excepcion->getMessage(); //Obtengo el mensaje del error y lo almaceno en la variable mensajeException

            echo "<p style='color: red'>Codigo del error: </p>" . $errorExcepcion; //Muestro el codigo del error
            echo "<p style='color: red'>Mensaje del error: </p>" . $mensajeException; //Muestro el mensaje del error
        } finally {
            //Cierro la conexion
            unset($miDB);
        }
        ?>
    </body>
</html>
0