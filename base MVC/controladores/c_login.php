<?

class c_login extends controlador {

    public $forzarNativo=false;
    
    function iniciar() {
        @mkdir("./tmp/");
        session_save_path("./tmp/");

        session_start();
        
        $objLogin = $this->cargarModelo("login", true);
        $objLogin->rutaModulo = $this->rutaModulo;
        $objLogin->vista->globales['actionForm']=$this->vista->globales['actionForm'];

        $objLogin->verifSesion();
//        include(rutaLogin . "models/mLogin.php");

        $this->vista->error = "";

        if (isset($_POST['usuario']) && isset($_POST['contraseña'])) {
            if (!$objLogin->login($_POST['usuario'], $_POST['contraseña'])) {
                $this->vista->error = "Usuario o Contraseña, incorrecto.";
            }
        }

        if (isset($_REQUEST['logout'])) {
            $objLogin->logout();
        }

        if ($objLogin->sesion != 1) {
//            include(rutaLogin . "views/vLogin.php");
            if (isset($_POST['accion']) && $_POST['accion'] == "recuperar") {
                $_GET['accion']=$_POST['accion'];
                if(isset($_POST['mailRecuperar']) && !empty($_POST['mailRecuperar'])){
                    //Enviar mail con contraseña
                    $objLogin->recuperarContrasena($_POST['mailRecuperar']);
                }
            }
            $this->vista->objLogin=$objLogin;
            
            $this->cargarVista($this->controlador, "", $this->forzarNativo);
            $objLogin->cerrarScript();
        } else {
            @mysql_close($objLogin->link);
        }
    }

}

?>
