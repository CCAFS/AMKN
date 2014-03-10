<?php
/**
 * Template Name: AMKN Home
 * @package WordPress
 * @subpackage AMKNToolbox
 */

get_header();
get_sidebar( 'home' );
?>


<div class="maincol">




<?php get_template_part( 'map', 'esri-layers' ); ?>


<div class="shadow"></div>


<div class="latest-stories">
<h3 class="lstories">Latest Stories</h3>
<ul>

<li><a href="#"><img src="<?php bloginfo( 'template_directory' ); ?>/images/tab-all.png" onmouseover="replaceme(this,'<?php bloginfo( 'template_directory' ); ?>/images/tab-all_hv.png')" onmouseout="restoreme(this,'<?php bloginfo( 'template_directory' ); ?>/images/tab-all.png')" alt="All" title="All"/></a></li>

<li><a href="#"><img src="<?php bloginfo( 'template_directory' ); ?>/images/tab-video.png" onmouseover="replaceme(this,'<?php bloginfo( 'template_directory' ); ?>/images/tab-video_hv.png')" onmouseout="restoreme(this,'<?php bloginfo( 'template_directory' ); ?>/images/tab-video.png')" alt="Video" title="Video"/></a></li>

<li><a href="#"><img src="<?php bloginfo( 'template_directory' ); ?>/images/tab-photo.png" onmouseover="replaceme(this,'<?php bloginfo( 'template_directory' ); ?>/images/tab-photos_hv.png')" onmouseout="restoreme(this,'<?php bloginfo( 'template_directory' ); ?>/images/tab-photo.png')" alt="Photo" title="Photo"/></a></li>

<li><a href="#"><img src="<?php bloginfo( 'template_directory' ); ?>/images/tab-audio.png" onmouseover="replaceme(this,'<?php bloginfo( 'template_directory' ); ?>/images/tab-audio_hv.png')" onmouseout="restoreme(this,'<?php bloginfo( 'template_directory' ); ?>/images/tab-audio.png')" alt="Audio" title="Audio"/></a></li>
</ul>
</div><!-- end latest-stories-->


<!-- here begins the loop -->
<?php get_template_part( 'loop', 'latestStories' ); ?>




</div><!-- end maincol-->


<?php get_footer(); ?>