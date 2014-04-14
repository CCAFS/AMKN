<?php
$bmsId = get_post_meta($post->ID, 'siteId', true);
$tableId = "bs_gender_weatherinfo";
$description = $wpdb->get_row("SELECT * FROM bs_descriptions WHERE bms_id='" . $bmsId . "' AND table_id='" . $tableId . "'");
$data = $wpdb->get_row("SELECT * FROM ".$tableId." WHERE bms_id='".$bmsId."'");
$urlJson = get_bloginfo('template_url') . "/ccafs-sites/json.php?table=" . $tableId . "&bmsid=" . $bmsId;
?>
<div id="url-site" style="visibility: hidden;"><?php echo $urlJson ?></div>
<h4>Gender-biased access to weather information</h4>

<div id="container-chart" style="float: right;width: 98%; height: auto; margin: 0 auto;font-size: 13px;font-weight: 700;">
   <table align="center" border="0" cellpadding="5" cellspacing="1" style="width:100%">
        <tr>
			<td width="210" align="center"></td>
            <td colspan="3" align="center">Of those households accessing the information:</td>
			
		</tr>
        <tr>
			<td align="center" class="table-color2">Type of weather-related information</td>
            <td align="center" class="table-color2">% of households reporting <b>WOMEN</b> receive the information</td>
			<td align="center" class="table-color2">% of households reporting <b>BOTH</b> men and women receive  the information</td>
			<td align="center" class="table-color2">% of households reporting only <b>MEN</b> receive the information</td>
		</tr>
		<tr>
			<td class="table-color1">Extreme events</td>
			<td align="center"><?php echo $data->women_extreme ?></td>
            <td align="center"><?php echo $data->both_extreme ?></td>
            <td align="center"><?php echo $data->men_extreme ?></td>
		</tr>
                <tr>
			<td class="table-color1">Pest or disease outbreak</td>
			<td align="center"><?php echo $data->women_pest ?></td>
            <td align="center"><?php echo $data->both_pest ?></td>
            <td align="center"><?php echo $data->men_pest ?></td>
		</tr>
                <tr>
			<td class="table-color1">Start of the rains</td>
			<td align="center"><?php echo $data->women_rains ?></td>
            <td align="center"><?php echo $data->both_rains ?></td>
            <td align="center"><?php echo $data->men_rains ?></td>
		</tr>
                <tr>
			<td class="table-color1">Weather for the next 2-3 months</td>
			<td align="center"><?php echo $data->women_weatherlong ?></td>
            <td align="center"><?php echo $data->both_weatherlong ?></td>
            <td align="center"><?php echo $data->men_weatherlong ?></td>
		</tr>
                <tr>
			<td class="table-color1">Weather for the next 2-3 days</td>
			<td align="center"><?php echo $data->women_weathershort ?></td>
            <td align="center"><?php echo $data->both_weathershort ?></td>
            <td align="center"><?php echo $data->men_weathershort ?></td>
		</tr>
                
		
		
	
</table>
   
</div>
<div id="container-description" style="float: left;width: 98%;">
   <?php echo $description->description ?>
</div>
<?php if ($description->source):?>
  <div class='source'><a href='<?php echo $description->source ?>' target="_blank">Source: Baseline survey</a></div>
<?php endif;?>