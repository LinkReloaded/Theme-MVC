<?

class c_usuarios extends controlador {

    function iniciar() {

        $this->cargarControlador("login", true);

        if ($_SESSION['permisos']['tipoUsuario'] != "1") { //si usuario no tiene permiso
            header("Location: " . $this->vista->globales['actionBaseForm']);
            exit();
        }

        $tablaGeneral = $this->vista->globales['tablaBd'];

        $modeloBackend = $this->cargarModelo("backend");
        $modeloSistema = $this->cargarModelo("sistema");
        $modeloUsuarios = $this->cargarModelo("usuarios");
        $modeloUsuarios->tabla = $tablaGeneral;

        //Datos del cliente
        $this->vista->datosCliente = $modeloBackend->datosCliente();

        $this->vista->campo[0] = "nombres";
        $this->vista->campo[1] = "apellidos";
        $this->vista->campo[2] = "empresa";
        $this->vista->campo[3] = "email";
        $this->vista->campo[4] = "tipoUsuario";
        $this->vista->campo[5] = "recibeCorreo";
        $this->vista->campo[6] = "accesoBackend";
        $this->vista->campo[7] = "marcasAsignadas";

        $this->vista->listaMarcas = $modeloSistema->listaMarcas();

        if (isset($_GET['accion'])) {

            foreach ($this->vista->campo as $nomCampo) {
                $this->vista->resultUsuario[$nomCampo] = false;
            }

            //Configurando validador de formulario
            $this->validaForm1 = new formularios(); //Instanciar objeto, indicando una palabra clave para identificar al formulario
            $this->validaForm1->idForm = "form1"; //Id del formulario
            $this->validaForm1->incluirJquery = true; //Porque wp ya incluse una versión, la cual es compatible con ciertos plugin
            $this->validaForm1->validacionJs = true; //Si se deja "false", solo validará por php
            $this->validaForm1->todosObligatorios = true; //Ningún campo debe estar vacío
            $this->validaForm1->incluirLocalidades = false;

            //Listado de campos a validar
            $this->validaForm1->parametros[0]['nombre'] = $this->vista->campo[0];
            $this->validaForm1->parametros[1]['nombre'] = $this->vista->campo[1];
            $this->validaForm1->parametros[2]['nombre'] = $this->vista->campo[2];
            $this->validaForm1->parametros[3]['nombre'] = $this->vista->campo[3];
            $this->validaForm1->parametros[3]['validacion'][0] = "email";
            $this->validaForm1->parametros[4]['nombre'] = $this->vista->campo[4];
            $this->validaForm1->parametros[5]['nombre'] = $this->vista->campo[5];
            $this->validaForm1->parametros[6]['nombre'] = $this->vista->campo[6];
//            $this->validaForm1->parametros[7]['nombre'] = $this->vista->campo[7];

            if ($this->validaForm1->validar()) {

                if (!isset($_POST['id']) || $_POST['id'] == "1") {
                    $_POST['id'] = false;
                }

                $stringHeader = "Location: " . $this->vista->globales['actionForm'];

                $modeloContrasena = $this->cargarModelo("login", true);

                //Guardar campos
                if ($_POST['id'] = $modeloUsuarios->guardarUsuario($this->vista->campo, $_POST['id'], $modeloContrasena)) {
                    $stringHeader.="&accion=editar&id=" . $_POST['id'] . "&estado=correcto";
                } else {
                    $stringHeader.="&accion=editar&id=" . $_POST['id'] . "&estado=error";
                }

                header($stringHeader);
                exit();
            }

            if (isset($_GET['id']) && !empty($_GET['id']) && $_GET['accion'] == "editar") {
                if ($resultUsuario = $modeloBackend->read("*", $tablaGeneral, $_GET['id'])) {
                    $this->vista->resultUsuario = $resultUsuario[0];
                }
            }

            //Borrar ficha
            if (isset($_GET['accion']) && $_GET['accion'] == "borrar" && isset($_GET['id']) && !empty($_GET['id'])) {
                if ($_SESSION['permisos']['tipoUsuario'] == "1") {
                    if ($modeloBackend->delete($tablaGeneral, $_GET['id'])) {
                        header("location: " . $this->vista->globales['actionForm'] . "&estado=borrado");
                        exit();
                    }
                } else {
                    header("location: " . $this->vista->globales['actionForm'] . "&estado=no%20tiene%20permisos");
                    exit();
                }
            }

            $this->cargarVista("detalleUsuario");
        } else {
            global $objForm;

            $masterArray = $this->vista->globales['arregloMaestro'];

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
                        if (isset($value['tabla']) && !empty($value['tabla'])) {
                            if (!in_array($value['tabla'], $arrayTablas)) {

                                $arrayTablas[$contArrayTablas] = $value['tabla'];
                                $contArrayTablas++;
                            }
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

            if (!empty($condicion)) {
                $condicion.=" and id!='1'";
            } else {
                $condicion.="id!='1'";
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
//                                    $condicion = " where ";
                                }

                                $filtroFechaMinTmp = explode("-", $_GET['filtroFechaMin']);
                                $filtroFechaMin = $filtroFechaMinTmp[2] . "-" . $filtroFechaMinTmp[1] . "-" . $filtroFechaMinTmp[0];
                                $filtroFechaMaxTmp = explode("-", $_GET['filtroFechaMax']);
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
//                                $condicion = " where ";
                            }
                            $condicion.=$datosCampoFiltrado['tabla'] . "." . $datosCampoFiltrado['bd'] . "='" . $_GET[$datosCampoFiltrado['idFiltro']] . "'";
                            break;

                        case "rangoEdad":
                            if (isset($_GET['inicioEdad']) && isset($_GET['finEdad'])) {
                                if (!empty($condicion)) {
                                    $condicion.=" and ";
                                } else {
//                                    $condicion = " where ";
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

            $_GET['marcaSel'][] = "";

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
                //Generamos el Excel 
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

            $this->cargarVista("usuarios");
        }
        @mysql_close($modeloBackend->link);
    }

}

?>
