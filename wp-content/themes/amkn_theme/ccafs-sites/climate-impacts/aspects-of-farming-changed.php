<?php
$bmsId = get_post_meta($post->ID, 'siteId', true);
$tableId = "bs_forecast_changes";
$description = $wpdb->get_row("SELECT * FROM bs_descriptions WHERE bms_id='" . $bmsId . "' AND table_id='" . $tableId . "'");
$longs = $wpdb->get_results("SELECT * FROM " . $tableId . " WHERE bms_id='" . $bmsId . "' and type_forecast='LONG'");
$shorts = $wpdb->get_results("SELECT * FROM " . $tableId . " WHERE bms_id='" . $bmsId . "'and type_forecast='SHORT'");
?>
<h4>Aspects of farming changed with forecast information</h4>
<div id="container-description" style="float: left;width: 30%;">
    <?php echo $description->description ?>
</div>
<div id="container-chart" style="float: right;width: 60%; height: auto; margin: 0 auto;font-size: 13px;font-weight: 700;">
    <table align="center" border="0" cellpadding="5" cellspacing="1" style="width:100%">
        <tr>
            <td align="center" class="table-color2">Type of forecast</td>
            <td align="center" class="table-color2">Farming practices changed</td>
        </tr>
        <tr>
            <td class="table-color1">Long-term (2-3 months)</td>
            <td align="center"><?php
                foreach ($longs as $long) {
                    echo $long->description."<br>";
                }
                ?></td>
        </tr>
        <tr>
            <td class="table-color1">Short-term (2-3 days)</td>
            <td align="center"> <?php
                foreach ($shorts  as $short ) {
                    echo $short->description."<br>";
                }
                ?></td>
        </tr>



    </table>

</div>