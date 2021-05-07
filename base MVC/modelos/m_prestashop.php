<?

class m_prestashop extends modelo {

    public $rutaRaiz = "";
    public $prefijo = "";

    function __construct() {
        $this->rutaRaiz = "";
        $this->prefijo = "";
    }

    function conexion() {
        $resp = false;

        if (is_readable($this->rutaRaiz . "config/settings.inc.php")) { //Verificar si ruta de archivo existe
            if (include($this->rutaRaiz . "config/settings.inc.php")) { //Incluir archivo de configuracion
                $this->prefijo = _DB_PREFIX_;

                //Conectarse a la bd
                $resp = $this->Conectarse(_DB_SERVER_, _DB_USER_, _DB_PASSWD_, _DB_NAME_);
            }
        }

        return $resp;
    }
}

?>