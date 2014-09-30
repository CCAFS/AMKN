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
//require_once( dirname(__FILE__) . '/wp-load.php' );
get_header();

$url = "http://amkn.org/wp-content/themes/amkn_theme/services.php/DataAndTools/get";
$http_respone_header = file_get_contents($url);
$apps = json_decode($http_respone_header, true);
//echo "<pre>".print_r( json_decode($http_respone_header,true),true)."</pre>"; 
?>
<div id="container">
  <h2>Data & Tools</h2>
  <?php
  foreach ($apps as $app) :
    ?>

    <div id="tool">
      <div id="tool-img">
        <a href="<?php echo $app['url'] ?>">
          <img src="<?php echo $app['imageUrl'] ?>" />
        </a>
      </div>

      <div id="tool-content">
        <a href="<?php echo $app['url'] ?>"><h4><?php echo $app['title'] ?></h4> </a>
        <?php echo $app['description'] ?>
      </div>
    </div>

    <?php
  endforeach;
  ?>
</div>
<?php
get_footer();
?>