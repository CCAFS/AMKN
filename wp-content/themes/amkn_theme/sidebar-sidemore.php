<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
global $post;
?>
<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
query_posts("cat=297&showposts=1&post_type=video_testimonials");
$postType = "";
?>
<?php /* Start the Loop */ ?>
<script type="text/javascript">
    function switchTab(switchTo)
    {
    $(".tabselected").removeClass("tabselected");
    $("."+switchTo).addClass("tabselected");
    }
</script>
<div class="side-more">
<h3 class="sidefollow">Featured on AMKN</h3>
<ul class="side-more-list">
<li><a href="javascript:void(0)" onclick="switchTab('tabvideo_testimonials')"><img src="<?php bloginfo( 'template_directory' ); ?>/images/tab-video.png" /></a></li>
<li><a href="javascript:void(0)" onclick="switchTab('tabphoto_testimonials')"><img src="<?php bloginfo( 'template_directory' ); ?>/images/tab-photo.png" /></a></li>
<li><a href="javascript:void(0)" onclick="switchTab('tabamkn_blog_posts')"><img src="<?php bloginfo( 'template_directory' ); ?>/images/tab-post.png" /></a></li>
</ul>
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
$metaDesc = get_post_meta($post->ID, 'content_description', true);
if(strlen($metaDesc) > 65)
    $metaDesc = substr($metaDesc,0,65)."...";
?>
<div class="more-item tab<?php echo $postType; ?> tabselected">
<h2 class="teasertitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<a href="<?php the_permalink(); ?>"><img width="225" src="<?php echo $postThumb; ?>" /></a>
<p><?php echo $metaDesc; ?>
<a href="<?php the_permalink(); ?>"><span class="button-more">Read more</span></a>
</p>
<br clear="all" />
<br clear="all" />
<a href="<?php echo get_post_type_archive_link($postType); ?>"><span class="button-sidebar-more ">View All <?php echo get_post_type_object($postType)->labels->name; ?></span></a>
</div>
<?php endwhile; ?><!-- end loop-->
<?php
query_posts("cat=297&showposts=1&post_type=photo_testimonials");
$postType = "";
?>

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
$metaDesc = get_post_meta($post->ID, 'content_description', true);
if(strlen($metaDesc) > 65)
    $metaDesc = substr($metaDesc,0,65)."...";
?>
<div class="more-item tab<?php echo $postType; ?>">
<h2 class="teasertitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<a href="<?php the_permalink(); ?>"><img width="225" src="<?php echo $postThumb; ?>" /></a>
<p><?php echo $metaDesc; ?>
<a href="<?php the_permalink(); ?>"><span class="button-more">Read more</span></a>
</p>
<br clear="all" />
<br clear="all" />
<a href="<?php echo get_post_type_archive_link($postType); ?>"><span class="button-sidebar-more ">View All <?php echo get_post_type_object($postType)->labels->name; ?></span></a>
</div>
<?php endwhile; ?><!-- end loop-->
<?php
query_posts("cat=297&showposts=1&post_type=amkn_blog_posts");
$postType = "";
?>

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

        //echo "i equals 2";
        break;
}

?>
<div class="more-item tab<?php echo $postType; ?>">
<div class="teaser">
<?php
$postType = $post->post_type;
$metaDesc = get_the_excerpt();
if(strlen($metaDesc) > 200){
    $metaDesc = substr($metaDesc,0,200)." ...";
}
?>
<h2 class="teasertitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<p>
<?php echo $metaDesc; ?>
<a href="<?php the_permalink(); ?>"><span class="button-more">Read more</span></a>
</p>

</div><!-- end feat-item -->
<br clear="all" />
<br clear="all" />
<a href="<?php echo get_post_type_archive_link($postType); ?>"><span class="button-sidebar-more ">View All <?php echo get_post_type_object($postType)->labels->name; ?></span></a>
</div>
<?php endwhile; ?><!-- end loop-->
</div>