<script type="text/javascript">
    $(document).ready(function() {
        $(".cambia-user").find("select[name='<?= nomParamVista ?>']").change(function() {
            $(this).parent("form:eq(0)").submit();
        });
    });
</script>
<header>
    <div class="row row-sup">
        <div class="col">
            <h1>ADMINISTRADOR</h1>
            <div class="user">
                <a class="btn_cerrar" href="<?= $this->vista->globales['actionBaseForm'] ?>&logout=1">Cerrar Sesi&oacute;n</a>
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
                <select name="<?= nomParamVista ?>">
                    <?
                    if (isset($this->vista->globales['permisos']) && is_array($this->vista->globales['permisos'])) {
                        foreach ($this->vista->globales['permisos'] as $seccion) {
                            if ($seccion != "editar") {
                                ?>
                                <option value="<?= $seccion ?>" <?
                                if (isset($_GET[nomParamVista]) && $_GET[nomParamVista] == $seccion) {
                                    echo "selected=selected";
                                }
                                ?>><?= $seccion ?>
                                </option>
                                <?
                            }
                        }
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
