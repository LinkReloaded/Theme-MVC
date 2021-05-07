<!doctype html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Cotizador Derco</title>
        <link type="image/x-icon" rel="shortcut icon" href="<?= $this->vista->globales['rutaVistasModulo'] ?>js/favicon.ico" />
        <!-- css -->
        <link type="text/css" rel="stylesheet" media="screen" href="<?= $this->vista->globales['rutaVistasModulo'] ?>css/reset.css"/>
        <link type="text/css" rel="stylesheet" media="screen" href="<?= $this->vista->globales['rutaVistasModulo'] ?>css/default.css"/>
        <link type="text/css" rel="stylesheet" media="screen" href="<?= $this->vista->globales['rutaVistasModulo'] ?>font/font.css"/>
        <link type="text/css" rel="stylesheet" media="screen" href="<?= $this->vista->globales['rutaVistasModulo'] ?>css/print.css"/>
        <link type="text/css" rel="stylesheet" media="screen" href="<?= $this->vista->globales['rutaVistasModulo'] ?>css/style.css"/>
        <!--[if IE]>
        <script src="<?= $this->vista->globales['rutaVistasModulo'] ?>js/html5.js"></script>
        <![endif]-->
        <!--[if IE 7]>
        <link type="text/css" rel="stylesheet" media="screen" href="<?= $this->vista->globales['rutaVistasModulo'] ?>css/style7.css?=<?php echo time(); ?>" />
        <![endif]-->
        <?php
        $isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'], 'iPad');
        if (!empty($isiPad)) { //detecta si el navegador es iPad  
            ?>
            <link type="text/css" rel="stylesheet" media="screen" href="<?= $this->vista->globales['rutaVistasModulo'] ?>css/ipad.css?=<?php echo time(); ?>"/>
        <?php } ?>
        <!-- /css -->
        <!-- jQuery -->
        <script type="text/javascript" src="<?= $this->vista->globales['rutaVistasModulo'] ?>js/jquery-1.8.3.min.js"></script>
        <!-- /jQuery -->
        <?php include('inc/header_elements.php'); ?>
        <script src="<?= $this->vista->globales['rutaVistasModulo'] ?>js/scripts.js" type="text/javascript"></script>
        <!-- jQuery -->
        <script type="text/javascript" src="<?= $this->vista->globales['rutaVistasModulo'] ?>js/jquery-1.8.3.min.js"></script>
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
                <a href="<?= $this->vista->globales['actionBaseForm'] ?>">VOLVER</a>
            </div>
            <?= $this->vista->globales['tablaEditar'] ?>
        </section>
        <!-- /Contenido -->
    </body>
</html>