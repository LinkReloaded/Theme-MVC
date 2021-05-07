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
        <? $this->validaForm1->codValJs(); //Imprime código para validar por js  ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $(".col-der").find(".unidad").find("input[type='checkbox']").change(function() {
                    if ($(this).attr("checked") == "checked") {
                        $(this).parent().parent().children(".logo").addClass("seleccionado");
                    } else {
                        $(this).parent().parent().children(".logo").removeClass("seleccionado");
                    }
                });
                $(".btn-crear").find("a").click(function(e) { //Evento que gatilla la validación js
                    e.preventDefault();
                    var respVal = false;
                    respVal = validarCampos_<?=$this->validaForm1->idForm ?>(); //Función que valida los campos según configuración de la clase php
                    if (respVal != "1") {
                        alert(respVal); //procedimiento a ejecutar en caso de error en la validación js
                    } else {
                        $("#contenido").find("form").submit();
                    }
                });

                $("#selecTodo").click(function(e) {
                    e.preventDefault();

<? /* Seleccionar todas las marcas de la lista */ ?>
                    $(".col-der").find("input[type='checkbox']").attr("checked", true);
                });
            });
        </script>
    </head>
    <body id="proceso">
        <!-- header -->
        <? include("header.php"); ?>
        <!-- /header --> 

        <!-- Contenido -->
        <section id="contenido" class="edicionUsuario">
            <div class="btn_volver">
                <a href="<?= $this->vista->globales['actionForm'] ?>">VOLVER</a>
            </div>
            <form action="" method="post">

                <!-- columna izquierda -->
                <div class="col-izq">
                    <h3>1. DATOS USUARIOS</h3>
                    <div class="cont">
                        <div class="mod linea-abajo linea-der">
                            <label>NOMBRE:</label>
                            <div class="dat">
                                <input name="<?= $this->vista->campo[0] ?>" value="<?= $this->vista->resultUsuario[$this->vista->campo[0]] ?>" type="text">
                                <span>(Dato obligatorio)</span>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="mod linea-abajo">
                            <label>APELLIDO:</label>
                            <div class="dat">
                                <input name="<?= $this->vista->campo[1] ?>" value="<?= $this->vista->resultUsuario[$this->vista->campo[1]] ?>" type="text">
                                <span>(Dato obligatorio)</span>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="mod linea-abajo linea-der">
                            <label>EMPRESA:</label>
                            <div class="dat">
                                <input name="<?= $this->vista->campo[2] ?>" value="<?= $this->vista->resultUsuario[$this->vista->campo[2]] ?>" type="text">
                                <span>(Dato obligatorio)</span>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="mod linea-abajo">
                            <label>E-MAIL:</label>
                            <div class="dat">
                                <input name="<?= $this->vista->campo[3] ?>" value="<?= $this->vista->resultUsuario[$this->vista->campo[3]] ?>" type="text">
                                <span>(Dato obligatorio)</span>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="selector linea-abajo linea-der">
                            <label>TIPO DE USUARIO:</label>
                            <div class="dat-sel">
                                <label class="adm">
                                    <input type="radio" name="<?= $this->vista->campo[4] ?>" value="1" <?
                                    if ($this->vista->resultUsuario[$this->vista->campo[4]] == "1") {
                                        echo "checked='checked'";
                                    } else if (empty($this->vista->resultUsuario[$this->vista->campo[4]])) {
                                        echo "checked='checked'";
                                    }
                                    ?>>
                                    ADM
                                </label>
                                <label class="cons">
                                    <input type="radio" name="<?= $this->vista->campo[4] ?>" value="2" <?
                                    if ($this->vista->resultUsuario[$this->vista->campo[4]] == "2") {
                                        echo "checked='checked'";
                                    }
                                    ?>>
                                    Consultor
                                </label>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="selector linea-abajo">
                            <label>RECIBE CORREO:</label>
                            <div class="dat-sel">
                                <label class="correo">
                                    <input type="radio" name="<?= $this->vista->campo[5] ?>" value="si" 
                                    <?
                                    if ($this->vista->resultUsuario[$this->vista->campo[5]] == "si") {
                                        echo "checked='checked'";
                                    } else if (empty($this->vista->resultUsuario[$this->vista->campo[5]])) {
                                        echo "checked='checked'";
                                    }
                                    ?>>
                                    S&iacute;
                                </label>
                                <label class="correo">
                                    <input type="radio" name="<?= $this->vista->campo[5] ?>" value="no" 
                                    <?
                                    if ($this->vista->resultUsuario[$this->vista->campo[5]] == "no") {
                                        echo "checked='checked'";
                                    }
                                    ?>>
                                    No
                                </label>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                        <div class="selector-largo row linea-der backend-acceso">
                            <div class="centrar"> <span>ACCESO AL BACKEND:</span>
                                <label>
                                    <input type="radio" name="<?= $this->vista->campo[6] ?>" value="si" 
                                    <?
                                    if ($this->vista->resultUsuario[$this->vista->campo[6]] == "si") {
                                        echo "checked='checked'";
                                    } else if (empty($this->vista->resultUsuario[$this->vista->campo[6]])) {
                                        echo "checked='checked'";
                                    }
                                    ?>>
                                    Si
                                </label>
                                <label>
                                    <input type="radio" name="<?= $this->vista->campo[6] ?>" value="no" 
                                    <?
                                    if ($this->vista->resultUsuario[$this->vista->campo[6]] == "no") {
                                        echo "checked='checked'";
                                    }
                                    ?>>
                                    No
                                </label>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="row btn-crear">
                            <div class="btn"> 
                                <a href="#">
                                    <?
                                    if (isset($_GET['id']) && !empty($_GET['id']) && $_GET['accion'] == "editar") {
                                        ?>
                                        MODIFICAR USUARIO
                                        <?
                                    } else {
                                        ?>
                                        CREAR USUARIO
                                        <?
                                    }
                                    ?>
                                </a>
                            </div>
                        </div>
                        <div class="mensaje">
                            <?
                            if (isset($_GET['estado'])) {
                                switch ($_GET['estado']) {
                                    case "correcto": echo "Guardado correctamente";
                                        break;
                                    case "error": echo "Error al intentar guardar. Intente nuevamente.";
                                        break;
                                }
                            }
                            ?>
                        </div>
                        <?
                        if (isset($_GET['id']) && !empty($_GET['id'])) {
                            ?>
                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>" />
                            <?
                        }
                        ?>
                        <input type="hidden" name="seccion" value="<?= $_GET[nomParamControlador] ?>" />
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>
                <!-- /columna izquierda --> 

                <!-- columna derecha -->
                <div class="col-der">
                    <h3>2. MARCA A LA QUE TIENE ACCESO <a id="selecTodo" href="#">[SELECCIONAR TODO]</a></h3>
                    <div class="cont">
                        <?
                        foreach ($this->vista->listaMarcas as $datosMarca) {
                            $marcaSeleccionada = false;
                            if (preg_match("/" . $datosMarca[0] . "/", $this->vista->resultUsuario['marcasAsignadas'])) {
                                $marcaSeleccionada = true;
                            }
                            ?>
                            <div class="unidad">
                                <label>
                                    <div class="logo logo<?= $datosMarca[0] ?><?
                                    if ($marcaSeleccionada) {
                                        echo " seleccionado";
                                    }
                                    ?>"></div>
                                    <div class="row nombre-marca">
                                        <input name="<?= $this->vista->campo[7] ?>[]" type="checkbox" value="<?= $datosMarca[0] ?>" <?
                                        if ($marcaSeleccionada) {
                                            echo "checked='checked'";
                                        }
                                        ?>>
                                        <span>Seleccionar</span>
                                        <div class="clear"></div>
                                    </div>
                                </label>
                                <div class="clear"></div>
                            </div>
                            <?
                        }
                        ?>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>
                <!-- /columna derecha -->

                <div class="clear"></div>
            </form>
        </section>
        <!-- /Contenido -->
    </body>
</html>