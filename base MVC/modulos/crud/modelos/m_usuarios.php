<?

class m_usuarios extends modelo {

    public $tabla;

    public function __construct() {
        parent::Conectarse();
    }

//    function datosCliente() {
//
//        $resp = false;
//
//        if ($result = $this->read(array("nombres", "apellidos", "marcasAsignadas"), "usuariosCotizaciones", false, "usuario='" . $_SESSION['user'] . "'")) {
//
//            $resp = $result;
//        }
//
//        return $resp;
//    }

    function guardarUsuario($datos, $id = false, $modeloContrasena) {

        $resp = false;

        if (!$id) {
            //Verificar si el correo existe
            if ($this->read("*", $this->tabla, false, "email='" . $_POST[$datos[3]] . "'")) {
                return $resp;
            }
        }

        if (isset($_POST) && is_array($_POST) && is_array($datos)) {

            $this->limpiarXss();

            if (!$id) {

                $contrasena = md5(rand($min, getrandmax()));
                $llaveContrasena = md5(rand($min, getrandmax()));

                //Enviar por mail
                require_once("clases/class.phpmailer.php");
                require_once("clases/class.smtp.php");

                $textMail = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                        <html xmlns="http://www.w3.org/1999/xhtml">
                            <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                <title>Backend Derco</title>
                            </head>
                            <body style="color:#000 !important;font-family:Arial, Helvetica, sans-serif; font-size:12px; width:600px;">
                                    <img src="'.$_SERVER['SERVER_NAME'].str_replace("index.php","",$_SERVER['SCRIPT_NAME']).'img/imagentop.jpg" alt="Derco" width="600" height="100" />
                                    <h3 style="background-color:#34424f; font-size:14px; color:white !important; padding:4px;">Nuevo Usuario</h3>
                                    <div style="font-weight:normal; padding:10px;">
                                    <p style="text-transform:uppercase;text-align:center;">Hola <strong>' . $_POST[$datos[0]] . '</strong>, su contrase&ntilde;a es:</p>
                                    <p style="text-align:center; font-weight:bold;">' . $contrasena . '</p>
                                </div>
                            </body>
                        </html>';

                $receptorMail = $_POST[$datos[3]];
                $mail = new PHPMailer();
                $mail->Mailer = "smtp";
                $mail->SMTPAuth = true;
                $mail->Port = "465";
                $mail->Host = 'tls://email-smtp.us-east-1.amazonaws.com';
                $mail->Username = 'AKIAJNSZVLKGI7YZUTCA';
                $mail->Password = 'AhyyYtNfe2sQ3lf4ItKGYe1/pXw2w0prgr4jGK+CiJj3';
                $mail->From = "noreply@4sale.cl";
                $mail->FromName = "Backend Derco";
                $mail->Timeout = 20;
                $mail->Subject = "Nuevo Usuario";
                $mail->CharSet = "UTF-8";
                $receptorMail = trim($receptorMail);
                if (!empty($receptorMail)) {
                    $mail->AddAddress(trim($receptorMail));
                } else {
                    $mail->ErrorInfo = "Email vacío";
                }
                $mail->AddBCC("hectzimudec@gmail.com");
                $mail->Body = $textMail;
                $mail->IsHTML(true);

                $mail->Send();

                $contrasenaEncriptada = $modeloContrasena->encriptar($contrasena, $llaveContrasena);
            }

            //Marcas
            $listaMarcas = "";

//            print_r($_POST);

            if (isset($_POST[$datos[7]]) && is_array($_POST[$datos[7]])) {

                foreach ($_POST[$datos[7]] as $marcaAsignada) {
                    $marcaAsignada = $this->limpiarVariable($marcaAsignada);
//                    echo "marca: ".$marcaAsignada;
                    $listaMarcas.=$marcaAsignada . ",";
                }
                $listaMarcas = substr($listaMarcas, 0, -1);
            }

            //limpiar campos
            $this->limpiarInjection();

//            include("clases/Browser.php");

            $browser = new Browser();
            $navegador = $browser->getBrowser() . "-" . $browser->getVersion();

            //Guardar en bd
            $fechaActual = date("Y-m-d H:i:s");

            $arrayInsert = array(
                array("campo" => $datos[0], "valor" => $_POST[$datos[0]])
                , array("campo" => $datos[1], "valor" => $_POST[$datos[1]])
                , array("campo" => $datos[2], "valor" => $_POST[$datos[2]])
                , array("campo" => $datos[3], "valor" => $_POST[$datos[3]])
                , array("campo" => $datos[4], "valor" => $_POST[$datos[4]])
                , array("campo" => $datos[5], "valor" => $_POST[$datos[5]])
                , array("campo" => $datos[6], "valor" => $_POST[$datos[6]])
                , array("campo" => $datos[7], "valor" => $listaMarcas)
                , array("campo" => "fecha", "valor" => $fechaActual)
                , array("campo" => "ip", "valor" => $_SERVER['REMOTE_ADDR'])
            );

            if (!$id) {
                $arrayInsert = array_merge($arrayInsert, array(
                    array("campo" => "navegador", "valor" => $navegador)
                    , array("campo" => "contrasena", "valor" => $contrasenaEncriptada)
                    , array("campo" => "llaveContrasena", "valor" => $llaveContrasena)
                        ));
            }

//        if (1 == 1) {
            if ($idUsuario = $this->insert($arrayInsert, $this->tabla, $id)) {
                $resp = $idUsuario;
            }
        }

        return $resp;
    }
}

?>
