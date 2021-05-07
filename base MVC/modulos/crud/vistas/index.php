<!doctype html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Administrador</title>
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
            <?php
        }
        ?>
        <!-- /css -->
        <!-- jQuery -->
        <script type="text/javascript" src="<?= $this->vista->globales['rutaVistasModulo'] ?>js/jquery-1.8.3.min.js"></script>
        <!-- /jQuery -->

        <!-- jQuery UI DATe PICKER-->
        <script type="text/javascript" src="<?= $this->vista->globales['rutaVistasModulo'] ?>js/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
        <link type="text/css" href="<?= $this->vista->globales['rutaVistasModulo'] ?>js/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" rel="stylesheet" />
        <!-- /jQuery UI DATe PICKER-->
        <script>

            //Array para dar formato en español
            $.datepicker.regional['es'] =
                    {
                        closeText: 'Cerrar',
                        prevText: 'Previo',
                        nextText: 'Próximo',
                        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                        monthStatus: 'Ver otro mes', yearStatus: 'Ver otro año',
                        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sáb'],
                        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                        dateFormat: 'dd-mm-yy', firstDay: 0,
                        initStatus: 'Selecciona la fecha', isRTL: false};

            $.datepicker.setDefaults($.datepicker.regional['es']);

            $(function() {

                $("#formFiltro").children("div[id]").each(function() {
                    if ($(this).attr("id").match(/fecha/i)) {
                        $(this).find("input[type='text']").datepicker();
                    }
                });
<? /* $("input[name='inicioRango']").datepicker();
  $("input[name='finRango']").datepicker(); */ ?>
            });
        </script>
        <script type="text/javascript">

            $(document).ready(function() {

                var host = "";
                var peticiones = "<?= "?" . $_SERVER['QUERY_STRING'] ?>";
                var pag = 1;
<?
if (isset($_GET['pag'])) {
    ?>
                    pag = parseInt("<?= $_GET['pag'] ?>");
    <?
}
?>
                $("input[name='inicio']").click(function(e) {

                    e.preventDefault();

                    location.href = "<?= $this->vista->globales['actionForm'] ?>";
                });

                $("select[name='secciones']").change(function() {

                    location.href = "index.php?m=<?= $_GET['m'] ?>&seccion=" + $(this).find("option:selected").val();
                });

                $("#formFiltro").find("input[name='mostrarTodosCotizaciones']").click(function(e) {
                    e.preventDefault();

                    location.href = "<?= $this->vista->globales['actionForm'] ?>";
                });
                $("#formFiltro").find("input[name='mostrarTodosContactos']").click(function(e) {
                    e.preventDefault();

                    location.href = "index.php?m=<?= $_GET['m'] ?>&inicioContacto=contacto";
                });

                $(".paginas").find("a#pagSig").click(function(e) {

                    e.preventDefault();
                    if (peticiones == "?") {
                        location.href = peticiones + "pag=" + (pag + 1);
                    } else {
                        if (peticiones.match(/\?pag\=/)) {
                            peticiones = peticiones.substring(0, peticiones.indexOf("?pag="));
                            location.href = peticiones + "?pag=" + (pag + 1);
                        } else
                        if (peticiones.match(/\&pag\=/)) {
                            peticiones = peticiones.substring(0, peticiones.indexOf("&pag="));
                            location.href = peticiones + "&pag=" + (pag + 1);
                        } else {
                            location.href = peticiones + "&pag=" + (pag + 1);
                        }
                    }
                });

                $(".paginas").find("a#pagAnt").click(function(e) {

                    e.preventDefault();

                    if (peticiones == "?") {
                        location.href = peticiones + "pag=" + (pag + 1);
                    } else {
                        if (peticiones.match(/\?pag\=/)) {
                            peticiones = peticiones.substring(0, peticiones.indexOf("?pag="));
                            location.href = peticiones + "?pag=" + (pag - 1);
                        } else
                        if (peticiones.match(/\&pag\=/)) {
                            peticiones = peticiones.substring(0, peticiones.indexOf("&pag="));
                            location.href = peticiones + "&pag=" + (pag - 1);
                        } else {
                            location.href = peticiones + "&pag=" + (pag - 1);
                        }
                        //                        alert(peticiones);
                    }
                });

                $("select[name='selectPag']").change(function() {

                    if (peticiones == "?") {
                        location.href = peticiones + "pag=" + $(this).val();
                    } else {
                        if (peticiones.match(/\?pag\=/)) {
                            peticiones = peticiones.substring(0, peticiones.indexOf("?pag="));
                            location.href = peticiones + "?pag=" + $(this).val();
                        } else
                        if (peticiones.match(/\&pag\=/)) {
                            peticiones = peticiones.substring(0, peticiones.indexOf("&pag="));
                            location.href = peticiones + "&pag=" + $(this).val();
                        } else {
                            location.href = peticiones + "&pag=" + $(this).val();
                        }
                    }
                });

                $(".btn_xls").click(function(e) {

                    e.preventDefault();

                    peticiones.replace(/\?genExcel\=Generar\+Excel/gi, "");
                    peticiones.replace(/\&genExcel\=Generar\+Excel/gi, "");

                    location.href = peticiones + "&genExcel=1";
                });

                $(".marcaTabla").click(function(e) {
                    e.preventDefault();

                    filtrar(true, $(this));
                });
            });

            function filtrar(marca, obj) {

                var msjeError = "";

                switch ($("#selectFiltro").val()) {

                    case "rut":
                        if ($("#rut").find("input").val() == "") {
                            msjeError = "Debe ingresar un Rut";
                        } else {
                            $("input[name='rut']").val(($("input[name='rut']").val().replace(/\./g, "")));
                        }
                        break;
                    case "email":
                        if ($("#email").find("input").val() == "") {
                            msjeError = "Debe ingresar un Email";
                        }
                        break;
                }

                if (msjeError != "") {
                    alert(msjeError);
                } else {

                    var urlHref = "";
                    //                    urlHref=host;

                    var nomFiltro = $("#selectFiltro").val();

                    //comenzar a armar la petición según el filtro
                    urlHref += "<?= $this->vista->globales['actionForm'] ?>&filtro=" + nomFiltro + "&buscar=Buscar";

                    //verificar si se está usando el buscador. Si es así, preparar los select con el valor buscado. Sino, dejar los select con un option vacío

                    var contenedorFiltro = $("#" + nomFiltro);

                    if ($("#" + $("#selectFiltro").val()).children("form").serialize() != "") {
                        urlHref += "&" + $("#" + $("#selectFiltro").val()).children("form").serialize();
                    }
                    if ($("form#formMarcas").serialize() != "") {
                        urlHref += "&" + $("form#formMarcas").serialize();
                    }

                    if (marca) {
                        location.href = urlHref + "&marcaTabla=" + obj.attr("id").replace("marca_", "");
                    } else {
                        location.href = urlHref;
                    }
                }
            }

            $(document).ready(function() {
                $("#selectFiltro").change(function() {
                    //                    alert($(this).val());

                    $("div#formFiltro").children(".row").each(function() {
                        if ($(this).attr("id") != "") {
                            $(this).addClass("hidden");
                        }
                    });

                    switch ($(this).val()) {
<?
//iterar e imprimir la lista de filtros para seleccionar
foreach ($this->vista->masterArray['campos'] as $key => $value) {

    if (isset($value['nomFiltro']) && !empty($value['nomFiltro'])) {

        //imprimir combobox con listado de filtros para seleccionar
        ?>
                                case "<?= $value['idFiltro'] ?>":
                                    $("#<?= $value['idFiltro'] ?>").removeClass("hidden");
                                    break;
        <?
    }
}
?>
                    }
                });

                $(".row-filtrosMarca").find("input").change(function() {
                    if ($(this).attr("checked") == "checked") {
                        $(this).parent().parent().children("figure").addClass("seleccionado");
                    } else {
                        $(this).parent().parent().children("figure").removeClass("seleccionado");
                    }
                });

                $(".btn-buscar").children("a").click(function(e) {
                    e.preventDefault();

                    filtrar(false);
                });
            });
