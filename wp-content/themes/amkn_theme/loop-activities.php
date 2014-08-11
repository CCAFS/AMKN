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
$metaKey = array();
$orderby = array();
$order = 'ASC';
$filt = '';
$themes = array('1' => 'Adaptation to Progressive Climate Change', '2' => 'Adaptation through Managing Climate Risk', '3' => ' Pro-Poor Climate Change Mitigation', '4.1' => ' Linking Knowledge to Action', '4.2' => 'Data and Tools for Analysis and Planning', '4.3' => 'Policies and Institutions');
if ($_GET['order'] == 'true') {
  $order = 'DESC';
}
if (isset($_GET['view'])) {
  if ($_GET['view'] == 'true') {
    $metaKey[] = array('key' => 'endDateFilter', 'value' => date('Ymd'), 'compare' => '>');
    $filt .='Ongoing projects<br>';
  } else {
    $metaKey[] = array('key' => 'endDateFilter', 'value' => date('Ymd'), 'compare' => '<=');
    $filt .='Past projects<br>';
  }
}
if ($_GET['leader'] != '0' && $_GET['leader'] != '') {
  $metaKey[] = array('key' => 'leaderAcronym', 'value' => $_GET['leader']);
  $filt .='CG Center ' . $_GET['leader'] . '<br>';
}
if ($_GET['theme'] != '0' && $_GET['theme'] != '') {
  $metaKey[] = array('key' => 'theme', 'value' => $_GET['theme']);
  $filt .='Topic ' . $themes[$_GET['theme']] . '<br>';
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

if ($_GET['keyword'] != '0' && $_GET['keyword'] != '') {
  $args['s'] = $_GET['keyword'];
  $filt .='Keyword ' . $_GET['keyword'] . '<br>';
}
//echo "<pre>".print_r($metaKey,true)."</pre>";
$posts = new WP_Query($args);
echo "<h3>Found " . $posts->found_posts . "<br><i style='font-family: -webkit-body;font-size: 0.75em;'>" . substr_replace(trim($filt), "", -1) . "</i></h3>";
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
<?php if ($posts->found_posts == 0): ?>
  <script>
    $("#myTable").hide();
  </script>  
<?php endif; ?>
<br clear="all" />
<div id="amkn-paginate">
  <?php
  if (function_exists('wp_pagenavi')) {
    wp_pagenavi(array('query' => $posts));
  } else {
    ?>
    <div class="alignleft"><?php next_posts_link('&larr; Previous Entries'); ?></div>
    <div class="alignright"><?php previous_posts_link('Next Entries &rarr;'); ?></div>
  <?php } ?>
</div>
<br clear="all">
<br clear="all">
<script>
  document.getElementById("menu-item-3841").className += ' current-menu-item';
</script>
