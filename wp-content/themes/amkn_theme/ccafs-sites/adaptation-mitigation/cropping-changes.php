<?php
$bmsId = get_post_meta($post->ID, 'siteId', true);
$tableId = "bs_climate_reasons";
$description = $wpdb->get_row("SELECT * FROM bs_descriptions WHERE bms_id='" . $bmsId . "' AND table_id='" . $tableId . "'");
$data = $wpdb->get_results("SELECT a.reason_type, b.description AS reason, c.description AS crop, a.value FROM ".$tableId." a 
  INNER JOIN bs_related_reasons b ON (a.reason=b.brr_id) INNER JOIN bs_crop_types c ON (a.crop=c.bct_id) WHERE bms_id='".$bmsId."'");
$cropping = array();
$urlJson = get_bloginfo('template_url') . "/ccafs-sites/json.php?table=" . $tableId . "&bmsid=" . $bmsId;
?>
<?php
  foreach ($data as $item) {
    if ($item->value == 0) 
      $cropping[$item->reason_type][$item->reason][$item->crop] = '--';
    else
      $cropping[$item->reason_type][$item->reason][$item->crop] = $item->value;
    $crops[$item->crop] = 1;
  }
  $crops=array_keys($crops);
  $head='<td></td>';
  foreach ($crops as $item) {
    $head .= '<td>'.$item.'</td>';
  }
?>
<div id="url-site" style="visibility: hidden;"><?php echo $urlJson ?></div>
<h4>Weather/climate related reasons for changes in cropping practices</h4>
<div id="container-description" style="float: left;width: 18%;">
   <?php //echo $description->description ?>
</div>
<div id="container-chart" style="float: right;width: 74%; height: auto; margin: 0 auto;font-size: 13px;font-weight: 700;">
   <table align="center" border="0" cellpadding="5" cellspacing="1" style="width:100%">
    <?php foreach($cropping as $typeR => $reasons):?>
      <tr>
        <td align="center" colspan='<?php echo count($crops)+1?>'class="table-color2"><?php echo $typeR.' related reasons for management changes'?></td>
      </tr>
      <tr class="table-color3">
        <?php echo $head?>
      </tr>
      <?php foreach($reasons as $desc => $reason):?>
        <tr>
          <td>
            <?php echo $desc?>
          </td>
          <?php foreach($crops as $crop):?>
            <td>
              <?php echo $reason[$crop]?>
            </td>
          <?php endforeach;?>
        </tr>
      <?php endforeach;?>
    <?php endforeach;?>                   
  </table>   
</div>