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
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
global $query_string; // required
global $wpdb;
$join = '';
$metaKey = array();
$orderby = array();
$order = 'ASC';
$filt = '';
$themes = array('1' => 'Adaptation to Progressive Climate Change', '2' => 'Adaptation through Managing Climate Risk', '3' => ' Pro-Poor Climate Change Mitigation', '4.1' => ' Linking Knowledge to Action', '4.2' => 'Data and Tools for Analysis and Planning', '4.3' => 'Policies and Institutions');
if ($_GET['order'] == 'true') {
  $order = 'DESC';
}
if (isset($_GET['view']) && count($_GET['view']) != 2) {
  if (in_array('active', $_GET['view'])) {
    $metaKey[] = array('key' => 'endDateFilter', 'value' => date('Ymd'), 'compare' => '>');
    $join .= " INNER JOIN $wpdb->postmeta b ON (b.post_id = z.ID AND b.meta_key = 'endDateFilter' AND b.meta_value > " . date('Ymd') . ")";
    $filt .='Ongoing projects<br>';
  } else {
    $metaKey[] = array('key' => 'endDateFilter', 'value' => date('Ymd'), 'compare' => '<=');
    $join .= " JOIN $wpdb->postmeta b ON (b.post_id = z.ID AND b.meta_key = 'endDateFilter' AND b.meta_value <= " . date('Ymd') . ")";
    $filt .='Past projects<br>';
  }
}
if ($_GET['leader'] != '0' && $_GET['leader'] != '') {
  $metaKey[] = array('key' => 'leaderAcronym', 'value' => $_GET['leader']);
  $join .= " INNER JOIN $wpdb->postmeta c ON (c.post_id = z.id AND c.meta_key = 'leaderAcronym' AND c.meta_value IN ('" . implode("','", $_GET['leader']) . "'))";
  $filt .='CG Center ' . $_GET['leader'] . '<br>';
}
if ($_GET['theme'] != '0' && $_GET['theme'] != '') {
  $metaKey[] = array('key' => 'theme', 'value' => $_GET['theme']);
  $join .= " INNER JOIN $wpdb->postmeta d ON (d.post_id = z.ID AND d.meta_key = 'theme' AND d.meta_value IN ('" . implode("','", $_GET['theme']) . "'))";
  //$filt .='Topic ' . $themes[$_GET['theme']] . '<br>';
}
if ($_GET['orderby'] != 'title' && $_GET['orderby'] != '') {
  $orderType = ($_GET['orderby'] == 'leaderName') ? 'meta_value' : 'meta_value_num';
  $orderby = array('orderby' => $orderType, 'meta_key' => $_GET['orderby']);
} else if ($_GET['orderby'] == 'title') {
  $orderby = array('orderby' => 'title', 'post_type' => 'ccafs_activities');
}

if ($_GET['nearest_site'] != '0' && $_GET['nearest_site'] != '') {
  $metaKey[] = array('key' => 'nearestBenchmarkSite', 'value' => $_GET['nearest_site']);
  $argsn = array('posts_per_page' => -1, 'post_type' => 'ccafs_sites');
  $contentQuery = new WP_Query($argsn);
  $sites = array();
  while ($contentQuery->have_posts()) {
    $contentQuery->the_post();
    $sites[$contentQuery->post->ID] = the_title("", "", false);
  }
  $filt .='Nearest Research site "' . $sites[$_GET['nearest_site']] . '"<br>';
}
if ($_GET['keyword'] != '0' && $_GET['keyword'] != '') {
  $args['s'] = $_GET['keyword'];
  $metaKey[] = array(
    'relation' => 'OR',
    array(
      'key' => 'keywords',
      'value' => ''.$_GET['keyword'].'',
      'compare' => 'LIKE'
    ),
    array(
      'key' => 'objective',
      'value' => ''.$_GET['keyword'].'',
      'compare' => 'LIKE'
    ),
    array(
      'key' => 'deliverableTitle',
      'value' => ''.$_GET['keyword'].'',
      'compare' => 'LIKE'
    )
    );
  $_GET['keyword'];
  $filt .='Keyword ' . $_GET['keyword'] . '<br>';
}
$paged = get_query_var('paged');
if (count($metaKey)) {
  $args = array_merge(array('meta_query' => $metaKey), array('posts_per_page' => '25', 'order' => $order, 'paged' => $paged), $orderby);
} elseif (count($orderby)) {
  $args = array_merge(array('posts_per_page' => '25', 'order' => $order, 'paged' => $paged), $orderby);
} else {
//  $args = $query_string.'&posts_per_page=25&order=ASC&orderby=title';
  $args = array(
    'post_type' => 'ccafs_activities',
    'orderby' => 'title',
    'order' => 'asc',
    'posts_per_page' => '25',
    'paged' => $paged
  );
}

