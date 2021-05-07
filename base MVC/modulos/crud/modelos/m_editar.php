<?

class m_editar extends modelo {

    public function __construct() {
        parent::Conectarse();
    }

    function verificarContrasena($contrasena) {
        $resp = false;

        if (isset($_SESSION['logged']) && isset($_SESSION['idUser'])) {
            if ($result = mysql_query("select * from backend_usuarios where id='" . $_SESSION['idUser'] . "' and accesoBackend='si' limit 1", $this->link)) {
                if (mysql_num_rows($result) > 0) {
                    if ($row = mysql_fetch_array($result)) {
                        //Verificar contraseña
//                        echo "verificando si pass: ".$contrasena;
//                        echo "<br/>Encriptada: ".$this->objLogin->encriptar($contrasena, $row['llaveContrasena']);
//                        echo "<br/>Sea igual a: ".$row['contrasena'];
                        if ($this->objLogin->encriptar($contrasena, $row['llaveContrasena']) == $row['contrasena']) {
                            $resp = true;
                        }
                    }
                }
            }
        }

        return $resp;
    }

    function cambiarContrasena($actual, $nueva1, $nueva2) {

        $resp = "";

        if (!empty($actual) && !empty($nueva1) && !empty($nueva2)) {

            if (isset($_SESSION['logged']) && isset($_SESSION['idUser'])) { //Si la sesión está iniciada
                
                if ($this->verificarContrasena($actual)) { //Si la contraseña actual es correcta

                    if ($nueva1 == $nueva2 && (strlen($nueva1) >= 8)) { //Revisar si contraseñas nuevas son iguales y tienen 8 caracteres o mas
                        //Cambiar contraseña antigua por la nueva
                        $contrasena = $nueva1;
                        $llaveContrasena = md5(rand($min, getrandmax()));
                        
                        $contrasenaEncriptada = $this->objLogin->encriptar($contrasena, $llaveContrasena);
                        
//                        include("clases/Browser.php");

                        $browser = new Browser();
                        $navegador = $browser->getBrowser() . "-" . $browser->getVersion();

                        //Guardar en bd
                        $fechaActual = date("Y-m-d H:i:s");
                        $arrayInsert = array(
                            array("campo" => "fecha", "valor" => $fechaActual)
                            , array("campo" => "ip", "valor" => $_SERVER['REMOTE_ADDR'])
                            , array("campo" => "navegador", "valor" => $navegador)
                            , array("campo" => "contrasena", "valor" => $contrasenaEncriptada)
                            , array("campo" => "llaveContrasena", "valor" => $llaveContrasena)
                        );
                        if (!$idUsuario = $this->insert($arrayInsert, "backend_usuarios", $_SESSION['idUser'])) {
//                            $resp = "No se actualizó correctamente. Intente nuevamente.";
                            $resp = "3";
                        }else{
                            $resp = "1";
                        }
                    }
                }else{
//                    $resp = "Su contraseña actual es incorrecta.";
                    $resp = "2";
                }
            }
        }

        return $resp;
    }

}

?>
