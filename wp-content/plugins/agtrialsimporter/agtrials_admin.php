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

/*
 * Plugin Name: AgImpacts - Paginas administrativas
 * Description: Plugin para manejo de propiedades de ag-impacts
 * Author: Camilo Rodriguez
 * Version: 1.0
 */

add_action('admin_menu', 'OpcionMenuMisOpciones');

function OpcionMenuMisOpciones() {
  add_menu_page('Importador', 'agTrials options', 'manage_options', 'pc-admin.php', 'AdminImporter');
}

function AdminImporter() {
//	$cots = consultarCotizaciones();
  $files = array();
  ?>
  <h2>Select the file with the data to import</h2>
  <form action='' method='POST' enctype='multipart/form-data'>
    <input id="infile" name="infile[]" type="file"  multiple="true"><br>
    <input type='submit' name='upload_btn' value='upload'>
  </form>

  <?php
  echo "No. files uploaded : " . count($_FILES['infile']['name']) . "<br>";
  $uploadDir = dirname(__FILE__) . "/tmp/";
//  $uploadDir = "tmp/";
  for ($i = 0; $i < count($_FILES['infile']['name']); $i++) {

    echo "File names : " . $_FILES['infile']['name'][$i] . "<br>";
    $ext = substr(strrchr($_FILES['infile']['name'][$i], "."), 1);

    // generate a random new file name to avoid name conflict
    $fPath = "dataFile" . $i . ".$ext";
    $files[] = $uploadDir . $fPath;
//    $fPath = $_FILES['infile']['tmp_name'][$i];
    echo "File paths : " . $_FILES['infile']['tmp_name'][$i] . "<br>";
    $result = move_uploaded_file($_FILES['infile']['tmp_name'][$i], $uploadDir . $fPath);

    if (strlen($ext) > 0) {
      echo "Uploaded " . $fPath . " succefully. <br>";
    }
//    echo "Upload complete.<br>";
  }
  if (count($files)) {
    importData($files);
  }
}

/**
 * function that valid the data file for ag-impacts data base schema
 * @param type $files array of files updated
 */
function importData($files) {
  global $wpdb;
  foreach ($files as $file) {
    $fh = fopen($file, 'r');
    //jum first line of file
    fgetcsv($fh, 3000, ",");
    //[0] =NAME, [1]=CROP, [2]=COUNTRY, [3] =SOW DATE, [4] = LATITUDE, [5] = LONGITUDE, [6] = URL;

    while ($line = fgetcsv($fh, 3000, ",")) {
      $post = array(
        'post_title' => $line[0],
        'post_name' => $line[0],
        'post_status' => 'publish',
        'post_type' => 'agtrials'
      );
      $postId = wp_insert_post($post);
      if ($postId) {
        $date = explode('/',$line[3]);
        add_post_meta($postId, 'crop', $line[1], true);
        add_post_meta($postId, 'country', $line[2], true);
        add_post_meta($postId, 'sow_date', $line[3], true);
        add_post_meta($postId, 'date_filter', $date[2].$date[0].$date[1], true);
        add_post_meta($postId, 'geoRSSPoint', trim($line[4]) . ' ' . trim($line[5]), true);
        add_post_meta($postId, 'syndication_permalink', $line[6], true);
      }
//       echo $line. "<br>";
    }
//    echo "<pre>CCC#" . print_r($validArticles, true) . "</pre>";
    fclose($fh);
  }
}

function exportJson($files) {
  $uploadDir = dirname(__FILE__) . "/tmp/";
  foreach ($files as $file) {
    $fh = fopen($file, 'r');
    //jum first line of file
    fgetcsv($fh, 3000, ",");
    $trials = array();
    while ($line = fgetcsv($fh, 3000, ",")) {
      $trials[] = array(
        'name' => $line[0],
        'crop' => $line[1],
        'country' => $line[2],
        'sow_date' => $line[3],
        'longitude' => $line[5],
        'latitude' => $line[4],
        'url' => $line[6]
      );
    }
    $myfile = fopen($uploadDir."newfile.json", "w") or die("Unable to open file!");
    $txt = json_encode($trials);
    fwrite($myfile, $txt);
    fclose($myfile);
  }
}
