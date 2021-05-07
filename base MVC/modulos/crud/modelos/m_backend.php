<?

class m_backend extends modelo {

    public function __construct() {
        parent::Conectarse();
    }

    function datosCliente() {

        $resp = false;

        if ($result = $this->read(array("nombres", "apellidos", "marcasAsignadas", "tipoUsuario"), "backend_usuarios", false, "id='" . $_SESSION['idUser'] . "'")) {

            $resp = $result;
        }

        return $resp;
    }

    function filtro($seccion, $campo, $masterArray, $stringTablas, $stringCampos, $condicion, $visible) {

        switch ($campo['tipoFiltro']) {

            case "rangoFecha": //buscar el año mínimo y año máximo registrado
                $minFecha = $maxFecha = "";
                if ($resultDate = mysql_query("select MIN(DATE(" . $campo['bd'] . ")) as minDate from " . $campo['tabla'], $this->link)) {
                    if (mysql_num_rows($resultDate) > 0) {
                        if ($rowDate = mysql_fetch_array($resultDate)) {
//                            if ($result = mysql_query("select CONCAT(YEAR(" . $rowDate['minDate'] . "),'-',MONTH(" . $rowDate['minDate'] . "),'-',DAY(" . $rowDate['minDate'] . ")) as minFecha", $this->link)) {
//                                if (mysql_num_rows($result) > 0) {
//                                    if ($row = mysql_fetch_array($result)) {
                            $minFechaTmp = explode("-", $rowDate['minDate']);
                            $minFecha = $minFechaTmp[2] . "-" . $minFechaTmp[1] . "-" . $minFechaTmp[0];
//                                    }
//                                }
//                            }
                        }
                    }
                }
                if ($resultDate = mysql_query("select MAX(DATE(" . $campo['bd'] . ")) as maxDate from " . $campo['tabla'], $this->link)) {
                    if (mysql_num_rows($resultDate) > 0) {
                        if ($rowDate = mysql_fetch_array($resultDate)) {
//                            if ($result = mysql_query("select CONCAT(YEAR(" . $rowDate['maxDate'] . "),'-',MONTH(" . $rowDate['maxDate'] . "),'-',DAY(" . $rowDate['maxDate'] . ")) as maxFecha", $this->link)) {
//                                if (mysql_num_rows($result) > 0) {
//                                    if ($row = mysql_fetch_array($result)) {
                            $maxFechaTmp = explode("-", $rowDate['maxDate']);
                            $maxFecha = $maxFechaTmp[2] . "-" . $maxFechaTmp[1] . "-" . $maxFechaTmp[0];
//                                    }
//                                }
//                            }
                        }
                    }
                }
                ?>

                <div id="<?= $campo['idFiltro'] ?>" class="row padd <?
                if (isset($_GET['filtro'])) {
                    if ($_GET['filtro'] != $campo['idFiltro']) {
                        echo "hidden";
                    }
                } else if ($visible != 1) {
                    echo "hidden";
                }
                ?>">
                                <!--                    <span>FECHA:</span><select name=""></select><span> / </span><select name=""></select><span class="clear textochico">(Dato Obligatorio)</span>-->

                    <form action="<?= $_SERVER['PHP_SELF'] ?>"  >
                <!--                    <table class="contFiltro">
                            <tr>
                                <td>-->
                        <?
                        if (isset($campo['tituloFiltro']) && !empty($campo['tituloFiltro'])) {
                            ?>
                            <span>
                                <?= $campo['tituloFiltro'] ?>: 
                            </span>
                            <?
                        }
                        ?>
                        <!--</td>-->
                        <?
                        //Fecha actual
                        $fechaActual = $maxFecha;
                        ?>
                        <!--<td>-->
                        <select name="filtroFechaMin">
                            <?
                            while ((strtotime($fechaActual)) >= (strtotime($minFecha))) {
                                $fechaOption = (date("d-m-Y", strtotime($fechaActual)));
                                ?>
                                <option value="<?= $fechaOption ?>" <?
                                if (isset($_GET['filtroFechaMin']) && $_GET['filtroFechaMin'] == $fechaOption) {
                                    echo "selected='selected'";
                                }
                                ?>><?= $fechaOption ?></option>
                                        <?
                                        $fechaActual = date("Y-m-d", strtotime($fechaActual . ' -1 day'));
                                    }
                                    ?>
                        </select><span> / </span>
                        <!--                            </td>
                                                </tr>
                                                <tr>
                                                    <td>-->
                        <?
                        if (isset($campo['tituloFiltro2']) && !empty($campo['tituloFiltro2'])) {
                            ?>
                            <?= $campo['tituloFiltro2'] ?>: 
                            <?
                        }
                        ?>
                        <!--                            </td>
                                                    <td>-->
                        <select name="filtroFechaMax">
                            <?
                            $fechaActual = $maxFecha;
                            while ((strtotime($fechaActual)) >= (strtotime($minFecha))) {
                                $fechaOption = (date("d-m-Y", strtotime($fechaActual)));
                                ?>
                                <option value="<?= $fechaOption ?>" <?
                                if (isset($_GET['filtroFechaMax']) && $_GET['filtroFechaMax'] == $fechaOption) {
                                    echo "selected='selected'";
                                }
                                ?>><?= $fechaOption ?></option>
                                        <?
                                        $fechaActual = date("Y-m-d", strtotime($fechaActual . ' -1 day'));
                                    }
                                    ?>
                        </select>
                        <!--<span class="clear textochico">(Dato Obligatorio)</span>-->
                        <!--                            </td>
                                                </tr>
                                            </table>-->
                    </form>
                    <div class="clear"></div>
                </div>
                <?
                break;

            case "rangoEdad":

                //buscar el año mínimo y año máximo registrado
                $minEdad = $maxEdad = "";

                if ($result = mysql_query("select max(TIMESTAMPDIFF(YEAR, DATE(" . $campo['tabla'] . "." . $campo['bd'] . "), NOW())) as edad from " . $campo['tabla'] . " where DATE(" . $campo['tabla'] . "." . $campo['bd'] . ") !='0000-00-00' order by " . $campo['tabla'] . "." . $campo['bd'] . " asc limit 1", $this->link)) {
                    if (mysql_num_rows($result) > 0) {
                        if ($row = mysql_fetch_array($result)) {
                            $maxEdad = $row['edad'];
                        }
                    }
                }

                if ($result = mysql_query("select min(TIMESTAMPDIFF(YEAR, DATE(" . $campo['tabla'] . "." . $campo['bd'] . "), NOW())) as edad from " . $campo['tabla'] . " where DATE(" . $campo['tabla'] . "." . $campo['bd'] . ") !='0000-00-00' order by " . $campo['tabla'] . "." . $campo['bd'] . " desc limit 1", $this->link)) {
                    if (mysql_num_rows($result) > 0) {
                        if ($row = mysql_fetch_array($result)) {
                            $minEdad = $row['edad'];
                        }
                    }
                }
                ?>
                <form id="<?= $campo['idFiltro'] ?>" action="<?= $_SERVER['PHP_SELF'] ?>" class="<?
                if (isset($_GET['filtro'])) {
                    if ($_GET['filtro'] != $campo['idFiltro']) {
                        echo "hidden";
                    }
                } else if ($visible != 1) {
                    echo "hidden";
                }
                ?>" >
                    <table  class="contFiltro">
                        <tr>
                            <td>
                                <?= $campo['tituloFiltro'] ?>
                            </td>
                            <td>
                                <select name="inicioEdad">
                                    <?
                                    if ((!empty($minEdad) || $minEdad == 0) && (!empty($maxEdad) || $maxEdad == 0)) {

                                        for ($i = $minEdad; $i <= $maxEdad; $i++) {
                                            ?>
                                            <option value="<?= $i ?>" <?
                                            if (isset($_GET['inicioEdad']) && $_GET['inicioEdad'] == $i) {
                                                echo "selected='selected'";
                                            }
                                            ?>><?= $i ?></option>
                                                    <?
                                                }
                                            }
                                            ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?= $campo['tituloFiltro2'] ?>
                            </td>
                            <td>
                                <select name="finEdad">
                                    <?
                                    if ((!empty($minEdad) || $minEdad == 0) && (!empty($maxEdad) || $maxEdad == 0)) {
                                        for ($i = $minEdad; $i <= $maxEdad; $i++) {
                                            ?>
                                            <option value="<?= $i ?>" <?
                                            if (isset($_GET['finEdad']) && $_GET['finEdad'] == $i) {
                                                echo "selected='selected'";
                                            }
                                            ?>><?= $i ?></option>
                                                    <?
                                                }
                                            }
                                            ?>
                                </select>
                            </td>
                        </tr>
                <!--                        <tr>
                            <td>Buscar</td>
                            <td><input type="hidden" name="buscar" vaue="Buscar" /></td>
                        </tr>-->
                    </table>
                </form>
                <?
                break;

            case "rangoNormal2":
                ?>
                <div id="<?= $campo['idFiltro'] ?>" class="row padd <?
                if (isset($_GET['filtro'])) {
                    if ($_GET['filtro'] != $campo['idFiltro']) {
                        echo "hidden";
                    }
                } else if ($visible != 1) {
                    echo "hidden";
                }
                ?>">

                    <form action="<?= $_SERVER['PHP_SELF'] ?>"  >
                        <label><?= $campo['tituloFiltro'] ?></label><span><input onblur="if (this.value == '') {
                                    this.value = 'dd-mm-aaaa';
                                }"  onfocus="if (this.value == 'dd-mm-aaaa') {
                                            this.value = '';
                                        }" name="inicioRango" type="text" value="<?
                                                                                 if (isset($_GET['inicioRango']) && !empty($_GET['inicioRango'])) {
                                                                                     echo $_GET['inicioRango'];
                                                                                 } else {
                                                                                     echo "dd-mm-aaaa";
                                                                                 }
                                                                                 ?>"></span>
                        <label><?= $campo['tituloFiltro2'] ?></label><span><input onblur="if (this.value == '') {
                                    this.value = 'dd-mm-aaaa';
                                }"  onfocus="if (this.value == 'dd-mm-aaaa') {
                                            this.value = '';
                                        }" name="finRango" type="text" value="<?
                                                                                  if (isset($_GET['finRango']) && !empty($_GET['finRango'])) {
                                                                                      echo $_GET['finRango'];
                                                                                  } else {
                                                                                      echo "dd-mm-aaaa";
                                                                                  }
                                                                                  ?>"></span>
                    </form>

