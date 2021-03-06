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
function custom_excerpt_length( $length ) {
  return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/**
 * Calculates distances in kilometers
 * $point1,$point2 --> String - "-0.314705,35.022805"
 */
function distance($point1, $point2) {
   $coo1 = explode(' ', trim($point1));
   $coo2 = explode(' ', trim($point2));
   return sqrt(pow(($coo1[0] - $coo2[0]), 2) + pow(($coo1[1] - $coo2[1]), 2)) * 235;
}



/**
 * Function to get an image of post
 */
function postimage($postId) {
    $scriptpath = get_bloginfo('template_directory');   
    $attachments = get_children(array('post_parent' => $postId, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order'));   
    if (empty($attachments)) {       
        $src_file = get_bloginfo('wpurl').'/wp-includes/images/noPicLarge.png';
        return $src_file;
    } else if (has_post_thumbnail($postId)) {
        $featuredImage = wp_get_attachment_image_src(get_post_thumbnail_id($postId), 'single-post-thumbnail');
        return $featuredImage[0];
    } else {
        $img = array_shift($attachments);        
        $imagelink = wp_get_attachment_image_src($img->ID, 'full');
        $image = $imagelink[0];
        return $image;
    }
}

function catch_that_image($post) {
  
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];

  if(empty($first_img)){ //Defines a default image
    $first_img = bloginfo('template_url')."/images/default.png";
  }
  return $first_img;
}

function date_format_wp ($date) {
  $date = explode('/',$date);
  return $date[2].$date[1].$date[0];
}

/**
 * trims text to a space then adds ellipses if desired
 * @param string $input text to trim
 * @param int $length in characters to trim to
 * @param bool $ellipses if ellipses (...) are to be added
 * @param bool $strip_html if html tags are to be stripped
 * @return string 
 */
function trim_text($input, $length, $ellipses = true, $strip_html = true) {
    //strip tags, if desired
    if ($strip_html) {
        $input = strip_tags($input);
    }
  
    //no need to trim, already shorter than trim length
    if (strlen($input) <= $length) {
        return $input;
    }
  
    //find last space within length
    $last_space = strrpos(substr($input, 0, $length), ' ');
    $trimmed_text = substr($input, 0, $last_space);
  
    //add ellipses (...)
    if ($ellipses) {
        $trimmed_text .= '...';
    }
    return $trimmed_text;
}

function cgValidate($text) {
  $exct = array('RPL EA','RPL LAM','RPL SAs','RPL WA','Theme 1', 'Theme 2', 'Theme 3', 'Theme 4.1', 'Theme 4.2', 'Theme 4.3');
  if (in_array($text, $exct))
    return true;
  return false;
}

if( !function_exists('get_the_content_with_format') ):
function get_the_content_with_format ($more_link_text = '', $stripteaser = 0, $more_file = '') {
$content = get_the_content($more_link_text, $stripteaser, $more_file);
$content = apply_filters('the_content', $content);
$content = strip_tags($content, '<p><a>');
return $content;
}
endif;
