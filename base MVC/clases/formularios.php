<?php

//Ej: $objeto = new formularios();
//    $objeto->validacionJs = true;
//    $objeto->todosObligatorios = true;
//    $objeto->parametros[0]['nombre']="Campo1";
//    $objeto->parametros[0]['validacion'][0]="rut"; //Permite 1 o mas validaciones
//    $objeto->parametros[1]['nombre'] = "fono";
//    $objeto->parametros[1]['validacion'][0] = "soloNumeros"; //Validación 1
//    $objeto->parametros[1]['validacion'][1] = "rango";       //Validación 2
//    $objeto->parametros[1]['minimo'][1] = "6";

class formularios {

    public $incluirJquery = true; //Poner "false" en caso que ya haya sido incluido desde otro archivo
    public $incluirJqueryRut = true; //Poner "false" en caso que ya haya sido incluido desde otro archivo
    public $incluirFuncionesVal = true; //Poner "false" en caso que ya hayan sido incluidas anteriormente (cuando hay mas de 1 form en la misma página)
    public $urlJs = "js/"; //Permitir ingresar una url personalizada, para incluir las API y plugins necesarios para las validaciones
    public $validacionJs = true; //Poner "false" en caso de solo necesitar validaciones php
    private $codigoJs = ""; //Código js para validar campos
    public $todosObligatorios = true; //En caso que ningún campo deba estár vacío
    public $parametros = Array(); //Arreglo de campos a validar (ver ejemplo al principio del archivo)
    public $msjeError = ""; //Mensaje de error de php, en caso que la validación retorne error
    public $incluirLocalidades = false; //Incluir código para incluir regiones y comunas en select en el formulario
    public $nombreSelectRegiones = "";
    public $nombreSelectComunas = "";
    public $idForm = ""; //Id del formulario
    public $camposFormulario = null; //Campos del formulario (Incluidos los que no se validan)
    public $tablaFormulario = null; //Tabla del formulario (Donde se van a insertar los valores)
    public $idBotonForm = "";

    public function __construct() {

//        $this->idForm = $idForm;
        $this->urlJs = carpetaVistas . carpetaVistasBase . $this->urlJs;
    }

    function formatoPrecio($valor) {

        if (empty($valor)) {
            $valor = 0;
        }

        //eliminar cualquier otro caracter que no sea número
        $valor = ereg_replace("[^0-9]", "", $valor);

        //darle formato de moneda chilena
        $valor = "$" . number_format($valor, 0, ',', '.');

        return $valor;
    }

    function limpiarNumero($valor) {

        if (empty($valor)) {
            $valor = 0;
        }

        //eliminar cualquier otro caracter que no sea número
        $valor = ereg_replace("[^0-9]", "", $valor);

        return $valor;
    }

    function validarRut($rut) {

        $resp = 0;

        $rut = str_replace(".", "", $rut);

        if ($rut1 = explode("-", $rut)) {
            if (isset($rut[0]) && isset($rut[1])) {

                $r = (int) $rut1[0];
                $rut1[0] = (int) $rut1[0];
                $rut1[1] = (int) $rut1[1];

                $s = 1;
                for ($m = 0; $r != 0; $r/=10)
                    $s = ($s + $r % 10 * (9 - $m++ % 6)) % 11;
                $digito = chr($s ? $s + 47 : 75);

                if ($rut1[1] == $digito) {
                    $resp = 1;
                } else {
                    $resp = 0;
                }
            } else {
                $resp = 0;
            }
        } else {
            $resp = 0;
        }

        return $resp;
    }

    function validarEmail($mail) {

        if (preg_match("#^([0-9a-zA-Z]+[!\#$%&'*+-/=?^_`{}|~]*)*[^!\#$%&'*+-/=?^_`{}|~]@[0-9a-zA-Z.+-]+\.[A-Za-z0-9]+$#", $mail)) {
            return 1;
        } else {
            return 0;
        }
    }

    function soloNumeros($valor) {

        if (eregi("^[[:digit:]]+$", $valor)) {
            return true;
        } else {
            return false;
        }
    }

    function validarRangoCar($valor, $min, $max) {

        $resp = false;

        if ($min != false) {
            if (strlen($valor) < $min) {
                return false;
            } else {
                $resp = true;
            }
        }

        if ($max != false) {
            if (strlen($valor) > $max) {
                return false;
            } else {
                $resp = true;
            }
        }

        return $resp;
    }

    function expresion($string, $expresion) {
        $resp = false;

        if ($expresion) {
//            echo "string: ".$string;
//            echo "expresion: ".$expresion;

            if (preg_match($expresion, $string)) {
                $resp = true;
            }
        }

        return $resp;
    }

    function quitarUtf8($array) {

        foreach ($array as $key => $val) {
            $array[$key] = utf8_decode($array[$key]);
        }

        return $array;
    }

