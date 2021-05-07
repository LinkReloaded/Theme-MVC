<?

class m_login extends modelo {

    public $sesion;

    public function __construct() {
        parent::Conectarse();
        $this->sesion = 0;
    }

    function verifSesion() {
//        include(carpetaClases . "sesionesUsuarios.php");
//        $usuario = new sesionesUsuario();

        $error = "";
        $this->sesion = 0;

        if ($this->verificarSesion()) {
            $this->sesion = 1;
        }
    }

    function verificarSesion() {

        $resp = false;

        if (!isset($_SESSION['logged']) || !isset($_SESSION['idUser'])) {
            $resp = false;
//            exit;
        } elseif ($result = mysql_query("select * from backend_usuarios where id='" . $_SESSION['idUser'] . "' and accesoBackend='si' limit 1", $this->link)) {
            if (mysql_num_rows($result) > 0) {
                if ($row = mysql_fetch_array($result)) {

                    $getSeccion="";
                    if(!isset($_GET[nomParamVista])){
                        $getSeccion=$_GET[nomParamControlador];
                    }else{
                        $getSeccion=$_GET[nomParamVista];
                    }
//                    echo "<br/>seccion: ".$getSeccion;
                    
                    $permitirPagina=false;
                    
                    $rowPermisos=explode(",",$row['permisos']);
                    foreach($rowPermisos as $rowPermiso){
//                        echo "<br/>Permiso: ".$rowPermiso;
                        if($rowPermiso==$getSeccion){
                            $permitirPagina=true;
                            break;
                        }
                    }
                    if($permitirPagina){
                    
                        $_SESSION['logged'] = true;
                        $_SESSION['user'] = $user;
                        $_SESSION['idUser'] = $row['id'];
                        $_SESSION['permisos']['permisos'] = $row['permisos'];
                        $_SESSION['permisos']['accesoBackend'] = $row['accesoBackend'];
                        $_SESSION['permisos']['marcasAsignadas'] = $row['marcasAsignadas'];

                        $resp = true;
                    }else{
                        header("Location: " . $this->vista->globales['actionBaseForm']."&".nomParamVista."=".$rowPermisos[0]); //Redirecciona a la primera sección permitida de la lista
                        exit();
                    }
                }
            }
        }

        return $resp;
    }

    function login($user, $pass, $redireccion = "") {

        $resp = false;

        if (empty($redireccion)) {
            $redireccion = $_SERVER['PHP_SELF'];
        }

        if ($result = mysql_query("select * from backend_usuarios where email='" . $user . "' and accesoBackend='si' limit 1", $this->link)) {
            if (mysql_num_rows($result) > 0) {
                if ($row = mysql_fetch_array($result)) {
                    //Verificar contraseña
//                    echo "update backend_usuarios set contrasena='".$this->encriptar($pass, $row['llaveContrasena'])."' where email='" . $user . "' limit 1";
//                    mysql_query("update backend_usuarios set contrasena='".$this->encriptar($pass, $row['llaveContrasena'])."' where email='" . $user . "' limit 1");
//                    echo $this->encriptar($pass, $row['llaveContrasena'])." == ".$row['contrasena'];
                    if ($this->encriptar($pass, $row['llaveContrasena']) == $row['contrasena']) {

                        $_SESSION['logged'] = true;
                        $_SESSION['user'] = $user;
                        $_SESSION['idUser'] = $row['id'];
                        $_SESSION['permisos']['permisos'] = $row['permisos'];
                        $_SESSION['permisos']['accesoBackend'] = $row['accesoBackend'];
                        $_SESSION['permisos']['marcasAsignadas'] = $row['marcasAsignadas'];
                        header('Location: ' . $this->vista->globales['actionForm']);
                        $this->cerrarScript();
                    }
                }
            }
        }

        return $resp;
    }

    function logout($redireccion = "") {
        if (empty($redireccion)) {
            $redireccion = $this->vista->globales['actionForm'];
        }
        $_SESSION['logged'] = null;
        header('Location: ' . $redireccion);
        $this->cerrarScript();
    }

    function encriptar($cadena, $clave) {
        $cifrado = MCRYPT_RIJNDAEL_256;
        $modo = MCRYPT_MODE_ECB;
        return base64_encode(mcrypt_encrypt($cifrado, $clave, $cadena, $modo, mcrypt_create_iv(mcrypt_get_iv_size($cifrado, $modo), MCRYPT_RAND)));
    }

    function desencriptar($cadena, $clave) {
        $cadena = base64_decode($cadena);
        $cifrado = MCRYPT_RIJNDAEL_256;
        $modo = MCRYPT_MODE_ECB;
        $temporal = mcrypt_decrypt($cifrado, $clave, $cadena, $modo, mcrypt_create_iv(mcrypt_get_iv_size($cifrado, $modo), MCRYPT_RAND));
        //Arreglo pora evitar caracteres raros.
        $temporalpos = stripos($temporal, chr(0));
        if ($temporalpos !== false) {
            $temporalfin = substr($temporal, 0, $temporalpos);
        } else {
            $temporalfin = $temporal;
        }
        return $temporalfin;
    }

    function recuperarContrasena($mail) {
        if (!empty($mail)) {
            $this->limpiarInjection();

            //Obtener contraseña del correo solicitado
            if ($result = $this->read("*", "backend_usuarios", false, "email='" . $mail . "' limit 1")) {

//            echo "pass: ".$this->desencriptar($result[0]['contrasena'], $result[0]['llaveContrasena']);

                $this->limpiarXss();

                $browser = new Browser();
                $navegador = $browser->getBrowser() . "-" . $browser->getVersion();

                //Enviar por mail
                require_once("clases/class.phpmailer.php");
                require_once("clases/class.smtp.php");
                
                ob_start();
                include($this->rutaModulo . carpetaVistas . "mail.php");
                $textMail = ob_get_contents();
                ob_end_clean();

                //$receptorMail = "hectzimudec@gmail.com";
                $receptorMail = $mail;
                $mail = new PHPMailer();
                $mail->Mailer = "smtp";
                $mail->SMTPAuth = true;
                $mail->Port = "465";
                $mail->Host = 'tls://email-smtp.us-east-1.amazonaws.com';
                $mail->Username = 'AKIAJNSZVLKGI7YZUTCA';
                $mail->Password = 'AhyyYtNfe2sQ3lf4ItKGYe1/pXw2w0prgr4jGK+CiJj3';
                $mail->From = "noreply@4sale.cl";
                $mail->FromName = "Backend";
                $mail->Timeout = 20;
                $mail->Subject = "Recuperación de contraseña";
                $mail->CharSet = "UTF-8";
                $receptorMail = trim($receptorMail);
                if (!empty($receptorMail)) {
                    $mail->AddAddress(trim($receptorMail));
                } else {
                    $mail->ErrorInfo = "Email vacío";
                }
                $mail->AddBCC("hector@4sale.cl");
                $mail->Body = $textMail;
                $mail->IsHTML(true);

                $mail->Send();
            }
        }
    }

}

?>
