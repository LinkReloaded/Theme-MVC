<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Backend</title>
    </head>
    <body style="color:#000 !important;font-family:Arial, Helvetica, sans-serif; font-size:12px; width:600px;">
        <img src="<?=$this->vista->globales['rutaVistasModulo']?>img/imagentop.jpg" alt="" width="600" height="100" />
             <h3 style="background-color:#34424f; font-size:14px; color:white !important; padding:4px;">Recuperaci&oacute;n de Contrase&ntilde;a</h3>
            <div style="font-weight:normal; padding:10px;">
                <p style="text-transform:uppercase;text-align:center;">Hola <strong><?=$result[0]['nombres']?></strong>, su contrase&ntilde;a es:</p>
                <p style="text-align:center; font-weight:bold;"><?=$this->desencriptar($result[0]['contrasena'], $result[0]['llaveContrasena'])?></p>
            </div>
    </body>
</html>