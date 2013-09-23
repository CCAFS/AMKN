<?php
/**
*/
require_once("../../../wp-config.php");
require_once("../../../wp-includes/wp-db.php");
require('../../../wp-blog-header.php');
require('../../../wp-includes/registration.php');
global $post;
global $wpdb;

// Update Geo Info

$defaults = array('fields'=>'all');
$mypostsPub = get_posts('numberposts=-1&post_type=ccafs_sites');
echo count($mypostsPub) . '<br>';
foreach($mypostsPub as $post)
{
   setup_postdata($post);
   $geoPoint = get_post_meta($post->ID, 'geoRSSPoint', true);
   if($geoPoint){
   $geoPointP = str_ireplace(" ", ",", trim($geoPoint));
   getGeoData($post->ID, $geoPointP);
    echo $post->ID . '|'.$post->post_type.'<br>';
   }
}
$mypostsPub2 = get_posts('numberposts=-1&post_type=video_testimonials');
echo count($mypostsPub2) . '<br>';
foreach($mypostsPub2 as $post)
{
   setup_postdata($post);
   $geoPoint = get_post_meta($post->ID, 'geoRSSPoint', true);
   if($geoPoint){
   $geoPointP = str_ireplace(" ", ",", trim($geoPoint));
   getGeoData($post->ID, $geoPointP);
    echo $post->ID . '|'.$post->post_type.'<br>';
   }
}

$mypostsPub3 = get_posts('numberposts=-1&post_type=amkn_blog_posts');
echo count($mypostsPub3) . '<br>';
foreach($mypostsPub3 as $post)
{
   setup_postdata($post);
   $geoPoint = get_post_meta($post->ID, 'geoRSSPoint', true);
   if($geoPoint){
   $geoPointP = str_ireplace(" ", ",", trim($geoPoint));
   getGeoData($post->ID, $geoPointP);
    echo $post->ID . '|'.$post->post_type.'<br>';
   }
}

$mypostsPub4 = get_posts('numberposts=-1&post_type=photo_testimonials');
echo count($mypostsPub4) . '<br>';
foreach($mypostsPub4 as $post)
{
   setup_postdata($post);
   $geoPoint = get_post_meta($post->ID, 'geoRSSPoint', true);
   if($geoPoint){
   $geoPointP = str_ireplace(" ", ",", trim($geoPoint));
   getGeoData($post->ID, $geoPointP);
    echo $post->ID . '|'.$post->post_type.'<br>';
   }
}
?>