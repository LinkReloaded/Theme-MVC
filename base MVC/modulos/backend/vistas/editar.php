<!doctype html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Cotizador Derco</title>
        <link type="image/x-icon" rel="shortcut icon" href="<?=$this->vista->globales['rutaVistasModulo']?>js/favicon.ico" />
        <!-- css -->
        <link type="text/css" rel="stylesheet" media="screen" href="<?=$this->vista->globales['rutaVistasModulo']?>css/reset.css"/>
        <link type="text/css" rel="stylesheet" media="screen" href="<?=$this->vista->globales['rutaVistasModulo']?>css/default.css"/>
        <link type="text/css" rel="stylesheet" media="screen" href="<?=$this->vista->globales['rutaVistasModulo']?>font/font.css"/>
        <link type="text/css" rel="stylesheet" media="screen" href="<?=$this->vista->globales['rutaVistasModulo']?>css/print.css"/>
        <link type="text/css" rel="stylesheet" media="screen" href="<?=$this->vista->globales['rutaVistasModulo']?>css/style.css"/>
        <!--[if IE]>
        <script src="<?=$this->vista->globales['rutaVistasModulo']?>js/html5.js"></script>
        <![endif]-->
        <!--[if IE 7]>
        <link type="text/css" rel="stylesheet" media="screen" href="<?=$this->vista->globales['rutaVistasModulo']?>css/style7.css?=<?php echo time(); ?>" />
        <![endif]-->
        <?php
        $isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'], 'iPad');
        if (!empty($isiPad)) { //detecta si el navegador es iPad  
            ?>
            <link type="text/css" rel="stylesheet" media="screen" href="<?=$this->vista->globales['rutaVistasModulo']?>css/ipad.css?=<?php echo time(); ?>"/>
        <?php } ?>
        <!-- /css -->
        <!-- jQuery -->
        <script type="text/javascript" src="<?=$this->vista->globales['rutaVistasModulo']?>js/jquery-1.8.3.min.js"></script>
        <!-- /jQuery -->
        <?php include('inc/header_elements.php'); ?>
        <script src="<?=$this->vista->globales['rutaVistasModulo']?>js/scripts.js" type="text/javascript"></script>
        <!-- jQuery -->
        <script type="text/javascript" src="<?=$this->vista->globales['rutaVistasModulo']?>js/jquery-1.8.3.min.js"></script>
        <!-- /jQuery -->
        <script type="text/javascript">
            $(document).ready(function() {
                $(".btn").children("a").click(function(e) {
                    e.preventDefault();

<? /* Verificar si la contraseña actual no está vacía */ ?>
                    if ($("input[name='contActual']").val() != "") {
                        if ($("input[name='contNueva1']").val() != "") {
                            if ($("input[name='contNueva1']").val().length >= 8) {
                                if ($("input[name='contNueva2']").val() != "") {
                                    if ($("input[name='contNueva2']").val() == $("input[name='contNueva1']").val()) {
<? /* Enviar formulario */ ?>
                                        $("#cambiarCont").submit();
                                    } else {
                                        alert("Debe reingresar su nueva contraseña correctamente");
                                    }
                                } else {
                                    alert("Debe reingresar su nueva contraseña");
                                }
                            } else {
                                alert("Su nueva contraseña debe ser de 8 caracteres o más");
                            }
                        } else {
                            alert("Debe ingresar su nueva contraseña");
                        }
                    } else {
                        alert("Debe ingresar su contraseña actual");
                    }
                });
            });
        </script>
    </head>
    <body id="proceso">
        <!-- header -->
        <? include("header.php"); ?>
        <!-- /header --> 

        <!-- Contenido -->
        <section id="contenido" class="edicionUsuario" style="padding-left:70px; width:470px;">

            <div class="btn_volver"  >
                <a href="<?=$this->vista->globales['actionBaseForm']?>">VOLVER</a>
            </div>

            <form id="cambiarCont" action="<?= $this->vista->globales['actionForm'] ?>" method="post">

                <!-- columna izquierda -->
                <div class="col-izq">
                    <h3>CAMBIAR CONTRASE&Ntilde;A</h3>
                    <div class="cont" style="height:295px;">
                        <div style="width:449px;" class="mod linea-abajo"><label style="width:250px;">CONTRASE&Ntilde;A ANTIGUA:</label><div class="dat" style="float:left"><input name="contActual" value="" type="password"></div><div class="clear"></div></div>
                        <div style="width:449px;" class="mod linea-abajo"><label style="width:250px;">CONTRASE&Ntilde;A NUEVA:</label><div class="dat" style="float:left"><input name="contNueva1" value="" type="password"><span>(8 caracteres)</span></div><div class="clear"></div></div>
                        <div style="width:449px;" class="mod linea-abajo"><label style="width:250px;">REPITA CONTRASE&Ntilde;A NUEVA:</label><div class="dat"  style="float:left"><input name="contNueva2" value="" type="password"><span>(8 caracteres)</span></div><div class="clear"></div></div>
                        <div class="row btn-crear"><div class="btn"><a href="#">CAMBIAR CONTRASE&Ntilde;A</a></div></div>
                        <div class="mensaje"><?=$this->vista->error?></div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>
                <!-- /columna izquierda -->

                <div class="clear"></div>
            </form>

        </section>
        <!-- /Contenido -->
    </body>
</html>