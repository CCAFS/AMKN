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
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
    <meta name="robots" content="NOINDEX, NOFOLLOW" />
    <!--<meta name="viewport" content="minimum-scale=1.0; maximum-scale=1.0; user-scalable=true; initial-scale=1.0;"/>-->
    <?php get_template_part('geo', 'tag'); ?>
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
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

    <link href="<?php echo get_bloginfo('template_url'); ?>/css/reveal.css" rel="stylesheet" />
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      //<![CDATA[
      google.load("jquery", "1.4.2");
      google.load("jqueryui", "1.8.2");
      //]]>
    </script>
    <script type="text/javascript">
      var djConfig = {
        parseOnLoad: true
      };
    </script>
    <script type="text/javascript" src="http://serverapi.arcgisonline.com/jsapi/arcgis/?v=2.5compact">
    </script>
    <?php
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== FALSE) {
      ?>
      <style type="text/css">
        body{
          height: auto !important;
          overflow: scroll;
        }
        /*#popContent_pane{
            overflow: scroll !important;
        }*/
      </style>
      <?php }
    ?>
    <?php
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== FALSE) {
      ?>
      <style type="text/css">
        #embedPage{
          height: 600px !important;
          overflow: scroll !important;
        }
        /*#popContent_pane{
            overflow: scroll !important;
        }*/
      </style>        
      <?php }
    ?>
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
  <body class="embededO tundra">    
    <div id="embed">

