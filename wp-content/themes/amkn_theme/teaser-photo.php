<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
query_posts("cat=297&showposts=1&post_type=photo_testimonials");
$postType = "";
?>
<?php /* Start the Loop */ ?>
<div class="column">
<?php while ( have_posts() ) : the_post(); ?>
<div class="teaser">
<?php
$postType = $post->post_type;
$postThumb = "";

switch ($postType) {
    case "video_testimonials":
        $firstPostThumb = get_post_meta($post->ID, 'thumb', true);
        $postThumb = substr( $firstPostThumb,0,strrpos( $firstPostThumb,'/')+1) . "0.jpg";
        //$postThumb = str_replace( $firstPostThumb, $postThumbName, "0.jpg");
        break;
    case "photo_testimonials":
        $postThumb = get_post_meta($post->ID, 'galleryThumb', true);
        break;
    case "amkn_blog_posts":
        //$postThumb = get_the_post_thumbnail($post->ID, array(130,224) );
        $postThumb = get_post_thumbnail_id($post->ID);

        //echo "i equals 2";
        break;
}
$metaDesc = get_post_meta($post->ID, 'content_description', true);
if(strlen($metaDesc) > 75)
    $metaDesc = substr($metaDesc,0,75)."...";
?>
<img class="titleico" src="<?php bloginfo( 'template_directory' ); ?>/images/<?php echo $postType; ?>-mini.png" alt="<?php echo get_post_type_object($postType)->labels->singular_name; ?>"/> <h2 class="teasertitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<div id="photoSetTeaserShim">
   <a href="<?php the_permalink(); ?>"><img width="257" height="157" src="<?php bloginfo( 'template_directory' ); ?>/images/blank.png" alt="<?php printf( esc_attr__( 'Permalink to %s', 'AMKNToolbox' ), the_title_attribute( 'echo=0' ) ); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'AMKNToolbox' ), the_title_attribute( 'echo=0' ) ); ?>" /></a>
</div>
<div id="photoSetTeaser" onclick="document.location.href='<?php the_permalink(); ?>'">
    <?php the_content(); ?>
<p><?php echo $metaDesc; ?>
</p>
</div>
<!--    -->

<p><?php echo $metaDesc; ?></p>
</div><!-- end feat-item -->
<a href="<?php the_permalink(); ?>"><span class="button-more">Read more</span></a>
<?php endwhile; ?><!-- end loop-->




<a href="<?php echo get_post_type_archive_link($postType); ?>"><span class="button-featured ">View All <?php echo get_post_type_object($postType)->labels->name; ?></span></a>

</div>