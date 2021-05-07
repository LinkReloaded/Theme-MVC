<?
if ($this->vista->globales["responsivo"] == "si") {
    ?>
    <meta name="viewport" content="initial-scale=1">
    <link type="text/css" rel="stylesheet" media="screen" href="<?=$this->vista->globales['rutaVistas'].carpetaVistasBase?>css/layout768.css"/>
    <link type="text/css" rel="stylesheet" media="screen" href="<?=$this->vista->globales['rutaVistas'].carpetaVistasBase?>css/layout480.css"/>
    <link type="text/css" rel="stylesheet" media="screen" href="<?=$this->vista->globales['rutaVistas'].carpetaVistasBase?>css/layout320.css"/>    
    <?
} else {

    $isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'], 'iPad');
    if (!empty($isiPad)) { //detecta si el navegador es iPad  
        ?>
        <!-- css ipad -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link type="text/css" rel="stylesheet" media="screen" href="<?=$this->vista->globales['rutaVistas'].carpetaVistasBase?>css/ipad.css?=<? echo time(); ?>"/>
        <!-- /css ipad -->
        <?
    }
    ?>
    <!--[if IE 7]><link rel="stylesheet" media="screen" href="<?=$this->vista->globales['rutaVistas'].carpetaVistasBase?>css/style7.css?=<? echo time(); ?>" /><![endif]-->
    <!--[if IE 8]><link rel="stylesheet" media="screen" href="<?=$this->vista->globales['rutaVistas'].carpetaVistasBase?>css/style8.css?=<? echo time(); ?>" /><![endif]-->
    <?
}
?>
