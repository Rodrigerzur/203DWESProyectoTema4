<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio05 PDO</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            h2{
                font-family: sans-serif;
                font-size:2em;
                font-weight: bold;
                color: deepskyblue;
                border-bottom: 5px solid deepskyblue;
            }
            table{
                border-collapse: collapse;
            }
            td{
                border:1px solid #0056b3;
                text-align:center;
                padding:5px;
            }
            th{
                text-align:center;
                font-weight:bold;
                padding:5px;
            }
            span{
                color:red;
                font-weight: bold;
            }
            fieldset{

                width: 70%;
                background-color: rgba(45, 23, 143, 0.17);
                color:purple;
                font-family: sans-serif;
                font-weight: bold;
                font-size:1.2em;
                padding:20px;
                text-align: justify;
                border:5px solid black;
            }
            legend{
                color:Red;
                font-size: 1.5em;
                padding:5px;
                margin: auto;
            }
            fieldset input{
                background-color: white;
                padding: 0.3rem;
            }
        </style>
    </head>
    <body>
        <main>
            <?php
          //Incluir la libreria de funciones para la validacion
        require_once '../core/210322ValidacionFormularios.php';
        require_once '../config/confDBPDO.php'; //Archivo con configuracion de PDO
            
            /*
             * Definición de constantes para el parámetro "obligatorio"
             */
            define("OBLIGATORIO", 1);
            define("OPCIONAL", 0);

            /*
             * Inicialización del array de elementos del formulario.
             */
            $aFormulario = [
                'codDepartamento1' => '',
                'descDepartamento1' => '',
                'volumenNegocio1' => '',
                'codDepartamento2' => '',
                'descDepartamento2' => '',
                'volumenNegocio2' => '',
                'codDepartamento3' => '',
                'descDepartamento3' => '',
                'volumenNegocio3' => ''
            ];

            /*
             * Inicialización del array de errores.
             */
            $aErrores = [
                'codDepartamento1' => '',
                'descDepartamento1' => '',
                'volumenNegocio1' => '',
                'codDepartamento2' => '',
                'descDepartamento2' => '',
                'volumenNegocio2' => '',
                'codDepartamento3' => '',
                'descDepartamento3' => '',
                'volumenNegocio3' => ''
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
                $aErrores['codDepartamento1'] = validacionFormularios::comprobarAlfabetico($_REQUEST['codDepartamento1'], 3, 3, OBLIGATORIO);
                $aErrores['descDepartamento1'] = validacionFormularios::comprobarAlfanumerico($_REQUEST['descDepartamento1'], 255, 5, OBLIGATORIO);
                $aErrores['volumenNegocio1'] = validacionFormularios::comprobarFloat($_REQUEST['volumenNegocio1'], 5000, 0, OBLIGATORIO);
                $aErrores['codDepartamento2'] = validacionFormularios::comprobarAlfabetico($_REQUEST['codDepartamento2'], 3, 3, OBLIGATORIO);
                $aErrores['descDepartamento2'] = validacionFormularios::comprobarAlfanumerico($_REQUEST['descDepartamento2'], 255, 5, OBLIGATORIO);
                $aErrores['volumenNegocio2'] = validacionFormularios::comprobarFloat($_REQUEST['volumenNegocio2'], 5000, 0, OBLIGATORIO);
                $aErrores['codDepartamento3'] = validacionFormularios::comprobarAlfabetico($_REQUEST['codDepartamento3'], 3, 3, OBLIGATORIO);
                $aErrores['descDepartamento3'] = validacionFormularios::comprobarAlfanumerico($_REQUEST['descDepartamento3'], 255, 5, OBLIGATORIO);
                $aErrores['volumenNegocio3'] = validacionFormularios::comprobarFloat($_REQUEST['volumenNegocio3'], 5000, 0, OBLIGATORIO);
                
                /*
                 * Recorrido del array de errores
                 */
                foreach ($aErrores as $sCampo => $sError) {
                    if ($sError != null) {
                        $_REQUEST[$sCampo] = ''; //Limpieza del campo.
                        $bEntradaOK = false;
                    }
                }
                
            }
            
            /*
             * Si el formulario no ha sido enviado,
             * 
             */
            else {
                $bEntradaOK = false;
            }
            
            /*
             * Si el formulario ha sido enviado y no ha tenido errores
             * muestra la información enviada.
             */
            if ($bEntradaOK) {
                /*
                 * Recogida de la información enviada.
                 */
                $aFormulario['codDepartamento1'] = $_REQUEST['codDepartamento1'];
                $aFormulario['descDepartamento1'] = $_REQUEST['descDepartamento1'];
                $aFormulario['volumenNegocio1'] = $_REQUEST['volumenNegocio1'];
                $aFormulario['codDepartamento2'] = $_REQUEST['codDepartamento2'];
                $aFormulario['descDepartamento2'] = $_REQUEST['descDepartamento2'];
                $aFormulario['volumenNegocio2'] = $_REQUEST['volumenNegocio2'];
                $aFormulario['codDepartamento3'] = $_REQUEST['codDepartamento3'];
                $aFormulario['descDepartamento3'] = $_REQUEST['descDepartamento3'];
                $aFormulario['volumenNegocio3'] = $_REQUEST['volumenNegocio3'];
                
                /*
                 * Inserción en la base de datos.
                 */
                try{
                    // Conexión con la base de datos.
                    $myDB = new PDO(HOST, USER, PASSWORD);
                    
                    // Mostrado de las excepciones.
                    $myDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    // Queries de inserción.
                    $sInsert1 = <<<QUERY
                            INSERT INTO Departamento VALUES
                            ('{$aFormulario['codDepartamento1']}', '{$aFormulario['descDepartamento1']}', null, {$aFormulario['volumenNegocio1']});
                    QUERY;
                    $sInsert2 = <<<QUERY
                            INSERT INTO Departamento VALUES
                            ('{$aFormulario['codDepartamento2']}', '{$aFormulario['descDepartamento2']}', null, {$aFormulario['volumenNegocio2']});
                    QUERY;
                    $sInsert3 = <<<QUERY
                            INSERT INTO Departamento VALUES
                            ('{$aFormulario['codDepartamento3']}', '{$aFormulario['descDepartamento3']}', null, {$aFormulario['volumenNegocio3']});
                    QUERY;
                    
                    // Inicio de la transacción, deshabilita el autocommit.
                    $myDB->beginTransaction();
                            
                    /*
                     * Ejecución de los queries.
                     */
                    $iRegistros = $myDB->exec($sInsert1);
                    $iRegistros = $myDB->exec($sInsert2);
                    $iRegistros = $myDB->exec($sInsert3);
                    
                    /*
                     * Si no ha habido ningún error,
                     */
                    $myDB->commit();
                    
                    /*
                    * Mostrado del contenido recogido por el formulario
                    * en una tabla.
                    */
                   echo "<h2>Registros realizados:</h2>";
                   echo '<table class="showVariables">';
                   foreach ($aFormulario as $key => $value) {
                       echo '<tr>';
                       echo "<td>$key</td><td>$value</td>";
                       echo '</tr>';
                   }
                   echo '</table>';
                    
                }catch(PDOException $exception){
                    /*
                     * Si ha habido algún error, vuelve atrás.
                     */
                    $myDB->rollback();
                    /*
                     * Mostrado del código de error y su mensaje.
                     */
                    echo '<div>Se han encontrado errores:</div><ul>';
                    echo '<li>'.$exception->getCode().' : '.$exception->getMessage().'</li>';
                    echo '</ul>';
                }
                finally{
                    unset($myDB);
                }
                
            }
            
            /*
             * Si el formulario no ha sido enviado o ha tenido errores
             * muestra el formulario.
             */
            else {
                ?>
            
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <fieldset>
                    <legend>Primer registro</legend>
                    <!--Campo Alfabetico codDepartamento1 OBLIGATORIO -->
                                <div>
                                    <label for="codDepartamento1"><strong>Codigo Departamento*</strong></label>
                                    <input name="codDepartamento1" id="codDepartamento1" type="text" value="<?php echo isset($_REQUEST['codDepartamento1']) ? $_REQUEST['codDepartamento1'] : ''; ?>" placeholder="Introduzca el Codidog del Departamento">
                                    <?php echo '<span>' . $aErrores['codDepartamento1'] . '</span>' ?>
                                </div>
                            
                            <!--Campo Alfabetico descDepartamento1 OBLIGATORIO-->
                                <div>
                                    <label for="descDepartamento1"><strong>Descripcion Departamento*</strong></label>
                                    <input name="descDepartamento1" id="descDepartamento1" type="text" value="<?php echo isset($_REQUEST['descDepartamento1']) ? $_REQUEST['descDepartamento1'] : ''; ?>" placeholder="Introduzca la Descripcion del Departamento">
                                    <?php echo '<span>' . $aErrores['descDepartamento1'] . '</span>' ?>
                                </div>
                            <!--Campo Float VolumenNegocio OBLIGATORIO-->
                                <div>
                                    <label for="volumenNegocio1"><strong>Volumen Negocio*</strong></label>
                                    <input name="volumenNegocio1" id="volumenNegocio1" type="text" value="<?php echo isset($_REQUEST['volumenNegocio1']) ? $_REQUEST['volumenNegocio1'] : ''?>" placeholder="Introduzca el Volumen del Negocio del Departamento">
                                    <?php echo '<span>' . $aErrores['volumenNegocio1'] . '</span>' ?>
                                </div>
                </fieldset>
                <fieldset>
                    <legend>Segundo registro</legend>
                    <!--Campo Alfabetico codDepartamento2 OBLIGATORIO -->
                                <div>
                                    <label for="codDepartamento2"><strong>Codigo Departamento*</strong></label>
                                    <input name="codDepartamento2" id="codDepartamento2" type="text" value="<?php echo isset($_REQUEST['codDepartamento2']) ? $_REQUEST['codDepartamento2'] : ''; ?>" placeholder="Introduzca el Codidog del Departamento">
                                    <?php echo '<span>' . $aErrores['codDepartamento2'] . '</span>' ?>
                                </div>
                            
                            <!--Campo Alfabetico descDepartamento2 OBLIGATORIO-->
                                <div>
                                    <label for="descDepartamento2"><strong>Descripcion Departamento*</strong></label>
                                    <input name="descDepartamento2" id="descDepartamento2" type="text" value="<?php echo isset($_REQUEST['descDepartamento2']) ? $_REQUEST['descDepartamento2'] : ''; ?>" placeholder="Introduzca la Descripcion del Departamento">
                                    <?php echo '<span>' . $aErrores['descDepartamento2'] . '</span>' ?>
                                </div>
                            <!--Campo Float VolumenNegocio OBLIGATORIO-->
                                <div>
                                    <label for="volumenNegocio2"><strong>Volumen Negocio*</strong></label>
                                    <input name="volumenNegocio2" id="volumenNegocio2" type="text" value="<?php echo isset($_REQUEST['volumenNegocio2']) ? $_REQUEST['volumenNegocio2'] : ''?>" placeholder="Introduzca el Volumen del Negocio del Departamento">
                                    <?php echo '<span>' . $aErrores['volumenNegocio2'] . '</span>' ?>
                                </div>

                </fieldset>
                <fieldset>
                    <legend>Tercer registro</legend>
                    <!--Campo Alfabetico codDepartamento3 OBLIGATORIO -->
                                <div>
                                    <label for="codDepartamento3"><strong>Codigo Departamento*</strong></label>
                                    <input name="codDepartamento3" id="codDepartamento3" type="text" value="<?php echo isset($_REQUEST['codDepartamento3']) ? $_REQUEST['codDepartamento3'] : ''; ?>" placeholder="Introduzca el Codidog del Departamento">
                                    <?php echo '<span>' . $aErrores['codDepartamento3'] . '</span>' ?>
                                </div>
                            
                            <!--Campo Alfabetico descDepartamento3 OBLIGATORIO-->
                                <div>
                                    <label for="descDepartamento3"><strong>Descripcion Departamento*</strong></label>
                                    <input name="descDepartamento3" id="descDepartamento3" type="text" value="<?php echo isset($_REQUEST['descDepartamento3']) ? $_REQUEST['descDepartamento3'] : ''; ?>" placeholder="Introduzca la Descripcion del Departamento">
                                    <?php echo '<span>' . $aErrores['descDepartamento3'] . '</span>' ?>
                                </div>
                            <!--Campo Float VolumenNegocio OBLIGATORIO-->
                                <div>
                                    <label for="volumenNegocio3"><strong>Volumen Negocio*</strong></label>
                                    <input name="volumenNegocio3" id="volumenNegocio3" type="text" value="<?php echo isset($_REQUEST['volumenNegocio3']) ? $_REQUEST['volumenNegocio3'] : ''?>" placeholder="Introduzca el Volumen del Negocio del Departamento">
                                    <?php echo '<span>' . $aErrores['volumenNegocio3'] . '</span>' ?>
                                </div>

                    </table>
                </fieldset>
                <input type="submit" name="submit" id="submit">
            </form>
            
            <?php
            }
            
            function columnsNameRow($oResultadoConsulta){
                $iNumColumnas = $oResultadoConsulta->columnCount();
                echo '<tr>';
                for($iColumna = 0; $iColumna<$iNumColumnas ;$iColumna++){
                    echo "<th>".$oResultadoConsulta->getColumnMeta($iColumna)['name']."</th>";
                }
                echo '</tr>';
            }
            ?>
        </main>


    </body>
</html>