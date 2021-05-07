<!-- plugins -->
<?php /*?><!-- superfish -->
<link href="js/superfish/superfish.css" rel="stylesheet" media="screen" />
<script type="text/javascript" src="js/superfish/superfish.js" ></script>
<script type="text/javascript" src="js/superfish/hoverIntent.js" ></script>
<!-- /superfish --><?php */?>
<?php /*?><!-- jCarousel -->
<link href="js/jcarousel/jcarousel.css" rel="stylesheet" media="screen" />
<script type="text/javascript" src="js/jcarousel/jquery.jcarousel.min.js" ></script>
<!-- /jCarousel --><?php */?>
<?php /*?><!-- shadowbox -->
<link href="js/shadowbox/shadowbox.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/shadowbox/shadowbox.js"></script>
<!-- /shadowbox --><?php */?>
<?php /*?><!-- acordeon -->
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("dd").hide();
		jQuery("#primero").slideToggle("slow");
		jQuery("dt a").click(function(){		
			jQuery(this).parent().next().siblings("dd:visible").slideUp("slow");
			jQuery(this).parent().next().slideToggle("slow");
			jQuery(this).parent().siblings("dt").addClass("marcado");
			jQuery(this).parent().next().siblings("dt").toggleClass("marcado");
		return false;
		});		
	});
		jQuery(document).ready(function(){
		jQuery("#subacordeon dd").hide();
		jQuery("#subacordeon a").click(function(){		
			jQuery(this).parent().next().siblings("dd:visible").slideUp("slow");
		return false;
		});		
	});
</script>
<!-- /acordeon --><?php */?>
<!-- /plugins -->
