<?php

class controlador {

    public $error;
    public $modelo;
    public $vista;
    public $rutaModulo = "";

    function obtenerGlobales() {
        global $objForm;

        include($objForm->obtenerRutaServidor(true) . "sistema/settings.php");

        $this->vista->globales = null;
//        echo "globales: ".print_r($globales,true);

        $respaldoGetControlador = $_GET[nomParamControlador];
        
        if (isset($_GET[nomParamControlador])) {
            if ($_GET[nomParamControlador] == controladorPorDefecto) {
                // Para cargar vistas estáticas de forma rápida, usando este mismo controlador
                if (isset($_GET[nomParamVista]) && !empty($_GET[nomParamVista])) {
                    $_GET[nomParamControlador] = $_GET[nomParamVista];
                }
            }
        }

        /* Obtener todalidad de globales de settings */
        if (isset($globales) and is_array($globales)) {
            foreach ($globales as $key => $value) {
                $this->vista->globales[$key] = $value;
            }
        }
        /* Fin Globales de settings */

        /* Globales base */
        $this->vista->globales['thispage'] = $_GET[nomParamControlador];
        $this->vista->globales['rutaBase'] = "";
        $this->vista->globales['rutaVistas'] = $objForm->obtenerRutaSitio(true) . carpetaVistas;
        $this->vista->globales['actionForm'] = "";
        $this->vista->globales['actionBaseForm'] = "";

        if (isset($_GET[nomParamModulo]) && !empty($_GET[nomParamModulo])) {
            $this->vista->globales['actionForm'].=nomParamModulo . "=" . $_GET['m'];
            $this->vista->globales['actionBaseForm'] = $this->vista->globales['actionForm'];
            $this->vista->globales['thispage'] = $_GET[nomParamModulo];
        }

        if (isset($respaldoGetControlador) && !empty($respaldoGetControlador)) {
            if (!empty($this->vista->globales['actionForm'])) {
                $this->vista->globales['actionForm'].="&";
            }
            $this->vista->globales['actionForm'].=nomParamControlador . "=" . $respaldoGetControlador;
        }

        if (isset($_GET[nomParamVista]) && !empty($_GET[nomParamVista])) {
            if (!empty($this->vista->globales['actionForm'])) {
                $this->vista->globales['actionForm'].="&";
            }
            $this->vista->globales['actionForm'].=nomParamVista . "=" . $_GET[nomParamVista];
        }

        $this->vista->globales['actionForm'] = "index.php?" . $this->vista->globales['actionForm'];
        if (!empty($this->vista->globales['actionBaseForm'])) {
            $this->vista->globales['actionBaseForm'] = "index.php?" . $this->vista->globales['actionBaseForm'];
        }
        /* Fin Globales base */

        /* Obtener globales del módulo cargado */
        if (isset($_GET[nomParamModulo]) && !empty($_GET[nomParamModulo])) { //Revisar si estamos dentro de un módulo
            if (isset($globales[$_GET[nomParamModulo]]) and is_array($globales[$_GET[nomParamModulo]])) {
                foreach ($globales[$_GET[nomParamModulo]] as $key => $value) {
                    $this->vista->globales[$key] = $value;
                }
            }

            $this->vista->globales['rutaBaseModulo'] = carpetaModulos . $_GET[nomParamModulo] . "/";
            $this->vista->globales['rutaVistasModulo'] = $objForm->obtenerRutaSitio(true) . carpetaModulos . $_GET[nomParamModulo] . "/" . carpetaVistas;

            /* Revisar y obtener settings propio del módulo */
            if (file_exists($this->vista->globales['rutaBaseModulo'] . "settings.php")) { //Reviso si el archivo settings existe en el módulo
                include($this->vista->globales['rutaBaseModulo'] . "settings.php");

                //Leo las variables y las agrego a los globales
                if (isset($globales[$_GET[nomParamModulo]]) and is_array($globales[$_GET[nomParamModulo]])) {
                    foreach ($globales[$_GET[nomParamModulo]] as $key => $value) {
                        $this->vista->globales[$key] = $value;
                    }
                }
            }
            /* Fin revisar y obtener settings propio del módulo */
        }
        /* Fin Obtener globales del módulo cargado */

        if (isset($respaldoGetControlador) && !empty($respaldoGetControlador)) {
            // Para cargar vistas estáticas de forma rápida, usando este mismo controlador
            $_GET[nomParamControlador] = $respaldoGetControlador;
        }
    }

