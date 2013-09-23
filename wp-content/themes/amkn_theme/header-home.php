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

        <script type="text/javascript" src="http://serverapi.arcgisonline.com/jsapi/arcgis/?v=2.5compact">
        </script>
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
            <div class="logos"><a href="<?php bloginfo('url'); ?>">
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
                    <form action="/search/" id="searchform" method="get"><input type="text" value="" id="searchbar" name="q" /><input type="submit" value="Search" id="searchsubmit" /></form>
                </div><!-- end navbar -->


            </div><!-- end right-header -->

           
        </div> <!-- end Header -->
        <?php get_header('menu'); ?>