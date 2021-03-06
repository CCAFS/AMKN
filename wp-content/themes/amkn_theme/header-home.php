<?php
/*
 *  This file is part of Adaptation and Mitigation Knowledge Network (AMKN).
 *
 *  AMKN is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  at your option) any later version.
 *
 *  AMKN is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with DMSP.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Copyright 2012 (C) Climate Change, Agriculture and Food Security (CCAFS)
 * 
 * Created on : 20-10-2012
 * @author      
 * @version     1.0
 */
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
$_SESSION['lastDate'] = 0;
setcookie("lastDateTmp", 0, strtotime('+1 days'));
ini_set('memory_limit', '-1');
if (isset($_COOKIE["lastDate"])) {
  $_SESSION['lastDate'] = 'January 1, 2014';
//  $_SESSION['lastDate'] = $_COOKIE["lastDate"];
  setcookie("lastDateTmp", 'January 1, 2014', strtotime('+1 days'));
//  setcookie("lastDateTmp", $_SESSION['lastDate']);
}
//setcookie("lastDate", date('Y-m-d H:i:s e'), strtotime( '+30 days' ));
setcookie("lastDate", date('F jS, Y'), strtotime('+30 days'));
$var = '';
if (isset($_GET["embedded"]) && $_GET["embedded"] != '') {
  $var = '?embedded=1';
  if (isset($_GET['width']) && isset($_GET['height'])) {
    $var .= "&width=" . $_GET['width'] . "&height=" . $_GET['height'];
  }
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <!-- no cache headers -->
    <!--<meta http-equiv="Pragma" content="no-cache">-->
    <!--<meta http-equiv="no-cache">-->
    <!--<meta http-equiv="Expires" content="Tue, 30 Dec 2014 23:59:59 GMT">-->
    <!--<meta http-equiv="Cache-Control" content="no-cache">-->
    <!-- end no cache headers -->        
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
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url') ?>?ver=2.3" type="text/css" media="screen" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <script type="text/javascript">
      var djConfig = {
        parseOnLoad: true
      };
    </script>
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <!-- DynaTree library used in the new sidebar -->
    <link href="<?php bloginfo('template_directory'); ?>/libs/dynatree/1.2.6/skin-vista/ui.dynatree.css" rel="stylesheet" type="text/css">
    <link href="<?php bloginfo('template_directory'); ?>/toggle-switch.css" rel="stylesheet" type="text/css">
    <script src="<?php bloginfo('template_directory'); ?>/libs/dynatree/1.2.6/jquery.dynatree.min.js" type="text/javascript"></script>
    <script src="<?php bloginfo('template_directory'); ?>/libs/jBox/jBox.min.js"></script>
    <link href="<?php bloginfo('template_directory'); ?>/libs/jBox/jBox.css" rel="stylesheet">
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.scrollTo.js"></script>
    <link rel=" stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/libs/TinyTools/css/tinytools.tourtip.min.css">
    <script src="<?php bloginfo('template_directory'); ?>/libs/TinyTools/tinytools.tourtip.min.js"></script>
    <!--<link rel="stylesheet" href="/resources/demos/style.css">-->
    <script type="text/javascript">
      var firstime = false;
      var inst;
      var selectAll = true;
      jQuery(function($) {
        //$(document).ready(function() {
        // Attach the dynatree widget to an existing <div id="tree"> element
        // and pass the tree options as an argument to the dynatree() function:                
        $("#cFiltersList2").dynatree({
          children: treeData,
          selectMode: 3,
          checkbox: true,
          select: true,
          debugLevel: 0,
          onClick: function(node) {
            if (node.data.key == 'accord_data_layers') {
              $("#legend-button").addClass("selected").siblings().removeClass("selected");
              $("#legend-button").removeClass("haslegend");
              $("#layersDiv").show().siblings().hide();
              node.select(false);
            }
          },
          onActivate: function(node) {
            // A DynaTreeNode object is passed to the activation handler
            // Note: we also get this event, if persistence is on, and the page is reloaded.

            //showItemDetails
            if (node.data.url) {
              document.location = node.data.url;
//                          updateLayerVisibilityTree();
            }
//                            window.open(node.data.url);                       
          },
          onSelect: function(flag, node) {
            if (!node.data.url) {

              if (node.data.key == 'accord_ccafs_sites' || node.data.key == 'accord_video_testimonials' || node.data.key == 'accord_amkn_blog_posts' || node.data.key == 'accord_agtrials'
                      || node.data.key == 'accord_biodiv_cases' || node.data.key == 'accord_photo_testimonials' || node.data.key == 'accord_ccafs_activities' || node.data.key.match('taxio_')) {
                if (firstime && selectAll) {
                  updateDataLayerTree(true);
                  layersSwitch(node.data.key, flag);
                }
                validateSelect();
              }
            }
            if (node.data.key == 'accord_data_layers') {
              node.select(false);
            }
          },
          onCreate: function(node, nodeSpan) {
            $(nodeSpan).hover(function() {
              onListHover(node.data.key, node.data.url);
            }, function() {
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
            if (node.data.url) {
              document.location = node.data.url;
//                          updateLayerVisibilityTree();
            }
//                            window.open(node.data.url);                       
          },
          onSelect: function(flag, node) {
            if (!node.data.url) {

              if (node.data.key == 'accord_ccafs_sites' || node.data.key == 'accord_video_testimonials' || node.data.key == 'accord_amkn_blog_posts'
                      || node.data.key == 'accord_biodiv_cases' || node.data.key == 'accord_photo_testimonials' || node.data.key == 'accord_ccafs_activities' || node.data.key.match('taxio_')) {

//                          var points = node.tree.getSelectedNodes(); 
                if (firstime)
                  updateDataLayerTree(true);
              } else {
                updateLayerVisibilityTree(node, flag);
              }
            }
          },
          onCreate: function(node, nodeSpan) {
            $(nodeSpan).hover(function() {
              onListHover(node.data.key, node.data.url);
            }, function() {
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
            if (node.data.url) {
              document.location = node.data.url;
//                          updateLayerVisibilityTree();
            }
          },
          onSelect: function(flag, node) {
            if (!node.data.url) {

              if (node.data.key == 'accord_ccafs_sites' || node.data.key == 'accord_video_testimonials' || node.data.key == 'accord_amkn_blog_posts'
                      || node.data.key == 'accord_biodiv_cases' || node.data.key == 'accord_photo_testimonials' || node.data.key == 'accord_ccafs_activities' || node.data.key.match('taxio_')) {

//                          var points = node.tree.getSelectedNodes(); 
                if (firstime)
                  updateDataLayerRegionTree(flag);
              }
            }
          },
          onCreate: function(node, nodeSpan) {
            $(nodeSpan).hover(function() {
//                            onListHover(node.data.key,node.data.url);
            }, function() {
//                            onFeatureLeave();
            });
          }
        });
        $("#basemap-button").click(function() {
          $(this).addClass("selected").siblings().removeClass("selected");
          $("#basemapGallery").show().siblings().hide();
        });
        $("#legend-button").click(function() {
          $(this).addClass("selected").siblings().removeClass("selected");
          $(this).removeClass("haslegend");
          $("#layersDiv").show().siblings().hide();
        });
        $("#filter-button").click(function() {
          $(this).addClass("selected").siblings().removeClass("selected");
          $("#sourceMap").show().siblings().hide();
        });
        $("#region-button").click(function() {
          $(this).addClass("selected").siblings().removeClass("selected");
          $("#regions").show().siblings().hide();
        });

        $("#tools-button").click(function() {
          $(this).addClass("selected").siblings().removeClass("selected");
          $("#tools").show().siblings().hide();
        });

        $(document).on('click', '#closePrintMapWin', function() {
          $(this).parent().fadeTo(300, 0, function() {
            $(this).hide();
          });
        });

        $("#from").datepicker({
          changeMonth: true,
          changeYear: true,
          dateFormat: 'dd/mm/yy',
          numberOfMonths: 2,
          onClose: function(selectedDate) {
            $("#to").datepicker("option", "minDate", selectedDate);
          }
        });
        $("#to").datepicker({
          changeMonth: true,
          changeYear: true,
          dateFormat: 'dd/mm/yy',
          numberOfMonths: 2,
          onClose: function(selectedDate) {
            $("#from").datepicker("option", "maxDate", selectedDate);
          }
        });

        var a = getCookie("showmsg");
        if (null != a && "" != a && "true" == a) {
          noticeInitial();
        } else {
          // Remodal-master http://vodkabears.github.io/remodal/ 
          openLandingPage();
        }

//        $("#btnDeselectAll").click(function() {
//          $("#dataLayers").dynatree("getRoot").visit(function(node) {
//            node.select(false);
//          });
//          return false;
//        });
        $("#ckbSelectAll").click(function() {
          var status = false;
          selectAll = false;
          if ($(this).prop('checked'))
            status = true;
          $("#cFiltersList2").dynatree("getRoot").visit(function(node) {
            node.select(status);
            layersSwitch(node.data.key, status);
          });
          updateDataLayerTree(true);
          selectAll = true;
        });
        $(document).on('click', '.close_box', function() {
          $(this).parent().fadeTo(300, 0, function() {
            $(this).remove();
          });
        });
//              $(function() {
//                $( "#onthemap" ).draggable();
//              });
//              $( "#layersDiv" ).accordion({
//                heightStyle: "content"
//              });        
      });
      function scrollNew() {
        $.scrollTo($("div#featured"), 500);
        setTimeout(function() {
//          $("#container").animate({left: '15px'}, 200);
//          $("#container").animate({left: '0px'}, 200);
        }, 500);
      }
      function hideLayers() {
        $("#dataLayers").dynatree("getRoot").visit(function(node) {
          node.select(false);
        });
      }
      function openLandingPage() {
        $('.remodal').show();
        inst = $('[data-remodal-id=modal]').remodal({"hashTracking": false});
        inst.open()
      }
      function closeLandingPage() {
        inst.close();
        noticeInitial();
      }
      function applyShowMsg() {
        showmsg = document.getElementById("chk_showmsg").checked, null != showmsg && "" != showmsg && setCookie("showmsg", showmsg, 365)
      }
      function getCookie(a) {
        var b = document.cookie, c = b.indexOf(" " + a + "=");
        if (-1 == c && (c = b.indexOf(a + "=")), -1 == c)
          b = null;
        else {
          c = b.indexOf("=", c) + 1;
          var d = b.indexOf(";", c);
          -1 == d && (d = b.length), b = unescape(b.substring(c, d))
        }
        return b
      }
      function setCookie(a, b, c) {
        var d = new Date;
        d.setDate(d.getDate() + c);
        var e = escape(b) + (null == c ? "" : "; expires=" + d.toUTCString());
        document.cookie = a + "=" + e
      }
      function tour() {
        $("#onthemap").tourTip({
          title: "On the map",
          description: "This is a description for the newly born TourTip :)",
          previous: true,
          position: 'right'
        });
        $("#filter-button").tourTip({
          title: "On the map",
          description: "This is a description for the newly born TourTip :)",
          previous: true,
          position: 'right'
        });
        $("#legend-button").tourTip({
          title: "On the map",
          description: "This is a description for the newly born TourTip :)",
          previous: true,
          position: 'right'
        });
        $("#basemap-button").tourTip({
          title: "On the map",
          description: "This is a description for the newly born TourTip :)",
          previous: true,
          position: 'right'
        });
        $("#region-button").tourTip({
          title: "On the map",
          description: "This is a description for the newly born TourTip :)",
          previous: true,
          position: 'right'
        });
        $("#reset-button").tourTip({
          title: "On the map",
          description: "This is a description for the newly born TourTip :)",
          previous: true,
          position: 'right'
        });
        $("#container").tourTip({
          title: "The newest",
          description: "This is a description for the newly born TourTip :)",
          previous: true,
          position: 'top',
          close: true
        });
        $.tourTip.start();
      }

    </script>
    <!--<script type="text/javascript" src="http://serverapi.arcgisonline.com/jsapi/arcgis/?v=2.5compact"></script>-->
    <!--<link rel="stylesheet" href="http://js.arcgis.com/3.7/js/esri/css/esri.css">-->
    <link rel="stylesheet" href="http://js.arcgis.com/3.10/js/esri/css/esri.css">
    <script src="http://js.arcgis.com/3.10/"></script>
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
    <script>
      (function(i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function() {
          (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
      })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

      ga('create', '<?php echo get_option('google_analytics'); ?>', 'amkn.org');
      ga('create', 'UA-22478956-2', 'amkn.org', {'name': 'newTracker'});
      ga('send', 'pageview');
      ga('newTracker.send', 'pageview');


    </script>        
  </head>
  <body class="tundra">
    <div id="header">
      <div class="logos"><a href="<?php
        bloginfo('url');
        echo $var;
        ?>">
          <img class="amkn_logo" src="<?php bloginfo('template_directory'); ?>/images/amkn.gif" alt="AMKN logo" />
          <img class="ccafs_logo" src="<?php bloginfo('template_directory'); ?>/images/ccafs-logo.png" alt="CCAFS logo" /></a>
      </div><!-- end logos -->

      <div id="right-header">

        <div class="navbar">
          <!--<form action="/search/" id="searchform" method="get"><input type="text" value="" id="searchbar" name="q" /><input type="submit" value="Search" id="searchsubmit" /></form>-->   
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
          <form action=<?php echo get_bloginfo('wpurl') . "/search/" ?> id="searchform" method="get"><input type="text" value="" id="searchbar" name="q" /><input type="submit" value="Search" id="searchsubmit" /></form>
        </div><!-- end navbar -->
      </div><!-- end right-header -->
    </div> <!-- end Header -->