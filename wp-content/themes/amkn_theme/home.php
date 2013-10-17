<?php
/*
Template Name: Home Map Template
*/
get_header('home');
//get_sidebar( 'home' );
?>
<div class="tundra">
<div id="yellow_navbar">
    <div class="taxonomies hide" dojoType="dijit.form.DropDownButton" id="rsType">
      <span>Filter Map Resources</span>
      <div dojoType="dijit.TooltipDialog">
        <button dojoType="dijit.form.Button" type="submit" class="checkCtrls amknButton"><a>Close</a></button>
        <?php get_template_part( 'content_type', 'filters' ); ?>

        <?php get_template_part( 'taxonomy', 'filters' ); ?>
      </div>
    </div>
    <div class="taxonomies hide" dojoType="dijit.form.DropDownButton" id="rsLayers">
      <span>Display Data Layers</span>
      <div dojoType="dijit.TooltipDialog">
      <button dojoType="dijit.form.Button" type="submit" class="checkCtrls amknButton"><a>Close</a></button>
  <!--    <button onClick="updateLegend();" dojoType="dijit.form.Button" type="submit" class="checkCtrls amknButton"><a>[Show Data Layer Legend]</a></button>-->
      <button class="checkCtrls amknButton" id="aLayer" dojoType="dijit.form.Button"  onclick="updateLayerVisibility(null, visLyr);">
          Hide All Layers
      </button>
      <br />
      <div id="tslider" dojoType="dijit.form.HorizontalSlider" name="tslider" width="350"
                    onChange="setTrans(arguments[0]/100);"
                    value="100" maximum="100" minimum="0" pageIncrement="100"
                    showButtons="true" intermediateChanges="true" slideDuration="500" style="position:relative; width:350px;">
                <ol dojoType="dijit.form.HorizontalRuleLabels" container="topDecoration"
                style="height:1.5em;font-size:75%;color:gray;">
                    <li>Active Data Layer Opacity
                    </li>
                </ol>

                <ol dojoType="dijit.form.HorizontalRuleLabels" container="bottomDecoration"
                style="height:1em;font-size:75%;color:gray;">
                    <li>
                        0.0
                    </li>

                    <li>
                        1.0
                    </li>
                </ol>
        </div>
        <div id="onmap_layers">

            <?php get_sidebar( 'map_layers' ); ?>

        </div>
      </div>
    </div>

</div> <!--end yellow_navbar -->

<div id="cBlock">
  <div id="showContent" class="navigating">
      <div id="popContent" class="layers-box" dojoType="dijit.TitlePane" title="Content" closable="true" open="true"> </div>
  </div>
  <style type="text/css">
      #borderContainer { width: 100%; height: 650px; border-bottom: 1px solid #CCCCCC; }
  </style>
  <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/dojo/1.6/dijit/themes/tundra/tundra.css" />
  <div dojoType="dijit.layout.BorderContainer" design="headline" gutters="true" liveSplitters="false" id="borderContainer">
    <div dojoType="dijit.layout.ContentPane" splitter="false" region="center" style="widows: 100%; display: inline; overflow:hidden;">
      <div id="tb2" class="hide">
          <div class="map_controls-box homebox">
              <p class="blockNoWrap">

              <!--    <a href="javascript:void(0)" onClick="map.setLevel(map.getLevel()+1)"><img src="<?php bloginfo( 'template_directory' ); ?>/images/z-in.gif" alt="zoom in" /></a> <a href="javascript:void(0)" onClick="map.setLevel(map.getLevel()-1)"><img src="<?php bloginfo( 'template_directory' ); ?>/images/z-out.gif" alt="zoom out" /></a>-->
              <div id="hide"> | <input id="iconType" checked="checked" type="checkbox" name="iconType" value="large" onClick="updateDataLayer(true)"><label for="iconType">
                  <a href="#">Use large icons</a>
              </label></div>
              </p>
              <div id="basemapGallery"></div>
              <p class="blockNoWrap"><a id="mapType1" class="controls-selected" href="javascript:void(0)" onClick="setBaseMap(1)">Topo map</a> | <a id="mapType2" href="javascript:void(0)" onClick="setBaseMap(2)">Street map</a> | <a id="mapType3" href="javascript:void(0)" onClick="setBaseMap(3)">Aerial map</a>
              </p>
          </div><!-- end map_controls-box -->
      </div>
      <div id="tb3" class="hide">
        <div class="map_controls-box homebox">
          <p class="blockNoWrap">
            <button class="amknButton" id="ccafsRegion" dojoType="dijit.form.Button">
                Zoom to CCAFS Region
            </button>
            <button class="amknButton" id="resetMap" dojoType="dijit.form.Button" onClick="zoomToOExt();">
              Reset Zoom
            </button>
            <div dojoType="dijit.Tooltip" connectId="ccafsRegion" position="below">
              <ul class="homebox-list zoom_in-list">
              <li><a href="javascript:void(0)" onClick="go2Region('-268581.06491998816;1492308.2161012604', 5);">West Africa</a></li>
              <li><a href="javascript:void(0)" onClick="go2Region('3997216.609617994;-51108.259032608126', 5);">East Africa</a></li>
              <li><a href="javascript:void(0)" onClick="go2Region('8610344.140683722;2172292.0197260105', 5);">South Asia</a></li>
              </ul>
            </div>
          </p>
        </div><!-- end map_controls-box -->
      </div>
      <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
      <?php the_content(); ?>
      <?php endwhile; // end of the loop. ?>
    </div>
    <div id="onthemap" dojoType="dojox.layout.ExpandoPane" title="What&#39;s on the map" maxWidth="235" splitter="false" region="left" style="width: 235px;" startExpanded="true">
      <!--Here is the calling to the template that show the left menu-->
        <?php get_template_part( 'content_type', 'filters_list2' ); ?>
    </div>
  </div>
    <!-- featured section starts here -->
</div>
</div>
<div id="featured">
  <h1 class="feat-maintitle">Featured on AMKN</h1>
  <!--<button onClick="feedback_widget.show()" dojoType="dijit.form.Button" type="submit" class="amknButton msGenButton right"><a>Community <br />Feedback</a></button>-->
  <?php get_template_part( 'teaser', 'video' ); ?><!-- end column 1 -->
  <?php get_template_part( 'teaser', 'photo' ); ?><!-- end column 2 -->
  <?php get_template_part( 'teaser', 'blog' ); ?><!-- end column 3 -->
  <?php get_sidebar( 'follow' ); ?>

</div><!-- end Featured -->
<?php get_footer('home'); ?>