//echo "<pre>".print_r($args,true)."</pre>";
$posts = new WP_Query($args);
//echo "<h3>Found " . $posts->found_posts . "<br><i style='font-family: -webkit-body;font-size: 0.75em;'>" . substr_replace(trim($filt), "", -1) . "</i></h3>";
?>

<?php /* Start the Loop */ ?>
<?php //query_posts('posts_per_page=10'); ?>
<?php
while ($posts->have_posts()) : $posts->the_post();
  $postType = $post->post_type;
  $postId = $post->ID;
  $postThumb = "";

  $geoRSSPoint = get_post_meta($post->ID, 'geoRSSPoint', true);
  $budget = get_post_meta($post->ID, 'budget', true);
  $leader = get_post_meta($post->ID, 'leaderName', true);
  $org = get_post_meta($post->ID, 'leaderAcronym', true);
  $theme = get_post_meta($post->ID, 'theme', true);
  $geoPoint = str_ireplace(" ", ",", trim($geoRSSPoint));
  $sURL = str_ireplace("http://", "", site_url());
  $sURL = "amkn.org";
  $staticMapURL = "http://maps.google.com/maps/api/staticmap?center=" . $geoPoint . "&zoom=2&size=70x70&markers=icon:http%3A%2F%2F" . $sURL . "%2Fwp-content%2Fthemes%2Famkn_theme%2Fimages%2F" . $post->post_type . "-mini.png|" . $geoPoint . "&maptype=roadmap&sensor=false";
  $tEx = $post->post_excerpt;
  if (strlen($tEx) > 150) {
    $tEx = substr($tEx, 0, 150) . "...";
  }
  $tactivity = $post->post_title;
  if (strlen($tactivity) > 60) {
    $tactivity = substr($tactivity, 0, 60) . "...";
  }

  $args4Countries = array('fields' => 'names');
  $cgMapCountries = wp_get_object_terms($post->ID, 'cgmap-countries', $args4Countries);
  ?>
  <tr onclick="window.location.href = '<?php the_permalink(); ?>';">
    <td>
      <?php echo $tactivity ?>
    </td>    
    <td>
      <?php echo $themes[$theme] ?>
    </td>
    <td>
      <?php echo (!cgValidate($org)) ? $org : ''; ?>
    </td>
  <!--    <td>
    <?php // echo number_format(str_replace(',', '', $budget), 2,',','.')?>
    <?php // echo $budget ?>
    </td>-->
  </tr>
<?php endwhile; ?><!-- end loop-->
</tbody> 
</table>
<?php echo "<p id='results' style=''>Showing <b>" . $posts->found_posts . "</b>  projects matching the search criteria</p>"; ?>
<br clear="all" />
<div class= "clearfix" id="amkn-paginate">
  <?php
  if (function_exists('wp_pagenavi')) {
    wp_pagenavi(array('query' => $posts));
  } else {
    ?>
    <div class="alignleft"><?php next_posts_link('&larr; Previous Entries'); ?></div>
    <div class="alignright"><?php previous_posts_link('Next Entries &rarr;'); ?></div>
  <?php } ?>
</div>
</div>

<div id="tabs-2" style="width:100%">
  <table id="" style="width: 100%">
    <tr>
      <td><div id="chartTheme" style="width:50%;"></div>
      </td>
      <td><div id="chartStatus" style="width:50%;"></div>
      </td> 
    </tr>
  </table>
  <div id="chartLeader" style="width:100%;padding-top: 30px;"></div>
