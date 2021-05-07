<?
global $objForm;
/* 	==========================================================================
  Version: 2.0 | 1.0.2.20140130
  ========================================================================== */

/* 	-------------------------------------------------------------------------- 	
  DEFINICIONES
  -------------------------------------------------------------------------- */

$globales['marca'] = "4sale";           //Escribir la marca, que se utilizará en todas las funcionalidades necesarias, como envío de correos, o impresión en las vistas.
$globales['responsivo'] = "no";           //Escribir "si" para habillitar las caracteristicas responsivas, de lo contrario utilizará la visualización normal.	
$globales['opengraph'] = "si";            //Escribir "si" para habilitar las caracteristicas de compartir con FB
$globales['OGapp_id'] = "";            //ID de la APP FB
$globales['OGadmin_id'] = "";            //Poner su identificacion de FB aqui 
$globales['metadescription'] = "";          //Escribir la descripcion global del sitio
$globales['metakeyworks'] = "";           //Escribir los keywords globales del sitio
$globales['elcodigoAnalytics'] = "<script>Código analytics</script>";         //Poner el codigo analytics aqui
$globales['WPRutaRaiz'] = "../wordprestest/";         //Ruta de wordpress (Si es necesario)
$globales['PSRutaRaiz'] = "../prestashops/prestashop_1_5_2/";         //Ruta de prestashop (Si es necesario)


/* 	-------------------------------------------------------------------------- 	
  TEXTOS PARTICULARES
  -------------------------------------------------------------------------- */

/*Primera posición del arreglo, es el nombre del controlador. Se puede modificar en objeto "Header".*/

//SI ES "INDEX"
$globales['index']['tituloPagina'] = "INDEX";
$globales['index']['descOGpagina'] = "poner la descripcion de la pagina aca";
$globales['index']['imagenOGpagina'] = $objForm->obtenerRutaSitio()."img/opengraph.jpg";
$globales['index']['metadescription'] = $objForm->setVariable($globales['metadescription'], "descripcion de la página index");
$globales['index']['metakeyworks'] = $objForm->setVariable($globales['metakeyworks'], "keywords, de, la, página, index");


//SI ES "PAGINA 2"
$globales['pagina2']['tituloPagina'] = "Página 2";
$globales['pagina2']['descOGpagina'] = "Descripción de la página 2";
$globales['pagina2']['imagenOGpagina'] = $objForm->obtenerRutaSitio()."img/opengraph2.jpg";
$globales['pagina2']['metadescription'] = $objForm->setVariable($globales['metadescription'], "descripcion de la página 2");
$globales['pagina2']['metakeyworks'] = $objForm->setVariable($globales['metakeyworks'], "keywords, de, la, página, 2");

//SI ES "INDEX de módulo formulario"
$globales['formulario']['index']['tituloPagina'] = "INDEX Formulario";
$globales['formulario']['index']['descOGpagina'] = "Descripción formulario";
$globales['formulario']['index']['imagenOGpagina'] = $objForm->obtenerRutaSitio()."img/opengraph.jpg";
$globales['formulario']['index']['metadescription'] = $objForm->setVariable($globales['metadescription'], "descripcion de la página formulario");
$globales['formulario']['index']['metakeyworks'] = $objForm->setVariable($globales['metakeyworks'], "keywords, de, la, página, formulario");

//SI ES "INDEX de módulo formulario2"
$globales['formulario2']['index']['tituloPagina'] = "INDEX Formulario 2";
$globales['formulario2']['index']['descOGpagina'] = "Descripción formulario 2";
$globales['formulario2']['index']['imagenOGpagina'] = $objForm->obtenerRutaSitio()."img/opengraph.jpg";
$globales['formulario2']['index']['metadescription'] = $objForm->setVariable($globales['metadescription'], "descripcion de la página formulario 2");
$globales['formulario2']['index']['metakeyworks'] = $objForm->setVariable($globales['metakeyworks'], "keywords, de, la, página, formulario 2");

/*
  $tituloPagina = "PAGINA 3";
  $descOGpagina = "poner la descripcion de la pagina aca";
  $imagenOGpagina = "http//www.URLABSOLUTA/img/opengraph3.jpg";
  $metadescription = setVariable($metadescription, "descripcion de la página 3");
  $metakeyworks = setVariable($metakeyworks, "keywords, de, la, página, 3");

  $tituloPagina = "PAGINA POR DEFECTO";
  $descOGpagina = "poner la descripcion de la pagina aca";
  $imagenOGpagina = "http//www.URLABSOLUTA/img/opengraph.jpg";
  $metadescription = setVariable($metadescription, "descripcion de la página por defecto");
  $metakeyworks = setVariable($metakeyworks, "keywords, de, la, página, por, defecto");
 */


/* 	-------------------------------------------------------------------------- 	
  CODIGOS
  -------------------------------------------------------------------------- */
$globales['codigoAnalytics'] = "\n<!-- analytics -->\n" . $globales['elcodigoAnalytics'] . "\n<!-- /analytics -->\n"; //le da formato al codigo analytics
$globales['URLBaseSitio'] = $objForm->obtenerRutaSitio(); //obtiene la URL base del sitio
$globales['URLRelativaSitio'] = $objForm->obtenerRutaSitio(true); //obtiene la URL del directorio en que estoy posicionado
$globales['UrlBaseServidor'] =  $objForm->obtenerRutaServidor();  //obtiene la URL base de servidor
$globales['UrlRelativaServidor'] =  $objForm->obtenerRutaServidor(true);  //obtiene la URL de servidor, en el directorio en el que estoy posicionado

/*PRUEBAS*/
/*echo "url base pag: ".$globales['URLBaseSitio']."<br/>";
echo "url relativa pag: ".$globales['URLRelativaSitio']."<br/>";
echo "url base Servidor: ".$globales['UrlBaseServidor']."<br/>";
echo "url relativa Servidor: ".$globales['UrlRelativaServidor']."<br/>";*/


//Cambia las META de la pagina
?>