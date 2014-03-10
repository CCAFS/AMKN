<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
$metaDesc = get_post_meta($post->ID, 'content_description', true);

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
<!--Begin Share Button-->
<?php if (function_exists('sociable_html')) {
echo sociable_html();
} ?>
<!--End Share Button-->
<?php get_sidebar( 'sidemap_embed' ); ?>
<div class="video blog-post">
    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <link rel="stylesheet" href="<?php bloginfo( 'template_directory' ); ?>/custom-theme/jquery-ui-1.8.11.custom.css" type="text/css" media="all" />
<style type="text/css">
    #worldclimData>table {
          font-size: x-small;
    width: 98%;
}
    #worldclimData>img {
    width: 98%;
}
</style>
<script>
$(function() {
        $( "#tabs" ).tabs();
});
</script>
<p>
    <?php the_content(); ?>
<?php
$siteCentroid = explode(" ",get_post_meta($post->ID, 'geoRSSPoint', true));
$worldClimDataURL1 = "http://droppr.org/data/climate/data/5/" . $siteCentroid[1] . "/" . $siteCentroid[0] . "/rain/809";
$worldClimDataURL2 = "http://droppr.org/data/climate/data/5/" . $siteCentroid[1] . "/" . $siteCentroid[0] . "/tmax/809";
$worldClimDataURL3 = "http://droppr.org/data/climate/data/5/" . $siteCentroid[1] . "/" . $siteCentroid[0] . "/tmin/809";
?>
<h3>Current weather and 2050 predictions</h3>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Total Rainfall (mm)</a></li>
		<li><a href="#tabs-2">Max. Temp. (C)</a></li>
		<li><a href="#tabs-3">Min. Temp. (C)</a></li>
	</ul>
	<div id="tabs-1">
            <div id="worldclimData">
    <?php
echo file_get_contents($worldClimDataURL1);
?>
            </div>

	</div>
	<div id="tabs-2">
            <div id="worldclimData">
    <?php
echo file_get_contents($worldClimDataURL2);
?>
            </div>
	</div>
	<div id="tabs-3">
            <div id="worldclimData">
    <?php
echo file_get_contents($worldClimDataURL3);
?>
            </div>

        </div>
</div>
<div class="entrymeta">
    Source: <a target="_blank" href="http://www.worldclim.org/">WorldClim database</a>
    <p>Hijmans, R.J., S.E. Cameron, J.L. Parra, P.G. Jones and A. Jarvis, 2005. Very high resolution interpolated climate surfaces for global land areas. <a target="_blank" href="http://www.worldclim.org/worldclim_IJC.pdf">International Journal of Climatology 25: 1965-1978</a></p>
</div>

            </p>
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
    <ul class="sidelinks">
    <li><a href="/about/benchmark-sites/">About sites</a></li>
    </ul>
<?php get_sidebar( 'sidemore' ); ?>

<?php get_sidebar( 'follow' ); ?>
</div><!--end sidebar -->
<div class="content">
<h2 class="title"><?php the_title(); ?></h2>
<!--Begin Share Button-->
<?php if (function_exists('sociable_html')) {
echo sociable_html();
} ?>
<!--End Share Button-->
<div class="video blog-post">
    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <link rel="stylesheet" href="<?php bloginfo( 'template_directory' ); ?>/custom-theme/jquery-ui-1.8.11.custom.css" type="text/css" media="all" />
<style type="text/css">
    #worldclimData>table {
          font-size: x-small;
    width: 98%;
}
    #worldclimData>img {
    width: 98%;
}
</style>
<script>
$(function() {
        $( "#tabs" ).tabs();
});
</script>
<p>
    <?php the_content(); ?>
<?php
$siteCentroid = explode(" ",get_post_meta($post->ID, 'geoRSSPoint', true));
$worldClimDataURL1 = "http://droppr.org/data/climate/data/5/" . $siteCentroid[1] . "/" . $siteCentroid[0] . "/rain/809";
$worldClimDataURL2 = "http://droppr.org/data/climate/data/5/" . $siteCentroid[1] . "/" . $siteCentroid[0] . "/tmax/809";
$worldClimDataURL3 = "http://droppr.org/data/climate/data/5/" . $siteCentroid[1] . "/" . $siteCentroid[0] . "/tmin/809";
?>
<h3>Current weather and 2050 predictions</h3>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Total Rainfall (mm)</a></li>
		<li><a href="#tabs-2">Max. Temp. (C)</a></li>
		<li><a href="#tabs-3">Min. Temp. (C)</a></li>
	</ul>
	<div id="tabs-1">
            <div id="worldclimData">
<?php
echo file_get_contents($worldClimDataURL1);
?>
            </div>

	</div>
	<div id="tabs-2">
            <div id="worldclimData">
    <?php
echo file_get_contents($worldClimDataURL2);
?>
            </div>
	</div>
	<div id="tabs-3">
            <div id="worldclimData">
    <?php
echo file_get_contents($worldClimDataURL3);
?>
            </div>

        </div>
</div>

            </p>
<div class="entrymeta">
    Source: <a target="_blank" href="http://www.worldclim.org/">WorldClim database</a>
    <p>Hijmans, R.J., S.E. Cameron, J.L. Parra, P.G. Jones and A. Jarvis, 2005. Very high resolution interpolated climate surfaces for global land areas. <a target="_blank" href="http://www.worldclim.org/worldclim_IJC.pdf">International Journal of Climatology 25: 1965-1978</a></p>
</div>
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


</div><!-- end Container -->

<?php
get_footer();
}
?>