<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */

$videoURLArray = get_post_meta($post->ID, 'enclosure', false);
$geoRSSPoint = get_post_meta($post->ID, 'geoRSSPoint', true);
$geoPoint = str_ireplace(" ", ";", trim($geoRSSPoint));
$browserURL = "/#/bm=1/cntr=".$geoPoint."/lvl=8";
foreach($videoURLArray as $videoURL0)
{
    $videoURL = (strrpos($videoURL0, "/v/") === false)? $videoURL : $videoURL0;
}
$videoURL = trim(str_ireplace("\n", "", $videoURL));
$videoURL = trim(str_ireplace("\r", "", $videoURL));
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
<!--Begin Share Button-->
<?php if (function_exists('sociable_html')) {
echo sociable_html();
} ?>
<!--End Share Button-->
<?php get_sidebar( 'sidemap_embed' ); ?>
<div class="video">
<object width="614" height="390" type="application/http">
  <param name="movie" value="<?php echo $videoURL; ?>&amp;fs=1&amp;hl=en_GB&amp;rel=0&amp;hd=1" />
  <param name="allowFullScreen" value="true" />
  <param name="allowScriptAccess" value="always" />
  <embed src="<?php echo $videoURL; ?>&amp;fs=1&amp;hl=en_GB&amp;rel=0&amp;hd=1"
    type="application/x-shockwave-flash"
    allowscriptaccess="always"
    width="614" height="390"
    allowfullscreen="true" />
</object>
</div>
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

</div><!-- end content -->
<?php
    get_footer('embed');
}else{
 ?>
<script>
  if (typeof document.getElementById("menu-item-4306") != 'undefined')
    document.getElementById("menu-item-4306").className += ' current-menu-item';
</script>
<div id="container">
<div id="sidebar">
<?php get_sidebar( 'sidemap' ); ?>
<?php get_sidebar( 'sidemore' ); ?>

</div><!--end sidebar -->


<div class="content">

<h2 class="title"><?php the_title(); ?></h2>
<div class="entrymeta">Source: <em><?php echo get_bookmark( $srcID )->link_description; ?></em> <a target="_blank" href="<?php echo get_post_meta($post->ID, 'syndication_permalink', true); ?>">permalink</a></div>

<!--End Share Button-->
<div class="video">
<object width="747" height="390" type="application/http">
  <param name="movie" value="<?php echo $videoURL; ?>&amp;fs=1&amp;hl=en_GB&amp;rel=0&amp;hd=1" />
  <param name="allowFullScreen" value="true" />
  <param name="allowScriptAccess" value="always" />
  <embed src="<?php echo $videoURL; ?>&amp;fs=1&amp;hl=en_GB&amp;rel=0&amp;hd=1"
    type="application/x-shockwave-flash"
    allowscriptaccess="always"
    width="747" height="390"
    allowfullscreen="true" />
</object>
</div>

<!--Begin Share Button-->
<?php if (function_exists('sociable_html')) {
echo sociable_html();
} ?>
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

</div><!-- end content -->


</div><!-- end Container -->

<?php
get_footer();
}
?>