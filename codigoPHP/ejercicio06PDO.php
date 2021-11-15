<!DOCTYPE html>
<html lang="en">
    <head>
        <title>EJERCICIO06PDO</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
        </style>
    </head>
    <body>

        <?php
        require_once '../config/confDBPDO.php'; //Archivo con configuracion de PDO
        try {

            //Hago la conexion con la base de datos
                    $miDB = new PDO(HOST, USER, PASSWORD);
                    //Establezco el atributo para la aparicion de errores con ATTR_ERRMODE y le pongo que cuando haya un error se lance una excepcion con ERRMODE_EXCEPTION
                    $miDB -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            /* Iniciar el array departamentos con tres registros */
            $aDepartamentos = [["CodDepartamento" => 'UNO', "DescDepartamento" => 'departamento UNO', "VolumenNegocio" => 2000],
                ["CodDepartamento" => 'DOS', "DescDepartamento" => 'departamento DOS', "VolumenNegocio" => 900],
                ["CodDepartamento" => 'TRI', "DescDepartamento" => 'departamento TRI', "VolumenNegocio" => 1899]];

            /* Insertamos datos */
            $sql = "
                   INSERT INTO Departamento (CodDepartamento, DescDepartamento, VolumenNegocio) VALUES 
                            (:CodDepartamento, :DescDepartamento, :VolumenNegocio);    
                    ";

            /* Preparamos la consulta */
            $consulta = $miDB->prepare($sql);


            /* transaccion */
            $miDB->beginTransaction();

            /* Recorrer el array */

            foreach ($aDepartamentos as $departamento) {
                $parametros = [":CodDepartamento" => $departamento["CodDepartamento"],
                    ":DescDepartamento" => $departamento["DescDepartamento"],
                    ":VolumenNegocio" => $departamento["VolumenNegocio"]];
                
                $consulta->execute($parametros);
            }
           
            $miDB->commit();

            /* si todo esta correcto. */
            echo 'Informacion insertada';
            ?>
            <table>
                <tr>
                    <th>Código del Departamento</th>
                    <th>Descripción</th>
                    <th>Volumen del negocio</th>
                </tr>
                <?php
                //ejecutando un select se muestra el contenido de la tabla departamento
                $sql = 'SELECT * FROM Departamento';
                //esto es un objeto de clase PDOStatement
                $resultadoConsulta = $miDB->query($sql);
                //mostrar el numero de registros que hemos seleccionado
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
        } catch (PDOException $exception) {
            $miDB->rollback();
            /* Si hay algun error */
            echo '<span> Codigo del Error :' . $exception->getCode() . '</span> <br>';

            /* Muestra el mensaje de error */
            echo '<span> Error :' . $exception->getMessage() . '</span> <br>';
        } finally {
            /* Cerramos la conexion */
            unset($miDB);
        }
        ?>
    </body>
</html>