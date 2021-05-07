<?

class BD {

    public $link;

    public function __construct() {

//        $this->link=$this->Conectarse();
    }

    //Crear conexión a la BD
    function Conectarse($host = false, $usuario = false, $contrasena = false, $bd = false) {

        if (!$host || !$usuario || !$contrasena || !$bd) {
            $host = HOST;
            $usuario = USER;
            $contrasena = PASS;
            $bd = DB;
        }

//        mysql_connect($host,$usuario,$contrasena) or die(mysql_error());
        if (!($this->link = mysql_connect($host, $usuario, $contrasena))) {
            echo "Error conectando a la base de datos.";
            exit();
        }
        if (!mysql_select_db($bd, $this->link)) {
            echo "Error seleccionando la base de datos.";
            exit();
        }

        mysql_query("SET NAMES 'utf8'");

        return $this->link;
    }

    //Limpia una variable de ataques sql injection y xss
    function limpiarVariable($variable, $tipoLimpieza = "todo") {

        switch ($tipoLimpieza) {

            case "scripts": $variable = str_replace("script", "_", $variable);
                break;

            case "escapes": $variable = str_replace("\\", "", $variable);
                break;

            case "sqlInjection": $variable = mysql_real_escape_string($variable, $this->link);
                break;

            default: $variable = str_replace("script", "_", $variable);
                $variable = str_replace("\\", "", $variable);
                $variable = mysql_real_escape_string($variable, $this->link);
        }

        return $variable;
    }

    //Limpia todas las variables GET, POST y REQUEST de "escapes" extras
    function limpiarEscapes($arreglo = false) {

        if ($arreglo && is_array($arreglo)) {
            foreach ($arreglo as $key => $val) {
                $arreglo[$key] = str_replace("\\", "", $arreglo[$key]);
            }

            return $arreglo;
        } else {

            if (is_array($_GET)) {
                foreach ($_GET as $key => $val) {
                    $_GET[$key] = str_replace("\\", "", $_GET[$key]);
                }
            }

            if (is_array($_POST)) {
                foreach ($_POST as $key => $val) {
                    $_POST[$key] = str_replace("\\", "", $_POST[$key]);
                }
            }

            if (is_array($_REQUEST)) {
                foreach ($_REQUEST as $key => $val) {

                    $_REQUEST[$key] = str_replace("\\", "", $_REQUEST[$key]);
                }
            }
        }
    }

    //Limpia todas las variables GET, POST y REQUEST de ataques xss
    function limpiarXss() {

        if (is_array($_GET)) {
            foreach ($_GET as $key => $val) {
                $_GET[$key] = str_replace("script", "_", $_GET[$key]);
            }
        }

        if (is_array($_POST)) {
            foreach ($_POST as $key => $val) {
                $_POST[$key] = str_replace("script", "_", $_POST[$key]);
            }
        }

        if (is_array($_REQUEST)) {
            foreach ($_REQUEST as $key => $val) {
                $_REQUEST[$key] = str_replace("script", "_", $_REQUEST[$key]);
            }
        }
    }

    //Limpia todas las variables GET, POST y REQUEST de ataques sql injection
    function limpiarInjection() {

        $this->limpiarEscapes();

        if (is_array($_GET)) {
            foreach ($_GET as $key => $val) {

                $_GET[$key] = str_replace("\\", "", $_GET[$key]);
//                $_GET[$key]=str_replace("script", "_", $_GET[$key]);
                @$_GET[$key] = mysql_real_escape_string($_GET[$key], $this->link);
            }
        }

        if (is_array($_POST)) {
            foreach ($_POST as $key => $val) {
//echo "ANTES: key: ".$key." => valor: ".$_POST[$key];
                $_POST[$key] = str_replace("\\", "", $_POST[$key]);
//                $_POST[$key]=str_replace("script", "_", $_POST[$key]);
                @$_POST[$key] = mysql_real_escape_string($_POST[$key], $this->link);
//                echo "DESPUES: key: ".$key." => valor: ".$_POST[$key];  
            }
        }

        if (is_array($_REQUEST)) {
            foreach ($_REQUEST as $key => $val) {

                $_REQUEST[$key] = str_replace("\\", "", $_REQUEST[$key]);
//                $_REQUEST[$key]=str_replace("script", "_", $_REQUEST[$key]);
                @$_REQUEST[$key] = mysql_real_escape_string($_REQUEST[$key], $this->link);
            }
        }
    }

