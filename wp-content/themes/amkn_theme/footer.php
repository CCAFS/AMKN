<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
?>
<!-- footer starts here -->
<div id="footer" class="footer-page">
  
<ul class="footercredits">
<li>Supported by the <a href="http://ictkm.cgiar.org/">Communications and Knowledge Team of the CGIAR Consortium</a></li>
</ul>    
<ul class="footerlogos">
<li><a href="http://www.ciat.cgiar.org"><img src="<?php bloginfo( 'template_directory' ); ?>/images/logo1.png" alt="CIAT - International Center for Tropical Agriculture"/></a></li>
<li><a href="http://www.essp.org/"><img src="<?php bloginfo( 'template_directory' ); ?>/images/logo2.png" alt="Earth System Science Partnership (ESSP)"/></a></li>
<li><a href="http://www.cgiar.org"><img src="<?php bloginfo( 'template_directory' ); ?>/images/logo3.png" alt="CGIAR"/></a></li>
<li><a href="http://www.ccafs.cgiar.org/"><img src="<?php bloginfo( 'template_directory' ); ?>/images/ccafs_sm.png" alt="The CGIAR Research Program on Climate Change, Agriculture and Food Security (CCAFS)"/></a></li>
</ul>
    
    <div class="credits"><a href="/about/disclaimer/">Disclaimer</a> <a href="/about/credits/">Credits</a></div>
</div><!-- end Footer -->
<script type="text/javascript" charset="utf-8">
  var is_ssl = ("https:" == document.location.protocol);
  var asset_host = is_ssl ? "https://s3.amazonaws.com/getsatisfaction.com/" : "http://s3.amazonaws.com/getsatisfaction.com/";
  document.write(unescape("%3Cscript src='" + asset_host + "javascripts/feedback-v2.js' type='text/javascript'%3E%3C/script%3E"));
</script>

<script type="text/javascript" charset="utf-8">
  var feedback_widget_options = {};

  feedback_widget_options.display = "overlay";  
  feedback_widget_options.company = "ccafs-amkn";
  feedback_widget_options.placement = "right";
  feedback_widget_options.color = "#55322B";
  feedback_widget_options.style = "idea";
  
  
  
  
  
  
  

  var feedback_widget = new GSFN.feedback_widget(feedback_widget_options);
</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo get_option('google_analytics'); ?>']);
  _gaq.push(['_trackPageview']);
  _gaq.push(['_trackPageLoadTime']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<?php wp_footer(); ?>
</body>

</html>
