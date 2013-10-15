<?php
$bmsId = get_post_meta($post->ID, 'siteId', true);
$tableId = "bs_climate_reasons";
$description = $wpdb->get_row("SELECT * FROM bs_descriptions WHERE bms_id='" . $bmsId . "' AND table_id='" . $tableId . "'");
$data = $wpdb->get_row("SELECT * FROM ".$tableId." WHERE bms_id='".$bmsId."'");
$urlJson = get_bloginfo('template_url') . "/ccafs-sites/json.php?table=" . $tableId . "&bmsid=" . $bmsId;
?>
<div id="url-site" style="visibility: hidden;"><?php echo $urlJson ?></div>
<h4>Weather/climate related reasons for changes in cropping practices</h4>
<div id="container-description" style="float: left;width: 18%;">
   <?php echo $description->description ?>
</div>
<div id="container-chart" style="float: right;width: 74%; height: auto; margin: 0 auto;font-size: 13px;font-weight: 700;">
   <table align="center" border="0" cellpadding="5" cellspacing="1" style="width:100%">
                <tr>
			<td align="center" class="table-color2">Weather/Climate-related Reason</td>
                        <td align="center" class="table-color2">% of households citing</td>
		</tr>
		<tr>
			<td class="table-color1">Earlier start of rains</td>
			<td align="center"><?php echo $data->esor ?></td>
		</tr>
                <tr>
			<td class="table-color1">Less overall rain</td>
			<td align="center"><?php echo $data->lran ?></td>  
		</tr>
                <tr>
			<td class="table-color1">More frequent droughts</td>
			<td align="center"><?php echo $data->obs_resp ?></td>
                <tr>
			<td class="table-color1">Later start of rains</td>
			<td align="center"><?php echo $data->grp_resp ?></td>
		</tr>
                <tr>
			<td class="table-color1">More frequent floods</td>
			<td align="center"><?php echo $data->newsp_resp ?></td>
		</tr>
                <tr>
			<td class="table-color1">More overall rainfall</td>
			<td align="center"><?php echo $data->tv_resp ?></td>
		</tr>
                <tr>
			<td class="table-color1">Higher temperatures</td>
			<td align="center"><?php echo $data->gov_resp ?></td>
		</tr>
                <tr>
			<td class="table-color1">Strong winds</td>
			<td align="center"><?php echo $data->trad_resp ?></td>
		</tr>
                <tr>
			<td class="table-color1">Lower groundwater table</td>
			<td align="center"><?php echo $data->rel_resp ?></td>
		</tr>
</table>
   
</div>