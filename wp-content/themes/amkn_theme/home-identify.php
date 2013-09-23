<?php
/*
Template Name: Home Identify Map Template
*/
get_header('home');
//get_sidebar( 'home' );
?>
<div id="yellow_navbar">
    <?php get_template_part( 'taxonomy', 'filters' ); ?>
</div><!-- end yellow_navbar -->
<div id="cBlock">
<div id="showContent" class="navigating">
<div id="popContent" class="layers-box" dojoType="dijit.TitlePane" title="Content" closable="true" open="false">
</div>
</div>
<div id="searching" style="position:absolute; left:45%; top:50%; border:thin solid white; background: red; color: white; PADDING: 0.80%; z-index: 2000; visibility:hidden; font-size: 13px; text-align:center;"><img src="images/loading.gif" /></div>    
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<?php the_content(); ?>
<?php endwhile; // end of the loop. ?>

<div id="tb1">
<div class="zoom_in-box homebox" dojoType="dijit.TitlePane" title="Zoom In" closable="false" open="false">
<div  dojoType="dijit.layout.ContentPane" title="Zoom In">
<ul class="homebox-list zoom_in-list">
<li><a href="javascript:void(0)" onClick="go2Region('-268581.06491998816;1492308.2161012604', 5);">West Africa</a></li>
<li><a href="javascript:void(0)" onClick="go2Region('3997216.609617994;-51108.259032608126', 5);">East Africa</a></li>
<li><a href="javascript:void(0)" onClick="go2Region('9131338.925475348;3199605.679878502', 5);">Indo-Gangetic Plain</a></li>
<li><div class="checkCtrls"><a href="javascript:void(0)" onClick="map.setExtent(initExtent);">Reset Map</a></div></li>

</ul>
</div>
</div><!-- end zoom_in-box -->



<div class="content-box homebox" dojoType="dijit.TitlePane" title="Content" closable="false" open="false">
<?php get_template_part( 'content_type', 'filters' ); ?>
<!--<form action="#" id="searchform-content" method="get"><input type="text" value="" id="searchbar" name="s"><input type="submit" value="Search" id="searchsubmit"></form>-->

</div><!-- end content -->




<div class="layers-box homebox" dojoType="dijit.TitlePane" title="Layers" closable="false" open="false">
<ul class="homebox-list">
<li><input class="homebox-check" id="gcpFS" type="checkbox" name="gcpFS" value="show" onClick="showHideGCP();">
    <label for="gcpFS">GCP Farming systems</label></li>
<!--<li><input class="homebox-check" type="checkbox" value="AEZ"  name="AEZ">HarvestChoice AEZ</li>
<li class="all"><input class="homebox-check" type="checkbox" value="All" name="All">Select / Clear All</li>-->
<li><a id="showLegendB" href="javascript:void(0)" onClick="showLegend.show();">[Show Legend]</a></li>
</ul>


</div><!-- end layers-box -->
</div>
<div id="tb2">
<div class="map_controls-box homebox">
    <p class="blockNoWrap">Zoom <a href="javascript:void(0)" onClick="map.setLevel(map.getLevel()+1)"><img src="<?php bloginfo( 'template_directory' ); ?>/images/z-in.gif" alt="zoom in" /></a> <a href="javascript:void(0)" onClick="map.setLevel(map.getLevel()-1)"><img src="<?php bloginfo( 'template_directory' ); ?>/images/z-out.gif" alt="zoom out" /></a><div id="hide"> | <input id="iconType" checked="checked" type="checkbox" name="iconType" value="large" onClick="updateDataLayer(true)">
<label for="iconType">
    <a href="#">Use large icons</a>
</label></div></p>
<div id="basemapGallery"></div>    
<p class="blockNoWrap"><a id="mapType1" class="controls-selected" href="javascript:void(0)" onClick="setBaseMap(1)">Topo map</a> | <a id="mapType2" href="javascript:void(0)" onClick="setBaseMap(2)">Street map</a> | <a id="mapType3" href="javascript:void(0)" onClick="setBaseMap(3)">Aerial map</a>
</p>
</div><!-- end map_controls-box -->
</div>
<!-- featured section starts here -->
</div>
<div id="featured">
<h1 class="feat-maintitle">Featured on AMKN</h1>
<?php get_template_part( 'teaser', 'video' ); ?><!-- end column 1 -->



<?php get_template_part( 'teaser', 'photo' ); ?><!-- end column 2 -->



<?php get_template_part( 'teaser', 'blog' ); ?><!-- end column 3 -->




<?php get_sidebar( 'follow' ); ?>

</div><!-- end Featured -->
<?php get_footer('home'); ?>