<?

class c_head extends controlador {

    function iniciar() {

    }

    public function cargarHeader() {

        $this->vista->globales['tituloPagina'] = "";
        $this->vista->globales['descOGpagina'] = "";
        $this->vista->globales['imagenOGpagina'] = "";
        $this->vista->globales['metadescription'] = "";
        $this->vista->globales['metakeyworks'] = "";

        if (!empty($this->vista->globales['thispage']) && isset($this->vista->globales[$this->vista->globales['thispage']]['tituloPagina'])) {
            $this->vista->globales['tituloPagina'] = $this->vista->globales[$this->vista->globales['thispage']]['tituloPagina'];
            $this->vista->globales['descOGpagina'] = $this->vista->globales[$this->vista->globales['thispage']]['descOGpagina'];
            $this->vista->globales['imagenOGpagina'] = $this->vista->globales[$this->vista->globales['thispage']]['imagenOGpagina'];
            $this->vista->globales['metadescription'] = $this->vista->globales[$this->vista->globales['thispage']]['metadescription'];
            $this->vista->globales['metakeyworks'] = $this->vista->globales[$this->vista->globales['thispage']]['metakeyworks'];
        }else{
            $this->vista->globales['tituloPagina'] = $this->vista->globales[controladorPorDefecto]['tituloPagina'];
            $this->vista->globales['descOGpagina'] = $this->vista->globales[controladorPorDefecto]['descOGpagina'];
            $this->vista->globales['imagenOGpagina'] = $this->vista->globales[controladorPorDefecto]['imagenOGpagina'];
            $this->vista->globales['metadescription'] = $this->vista->globales[controladorPorDefecto]['metadescription'];
            $this->vista->globales['metakeyworks'] = $this->vista->globales[controladorPorDefecto]['metakeyworks'];
        }

        //Cargar vista
        $objVista = $this->cargarVista($this->controlador, carpetaVistasBase, true);
    }

}

?>
