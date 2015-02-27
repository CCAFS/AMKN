<?php
/*
 * Copyright (C) 2015 CRSANCHEZ
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
  Template Name: CCAFS sites full embed
 */
//require('../../../wp-load.php');
//$args = $query_string . '&posts_per_page=16&order=ASC&orderby=meta_value&meta_key=ccafs_region';
//$args = array_merge($dateArg, array(
//'post_type' => get_query_var('post_type'),
// 'orderby' => 'meta_value',
// 'order' => 'ASC',
// 'posts_per_page' => '16',
// 'meta_key' => 'ccafs_region'
//));
//$regions = $_GET["region"];
$meta = array();
//if (count($regions) && $regions != 'all') {
//$meta = array('realtion' => 'OR');
////  foreach($regions as $region){
//$meta[] = array('key' => 'ccafs_region', 'value' => $regions);
////  }
//}
////$meta = array('realtion' => 'OR', array('key' => 'ccafs_region', 'value' => 'East Africa'), array('key' => 'ccafs_region', 'value' => 'South Asia'));
//$qargs = array(
//'post_type' => 'ccafs_sites',
// 'posts_per_page' => '-1',
// 'orderby' => 'meta_value',
// 'order' => 'ASC',
// 'meta_key' => 'ccafs_region'
//);
//if (count($meta)) {
//$args = array_merge(array('meta_query' => $meta), $qargs);
//} else {
//$args = array(
//'post_type' => 'ccafs_sites',
// 'posts_per_page' => '-1',
// 'orderby' => 'meta_value',
// 'order' => 'ASC',
// 'meta_key' => 'ccafs_region'
//);
//}
$args = array(
'post_type' => 'ccafs_sites',
 'posts_per_page' => '-1',
 'orderby' => 'meta_value',
 'order' => 'ASC',
 'meta_key' => 'ccafs_region'
);
$posts = new WP_Query($args);
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/style.css">
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.4.2/pure-min.css">
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.scrollTo.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js"></script>
<script>
  var map;
  var markerArray = {};
  function initialize() {
    var myLatlng = new google.maps.LatLng(12.968888, 10.138147);
    var mapOptions = {
      zoom: 2,
      center: myLatlng
    }
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    rgs = 'East%20Africa,West%20Africa,South%20Asia,Southeast%20Asia,Latin%20America';
    var script = document.createElement('script');
    script.src = '<?php bloginfo('url'); ?>/sitesgeojson/?rgs=' + rgs;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(script, s);

    google.maps.event.addListener(map, "center_changed", function() {
      filterPanel();
    });
  }

  window.eqfeed_callback = function(results) {
    var image = "<?php bloginfo('template_directory'); ?>/images/ccafs_sites-miniH.png";
    var infobox;
    var markeri = new google.maps.Marker();
    for (var i = 0; i < results.features.length; i++) {
      idx = i;
      var coords = results.features[i].geometry.coordinates;
      var latLng = new google.maps.LatLng(coords[1], coords[0]);
      var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        icon: image
                //              title: results.features[i].properties.title
      });

      markerArray[results.features[i].id] = marker;
      //            google.maps.event.addListener(marker, 'click', function(event) {alert(results.features[idx].properties.title)});
      google.maps.event.addListener(marker, 'mouseover', (function(marker, i, results) {
        return function() {
          if (infobox) {
            eval(infobox).close();
          }
          if (markeri) {
            eval(markeri).setMap(null);
          }
          $("div#" + results.features[i].id).addClass("ccafs_sites_selected").siblings().removeClass("ccafs_sites_selected");
          $('#sites').scrollTo($("div#" + results.features[i].id), 100, {offset: {top: -135, left: 0}});
          var contentString = infoWindowContent(results.features[i]);
          infobox = getBox(contentString);
          infobox.open(map, marker);
          google.maps.event.addListener(infobox, "closeclick", function() {
            markeri.setMap(null);
          });
          var imagei = "<?php bloginfo('template_directory'); ?>/images/ccafs_sites-miniI.png";
          var coords = results.features[i].geometry.coordinates;
          var latLng = new google.maps.LatLng(coords[1], coords[0]);
          markeri = new google.maps.Marker({
            position: latLng,
            map: map,
            zIndex: 9999999,
            icon: imagei
          });
          google.maps.event.addListener(markeri, 'click', (function(i, results) {
            return function() {
              window.open("./?p=" + results.features[i].id + "&embedded=1", "_blank", "scrollbars=yes, resizable=yes, top=20, left=60, width=1065, height=670");
            };
          })(i, results));
        };
      })(marker, i, results));

      google.maps.event.addListener(marker, 'dblclick', (function(marker, i, results) {
        return function() {
          if (infobox) {
            eval(infobox).close();
          }
          if (markeri) {
            eval(markeri).setMap(null);
          }
          $("div#" + results.features[i].id).addClass("ccafs_sites_selected").siblings().removeClass("ccafs_sites_selected");
          var contentString = infoWindowContent(results.features[i]);
          infobox = getBox(contentString);
          infobox.open(map, marker);
          google.maps.event.addListener(infobox, "closeclick", function() {
            markeri.setMap(null);
          });
          var imagei = "<?php bloginfo('template_directory'); ?>/images/ccafs_sites-miniI.png";
          var coords = results.features[i].geometry.coordinates;
          var latLng = new google.maps.LatLng(coords[1], coords[0]);
          markeri = new google.maps.Marker({
            position: latLng,
            map: map,
            zIndex: 9999999,
            icon: imagei
          });
        };
      })(marker, i, results));

      google.maps.event.addListener(map, "click", function() {
        infobox.close();
        markeri.setMap(null);
      });
    }
  }

  function infoWindowContent(result) {
    return '<div class="gmap" id="content"><b>' + result.properties.title + ' [' + result.properties.country + '] </b><br>CCAFS Region: ' + result.properties.region
                  + '<br>'
                  + '<img src="<?php bloginfo('template_directory'); ?>/images/ccafs_activities-mini.png"/> Projects: ' + result.properties.activities + ''
                  + '<br><img src="<?php bloginfo('template_directory'); ?>/images/amkn_blog_posts-mini.png"/> Blogs: ' + result.properties.blogs + ''
                  + '<br><img src="<?php bloginfo('template_directory'); ?>/images/photo_testimonials-mini.png" /> Photos: ' + result.properties.photos + ''
                  + '<br><img src="<?php bloginfo('template_directory'); ?>/images/video_testimonials-mini.png" /> Videos: ' + result.properties.videos + ''
                  + '</div>';
  }

  function getBox(contentString) {
    return new InfoBox({
      content: contentString,
      disableAutoPan: false,
      maxWidth: 150,
      pixelOffset: new google.maps.Size(-140, 0),
      zIndex: null,
      boxStyle: {
        background: "url('<?php bloginfo('template_directory'); ?>/images/tipbox1.gif') no-repeat",
        width: "200px"
      },
      closeBoxMargin: "12px 4px 2px 2px",
      closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
      infoBoxClearance: new google.maps.Size(1, 1)
    });
  }

  function openDialog(marker) {
    google.maps.event.trigger(marker, 'dblclick');
  }

  function filterMap(rgs) {
    var myLatlng;
    var zoom = 4;
    if (rgs == 'East Africa') {
      myLatlng = new google.maps.LatLng(-0.314705, 35.022805);
    } else if (rgs == 'West Africa') {
      myLatlng = new google.maps.LatLng(13.3686965, -5.762451);
    } else if (rgs == "Latin America") {
      myLatlng = new google.maps.LatLng(15.2, -87.883333);
    } else if (rgs == 'Southeast Asia') {
      myLatlng = new google.maps.LatLng(21.033333, 105.85);
    } else if (rgs == 'South Asia') {
      myLatlng = new google.maps.LatLng(27.5446255, 83.4506495);
    } else if (rgs == 'all') {
      myLatlng = new google.maps.LatLng(12.968888, 10.138147);
      zoom = 2;
      rgs = 'ccafs_sites';
    }
    map.setZoom(zoom);
    map.panTo(myLatlng);
  }

  function filterPanel() {
    $(".ccafs_sites").css("display", "none");
    $.each(markerArray, function(i, val) {
      if (map.getBounds().contains(val.getPosition())) {
        $("#" + i).css("display", "block");
      }
    });
  }
  google.maps.event.addDomListener(window, 'load', initialize);
