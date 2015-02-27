<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
global $post;
?>
<?php wp_reset_query(); ?>
<script type="text/javascript">
//<![CDATA[ 
  var fUd = false;
<?php
$args = array(
  'post_type' => 'layer_group',
  'posts_per_page' => -1,
  'order' => 'ASC',
  'meta_key' => 'mapserverUrl'
);
$the_query = new WP_Query($args);
if ($the_query->have_posts()) :
  while ($the_query->have_posts()) :
    $the_query->the_post();
    $meta_value = get_post_meta(get_the_ID(), 'mapserverUrl', true);
    ?>
      var aglyr<?php echo get_the_ID() ?>;
    <?php
  endwhile;
endif;
wp_reset_postdata();
?>
  function addDataLayers()
  {
<?php
$args = array(
  'post_type' => 'layer_group',
  'posts_per_page' => -1,
  'order' => 'ASC',
  'meta_key' => 'mapserverUrl'
);
$the_query = new WP_Query($args);
if ($the_query->have_posts()) :
  while ($the_query->have_posts()) :
    $the_query->the_post();
    $meta_value = get_post_meta(get_the_ID(), 'mapserverUrl', true);
    $cache = get_post_meta(get_the_ID(), 'fused_cache', true);
    if ($cache == 'TRUE' || $cache == 'true') :
      ?>
          aglyr<?php echo get_the_ID() ?> = new esri.layers.ArcGISTiledMapServiceLayer("<?php echo $meta_value; ?>");
      <?php
    else :
      ?>
          aglyr<?php echo get_the_ID() ?> = new esri.layers.ArcGISDynamicMapServiceLayer("<?php echo $meta_value; ?>");
    <?php
    endif;
    ?>
        aglyr<?php echo get_the_ID(); ?>.id = "aglyr<?php echo get_the_ID(); ?>";
        aglyr<?php echo get_the_ID() ?>.visibility = !1;
        aglyr<?php echo get_the_ID() ?>.hide();
        legendLayers.push({layer: aglyr<?php echo get_the_ID(); ?>, title: ''});
        tLayers.push(aglyr<?php echo get_the_ID(); ?>);
        dojo.connect(aglyr<?php echo get_the_ID(); ?>, "onError", function(error) {
          var layer<?php echo get_the_ID(); ?> = new dijit.TooltipDialog({
            content: "No layers were found"
          });
        });
        dojo.connect(aglyr<?php echo get_the_ID(); ?>, "onLoad", function(aglyr<?php echo get_the_ID(); ?>) {
          dojo.connect(aglyr<?php echo get_the_ID(); ?>, "onUpdateStart", showLoading);
          dojo.connect(aglyr<?php echo get_the_ID(); ?>, "onUpdateEnd", hideLoading);
          dojo.connect(aglyr<?php echo get_the_ID(); ?>, "onVisibilityChange", rLegend);
        });
    <?php
  endwhile;
endif;
wp_reset_postdata();
?>
    map.addLayers(tLayers);
    dojo.connect(map, "onLayersAddResult", sLeg);
  }
  function sLeg(results) {
    legend = new esri.dijit.Legend({
      map: map,
      layerInfos: legendLayers
    }, "legendDiv");
    rLegend();
  }
  function addInitLayers()
  {
<?php
if ($the_query->have_posts()) :
  while ($the_query->have_posts()) :
    $the_query->the_post();
    ?>
        if (((typeof vLyr != "undefined") && vLyr != "") && fUd == false && vLyr.split("|")[0] == "aglyr<?php echo get_the_ID(); ?>") {
          fUd = true;
          updateInitLyr(vLyr.split("|")[1], vLyr.split("|")[0], vLyr.split("|")[2]);
          rLegend();
        }
    <?php
  endwhile;
endif;
?>
  }
//]]>
</script>