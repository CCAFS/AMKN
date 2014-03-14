<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
?>
<!-- footer starts here -->
<div id="footer" class="footer-page">

      
   <ul class="footerlogos">
      <li><a href="http://www.ciat.cgiar.org"><img src="<?php bloginfo('template_directory'); ?>/images/logo_ciat.png" alt="CIAT - International Center for Tropical Agriculture"/></a></li>
      <li><a href="http://www.cgiar.org"><img src="<?php bloginfo('template_directory'); ?>/images/logo_cgiar.png" alt="CGIAR"/></a></li>
      <li><a href="http://www.ccafs.cgiar.org/"><img src="<?php bloginfo('template_directory'); ?>/images/logo_ccafs.png" alt="The CGIAR Research Program on Climate Change, Agriculture and Food Security (CCAFS)"/></a></li>
   </ul>

    
    
   <ul class="sidelinks-footer">
   <?php
      $aboutPages = get_pages('child_of=5&sort_column=post_title');
           $currStyle = $post->ID == 5 ? "sidecurrent" : "";
      ?>
       <li><a class="<?php echo $currStyle; ?>" href="<?php echo get_page_link(5) ?>">About AMKN</a></li>
      <?php
      foreach($aboutPages as $pageA)
      {
      $currPStyle = $post->ID == $pageA->ID ? "sidecurrent" : "";
               ?>
       <li><a class="<?php echo $currPStyle; ?>" href="<?php echo get_page_link($pageA->ID) ?>"><?php echo $pageA->post_title ?></a></li>
      <?php
      }
   ?>
   </ul>

   <?php get_sidebar( 'follow' ); ?>
 


</div><!-- end Footer -->
<script type="text/javascript">
   var _gaq = _gaq || [];
   _gaq.push(['_setAccount', '<?php echo get_option('google_analytics'); ?>']);
   _gaq.push(['_trackPageview']);
   _gaq.push(['_trackPageLoadTime']);
   (function() {
      var ga = document.createElement('script');
      ga.type = 'text/javascript';
      ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0];
      s.parentNode.insertBefore(ga, s);
   })();
</script>

<?php wp_footer(); ?>
</body>

</html>
