<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
$embed = $_GET["embedded"];
global $post;
$post_old = $post; // Save the post object.
if (get_post_meta($post->ID, 'rangephotos', true)) {
   $rangephotos = get_post_meta($post->ID, 'rangephotos', true);
} else {
   // Range default of photos --> 710 km
   $rangephotos = 300;
}
$siteTitle = $post->post_name;
$sitepoint = get_post_meta($post->ID, 'geoRSSPoint', true);
query_posts("posts_per_page=1000&post_type=photo_testimonials&meta_key=geoRSSPoint");
$postType = "";
?>
<?php /* Start the Loop */ ?>
<div style="padding-left: 0px; margin-bottom: 0px; font-size: 12px; height: 15px;">Nearest photo sets</div>
<div class="slider-photos side-more" style="display:none;"> 
   <?php while (have_posts()) : the_post(); ?>
      <?php
      $postType = $post->post_type; 
      $photopoint = get_post_meta($post->ID, 'geoRSSPoint', true);
      
      if (distance($sitepoint, $photopoint) < $rangephotos) {
          $filename = get_post_meta($post->ID, 'galleryThumb', true);
          $extension_pos = strrpos($filename, '.'); // find position of the last dot, so where the extension starts
          $thumb = substr($filename, 0, $extension_pos) . '_q' . substr($filename, $extension_pos);
         ?>

         <div class="site-photo <?php echo distance($sitepoint, $photopoint) ?>">             
            <a href="#" data-reveal-id="<?php echo $post->ID; ?>"><img height="60" class="site-photo" src="<?php echo $thumb; ?>" border="0"></a>
         </div>

      <?php } ?>
   <?php
   endwhile;   
// Reset Query
//   wp_reset_query();
   ?><!-- end loop-->  
</div>
<?php while (have_posts()) : the_post(); ?>
    <?php
    $postType = $post->post_type; 
    $photopoint = get_post_meta($post->ID, 'geoRSSPoint', true);
    $metaDesc = get_post_meta($post->ID, 'content_description', true);
    $srcID = get_post_meta($post->ID, 'syndication_feed_id', true);
    if (strlen($metaDesc) > 250)
      $metaDesc = substr($metaDesc, 0, 250) . "...";
   
    if (distance($sitepoint, $photopoint) < $rangephotos) {
        $filename = get_post_meta($post->ID, 'galleryThumb', true);
        $extension_pos = strrpos($filename, '.'); // find position of the last dot, so where the extension starts
        $thumb = substr($filename, 0, $extension_pos) . '_q' . substr($filename, $extension_pos);
       ?>

       <div id="<?php echo $post->ID; ?>" class="reveal-modal" data-reveal style="top:100px">                       
          <div class ="metaDesc">
            <strong>
                <h2 class="teasertitle">
                    <?php if (isset($embed) && $embed == "1") :?>
                        <a>
                            <?php the_title(); ?>
                        </a>
                    <?php else: ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    <?php endif;?>                    
                </h2>
            </strong>
            <div class="entrymeta">Source: <em><?php echo get_bookmark($srcID)->link_description; ?></em> 
                <a target="_blank" href="<?php echo get_post_meta($post->ID, 'syndication_permalink', true); ?>">permalink</a>
            </div>
             
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
            <h3 class="videolabels">Distance to <?php echo ucfirst($siteTitle);?>: <span class="taxItems"><?php echo round(distance($sitepoint, $photopoint),2)." km"?></span></h3>
         </div>
         <div class="video photoset" style="max-height: 300px; overflow-y: scroll;">
              <?php the_content(); ?>
          </div>
         <div id="amkn-paginate">
          <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>
              <div class="alignleft"><?php next_posts_link('&larr; Previous Entries'); ?></div>
              <div class="alignright"><?php previous_posts_link('Next Entries &rarr;'); ?></div>
              <?php } ?>
          </div>
          <a class="close-reveal-modal">&#215;</a>
       </div>

    <?php } ?>
 <?php
 endwhile;
 $post = $post_old; // Restore the post object.
 ?>
