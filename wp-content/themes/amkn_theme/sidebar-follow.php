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
));
if(is_front_page() || is_home()){
    ?>
<div id="follow">
<h2 class="followtitle">Follow</h2>
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
<?php
}else{
    ?>
<div class="side-follow">
<h3 class="sidefollow">Follow</h3>
<ul class="side-followlist">
	<?php
        foreach($bookmarks as $bm)
	{
            ?>
<li><a target="<?php echo $bm->link_target; ?>" href="<?php echo $bm->link_url; ?>"><img alt="<?php echo $bm->link_name; ?>" src="<?php echo $bm->link_image; ?>"></a> <?php echo $bm->link_name; ?></li>
	<?php
	}
        ?>
</ul>
</div><!--end sidefollow --><?php
}
?>