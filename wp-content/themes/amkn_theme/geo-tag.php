<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
?>
<?php /* Start the Loop */ ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php
$geoRSSPoint0 = get_post_meta($post->ID, 'geoRSSPoint', true);
$geoPoint0 = str_ireplace(" ", ";", trim($geoRSSPoint0));
$geoPoint1 = str_ireplace(" ", ", ", trim($geoRSSPoint0));
if($geoRSSPoint0){
?>
<meta name="geo.position" content="<?php echo $geoPoint0; ?>" />
<meta name="ICBM" content="<?php echo $geoPoint1; ?>" />
<?php
}
?>
<?php endwhile; ?><!-- end loop-->