<?
get_header();
?>
<!--WRAP-->
<div id="wrap">

    <!--Header-->
    <header>
        <div id="header">
            <div class="huella2">Noticias</div>
        </div>
    </header>    
    <!--Header-->

    <!--Paginador-->
    <?
    if (!isset($_GET['paged'])) {
        $_GET['paged'] = 1;
    }
    $_GET['paged'] = (int) $_GET['paged'];
    ?>
    <!--//Header-->
    
    <!--Paginador-->
    <script type="text/javascript">
        jQuery(document).ready(function() {
            var paginador1 = "";
            var paginador2 = "";
            var paged =<?= $_GET['paged'] ?>;
            if (jQuery("#paginador").find(".colpag-ant").length > 0) {
                paginador1 = jQuery("#paginador").find(".colpag-ant").parent();
                <?/*paginador1.attr("href", "<?=$this->vista->globales['actionForm']?>category.php?cat=1&paged=" + (paged - 1));*/?>
                paginador1.attr("href", "./<?= $this->vista->globales['actionForm'] ?>&cat=1&paged=" + (paged - 1));
            }
            if (jQuery("#paginador").find(".colpag-sig").length > 0) {
                paginador2 = jQuery("#paginador").find(".colpag-sig").parent();
                <?/*paginador2.attr("href", "<?=$this->vista->globales['actionForm']?>category.php?cat=1&paged=" + (paged + 1));*/?>
                paginador2.attr("href", "./<?= $this->vista->globales['actionForm'] ?>&cat=1&paged=" + (paged + 1));
            }
        });
    </script>
    <!--Paginador-->

    <!--Contenido-Blog-->
    <section>

        <!--Blog-->	
        <div id="blog">

            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            query_posts('paged=' . $paged . '&amp;cat=1');
            if (have_posts()) : while (have_posts()) : the_post();
                    ?>
                    <div class="ContBlog">
                        <div class="imagenPost">
                            <?/*<a href="<?=$this->vista->globales['WPRutaRaiz']?>single.php?id=<?php the_ID(); ?>">*/?>
                            <a href="<?=$this->vista->globales['WPRutaRaiz']?>?p=<?php the_ID(); ?>">
                                <?php if (has_post_thumbnail()) { ?>      
                                    <?php the_post_thumbnail('img_cat'); ?>
                                    <?php
                                } else {
                                    if (function_exists('cim_the_thumb')) {
                                        cim_the_thumb('medium');
                                    }
                                }
                                ?>
                            </a>
                        </div>
                        <?/*<a href="<?=$this->vista->globales['WPRutaRaiz']?>single.php?id=<?php the_ID(); ?>">*/?>
                        <a href="<?=$this->vista->globales['WPRutaRaiz']?>?p=<?php the_ID(); ?>">
                            <div class="txtPost">
                                <p><?php the_title(); ?></p>
                            </div></a> 
                    </div>

                    <div id="sombra_blog"></div>

                    <?php
                endwhile;
            endif;
            ?>

            <!-- paginador -->
            <div id="paginador">
                <?php previous_posts_link('<div class="colpag-ant">ANTERIOR</div>'); ?>
                <?php next_posts_link('<div class="colpag-sig">SIGUIENTE</div>'); ?>                     
                <div class="clear"></div>
            </div>
            <!-- /paginador -->

            <div class="clearfix"></div>
        </div>
        <!--//Blog-->

    </section>
    <!--//Contenido-Blog-->
</div>
<!--//WRAP-->
</body>
</html>