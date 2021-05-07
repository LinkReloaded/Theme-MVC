<?
class c_index extends controlador {
    function iniciar() {
        
        $this->vista->objWp=$this->cargarModelo("wordpress");
        $this->vista->objWp->rutaRaiz=$this->vista->globales['WPRutaRaiz'];
        /*$this->vista->objWp->conexion();
        
        //Prueba WP
        $this->vista->resultWp=$this->vista->objWp->read("*", $this->vista->objWp->prefijo."users");
        print_r($this->vista->resultWp);*/
        
        //Conexión prestashop
        $this->vista->objPs=$this->cargarModelo("prestashop");
        $this->vista->objPs->rutaRaiz=$this->vista->globales['PSRutaRaiz'];
        /*$this->vista->objPs->conexion();
        
        //Prueba PS
        $this->vista->resultPs=$this->vista->objPs->read("*", $this->vista->objPs->prefijo."employee");
        print_r($this->vista->resultPs);*/
        
        //Cargar vista
        $this->cargarVista($this->controlador);
    }
}


?>