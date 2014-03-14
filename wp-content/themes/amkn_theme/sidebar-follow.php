<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
global $post;
?>
<?php wp_reset_query(); ?>
<?php
$bookmarks = get_bookmarks( array(
    'orderby'        => 'name',
    'order'          => 'DESC',
    'category_name'  => 'follow'
));?>
<div id="follow">

<ul class="followlist">
    	<?php
        foreach($bookmarks as $bm)
	{
         ?>
<li><a target="<?php echo $bm->link_target; ?>" href="<?php echo $bm->link_url; ?>"><img alt="<?php echo $bm->link_name; ?>" src="<?php echo $bm->link_image; ?>" /> <?php echo $bm->link_name; ?></a></li>
	<?php
	}
        ?>
</ul>
</div>
