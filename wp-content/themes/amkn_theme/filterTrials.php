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

require('../../../wp-load.php');
global $wpdb;
$metaKey = array();
$txt = '';
if (isset($_POST['comodity']) && $_POST['comodity'] != '') {
  $metaKey[] = array('key' => 'crop', 'value' => $_POST['comodity']);
}
if (isset($_POST['country']) && $_POST['country'] != '') {
  $metaKey[] = array('key' => 'country', 'value' => $_POST['country']);
}
if (isset($_POST['from']) && $_POST['from'] != '' && isset($_POST['to']) && $_POST['to'] != '') {
  $from = explode('/',$_POST['from']);
  $to = explode('/',$_POST['to']);
  $metaKey[] = array('key' => 'date_filter', 'value' => array($from[2].$from[1].$from[0],$to[2].$to[1].$to[0]), 'type' => 'DATE', 'compare' => 'BETWEEN');
}
$args = array(
  'post_type' => 'agtrials',
  'posts_per_page' => '-1');
if (count($metaKey)) {
  $args = array_merge(array('meta_query' => $metaKey), $args);

  $posts = new WP_Query($args);

// The Loop
  if ($posts->have_posts()) {
    $result = array();
    while ($posts->have_posts()) {
      $posts->the_post();

      $meta = get_post_meta($post->ID);
//      echo "<pre>" . $post->ID . print_r($meta, true) . "</pre>";
      $geodata = explode(' ', $meta['geoRSSPoint'][0]);
      $trials[] = array(
        'name' => $post->post_title,
        'crop' => $meta['crop'][0],
        'country' => $meta['country'][0],
        'sow_date' => $meta['sow_date'][0],
        'longitude' => $geodata[1],
        'latitude' => $geodata[0],
        'url' => $meta['syndication_permalink'][0]
      );
    }
    $txt = json_encode($trials);
    echo 1;
  } else {
    echo 2;
  }
  $uploadDir = WP_PLUGIN_DIR . "/agtrialsimporter/tmp/";
  $myfile = fopen($uploadDir . "newfile.json", "w") or die("Unable to open file!");
  fwrite($myfile, $txt);
  fclose($myfile);
  /* Restore original Post Data */
  wp_reset_postdata();

//  echo 1;
} else {
  echo 0;
}

//print_r($metaKey);


