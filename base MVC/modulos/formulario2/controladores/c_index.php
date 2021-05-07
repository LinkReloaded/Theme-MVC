<?

class c_index extends controlador {

    function iniciar() {

        $objModelo = $this->cargarModelo($_GET[nomParamControlador]);

        $this->validaForm1 = new formularios(); //Instanciar objeto, indicando una palabra clave para identificar al formulario

        /* Configuración de parámetros iniciales */
        $objModelo->urlHomeCot = $this->validaForm1->obtenerRutaSitio();                  //Ruta base del sitio web
//        echo "<br/><br/>antes: <pre>".print_r($this->vista->globales, true)."</pre>";
        foreach($this->vista->globales[$this->controlador] as $key=>$elementoGlobal){
            $this->vista->globales[$key]=$elementoGlobal;
        }

//        echo "<br/><br/>después: <pre>".print_r($this->vista->globales, true)."</pre>";exit();
        
        $objModelo->tablaBd = $this->vista->globales['tablaBd']; //Nombre de la BD, donde se insertarán los datos del formulario
        $objModelo->marca = $this->vista->globales['marca']; //Nombre de la marca, obtenida de settings

        /* Campos totales a guardar en bd (No necesariamente a validar) */
        $campos[0] = "nombre";
        $campos[1] = "apellido";
        $campos[2] = "rut";
        $campos[3] = "mail";
        $campos[4] = "tipoFono";
        $campos[5] = "direccion";
        $campos[6] = "codArea";
        $campos[7] = "fono";
        $campos[8] = "region";
        $campos[9] = "comuna";
        $campos[10] = "marca";
        $campos[11] = "modelo";
        $campos[12] = "version";
        $campos[13] = "anio";
        $campos[14] = "kilometros";
        $campos[15] = "sucursal";

        /* Configurando validador de formulario */
        $this->validaForm1->idForm = "form1";           //Id del formulario
        $this->validaForm1->idBotonForm = "botonEnviar"; //Id del botón que enviará el formulario
        $this->validaForm1->incluirJquery = false; //Si es "false", no es incluye jquery (normalmente es "false" porque ya se incluye jquery en el header)
        $this->validaForm1->validacionJs = true;               //Si es "false", solo validará por php
        $this->validaForm1->todosObligatorios = true;          //Si es "true", ningún campo debe estar vacío
        $this->validaForm1->incluirLocalidades = true;         //Incluir regiones y comunas
        $this->validaForm1->nombreSelectRegiones = $campos[8]; //Campo regiones
        $this->validaForm1->nombreSelectComunas = $campos[9];  //Campo comunas

        /* Listado de campos a validar */
        $this->validaForm1->parametros[0]['nombre'] = $campos[0];
        $this->validaForm1->parametros[1]['nombre'] = $campos[1];
        $this->validaForm1->parametros[2]['nombre'] = $campos[2];
        $this->validaForm1->parametros[2]['validacion'][0] = "rut";
        $this->validaForm1->parametros[2]['formato'] = "rut";
        $this->validaForm1->parametros[3]['nombre'] = $campos[3];
        $this->validaForm1->parametros[3]['validacion'][0] = "email";
        $this->validaForm1->parametros[4]['nombre'] = $campos[4];
        $this->validaForm1->parametros[5]['nombre'] = $campos[5];
        $this->validaForm1->parametros[6]['nombre'] = $campos[6];
        $this->validaForm1->parametros[6]['validacion'][0] = "soloNumeros";
        $this->validaForm1->parametros[7]['nombre'] = $campos[7];
        $this->validaForm1->parametros[7]['validacion'][0] = "soloNumeros";
        $this->validaForm1->parametros[8]['nombre'] = $campos[8];
        $this->validaForm1->parametros[9]['nombre'] = $campos[9];
        $this->validaForm1->parametros[10]['nombre'] = $campos[10];
//      $this->validaForm1->parametros[11]['nombre'] = $campos[11];
        $this->validaForm1->parametros[12]['nombre'] = $campos[12];
//      $this->validaForm1->parametros[13]['nombre'] = $campos[13];
        $this->validaForm1->parametros[14]['nombre'] = $campos[14];

        if ($this->validaForm1->validar()) { //Si formulario es enviado, se valida.
            //Guardar en bd
            $this->validaForm1->camposFormulario = $campos; //Campos formulario
            $this->validaForm1->tablaFormulario = $objModelo->tablaBd; //Tabla de insertado
            $this->validaForm1->insertarFormulario($objModelo);

            if ($this->vista->globales['enviarMail'] == "si") {
                //Enviar mail
                $objModelo->destinoMail = $this->vista->globales['mailsDestino'];   //Lista de correos, separados por coma
                $objModelo->copiaOcultaMail = $this->vista->globales['copiaOcultaMail']; //Lista de correos con copia oculta, separados por coma
                $objModelo->campoCopiaMailUsuario = ""; //Si se requiere enviar copia del correo al mail del usuario que llenó el formulario
                if (isset($this->vista->globales['campoCopiaMailUsuario']) && !empty($this->vista->globales['campoCopiaMailUsuario'])) {
                    $objModelo->campoCopiaMailUsuario = $this->vista->globales['campoCopiaMailUsuario'];
                }

                $objModelo->vista->globales=$this->vista->globales;
                
                $objModelo->enviarMail($campos);
            }

            header("Location: ./?" . $_SERVER['QUERY_STRING'] . "&enviado=1"); //Mostrar página de "Enviado"
            exit();
        }

//Cargar vista
        $objVista = $this->cargarVista($_GET[nomParamControlador]);
    }

}

?>