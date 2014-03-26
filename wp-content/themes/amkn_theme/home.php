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
    
    <div id="map-side" dojoType="dijit.layout.ContentPane" splitter="false" region="center" style="widows: 100%; display: inline; overflow:hidden;">
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
      </div>
      <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
      <?php the_content(); ?>
      <?php endwhile; // end of the loop. ?>
    </div>

    <div id="onthemap" <?php echo $style?> dojoType="dojox.layout.ExpandoPane" title="What&#39;s on the map" maxWidth="235" splitter="<?php echo $splitter?>" region="left" style="width: 235px;" startExpanded="true">
      <!--Here is the calling to the template that show the left menu-->
        <?php get_template_part( 'content_type', 'filters_list2' ); ?>
    </div>
  </div>
    <!-- featured section starts here -->
</div>
</div>
<?php if (!isset($_GET['embedded'])):?>


<?php get_footer(); endif; ?>