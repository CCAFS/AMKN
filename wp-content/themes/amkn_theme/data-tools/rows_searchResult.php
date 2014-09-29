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
$where = "";
$search = $_POST['key'];

// Make the script run only if there is a page number posted to this script
if (isset($_POST['pn'])) {
  $rpp = preg_replace('#[^0-9]#', '', $_POST['rpp']);
  $last = preg_replace('#[^0-9]#', '', $_POST['last']);
  $pn = preg_replace('#[^0-9]#', '', $_POST['pn']);
  // This makes sure the page number isn't below 1, or more than our $last page
  if ($pn < 1) {
    $pn = 1;
  } else if ($pn > $last) {
    $pn = $last;
  }
  // This sets the range of rows to query for the chosen $pn
  $limit = 'LIMIT ' . ($pn - 1) * $rpp . ',' . $rpp;
  $sql1 = "SELECT a.*, b.name as sub, c.name as cat, c.id as cat_id FROM dt_deliverables a INNER JOIN dt_subcategories b ON (a.subcategory_id = b.id) INNER JOIN dt_categories c ON (b.category_id = c.id) WHERE a.description LIKE '%".$search."%' OR a.name LIKE '%".$search."%' OR a.subject LIKE '%".$search."%' ORDER BY sub, name, cat $limit";
  $results = $wpdb->get_results($sql1);
}
?>
<?php if (count($results)): ?>
  <div style="font-size: 30px;">Results</div>
  <?php // echo $sql1;   ?>
  <?php foreach ($results as $res): ?>
    <div class="clearfix" style="margin-bottom: 15px;width: 100%; cursor: pointer;" onclick="deliverableChosen(<?php echo $res->id ?>)">
      <div class="label-category <?php echo ($res->external)?'external':''?>" style="background-image: url(img/<?php echo $res->cat_id ?>.png);"><span> <?php // echo $res->cat  ?></span></div>
      <div class="label-subcategory <?php echo ($res->external)?'external':''?>"><span> <?php echo ($res->external)?'External<br>'.$res->sub:$res->sub ?></span></div>
      <div class="content-category-search <?php echo ($res->external)?'external':''?>" style="width: 73%"> 
        <?php echo $res->name ?>
        <p style="color:#4bc8dc">
          <?php echo trim_text($res->description, 100) ?>
        </p>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div style="float: left; padding: 10px; margin: 10px; width: 100%;text-align: center;font-size: 35px; font-style: oblique;">
    No results
  </div>
<?php endif; ?>