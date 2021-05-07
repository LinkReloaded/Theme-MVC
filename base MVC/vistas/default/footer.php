<? //FOOTER ELEMENTS  ?>
<!-- footer elements -->
	<link href="<?=$this->vista->globales['rutaVistas'].carpetaVistasBase?>js/superfish/superfish.css" rel="stylesheet" media="screen" />
	<link href="<?=$this->vista->globales['rutaVistas'].carpetaVistasBase?>js/shadowbox/shadowbox.css" rel="stylesheet" type="text/css">


	<? /*
        <!-- superfish -->
        <script type="text/javascript" src="<?=$this->vista->globales['rutaVistas'].carpetaVistasBase?>js/superfish/superfish.js" ></script>
        <script type="text/javascript" src="<?=$this->vista->globales['rutaVistas'].carpetaVistasBase?>js/superfish/hoverIntent.js" ></script>
        <script>
            jQuery(document).ready(function() {
                jQuery('ul#menu-topmenu').superfish(); 		
            });
        </script>
        <!-- /superfish -->
    */ ?>

    <? /*
        <!-- CarouFredSel -->
        <script type="text/javascript" language="javascript" src="<?=$this->vista->globales['rutaVistas'].carpetaVistasBase?>js/carouFredSel/jquery.mousewheel.min.js"></script>
        <script type="text/javascript" language="javascript" src="<?=$this->vista->globales['rutaVistas'].carpetaVistasBase?>js/carouFredSel/jquery.touchSwipe.min.js"></script>
        <script type="text/javascript" language="javascript" src="<?=$this->vista->globales['rutaVistas'].carpetaVistasBase?>js/carouFredSel/jquery.carouFredSel-6.2.1.js"></script>
        <script type="text/javascript" language="javascript">
            jQuery(function() {
                jQuery('#carrusel').carouFredSel({
                    auto: 5000,
                    prev: '#prev2',
                    next: '#next2',
                    mousewheel: true,
                    swipe: {
                        onMouse: true,
                        onTouch: true
                    }
                });
            });
        </script>
        <!-- /CarouFredSel -->
    */ ?>

  	<? /*  
        <!-- shadowbox -->
        <script type="text/javascript" src="<?=$this->vista->globales['rutaVistas'].carpetaVistasBase?>js/shadowbox/shadowbox.js"></script>
        <script>
            Shadowbox.init({
                language: 'es',
                players:  ['swf', 'img', 'html', 'iframe']
            });
        </script>
        <!-- /shadowbox -->
    */?>

    <? /*
        <!-- acordeon -->
        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery("dd").hide();
                jQuery("#primero").slideToggle("slow");
                jQuery("dt a").click(function(){		
                    jQuery(this).parent().next().siblings("dd:visible").slideUp("slow");
                    jQuery(this).parent().next().slideToggle("slow");
                    jQuery(this).parent().siblings("dt").addClass("marcado");
                    jQuery(this).parent().next().siblings("dt").toggleClass("marcado");
                return false;
                });		
            });
                jQuery(document).ready(function(){
                jQuery("#subacordeon dd").hide();
                jQuery("#subacordeon a").click(function(){		
                    jQuery(this).parent().next().siblings("dd:visible").slideUp("slow");
                return false;
                });		
            });
        </script>
        <!-- /acordeon -->
    */?>

    <? /*
    <script>
        jQuery(document).ready(function(){
            if (anchoVentana > 979) {								//sitio normal
                //alert('document.write('sitio normal');
            } else if(anchoVentana > 767 && anchoVentana < 980){	//ipad vertical
                //alert('document.write('ipad vertical');
            } else if(anchoVentana > 479 && anchoVentana < 768){	//iPhone horizontal
                //alert('document.write('iphone horizontal');
            } else if(anchoVentana < 480){ 							//iPhone vertical
                //alert('document.write('iphone vertical');
            }
        });
    </script>
    */?>


<? //SI TIENE CONFIGURACIONES ESPECIFICAS PARA ESTA PAGINA PUEDE PONERLAS ACÁ ?>

<?
switch($this->vista->globales['thispage']){
    case "pagina2":
    ?>
        <script>
            jQuery(document).ready(function(){
                /*alert("soy la página 2");*/
            });
        </script>
    <?
    break;

    default:
    ?>
        <script>
            jQuery(document).ready(function(){
                /*alert("soy el index");*/
            });
        </script>
    <?
}
?>


<!-- /footer elements -->
<? //FIN FOOTER ELEMENTS  ?>

