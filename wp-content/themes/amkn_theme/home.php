<?php
/*
  Template Name: Home Map Template
 */
if (!isset($_GET['embedded'])) {
  get_header('home');
  $style = '';
  $splitter = "true";
} else {
  get_header('light');
  $style = "style='display:none'";
  $splitter = "false";
}
$size = "";
if (isset($_GET['width']) && isset($_GET['height'])) {
  $size = "width:" . $_GET['width'] . "px;height:" . $_GET['height'] . "px;";
}

//get_sidebar( 'home' );
?>
<div class="remodal-bg">
  <div class="tundra">

    <div <?php echo $style ?> id="yellow_navbar">       
      <div class="taxonomies hide" data-dojo-type="dijit.form.DropDownButton" id="rsLayers">
        <span>Display Data Layers</span>
        <div data-dojo-type="dijit.TooltipDialog">
          <button data-dojo-type="dijit.form.Button" type="submit" class="checkCtrls amknButton"><a>Close</a></button>
          <!--    <button onClick="updateLegend();" data-dojo-type="dijit.form.Button" type="submit" class="checkCtrls amknButton"><a>[Show Data Layer Legend]</a></button>-->
          <button class="checkCtrls amknButton" id="aLayer" data-dojo-type="dijit.form.Button"  onclick="updateLayerVisibility(null, visLyr);">
            Hide All Layers
          </button>
          <br />
          <div id="tslider" data-dojo-type="dijit.form.HorizontalSlider" name="tslider" width="350"
               onChange="setTrans(arguments[0] / 100);"
               value="100" maximum="100" minimum="0" pageIncrement="100"
               showButtons="true" intermediateChanges="true" slideDuration="500" style="position:relative; width:350px;">
            <ol data-dojo-type="dijit.form.HorizontalRuleLabels" container="topDecoration"
                style="height:1.5em;font-size:75%;color:gray;">
              <li>Active Data Layer Opacity
              </li>
            </ol>

            <ol data-dojo-type="dijit.form.HorizontalRuleLabels" container="bottomDecoration"
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

            <?php get_sidebar('map_layers'); ?>

          </div>
        </div>
      </div>

    </div> <!--end yellow_navbar -->

    <div id="cBlock" style='<?php echo $size ?>'>
      <div id="showContent" class="navigating">
        <div id="popContent" class="layers-box" data-dojo-type="dijit.TitlePane" title="Content" closable="true" open="true"> </div>
      </div>