    //Limpia todas las variables GET, POST y REQUEST de ataques sql injection y xss
    function limpiarTodo() {

        if (is_array($_GET)) {
            foreach ($_GET as $key => $val) {

                if (!empty($_GET[$key]) && !is_array($_GET[$key])) {

                    $_GET[$key] = str_replace("\\", "", $_GET[$key]);
                    $_GET[$key] = str_replace("script", "_", $_GET[$key]);
//                    if(isset($this->link) && $this->link){
//                        $_GET[$key]=mysql_real_escape_string($_GET[$key], $this->link);
//                    }
                }
            }
        }

        if (is_array($_POST)) {
            foreach ($_POST as $key => $val) {
                if (!empty($_POST[$key]) && !is_array($_POST[$key])) {
//echo "ANTES: key: ".$key." => valor: ".$_POST[$key];
                    $_POST[$key] = str_replace("\\", "", $_POST[$key]);
                    $_POST[$key] = str_replace("script", "_", $_POST[$key]);
//                    if(isset($this->link) && $this->link){
//                        $_POST[$key]=mysql_real_escape_string($_POST[$key], $this->link);
//                    }
//                echo "DESPUES: key: ".$key." => valor: ".$_POST[$key];
                }
            }
        }

        if (is_array($_REQUEST)) {
            foreach ($_REQUEST as $key => $val) {
//                echo $key."=>antes: ".$_REQUEST[$key]."<br/>";
                if (!empty($_REQUEST[$key]) && !is_array($_REQUEST[$key])) {
                    $_REQUEST[$key] = str_replace("\\", "", $_REQUEST[$key]);
                    $_REQUEST[$key] = str_replace("script", "_", $_REQUEST[$key]);
//                    if(isset($this->link) && $this->link){
//                        $_REQUEST[$key]=mysql_real_escape_string($_REQUEST[$key], $this->link);
//                    }
                }
//                echo $key."=>despues: ".$_REQUEST[$key]."<br/>";
            }
        }
    }

    //Transforma los caracteres de un string en su equivalente en html entities
    function entities($variable) {

        $variable = str_replace("\\", "", $variable);
        $variable = htmlentities($variable);

        return $variable;
    }

    //Bota la conexión a la bd y finaliza el script
    function cerrarScript() {
        @mysql_close($this->link);
        exit();
    }

    //Crear un campo en una tabla, si no existe
    function crearCampo($tabla, $campo) {

        $resp = true;

        if (preg_match("/fecha/", $campo) || preg_match("/date/", $campo)) {
            $tipoCampo = "DATETIME";
        } else if (preg_match("/orden/", $campo)) {
            $tipoCampo = "INT";
        } else {
            $tipoCampo = "TEXT";
        }

        if (!empty($tabla)) {
//            echo "<br/>Creando Campo: ".$campo." en tabla ".$tabla;
//            echo "<br/>"."ALTER TABLE `".$tabla."` ADD COLUMN `".$campo."` ".$tipoCampo." NULL";
            @mysql_query("ALTER TABLE `" . $tabla . "` ADD COLUMN `" . $campo . "` " . $tipoCampo . " NULL", $this->link);
        }

        return $resp;
    }

    //Leer los campos de una tabla
    function read($campos, $tabla, $id = false, $condicionExtra = false) {

        $resp = false;

//        echo "<br/><br/>Read: ";
//        print_r($campos);

        if (!empty($tabla)) {

            $listaCampos = "";

            if (is_array($campos)) {
                foreach ($campos as $campo) {

                    if ($campo) {
                        //crear campo si no existe
                        $this->crearCampo($tabla, $campo);

                        $listaCampos.="`" . $campo . "`,";
                    }
                }
                $listaCampos = substr($listaCampos, 0, -1);
            } else {

                $listaCampos = "*";
            }

            $condicion = "";
            if (isset($id) && !empty($id) && $id) {
                $id = $this->limpiarVariable($id);
                $condicion = " where id='" . $id . "' limit 1";
            }

            if ($condicionExtra) {
                $condicionExtra = str_replace("where", "", $condicionExtra);
                if (!empty($condicion)) {
                    $condicion.=" and " . $condicionExtra;
                } else {
                    $condicion = " where " . $condicionExtra;
                }
            }
//                         echo "<br/>select ".$listaCampos." from ".$tabla.$condicion;
            if ($result = mysql_query("select " . $listaCampos . " from " . $tabla . $condicion, $this->link)) {
                if (mysql_num_rows($result) > 0) {
                    while ($rowResult = mysql_fetch_array($result)) {
                        $resp[] = $rowResult;
                    }
                }
            }
        }

//        echo "<br/><br/>Resultado Read:";
//        print_r($resp);

        return $resp;
    }

