<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
get_header();
?>
<div id="container">






<div class="content">
<h2 class="title"><?php the_title(); ?></h2>
<!--Begin Share Button-->
<?php if (function_exists('sociable_html')) {
echo sociable_html();
} ?>
<!--End Share Button-->
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <?php the_content(); ?>
<?php endwhile; // end of the loop. ?>
</div><!-- end content -->
</div><!-- end Container -->
<?php get_footer(); ?>