</div>
</div>
</div>
</div>
<script src="<?php echo get_bloginfo('template_url'); ?>/ccafs-sites/libs/highcharts-3.0.5/highcharts.js"></script>

<?php
//  $sql = "SELECT a.meta_value, count(*) FROM $wpdb->posts z INNER JOIN  $wpdb->postmeta a ON (a.post_id = z.ID) $join WHERE a.meta_key = 'theme' GROUP BY a.meta_key ";
$sql = "SELECT a.meta_value, count(*) as total FROM $wpdb->postmeta a WHERE a.meta_key = 'theme' AND a.post_id IN (SELECT ID FROM $wpdb->posts z $join) GROUP BY a.meta_value ";
$chartTheme = $wpdb->get_results($sql);

$sql = "SELECT CASE WHEN a.meta_value > NOW() THEN 'active' WHEN a.meta_value <= NOW() THEN 'closed' END AS status, count(*) as total FROM $wpdb->postmeta a WHERE a.meta_key = 'endDateFilter' AND a.post_id IN (SELECT ID FROM $wpdb->posts z $join) GROUP BY status ";
$chartStatus = $wpdb->get_results($sql);

$sql = "SELECT a.meta_value, count(*) as total FROM $wpdb->postmeta a WHERE a.meta_key = 'leaderAcronym' AND a.post_id IN (SELECT ID FROM $wpdb->posts z $join) AND a.meta_value NOT IN ('RPL EA','RPL LAM','RPL SAs','RPL WA','Theme 1', 'Theme 2', 'Theme 3', 'Theme 4.1', 'Theme 4.2', 'Theme 4.3') GROUP BY a.meta_value ";
$chartLead = $wpdb->get_results($sql);

$rest = "";
$ress = "";
$resl = "";
foreach ($chartTheme as $theme) {
  $rest .= "['" . $themes[$theme->meta_value] . "', " . $theme->total . "],";
}

foreach ($chartStatus as $status) {
  $ress .= "['" . $status->status . "', " . $status->total . "],";
}

foreach ($chartLead as $lead) {
  $resl .= "['" . $lead->meta_value . "', " . $lead->total . "],";
}
//echo "<pre>" . print_r($chartStatus, true) . "</pre>$$$" . $sql;
?>
<script>
    $("#tabs-min").tabs();

    // Build the chart
    $('#chartTheme').highcharts({
      chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        width: 300
      },
      title: {
        text: 'Projects by Theme'
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.y}</b>'
      },
      legend: {
        layout: 'vertical',
      },
      plotOptions: {
        pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          dataLabels: {
            enabled: false
          },
          showInLegend: true
        }
      },
      series: [{
          type: 'pie',
          name: 'Projects',
          data: [
<?php echo $rest ?>
          ]
        }]
    });

    // Build the chart
    $('#chartStatus').highcharts({
      chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        width: 300
      },
      title: {
        text: 'Projects by Status'
      },
      legend: {
        layout: 'vertical'
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.y}</b>'
      },
      plotOptions: {
        pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          dataLabels: {
            enabled: false
          },
          showInLegend: true
        }
      },
      series: [{
          type: 'pie',
          name: 'Projects',
          data: [
<?php echo $ress ?>
          ]
        }]
    });

    // Build the chart
    $('#chartLeader').highcharts({
      chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        width: 600
      },
      title: {
        text: 'Projects by Leader center'
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.y}</b>'
      },
      legend: {
        layout: 'vertical',
        verticalAlign: 'middle',
        align: 'right'
      },
      plotOptions: {
        pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          dataLabels: {
            enabled: false
          },
          showInLegend: true
        }
      },
      series: [{
          type: 'pie',
          name: 'Projects',
          data: [
<?php echo $resl ?>
          ]
        }]
    });
</script>
<?php if ($posts->found_posts == 0): ?>
  <script>
    $("#projectsTable").hide();
  </script>  
<?php endif; ?>

<br clear="all">
<br clear="all">
<script>
  document.getElementById("menu-item-3841").className += ' current-menu-item';
</script>
