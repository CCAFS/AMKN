<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
$searchQ = $_GET["q"];
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
<?php if(is_archive()){ ?>
<meta name="robots" content="NOINDEX, FOLLOW" />
<?php } ?>
<?php get_template_part( 'geo', 'tag' ); ?>
<title><?php
/*
* Print the <title> tag based on what is being viewed.
*/
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";
	?></title>
<link rel="icon" type="image/png" href="<?php bloginfo( 'template_directory' ); ?>/images/favicon.png" />
<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="screen" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script type="text/javascript">
  var djConfig = {
    parseOnLoad: true
  };
</script>

<script type="text/javascript" src="http://serverapi.arcgisonline.com/jsapi/arcgis/?v=2.5compact">
</script>
</head>
<body>
<div id="header index" class="header-page">
<div class="logos"><a href="<?php bloginfo('url'); ?>">
<img class="amkn_logo" src="<?php bloginfo( 'template_directory' ); ?>/images/amkn.gif" alt="AMKN logo" />
<img class="ccafs_logo" src="<?php bloginfo( 'template_directory' ); ?>/images/ccafs-logo.png" alt="CCAFS logo" /></a>
</div><!-- end logos -->

<div id="right-header">
<div class="navbar">

<?php
$defaults = array(
  'container'       => 'none',
  'container_id'    => '',
  'menu_class'      => 'navigation',
  'menu_id'         => 'menu',
  'echo'            => true,
  'fallback_cb'     => 'wp_page_menu',
  'before'          => '',
  'after'           => '',
  'link_before'     => '',
  'link_after'      => '',
  'depth'           => 0,
  'walker'          => '');
//
wp_nav_menu( $defaults ); ?>
<form action="/search/" id="searchform" method="get"><input type="text" value="<?php echo $searchQ; ?>" id="searchbar" name="q" /><input type="submit" value="Search" id="searchsubmit" /></form>
</div><!-- end navbar -->
</div><!-- end right-header -->
</div> <!-- end Header -->