<? ?>
        </script>
        <?php include('inc/header_elements.php'); ?>
        <script src="<?= $this->vista->globales['rutaVistasModulo'] ?>js/scripts.js" type="text/javascript"></script>
    </head>
    <body id="proceso">
        <!-- header -->
        <? include("header.php"); ?>
        <!-- /header -->
        <!-- Contenido -->
        <section id="contenido">
            <!-- titulo -->
            <div class="row">
                <h2>FILTROS DE B&Uacute;SQUEDA</h2>
            </div>
            <!-- /titulo -->
            <!-- filtro datos registrados -->
            <div class="row">
                <h4>POR DATOS REGISTRADOS</h4>
                <div class="row fnd-gris caja-filtros modulo">
                    <?
                    $this->vista->modeloBackend->filtrado($_GET[nomParamVista], $this->vista->masterArray, $this->vista->stringTablas, $this->vista->stringCampos, $this->vista->condicionFiltro);
                    ?>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
            <!-- /filtro datos registrados -->
            <!-- btn buscar -->
            <div class="row row-buscar modulo">
                <div class="btn-buscar"><a href="#"><img src="<?= $this->vista->globales['rutaVistasModulo'] ?>img/btn_buscar.gif" width="151" height="35" alt="Buscar"></a></div>
            </div>
            <!-- /btn buscar -->

            <!-- filtros utilizados -->
            <div class="row">
                <h4>FILTRO DE B&Uacute;SQUEDA UTILIZADO</h4>
                <div class="row row-filtrosUtilizados modulo">
                    <div class="criterio">
                        <?
                        switch ($_GET['filtro']) {
                            case "fecha":
                                ?>
                                FECHA: <?= $_GET['filtroFechaMin'] ?> / <?= $_GET['filtroFechaMax'] ?>
                                <?
                                break;
                            case "rut":
                                ?>
                                RUT: <?= $_GET['rut'] ?>
                                <?
                                break;
                            case "email":
                                ?>
                                E-MAIL: <?= $_GET['email'] ?>
                                <?
                                break;
                        }
                        ?>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <!-- /filtros utilizados -->
            <!-- detalle resultados -->
            <?=$this->vista->globales['tablaResultados']?>
            <!-- /detalle resultados -->

            <div class="clear"></div>
        </section>
        <!-- /Contenido -->
    </body>
</html>