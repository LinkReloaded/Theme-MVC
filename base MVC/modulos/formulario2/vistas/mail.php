<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?= $this->marca ?></title>
    </head>
    <body class="mail" style="font-family:Arial, Helvetica, sans-serif; color:#000 !important; font-size:12px; width:550px;">
        <img src="<?= $this->vista->globales['rutaVistasModulo']. 'img/imagentop.jpg?' . $this->time ?>" alt="<?= $this->marca ?>" />
        <h4 style="font-family:Arial, Helvetica, sans-serif; color:#7c7c7c !important">Esta solicitud de cotización fue recibida por el cotizador web de <?= $this->marca ?></h4>
        <div>
            <h3 style="font-family:Arial, Helvetica, sans-serif; background-color:#6f6f6f; font-size:14px; color:white !important; padding:4px;">Datos del cliente</h3>
            <div style="font-family:Arial, Helvetica, sans-serif; padding:0px 10px; text-transform:uppercase; font-weight:bold">
                <p>NOMBRE: <span style="font-family:Arial, Helvetica, sans-serif; font-weight:normal;"><?= $_POST[$campos[0]] ?></span></p>
                <p>APELLIDO: <span style="font-family:Arial, Helvetica, sans-serif; font-weight:normal;"><?= $_POST[$campos[1]] ?></span></p>
                <p>RUT: <span style="font-family:Arial, Helvetica, sans-serif; font-weight:normal;"><?= $_POST[$campos[2]] ?></span></p>
                <p>EMAIL: <span style="font-family:Arial, Helvetica, sans-serif; font-weight:normal;"><?= $_POST[$campos[3]] ?></span></p>
                <p>DIRECCI&Oacute;N: <span style="font-family:Arial, Helvetica, sans-serif; font-weight:normal;"><?= $_POST[$campos[5]] ?></span></p>
                <p>REGI&Oacute;N: <span style="font-family:Arial, Helvetica, sans-serif; font-weight:normal;"><?= $_POST[$campos[8]] ?></span></p>
                <p>COMUNA: <span style="font-family:Arial, Helvetica, sans-serif; font-weight:normal;"><?= $_POST[$campos[9]] ?></span></p>
                <p>TEL&Eacute;FONO: <span style="font-family:Arial, Helvetica, sans-serif; font-weight:normal;"><?= $_POST[$campos[6]] . "-" . $_POST[$campos[7]] ?></span></p>
            </div>
        </div>
        <div>
            <h3 style="font-family:Arial, Helvetica, sans-serif; background-color:#6f6f6f; font-size:14px; color:white !important; padding:4px;">Datos del Autom&oacute;vil</h3>
            <div style="font-family:Arial, Helvetica, sans-serif; padding:0px 10px; text-transform:uppercase; font-weight:bold">
                <p>MARCA: <span style="font-family:Arial, Helvetica, sans-serif; font-weight:normal;"><?= $_POST[$campos[10]] ?></span></p>
                <p>MODELO: <span style="font-family:Arial, Helvetica, sans-serif; font-weight:normal;"><?= $_POST[$campos[11]] ?></span></p>
                <p>A&Ntilde;O: <span style="font-family:Arial, Helvetica, sans-serif; font-weight:normal;"><?= $_POST[$campos[13]] ?></span></p>
                <p>KIL&Oacute;METROS: <span style="font-family:Arial, Helvetica, sans-serif; font-weight:normal;"><?= $_POST[$campos[14]] ?></span></p>
                <p>VERSI&Oacute;N: <span style="font-family:Arial, Helvetica, sans-serif; font-weight:normal;"><?= $_POST[$campos[12]] ?></span></p>
            </div>
        </div>
        <div>
            <h3 style="font-family:Arial, Helvetica, sans-serif; background-color:#6f6f6f; font-size:14px; color:white !important; padding:4px;">&iquest;EN QUE LOCAL DESEA SER ATENDIDO?</h3>
            <div style="font-family:Arial, Helvetica, sans-serif; padding:0px 10px; text-transform:uppercase; font-weight:bold">
                <p>SUCURSAL SELECCIONADA: <span style="font-family:Arial, Helvetica, sans-serif; font-weight:normal;"><?= $_POST[$campos[15]] ?></span></p>
            </div>
        </div>
    </body>
</html>