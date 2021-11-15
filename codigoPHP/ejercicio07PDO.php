<!Doctype HTML>
<html>
    <head>
        <title>EJERCICIO07 PDO</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            span{
                color:red;
            }
        </style>

    </head>
    <body>

        <?php
        require_once '../config/confDBPDO.php'; //Archivo con configuracion de PDO

        try {
            //Hago la conexion con la base de datos
            $miDB = new PDO(HOST, USER, PASSWORD);
            //Establezco el atributo para la aparicion de errores con ATTR_ERRMODE y le pongo que cuando haya un error se lance una excepcion con ERRMODE_EXCEPTION
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = <<<HER
            Insert into Departamento values
            (:CodDepartamento, :DescDepartamento, :FechaBaja, :VolumenNegocio);
            HER;


            $consulta = $miDB->prepare($sql); //Preparar la consulta

            $archivoXML = new DOMDocument("1.0", "utf-8"); //Objeto DOMDocument
            $archivoXML->load('../tmp/tablaDepartamento.xml'); //Cargamos el documento XML

            $numeroDepartamentos = $archivoXML->getElementsByTagName('Departamento')->count(); //Contamos y guardamos el número de departamentos
            
            for ($numeroDepartamento = 0; $numeroDepartamento < $numeroDepartamentos; $numeroDepartamento++) {
                    //Recorremos los departamentos que tenemos en la BD
                $CodDepartamento = $archivoXML->getElementsByTagName("CodDepartamento")->item($numeroDepartamento)->nodeValue;
               //Guardar valores
                $DescDepartamento = $archivoXML->getElementsByTagName("DescDepartamento")->item($numeroDepartamento)->nodeValue;
                //Guardar valores               
                $FechaBaja = $archivoXML->getElementsByTagName("FechaBaja")->item($numeroDepartamento)->nodeValue;
                //Guardar valores
                if (empty($FechaBaja)) {//Si el elemento de la feha de baja está vacío
                    $FechaBaja = null; //Le asignamos el valor de null para que no de error a la hora de insertar en la base de datos
                }
                $VolumenNegocio = $archivoXML->getElementsByTagName("VolumenNegocio")->item($numeroDepartamento)->nodeValue; //Guardar valores
                //Rellenar el array con los valores que teniamos
                $parametros = [":CodDepartamento" => $CodDepartamento,
                    ":DescDepartamento" => $DescDepartamento,
                    ":FechaBaja" => $FechaBaja,
                    ":VolumenNegocio" => $VolumenNegocio];
                $consulta->execute($parametros); //Ejecutamos la consulta con los parámetros
            }
            echo "<h3> <span style='color: green;'>" . "Ningun problema encontrado </span></h3>";
        } catch (PDOException $excepcion) { //Código por si se produce alguna excepción
            $errorExcepcion = $excepcion->getCode(); //Guardar el código del error 
            $mensajeExcepcion = $excepcion->getMessage(); //Guardar el mensaje de la excepcion

            echo "<span>Error: </span>" . $mensajeExcepcion . "<br>"; //mensaje de la excepción
            echo "<span>Código del error: </span>" . $errorExcepcion; //código de la excepción
        } finally {
            unset($miDB); //Cerrar la conexion 
        }
        ?>
    </body>

</html> 