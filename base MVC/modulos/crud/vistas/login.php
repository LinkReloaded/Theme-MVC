<!doctype html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Inicio Sesión</title>
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
        <script src="<?=$this->vista->globales['rutaVistasModulo']?>js/jquery-1.8.3.min.js" type="text/javascript"></script>
        <!-- /jQuery -->
        <script type="text/javascript">
            $(document).ready(function(){

                $("body").css({"display":"block"});
                $("input[name='usuario']").focus();
            });
        </script>
        <?php include('inc/header_elements.php'); ?>
        <script src="<?=$this->vista->globales['rutaVistasModulo']?>js/scripts.js" type="text/javascript"></script>
    </head>
    <body display="none" id="home">
        <header>
            <div class="row row-sup">
                <div class="col">
                    <h1>ADMINISTRADOR</h1>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="row row-inf">
                <?php /* aca no va nada XD */ ?>
                <div class="clear"></div>
            </div>   
            <div class="clear"></div>
        </header>
        <div class="row row-login">    
            <section id="login">

                <div class="mod-login">
                    <?
                    if (isset($_GET['accion']) && $_GET['accion'] == "recuperar") {

                        if (isset($_POST['mailRecuperar']) && !empty($_POST['mailRecuperar'])) {
                            ?>
                            <div class="intr_header">CONTRASE&Ntilde;A ENVIADA</div>
                            <div class="intr_footer">
                                <div class="row">
                                    <div class="mensaje-rec-final">
                                    	La contraseña fue enviada a <strong><?=$_GET['mailRecuperar']?></strong><br>
                                    	<a href="<?= $this->vista->globales['actionForm'] ?>">Volver al Index</a>
                                    	<div class="clear"></div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="txt-error"><?= $this->vista->error ?></div>
                                <div class="clear"></div>
                            </div>
                            <?
                        } else {
                            ?>
                            <div class="intr_header">PARA RECUPERAR LA CONTRASE&Ntilde;A INGRESA TU E-MAIL</div>
                            <div class="intr_footer">
                                <form action="<?= $this->vista->globales['actionForm'] ?>" method="post">
                                    <div class="row"><label>E-MAIL:</label><input name="mailRecuperar" type="text" /><div class="clear"></div></div>
                                    <div class="row btn">
                                        <div class="btn_cont">
                                            <input type="image" src="<?=$this->vista->globales['rutaVistasModulo']?>img/fnd_btn_recuperar.png" width="92" height="26" />
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <input type="hidden" name="accion" value="recuperar" />
                                </form>
                                <div class="txt-error"><?= $this->vista->error ?></div>
                                <div class="clear"></div>
                            </div>
                            <?
                        }
                    } else {
                        ?>
                        <div class="intr_header">INGRESA TUS DATOS</div>
                        <div class="intr_footer">
                            <form action="./?<?=$_SERVER['QUERY_STRING']?>" method="post">
                                <div class="row"><label>USUARIO:</label><input name="usuario" type="text" /><div class="clear"></div></div>
                                <div class="row"><label>CLAVE:</label><input name="contraseña" type="password" /><div class="clear"></div></div>
                                <div class="row btn">
                                    <div class="btn_cont">
                                        <input type="image" src="<?=$this->vista->globales['rutaVistasModulo']?>img/btn_ingresar.png" width="92" height="26" />
                                    </div>
                                    <div class="olv-cl"><a href="<?= $this->vista->globales['actionForm'] ?>&accion=recuperar">Olvidaste tu clave?</a></div>
                                    <div class="clear"></div>
                                </div>
                            </form>
                            <div class="txt-error"><?= $this->vista->error ?></div>
                            <div class="clear"></div>
                        </div>
                        <?
                    }
                    ?>
                    <div class="sombra"><img src="<?=$this->vista->globales['rutaVistasModulo']?>img/fnd_login_form.png" width="444" height="68"></div>
                    <div class="clear"></div>
                </div>
                </form>
            </section>
            <div class="clear"></div>
        </div>    
    </body>
</html>