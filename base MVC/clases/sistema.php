<?php

include("sistema/config.php");
include(carpetaClases."bd.php");
include(carpetaClases."modelo.php");
include(carpetaClases."controlador.php");
include(carpetaClases."formularios.php");
include(carpetaClases."Browser.php");

$objBd=new BD();
$objForm = new formularios();

$objBd->limpiarTodo();

class sistema extends controlador{
    
    public $error="";
    
    function __construct() {
        if (!isset($_GET[nomParamControlador]) || empty($_GET[nomParamControlador])) { //Saber si no se recibió controlador
            $_GET[nomParamControlador] = controladorPorDefecto;
            if (debug == true) {
                echo "<br/>- No hay controlador. Cargando controlador por defecto: ".$_GET[nomParamControlador];
            }
        }
        $this->obtenerGlobales();
    }
    
    function iniciar(){
        
        global $objForm;
        
        //Verificar si solicita un módulo
        $nombreModulo="";
        $rutaModulo="";
        
        if(isset($_GET[nomParamModulo]) && !empty($_GET[nomParamModulo])){
//            controlador::$rutaModulo=carpetaModulos . $_GET[nomParamModulo] . "/";
            $rutaModulo=carpetaModulos . $_GET[nomParamModulo] . "/";
            $nombreModulo=$_GET[nomParamModulo];
        }
        
//        echo "<br/>ruta modulo: ".controlador::$rutaModulo;
        
        $cargaSeccion=true;
        $forzarVista=false;
        
        if (isset($_GET[nomParamVista]) && !empty($_GET[nomParamVista])) {
            $forzarVista=$_GET[nomParamVista];
            $ruta = $objForm->obtenerRutaServidor(true). $rutaModulo . carpetaVistas . prefijoVistas . $_GET[nomParamVista].".php";
            if(!is_readable($ruta)){
                $cargaSeccion=false;
            }
        }
        
        if (!$cargaSeccion || !$objControlador=$this->cargarControlador($_GET[nomParamControlador], false, $nombreModulo, $forzarVista)) {
            if (debug == true) {
                if(!$cargaSeccion){
                    echo "<br/>- seccion '$ruta' no existe. Cargando página 404";
                }else{
                    echo "<br/>- Controlador '".$_GET[nomParamControlador]."' no existe. Cargando página 404";
                }
            }
            $this->cargarVista("404", carpetaVistasBase, true);
//            $this->error.="Error: No se pudo cargar controlador '" . $_GET[nomParamControlador] . "'";
        }
//        if(!empty($this->error)){
//            echo "<br/>- Error: ".$this->error;
//        }
    }
}

?>
