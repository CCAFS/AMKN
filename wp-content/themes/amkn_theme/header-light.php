<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
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
                              || node.data.key == 'accord_biodiv_cases' || node.data.key == 'accord_photo_testimonials' || node.data.key.match('taxio_')) {
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
        <link rel="stylesheet" href="http://js.arcgis.com/3.7/js/esri/css/esri.css">
        <script src="http://js.arcgis.com/3.7/"></script>
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
        <?php //wp_head(); ?>
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', '<?php echo get_option('google_analytics'); ?>', 'amkn.org');
          ga('create', 'UA-22478956-2', 'amkn.org', {'name': 'newTracker'});
          ga('send', 'pageview');
          ga('newTracker.send', 'pageview');


        </script>
    </head>
    <body class="tundra">