<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
get_header();
$currType=get_query_var( 'taxonomy' );

?>
<div id="container">


<div id="sidebar">
<ul class="sidelinks">
<?php
$args1=array(
  'public'   => true,
  '_builtin' => false
);
$excludeTypes = array("flickr_photos", "biodiv_cases");
$output = 'objects'; // names or objects
$operator = 'and'; // 'and' or 'or'
$post_types=get_post_types($args1,$output,$operator);
asort($post_types);
  foreach ($post_types  as $post_type ) {
    if(!in_array($post_type->name, $excludeTypes)){
	$currPStyle = get_query_var( 'post_type' ) == $post_type->name ? "sidecurrent" : "";
            ?>
    <li><a class="<?php echo $currPStyle; ?>" href="<?php echo get_post_type_archive_link($post_type->name); ?>"><?php echo $post_type->label; ?></a></li>
	<?php
      }
  }
  ?>
</ul>

<a href="/"><span class="button-sidebar ">Browse the map</span></a>

<?php get_sidebar( 'follow' ); ?>
</div><!--end sidebar -->



<div class="content">
<h2 class="title"><?php echo get_post_type_object( get_query_var( 'post_type' ) )->labels->name; ?></h2>
				<?php rewind_posts(); ?>

				<?php get_template_part( 'loop', 'archive' ); ?>
</div><!-- end content -->
</div><!-- end Container -->
<?php get_footer(); ?>