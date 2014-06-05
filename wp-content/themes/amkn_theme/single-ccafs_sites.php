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
$embed = $_GET["embeddded"];
$section = $_GET["section"];

if (isset($embed) && $embed == "1") {
   get_header('embed');
} else {
   get_header('page');
}
?>
</div> <!-- end Header -->
<div id="header-sites">
<div class="title-page">
   <h2 class="title"><?php the_title(); ?>
      <em style="font-size:32px">(<?php echo get_post_meta($post->ID, 'siteCountry', true); ?>)</em>
   </h2>
   <div class="photos">
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
         <li <?php if ($section == '') echo $class; ?>><a  href="./"><span>Description</span></a></li>
         <li <?php if ($section == 'quick-facts') echo $class; ?>><a href="./?section=quick-facts"><span>Quick facts</span></a></li>
         <li <?php if ($section == 'food-livelihood') echo $class; ?>><a href="./?section=food-livelihood"><span>Food & Livelihood</span></a></li>
         <li <?php if ($section == 'climate-impacts') echo $class; ?>><a href="./?section=climate-impacts"><span>Climate & Impacts</span></a></li>
         <li <?php if ($section == 'adaptation-mitigation') echo $class; ?>><a href="./?section=adaptation-mitigation"><span>Adaptation & Mitigation</span></a></li>
         <li <?php if ($section == 'gender') echo $class; ?>><a href="./?section=gender"><span>Gender</span></a></li>
         <!--<li <?php if ($section == 'ongoing-research') echo $class; ?>><a href="./?section=ongoing-research"><span>Ongoing Research</span></a></li>-->
         <!--<li <?php if ($section == 'tools-data') echo $class; ?>><a href="./?section=tools-data"><span>Tools & Data</span></a></li>-->
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
<script>
  if (typeof document.getElementById("menu-item-4302") != 'undefined')
    document.getElementById("menu-item-4302").className += ' current-menu-item';
</script>
<script src="<?php echo get_bloginfo('template_url'); ?>/ccafs-sites/js/jquery.bxslider.min.js"></script>
<link href="<?php echo get_bloginfo('template_url'); ?>/ccafs-sites/css/jquery.bxslider.css" rel="stylesheet" />
<script src="<?php echo get_bloginfo('template_url'); ?>/ccafs-sites/js/sliders.js"></script>
