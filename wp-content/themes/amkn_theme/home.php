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



<div id="cBlock" style='<?php echo $size?>'>
  <div id="showContent" class="navigating">
      <div id="popContent" class="layers-box" dojoType="dijit.TitlePane" title="Content" closable="true" open="true"> </div>
  </div> 
  
  <div dojoType="dijit.layout.BorderContainer" design="headline" gutters="true" liveSplitters="false" id="borderContainer" style='<?php echo $size?>'>
    
    <div dojoType="dijit.layout.ContentPane" splitter="false" region="center" style="widows: 100%; display: inline; overflow:hidden;">
      <!--  Base map -->
      <div  style="position:absolute; left:20px; bottom:10px; z-Index:999;">
        <div data-dojo-type="dijit/TitlePane" 
             data-dojo-props="title:'Switch Basemap', closable:false,  open:false">
          <div class="hide" data-dojo-type="dijit/layout/ContentPane" style="width:380px; height:280px; overflow:auto;">
            <div id="basemapGallery" ></div>            
          </div>
        </div>
      </div>
      <!--  end Base map -->
      <div <?php echo $style?> id="tb3" class="hide">
        <!-- Map_controls-box -->
        <div class="map_controls-box homebox">
          <p class="blockNoWrap">
            <div data-dojo-type="dijit/form/DropDownButton">
                <span>Zoom to CCAFS Region</span>
                <div data-dojo-type="dijit/TooltipDialog">
                  <ul class="homebox-list zoom_in-list">
                  <li><a href="javascript:void(0)" onClick="go2Region('-268581.06491998816;1492308.2161012604', 5);">West Africa</a></li>
                  <li><a href="javascript:void(0)" onClick="go2Region('3997216.609617994;-51108.259032608126', 5);">East Africa</a></li>
                  <li><a href="javascript:void(0)" onClick="go2Region('8610344.140683722;2172292.0197260105', 5);">South Asia</a></li>
                  </ul>
                </div>
            </div>
            <button class="amknButton" id="resetMap" dojoType="dijit.form.Button" onClick="zoomToOExt();">
              Reset Zoom
            </button>
          </p>
        </div><!-- end map_controls-box -->
      </div>
      <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
      <?php the_content(); ?>
      <?php endwhile; // end of the loop. ?>
    </div>

    <div <?php echo $style?> id="onthemap" dojoType="dojox.layout.ExpandoPane" title="What&#39;s on the map" maxWidth="235" splitter="<?php echo $splitter?>" region="left" style="width: 235px;" startExpanded="true">
      <!--Here is the calling to the template that show the left menu-->
        <?php get_template_part( 'content_type', 'filters_list2' ); ?>
    </div>
  </div>
    <!-- featured section starts here -->
</div>
</div>
<?php if (!isset($_GET['embedded'])):?>


<?php get_footer(); endif; ?>