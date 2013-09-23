<?php
/**
*/
require_once("../../../wp-config.php");
require_once("../../../wp-includes/wp-db.php");
require('../../../wp-blog-header.php');
require('../../../wp-includes/registration.php');
global $post;
global $wpdb;

// Update Excerpt Info

$mypostsPub2 = get_posts('numberposts=-1&post_type=ccafs_sites');
echo count($mypostsPub2) . '<br>';
foreach($mypostsPub2 as $post)
{
	$cSite = array();
	$cSite['ID'] = $post->ID;
	$cSite['post_excerpt'] = wp_trim_excerpt( strip_tags($post->post_content) );

	wp_update_post( $cSite );
}

?>