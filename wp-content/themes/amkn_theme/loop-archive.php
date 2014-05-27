<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
global $query_string; // required
$metaKey = array();
if($_GET['initDate'] != '') {
  $metaKey[] = array('key' => 'startDate','value' => date_format_wp($_GET['initDate']), 'compare' => '>=');
}
if($_GET['endDate'] != '') {
  $metaKey[] = array('key' => 'endDate','value' => date_format_wp($_GET['endDate']), 'compare' => '<=');
}
if($_GET['leader'] != '0' && $_GET['leader'] != '') {
  $metaKey[] = array('key' => 'leaderAcronym','value' => $_GET['leader']);
}
if($_GET['theme'] != '0' && $_GET['theme'] != '') {
  $metaKey[] = array('key' => 'theme','value' => $_GET['theme']);
}
$paged = get_query_var('paged');
if(count($metaKey)) {
  $args = array_merge(array('meta_query' => $metaKey), array('posts_per_page' => '8', 'order'=>'DESC', 'paged'=>$paged)); 
} else {
  $args = $query_string.'&posts_per_page=16&order=ASC&orderby=title';  
}
//echo "**".count($total->found_posts)."**";
$posts = query_posts($args);
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

    <div class="entry">
    <div class="image" style="background: url(<?php echo catch_that_image($post); ?>) center" ></div>
    <h2 class="entrytitle"><a href="<?php the_permalink(); ?>"><?php echo $ttitle; ?></a></h2>
    <div class="entrymeta">Posted by <?php the_author(); ?> on <?php the_date(); ?><!--  | <a href="<?php comments_link(); ?>"><?php comments_number('no responses','one response','% responses'); ?></a>--><?php echo get_the_tag_list(' | ',', ',''); ?> </div>
    <p><?php echo $tEx; ?></p>
    <p><a href="<?php the_permalink(); ?>"><span class="button-more">Read more</span></a></p>
    </div>
<?php
    break;
    case "ccafs_sites":
        //$postThumb = get_the_post_thumbnail($post->ID, array(130,224) );

    $geoRSSPoint = get_post_meta($post->ID, 'geoRSSPoint', true);
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
    $village = get_post_meta($post->ID, 'village', true);
    $city = get_post_meta($post->ID, 'city', true);
    $showLocality = ($village) ? $village : $city;
?>

    <div class="videoteaser">
    <img class="videotitleico" src="<?php bloginfo( 'template_directory' ); ?>/images/<?php echo $postType; ?>-mini.png" alt="Benchmark site"/> 
    <h2 class="teasertitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?> [<?php echo $cgMapCountries[0]; ?>]</a></h2>
    <a href="<?php the_permalink(); ?>"><img class="image" src="<?php echo $staticMapURL; ?>" /></a>
    <p>
      <?php echo $tEx; ?><br>
        <span class="sidemap-labels">Next town:</span> <?php echo $showLocality; ?><br>
        <span class="sidemap-labels">Geocoordinates:</span>
        <span class="geo">
           <span class="latitude"><?php echo str_ireplace(" ", "</span>; <span class='longitude'>", $geoRSSPoint); ?></span>
        </span>
    </p>    
     
    </div>
 
<?php
    break;
    case "ccafs_activities":
    $geoRSSPoint = get_post_meta($post->ID, 'geoRSSPoint', true);
    $geoPoint = str_ireplace(" ", ",", trim($geoRSSPoint));
    $sURL = str_ireplace("http://", "", site_url());
    $sURL= "amkn.org";
    $staticMapURL = "http://maps.google.com/maps/api/staticmap?center=".$geoPoint."&zoom=2&size=70x70&markers=icon:http%3A%2F%2F".$sURL."%2Fwp-content%2Fthemes%2Famkn_theme%2Fimages%2F".$post->post_type."-mini.png|".$geoPoint."&maptype=roadmap&sensor=false";
    $tEx = $post->post_excerpt;
    if(strlen($tEx) > 150){
        $tEx = substr($tEx,0,150)."...";
    }
    $tactivity = $post->post_title;
    if(strlen($tactivity) > 60){
        $tactivity = substr($tactivity,0,60)."...";
    }

    $args4Countries = array('fields' => 'names');
    $cgMapCountries = wp_get_object_terms($post->ID, 'cgmap-countries', $args4Countries);
?>

    <div class="videoteaser">
    <img class="videotitleico" src="<?php bloginfo( 'template_directory' ); ?>/images/<?php echo $postType; ?>-mini.png" alt="Benchmark site"/> 
    <h2 class="teasertitle"><a href="<?php the_permalink(); ?>"><?php echo $tactivity; ?></a></h2>
    <a href="<?php the_permalink(); ?>"><img class="image" src="<?php echo $staticMapURL; ?>" /></a>
    <p><?php echo $tEx; ?></p>
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