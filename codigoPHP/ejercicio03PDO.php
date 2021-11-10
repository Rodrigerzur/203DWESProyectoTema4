<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ejercicio03PDO.php</title>
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
        <?php
//Incluir la libreria de funciones para la validacion
        require_once '../core/210322ValidacionFormularios.php';
        require_once '../config/confDBPDO.php'; //Archivo con configuracion de PDO
//Definir constantes que usare para determinar si una parte del formulario sera obligatoria para enviarlo o no
        define('OBLIGATORIO', 1);
        define('OPCIONAL', 0);

        //Variables maximos y minimos
        define("TAMANO_MAXIMO_CODDEPARTAMENTO", 3); //Maximo del campo CodDepartamento
        define("TAMANO_MINIMO_CODDEPARTAMENTO", 3); //Minimo del campo CodDepartamento
        define("TAMANO_MAXIMO_DESCDEPARTAMENTO", 255); //Maximo del campo DescDepartamento
        define("TAMANO_MINIMO_DESCDEPARTAMENTO", 0); //Minimo del campo DescDepartamento
        define("TAMANO_MAXIMO_VOLUMENNEGOCIO", 3.402823466E+38); //Maximo del campo VolumenNegocio
        define("TAMANO_MINIMO_VOLUMENNEGOCIO", 0); //Minimo del campo VolumenNegocio
        //Inicializacion del array de errores con todos los campos del formulario a validar
        $aErrores = ["DescDepartamento" => null,
            "CodDepartamento" => null,
            "volumenNegocio" => null];

//Varible de entrada correcta inicializada a true
        $entradaOK = true;
