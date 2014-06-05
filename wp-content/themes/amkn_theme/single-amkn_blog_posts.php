<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
$metaDesc = get_post_meta($post->ID, 'content_description', true);
$srcID = get_post_meta($post->ID, 'syndication_feed_id', true);

if(isset($_GET["embed"]) && $_GET["embed"] == "true")
{
        get_header('embed');
}else{
    get_header();
}

if(isset($_GET["embed"]) && $_GET["embed"] == "true")
{
?>
<div class="content">
<a class="msGenButton" target="_blank" href="<?php the_permalink(); ?>">Open in new window</a>
<h2 class="title"><?php the_title(); ?></h2>
<div class="entrymeta">Source: <em><?php echo get_bookmark( $srcID )->link_description; ?></em> <a target="_blank" href="<?php echo get_post_meta($post->ID, 'syndication_permalink', true); ?>">permalink</a></div>
<div class="entrymeta">Posted by <?php the_author(); ?> on <?php the_date(); ?><!--  | <a href="<?php comments_link(); ?>"><?php comments_number('no responses','one response','% responses'); ?></a>--><?php echo get_the_tag_list(' | ',', ',''); ?> </div>
<!--Begin Share Button-->
<?php if (function_exists('sociable_html')) {
echo sociable_html();
} ?>
<!--End Share Button-->

<?php get_sidebar( 'sidemap_embed' ); ?>

<div class="video blog-post">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <?php the_excerpt(); ?>
<p>
<a target="_top" href="<?php the_permalink(); ?>"><span class="button-more">Read more</span></a>
</p>   
<br clear="all" />
<?php endwhile; // end of the loop. ?>
<h3>Themes</h3>
<p><?php echo $metaDesc; ?></p>
<?php
$args2=array(
  'public'   => true,
  '_builtin' => false
);
$excludeTaxonomies = array("cgmap-countries", "farming_systems");
$output = 'objects'; // or names
$operator = 'and'; // 'and' or 'or'
$taxonomies=get_taxonomies($args2,$output,$operator);
if  ($taxonomies) {
    asort($taxonomies);
  foreach ($taxonomies  as $taxonomy ) {
$getArgs=array(
'orderby'   => 'name'
);
        $terms = wp_get_object_terms($post->ID, $taxonomy->name);
        $count = count($terms);
         if($count > 0 && (!in_array($taxonomy->name, $excludeTaxonomies))){
            echo '<h3 class="videolabels">' . $taxonomy->label . ': <span class="taxItems">';
        unset($termNames);
             foreach ($terms as $term) {
                $termNames[] = $term->name;
             }
            echo join(", ", $termNames) . '</span></h3>';
         }
  }
}
?>
</div>
</div><!-- end content -->
</div>
<?php
    get_footer('embed');
}else{
?>

<div id="container">
<div id="sidebar">
<?php get_sidebar( 'sidemap' ); ?>
<?php get_sidebar( 'sidemore' ); ?>



</div><!--end sidebar -->
<div class="content">
<h2 class="title"><?php the_title(); ?></h2>
<div class="entrymeta">Source: <em><?php echo get_bookmark( $srcID )->link_description; ?></em> <a target="_blank" href="<?php echo get_post_meta($post->ID, 'syndication_permalink', true); ?>">permalink</a></div>
<div class="entrymeta">Posted by <?php the_author(); ?> on <?php the_date(); ?><!--  | <a href="<?php comments_link(); ?>"><?php comments_number('no responses','one response','% responses'); ?></a>--><?php echo get_the_tag_list(' | ',', ',''); ?> </div>
<div class="video blog-post">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <?php the_content(); ?>
<?php endwhile; // end of the loop. ?>
<?php if ($metaDesc != ''): ?>
  <h3>Themes</h3>
  <p><?php echo $metaDesc; ?></p>
<?php endif; ?>
<?php
$args2=array(
  'public'   => true,
  '_builtin' => false
);
$excludeTaxonomies = array("cgmap-countries", "farming_systems");
$output = 'objects'; // or names
$operator = 'and'; // 'and' or 'or'
$taxonomies=get_taxonomies($args2,$output,$operator);
if  ($taxonomies) {
    asort($taxonomies);
  foreach ($taxonomies  as $taxonomy ) {
$getArgs=array(
'orderby'   => 'name'
);
        $terms = wp_get_object_terms($post->ID, $taxonomy->name);
        $count = count($terms);
         if($count > 0 && (!in_array($taxonomy->name, $excludeTaxonomies))){
            echo '<h3 class="videolabels">' . $taxonomy->label . ': <span class="taxItems">';
        unset($termNames);
             foreach ($terms as $term) {
                $termNames[] = $term->name;
             }
            echo join(", ", $termNames) . '</span></h3>';
         }
  }
}
?>   
</div>
<?php 
  if (function_exists('sociable_html')) {
    echo sociable_html();
  }
?>
</div><!-- end content -->


</div><!-- end Container -->
<script>
  if (typeof document.getElementById("menu-item-4306") != 'undefined')
    document.getElementById("menu-item-4306").className += ' current-menu-item';
</script>
<?php
get_footer();
}
?>