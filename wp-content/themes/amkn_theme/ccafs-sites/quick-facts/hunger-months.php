<?php
$bmsId = get_post_meta($post->ID, 'siteId', true);
$tableId = "bs_hunger_mos";
$description = $wpdb->get_row("SELECT * FROM bs_descriptions WHERE bms_id='" . $bmsId . "' AND table_id='" . $tableId . "'");
$urlJson = get_bloginfo('template_url') . "/ccafs-sites/json.php?table=" . $tableId . "&bmsid=" . $bmsId;
?>
<div id="url-site" style="visibility: hidden;"><?php echo $urlJson ?></div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="<?php echo get_bloginfo('template_url'); ?>/ccafs-sites/quick-facts/js/hunger-months.js"></script>
<script src="<?php echo get_bloginfo('template_url'); ?>/ccafs-sites/libs/highcharts-3.0.5/highcharts.js"></script>
<script src="<?php echo get_bloginfo('template_url'); ?>/ccafs-sites/libs/highcharts-3.0.5/modules/exporting.js"></script>

<h4>Hunger/food shortage months</h4>
<div id="container-description" style="float: left;width: 25%;">
   <?php echo $description->description ?>
</div> 

<div id="container-chart" style="float: right;width: 65%; height: auto; margin: 0 auto"></div>
<?php if ($description->source):?>
  <div class='source'><a href='<?php echo $description->source ?>' target="_blank">Source: Baseline survey, <?php echo $description->source_date?></a></div>
<?php endif;?>