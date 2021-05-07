<?

class m_sistema extends modelo {

    public function __construct() {
        parent::Conectarse();
    }

    function datosUsuario() {

        $resp = false;

        if ($result = $this->read(array("nombres", "apellidos", "marcasAsignadas"), "backend_usuarios", false, "email='" . $_SESSION['user'] . "'")) {

            $resp = $result;
        }

        return $resp;
    }

   function listaMarcas(){
       return array(array("suzuki","Suzuki"),array("greatwall","Greatwall"),array("mazda","Mazda"),array("renaultsamsung","Renault Samsung"),array("renault","Renault"),array("geely","Geely"),array("changan","Changan"),array("jacautos","Jac Autos"));
   }
    

}
?>
