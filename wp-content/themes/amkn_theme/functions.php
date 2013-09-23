<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
/**
 * Make theme available for translation
 * Translations can be filed in the /languages/ directory
 * If you're building a theme based on AMKNToolbox, use a find and replace
 * to change 'AMKNToolbox' to the name of your theme in all the template files
 */
load_theme_textdomain('AMKNToolbox', TEMPLATEPATH . '/languages');



$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if (is_readable($locale_file))
   require_once( $locale_file );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if (!isset($content_width))
   $content_width = 640;

/**
 * This theme uses wp_nav_menu() in one location.
 */
register_nav_menus(array(
    'primary' => __('Primary Menu', 'AMKNToolbox'),
    'secondary' => __('Secondary Navigation', 'AMKNToolbox'),
));

/**
 * Add default posts and comments RSS feed links to head
 */
add_theme_support('automatic-feed-links');

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function AMKNToolbox_page_menu_args($args) {
   $args['show_home'] = true;



   return $args;
}

add_filter('wp_page_menu_args', 'AMKNToolbox_page_menu_args');

/**
 * Register widgetized area and update sidebar with default widgets
 */
function AMKNToolbox_widgets_init() {
   register_sidebar(array(
       'name' => __('Sidebar 1', 'AMKNToolbox'),
       'id' => 'sidebar-1',
       'before_widget' => '<aside id="%1$s" class="widget %2$s">',
       'after_widget' => "</aside>",
       'before_title' => '<h1 class="widget-title">',
       'after_title' => '</h1>',
   ));

   register_sidebar(array(
       'name' => __('Sidebar 2', 'AMKNToolbox'),
       'id' => 'sidebar-2',
       'description' => __('An optional second sidebar area', 'AMKNToolbox'),
       'before_widget' => '<aside id="%1$s" class="widget %2$s">',
       'after_widget' => "</aside>",
       'before_title' => '<h1 class="widget-title">',
       'after_title' => '</h1>',
   ));
}

add_action('init', 'AMKNToolbox_widgets_init');

/**
 * Calculates distances in kilometers
 * $point1,$point2 --> String - "-0.314705,35.022805"
 */
function distance($point1, $point2) {
   $coo1 = explode(',', trim($point1));
   $coo2 = explode(',', trim($point2));
   return sqrt(pow(($coo1[0] - $coo2[0]), 2) + pow(($coo1[1] - $coo2[1]), 2)) * 235;
}