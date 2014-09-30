<?php
/*
 *  This file is part of Adaptation and Mitigation Knowledge Network (AMKN).
 *
 *  AMKN is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  at your option) any later version.
 *
 *  AMKN is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with DMSP.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Copyright 2012 (C) Climate Change, Agriculture and Food Security (CCAFS)
 * 
 * Created on : 20-10-2012
 * @author      
 * @version     1.0
 */
/**
 * @package WordPress
 * @subpackage AMKNToolbox
 */
?>

<?php
$args1 = array(
  'public' => true,
  '_builtin' => false
);
$excludeTypes = array("flickr_photos", "agtrials");
$output = 'objects'; // names or objects
$operator = 'and'; // 'and' or 'or'
$post_types = get_post_types($args1, $output, $operator);
$sortArray = array();
foreach ($post_types as $post_type) {
  foreach ($post_type as $key => $value) {
    if (!isset($sortArray[$key])) {
      $sortArray[$key] = array();
    }
    $sortArray[$key][] = $value;
  }
}
$orderby = "menu_position";
array_multisort($sortArray[$orderby], SORT_ASC, $post_types);
?>
<!-- java script to configure the custom post types that are in the tree -->
<script type="text/javascript">
<?php
$bookmarks = get_bookmarks(array(
  'orderby' => 'name',
  'order' => 'ASC',
  'category_name' => 'MapServerLayers'
        ));
?>
  var treeData = [
<?php
$fst = 1;
echo "{ title: \"Data Layers\", 
                key: \"accord_data_layers\",                 
                isFolder: false,                
//                select: true,
                icon: '../../../../images/data_layersM.png',
                addClass: \"customSelect\",
                selectMode: 2,
//                icon:false,
                hideCheckbox: true,
            },";
foreach ($post_types as $post_type) {
  if (!in_array($post_type->name, $excludeTypes)) {
    echo $fst == 1 ? "" : ",";
    $fst = 0;
    echo "{ title: \"" . $post_type->label . "\", 
                key: \"accord_" . $post_type->name . "\",                 
                isFolder: true,                
//                select: true,
                selectMode: 2,
                hideCheckbox: false,
                    ";
    switch ($post_type->name) {
      case "ccafs_sites":
        echo "icon: \"../../../../images/ccafs_sites-mini.png\",";
        break;
      case 'video_testimonials':
        echo "icon: \"../../../../images/video_testimonials-mini.png\",";
        break;
      case 'amkn_blog_posts':
        echo "icon: \"../../../../images/amkn_blog_posts-mini.png\",";
        break;
      case 'biodiv_cases':
        echo "icon: \"../../../../images/biodiv_cases-mini.png\",";
        break;
      case 'photo_testimonials':
        echo "icon: \"../../../../images/photo_testimonials-mini.png\",";
        break;
      case 'ccafs_activities':
        echo "icon: \"../../../../images/ccafs_activities-mini.png\",";
        break;
    }
    echo "
            children: [ // Pass an array of nodes.
                ]
            }";
  }
}
$layers = "]; var treeDataLayer = [ { title: \"Data Layer (" . count($bookmarks) . ")\", 
                key: \"accord_data_layer\",                  
                isFolder: true,
                hideCheckbox: true,            
                select: false,
                icon: '../../../../images/data_layersM.png',
                selectMode: 3,
                children: [";
$i = 0;
foreach ($bookmarks as $bm) {
  $bmLStr = explode("||", $bm->link_url);
  if (count($bmLStr) == 1) {
    $bmLURL = $bm->link_url;
    $singleLayer = "null";
  } else {
    $bmLURL = $bmLStr[0];
    $singleLayer = $bmLStr[1];
  }
  $layers .= "{title: '" . $bm->link_name . "', isFolder: true, hideCheckbox: true, key: 'aglyr" . $bm->link_id . "-" . $singleLayer . "-" . $bmLURL . "-" . $bm->link_id . "'},";
//  $layers .= "children: [ test[".$i."]]},";
  $i++;
}
$layers .= "]
       }];";