                    <? /*

                      <span>FECHA:</span><select name=""></select><span> / </span><select name=""></select><span class="clear textochico">(Dato Obligatorio)</span>

                      <form action="<?= $_SERVER['PHP_SELF'] ?>"  >
                      <table  class="contFiltro">
                      <tr>
                      <td>
                      <?= $campo['tituloFiltro'] ?>
                      </td>
                      <td>
                      <input name="inicioRango" type="text" value="<?if(isset($_GET['inicioRango']) && !empty($_GET['inicioRango'])){echo $_GET['inicioRango'];}?>">
                      </td>
                      </tr>
                      <tr>
                      <td>
                      <?= $campo['tituloFiltro2'] ?>
                      </td>
                      <td>
                      <input name="finRango" type="text" value="<?if(isset($_GET['finRango']) && !empty($_GET['finRango'])){echo $_GET['finRango'];}?>">
                      </td>
                      </tr>
                      </table>
                      </form>
                     */ ?>
                    <div class="clear"></div>
                </div>
                <?
                break;
            case "rangoNormal":

                //buscar el año mínimo y año máximo registrado
                $minEdad = $maxEdad = "";

                if ($result = mysql_query("select max(" . $campo['tabla'] . "." . $campo['bd'] . ") as rango from " . $campo['tabla'] . " order by " . $campo['tabla'] . "." . $campo['bd'] . " asc limit 1", $this->link)) {
                    if (mysql_num_rows($result) > 0) {
                        if ($row = mysql_fetch_array($result)) {
                            $maxEdad = $row['rango'];
                        }
                    }
                }

