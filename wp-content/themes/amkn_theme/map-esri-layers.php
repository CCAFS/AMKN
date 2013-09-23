<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
?>


   <link rel="stylesheet" type="text/css" href="http://serverapi.arcgisonline.com/jsapi/arcgis/2.1/js/dojo/dijit/themes/claro/claro.css">
    <style>
      html, body { height: 98%; width: 98%; margin: 0; padding: 5px; }
      #rightPane{
        width:100%;
        display: block;
        position: absolute;
      }
      #legendPane{
        border: solid #97DCF2 1px;
      }

    </style>
    <script type="text/javascript">var djConfig = {parseOnLoad: true};</script>
    <script type="text/javascript" src="http://serverapi.arcgisonline.com/jsapi/arcgis/?v=2.1"></script>
    <script type="text/javascript">
      dojo.require("dijit.layout.BorderContainer");
      dojo.require("dijit.layout.ContentPane");
      dojo.require("dijit.layout.AccordionContainer");
      dojo.require("esri.map");
      dojo.require("esri.dijit.Legend");
      dojo.require("esri.arcgis.utils");
      dojo.require("dijit.form.CheckBox");
      dojo.require("esri.layers.FeatureLayer");

      var map;
      var legendLayers = [];

      function init() {
        var initialExtent = new esri.geometry.Extent({"xmin":-3247790.679362219,"ymin":-2944708.4017954674,"xmax":10919353.89112171,"ymax":5449911.79259349,"spatialReference":{"wkid":0000}});
        map = new esri.Map("map", { extent: initialExtent});

        //Add the terrain service to the map. View the ArcGIS Online site for services http://arcgisonline/home/search.html?t=content&f=typekeywords:service
        var basemap = new esri.layers.ArcGISTiledMapServiceLayer("http://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer");
        map.addLayer(basemap);

        var photoLayer = new esri.layers.ArcGISDynamicMapServiceLayer("http://184.73.156.57/ArcGIS/rest/services/1012_CGIAR_OJE/AMKN/MapServer",{id:'1'});

        legendLayers.push({layer:photoLayer,title:'Photos'});

        dojo.connect(map,'onLayersAddResult',function(results){
          var legend = new esri.dijit.Legend({
            map:map,
            layerInfos:legendLayers
          },"tags_body");
          legend.startup();
        });
        map.addLayers([photoLayer]);

       dojo.connect(map,'onLayersAddResult',function(results){
       var layers = [];
        dojo.forEach(map.layerIds, dojo.hitch(this, function (layerId) {
          layers.push(map.getLayer(layerId));
        }));
        dojo.forEach(map.graphicsLayerIds, dojo.hitch(this, function (layerId) {
          layers.push(map.getLayer(layerId));
        }));

        //add check boxes
        dojo.forEach(layers,function(layer){
         var layerName = layer.title;
         var checkBox = new dijit.form.CheckBox({
            name: "checkBox" + layer.layer.id,
            value: layer.layer.id,
            checked: layer.layer.visible,
            onChange: function(evt) {
              var clayer = map.getLayer(this.value);
              if (clayer.visible) {
                clayer.hide();
              } else {
                clayer.show();
              }
              this.checked = clayer.visible;
            }
          });

          //add the check box and label to the toc
          dojo.place(checkBox.domNode,dojo.byId("toggle"),"after");
          var checkLabel = dojo.create('label',{'for':checkBox.name, innerHTML:layerName},checkBox.domNode,"after");
           dojo.place("<br />",checkLabel,"after");
        });

        });
        //resize the map when the browser resizes - view the 'Resizing and repositioning the map' section in
        //the following help topic for more details http://help.esri.com/EN/webapi/javascript/arcgis/help/jshelp_start.htm#jshelp/inside_guidelines.htm
        var resizeTimer;
        dojo.connect(map, 'onLoad', function(theMap) {
          dojo.connect(dijit.byId('map'), 'resize', function() {  //resize the map if the div is resized
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout( function() {
              map.resize();
              map.reposition();
            }, 500);
          });
        });
      }



      dojo.addOnLoad(init);
    </script>












<div class="tags"><a href="#"><img src="<?php bloginfo( 'template_directory' ); ?>/images/explore.png" alt="Explore with tag" /></a></div>

<div class="tags_body">


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
      <div id="rightPane" dojotype="dijit.layout.ContentPane" region="right">
        <div dojoType="dijit.layout.AccordionContainer">
          <div dojoType="dijit.layout.ContentPane" id="legendPane" title="Legend"  selected="true">
            <div id="legendDiv"></div>
          </div>
          <div dojoType="dijit.layout.ContentPane" title="Natural Disasters" >
            <span style="padding:10px 0;">Click to toggle the visibilty of the various natural disasters</span>
            <div id="toggle" style="padding: 2px 2px;"></div>
          </div>
        </div>
      </div>


</div> <!-- end controls -->





