<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
global $post;
if (get_post_meta($post->ID, 'rangephotos', true)) {
   $rangevideos = get_post_meta($post->ID, 'rangephotos', true);
} else {
   // Range default of photos --> 710 km
   $rangephotos = 300;
}

$sitepoint = get_post_meta($post->ID, 'geoRSSPoint', true);
query_posts("posts_per_page=1000&post_type=photo_testimonials");
$postType = "";
?>
<?php /* Start the Loop */ ?>


<div class="slider-photos side-more" > 

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
            <a href="<?php the_permalink(); ?>">  <img height="60" class="site-photo" src="<?php echo $thumb  ?>" border="0">  </a>  
         </div>

      <?php } ?>
   <?php
   endwhile;
// Reset Query
   wp_reset_query();
   ?><!-- end loop-->

</div>