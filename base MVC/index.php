<?php

//Modo mantención
//echo $_SERVER['REMOTE_ADDR'];
//if($_SERVER['REMOTE_ADDR']!="186.67.23.234"){echo "En mantenimiento.... por favor vuelva m&aacute;s tarde.";exit();}

include("clases/sistema.php");

$sistema = new sistema();

//Solo para wp
//print_r($sistema->vista->globales);
if (isset($sistema->vista->globales['WPRutaRaiz']) && !empty($sistema->vista->globales['WPRutaRaiz'])) {
    if (is_readable($sistema->vista->globales['WPRutaRaiz'] . "wp-config.php")) { //Verificar si ruta de archivo existe
//    echo "<br/>wp existe";
        if (include($sistema->vista->globales['WPRutaRaiz'] . "wp-config.php")) {
//        echo "<br/>wp incluido";
            $wp->init();
            $wp->parse_request();
            $wp->query_posts();
            $wp->register_globals();
            $wp->send_headers();
//        echo "<br/>Cabecera de wp agregada";
            $resp = $wp;
        }
    }
}
//

$sistema->iniciar();
?>