    //Insertar o actualizar registro de una tabla
    function insert($campos, $tabla, $id = false, $forzarInsert = false, $forzarUpdate = false, $condicionExtra = false) {

        $resp = false;

//        echo "<br/><br/>Insert: ";
//        print_r($campos);

        if (!empty($tabla) && is_array($campos)) {

            $listaCampos = "";
            $listaValores = "";

            if (($id && !$forzarInsert) || $forzarUpdate) {
                //actualizar
                foreach ($campos as $campo) {
//                    echo "<br/><br/>Campo: ".$campo['campo'];
//                    echo "<br/>Valor: : ".$campo['valor'];
                    if ($campo['campo'] != "id") {
                        //crear campo si no existe
                        $this->crearCampo($tabla, $campo['campo']);

                        //limpiar dato
                        $campo['valor'] = $this->limpiarVariable($campo['valor']);

                        $listaCampos.="`" . $campo['campo'] . "`='" . $campo['valor'] . "',";
                    }
                }

                $listaCampos = substr($listaCampos, 0, -1);

                //limpiar dato
                $id = $this->limpiarVariable($id);

                if ($id != "*" && $id != false) {
                    $condicion = " where id='" . $id . "' limit 1";
                } else {
                    $condicion = "";
                }

                if ($condicionExtra) {
                    $condicionExtra = str_replace("where", "", $condicionExtra);
                    if (!empty($condicion)) {
                        $condicion.=" and " . $condicionExtra;
                    } else {
                        $condicion = " where " . $condicionExtra;
                    }
                }
//                          echo "<br/>"."update ".$tabla." set ".$listaCampos.$condicion;
                if ($result = mysql_query("update " . $tabla . " set " . $listaCampos . $condicion, $this->link)) {
                    if ($id != "*" && $id != false) {
                        $resp = $id;
                    } else {
                        $resp = true;
                    }
                }
            } else {
                //insertar
                foreach ($campos as $campo) {

                    if ($campo['campo'] != "id" || $forzarInsert) {

                        //crear campo si no existe
                        $this->crearCampo($tabla, $campo['campo']);

                        //limpiar dato
                        $campo['valor'] = $this->limpiarVariable($campo['valor']);

                        $listaCampos.="`" . $campo['campo'] . "`,";
                        $listaValores.="'" . $campo['valor'] . "',";
                    }
                }

                $listaCampos = substr($listaCampos, 0, -1);
                $listaValores = substr($listaValores, 0, -1);

//                $condicion=" where id='".$id."' limit 1";
//                             echo "<br/>insert into ".$tabla." (".$listaCampos.") values (".$listaValores.")";
                if ($result = mysql_query("insert into " . $tabla . " (" . $listaCampos . ") values (" . $listaValores . ")", $this->link)) {

                    $resp = $this->ultimoInsertado();
                    if (!$resp) {
                        $resp = true;
                    }
                }
            }
        }

        return $resp;
    }

    //borrar registros de una tabla
    function delete($tabla, $id = false, $condicionExtra = false) {

        $resp = false;

        if (!empty($tabla)) {

            $condicion = "";
            if (isset($id) && !empty($id) && $id) {
                $id = $this->limpiarVariable($id);
                $condicion = " where id='" . $id . "' limit 1";
            }

            if ($condicionExtra) {
                $condicionExtra = str_replace("where", "", $condicionExtra);
                if (!empty($condicion)) {
                    $condicion.=" and " . $condicionExtra;
                } else {
                    $condicion = " where " . $condicionExtra;
                }
            }

//                      echo "delete from ".$tabla.$condicion;
            if (mysql_query("delete from " . $tabla . $condicion, $this->link)) {
                $resp = true;
            }
        }

        return $resp;
    }

