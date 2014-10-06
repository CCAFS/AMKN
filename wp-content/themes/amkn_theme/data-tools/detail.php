<?php
/*
 * Copyright (C) 2014 CRSANCHEZ
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
require('../../../../wp-load.php');
//get_header('embed');
global $wpdb;
$id = $_POST['deliverable'];
$sql1 = "SELECT a.* FROM dt_deliverables a  WHERE a.id= " . $id;
$result = $wpdb->get_row($sql1);
?>
<div style="width: 100%; background: #f2f1ef; float:left; padding: 10px 0px 0px 10px">
  <div id="closeDetail" class="closeDetailBtn" title="Close" onclick="$('#result').show();
      $('#detail').html('');"></div>
  <div style="float: left; padding-bottom: 10px; margin-bottom: 10px; width: 100%;font-size: 35px; font-style: oblique;">
    <?php echo $result->name ?>
  </div>
  <div style="width: 67%; float:left; padding-right: 30px;">
    <div style="font-size: 30px;">Subject</div>
    <div>
      <p>
        <?php echo $result->subject ?>
      </p>
    </div>
    <div style="font-size: 30px;">Description</div>
    <div>
      <p>
        <?php echo $result->description ?>
      </p>
    </div>
    <div>
      <table >
        <tr>
          <td style="width: 50%"><b>Publisher: </b><?php echo $result->publisher ?></td>
          <td><b>Language:</b> <?php echo $result->language ?></td>
        </tr>
        <tr>
          <td style="width: 50%"><b>URL: </b><?php echo $result->url ?></td>
          <td><b>Rights: </b><?php echo $result->rights ?></td>
        </tr>
        <tr>
          <td style="width: 50%"><b>Contributor:</b> <?php echo $result->contributor ?></td>
          <td rowspan="4"><b>Source: </b><?php echo $result->source ?></td>
        </tr>
        <tr>
          <td style="width: 50%"><b>Date: </b><?php echo $result->date ?></td>
        </tr>
        <tr>
          <td style="width: 50%"><b>Format: </b><?php echo $result->Format ?></td>
        </tr>
        <tr>
          <td style="width: 50%"><b>Relation: </b><?php echo $result->relation ?></td>
        </tr>
      </table>
    </div>
  </div>
  <div style="width: 30%; float:left;">
    <div class="coverage" style="font-size: 30px; text-align: center">
      Coverage(<?php echo ($result->region_id == 1) ? 'Global' : $result->coverage ?>)
      <img style="margin-top:15px" src="img/world.png" width="280px">
    </div>
    <div style="font-size: 30px;text-align: center;margin-top: 20px">
      Creator (<?php echo $result->creator?>)
      <img style="margin-top:15px" src="../images/logo_ciat.png" width="225px">
    </div>
  </div>



</div>