<?php
$bmsId = get_post_meta($post->ID, 'siteId', true);
$tableId = "bs_cash_resources";
$description = $wpdb->get_row("SELECT * FROM bs_descriptions WHERE bms_id='" . $bmsId . "' AND table_id='" . $tableId . "'");
$data = $wpdb->get_row("SELECT * FROM ".$tableId." WHERE bms_id='".$bmsId."'");
$urlJson = get_bloginfo('template_url') . "/ccafs-sites/json.php?table=" . $tableId . "&bmsid=" . $bmsId;
?>
<div id="url-site" style="visibility: hidden;"><?php echo $urlJson ?></div>
<h4>Sources of off-farm cash resources</h4>
<div id="container-description" style="float: left;width: 30%;">
   <?php echo $description->description ?>
</div>
<div id="container-chart" style="float: right;width: 60%; height: auto; margin: 0 auto;font-size: 13px;font-weight: 700;">
   <table align="center" border="0" cellpadding="5" cellspacing="1" style="width:100%">
                <tr>
			<td align="center" class="table-color2">Source of Cash Income</td>
			<td align="center" class="table-color2">% of Households</td>
		</tr>
		<tr>
			<td class="table-color1">Employment on someone else's farm</td>
			<td align="center"><?php echo $data->hh_facing ?></td>
		</tr>
		<tr>
			<td class="table-color1">Business</td>
			<td align="center"> <?php echo $data->business ?></td>
		</tr>
		<tr>
			<td  class="table-color1">Remittances/gifts</td>
			<td align="center"><?php echo $data->remitt ?></td>
		</tr>
                <tr>
			<td  class="table-color1">Other off-farm employment</td>
			<td align="center"><?php echo $data->otherfarm ?></td>
		</tr>
		<tr>
			<td class="table-color1">No off-farm cash source</td>
			<td align="center"> <?php echo $data->otherjob ?></td>
		</tr>
		<tr>
			<td  class="table-color1">Renting out farm machinery</td>
			<td align="center"><?php echo $data->rentmatch ?></td>
		</tr>
                <tr>
			<td  class="table-color1">Renting out land</td>
			<td align="center"><?php echo $data->rentland ?></td>
		</tr>
		<tr>
			<td  class="table-color1">Payments for environmental services</td>
			<td align="center"> <?php echo $data->envirpay ?></td>
		</tr>
		<tr>
			<td class="table-color1">Loan or credit from a formal institution</td>
			<td align="center"><?php echo $data->formloan	 ?></td>
		</tr>
                <tr>
			<td class="table-color1">Payments from government or other projects/programs</td>
			<td align="center"><?php echo $data->govpay ?></td>
		</tr>
		<tr>
			<td  class="table-color1">Informal loan or credit</td>
			<td align="center"> <?php echo $data->informloan ?></td>
		</tr>
		
	
</table>
   
</div>