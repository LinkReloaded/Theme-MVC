<script type="text/javascript">
    $(document).ready(function() {
        $(".cambia-user").find("select[name='<?=nomParamControlador?>']").change(function() {
            $(this).parent("form:eq(0)").submit();
        });
    });
</script>
<header>
    <div class="row row-sup">
        <div class="col">
            <figure><img src="<?= $this->vista->globales['rutaVistasModulo'] ?>img/logo_derco.jpg" width="76" height="76" alt="Derco"></figure>
            <h1>BUSCADOR DE COTIZACIONES</h1>
            <div class="user">
                <a class="btn_cerrar" href="<?=$this->vista->globales['actionBaseForm']?>&logout=1">Cerrar Sesi&oacute;n</a>
                <div class="nombre">
                    <div class="row row1">Bienvenido, <span><?= $this->vista->datosCliente[0]['nombres'] . " " . $this->vista->datosCliente[0]['apellidos'] ?></span></div>
                    <div class="row row2"><a href="<?= $this->vista->globales['actionBaseForm'] ?>&controlador=editar">[Cambiar contrase&ntilde;a]</a></div>    
                </div>    
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="row row-inf">
        <div class="logos-cont">
            <ul>
                <li><figure class="suzuki_marca"></figure></li>
                <li><figure class="mazda_marca"></figure></li>
                <li><figure class="renault_marca"></figure></li>
                <li><figure class="samsung_marca"></figure></li>
                <li><figure class="greatwall_marca"></figure></li>
                <li><figure class="jac_marca"></figure></li>
                <li><figure class="greely_marca"></figure></li>
                <li><figure class="changan_marca"></figure></li>
                <div class="clear"></div>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>   
    <div class="clear"></div>
</header>
<?
if ($_GET[nomParamControlador] != "editar") {
    ?>
    <div class="row base-select">

        <!-- cambiador usuarios -->
        <div class="cambia-user">
            <form action="" method="get">
                <label>Cambiar Secci&oacute;n: </label>
                <input type="hidden" name="m" value="<?= $_GET['m'] ?>"/>
                <select name="<?=nomParamControlador?>">
                    <option value="index" <?
                    if (isset($_GET[nomParamControlador]) && $_GET[nomParamControlador] == "index") {
                        echo "selected=selected";
                    }
                    ?>>Cotizaciones</option>
                            <?
                            if ($this->vista->datosCliente[0]['tipoUsuario'] == "1") {
                                ?>
                        <option value="usuarios" <?
                        if (isset($_GET[nomParamControlador]) && $_GET[nomParamControlador] == "usuarios") {
                            echo "selected=selected";
                        }
                        ?>>Usuarios</option>
                                <?
                            }
                            ?>
                </select>
            </form>
        </div>
        <!-- /cambiador usuarios -->

    </div>
    <?
}
?>
