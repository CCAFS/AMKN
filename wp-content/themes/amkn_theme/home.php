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
<div class="remodal-bg">
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
            
            <div id="sourceMap" data-dojo-type="dijit/layout/AccordionContainer" style="height: 100%;">
                <!--<div id ="gpoints" data-dojo-type="dijit/layout/ContentPane" title="GEOPOINTS" selected="true">-->
                  <label class="switch-light switch-candy" onclick="" style="margin-left: 0;">
                    <input type="checkbox" onclick="updateDataLayerPoints(this.checked)">
                    <span>
                      Wireless
                      <span>GEOPOINTS</span>
                      <span>REGIONS</span>
                    </span>
                    <a></a>
                  </label>
                    <div id="cFiltersList2" style="width: 100%; height: 100%; overflow: hidden;"></div>
                <!--</div>-->
                <!--<div id="gregions" data-dojo-type="dijit/layout/ContentPane" title="REGIONS">-->
                    <div id="cFiltersRegion" style="width: 100%; height: 100%; overflow: hidden; display: none"></div>
                <!--</div>-->                
            </div>
            <div id="basemapGallery" class="drop-panel" ></div> 
            <div id="legendDiv" class="drop-panel"></div>
            <div id="regions" class="drop-panel">
              <ul class="homebox-list zoom_in-list">
              <li><a href="javascript:void(0)" onClick="go2Region('-268581.06491998816;1492308.2161012604', 5);"><img src="<?php bloginfo('template_directory'); ?>/images/west-africa.png"> West Africa</a></li>
              <li><a href="javascript:void(0)" onClick="go2Region('3997216.609617994;-51108.259032608126', 5);"><img src="<?php bloginfo('template_directory'); ?>/images/east-africa.png"> East Africa</a></li>
              <li><a href="javascript:void(0)" onClick="go2Region('8610344.140683722;2172292.0197260105', 5);"><img src="<?php bloginfo('template_directory'); ?>/images/south-asia.png"> South Asia</a></li>
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
<div class="remodal" style="display:none;" data-remodal-id="modal" data-remodal-options='{ "hashTracking": false }'>
  <div id="whatisamkn" class="modal"> 
    <h1><strong>What is AMKN?</strong></h1>
    <p>
      The Climate Change Adaptation and Mitigation Knowledge Network (AMKN) is a platform for accessing and sharing current agricultural adaptation and mitigation knowledge from the CGIAR and its partners. It brings together farmers’ realities on the ground and links them with multiple and combined research outputs, to highlight current challenges and inspire new ideas. It aims to assits scientists and stakeholders to assess and adjust their actions in order to ensure future food security, improved smallholder farmers’ resilience and livelihoods.
    </p>
    <p>  
      AMKN aggregates, visualizes and interconnects research outputs from the CGIAR Research Program on Climate Change, Agriculture and Food Security (CCAFS) focused on addressing risk management, progressive adaptation and pro-poor mitigation options for agricultural and food systems.
    </p>
    <p>  
      The AMKN map allows users to explore a large volume of climatic, environmental, and social information from diverse sources, including data visualization tools, map layers, and multimedia. 
    </p>
    <br>
  </div>

  <div id="whatonthemap" class="modal"> 
    <h1><strong>What’s on the map?</strong></h1>
    <p><img src="<?php bloginfo('template_directory'); ?>/images/data_layersM.png" alt="">  <strong>Data layers </strong> – Geographic data such as crop suitability, crop yield, soils, drought indices and GHG emissions scenarios </p>
    <p><img src="<?php bloginfo('template_directory'); ?>/images/ccafs_sites-mini.png" alt="">  <strong>CCAFS sites</strong> – Descriptions, related media, and facts and statistics on CCAFS focal research sites in five regions of the world: East Africa, West Africa, South Asia, Southeast Asia and Latin America</p>
    <p><img src="<?php bloginfo('template_directory'); ?>/images/amkn_blog_posts-mini.png" alt="">  <strong>Blogs</strong> – Original posts from the CCAFS, CIAT-DAPA and other online sources relating to climate change, agriculture and food security research in the global tropics</p>
    <p><img src="<?php bloginfo('template_directory'); ?>/images/photo_testimonials-mini.png" alt="">  <strong>Photos</strong> – Photosets from around the world highlighting research projects, workshops and events from CCAFS and its partners</p>
    <p><img src="<?php bloginfo('template_directory'); ?>/images/video_testimonials-mini.png" alt=""> <strong>Videos</strong> – Farmer testimonials, interviews, and informational videos relating to climate change mitigation and adaptation in CCAFS sites and the rest of the world</p>
    <p><img src="<?php bloginfo('template_directory'); ?>/images/biodiv_cases-mini.png" alt="">  <strong>Agrobiodiversity case studies</strong> – Stories from the Platform for Agrobiodiversity Research highlighting benefits, uses and challenges confronting agricultural biodiversity in the tropics</p>
    <p><img src="<?php bloginfo('template_directory'); ?>/images/ccafs_activities-mini.png" alt="">  <strong>CCAFS activities</strong> – Descriptions of specific past and ongoing research being conducted by CCAFS and its partners, including date, location and budget information</p>
    <br>
  </div>
  <div id="info" class="left">
    <p >For more information on AMKN, visit the About page.</p>
    <p class="chkmsg">&nbsp;&nbsp;<input type="checkbox" id="chk_showmsg" onchange="applyShowMsg();">Do not show this message again</p>
    <a id="gotoamkn" onclick="closeLandingPage()">Go to AMKN</a>
  </div>
    
</div>
<?php get_footer(); endif; ?>

</div>

