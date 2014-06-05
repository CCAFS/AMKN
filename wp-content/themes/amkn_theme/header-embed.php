<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
<meta name="robots" content="NOINDEX, NOFOLLOW" />
<meta name="viewport" content="minimum-scale=1.0; maximum-scale=1.0; user-scalable=true; initial-scale=1.0;"/>
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
<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="screen" />

<?php wp_head(); ?>
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
if (strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== FALSE){ 
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
    <?php 
}?>
<?php 
if (strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== FALSE){ 
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
    <?php 
}?>
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
<body class="embededO tundra">
<div id="embedPage">

