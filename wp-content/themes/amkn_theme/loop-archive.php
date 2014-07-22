<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
//echo $_COOKIE['lastDateTmp'] . "$#";
global $query_string; // required
$date = array();
$dateArg = array();
$paged = get_query_var('paged');
$filt = '';

if ($_GET['initDate'] != '') {
  $initDate = explode('/', $_GET['initDate']);
  $date['after'] = array('year' => $initDate[2], 'month' => $initDate[1], 'day' => $initDate[0]);
  $dateFormat = explode('/', $_GET['initDate']);
  $filt .='Start date ' . date('d F, Y', strtotime($dateFormat[1] . '/' . $dateFormat[0] . '/' . $dateFormat[2])) . "<br>";
}

if ($_GET['endDate'] != '') {
  $endDate = explode('/', $_GET['endDate']);
  $date['before'] = array('year' => $endDate[2], 'month' => $endDate[1], 'day' => $endDate[0]);
  $dateFormat = explode('/', $_GET['endDate']);
  $filt .='End date ' . date('d F, Y', strtotime($dateFormat[1] . '/' . $dateFormat[0] . '/' . $dateFormat[2])) . "<br>";
}

if (count($date)) {
  $dateArg = array(
    'date_query' => array(
      $date,
      'inclusive' => false
    )
  );
}

if (get_query_var('post_type') == 'ccafs_sites') {
  $args = $query_string . '&posts_per_page=16&order=ASC&orderby=meta_value&meta_key=ccafs_region';
  $args = array_merge($dateArg, array(
    'post_type' => get_query_var('post_type'),
    'orderby' => 'meta_value',
    'order' => 'ASC',
    'posts_per_page' => '16',
    'meta_key' => 'ccafs_region'
  ));
  $regions = $_GET["region"];
  $meta = array();
  if (count($regions) && $regions != 'all') {
    $meta = array('realtion' => 'OR');
    //  foreach($regions as $region){
    $meta[] = array('key' => 'ccafs_region', 'value' => $regions);
    //  }
  }
  //$meta = array('realtion' => 'OR', array('key' => 'ccafs_region', 'value' => 'East Africa'), array('key' => 'ccafs_region', 'value' => 'South Asia'));
  $qargs = array(
    'post_type' => 'ccafs_sites',
    'posts_per_page' => '-1',
    'orderby' => 'meta_value',
    'order' => 'ASC',
    'meta_key' => 'ccafs_region'
  );
  if (count($meta)) {
    $args = array_merge(array('meta_query' => $meta), $qargs);
  } else {
    $args = array(
      'post_type' => 'ccafs_sites',
      'posts_per_page' => '-1',
      'orderby' => 'meta_value',
      'order' => 'ASC',
      'meta_key' => 'ccafs_region'
    );
  }
} else {
//  $args = $query_string.'&posts_per_page=16&order=DESC&orderby=date';
  $args = array_merge($dateArg, array(
    'post_type' => get_query_var('post_type'),
    'orderby' => 'date',
    'order' => 'DESC',
    'posts_per_page' => '16',
    'paged' => $paged
  ));
}

if ($_GET['keyword'] != '0' && $_GET['keyword'] != '') {
  $mypostids = $wpdb->get_col("select ID from " . $wpdb->posts . " where post_type = '" . get_query_var('post_type') . "' AND (post_title like '%" . $_GET['keyword'] . "%' OR post_content like '%" . $_GET['keyword'] . "%')");
  $args = array_merge($args, array('post__in' => $mypostids));
  $filt .='Keyword ' . $_GET['keyword'] . "<br>";
}

$posts = query_posts($args);
global $wp_query;
//$plural = ($wp_query->found_posts>1)?'s':'';
if ($post->post_type != 'ccafs_sites')
  echo "<h3>Found " . $wp_query->found_posts . "<br><i style='font-family: -webkit-body;font-size: 0.75em;'>" . substr_replace(trim($filt), "", -1) . "</i></h3>";
