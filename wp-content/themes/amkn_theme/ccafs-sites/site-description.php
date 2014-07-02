
<div id="container-page">
   <div id="column1" class="borde1">
      <?php get_sidebar('sidemap'); ?>
      <?php $information = get_the_content(); 
            $information = apply_filters('the_content', $information);
            $information = str_replace(']]>', ']]&gt;', $information);?>
      
   </div>
   <div id="column2">
      <div id="column2-video" class="borde1">
        <?php load_template(TEMPLATEPATH . '/ccafs-sites/description/videos.php'); ?>
      </div>
      <div id="column2-info" class="borde1">
          <?php echo $information; ?>
      </div>

   </div>


</div><!-- end Container -->

<?php
  $embed = $_GET["embedded"];

  if (!isset($embed) || $embed != "1")
    get_footer();
?>