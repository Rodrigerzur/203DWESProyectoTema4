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
            require_once '../config/confDBPDO.php';
            echo '<h2>Conexion correcta </h2>';
            
            try{
                $miDB = new PDO(HOST, USER, PASSWORD);
                $miDB ->setAttribute(PDO_ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $aAtributosPDO=[
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
                
                foreach($aAtributosPDO as $valor){
                    echo 'PDO::ATTR_$valor: ';
                    echo $miDB->getAttribute(costant("PDO::ATTR_$valor"))."<br>";
                }
                
                echo "<h3><span style='collor: green;'>"."Conexion establecida con exito </span></h3>";
            } catch (PDOException $exception) {
                $errorExcepcion = $excepcion->getCode();
                $mensajeExcepcion = $excepcion->getMessage();
                
                echo "<span style='color:red;'>Error: </span>".$mensajeExcepcion."<br>";
                echo "<span style='color:red;'>Codigo del error: </span>".$mensajeExcepcion."<br>";
            } finally {
                unset($miDB);
            }
        ?>
    </body>
</html>
