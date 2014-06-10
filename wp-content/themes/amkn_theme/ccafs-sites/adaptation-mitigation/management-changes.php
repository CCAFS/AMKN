<?php
$bmsId = get_post_meta($post->ID, 'siteId', true);
$tableId = "bs_mgmt_changes";
$description = $wpdb->get_row("SELECT * FROM bs_descriptions WHERE bms_id='" . $bmsId . "' AND table_id='" . $tableId . "'");
$urlJson = get_bloginfo('template_url') . "/ccafs-sites/json.php?table=" . $tableId . "&bmsid=" . $bmsId;
?>
<div id="url-site" style="visibility: hidden;"><?php echo $urlJson ?></div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="<?php echo get_bloginfo('template_url'); ?>/ccafs-sites/adaptation-mitigation/js/management-changes.js"></script>
<script src="<?php echo get_bloginfo('template_url'); ?>/ccafs-sites/libs/highcharts-3.0.5/highcharts.js"></script>
<script src="<?php echo get_bloginfo('template_url'); ?>/ccafs-sites/libs/highcharts-3.0.5/modules/exporting.js"></script>


<h4>Management changes made by 50% or more of households in the last 10 years</h4>
<div id="container-chart" style="float: left;width: 100%;">
   
</div>
<?php if ($description->source):?>
  <div class='source'><a href='<?php echo $description->source ?>' target="_blank">Source: Baseline survey, <?php echo $description->source_date?></a></div>
<?php endif;?>
