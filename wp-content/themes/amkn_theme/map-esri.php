<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
?>
   <script type="text/javascript">
      var djConfig = {
        parseOnLoad: true
      };
    </script>
    <script type="text/javascript" src="http://serverapi.arcgisonline.com/jsapi/arcgis/?v=2.1">
    </script>
    <script type="text/javascript">
      dojo.require("dijit.dijit"); // optimize: load dijit layer
      dojo.require("dijit.layout.BorderContainer");
      dojo.require("dijit.layout.ContentPane");
      dojo.require("dijit.layout.StackContainer");
    </script>
    <script type="text/javascript" src="<?php bloginfo( 'template_directory' ); ?>/esriMaps.js"></script>
    <script type="text/javascript">
      var webmap, title, subtitle, bingMapsKey;
      function init(){
        //The ID for the map from ArcGIS.com
        webmap = "8b38a6615e5647958feae44c471b5dce";
        //Enter a title, if no title is specified, the webmap's title is used.
        title = "";
        //Enter a subtitle, if not specified the ArcGIS.com web map's summary is used
        subtitle ="";
        //If the webmap uses Bing Maps data, you will need to provided your Bing Maps Key
        bingMapsKey="";
        //By default the application will display the map's description in the sidebar.
        //To define custom content set this value to custom.
        sidebarContent = "";

        initMap();
      }
      dojo.addOnLoad(init);

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
      <div  id="map" class="map">

      </div>

<!--end map-->

<div class="controls">
<ul>
<li><input type="radio" name="map-controls" value="video" /><img src="<?php bloginfo( 'template_directory' ); ?>/images/video.png" alt="Video" title="Video" />Video</li>
<li><input type="radio" name="map-controls" value="photo" /><img src="<?php bloginfo( 'template_directory' ); ?>/images/photo.png" alt="Photo" title="Photo" />Photo</li>
<li><input type="radio" name="map-controls" value="audio" /><img src="<?php bloginfo( 'template_directory' ); ?>/images/audio.png" alt="Audio" title="Audio" />Audio</li>
<li><input type="radio" name="map-controls" value="post" /><img src="<?php bloginfo( 'template_directory' ); ?>/images/post.png" alt="Posts" title="Post" />Bog Posts</li>
<li><input type="radio" name="map-controls" value="site" /><img src="<?php bloginfo( 'template_directory' ); ?>/images/pin.png" alt="Site" title="Site" />Research Site</li>
</ul>


       <div dojotype="dijit.layout.ContentPane" id="rightPane" region="right">
        <div id="rightPaneContent" dojotype="dijit.layout.BorderContainer" design="headline"
        gutters="false" design="headline" style="width:100%; height:100%;">
          <!--Legend Header
          <div class="panelHeader" dojotype="dijit.layout.ContentPane" region="top">
            <span>
              Legend
            </span>
          </div>
          -->
          <!--Legend Content-->
          <div id="rightPaneBody" dojotype="dijit.layout.StackContainer" region="center">
            <div class="panel_content" dojotype="dijit.layout.ContentPane">
              <div id="legendDiv">
              </div>
            </div>
          </div>
        </div>
      </div>
</div> <!-- end controls -->





