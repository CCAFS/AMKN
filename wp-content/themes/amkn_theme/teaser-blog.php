<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
query_posts("showposts=1&post_type=amkn_blog_posts&order=DESC");
$postType = "";
?>
<?php /* Start the Loop */ ?>
<div class="column">
<?php while ( have_posts() ) : the_post(); ?>
<div class="teaser">
<?php
$postType = $post->post_type;
$metaDesc = get_the_excerpt();
if(strlen($metaDesc) > 150){
    $metaDesc = substr($metaDesc,0,150)."...";
}
?>
<img class="titleico" src="<?php bloginfo( 'template_directory' ); ?>/images/<?php echo $postType; ?>-mini.png" alt="<?php echo get_post_type_object($postType)->labels->singular_name; ?>"/> <h2 class="teasertitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<p><?php the_excerpt(); ?>

</p>
</div><!-- end feat-item -->
<a href="<?php the_permalink(); ?>"><span class="button-more">Read more</span></a>
<?php endwhile; ?><!-- end loop-->




</div>