    function funcionesJs() {
        if ($this->incluirJquery) {
            ?>
            <script type="text/javascript" src="<?= $this->urlJs ?>jquery-1.9.1.min.js"></script>
            <?
        }

        if ($this->incluirJqueryRut) {
            ?>
            <script type="text/javascript" src="<?= $this->urlJs ?>jquery.Rut.js"></script>
            <?
        }
        ?>
        <script type="text/javascript">
            var funcionesJs = new function() {
                this.number_format = function(a, b, c, d) {

                    a = a.toString().replace(/[^0-9]/gi, '');
                    a = parseInt(a);
                    a = Math.round(a * Math.pow(10, b)) / Math.pow(10, b);
                    e = a + '';
                    f = e.split('.');
                    if (!f[0]) {
                        f[0] = '0';
                    }
                    if (!f[1]) {
                        f[1] = '';
                    }
                    if (f[1].length < b) {
                        g = f[1];
                        for (i = f[1].length + 1; i <= b; i++) {
                            g += '0';
                        }
                        f[1] = g;
                    }
                    if (d != '' && f[0].length > 3) {
                        h = f[0];
                        f[0] = '';
                        for (j = 3; j < h.length; j += 3) {
                            i = h.slice(h.length - j, h.length - j + 3);
                            f[0] = d + i + f[0] + '';
                        }
                        j = h.substr(0, (h.length % 3 == 0) ? 3 : (h.length % 3));
                        f[0] = j + f[0];
                    }
                    c = (b <= 0) ? '' : c;
                    return f[0] + c + f[1];
                }

                this.validarRut = function(val) {

                    var resp = false;

                    if ($.Rut.validar(val)) {
                        resp = true;
                    }

                    return resp;
                }

                this.soloNumeros = function(valor) {

                    var reg = /^\d+$/;

                    if (reg.test(valor)) {
                        return 1;
                    } else {
                        return 0;
                    }
                }

                this.validarMail = function(valor) {

                    var reg = /^([0-9a-zA-Z]+[!\#$%&'*+-/=?^_`{}|~]*)*[^!\#$%&'*+-/=?^_`{}|~]@[0-9a-zA-Z.+-]+\.[A-Za-z0-9]+$/;

                    if (reg.test(valor)) {
                        return 1;
                    } else {
                        return 0;
                    }
                }

                this.validarRangoCar = function(valor, min, max) {

                    var resp = false;

                    if (min != false) {
                        if (valor.length < min) {
                            return false;
                        } else {
                            resp = true;
                        }
                    }

                    if (max != false) {
                        if (valor.length > max) {
                            return false;
                        } else {
                            resp = true;
                        }
                    }

                    return resp;
                }

                this.validarAnio = function(valor) {

                    var reg = /^\d+$/;

                    if (reg.test(valor) && valor.length == 4) {
                        return 1;
                    } else {
                        return 0;
                    }
                }

                this.validarRadios = function(name) {

                    var resp = 0;

                    $("input[name='" + name + "']").each(function() {
                        if ($(this).attr("checked") == true) {
                            resp = 1;
                        }
                    });

                    return resp;
                }

                this.validarSelect = function(val) {
                    if (val != "") {
                        return true;
                    } else {
                        return false;
                    }
                }

                this.formatoRut = function(elemento) {
                    elemento.Rut({
                        on_error: function() {
                            //                    alert('Rut incorrecto'); $('#rut').val(""); $('#rut').focus(); 
                        },
                        format_on: 'keyup'
                    });
                }

                this.expresion = function(string, expresion) {
                    var resp = false;
                    //                    var re = new RegExp(expresion, "i");
                    //                    console.log("expresion: "+re);

                    if (expresion) {
                        //                        console.log("string valor: "+string);
                        //                        console.log("string exp: "+expresion);
                        if (expresion.test(string)) {
                            resp = true;
                        }
                    }

                    return resp;
                }

                this.formatoNumero = function(elemento) {
                    var ultimoValor = "";

                    elemento.keydown(function(e) { //Formateado

                        if ((e.which <= 57 && e.which >= 48) || e.which == 46 || e.which == 8 || e.which == 9 || e.which == 37 || e.which == 39 || (e.which >= 96 && e.which <= 105)) {

                        } else {
                            e.preventDefault();
                        }
                    });

                    elemento.keyup(function(e) { //Formateado

                        $(this).val($(this).val().replace(/[^0-9]/gi, ''));

                        if ($(this).val() != "" && $(this).val() != ultimoValor) {
                            $(this).val(funcionesJs.number_format($(this).val(), 0, ",", "."));
                            ultimoValor = $(this).val();
                        }
                    });
                }
        <?
        if ($this->incluirLocalidades) {
            ?>
                    this.jsonComunas = "";

                    this.getJson = function() {

                        //                $.ajax({
                        //
                        //                url: "./funciones/comunas.php",
                        //                async: false,
                        //                dataType: "json",
                        //                success: function(data){

                        //                                this.jsonComunas={"region":{"1":[{"codigo":"1101","nombre":"Iquique","provincia_codigo":"1"},{"codigo":"1405","nombre":"Pica","provincia_codigo":"1"},{"codigo":"1404","nombre":"Huara","provincia_codigo":"1"},{"codigo":"1403","nombre":"Colchane","provincia_codigo":"1"},{"codigo":"1402","nombre":"Cami\u00f1a","provincia_codigo":"1"},{"codigo":"1401","nombre":"Pozo Almonte","provincia_codigo":"1"},{"codigo":"1107","nombre":"Alto Hospicio","provincia_codigo":"1"}],"2":[{"codigo":"2302","nombre":"Mar\u00eda Elena","provincia_codigo":"2"},{"codigo":"2301","nombre":"Tocopilla","provincia_codigo":"2"},{"codigo":"2203","nombre":"San Pedro de Atacama","provincia_codigo":"2"},{"codigo":"2202","nombre":"Ollague","provincia_codigo":"2"},{"codigo":"2201","nombre":"Calama","provincia_codigo":"2"},{"codigo":"2104","nombre":"Taltal","provincia_codigo":"2"},{"codigo":"2103","nombre":"Sierra Gorda","provincia_codigo":"2"},{"codigo":"2102","nombre":"Mejillones","provincia_codigo":"2"},{"codigo":"2101","nombre":"Antofagasta","provincia_codigo":"2"}],"3":[{"codigo":"3304","nombre":"Huasco","provincia_codigo":"3"},{"codigo":"3303","nombre":"Freirina","provincia_codigo":"3"},{"codigo":"3302","nombre":"Alto del Carmen","provincia_codigo":"3"},{"codigo":"3301","nombre":"Vallenar","provincia_codigo":"3"},{"codigo":"3202","nombre":"Diego de Almagro","provincia_codigo":"3"},{"codigo":"3201","nombre":"Cha\u00f1aral","provincia_codigo":"3"},{"codigo":"3103","nombre":"Tierra Amarilla","provincia_codigo":"3"},{"codigo":"3102","nombre":"Caldera","provincia_codigo":"3"},{"codigo":"3101","nombre":"Copiap\u00f3","provincia_codigo":"3"}],"4":[{"codigo":"4204","nombre":"Salamanca","provincia_codigo":"4"},{"codigo":"4301","nombre":"Ovalle","provincia_codigo":"4"},{"codigo":"4302","nombre":"Combarbal\u00e1","provincia_codigo":"4"},{"codigo":"4303","nombre":"Monte Patria","provincia_codigo":"4"},{"codigo":"4304","nombre":"Punitaqui","provincia_codigo":"4"},{"codigo":"4305","nombre":"R\u00edo Hurtado","provincia_codigo":"4"},{"codigo":"4203","nombre":"Los Vilos","provincia_codigo":"4"},{"codigo":"4202","nombre":"Canela","provincia_codigo":"4"},{"codigo":"4201","nombre":"Illapel","provincia_codigo":"4"},{"codigo":"4101","nombre":"La Serena","provincia_codigo":"4"},{"codigo":"4102","nombre":"Coquimbo","provincia_codigo":"4"},{"codigo":"4103","nombre":"Andacollo","provincia_codigo":"4"},{"codigo":"4104","nombre":"La Higuera","provincia_codigo":"4"},{"codigo":"4105","nombre":"Paihuano","provincia_codigo":"4"},{"codigo":"4106","nombre":"Vicu\u00f1a","provincia_codigo":"4"}],"5":[{"codigo":"5602","nombre":"Algarrobo","provincia_codigo":"5"},{"codigo":"5601","nombre":"San Antonio","provincia_codigo":"5"},{"codigo":"5507","nombre":"Olmu\u00e9","provincia_codigo":"5"},{"codigo":"5506","nombre":"Nogales","provincia_codigo":"5"},{"codigo":"5505","nombre":"Limache","provincia_codigo":"5"},{"codigo":"5504","nombre":"La Cruz","provincia_codigo":"5"},{"codigo":"5503","nombre":"Hijuelas","provincia_codigo":"5"},{"codigo":"5502","nombre":"Calera","provincia_codigo":"5"},{"codigo":"5603","nombre":"Cartagena","provincia_codigo":"5"},{"codigo":"5604","nombre":"El Quisco","provincia_codigo":"5"},{"codigo":"5706","nombre":"Santa Mar\u00eda","provincia_codigo":"5"},{"codigo":"5705","nombre":"Putaendo","provincia_codigo":"5"},{"codigo":"5704","nombre":"Panquehue","provincia_codigo":"5"},{"codigo":"5703","nombre":"Llay Llay","provincia_codigo":"5"},{"codigo":"5702","nombre":"Catemu","provincia_codigo":"5"},{"codigo":"5701","nombre":"San Felipe","provincia_codigo":"5"},{"codigo":"5606","nombre":"Santo Domingo","provincia_codigo":"5"},{"codigo":"5605","nombre":"El Tabo","provincia_codigo":"5"},{"codigo":"5501","nombre":"Quillota","provincia_codigo":"5"},{"codigo":"5405","nombre":"Zapallar","provincia_codigo":"5"},{"codigo":"5108","nombre":"Villa Alemana","provincia_codigo":"5"},{"codigo":"5107","nombre":"Quintero","provincia_codigo":"5"},{"codigo":"5106","nombre":"Quilpu\u00e9","provincia_codigo":"5"},{"codigo":"5105","nombre":"Puchuncav\u00ed","provincia_codigo":"5"},{"codigo":"5104","nombre":"Juan Fern\u00e1ndez","provincia_codigo":"5"},{"codigo":"5103","nombre":"Conc\u00f3n","provincia_codigo":"5"},{"codigo":"5102","nombre":"Casablanca","provincia_codigo":"5"},{"codigo":"5101","nombre":"Valpara\u00edso","provincia_codigo":"5"},{"codigo":"5109","nombre":"Vi\u00f1a del Mar","provincia_codigo":"5"},{"codigo":"5201","nombre":"Isla de Pascua","provincia_codigo":"5"},{"codigo":"5404","nombre":"Petorca","provincia_codigo":"5"},{"codigo":"5403","nombre":"Papudo","provincia_codigo":"5"},{"codigo":"5402","nombre":"Cabildo","provincia_codigo":"5"},{"codigo":"5401","nombre":"La Ligua","provincia_codigo":"5"},{"codigo":"5304","nombre":"San Esteban","provincia_codigo":"5"},{"codigo":"5303","nombre":"Rinconada","provincia_codigo":"5"},{"codigo":"5302","nombre":"Calle Larga","provincia_codigo":"5"},{"codigo":"5301","nombre":"Los Andes","provincia_codigo":"5"}],"6":[{"codigo":"6301","nombre":"San Fernando","provincia_codigo":"6"},{"codigo":"6206","nombre":"Paredones","provincia_codigo":"6"},{"codigo":"6205","nombre":"Navidad","provincia_codigo":"6"},{"codigo":"6204","nombre":"Marchihue","provincia_codigo":"6"},{"codigo":"6203","nombre":"Litueche","provincia_codigo":"6"},{"codigo":"6202","nombre":"La Estrella","provincia_codigo":"6"},{"codigo":"6302","nombre":"Ch\u00e9pica","provincia_codigo":"6"},{"codigo":"6303","nombre":"Chimbarongo","provincia_codigo":"6"},{"codigo":"6304","nombre":"Lolol","provincia_codigo":"6"},{"codigo":"6305","nombre":"Nancagua","provincia_codigo":"6"},{"codigo":"6306","nombre":"Palmilla","provincia_codigo":"6"},{"codigo":"6307","nombre":"Peralillo","provincia_codigo":"6"},{"codigo":"6308","nombre":"Placilla","provincia_codigo":"6"},{"codigo":"6309","nombre":"Pumanque","provincia_codigo":"6"},{"codigo":"6310","nombre":"Santa Cruz","provincia_codigo":"6"},{"codigo":"6201","nombre":"Pichilemu","provincia_codigo":"6"},{"codigo":"6117","nombre":"San Vicente","provincia_codigo":"6"},{"codigo":"6116","nombre":"Requinoa","provincia_codigo":"6"},{"codigo":"6101","nombre":"Rancagua","provincia_codigo":"6"},{"codigo":"6102","nombre":"Codegua","provincia_codigo":"6"},{"codigo":"6103","nombre":"Coinco","provincia_codigo":"6"},{"codigo":"6104","nombre":"Coltauco","provincia_codigo":"6"},{"codigo":"6105","nombre":"Do\u00f1ihue","provincia_codigo":"6"},{"codigo":"6106","nombre":"Graneros","provincia_codigo":"6"},{"codigo":"6107","nombre":"Las Cabras","provincia_codigo":"6"},{"codigo":"6108","nombre":"Machal\u00ed","provincia_codigo":"6"},{"codigo":"6109","nombre":"Malloa","provincia_codigo":"6"},{"codigo":"6115","nombre":"Rengo","provincia_codigo":"6"},{"codigo":"6114","nombre":"Quinta de Tilcoco","provincia_codigo":"6"},{"codigo":"6113","nombre":"Pichidegua","provincia_codigo":"6"},{"codigo":"6112","nombre":"Peumo","provincia_codigo":"6"},{"codigo":"6111","nombre":"Olivar","provincia_codigo":"6"},{"codigo":"6110","nombre":"Mostazal","provincia_codigo":"6"}],"7":[{"codigo":"7309","nombre":"Vichuqu\u00e9n","provincia_codigo":"7"},{"codigo":"7308","nombre":"Teno","provincia_codigo":"7"},{"codigo":"7307","nombre":"Sagrada Familia","provincia_codigo":"7"},{"codigo":"7306","nombre":"Romeral","provincia_codigo":"7"},{"codigo":"7305","nombre":"Rauco","provincia_codigo":"7"},{"codigo":"7304","nombre":"Molina","provincia_codigo":"7"},{"codigo":"7401","nombre":"Linares","provincia_codigo":"7"},{"codigo":"7402","nombre":"Colb\u00fan","provincia_codigo":"7"},{"codigo":"7403","nombre":"Longav\u00ed","provincia_codigo":"7"},{"codigo":"7404","nombre":"Parral","provincia_codigo":"7"},{"codigo":"7405","nombre":"Retiro","provincia_codigo":"7"},{"codigo":"7406","nombre":"San Javier","provincia_codigo":"7"},{"codigo":"7407","nombre":"Villa Alegre","provincia_codigo":"7"},{"codigo":"7408","nombre":"Yerbas Buenas","provincia_codigo":"7"},{"codigo":"7303","nombre":"Licant\u00e9n","provincia_codigo":"7"},{"codigo":"7302","nombre":"Huala\u00f1\u00e9","provincia_codigo":"7"},{"codigo":"7101","nombre":"Talca","provincia_codigo":"7"},{"codigo":"7102","nombre":"Constituci\u00f3n","provincia_codigo":"7"},{"codigo":"7103","nombre":"Curepto","provincia_codigo":"7"},{"codigo":"7104","nombre":"Empedrado","provincia_codigo":"7"},{"codigo":"7105","nombre":"Maule","provincia_codigo":"7"},{"codigo":"7106","nombre":"Pelarco","provincia_codigo":"7"},{"codigo":"7107","nombre":"Pencahue","provincia_codigo":"7"},{"codigo":"7108","nombre":"R\u00edo Claro","provincia_codigo":"7"},{"codigo":"7301","nombre":"Curic\u00f3","provincia_codigo":"7"},{"codigo":"7203","nombre":"Pelluhue","provincia_codigo":"7"},{"codigo":"7202","nombre":"Chanco","provincia_codigo":"7"},{"codigo":"7201","nombre":"Cauquenes","provincia_codigo":"7"},{"codigo":"7110","nombre":"San Rafael","provincia_codigo":"7"},{"codigo":"7109","nombre":"San Clemente","provincia_codigo":"7"}],"8":[{"codigo":"8406","nombre":"Chill\u00e1n Viejo","provincia_codigo":"8"},{"codigo":"8405","nombre":"Coihueco","provincia_codigo":"8"},{"codigo":"8404","nombre":"Coelemu","provincia_codigo":"8"},{"codigo":"8403","nombre":"Cobquecura","provincia_codigo":"8"},{"codigo":"8402","nombre":"Bulnes","provincia_codigo":"8"},{"codigo":"8401","nombre":"Chill\u00e1n","provincia_codigo":"8"},{"codigo":"8314","nombre":"Alto Biob\u00edo","provincia_codigo":"8"},{"codigo":"8313","nombre":"Yumbel","provincia_codigo":"8"},{"codigo":"8312","nombre":"Tucapel","provincia_codigo":"8"},{"codigo":"8311","nombre":"Santa B\u00e1rbara","provincia_codigo":"8"},{"codigo":"8310","nombre":"San Rosendo","provincia_codigo":"8"},{"codigo":"8309","nombre":"Quilleco","provincia_codigo":"8"},{"codigo":"8407","nombre":"El Carmen","provincia_codigo":"8"},{"codigo":"8408","nombre":"Ninhue","provincia_codigo":"8"},{"codigo":"8409","nombre":"\u00d1iqu\u00e9n","provincia_codigo":"8"},{"codigo":"8420","nombre":"Trehuaco","provincia_codigo":"8"},{"codigo":"8419","nombre":"San Nicol\u00e1s","provincia_codigo":"8"},{"codigo":"8418","nombre":"San Ignacio","provincia_codigo":"8"},{"codigo":"8417","nombre":"San Fabi\u00e1n","provincia_codigo":"8"},{"codigo":"8416","nombre":"San Carlos","provincia_codigo":"8"},{"codigo":"8415","nombre":"Ranquil","provincia_codigo":"8"},{"codigo":"8414","nombre":"Quirihue","provincia_codigo":"8"},{"codigo":"8413","nombre":"Quill\u00f3n","provincia_codigo":"8"},{"codigo":"8412","nombre":"Portezuelo","provincia_codigo":"8"},{"codigo":"8411","nombre":"Pinto","provincia_codigo":"8"},{"codigo":"8410","nombre":"Pemuco","provincia_codigo":"8"},{"codigo":"8421","nombre":"Yungay","provincia_codigo":"8"},{"codigo":"8101","nombre":"Concepci\u00f3n","provincia_codigo":"8"},{"codigo":"8112","nombre":"Hualp\u00e9n","provincia_codigo":"8"},{"codigo":"8111","nombre":"Tom\u00e9","provincia_codigo":"8"},{"codigo":"8110","nombre":"Talcahuano","provincia_codigo":"8"},{"codigo":"8109","nombre":"Santa Juana","provincia_codigo":"8"},{"codigo":"8108","nombre":"San Pedro De La Paz","provincia_codigo":"8"},{"codigo":"8107","nombre":"Penco","provincia_codigo":"8"},{"codigo":"8106","nombre":"Lota","provincia_codigo":"8"},{"codigo":"8105","nombre":"Hualqui","provincia_codigo":"8"},{"codigo":"8104","nombre":"Florida","provincia_codigo":"8"},{"codigo":"8103","nombre":"Chiguayante","provincia_codigo":"8"},{"codigo":"8102","nombre":"Coronel","provincia_codigo":"8"},{"codigo":"8201","nombre":"Lebu","provincia_codigo":"8"},{"codigo":"8202","nombre":"Arauco","provincia_codigo":"8"},{"codigo":"8203","nombre":"Ca\u00f1ete","provincia_codigo":"8"},{"codigo":"8308","nombre":"Quilaco","provincia_codigo":"8"},{"codigo":"8307","nombre":"Negrete","provincia_codigo":"8"},{"codigo":"8306","nombre":"Nacimiento","provincia_codigo":"8"},{"codigo":"8305","nombre":"Mulch\u00e9n","provincia_codigo":"8"},{"codigo":"8304","nombre":"Laja","provincia_codigo":"8"},{"codigo":"8303","nombre":"Cabrero","provincia_codigo":"8"},{"codigo":"8302","nombre":"Antuco","provincia_codigo":"8"},{"codigo":"8301","nombre":"Los Angeles","provincia_codigo":"8"},{"codigo":"8207","nombre":"Tirua","provincia_codigo":"8"},{"codigo":"8206","nombre":"Los Alamos","provincia_codigo":"8"},{"codigo":"8205","nombre":"Curanilahue","provincia_codigo":"8"},{"codigo":"8204","nombre":"Contulmo","provincia_codigo":"8"}],"9":[{"codigo":"9202","nombre":"Collipulli","provincia_codigo":"9"},{"codigo":"9201","nombre":"Angol","provincia_codigo":"9"},{"codigo":"9121","nombre":"Cholchol","provincia_codigo":"9"},{"codigo":"9120","nombre":"Villarrica","provincia_codigo":"9"},{"codigo":"9119","nombre":"Vilc\u00fan","provincia_codigo":"9"},{"codigo":"9118","nombre":"Tolt\u00e9n","provincia_codigo":"9"},{"codigo":"9203","nombre":"Curacaut\u00edn","provincia_codigo":"9"},{"codigo":"9204","nombre":"Ercilla","provincia_codigo":"9"},{"codigo":"9205","nombre":"Lonquimay","provincia_codigo":"9"},{"codigo":"9206","nombre":"Los Sauces","provincia_codigo":"9"},{"codigo":"9207","nombre":"Lumaco","provincia_codigo":"9"},{"codigo":"9208","nombre":"Pur\u00e9n","provincia_codigo":"9"},{"codigo":"9209","nombre":"Renaico","provincia_codigo":"9"},{"codigo":"9210","nombre":"Traigu\u00e9n","provincia_codigo":"9"},{"codigo":"9211","nombre":"Victoria","provincia_codigo":"9"},{"codigo":"9117","nombre":"Teodoro Schmidt","provincia_codigo":"9"},{"codigo":"9116","nombre":"Saavedra","provincia_codigo":"9"},{"codigo":"9101","nombre":"Temuco","provincia_codigo":"9"},{"codigo":"9102","nombre":"Carahue","provincia_codigo":"9"},{"codigo":"9103","nombre":"Cunco","provincia_codigo":"9"},{"codigo":"9104","nombre":"Curarrehue","provincia_codigo":"9"},{"codigo":"9105","nombre":"Freire","provincia_codigo":"9"},{"codigo":"9106","nombre":"Galvarino","provincia_codigo":"9"},{"codigo":"9107","nombre":"Gorbea","provincia_codigo":"9"},{"codigo":"9108","nombre":"Lautaro","provincia_codigo":"9"},{"codigo":"9109","nombre":"Loncoche","provincia_codigo":"9"},{"codigo":"9115","nombre":"Puc\u00f3n","provincia_codigo":"9"},{"codigo":"9114","nombre":"Pitrufqu\u00e9n","provincia_codigo":"9"},{"codigo":"9113","nombre":"Perquenco","provincia_codigo":"9"},{"codigo":"9112","nombre":"Padre Las Casas","provincia_codigo":"9"},{"codigo":"9111","nombre":"Nueva Imperial","provincia_codigo":"9"},{"codigo":"9110","nombre":"Melipeuco","provincia_codigo":"9"}],"10":[{"codigo":"10303","nombre":"Purranque","provincia_codigo":"10"},{"codigo":"10302","nombre":"Puerto Octay","provincia_codigo":"10"},{"codigo":"10301","nombre":"Osorno","provincia_codigo":"10"},{"codigo":"10210","nombre":"Quinchao","provincia_codigo":"10"},{"codigo":"10209","nombre":"Quemchi","provincia_codigo":"10"},{"codigo":"10208","nombre":"Quell\u00f3n","provincia_codigo":"10"},{"codigo":"10304","nombre":"Puyehue","provincia_codigo":"10"},{"codigo":"10305","nombre":"R\u00edo Negro","provincia_codigo":"10"},{"codigo":"10306","nombre":"San Juan de la Costa","provincia_codigo":"10"},{"codigo":"10307","nombre":"San Pablo","provincia_codigo":"10"},{"codigo":"10401","nombre":"Chait\u00e9n","provincia_codigo":"10"},{"codigo":"10402","nombre":"Futaleuf\u00fa","provincia_codigo":"10"},{"codigo":"10403","nombre":"Hualaihue","provincia_codigo":"10"},{"codigo":"10404","nombre":"Palena","provincia_codigo":"10"},{"codigo":"10207","nombre":"Queil\u00e9n","provincia_codigo":"10"},{"codigo":"10206","nombre":"Puqueld\u00f3n","provincia_codigo":"10"},{"codigo":"10101","nombre":"Puerto Montt","provincia_codigo":"10"},{"codigo":"10102","nombre":"Calbuco","provincia_codigo":"10"},{"codigo":"10103","nombre":"Cocham\u00f3","provincia_codigo":"10"},{"codigo":"10104","nombre":"Fresia","provincia_codigo":"10"},{"codigo":"10105","nombre":"Frutillar","provincia_codigo":"10"},{"codigo":"10106","nombre":"Los Muermos","provincia_codigo":"10"},{"codigo":"10107","nombre":"Llanquihue","provincia_codigo":"10"},{"codigo":"10108","nombre":"Maull\u00edn","provincia_codigo":"10"},{"codigo":"10205","nombre":"Dalcahue","provincia_codigo":"10"},{"codigo":"10204","nombre":"Curaco de V\u00e9lez","provincia_codigo":"10"},{"codigo":"10203","nombre":"Chonchi","provincia_codigo":"10"},{"codigo":"10202","nombre":"Ancud","provincia_codigo":"10"},{"codigo":"10201","nombre":"Castro","provincia_codigo":"10"},{"codigo":"10109","nombre":"Puerto Varas","provincia_codigo":"10"}],"11":[{"codigo":"11402","nombre":"R\u00edo Ib\u00e1\u00f1ez","provincia_codigo":"11"},{"codigo":"11401","nombre":"Chile Chico","provincia_codigo":"11"},{"codigo":"11303","nombre":"Tortel","provincia_codigo":"11"},{"codigo":"11302","nombre":"Ohiggins","provincia_codigo":"11"},{"codigo":"11301","nombre":"Cochrane","provincia_codigo":"11"},{"codigo":"11203","nombre":"Guaitecas","provincia_codigo":"11"},{"codigo":"11202","nombre":"Cisnes","provincia_codigo":"11"},{"codigo":"11201","nombre":"Ais\u00e9n","provincia_codigo":"11"},{"codigo":"11102","nombre":"Lago Verde","provincia_codigo":"11"},{"codigo":"11101","nombre":"Coihaique","provincia_codigo":"11"}],"12":[{"codigo":"12302","nombre":"Primavera","provincia_codigo":"12"},{"codigo":"12303","nombre":"Timaukel","provincia_codigo":"12"},{"codigo":"12401","nombre":"Natales","provincia_codigo":"12"},{"codigo":"12402","nombre":"Torres del Paine","provincia_codigo":"12"},{"codigo":"12301","nombre":"Porvenir","provincia_codigo":"12"},{"codigo":"12202","nombre":"ANT\u00c1RTICA","provincia_codigo":"12"},{"codigo":"12201","nombre":"Cabo de Hornos","provincia_codigo":"12"},{"codigo":"12104","nombre":"San Gregorio","provincia_codigo":"12"},{"codigo":"12103","nombre":"R\u00edo Verde","provincia_codigo":"12"},{"codigo":"12102","nombre":"Laguna Blanca","provincia_codigo":"12"},{"codigo":"12101","nombre":"Punta Arenas","provincia_codigo":"12"}],"13":[{"codigo":"13202","nombre":"Pirque","provincia_codigo":"13"},{"codigo":"13203","nombre":"San Jos\u00e9 de Maipo","provincia_codigo":"13"},{"codigo":"13301","nombre":"Colina","provincia_codigo":"13"},{"codigo":"13302","nombre":"Lampa","provincia_codigo":"13"},{"codigo":"13303","nombre":"Til til","provincia_codigo":"13"},{"codigo":"13201","nombre":"Puente Alto","provincia_codigo":"13"},{"codigo":"13132","nombre":"Vitacura","provincia_codigo":"13"},{"codigo":"13131","nombre":"San Ram\u00f3n","provincia_codigo":"13"},{"codigo":"13130","nombre":"San Miguel","provincia_codigo":"13"},{"codigo":"13129","nombre":"San Joaqu\u00edn","provincia_codigo":"13"},{"codigo":"13128","nombre":"Renca","provincia_codigo":"13"},{"codigo":"13127","nombre":"Recoleta","provincia_codigo":"13"},{"codigo":"13401","nombre":"San Bernardo","provincia_codigo":"13"},{"codigo":"13402","nombre":"Buin","provincia_codigo":"13"},{"codigo":"13604","nombre":"Padre Hurtado","provincia_codigo":"13"},{"codigo":"13603","nombre":"Isla de Maipo","provincia_codigo":"13"},{"codigo":"13602","nombre":"El Monte","provincia_codigo":"13"},{"codigo":"13601","nombre":"Talagante","provincia_codigo":"13"},{"codigo":"13505","nombre":"San Pedro","provincia_codigo":"13"},{"codigo":"13504","nombre":"Mar\u00eda Pinto","provincia_codigo":"13"},{"codigo":"13503","nombre":"Curacav\u00ed","provincia_codigo":"13"},{"codigo":"13502","nombre":"Alhu\u00e9","provincia_codigo":"13"},{"codigo":"13501","nombre":"Melipilla","provincia_codigo":"13"},{"codigo":"13404","nombre":"Paine","provincia_codigo":"13"},{"codigo":"13403","nombre":"Calera de Tango","provincia_codigo":"13"},{"codigo":"13605","nombre":"Pe\u00f1aflor","provincia_codigo":"13"},{"codigo":"13101","nombre":"Santiago","provincia_codigo":"13"},{"codigo":"13112","nombre":"La Pintana","provincia_codigo":"13"},{"codigo":"13111","nombre":"La Granja","provincia_codigo":"13"},{"codigo":"13110","nombre":"La Florida","provincia_codigo":"13"},{"codigo":"13109","nombre":"La Cisterna","provincia_codigo":"13"},{"codigo":"13108","nombre":"Independencia","provincia_codigo":"13"},{"codigo":"13107","nombre":"Huechuraba","provincia_codigo":"13"},{"codigo":"13106","nombre":"Estaci\u00f3n Central","provincia_codigo":"13"},{"codigo":"13105","nombre":"El Bosque","provincia_codigo":"13"},{"codigo":"13104","nombre":"Conchal\u00ed","provincia_codigo":"13"},{"codigo":"13103","nombre":"Cerro Navia","provincia_codigo":"13"},{"codigo":"13102","nombre":"Cerrillos","provincia_codigo":"13"},{"codigo":"13113","nombre":"La Reina","provincia_codigo":"13"},{"codigo":"13114","nombre":"Las Condes","provincia_codigo":"13"},{"codigo":"13126","nombre":"Quinta Normal","provincia_codigo":"13"},{"codigo":"13125","nombre":"Quilicura","provincia_codigo":"13"},{"codigo":"13124","nombre":"Pudahuel","provincia_codigo":"13"},{"codigo":"13123","nombre":"Providencia","provincia_codigo":"13"},{"codigo":"13122","nombre":"Pe\u00f1alol\u00e9n","provincia_codigo":"13"},{"codigo":"13121","nombre":"Pedro Aguirre Cerda","provincia_codigo":"13"},{"codigo":"13120","nombre":"\u00d1u\u00f1oa","provincia_codigo":"13"},{"codigo":"13119","nombre":"Maip\u00fa","provincia_codigo":"13"},{"codigo":"13118","nombre":"Macul","provincia_codigo":"13"},{"codigo":"13117","nombre":"Lo Prado","provincia_codigo":"13"},{"codigo":"13116","nombre":"Lo Espejo","provincia_codigo":"13"},{"codigo":"13115","nombre":"Lo Barnechea","provincia_codigo":"13"}],"14":[{"codigo":"14108","nombre":"Panguipulli","provincia_codigo":"14"},{"codigo":"14201","nombre":"La Uni\u00f3n","provincia_codigo":"14"},{"codigo":"14202","nombre":"Futrono","provincia_codigo":"14"},{"codigo":"14203","nombre":"Lago Ranco","provincia_codigo":"14"},{"codigo":"14204","nombre":"R\u00edo Bueno","provincia_codigo":"14"},{"codigo":"14107","nombre":"Paillaco","provincia_codigo":"14"},{"codigo":"14106","nombre":"Mariquina","provincia_codigo":"14"},{"codigo":"14101","nombre":"Valdivia","provincia_codigo":"14"},{"codigo":"14102","nombre":"Corral","provincia_codigo":"14"},{"codigo":"14103","nombre":"Lanco","provincia_codigo":"14"},{"codigo":"14104","nombre":"Los Lagos","provincia_codigo":"14"},{"codigo":"14105","nombre":"M\u00e1fil","provincia_codigo":"14"}],"15":[{"codigo":"15101","nombre":"Arica","provincia_codigo":"15"},{"codigo":"15102","nombre":"Camarones","provincia_codigo":"15"},{"codigo":"15201","nombre":"Putre","provincia_codigo":"15"},{"codigo":"15202","nombre":"General Lagos","provincia_codigo":"15"}]}};
                        this.jsonComunas = {"region": {"1": [{"nombre": "Alto Hospicio"}, {"nombre": "Cami\u00f1a"}, {"nombre": "Colchane"}, {"nombre": "Huara"}, {"nombre": "Iquique"}, {"nombre": "Pica"}, {"nombre": "Pozo Almonte"}], "2": [{"nombre": "Antofagasta"}, {"nombre": "Calama"}, {"nombre": "Mar\u00eda Elena"}, {"nombre": "Mejillones"}, {"nombre": "Ollague"}, {"nombre": "San Pedro de Atacama"}, {"nombre": "Sierra Gorda"}, {"nombre": "Taltal"}, {"nombre": "Tocopilla"}], "3": [{"nombre": "Alto del Carmen"}, {"nombre": "Caldera"}, {"nombre": "Cha\u00f1aral"}, {"nombre": "Copiap\u00f3"}, {"nombre": "Diego de Almagro"}, {"nombre": "Freirina"}, {"nombre": "Huasco"}, {"nombre": "Tierra Amarilla"}, {"nombre": "Vallenar"}], "4": [{"nombre": "Andacollo"}, {"nombre": "Canela"}, {"nombre": "Combarbal\u00e1"}, {"nombre": "Coquimbo"}, {"nombre": "Illapel"}, {"nombre": "La Higuera"}, {"nombre": "La Serena"}, {"nombre": "Los Vilos"}, {"nombre": "Monte Patria"}, {"nombre": "Ovalle"}, {"nombre": "Paihuano"}, {"nombre": "Punitaqui"}, {"nombre": "R\u00edo Hurtado"}, {"nombre": "Salamanca"}, {"nombre": "Vicu\u00f1a"}], "5": [{"nombre": "Algarrobo"}, {"nombre": "Cabildo"}, {"nombre": "Calera"}, {"nombre": "Calle Larga"}, {"nombre": "Cartagena"}, {"nombre": "Casablanca"}, {"nombre": "Catemu"}, {"nombre": "Conc\u00f3n"}, {"nombre": "El Quisco"}, {"nombre": "El Tabo"}, {"nombre": "Hijuelas"}, {"nombre": "Isla de Pascua"}, {"nombre": "Juan Fern\u00e1ndez"}, {"nombre": "La Cruz"}, {"nombre": "La Ligua"}, {"nombre": "Limache"}, {"nombre": "Llay Llay"}, {"nombre": "Los Andes"}, {"nombre": "Nogales"}, {"nombre": "Olmu\u00e9"}, {"nombre": "Panquehue"}, {"nombre": "Papudo"}, {"nombre": "Petorca"}, {"nombre": "Puchuncav\u00ed"}, {"nombre": "Putaendo"}, {"nombre": "Quillota"}, {"nombre": "Quilpu\u00e9"}, {"nombre": "Quintero"}, {"nombre": "Rinconada"}, {"nombre": "San Antonio"}, {"nombre": "San Esteban"}, {"nombre": "San Felipe"}, {"nombre": "Santa Mar\u00eda"}, {"nombre": "Santo Domingo"}, {"nombre": "Valpara\u00edso"}, {"nombre": "Villa Alemana"}, {"nombre": "Vi\u00f1a del Mar"}, {"nombre": "Zapallar"}], "6": [{"nombre": "Ch\u00e9pica"}, {"nombre": "Chimbarongo"}, {"nombre": "Codegua"}, {"nombre": "Coinco"}, {"nombre": "Coltauco"}, {"nombre": "Do\u00f1ihue"}, {"nombre": "Graneros"}, {"nombre": "La Estrella"}, {"nombre": "Las Cabras"}, {"nombre": "Litueche"}, {"nombre": "Lolol"}, {"nombre": "Machal\u00ed"}, {"nombre": "Malloa"}, {"nombre": "Marchihue"}, {"nombre": "Mostazal"}, {"nombre": "Nancagua"}, {"nombre": "Navidad"}, {"nombre": "Olivar"}, {"nombre": "Palmilla"}, {"nombre": "Paredones"}, {"nombre": "Peralillo"}, {"nombre": "Peumo"}, {"nombre": "Pichidegua"}, {"nombre": "Pichilemu"}, {"nombre": "Placilla"}, {"nombre": "Pumanque"}, {"nombre": "Quinta de Tilcoco"}, {"nombre": "Rancagua"}, {"nombre": "Rengo"}, {"nombre": "Requinoa"}, {"nombre": "San Fernando"}, {"nombre": "San Vicente"}, {"nombre": "Santa Cruz"}], "7": [{"nombre": "Cauquenes"}, {"nombre": "Chanco"}, {"nombre": "Colb\u00fan"}, {"nombre": "Constituci\u00f3n"}, {"nombre": "Curepto"}, {"nombre": "Curic\u00f3"}, {"nombre": "Empedrado"}, {"nombre": "Huala\u00f1\u00e9"}, {"nombre": "Licant\u00e9n"}, {"nombre": "Linares"}, {"nombre": "Longav\u00ed"}, {"nombre": "Maule"}, {"nombre": "Molina"}, {"nombre": "Parral"}, {"nombre": "Pelarco"}, {"nombre": "Pelluhue"}, {"nombre": "Pencahue"}, {"nombre": "Rauco"}, {"nombre": "Retiro"}, {"nombre": "R\u00edo Claro"}, {"nombre": "Romeral"}, {"nombre": "Sagrada Familia"}, {"nombre": "San Clemente"}, {"nombre": "San Javier"}, {"nombre": "San Rafael"}, {"nombre": "Talca"}, {"nombre": "Teno"}, {"nombre": "Vichuqu\u00e9n"}, {"nombre": "Villa Alegre"}, {"nombre": "Yerbas Buenas"}], "8": [{"nombre": "Alto Biob\u00edo"}, {"nombre": "Antuco"}, {"nombre": "Arauco"}, {"nombre": "Bulnes"}, {"nombre": "Cabrero"}, {"nombre": "Ca\u00f1ete"}, {"nombre": "Chiguayante"}, {"nombre": "Chill\u00e1n"}, {"nombre": "Chill\u00e1n Viejo"}, {"nombre": "Cobquecura"}, {"nombre": "Coelemu"}, {"nombre": "Coihueco"}, {"nombre": "Concepci\u00f3n"}, {"nombre": "Contulmo"}, {"nombre": "Coronel"}, {"nombre": "Curanilahue"}, {"nombre": "El Carmen"}, {"nombre": "Florida"}, {"nombre": "Hualp\u00e9n"}, {"nombre": "Hualqui"}, {"nombre": "Laja"}, {"nombre": "Lebu"}, {"nombre": "Los Alamos"}, {"nombre": "Los Angeles"}, {"nombre": "Lota"}, {"nombre": "Mulch\u00e9n"}, {"nombre": "Nacimiento"}, {"nombre": "Negrete"}, {"nombre": "Ninhue"}, {"nombre": "\u00d1iqu\u00e9n"}, {"nombre": "Pemuco"}, {"nombre": "Penco"}, {"nombre": "Pinto"}, {"nombre": "Portezuelo"}, {"nombre": "Quilaco"}, {"nombre": "Quilleco"}, {"nombre": "Quill\u00f3n"}, {"nombre": "Quirihue"}, {"nombre": "Ranquil"}, {"nombre": "San Carlos"}, {"nombre": "San Fabi\u00e1n"}, {"nombre": "San Ignacio"}, {"nombre": "San Nicol\u00e1s"}, {"nombre": "San Pedro De La Paz"}, {"nombre": "San Rosendo"}, {"nombre": "Santa B\u00e1rbara"}, {"nombre": "Santa Juana"}, {"nombre": "Talcahuano"}, {"nombre": "Tirua"}, {"nombre": "Tom\u00e9"}, {"nombre": "Trehuaco"}, {"nombre": "Tucapel"}, {"nombre": "Yumbel"}, {"nombre": "Yungay"}], "9": [{"nombre": "Angol"}, {"nombre": "Carahue"}, {"nombre": "Cholchol"}, {"nombre": "Collipulli"}, {"nombre": "Cunco"}, {"nombre": "Curacaut\u00edn"}, {"nombre": "Curarrehue"}, {"nombre": "Ercilla"}, {"nombre": "Freire"}, {"nombre": "Galvarino"}, {"nombre": "Gorbea"}, {"nombre": "Lautaro"}, {"nombre": "Loncoche"}, {"nombre": "Lonquimay"}, {"nombre": "Los Sauces"}, {"nombre": "Lumaco"}, {"nombre": "Melipeuco"}, {"nombre": "Nueva Imperial"}, {"nombre": "Padre Las Casas"}, {"nombre": "Perquenco"}, {"nombre": "Pitrufqu\u00e9n"}, {"nombre": "Puc\u00f3n"}, {"nombre": "Pur\u00e9n"}, {"nombre": "Renaico"}, {"nombre": "Saavedra"}, {"nombre": "Temuco"}, {"nombre": "Teodoro Schmidt"}, {"nombre": "Tolt\u00e9n"}, {"nombre": "Traigu\u00e9n"}, {"nombre": "Victoria"}, {"nombre": "Vilc\u00fan"}, {"nombre": "Villarrica"}], "10": [{"nombre": "Ancud"}, {"nombre": "Calbuco"}, {"nombre": "Castro"}, {"nombre": "Chait\u00e9n"}, {"nombre": "Chonchi"}, {"nombre": "Cocham\u00f3"}, {"nombre": "Curaco de V\u00e9lez"}, {"nombre": "Dalcahue"}, {"nombre": "Fresia"}, {"nombre": "Frutillar"}, {"nombre": "Futaleuf\u00fa"}, {"nombre": "Hualaihue"}, {"nombre": "Llanquihue"}, {"nombre": "Los Muermos"}, {"nombre": "Maull\u00edn"}, {"nombre": "Osorno"}, {"nombre": "Palena"}, {"nombre": "Puerto Montt"}, {"nombre": "Puerto Octay"}, {"nombre": "Puerto Varas"}, {"nombre": "Puqueld\u00f3n"}, {"nombre": "Purranque"}, {"nombre": "Puyehue"}, {"nombre": "Queil\u00e9n"}, {"nombre": "Quell\u00f3n"}, {"nombre": "Quemchi"}, {"nombre": "Quinchao"}, {"nombre": "R\u00edo Negro"}, {"nombre": "San Juan de la Costa"}, {"nombre": "San Pablo"}], "11": [{"nombre": "Ais\u00e9n"}, {"nombre": "Chile Chico"}, {"nombre": "Cisnes"}, {"nombre": "Cochrane"}, {"nombre": "Coihaique"}, {"nombre": "Guaitecas"}, {"nombre": "Lago Verde"}, {"nombre": "Ohiggins"}, {"nombre": "R\u00edo Ib\u00e1\u00f1ez"}, {"nombre": "Tortel"}], "12": [{"nombre": "ANT\u00c1RTICA"}, {"nombre": "Cabo de Hornos"}, {"nombre": "Laguna Blanca"}, {"nombre": "Natales"}, {"nombre": "Porvenir"}, {"nombre": "Primavera"}, {"nombre": "Punta Arenas"}, {"nombre": "R\u00edo Verde"}, {"nombre": "San Gregorio"}, {"nombre": "Timaukel"}, {"nombre": "Torres del Paine"}], "13": [{"nombre": "Alhu\u00e9"}, {"nombre": "Buin"}, {"nombre": "Calera de Tango"}, {"nombre": "Cerrillos"}, {"nombre": "Cerro Navia"}, {"nombre": "Colina"}, {"nombre": "Conchal\u00ed"}, {"nombre": "Curacav\u00ed"}, {"nombre": "El Bosque"}, {"nombre": "El Monte"}, {"nombre": "Estaci\u00f3n Central"}, {"nombre": "Huechuraba"}, {"nombre": "Independencia"}, {"nombre": "Isla de Maipo"}, {"nombre": "La Cisterna"}, {"nombre": "La Florida"}, {"nombre": "La Granja"}, {"nombre": "La Pintana"}, {"nombre": "La Reina"}, {"nombre": "Lampa"}, {"nombre": "Las Condes"}, {"nombre": "Lo Barnechea"}, {"nombre": "Lo Espejo"}, {"nombre": "Lo Prado"}, {"nombre": "Macul"}, {"nombre": "Maip\u00fa"}, {"nombre": "Mar\u00eda Pinto"}, {"nombre": "Melipilla"}, {"nombre": "\u00d1u\u00f1oa"}, {"nombre": "Padre Hurtado"}, {"nombre": "Paine"}, {"nombre": "Pedro Aguirre Cerda"}, {"nombre": "Pe\u00f1aflor"}, {"nombre": "Pe\u00f1alol\u00e9n"}, {"nombre": "Pirque"}, {"nombre": "Providencia"}, {"nombre": "Pudahuel"}, {"nombre": "Puente Alto"}, {"nombre": "Quilicura"}, {"nombre": "Quinta Normal"}, {"nombre": "Recoleta"}, {"nombre": "Renca"}, {"nombre": "San Bernardo"}, {"nombre": "San Joaqu\u00edn"}, {"nombre": "San Jos\u00e9 de Maipo"}, {"nombre": "San Miguel"}, {"nombre": "San Pedro"}, {"nombre": "San Ram\u00f3n"}, {"nombre": "Santiago"}, {"nombre": "Talagante"}, {"nombre": "Til til"}, {"nombre": "Vitacura"}], "14": [{"nombre": "Corral"}, {"nombre": "Futrono"}, {"nombre": "La Uni\u00f3n"}, {"nombre": "Lago Ranco"}, {"nombre": "Lanco"}, {"nombre": "Los Lagos"}, {"nombre": "M\u00e1fil"}, {"nombre": "Mariquina"}, {"nombre": "Paillaco"}, {"nombre": "Panguipulli"}, {"nombre": "R\u00edo Bueno"}, {"nombre": "Valdivia"}], "15": [{"nombre": "Arica"}, {"nombre": "Camarones"}, {"nombre": "General Lagos"}, {"nombre": "Putre"}]}};
                        //                }
                        //            });
                    }

                    this.setRegiones = function(objRegiones, objComunas) {

                        this.getJson();
                        claseFunc = this;
                        $(document).ready(function() {
                            objRegiones.html("<option value=''>Seleccionar Región</option>");
                            objComunas.html('<option value=""></option>');
                            objRegiones.append('<option value="13">RM - Región Metropolitana</option><option value="1">I - Región de Tarapaca</option><option value="2">II - Región de Antofagasta</option><option value="3">III - Región de Atacama</option><option value="4">IV - Región de Coquimbo</option><option value="5">V - Región de Valparaíso</option><option value="6">VI - Región de O\'Higgins</option><option value="7">VII - Región del Maule</option><option value="8">VIII - Región del Bio - Bio</option><option value="9">IX - Región de la Araucania</option><option value="10">X - Región de Los Lagos</option><option value="11">XI - Región de Aisen</option><option value="12">XII - Región de Magallanes Y Antartica</option><option value="14">XIV - Región de Los Rios</option><option value="15">XV - Región de Arica y Parinacota</option>');

                            objRegiones.change(function() {
                                claseFunc.setComunas($(this), objComunas);
                            });
                        });
                    }

                    this.setComunas = function(a, objComunas) {

                        var region = this.jsonComunas.region;

                        var id = $(a).val();
                        objComunas.html('');
                        objComunas.append('<option value="">Seleccionar Comuna</option>');
                        $.each(region[id], function(i, comuna) {
                            objComunas.append('<option value="' + comuna.nombre + '">' + comuna.nombre + '</option>');
                        });
                    }
            <?
        }
        ?>
            }
        </script>
        <?
    }

    public function validar() {

        $resp = false;

        $codigoJs2 = "";

        $postRecibido = false;

        if (isset($this->validacionJs) && $this->validacionJs == true) { //Verifico si se solicita validación por js
            $this->codigoJs.= '<script type="text/javascript">

                                function validarCampos_' . $this->idForm . '(){
                                        var msje="";
                                        ';
        }

        if (isset($this->parametros[0]['nombre'])) { //Si es un arreglo
            foreach ($this->parametros as $parametro) { //Recorre el arreglo
                $obligatorio = false;

                if (isset($parametro['nombre']) && !empty($parametro['nombre'])) { //Si existe el nombre y no está vacío
                    if ($this->todosObligatorios == true) { //Si todos deben ser obligatorios
                        $obligatorio = true;
                    } else if (isset($parametro['obligatorio']) && $parametro['obligatorio'] == true) { //Sino, veo si el campo debe ser obligatorio
                        $obligatorio = true;
                    }

                    if (isset($parametro['validacion'][0]) && !empty($parametro['validacion'][0])) { //Si se solicitan validaciones
                        //Recorrer validaciones
                        foreach ($parametro['validacion'] as $keyVal => $validacion) {

                            switch ($validacion) {
                                case "rut": //Validar rut
                                    if (isset($_POST[$this->parametros[0]['nombre']])) {//Verifico si se solicita validación por php
                                        $postRecibido = true;
                                        if (!$this->validarRut($_POST[$parametro['nombre']])) {
                                            $this->msjeError.="- 'RUT' no válido.<br/>";
                                        }
                                    }

                                    if (isset($this->validacionJs) && $this->validacionJs == true) { //Verifico si se solicita validación por js
                                        $this->codigoJs.= 'if(!funcionesJs.validarRut($("[name=\'' . $parametro['nombre'] . '\']").val())){
                                                                msje+="\\n- \"RUT\" no válido.";
                                                            }
                                                            ';
                                    }
                                    break;
                                case "email": //Validar e-mail
                                    if (isset($_POST[$this->parametros[0]['nombre']])) {//Verifico si se solicita validación por php
                                        $postRecibido = true;
                                        if (!$this->validarEmail($_POST[$parametro['nombre']])) {
                                            $this->msjeError.="- 'E-mail' no válido.<br/>";
                                        }
                                    }

                                    if (isset($this->validacionJs) && $this->validacionJs == true) { //Verifico si se solicita validación por js
                                        $this->codigoJs.= 'if(!funcionesJs.validarMail($("[name=\'' . $parametro['nombre'] . '\']").val())){

                                                                msje+="\\n- \"E-mail\" no válido.";

                                                            }
                                                            ';
                                    }
                                    break;
                                case "soloNumeros": //Validar solo número
                                    if (isset($_POST[$this->parametros[0]['nombre']])) {//Verifico si se solicita validación por php
                                        $postRecibido = true;
                                        if (!$this->soloNumeros($_POST[$parametro['nombre']])) {
                                            $this->msjeError.="- '" . ucfirst($parametro['nombre']) . "' no válido.<br/>";
                                        }
                                    }

                                    if (isset($this->validacionJs) && $this->validacionJs == true) { //Verifico si se solicita validación por js
                                        $this->codigoJs.= 'if(!funcionesJs.soloNumeros($("[name=\'' . $parametro['nombre'] . '\']").val())){

                                                                msje+="\\n- \"' . ucfirst($parametro['nombre']) . '\" no válido.";

                                                            }
                                                            ';
                                    }
                                    break;
                                case "archivo": //Validar solo número
                                    if (isset($_FILES[$parametro['nombre']])) {//Verifico si se solicita validación por php
                                        if (empty($_FILES[$parametro['nombre']])) {
                                            $this->msjeError.="- '" . ucfirst($parametro['nombre']) . "' no válido.<br/>";
                                        }
                                    }

                                    if (isset($this->validacionJs) && $this->validacionJs == true) { //Verifico si se solicita validación por js
                                        $this->codigoJs.= 'if($(\'[name="' . $parametro['nombre'] . '"]\').val().length<1){
                                                                msje+="\\n- \"' . ucfirst($parametro['nombre']) . '\" no válido.";
                                                            }
                                                            ';
                                    }

                                    $obligatorio = false;
                                    break;
                                case "rango": //Validar rango

                                    if (!isset($parametro['minimo'][$keyVal]) || empty($parametro['minimo'][$keyVal])) {
                                        $parametro['minimo'][$keyVal] = false;
                                    }
                                    if (!isset($parametro['maximo'][$keyVal]) || empty($parametro['maximo'][$keyVal])) {
                                        $parametro['maximo'][$keyVal] = false;
                                    }

                                    if (isset($_POST[$this->parametros[0]['nombre']])) {//Verifico si se solicita validación por php
                                        $postRecibido = true;
                                        if (!$this->validarRangoCar($_POST[$parametro['nombre']], $parametro['minimo'][$keyVal], $parametro['maximo'][$keyVal])) { //Validar rango de caracteres
                                            $msjeError = "";
                                            if ($parametro['minimo'][$keyVal] != false) {
                                                $msjeError = "mínino <b>" . $parametro['minimo'][$keyVal] . "</b> caracteres.";
                                            }

                                            if ($parametro['maximo'][$keyVal] != false) {
                                                if (empty($msjeError)) {
                                                    $msjeError = "máximo <b>" . $parametro['maximo'][$keyVal] . "</b> caracteres.";
                                                } else {
                                                    $msjeError = " y de máximo <b>" . $parametro['maximo'][$keyVal] . "</b> caracteres.";
                                                }
                                            }
                                            $this->msjeError.="- '" . ucfirst($parametro['nombre']) . "', debe ser de " . $msjeError . "<br/>";
                                        }
                                    }

                                    if (isset($this->validacionJs) && $this->validacionJs == true) { //Verifico si se solicita validación por js
                                        $this->codigoJs.= 'if(!funcionesJs.validarRangoCar($("[name=\'' . $parametro['nombre'] . '\']").val(), "' . $parametro['minimo'][$keyVal] . '", "' . $parametro['maximo'][$keyVal] . '")){
                                                            
                                                                var msjeError = "";
                                                                var min="' . $parametro['minimo'][$keyVal] . '";
                                                                var max="' . $parametro['maximo'][$keyVal] . '";
                                                                if (min != false) {
                                                                    msjeError = "mínino "+min+" caracteres.";
                                                                }

                                                                if (max != false) {
                                                                    if (empty(msjeError)) {
                                                                        msjeError = "máximo "+max+" caracteres.";
                                                                    } else {
                                                                        msjeError = " y de máximo "+max+" caracteres.";
                                                                    }
                                                                }
                                                                
                                                                msje+="\\n- \"' . ucfirst($parametro['nombre']) . '\", debe ser de "+msjeError;

                                                            }
                                                            ';
                                    }

                                    break;

                                case "expresion":

                                    if (!isset($parametro['texto'][$keyVal])) {
                                        $parametro['texto'][$keyVal] = '\"' . ucfirst($parametro['nombre']) . '\" no válido';
                                    }

                                    if (isset($_POST[$this->parametros[0]['nombre']])) {//Verifico si se solicita validación por php
                                        $postRecibido = true;
                                        if ($this->expresion($_POST[$parametro['nombre']], $parametro['expresion'][$keyVal])) {
                                            $this->msjeError.="- " . $parametro['texto'][$keyVal] . ".<br/>";
                                        }
                                    }

                                    if (isset($parametro['expresion'])) {

                                        if (isset($this->validacionJs) && $this->validacionJs == true) { //Verifico si se solicita validación por js
                                            $this->codigoJs.= 'if(funcionesJs.expresion($("[name=\'' . $parametro['nombre'] . '\']").val(), ' . $parametro['expresion'][$keyVal] . ')){
                                                                msje+=\'\\n- ' . $parametro['texto'][$keyVal] . '.\';
                                                            }
                                                            ';
                                        }
                                    }
                                    break;
                            }
                        }
                    }

                    if ($obligatorio) { //Si el campo es obligatorio
                        if (!isset($parametro['texto'][$keyVal])) {
                            $parametro['texto'][$keyVal] = '\"' . ucfirst($parametro['nombre']) . '\" es obligatorio';
                        }

                        if (isset($_POST[$this->parametros[0]['nombre']])) {//Verifico si se solicita validación por php
                            $postRecibido = true;
                            if (!isset($_POST[$parametro['nombre']]) || empty($_POST[$parametro['nombre']])) {//Verifico si el campo no existe o viene vacío
                                $this->msjeError.="- " . $parametro['texto'][$keyVal] . "<br/>";
                            }
                        }

                        if (isset($this->validacionJs) && $this->validacionJs == true) { //Verifico si se solicita validación por js
                            $this->codigoJs.= 'if($("[name=\"' . $parametro['nombre'] . '\"][type=\"radio\"]").length>0){
                                                    if($("[name=\"' . $parametro['nombre'] . '\"][type=\"radio\"]:checked").length<1){
                                                        msje+=\'\\n- ' . $parametro['texto'][$keyVal] . '.\';
                                                }
                                                }else{
                                                    if($(\'[name="' . $parametro['nombre'] . '"]\').val().length<1){
                                                        msje+=\'\\n- ' . $parametro['texto'][$keyVal] . '.\';
                                                    }
                                                }
                                                ';
                        }
                    }

                    if (isset($parametro['formato']) && !empty($parametro['formato'])) {
                        switch ($parametro['formato']) {
                            case "rut":
                                $codigoJs2.='funcionesJs.formatoRut($("[name=\'' . $parametro['nombre'] . '\']"));';
                                break;
                        }
                    }
                }
            }
        }

        if (isset($this->validacionJs) && $this->validacionJs == true) { //Verifico si se solicita validación por js
            $this->codigoJs .= 'if(msje!=""){
                                                return msje;
                                            }else{
                                                return "1";
                                            }
                                        }

                                        </script>';
        }

        if (!empty($codigoJs2)) {
            $codigoJs2 = '<script type="text/javascript">
                    $(document).ready(function() {'
                    . $codigoJs2 .
                    'var regionSeleccionada = "' . $_POST[$this->nombreSelectRegiones] . '";
                        var comunaSeleccionada = "' . $_POST[$this->nombreSelectComunas] . '";

                        funcionesJs.setRegiones($("select[name=\'' . $this->nombreSelectRegiones . '\']"), $("select[name=\'' . $this->nombreSelectComunas . '\']"), regionSeleccionada, comunaSeleccionada);


                        $("#' . $this->idBotonForm . '").click(function(e) { //Evento que gatilla la validación js
                            e.preventDefault();
                            var respVal = false;
                            respVal = validarCampos_' . $this->idForm . '(); //Función que valida los campos según configuración de la clase php
                            if (respVal != "1") {
                                alert(respVal); //procedimiento a ejecutar en caso de error en la validación js
                            } else {
                                $("#' . $this->idForm . '").submit();
                            }
                        });
                    });
                    </script>';
            $this->codigoJs .=$codigoJs2;
        }

