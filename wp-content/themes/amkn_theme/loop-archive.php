<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
global $query_string; // required
$paged = get_query_var('paged');
if (get_query_var( 'post_type' ) == 'ccafs_sites') {
  $args = $query_string.'&posts_per_page=16&order=ASC&orderby=meta_value&meta_key=ccafs_region'; 
} else {
  $args = $query_string.'&posts_per_page=16&order=DESC&orderby=date';  
}
$posts = query_posts($args);
$tmpregion = '';
//print_r($args);echo "**";
?>

<?php /* Start the Loop */ ?>
<?php //query_posts('posts_per_page=10'); ?>
<?php while ( have_posts() ) : the_post();
$postType = $post->post_type;
$postId = $post->ID;
$postThumb = "";

?>

<div id="archive-entry">
<?php
  $region = get_post_meta($post->ID, 'ccafs_region', true);
?>
<?php if ($region != $tmpregion && $postType == 'ccafs_sites'): ?>
<br><h3><?php echo $region?></h3>
<?php $tmpregion = $region; endif;?>
<div class="videocolumn <?php echo $postType; ?>">
<?php 
switch ($postType) {
    case "video_testimonials":
        $firstPostThumb = get_post_meta($post->ID, 'thumb', true);
        $postThumb = substr( $firstPostThumb,0,strrpos( $firstPostThumb,'/')+1) . "0.jpg";
        $metaDesc = get_post_meta($post->ID, 'content_description', true);
        if(strlen($metaDesc) > 75){
         $metaDesc = substr($metaDesc,0,75)."...";
        } 
        $tTitle = $post->post_title;
        if(strlen($tTitle) > 35){
            $tTitle = substr($tTitle,0,35)."...";
        }  
?>
        <script>    
          if (typeof document.getElementById("menu-item-3842") != 'undefined')
            document.getElementById("menu-item-3842").className += ' current-menu-item';
        </script>
        <div class="videoteaser">
        <img class="videotitleico" src="<?php bloginfo( 'template_directory' ); ?>/images/<?php echo $postType; ?>-mini.png" alt="Video Testimonials"/> 
        <h2 class="teasertitle"><a href="<?php the_permalink(); ?>"><?php echo $tTitle; ?></a></h2>

        <a href="<?php the_permalink(); ?>"><img class="image"   src="<?php echo $postThumb; ?>" alt="Video Testimonials" /></a>
        <p><?php echo $metaDesc; ?></p>
        </div>
        


<?php        break;
    case "photo_testimonials":
        $postThumb = get_post_meta($post->ID, 'galleryThumb', true);
        $metaDesc = get_post_meta($post->ID, 'content_description', true);
        if(strlen($metaDesc) > 75){
         $metaDesc = substr($metaDesc,0,75)."...";
        }

        $tTitle = $post->post_title;
        if(strlen($tTitle) > 35){
            $tTitle = substr($tTitle,0,35)."...";
        } 
?>
        <script>
          if (typeof document.getElementById("menu-item-3842") != 'undefined')
            document.getElementById("menu-item-3842").className += ' current-menu-item';
        </script>
        <div class="videoteaser">
        <img class="videotitleico" src="<?php bloginfo( 'template_directory' ); ?>/images/<?php echo $postType; ?>-mini.png" alt="Video Testimonials"/> <h2 class="teasertitle"><a href="<?php the_permalink(); ?>"><?php echo $tTitle; ?></a></h2>

        <a href="<?php the_permalink(); ?>"><img class="image" src="<?php echo $postThumb; ?>" alt="Video Testimonials" /></a>
        <p><?php echo $metaDesc; ?></p>
        </div>
         


<?php
        break;
    case "amkn_blog_posts":
    $tEx = $post->post_excerpt;
    if(strlen($tEx) > 500){
        $tEx = substr($tEx,0,500)."...";
    }
    $ttitle = $post->post_title;
    if(strlen($ttitle) > 80){
        $ttitle = substr($ttitle,0,80)."...";
    }
?>
    <script>
      if (typeof document.getElementById("menu-item-3842") != 'undefined')
        document.getElementById("menu-item-3842").className += ' current-menu-item';
    </script>
    <div class="entry">
    <div class="image" style="background: url(<?php echo catch_that_image($post); ?>) center" ></div>
    <h2 class="entrytitle"><a href="<?php the_permalink(); ?>"><?php echo htmlspecialchars_decode($ttitle); ?></a></h2>
    <div class="entrymeta">Posted by <?php the_author(); ?> on <?php the_date(); ?><!--  | <a href="<?php comments_link(); ?>"><?php comments_number('no responses','one response','% responses'); ?></a>--><?php echo get_the_tag_list(' | ',', ',''); ?> </div>
    <p><?php echo $tEx; ?></p>
    <p><a href="<?php the_permalink(); ?>"><span class="button-more">Read more</span></a></p>
    </div>
<?php
    break;
    case "ccafs_sites":
        //$postThumb = get_the_post_thumbnail($post->ID, array(130,224) );
//    $region = get_post_meta($post->ID, 'ccafs_region', true);
    $geoRSSPoint = get_post_meta($post->ID, 'geoRSSPoint', true);
    $sideId = get_post_meta($post->ID, 'siteId', true);
    $blockName = get_post_meta($post->ID, 'blockName', true);
    $geoPoint = str_ireplace(" ", ",", trim($geoRSSPoint));
    $sURL = str_ireplace("http://", "", site_url());
    $sURL= "amkn.org";
    $staticMapURL = "http://maps.google.com/maps/api/staticmap?center=".$geoPoint."&zoom=4&size=70x70&markers=icon:http%3A%2F%2F".$sURL."%2Fwp-content%2Fthemes%2Famkn_theme%2Fimages%2F".$post->post_type."-mini.png|".$geoPoint."&maptype=roadmap&sensor=false";
    $tEx = $post->post_excerpt;
    if(strlen($tEx) > 75){
        $tEx = substr($tEx,0,75)."...";
    }
    $args4Countries = array('fields' => 'names');
    $cgMapCountries = wp_get_object_terms($post->ID, 'cgmap-countries', $args4Countries);
    $country = get_post_meta($post->ID, 'siteCountry', true);
    $village = get_post_meta($post->ID, 'village', true);
    $city = get_post_meta($post->ID, 'city', true);
    $showLocality = ($village) ? $village : $city;
?>

    <div class="videoteaser">
      <img class="videotitleico" src="<?php bloginfo( 'template_directory' ); ?>/images/<?php echo $postType; ?>-mini.png" alt="Benchmark site"/> 
      <h2 class="teasertitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?> [<?php echo $country; ?>]</a></h2>
      <a href="<?php the_permalink(); ?>"><img class="image" src="<?php echo $staticMapURL; ?>" /></a>
      <p>
        <?php // echo $tEx; ?>
          <span class="sidemap-labels">Site ID:</span> <?php echo $sideId; ?><br>
          <span class="sidemap-labels">Sampling Frame Name:</span> <?php echo $blockName; ?><br>
          <span class="sidemap-labels">Next town:</span> <?php echo $showLocality; ?><br>
          <span class="sidemap-labels">Geocoordinates:</span>
          <span class="geo">
             <span class="latitude"><?php echo str_ireplace(" ", "</span>; <span class='longitude'>", $geoRSSPoint); ?></span>
          </span>
      </p>         
    </div>
 
<?php
    break;    
}
?>
</div>
</div>
<?php endwhile; ?><!-- end loop-->

<br clear="all" />
<div id="amkn-paginate">
<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>
    <div class="alignleft"><?php next_posts_link('&larr; Previous Entries'); ?></div>
    <div class="alignright"><?php previous_posts_link('Next Entries &rarr;'); ?></div>
    <?php } ?>
</div>
<br clear="all">
<br clear="all">