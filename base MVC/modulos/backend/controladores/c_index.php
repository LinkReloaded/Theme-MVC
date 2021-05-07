<?

class c_index extends controlador {

    function iniciar() {
        
        $this->cargarControlador("login", true, $_GET[nomParamModulo]);

        global $objForm;

        $masterArray=$this->vista->globales["arregloMaestro"];

        $modeloBackend = $this->cargarModelo("backend");
        $modeloSistema = $this->cargarModelo("sistema");

        $this->vista->listaMarcas = $modeloSistema->listaMarcas();

        //Datos del cliente
        $this->vista->datosCliente = $modeloBackend->datosCliente();

        $stringCampos = " ";
        $arrayTablas = array();
        $condicion = "";
        $orderBy = "";

        $contArrayTablas = 0;

        if (is_array($masterArray)) { //Veo si existe una lista de secciones
            if (isset($masterArray['condicion']) && !empty($masterArray['condicion'])) {
                $condicion = $masterArray['condicion'];
            }

            if (is_array($masterArray['campos'])) { //Veo si existe una lista de campos
                foreach ($masterArray['campos'] as $key => $value) { //Recorro los campos
                    if ($key == 0 && $stringCampos == " ") {

                        $stringCampos.=$value['tabla'] . "." . $value['bd'];
                        $orderBy = " order by " . $value['tabla'] . "." . $value['bd'] . " desc ";
                    } else {
                        if (!preg_match("/" . $value['tabla'] . "." . $value['bd'] . "/", $stringCampos)) {
                            $stringCampos.=", " . $value['tabla'] . "." . $value['bd'];
                        }
                    }

                    if (isset($value['alias']) && !empty($value['alias'])) {
                        $stringCampos.=" as " . $value['alias'];
                    }

                    //reviso si ya se agregó la tabla y agrego la tabla a la lista de tablas para la query en un array
                    if (!in_array($value['tabla'], $arrayTablas)) {

                        $arrayTablas[$contArrayTablas] = $value['tabla'];
                        $contArrayTablas++;
                    }

                    //reviso si hay una relación de tablas, y genero una condición para la query
                    if (isset($value['tablaFk']) && !empty($value['tablaFk']) && isset($value['bdFk']) && !empty($value['bdFk'])) {

                        $pkFk = "id";
//                echo "tablafk: ".$value['tablaFk'];
//                echo "pkfk: ".$value['pkFk'];
                        if (isset($value['pkFk']) && !empty($value['pkFk'])) {
                            $pkFk = $value['pkFk'];
                        }

                        if (!preg_match("/" . $value['tabla'] . "." . $pkFk . " = " . $value['tablaFk'] . "." . $value['bdFk'] . "/", $condicion)) {

                            if (!empty($condicion)) {
                                $condicion.=" and ";
                            }

                            $condicion.=$value['tabla'] . "." . $pkFk . " = " . $value['tablaFk'] . "." . $value['bdFk'];
                        }
                    }
                }
            } else {
                echo "Debe configurar los campos de BD de la seccion " . $masterArray['seccion'];
                exit();
            }

            $stringCampos.=" ";
        } else {
            echo "Debe configurar las secciones";
            exit();
        }

        $condicionFiltro = $condicion;

        $stringTablas = "";

//creo el el string de la lista de tablas para la query
        if (is_array($arrayTablas)) {
            $stringTablas = " ";
            foreach ($arrayTablas as $key => $value) {
                if ($key == 0) {
                    $stringTablas.=$value;
                } else {
                    $stringTablas.=", " . $value;
                }
            }
            $stringTablas.=" ";
        }

//crear condición a partir del filtro que se solicite
        if (isset($_GET['filtro'])) {

            $datosCampoFiltrado = "";

            //buscar el tipo de filtro según el nombre del filtro solicitado
            foreach ($masterArray['campos'] as $key => $value) { //Recorro los campos
                if (isset($value['nomFiltro']) && $value['idFiltro'] == $_GET['filtro']) {

                    $datosCampoFiltrado = $value;
                    break;
                }
            }

            //crear la condición para filtrar
            if (isset($datosCampoFiltrado['tipoFiltro'])) {
                switch ($datosCampoFiltrado['tipoFiltro']) {
                    case "rangoFecha":
//                        if (isset($_GET['inicioMes']) && isset($_GET['inicioAnio']) && isset($_GET['finMes']) && isset($_GET['finAnio'])) {
                        if (isset($_GET['filtroFechaMin']) && isset($_GET['filtroFechaMax'])) {

                            if (!empty($condicion)) {
                                $condicion.=" and ";
                            } else {
                                $condicion = " where ";
                            }

                            $filtroFechaMinTmp = explode("-", $_GET['filtroFechaMin']);
                            $filtroFechaMin = $filtroFechaMinTmp[2] . "-" . $filtroFechaMinTmp[1] . "-" . $filtroFechaMinTmp[0];
                            $filtroFechaMaxTmp = explode("-", $_GET['filtroFechaMax']);
                            $filtroFechaMax = $filtroFechaMaxTmp[2] . "-" . $filtroFechaMaxTmp[1] . "-" . $filtroFechaMaxTmp[0];

//                            $condicion.="date(".$datosCampoFiltrado['tabla'] . "." . $datosCampoFiltrado['bd'] . ") >='" . $filtroFechaMin . "' and date(" . $datosCampoFiltrado['tabla'] . "." . $datosCampoFiltrado['bd'] . ") <='" . $filtroFechaMax . "' order by " . $datosCampoFiltrado['tabla'] . "." . $datosCampoFiltrado['bd'] . " desc";
                            $condicion.="date(" . $datosCampoFiltrado['tabla'] . "." . $datosCampoFiltrado['bd'] . ") >='" . $filtroFechaMin . "' and date(" . $datosCampoFiltrado['tabla'] . "." . $datosCampoFiltrado['bd'] . ") <='" . $filtroFechaMax . "'";
                        }
                        break;
                    case "rangoNormal2":

                        if (isset($_GET['inicioRango']) && isset($_GET['finRango'])) {

                            if (!empty($condicion)) {
                                $condicion.=" and ";
                            } else {
                                $condicion = " where ";
                            }

                            $filtroFechaMinTmp = explode("-", $_GET['inicioRango']);
                            $filtroFechaMin = $filtroFechaMinTmp[2] . "-" . $filtroFechaMinTmp[1] . "-" . $filtroFechaMinTmp[0];
                            $filtroFechaMaxTmp = explode("-", $_GET['finRango']);
                            $filtroFechaMax = $filtroFechaMaxTmp[2] . "-" . $filtroFechaMaxTmp[1] . "-" . $filtroFechaMaxTmp[0];

//                            $condicion.="date(".$datosCampoFiltrado['tabla'] . "." . $datosCampoFiltrado['bd'] . ") >='" . $filtroFechaMin . "' and date(" . $datosCampoFiltrado['tabla'] . "." . $datosCampoFiltrado['bd'] . ") <='" . $filtroFechaMax . "' order by " . $datosCampoFiltrado['tabla'] . "." . $datosCampoFiltrado['bd'] . " desc";
                            $condicion.="date(" . $datosCampoFiltrado['tabla'] . "." . $datosCampoFiltrado['bd'] . ") >='" . $filtroFechaMin . "' and date(" . $datosCampoFiltrado['tabla'] . "." . $datosCampoFiltrado['bd'] . ") <='" . $filtroFechaMax . "'";
                        }
                        break;
                    case "normal2":
                    case "normal":
                        if (!empty($condicion)) {
                            $condicion.=" and ";
                        } else {
                            $condicion = " where ";
                        }
                        $condicion.=$datosCampoFiltrado['tabla'] . "." . $datosCampoFiltrado['bd'] . "='" . $_GET[$datosCampoFiltrado['idFiltro']] . "'";
                        break;

                    case "rangoEdad":
                        if (isset($_GET['inicioEdad']) && isset($_GET['finEdad'])) {
                            if (!empty($condicion)) {
                                $condicion.=" and ";
                            } else {
                                $condicion = " where ";
                            }
                            $condicion.="TIMESTAMPDIFF(YEAR, DATE(" . $datosCampoFiltrado['tabla'] . "." . $datosCampoFiltrado['bd'] . "), NOW()) >=" . $_GET['inicioEdad'] . " and TIMESTAMPDIFF(YEAR, DATE(" . $datosCampoFiltrado['tabla'] . "." . $datosCampoFiltrado['bd'] . "), NOW()) <=" . $_GET['finEdad'];
                        }
                        break;
                }
            }
        } else {
//            $condicion.=$orderBy;
        }

        $condicionTabla = $condicion;

        if (!isset($_GET['marcaTabla'])) {
            $_GET['marcaTabla'] = $_GET['marcaSel'][0];
        }

        if (isset($_GET['marcaTabla']) && !empty($_GET['marcaTabla'])) {
            if (preg_match("/" . $_GET['marcaTabla'] . "/", $this->vista->datosCliente[0]['marcasAsignadas'])) { //verificar permisos
                if (!empty($condicion)) { //
                    $condicionTabla.=" and";
                }

                $condicionTabla.=" marca='" . $_GET['marcaTabla'] . "'";
            }
        }

        if (isset($_GET['marcaSel']) && is_array($_GET['marcaSel'])) { //Si se solicita filtrar por marca
            if (preg_match("/" . $_GET['marcaSel'][0] . "/", $this->vista->datosCliente[0]['marcasAsignadas'])) { //verificar permisos
                if (!empty($condicion)) { //
                    $condicion.=" and";
                }

                $condicion.=" (marca='" . $_GET['marcaSel'][0] . "'";

                foreach ($_GET['marcaSel'] as $key => $marcaSel) {
                    if ($key > 0) {
                        if (preg_match("/" . $marcaSel . "/", $this->vista->datosCliente[0]['marcasAsignadas'])) { //verificar permisos
                            $condicion.=" or marca='" . $marcaSel . "'";
                        }
                    }
                }

                $condicion.=")";
            }
        } else if (isset($_GET['buscar'])) {
            foreach ($this->vista->listaMarcas as $listaMarcas1) {
                $_GET['marcaSel'][] = $listaMarcas1[0];
            }
        } else {
            $_GET['marcaSel'][] = "";
        }

        if (!empty($condicion)) {
            $condicion = " where " . $condicion;
        }

        if (!empty($condicionTabla)) {
            $condicionTabla = " where " . $condicionTabla;
        }
        if (!empty($condicionFiltro)) {
            $condicionFiltro = " where " . $condicionFiltro;
        }

        $condicion.=$orderBy;
        $condicionTabla.=$orderBy;


//generar excel
        if (isset($_GET['genExcel'])) {

            require_once("clases/excel.php");
            require_once("clases/excel-ext.php");
//                                 echo "select " . $stringCampos . " from " . $stringTablas . " " . $condicion;
            if ($result = mysql_query("select " . $stringCampos . " from " . $stringTablas . " " . $condicion, $modeloBackend->link)) {
                if (mysql_num_rows($result) > 0) {
                    while ($datatmp = mysql_fetch_assoc($result)) {
                        $data[] = $objForm->quitarUtf8($datatmp);
                    }
                }
            }
            // Generamos el Excel 
            createExcel("planillaDerco.xls", $data);
        }
        $this->vista->masterArray = $masterArray;
        $this->vista->stringTablas = $stringTablas;
        $this->vista->stringCampos = $stringCampos;
        $this->vista->condicionFiltro = $condicionFiltro;
        $this->vista->condicion = $condicion;
        $this->vista->condicionTabla = $condicionTabla;
        $this->vista->modeloBackend = $modeloBackend;
        $this->vista->objForm = $objForm;

        $this->cargarVista("backend");
        @mysql_close($modeloBackend->link);

        //Cargar vista
//        $objVista = $this->cargarVista($_GET[nomParamControlador]);
    }

}

?>