<?
//Configuración del módulo de formulario
//Base de datos
$globales[$_GET[nomParamModulo]]['index']['tablaBd'] = prefijoTablasBd."formulario1";

//Envío de correo
$globales[$_GET[nomParamModulo]]['index']['enviarMail'] = "si"; //Si se desea desactivar, colocar "no"
$globales[$_GET[nomParamModulo]]['index']['mailsDestino'] = "hectzimudec@gmail.com"; //Lista de mails destino, separados por coma
$globales[$_GET[nomParamModulo]]['index']['asunto'] = "Formulario 2 de ".$this->vista->globales['marca']; //Asunto del correo
$globales[$_GET[nomParamModulo]]['index']['fromName'] = "Se envía desde ".$this->vista->globales['marca']; //FromName del correo
$globales[$_GET[nomParamModulo]]['index']['from'] = "formularios@4sale.cl"; //Mail de origen
$globales[$_GET[nomParamModulo]]['index']['copiaOcultaMail'] = ""; //Lista de mails con copia oculta, separados por coma (Ej: formularios@4sale.cl)

//Copia hacia el usuario.
$globales[$_GET[nomParamModulo]]['index']['campoCopiaMailUsuario'] = "mail"; //Indicar campo de correo del formulario, para enviar copia del mail al usuario.

?>