<?php
/*
Template Name: Home Map Template
*/
if (!isset($_GET['embedded'])){
  get_header('home');
  $style='';
  $splitter = "false";
} else {
  get_header('light');
  $style="style='display:none'";
  $splitter = "false";
}
$size="";
if (isset($_GET['width']) && isset($_GET['height'])) {
  $size = "width:".$_GET['width']."px;height:".$_GET['height']."px;";
}

//get_sidebar( 'home' );
?>
<div class="tundra">

<div <?php echo $style?> id="yellow_navbar">       
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

<div id="cBlock" style='<?php echo $size?>'>
  <div id="showContent" class="navigating">
      <div id="popContent" class="layers-box" dojoType="dijit.TitlePane" title="Content" closable="true" open="true"> </div>
  </div> 
  <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/dojo/1.9.1/dijit/themes/tundra/tundra.css" />
  <div dojoType="dijit.layout.BorderContainer" design="headline" gutters="true" liveSplitters="false" id="borderContainer" style='<?php echo $size?>'>
    
    <div id="map-side" dojoType="dijit.layout.ContentPane" splitter="false" region="center" style="widows: 100%; display: inline; overflow:hidden;">
    
      <div <?php echo $style?> id="tb3" class="hide"> 
      </div>
      <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
      <?php the_content(); ?>
      <?php endwhile; // end of the loop. ?>
    </div>
    
    <div id="onthemap" <?php echo $style?> dojoType="dojox.layout.ExpandoPane" title="What&#39;s on the map" maxWidth="259" splitter="<?php echo $splitter?>" region="left" style="width: 259px;" startExpanded="true">
      <!--Here is the calling to the template that show the left menu-->
        <?php get_template_part( 'content_type', 'filters_list2' ); ?>

          <!--  Base map -->
          <div style="height: 86%;">
            <div id="cFiltersList2" style="width: 100%; height: 100%; overflow: hidden;"></div>
            <div id="basemapGallery" class="drop-panel" ></div> 
            <div id="legendDiv" class="drop-panel"></div>
            <div id="regions" class="drop-panel">
              <ul class="homebox-list zoom_in-list">
              <li><a href="javascript:void(0)" onClick="go2Region('-268581.06491998816;1492308.2161012604', 5);">West Africa</a></li>
              <li><a href="javascript:void(0)" onClick="go2Region('3997216.609617994;-51108.259032608126', 5);">East Africa</a></li>
              <li><a href="javascript:void(0)" onClick="go2Region('8610344.140683722;2172292.0197260105', 5);">South Asia</a></li>
              </ul>
            </div>
          </div>   
          <!--  end Base map -->
       <div id="panel-buttons">
      <button id="filter-button" class="panel-button selected"> &nbsp;</button>
      <button id="legend-button" class="panel-button"> &nbsp;</button>
      <button id="basemap-button" class="panel-button"> &nbsp;</button>
      <button id="region-button" class="panel-button"> &nbsp;</button>
      <button id="reset-button" class="panel-button" onClick="zoomToOExt();"> &nbsp;</button>
    </div>    
    </div>
    
  </div>

    <!-- featured section starts here -->
</div>



</div>


<?php if (!isset($_GET['embedded'])):?>

<div id="featured">
  <div id="container">
    <h1 class="feat-maintitle">Featured on AMKN</h1>
    <!--<button onClick="feedback_widget.show()" dojoType="dijit.form.Button" type="submit" class="amknButton msGenButton right"><a>Community <br />Feedback</a></button>-->
    <?php get_template_part( 'teaser', 'video' ); ?><!-- end column 1 -->
    <?php get_template_part( 'teaser', 'photo' ); ?><!-- end column 2 -->
    <?php get_template_part( 'teaser', 'blog' ); ?><!-- end column 3 -->
    

  </div><!-- end Featured -->
</div>  
<?php get_footer(); endif; ?>