                if ($result = mysql_query("select min(" . $campo['tabla'] . "." . $campo['bd'] . ") as rango from " . $campo['tabla'] . " order by " . $campo['tabla'] . "." . $campo['bd'] . " desc limit 1", $this->link)) {
                    if (mysql_num_rows($result) > 0) {
                        if ($row = mysql_fetch_array($result)) {
                            $minEdad = $row['rango'];
                        }
                    }
                }
                ?>
                <form id="<?= $campo['idFiltro'] ?>" action="<?= $_SERVER['PHP_SELF'] ?>" class="<?
                if (isset($_GET['filtro'])) {
                    if ($_GET['filtro'] != $campo['idFiltro']) {
                        echo "hidden";
                    }
                } else if ($visible != 1) {
                    echo "hidden";
                }
                ?>" >
                    <table  class="contFiltro">
                        <tr>
                            <td>
                                    <?= $campo['tituloFiltro'] ?>
                            </td>
                            <td>
                                <select name="inicioRango">
                                    <?
                                    if ((!empty($minEdad) || $minEdad == 0) && (!empty($maxEdad) || $maxEdad == 0)) {

                                        for ($i = $minEdad; $i <= $maxEdad; $i++) {
                                            ?>
                                            <option value="<?= $i ?>" <?
                                                    if (isset($_GET['inicioRango']) && $_GET['inicioRango'] == $i) {
                                                        echo "selected='selected'";
                                                    }
                                                    ?>><?= $i ?></option>
                        <?
                    }
                }
                ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                    <?= $campo['tituloFiltro2'] ?>
                            </td>
                            <td>
                                <select name="finRango">
                                    <?
                                    if ((!empty($minEdad) || $minEdad == 0) && (!empty($maxEdad) || $maxEdad == 0)) {
                                        for ($i = $minEdad; $i <= $maxEdad; $i++) {
                                            ?>
                                            <option value="<?= $i ?>" <?
                                                    if (isset($_GET['finRango']) && $_GET['finRango'] == $i) {
                                                        echo "selected='selected'";
                                                    }
                                                    ?>><?= $i ?></option>
                        <?
                    }
                }
                ?>
                                </select>
                            </td>
                        </tr>
                <!--                        <tr>
                            <td>Buscar</td>
                            <td><input type="hidden" name="buscar" vaue="Buscar" /></td>
                        </tr>-->
                    </table>
                </form>
                <?
                break;

