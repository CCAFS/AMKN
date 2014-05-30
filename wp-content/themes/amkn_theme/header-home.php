<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
$var = '';
if (isset($_GET["embedded"]) && $_GET["embedded"] != ''){ 
  $var = '?embedded=1';
  if (isset($_GET['width']) && isset($_GET['height'])) {
    $var .= "&width=".$_GET['width']."&height=".$_GET['height'];
  }
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />
        <meta name="description" content="The Climate Change Adaptation and Mitigation Knowledge Network (AMKN) is a platform for accessing and sharing current agricultural adaptation and mitigation knowledge from the CGIAR and its partners. It brings together farmers’ realities on the ground and links them with multiple and combined research outputs, to highlight current challenges and inspire new ideas. It aims to assits scientists and stakeholders to assess and adjust their actions in order to ensure future food security, improved smallholder farmers’ resilience and livelihoods.">
        <title><?php
            /*
             * Print the <title> tag based on what is being viewed.
             */
            global $page, $paged;

            wp_title('|', true, 'right');

            // Add the blog name.
            bloginfo('name');

            // Add the blog description for the home/front page.
            $site_description = get_bloginfo('description', 'display');
            if ($site_description && ( is_home() || is_front_page() ))
                echo " | $site_description";
            ?></title>
        <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.4.2/pure-min.css">
        <link rel="icon" type="image/png" href="<?php bloginfo('template_directory'); ?>/images/favicon.png" />
        <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/dojo/1.9.1/dijit/themes/tundra/tundra.css" />
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <script type="text/javascript">
            var djConfig = {
                parseOnLoad: true
            };
        </script>
        <script type="text/javascript" src="http://www.google.com/jsapi"></script>
        <script type="text/javascript">
            //<![CDATA[
            google.load("jquery", "1.7.1");
            google.load("jqueryui", "1.8.2");
            //]]>
        </script>
        <!-- DynaTree library used in the new sidebar -->
        <link href="<?php bloginfo('template_directory'); ?>/libs/dynatree/1.2.4/skin-vista/ui.dynatree.css" rel="stylesheet" type="text/css">
        <link href="<?php bloginfo('template_directory'); ?>/toggle-switch.css" rel="stylesheet" type="text/css">
        <script src="<?php bloginfo('template_directory'); ?>/libs/dynatree/1.2.4/jquery.dynatree.js" type="text/javascript"></script>
        <script type="text/javascript">
          var firstime = false;
          var inst;
            jQuery(function ($) {
                //$(document).ready(function() {
                // Attach the dynatree widget to an existing <div id="tree"> element
                // and pass the tree options as an argument to the dynatree() function:                
                $("#cFiltersList2").dynatree({
                    children: treeData,
                    selectMode: 3,
                    checkbox: true,
                    select: true,
                    debugLevel: 0,
                    onActivate: function(node) {
                        // A DynaTreeNode object is passed to the activation handler
                        // Note: we also get this event, if persistence is on, and the page is reloaded.
                                               
                        //showItemDetails
                        if( node.data.url ) {
                          document.location = node.data.url;
//                          updateLayerVisibilityTree();
                        }
//                            window.open(node.data.url);                       
                    },
                    onSelect: function(flag, node) {  
                      if( !node.data.url ) {

                        if (node.data.key == 'accord_ccafs_sites' || node.data.key == 'accord_video_testimonials'  || node.data.key == 'accord_amkn_blog_posts'
                              || node.data.key == 'accord_biodiv_cases' || node.data.key == 'accord_photo_testimonials'|| node.data.key == 'accord_ccafs_activities' || node.data.key.match('taxio_')) {
                            if (firstime) updateDataLayerTree(true);
                            validateSelect();
                        }
                      }
                    },
                    onCreate: function(node, nodeSpan) {
                        $(nodeSpan).hover(function(){
                            onListHover(node.data.key,node.data.url);
                        }, function(){                                                        
                            onFeatureLeave();
                        });
                    }
                }); 
                $("#dataLayers").dynatree({
                    children: treeDataLayer,
                    selectMode: 3,
                    expand: true,
                    checkbox: true,
                    classNames: {checkbox: "dynatree-radio"},
                    debugLevel: 0,
                    onActivate: function(node) {
                        // A DynaTreeNode object is passed to the activation handler
                        // Note: we also get this event, if persistence is on, and the page is reloaded.
                                              
                        //showItemDetails
                        if( node.data.url ) {
                          document.location = node.data.url;
//                          updateLayerVisibilityTree();
                        }
//                            window.open(node.data.url);                       
                    },
                    onSelect: function(flag, node) {  
                      if( !node.data.url ) {

                        if (node.data.key == 'accord_ccafs_sites' || node.data.key == 'accord_video_testimonials'  || node.data.key == 'accord_amkn_blog_posts'
                              || node.data.key == 'accord_biodiv_cases' || node.data.key == 'accord_photo_testimonials'|| node.data.key == 'accord_ccafs_activities' || node.data.key.match('taxio_')) {

//                          var points = node.tree.getSelectedNodes(); 
                            if (firstime) updateDataLayerTree(true); 
                        } else { 
                          updateLayerVisibilityTree(node,flag);
                        }
                      }
                    },
                    onCreate: function(node, nodeSpan) {
                        $(nodeSpan).hover(function(){
                            onListHover(node.data.key,node.data.url);
                        }, function(){                                                        
                            onFeatureLeave();
                        });
                    }
                }); 
                $("#cFiltersRegion").dynatree({
                    children: treeData,
                    selectMode: 3,
                    checkbox: true,
                    debugLevel: 0,
                    onActivate: function(node) {
                        // A DynaTreeNode object is passed to the activation handler
                        // Note: we also get this event, if persistence is on, and the page is reloaded.
                       
                        //onListHover(node.data.key);
                        //showItemDetails
                        if( node.data.url ) {
                          document.location = node.data.url;
//                          updateLayerVisibilityTree();
                        }
                    },
                    onSelect: function(flag, node) {  
                      if( !node.data.url ) {

                        if (node.data.key == 'accord_ccafs_sites' || node.data.key == 'accord_video_testimonials'  || node.data.key == 'accord_amkn_blog_posts'
                              || node.data.key == 'accord_biodiv_cases' || node.data.key == 'accord_photo_testimonials'|| node.data.key == 'accord_ccafs_activities' || node.data.key.match('taxio_')) {

//                          var points = node.tree.getSelectedNodes(); 
                            if (firstime) updateDataLayerRegionTree(flag); 
                        }
                      }
                    },
                    onCreate: function(node, nodeSpan) {
                        $(nodeSpan).hover(function(){
//                            onListHover(node.data.key,node.data.url);
                        }, function(){                                                        
//                            onFeatureLeave();
                        });
                    }
                }); 
                $( "#basemap-button" ).click(function() {
                  $( this ).addClass("selected").siblings().removeClass("selected");  
                  $( "#basemapGallery" ).show().siblings().hide();
                }); 
                $( "#legend-button" ).click(function() {
                  $( this ).addClass("selected").siblings().removeClass("selected"); 
                  $( this ).removeClass("haslegend"); 
                  $( "#layersDiv" ).show().siblings().hide(); 
                }); 
                $( "#filter-button" ).click(function() {
                  $( this ).addClass("selected").siblings().removeClass("selected");  
                  $( "#sourceMap" ).show().siblings().hide();
                }); 
                $( "#region-button" ).click(function() {
                  $( this ).addClass("selected").siblings().removeClass("selected");  
                  $( "#regions" ).show().siblings().hide();
                });

                var a =getCookie("showmsg"); 
                if(null!=a&&""!=a&&"true"==a);else{
                    // Remodal-master http://vodkabears.github.io/remodal/ 
                    openLandingPage();
                }
                
              $("#btnDeselectAll").click(function(){
                $("#dataLayers").dynatree("getRoot").visit(function(node){
                  node.select(false);
                });
                return false;
              });
              $("#ckbSelectAll").click(function(){
                var status = false;
                if( $(this).prop('checked')  ) status = true;
                $("#cFiltersList2").dynatree("getRoot").visit(function(node){
                  node.select(status);
                });
              });
              $(document).on('click','.close_box',function(){
                  $(this).parent().fadeTo(300,0,function(){
                        $(this).remove();
                  });
              });
            });
            function openLandingPage(){$('.remodal').show();inst = $('[data-remodal-id=modal]').remodal({ "hashTracking": false });inst.open()}
            function closeLandingPage(){inst.close()}
            function applyShowMsg(){showmsg=document.getElementById("chk_showmsg").checked,null!=showmsg&&""!=showmsg&&setCookie("showmsg",showmsg,365)}
            function getCookie(a){var b=document.cookie,c=b.indexOf(" "+a+"=");if(-1==c&&(c=b.indexOf(a+"=")),-1==c)b=null;else{c=b.indexOf("=",c)+1;var d=b.indexOf(";",c);-1==d&&(d=b.length),b=unescape(b.substring(c,d))}return b}
            function setCookie(a,b,c){var d=new Date;d.setDate(d.getDate()+c);var e=escape(b)+(null==c?"":"; expires="+d.toUTCString());document.cookie=a+"="+e}
            
        </script>
        <!--<script type="text/javascript" src="http://serverapi.arcgisonline.com/jsapi/arcgis/?v=2.5compact"></script>-->
        <!--<link rel="stylesheet" href="http://js.arcgis.com/3.7/js/esri/css/esri.css">-->
        <link rel="stylesheet" href="http://js.arcgis.com/3.8/js/esri/css/esri.css">
        <script src="http://js.arcgis.com/3.8/"></script>
        <?php
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== FALSE) {
            ?>
            <style type="text/css">
                /*#popContent_pane{
                    overflow: scroll !important;
                }*/
            </style>
        <?php }
        ?>
        <!--  Remodal-master  "version": "0.1.3" http://vodkabears.github.io/remodal/ -->
        <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/libs/Remodal-master/dist/jquery.remodal.css">
        <script src="<?php bloginfo('template_directory'); ?>/libs/Remodal-master/dist/jquery.remodal.min.js"></script>
        <?php wp_head(); ?>
    </head>
    <body class="tundra">
        
 

        <div id="header">
            <div class="logos"><a href="<?php bloginfo('url');echo $var; ?>">
                    <img class="amkn_logo" src="<?php bloginfo('template_directory'); ?>/images/amkn.gif" alt="AMKN logo" />
                    <img class="ccafs_logo" src="<?php bloginfo('template_directory'); ?>/images/ccafs-logo.png" alt="CCAFS logo" /></a>
            </div><!-- end logos -->
            
            <div id="right-header">

                <div class="navbar">
                    <form action="/search/" id="searchform" method="get"><input type="text" value="" id="searchbar" name="q" /><input type="submit" value="Search" id="searchsubmit" /></form>   
                    <?php
                    $defaults = array(
                        'container' => 'none',
                        'container_id' => '',
                        'menu_class' => 'navigation',
                        'menu_id' => 'menu',
                        'echo' => true,
                        'fallback_cb' => 'wp_page_menu',
                        'theme_location' => 'primary',
                        'before' => '',
                        'after' => '',
                        'link_before' => '',
                        'link_after' => '',
                        'depth' => 0,
                        'walker' => '');
                    wp_nav_menu($defaults);
                    ?>
                    <form action=<?php echo get_bloginfo('wpurl')."/search/"?> id="searchform" method="get"><input type="text" value="" id="searchbar" name="q" /><input type="submit" value="Search" id="searchsubmit" /></form>
                </div><!-- end navbar -->


            </div><!-- end right-header -->

           
        </div> <!-- end Header -->
        <?php //get_header('menu'); ?>