//        if($postRecibido){
//    echo "post recibido";
//}
        if (!empty($this->msjeError) || !$postRecibido) {
            $resp = false;
        } else {
            $resp = true;
        }

//        print_r($this->parametros);
        return $resp;
    }

    function codValJs() {
        if ($this->incluirFuncionesVal) {
            $this->funcionesJs();
        }

        echo $this->codigoJs;
    }

    function insertarFormulario($objBd) {

        $resp = false;

        $objBd->Conectarse();
        
        /*Crear tabla*/
        if(isset($this->tablaFormulario)){
            $objBd->crearTabla($this->tablaFormulario);
        }

        $browser = new Browser();
        $navegador = $browser->getBrowser() . "-" . $browser->getVersion();
        $objBd->limpiarInjection();

        $fechaActual = date("Y-m-d H:i:s");

        $arrayInsert = array();
        $cont = 0;
        foreach ($this->camposFormulario as $campoFormulario) {
            $arrayInsert[$cont]['campo'] = $campoFormulario;
            $arrayInsert[$cont]['valor'] = $_POST[$campoFormulario];
            $cont++;
        }

        $arrayInsert[$cont]['campo'] = "fecha";
        $arrayInsert[$cont]['valor'] = $fechaActual;
        $cont++;
        $arrayInsert[$cont]['campo'] = "ip";
        $arrayInsert[$cont]['valor'] = $_SERVER['REMOTE_ADDR'];
        $cont++;
        $arrayInsert[$cont]['campo'] = "navegador";
        $arrayInsert[$cont]['valor'] = $navegador;

        if ($objBd->insert($arrayInsert, $this->tablaFormulario)) {

            $resp = true;
        }

        return $resp;
    }

    function obtenerRutaServidor($relativa=false) {
        $resp = false;
        if ($relativa) {
            if (preg_match("/\/.*\//", $_SERVER['SCRIPT_FILENAME'], $urlBaseServidor)) {
                $resp = $urlBaseServidor[0];
            }
        } else {
            if (preg_match("/\/.*public_html\//", $_SERVER['SCRIPT_FILENAME'], $urlBaseServidor)) {
                $resp = $urlBaseServidor[0];
            }
        }

        return $resp;
    }

    function obtenerRutaSitio($relativa=false) {
        $resp = false;

        if ($relativa) {

            if (preg_match("/\/.*\//", $_SERVER['REQUEST_URI'], $urlRelativaTemp)) {
                $urlRelativa = $urlRelativaTemp[0];
            } else {
                $urlRelativa = $_SERVER['REQUEST_URI'];
            }
            $resp = "http://" . str_replace("http://", "", $_SERVER['HTTP_HOST']) . $urlRelativa;
        } else {
            $resp = "http://" . str_replace("http://", "", $_SERVER['HTTP_HOST']);
            if (preg_match("/desarrollo\.4sale\.cl/", $_SERVER['HTTP_HOST'])) {
                $resp.='/~clientes/';
            }
        }

        return $resp;
    }

    function setVariable($variable, $valor) {
        if (strlen($variable) == 0) {
            return $valor;
        }return $variable;
    }

}
?>
