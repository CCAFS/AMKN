<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
global $post;
    //geoRSSPoint
    $geoRSSPoint = get_post_meta($post->ID, 'geoRSSPoint', true);
    $geoPoint = str_ireplace(" ", ",", trim($geoRSSPoint));
    $sURL = str_ireplace("http://", "", site_url());
    $staticMapURL = "http://maps.google.com/maps/api/staticmap?center=".$geoPoint."&amp;zoom=4&amp;size=205x205&amp;markers=icon:http%3A%2F%2F".$sURL."%2Fwp-content%2Fthemes%2Famkn_theme%2Fimages%2F".$post->post_type."-mini.png|".$geoPoint."&amp;maptype=roadmap&amp;sensor=false";
?>
<?php wp_reset_query(); ?>
<div class="sidemap">
<img width="205" height="205" src="<?php echo $staticMapURL; ?>" />
<ul class="sidemap-list">
<?php
$args4Countries = array('fields' => 'names');
$cgMapCountries = wp_get_object_terms($post->ID, 'cgmap-countries', $args4Countries);
 if($cgMapCountries){
    echo '<li><span class="sidemap-labels">Country:</span> '.$cgMapCountries[0].'</li>';
 }
 $village = get_post_meta($post->ID, 'village', true);
 $city = get_post_meta($post->ID, 'city', true);
 $showLocality = ($village) ? $village : $city;
 $nearestBMSiteID = get_post_meta($post->ID, 'nearestBenchmarkSite', true);
 $nearestBMSitePermalink = get_permalink( $nearestBMSiteID );
$browserURL = "/#/bm=1/cntr=".str_ireplace(" ", ";", trim($geoRSSPoint))."/lvl=8";
 $showLocality2 = ($showLocality) ? $showLocality : $geoPoint;
    $wcURL = "/marksim-dssat-weather-file-generator/?lt=" . str_ireplace(" ", "&ln=", $geoRSSPoint) . "&pl=" . $showLocality2;
?>
<li><span class="sidemap-labels">Next town:</span> <?php echo $showLocality; ?></li>
<li><span class="sidemap-labels">Geocoordinates:</span>
<span class="geo">
<span class="latitude"><?php echo str_ireplace(" ", "</span>; <span class='longitude'>", $geoRSSPoint); ?></span>
</span>
</li>
<?php
 if($post->post_type != "ccafs_sites"){
?>
<li><span class="sidemap-labels">Nearest site:</span> <a href="<?php echo $nearestBMSitePermalink; ?>"><?php echo get_the_title($nearestBMSiteID) ?></a></li>
 <?php
 }
?>
<li><span class="sidemap-labels">&nbsp;</span></li>
<li><span class="sidemap-labels"><a href="javascript:void(0)" onClick="window.open('<?php echo $wcURL; ?>','marksim','width=700,height=730');">Simulate Daily Weather</a></span></li>
<li><span class="sidemap-labels"><a href="<?php echo $browserURL; ?>">Locate on the map</a></span></li>
</ul>
</div>