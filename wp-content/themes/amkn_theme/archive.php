<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
get_header();
$currType=get_query_var( 'taxonomy' );

?>
<div id="container">
<div class="content">
<h2 class="title"><?php echo get_post_type_object( get_query_var( 'post_type' ) )->labels->name; ?></h2>
				<?php //rewind_posts(); ?>
        
				<?php get_template_part( 'loop', 'archive' ); ?>
         
       
</div><!-- end content -->
</div><!-- end Container -->
<?php get_footer(); ?>