<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
get_header();
?>
<div id="container">
<div id="sidebar">
<ul class="sidelinks">
<?php
	$aboutPages = get_pages('child_of=5&sort_column=post_title');
        $currStyle = $post->ID == 5 ? "sidecurrent" : "";
	?>
    <li><a class="<?php echo $currStyle; ?>" href="<?php echo get_page_link(5) ?>">About AMKN</a></li>
	<?php
	foreach($aboutPages as $pageA)
	{
	$currPStyle = $post->ID == $pageA->ID ? "sidecurrent" : "";
            ?>
    <li><a class="<?php echo $currPStyle; ?>" href="<?php echo get_page_link($pageA->ID) ?>"><?php echo $pageA->post_title ?></a></li>
	<?php
	}
?>
</ul>

<a href="/"><span class="button-sidebar ">Browse the map</span></a>

<?php get_sidebar( 'follow' ); ?>
</div><!--end sidebar -->


<div class="content">
<h2 class="title"><?php the_title(); ?></h2>
<p>The page you requested cannot be found</p>
<p><a href="/search">Search</a> the site?</p>
</div><!-- end content -->
</div><!-- end Container -->
<?php get_footer(); ?>