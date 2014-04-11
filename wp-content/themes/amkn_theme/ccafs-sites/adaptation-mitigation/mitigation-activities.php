<?php
$bmsId = get_post_meta($post->ID, 'siteId', true);
$tableId = "bs_mitig_acts";
$data = $wpdb->get_row("SELECT * FROM ".$tableId." WHERE bms_id='".$bmsId."'");
$description = $wpdb->get_row("SELECT * FROM bs_descriptions WHERE bms_id='" . $bmsId . "' AND table_id='" . $tableId . "'");
?>
<h4>Household mitigation indices</h4>
<div id="container-description" style="float: left;width: 35%;">
    <?php echo $description->description ?>
</div>
<div id="container-chart" style="float: right;width: 55%; height: auto; margin: 0 auto;font-size: 13px;font-weight: 700;">
    <table align="center" border="0" cellpadding="5" cellspacing="1" style="width:100%">
        <tr>
            <td align="center" class="table-color2">Mitigation Index</td>
            <td align="center" class="table-color2">% of households citing</td>
        </tr>
        <tr>
            <td class="table-color1">Tree management</td>
            <td align="center"><?php echo $data->tree ?></td>
        </tr>
        <tr>
            <td class="table-color1">Soil amendments </td>
            <td align="center"><?php echo $data->soil ?></td>
        </tr>
        <tr>
            <td class="table-color1">Increase in productivity </td>
            <td align="center"><?php echo $data->productiv ?></td>
        </tr>
        <tr>
            <td class="table-color1">Input intensification </td>
            <td align="center">Low-<?php echo $data->intensif_lo ?>  Higth-<?php echo $data->intensif_hl ?></td>
        </tr>



    </table>

</div>
<div class='source'><a href='<?php echo $description->source ?>' target="_blank">Source: Baseline survey</a></div>