<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio04PDO</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
        </style>
    </head>
    <body>
        <main>
            <?php
            require_once '../core/210322ValidacionFormularios.php'; //Incluir la libreria de funciones para la validacion
            require_once '../config/confDBMySQL.php'; //Archivo con configuracion de mysqli

            /*
             * Definición de constantes
             */
            define("OBLIGATORIO", 1);
            define("OPCIONAL", 0);

            /*
             * Inicialización del array de elementos del formulario.
             */
            $aFormulario = [
                'descDepartamento' => ''
            ];

            /*
             * Inicialización del array de errores.
             */
            $aErrores = [
                'descDepartamento' => ''
            ];

            /*
             * Confirmación si el formulario ha sido enviado.
             * Si ha sido enviado, valida los campos y registra los errores.
             */
            if (isset($_REQUEST['submit'])) {
                /*
                 * Manejador de errores. Por defecto asume que no hay ningún
                 * error (true). Si encuentra alguno se pone a false.
                 */
                $bEntradaOK = true;

                /*
                 * Registro de errores. Valida todos los campos.
                 */
                $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfanumerico($_REQUEST['descDepartamento'], 255, 3, OPCIONAL);

                /*
                 * Recorrido del array de errores.
                 * Si existe alguno, cambia el manejador de errores a false
                 * y limpia el campo en el $_REQUEST.
                 */
                foreach ($aErrores as $sCampo => $sError) {
                    if ($sError != null) {
                        $_REQUEST[$sCampo] = ''; //Limpieza del campo.
                        $bEntradaOK = false;
                    }
                }
            }

            /*
             * Si el formulario no ha sido enviado
             */ else {
                $bEntradaOK = false;
            }

            /*
             * Si el formulario ha sido enviado y no ha tenido errores
             * muestra la información enviada.
             */
            if ($bEntradaOK) {
                //Si la entrada es true recojo los valores del array aRespuestas
                $aRespuestas['DescDepartamento'] = $_REQUEST['DescDepartamento'];
             
                //Mostrar datos

                echo "<h2>Contenido tabla Departamento</h2>";
                try {
                    //Hago la conexion con la base de datos
                    $miDB = new PDO(HOST, USER, PASSWORD);
                    //Establezco el atributo para la aparicion de errores con ATTR_ERRMODE y le pongo que cuando haya un error se lance una excepcion con ERRMODE_EXCEPTION
                    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    //MUESTRA DE LA TABLA DEPARTAMENTOS
                    $sqlmostrar = "SELECT * FROM Departamento";
                    $resultadoConsulta2 = $miDB->prepare($sqlmostrar); //Preparo la consulta
                    $resultadoConsulta2->execute(); //Ejecuto la consulta    
                    ?>
                    <table>
                        <tr>
                            <th>CodDepartamento</th>
                            <th>DescDepartamento</th>
                            <th>FechaBaja</th>
                            <th>VolumenNegocio</th>
                        </tr>
        <?php
        $oDepartamento = $resultadoConsulta2->fetchObject(); // Obtengo el primer registro de la consulta como un objeto
        while ($oDepartamento) { // recorro los registros que devuelve la consulta de la consulta 
            ?>
                            <tr>
                                
                                <td><?php echo $oDepartamento->DescDepartamento; // obtengo el valor de la descripcion del departamento del registro actual  ?></td>
                            </tr>
                            <?php
                            $oDepartamento = $resultadoConsulta2->fetchObject(); // guardo el registro actual como un objeto y avanzo el puntero al siguiente registro de la consulta 
                        }
                        ?>
                    </table>    
                    <?php
                } catch (PDOException $excepcion) {//Codigo que se ejecuta si hay algun error
                    $errorExcepcion = $excepcion->getCode(); //Obtengo el codigo del error y lo almaceno en la variable errorException
                    $mensajeException = $excepcion->getMessage(); //Obtengo el mensaje del error y lo almaceno en la variable mensajeException

                    echo "<span style='color: red'>Codigo del error: </span>" . $errorExcepcion; //Muestro el codigo del error
                    echo "<span style='color: red'>Mensaje del error: </span>" . $mensajeException; //Muestro el mensaje del error
                } finally {
                    //Cierro la conexion
                    unset($miDB);
                }
            } else {// si hay algun campo de la entrada que este mal muestro el formulario hasta que esten bien todos los campos
                ?> 

                <form name="formulario" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form">
                    <fieldset>
                        <h2>Formulario de Busqueda de departamento</h2>
                        <ul>
                           
                            <!--Campo Alfabetico DescDepartamento OBLIGATORIO-->
                            <li>
                                <div>
                                    <label for="DescDepartamento"><strong>Descripcion Departamento*</strong></label>
                                    <input name="DescDepartamento" id="DescDepartamento" type="text" value="<?php echo isset($_REQUEST['DescDepartamento']) ? $_REQUEST['DescDepartamento'] : ''; ?>" placeholder="Introduzca la Descripcion del Departamento">
                                    <?php echo '<span>' . $aErrores['DescDepartamento'] . '</span>' ?>
                                </div>
                            </li>
                            
                            <!--Campo Boton Enviar-->
                            <li>
                                <input class="enviar" id="enviar" type="submit" name="enviar" value="Enviar"/>
                            </li>
                        </ul>
                    </fieldset>
                </form>
                <?php
            }
            ?>

    </body>
</html>