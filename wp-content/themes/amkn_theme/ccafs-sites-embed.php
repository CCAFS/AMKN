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
Template Name: CCAFS sites embed
*/
$height = 420;
$width = 600;
if($_GET['height'])
  $height = $_GET['height'];
if($_GET['width'])
  $width = $_GET['width'];
?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
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
    // Create a script tag and set the USGS URL as the source.
//          if(!location.hash)

    rgs = 'East%20Africa,West%20Africa,South%20Asia,Southeast%20Asia,Latin%20America';
    var script = document.createElement('script');
    script.src = '<?php bloginfo('url'); ?>/sitesgeojson/?rgs='+rgs;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(script, s);        
  }

  window.eqfeed_callback = function(results) {
    var image = "<?php bloginfo('template_directory'); ?>/images/ccafs_sites-miniH.png";          
    var infowindow;
    for (var i = 0; i < results.features.length; i++) {
      idx = i;
      var coords = results.features[i].geometry.coordinates;
      var latLng = new google.maps.LatLng(coords[1], coords[0]);
      var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        icon: image,
        title: results.features[i].properties.title
      });

      markerArray[results.features[i].id] = marker;
//            google.maps.event.addListener(marker, 'click', function(event) {alert(results.features[idx].properties.title)});
      google.maps.event.addListener(marker,'mouseover', (function(marker,i,results){
        return function() {
          if(infowindow){
              eval(infowindow).close();
          }
//          $("div#"+results.features[i].id).addClass("ccafs_sites_selected").siblings().removeClass("ccafs_sites_selected");  
//          $('#sites').scrollTo($("div#"+results.features[i].id), 500,{offset: {top:-135, left:0}});
          var contentString = 
                        '<div id="content"><b>' + results.features[i].properties.title + ' [' + results.features[i].properties.country + '] </b><br>CCAFS Region: ' + results.features[i].properties.region
                        + '<br>'
                        + '<img src="<?php bloginfo('template_directory'); ?>/images/ccafs_activities-mini.png" class="gmap"/> Projects: ' + results.features[i].properties.activities+''
                        + '<br><img src="<?php bloginfo('template_directory'); ?>/images/amkn_blog_posts-mini.png" class="gmap"/> Blogs: ' + results.features[i].properties.blogs+''
                        + '<br><img src="<?php bloginfo('template_directory'); ?>/images/photo_testimonials-mini.png" class="gmap"/> Photos: ' + results.features[i].properties.photos+''
                        + '<br><img src="<?php bloginfo('template_directory'); ?>/images/video_testimonials-mini.png" class="gmap"/> Videos: ' + results.features[i].properties.videos + ''
                        + '</div>';
          infowindow = new google.maps.InfoWindow({
              content: contentString
          });
           infowindow.open(map,marker);
        };
      })(marker,i,results));

      google.maps.event.addListener(marker,'click', (function(i,results){
        return function() {
          window.open("./?p="+results.features[i].id+"&embedded=1","_blank","scrollbars=yes, resizable=yes, top=20, left=60, width=975, height=670");
        };
      })(i,results));
      google.maps.event.addListener(map, "click", function(){
        infowindow.close();
      });
    }
  }

  function openDialog (marker) {
    google.maps.event.trigger(marker, 'dblclick');
  }

  function updateMap () {
    var script = document.createElement('script');
    script.src = 'http://amkn.local/sitesgeojson/?rgs=East%20Africa';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(script, s);
    google.maps.event.trigger(map, 'resize');
  }
  google.maps.event.addDomListener(window, 'load', initialize);
</script>
<div style="height: <?php echo $height?>px; width: <?php echo $width?>px;" id="map-canvas"></div>