<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
//CCAFS - SITES
//- Description (description)
//
//- Quick facts (quick-facts)
//	- Main crops & Livestock
//	- Crop Calendar
//	- Land use
//	- Hunger months
//	- Climate crises
//	- Food Security
//
//- Food & Livelihood (food-livelihood)
//	- Food Sources
//	- On-farm diversity
//	- Off-farmcash resorces
//	- Diversification indices
//
//- Climate &Impacts (climate-impacts)
//	- Weather predictions
//	- Weather info sources
//	- Communication assets
//	- Aspects of farming changed
//
//- Adaptation & Mitigation (adaptation-mitigation)
//	- Adaptability  index
//	- Mitigation activities
//	- Cropping changes
//	- Management changes
//
//- Gender (gender)
//	- Workload by gender
//	- Female-headed households
//	- Gender & weather information
//
//- Ongoing Research (ongoing-research)
//
//- Tools & Data (tools-data )


$metaDesc = get_post_meta($post->ID, 'content_description', true);
$embed = $_GET["embedded"];
$section = $_GET["section"];

$bmsId = get_post_meta($post->ID, 'siteId', true);
$description = $wpdb->get_row("SELECT * FROM bs_descriptions WHERE bms_id='" . $bmsId . "'");
if (isset($embed) && $embed == "1") :
  get_header('embed');
  ?>
  <div class="top-banner">
    To view the full version click <a target="_blank" href="./?p=<?php echo $post->ID ?>" onclick="window.close();" id="ar-top-banner">here</a>
  </div>
<?php
else:
  get_header('page');
  ?>
  <script>
    if (typeof document.getElementById("menu-item-3840") != 'undefined')
      document.getElementById("menu-item-3840").className += ' current-menu-item';
  </script>
<?php endif;
?>
</div> <!-- end Header -->
<script src="<?php echo get_bloginfo('template_url'); ?>/ccafs-sites/js/jquery.bxslider.min.js"></script>
<link href="<?php echo get_bloginfo('template_url'); ?>/ccafs-sites/css/jquery.bxslider.css" rel="stylesheet" />
<script src="<?php echo get_bloginfo('template_url'); ?>/ccafs-sites/js/sliders.js"></script>

<div id="header-sites">
  <div class="title-page">
    <h2 class="title"><?php the_title(); ?>
      <em style="font-size:32px">(<?php echo get_post_meta($post->ID, 'siteCountry', true); ?>)</em>
    </h2>
    <div id="column2-photos" class="photos">
<?php load_template(TEMPLATEPATH . '/ccafs-sites/photos.php'); ?>
    </div>  
  </div>  
  <script src="<?php echo get_bloginfo('template_url'); ?>/js/jquery.reveal.js" type="text/javascript"></script>
  <?php
//Load Menu with pin $section on
  $class = 'class="current-menu-item"';
  ?>
  <div class="mainmenu"> 
    <ul id="Mainmenu" class="Mainmenu">
      <li <?php if ($section == '') echo $class; ?>><a  href="./<?php echo (isset($_GET["embedded"])) ? '?embedded=' . $_GET["embedded"] : ''; ?>"><span>Description</span></a></li>
  <?php if ($description) :?>
      <li <?php if ($section == 'quick-facts') echo $class; ?>><a href="./?section=quick-facts<?php echo (isset($_GET["embedded"])) ? '&embedded=' . $_GET["embedded"] : ''; ?>"><span>Quick facts</span></a></li>
      <li <?php if ($section == 'food-livelihood') echo $class; ?>><a href="./?section=food-livelihood<?php echo (isset($_GET["embedded"])) ? '&embedded=' . $_GET["embedded"] : ''; ?>"><span>Food & Livelihood</span></a></li>
      <li <?php if ($section == 'climate-impacts') echo $class; ?>><a href="./?section=climate-impacts<?php echo (isset($_GET["embedded"])) ? '&embedded=' . $_GET["embedded"] : ''; ?>"><span>Climate & Impacts</span></a></li>
      <li <?php if ($section == 'adaptation-mitigation') echo $class; ?>><a href="./?section=adaptation-mitigation<?php echo (isset($_GET["embedded"])) ? '&embedded=' . $_GET["embedded"] : ''; ?>"><span>Adaptation & Mitigation</span></a></li>
      <li <?php if ($section == 'gender') echo $class; ?>><a href="./?section=gender<?php echo (isset($_GET["embedded"])) ? '&embedded=' . $_GET["embedded"] : ''; ?>"><span>Gender</span></a></li>
      <!--<li <?php if ($section == 'ongoing-research') echo $class; ?>><a href="./?section=ongoing-research"><span>Ongoing Research</span></a></li>-->
      <!--<li <?php if ($section == 'tools-data') echo $class; ?>><a href="./?section=tools-data"><span>Tools & Data</span></a></li>-->
  <?php endif;?>
    </ul> 
  </div><!-- end mainmenu -->
</div>
<div class="borde-menu"> </div>
<?php
//Load information of CCAFS Sites
$ccafsSections = array("quick-facts", "food-livelihood", "climate-impacts", "adaptation-mitigation", "gender");
if (in_array($section, $ccafsSections)) {
  load_template(TEMPLATEPATH . '/ccafs-sites/site-' . $section . '.php');
} else {
  load_template(TEMPLATEPATH . '/ccafs-sites/site-description.php');
}
?>
