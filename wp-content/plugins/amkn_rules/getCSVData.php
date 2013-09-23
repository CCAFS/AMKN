<?php
require_once("../../../wp-config.php");
require_once("../../../wp-includes/wp-db.php");
header("Content-type: text/html; charset=UTF-8");
ob_start ("ob_gzhandler");

global $wp_query;

$args = array( 'posts_per_page'=>-1 );
$postTypes = $_GET["pts"];
$args[post_type] = isset($postTypes) ? explode(",",$postTypes) : array( 'video_testimonials', 'ccafs_sites', 'amkn_blog_posts', 'photo_testimonials' );

//$args['tax_query'] = array(
//    'relation' => 'OR',
//    array(
//            'taxonomy' => 'farming_systems',
//            'field' => 'id',
//            'terms' => $fsQ,
//            'operator' => 'IN',
//    ),
//    array(
//            'taxonomy' => 'adaptation_strategy',
//            'field' => 'id',
//            'terms' => $asQ,
//            'operator' => 'NOT IN',
//    ),
//);

//$args = array(
//	'tax_query' => array(
//		'relation' => 'OR',
//		array(
//			'taxonomy' => 'farming_systems',
//			'field' => 'id',
//			'terms' => $fsQ,
//                        'operator' => 'IN',
//		),
//		array(
//			'taxonomy' => 'adaptation_strategy',
//			'field' => 'id',
//			'terms' => $asQ,
//                        'operator' => 'IN',
//		)
//	)
//);
//$args = array(	'numberposts'=>-1,
//		'post_type' => array( 'video_testimonials', 'ccafs_sites', 'amkn_blog_posts', 'photo_testimonials' ),
//		'tax_query'=>array(array('taxonomy'=>'farming_systems',
//					'field'=>'id',
//					'terms'=>$fsQ,
//                                        'operator' => 'IN'
//					))
//		);


$geo_query = new WP_Query($args);
$trans = array(" " => ",");
echo 'Latitude,Longitude,Location,CID,Type' . "\n";
// The Loop
while ( $geo_query->have_posts() ) : $geo_query->the_post();
$geoPoint=strtr(get_post_meta($geo_query->post->ID, 'geoRSSPoint', true), $trans);
    if($geoPoint)
    {
         echo $geoPoint.",\"".the_title( "", "", false )."\",\"".$geo_query->post->ID."\",\"".$geo_query->post->post_type."\"" . "\n";
    }
endwhile;
?>