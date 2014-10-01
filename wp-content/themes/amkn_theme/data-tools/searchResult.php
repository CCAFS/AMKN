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
$search = $_POST['key'];
//$sql1 = "SELECT a.*, b.name as sub, c.name as cat, c.id as cat_id FROM dt_deliverables a INNER JOIN dt_subcategories b ON (a.subcategory_id = b.id) INNER JOIN dt_categories c ON (b.category_id = c.id) WHERE a.description LIKE '%".$search."%' OR a.name LIKE '%".$search."%' OR a.subject LIKE '%".$search."%' ";
//$results = $wpdb->get_results($sql1);

$sql1 = "SELECT count(*) as total FROM dt_deliverables a INNER JOIN dt_subcategories b ON (a.subcategory_id = b.id) INNER JOIN dt_categories c ON (b.category_id = c.id) WHERE a.description LIKE '%".$search."%' OR a.name LIKE '%".$search."%' OR a.subject LIKE '%".$search."%' ";
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
  var id = '<?php echo $search; ?>'; // last page number
  function request_page(pn) {
//    $("#results_box").html("");
    $("#loading").show();
//    $("#pagination_controls").hide();
    $.ajax({
      url: "rows_searchResult.php",
      type: "POST",
      data: {key: id, rpp: rpp, last: last, pn: pn},
      success: function(result) {
        $("#results_box").hide();
        $("#results_box").html(result);
        $("#results_box").fadeIn();
        $("#pagination_controls").css('display', 'inline-flex');
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
        paginationCtrls += '<button style="margin: 0px 0px 5px 5px;" onclick="request_page(' + 1 + ')">&lt;&lt;</button>';
        paginationCtrls += '<button style="margin: 0px 0px 5px 5px;" onclick="request_page(' + (pn - 1) + ')">&lt;</button>';
      }
      paginationCtrls += ' &nbsp; &nbsp; <b>Page ' + pn + ' of ' + last + '</b> &nbsp; &nbsp; ';
      paginationCtrls += '<ul class="paginate">';
      if (pn != 1 && pn != last) {
        first = (pn-1);
        lastt = (pn+1);
      } else if (pn == 1){
        first = 1;
        lastt = 3;
      } else if (pn == last){
        first = last-2;
        lastt = last;
      }
      for (i = first; i <= lastt; i++) {
        var sel = '';
        if(i==pn) {
          sel = 'active';
        }
        paginationCtrls += '<li><a href="javascript:onclick=request_page(' + i + ');"  class="paginate_click '+sel+'" id="'+i+'-page">'+i+'</a></li>';
      }
      paginationCtrls += '</ul>';
      if (pn != last) {
        paginationCtrls += '<button style="margin: 0px 0px 5px 5px;" onclick="request_page(' + (pn + 1) + ')">&gt;</button>';
        paginationCtrls += '<button style="margin: 0px 0px 5px 5px;" onclick="request_page(' + last + ')">&gt;&gt;</button>';
      }
    }
    $("#pagination_controls").html(paginationCtrls);
  }
</script>
<div id="results_box" style="width: 100%; float:left; margin-left: 15px">
</div>
<div id="loading-r" style="display:none;position:absolute; width:100%;top: 300px;">
  <img style="display: block; margin: 0 auto;" src="img/loading.gif" alt="Loader" />
</div>
<div id="pagination_controls" style="float:right; display:none"></div>
<script> request_page(1);</script>
