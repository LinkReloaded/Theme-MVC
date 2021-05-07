<?

class m_index extends modelo {

    public $marca = "";
    public $tablaBd = "";
    public $urlSitio = "";
    public $carpetaMaterial = "";
    public $destinoMail = "";

    function __construct() {
        $this->tablaBd = "";
        $this->carpetaMaterial = carpetaVistas . carpetaVistasBase;
    }

    function enviarMail($campos) {
        $resp = false;

        require_once(carpetaClases . "class.phpmailer.php");
        require_once(carpetaClases . "class.smtp.php");
        
        $this->time=time();

        ob_start();
        include(carpetaModulos . $_GET[nomParamModulo] . "/" . carpetaVistas . "mail.php");

        $textMail11 = ob_get_contents();

        ob_end_clean();

        $mail = new PHPMailer();
        $mail->Mailer = "smtp";
        $mail->SMTPAuth = true;
        $mail->Port = "465";
        $mail->Host = 'tls://email-smtp.us-east-1.amazonaws.com';
        $mail->Username = 'AKIAJNSZVLKGI7YZUTCA';
        $mail->Password = 'AhyyYtNfe2sQ3lf4ItKGYe1/pXw2w0prgr4jGK+CiJj3';
        $mail->From = $this->vista->globales['from'];
        $mail->FromName = $this->vista->globales['fromName'];
        $mail->Timeout = 20;
        $mail->Subject = $this->vista->globales['asunto'];
        $mail->CharSet = "UTF-8";

        /*Prueba error*/
        /*header("Location: ./?" . $_SERVER['QUERY_STRING'] . "&error=1"); //Mostrar página de "Enviado"
        exit();*/
        /*Prueba error*/
        
        $receptorMails = explode(",", $this->destinoMail);
        foreach ($receptorMails as $receptorMail) {
            $receptorMail = trim($receptorMail);
            if (!empty($receptorMail)) {
                $mail->AddAddress(trim($receptorMail));
                echo "<br/>Agregado mail destino: ".$receptorMail;
            } else {
                echo "<br/>Email vacío";
//                $mail->ErrorInfo = "Email vacío";
            }
        }

        $receptorMails = explode(",", $this->copiaOcultaMail);
        foreach ($receptorMails as $receptorMail) {
            $receptorMail = trim($receptorMail);
            if (!empty($receptorMail)) {
                $mail->AddBCC(trim($receptorMail));
//                echo "<br/>Agregado mail copia oculta: ".$receptorMail;
            } else {
                echo "<br/>Email vacío";
            }
        }

        $mail->Body = $textMail11;
        $mail->IsHTML(true);

        if(!$mail->send()){
//            print_r($this->vista->globales);
            header("Location: ./?" . $_SERVER['QUERY_STRING'] . "&error=1"); //Mostrar página de "Enviado"
            exit();
        }

        //Si se solicita enviar copia del mail al usuario
        if (isset($_POST[$this->campoCopiaMailUsuario]) && !empty($_POST[$this->campoCopiaMailUsuario])) {
//            echo "<br/>se solicitó enviar copia del mail al usuario";
            $mail->ClearAddresses(); //Limpiar todos los correos destino asignados anteriormente
            $receptorMails = explode(",", $_POST[$this->campoCopiaMailUsuario]);
            foreach ($receptorMails as $receptorMail) {
                $receptorMail = trim($receptorMail);
                if (!empty($receptorMail)) {
                    $mail->AddAddress(trim($receptorMail));
//                    echo "<br/>Agregado mail copia al usuario: ".$receptorMail;
                } else {
                    echo "<br/>Email vacío";
                }
            }
            
            if(!$mail->send()){
                header("Location: ./?" . $_SERVER['QUERY_STRING'] . "&error=1"); //Mostrar página de "Enviado"
                exit();
            }
        }
        
        return $resp;
    }

}

?>