</script>
<?php
//        print_r($_GET['region']);
$checkOng = 'checked';
?>
<div id="container" style='background-color: white'>
  <div class="content">
    <!--<h2 class="title">Research Sites</h2>-->
    <form class="pure-form pure-form-stacked" name ="search-sources" id ="search-sources" method="get">
      <fieldset>
        <legend>Filter By CCAFS Region</legend>                      
        <div class="pure-g">
          <div class="pure-u-1-6">
            <label for="space">
              &nbsp;
            </label>
            <label for="remember">
              <input id="ong" name="region" onchange="filterMap(this.value)" type="radio" value="all" <?php echo (!isset($_GET['region']) || $_GET['region'] == 'all') ? 'checked' : '' ?>>Show all
            </label>
          </div>
          <div class="pure-u-1-6">
            <label for="space">
              &nbsp;
            </label>
            <label for="remember">
              <input id="ong" name="region" onchange="filterMap(this.value)" type="radio" value="East Africa" <?php echo ($_GET['region'] == 'East Africa') ? 'checked' : '' ?>>East Africa
            </label>
          </div>
          <div class="pure-u-1-6">
            <label for="space">
              &nbsp;
            </label>
            <label for="remember">
              <input id="ong" name="region" onchange="filterMap(this.value)" type="radio" value="West Africa" <?php echo ($_GET['region'] == 'West Africa') ? 'checked' : '' ?>>West Africa
            </label>
          </div>
          <div class="pure-u-1-6">
            <label for="space">
              &nbsp;
            </label>
            <label for="remember">
              <input id="ong" name="region" onchange="filterMap(this.value)" type="radio" value="Latin America" <?php echo ($_GET['region'] == 'Latin America') ? 'checked' : '' ?>>Latin America
            </label>
          </div>
          <div class="pure-u-1-6">
            <label for="space">
              &nbsp;
            </label>
            <label for="remember">
              <input id="ong" name="region" onchange="filterMap(this.value)" type="radio" value="Southeast Asia" <?php echo ($_GET['region'] == 'Southeast Asia') ? 'checked' : '' ?>> Southeast Asia 
            </label>
          </div>
          <div class="pure-u-1-6">
            <label for="space">
              &nbsp;
            </label>
            <label for="remember">
              <input id="ong" name="region" onchange="filterMap(this.value)" type="radio" value="South Asia" <?php echo ($_GET['region'] == 'South Asia') ? 'checked' : '' ?>>South Asia
            </label>
          </div>
        </div>            
      </fieldset>        
    </form>
    <!--<button id="search" class="pure-button pure-button-primary" onclick="updateMap()">Test</button>-->
    <div style="height: 400px; width: 67%;float:left;margin-bottom: 20px" id="map-canvas"></div>
    <div id="sites" style="height: 400px; width: 33%;float:left; overflow: scroll;margin-bottom: 20px;background: #F5F5F5;overflow-x: auto">
      <?php
      while ($posts->have_posts()) : $posts->the_post();
      $postType = $post->post_type;
      $postId = $post->ID;
      $postThumb = "";
      $region = get_post_meta($post->ID, 'ccafs_region', true);
      ?>
      <div id="<?php echo $post->ID ?>" class="<?php echo $postType." ".str_replace(' ', '', $region); ?>" onmouseover="openDialog(markerArray[<?php echo $post->ID ?>])">
        <?php
        $geoRSSPoint = get_post_meta($post->ID, 'geoRSSPoint', true);
        $sideId = get_post_meta($post->ID, 'siteId', true);
        $blockName = get_post_meta($post->ID, 'blockName', true);
        $geoPoint = str_ireplace(" ", ",", trim($geoRSSPoint));
        $sURL = str_ireplace("http://", "", site_url());
        $sURL = "amkn.org";
