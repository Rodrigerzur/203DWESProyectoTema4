<!DOCTYPE html>
<html lang="es">
    <head>
        <title>indexProyectoTema4</title>
        <meta charset="UTF-8">
        <meta name="description" content="ejercicios DWES">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="webroot/css/bootstrap-4.1.2/bootstrap.min.css">
        <link href="webroot/plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="webroot/css/about.css">
        <link rel="stylesheet" type="text/css" href="webroot/css/about_responsive.css">
    </head>

    <body bgcolor="#FFFFFF" ondragstart="return false" onselectstart="return false">
        <div class="pagina">
            <div class="pagina2"></div>

            <!-- Header -->

            <header class="header">
                <div class="header_bar d-flex flex-row align-items-center justify-content-start">
                    <div class="header_list">
                        <ul class="d-flex flex-row align-items-center justify-content-start">
                            <li class="d-flex flex-row align-items-center justify-content-start">
                                <span>Rodrigo Geras</span>
                            </li>
                            <li class="d-flex flex-row align-items-center justify-content-start">
                                <div><img src="" alt=""></div>
                                <span>Rodrigo.gerzur@educa.jcyl.es</span>	
                            </li>
                            <div class="github">
                                <a href="https://github.com/Rodrigerzur/DWES">
                                    <img src="webroot/media/img/logoGit.png" alt="github">
                                </a>
                            </div>
                        </ul>
                    </div>
                </div>

                <!-- Navegador -->
                <div class="header_content d-flex flex-row align-items-center justify-content-start">
                    <div class="logo"><a href="#"><span>MENÚ</span></a></div>
                    <nav class="main_nav">
                        <ul class="d-flex flex-row align-items-start justify-content-start">
                            <li><a href="../index.php">Inicio</a></li>
                            <li class="active"><a href="../proyectoDWES/indexProyectoDWES.php">DWES</a></li>
                            <li><a href="">DIW</a></li>
                            <li><a href="">DWEC</a></li>
                            <li><a href="">EIE</a></li>
                            <li><a href="">DAW</a></li>
                        </ul>
                    </nav>
                    <div class="hamburger ml-auto"><i class="fa fa-bars" aria-hidden="true"></i></div>
                </div>

            </header>

            <!-- MenÃº a la derecha  -->

            <div class="menu text-right">
                <div class="menu_close"><i class="fa fa-times" aria-hidden="true"></i></div>
                <div class="menu_log_reg">
                    <nav class="menu_nav">
                        <ul>
                            <li><a href="../index.php">HOME</a></li>				
                            <li><a href="../proyectoDWES/indexProyectoDWES.php">DWES</a></li>
                            <li><a href="">DIW</a></li>
                            <li><a href="">DWEC</a></li>
                            <li><a href="">EIE</a></li>
                            <li><a href="">DAW</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Principal -->

            <div class="home">
                <div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="webroot/media/img/cat.jpeg" data-speed="0.8"></div>
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="home_content text-center">
                                <div class="home_title">DESARROLLO WEB EN ENTORNO SERVIDOR</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ejercicios -->

            <div class="services">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="section_title_container text-center">
                                <div class="section_subtitle">EJERCICIOS DEL</div>
                                <div class="section_title"><h1>TEMA 4: TÉCNICAS DE ACCESO A DATOS EN PHP</h1></div>
                            </div>
                        </div>
                    </div>
                    <div class="row services_row">

                        <!-- Ejercicio -->
                        <div class="col-xl-4 col-md-6">
                            <a href="codigoPHP/ejercicio01PDO.php">
                                <div class="service">
                                    <div class="mostrarejercicio" data-hover="MOSTRAR EL EJERCICIO">
                                        <div class="listing_image">
                                            <div class="listing_image_container">
                                                <h3>Conexión a la base de datos con la cuenta usuario y tratamiento de errores</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="mostrarcodigo/muestraEjercicio01PDO.php">
                                        <div class="mostrarcodigo" data-hover="MOSTRAR EL CODIGO">
                                            <div class="service_title_container d-flex flex-row align-items-center justify-content-start">
                                                <div class="service_title">
                                                    <h3>EJERCICIO 01</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </a>
                        </div>

                        <table>
                            <tr>
                                <td>Conexión a la base de datos con la cuenta usuario y tratamiento de errores.</td><td data-hover ="PDO"><a href="codigoPHP/ejercicio01PDO.php">Ejecutar</a></td><td><a href="mostrarcodigo/muestraEjercicio01PDO.php">Mostrar</a></td>
                                <td><a href="codigoPHP/ejercicio01PDO.php">Ejecutar</a></td><td><a href="mostrarcodigo/muestraEjercicio01PDO.php">Mostrar</a></td>
                            </tr>

                            <tr>
                                <td>Mostrar el contenido de la tabla Departamento y el número de registros.</td><td><a href="codigoPHP/ejercicio02PDO.php">Ejecutar</a></td><td><a href="mostrarcodigo/muestraEjercicio02PDO.php">Mostrar</a></td>
                                <td><a href="codigoPHP/ejercicio02PDO.php">Ejecutar</a></td><td><a href="mostrarcodigo/muestraEjercicio02PDO.php">Mostrar</a></td>
                            </tr>
                            <tr>
                                <td>Formulario para añadir un departamento a la tabla Departamento con validación de entrada y
                                    control de errores.<td colspan="2"><a href="codigoPHP/ejercicio03PDO.php">Ejecutar</a></td><td colspan="2"><a href="mostrarcodigo/muestraEjercicio03PDO.php">Mostrar</a></td>
                                </td>
                            </tr>
                            <tr>
                                <td>Formulario de búsqueda de departamentos por descripción</td><td colspan="2"><a href="codigoPHP/ejercicio04PDO.php">Ejecutar</a></td><td colspan="2"><a href="mostrarcodigo/muestraEjercicio04PDO.php">Mostrar</a></td>
                            </tr>
                            <tr>
                                <td>Pagina web que añade tres registros a nuestra tabla Departamento utilizando tres instrucciones
                                    insert y una transacción, de tal forma que se añadan los tres registros o no se añada ninguno.</td><td colspan="2"><a href="codigoPHP/ejercicio05PDO.php">Ejecutar</a></td><td colspan="2"><a href="mostrarcodigo/muestraEjercicio05PDO.php">Mostrar</a></td>
                            </tr>
                        </table>




                    </div>
                </div>
            </div>
            <!-- Footer -->

            <footer class="footer">	
                <div class="footer_bar">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="footer_bar_content d-flex flex-md-row flex-column align-items-md-center align-items-start justify-content-start">
                                    <div class="copyright order-md-1 order-2">
                                        2021-2022 Rodrigo Geras Zurrón</div>
                                    <nav class="footer_nav order-md-2 order-1 ml-md-auto">
                                        <ul class="d-flex flex-md-row flex-column align-items-md-center align-items-start justify-content-start">
                                            <li><a href="../index.php">Inicio</a></li>				
                                            <li><a href="../proyectoDWES/indexProyectoDWES.php">DWES</a></li>
                                            <li><a href="">DIW</a></li>
                                            <li><a href="">DWEC</a></li>
                                            <li><a href="">EIE</a></li>
                                            <li><a href="">DAW</a></li>
                                            <li><a href="https://github.com/Rodrigerzur/DWES">GITHUB</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Scripts varios -->
        <script src="webroot/js/jquery-3.3.1.min.js"></script>
        <script src="webroot/css/bootstrap-4.1.2/popper.js"></script>
        <script src="webroot/css/bootstrap-4.1.2/bootstrap.min.js"></script>
        <script src="webroot/plugins/parallax-js-master/parallax.min.js"></script>
        <script src="webroot/plugins/scrollmagic/ScrollMagic.min.js"></script>
        <script src="webroot/js/about.js"></script>

    </body>
</html>