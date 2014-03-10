<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
global $post;
    //geoRSSPoint
    $geoRSSPoint = get_post_meta($post->ID, 'geoRSSPoint', true);
    $geoPoint = str_ireplace(" ", ",", trim($geoRSSPoint));
?>
<?php wp_reset_query(); ?>
<div class="sidemap-small">
<?php
$args4Countries = array('fields' => 'names');
$cgMapCountries = wp_get_object_terms($post->ID, 'cgmap-countries', $args4Countries);
$mapCo="";
 if($cgMapCountries){
    $mapCo='<li><span class="sidemap-labels">Country:</span> '.$cgMapCountries[0].'</li>';
 }
 $village = get_post_meta($post->ID, 'village', true);
 $city = get_post_meta($post->ID, 'city', true);
 $showLocality = ($village) ? $village : $city;
 $showLocality = ($showLocality) ? $showLocality : $geoPoint;
 
    $wcURL = "/marksim-dssat-weather-file-generator/?lt=" . str_ireplace(" ", "&ln=", $geoRSSPoint) . "&pl=" . $showLocality;
?>
<script>
dojo.require("dijit.dijit"); // optimize: load dijit layer
dojo.require("dijit.form.Button");
</script>
<ul class="sidemap-list">
<?php echo $mapCo; ?>    
<li><span class="sidemap-labels">Next town:</span> <?php echo $showLocality; ?></li>
<li><span class="sidemap-labels">Geocoordinates:</span>
<span class="geo">
<span class="latitude"><?php echo str_ireplace(" ", "</span>; <span class='longitude'>", $geoRSSPoint); ?></span>
</span></li>
</ul>
<a href="javascript:void(0)" onClick="window.open('<?php echo $wcURL; ?>','marksim','width=700,height=730');">Simulate Daily Weather</a>

</div>
<br clear="all" />