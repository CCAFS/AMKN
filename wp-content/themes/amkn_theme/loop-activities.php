<?php
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
global $query_string; // required
global $wpdb;
$metaKey = array();
$orderby = array();
$order = 'ASC';
$filt = '';
$themes = array('1'=>'Adaptation to Progressive Climate Change','2'=>'Adaptation through Managing Climate Risk','3'=>' Pro-Poor Climate Change Mitigation','4.1'=>' Linking Knowledge to Action','4.2'=>'Data and Tools for Analysis and Planning','4.3'=>'Policies and Institutions');
if($_GET['order'] == 'true') {
  $order = 'DESC';
}
if($_GET['initDate'] != '') {
  $metaKey[] = array('key' => 'startDateFilter','value' => date_format_wp($_GET['initDate']), 'compare' => '>=');
}
if($_GET['endDate'] != '') {
  $metaKey[] = array('key' => 'endDateFilter','value' => date_format_wp($_GET['endDate']), 'compare' => '<=');
}
if($_GET['leader'] != '0' && $_GET['leader'] != '') {
  $metaKey[] = array('key' => 'leaderAcronym','value' => $_GET['leader']);
  $filt .='CG Center: '.$_GET['leader'].'; ';
}
if($_GET['theme'] != '0' && $_GET['theme'] != '') {
  $metaKey[] = array('key' => 'theme','value' => $_GET['theme']);
  $filt .='Topic: Theme '.$_GET['theme'].'; ';
}
if($_GET['orderby'] != 'title' && $_GET['orderby'] != '') {
  $orderType = ($_GET['orderby']=='leaderName')?'meta_value':'meta_value_num';
  $orderby = array( 'orderby' => $orderType, 'meta_key' => $_GET['orderby']);
} else if ($_GET['orderby'] == 'title') {
  $orderby = array( 'orderby' => 'title','post_type'=>'ccafs_activities');
}
$paged = get_query_var('paged');
if(count($metaKey)) {  
  $args = array_merge(array('meta_query' => $metaKey), array('posts_per_page' => '25', 'order'=>$order, 'paged'=>$paged), $orderby);  
} elseif(count($orderby)) {
  $args = array_merge(array('posts_per_page' => '25', 'order'=>$order, 'paged'=>$paged), $orderby);  
}  else {
//  $args = $query_string.'&posts_per_page=25&order=ASC&orderby=title';
  $args = array(
      'post_type'=>'ccafs_activities',
      'orderby'=>'title',
      'order'=>'asc',
      'posts_per_page'=>'25'
  );
}

if($_GET['keyword'] != '0' && $_GET['keyword'] != '') {
  $mypostids = $wpdb->get_col("select ID from ".$wpdb->posts." where post_type = 'ccafs_activities' AND (post_title like '%".$_GET['keyword']."%' OR post_content like '%".$_GET['keyword']."%')");
  $args = array_merge($args,array('post__in'=>$mypostids));
  $filt .='Keyword: '.$_GET['keyword'].'; ';
}
//echo "<pre>".$query_string.print_r($args,true)."</pre>";
$posts = query_posts($args);
global $wp_query;
$plural = ($wp_query->found_posts>1)?'s':'';
echo "<h3>".$wp_query->found_posts." result".$plural." found; <i style='font-family: -webkit-body;'>".substr_replace(trim($filt), "", -1)."</i></h3>";
?>

<?php /* Start the Loop */ ?>
<?php //query_posts('posts_per_page=10'); ?>
<?php while ( have_posts() ) : the_post();
  $postType = $post->post_type;
  $postId = $post->ID;
  $postThumb = "";
   
  $geoRSSPoint = get_post_meta($post->ID, 'geoRSSPoint', true);
  $budget = get_post_meta($post->ID, 'budget', true);
  $leader = get_post_meta($post->ID, 'leaderName', true);
  $org = get_post_meta($post->ID, 'leaderAcronym', true);
  $theme = get_post_meta($post->ID, 'theme', true); 
  $geoPoint = str_ireplace(" ", ",", trim($geoRSSPoint));
  $sURL = str_ireplace("http://", "", site_url());
  $sURL= "amkn.org";
  $staticMapURL = "http://maps.google.com/maps/api/staticmap?center=".$geoPoint."&zoom=2&size=70x70&markers=icon:http%3A%2F%2F".$sURL."%2Fwp-content%2Fthemes%2Famkn_theme%2Fimages%2F".$post->post_type."-mini.png|".$geoPoint."&maptype=roadmap&sensor=false";
  $tEx = $post->post_excerpt;
  if(strlen($tEx) > 150){
      $tEx = substr($tEx,0,150)."...";
  }
  $tactivity = $post->post_title;
  if(strlen($tactivity) > 60){
      $tactivity = substr($tactivity,0,60)."...";
  }

  $args4Countries = array('fields' => 'names');
  $cgMapCountries = wp_get_object_terms($post->ID, 'cgmap-countries', $args4Countries);
?>
  <tr onclick="window.location.href = '<?php the_permalink(); ?>';">
    <td>
      <?php echo $tactivity?>
    </td>    
    <td>
      <?php echo $themes[$theme]?>
    </td>
    <td>
      <?php echo (!cgValidate($org))?$org:'';?>
    </td>
<!--    <td>
      <?php // echo number_format(str_replace(',', '', $budget), 2,',','.')?>
      <?php // echo $budget?>
    </td>-->
  </tr>
<?php endwhile; ?><!-- end loop-->
