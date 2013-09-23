<?php
$subsection = $_GET["subsection"];
$section = $_GET["section"];
$class = 'class="selected"';
$ltab = './?section=' . $section . '&subsection=';

$ccafsSubSections = array("crop-calendar", "land-use", "hunger-months", "climate-crises", "food-security");
?>
<div id="container">

   <div id="vtab"> 
      <ul>
         <li <?php if (!$subsection) echo $class; ?>>
            <a href="<?php echo $ltab; ?>">
               <img src="<?php bloginfo('template_directory'); ?>/ccafs-sites/images/crops-livestock.png" border="0"><br> Crops & Livestock</a>
         </li>
         <li <?php if ($subsection == $ccafsSubSections[0]) echo $class; ?>>
            <a href="<?php echo $ltab . $ccafsSubSections[0]; ?>">
               <img src="<?php bloginfo('template_directory'); ?>/ccafs-sites/images/crop-calendar.png" border="0"><br>Crop Calendar</a>
         </li>
         <li <?php if ($subsection == $ccafsSubSections[1]) echo $class; ?>>
            <a href="<?php echo $ltab . $ccafsSubSections[1]; ?>">
               <img src="<?php bloginfo('template_directory'); ?>/ccafs-sites/images/land-use.png" border="0"><br>Land use</a>
         </li>
         <li <?php if ($subsection == $ccafsSubSections[2]) echo $class; ?>>
            <a href="<?php echo $ltab . $ccafsSubSections[2]; ?>">
               <img src="<?php bloginfo('template_directory'); ?>/ccafs-sites/images/hunger-months.png" border="0"><br>Hunger months</a>
         </li>
         <li <?php if ($subsection == $ccafsSubSections[3]) echo $class; ?>>
            <a href="<?php echo $ltab . $ccafsSubSections[3]; ?>">
                <img src="<?php bloginfo('template_directory'); ?>/ccafs-sites/images/climate-crises.png" border="0"><br>Climate crises</a>
         </li> 
         <li <?php if ($subsection == $ccafsSubSections[4]) echo $class; ?>>
            <a href="<?php echo $ltab . $ccafsSubSections[4]; ?>">
                <img src="<?php bloginfo('template_directory'); ?>/ccafs-sites/images/food-security.png" border="0"><br>Food Security</a>
         </li>
      </ul>
      <div>
         <?php 
         if (in_array($subsection, $ccafsSubSections)) {
            load_template(TEMPLATEPATH . '/ccafs-sites/' . $section . '/' . $subsection . '.php');
         } else {
            load_template(TEMPLATEPATH . '/ccafs-sites/' . $section . '/default.php');
         }
         ?>
      </div>
   </div><!-- end vtab -->


   </div><!-- end Container -->

   <?php
   get_footer();
   ?>