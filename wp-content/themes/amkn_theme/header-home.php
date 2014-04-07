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
        <link rel="icon" type="image/png" href="<?php bloginfo('template_directory'); ?>/images/favicon.png" />
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
        <script src="<?php bloginfo('template_directory'); ?>/libs/dynatree/1.2.4/jquery.dynatree.js" type="text/javascript"></script>
        <script type="text/javascript">
          var firstime = false;
            jQuery(function ($) {
                //$(document).ready(function() {
                // Attach the dynatree widget to an existing <div id="tree"> element
                // and pass the tree options as an argument to the dynatree() function:
                $("#cFiltersList2").dynatree({
                    children: treeData,
                    selectMode: 3,
                    checkbox: true,
                    onActivate: function(node) {
                        // A DynaTreeNode object is passed to the activation handler
                        // Note: we also get this event, if persistence is on, and the page is reloaded.
                       
                        //onListHover(node.data.key);
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
                            onListHover(node.data.key);
                        }, function(){                                                        
                            onFeatureLeave();
                        });
                    },
                });                               
            });
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
        <?php wp_head(); ?>
    </head>
    <body class="tundra">
        <div id="header index">
            <div class="logos"><a href="<?php bloginfo('url');echo $var; ?>">
                    <img class="amkn_logo" src="<?php bloginfo('template_directory'); ?>/images/amkn.gif" alt="AMKN logo" />
                    <img class="ccafs_logo" src="<?php bloginfo('template_directory'); ?>/images/ccafs-logo.png" alt="CCAFS logo" /></a>
            </div><!-- end logos -->
            
            <div id="right-header">

                <div class="navbar">

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
        <?php get_header('menu'); ?>
