<?php
$subsection = $_GET["subsection"];
$section = $_GET["section"];
$class = 'class="selected"';
$ltab = './?section=' . $section . '&subsection=';

$ccafsSubSections = array("on-farm", "off-farmcash", "diversification");
?>
<style>
    #vtab ul li {
        height: 93px;
        padding-top: 22px;
    }
</style>
<div id="container">

    <div id="vtab" class="4tabs"> 

        <ul>
            <li <?php if (!$subsection) echo $class; ?>>
                <a href="<?php echo $ltab; ?>">
                    <img src="<?php bloginfo('template_directory'); ?>/ccafs-sites/images/hunger-months.png" border="0"><br> Food Sources</a>
            </li>
            <li <?php if ($subsection == $ccafsSubSections[0]) echo $class; ?>>
                <a href="<?php echo $ltab . $ccafsSubSections[0]; ?>">
                    <img src="<?php bloginfo('template_directory'); ?>/ccafs-sites/images/crop-calendar.png" border="0"><br>On-farm diversity</a>
            </li>
            <li <?php if ($subsection == $ccafsSubSections[1]) echo $class; ?>>
                <a href="<?php echo $ltab . $ccafsSubSections[1]; ?>">
                    <img src="<?php bloginfo('template_directory'); ?>/ccafs-sites/images/climate-crises.png" border="0"><br>Off-farmcash resorces</a>
            </li>
            <li <?php if ($subsection == $ccafsSubSections[2]) echo $class; ?>>
                <a href="<?php echo $ltab . $ccafsSubSections[2]; ?>">
                    <img src="<?php bloginfo('template_directory'); ?>/ccafs-sites/images/food-security.png" border="0"><br>Diversification indices</a>
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