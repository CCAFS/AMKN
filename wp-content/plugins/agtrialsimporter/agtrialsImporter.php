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

$origen = file_get_contents("http://www.agtrials.org/api/apitrials?key=5BA47C07B9B6A8F&trialgroup=71,86");
$trials = json_decode($origen);
$output = '<?xml version="1.0" encoding="UTF-8"?>$';
$output .= '<rss xmlns:georss="http://www.georss.org/georss" xmlns:trial="http://localhost/AMKN/wp-content/plugins/activitiesImporter/TypeActivities" version="2.0">$';
$output .= '<channel><title>Agtrials</title><link>http://www.agtrials.org/</link><description></description>$';
echo "total: " . count($trials);
foreach ($trials as $trial) {
//  echo $trial->id . ', ';
  $output .= '<item>$';
  $output .= '<title>' . $trial->trialname . '</title>$';
  $output .= '<link>' . $trial->url . '</link>$';
  $output .= '<description></description>$';
  $output .= '<id>' . $trial->id . '</id>$';
  $output .= '<georss:point>' . $trial->latitude . ' ' . $trial->longitude . '</georss:point>$';
  $output .= '<trial:crop>' . $trial->crop . '</trial:crop>$';
  $output .= '</item>$';
}
$output .= '</channel>$';
$output .= '</rss>';
$fh = fopen("rssTrials.xml", 'w');
//$stringData = $_POST['dataxml'];
fwrite($fh, $output);
fclose($fh);
echo 'rssTrials.xml created successfully';
$fh = fopen("rssTrials.json", 'w');
//$stringData = $_POST['dataxml'];
fwrite($fh, $origen);
fclose($fh);
?>
<script>
//  var trials = <?php // echo $origen  ?>;
//  var count = Object.keys(trials).length;
//  var ids = "";
//  var output = '<?xml version="1.0" encoding="UTF-8"?>$';
//  output += '<rss xmlns:georss="http://www.georss.org/georss" xmlns:ccafs="http://localhost/AMKN/wp-content/plugins/activitiesImporter/TypeActivities" version="2.0">$';
//  output += '<channel><title>Planing and Reporting</title><link>http://activities.ccafs.cgiar.org</link><description></description>$';
//  console.log(count);
//  for (var i = 0; i < trials.length; i++) {
//    var obj = trials[i];
//    ids += obj.id + ', ';
////    for (var key in obj) {
////      var attrName = key;
////      var attrValue = obj[key];
////    }
//  }
//  console.log(ids);
</script>
