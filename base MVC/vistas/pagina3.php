<!doctype html>
<html lang="es">
    <head>
        <?
        $objHeader = $this->cargarControlador("head");
        $objHeader->cargarHeader();
        ?>
    </head>
    <body id="<?= $objHeader->vista->globales['thispage']?>" class="page">
		<? $this->cargarVista("header", carpetaVistasBase, true); ?>        
        
        <? $objHook = $this->cargarControlador("index", false, "hook"); //escribir la descripcion aca ?>
        <?php /* REFERENCIA HTML5 
          <header></header> 					//la cabecera de una  seccion o de la pagina
          <section></section> 				//un grupo tematico de contenido, tipicamente comienza con un encabezado
          <footer></footer> 					//el footer de una seccion o de la pagina
          <article></article> 				//un subseccion dentro de una seccion
          <aside></aside> 					//el sidebar, es el contenido complementario de una pagina
          <figure></figure> 					//una imagen... debe contener un img y si aplica un "<figcaption>"
          <figcaption></figcaption> 			//es el pie de foto dentro de una figure
          <div contenteditable=true></div>	 //content editable se refiere a que el contenido de ese elemento puede ser modificado por el usuario
          <nav></nav> 						//contiene los elementos de navegacion de un sitio o una pagina
          <time></time>						//indica la fecha/hora en el contenido
         */ ?>

        <? $this->cargarVista("footer", carpetaVistasBase, true); ?>
    </body>
</html>