            case "normal2":
            case "normal":
                ?>

                <div id="<?= $campo['idFiltro'] ?>" class="row padd <?
                if (isset($_GET['filtro'])) {
                    if ($_GET['filtro'] != $campo['idFiltro']) {
                        echo "hidden";
                    }
                } else if ($visible != 1) {
                    echo "hidden";
                }
                ?>">
                    <form action="<?= $_SERVER['PHP_SELF'] ?>" >

                            <?
                            if (isset($campo['tituloFiltro']) && !empty($campo['tituloFiltro'])) {
                                ?>
                            <span>
                            <?= $campo['tituloFiltro'] ?>
                            </span>
                            <?
                        }
                        ?>
                        <?
                        if ($campo['tipoFiltro'] == "normal2") {
                            ?>
                            <input name="<?= $campo['idFiltro'] ?>" type="text" value="<?
                                   if (isset($_GET[$campo['idFiltro']])) {
                                       echo $_GET[$campo['idFiltro']];
                                   }
                                   ?>">
                                <?
                            } else {
                                ?>
                            <select name="<?= $campo['idFiltro'] ?>">
                                <?
//                                    echo "select " . $campo['tabla'] . "." . $campo['bd'] . " from " . $stringTablas . " " . $condicion . " group by " . $campo['tabla'] . "." . $campo['bd'];
                                if ($result = mysql_query("select " . $campo['tabla'] . "." . $campo['bd'] . " from " . $stringTablas . " " . $condicion . " group by " . $campo['tabla'] . "." . $campo['bd'], $this->link)) {

                                    if (mysql_num_rows($result) > 0) {
                                        while ($row = mysql_fetch_array($result)) {
                                            ?>
                                            <option value="<?= strtolower($row[$campo['bd']]) ?>" <?
                                                    if (isset($_GET[$campo['idFiltro']]) && $_GET[$campo['idFiltro']] == strtolower($row[$campo['bd']])) {
                                                        echo "selected='selected'";
                                                    }
                                                    ?>><?= $row[$campo['bd']] ?></option>
                                                    <?
                                                }
                                            }
                                        }
                                        ?>
                            </select>
                    <?
                }
                ?>
                        <div class="clear"></div>

                    </form>
                </div>
                <?
                break;
        }
    }

//funcion que busca e imprime los filtros de la sección actual
    function filtrado($seccion, $masterArray, $stringTablas, $stringCampos, $condicion) {

        //verificar si existe la sección
        ?>
        <div class="selector">
            <select id="selectFiltro" name="filtro">
                <?
                //iterar e imprimir la lista de filtros para seleccionar
                foreach ($masterArray['campos'] as $key => $value) {

                    if (isset($value['idFiltro']) && !empty($value['idFiltro'])) {

                        //imprimir combobox con listado de filtros para seleccionar
                        ?>
                        <option value="<?= $value['idFiltro'] ?>" <?
                                if (isset($_GET['filtro']) && $_GET['filtro'] == $value['idFiltro']) {
                                    echo "selected='selected'";
                                }
                                ?>><?= $value['nomFiltro'] ?></option>
                <?
            }
        }
        ?>
            </select>
        </div>
        <div id="formFiltro" class="seleccionado">
            <?
            $visible = 1;
            //iterar e imprimir los filtros con su contenido
            foreach ($masterArray['campos'] as $key => $value) {

                if (isset($value['tipoFiltro']) && !empty($value['tipoFiltro'])) {

                    $this->filtro($seccion, $value, $masterArray, $stringTablas, $stringCampos, $condicion, $visible, $this->link);
                    $visible = 0;
                }
            }
            ?>
            <div class="clear"></div>
        </div>    
        <?
    }

}
?>
