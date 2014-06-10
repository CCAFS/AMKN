<?php
$bmsId = get_post_meta($post->ID, 'siteId', true);
$tableId = "bs_pdi";
$description = $wpdb->get_row("SELECT * FROM bs_descriptions WHERE bms_id='" . $bmsId . "' AND table_id='" . $tableId . "'");
$urlJson = get_bloginfo('template_url') . "/ccafs-sites/json.php?table=" . $tableId . "&bmsid=" . $bmsId;

$tableId2 = "bs_sdi";
$description2 = $wpdb->get_row("SELECT * FROM bs_descriptions WHERE bms_id='" . $bmsId . "' AND table_id='" . $tableId2 . "'");
$urlJson2 = get_bloginfo('template_url') . "/ccafs-sites/json.php?table=" . $tableId2 . "&bmsid=" . $bmsId;
?>
<h4>Production and commercialization diversification indices</h4> 

<div style="float: left;width: 48%;">
    <div id="container-chart1" style="float: left;width: 95%; height: 250px; margin: 0 auto"></div>    
    <div id="container-description" style="float: left;width: 80%;">
        <?php echo $description->description ?> 
    </div>
</div>

<div style="float: right;width: 52%;">
    <div id="container-chart2" style="float: left;width: 95%; height: 250px; margin: 0 auto"></div>
    <div id="container-description" style="float: left;width: 80%;">
        <?php echo $description->description ?> 
    </div>
</div>

<div id="url-site" style="visibility: hidden;"><?php echo $urlJson ?></div>
<div id="url-site2" style="visibility: hidden;"><?php echo $urlJson2 ?></div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="<?php echo get_bloginfo('template_url'); ?>/ccafs-sites/food-livelihood/js/diversification.js"></script>
<script src="<?php echo get_bloginfo('template_url'); ?>/ccafs-sites/libs/highcharts-3.0.5/highcharts.js"></script>
<script src="<?php echo get_bloginfo('template_url'); ?>/ccafs-sites/libs/highcharts-3.0.5/modules/exporting.js"></script>
<?php if ($description->source):?>
  <div class='source'><a href='<?php echo $description->source ?>' target="_blank">Source: Baseline survey, <?php echo $description->source_date?></a></div>
<?php endif;?>