    function ultimoInsertado() {

        $resp = false;

        if ($result = mysql_query("SELECT LAST_INSERT_ID()", $this->link)) {
            if (mysql_num_rows($result) > 0) {
                if ($row = mysql_fetch_array($result)) {
                    $resp = $row[0];
                }
            }
        }

        return $resp;
    }

    function duplicarContTabla($tabla1, $tabla2, $truncar = true, $condicion = false) {

        $camposTabla = false;

//        echo "Copiando tabla '".$tabla1."' en tabla '".$tabla2."'";
//        echo "<br/>".date("H:i:s")." - Inicio copiar tabla";
        //crear tabla si no existe
        if (mysql_query("CREATE  TABLE `" . $tabla2 . "` (
                        `id` INT NOT NULL AUTO_INCREMENT ,
                        PRIMARY KEY (`id`) )
                        ENGINE = InnoDB;
                        ", $this->link)) {
            
        }
//        echo "<br/>".date("H:i:s")." - obtener campos de la tabla";
        //obtener campos de la tabla
        if ($resultCamposTabla = mysql_query("SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_NAME = '$tabla1' and TABLE_SCHEMA='" . DB . "'", $this->link)) {
            if (mysql_num_rows($resultCamposTabla) > 0) {

                if ($truncar) {
                    //limpiar tabla2 de datos
                    if (!mysql_query("truncate table " . $tabla2 . "", $this->link)) {
//                            echo "No se pudo truncar la tabla";
                    }
                }

                $i = 0;
//                    echo "<br/>".date("H:i:s")." - recorremos los campos de la tabla";
                //recorremos los campos de la tabla
                while ($rowCamposTabla = mysql_fetch_array($resultCamposTabla)) {
//                        echo "<br/><br/>Campos: ";
//                        print_r($rowCamposTabla);
                    //guardamos los campos en un arreglo
                    $camposTabla[$i] = $rowCamposTabla[0];

                    $i++;
                }
                //                print_r($respRead);
//                    print_r($camposTabla);
                $arregloInsert = false;

                if (isset($camposTabla) && is_array($camposTabla)) {
//                    echo "info: ";
//                        print_r($camposTabla);
                    //obtener datos de la tabla
                    if ($respRead = $this->read($camposTabla, $tabla1, false, $condicion)) {

//    print_r($respRead);
//                            echo "<br/>".date("H:i:s")." - crear arreglo para realizar insert a la nueva tabla";
                        //crear arreglo para realizar insert a la nueva tabla
                        foreach ($respRead as $key => $reg) {
                            //                    print_r($reg);
//                                echo "<br/>".date("H:i:s")." - Preparando insert";
                            $j = 0;
                            foreach ($camposTabla as $campoTabla) {
                                //                        echo "<br/>campo: ".$campoTabla;
                                //                        echo "<br/>valor: ".$reg[$campoTabla];

                                $arregloInsert[$j]['campo'] = $campoTabla;
                                $arregloInsert[$j]['valor'] = $reg[$campoTabla];

                                //insertar

                                $j++;
                            }

//                                echo "<br/>".date("H:i:s")." - Si no existe el campo, forzar su creación";
                            //Si no existe el campo, forzar su creación
                            if ($this->read("*", $tabla2, $reg['id'])) {

                                $forzarInsert = false;
                                $forzarUpdate = true;
                                $condicionDestino = "id='" . $reg['id'] . "'";
                            } else {

                                $forzarInsert = true;
                                $forzarUpdate = false;
                                $condicionDestino = false;
                            }

//                                echo "<br/>".date("H:i:s")." - Insertando datos";
                            $this->insert($arregloInsert, $tabla2, false, $forzarInsert, $forzarUpdate, $condicionDestino);
//                                echo "<br/>".date("H:i:s")." - Fin";
                        }
                    }
                }
            }
        } else {
            echo "No se pudo obtener los campos de la tabla.";
        }
    }

    function crearTabla($tabla) {

        $resp = false;

        if (!empty($tabla)) {
            if (mysql_query("CREATE TABLE `" . $tabla . "` (
                                    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                                    PRIMARY KEY (`id`)
                                  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;", $this->link)
            ) {
                $resp = true;
            }
        }

        return $resp;
    }

}

?>