$tmpregion = '';
//echo "<pre>".print_r($args,true)."</pre>";echo "**";
?>
<?php /* Start the Loop */ ?>
<?php //query_posts('posts_per_page=10');   ?>
<?php
while (have_posts()) : the_post();
  $postType = $post->post_type;
  $postId = $post->ID;
  $postThumb = "";
  ?>
  <!--<div id="archive-entry">-->
  <?php
  $region = get_post_meta($post->ID, 'ccafs_region', true);
  ?>
  <?php if ($postType == 'ccafs_sites'): ?>
    <div id="<?php echo $post->ID ?>" class="<?php echo $postType; ?>" onmouseover="openDialog(markerArray[<?php echo $post->ID ?>])">
    <?php else: ?>
      <div id="<?php echo $post->ID ?>" class="videocolumn <?php echo $postType; ?>" style="position: relative">
        <?php if (strtotime($_COOKIE['lastDateTmp']) < strtotime(get_the_date()) ): ?>
          <img style="right:0; position:absolute" src="<?php bloginfo('template_directory'); ?>/images/new-icon.png" alt="New item" height="30" width="30" /> 
        <?php endif; ?>
      <?php endif; ?>
      <?php
      switch ($postType) {
        case "video_testimonials":
          $firstPostThumb = get_post_meta($post->ID, 'thumb', true);
          $postThumb = substr($firstPostThumb, 0, strrpos($firstPostThumb, '/') + 1) . "0.jpg";
          $metaDesc = get_post_meta($post->ID, 'content_description', true);
          if (strlen($metaDesc) > 75) {
            $metaDesc = substr($metaDesc, 0, 75) . "...";
          }
          $tTitle = $post->post_title;
          if (strlen($tTitle) > 35) {
            $tTitle = substr($tTitle, 0, 35) . "...";
          }
          ?>
          <script>
            if (typeof document.getElementById("menu-item-3842") != 'undefined')
              document.getElementById("menu-item-3842").className += ' current-menu-item';
          </script>          
          <div class="videoteaser">
            <img class="videotitleico" src="<?php bloginfo('template_directory'); ?>/images/<?php echo $postType; ?>-mini.png" alt="Video Testimonials"/> 
            <h2 class="teasertitle"><a href="<?php the_permalink(); ?>"><?php echo $tTitle; ?></a></h2>
            <div class="entrymeta" style="padding-left: 15px;">Posted on <?php echo get_the_date(); ?></div>
            <a href="<?php the_permalink(); ?>"><img class="image"   src="<?php echo $postThumb; ?>" alt="Video Testimonials" /></a>
            <p><?php echo $metaDesc; ?></p>
          </div>



          <?php
          break;
        case "photo_testimonials":
          $postThumb = get_post_meta($post->ID, 'galleryThumb', true);
          $metaDesc = get_post_meta($post->ID, 'content_description', true);
          if (strlen($metaDesc) > 75) {
            $metaDesc = substr($metaDesc, 0, 75) . "...";
          }

          $tTitle = $post->post_title;
          if (strlen($tTitle) > 35) {
            $tTitle = substr($tTitle, 0, 35) . "...";
          }
          ?>
          <script>
            if (typeof document.getElementById("menu-item-3842") != 'undefined')
              document.getElementById("menu-item-3842").className += ' current-menu-item';
          </script>
          <div class="videoteaser">
            <img class="videotitleico" src="<?php bloginfo('template_directory'); ?>/images/<?php echo $postType; ?>-mini.png" alt="Video Testimonials"/> <h2 class="teasertitle"><a href="<?php the_permalink(); ?>"><?php echo $tTitle; ?></a></h2>
            <div class="entrymeta" style="padding-left: 15px;">Posted on <?php echo get_the_date(); ?></div>
            <a href="<?php the_permalink(); ?>"><img class="image" src="<?php echo $postThumb; ?>" alt="Video Testimonials" /></a>
            <p><?php echo $metaDesc; ?></p>
          </div>



          <?php
          break;
        case "amkn_blog_posts":
          $tEx = $post->post_excerpt;
          if (strlen($tEx) > 500) {
            $tEx = substr($tEx, 0, 500) . "...";
          }
          $ttitle = $post->post_title;
          if (strlen($ttitle) > 80) {
            $ttitle = substr($ttitle, 0, 80) . "...";
          }
          ?>
          <script>
            if (typeof document.getElementById("menu-item-3842") != 'undefined')
              document.getElementById("menu-item-3842").className += ' current-menu-item';
          </script>
          <div class="entry">
            <div class="image" style="background: url(<?php echo catch_that_image($post); ?>) center;background-repeat:no-repeat;" ></div>
            <h2 class="entrytitle"><a href="<?php the_permalink(); ?>"><?php echo htmlspecialchars_decode($ttitle); ?></a></h2>
            <div class="entrymeta">Posted by <?php the_author(); ?> on <?php echo get_the_date(); ?><!--  | <a href="<?php comments_link(); ?>"><?php comments_number('no responses', 'one response', '% responses'); ?></a>--><?php echo get_the_tag_list(' | ', ', ', ''); ?> </div>
            <p><?php echo $tEx; ?></p>
            <p><a href="<?php the_permalink(); ?>"><span class="button-more">Read more</span></a></p>
          </div>
          <?php
          break;
        case "ccafs_sites":
          //$postThumb = get_the_post_thumbnail($post->ID, array(130,224) );
//    $region = get_post_meta($post->ID, 'ccafs_region', true);
          $geoRSSPoint = get_post_meta($post->ID, 'geoRSSPoint', true);
          $sideId = get_post_meta($post->ID, 'siteId', true);
          $blockName = get_post_meta($post->ID, 'blockName', true);
          $geoPoint = str_ireplace(" ", ",", trim($geoRSSPoint));
          $sURL = str_ireplace("http://", "", site_url());
          $sURL = "amkn.org";
//    $staticMapURL = "http://maps.google.com/maps/api/staticmap?center=".$geoPoint."&zoom=4&size=70x70&markers=icon:http%3A%2F%2F".$sURL."%2Fwp-content%2Fthemes%2Famkn_theme%2Fimages%2F".$post->post_type."-mini.png|".$geoPoint."&maptype=roadmap&sensor=false";
          $tEx = $post->post_excerpt;
          if (strlen($tEx) > 75) {
            $tEx = substr($tEx, 0, 75) . "...";
          }
          $args4Countries = array('fields' => 'names');
          $cgMapCountries = wp_get_object_terms($post->ID, 'cgmap-countries', $args4Countries);
          $country = get_post_meta($post->ID, 'siteCountry', true);
          $village = get_post_meta($post->ID, 'village', true);
          $city = get_post_meta($post->ID, 'city', true);
          $area = get_post_meta($post->ID, 'area', true);
          if ($village)
            $showLocality = $village;
          else if ($city)
            $showLocality = $city;
          else
            $showLocality = $area;
//    $showLocality = ($village) ? $village : $city;
          ?>

          <div class="videoteaser">
            <img class="videotitleico" src="<?php bloginfo('template_directory'); ?>/images/<?php echo $postType; ?>-mini.png" alt="Benchmark site"/> 
            <h2 class="teasertitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?> [<?php echo $country; ?>]</a></h2>
            <!--<a href="<?php // the_permalink();  ?>"><img class="image" src="<?php // echo $staticMapURL;  ?>" /></a>-->
            <p>
              <?php // echo $tEx;  ?>
              <span class="sidemap-labels">Site ID:</span> <?php echo $sideId; ?><br>
              <span class="sidemap-labels">Sampling Frame Name:</span> <?php echo $blockName; ?><br>
              <span class="sidemap-labels">Town:</span> <?php echo $showLocality; ?>          
            </p>         
          </div>

          <?php
          break;
      }
      ?>
    </div>
    <!--</div>-->
  <?php endwhile; ?><!-- end loop-->
  <br clear="all" />
  <div id="amkn-paginate">
    <?php
    if (function_exists('wp_pagenavi')) {
      wp_pagenavi();
    } else {
      ?>
      <div class="alignleft"><?php next_posts_link('&larr; Previous Entries'); ?></div>
      <div class="alignright"><?php previous_posts_link('Next Entries &rarr;'); ?></div>
<?php } ?>
  </div>
  <br clear="all">
  <br clear="all">