//Array de respuestas inicializado a null
        $aRespuestas = ["DescDepartamento" => null,
            "CodDepartamento" => null,
            "volumenNegocio" => null];

        //Comprobar si se ha pulsado el boton enviar en el formulario
        if (isset($_REQUEST['enviar'])) {
            //Comprobar si el campo CodDepartamento esta bien rellenado
            $aErrores['CodDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['CodDepartamento'], TAMANO_MAXIMO_CODDEPARTAMENTO, TAMANO_MINIMO_CODDEPARTAMENTO, OBLIGATORIO);
            //Realizo un if para solo comprobar si existe el codigo, si ha sido nulo ya no es necesario entrar a comprobar si se encuentra
            if ($aErrores['CodDepartamento'] == null) {
                //Realizo la conexion
                try {
                    //Hago la conexion con la base de datos
                    $miDB = new PDO(HOST, USER, PASSWORD);
                    // Establezco el atributo para la aparicion de errores con ATTR_ERRMODE y le pongo que cuando haya un error se lance una excepcion con ERRMODE_EXCEPTION
                    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    //Creo el SELECT de la tabla departamento con un WHERE y el codigo de departamento pasado en el formulario
                    $consulta = "SELECT CodDepartamento FROM Departamento WHERE CodDepartamento='{$_REQUEST['CodDepartamento']}'";
                    $resultadoConsulta = $miDB->prepare($consulta); //preparo la consulta

                    $resultadoConsulta->execute(); //ejecuto la consulta

                    if ($resultadoConsulta->rowCount() > 0) {//Compruebo si el valor que devuelve la consulta es mayor que 0, si es mayor que 0 el codigo de departamento ya existe
                        $aErrores['CodDepartamento'] = "El codigo de departamento introducido ya existe."; //Muestro un mensaje de error en el array de errores del codigo del departamento
                    }
                } catch (PDOException $excepcion) {//Codigo que se ejecuta si hay algun error
                    $errorExcepcion = $excepcion->getCode(); //Obtengo el codigo del error y lo almaceno en la variable errorException
                    $mensajeException = $excepcion->getMessage(); //Obtengo el mensaje del error y lo almaceno en la variable mensajeException

                    echo "<span style='color: red'>Codigo del error: </span>" . $errorExcepcion; //Muestro el codigo del error
                    echo "<span style='color: red'>Mensaje del error: </span>" . $mensajeException; //Muestro el mensaje del error
                } finally {
                    //Cierro la conexion
                    unset($miDB);
                }
            }
            //Comprobar si el campo DescDepartamento esta bien rellenado
            $aErrores['DescDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['DescDepartamento'], TAMANO_MAXIMO_DESCDEPARTAMENTO, TAMANO_MINIMO_DESCDEPARTAMENTO, OBLIGATORIO);
            //Comprobar si el campo es un float
            $aErrores['volumenNegocio'] = validacionFormularios::comprobarFloat($_REQUEST['volumenNegocio'], TAMANO_MAXIMO_VOLUMENNEGOCIO, TAMANO_MINIMO_VOLUMENNEGOCIO, OBLIGATORIO);

            foreach ($aErrores as $campos => $value) {
                //Comprobar si el campo ha sido rellenado
                if ($value != null) {
                    $_REQUEST[$campos] = "";
                    $entradaOK = false;
                }
            }
        } else {
            $entradaOK = false;
        }
        if($entradaOK){ //Si la entrada es true recojo los valores del array aRespuestas
                $aRespuestas['CodDepartamento'] = strtoupper($_REQUEST['CodDepartamento']); // strtoupper() transforma los caracteres de un string a mayuscula
                $aRespuestas['DescDepartamento'] = $_REQUEST['DescDepartamento']; 
                $aRespuestas['volumenNegocio'] = $_REQUEST['volumenNegocio'];
            //Mostrar datos

             echo "<h2>Contenido tabla Departamento</h2>";
                try{
                    //Hago la conexion con la base de datos
                    $miDB = new PDO(HOST, USER, PASSWORD);
                    //Establezco el atributo para la aparicion de errores con ATTR_ERRMODE y le pongo que cuando haya un error se lance una excepcion con ERRMODE_EXCEPTION
                    $miDB -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                           
                    //INSERCION DE DATOS EN DEPARTAMENTOS
                    //Creacion de la consulta que inserta los datos en Departamento
                    $consultaInsertar = <<<CONSULTA
                            INSERT INTO Departamento(CodDepartamento,DescDepartamento,VolumenNegocio) VALUES 
                            (:CodDepartamento, :DescDepartamento,:VolumenNegocio);
                            CONSULTA;
                    $ejecutarConsulta=$miDB->prepare($consultaInsertar); //Preparo la consulta antes de ejecutarla
                    //Creo un array con los parametros que hay que insertar obtenidos del array de respuestas
                    $parametros = [ ":CodDepartamento" => $aRespuestas['CodDepartamento'],
                                    ":DescDepartamento" => $aRespuestas['DescDepartamento'],
                                    ":VolumenNegocio" => $aRespuestas['volumenNegocio'] ];
                    
                    $ejecutarConsulta->execute($parametros); //Ejecuto la consulta pasando los parametros del array de parametros
                    
                    //MUESTRA DE LA TABLA DEPARTAMENTOS
                    $sqlmostrar="SELECT * FROM Departamento";
                    $resultadoConsulta2=$miDB->prepare($sqlmostrar); //Preparo la consulta
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
                            while($oDepartamento) { // recorro los registros que devuelve la consulta de la consulta ?>
                        <tr>
                            <td><?php echo $oDepartamento->CodDepartamento; // obtengo el valor del codigo del departamento del registro actual ?></td>
                            <td><?php echo $oDepartamento->DescDepartamento; // obtengo el valor de la descripcion del departamento del registro actual ?></td>
                            <td><?php echo $oDepartamento->FechaBaja; // obtengo el valor de la fecha de baja del departamento del registro actual ?></td>
                            <td><?php echo $oDepartamento->VolumenNegocio; // obtengo el valor de la fecha de baja del departamento del registro actual ?></td>
                        </tr>
                        <?php 
                            $oDepartamento = $resultadoConsulta2->fetchObject(); // guardo el registro actual como un objeto y avanzo el puntero al siguiente registro de la consulta 
                        }
                        ?>
                    </table>    
                    <?php
                }catch(PDOException $excepcion){//Codigo que se ejecuta si hay algun error
                    $errorExcepcion = $excepcion->getCode();//Obtengo el codigo del error y lo almaceno en la variable errorException
                    $mensajeException = $excepcion->getMessage();//Obtengo el mensaje del error y lo almaceno en la variable mensajeException

                    echo "<span style='color: red'>Codigo del error: </span>" . $errorExcepcion;//Muestro el codigo del error
                    echo "<span style='color: red'>Mensaje del error: </span>" . $mensajeException;//Muestro el mensaje del error
                }finally{
                    //Cierro la conexion
                    unset($miDB);
                }
            }else{// si hay algun campo de la entrada que este mal muestro el formulario hasta que esten bien todos los campos
            ?> 
            
            <form name="formulario" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form">
                    <fieldset>
                        <h2>Formulario de Nuevo Departamento</h2>
                        <ul>
                            <!--Campo Alfabetico CodDepartamento OBLIGATORIO -->
                            <li>
                                <div>
                                    <label for="CodDepartamento"><strong>Codigo Departamento*</strong></label>
                                    <input name="CodDepartamento" id="CodDepartamento" type="text" value="<?php echo isset($_REQUEST['CodDepartamento']) ? $_REQUEST['CodDepartamento'] : ''; ?>" placeholder="Introduzca el Codidog del Departamento">
                                    <?php echo '<span>' . $aErrores['CodDepartamento'] . '</span>' ?>
                                </div>
                            </li>
                            <!--Campo Alfabetico DescDepartamento OBLIGATORIO-->
                            <li>
                                <div>
                                    <label for="DescDepartamento"><strong>Descripcion Departamento*</strong></label>
                                    <input name="DescDepartamento" id="DescDepartamento" type="text" value="<?php echo isset($_REQUEST['DescDepartamento']) ? $_REQUEST['DescDepartamento'] : ''; ?>" placeholder="Introduzca la Descripcion del Departamento">
                                    <?php echo '<span>' . $aErrores['DescDepartamento'] . '</span>' ?>
                                </div>
                            </li>
                            <!--Campo Float VolumenNegocio OBLIGATORIO-->
                            <li>
                                <div>
                                    <label for="volumenNegocio"><strong>Volumen Negocio*</strong></label>
                                    <input name="volumenNegocio" id="volumenNegocio" type="text" value="<?php echo isset($_REQUEST['volumenNegocio']) ? $_REQUEST['volumenNegocio'] : ''?>" placeholder="Introduzca el Volumen del Negocio del Departamento">
                                    <?php echo '<span>' . $aErrores['volumenNegocio'] . '</span>' ?>
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
