<?php

/*
  Plugin Name:AMKN Business Rules
  Plugin URI: http://ictkm.cgiar.org
  Description: AMKN Site Rules
  Author: michaelmarus
  Version: 0.1
  Author URI: http://ictkm.cgiar.org/
  Generated At: ictkm.cgiar.org/;
 */

/*  Copyright 2011  ictkm.cgiar.org  (email : ictkm@cgiar.org)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
include("amkn-options.php");


add_action('pre_get_posts', 'amkn_set_content_query');

function amkn_set_content_query($query) {
  if (!isset($query->query_vars['post_type']) || $query->query_vars['post_type'] == 'post') {
    $query->set('post_type', 'any');
  }
  return $query;
}

function AMKNadd2Robots() {
  echo "\nDisallow: /search/";
  echo "\nDisallow: /mappoints/";
  echo "\nDisallow: /filter/";
  echo "\nDisallow: /wp-admin/";
  echo "\nDisallow: /feed/";
  echo "\nDisallow: /*embed=true";
}

add_action('do_robots', 'AMKNadd2Robots');



// RSS NS AND ADDED CONTENT
add_action('atom_ns', 'amkn_namespace');
add_action('atom_entry', 'amkn_added_entry');
add_action('rss2_ns', 'amkn_namespace');
add_action('rss2_item', 'amkn_added_entry');
add_action('rdf_ns', 'amkn_namespace');
add_action('rdf_item', 'amkn_added_entry');
add_action('rss_ns', 'amkn_namespace');
add_action('rss_item', 'amkn_added_entry');

function amkn_namespace() {
  echo 'xmlns:amkn="http://www.amkn.org/georss"' . "\n";
  echo 'xmlns:georss="http://www.georss.org/georss"' . "\n";
}

function amkn_added_entry() {
  global $post;

  echo "<amkn:PID>" . $post->ID . "</amkn:PID>\n";
  $args2 = array(
    'public' => true,
    '_builtin' => false
  );
//
  if (get_post_meta($post->ID, 'geoRSSPoint', true)) {
    echo "<georss:point>" . get_post_meta($post->ID, 'geoRSSPoint', true) . "</georss:point>\n";
  }
  $excludeTaxonomies = array();
  $output = 'objects'; // or names
  $operator = 'and'; // 'and' or 'or'
  $taxonomies = get_taxonomies($args2, $output, $operator);
  if ($taxonomies) {
    asort($taxonomies);
    foreach ($taxonomies as $taxonomy) {
      $getArgs = array(
        'orderby' => 'name'
      );
      $terms = wp_get_object_terms($post->ID, $taxonomy->name);
      $count = count($terms);
      if ($count > 0 && (!in_array($taxonomy->name, $excludeTaxonomies))) {
        echo "<amkn:" . $taxonomy->name . ">";
        unset($termNames);
        foreach ($terms as $term) {
          $termNames[] = htmlspecialchars($term->name);
        }
        echo join(", ", $termNames) . "</amkn:" . $taxonomy->name . ">\n";
      }
    }
  }
}

add_action('wp_insert_post', 'AMKN_Save');

//add_action('publish_ccafs_sites', 'AMKN_Save');
//add_action('publish_video_testimonials', 'AMKN_Save');
//add_action('publish_amkn_blog_posts', 'AMKN_Save');

function AMKN_Save($postid) {
  global $wpdb;
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return $postid;
  } else {
    if (!get_post_meta($postid, 'processed', true) && get_post_status($postid) != "trash") {
      switch (get_post_type($postid)) {
        case 'video_testimonials':
          $geoPoint = get_post_meta($postid, 'geoRSSPoint', true);
//                        $geoCountry = "
//                        SELECT `slug`
//                        FROM   `TRABARIA_GEO_SPACE`
//                        WHERE trabariaTrueWithin(GeomFromText('POINT(".$geoPoint.")'), `g`);";
//                        $countrySlugA = $wpdb->get_results($geoCountry);
//                        $countrySlug = explode("|",$countrySlugA[0]->slug);
          //wp_set_object_terms( $postid, $countrySlug[0], 'cgmap-countries' );
          //update_post_meta($postid, 'processed', "true");
          $geoPointP = str_ireplace(" ", ",", trim($geoPoint));
          getGeoData($postid, $geoPointP);
          getNearestBMSite($postid);
          update_post_meta($postid, 'processed', "true");
          break;
        case 'amkn_blog_posts':
          $geoPoint = get_post_meta($postid, 'geoRSSPoint', true);
//                        $geoCountry = "
//                        SELECT `slug`
//                        FROM   `TRABARIA_GEO_SPACE`
//                        WHERE trabariaTrueWithin(GeomFromText('POINT(".$geoPoint.")'), `g`);";
//                        $countrySlugA = $wpdb->get_results($geoCountry);
//                        $countrySlug = explode("|",$countrySlugA[0]->slug);
//                        wp_set_object_terms( $postid, $countrySlug[0], 'cgmap-countries' );
          $geoPointP = str_ireplace(" ", ",", trim($geoPoint));
          getGeoData($postid, $geoPointP);
          getNearestBMSite($postid);
          update_post_meta($postid, 'processed', "true");
          break;
        case 'photo_testimonials':
          $geoPoint = get_post_meta($postid, 'geoRSSPoint', true);
//                        $geoCountry = "
//                        SELECT `slug`
//                        FROM   `TRABARIA_GEO_SPACE`
//                        WHERE trabariaTrueWithin(GeomFromText('POINT(".$geoPoint.")'), `g`);";
//                        $countrySlugA = $wpdb->get_results($geoCountry);
//                        $countrySlug = explode("|",$countrySlugA[0]->slug);
//                        wp_set_object_terms( $postid, $countrySlug[0], 'cgmap-countries' );
          $geoPointP = str_ireplace(" ", ",", trim($geoPoint));
          getGeoData($postid, $geoPointP);
          getNearestBMSite($postid);
          update_post_meta($postid, 'processed', "true");
          break;
        case 'photosets':
          $geoPoint = get_post_meta($postid, 'geoRSSPoint', true);
//                        $geoCountry = "
//                        SELECT `slug`
//                        FROM   `TRABARIA_GEO_SPACE`
//                        WHERE trabariaTrueWithin(GeomFromText('POINT(".$geoPoint.")'), `g`);";
//                        $countrySlugA = $wpdb->get_results($geoCountry);
//                        $countrySlug = explode("|",$countrySlugA[0]->slug);
//                        wp_set_object_terms( $postid, $countrySlug[0], 'cgmap-countries' );
          $geoPointP = str_ireplace(" ", ",", trim($geoPoint));
          getGeoData($postid, $geoPointP);
          getNearestBMSite($postid);
          update_post_meta($postid, 'processed', "true");
          break;
        case 'ccafs_activities':
          $geoPoint = get_post_meta($postid, 'geoRSSPoint', true);
          $geoPointP = str_ireplace(" ", ",", trim($geoPoint));
          getGeoData($postid, $geoPointP);
          getNearestBMSite($postid);
          update_post_meta($postid, 'processed', "true");
          break;
        case 'flickr_photos':
          $geoPoint = get_post_meta($postid, 'geoRSSPoint', true);
          $geoCountry = "
                        SELECT `slug`
                        FROM   `TRABARIA_GEO_SPACE`
                        WHERE trabariaTrueWithin(GeomFromText('POINT(" . $geoPoint . ")'), `g`);";
          $countrySlugA = $wpdb->get_results($geoCountry);
          $countrySlug = explode("|", $countrySlugA[0]->slug);
          wp_set_object_terms($postid, $countrySlug[0], 'cgmap-countries');
          update_post_meta($postid, 'processed', "true");
          break;
        case 'biodiv_cases':
          $geoPoint = get_post_meta($postid, 'geoRSSPoint', true);
          $geoPointP = str_ireplace(" ", ",", trim($geoPoint));
          getGeoData($postid, $geoPointP);
          getNearestBMSite($postid);
          update_post_meta($postid, 'processed', "true");
          break;
        case 'ccafs_sites':
          $polyText = get_post_meta($postid, 'posList');
          if ($polyText && $polyText != '') {
            $pArray = explode("\n", trim($polyText[0]));
            $p0 = trim($pArray[0]);
            $p1 = trim($pArray[1]);
            $p2 = trim($pArray[2]);
            $p3 = trim($pArray[3]);
            $strPoly = "
                            SELECT AsText(Centroid(GeomFromText('MultiPolygon(((" . $p0 . "," . $p1 . "," . $p2 . "," . $p3 . "," . $p0 . ")))'))) as CTR;
                            ";
            $geoRSSPointA = $wpdb->get_results($strPoly);
            $geoRSSPoint = str_ireplace("POINT(", "", $geoRSSPointA[0]->CTR);
            $geoRSSPoint = str_ireplace(")", "", $geoRSSPoint);
            update_post_meta($postid, 'geoRSSPoint', $geoRSSPoint);
          } else {
            $geoRSSPoint = get_post_meta($postid, 'geoRSSPoint', true);
          }
          $siteMeta = get_post_meta($postid, 'siteMeta');
          $sMetaArray = explode("|", $siteMeta[0]);
          update_post_meta($postid, 'siteCountry', $sMetaArray[0]);
          update_post_meta($postid, 'siteName', $sMetaArray[1]);
          update_post_meta($postid, 'siteId', $sMetaArray[2]);
          update_post_meta($postid, 'blockName', $sMetaArray[3]);
          update_post_meta($postid, 'blockId', $sMetaArray[4]);

          $geoPointP = str_ireplace(" ", ",", trim($geoRSSPoint));
          getGeoData($postid, $geoPointP);
          getNearestBMSite($postid);

          $geoCountry = "
                        SELECT `slug`
                        FROM   `TRABARIA_GEO_SPACE`
                        WHERE trabariaTrueWithin(GeomFromText('POINT(" . $geoRSSPoint . ")'), `g`);";
          $countrySlugA = $wpdb->get_results($geoCountry);
          $countrySlug = explode("|", $countrySlugA[0]->slug);
          wp_set_object_terms($postid, $countrySlug[0], 'cgmap-countries');
          update_post_meta($postid, 'processed', "true");
          break;
      }
    }
    if (get_post_type($postid) == "ccafs_sites" && !get_post_meta($postid, 'processed', true)) {
      updateAllNearestBMSite();
    }
  }
  $this_dir = dirname(__FILE__);
  rmdir($this_dir . "/tmp");
}

// [esrimap foo="foo-value"]
function esriMapEmbed($atts) {
  $x = WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__), "", plugin_basename(__FILE__));
  extract(shortcode_atts(array(
    'foo' => 'something',
    'bar' => 'something else',
                  ), $atts));
  $embedCode = '

    <link rel="stylesheet" type="text/css" href="http://serverapi.arcgisonline.com/jsapi/arcgis/2.1/js/dojo/dijit/themes/tundra/tundra.css">
    <link rel="stylesheet" type="text/css" href="' . $x . '/map.css">
    <script type="text/javascript">
      var djConfig = {
        parseOnLoad: true
      };
    </script>

    <script type="text/javascript" src="http://serverapi.arcgisonline.com/jsapi/arcgis/?v=2.1compact">
    </script>
    <script type="text/javascript">
      dojo.require("dijit.dijit"); // optimize: load dijit layer
      dojo.require("dijit.layout.BorderContainer");
      dojo.require("dijit.layout.ContentPane");
    </script>
    <script type="text/javascript" src="' . $x . '/layout.js"></script>

    <script>
      //Global Variables
      var proxyUrl, defaultSymbols, popupSize, layout,defaultFields, map, agoId, title, subtitle, bingMapsKey, urlObject, csvStore, dataUrl, dataLayer, symbol, highlightSymbol, highlightGraphic, popupWindow, highlightedNode;

      function init() {

        agoId = "d5e02a0c1f2b4ec399823fdd3c2fdebd";

        dataUrl = "' . $x . '/getCSVData.php";

        defaultFields = ["Location", "latitude", "longitude", "type"];

        defaultInfoTemplate = "${Location}<br /><hr>${Details}";

        title = "Points of Interest";
        //The subtitle, if blank the description of the first layer in the webmap is used.
        subtitle = "Redlands, CA";
        //If the webmap uses Bing Maps data, you will need to provide your bing maps key
        bingMapsKey = "";
        //The size of the popup window
        popupSize = "175,175"
        //The default location of the popup
        layout="left";
        //Uncomment this line if the proxy file is not on the same domain as the application
        //proxyUrl = "/proxy/proxy.ashx";
        //Default colors for the symbols
        defaultSymbols = "rgba(255,0,0,0.75);rgba(0,0,255,0.75)";

        initMap();
      }

      dojo.addOnLoad(init);
    </script>

    <div id="mainWindow" dojotype="dijit.layout.BorderContainer" design="headline"
    gutters="false" style="width:100%; height:100%;">

      <div dojotype="dijit.layout.ContentPane" id="leftPane" region="left">
          <br />
    Layer List : <span id="layer_list"></span><br />
    <br />
        <div id="itemsDiv">
          <ul id="itemsList">
          </ul>
        </div>
      </div>

            <div id="map" class="map" dojotype="dijit.layout.ContentPane" region="center">
            <img id="loadingImg" src="' . $x . '/images/loading.gif" style="position:absolute; right:512px; top:256px; z-index:100; display:none;" />
      </div>


    </div>

';
  return $embedCode;
}

add_shortcode('esrimap', 'esriMapEmbed');

// [esrimapfine0 foo="foo-value"]
function esriMapEmbedFine0($atts) {
  $x = WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__), "", plugin_basename(__FILE__));
  extract(shortcode_atts(array(
    'foo' => 'something',
    'bar' => 'something else',
                  ), $atts));
  $embedCode = '
    <link rel="stylesheet" type="text/css" href="' . $x . 'map.css">
        <script type="text/javascript" src="' . $x . 'map.js"></script>

    <script>
        var dataUrl = "' . get_bloginfo('home') . '/mappoints/";
        var baseDataURL = "' . get_bloginfo('home') . '/mappoints/";
        var defaultFields = ["Location", "Latitude", "Longitude", "Type", "cID"];
        var defaultInfoTemplate = "<iframe src=\'' . get_bloginfo('home') . '/?p=${CID}&embed=true\' width=\'100%\' height=\'680\' frameborder=\'0\' scrolling=\'yes\'></iframe>";
        var titleTemplate = "${Location}";
    </script>
<div id="map" class="map" dojotype="dijit.layout.ContentPane" region="center">
      <div style="position:absolute; right:180px; top:10px; z-Index:999;">
        <div dojoType="dijit.TitlePane" title="Map Controls" closable="false" open="false">
        <div dojoType="dijit.layout.ContentPane" style="width:325px;">
          <a href="javascript:void(0)" onClick="map.setLevel(map.getLevel()+1)">Zoom in</a> |
          <a href="javascript:void(0)" onClick="map.setLevel(map.getLevel()-1)">Zoom out</a>
</div>
          <div id="panel" dojoType="dijit.layout.ContentPane" style="width:325px; height:280px; overflow:scroll;">
          <div id="basemapGallery" ></div></div>
        </div>
      </div>
<img id="loadingImg" src="' . $x . '/images/loading.gif" style="position:absolute; right:512px; top:256px; z-index:100; display:none;" />


</div>
<div id="popupWindow" dojoType="dijit.Dialog" title="Content Window">
    <div id="showContent" style="width: 200px; height: 300px;">

    </div>
</div>
';
  return $embedCode;
}

add_shortcode('esrimapfine0', 'esriMapEmbedFine0');

// [esrimapfine foo="foo-value"]
function esriMapEmbedFine($atts) {
  $x = WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__), "", plugin_basename(__FILE__));
  extract(shortcode_atts(array(
    'foo' => 'something',
    'bar' => 'something else',
                  ), $atts));
  $embedCode = '
<script type="text/javascript" src="' . $x . 'map.js?ver=2"></script>
<script>
    var dataUrl = "' . get_bloginfo('home') . '/mapPoints";
    var baseDataURL = "' . get_bloginfo('home') . '/mappoints/";
    var regionsDataURL = "' . get_bloginfo('home') . '/mapregions/";
    var defaultFields = ["Location", "Latitude", "Longitude", "Type", "cID"];
    var defaultInfoTemplate = "<iframe id=\'ifrm\' class=\'embededO\' src=\'' . get_bloginfo('home') . '/?p=${CID}&embed=true\' width=\'100%\' frameborder=\'0\' scrolling=\'yes\'></iframe>";
    var titleTemplate = "${Type}";
    var initLyrs=[];
</script>
<div id="map" class="map" dojotype="dijit.layout.ContentPane" region="center">
<img id="loadingImg" src="' . $x . 'images/loading2.gif" style="position:absolute; right:512px; top:256px; z-index:100; display:none;" />
</div>

';
  return $embedCode;
}

add_shortcode('esrimapfine', 'esriMapEmbedFine');

// [esrimapfineidentify foo="foo-value"]
function esriMapEmbedFineIdentify($atts) {
  $x = WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__), "", plugin_basename(__FILE__));
  extract(shortcode_atts(array(
    'foo' => 'something',
    'bar' => 'something else',
                  ), $atts));
  $embedCode = '
<script type="text/javascript" src="' . $x . 'map-identify.js"></script>
<script>
    var dataUrl = "' . get_bloginfo('home') . '/mappoints/";
    var baseDataURL = "' . get_bloginfo('home') . '/mappoints/";
    var defaultFields = ["Location", "Latitude", "Longitude", "Type", "cID"];
    var defaultInfoTemplate = "<iframe id=\'ifrm\' class=\'embededO\' src=\'' . get_bloginfo('home') . '/?p=${CID}&embed=true\' width=\'100%\' height=\'630px\' frameborder=\'0\' scrolling=\'yes\'></iframe>";
    var titleTemplate = "${Type}";
</script>
<div id="map" class="map" dojotype="dijit.layout.ContentPane" region="center">
<img id="loadingImg" src="' . $x . '/images/loading.gif" style="position:absolute; right:512px; top:256px; z-index:100; display:none;" />
</div>
<div class="content-box homebox hide" id="legendWindow" title="Data Layers Legend" dojoType="dijit.Dialog" style="width: 750px; height: 450px;">
    <div id="legendDiv" class="hide">
    </div>
</div>
';
  return $embedCode;
}

add_shortcode('esrimapfineidentify', 'esriMapEmbedFineIdentify');

// [getcsvpoints foo="foo-value"]
function esriMapPoints($atts) {

  $postTypes = $_GET["pts"];
  $imp = $_GET["imp"];
  $as = $_GET["as"];
  $ms = $_GET["ms"];
  $cl = $_GET["cl"];
  $ccc = $_GET["ccc"];
  $az = $_GET["az"];

  $impQ = isset($imp) ? explode(",", $imp) : array(0, 1000000);
  $asQ = isset($as) ? explode(",", $as) : array(0, 1000000);
  $msQ = isset($ms) ? explode(",", $ms) : array(0, 1000000);
  $clQ = isset($cl) ? explode(",", $cl) : array(0, 1000000);
  $cccQ = isset($ccc) ? explode(",", $ccc) : array(0, 1000000);
  $azQ = isset($az) ? explode(",", $az) : array(0, 1000000);

  $impO = isset($imp) ? "IN" : "BETWEEN";
  $asO = isset($as) ? "IN" : "BETWEEN";
  $msO = isset($ms) ? "IN" : "BETWEEN";
  $clO = isset($cl) ? "IN" : "BETWEEN";
  $cccO = isset($ccc) ? "IN" : "BETWEEN";
  $azO = isset($az) ? "IN" : "BETWEEN";

  $this_dir = dirname(__FILE__);
  $filename = "mapPoints" . $postTypes . ".csv";
  if (file_exists($this_dir . "/tmp/" . $filename)) {
    $file = fopen($this_dir . "/tmp/" . $filename, "r");
    // read the contents  
    $contents = fread($file, filesize($this_dir . "/tmp/" . $filename));
    fclose($file);  
    echo $contents; 
  } else {
    $qargs = array(
      'post_type' => isset($postTypes) ? explode(",", $postTypes) : array('none'),
      'posts_per_page' => '-1',
      'tax_query' => array(
        'relation' => 'AND',
        array(
          'taxonomy' => 'impacts',
          'field' => 'id',
          'terms' => $impQ,
          'operator' => $impO,
        ),
        array(
          'taxonomy' => 'adaptation_strategy',
          'field' => 'id',
          'terms' => $asQ,
          'operator' => $asO,
        ),
        array(
          'taxonomy' => 'agroecological_zones',
          'field' => 'id',
          'terms' => $azQ,
          'operator' => $azO,
        ),
        array(
          'taxonomy' => 'climate_change_challenges',
          'field' => 'id',
          'terms' => $cccQ,
          'operator' => $cccO,
        ),
        array(
          'taxonomy' => 'mitigation_strategy',
          'field' => 'id',
          'terms' => $msQ,
          'operator' => $msO,
        ),
        array(
          'taxonomy' => 'crops_livestock',
          'field' => 'id',
          'terms' => $clQ,
          'operator' => $clO,
        ),
      )
    );
    $output = '';
    $contentQuery = new WP_Query($qargs);
    $trans = array(" " => ",");
    $output .= 'Latitude,Longitude,Location,CID,Type' . "\n";
    while ($contentQuery->have_posts()) : $contentQuery->the_post();
      $row = get_post_meta($contentQuery->post->ID);
      $tmpGeoPoint = '';
      if ($row['geoRSSPoint']) {
        foreach ($row['geoRSSPoint'] as $key => $value) {
          if (trim($value) != '') {
            $geoPoint = strtr($value, $trans);
            if (($geoPoint && $tmpGeoPoint == '' ) || $geoPoint != $tmpGeoPoint) {
              if ($contentQuery->post->post_type == 'ccafs_activities')
                $output .= $geoPoint . ",\"" . preg_replace('/\s+?(\S+)?$/', '', substr(the_title("", "", false), 0, 60)) . "...|" . implode('#', $row['contactName']) . '|' . implode('#', $row['theme']) . "\",\"" . $contentQuery->post->ID . "\",\"" . $contentQuery->post->post_type . "\"" . "\n";
              else if ($contentQuery->post->post_type == 'ccafs_sites')
                $output .= $geoPoint . ",\"" . preg_replace('/\s+?(\S+)?$/', '', the_title("", "", false)) . "|" . $row['siteId'][0] . "|" . $row['siteCountry'][0] . "\",\"" . $contentQuery->post->ID . "\",\"" . $contentQuery->post->post_type . "\"" . "\n";
              else
                $output .= $geoPoint . ",\"" . preg_replace('/\s+?(\S+)?$/', '', substr(the_title("", "", false), 0, 80)) . "...|" . get_the_date() . "\",\"" . $contentQuery->post->ID . "\",\"" . $contentQuery->post->post_type . "\"" . "\n";
            }
            $tmpGeoPoint = $geoPoint;
          }
        }
      }
//  $geoPoint=strtr(get_post_meta($contentQuery->post->ID, 'geoRSSPoint', true), $trans);
//  if($geoPoint) {
//    echo $geoPoint.",\"".the_title( "", "", false )."\",\"".$contentQuery->post->ID."\",\"".$contentQuery->post->post_type."\"" . "\n";
//  }
//    else
//    {
//         echo "NP".",\"".the_title( "", "", false )."\",\"".$contentQuery->post->ID."\",\"".$contentQuery->post->post_type."\"" . "\n";
//
//    }
    endwhile;
    echo $output;
    mkdir($this_dir . "/tmp", 0700);
    $file = fopen($this_dir . "/tmp/" . $filename, "w+");
    fwrite($file, $output);
    fclose($file);
    wp_reset_postdata();
  }
}

function combinatoria($items, $size) {
//  $items = explode(',',$string);
//  echo count($items);
  if ($size <= 0) {
    echo '<br>';
  } else {
    foreach ($items as $key => $item) {
      echo $item . ', ';
      unset($items[$key]);
      combinatoria($items, $size - 1);
    }
  }
}

add_shortcode('getcsvpoints', 'esriMapPoints');

function esriMapRegions($atts) {
  $qargs = array(
//        'post_type' => array('ccafs_activities'),
    'posts_per_page' => '-1');
  $contentQuery = new WP_Query($qargs);
  $trans = array(" " => ",");
  echo 'Regions,Location,CID,Type' . "\n";
  while ($contentQuery->have_posts()) {
    $contentQuery->the_post();
    $row = get_post_meta($contentQuery->post->ID);
    $tmpGeoPoint = '';
    if ($row['countryLocationName']) {
      foreach ($row['countryLocationName'] as $key => $value) {
        $geoPoint = $value;
        if (($geoPoint && $tmpGeoPoint == '' ) || $geoPoint != $tmpGeoPoint) {
          if ($contentQuery->post->post_type == 'ccafs_activities')
            echo "\"" . $geoPoint . "\",\"" . preg_replace('/\s+?(\S+)?$/', '', substr(the_title("", "", false), 0, 60)) . "...|" . implode('#', $row['contactName']) . '|' . implode('#', $row['theme']) . "\",\"" . $contentQuery->post->ID . "\",\"" . $contentQuery->post->post_type . "\"" . "\n";
          else
            echo "\"" . $geoPoint . "\",\"" . preg_replace('/\s+?(\S+)?$/', '', substr(the_title("", "", false), 0, 80)) . "...\",\"" . $contentQuery->post->ID . "\",\"" . $contentQuery->post->post_type . "\"" . "\n";
        }
        $tmpGeoPoint = $geoPoint;
      }
    }
  }
}

add_shortcode('getcsvregions', 'esriMapRegions');

function ccafsSitesGeojson() {

  $regions = explode(',', $_GET["rgs"]);
  $meta = array();
  if (count($regions)) {
    $meta = array('realtion' => 'OR');
//  foreach($regions as $region){
    $meta[] = array('key' => 'ccafs_region', 'value' => $regions);
//  }
  }
//$meta = array('realtion' => 'OR', array('key' => 'ccafs_region', 'value' => 'East Africa'), array('key' => 'ccafs_region', 'value' => 'South Asia'));
  $qargs = array(
    'post_type' => 'ccafs_sites',
    'posts_per_page' => '-1',
    'orderby' => 'meta_value',
    'order' => 'ASC',
    'meta_key' => 'ccafs_region'
  );
  if (count($meta)) {
    $args = array_merge(array('meta_query' => $meta), $qargs);
  } else {
    $args = array(
      'post_type' => 'none'
    );
  }
//print_r($args);
  $contentQuery = new WP_Query($args);
  $trans = array(" " => ",");
  echo 'eqfeed_callback({ "type": "FeatureCollection",
          "features": [';
  while ($contentQuery->have_posts()) {
    $contentQuery->the_post();
    $countPosts = nearestPosts($contentQuery->post->ID);
    $row = get_post_meta($contentQuery->post->ID);
    $tmpGeoPoint = '';
    if ($row['geoRSSPoint']) {
      foreach ($row['geoRSSPoint'] as $key => $value) {
        if ($value != '') {
          $geoPoint = explode(' ', $value);
          if (($geoPoint && $tmpGeoPoint == '' ) || $geoPoint != $tmpGeoPoint) {
            echo '
             { "type": "Feature",
              "id": "' . $contentQuery->post->ID . '",
              "geometry": {"type": "Point", "coordinates": [' . $geoPoint[1] . ', ' . $geoPoint[0] . ']},
              "properties": {
                "title": "' . preg_replace('/\s+?(\S+)?$/', '', the_title("", "", false)) . '", '
            . '"country":"' . $row['siteCountry'][0] . '", '
            . '"region":"' . $row['ccafs_region'][0] . '",'
            . '"photos":"' . $countPosts['p'] . '",'
            . '"blogs":"' . $countPosts['b'] . '",'
            . '"activities":"' . $countPosts['a'] . '",'
            . '"videos":"' . $countPosts['v'] . '"'
            . '}
             }, 
            ';
//              echo $geoPoint.",\"".preg_replace('/\s+?(\S+)?$/', '', the_title( "", "", false ))."|".$row['siteId'][0]."|".$row['siteCountry'][0]."\",\"".$contentQuery->post->ID."\",\"".$contentQuery->post->post_type."\"" . "\n";            
          }
          $tmpGeoPoint = $geoPoint;
        }
      }
    }
  }
  echo ']
     });';
  wp_reset_postdata();
}

add_shortcode('getGeojson', 'ccafsSitesGeojson');

function nearestPosts($siteId) {
  $args = array(
    'post_type' => array('ccafs_activities', 'video_testimonials', 'amkn_blog_posts', 'photo_testimonials'),
    'posts_per_page' => '-1',
    'order' => 'ASC',
    'meta_query' => array(array('key' => 'nearestBenchmarkSite', 'value' => $siteId))
  );
  $count['a'] = 0;
  $count['v'] = 0;
  $count['p'] = 0;
  $count['b'] = 0;
  $contentQuery = new WP_Query($args);
  foreach ($contentQuery->posts as $post) {
    switch ($post->post_type) {
      case "ccafs_activities":
        $count['a'] ++;
        break;
      case "video_testimonials":
        $count['v'] ++;
        break;
      case "amkn_blog_posts":
        $count['b'] ++;
        break;
      case "photo_testimonials":
        $count['p'] ++;
        break;
    }
//    $count++;
  }
  return $count;
}

//add_filter('wp_loaded','flushRules');
//
//// Remember to flush_rules() when adding rules
//function flushRules(){
//	global $wp_rewrite;
//        $wp_rewrite->add_rewrite_tag("%standalone%", '([0-9]+)', "standalone=");
//   	$wp_rewrite->flush_rules();
//}
//
//
//
//add_action('admin_init', 'flush_rewrite_rules');

function applyAMKNHTML() {
  global $current_user;
  get_currentuserinfo();
  if ($currUserLog->roles[0] == "Administrator") {
    ?>
    <script type="text/javascript">
      //<![CDATA[

      //jQuery("#postcustom").hide();
      jQuery('#postcustom').toggleClass("closed");

      //    jQuery(function(){
      //        if(jQuery('input[value="content_description"]').attr("id") != undefined){
      //         wysyFieldId = jQuery('input[value="content_description"]').attr("id").replace("key", "value")
      //         jQuery('textarea[name="'+wysyFieldId+'"]').addClass("theEditor");
      //         jQuery('textarea[name="'+wysyFieldId+'"]').append("<div>Content Description</div><br />");
      //         tinyMCE.init(tinyMCEPreInit.mceInit);
      //        }else{
      //         jQuery('#enternew').click();
      //         jQuery('#metakeyinput').val("content_description");
      //         jQuery('#metavalue').addClass("theEditor");
      //         tinyMCE.init(tinyMCEPreInit.mceInit);
      //        }
      //    });

      //]]>
    </script>



    <?php

  }
}

if ($pagenow == "post.php" || $pagenow == "post-new.php") {
  $addDesc = array("ccafs_sites", "video_testimonials", "amkn_blog_posts", "climate_change_projects", "photo_testimonials", "flickr_photos");
  if ((isset($_REQUEST['post_type']) && in_array($_REQUEST['post_type'], $addDesc)) || (isset($_REQUEST['post']) && in_array(get_post_type($_REQUEST['post']), $addDesc))) {
    add_action('admin_footer', 'applyAMKNHTML');
  }
}

function getGeoData($pID, $geoPT) {
  $xml = simplexml_load_file("http://maps.googleapis.com/maps/api/geocode/xml?latlng=" . $geoPT . "&sensor=false");
  $village = $xml->xpath("//address_component[type='locality']/long_name");
  $city = $xml->xpath("//address_component[type='administrative_area_level_2']/long_name");
  $country = $xml->xpath("//address_component[type='country']/short_name");
  $area = $xml->xpath("//address_component[type='administrative_area_level_1']/long_name");

  update_post_meta($pID, 'village', (string) $village[0]);
  update_post_meta($pID, 'city', (string) $city[0]);
  update_post_meta($pID, 'area', (string) $area[0]);
  wp_set_object_terms($pID, trabaria_get_country_slug((string) $country[0]), 'cgmap-countries');
}

function updateAllNearestBMSite() {
  $args = array('numberposts' => -1, 'post_status' => 'publish');
  $amknObjs = get_posts($args);
  if ($amknObjs) {
    foreach ($amknObjs as $amknObj) {
      if ($amknObj->post_type != "ccafs_sites") {
        getNearestBMSite($amknObj->ID);
      }
    }
  }
}

function getNearestBMSite($pID) {
  global $wpdb;
  global $post;
  $geoPoints = get_post_meta($pID, 'geoRSSPoint');
  $destLat = "";
  $destLon = "";
  $nearestSiteID = "";
  $nearestSiteIDs = "";
  $querystr = "
        SELECT wposts.ID, wpostmeta.meta_value
        FROM $wpdb->posts wposts
	LEFT JOIN $wpdb->postmeta wpostmeta ON wposts.ID = wpostmeta.post_id

        WHERE wpostmeta.meta_key = 'geoRSSPoint'
                AND wposts.post_type = 'ccafs_sites'
                AND wposts.post_status = 'publish'
        ";
  delete_post_meta($pID, 'nearestBenchmarkSite');
  delete_post_meta($pID, 'distances');
  foreach ($geoPoints as $geoPoint) {
    $shortDistance = 0;
    $geoPointP = trim($geoPoint);
    if ($geoPointP) {
      $pCoords = explode(" ", $geoPointP);
      $orgLat = $pCoords[0];
      $orgLon = $pCoords[1];
      $bmSites = $wpdb->get_results($querystr, OBJECT);
      foreach ($bmSites as $bmSite) {
        $bPoint = trim($bmSite->meta_value);
        $sCoords = explode(" ", $bPoint);
        $destLat = $sCoords[0];
        $destLon = $sCoords[1];
        $geoBMSiteT = "
    SELECT (3956 * 2 * ASIN(SQRT(POWER(SIN((" . $orgLat . " - abs(" . $destLat . ")) * pi()/180 / 2), 2) + COS(" . $orgLat . " * pi()/180 ) * COS(abs(" . $destLat . ") * pi()/180) * POWER(SIN((" . $orgLon . " - " . $destLon . ") * pi()/180 / 2), 2) ))) as dista;                
    ";

        $rGeoDist = $wpdb->get_results($geoBMSiteT);
        //$shortDistance
        if ($geoPointP == trim($bPoint)) {
          $nearestSiteID = $bmSite->ID;
        } else {
          if ($shortDistance == 0 || $rGeoDist[0]->dista < $shortDistance) {
            $shortDistance = $rGeoDist[0]->dista;
            $nearestSiteID = $bmSite->ID;
          }
//        echo $rGeoDist[0]->dist." | ";
//        echo $bmSite->ID." | ".$geoPointP.",".$bPoint;
//        echo "<br>";                   
        }
      }
      add_post_meta($pID, 'distances', $shortDistance);
      add_post_meta($pID, 'nearestBenchmarkSite', $nearestSiteID);
    }
  }
}
?>