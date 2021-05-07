<title><?= $this->vista->globales['tituloPagina'] ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=IE6">
<meta name="keywords" content="<?= $this->vista->globales["metakeyworks"]?>">
<meta name="description" content="<?= $this->vista->globales["metadescription"]?>">
<script type="text/javascript" src="<?=$this->vista->globales['rutaVistas'].carpetaVistasBase?>js/jquery-1.9.1.min.js"></script>
<!--[if IE]><script src="<?=$this->vista->globales['rutaVistas']?>js/html5.js"></script><![endif]-->
<script type="text/javascript"> 
	var $thispage = '<? echo $this->vista->globales["thispage"]; ?>';
	var anchoVentana = $(window).width(); 
</script>
<link type="image/x-icon" rel="shortcut icon" href="<?=$this->vista->globales['rutaVistas'].carpetaVistasBase?>js/favicon.ico" />
<link rel="apple-touch-icon" href="<?=$this->vista->globales['rutaVistas'].carpetaVistasBase?>img/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?=$this->vista->globales['rutaVistas'].carpetaVistasBase?>img/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?=$this->vista->globales['rutaVistas'].carpetaVistasBase?>img/apple-touch-icon-114x114.png"> 
<? include('opengraph.php'); ?>
<!-- css -->
<link rel="stylesheet" media="screen" href="<?=$this->vista->globales['rutaVistas'].carpetaVistasBase?>css/default.css"/>
<link rel="stylesheet" media="screen" href="<?=$this->vista->globales['rutaVistas'].carpetaVistasBase?>font/font.css"/>
<link rel="stylesheet" media="screen" href="<?=$this->vista->globales['rutaVistas'].carpetaVistasBase?>css/style.css?=<? echo time();?>"/>
<link rel="stylesheet" media="print" href="<?=$this->vista->globales['rutaVistas'].carpetaVistasBase?>css/print.css"/>
<? include('responsivo.php'); ?>
<!-- /css -->