echo $layers;

$args2 = array(
  'public' => true,
  '_builtin' => false
);
$excludeTaxonomies = array("cgmap-countries", "crops_livestock", "agroecological_zones", "farming_systems");

$output = 'objects'; // or names
$operator = 'and'; // 'and' or 'or'
$taxonomies = get_taxonomies($args2, $output, $operator);
if ($taxonomies) {
  $taxoTree = "var treeDataTaxo = [{ title: \"Filter by Resource Theme\", 
                key: \"accord_filter_resource_theme\", 
                isFolder: true,
                hideCheckbox: true,            
                //select: false,
                //icon: '../../../../images/data_layersM.png',
                selectMode: 3,
                children: [";
  asort($taxonomies);
  foreach ($taxonomies as $taxonomy) {
    if (!in_array($taxonomy->name, $excludeTaxonomies)) {
      $args3 = array(
        'orderby' => 'name'
      );
      $terms = get_terms($taxonomy->name, $args3);
      $count = count($terms);
      $taxoTree .= "{title: '" . $taxonomy->label . " (" . $count . ")', 
                     isFolder: true, 
                     hideCheckbox: true,
                     key: '" . $taxonomy->name . "',
                     selectMode: 3,                     
                     children: [";
      if ($count > 0) {
        foreach ($terms as $term) {
          $taxoTree .= "{title: '" . $term->name . "',
                        icon:false,
                        key: 'taxio_" . $term->term_id . "',
                        },";
        }
      }
      $taxoTree .= "]},";
    }
  }
  $taxoTree .= "]
       }";
  echo $taxoTree;
}
?>
  ];
</script>
<!-- div element in wich the tree will appear. -->
<!--<div id="cFiltersList2" style="width: 100%; height: 68%; overflow: hidden;">
</div>  end cFiltersList2-->
<?php
$qargs = array(
  'post_type' => isset($postTypes) ? explode(",", $postTypes) : array('ccafs_activities', 'ccafs_sites', 'biodiv_cases', 'amkn_blog_posts', 'photo_testimonials', 'video_testimonials,'),
  'posts_per_page' => '-1',
  'tax_query' => array(
    'relation' => 'AND',
    array(
      'taxonomy' => 'impacts',
      'field' => 'id',
      'terms' => $impQ,
      'operator' => $impO,
    ),
    array(
      'taxonomy' => 'adaptation_strategy',
      'field' => 'id',
      'terms' => $asQ,
      'operator' => $asO,
    ),
    array(
      'taxonomy' => 'agroecological_zones',
      'field' => 'id',
      'terms' => $azQ,
      'operator' => $azO,
    ),
    array(
      'taxonomy' => 'climate_change_challenges',
      'field' => 'id',
      'terms' => $cccQ,
      'operator' => $cccO,
    ),
    array(
      'taxonomy' => 'mitigation_strategy',
      'field' => 'id',
      'terms' => $msQ,
      'operator' => $msO,
    ),
    array(
      'taxonomy' => 'crops_livestock',
      'field' => 'id',
      'terms' => $clQ,
      'operator' => $clO,
    ),
  )
);
$contentQuery = new WP_Query($qargs);
$trans = array(" " => ",");
//echo 'Latitude,Longitude,Location,CID,Type' . "\n";
while ($contentQuery->have_posts()) {
  $contentQuery->the_post();
  $contentQuery->post->post_type;
  if (!isset($postTotal[$contentQuery->post->post_type]))
    $postTotal[$contentQuery->post->post_type] = 0;
  $postTotal[$contentQuery->post->post_type] +=1;
}
//print_r($postTotal);
?>
<script>
  var postTotal = <?php echo json_encode($postTotal) ?>;
//   alert(postTotal);
//   alert(JSON.stringify(postTotal, null, 4));
</script>