    protected function cargarControlador($elemento = false, $forzarNativo = false, $moduloNombre = false, $forzarVista = false) {

        $resp = false;

        global $objForm;

        $this->error = "";

        $rutaModulo = "";

        if ($forzarNativo) {
//            $this->rutaModulo2 = "no";
            $ruta = $objForm->obtenerRutaServidor(true) . carpetaControladores . prefijoControladores . $elemento . ".php";
        } else {

            if ($moduloNombre) {
                $rutaModulo = carpetaModulos . $moduloNombre . "/";
//                $respaldoControlador=$_GET[nomParamControlador];
//                $_GET[nomParamControlador]=$elemento;
            }

            $ruta = $objForm->obtenerRutaServidor(true) . $rutaModulo . carpetaControladores . prefijoControladores . $elemento . ".php";
        }

//        echo "<br/>ruta controlador: ".$ruta;

        if ($elemento && is_readable($ruta)) { //Revisar si existe el controlador
            require_once $ruta; //incluyo el archivo del controlador
            $nomClase = prefijoControladores . $elemento;
            if (class_exists($nomClase)) {
                if (debug == true) {
                    echo "<br/>- Cargando controlador '" . $ruta . "'";
                    if ($moduloNombre) {
                        echo " del módulo '" . $moduloNombre . "'";
                    }
                }
                $obj = new $nomClase($forzarNativo); //instancio objeto de controlador
                $obj->obtenerGlobales();
                $obj->rutaModulo = "";
                if ($forzarVista && !empty($forzarVista)) {
                    if (debug == true) {
                        echo "<br/>- Cargando seccion '" . $forzarVista . "'";
                    }
                    $obj->controlador = $forzarVista;
                } else {
                    $obj->controlador = $elemento;
                }

                if ($moduloNombre) {
                    if ($forzarNativo) {
                        $rutaModulo = carpetaModulos . $moduloNombre . "/";
                    }

                    $obj->rutaModulo = $rutaModulo;
                }
                $obj->iniciar();
//                if ($forzarNativo) {
//                    $obj->rutaModulo2 = "no";
//                } else {
//                    $obj->rutaModulo2 = "";
//                }
                $resp = $obj;
            } else {
                if (debug == true) {
                    $this->error.="<br/>- Error: Nombre de clase de controlador inválida";
                }
            }
        } else {
            if (debug == true) {
                $this->error.="<br/>- Error: No existe controlador '" . $ruta . "'";
            }
        }

        if (!empty($this->error)) {
            echo $this->error;
        }

        return $resp;
    }

    protected function cargarModelo($elemento = false, $forzarNativo = false) {

        $resp = false;

        global $objForm;

        $this->error = "";

        if ($forzarNativo) {
//            $this->rutaModulo2 = "no";
            $ruta = $objForm->obtenerRutaServidor(true) . carpetaModelos . prefijoModelos . $elemento . ".php";
        } else {
            $ruta = $objForm->obtenerRutaServidor(true) . $this->rutaModulo . carpetaModelos . prefijoModelos . $elemento . ".php";
        }

//        echo "<br/>ruta modelo: ".$ruta;

        if ($elemento && is_readable($ruta)) { //Revisar si existe el controlador
            require_once $ruta; //incluyo el archivo del controlador
            $nomClase = prefijoModelos . $elemento;

            if (class_exists($nomClase)) {
                if (debug == true) {
                    echo "<br/>- Cargando modelo '" . $ruta . "'";
                }
                $obj = new $nomClase($forzarNativo); //instancio objeto de controlador
                $obj->vista->globales = $this->vista->globales;
                $resp = $obj;
            } else {
                if (debug == true) {
                    $this->error.="<br/>- Error: Nombre de clase de modelo inválida";
                }
            }
        } else {
            if (debug == true) {
                $this->error.="<br/>- Error: No existe modelo '" . $ruta . "'";
            }
        }

        if (!empty($this->error)) {
            echo $this->error;
        }

        return $resp;
    }

    protected function cargarVista($elemento = false, $rutaPersonalizada = "", $forzarNativo = false) {

        $resp = false;

        global $objForm;

        $this->error = "";

        if (isset($this->seccion) && !empty($this->seccion)) {
            $elemento = $this->seccion;
        }

        if ($forzarNativo) {
            $ruta = $objForm->obtenerRutaServidor(true) . carpetaVistas . $rutaPersonalizada . prefijoVistas . $elemento . ".php";
        } else {
            $ruta = $objForm->obtenerRutaServidor(true) . $this->rutaModulo . carpetaVistas . $rutaPersonalizada . prefijoVistas . $elemento . ".php";
        }

//        echo "<br/>ruta vista: ".$ruta;

        if ($elemento && is_readable($ruta)) { //Revisar si existe el controlador
//            ob_start();
            if (debug == true) {
                echo "<br/>- Cargando vista '" . $ruta . "'";
            }
            require_once $ruta; //incluyo el archivo del controlador
//        echo "require_once: ".$ruta;exit();
//            $contenidoVista = ob_get_contents();
//            ob_end_clean();
            //Aplicar rutas a href, src, includes, include_once, require y require_once
//            <link type="text/css" rel="stylesheet" media="screen" href="css/style.css"/>
//            $contenidoVista=preg_replace("/(\<link.*href=(\"|\')|src=(\"|\'))/", '$0'.$objForm->obtenerRutaSitio(true).self::$rutaModulo . carpetaVistas . $rutaPersonalizada . prefijoVistas, $contenidoVista);
//            echo $contenidoVista;

            /* $nomClase = prefijoVistas . $elemento;

              if (class_exists($nomClase)) {
              $obj = new $nomClase; //instancio objeto de controlador
              $resp = $obj;
              } else {
              //                $this->error.="<br/>- Error: Nombre de clase de vista inválida";
              } */
        } else {
            if (debug == true) {
                $this->error.="<br/>- Error: No existe vista '" . $ruta . "'";
            }
        }

        if (!empty($this->error)) {
            echo $this->error;
        }

        return $resp;
    }

}

?>
