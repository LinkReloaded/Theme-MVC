<?

class c_index extends controlador {

    function iniciar(){
        
        $this->vista->prueba1="prueba";
        $objVista = $this->cargarVista($this->controlador);
    }
}

?>