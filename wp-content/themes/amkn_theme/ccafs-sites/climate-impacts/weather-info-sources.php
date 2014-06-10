<?php
$bmsId = get_post_meta($post->ID, 'siteId', true);
$tableId = "bs_weather_infosources";
$description = $wpdb->get_row("SELECT * FROM bs_descriptions WHERE bms_id='" . $bmsId . "' AND table_id='" . $tableId . "'");
$data = $wpdb->get_row("SELECT * FROM ".$tableId." WHERE bms_id='".$bmsId."'");
$urlJson = get_bloginfo('template_url') . "/ccafs-sites/json.php?table=" . $tableId . "&bmsid=" . $bmsId;
?>
<div id="url-site" style="visibility: hidden;"><?php echo $urlJson ?></div>
<h4>Sources of information on extreme weather events</h4>
<div id="container-description" style="float: left;width: 18%;">
   <?php echo $description->description ?>
</div>
<div id="container-chart" style="float: right;width: 74%; height: auto; margin: 0 auto;font-size: 13px;font-weight: 700;">
   <table align="center" border="0" cellpadding="5" cellspacing="1" style="width:100%">
                <tr>
			<td align="center" class="table-color2">Source of information on extreme events</td>
                        <td align="center" class="table-color2">Number of responses</td>
			<td align="center" class="table-color2">Percent of households</td>
		</tr>
		<tr>
			<td class="table-color1">Radio</td>
			<td align="center"><?php echo $data->radio_resp ?></td>
                        <td align="center"><?php echo $data->radio_perc ?></td>
		</tr>
                <tr>
			<td class="table-color1">Friends, relatives or neighbors</td>
			<td align="center"><?php echo $data->friend_resp ?></td>
                        <td align="center"><?php echo $data->friend_perc ?></td>
		</tr>
                <tr>
			<td class="table-color1">Own observations</td>
			<td align="center"><?php echo $data->obs_resp ?></td>
                        <td align="center"><?php echo $data->obs_perc ?></td>
		</tr>
                <tr>
			<td class="table-color1">Local group/ gatherings/ meetings</td>
			<td align="center"><?php echo $data->grp_resp ?></td>
                        <td align="center"><?php echo $data->grp_perc ?></td>
		</tr>
                <tr>
			<td class="table-color1">Newspaper</td>
			<td align="center"><?php echo $data->newsp_resp ?></td>
                        <td align="center"><?php echo $data->newsp_perc ?></td>
		</tr>
                <tr>
			<td class="table-color1">Television</td>
			<td align="center"><?php echo $data->tv_resp ?></td>
                        <td align="center"><?php echo $data->tv_perc ?></td>
		</tr>
                <tr>
			<td class="table-color1">Government agricultural or veterinary officer</td>
			<td align="center"><?php echo $data->gov_resp ?></td>
                        <td align="center"><?php echo $data->gov_perc ?></td>
		</tr>
                <tr>
			<td class="table-color1">Traditional forecasts/ indigenous knowledge</td>
			<td align="center"><?php echo $data->trad_resp ?></td>
                        <td align="center"><?php echo $data->trad_perc ?></td>
		</tr>
                <tr>
			<td class="table-color1">Religious faith</td>
			<td align="center"><?php echo $data->rel_resp ?></td>
                        <td align="center"><?php echo $data->rel_perc ?></td>
		</tr>
                <tr>
			<td class="table-color1">NGO project officers</td>
			<td align="center"><?php echo $data->ngo_resp ?></td>
                        <td align="center"><?php echo $data->radio_perc ?></td>
		</tr>
                <tr>
			<td class="table-color1">Meteorological offices</td>
			<td align="center"><?php echo $data->meteo_resp ?></td>
                        <td align="center"><?php echo $data->meteo_perc ?></td>
		</tr>
		
		
	
</table>
   
</div>
<?php if ($description->source):?>
  <div class='source'><a href='<?php echo $description->source ?>' target="_blank">Source: Baseline survey, <?php echo $description->source_date?></a></div>
<?php endif;?>