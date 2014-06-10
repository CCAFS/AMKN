<?php
$bmsId = get_post_meta($post->ID, 'siteId', true);
$tableId = "bs_climate_crises";
$description = $wpdb->get_row("SELECT * FROM bs_descriptions WHERE bms_id='" . $bmsId . "' AND table_id='" . $tableId . "'");
$data = $wpdb->get_row("SELECT * FROM ".$tableId." WHERE bms_id='".$bmsId."'");
$urlJson = get_bloginfo('template_url') . "/ccafs-sites/json.php?table=" . $tableId . "&bmsid=" . $bmsId;
?>
<div id="url-site" style="visibility: hidden;"><?php echo $urlJson ?></div>
<h4>Climate-related crises in the past 5 years</h4>
<div id="container-description" style="float: left;width: 30%;">
   <?php echo $description->description ?>
</div>
<div id="container-chart" style="float: right;width: 60%; height: auto; margin: 0 auto;font-size: 13px;font-weight: 700;">
   <table align="center" border="0" cellpadding="20" cellspacing="1" style="width:100%">
	
		<tr>
			<td align="center" class="table-color1">Households facing a climate crisis</td>
			<td align="center"><?php echo $data->hh_facing ?></td>
		</tr>
		<tr>
			<td align="center" class="table-color1">Households receiving assistance</td>
			<td align="center"> <?php echo $data->hh_receiving ?></td>
		</tr>
		<tr>
			<td align="center" class="table-color1">Source of aid</td>
			<td align="center"><?php echo $data->aid_source ?></td>
		</tr>
	
</table>
   
</div>
<?php if ($description->source):?>
  <div class='source'><a href='<?php echo $description->source ?>' target="_blank">Source: Baseline survey, <?php echo $description->source_date?></a></div>
<?php endif;?>