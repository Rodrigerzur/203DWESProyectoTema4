<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Ejercicio2.0 PDO</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            table,tr,td{
                border-collapse: collapse;
                border: 1px solid black;
            }
            table{
                width: 100%;
            }
        </style>
    </head>
    <body>
        <?php
        require_once '../config/confDBPDO.php'; //Archivo con configuracion de PDO
        try {
            /* Establecemos la connection con pdo */
            $miDB = new PDO(HOST, USER, PASSWORD);
            /* configurar las excepcion */
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            ?>
            <table>
                <tr>
                    <th>Código del Departamento</th>
                    <th>Descripción</th>
                    <th>Volumen del negocio</th>
                </tr>
                <?php
                //cogemos el contenido de la tabla con select
                $sql = 'SELECT * FROM Departamento';
               
                $resultadoConsulta = $miDB->prepare($sql);//Preparamos la consulta
                //mostrar el numero de registros que hemos seleccionado
                $resultadoConsulta->execute();//Ejecutamos la consulta
                $numRegistros = $resultadoConsulta->rowCount();
                echo '<p style="color: blue"> <strong>Número de registros: ' . $numRegistros . '</strong></p>';
                $registroObjeto = $resultadoConsulta->fetchObject();
                while ($registroObjeto) {
                    ?>
                    <tr>
                        <td><?php echo $registroObjeto->CodDepartamento ?></td>
                        <td><?php echo $registroObjeto->DescDepartamento ?></td>
                        <td><?php echo $registroObjeto->VolumenNegocio ?></td>
                    </tr>
                    <?php
                    $registroObjeto = $resultadoConsulta->fetchObject();
                }
                ?>
            </table>
            <?php
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