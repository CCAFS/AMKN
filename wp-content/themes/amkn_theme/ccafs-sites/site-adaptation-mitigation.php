<?php
$subsection = $_GET["subsection"];
$section = $_GET["section"];
$class = 'class="selected"';
$ltab = './?section=' . $section . '&subsection='; 
$ccafsSubSections = array("mitigation-activities", "cropping-changes", "management-changes");
?> 
<div id="container"> 
    <div id="vtab" class="tabs4">  
        <ul>
            <li <?php if (!$subsection) echo $class; ?>>
                <a href="<?php echo $ltab; echo (isset($_GET["embedded"]))?'&embedded='.$_GET["embedded"]:'';?>">
                    <img src="<?php bloginfo('template_directory'); ?>/ccafs-sites/images/food-security.png" border="0"><br> Adaptability index</a>
            </li>
            <li <?php if ($subsection == $ccafsSubSections[0]) echo $class; ?>>
                <a href="<?php echo $ltab . $ccafsSubSections[0]; echo (isset($_GET["embedded"]))?'&embedded='.$_GET["embedded"]:'';?>">
                    <img src="<?php bloginfo('template_directory'); ?>/ccafs-sites/images/climate-crises.png" border="0"><br> Mitigation activities</a>
            </li>
            <li <?php if ($subsection == $ccafsSubSections[1]) echo $class; ?>>
                <a href="<?php echo $ltab . $ccafsSubSections[1]; echo (isset($_GET["embedded"]))?'&embedded='.$_GET["embedded"]:'';?>">
                    <img src="<?php bloginfo('template_directory'); ?>/ccafs-sites/images/climate-crises.png" border="0"><br>Cropping changes</a>
            </li>
            <li <?php if ($subsection == $ccafsSubSections[2]) echo $class; ?>>
                <a href="<?php echo $ltab . $ccafsSubSections[2]; echo (isset($_GET["embedded"]))?'&embedded='.$_GET["embedded"]:'';?>">
                    <img src="<?php bloginfo('template_directory'); ?>/ccafs-sites/images/management-changes.png" border="0"><br>Management changes</a>
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
  $embed = $_GET["embedded"];

  if (!isset($embed) || $embed != "1")
    get_footer();
?>