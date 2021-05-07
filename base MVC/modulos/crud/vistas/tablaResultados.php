<div class="row row-resultados modulo">
    <div class="row lineaAzulFondo">
        <h3>DETALLE DE RESULTADOS</h3>
        <div class="mas-info">
            <span>Para m&aacute;s informaci&oacute;n:</span>
            <a href="#" class="btn_xls"><img src="<?= $this->vista->globales['rutaVistasModulo'] ?>img/btn_desc_xls.gif" width="231" height="33" alt="Exportar .xls"></a>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="row">
        <div class="mensaje">
        <?
        if (isset($_GET['estado']) && $_GET['estado'] == "borrado") {
            echo "Elemento Borrado";
        }
        ?>
        </div>  
        <?
        $maxPorPag = 25;

        $pagina = 1;

        if (isset($_GET['pag']) && $_GET['pag']) {
            $pagina = (int) $_GET['pag'];
        }

        $totalResultados = 0;

        if ($result = mysql_query("select count(*) as total from " . $this->vista->stringTablas . " " . preg_replace("/order by .+ (desc|asc)/i", "", $this->vista->condicionTabla), $this->vista->modeloBackend->link)) {
            if (mysql_num_rows($result) > 0) {
                if ($row = mysql_fetch_array($result)) {
                    $totalResultados = $row['total'];
                }
            }
        }

        if ($totalResultados > 0) {
            $totalPaginas = ceil($totalResultados / $maxPorPag);
        }

        if ($pagina < 2) {
            $pagDesde = 0;
        } else {
            $pagDesde = ($pagina - 1) * $maxPorPag;
        }

//                             echo "select " . $this->vista->stringCampos . " from " . $this->vista->stringTablas . " " . $this->vista->condicionTabla . " limit " . $pagDesde . "," . $maxPorPag;
        if ($result = mysql_query("select " . $this->vista->stringCampos . " from " . $this->vista->stringTablas . " " . $this->vista->condicionTabla . " limit " . $pagDesde . "," . $maxPorPag, $this->vista->modeloBackend->link)) {
            if (mysql_num_rows($result) > 0) {
                ?>
                <div class="tablacont">
                    <table width="940" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <?
                            foreach ($this->vista->masterArray['campos'] as $key => $value) { //Recorro los campos
                                if (isset($value['reporteTabla'])) {
                                    ?>
                                    <th scope="col"><?= $value['reporteTabla'] ?></th>
                                    <?
                                }
                            }
                            ?>
                        </tr>
                        <?
                        $contFondo = 1;
                        while ($row = mysql_fetch_array($result)) {

                            $row = $this->vista->modeloBackend->limpiarEscapes($row);
                            ?>
                            <tr <?
                            if ($contFondo % 2 == 0) {
                                echo 'class="fnd-gris"';
                            }
                            ?>>
                                    <?
                                    foreach ($this->vista->masterArray['campos'] as $key => $value) { //Recorro los campos
                                        if (isset($value['reporteTabla'])) {
                                            ?>
                                        <td>
                                            <?
                                            if ($value['reporteTabla'] == "editar") {
                                                ?>
                                                <a class="linkeditar" href="<?= $this->vista->globales['actionBaseForm'] ?>&<?=nomParamVista?>=editar&accion=editar&id=<?= $row['id'] ?>">Editar</a>
                                                <?
                                            } else if ($value['reporteTabla'] == "borrar") {
                                                ?>
                                                <a class="borrarFicha" href="<?= $this->vista->globales['actionBaseForm'] ?>&<?=nomParamVista?>=editar&accion=borrar&id=<?= $row['id'] ?>">Borrar</a>
                                                <?
                                            } else {

                                            if (isset($value['alias']) && !empty($value['alias'])) {
                                                $valorCampo = $value['alias'];
                                            } else {
                                                $valorCampo = $value['bd'];
                                            }

                                            if (isset($row[$valorCampo])) {

                                                if (preg_match("/precio/i", $valorCampo) || preg_match("/valor/i", $valorCampo)) {
                                                    echo $this->vista->objForm->formatoPrecio($row[$valorCampo]);
                                                } else {
                                                    echo $row[$valorCampo];
                                                }
                                            }
                                            ?>
                                        </td>
                                        <?
                                    }
                                }
                                }
                                ?>
                            </tr>
                            <?
//                                            }
                            $contFondo++;
                        }
                        ?>
                    </table>
                    <div class="clear"></div>
                </div>
                <?
            }
        }
        ?>

        <div class="clear"></div>
    </div>
    <div class="row paginador">
        <div class="pag">
            <div class="txt-pag">P&Aacute;GINA</div>
            <div class="sel-cont">
                <select name="selectPag">
                    <?
                    for ($i = 1; $i <= $totalPaginas; $i++) {
                        ?>
                        <option <?
                        if ($i == $pagina) {
                            echo "selected='selected'";
                        }
                        ?>><?= $i ?></option>
                            <?
                        }
                        ?>
                </select>
            </div>
            <div class="txt-pag">DE <?= $totalPaginas ?></div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>