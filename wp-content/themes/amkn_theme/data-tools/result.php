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
$category = $_POST['category'];
$subcategories = array();
if (!isset($_GET['first'])) {
  if (isset($_GET['subc'])) {
    $subcategories = $_GET['subc'];
    $where .= " AND a.subcategory_id IN (" . implode(",", $subcategories) . ") ";
  } else {
    $where .= " AND a.subcategory_id = 0 ";
  }
}

$regions = array();
if (isset($_GET['reg'])) {
  $regions = $_GET['reg'];
  $where .= " AND a.region_id IN (" . implode(",", $regions) . ") ";
}
$sql = "SELECT * FROM dt_subcategories where category_id = " . $category;
$subs = $wpdb->get_results($sql);

$sql = "SELECT * FROM dt_regions";
$regs = $wpdb->get_results($sql);

$sql1 = "SELECT count(*) as total FROM dt_deliverables a INNER JOIN dt_subcategories b ON (a.subcategory_id = b.id) INNER JOIN dt_categories c ON (b.category_id = c.id) WHERE c.id= " . $category . " " . $where;
$result = $wpdb->get_row($sql1);

$total_rows = $result->total;
$rpp = 3;
// This tells us the page number of our last page
$last = ceil($total_rows / $rpp);
// This makes sure $last cannot be less than 1
if ($last < 1) {
  $last = 1;
}
?>
<script>
  var rpp = <?php echo $rpp; ?>; // results per page
  var last = <?php echo $last; ?>; // last page number
  var id = <?php echo $category; ?>; // last page number
  function request_page(pn, form) {
//    $("#results_box").html("");
    $("#loading").show();
//    $("#pagination_controls").hide();
    $.ajax({
      url: "pagination_parser.php?" + form,
      type: "POST",
      data: {category: id, rpp: rpp, last: last, pn: pn},
      success: function(result) {
        $("#results_box").hide();
        $("#results_box").html(result);
        $("#results_box").fadeIn();
        $("#pagination_controls").fadeIn();
      },
      complete: function() {
        $("#loading").fadeOut('slow');
//        $("#results_box").html(result);
      }
    })
    // Change the pagination controls
    var paginationCtrls = "";
    // Only if there is more than 1 page worth of results give the user pagination controls
    if (last != 1) {
      if (pn > 1) {
        paginationCtrls += '<button style="margin: 0px 0px 5px 5px;" onclick="request_page(' + 1 + ',\'' + form + '\')">&lt;&lt;</button>';
        paginationCtrls += '<button style="margin: 0px 0px 5px 5px;" onclick="request_page(' + (pn - 1) + ',\'' + form + '\')">&lt;</button>';
      }
      paginationCtrls += ' &nbsp; &nbsp; <b>Page ' + pn + ' of ' + last + '</b> &nbsp; &nbsp; ';
      paginationCtrls += '<ul class="paginate">';
      for (i = 1; i <= last; i++) {
        var sel = '';
        if(i==pn) {
          sel = 'active';
        }
        paginationCtrls += '<li><a href="javascript:onclick=request_page(' + i + ',\'' + form + '\');"  class="paginate_click '+sel+'" id="'+i+'-page">'+i+'</a></li>';
      }
      paginationCtrls += '</ul>';
      if (pn != last) {
        paginationCtrls += '<button style="margin: 0px 0px 5px 5px;" onclick="request_page(' + (pn + 1) + ',\'' + form + '\')">&gt;</button>';
        paginationCtrls += '<button style="margin: 0px 0px 5px 5px;" onclick="request_page(' + last + ',\'' + form + '\')">&gt;&gt;</button>';
      }
    }
    $("#pagination_controls").html(paginationCtrls);
  }
</script>
<div style="width: 30%; float:left; background: #f2f1ef; padding: 5px 0px 5px 10px">
  <div style="font-size: 30px;">Tools and computer</div>
  <div style="font-size: 18px; color:#4bc8dc">Description of category</div>
  <form id="filter">
    <div>
      <ul style="list-style-type: none;">
        <li><input type="checkbox" name="selectall" id="selectall" <?php echo (isset($_GET['selectall']) || isset($_GET['first'])) ? 'checked' : '' ?> onclick="selectAll(this);
            categoryChosen(<?php echo $category ?>, $('#filter').serialize());"/><label><?php echo 'All' ?></label></li>
          <?php foreach ($subs as $sub): ?>
          <li><input class="checkall" type="checkbox" name="subc[]" value="<?php echo $sub->id ?>" <?php echo (in_array($sub->id, $subcategories) || isset($_GET['first'])) ? 'checked' : '' ?> onclick="validSelect(this);
                categoryChosen(<?php echo $category ?>, $('#filter').serialize());"/><label><?php echo $sub->name ?></label></li>
          <?php endforeach; ?>
      </ul>
    </div>
    <div style="font-size: 30px;">Regions</div>
    <div>
      <ul style="list-style-type: none;">
        <!--<li><input type="checkbox" name="subc0"/><label><?php echo 'All' ?></label></li>-->
        <?php foreach ($regs as $reg): ?>
          <li><input type="checkbox" name="reg[]" value="<?php echo $reg->id ?>" <?php echo (in_array($reg->id, $regions)) ? 'checked' : '' ?> onclick="categoryChosen(<?php echo $category ?>, $('#filter').serialize());"/><label><?php echo $reg->name ?></label></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </form>
</div>
<div id="results_box" style="width: 67%; float:left; margin-left: 15px">

</div>
<div id="loading-r" style="display:none;position:absolute; width:100%;top: 300px;">
  <img style="display: block; margin: 0 auto;" src="img/loading.gif" alt="Loader" />
</div>
<div id="pagination_controls" style="float:right; display:inline-flex"></div>
<script> request_page(1, $('#filter').serialize());</script>
