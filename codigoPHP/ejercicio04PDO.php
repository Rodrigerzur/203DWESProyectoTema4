<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejercicio04PDO</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body{
              
            }
            h2{
                font-family: sans-serif;
                font-size:2em;
                font-weight: bold;
                color: deepskyblue;
                border-bottom: 5px solid deepskyblue;
            }
            table{
                text-align: center;
                border-collapse: collapse;
                margin:auto;
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
            form{
                display: inline-block;
                margin:auto;
            }
            fieldset{

                width: 100%;
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
            ///Incluir la libreria de funciones para la validacion
        require_once '../core/210322ValidacionFormularios.php';
        require_once '../config/confDBPDO.php'; //Archivo con configuracion de PDO
            
            //Variable OPCIONAL inicializada a 0
            define("OPCIONAL", 0);
            
            //Variables maximos y minimos
            define("TAMANO_MAXIMO_DESCDEPARTAMENTO",255);
            
            //Variable de entrada correcta inicializada a true
            $entradaOK = true;
            
            //Creo el array de errores y lo inicializo a null
            $aErrores = [
                'descDepartamento' => null
            ];
            
            //Creo el array de respuestas y lo incializo a null
            $aRespuestas = [
                'descDepartamento' => null
            ];
            
            //Comprobar si se ha pulsado el boton enviar en el formulario
            if (isset($_REQUEST['enviar'])) {
                //Comprobar si el campo DescDepartamento esta bien rellenado
                $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['descDepartamento'], TAMANO_MAXIMO_DESCDEPARTAMENTO, OPCIONAL);
                
                //Comprobar si algun campo del array de errores ha sido rellenado
                foreach ($aErrores as $campo => $error) {//recorro el array errores
                    if ($error != null) {//compruebo si hay algun error
                        $_REQUEST[$campo] = '';//limpio el campo
                        $entradaOK = false;//
                    }
                }
            } else {//si el usuario no le ha dado a enviar
                $entradaOK = false;
            }
              
            if($entradaOK){ // si la entrada es true recojo los valores del array aRespuestas
                $aRespuestas['descDepartamento'] = $_REQUEST['descDepartamento'];
            
                echo "<h2>Datos introducidos</h2>";
                echo "<p>Descripcion departamento a buscar: " . $aRespuestas['descDepartamento'] . "</p>";
                
                echo "<h2>Contenido tabla Departamento</h2>";
                //Realizo la conexion
                try{
                    //conexion con la base de datos
                    $miDB = new PDO(HOST, USER, PASSWORD);
                    $miDB -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                           
                 
                    $consulta = "SELECT * FROM Departamento WHERE DescDepartamento LIKE '%{$aRespuestas['descDepartamento']}%';";
                            
                    $resultadoConsulta=$miDB->prepare($consulta); // Preparo la consulta 
                    
                    $parametros = [":DescDepartamento" => $aRespuestas['descDepartamento']];
                    
                    $resultadoConsulta->execute($parametros); // Ejecuto la consulta 
                    
                       
                    if($resultadoConsulta->rowCount() > 0){ //Si devuelve algun registro
                        ?>
                        <table>
                            <tr>
                                <th>CodDepartamento</th>
                                <th>DescDepartamento</th>
                                <th>FechaBaja</th>
                                <th>VolumenNegocio</th>
                            </tr>
                            <?php 
                                $oDepartamento = $resultadoConsulta->fetchObject(); // Obtengo el primer registro de la consulta 
                                while($oDepartamento) { // recorro los registros ?>
                            <tr>
                                <td><?php echo $oDepartamento->CodDepartamento;  ?></td>
                                <td><?php echo $oDepartamento->DescDepartamento;  ?></td>
                                <td><?php echo $oDepartamento->FechaBaja;  ?></td>
                                <td><?php echo $oDepartamento->VolumenNegocio;  ?></td>
                            </tr>
                            <?php 
                                $oDepartamento = $resultadoConsulta->fetchObject(); // guardo el registro actual como un objeto y avanzo el puntero al siguiente registro de la consulta 
                            }
                            ?>
                        </table>
                        <?php
                    }else{
                        echo "<p>No se ha encontrado ningun departamento con esa descripcion.</p>";
                        
                      
                    }
                }catch (PDOException $excepcion) { //si se produce alguna excepción
                    $errorExcepcion = $excepcion->getCode(); //Guardar el código del error 
                    $mensajeExcepcion = $excepcion->getMessage(); //Guardar el mensaje de la excepcion

                    echo "<span>Error: </span>" . $mensajeExcepcion . "<br>"; //mensaje de la excepción
                    echo "<span>Código del error: </span>" . $errorExcepcion; //código de la excepción
                } finally {
                    unset($miDB); //Cerrar la conexion 
                }
            }else{// muestra el formulario hasta que esten bien todos los campos
            ?>
            
            <form name="formulario" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form">
                    <fieldset>
                        <legend>Busqueda de un departamento</legend>
                          
                                <div>
                                    <label for="descDepartamento"><strong>Descripcion Departamento</strong></label>
                                    <input name="descDepartamento" id="descDepartamento" type="text" value="<?php echo isset($_REQUEST['descDepartamento']) ? $_REQUEST['descDepartamento'] : ''; ?>" placeholder="Introduzca la Descripcion del Departamento">
                                    <?php echo '<span>' . $aErrores['descDepartamento'] . '</span>' ?>
                                </div>
                
                                <input class="enviar" id="enviar" type="submit" name="enviar" value="Enviar"/>
                         
                    </fieldset>
                </form>
            <?php
            }
            ?>
        </main>
    </body>
</html>