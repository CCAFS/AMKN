<?php
/*
 *  This file is part of Adaptation and Mitigation Knowledge Network (AMKN).
 *
 *  AMKN is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  at your option) any later version.
 *
 *  AMKN is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with DMSP.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Copyright 2012 (C) Climate Change, Agriculture and Food Security (CCAFS)
 * 
 * Created on : 20-10-2012
 * @author      
 * @version     1.0
 */
/*
  Template Name: data&tools Template
 */
require('../../../../wp-load.php');
get_header('embed');
global $wpdb;
//$url = "http://amkn.org/wp-content/themes/amkn_theme/services.php/DataAndTools/get";
//$http_respone_header = file_get_contents($url);
//$apps = json_decode($http_respone_header, true);

$sql = "SELECT c.id, c.name, count(*) as total FROM dt_deliverables a INNER JOIN dt_subcategories b ON (a.subcategory_id = b.id) INNER JOIN dt_categories c ON (b.category_id = c.id) group by c.name ";
$results = $wpdb->get_results($sql);
$catCount = array();
foreach ($results as $res) {
  $catCount[$res->id] = $res->total;
}

$sql = "SELECT id, name FROM dt_categories";
$categories = $wpdb->get_results($sql);
//echo "<pre>".print_r( $categories,true)."</pre>#".count($categories); 
?>
<link rel="stylesheet" type="text/css" href="css/dataAndTools.css">
<?php if (isset($_GET['css'])): ?>
  <link rel="stylesheet" type="text/css" href="css/<?php echo $_GET['css'] ?>.css">
<?php else : ?>
  <link rel="stylesheet" type="text/css" href="css/default.css">
<?php endif; ?>
<script src="js/dataAndTools.js"></script>
<div id="container" style="background: #FFF; font-family: open_sanscondensed_light;">
  <div class="art-search clearfix">
    <!--<form class="" method="get" name="" action="" style="display: inline-flex">-->
    <input class="searchbar" name="s" type="text" value="" onkeydown="serachDeliverable(this.value, event)">
    <button class="searchsubmit" onclick="serachDeliverable($('.searchbar').val(), true)"> Search   </button>
    <!--</form>--> 
  </div>
  <div class="clearfix categories-btns">
    <?php foreach ($categories AS $cat): ?>
      <div class="category-btn" style="background-image: url(img/<?php echo $cat->id ?>.png);width:<?php echo 95 / count($categories) ?>%; margin:<?php echo 2.5 / count($categories) ?>%;" onclick="categoryChosen(<?php echo $cat->id ?>, 'first=true');
          $(this).addClass('selected').siblings().removeClass('selected');
          $('#result').show();
          $('#detail').html('');
          $('.searchbar').val('');">
        <div style="position: absolute;right: 0.5em;bottom: 0;"><?php echo (isset($catCount[$cat->id])) ? $catCount[$cat->id] : 0 ?></div>
        <div style="position: absolute;bottom: 0;padding-left: 5px;"><?php echo $cat->name ?></div>
      </div>
    <?php endforeach; ?>
  </div>
 
  <div id="loading" style="display:none;position:absolute; width:100%;top: 300px;">
    <img style="display: block; margin: 0 auto;" src="img/loading.gif" alt="Loader" />
  </div>
  <div id="result" style="padding-top: 30px; width: 100%;" class="clearfix">
    <div style="float: left; padding: 10px; margin: 10px; width: 100%;text-align: center;font-size: 35px; font-style: oblique;">
      Select a category that you are interested
    </div>
    <?php //get_template_part('data-tools/result') ?>
  </div>
  <div id="detail" style="padding-top: 30px; width: 100%;" class="clearfix"></div>
</div>
<?php
//get_footer();
?>