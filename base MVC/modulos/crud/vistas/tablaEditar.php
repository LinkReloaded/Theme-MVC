<form id='cambiarCont' action='<?= $this->vista->globales['actionForm'] ?>' method='POST' enctype='multipart/form-data'>

    <? /* <script type="text/javascript" src="jQuery1.7.1.js"></script> */ ?>
    <script type="text/javascript" src="<?= $this->vista->globales['rutaVistasModulo'] ?>js/ckeditor/ckeditor.js"></script>

    <div id='comienzo'></div>
    <table class='editarFicha'>

        <?
        print_r($this->vista->globales["arregloMaestro"]);
        //Listar datos de la ficha
        foreach ($this->vista->globales["arregloMaestro"]['campos'] as $campoForm) {

            if (isset($campoForm['tipo'])) {
                switch ($campoForm['tipo']) {

                    case "hidden":
                        ?>
                        <tr>
                            <td></td>
                            <td>
                                <input type="hidden" name="<?
                                if (isset($campoForm['nombre'])) {
                                    echo $campoForm['nombre'];
                                }
                                ?>" value="<?
                                       if (isset($campoForm['contenido'])) {
                                           echo $campoForm['contenido'];
                                       }
                                       ?>" />
                            </td>
                        </tr>
                        <?
                        break;

                    case "text":
                        ?>
                        <tr>
                            <td>
                                <?
                                if (isset($campoForm['titulo'])) {
                                    echo $campoForm['titulo'];
                                }
                                ?>
                            </td>
                            <td>
                                <input type="text" name="<?
                                if (isset($campoForm['nombre'])) {
                                    echo $campoForm['nombre'];
                                }
                                ?>" value="<?
                                       if (isset($campoForm['contenido'])) {
                                           echo $campoForm['contenido'];
                                       }
                                       ?>" />
                            </td>
                        </tr>
                        <?
                        break;

                    case "editor":

                        $idEditor = "";
                        if (isset($campoForm['nombre'])) {
                            $idEditor = $campoForm['nombre'];
                        }
                        ?>
                        <script type='text/javascript'>
                            $(document).ready(function() {
                                CKEDITOR.replace('<?= $idEditor ?>',
                                        {
                                            toolbar:
                                                    [
                                                        {name: 'document', items: ['Source', '-', 'Save', 'NewPage', 'DocProps', 'Preview', 'Print', '-', 'Templates']},
                                                        {name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
                                                        {name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt']},
                                                        {name: 'forms', items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton',
                                                                'HiddenField']}, '/',
                                                        {name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']},
                                                        {name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl']},
                                                        {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
                                                        {name: 'insert', items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe']}, '/',
                                                        {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
                                                        {name: 'colors', items: ['TextColor', 'BGColor']},
                                                        {name: 'tools', items: ['Maximize', 'ShowBlocks', '-', 'About']}
                                                    ]
                                        });
                            });
                            CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                        </script>

                        <tr>
                            <td>
                                <?
                                if (isset($campoForm['titulo'])) {
                                    echo $campoForm['titulo'];
                                }
                                ?>
                            </td>
                            <td>
                                <textarea name="<?
                                if (isset($campoForm['nombre'])) {
                                    echo $campoForm['nombre'];
                                }
                                ?>" id="<?= $idEditor ?>" >
                                              <?
                                              if (isset($campoForm['contenido'])) {
                                                  echo $campoForm['contenido'];
                                              }
                                              ?>
                                </textarea>
                            </td>
                        </tr>

                        <?
                        break;

                    case "select":
                        ?>
                        <tr>
                            <td>
                                <?
                                if (isset($campoForm['titulo'])) {
                                    echo $campoForm['titulo'];
                                }
                                ?></td>
                            <td>
                                <select name="
                                <?
                                if (isset($campoForm['nombre'])) {
                                    echo $campoForm['nombre'];
                                }
                                ?>">

                                    <?
                                    if (isset($campoForm['valores']) && is_array($campoForm['valores'])) {

                                        foreach ($campoForm['valores'] as $valores) {
                                            ?>
                                            <option value="
                                            <?
                                            if (isset($valores['valor'])) {
                                                echo $valores['valor'];
                                            }
                                            ?>" <? if (isset($campoForm['contenido']) && $campoForm['contenido'] == $valores['valor']) {
                                                ?>selected='selected'<? }
                                            ?>>
                                                        <?
                                                        if (isset($valores['texto'])) {
                                                            echo $valores['texto'];
                                                        }
                                                        ?>
                                            </option>
                                            <?
                                        }
                                    }
                                    ?>

                                </select>
                            </td>
                        </tr>

                        <?
                        break;

                    case "file":
                        ?>
                        <tr>
                            <td>
                                <?
                                if (isset($campoForm['titulo'])) {
                                    echo $campoForm['titulo'];
                                }
                                ?>
                            </td>
                            <td><input type="file" name="
                                <?
                                if (isset($campoForm['nombre'])) {
                                    echo $campoForm['nombre'];
                                }
                                ?>" /><br/><br/>
                                <input type="checkbox" name="borrar_
                                <?
                                if (isset($campoForm['nombre'])) {
                                    echo $campoForm['nombre'];
                                }
                                ?>"> Eliminar

                                <? if (!empty($campoForm['contenido'])) {
                                    ?><span><a target="_blank" href="<?= rutaRecursos . $_REQUEST['sitio'] . "/" . $_REQUEST['seccion'] . "_" . $_REQUEST['id'] . "/" . $campoForm['contenido'] . $time ?>">Imágen Subida</a></span>
                                    <?
                                }
                                ?>
                            </td>
                        </tr>
                        <?
                        break;

                    case "titulo":
                        ?>
                        <tr>
                            <td class="tituloForm">
                                <b>
                                    <?
                                    if (isset($campoForm['titulo'])) {
                                        echo $campoForm['titulo'];
                                    }
                                    ?>
                                </b>
                            </td>
                            <td class="tituloForm"></td>
                        </tr>
                        <?
                        break;

                    case "multiCheck":
                        $camposArray = null;
                        if (isset($campoForm['contenido'])) {
                            $camposArray = explode(";;", $campoForm['contenido']);
                        }

                        if (isset($campoForm['valores']) && is_array($campoForm['valores'])) {
                            $k = 0;
                            foreach ($campoForm['valores'] as $valores) {
                                ?>
                                <tr>
                                    <?
                                    if ($k == 0) {
                                        ?>
                                        <td>
                                            <?
                                            if (isset($campoForm['titulo'])) {
                                                echo $campoForm['titulo'];
                                            }
                                            ?>
                                        </td>
                                        <?
                                    } else {
                                        ?>
                                        <td>&nbsp;</td>
                                        <?
                                    }
                                    ?>
                                    <td>
                                        <input type="checkbox" name="
                                        <?
                                        if (isset($campoForm['nombre'])) {
                                            echo $campoForm['nombre'];
                                        }
                                        ?>[]" value="<?
                                               if (isset($valores['valor'])) {
                                                   echo $valores['valor'];
                                               }
                                               ?>"
                                               <?
                                               if (isset($campoForm['contenido']) && !empty($campoForm['contenido']) && is_array($camposArray)) {
                                                   if (in_array($valores['valor'], $camposArray)) {
                                                       ?>
                                                       checked="checked"
                                                       <?
                                                   }
                                               } else if (isset($campoForm['default']) && $campoForm['default'] == "checked") {
                                                   ?>checked="checked"
                                                   <?
                                               }
                                               ?> />
                                               <?
                                               if (isset($valores['texto'])) {
                                                   echo $valores['texto'];
                                               }
                                               ?>
                                    </td>
                                </tr>
                                <?
                                $k++;
                            }
                        }

                        break;

                    case "separador":
                        ?>
                        <tr>
                            <td class="sepForm">&nbsp;</td>
                            <td class="sepForm">&nbsp;</td>
                        </tr>
                        <?
                        break;
                }
            }
        }
        ?>

        <tr><td><input type='hidden' name='guardar' value='Guardar' /></td><td></td></tr>
    </table>

    <input type='hidden' name='seccion' value='<?= $_REQUEST['seccion'] ?>' />
    <input type='hidden' name='sitio' value='<?= $_REQUEST['sitio'] ?>' />
    <div id='final'></div>
</form>
