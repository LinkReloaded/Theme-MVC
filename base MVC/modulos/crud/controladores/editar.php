<?
class c_editar extends controlador {
    function iniciar() {
        
        $this->cargarControlador("login", true);

//        if($_SESSION['permisos']['tipoUsuario']!="1"){ //si usuario no tiene permiso
//            header("Location: index.php");
//            exit();
//        }
        
        $this->vista->error = "";
        
        if(isset($_GET['msje']) && !empty($_GET['msje'])){
            switch($_GET['msje']){
                case "1":
                    $this->vista->error = "Contraseña modificada correctamente.";
                    break;
                case "2":
                    $this->vista->error = "Su contraseña actual es incorrecta.";
                    break;
                case "3":
                    $this->vista->error = "No se actualizó correctamente. Intente nuevamente.";
                    break;
            }
        }
        
        
        if(isset($_POST['contActual']) && !empty($_POST['contActual']) && isset($_POST['contNueva1']) && !empty($_POST['contNueva1']) && isset($_POST['contNueva2']) && !empty($_POST['contNueva2'])){ //Si es solicita cambiar la contraseña
            $objEditar = $this->cargarModelo("editar");
            $objLogin = $this->cargarModelo("login", true);
            $objEditar->objLogin=$objLogin;
            
            //Cambiar contraseña
            $this->vista->error=$objEditar->cambiarContrasena($_POST['contActual'], $_POST['contNueva1'], $_POST['contNueva2']);
            
            if(!empty($this->vista->error)){
                header("Location: ".$this->vista->globales['actionForm']."&msje=".$this->vista->error);
                exit();
            }
        }
        
        $modeloBackend = $this->cargarModelo("backend");
        
        //Datos del cliente
        $this->vista->datosCliente = $modeloBackend->datosCliente();
        
        $this->cargarVista($this->controlador);
    }
}
?>