<!--      <div id="printMap" class="shadow" style="visibility: visible;">
        <div id="closePrintMapWin" class="closeBtn" title="Close"></div>
        <div style="top:5px;padding-top:15px;text-align:center;"><h3>Print Map</h3></div>
        <span id="printWorking" style="display:none;position: absolute;top: 80px;left: 35px;"><img src="<?php echo get_template_directory_uri(); ?>/imgs/ajax-loader.gif"></span>
        <div id="print_button" style="text-align:center;"><div class="esriPrint"><table class="dijit dijitReset dijitInline dijitLeft esriPrintButton dijitComboButton" cellspacing="0" cellpadding="0" role="presentation" id="dijit_form_ComboButton_0" widgetid="dijit_form_ComboButton_0"><tbody role="presentation"><tr role="presentation"><td class="dijitReset dijitStretch dijitButtonNode" data-dojo-attach-point="buttonNode" data-dojo-attach-event="ondijitclick:_onClick,onkeypress:_onButtonKeyPress"><div id="dijit_form_ComboButton_0_button" class="dijitReset dijitButtonContents" data-dojo-attach-point="titleNode" role="button" aria-labelledby="dijit_form_ComboButton_0_label" tabindex="0"><div class="dijitReset dijitInline dijitIcon dijitNoIcon" data-dojo-attach-point="iconNode" role="presentation"></div><div class="dijitReset dijitInline dijitButtonText" id="dijit_form_ComboButton_0_label" data-dojo-attach-point="containerNode" role="presentation">Imprimir</div></div></td><td id="dijit_form_ComboButton_0_arrow" class="dijitReset dijitRight dijitButtonNode dijitArrowButton dijitDownArrowButton" data-dojo-attach-point="_popupStateNode,focusNode,_buttonNode" data-dojo-attach-event="onkeypress:_onArrowKeyPress" title="" role="button" aria-haspopup="true" tabindex="0" style="-webkit-user-select: none;"><div class="dijitReset dijitArrowButtonInner" role="presentation"></div><div class="dijitReset dijitArrowButtonChar" role="presentation">▼</div></td><td style="display:none !important;"><input type="button" value="" data-dojo-attach-point="valueNode" role="presentation"></td></tr></tbody></table></div></div>
        <div id="print_button" style="text-align:center;"></div>
        <hr>        
      </div>-->
      <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/dojo/1.9.1/dijit/themes/tundra/tundra.css" />
      <div data-dojo-type="dijit.layout.BorderContainer" design="headline" gutters="true" liveSplitters="false" id="borderContainer" style='<?php echo $size ?>'>

        <div id="map-side" data-dojo-type="dijit.layout.ContentPane" splitter="false" region="center" style="widows: 100%; display: inline; overflow:hidden;">

          <div <?php echo $style ?> id="tb3" class="hide"> 
          </div>
          <?php if (have_posts()) while (have_posts()) : the_post(); ?>
              <?php the_content(); ?>
            <?php endwhile; // end of the loop. ?>
        </div>

        <div id="onthemap" <?php echo $style ?> data-dojo-type="dojox.layout.ExpandoPane" title="What&#39;s on the map" maxWidth="259" splitter="<?php echo $splitter ?>" region="left" style="width: 259px;" startExpanded="true">
          <!--Here is the calling to the template that show the left menu-->
          <?php get_template_part('content_type', 'filters_list2'); ?>          
          <div id="panel-buttons">
            <button id="filter-button" class="panel-button selected"> &nbsp;</button>
            <button id="legend-button" class="panel-button"> &nbsp;</button>
            <button id="basemap-button" class="panel-button"> &nbsp;</button>
            <button id="region-button" class="panel-button"> &nbsp;</button>
            <button id="reset-button" class="panel-button" onClick="zoomToOExt();"> &nbsp;</button>
          </div>
          <!--  Base map -->
          <div style="height: 86%;">            
            <div id="sourceMap" data-dojo-type="dijit/layout/AccordionContainer" style="height: 100%;position: relative;">          
              <div class="switch-toggle switch-candy switch-candy-yellow" style="display:none">
                <input id="geop" name="view" type="radio" checked onclick="updateDataLayerPoints(this.id);">
                <label for="geop" onclick="">GEOPOINTS</label>
                <input id="regs" name="view" type="radio" onclick="updateDataLayerPoints(this.id);">
                <label for="regs" onclick="">REGIONS</label>
                <a></a>
              </div>          
              <div class="info" >
                <div class="close_box">&nbsp;</div>
                <div style="">
                  Only contents with geo-coordinates are represented on the map.
                </div>
              </div>
              <div id="divBtnUnselectAll" style="padding:5px 10px;">
                <input type="checkbox" id ="ckbSelectAll" checked> Select All
              </div>              
              <div id="cFiltersList2" style="width: 100%; height: 75%;position: absolute;"></div>                
              <div id="cFiltersRegion" style="width: 100%; height: 100%; overflow: hidden; display: none"></div>
            </div>
            <div id="basemapGallery" class="drop-panel" ></div> 
            <div id="layersDiv" class="drop-panel" data-dojo-type="dijit/layout/AccordionContainer" style="height: 100%;">
              <div id="accord_data_layer" data-dojo-type="dijit/layout/ContentPane" title="Data Layers" selected="true" style="overflow: hidden;">
                <button class="checkCtrls amknButton" id="btnDeselectAll" data-dojo-type="dijit.form.Button"  onclick="hideLayers()">
                  Hide All Layers
                </button>
                <div id="dataLayers" style="width: 100%; height: 100%;" ></div>
              </div>
              <div id="accord_legend" title="Data Legend" data-dojo-type="dijit/layout/ContentPane">
                <div id="legendDiv" style="width: 100%; height: 100%;"></div>
              </div>
            </div>
            <!--            <div id="layersDiv" style="height: 100%;">
                      <h3>Data Layers</h3>
                      <div style="height: 100%;">
                        <div>                  
                            <a href="#" id="btnDeselectAll">Hide All Layers</a>                  
                        </div>
                        <div id="dataLayers" style="width: 100%; height: 100%;" ></div>
                      </div>
                      <h3>Data Legend</h3>
                      <div style="height: 100%;">
                        <div id="legendDiv" style="width: 100%; height: 100%;"></div>
                      </div>
                    </div>-->        
            <div id="regions" class="drop-panel">
              <ul class="homebox-list zoom_in-list">
                <li><a href="javascript:void(0)" onClick="go2Region('-268581.06491998816;1492308.2161012604', 4, 'wa');"><img src="<?php bloginfo('template_directory'); ?>/images/west-africa.png"> West Africa</a></li>
                <li><a href="javascript:void(0)" onClick="go2Region('3997216.609617994;-51108.259032608126', 4, 'ea');"><img src="<?php bloginfo('template_directory'); ?>/images/east-africa.png"> East Africa</a></li>
                <li><a href="javascript:void(0)" onClick="go2Region('8610344.140683722;2172292.0197260105', 4, 'sa');"><img src="<?php bloginfo('template_directory'); ?>/images/south-asia.png"> South Asia</a></li>
                <li><a href="javascript:void(0)" onClick="go2Region('-8364791.100883702;-303044.7042604806', 4, 'la');"><img src="<?php bloginfo('template_directory'); ?>/images/latin-america2.png"> Latin America</a></li>
                <li><a href="javascript:void(0)" onClick="go2Region('11442794.66081846;782972.5936150161', 4, 'sea');"><img src="<?php bloginfo('template_directory'); ?>/images/southeast-asia2.png"> Southeast Asia</a></li>
              </ul>
            </div>          
          </div>   
          <!--  end Base map -->

        </div>     

      </div>  
      <!-- featured section starts here -->
    </div>



  </div>
  <?php if (!isset($_GET['embedded'])): ?>

    <div id="featured">
      <div id="container">
        <h1 class="feat-maintitle">The Newest on AMKN</h1>
        <!--<button onClick="feedback_widget.show()" data-dojo-type="dijit.form.Button" type="submit" class="amknButton msGenButton right"><a>Community <br />Feedback</a></button>-->
        <?php get_template_part('teaser', 'video'); ?><!-- end column 1 -->
        <?php get_template_part('teaser', 'photo'); ?><!-- end column 2 -->
        <?php get_template_part('teaser', 'blog'); ?><!-- end column 3 -->


      </div><!-- end Featured -->
    </div>
    <?php get_template_part('teaser', 'newest_posts'); ?>
    <div class="remodal" style="display:none;" data-remodal-id="modal" data-remodal-options='{ "hashTracking": false }'>
      <div id="whatisamkn" class="modal"> 
        <h1><strong>What is AMKN?</strong></h1>
        <p>
          The AMKN is a platform for accessing and sharing current agricultural adaptation and mitigation knowledge from the CGIAR and its partners. 
        </p>
        <p>  
          It provides a visual display of farmers’ on-the-ground climate realities and transforms hard research data into interactive multimedia that can be easily understood by all users.
        </p>
        <p>  
          The AMKN map allows users to explore various forms of agro-climatic information from diverse sources, in a user friendly way that meets the needs of different users regardless of their technical background.
        </p>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <p >For more information on AMKN, visit the <a href="./about/">About</a> page.</p>
        <p class="chkmsg"><input type="checkbox" id="chk_showmsg" onchange="applyShowMsg();">&nbsp;Do not show this message again</p>
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
        <a id="gotoamkn" onclick="closeLandingPage()">Go to AMKN</a>
        <a id="tour" onclick="closeLandingPage();
              tour()">Start tour</a>
        &nbsp;&nbsp;&nbsp;
      </div>

    </div>
    <?php
    get_footer();
  endif;
  ?>

</div>

