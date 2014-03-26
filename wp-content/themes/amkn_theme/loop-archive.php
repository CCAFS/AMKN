<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
global $query_string; // required
$posts = query_posts($query_string.'&posts_per_page=8&order=ASC'); 
?>

<?php /* Start the Loop */ ?>
<?php //query_posts('posts_per_page=10'); ?>
<?php while ( have_posts() ) : the_post();
$postType = $post->post_type;
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
        <img class="videotitleico" src="<?php bloginfo( 'template_directory' ); ?>/images/<?php echo $postType; ?>-mini.png" alt="Video Testimonials"/> <h2 class="teasertitle"><a href="<?php the_permalink(); ?>"><?php echo $tTitle; ?></a></h2>

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
        //$postThumb = get_the_post_thumbnail($post->ID, array(130,224) ); 
?>

<div class="entry">
<h2 class="entrytitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<div class="entrymeta">Posted by <?php the_author(); ?> on <?php the_date(); ?><!--  | <a href="<?php comments_link(); ?>"><?php comments_number('no responses','one response','% responses'); ?></a>--><?php echo get_the_tag_list(' | ',', ',''); ?> </div>
<p><?php the_excerpt(); ?></p>
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
    $staticMapURL = "http://maps.google.com/maps/api/staticmap?center=".$geoPoint."&zoom=4&size=220x215&markers=icon:http%3A%2F%2F".$sURL."%2Fwp-content%2Fthemes%2Famkn_theme%2Fimages%2F".$post->post_type."-mini.png|".$geoPoint."&maptype=roadmap&sensor=false";
    $tEx = $post->post_excerpt;
    if(strlen($tEx) > 75){
        $tEx = substr($tEx,0,75)."...";
    }
    $args4Countries = array('fields' => 'names');
    $cgMapCountries = wp_get_object_terms($post->ID, 'cgmap-countries', $args4Countries);
?>


 
<div class="videoteaser">
<img class="videotitleico" src="<?php bloginfo( 'template_directory' ); ?>/images/<?php echo $postType; ?>-mini.png" alt="Benchmark site"/> <h2 class="teasertitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?> [<?php echo $cgMapCountries[0]; ?>]</a></h2>

<a href="<?php the_permalink(); ?>"><img src="<?php echo $staticMapURL; ?>" /></a>
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