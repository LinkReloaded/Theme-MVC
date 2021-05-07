<?

class m_wordpress extends modelo {

    public $rutaRaiz = "";
    public $prefijo = "";

    function __construct() {
        $this->rutaRaiz = "";
        $this->prefijo = "";
    }

    function conexion() {
        $resp = false;

        if (is_readable($this->rutaRaiz . "wp-config.php")) { //Verificar si ruta de archivo existe
            if (include($this->rutaRaiz . "wp-config.php")) { //Incluir archivo de configuracion
                $this->prefijo = $table_prefix;

                //Conectarse a la bd
                $resp = $this->Conectarse(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            }
        }

        return $resp;
    }

    function cabecera() {

        $resp=false;
        echo "intentando incluir: ".get_include_path() . PATH_SEPARATOR . "./";
        set_include_path(get_include_path() . PATH_SEPARATOR . "./");
        if (is_readable($this->rutaRaiz."wp-config.php")) { //Verificar si ruta de archivo existe
            echo "<br/>wp existe";
            if (include($this->rutaRaiz."wp-config.php")) {
                echo "<br/>wp incluido";
                $wp->init();
                $wp->parse_request();
                $wp->query_posts();
                $wp->register_globals();
                $wp->send_headers();
                echo "<br/>Cabecera de wp agregada";
                $resp=$wp;
            }
        }
        set_include_path(get_include_path());
        
        return $resp;
    }

}

?>