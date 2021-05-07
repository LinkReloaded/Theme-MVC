<!doctype html>
<html lang="es">
    <head>
        <?
        $objHeader = $this->cargarControlador("header", true);
        $objHeader->cargarHeader();
        ?>
        <?
        if (!isset($_GET['enviado'])) {
            ?>
            <? $this->validaForm1->codValJs(); //Imprime código para validar por js  ?>
            <script type="text/javascript">
                $(document).ready(function() {
                    $("select[name='codArea']").html($("#telFijo").html());
                    $("#tel-01").click(function() {
                        $("input[name='tipoFono']").val("1");
                        $("select[name='codArea']").html($("#telFijo").html());
                        $("#tel-02").removeClass("select").addClass("noselect");
                        $(this).removeClass("noselect").addClass("select");
                    });
                    $("#tel-02").click(function() {
                        $("input[name='tipoFono']").val("2");
                        $("select[name='codArea']").html($("#telMovil").html());
                        $("#tel-01").removeClass("select").addClass("noselect");
                        $(this).removeClass("noselect").addClass("select");
                    });
                });
            </script>
            <?
        }
        ?>
    </head>
    <body id="<?= $objHeader->vista->globales['thispage'] //ACA IMPRIMIR LA VISTA EN DONDE ESTOY <---------------------    ?>">

        <header>
            <div class="col">
                <figure>
                    <a href="http://www.okusados.cl" ><img src="<?= $this->vista->globales['rutaVistasModulo']. 'img/imagentop.jpg?' . $this->time ?>" alt="imagen de prueba"></a>
                </figure>                               
            </div>
            <div class="clear"></div>
        </header>

        <section id="cont">
            <div class="col">

                <?
                if (isset($_GET['enviado']) || isset($_GET['error'])) {
                    ///////////////////////////////////////////////////////////////////////////////////////////
//	GRACIAS
/////////////////////////////////////////////////////////////////////////////////////////// 
                    ?>
                    <section id="paso04" style="display:block;">
                        <?
                        if (isset($_GET['error'])) {
                            ?>
                            <div class="panel-gracias">
                                <? //MENSAJE DE ERROR    ?>
                                <div class="mensaje-error">Se ha producidor un error. Intente nuevamente clickeando <a href="#" onclick="history.go(-2);">acá</a>.</div>
                                <div class="clear"></div>
                            </div>
                            <?
                        } else {
                            ?>
                            <div class="cabecera">
                                <div class="colder">
                                    <div class="row" style="padding-top:15px; height:25px;">
                                        <h3>COTIZACI&Oacute;N ENVIADA</h3>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="clear"></div>
                            </div>

                            <div class="panel-gracias">

                                <h2><?= $this->vista->datosUsuario[0]['nombre'] ?> <?= $this->vista->datosUsuario[0]['apellido'] ?></h2>

                                <? //MENSAJE DE EXTIO    ?>
                                <p>Tu cotizaci&oacute;n fue enviada exitosamente a <span><?= $this->vista->datosUsuario[0]['mail'] ?></span> <br/>Pronto uno de nuestros ejecutivos te contactar&aacute;</p>
                                <? //MENSAJE DE ERROR    ?>
                                <? /*
                                  <div class="mensaje-error">Hay un problema con tu cotizaci&oacute;n, por favor int&eacute;ntalo m&aacute;s tarde.</div>

                                  <a class="btn-desc" href="<?= $this->vista->urlPdf ?>"><img src="img/btn_descargar.png"  alt="Quieres descargar tu cotizaci&oacute;n"></a>
                                 */ ?>
                                <div class="clear"></div>
                            </div>
                            <div class="mensaje-legal">Los datos personales recogidos en este formulario, se utilizar&aacute;n exclusivamente para efectos de cotizaci&oacute;n</div>
                            <?
                        }
                        ?>
                        <nav>
                            <div class="colder">
                                <a class="btn-continuar" href="http://www.okusados.cl">VOLVER A OKUSADOS.CL</a>
                            </div>
                        </nav>

                    </section>
                    <?
                } else {
                    ///////////////////////////////////////////////////////////////////////////////////////////
                    //	REGISTRO
                    /////////////////////////////////////////////////////////////////////////////////////////// 
                    ?>		
                    <section id="paso02" style="display:block;">

                        <div class="cabecera">
                            <div class="colder">
                                <div class="row">
                                    <h3>COMPRAMOS TU AUTO</h3>
                                </div>
                                <div class="row">
                                    <p>Completa los campos que se presentan a contnuaci&oacute;n para coordinar la tasaci&oacute;n.<br/><span>Los datos con asterisco (*) son obligatorios.</span></p>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="clear"></div>
                        </div>              

                        <form class="form-datos-pers" id="<?= $this->validaForm1->idForm ?>" action="<?= $this->vista->globales['actionForm'] ?>" method="post">
                            <div class="row linea_arriba">
                                <!-- columna uno -->
                                <div class="col-1 col-col">
                                    <h2>DATOS PERSONALES</h2>
                                    <div class="formulario">
                                        <div class="row dato"><label>(*) NOMBRE:</label><span><input name="nombre" type="text" value="<?= $_POST['nombre'] ?>"></span><div class="clear"></div></div>
                                        <div class="row dato"><label>(*) APELLIDO:</label><span><input name="apellido" type="text" value="<?= $_POST['apellido'] ?><?= $_POST['ApellidoMat'] ?>"></span><div class="clear"></div></div>
                                        <div class="row dato"><label>(*) RUT:</label><span class="c-med"><input name="rut" type="text" value="<?= $_POST['rut'] ?>"></span><div class="clear"></div></div>
                                        <div class="row dato"><label>(*) EMAIL:</label><span><input name="mail" type="text" value="<?= $_POST['mail'] ?>"></span><div class="clear"></div></div>
                                        <div class="row dato"><label>(*) DIRECCI&Oacute;N:</label><span><input name="direccion" type="text" value="<?= $_POST['direccion'] ?><?= $_POST['numero'] ?>"></span><div class="clear"></div></div>
                                        <div class="row dato"><label>(*) REGI&Oacute;N:</label><span class="c-med"><select name="region"><option value=""></option></select></span><div class="clear"></div></div>
                                        <div class="row dato"><label>(*) COMUNA:</label><span class="c-med"><select name="comuna"><option value=""></option></select></span><div class="clear"></div></div>
                                        <div class="row dato">
                                            <label>(*) TEL&Eacute;FONO:</label>
                                            <ul class="datos-tel">
                                                <li class="opcion"><span id="tel-01" class="select"></span><label>FIJO</label><div class="clear"></div></li>
                                                <li class="opcion"><span id="tel-02" class="noselect"></span><label>M&Oacute;VIL</label><div class="clear"></div></li>
                                                <input type="hidden" name="tipoFono" value="1" />
                                                <div class="clear"></div>
                                                <span class="sub-tel">
                                                    <select name="codArea"></select>
                                                </span>
                                                <select id="telFijo" style="display:none;">
                                                    <option value="02">02</option>
                                                    <option value="75">75</option>
                                                    <option value="73">73</option>
                                                    <option value="72">72</option>
                                                    <option value="71">71</option>
                                                    <option value="68">68</option>
                                                    <option value="67">67</option>
                                                    <option value="65">65</option>
                                                    <option value="64">64</option>
                                                    <option value="63">63</option>
                                                    <option value="58">58</option>
                                                    <option value="57">57</option>
                                                    <option value="55">55</option>
                                                    <option value="53">53</option>
                                                    <option value="52">52</option>
                                                    <option value="51">51</option>
                                                    <option value="45">45</option>
                                                    <option value="43">43</option>
                                                    <option value="42">42</option>
                                                    <option value="41">41</option>
                                                    <option value="39">39</option>
                                                    <option value="35">35</option>
                                                    <option value="34">34</option>
                                                    <option value="33">33</option>
                                                    <option value="32">32</option>
                                                </select>
                                                <select class="sub-tel" id="telMovil" style="display:none;">
                                                    <option value="09">09</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                </select>
                                                <input class="mediano" name="fono" type="text" value="<?= $_POST['fono'] ?>"> 
                                                <div class="clear"></div>
                                            </ul>
                                            <div class="clear"></div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>  
                                    <div class="clear"></div>
                                </div>
                                <!-- /columna uno -->						
                                <!-- columna dos -->
                                <div class="col-2 col-col">
                                    <h2>DATOS DEL AUTOM&Oacute;VIL</h2>
                                    <div class="formulario">
                                        <div class="row dato"><label>(*)  MARCA:</label><span>
                                                <select name="marca" class="largo">
                                                    <option value="1">Seleccione Marca</option>
                                                    <?
                                                    if (is_array($this->vista->marcas)) {
                                                        foreach ($this->vista->marcas as $marca) {
                                                            ?>
                                                            <option value="<?= $marca["id"] ?>"><?= $marca["nombre"] ?></option>
                                                            <?
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </span><div class="clear"></div></div>
                                        <div class="row dato"><label>MODELO:</label><span><input type="text" name="modelo"></span><div class="clear"></div></div>
                                        <div class="row dato"><label>A&ntilde;O:</label><span class="c-med">
                                                <select name="anio">
                                                    <option value="">Seleccione Año</option>
                                                    <?
                                                    $anioActual = (int) date("Y");
                                                    for ($i = ($anioActual - 10); ($i <= ($anioActual)); $i++) {
                                                        ?>
                                                        <option value="<?= $i ?>"><?= $i ?></option>
                                                        <?
                                                    }
                                                    ?>
                                                </select>
                                            </span><div class="clear"></div></div>
                                        <div class="row dato"><label>(*) KIL&Oacute;METROS:</label><span><input type="text" name="kilometros"></span><div class="clear"></div></div>
                                        <div class="row dato"><label>(*) VERSI&Oacute;N:</label><span><input type="text" name="version"></span><div class="clear"></div></div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <!-- /columna dos -->
                                <div class="clear"></div>
                            </div>

                            <div class="row linea_arriba">
                                <div class="col-3">
                                    <h2>&iquest;EN QUE LOCAL DESEA SER ATENDIDO?</h2>
                                    <div class="formulario">
                                        <div class="row dato">
                                            <label>SELECCIONE SUCURSAL:</label>
                                            <span>
                                                <select class="tipo" name="sucursal">
                                                    <option value="" selected="selected">Seleccione Sucursal</option>
                                                    <option value="Parque Arauco">Parque Arauco</option>
                                                    <option value="Plaza Oeste">Plaza Oeste</option>
                                                    <option value="Movicenter">Movicenter</option>
                                                    <option value="Departamental">Departamental</option>					
                                                </select>
                                            </span>
                                            <div class="clear"></div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>							
                                    <div class="clear"></div>
                                </div>	
                                <div class="clear"></div>
                            </div>
                        </form>

                        <nav>
                            <div class="colizq">
                                <a class="btn-volver" href="javascript:history.back()">VOLVER</a>
                            </div>                
                            <div class="colder">
                                <a class="btn-continuar" id="<?= $this->validaForm1->idBotonForm ?>" href="#">CONTINUAR</a>
                            </div>
                        </nav>

                    </section>
                    <?
                }
                ?>

                <div class="link">
                    <a href="<?= $terminosYCondiciones ?>" target="_blank">T&eacute;rminos y Condiciones</a>
                </div>

                <div class="clear"></div>
            </div>

            <div class="clear"></div>
        </section>

        <? include('inc/footer.php'); ?>	
    </body>
</html>