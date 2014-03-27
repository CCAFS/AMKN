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
  <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/dojo/1.9.1/dijit/themes/tundra/tundra.css" />
  <div dojoType="dijit.layout.BorderContainer" design="headline" gutters="true" liveSplitters="false" id="borderContainer" style='<?php echo $size?>'>
    
    <div id="map-side" dojoType="dijit.layout.ContentPane" splitter="false" region="center" style="widows: 100%; display: inline; overflow:hidden;">
      <!--  Base map -->
      <div id="basemap-gallery">
        <div data-dojo-type="dijit/TitlePane" data-dojo-props="title:'Basemap', closable:false,  open:false">
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