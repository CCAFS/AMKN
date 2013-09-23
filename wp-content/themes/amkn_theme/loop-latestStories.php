<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
query_posts("showposts=3&post_type=any");
query_posts( array( 'post_type' => array( 'video_testimonials', 'amkn_blog_posts', 'photo_testimonials' ), 'showposts' => 3 ) );
?>
<?php /* Start the Loop */ ?>
<div class="loop">
<?php while ( have_posts() ) : the_post(); ?>

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

?>
<div class="post">
    <div id="symbol-<?php echo $postType; ?>"></div>
<a href="<?php the_permalink(); ?>">
<?php
switch ($postType) {
    case "video_testimonials":
        ?>
            <img class="loop-img" src="<?php echo $postThumb; ?>" alt="<?php printf( esc_attr__( 'Permalink to %s', 'AMKNToolbox' ), the_title_attribute( 'echo=0' ) ); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'AMKNToolbox' ), the_title_attribute( 'echo=0' ) ); ?>" />
        <?php
        break;
    case "photo_testimonials":
        ?>
            <img class="loop-img" src="<?php echo $postThumb; ?>" alt="<?php printf( esc_attr__( 'Permalink to %s', 'AMKNToolbox' ), the_title_attribute( 'echo=0' ) ); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'AMKNToolbox' ), the_title_attribute( 'echo=0' ) ); ?>" />
        <?php
        break;
    case "amkn_blog_posts":
        $thumb_attr = array(

                'class'	=> "loop-img",
                'alt'	=> trim(strip_tags( $attachment->post_excerpt )),
                'title'	=> trim(strip_tags( $attachment->post_title ))
        );
        ?>
            <?php echo get_the_post_thumbnail( $post->ID, array(224,130), $thumb_attr ); ?>

        <?php
        break;
}
?>
</a>
<h2 class="loop-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'AMKNToolbox' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a></h2>
<!--<div class="shadow"></div>-->
<span class="meta">From <a href="#"><?php the_author(); ?></a></span>

</div><!-- end post--><!-- #post-<?php the_ID(); ?> -->








<?php endwhile; ?>
</div><!-- end loop-->
