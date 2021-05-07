<?
if ($this->vista->globales["opengraph"] == "si") {
    ?>
    <!-- opengraph -->
    <meta property="fb:app_id" content="<?= $this->vista->globales["OGapp_id"] ?>"/>
    <meta property="fb:admins" content="<?= $this->vista->globales["OGadmin_id"] ?>"/>
    <meta property="og:url" content="<?= $this->vista->globales["URLestaPagina"] ?>"/> 
    <meta property="og:title" content="<?= $this->vista->globales["tituloPagina"] ?>"/>
    <meta property="og:description" content="<?= $this->vista->globales["descOGpagina"] ?>"/>
    <meta property="og:type" content="website" />
    <meta property="og:image" content="<?= $this->vista->globales["imagenOGpagina"] ?>"/>
    <!-- /opengraph -->
    <?
}
?>
