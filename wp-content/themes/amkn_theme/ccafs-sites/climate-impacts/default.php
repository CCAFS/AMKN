<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/custom-theme/jquery-ui-1.8.11.custom.css" type="text/css" media="all" />
<style type="text/css">
    #worldclimData>table {
        font-size: x-small;
        width: 98%;
    }
    #worldclimData>img {
        width: 98%;
    }
</style>
<script>
    $(function() {
        $("#tabs").tabs();
    });
</script>
<p>  <?php
    $siteCentroid = explode(" ", get_post_meta($post->ID, 'geoRSSPoint', true));
    $worldClimDataURL1 = "http://droppr.org/data/climate/data/5/" . $siteCentroid[1] . "/" . $siteCentroid[0] . "/rain/809";
    $worldClimDataURL2 = "http://droppr.org/data/climate/data/5/" . $siteCentroid[1] . "/" . $siteCentroid[0] . "/tmax/809";
    $worldClimDataURL3 = "http://droppr.org/data/climate/data/5/" . $siteCentroid[1] . "/" . $siteCentroid[0] . "/tmin/809";
    ?>
<h4>Current weather and 2050 predictions</h4>

<div id="tabs" class="tabs4">
    <ul>
        <li><a href="#tabs-1">Total Rainfall (mm)</a></li>
        <li><a href="#tabs-2">Max. Temp. (C)</a></li>
        <li><a href="#tabs-3">Min. Temp. (C)</a></li>
    </ul>
    <div id="tabs-1">
        <div id="worldclimData">
            <?php  echo file_get_contents($worldClimDataURL1); ?>
        </div> 
    </div>
    <div id="tabs-2">
        <div id="worldclimData">
            <?php echo file_get_contents($worldClimDataURL2); ?>
        </div>
    </div>
    <div id="tabs-3">
        <div id="worldclimData">
            <?php echo file_get_contents($worldClimDataURL3);  ?>
        </div>

    </div>
</div> 
<div class="entrymeta">
    Source: <a target="_blank" href="http://www.worldclim.org/">WorldClim database</a>
    <p>Hijmans, R.J., S.E. Cameron, J.L. Parra, P.G. Jones and A. Jarvis, 2005. Very high resolution interpolated climate surfaces for global land areas. <a target="_blank" href="http://www.worldclim.org/worldclim_IJC.pdf">International Journal of Climatology 25: 1965-1978</a></p>
</div>
<?php if ($description->source):?>
  <div class='source'><a href='<?php echo $description->source ?>' target="_blank">Source: Baseline survey, <?php echo $description->source_date?></a></div>
<?php endif;?>