<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
$embed = $_GET["embedded"];
global $post;
?>
<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
if (get_post_meta($post->ID, 'rangevideos', true)) {
  $rangevideos = get_post_meta($post->ID, 'rangevideos', true);
} else {
  // Range default of videos --> 710 km
  $rangevideos = 710;
}


$sitepoint = get_post_meta($post->ID, 'geoRSSPoint', true);
$siteTitle = $post->post_name;
$args = array(
  'post_type' => 'video_testimonials',
  'posts_per_page' => '-1',
  'order' => 'ASC',
  'meta_query' => array(array('key' => 'nearestBenchmarkSite', 'value' => $post->ID))
);
//$args = "posts_per_page=-1&post_type=video_testimonials&meta_key=geoRSSPoint";
query_posts($args);
$postType = "";
$totalVideos = 0;
?>
<?php /* Start the Loop */ ?>

<h2 style="padding-left: 10px; margin-bottom: 0px; margin-top: 10px;">Nearest videos</h2>
<div class="slider-video side-more borde1" style="display:none"> 

  <?php while (have_posts()) : the_post(); ?>
    <?php
    $postType = $post->post_type;
    $postThumb = "";
    $videopoint = get_post_meta($post->ID, 'geoRSSPoint', true);
    $firstPostThumb = get_post_meta($post->ID, 'thumb', true);
    $postThumb = substr($firstPostThumb, 0, strrpos($firstPostThumb, '/') + 1) . "0.jpg";
    $videoURLArray = get_post_meta($post->ID, 'enclosure', false);
    foreach ($videoURLArray as $videoURL0) {
      $videoURL = (strrpos($videoURL0, "/v/") === false) ? $videoURL : $videoURL0;
    }
    $videoURL = trim(str_ireplace("\n", "", $videoURL));
    $videoURL = trim(str_ireplace("\r", "", $videoURL));

    $metaDesc = get_post_meta($post->ID, 'content_description', true);
    if (strlen($metaDesc) > 150)
      $metaDesc = trim_text($metaDesc, 150);

    $title = get_the_title();
    if (strlen($title) > 65)
      $title = trim_text($title, 60);

//    if (distance($sitepoint, $videopoint) < $rangevideos) :
    $totalVideos++;
    ?>

    <div class="site-video <?php echo distance($sitepoint, $videopoint) ?>">

      <h2 class="teasertitle">
        <a href="<?php
        if (isset($embed) && $embed == "1")
          echo "#";
        else
          the_permalink();
        ?>" <?php if (isset($embed) && $embed == "1") echo "data-reveal-id='" . $post->ID . "'" ?>>
  <?php echo $title; ?>
        </a>
      </h2>
      <a href="<?php the_permalink(); ?>"></a> 

      <a href="#" data-reveal-id="<?php echo $post->ID; ?>"><img style="float:left" width="210" height="120" src="<?php echo $postThumb; ?>" border="0"></a>

      <p style="float:right;width: 188px;padding-right: 20px;"><?php echo $metaDesc; ?><br>
        <a href="<?php
        if (isset($embed) && $embed == "1")
          echo "#";
        else
          the_permalink();
        ?>" <?php if (isset($embed) && $embed == "1") echo "data-reveal-id='" . $post->ID . "'" ?>>
          <span class="button-more" style="width:40px">
            Read more
          </span>
        </a>
      </p>
      <br clear="all" />
      <br clear="all" /> 

    </div>


  <?php // endif;  ?>
<?php endwhile; ?><!-- end loop-->


</div>

<?php while (have_posts()) : the_post(); ?>
  <?php
  $srcID = get_post_meta($post->ID, 'syndication_feed_id', true);
  $videopoint = get_post_meta($post->ID, 'geoRSSPoint', true);
  $videoURLArray = get_post_meta($post->ID, 'enclosure', false);
  foreach ($videoURLArray as $videoURL0) {
    $videoURL = (strrpos($videoURL0, "/v/") === false) ? $videoURL : $videoURL0;
  }
  $videoURL = trim(str_ireplace("\n", "", $videoURL));
  $videoURL = trim(str_ireplace("\r", "", $videoURL));
  $metaDesc = get_post_meta($post->ID, 'content_description', true);
  if (strlen($metaDesc) > 250)
    $metaDesc = trim_text($metaDesc, 250);


//  if (distance($sitepoint, $videopoint) < $rangevideos) {
  ?>
  <div id="<?php echo $post->ID; ?>" class="reveal-modal"> 
    <object width="560" height="315">
      <param name="movie" value="<?php echo $videoURL; ?>?rel=0;showinfo=0;controls=0" frameborder="0" allowfullscreen></param>
      <param name="allowFullScreen" value="true"></param>
      <param name="allowscriptaccess" value="always"></param>
      <embed src="<?php echo $videoURL; ?>" type="application/x-shockwave-flash" width="560" height="315" allowscriptaccess="always" allowfullscreen="true"></embed>
    </object>
    <div class ="metaDesc">
      <strong>
        <h2 class="teasertitle">
            <?php if (isset($embed) && $embed == "1") : ?>
            <a>
            <?php the_title(); ?>
            </a>
            <?php else: ?>
            <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
            </a>
  <?php endif; ?>  
        </h2>
      </strong>
      <div class="entrymeta">Source: <em><?php echo get_bookmark($srcID)->link_description; ?></em> <a target="_blank" href="<?php echo get_post_meta($post->ID, 'syndication_permalink', true); ?>">permalink</a></div>

      <p><?php echo $metaDesc; ?></p>

      <?php
      $args2 = array(
        'public' => true,
        '_builtin' => false
      );
      $excludeTaxonomies = array("cgmap-countries", "farming_systems");
      $output = 'objects'; // or names
      $operator = 'and'; // 'and' or 'or'
      $taxonomies = get_taxonomies($args2, $output, $operator);
      if ($taxonomies) {
        asort($taxonomies);
        foreach ($taxonomies as $taxonomy) {
          $getArgs = array(
            'orderby' => 'name'
          );
          $terms = wp_get_object_terms($post->ID, $taxonomy->name);
          $count = count($terms);
          if ($count > 0 && (!in_array($taxonomy->name, $excludeTaxonomies))) {
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
      <h3 class="videolabels">Distance to <?php echo ucfirst($siteTitle); ?>: <span class="taxItems"><?php echo round(distance($sitepoint, $videopoint), 2) . " km" ?></span></h3>
    </div>

    <a class="close-reveal-modal">&#215;</a>
  </div>

  <?php // } ?>
<?php endwhile; ?><!-- end loop-->
<?php if ($totalVideos == 0): ?>
  <script>
    $('#column2-video').hide();
  </script>
<?php elseif ($totalVideos == 1): ?>
  <script>
    jQuery(document).ready(function($) {
      $('.slider-video').bxSlider({
        slideWidth: 450,
        minSlides: 1,
        maxSlides: 1,
        slideMargin: 10,
        controls: false,
        pager: true,
        auto: false
      });
    });
  </script>
<?php else: ?>
  <script>
    jQuery(document).ready(function($) {
      $('.slider-video').bxSlider({
        slideWidth: 450,
        minSlides: 1,
        maxSlides: 1,
        slideMargin: 10,
        controls: false,
        pager: true,
        auto: true,
        useCSS: false
      });
    });
  </script>
<?php endif; ?>