//    $staticMapURL = "http://maps.google.com/maps/api/staticmap?center=".$geoPoint."&zoom=4&size=70x70&markers=icon:http%3A%2F%2F".$sURL."%2Fwp-content%2Fthemes%2Famkn_theme%2Fimages%2F".$post->post_type."-mini.png|".$geoPoint."&maptype=roadmap&sensor=false";
        $tEx = $post->post_excerpt;
        if (strlen($tEx) > 75) {
        $tEx = trim_text($tEx, 75);
        }
        $args4Countries = array('fields' => 'names');
        $cgMapCountries = wp_get_object_terms($post->ID, 'cgmap-countries', $args4Countries);
        $country = get_post_meta($post->ID, 'siteCountry', true);
        $village = get_post_meta($post->ID, 'village', true);
        $city = get_post_meta($post->ID, 'city', true);
        $area = get_post_meta($post->ID, 'area', true);
        $overview = get_post_meta($post->ID, 'Overview', true);
        if ($village)
        $showLocality = $village;
        else if ($city)
        $showLocality = $city;
        else
        $showLocality = $area;
        ?>
        <div class="">
          <img class="videotitleico" src="<?php bloginfo('template_directory'); ?>/images/<?php echo $postType; ?>-mini.png" alt="Benchmark site"/> 
          <h2 class="teasertitle"><a href="javascript:window.open('./?p=<?php the_ID()?>&embedded=1','_blank','scrollbars=yes, resizable=yes, top=20, left=60, width=1065, height=670');"><?php the_title(); ?> [<?php echo $country; ?>]</a></h2>
          <p>
            <span class="sidemap-labels">Town:</span> <?php echo $showLocality."."; ?><br>
            <span class="sidemap-over"><?php echo $overview ?></span>
          </p>         
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
</div>
