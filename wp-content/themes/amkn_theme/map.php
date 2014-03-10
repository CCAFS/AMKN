<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
?>


<script type="text/javascript">
var dynMapOv = null;
  function initialize() {
    var myLatlng = new google.maps.LatLng(10.746969, 37.792969);
    var myOptions = {
      zoom: 3,
      center: myLatlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    var map = new google.maps.Map(document.getElementById("map"), myOptions);

    var dynamicMap = new esri.arcgis.gmaps.DynamicMapServiceLayer("http://184.73.156.57/ArcGIS/rest/Services/1012_CGIAR_OJE/AMKN/FeatureServer/3", null, 0.75, dynmapcallback);
          
  }
function dynmapcallback(groundov) {
  //Add groundoverlay to map using gmap.addOverlay()
  map.addOverlay(groundov);
  dynMapOv = groundov;
  alert(dynMapOv);
}
function loadScript() {
    detectBrowser();
  var script = document.createElement("script");
  script.type = "text/javascript";
  script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=initialize";
  document.body.appendChild(script);

  var script2 = document.createElement("script");
  script2.type = "text/javascript";
  script2.src = "http://serverapi.arcgisonline.com/jsapi/gmaps/?v=1.6";
  document.body.appendChild(script2);
}

function detectBrowser() {
  var useragent = navigator.userAgent;
  var mapdiv = document.getElementById("map");

  if (useragent.indexOf('iPhone') != -1 || useragent.indexOf('Android') != -1 ) {
    mapdiv.style.width = '100%';
    mapdiv.style.height = '100%';
  }
}
window.onload = loadScript;
</script>

<div class="tags"><a href="#"><img src="<?php bloginfo( 'template_directory' ); ?>/images/explore.png" alt="Explore with tag" /></a></div>

<div class="tags_body">
<ul>
<li><a href="#">Lorem Ipsum</a></li>
<li><a href="#">Dolor sit</a></li>
<li><a href="#">Amet Adipisci</a></li>
<li><a href="#">sed do eiusmod</a></li>
<li><a href="#">on proident</a></li>
<li><a href="#">vitae dicta</a></li>
<li><a href="#">Etiam Vivamque</a></li>
<li><a href="#">Deinde</a></li>
<li><a href="#">Ullam Corporis</a></li>
<li><a href="#">reprehenderit</a></li>
<li><a href="#">Ratione reconducta</a></li>
<li><a href="#">exercitationem</a></li>
<li><a href="#">consequuntur</a></li>
<li><a href="#">Tandem Sunt</a></li>
<li><a href="#">ea voluptate</a></li>
<li><a href="#">Quisquam</a></li>
</ul>

</div><!-- end tags body -->


<div id="map" class="map">

</div> <!--end map-->

<div class="controls">
<ul>
<li><input type="radio" name="map-controls" value="video" /><img src="<?php bloginfo( 'template_directory' ); ?>/images/video.png" alt="Video" title="Video" />Video</li>
<li><input type="radio" name="map-controls" value="photo" /><img src="<?php bloginfo( 'template_directory' ); ?>/images/photo.png" alt="Photo" title="Photo" />Photo</li>
<li><input type="radio" name="map-controls" value="audio" /><img src="<?php bloginfo( 'template_directory' ); ?>/images/audio.png" alt="Audio" title="Audio" />Audio</li>
<li><input type="radio" name="map-controls" value="post" /><img src="<?php bloginfo( 'template_directory' ); ?>/images/post.png" alt="Posts" title="Post" />Blog Posts</li>
<li><input type="radio" name="map-controls" value="site" /><img src="<?php bloginfo( 'template_directory' ); ?>/images/pin.png" alt="Site" title="Site" />Research Site</li>
</ul>
</div> <!-- end controls -->