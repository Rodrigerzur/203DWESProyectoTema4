<!DOCTYPE html>
<html>
    <head>
        <title>EJECICIO08 PDO</title>
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
                
                $sql = "SELECT * from Departamento";
                
                $consulta = $miDB->prepare($sql); //Preparar la consulta
                $consulta->execute();//Ejecutarla
                
                $archivoXML = new DOMDocument("1.0", "utf-8"); //Objeto DOMDocument
                $archivoXML->formatOutput = true; //salida formateada
                
                $nodoDepartamentos = $archivoXML->appendChild($archivoXML->createElement("Departamentos"));//creacion del nodo "Departamentos"
                
                $registro =  $consulta->fetchObject();//
                while($registro){//Mientras el valor no sea null
                    $nodoDepartamento  = $nodoDepartamentos->appendChild($archivoXML->createElement("Departamento"));
                    
                    $nodoDepartamento->appendChild($archivoXML->createElement("CodDepartamento", $registro->CodDepartamento)); 
                    
                    $nodoDepartamento->appendChild($archivoXML->createElement("DescDepartamento", $registro->DescDepartamento)); 
                    
                    $nodoDepartamento->appendChild($archivoXML->createElement("FechaBaja", $registro->FechaBaja)); 
                    
                    $nodoDepartamento->appendChild($archivoXML->createElement("VolumenNegocio", $registro->VolumenNegocio)); 
                    
                    $registro =  $consulta->fetchObject();//Bucle para avanzar por la consulta
                }
                
                $archivoXML->save("../tmp/tablaDepartamento.xml");//Guardar el xml en un archivo dentro de la carpeta tmp
                
                echo "<h3> <span style='color: green;'>" . "Ningun problema encontrado </span></h3>";
        } catch (PDOException $excepcion) { //si se produce alguna excepción
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